<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 8/2/16
 * Time: 2:53 AM
 */

namespace unit\model;


use CDbTestCase;
use CHtmlPurifier;
use DisposaleForm;

class DisposaleFormTest extends CDbTestCase {

    public function setUp() {
        \Disposale::model()->deleteAll();
    }

    public function testResumitAfterLimitDays()
    {
        $p = new CHtmlPurifier();
        $_POST['dispo_name'] = "something";
        $_POST['phone_number'] = "07321654987";
        $_POST['first_name'] = "juan";
        $_POST['last_name'] = "dela cruz";

        $disposaleForm = new DisposaleForm();
        $disposaleForm->dispo_name = $p->purify(@$_POST['dispo_name']);
        $disposaleForm->phone_number = $p->purify(@$_POST['phone_number']);
        $disposaleForm->posted_data = json_encode(@$_POST);
        $this->assertTrue($disposaleForm->validate(), "the disposale should validate and would'nt fail");

        /*Create record initial*/
        $this->assertTrue($disposaleForm->save() , "The disposale should save");
        //update the last record inserted - move date created to limit days passed + 1
        /**
         * @var $model \Disposale
         */
        $criteria = new \CDbCriteria();
        $criteria->order = "date_created DESC";
        $model = \Disposale::model()->find($criteria);
        $limitDays = intval(\Yii::app()->params['time_limit']) + 1;
        $pastLimitdays = strtotime("-{$limitDays} days");
        $model->date_created = date("Y-m-d H:i:s", $pastLimitdays);
        $this->assertTrue($model->update(), "Persisting the update to database");
        $criteria = new \CDbCriteria();
        $criteria->order = "date_created DESC";
        $model = \Disposale::model()->find($criteria);//get the latest inserted record
        $this->assertEquals(date("Y-m-d H:i:s", $pastLimitdays), $model->date_created , "The date created should be equal now");

        /*insert another same record after limit days*/
        $disposaleFormAfterLimit = new DisposaleForm();
        $disposaleFormAfterLimit->dispo_name = $p->purify(@$_POST['dispo_name']);
        $disposaleFormAfterLimit->phone_number = $p->purify(@$_POST['phone_number']);
        $disposaleFormAfterLimit->posted_data = json_encode(@$_POST);
        $this->assertTrue($disposaleFormAfterLimit->validate(), "the disposale is valid and validation would'nt fail : " . \CHtml::errorSummary($disposaleFormAfterLimit));
        /*should insert*/
        $this->assertTrue($disposaleForm->save() , "The disposale should save");

        /*insert another same record - insertion should fail*/
        $disposaleFormSameData = new DisposaleForm();
        $disposaleFormSameData->dispo_name = $p->purify(@$_POST['dispo_name']);
        $disposaleFormSameData->phone_number = $p->purify(@$_POST['phone_number']);
        $disposaleFormSameData->posted_data = json_encode(@$_POST);
        $this->assertFalse($disposaleFormSameData->validate(), "the disposale should validate and return false ");
        /*should not insert*/
        $this->assertFalse($disposaleForm->save() , "The disposale should not save");
    }


    public function testTestViaCurl()
    {
        $URL_TARGET = "http://localhost:8000/disposale/save";
        $postdata = [
            "dispo_name"=>"something",
            "phone_number"=>"07321654987",
            "first_name"=>"juan",
            "last_name"=>"dela cruz"
        ];
        $curlRes = curl_init($URL_TARGET);
        curl_setopt($curlRes, CURLOPT_RETURNTRANSFER , true);
        curl_setopt($curlRes, CURLOPT_POST , true);
        curl_setopt($curlRes, CURLOPT_POSTFIELDS, $postdata);
        $returnedData = curl_exec($curlRes);
        $this->assertContains("success", $returnedData, "The returned result should contain success : ".$returnedData );
        curl_close($curlRes);
        //curl test WITH data

        //curl test WITH SAME DATA
        $postdata = [
            "phone_number"=>"07321654987",
            "first_name"=>"juan",
            "last_name"=>"dela cruz"
        ];
        $curlRes = curl_init($URL_TARGET);
        curl_setopt($curlRes, CURLOPT_RETURNTRANSFER , true);
        curl_setopt($curlRes, CURLOPT_POST , true);
        curl_setopt($curlRes, CURLOPT_POSTFIELDS, $postdata);
        $returnedData = curl_exec($curlRes);
        $this->assertContains("failed", $returnedData, "The returned result should contain failed because it has the same data: ".$returnedData );
        curl_close($curlRes);



        //curl test WITHOUT
        $postdata = [
            "phone_number"=>"07321654981",
            "first_name"=>"juan",
            "last_name"=>"dela cruz"
        ];
        $curlRes = curl_init($URL_TARGET);
        curl_setopt($curlRes, CURLOPT_RETURNTRANSFER , true);
        curl_setopt($curlRes, CURLOPT_POST , true);
        curl_setopt($curlRes, CURLOPT_POSTFIELDS, $postdata);
        $returnedData = curl_exec($curlRes);
        $this->assertContains("failed", $returnedData, "The returned result should contain failed because of incomplete data: ".$returnedData );
        curl_close($curlRes);

        //another INVALID POST
        $postdata = [
            "dispo_name"=>"something",
            "first_name"=>"juan",
            "last_name"=>"dela cruz"
        ];
        $curlRes = curl_init($URL_TARGET);
        curl_setopt($curlRes, CURLOPT_RETURNTRANSFER , true);
        curl_setopt($curlRes, CURLOPT_POST , true);
        curl_setopt($curlRes, CURLOPT_POSTFIELDS, $postdata);
        $returnedData = curl_exec($curlRes);
        $this->assertContains("failed", $returnedData, "The returned result should contain  failed because of incomplete data: ".$returnedData );
        curl_close($curlRes);

    }


