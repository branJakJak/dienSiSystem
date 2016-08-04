<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 8/2/16
 * Time: 2:25 AM
 */

class DisposaleForm extends CFormModel{

    public $dispo_name;
    public $phone_number;
    public $posted_data;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('dispo_name, posted_data , phone_number', 'required'),
            array('phone_number', 'numerical'),
            array('dispo_name', 'length', 'max'=>255),
            array('phone_number', 'checkRule'),
            array('date_created, date_updated', 'safe'),
        );
    }

    public function checkRule($attribute , $params){
        /*check db if it exists*/
        /* @var $dispoModel Disposale*/
        if(!isset($this->$attribute) || empty($this->$attribute)) {
            $this->addError($attribute, "Can't check rule. You must provide a mobile number");
        }
        $criteria = new CDbCriteria();
        $criteria->compare("phone_number", $this->$attribute);
        $criteria->order = "date_created DESC";
        $dispoModel = Disposale::model()->find($criteria);
        $isValid = true;
        if($dispoModel && !empty($dispoModel) ){
            $dt1Str = date("Y-m-d H:i:s", strtotime($dispoModel->date_created));
            $dt2Str = date("Y-m-d H:i:s", strtotime("+0 day" ));
            $dt1Obj = new DateTime($dt1Str);
            $dt2Obj = new DateTime($dt2Str);
            $dateDifference = $dt2Obj->diff($dt1Obj)->format("%a");
            $dateDifference = intval($dateDifference);
            $limitDays = intval(\Yii::app()->params['time_limit']);
            /*After 182 days , if equal to 182 still not valid*/
            if($dateDifference <= $limitDays){
                $lastInsertData = $dispoModel->date_created;
                $this->addError($attribute, "Sorry we cant process your data . You must wait {$limitDays} days before we accept your submittion. Last insert was $lastInsertData. Difference is $dateDifference and limit is $limitDays");
            }
        }
        return $isValid;
    }

    public function save()
    {
        $status = false;
        if($this->validate()){
            $newDispoModel = new Disposale();
            $newDispoModel->dispo_name = $this->dispo_name;
            $newDispoModel->phone_number = $this->phone_number;
            $newDispoModel->posted_data = $this->posted_data;
            $status = $newDispoModel->save();
        }
        return $status;
    }


}