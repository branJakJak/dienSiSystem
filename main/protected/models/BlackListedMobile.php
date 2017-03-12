<?php

/**
 * This is the model class for table "black_listed_mobile".
 *
 * The followings are the available columns in table 'black_listed_mobile':
 * @property integer $rec_id
 * @property integer $queue_id
 * @property string $mobile_number
 * @property string $date_created
 * @property string $date_updated
 */
class BlackListedMobile extends CActiveRecord
{
	public $ip_address;
	public $origin;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'black_listed_mobile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mobile_number', 'required'),
			array('mobile_number', 'unique'),
			array('mobile_number', 'validUkPhone'),
			array('queue_id', 'numerical', 'integerOnly'=>true),
			array('ip_address ,origin,date_created, date_updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('rec_id, queue_id, mobile_number,origin, date_created, date_updated , ip_address', 'safe', 'on'=>'search'),
		);
	}
	public function validUkPhone($attr , $params)
	{
		if (isset($this->mobile_number) && !empty($this->mobile_number) && !preg_match("/^07\d{9}$/", $this->mobile_number)  ) {
			 $this->addError('mobile_number','Invalid format.Please use 07#########');
		}
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rec_id' => 'Rec',
			'queue_id' => 'Queue',
			'mobile_number' => 'Mobile Number',
			'origin' => 'Website Origin',
			'ip_address' => 'IP Address',
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
		$criteria=new CDbCriteria;
		$criteria->compare('rec_id',$this->rec_id);
		$criteria->compare('queue_id',$this->queue_id);
		$criteria->addSearchCondition("mobile_number"  , doubleval($this->mobile_number));
		$criteria->compare('ip_address',$this->ip_address);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->group = "mobile_number";
		$criteria->order = "date_created DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BlackListedMobile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function getTotalBlacklistedCount()
	{
		return Yii::app()->db->createCommand("select count(mobile_number) from black_listed_mobile")->queryScalar();
	}
	public static function getSubmittedBlackListedMobileCount($date)
	{
		$count = 0;
		$d = DateTime::createFromFormat('Y-m-d H:i:s', $date);
		/*check date if in valid format*/
		if (!isset($date) || is_null($date) || ($d->format('Y-m-d') == $date   )) {
			throw new Exception("Please provide valid date. Y-m-d H:i:s");
		}else{
			$commandObj = Yii::app()->db->createCommand("select count(rec_id) from black_listed_mobile where date(date_created) = :date_created");
			$commandObj->params = array(
					":date_created"=>date("Y-m-d",strtotime($date))
				);
			$count = $commandObj->queryScalar();
		}
		return $count;
	}
	public function thisWeekSubmittion()
	{
		$criteria=new CDbCriteria();
        $criteria->addBetweenCondition("date_created", date("Y-m-d H:i:s", strtotime("monday this week")), date("Y-m-d H:i:s", strtotime("sunday this week")));
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function behaviors(){
		return array(
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'date_created',
				'updateAttribute' => 'date_updated',
			)
		);
	}


}
