<?php

class DisposaleController extends DncMainController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

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
            array('allow',
                'actions' => array('save'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('create', 'update', 'index', 'view', 'admin', 'delete'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Required POSTED data are :
     * phone_number - required - number
     * dispo_name - required - any
     * @return void
     */
    public function actionSave()
    {
        header("Content-Type: application/json");
        $returnResult = [
            'status' => "",
            'message' => "",
        ];
        $p = new CHtmlPurifier();
        $disposaleForm = new DisposaleForm();
        $disposaleForm->dispo_name = $p->purify(@$_POST['dispo_name']);
        $disposaleForm->phone_number = $p->purify(@$_POST['phone_number']);
        $disposaleForm->posted_data = json_encode(@$_POST);
        if ($disposaleForm->validate()) {
            if ($disposaleForm->save()) {
                $returnResult['status'] = 'success';
                $returnResult['message'] = "New dispo sale saved";
            } else {
                $returnResult['status'] = 'failed';
                $returnResult['message'] = CHtml::errorSummary($disposaleForm);
            }
        } else {
            $returnResult['status'] = 'failed';
            $returnResult['message'] = CHtml::errorSummary($disposaleForm);
        }
        echo json_encode($returnResult);
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Disposale;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Disposale'])) {
            $model->attributes = $_POST['Disposale'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Disposale'])) {
            $model->attributes = $_POST['Disposale'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
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
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Disposale');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Disposale('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Disposale']))
            $model->attributes = $_GET['Disposale'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Disposale the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Disposale::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Disposale $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'disposale-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
