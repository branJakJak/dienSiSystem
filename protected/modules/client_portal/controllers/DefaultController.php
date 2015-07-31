<?php

class DefaultController extends Controller
{
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            array('application.filters.IpAddressFilter'),
            array('application.filters.UnderConstructionFilter'),
        );
    }

    public function actionIndex()
    {
        $criteria = new CDbCriteria;
        $criteria->compare("origin", "client");
        $criteria->order = "date_created DESC";
        $dataProvider = new CActiveDataProvider("BlackListedMobile", array("criteria" => $criteria));
        $this->render('index', array('dataProvider' => $dataProvider));
    }
}