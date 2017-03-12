<?php

/**
 * This is the model class for table "claimrecord".
 *
 * The followings are the available columns in table 'claimrecord':
 * @property integer $record_id
 * @property integer $account_id
 * @property string $claimData
 * @property string $ip_address
 * @property string $other_information
 * @property string $date_created
 * @property string $date_updated
 *
 * The followings are the available model relations:
 * @property Claimaccount $account
 */
class Records extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'claimrecord';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id, claimData, ip_address, other_information', 'required'),
			array('account_id', 'numerical', 'integerOnly'=>true),
			array('ip_address', 'length', 'max'=>120),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('record_id, account_id, claimData, ip_address, other_information, date_created, date_updated', 'safe', 'on'=>'search'),
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
			'account' => array(self::BELONGS_TO, 'Claimaccount', 'account_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'record_id' => 'Record',
			'account_id' => 'Account',
			'claimData' => 'Claim Data',
			'ip_address' => 'Ip Address',
			'other_information' => 'Other Information',
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

		$criteria->compare('record_id',$this->record_id);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('claimData',$this->claimData,true);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('other_information',$this->other_information,true);
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
	 * @return Records the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function beforeSave()
	{
		if (empty($this->date_created)) {
			$this->date_created = new CDbExpression("NOW()");
			$this->date_updated = new CDbExpression("NOW()");
		}
		parent::beforeSave();
		return true;
	}
	/*
	*  Returns total number of entries
	*/
	public function getTotalNumberOfEntries()
	{
		//using accountID
		$criteria = new CDbCriteria();
		$criteria->compare("account_id",$this->account_id);
		//$criteria->group = "ip_address";
		$criteria->distinct = true;		

		return Records::model()->count($criteria);
	}
	/*
	* Returns total number of entries today
	*/
	public function getTotalNumberOfEntriesToday()
	{
		//using accountID
		$criteria = new CDbCriteria();
		$criteria->compare("account_id",$this->account_id);
		$criteria->addCondition("date(date_created) = date(NOW())");
		//$criteria->group = "ip_address";
		$criteria->distinct = true;		
		
		return Records::model()->count($criteria);
	}
	/*Returns number of claims this week*/
	public function getThisWeekreport()
	{
		//using accountID
		$criteria = new CDbCriteria();
		$criteria->compare("account_id",$this->account_id);
		/* sunday 00.00 hrs - saturday 23:59 hrs*/
		
		// $startingDate = date("Y-m-d 24:00:00",strtotime('sunday last week')  );
		// $endDate = date("Y-m-d 23:59:59",strtotime('saturday this week')  );
		
		$startingDate = date("Y-m-d 12:00:00",strtotime('friday last week')  );
		$endDate = date("Y-m-d 23:59:00",strtotime('friday this week')  );

		$criteria->addBetweenCondition("date_created",$startingDate,$endDate);
		//$criteria->group = "ip_address";
		$criteria->distinct = true;		

		return Records::model()->count($criteria);
	}

}
