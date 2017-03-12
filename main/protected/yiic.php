<?php
defined('APP_ENV') or define('APP_ENV',"dev");
// defined('APP_ENV') or define('APP_ENV',"prod");

// change the following paths if necessary
$yiic=dirname(__FILE__).'/../../yii/framework/yiic.php';
$config=dirname(__FILE__).'/config/'.APP_ENV.'/console.php';


require_once($yiic);
