<?php

/**
 * This is the model class for table "job_queue".
 *
 * The followings are the available columns in table 'job_queue':
 * @property integer $queue_id
 * @property string $queue_name
 * @property string $status
 * @property integer $total_records
 * @property integer $processed_record
 * @property string $filename
 * @property string $date_done
 * @property string $date_created
 * @property string $date_updated
 */
class JobQueue extends CActiveRecord
{
    public $status = 'idle';// [ idle , on-going , requeue , done ]
    public static $JOBQUEUE_STATUS_IDLE = 'IDLE';
    public static $JOBQUEUE_STATUS_PRELOADED = 'PRELOADED';
    public static $JOBQUEUE_STATUS_ON_GOING = 'ON_GOING';
    public static $JOBQUEUE_STATUS_REQUEUE = 'REQUEUE';
    public static $JOBQUEUE_STATUS_DONE = 'DONE';
    public $total_records = 0;
    public $processed_record = 0;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'job_queue';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('queue_name, status, filename', 'required'),
            array('total_records, processed_record', 'numerical', 'integerOnly' => true),
            array('queue_name, status, filename', 'length', 'max' => 255),
            array('date_done, date_created, date_updated', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array(
                'queue_id, queue_name, status, total_records, processed_record, filename, date_done, date_created, date_updated',
                'safe',
                'on' => 'search'
            ),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'queue_id' => 'Queue',
            'queue_name' => 'Queue Name',
            'status' => 'Status',
            'total_records' => 'Total Records',
            'processed_record' => 'Processed Record',
            'filename' => 'Filename',
            'date_done' => 'Date Done',
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

        $criteria = new CDbCriteria;

        $criteria->compare('queue_id', $this->queue_id);
        $criteria->compare('queue_name', $this->queue_name, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('total_records', $this->total_records);
        $criteria->compare('processed_record', $this->processed_record);
        $criteria->compare('filename', $this->filename, true);
        $criteria->compare('date_done', $this->date_done, true);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('date_updated', $this->date_updated, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return JobQueue the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->date_created = date("Y-m-d H:i:s");
        }
        $this->date_updated = date("Y-m-d H:i:s");
        parent::beforeSave();

        return true;
    }


}
