<?php
/**
 * Created by JetBrains PhpStorm.
 * User: EMAXX-A55-FM2
 * Date: 2/16/15
 * Time: 9:19 PM
 * To change this template use File | Settings | File Templates.
 */

class WhiteListerCommand extends CConsoleCommand{
    public function actionIndex()
    {
        Yii::import("application.models.*");
        //get a queued file
        $criteria = new CDbCriteria();
        $criteria->addInCondition("status", array("IDLE", "REQUEUE"));
        /* @var $currentQueue WhitelistJobQueue*/
        $currentQueue = WhitelistJobQueue::model()->find($criteria);

        //if no queued file die()
        if (!$currentQueue) {
            echo "No files in queue";
            die();
        }
        // else continue as usuall
        $currentQueue->status = WhitelistJobQueue::$JOBQUEUE_STATUS_ON_GOING;
        $currentQueue->save(false);

        //get contents
        $currentCsvFile = new SplFileObject($currentQueue->filename);
        $currentCsvFile->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD |  SplFileObject::DROP_NEW_LINE | SplFileObject::SKIP_EMPTY);


        //get total number of lines
        $currentCsvFile->seek(PHP_INT_MAX);
        $linesTotal = $currentCsvFile->key();
        $currentQueue->total_records = $linesTotal;
        $currentQueue->save(false);

        $currentCsvFile->rewind();
        $currentCsvFile->next();
        //foreach content , lookup in the blacklist record
        $index = 0;
        foreach ($currentCsvFile as $content) {
            if ($currentCsvFile->key() === 0) {
                continue;
            }

            $currentQueue->processed_record = ++$index;
            $currentQueue->save(false);
            

            $currentMobileNumber = $content[0];
            $curMobileObj = new WhiteListedMobile();
            //cleaning time
            $currentMobileNumber = trim($currentMobileNumber);
            $currentMobileNumber = rtrim($currentMobileNumber);
            $currentMobileNumber = ltrim($currentMobileNumber);
            $curMobileObj->mobile_number = $currentMobileNumber;
            $curMobileObj->queue_id = $currentQueue->queue_id;

            $criteria2 = new CDbCriteria();
            $criteria2->addSearchCondition("mobile_number", $currentMobileNumber);
            
            $isOpted = BlackListedMobile::model()->exists($criteria2);

            //if opted , set status error
            if($isOpted){
                $curMobileObj->status = WhiteListedMobile::$WHITELISTEDMOBILE_STATUS_ERROR;
            }else{
                //else status ok
                $curMobileObj->status = WhiteListedMobile::$WHITELISTEDMOBILE_STATUS_OK;
            }
            $curMobileObj->save();
            echo "$curMobileObj->mobile_number  : $curMobileObj->status \n";
        }
        //done
        $currentQueue->status = WhitelistJobQueue::$JOBQUEUE_STATUS_DONE;
        $currentQueue->date_done = date("Y-m-d H:i:s");//set done datetime to now()
        $currentQueue->save();
    }
}