    /**
     * Test FormValidation for DisposaleForm - this should validate with no errors
     */
    public function testFormValidationValid() {
        $p = new CHtmlPurifier();
        $findByPhoneNumberCriteria = new \CDbCriteria();
        $_POST['dispo_name'] = "something";
        $_POST['phone_number'] = "07321654987";
        $_POST['first_name'] = "juan";
        $_POST['last_name'] = "dela cruz";
        $disposaleForm = new DisposaleForm();
        $disposaleForm->dispo_name = $p->purify(@$_POST['dispo_name']);
        $disposaleForm->phone_number = $p->purify(@$_POST['phone_number']);
        $disposaleForm->posted_data = json_encode(@$_POST);
        $this->assertTrue($disposaleForm->validate(),"Validating a valid data  - this is a new data  - a fress record : ". \CHtml::errorSummary($disposaleForm));
        $this->assertTrue($disposaleForm->save(),"Check to see if there are any issue in saving the record");
        //after this the data should be persisted in the database
        $findByPhoneNumberCriteria->compare("phone_number", $_POST['phone_number']);
        $this->assertTrue(\Disposale::model()->find($findByPhoneNumberCriteria)->exists(), "check if the record is in the database and is inserted");
        /*try to insert again - with the same data*/
        $disposaleFormAgain = new DisposaleForm();
        $disposaleFormAgain->dispo_name = $p->purify(@$_POST['dispo_name']);
        $disposaleFormAgain->phone_number = $p->purify(@$_POST['phone_number']);
        $disposaleFormAgain->posted_data = json_encode(@$_POST);
        $this->assertFalse($disposaleFormAgain->validate(),"Testing with the same data - this should return false because it is  invalid");
        $this->assertFalse($disposaleFormAgain->save(),"This should return false since the data is invalid. Or validation return false.");
    }

    /**
     * Test FormValidation for DisposaleForm - this should validate with error
     */
    public function testFormValidationInvalid() {
        $p = new CHtmlPurifier();
        $findByPhoneNumberCriteria = new \CDbCriteria();
        $_POST['dispo_name'] = "something";
        $_POST['phone_number'] = "asdfgwsdfgsdgsdf";
        $_POST['first_name'] = "juan";
        $_POST['last_name'] = "dela cruz";

        $disposaleForm = new DisposaleForm();
        $disposaleForm->dispo_name = $p->purify(@$_POST['dispo_name']);
        $disposaleForm->phone_number = $p->purify(@$_POST['phone_number']);
        $disposaleForm->posted_data = json_encode(@$_POST);
        $this->assertFalse($disposaleForm->validate(), "Testing to see if phone_number asdfgwsdfgsdgsdf would save ");

        unset($_POST['dispo_name']);
        $_POST['phone_number'] = "07321654987";
        $_POST['first_name'] = "juan";
        $_POST['last_name'] = "dela cruz";
        $disposaleForm = new DisposaleForm();
        $disposaleForm->dispo_name = $p->purify(@$_POST['dispo_name']);
        $disposaleForm->phone_number = $p->purify(@$_POST['phone_number']);
        $disposaleForm->posted_data = json_encode(@$_POST);
        $this->assertFalse($disposaleForm->validate(), "Testing to see if empty dispo_name would save ");

        unset($_POST['phone_number']);
        $_POST['first_name'] = "juan";
        $_POST['last_name'] = "dela cruz";
        $disposaleForm = new DisposaleForm();
        $disposaleForm->dispo_name = $p->purify(@$_POST['dispo_name']);
        $disposaleForm->phone_number = $p->purify(@$_POST['phone_number']);
        $disposaleForm->posted_data = json_encode(@$_POST);
        $this->assertFalse($disposaleForm->validate(), "Testing to see if empty phone_number would save ");
    }



    protected function tearDown()
    {
        \Disposale::model()->deleteAll();
    }


}
