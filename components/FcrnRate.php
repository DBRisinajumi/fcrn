<?php

class FcrnRate extends CApplicationComponent {

    const SOURCE_BANK_LV = 1;
    const SOURCE_BANK_LT = 2;
    
    var $sError = FALSE;
    var $base = self::SOURCE_BANK_LV;
    var $source = self::SOURCE_BANK_LV;
    

    /**
     * Get cyrrency id by currency code
     * @param char $sCode currency code
     * @return boolean|int - currency id
     */
    public function getCurrencyIdByCode($sCode) {
        $this->sError = FALSE;

        $sSql = "SELECT
                    fcrn_id
                FROM
                    fcrn_currency
                WHERE
                    fcrn_code = '" . $sCode . "'
                ";
        $result = Yii::app()->db->createCommand($sSql)->queryScalar(); 

        if (!$result) {
            $this->sError = 'Incorect currency code: ' . $sCode;
            return FALSE;
        }
        
        return $result;

    }
    
    /**
     * Validate currency ID
     * @param char $id currency id
     * @return boolean
     */
    public function isValidCurrencyId($id) {
        $this->sError = FALSE;

        $sSql = "SELECT
                    fcrn_id
                FROM
                    fcrn_currency
                WHERE
                    fcrn_id = '" . $id . "'
                ";
        $result = Yii::app()->db->createCommand($sSql)->queryScalar(); 

        if (!$result) {
            $this->sError = 'Incorect currency id: ' . $id;
            return FALSE;
        }
        
        return TRUE;

    }
    /**
     * Validate SOURCE ID
     * @param char $id source id
     * @return boolean
     */
    public function isValidSourceId($source) {
        $this->sError = FALSE;

        $sSql = "SELECT
                    fcsr_id
                FROM
                    fcsr_courrency_source
                WHERE
                    fcsr_id = '" . $source . "'
                ";
        $result = Yii::app()->db->createCommand($sSql)->queryScalar(); 
        $aRow = MySQL::q($sSql);

        if (!$result) {
            $this->sError = 'Incorect source id: ' . $source;
            return FALSE;
        }
        
        return TRUE;

    }

    /**
     * valutas kurrs valūtai uz konkrēto datumu
     * @param int $nId currency id
     * @param date $dDate format yyyy.mm.dd
     * @return boolean|float - currency rate
     */
    public function getCurrencyRate($id, $date, $base = FALSE,$source = FALSE) {
        $this->sError = FALSE;
        
        
        
        /**
         * validate input param
         */
        
        if(!$this->isValidCurrencyId($id)){
            return FALSE;
        }

       if ($date) {
           $sSql = "SELECT IF(DATEDIFF('" . $date . "',CURDATE())>0, 1, 0) in_future ";
           $result = Yii::app()->db->createCommand($sSql)->queryScalar();
            if ($result == 1) {
                $this->sError = "Can not get currency rate, Date(" . $date . ") is in future.";
                return FALSE;
            }
        }
        
        if($base){
            if(!$this->isValidCurrencyId($base)){
                return FALSE;
            }
        }else{
            $base = $this->base;
        }
        
        if($source){
            if(!$this->isValidSourceId($source)){
                return FALSE;
            }
        }else{
            $source = $this->source;
        }

        return $this->_getRateFromDb($source, $base, $id, $date);
    }

    /**
     * valutas kurrs valūtai uz konkrēto datumu
     * @param int $nId currency id
     * @param date $dDate format yyyy.mm.dd
     * @return boolean|float - currency rate
     */
    private function getCurrencyRateaaa($nId, $dDate) {
        $this->sError = FALSE;

        /**
         * sys valutas kurs ir 1 vienmer
         */
        if ($nId == CONFIG_SYS_CURRENCY) {
            return 1;
        }

        if ($dDate) {
            $aDates = MySQL::q("SELECT IF(DATEDIFF('" . $dDate . "',CURDATE())>0, 1, 0) in_future ");
            if ($aDates[0]['in_future'] == 1) {
                $this->sError = "Can not get currency rate, Date(" . $dDate . ") is in future.";
                return FALSE;
            }
        }

        /**
         * meklē kursu iekš DB
         */
        $nRate = $this->_getRateFromDb($nId, $dDate);
        if ($nRate) {
            return $nRate;
        }

        /**
         * kursu uz aktuālo datumu nolasa no bank.lv
         */
        $aRate = $this->_getRateFromBankLv($dDate);
        if (!$aRate) {
            return FALSE;
        }

        /**
         * saglabā bank.lv datus
         */
        $this->_saveRate($aRate, $dDate);

        /**
         * meklē kursu iekš DB
         */
        $nRate = $this->_getRateFromDb($nId, $dDate);
        if (!$aRate) {
            $this->sError = 'Neizdevās nolasīt valūtas kursu no bank.lv';
            return FALSE;
        }

        return $nRate;
    }

