<?php

// defined('YII_DEBUG') or define('YII_DEBUG',true);
// defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

// defined('LOCAL_MODE') or define('LOCAL_MODE',true);

// change the following paths if necessary
$yiic=dirname(__FILE__).'/../../yii/framework/yiic.php';
if (defined('YII_DEBUG')) {
	$config=dirname(__FILE__).'/config/console_dev.php';	
}else{
	$config=dirname(__FILE__).'/config/console.php';
}
require_once($yiic);
