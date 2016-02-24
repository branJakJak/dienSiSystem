<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);




// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
// if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == ""){
//     $redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//     header("HTTP/1.1 301 Moved Permanently");
//     header("Location: $redirect");
// }



// change the following paths if necessary
$yii = __DIR__.'/../yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';
// $config = __DIR__.'/protected/config/development.php';


require_once($yii);
Yii::createWebApplication($config)->run();


