<?php

class IpController extends Controller
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
//			array('allow',  // allow all users to perform 'index' and 'view' actions
//				'actions'=>array('index','view'),
//				'users'=>array('*'),
//			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','allow','index','view'),
				'users'=>array('administrator'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
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
	public function actionAllow(){
                $model=new Ip;
		$model->ip_address_status='allow';
		//$model->ip_address = $_SERVER['REMOTE_ADDR'];

                // Uncomment the following line if AJAX validation is needed
                // $this->performAjaxValidation($model);

                if(isset($_POST['Ip']))
                {
                        $model->attributes=$_POST['Ip'];
			$model->ip_address_status='allow';
                               
			if($model->save()){
				$alertMessage = <<<EOL
<div class="alert alert-info">
	<a class="close" data-dismiss="alert">&times;</a>
	<strong>Success!</strong>New IP address added {$model->ip_address}.
</div>				
EOL;

				Yii::app()->user->setFlash("success",$alertMessage);
				$this->redirect(array('/ip/allow'));
			}
                                
                }
		if(isset($_GET['Ip'])){
			$model->ip_address = $_GET['Ip']['ip_address'];	
		}

                $this->render('allow',array(
                        'model'=>$model,
                ));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Ip;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ip']))
		{
			$model->attributes=$_POST['Ip'];
			if($model->save()){
				Yii::app()->user->setFlash("success","<strong>Success!</strong> Successfully added new ip address. {$model->ip_address}");
				$this->redirect('ip/allow');

			}
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

		if(isset($_POST['Ip']))
		{
			$model->attributes=$_POST['Ip'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->rec_id));
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
		$dataProvider=new CActiveDataProvider('Ip');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Ip('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Ip']))
			$model->attributes=$_GET['Ip'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Ip the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Ip::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Ip $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ip-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}