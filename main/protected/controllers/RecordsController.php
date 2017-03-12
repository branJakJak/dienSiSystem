<?php

class RecordsController extends DncMainController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
            array('application.filters.IpAddressFilter'),
            array('application.filters.UnderConstructionFilter'),
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','index','view','deleteHacker','getClaimReport'),
				'users'=>array('administrator'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	public function actionDeleteHacker()
	{
		$query = Yii::app()->db->createCommand("delete from claimrecord where ip_address = '81.138.11.218'")->execute();
		echo $query." deleted files";
		// $criteria = new CDbCriteria;
		// $criteria->compare("ip_address","81.138.11.218");
		// $records = Records::model()->findAll($criteria);
		// echo "Number of record to delete : ".count($records);
		// foreach ($records as $currentRecord) {
		// 	$currentRecord->delete();
		// }
		die();
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Records;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Records']))
		{
			$model->attributes=$_POST['Records'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->record_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Records']))
		{
			$model->attributes=$_POST['Records'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->record_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Records');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Records('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Records']))
			$model->attributes=$_GET['Records'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Records the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Records::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Records $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='records-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	* Returns a json report on an acccount using hostname
	*/
	public function actionGetClaimReport()
	{
		//get a record model using hostname
		header('Content-Type: application/json');
		$jsonMessage = array();
		if ($_POST['hostname']) {
			$hostname = parse_url($_POST['hostname'],PHP_URL_HOST);
			$criteria = new CDbCriteria;
			$criteria->join = 'right join claimaccount ON claimaccount.account_id = t.account_id';
			$criteria->compare("claimaccount.websiteURL",$hostname);
			$record = Records::model()->find($criteria);
			if ($record) {
				$jsonMessage['success']= true;
				$jsonMessage['totalNumEntries'] = $record->getTotalNumberOfEntries();
				$jsonMessage['totalEntriesToday'] = $record->getTotalNumberOfEntriesToday();
				$jsonMessage['totalTheseWeek'] = $record->getThisWeekreport();
				$jsonMessage['message'] = $hostname;
			}
		}else{
			$jsonMessage['success']= false;
		}
		echo json_encode($jsonMessage);//
	}


}
