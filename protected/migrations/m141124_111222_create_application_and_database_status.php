<?php

class m141124_111222_create_application_and_database_status extends CDbMigration
{
	public function up()
	{
        // $this->addColumn('claimaccount' , 'application_status',"string");
        // $this->addColumn('claimaccount', 'database_status', 'string');
	}

	public function down()
	{
        // $this->dropColumn('claimaccount','application_status');
        // $this->dropColumn('claimaccount','database_status');
		return true;
	}


}