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
				'actions'=>array('index','list'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('download'),
				'users'=>array('*')
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
		if (isset($_GET['download'])) {
			$fileName = $model->queue_name.'-cleaneddata';
			// header("Content-Type: text/plain");
			// header("Content-Disposition: attachment; filename=\"$fileName.txt\";" );
			echo "Mobile Number"."\r\n";
            DncUtilities::printCleanMobileNumbers($model->queue_id);
			die();
		}
		if ($model) {
			$totalUploadedMobileNumbers = DncUtilities::getTotalUploadedMobileNumbers($model->queue_id);
			$removedMobileNumbers = DncUtilities::getRemovedMobileNumber($model->queue_id);
			$totalDuplicatesRemoved = DncUtilities::getTotalDuplicatesRemoved($model->queue_id);
			$totalDataToDownload = DncUtilities::getTotalDataToDownload($model->queue_id);
			$this->render('index' ,  array('model'=>$model,'totalUploadedMobileNumbers'=>$totalUploadedMobileNumbers  , 'totalDuplicatesRemoved'=> $totalDuplicatesRemoved , 'totalDataToDownload'=>$totalDataToDownload  )   );
		}
	}
	public function actionList()
	{
        $this->render('list');
	}

}
