<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kevin
 * Date: 3/19/15
 * Time: 4:36 AM
 * To change this template use File | Settings | File Templates.
 */

class DncUtilities
{
    public static function getTotalUploadedMobileNumbers($queue_id)
    {
        $result = 0;
        //get total records from attribute total_records

        $model = WhitelistJobQueue::model()->findByPk($queue_id);
        if ($model) {
            $result = $model->total_records;
        }
        return $result;
        // $sqlCommand = "
        //     select count(white_listed_mobile.mobile_number) from white_listed_mobile where queue_id = :queue_id and white_listed_mobile.mobile_number <> 0
        // ";
        // $commandObj = Yii::app()->db->createCommand($sqlCommand);
        // $commandObj->params = array(
        //     ":queue_id" => $queue_id
        // );
        // return $commandObj->queryScalar();
    }

    public static function getTotalCleanNumbers($queue_id)
    {

        $sqlQuery = '
            select count(a.mobile_number)
            from white_listed_mobile as a
            left join black_listed_mobile as b on a.mobile_number = b.mobile_number
            where 
            a.queue_id = ' . $queue_id . ' and
            b.mobile_number IS NULL
            group by a.mobile_number;
            ';

        $commandObj = Yii::app()->db->createCommand($sqlCommand);
        $commandObj->params = array(
            ":queue_id" => $queue_id
        );
        return $commandObj->queryScalar();
    }

    public static function getRemovedMobileNumber($queue_id)
    {
        $queue_id = intval($queue_id);
        $removedMobileNumberCount = 0;
        $sqlCommand = '
            select count(distinct a.mobile_number)
            from white_listed_mobile as a
            left join black_listed_mobile as b on a.mobile_number = b.mobile_number
            where 
            a.queue_id = :queue_id and
            b.mobile_number IS NOT NULL;
            ';
        $commandObj = Yii::app()->db->createCommand($sqlCommand);
        $commandObj->params = array(
            ":queue_id" => $queue_id
        );
        $removedMobileNumberCount = $commandObj->queryScalar();
        return intval($removedMobileNumberCount);
    }

    public static function getTotalRemovedMobileNumbers($queue_id)
    {

        $sqlCommand = '
            select count(a.mobile_number)
            from white_listed_mobile as a
            left join black_listed_mobile as b on a.mobile_number = b.mobile_number
            where 
            a.queue_id = ' . $queue_id . ' and
            b.mobile_number IS NOT NULL
            group by a.mobile_number
            ';


        $commandObj = Yii::app()->db->createCommand($sqlCommand);
        $commandObj->params = array(
            ":queue_id" => $queue_id
        );
        return $commandObj->queryScalar();
    }

    public static function printCleanMobileNumbers($queue_id)
    {
        $queue_id = intval($queue_id);
        $tempFileContainer = tempnam(sys_get_temp_dir(), "assd");
        $tempFileContainerRes = fopen($tempFileContainer, "w+");
        $queue_id = intval($queue_id);
        $sqlCountStr = <<<EOL
select count(p1.mobile_number)
FROM white_listed_mobile as p1
left join black_listed_mobile as p2 ON p1.mobile_number = p2.mobile_number
where p1.queue_id = $queue_id 
and p2.mobile_number is null
EOL;
        $numOfCount = Yii::app()->db->createCommand($sqlCountStr)->queryScalar();
        $offset = 0;
        $limit = intval($numOfCount / 10);//break to ten parts
        //if greater than 100000 , break it 
        if ($numOfCount < 100000) {
            $limit = $numOfCount;
        }
        do {
            $sqlQuery = '
                select a.mobile_number
                from white_listed_mobile as a
                left join black_listed_mobile as b on a.mobile_number = b.mobile_number
                where
                a.queue_id = ' . $queue_id . ' and
                b.mobile_number IS NULL
                LIMIT ' . $limit . '
                OFFSET ' . $offset . '
            ';
            $allResults = Yii::app()->db->createCommand($sqlQuery)->queryAll();
            shuffle($allResults);
            foreach ($allResults as $curVal) {
                fwrite($tempFileContainerRes, $curVal['mobile_number'] . "\n");
                //append to temp file container
            }
            $offset += $limit;
        } while ($offset < $numOfCount);
        fclose($tempFileContainerRes);
        echo `sort $tempFileContainer | uniq `;
        //echo file_get_contents($tempFileContainer);
    }
    public static function getCleanMobileNumberIncDups($queue_id){
        $queue_id = intval($queue_id);
        $criteriaWhiteList = new CDbCriteria;
        $criteriaWhiteList->compare("queue_id", $queue_id);
        $totalWhiteListed = WhiteListedMobile::model()->count($criteriaWhiteList);
        $totalWhiteListed = intval($totalWhiteListed);
        /*get total white list using queue id*/

        $offset = 0;
        $limit = 1000000;
        do {
            $sqlQuery = '
select a.mobile_number
from white_listed_mobile as a
left join black_listed_mobile as b on a.mobile_number = b.mobile_number
where
a.queue_id = ' . $queue_id . ' and
b.mobile_number IS NULL
LIMIT ' . $limit . '
OFFSET ' . $offset . '
            ';
            $allResults = Yii::app()->db->createCommand($sqlQuery)->queryAll();
            foreach ($allResults as $curVal) {
                echo $curVal['mobile_number'] . "\r\n";
            }
            $offset += $limit;
        } while ($offset < $totalWhiteListed);


    }

    public static function getTotalDuplicatesRemoved($queue_id)
    {
        $totalCount = Yii::app()->db->createCommand("
		select count(mobile_number)
		from white_listed_mobile
		where queue_id = $queue_id")->queryScalar();

        $totalWithoutDuplicates = Yii::app()->db->createCommand("
		select count(distinct mobile_number)
		from white_listed_mobile
		where queue_id = $queue_id
	")->queryScalar();
        return ($totalCount - $totalWithoutDuplicates);
    }

    public static function getTotalDataToDownload($queue_id)
    {
        $totalDataToDownload = Yii::app()->db->createCommand("
			select count(distinct a.mobile_number)
			from white_listed_mobile as a
			left join black_listed_mobile as b on a.mobile_number = b.mobile_number
			where 
			a.queue_id = $queue_id and b.mobile_number IS NULL
			")->queryScalar();
        return $totalDataToDownload;
    }
    /**
     * Cache query result for faster data retrieval
     * @param int $queue_id
     */
    public static function cacheSqlQuery($queue_id)
    {

        // cache total uploaded mobile numbers
        
        // cache total clean numbers 
        
        // cache total removed mobile number
        
        // finally  , cache the 

    }
}
