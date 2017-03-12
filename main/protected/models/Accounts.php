<?php

/**
 * This is the model class for table "claimaccount".
 *
 * The followings are the available columns in table 'claimaccount':
 * @property integer $account_id
 * @property string $claimAccountName
 * @property string $claimAccountDescription
 * @property string $websiteURL
 * @property string $application_status
 * @property string $database_status
 * @property string $date_created
 * @property string $date_updated
 *
 * The followings are the available model relations:
 * @property Claimrecord[] $claimrecords
 */
class Accounts extends CActiveRecord
{

	public $websiteURL;
	public $application_status;
	public $database_status;
    const OK ="ok";
    const ERROR = "error";

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'claimaccount';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('claimAccountName, claimAccountDescription', 'required'),
			array('claimAccountName', 'length', 'max'=>150),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('account_id, claimAccountName, websiteURL, claimAccountDescription, date_created, date_updated', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'claimrecords' => array(self::HAS_MANY, 'Claimrecord', 'account_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'account_id' => 'Account',
			'claimAccountName' => 'Claim Account Name',
			'claimAccountDescription' => 'Claim Account Description',
			'websiteURL' => 'Website URL',
			'application_status' => 'Application Status',
			'database_status' => 'Database Status',
			'date_created' => 'Date Created',
			'date_updated' => 'Date Updated',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('claimAccountName',$this->claimAccountName,true);
		$criteria->compare('claimAccountDescription',$this->claimAccountDescription,true);
		$criteria->compare('websiteURL',$this->websiteURL,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Accounts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function beforeSave()
	{
		if ($this->isNewRecord) {
			$this->date_created = new CDbExpression("NOW()");
		}
		$this->date_updated = new CDbExpression("NOW()");
		parent::beforeSave();
		return true;
	}



	public static function getAccountName($acctId)
	{
		$tempAccountName = "";
		$criteria = new CDbCriteria();
		$criteria->compare('account_id',$acctId);
		$found = Accounts::model()->find($criteria);
		if ($found) {
			$tempAccountName = $found->claimAccountName;
		}else{
			$tempAccountName = "Not Found";
		}
		return $tempAccountName;
	}
    public function checkWebsiteStatus()
    {
        /*starting invoking the [website]/SystemInfo     */
        try{
            echo "Check site status and database status(DEFAULT) : $this->websiteURL.\n";
            $this->checkStatusDefault();
        }catch (Exception $ex){
            try{
                /*if that does exists .    try [website]/SystemInfo.php   */
                echo "Reverting to alternative\n";
                echo "Check site status and database status(ALTERNATIVE) : $this->websiteURL.\n";
                $this->checkStatusAlternative();
            }catch (Exception $ex2){
                $this->application_status = Accounts::ERROR;
                $this->database_status = Accounts::ERROR;
                $this->save();
            }
        }
    }

    protected function checkStatusDefault()
    {
        /*starting invoking the [website]/SystemInfo     */
		$url = $this->websiteURL.'/SystemInfo';
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$responseText = curl_exec($curl);
		$resultStatus = curl_getinfo($curl);
		curl_close($curl);
        if(empty($responseText)){
            throw new Exception("Error Result");
        }
        $jsonResult = json_decode($responseText);
        if (  ( isset($jsonResult->application_status) && isset($jsonResult->database_status) ) ) {
        	if ($jsonResult->application_status == Accounts::OK) {
        		$this->application_status = Accounts::OK;
        	}else{
        		$this->application_status = Accounts::ERROR;
        		$this->reportWebsiteDown();
        	}
        	if ($jsonResult->database_status == Accounts::OK) {
        		$this->database_status = Accounts::OK;
        	}else{
        		$this->database_status = Accounts::ERROR;
        		$this->reportDatabaseDown();
        	}
            $this->save(false);
        }else{
            throw new Exception("Error Result");
        }
    }
    protected function checkStatusAlternative()
    {
        /*if that does exists .    try [website]/SystemInfo.php   */
        $url = $this->websiteURL.'/SystemInfo.php';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $responseText = curl_exec($curl);
        $resultStatus = curl_getinfo($curl);
        curl_close($curl);

        if(empty($responseText)){
            throw new Exception("Error Result");
        }
        $jsonResult = json_decode($responseText);
        if (  ( isset($jsonResult->application_status) && isset($jsonResult->database_status) ) ) {
            if ($jsonResult->application_status == Accounts::OK) {
                $this->application_status = Accounts::OK;
            }else{
                $this->application_status = Accounts::ERROR;
                $this->reportWebsiteDown();
            }
            if ($jsonResult->database_status == Accounts::OK) {
                $this->database_status = Accounts::OK;
            }else{
                $this->database_status = Accounts::ERROR;
                $this->reportDatabaseDown();
            }
            $this->save(false);
        }else{
            throw new Exception("Error Result");
        }
    }

    public function reportWebsiteDown()
    {
    	Yii::import('ext.YiiMailer.YiiMailer');
        $mailer = new YiiMailer;
        $mailer->setView('contact');
        $mailer->setData(array(
             "websiteURL"     => $this->websiteURL,
             "accountName" => $this->claimAccountName,
             "description" => "Website Down.",
        ));
        $mailer->setFrom("claimsdatastorage@ezfastloans4u.com");
        $mailer->setTo(array(
        	"hellsing357@gmail.com",
        	"pcgeekz@gmail.com",
        	"notifyusplease@gmail.com",
        ));
        $mailer->setSubject(" {$data->claimAccountName}- Website Went Down");
        $mailer->send();
    }
    public function reportDatabaseDown()
    {
    	Yii::import('ext.YiiMailer.YiiMailer');
        $mailer = new YiiMailer;
        $mailer->setView('contact');
        $mailer->setData(array(
             "websiteURL"     => $this->websiteURL,
             "accountName" => $this->claimAccountName,
             "description" => "Database down.",
        ));
        $mailer->setFrom("claimsdatastorage@ezfastloans4u.com");
        $mailer->setTo(array(
        	"hellsing357@gmail.com",
        	"pcgeekz@gmail.com",
        	"notifyusplease@gmail.com",
        ));
        $mailer->setSubject(" {$data->claimAccountName}- Database Went Down");
        $mailer->send();
    }

}
