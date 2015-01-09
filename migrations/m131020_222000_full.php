<?php

class m131020_222000_full extends CDbMigration {

    /**
     * Creates initial version of the audit trail table
     */
    public function up() {

        if (Yii::app()->db->schema->getTable('fcrn_currency', true) === null) {

            $this->execute(" 
                CREATE TABLE `fcrn_currency` (
                  `fcrn_id` TINYINT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                  `fcrn_code` VARCHAR(3) NOT NULL COMMENT 'Currency code ',
                  `fcrn_hide` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
                  PRIMARY KEY (`fcrn_id`),
                  KEY `fcrn_code` (`fcrn_code`)
                ) ENGINE=INNODB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;            
            ");

            $this->execute("
            CREATE TABLE `fcsr_courrency_source` (
              `fcsr_id` TINYINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
              `fcsr_name` VARCHAR(50) NOT NULL,
              `fcsr_notes` TEXT,
              `fcsr_base_fcrn_id` TINYINT(3) UNSIGNED DEFAULT NULL,
              PRIMARY KEY (`fcsr_id`),
              KEY `fcsr_base_fcrn_id` (`fcsr_base_fcrn_id`),
              CONSTRAINT `fcsr_courrency_source_ibfk_1` FOREIGN KEY (`fcsr_base_fcrn_id`) REFERENCES `fcrn_currency` (`fcrn_id`)
            ) ENGINE=INNODB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
          
            ");

            $this->execute("
            CREATE TABLE `fcrt_currency_rate` (
              `fcrt_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
              `fcrt_fcsr_id` TINYINT(3) UNSIGNED NOT NULL COMMENT 'currency source',
              `fcrt_base_fcrn_id` TINYINT(3) UNSIGNED NOT NULL COMMENT 'FK: currency from',
              `fcrt_fcrn_id` TINYINT(3) UNSIGNED NOT NULL COMMENT 'FK: currency to',
              `fcrt_date` DATE NOT NULL COMMENT 'Date of the rate',
              `fcrt_rate` FLOAT NOT NULL COMMENT 'Rate',
              PRIMARY KEY (`fcrt_id`),
              KEY `fcrt_fcrn_id` (`fcrt_base_fcrn_id`),
              KEY `FcrnIdDateRate` (`fcrt_base_fcrn_id`,`fcrt_date`,`fcrt_rate`),
              KEY `fcrt_fcsr_id` (`fcrt_fcsr_id`),
              KEY `fcrt_to_fcrn_id` (`fcrt_fcrn_id`),
              KEY `fcrt_fcrn_id_2` (`fcrt_base_fcrn_id`,`fcrt_date`),
              CONSTRAINT `fcrt_currency_rate_ibfk_2` FOREIGN KEY (`fcrt_fcsr_id`) REFERENCES `fcsr_courrency_source` (`fcsr_id`),
              CONSTRAINT `fcrt_currency_rate_ibfk_3` FOREIGN KEY (`fcrt_base_fcrn_id`) REFERENCES `fcrn_currency` (`fcrn_id`),
              CONSTRAINT `fcrt_currency_rate_ibfk_4` FOREIGN KEY (`fcrt_fcrn_id`) REFERENCES `fcrn_currency` (`fcrn_id`)
            ) ENGINE=INNODB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8;          
            ");

            $this->execute("
            INSERT  INTO `fcrn_currency`
                (`fcrn_id`,`fcrn_code`,`fcrn_hide`) 
                VALUES 
                (1,'EUR',0),(2,'USD',0),(3,'LVL',0),(4,'GBP',0),(5,'SEK',0),
                (6,'EEK',0),(7,'CHF',0),(8,'DKK',0),(9,'NOK',0),(10,'RUB',0),
                (11,'JPY',0),(12,'LTL',0),(13,'CAD',0),(14,'SGD',0);            
            ");


            $this->execute("
            INSERT  INTO `fcsr_courrency_source`
            (`fcsr_id`,`fcsr_name`,`fcsr_notes`,`fcsr_base_fcrn_id`) 
            VALUES 
            (1,'bank.lv',NULL,3),
            (2,'bank.lt',NULL,12);
                ");
        }
    }

    /**
     * Drops the audit trail table
     */
    public function down() {
        $this->execute("DROP TABLE IF EXISTS `fcrn_currency`");
        $this->execute("DROP TABLE IF EXISTS `fcrt_currency_rate`;");
        $this->execute("DROP TABLE IF EXISTS `fcsr_courrency_source`;");
    }

    /**
     * Creates initial version of the audit trail table in a transaction-safe way.
     * Uses $this->up to not duplicate code.
     */
    public function safeUp() {
        $this->up();
    }

    /**
     * Drops the audit trail table in a transaction-safe way.
     * Uses $this->down to not duplicate code.
     */
    public function safeDown() {
        $this->down();
    }

}
