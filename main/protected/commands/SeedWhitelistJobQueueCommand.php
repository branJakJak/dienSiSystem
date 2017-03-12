<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SeedWhitelistJobQueueCommand
 *
 * @author user
 */
class SeedWhitelistJobQueueCommand extends CConsoleCommand {

    public function actionIndex() {

        Yii::import('application.models.*');
    	$filename = tempnam(sys_get_temp_dir(), "da");
        $whiteListjob = new WhitelistJobQueue;
        $whiteListjob->filename = $filename;
        $whiteListjob->queue_name = "2123";
        //Add scan total
        $whiteListjob->total_records = 999;
        $whiteListjob->processed_record = 999;
        $whiteListjob->status = WhitelistJobQueue::$JOBQUEUE_STATUS_DONE; 
        $whiteListjob->save();

        foreach (range(0, 200) as $key => $value) {
        	$newWhiteListedMobile = new WhiteListedMobile();
        	$newWhiteListedMobile->queue_id = $whiteListjob->queue_id;
        	$newWhiteListedMobile->mobile_number = sprintf("07321654%s%s%s" ,rand(0,9),rand(0,9),rand(0,9));
        	$newWhiteListedMobile->status = "ok";
        	$newWhiteListedMobile->save();
        	echo "new whitelistmobile created $newWhiteListedMobile->mobile_number \t\n";
        }
   }

}
