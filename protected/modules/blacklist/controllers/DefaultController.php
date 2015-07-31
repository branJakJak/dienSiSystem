<?php

class DefaultController extends Controller
{
    public $layout='//layouts/column2';

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
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
	public function actionIndex()
	{
        $uploadedFile = CUploadedFile::getInstanceByName("blackListedFile");
        if (isset($_GET['downloadSampleFile'])) {
            $headers = array("Mobilephone");
            $contents = array(
                array("447123456789"),
                array("447123456455"),
                array("447123456321"),
            );
            $tempFile = new SplTempFileObject();
            $tempFile->fputcsv($headers);
            foreach ($contents as $currentLine) {
                $tempFile->fputcsv($currentLine);
            }
            $tempFile->rewind();
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=SampleFile.csv");
            header("Pragma: no-cache");
            header("Expires: 0");
            $tempFile->fpassthru();
            die();
        }
        if(isset($_POST['singleBlackList']) && !empty($_POST['singleBlackList'] ) ) {
            $newMobileNum = new BlackListedMobile();
            $newMobileNum->mobile_number = $_POST['singleBlackList'];
            $newMobileNum->queue_id = 1;
            if ($newMobileNum->save()) {
                Yii::app()->user->setFlash('success', '<strong>New blacklist mobile numberSaved!</strong>');
            }else{
                Yii::app()->user->setFlash('error', '<strong>Error!</strong>'.CHtml::errorSummary($newMobileNum));
            }

        }if(isset($_POST['massiveTextArea'])  && !empty($_POST['massiveTextArea'] ) ) {
            
            /*@TODO get total now , using randomQueue  */
            $queueName = ( ($_POST['randomQueue']) ? $_POST['randomQueue'] : 'Task : upload - '.rand(0,9999) );
            $criteriaJobQueue = new CDbCriteria;
            $criteriaJobQueue->compare("queue_name" , $queueName );
            $jobQueueModl = JobQueue::model()->find($criteriaJobQueue);
            /*@TODO $total_before*/
            $total_before = 0;
            if (!$jobQueueModl) {
                $jobQueueModl = new JobQueue(); //@TODO declare above , 
                $jobQueueModl->queue_name = $queueName;
                $jobQueueModl->save(false);//pre save
            }else{
                $criteriaTotalBefore = new CDbCriteria;
                $criteriaTotalBefore->compare("queue_id" , $jobQueueModl->queue_id);
                $total_before = BlackListedMobile::model()->count($criteriaTotalBefore);
            }

            /*write posted textarea to file*/
            $tp = tempnam(  Yii::getPathOfAlias('application.data') ,"tempWrite");
            $tempName = $tp.'.csv';


            


            $linecount = 0;
            $tempContainer2= explode("\n", $_POST['massiveTextArea']);
            $tempContainer2 = array_filter($tempContainer2);
            $linecount = count($tempContainer2);
            file_put_contents($tempName, implode(PHP_EOL, $tempContainer2)   );


            // $handle = fopen($tempName, "r");
            // while(!feof($handle)){
            //     $line = fgets($handle);  
            //     ++$linecount;
            // }
            // fclose($handle);
            


            $jobQueueModl->filename = $tempName;//ignore this
            $jobQueueModl->status = JobQueue::$JOBQUEUE_STATUS_PRELOADED;

            /*check number files' number of line*/
            // Total_records ,
            $jobQueueModl->total_records = $linecount;
            $jobQueueModl->processed_record = $linecount;

            /*update job queue record*/
            if($jobQueueModl->save()){
                $filePath = $tempName;

                /*load to database*/
                $tempFile2 = tempnam(__DIR__, "tempContainer");
                $appendCommand = sprintf('cat "%s" | gawk \'{print $0",0%s"}\'  > "%s" ', $filePath , $jobQueueModl->queue_id,$tempFile2);
                system($appendCommand);
                system("mv \"$tempFile2\" \"$filePath\"");
                $sqlCommand = <<<EOL
LOAD DATA LOCAL INFILE "%s"
INTO TABLE black_listed_mobile
FIELDS TERMINATED BY "%s"
LINES TERMINATED BY "%s"
IGNORE 0 LINES
(mobile_number,queue_id)
EOL;
                $sqlCommand = sprintf($sqlCommand, $filePath , ',' , '\n');
                $mainCommand = "mysql  --user=dncsyste_dnc --password=hitman052529 --database=dncsyste_dnc -e '$sqlCommand'";
                exec($mainCommand);
                
                $criteriaTotalBefore = new CDbCriteria;
                $criteriaTotalBefore->compare("queue_id" , $jobQueueModl->queue_id);
                /* $total_now*/
                $total_now = BlackListedMobile::model()->count($criteriaTotalBefore);
                if (Yii::app()->request->isAjaxRequest) {
                    header("Content-Type: application/json");
                    $numOfInsertedData =  ($total_now - $total_before);
                    $numOfInsertedData = ($numOfInsertedData <= 0) ? 0 : $numOfInsertedData;
                    $numOfDeletedData = ( $linecount - ($total_now - $total_before));
                    $numOfDeletedData = ($numOfDeletedData <= 0) ? 0 : $numOfDeletedData ;
                    $jsonResult = array(
                            "numOfInsertedData"=> $numOfInsertedData,
                            "numOfDeletedData"=> $numOfDeletedData,
                        );
                    echo json_encode($jsonResult);
                    die();
                }else{
                    Yii::app()->user->setFlash('success', '<strong>File Imported!</strong>You have successfully imported new blacklisted mobile number. ');   
                }
            }else{
                Yii::app()->user->setFlash('error', CHtml::errorSummary($newQueueFile));
            }
        }if ($uploadedFile) {
            set_time_limit(0);
            $newFileLocation = Yii::getPathOfAlias("application.uploaded_files").DIRECTORY_SEPARATOR.rand(0,9999).'-'.$uploadedFile->name;
            //save new queue file
            $newQueueFile = new JobQueue();
            $uploadedFile->saveAs($newFileLocation);
            $newQueueFile->queue_name = "Task : ". $uploadedFile->name.' - '.rand(0,9999);
            $newQueueFile->filename = $newFileLocation;
            $newQueueFile->status = JobQueue::$JOBQUEUE_STATUS_PRELOADED;





            /*check number files' number of line*/
            $linesTotal = 0;
            $handle = fopen($newQueueFile->filename, "r");
            while(!feof($handle)){
              $line = fgets($handle);
              ++$linesTotal;
            }
            fclose($handle);

            $newQueueFile->total_records = $linesTotal;
            $newQueueFile->processed_record = $linesTotal;




            if($newQueueFile->save()){
                $filePath = $newQueueFile->filename;
                $tempFile2 = tempnam(__DIR__, "tempContainer");
                $appendCommand = sprintf('gawk \'{print $0",0%s"}\' "%s"  > "%s"',  $newQueueFile->queue_id,$filePath,$tempFile2);
		system($appendCommand);
                system("mv \"$tempFile2\" \"$filePath\"");
                /*append queue identification for blacklist*/
		$rawContents = file_get_contents($filePath);
//		print_r( explode("\n",$rawContents)  );
//		die();
                $sqlCommand = <<<EOL
LOAD DATA LOCAL INFILE "%s"
INTO TABLE black_listed_mobile
FIELDS TERMINATED BY "%s"
LINES TERMINATED BY "%s"
IGNORE 0 LINES
(mobile_number,queue_id)
EOL;
                $sqlCommand = sprintf($sqlCommand, $filePath , ',' , '\n');
                $mainCommand = "mysql  --user=dncsyste_dnc --password=hitman052529 --database=dncsyste_dnc -e '$sqlCommand'";
                exec($mainCommand);
                $undoLink = "<a href='".Yii::app()->getBaseUrl(true)."/blacklist/delete?queue_id=$newQueueFile->queue_id' onClick='return confirm(\"Are you sure you want to delete this ?\")'> Undo Action  </a>";
                Yii::app()->user->setFlash('success', '<strong>File Imported!</strong>You have successfully imported new blacklisted mobile number. '.$undoLink);

            }else{
                Yii::app()->user->setFlash('error', CHtml::errorSummary($newQueueFile));
            }
        }
		$this->render('index');
	}
}
