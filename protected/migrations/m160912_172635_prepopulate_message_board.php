<?php

class m160912_172635_prepopulate_message_board extends CDbMigration
{
	public function up()
	{
		$this->insert("messageBoard",array(
	            "messageType"=>'info',
	            "messageStatus"=>'info',
	            "fullMessage"=>''
			));
	}

	public function down()
	{
		$this->delete("messageBoard",array());
	}
}