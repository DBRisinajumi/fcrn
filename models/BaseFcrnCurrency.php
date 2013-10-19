<?php

/**
 * This is the model base class for the table "fcrn_currency".
 *
 * Columns in table "fcrn_currency" available as properties of the model:
 * @property integer $fcrn_id
 * @property string $fcrn_code
 * @property integer $fcrn_hide
 *
 * Relations of table "fcrn_currency" available as properties of the model:
 * @property FcrtCurrencyRate[] $fcrtCurrencyRates
 */
abstract class BaseFcrnCurrency extends CActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'fcrn_currency';
	}

	public function rules()
	{
		return array_merge(
		    parent::rules(), array(
			array('fcrn_code', 'required'),
			array('fcrn_hide', 'default', 'setOnEmpty' => true, 'value' => null),
			array('fcrn_hide', 'numerical', 'integerOnly'=>true),
			array('fcrn_code', 'length', 'max'=>3),
			array('fcrn_id, fcrn_code, fcrn_hide', 'safe', 'on'=>'search'),
		    )
		);
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
			'fcrtCurrencyRates' => array(self::HAS_MANY, 'FcrtCurrencyRate', 'fcrt_fcrn_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'fcrn_id' => Yii::t('FcrnModule.crud', 'Fcrn'),
			'fcrn_code' => Yii::t('FcrnModule.crud', 'Fcrn Code'),
			'fcrn_hide' => Yii::t('FcrnModule.crud', 'Fcrn Hide'),
		);
	}


	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('t.fcrn_id', $this->fcrn_id);
		$criteria->compare('t.fcrn_code', $this->fcrn_code, true);
		$criteria->compare('t.fcrn_hide', $this->fcrn_hide);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

}
