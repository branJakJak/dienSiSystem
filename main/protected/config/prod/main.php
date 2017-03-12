<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
Yii::setPathOfAlias('booster',dirname(__FILE__.'/../../extensions/booster'));
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'../..',
	'name'=>'DNC',
	'theme'=>'abound',
	// preloading 'log' component
	'preload'=>array('log'),
    'aliases' => array(
        'booster' =>dirname(__FILE__).'/../../extensions/yiibooster',
        'bootstrap'=>dirname(__FILE__).'/../../extensions/bootstrap',
        'yiiwheels'=>dirname(__FILE__).'/../../extensions/yiiwheels',
    ),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	        'bootstrap.helpers.TbHtml',
	        'bootstrap.helpers.TbArray',
	        'bootstrap.behaviors.TbWidget',
		'ext.YiiMailer.YiiMailer',
	),

	'modules'=>array(
		'remotecheck',
		'redirect',
		'remoteDedupe',
        'client_portal',
        'whitelist',
        'blacklist',
        'dnc',
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'hitman052529',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
			// 'ipFilters'=>array('*.*.*.*'),
		),
	),

	// application components
	'components'=>array(
		'cache'=>array( 
		    'class'=>'system.caching.CDbCache'
		),
        'bootstrap' => array(
            'class' => 'bootstrap.components.TbApi',
        ),
        'yiiwheels' => array(
            'class' => 'yiiwheels.YiiWheels',   
        ),        
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
		                '/underconstruction'=>'site/underconstruction',
		                'de-dupe'=>'dnc/default/list',
		                'dnc/<id:\d+>'=>'dnc/default/index',				
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=dncsyste_db',
			'emulatePrepare' => true,
			'username' => 'dncsyste_db',
			'password' => 'K6xMtEoZlHdGwqsOTD8P',
			'charset' => 'utf8',
		),
		
		'errorHandler'=>array(
	            'errorAction'=>'site/error',
	        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CWebLogRoute',
					'levels'=>'error, warning,info',
				)
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'isUnderConstruction'=>false,
		'SERVER_IP_ADDDRESS'=>'81.138.138.57',
	        'time_limit'=>182
	),
);
