<?php

/**
 * This is the model base class for the table "fcsr_courrency_source".
 *
 * Columns in table "fcsr_courrency_source" available as properties of the model:
 * @property integer $fcsr_id
 * @property string $fcsr_name
 * @property string $fcsr_notes
 * @property integer $fcsr_base_fcrn_id
 *
 * Relations of table "fcsr_courrency_source" available as properties of the model:
 * @property FcrtCurrencyRate[] $fcrtCurrencyRates
 * @property FcrnCurrency $fcsrBaseFcrn
 */
abstract class BaseFcsrCourrencySource extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'fcsr_courrency_source';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('fcsr_name', 'required'),
                array('fcsr_notes, fcsr_base_fcrn_id', 'default', 'setOnEmpty' => true, 'value' => null),
                array('fcsr_base_fcrn_id', 'numerical', 'integerOnly' => true),
                array('fcsr_name', 'length', 'max' => 50),
                array('fcsr_notes', 'safe'),
                array('fcsr_id, fcsr_name, fcsr_notes, fcsr_base_fcrn_id', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->fcsr_name;
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(), array(
                'savedRelated' => array(
                    'class' => '\GtcSaveRelationsBehavior'
                )
            )
        );
    }

    public function relations()
    {
        return array(
            'fcrtCurrencyRates' => array(self::HAS_MANY, 'FcrtCurrencyRate', 'fcrt_fcsr_id'),
            'fcsrBaseFcrn' => array(self::BELONGS_TO, 'FcrnCurrency', 'fcsr_base_fcrn_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'fcsr_id' => Yii::t('fcrn.crud', 'FcsrId'),
            'fcsr_name' => Yii::t('fcrn.crud', 'Name'),
            'fcsr_notes' => Yii::t('fcrn.crud', 'Notes'),
            'fcsr_base_fcrn_id' => Yii::t('fcrn.crud', 'Base Currency'),
        );
    }

    public function search($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.fcsr_id', $this->fcsr_id);
        $criteria->compare('t.fcsr_name', $this->fcsr_name, true);
        $criteria->compare('t.fcsr_notes', $this->fcsr_notes, true);
        $criteria->compare('t.fcsr_base_fcrn_id', $this->fcsr_base_fcrn_id);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }

}
