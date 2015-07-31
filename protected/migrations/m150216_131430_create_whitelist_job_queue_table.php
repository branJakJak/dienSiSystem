<?php

class m150216_131430_create_whitelist_job_queue_table extends CDbMigration
{
    public function up()
    {
        $this->createTable("whitelist_job_queue",array(
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
        $this->dropTable("whitelist_job_queue");
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