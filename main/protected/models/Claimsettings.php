<?php

/**
 * This is the model class for table "claimsettings".
 *
 * The followings are the available columns in table 'claimsettings':
 * @property integer $settings_id
 * @property string $settings_key
 * @property string $settings_val
 * @property string $date_created
 * @property string $date_updated
 * @property integer $settings_owner
 *
 * The followings are the available model relations:
 * @property Claimaccount $settingsOwner
 */
class Claimsettings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'claimsettings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('settings_key, settings_val, settings_owner', 'required'),
			array('settings_owner', 'numerical', 'integerOnly'=>true),
			array('settings_key', 'length', 'max'=>120),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('settings_id, settings_key, settings_val, date_created, date_updated, settings_owner', 'safe', 'on'=>'search'),
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
			'settingsOwner' => array(self::BELONGS_TO, 'Claimaccount', 'settings_owner'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'settings_id' => 'Settings',
			'settings_key' => 'Settings Key',
			'settings_val' => 'Settings Val',
			'date_created' => 'Date Created',
			'date_updated' => 'Date Updated',
			'settings_owner' => 'Settings Owner',
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

		$criteria->compare('settings_id',$this->settings_id);
		$criteria->compare('settings_key',$this->settings_key,true);
		$criteria->compare('settings_val',$this->settings_val,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('settings_owner',$this->settings_owner);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Claimsettings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}



}
