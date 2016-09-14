<?php

class DefaultController extends Controller
{
    public $layout = '//layouts/dnc_layout';
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            array('application.filters.IpAddressFilter'),
            array('application.filters.UnderConstructionFilter'),
            'accessControl',
        );
    }
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('index'),
                'users'=>array('@'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }    


    public function actionIndex()
    {
        Yii::import('application.modules.dnc.components.*');
        $dncFile = CUploadedFile::getInstanceByName("dncFile");
        if (isset($_POST['manualCheck']) && !empty($_POST['manualCheck'])) {
            //write the massive input to a csv file . process it like a whitelistjobqueue
            $criteria = new CDbCriteria();
            $criteria->compare("mobile_number", $_POST['manualCheck']);
            // $criteria->addSearchCondition("mobile_number", $_POST['manualCheck']);
            $mobileIsWhiteListed = BlackListedMobile::model()->exists($criteria);
            if ($mobileIsWhiteListed) {
                Yii::app()->user->setFlash('error', '<strong>Mobile Number opted out!</strong> The mobile number opted out before.');
            } else {
                Yii::app()->user->setFlash('success', '<strong>Mobile Number is Clean!</strong> The mobile number has not been opted yet.');
            }
        } else if (isset($_POST['massiveTextArea'])) {
            //write the posted manual file  to a CSV file
            $tempName = tempnam(Yii::getPathOfAlias('application.tempWrite'), "tempWrite");
            $tempName = $tempName . '.csv';
            $mobileNumsArr = explode("\n", $_POST['massiveTextArea']);
            $mobileNumsArr = array_filter($mobileNumsArr); //
            $tempNumsContainer = implode("\n", $mobileNumsArr);
            file_put_contents($tempName, $tempNumsContainer);
            $linecount = count($mobileNumsArr);
            $criteria = new CDbCriteria;
            $criteria->compare("queue_name" , $_POST['copyPasteFileName']);
            $whiteListjob = WhitelistJobQueue::model()->find($criteria);
            if (!$whiteListjob) {
                $whiteListjob = new WhitelistJobQueue;
                $whiteListjob->filename = $tempName;
                if (isset($_POST['copyPasteFileName'])) {
                    $whiteListjob->queue_name = $_POST['copyPasteFileName'];
                }else{
                    $whiteListjob->queue_name = 'Uploaded-'. date("Y.m.d.H.i.s");
                }
            }
            $whiteListjob->status = WhitelistJobQueue::$JOBQUEUE_STATUS_IDLE;
            //Add scan total
            $whiteListjob->total_records = intval($whiteListjob->total_records) + intval($linecount);
            $whiteListjob->processed_record = intval($whiteListjob->processed_record)+$linecount;
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

                $mainCommand = "nohup mysql  --user=dncsyste_dnc --password=hitman052529 --database=dncsyste_dnc -e '$sqlCommand' > /dev/null 2>&1 &";
                exec($mainCommand);
                $referenceLink = Yii::app()->getBaseUrl(true) . "/dnc/" . $whiteListjob->queue_id;

                /*prepare export file path*/
                $exportFileLocation=$whiteListjob->queue_name.'-cleandata.csv';
                $queue_id = $whiteListjob->queue_id;
                DncUtilities::exportCleanToFile($exportFileLocation ,$queue_id);
                
                //execute the nohup command here
                Yii::app()->user->setFlash('success', '<strong>File Uploaded!</strong> Please click the link to download your cleaned mobile numbers . ' . CHtml::link('Reference Link', $referenceLink));
            } else {
                Yii::app()->user->setFlash('error', CHtml::errorSummary($whiteListjob));
            }
        } else if ($dncFile) {
            $newFileLocation = Yii::getPathOfAlias("application.uploaded_files") . DIRECTORY_SEPARATOR . uniqid();
            $whileListjob = new WhitelistJobQueue();
            $dncFile->saveAs($newFileLocation);
            $whileListjob->queue_name = $dncFile->name;
            $whileListjob->filename = $newFileLocation;
            $whileListjob->status = WhitelistJobQueue::$JOBQUEUE_STATUS_IDLE;
            //add scan total
            $queueFile = new SplFileObject($whileListjob->filename); //read file
            $queueFile->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD | SplFileObject::DROP_NEW_LINE | SplFileObject::SKIP_EMPTY);
            $queueFile->seek(PHP_INT_MAX);
            $linesTotal = $queueFile->key();
            $whileListjob->total_records = $linesTotal;
            $whileListjob->processed_record = $linesTotal;
            $whileListjob->status = WhitelistJobQueue::$JOBQUEUE_STATUS_DONE; //status to done
            if ($whileListjob->save()) {
                //insert queueid sa file firstColumn,
                $tempDump = tempnam(sys_get_temp_dir(), "temp");
                exec("head -1500000 $newFileLocation > $tempDump"); //cut first 1m 500 k
                exec("gawk '{print \"$whileListjob->queue_id,0\"$0}' $tempDump > $newFileLocation"); //insert queueid

                $queueFile = null;
                $queueFile = new SplFileObject($newFileLocation); //read file

                $queueFile->seek(PHP_INT_MAX);
                $linesTotal = $queueFile->key();
                $whileListjob->filename = $newFileLocation;
                $whileListjob->total_records = $linesTotal;
                $whileListjob->processed_record = $linesTotal;
                $whileListjob->save();


                $sqlCommand = <<<EOL
LOAD DATA LOCAL INFILE "%s"
INTO TABLE white_listed_mobile
FIELDS TERMINATED BY "%s"
LINES TERMINATED BY "%s"
IGNORE 0 LINES
(queue_id,mobile_number)
EOL;

                $sqlCommand = sprintf($sqlCommand, $newFileLocation, ',', '\n');
 
                $mainCommand = "nohup mysql  --user=dncsyste_dnc --password=hitman052529 --database=dncsyste_dnc -e '$sqlCommand' > /dev/null 2>&1 &";
                $result = exec($mainCommand);
                //unlink($tempDump);
                $referenceLink = Yii::app()->getBaseUrl(true) . "/dnc/" . $whileListjob->queue_id;

                /*prepare export file path*/
                $exportFileLocation=$whileListjob->queue_name.'-cleandata.csv';
                $queue_id = $whileListjob->queue_id;
                DncUtilities::exportCleanToFile($exportFileLocation ,$queue_id);
                
                Yii::app()->user->setFlash('success', '<strong>File Uploaded!</strong> Please click the link to download your cleaned mobile numbers . ' . CHtml::link('Reference Link', $referenceLink));
            } else {
                Yii::app()->user->setFlash('error', CHtml::errorSummary($whileListjob));
            }
        }
        Yii::app()->user->setFlash('info', '<strong><i class="fa fa-info-circle"></i></strong> Please use the following format  : 07#########.');
        $this->render('index');
    }
}
