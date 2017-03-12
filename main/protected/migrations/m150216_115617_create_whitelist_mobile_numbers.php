
<?php

class m150216_115617_create_whitelist_mobile_numbers extends CDbMigration
{
	public function up()
	{
        $this->createTable("white_listed_mobile", array(
                'rec_id'=>'pk',
                'queue_id'=>'integer',
                'mobile_number'=>'string not null',
                'status'=>'string not null',
                'date_created'=>'datetime',
                'date_updated'=>'datetime',
            ));
	}

	public function down()
	{
        $this->dropTable("white_listed_mobile");
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