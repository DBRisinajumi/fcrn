<?php

class FcrnRate extends CApplicationComponent {

    const SOURCE_BANK_LV = 1;
    const SOURCE_BANK_LT = 2;
    const C_LVL = 3;
    const C_EUR = 1;

    var $sError = FALSE;
    var $base = self::SOURCE_BANK_LV;
    var $source = self::SOURCE_BANK_LV;
    private $_currencyId2Code = FALSE;
    private $_currencyCode2Id = FALSE;
    private $_source = FALSE;

    public function init(){
        $this->base = Yii::app()->sysCompany->getAttribute('base_fcrn_id');
    }    
    
    public function getCurrencyCode2Id() {
        if ($this->_currencyCode2Id === FALSE) {
            $this->_loadCurrencyCodes();
        }
        return $this->_currencyCode2Id;
    }

    public function getCurrencyId2Code() {
        if ($this->_currencyId2Code === FALSE) {
            $this->_loadCurrencyCodes();
        }
        return $this->_currencyId2Code;
    }

    public function getBaseCurrency($source, $date) {

        if ($this->_source === FALSE) {
            $this->_loadSources();
        }

        return $this->_source[$source]['fcsr_base_fcrn_id'];
    }

    public function _loadSources() {
        $this->_source = array();
        $sSql = "SELECT
                    *
                FROM
                    fcsr_courrency_source
                ";
        $result = Yii::app()->db->createCommand($sSql)->queryAll();
        foreach ($result as $row) {
            $this->_source[$row['fcsr_id']] = $row;
        }
    }

    public function _loadCurrencyCodes() {
        $this->_currencyId2Code = $this->_currencyCode2Id = array();
        $sSql = "SELECT
                    fcrn_id,
                    fcrn_code
                FROM
                    fcrn_currency
                ";
        $result = Yii::app()->db->createCommand($sSql)->queryAll();
        foreach ($result as $row) {
            $this->_currencyId2Code[$row['fcrn_id']] = $row['fcrn_code'];
            $this->_currencyCode2Id[$row['fcrn_code']] = $row['fcrn_id'];
        }
    }

    /**
     * Get cyrrency id by currency code
     * @param char $sCode currency code
     * @return boolean|int - currency id
     */
    public function getCurrencyIdByCode($code) {
        $this->sError = FALSE;

        if ($this->_currencyCode2Id === FALSE) {
            $this->_loadCurrencyCodes();
        }

        if (!isset($this->_currencyCode2Id[$code])) {
            $this->sError = 'Incorect currency code: ' . $code;
            return FALSE;
        }

        return $this->_currencyCode2Id[$code];
    }