    /**
     * nolasa valūtas kursus no bank.lv prasītajam datumam
     * @param char $nDate date in yyyy.mm.dd vai yyyymmdd format
     * @return boolean|int
     */
    private function _getRateFromBankLv($nDate) {
        $aResRate = array();

        $nDate = preg_replace('#[^0-9]*#', '', $nDate);
        $sUrl = "http://www.bank.lv/vk/xml.xml?date=" . $nDate;

        $cXML = file_get_contents($sUrl);
        if (!$cXML) {
            $this->sError = 'Neizdevās pieslēgties bank.lv';
            return false;
        }

        preg_match_all("#<ID>(.*?)</ID>#", $cXML, $aIDs);
        preg_match_all("#<Units>(.*?)</Units>#", $cXML, $aUnits);
        preg_match_all("#<Rate>(.*?)</Rate>#", $cXML, $aRate);

        foreach ($aIDs[1] as $k => $v) {
            if ($aUnits[1][$k] > 1)
                $nCurrencyRate = $aRate[1][$k] / $aUnits[1][$k];
            else
                $nCurrencyRate = $aRate[1][$k];

            $aResRate[$v] = $nCurrencyRate;
        }
        $aResRate['LVL'] = 1;
        return $aResRate;
    }

    /**
     * saglabā valūtas kursus DB
     * @param type $aRate
     * @param type $dDate
     * @return boolean
     */
    private function _saveRate($aRate, $dDate) {

        /**
         * savāc vajadzīgās valūtas
         */
        $aCurr = array();
        $sSql = "
SELECT
id,
currency_code
FROM
currency
";
        $aC = MySQL::q($sSql);
        foreach ($aC as $aRow) {
            $aCurr[$aRow['currency_code']] = $aRow['id'];
        }

        /**
         * iet cauri bank.lv kursiem un saglabā tos
         */
        foreach ($aRate as $sCurCode => $nRate) {

            if (!isset($aCurr[$sCurCode])) {
                /**
                 * valūta nav starp vajadzīgajām valūtam
                 */
                continue;
            }
            $nCurrId = $aCurr[$sCurCode];

            /**
             * vai tāds ieraksts jau nav tabulā
             */
            $sSql = "
SELECT
id
FROM
currency_rate
WHERE
currency_id = " . $nCurrId . "
and `date` = '" . $dDate . "'
";
            $aC = MySQL::q($sSql);
            if (count($aC) > 0) {
                continue;
            }

            /**
             * saglabā ierakstu tabulā
             */
            $sSql = "
insert into
currency_rate
set
currency_id = " . $nCurrId . ",
`date` = '" . $dDate . "',
rate = " . $nRate . "
";
            $r = MySQL::s($sSql);
        }
        return true;
    }

    /**
     * nolasa valūtas kursu no DB
     * @param int $nId currency_id
     * @param date $dDate yyyy.mm.dd
     * @return boolean/float
     */
    private function _getRateFromDb($source, $base, $id, $date) {

        $rate = Yii::app()->db->createCommand()
                ->select('fcrt_rate')
                ->from('fcrt_currency_rate')
                ->where('
                    fcrt_fcsr_id=:source 
                    AND fcrt_fcrn_id=:from_id
                    and fcrt_fcrn_id=:to_id
                    and fcrt_date=:date', array(
                        ':source' => $source,
                        ':from_id' => $base,
                        ':to_id' => $id,
                        ':date' => $date
                        
                        ))
//                ->where('', array(':from_id' => $base))
 //               ->where('', array())
  //              ->where('fcrt_date=:date', array())
                ->queryScalar();


        if (!$rate) {
            return FALSE;
        }
        return $rate;
    }

}
