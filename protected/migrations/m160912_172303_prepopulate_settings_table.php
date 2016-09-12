<?php

class m160912_172303_prepopulate_settings_table extends CDbMigration
{
	public function up()
	{
		$this->insert("tbl_settings",array(
                "setting_key"=>"enabled",
                "setting_value"=>"true",
                "date_created"=>date("Y-m-d H:i:s"),
                "date_updated"=>date("Y-m-d H:i:s"),
			));
	}

	public function down()
	{
		$this->delete("tbl_settings",array());
	}

}