    /**
     * Validate currency ID
     * @param char $id currency id
     * @return boolean
     */
    public function isValidCurrencyId($id) {
        $this->sError = FALSE;

        if (!$this->getCurrencyId2Code($id)) {
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

        if ($this->_source === FALSE) {
            $this->_loadSources();
        }
        if (!isset($this->_source[$source])) {
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
    public function getCurrencyRate($id, $date, $source = FALSE) {
        $this->sError = FALSE;

        /**
         * validate input param
         */
        if (!$this->isValidCurrencyId($id)) {
            return FALSE;
        }
        
        //same currency no convert
        if($id == $this->base){
            return 1;
        }
        
        if ($source) {
            if (!$this->isValidSourceId($source)) {
                return FALSE;
            }
        } else {
            $source = $this->source;
        }

        $base = $this->getBaseCurrency($source, $date);
        
        if(empty($date)){
            $this->sError = "Date can not be empty.";            
            return FALSE;
        }
        
        if ($date) {
            $sSql = "SELECT IF(DATEDIFF('" . $date . "',CURDATE())>1, 1, 0) in_future ";
            $result = Yii::app()->db->createCommand($sSql)->queryScalar();
            if ($result == 1) {
                $this->sError = "Can not get currency rate, Date(" . $date . ") is in future.";
                return FALSE;
            }
        }

        $rate = $this->_getRateFromDb($source, $base, $id, $date);

        /**
         * load rates
         */
        if ($rate) {
            return $rate;
        }
        if ($source == self::SOURCE_BANK_LV) {
            $aRate = $this->_getRateFromBankLv($date);
            if (!$aRate) {
                return FALSE;
            }
        } elseif ($source == self::SOURCE_BANK_LT) {
            $aRate = $this->_getRateFromBankLt($date);
            if (!$aRate) {
                return FALSE;
            }
        }

        $this->_saveRate($aRate, $date, $source);

        return $this->_getRateFromDb($source, $base, $id, $date);
    }

    /**
     * nolasa valūtas kursus no bank.lv prasītajam datumam
     * doc: http://www.bank.lv/monetara-politika/latvijas-bankas-noteiktie-valutu-kursi-xml-formata
     * @param char $nDate date in yyyy.mm.dd vai yyyymmdd format
     * @return boolean|int
     */
    public function _getRateFromBankLv($nDate) {
        $aResRate = array();

        $nDate = preg_replace('#[^0-9]*#', '', $nDate);
        $sUrl = "http://www.bank.lv/vk/ecb.xml?date=" . $nDate;

        $cXML = file_get_contents($sUrl);
        if (!$cXML) {
            $this->sError = 'Neizdevās pieslēgties bank.lv';
            return false;
        }

        preg_match_all("#<ID>(.*?)</ID>#", $cXML, $aIDs);
        preg_match_all("#<Rate>(.*?)</Rate>#", $cXML, $aRate);

        foreach ($aIDs[1] as $k => $v) {
            $aResRate[$v] = $aRate[1][$k];
        }
        return $aResRate;
    }

    /**
     * get currency rate from Bank Lituania
     * link example: http://webservices.lb.lt/ExchangeRates/ExchangeRates.asmx/getExchangeRatesByDate?Date=2013.09.14
     * doc: http://webservices.lb.lt/ExchangeRates/ExchangeRates_En.htm
     * @param char $nDate date in yyyy.mm.dd vai yyyymmdd format
     * @return boolean|int
     */
    public function _getRateFromBankLt($nDate) {
        $aResRate = array();

        $nDate = preg_replace('#[^0-9]*#', '', $nDate);
        $sUrl = "http://webservices.lb.lt/ExchangeRates/ExchangeRates.asmx/getExchangeRatesByDate?date=" . $nDate;

        $cXML = file_get_contents($sUrl);
        if (!$cXML) {
            $this->sError = 'Neizdevās pieslēgties bl.ll';
            return false;
        }

        preg_match_all("#<currency>(.*?)</currency>#", $cXML, $aIDs);
        preg_match_all("#<quantity>(.*?)</quantity>#", $cXML, $aUnits);
        preg_match_all("#<rate>(.*?)</rate>#", $cXML, $aRate);

        foreach ($aIDs[1] as $k => $v) {
            if ($aUnits[1][$k] > 1)
                $nCurrencyRate = $aRate[1][$k] / $aUnits[1][$k];
            else
                $nCurrencyRate = $aRate[1][$k];

            $aResRate[$v] = $nCurrencyRate;
        }

        return $aResRate;
    }

    /**
     * saglabā valūtas kursus DB
     * @param type $aRate
     * @param type $dDate
     * @return boolean
     */
    private function _saveRate($aRate, $date, $source) {


        $base = $this->getBaseCurrency($source, $date);

        //for base currency rate always is 1
        $aRate[$base] = 1;
        /**
         * iet cauri kursiem un saglabā tos
         */
        foreach ($aRate as $fcrn_code => $rate) {
            $id = $this->getCurrencyIdByCode($fcrn_code);
            if (!$id) {
                /**
                 * valūta nav starp vajadzīgajām valūtam
                 */
                continue;
            }

            /**
             * vai tāds ieraksts jau nav tabulā
             */
            if ($this->_getRateFromDb($source, $base, $id, $date)) {
                continue;
            }

            $sql = "
                INSERT INTO fcrt_currency_rate (
                  fcrt_fcsr_id,
                  fcrt_base_fcrn_id,
                  fcrt_fcrn_id,
                  fcrt_date,
                  fcrt_rate
                ) 
                VALUES
                  (
                    :fcrt_fcsr_id,
                    :fcrt_base_fcrn_id,
                    :fcrt_fcrn_id,
                    :fcrt_date,
                    :fcrt_rate
                  )                
                ";

            $parameters = array(
                ':fcrt_fcsr_id' => $source,
                ':fcrt_base_fcrn_id' => $base, 
                ':fcrt_fcrn_id' => $id,
                ':fcrt_date' => $date,
                ':fcrt_rate' => $rate,
            );

            Yii::app()->db->createCommand($sql)->execute($parameters);
        }
        return true;
    }

    /**
     * nolasa valūtas kursu no DB
     * @param int $source rate source 
     * @param int $base currency base
     * @param int $id currency_id
     * @param date $dDate yyyy.mm.dd
     * @return boolean/float
     */
    private function _getRateFromDb($source, $base, $id, $date) {

        $rate = Yii::app()->db->createCommand()
                ->select('fcrt_rate')
                ->from('fcrt_currency_rate')
                ->where('
                    fcrt_fcsr_id=:source 
                    AND fcrt_base_fcrn_id=:base
                    and fcrt_fcrn_id=:id
                    and fcrt_date=:date', array(
                    ':source' => $source,
                    ':base' => $base,
                    ':id' => $id,
                    ':date' => $date
                ))
                ->queryScalar();


        if (!$rate) {
            return FALSE;
        }
        return $rate;
    }
    
    /**
     * convert to base currency
     * @param decimal $amt
     * @param int $fcrn_id
     * @param date $date
     * @return boolean/amt
     */
    public function convertToBase($amt, $fcrn_id, $date,$round = 6) {
        $rate = $this->getCurrencyRate($fcrn_id, $date);
        if ($rate === FALSE) {
            return FALSE;
        }
        return round($rate * $amt, $round);

        
    }
    
    /**
     * convert from one currency to other
     * @param int $from_fcrn_id
     * @param int $to_fcrn_id
     * @param decimal $amt
     * @param date $date
     * @return boolean/amt
     */
    public function convertFromTo($from_fcrn_id,$to_fcrn_id,$amt,  $date,$round = 6) {
        $from_rate = $this->getCurrencyRate($from_fcrn_id, $date);
       if ($from_rate === FALSE) {
            return FALSE;
        }        
        $to_rate = $this->getCurrencyRate($to_fcrn_id, $date);
        if ($to_rate === FALSE) {
            return FALSE;
        }
        return round($from_rate/$to_rate * $amt, $round);

        
    }

}
