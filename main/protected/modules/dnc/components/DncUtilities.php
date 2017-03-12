<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kevin
 * Date: 3/19/15
 * Time: 4:36 AM
 * To change this template use File | Settings | File Templates.
 */

class DncUtilities {
	public static function getTotalUploadedMobileNumbers($queue_id) {
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
	public static function getTotalCleanNumbers($queue_id) {
		$totalCleanNumbers = 0;
		// check if cache is present
		$totalCleanNumbers = Yii::app()->cache->get($queue_id+"_total_clean_numbers");
		if (is_null($totalCleanNumbers)) {
			// retrieve if present , recalculate if not present
			$sqlQuery = '
                select count(a.mobile_number)
                from white_listed_mobile as a
                left join black_listed_mobile as b on a.mobile_number = b.mobile_number
                where
                a.queue_id = :queue_id and
                b.mobile_number IS NULL
                group by a.mobile_number;
                ';
			$commandObj         = Yii::app()->db->createCommand($sqlCommand);
			$commandObj->params = array(
				":queue_id" => $queue_id
			);
			$totalCleanNumbers = $commandObj->queryScalar();
		}
		return $totalCleanNumbers;
	}

	public static function getRemovedMobileNumber($queue_id) {
		$queue_id                 = intval($queue_id);
		$removedMobileNumberCount = Yii::app()->cache->get($queue_id+"_removed_mobile_number");
		if (is_null($removedMobileNumberCount)) {
			$sqlCommand = '
                select count(distinct a.mobile_number)
                from white_listed_mobile as a
                left join black_listed_mobile as b on a.mobile_number = b.mobile_number
                where
                a.queue_id = :queue_id and
                b.mobile_number IS NOT NULL;
                ';
			$commandObj         = Yii::app()->db->createCommand($sqlCommand);
			$commandObj->params = array(
				":queue_id" => $queue_id
			);
			$removedMobileNumberCount = $commandObj->queryScalar();
			$removedMobileNumberCount = intval($removedMobileNumberCount);
		}
		return $removedMobileNumberCount;
	}

	/**
	 *
	 * @SEE getRemovedMobileNumber()
	 */
	public static function getTotalRemovedMobileNumbers($queue_id) {
		return $this->getRemovedMobileNumber($queue_id);
	}

	public static function printCleanMobileNumbers($queue_id) {
		$queue_id             = intval($queue_id);
		$tempFileContainer    = tempnam(sys_get_temp_dir(), "assd");
		$tempFileContainerRes = fopen($tempFileContainer, "w+");
		$queue_id             = intval($queue_id);
		$sqlCountStr          = <<<EOL
select count(p1.mobile_number)
FROM white_listed_mobile as p1
left join black_listed_mobile as p2 ON p1.mobile_number = p2.mobile_number
where p1.queue_id = $queue_idand p2.mobile_number is null
EOL
		;
		$numOfCount = Yii::app()->db->createCommand($sqlCountStr)->queryScalar();
		$offset     = 0;
		$limit      = intval($numOfCount/10);//break to ten parts
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
                a.queue_id = '.$queue_id.' and
                b.mobile_number IS NULL
                LIMIT '.$limit.'
                OFFSET '.$offset.'
            ';
			$allResults = Yii::app()->db->createCommand($sqlQuery)->queryAll();
			shuffle($allResults);
			foreach ($allResults as $curVal) {
				fwrite($tempFileContainerRes, $curVal['mobile_number']."\n");
				//append to temp file container
			}
			$offset += $limit;
		} while ($offset < $numOfCount);
		fclose($tempFileContainerRes);
		echo `sort $tempFileContainer | uniq `;
		//echo file_get_contents($tempFileContainer);
	}

