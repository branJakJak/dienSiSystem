<?php

class m160912_171817_create_settings_table extends CDbMigration
{
	public function up()
	{
        $this->createTable("tbl_settings",array(
                "id"=>"pk",
                "setting_key"=>"string",
                "setting_value"=>"string",
                "date_created"=>"datetime",
                "date_updated"=>"datetime",
            ));
	}

	public function down()
	{
		$this->dropTable("tbl_settings");
	}

}