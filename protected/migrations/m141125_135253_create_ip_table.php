<?php

class m141125_135253_create_ip_table extends CDbMigration
{
	public function up()
	{
		$sqlStatement = <<<EOL
CREATE TABLE IF NOT EXISTS `ip` (
  `rec_id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(60) NOT NULL,
  `ip_address_status` varchar(60) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`rec_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=198 ;		
EOL;
		$this->execute($sqlStatement);
	}

	public function down()
	{
		$this->dropTable('ip');
		return true;
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