<?php

class ClaimsettingsController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','requestExport','updateAjax','getSettings','remoteLogin','changeSettings'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','analyticsCode'),
				'users'=>array('administrator'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	public function actionChangeSettings()
	{
		$criteria = new CDbCriteria;
		$criteria->compare("settings_key",'analyticsCode');
		$claimsettings = Claimsettings::model()->findAll($criteria);
		foreach ($claimsettings as $claimSetting) {
			$newSettingsValue = str_replace("nb_visits", "nb_actions", $claimSetting->settings_val);
			$claimSetting->settings_val = $newSettingsValue;
			if ($claimSetting->save()) {
				echo "Updated!";
			}else{
				echo "Failed to update!";
			}
			echo "<br>";
			echo "<br>";
		}
	}
	public function actionAnalyticsCode()
	{
		if (isset($_POST['accountID'])) {
			$criteria = new CDbCriteria;
			$criteria->compare('settings_owner',(int)$_POST['accountID']);
			$criteria->compare('settings_key','analyticsCode');
			$foundsetting=Claimsettings::model()->find($criteria);
			if ($foundsetting) {
				echo $foundsetting->settings_val;
			}else{
				throw new CHttpException(404,'Cant find your request');
			}
		}else{
			throw new CHttpException(500,'Incomplete request');
		}
	}

	public function actionRemoteLogin()
	{
		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
		if (isset($_POST['accountID']) && isset($_POST['remoteUsername']) && isset($_POST['remotePassword'])   ) {
			$criteriaUsername = new CDbCriteria;
			$criteriaUsername->compare('settings_owner',(int)$_POST['accountID']);
			$criteriaUsername->compare('settings_key','exportUsername');
			/*if username is match */
			$foundUsername = Claimsettings::model()->find($criteriaUsername);
			if ($foundUsername->settings_val === $_POST['remoteUsername']) {
				/*check password*/
				$criteriaPassword = new CDbCriteria;
				$criteriaPassword->compare('settings_owner',(int)$_POST['accountID']);
				$criteriaPassword->compare('settings_key','exportPassword');
				$foundPassword = Claimsettings::model()->find($criteriaPassword);
				if ($foundPassword->settings_val === $_POST['remotePassword']) {
					$dataArr = array(
							'type'=>'success',
							'message'=>'Success : Successfully logged in'
						);
				}else{
					$dataArr = array(
							'type'=>'error',
							'message'=>'Error : Invalid Password'
						);
				}

			}else{
				$dataArr = array(	
						'type'=>'error',
						'message'=>'Error : Username doesnt exist',
					);
			}
		}else{
			$dataArr = array(
					'type'=>'error',
					'message'=>'Error : Incomplete paramters',
				);
		}
		echo CJSON::encode($dataArr);

	}


	public function actionGetSettings()
	{
		header('Content-Type: application/json');
		if (isset($_GET['accountID'])) {
			/*get settings of that account*/
			$criteria = new CDbCriteria;
			$criteria->compare('settings_owner',(int)$_GET['accountID']);
			$foundSettings = Claimsettings::model()->findAll($criteria);
			$message = array(
					'type'=>"success",
					'data'=>$foundSettings
				);
			echo CJSON::encode($message);
		}else{
			$errorMessage = array(
					"type"=>"error",
					"message"=> "Please supply accountID"
				);
			echo CJSON::encode($errorMessage);
		}
	}
	public function actionUpdateAjax()
	{
		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
		$dataArr = array(
				'type'=>'invalid',
				'message'=>'Invalid parameter or incomplete parameter'
			);
		if (isset($_POST['canExport'])) {
			/*update canExport settings*/
			$criteria = new CDbCriteria;
			$criteria->compare("settings_owner" ,$_POST['accountID'] );
			$criteria->compare("settings_key","canExport");
			$found = Claimsettings::model()->find($criteria);
			$found->settings_val = $_POST['canExport'];
			if ($found->save()) {
				$dataArr = array(
						'type'=>'success',
						'message'=>'Success  : Settings updated'
					);
			}else{
				$dataArr = array(
						'type'=>'error',
						'message'=>'Error  : Failed to update'
					);
			}
		}
		if (isset($_POST['settingsUsername']) && isset($_POST['settingsPassword'])) {
			if (!empty($_POST['settingsUsername']) && !empty($_POST['settingsPassword'])) {
				/*update export accounts */
				$criteriaUsername = new CDbCriteria;
				$criteriaUsername->compare("settings_owner",(int)$_POST['accountID']);
				$criteriaUsername->compare('settings_key','exportUsername');
				$foundUsername = Claimsettings::model()->find($criteriaUsername);
				$foundUsername->settings_val = $_POST['settingsUsername'];
				if ($foundUsername->save()) {
					$dataArr = array(
						'type'=>'success',
						'message'=>'Success  : Settings updated'
					);
				}else{
					$dataArr = array(
							'type'=>'error',
							'message'=>'Error  : Failed to update username'
						);
				}
				$criteriaPassword = new CDbCriteria;
				$criteriaPassword->compare("settings_owner",(int)$_POST['accountID']);
				$criteriaPassword->compare('settings_key','exportPassword');
				$foundPassword = Claimsettings::model()->find($criteriaPassword);
				$foundPassword->settings_val = $_POST['settingsPassword'];
				if ($foundPassword->save()) {
					$dataArr = array(
						'type'=>'success',
						'message'=>'Success  : Settings updated'
					);
				}else{
					$dataArr = array(
							'type'=>'error',
							'message'=>'Error  : Failed to update password'
						);
				}
			}
		}
		echo json_encode($dataArr);
	}
	public function actionRequestExport()
	{
		if ($_POST['accountID']) {
			header('Content-Type: application/json');
			header('Access-Control-Allow-Origin: *');
			/*check if these settings has */
			$criteria = new CDbCriteria;
			$criteria->compare("settings_key","canExport");
			$criteria->compare("settings_owner",intval($_POST['accountID']));
			$singleSetting = Claimsettings::model()->find($criteria);
			if ($singleSetting->settings_val === 'yes') {
				$dataArr = array(
						'type'=>"success",
						'message'=>"You are allowed to export",
					);
			}else{
				$dataArr = array(
						'type'=>"error",
						'message'=>"You are not allowed to export",
					);
			}
		}else{
			$dataArr = array(
				'type'=>"error",
				'message'=>"Invalid parameter",
				);
		}
		echo json_encode($dataArr);
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
		$model=new Claimsettings;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Claimsettings']))
		{
			$model->attributes=$_POST['Claimsettings'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->settings_id));
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

		if(isset($_POST['Claimsettings']))
		{
			$model->attributes=$_POST['Claimsettings'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->settings_id));
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
		$dataProvider=new CActiveDataProvider('Claimsettings');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Claimsettings('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Claimsettings'])){
			// if (!is_numeric($_GET['Claimsettings']['settingsOwner'])) {
			// 	/*find settings owmer where owner name is equal to this*/
			// 	$criteria = new CDbCriteria;
			// 	$criteria->compare("claimAccountName",$_GET['Claimsettings']['settings_owner']);
			// 	$found = Accounts::model()->find($criteria);
			// 	if ($found) {
			// 		$_GET['Claimsettings']['settings_owner'] = $found->account_id;
			// 	}else{
			// 		$_GET['Claimsettings']['settings_owner'] = 0;
			// 	}
			// }
			$model->attributes=$_GET['Claimsettings'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Claimsettings the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Claimsettings::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Claimsettings $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='claimsettings-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
