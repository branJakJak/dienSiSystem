<?php

defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
defined('APP_ENV') or define('APP_ENV',"dev");
// defined('APP_ENV') or define('APP_ENV',"prod");


// if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == ""){
//     $redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//     header("HTTP/1.1 301 Moved Permanently");
//     header("Location: $redirect");
// }



// change the following paths if necessary
$autoload = __DIR__.'/protected/vendor/autoload.php';
$yii = __DIR__.'/../yii/framework/yii.php';
$config = dirname(__FILE__).'/protected/config/'.APP_ENV.'/main.php';


require_once $autoload;
require_once($yii);
Yii::createWebApplication($config)->run();


