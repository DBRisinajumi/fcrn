<?php

class m150414_154701_add_eur_lt extends EDbMigration
{
	public function up()
	{
        $this->execute("
            INSERT  INTO `fcsr_courrency_source`
            (`fcsr_id`,`fcsr_name`,`fcsr_notes`,`fcsr_base_fcrn_id`) 
            VALUES 
            (4,'www.lb.lt ACC EUR',NULL,1);
                ");
	}

	public function down()
	{
		echo "m150414_154701_add_eur_lt does not support migration down.\n";
		return false;
	}

}