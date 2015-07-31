<?php
/**
 * Created by JetBrains PhpStorm.
 * User: EMAXX-A55-FM2
 * Date: 2/16/15
 * Time: 5:40 PM
 * To change this template use File | Settings | File Templates.
 */

class ImportBlackListMobileCommand extends CConsoleCommand{
    public function actionIndex()
    {
        Yii::import("application.models.*");
        //get the latest idle cron job
        /* @var $latestidle JobQueue*/
        $latestidle = JobQueue::model()->findByAttributes(array(
                "status"=>JobQueue::$JOBQUEUE_STATUS_IDLE
            ));
        if(!$latestidle){
            echo "No file queued";
            die();
        }
        //set status to on-going
        $latestidle->status = JobQueue::$JOBQUEUE_STATUS_ON_GOING;
        $latestidle->save(false);
        //retrieve file
        $queueFile = new SplFileObject($latestidle->filename);//read file
        $queueFile->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD |  SplFileObject::DROP_NEW_LINE | SplFileObject::SKIP_EMPTY);
        $queueFile->next();

        // Total_records , 
        $queueFile->seek(PHP_INT_MAX);
        $linesTotal = $queueFile->key();
        $latestidle->total_records = $linesTotal;
        $latestidle->save(false);

        $index = 0;
        foreach ($queueFile as $currentLine) {//iterate content
            if ($queueFile->key() === 0) {
                continue;
            }
            //TODO: processed_record
            $latestidle->processed_record = ++$index;
            $latestidle->save(false);

            $currentMobile = $currentLine[0];
            $newBlackListedmobile = new BlackListedMobile();
            //cleaning time 
            $currentMobile = trim($currentMobile);
            $currentMobile = rtrim($currentMobile);
            $currentMobile = ltrim($currentMobile);
            $newBlackListedmobile->mobile_number = $currentMobile;
            $newBlackListedmobile->queue_id = $latestidle->queue_id;//set queueid
            if ($newBlackListedmobile->save()) {//save content
                echo "$newBlackListedmobile->mobile_number : Saved \n";
            }else{
                echo "$newBlackListedmobile->mobile_number : Failed \n";
            }
        }//when done
        //set status to done
        $latestidle->status = JobQueue::$JOBQUEUE_STATUS_DONE;
        $latestidle->date_done = date("Y-m-d H:i:s");//set done datetime to now()
        $latestidle->save();
        echo "Queue DONE \n";
    }
}