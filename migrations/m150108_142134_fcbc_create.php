<?php

class m150108_142134_fcbc_create extends EDbMigration
{
	public function up()
	{
        $this->execute("
            CREATE TABLE `fcbc_ccmp_base_currency`(  
              `fcbc_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
              `fcbc_ccmp_id` INT UNSIGNED NOT NULL,
              `fcbc_year_from` SMALLINT UNSIGNED NOT NULL,
              `fcbc_year_to` SMALLINT UNSIGNED,
              `fcbc_fcsr_id` TINYINT UNSIGNED NOT NULL,
              `fcbc_fcrn_id` TINYINT UNSIGNED NOT NULL,
              PRIMARY KEY (`fcbc_id`),
              FOREIGN KEY (`fcbc_ccmp_id`) REFERENCES `ccmp_company`(`ccmp_id`),
              FOREIGN KEY (`fcbc_fcrn_id`) REFERENCES `fcrn_currency`(`fcrn_id`),
              FOREIGN KEY (`fcbc_fcsr_id`) REFERENCES `fcsr_courrency_source`(`fcsr_id`)
            ) ENGINE=INNODB CHARSET=utf8;
        ");        
        
        //copy from custom field data base currencies
        $cccd_custom_data = Yii::app()->db->schema->getTable('cccd_custom_data', true);
        if (!empty($cccd_custom_data) && 
                $cccd_custom_data->getColumn('base_fcrn_id') !== null) {
            $this->execute("
                INSERT INTO fcbc_ccmp_base_currency 
                    (fcbc_ccmp_id,fcbc_year_from,fcbc_year_to,fcbc_fcsr_id,fcbc_fcrn_id)
                SELECT 
                    cccd_ccmp_id,
                    YEAR(NOW()),
                    NULL,
                    1,
                    base_fcrn_id 
                FROM
                    cccd_custom_data 
                WHERE 
                    NOT base_fcrn_id IS NULL 
                    AND base_fcrn_id !=0 ;
            ");
        }else{
            /**
             * create for all syscompanies base currency record
             * * source - bank.lv
             * year_from - current year
             * base currency - EUR
             */
            $this->execute("
                INSERT INTO fcbc_ccmp_base_currency 
                    (fcbc_ccmp_id,fcbc_year_from,fcbc_year_to,fcbc_fcsr_id,fcbc_fcrn_id)
                SELECT DISTINCT
                  ccxg_ccmp_id
                    YEAR(NOW()),
                    NULL,
                    1,
                    1 
                FROM
                  ccxg_company_x_group 
                WHERE 
                  ccxg_ccgr_id = ".Yii::app()->params['ccgr_group_sys_company']."               
            ");            
            
        }
	}

	public function down()
	{
        $this->execute("
            DROP TABLE `fcbc_ccmp_base_currency`;
        ");        
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}