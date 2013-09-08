<?php

class 130908_152700_create_tables extends CDbMigration
{

/**
* Creates initial version of the audit trail table
*/
public function up()
{

$this->createTable( 'fcrn_currency',
array(
'fcrn_id' => 'tinyint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
'fcrn_code' => 'char(3) CHARACTER SET ascii NOT NULL',
'fcrn_hide' => 'tinyint(3) unsigned NOT NULL DEFAULT \'0\'',
)
);

$this->createIndex( 'idx_fcrn_code', 'fcrn_currency', 'fcrn_code');




$this->createTable( 'fcrt_currency_rate',
array(
'fcrt_id' => 'int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
'fcrt_fcrn_id' => 'tinyint unsigned NOT NULL',
'fcrt_date' => 'date NOT NULL',
'fcrt_rate' => 'float NOT NULL'
)
);

$this->createIndex( 'idx_fcrt_fcrn_date_rate', 'fcrt_currency_rate', 'fcrt_fcrn_id,fcrt_date,fcrt_rate');

$this->addForeignKey(
		'fk_fcrt_fcrn',
		'fcrt_currency_rate','fcrt_fcrn_id',
		'fcrn_currency','fcrn_id');

$this->insert(,fcrn_currency,array('fcrn_id' =>13, ,'fcrn_code'=>'CAD'));
$this->insert(,fcrn_currency,array('fcrn_id' =>'7','fcrn_code' =>'CHF');
$this->insert(,fcrn_currency,array('fcrn_id' => '8','fcrn_code' =>'DKK');
$this->insert(,fcrn_currency,array('fcrn_id' => '6','fcrn_code' =>'EEK');
$this->insert(,fcrn_currency,array('fcrn_id' => '1','fcrn_code' =>'EUR');
$this->insert(,fcrn_currency,array('fcrn_id' => '4','fcrn_code' =>'GBP');
$this->insert(,fcrn_currency,array('fcrn_id' => '11','fcrn_code' =>'JPY');
$this->insert(,fcrn_currency,array('fcrn_id' => '12','fcrn_code' =>'LTL');
$this->insert(,fcrn_currency,array('fcrn_id' => '3','fcrn_code' =>'LVL');
$this->insert(,fcrn_currency,array('fcrn_id' => '9','fcrn_code' =>'NOK');
$this->insert(,fcrn_currency,array('fcrn_id' => '10','fcrn_code' =>'RUB');
$this->insert(,fcrn_currency,array('fcrn_id' => '5','fcrn_code' =>'SEK');
$this->insert(,fcrn_currency,array('fcrn_id' => '14','fcrn_code' =>'SGD');
$this->insert(,fcrn_currency,array('fcrn_id' => '2','fcrn_code' =>'USD');

		
		

}

/**
* Drops the audit trail table
*/
public function down()
{
$this->dropTable( 'fcrt_currency_rate' );
$this->dropTable( 'fcrn_currency' );
}

/**
* Creates initial version of the audit trail table in a transaction-safe way.
* Uses $this->up to not duplicate code.
*/
public function safeUp()
{
$this->up();
}

/**
* Drops the audit trail table in a transaction-safe way.
* Uses $this->down to not duplicate code.
*/
public function safeDown()
{
$this->down();
}
}