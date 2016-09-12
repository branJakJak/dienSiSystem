<?php

class m150309_153813_create_message_table extends CDbMigration
{
	public function up()
	{
        $this->createTable("messageBoard", array(
            "rec_id"=>'pk',
            "messageType"=>'string',
            "messageStatus"=>'string',
            "fullMessage"=>'text',
        ));
	}

	public function down()
	{
        $this->dropTable("messageBoard");
	}


}