<?php

class m150216_090337_create_job_queuee extends CDbMigration
{
	public function up()
	{
        $this->createTable("job_queue",array(
                "queue_id"=>"pk",
                "queue_name"=>"string not null",
                "status"=>"string not null",
                "total_records"=>"integer",
                "processed_record"=>"integer",
                "filename"=>"string not null",
                "date_done"=>"datetime",
                "date_created"=>"datetime",
                "date_updated"=>"datetime",
            ));
	}

	public function down()
	{
        $this->dropTable("job_queue");
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