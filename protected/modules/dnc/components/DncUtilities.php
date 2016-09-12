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
        $sqlCommand = "
            select count(white_listed_mobile.mobile_number) from white_listed_mobile where queue_id = :queue_id and white_listed_mobile.mobile_number <> 0
        ";
        $commandObj = Yii::app()->db->createCommand($sqlCommand);
        $commandObj->params = array(
            ":queue_id" => $queue_id
        );
        return $commandObj->queryScalar();
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
        $sqlCommand = '
            select a.mobile_number
            from white_listed_mobile as a
            left join black_listed_mobile as b on a.mobile_number = b.mobile_number
            where 
            a.queue_id = ' . $queue_id . ' and
            b.mobile_number IS NOT NULL
            group by a.mobile_number;
            ';
        $commandObj = Yii::app()->db->createCommand($sqlCommand);
        $commandObj->params = array(
            ":queue_id" => $queue_id
        );
        return $commandObj->queryAll();
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

        $sqlCountStr = <<<EOL
select count(p1.mobile_number)
FROM white_listed_mobile as p1
left join black_listed_mobile as p2 ON p1.mobile_number = p2.mobile_number
where p1.queue_id = $queue_id 
and p2.mobile_number is null
EOL;
        $numOfCount = Yii::app()->db->createCommand($sqlCountStr)->queryScalar();

        $offset = 0;
        $limit = 10000;
        if ($limit < 1000) {
            $limit = 1000;
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
            echo $curVal['mobile_number'] . "\r\n";
        }
            $offset += $limit;
        } while ($offset < $numOfCount);

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


}
