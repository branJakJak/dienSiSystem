<?php

class m160801_175529_create_disposale_table extends CDbMigration
{
	public function up()
	{
        $this->createTable("tbl_disposale",array(
                "id"=>"pk",
                "dispo_name"=>"string not null",
                "phone_number"=>"double",
                "posted_data"=>"string not null",
                "date_created"=>"datetime",
                "date_updated"=>"datetime",
            ));
	}
	public function down()
	{
		$this->dropTable("tbl_disposale");
	}
}