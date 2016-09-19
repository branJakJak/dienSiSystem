<?php 

/**
* 
*/
class WebsiteCheckerCommand extends CConsoleCommand
{
    public function actionIndex()
    {
        Yii::import("application.models.*");
    	set_time_limit(0);
	

    	$accounts = Accounts::model()->findAll();
    	foreach ($accounts as $currentValue) {
    		$currentValue->checkWebsiteStatus();
    	}    		


    }/*end of function*/
}
?>
