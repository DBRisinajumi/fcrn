<?php

class m150410_115149_add_rur extends EDbMigration
{
	public function up()
	{
        $this->execute("
            INSERT  INTO `fcsr_courrency_source`
            (`fcsr_id`,`fcsr_name`,`fcsr_notes`,`fcsr_base_fcrn_id`) 
            VALUES 
            (3,'www.cbr.ru',NULL,10);
                ");
	}

	public function down()
	{
		echo "m150410_115149_add_rur does not support migration down.\n";
		return false;
	}

}