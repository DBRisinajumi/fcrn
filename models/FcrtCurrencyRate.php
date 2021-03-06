<?php

// auto-loading
Yii::setPathOfAlias('FcrtCurrencyRate', dirname(__FILE__));
Yii::import('FcrtCurrencyRate.*');

class FcrtCurrencyRate extends BaseFcrtCurrencyRate
{
	// Add your model-specific methods here. This file will not be overriden by gtc except you force it.
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function init()
	{
		return parent::init();
	}

	public function get_label() {
		return (string) $this->fcrt_date;

	}

    public function behaviors() {
        return array_merge(
                parent::behaviors(), array(
             //auditrail       
            'LoggableBehavior' => array(
                'class' => 'LoggableBehavior'
            ),
        ));
    }  


	public function rules()
	{
		return array_merge(
		    parent::rules(),
            array(
                array('fcrt_fcsr_id, fcrt_date', 'required', 'on' => 'load'),
		    )
		);
	}

}
