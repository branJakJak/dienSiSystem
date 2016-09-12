<?php

class m150213_153939_create_black_list_mobile_table extends CDbMigration
{
	public function up(){
        $this->createTable("black_listed_mobile", array(
                'rec_id'=>'pk',
                'queue_id'=>'integer',
                'mobile_number'=>'string not null',
                'date_created'=>'datetime',
                'date_updated'=>'datetime',
            ));
	}

	public function down(){
        $this->dropTable("black_listed_mobile");
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