	/**
	 *
	 * @DEPRECATED
	 */
	public static function getCleanMobileNumberIncDups($queue_id) {
		$queue_id          = intval($queue_id);
		$criteriaWhiteList = new CDbCriteria;
		$criteriaWhiteList->compare("queue_id", $queue_id);
		$totalWhiteListed = WhiteListedMobile::model()->count($criteriaWhiteList);
		$totalWhiteListed = intval($totalWhiteListed);
		/*get total white list using queue id*/

		$offset = 0;
		$limit  = 1000000;
		do {
			$sqlQuery = '
                select a.mobile_number
                from white_listed_mobile as a
                left join black_listed_mobile as b on a.mobile_number = b.mobile_number
                where
                a.queue_id = '.$queue_id.' and
                b.mobile_number IS NULL
                LIMIT '.$limit.'
                OFFSET '.$offset.'
            ';
			$allResults = Yii::app()->db->createCommand($sqlQuery)->queryAll();
			foreach ($allResults as $curVal) {
				echo $curVal['mobile_number']."\r\n";
			}
			$offset += $limit;
		} while ($offset < $totalWhiteListed);
	}

	public static function getTotalDuplicatesRemoved($queue_id) {
		$totalDupsRemoved = Yii::app()->cache->get($queue_id+"_total_duplicates_removed");
		if (is_null($totalDupsRemoved)) {
			$totalCount = Yii::app()->db->createCommand("
            select count(mobile_number)
            from white_listed_mobile
            where queue_id = $queue_id")->queryScalar();

			$totalWithoutDuplicates = Yii::app()->db->createCommand("
            select count(distinct mobile_number)
            from white_listed_mobile
            where queue_id = $queue_id")->queryScalar();
			$totalDupsRemoved = ($totalCount-$totalWithoutDuplicates);
		}
		return $totalDupsRemoved;
	}

	public static function getTotalDataToDownload($queue_id) {
		$totalDataToDownload = Yii::app()->cache->get($queue_id+"_total_data_download");
		;

		if (is_null($totalDataToDownload)) {
			$totalDataToDownload = Yii::app()->db->createCommand("
                select count(distinct a.mobile_number)
                from white_listed_mobile as a
                left join black_listed_mobile as b on a.mobile_number = b.mobile_number
                where
                a.queue_id = $queue_idand b.mobile_number IS NULL
")->queryScalar();
		}
		return $totalDataToDownload;
	}
	/**
	 * Cache query result for faster data retrieval
	 * @param int $queue_id
	 */
	public static function cacheSqlQuery($queue_id) {
		// Keyfields
		$totalCleanNumbers        = $queue_id+"_total_clean_numbers";
		$removedMobileNumberCount = $queue_id+"_removed_mobile_number";
		$totalDuplicatesRemoved   = $queue_id+"_total_duplicates_removed";
		$totalDataDownload        = $queue_id+"_total_data_download";
		// TODO : cache total clean numbers
		$expirationTime = (60*(60*60));//1 hour
		Yii::app()->cache->set($totalCleanNumbers, DncUtilities::getTotalCleanNumbers($queue_id), $expirationTime);

		// cache total removed mobile number
		Yii::app()->cache->set($removedMobileNumberCount, DncUtilities::getRemovedMobileNumber($queue_id), $expirationTime);

		//dups
		Yii::app()->cache->set($totalDuplicatesRemoved, DncUtilities::getTotalDuplicatesRemoved($queue_id), $expirationTime);

		// finally  , cache the
		$queryToCache = '
            select a.mobile_number
            from white_listed_mobile as a
            left join black_listed_mobile as b on a.mobile_number = b.mobile_number
            where
            a.queue_id = '.$queue_id.' and
            b.mobile_number IS NULL
        ';
		$queryDep = '
            select count(a.mobile_number)
            from white_listed_mobile as a
            left join black_listed_mobile as b on a.mobile_number = b.mobile_number
            where
            a.queue_id = '.$queue_id.' and
            b.mobile_number IS NULL
        ';
		$dependency = new CDbCacheDependency($queryDep);
		Yii::app()->db->cache($expirationTime, $dependency)->createCommand($queryToCache)->queryAll();
	}
}
