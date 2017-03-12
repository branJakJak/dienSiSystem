<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

$yii = __DIR__.'/../data/protected/framework/yii.php';
$config = dirname(__FILE__).'/protected/config/prod/main.php';


//require_once $autoload;
require_once($yii);
Yii::setPathOfAlias('redirect', dirname(__FILE__).'/protected/modules/redirect');
Yii::createWebApplication($config)->run();

