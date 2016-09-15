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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','list','exportStatus'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('download'),
				'users'=>array('@')
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex($id)
	{
        Yii::import("application.modules.dnc.components.*");
        /* @var $model WhitelistJobQueue */
		$model = WhitelistJobQueue::model()->findByPk($id);
		if ($model) {
			/*check if the file exists*/
			$exportFileLocation = Yii::getPathOfAlias("application.data").'/cleandata-'.$model->queue_name;
			/*count number of lines content*/
			$lineCountRaw = `wc -l $exportFileLocation`;
			$lineCountArr = explode(" ", $lineCountRaw);
			$lineCountInt = intval($lineCountArr[0]);
			if (file_exists($exportFileLocation) && $lineCountInt > 0) {
				$fileName = $model->queue_name.'-cleaneddata';
				header("Content-Type: text/plain");
				header("Content-Disposition: attachment; filename=\"$fileName.txt\";" );
				echo "Mobile Number"."\r\n";
				echo file_get_contents($exportFileLocation);
			} else {
				/*notify the user  that the file is being exported */
                /*prepare export file path*/
                $exportFileLocation='cleandata-'.$model->queue_name;
                DncUtilities::exportCleanToFile($exportFileLocation ,$model->queue_id);
                Yii::app()->user->setFlash('success', '<strong>Please wait</strong> We are currrently processing the exported file. ');
                /* notify our script that export status is pending*/
                Yii::app()->clientScript->registerScript('notifyScript', 'window.EXPORT_STATUS = "pending";', CClientScript::POS_END);
				$totalUploadedMobileNumbers = "disabled";
				$removedMobileNumbersArr = "disabled";
				$removedMobileNumbersArr = "disabled";
				$removedMobileNumbers = "disabled";
				$totalDuplicatesRemoved = "disabled";
				$totalDataToDownload = "disabled";
				$this->render('index' ,  array('model'=>$model,'totalUploadedMobileNumbers'=>$totalUploadedMobileNumbers  , "removedMobileNumbersArr"=>$removedMobileNumbersArr , 'totalDuplicatesRemoved'=> $totalDuplicatesRemoved , 'totalDataToDownload'=>$totalDataToDownload  )   );                
			}
		} else {
			throw new CHttpException(404,"Can't find $id from database", 1);
		}
	}
	public function actionExportStatus($queue_id)
	{
		header("Content-Type: application/json");
        Yii::import("application.modules.dnc.components.*");
        /* @var $model WhitelistJobQueue */
		$model = WhitelistJobQueue::model()->findByPk($queue_id);
		if ($model){
			$exportFileLocation = Yii::getPathOfAlias("application.data").'/cleandata-'.$model->queue_name;
			/*count number of lines content*/
			$lineCountRaw = `wc -l $exportFileLocation`;
			$lineCountArr = explode(" ", $lineCountRaw);
			$lineCountInt = intval($lineCountArr[0]);
			$returnMess = array();
			if ( $lineCountInt > 0 ) {
				$returnMess['status']='ok';
			}else{
				$returnMess['status']='pending';
			}
			echo CJSON::encode($returnMess);
			Yii::app()->end();
		}else{
			throw new CHttpException(404,"$queue_id doesnt exists in the whitelist job queue");
		}
		
	}
	public function actionList()
	{
        $this->render('list');
	}

}
