<?php

/**
 * This is the model class for table "white_listed_mobile".
 *
 * The followings are the available columns in table 'white_listed_mobile':
 * @property integer $rec_id
 * @property integer $queue_id
 * @property string $mobile_number
 * @property string $status [ok , error]
 * @property string $date_created
 * @property string $date_updated
 */
class WhiteListedMobile extends CActiveRecord
{
	public static $WHITELISTEDMOBILE_STATUS_OK = "ok";
	public static $WHITELISTEDMOBILE_STATUS_ERROR = "error";
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'white_listed_mobile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status', 'required'),
			array('queue_id', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>255),
			array('date_created, date_updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('rec_id, queue_id, mobile_number, status, date_created, date_updated', 'safe', 'on'=>'search'),
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
			'status' => 'Status',
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

		$criteria->compare('rec_id',$this->rec_id);
		$criteria->compare('queue_id',$this->queue_id);
		$criteria->compare('mobile_number',$this->mobile_number);
		$criteria->compare('status',$this->status,true);
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
	 * @return WhiteListedMobile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
