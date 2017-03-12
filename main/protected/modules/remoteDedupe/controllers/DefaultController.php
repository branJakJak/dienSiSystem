<?php

class DefaultController extends Controller
{
    public function actionIndex()
    {
        Yii::import("application.modules.dnc.components.*");
        if (Yii::app()->request->isPostRequest && isset($_POST['accessKey']) && !empty($_POST['accessKey'])) {

            $rawFromPhpInput = file_get_contents("php://input");
            $rawFromPhpInputArr = explode("&", $rawFromPhpInput);
            foreach ($rawFromPhpInputArr as $currentData) {
                $currentGetData  = explode("=", $currentData);
                $_POST[$currentGetData[0]] = $currentGetData[1];
            }



            $tempName = tempnam(Yii::getPathOfAlias("application.data"), "tempWrite");
            $tempName = $tempName . '.csv';




            $tempContainerData = str_replace(" ", "", $_POST['data']);
            $tempContainerData = trim($tempContainerData);
            $tempContainerData = ltrim($tempContainerData);
            $tempContainerData = trim($tempContainerData);
            $mobileNumsArr = explode("%0A",$tempContainerData);
            $mobileNumsArr = array_filter($mobileNumsArr); //
            $tempNumsContainer = implode("\n", $mobileNumsArr);


            file_put_contents($tempName, $tempNumsContainer);
            $linecount = count($mobileNumsArr);
            $criteria = new CDbCriteria;
            $criteria->compare("queue_name", $_POST['fileName']);
            $whiteListjob = WhitelistJobQueue::model()->find($criteria);

            if (!$whiteListjob) {
                $whiteListjob = new WhitelistJobQueue;
                $whiteListjob->filename = $tempName;
                if (isset($_POST['fileName'])) {
                    $whiteListjob->queue_name = $_POST['fileName'];
                } else {
                    $whiteListjob->queue_name = 'Uploaded-' . date("Y.m.d.H.i.s");
                }
            }
            $whiteListjob->status = WhitelistJobQueue::$JOBQUEUE_STATUS_IDLE;
            //Add scan total
            $whiteListjob->total_records = intval($whiteListjob->total_records) + intval($linecount);
            $whiteListjob->processed_record = intval($whiteListjob->processed_record) + $linecount;
            $whiteListjob->status = WhitelistJobQueue::$JOBQUEUE_STATUS_DONE; //status to done

            if ($whiteListjob->save()) {
                //insert queueid sa file firstColumn,
                $tempDump = tempnam(sys_get_temp_dir(), "temp");
                $insertQueueidColCommand = "gawk '{print \"$whiteListjob->queue_id,0\"$0}' $tempName > $tempDump";
                exec($insertQueueidColCommand);
                exec("mv \"$tempDump\" \"$tempName\"  ");
                //insert the whitelisted data to database;
                $filePath = $tempName;
                $sqlCommand = <<<EOL
LOAD DATA LOCAL INFILE "%s"
INTO TABLE white_listed_mobile
FIELDS TERMINATED BY "%s"
LINES TERMINATED BY "%s"
IGNORE 0 LINES
(queue_id,mobile_number)
EOL;
                $sqlCommand = sprintf($sqlCommand, $filePath, ',', '\n');
                $mainCommand = "mysql  --user=dncsyste_dnc --password=hitman052529 --database=dncsyste_dnc -e '$sqlCommand'";
                exec($mainCommand);
                /*clean up*/
            }
        }else if(isset($_GET['queue_name'])  && !isset($_GET['query']) ){
            $criteriaWhiteList = new CDbCriteria;
            $criteriaWhiteList->compare("queue_name", $_GET['queue_name'] );
            $model = WhitelistJobQueue::model()->find($criteriaWhiteList);
            /* @var $model WhitelistJ~obQueue */
            if ( $model ) {
                /*get queue id of whitelisted job queue*/
                DncUtilities::getCleanMobileNumberIncDups($model->queue_id);
            }else{
                throw new CHttpException(404, "Cant find queue name provided : " . CHtml::encode($_GET['queue_name']));
            }
        }else if (isset($_GET['query'])  && isset($_GET['queue_name']) ) {
            $queryName = $_GET['query'];
            $criteriaWhiteList = new CDbCriteria;
            $criteriaWhiteList->compare("queue_name", $_GET['queue_name'] );
            $model = WhitelistJobQueue::model()->find($criteriaWhiteList);
            /* @var $model WhitelistJ~obQueue */
            if ( $model ) {
                $removedDataArr = DncUtilities::$queryName($model->queue_id);
                echo count($removedDataArr);
            }else{
                throw new CHttpException(404, "Cant find queue name provided : " . CHtml::encode($_GET['queue_name']));
            }

        }else{
            throw new CHttpException(404, "Sorry that page is unavailable");
        }

    }
}