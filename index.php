<?php
// defined('YII_DEBUG') or define('YII_DEBUG',true);
// defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
// defined('LOCAL_MODE') or define('LOCAL_MODE',true);

//	administrator
//  r4l535*y980g9v1O
//  wee

/* if https is enabled */
defined('HTTPS_MODE') or define('HTTPS_MODE',false);
defined('HTTPS_MODE') or define('HTTPS_MODE',false);

if (HTTPS_MODE) {
	if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == ""){
	    $redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	    header("HTTP/1.1 301 Moved Permanently");
	    header("Location: $redirect");
	}
}

$autoload = __DIR__.'/protected/vendor/autoload.php';
// change the following paths if necessary

$yii =__DIR__ . '/protected/vendor/yiisoft/yii/framework/yii.php';

$config = "";
if (defined(LOCAL_MODE)) {
	$config = __DIR__.'/protected/config/development.php';
} else {
	$config=dirname(__FILE__).'/protected/config/main.php';
}


require_once $autoload;
require_once($yii);
Yii::createWebApplication($config)->run();