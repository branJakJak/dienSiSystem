<?php

class m150417_170949_create_new_ip_address_column_blacklisted_mobile extends CDbMigration
{
	public function up()
	{
        $this->addColumn('black_listed_mobile', 'ip_address', 'string');
	}
	public function down()
	{
		$this->dropColumn('black_listed_mobile', 'ip_address');
	}
}