<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'../..',
	'name'=>'My Console Application',
	'import'=>array(
		'ext.YiiMailer.YiiMailer',
	),
	// application components
	'components'=>array(
		'cache'=>array( 
		    'class'=>'system.caching.CDbCache'
		),
	
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=dncsyste_dnc',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
	),
);