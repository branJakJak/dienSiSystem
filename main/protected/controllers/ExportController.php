<?php

class ExportController extends CController
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
            array('application.filters.IpAddressFilter'),
            array('application.filters.UnderConstructionFilter'),
			'accessControl', 
		);
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array("range","exportpi","exportAll","exportAllData","exportToday","exportWeek","allMobile","mobile"),
				'users'=>array('administrator'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionRange()
	{
		if (isset($_POST['dateFrom']) && isset($_POST['dateTo'])) {
			$filename = sprintf(" all-claims-from %s to %s",$_POST['dateFrom'],$_POST['dateTo']);
			$flightSites = array(31,4 , 9);
			$accountMdl = Accounts::model()->findByPk($_REQUEST['accountID']);
			if (in_array($_REQUEST['accountID'], $flightSites)) {
				$exportObj = new ExportAllFlightSiteRecords($accountMdl , "this week" , array('dateFrom'=>$_POST['dateFrom'] , "dateTo"=>$_POST['dateTo']));
				$exportObj->download();
				die();
			}


	        header("Pragma: public");
	        header("Expires: 0");
	        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	        header("Cache-Control: private",false);
	        header("Content-Type: application/octet-stream");
	        header("Content-Disposition: attachment; filename=\"$filename.csv\";" );
	        header("Content-Transfer-Encoding: binary");

			/*get claims between */
			$criteria = new CDbCriteria;
			$dateFrom = DateTime::createFromFormat("m/d/Y",$_POST['dateFrom']);
			$dateTo = DateTime::createFromFormat("m/d/Y",$_POST['dateTo']);
			$dateFromStr = $dateFrom->format('Y-m-d');
			$dateToStr = $dateTo->format('Y-m-d');

			$accountID = filter_var($_REQUEST['accountID'] , FILTER_VALIDATE_INT);
			$criteria->compare("account_id",$accountID);
			$criteria->addBetweenCondition(  'date_created'  , $dateFromStr , $dateToStr );
			$criteria->order = "date_created DESC";
			//$criteria->group = "ip_address";
			$criteria->distinct = true;
			
			
			// $criteria->addCondition(" date_created >= '{$dateFromStr}' && date_created <= '{$dateToStr}' ");
			$allRecords = Records::model()->findAll($criteria);
			$isFirst = true;
			foreach ($allRecords as $curRecord) {
				$data = json_decode($curRecord->claimData,true);
				$allowPrint = true;
				$rowData = "";
				/*check if mobile number exists at blacklist mobile nums*/
				$mobileNumMatch = preg_grep('/0?7\d{9}/', $data);
				if ( count($mobileNumMatch) > 0 ) {
					$mobileNumContainer = array_values($mobileNumMatch)[0];
					$criteria = new CDbCriteria;
					$criteria->compare('mobile_number', $mobileNumContainer);
					$allowPrint = !(BlackListedMobile::model()->exists($criteria) );
				}
				if ($allowPrint) {
					foreach ($data as $curRowData) {
						$rowData=$rowData."\"$curRowData\",";
					}
				}
				
				if ($isFirst) {
					//print heads
					$headers = "";
					foreach ($data as $key => $value) {
						$headers = $headers."\"$key\",";
					}
					echo $headers."\n";
					$isFirst = false;
				}
				$rowData = str_replace(chr(194)," ",$rowData);
				//prepare data
				if ($allowPrint) {
					echo $rowData."\n";
				}

			}
		}else{
			throw new CHttpException(404,'Incomplete parameter');
		}
		die();
	}

    public function actionExportpi()
    {
        $piSitesId = array(
            "6",
            "10",
            "3",
            "7",
            "14",
            "16",
            "17",
            "18",
            "19"
        );
        $accountIds = implode(",", $piSitesId);

        $fileName = date("Y-m-d") . '-All-PI-sites-entry';
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$fileName.csv\";" );
        header("Content-Transfer-Encoding: binary");


        $results = Yii::app()->db->createCommand(
            "SELECT * FROM  claimrecord WHERE account_id IN ($accountIds)  ORDER BY date_created DESC"
        )->queryAll();
        //write the contents to csv and passthru it
        $tempExportCsv = new SplTempFileObject();
        foreach ($results as $currentLine) {
        	$curArr = json_decode($currentLine['claimData'],true);
        	$curArr = array_values($curArr);
        	/*check if mobile number exists in the blacklist record*/
            $tempExportCsv->fputcsv($curArr);
        }
        $tempExportCsv->rewind();
        $tempExportCsv->fpassthru();
    }
	
	public function actionExportAll()
	{
		if ( isset($_REQUEST['accountID'])  && $_REQUEST['accountID'] == '29' ) {
			$dFileContent = dirname(__FILE__).'/../data/whatmyclaimworth.in - 2015-01-23-All-entries';
			$fileName  = "whatmyclaimworth.in";
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename=\"$fileName.csv\";" );
			header("Content-Transfer-Encoding: binary");
			echo file_get_contents($dFileContent);
			die();
		}else if (isset($_REQUEST['accountID'])) {
			$flightSites = array(31,4 , 9);
			$accountMdl = Accounts::model()->findByPk($_REQUEST['accountID']);
			if (in_array($_REQUEST['accountID'], $flightSites)) {
				$exportObj = new ExportAllFlightSiteRecords($accountMdl,"all",null);
			}else{
				$exportObj = new ExportAllRecords($accountMdl);
			}
			$exportObj->download();
			die();
		}else{
			throw new CHttpException(404,"Yikes , You forgot to pass in the Account ID");
		}
	}
	public function actionExportAllData()
	{
		$fileName = date("Y-m-d").'-All-entries';
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$fileName.csv\";" );
        header("Content-Transfer-Encoding: binary"); 


		$sqlCommand = Yii::app()->db->createCommand();
		$sqlCommand->select = "claimrecord.record_id";
		$sqlCommand->from = "claimrecord";
		$sqlCommand->order = "date_created DESC";
		$sqlResultRows = $sqlCommand->queryAll();

		$isFirst = true;
		foreach ($sqlResultRows as $currentRow) {
			$currentRowSelected = $currentRow['record_id'];
			$criteria = new CDbCriteria;
			$criteria->compare('record_id',$currentRowSelected);
			$currentRecord = Records::model()->find($criteria);
			$currentData = json_decode($currentRecord->claimData , true);
			if ($isFirst) {
				$isFirst = false;
				//print heads
				$headers = array_keys($currentData);
				$headers = implode(",", $headers);
				$headers .= "\n";
				echo $headers;
			}
			$rowData = "";
			$allowPrint = true;
			$mobileNumMatch = preg_grep('/0?7\d{9}/', $currentData);
			if ( count($mobileNumMatch) > 0 ) {
				$mobileNumContainer = array_values($mobileNumMatch)[0];
				$criteria = new CDbCriteria;
				$criteria->compare('mobile_number', $mobileNumContainer);
				$allowPrint = !(BlackListedMobile::model()->exists($criteria) );
			}
			if ($allowPrint) {
				foreach ($currentData as $curRowData) {
					$rowData=$rowData."\"$curRowData\",";
				}
			}
			$rowData = str_replace(chr(194)," ",$rowData);
			//prepare data
			if ($allowPrint) {
				echo $rowData."\n";
			}

		}
	}

	public function actionExportToday()
	{
		if (isset($_REQUEST['accountID'])) {
			$accountMdl = Accounts::model()->findByPk($_REQUEST['accountID']);
			$flightSites = array(31,4 , 9);
			$accountMdl = Accounts::model()->findByPk($_REQUEST['accountID']);
			if (in_array($_REQUEST['accountID'], $flightSites)) {
				$exportObj = new ExportAllFlightSiteRecords($accountMdl , "today" , null);
				$exportObj->download();
				die();
			}


			$fileName = $accountMdl->claimAccountName.' - '.date("Y-m-d").'-All-entries-submitted-today';
	        header("Pragma: public");
	        header("Expires: 0");
	        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	        header("Cache-Control: private",false);
	        header("Content-Type: application/octet-stream");
	        header("Content-Disposition: attachment; filename=\"$fileName.csv\";" );
	        header("Content-Transfer-Encoding: binary");	        
	        
			$criteria = new CDbCriteria();
			$criteria->compare("account_id",$_REQUEST['accountID']);
			$criteria->addCondition("date(date_created) = date(now())");
			$criteria->order = "date_created DESC";
			//$criteria->group = "ip_address";
			$criteria->distinct = true;
			$records = Records::model()->findAll($criteria);
			$isFirst = true;
			foreach ($records as $curRecord) {
				$data = json_decode($curRecord->claimData,true);
				$allowPrint = true;
				$rowData = "";
				/*check if mobile number exists at blacklist mobile nums*/
				$mobileNumMatch = preg_grep('/0?7\d{9}/', $data);
				if ( count($mobileNumMatch) > 0 ) {
					$mobileNumContainer = array_values($mobileNumMatch)[0];
					$criteria = new CDbCriteria;
					$criteria->compare('mobile_number', $mobileNumContainer);
					$allowPrint = !(BlackListedMobile::model()->exists($criteria) );
				}
				if ($allowPrint) {
					foreach ($data as $curRowData) {
						$rowData=$rowData."\"$curRowData\",";
					}
				}



				if ($isFirst) {
					//print heads
					$headers = "";
					foreach ($data as $key => $value) {
						$headers = $headers."\"$key\",";
					}
					echo $headers."\n";
					$isFirst = false;
				}
				$rowData = str_replace(chr(194)," ",$rowData);
				//prepare data
				if ($allowPrint) {
					echo $rowData."\n";
				}

			}


		}else{
			throw new CHttpException(404,"Yikes , You forgot to pass in the Account ID");
		}
	}
	public function actionExportWeek()
	{
		if (isset($_REQUEST['accountID'])) {
			$accountID = filter_var($_REQUEST['accountID'] , FILTER_VALIDATE_INT);
			$flightSites = array(31,4 , 9);
			$accountMdl = Accounts::model()->findByPk($_REQUEST['accountID']);
			if (in_array($_REQUEST['accountID'], $flightSites)) {
				$exportObj = new ExportAllFlightSiteRecords($accountMdl , "this week" , null);
				$exportObj->download();
				die();
			}
	        $criteria = new CDbCriteria();
	        $criteria->compare("account_id",$accountID);
			$startingDate = date("Y-m-d 12:00:00",strtotime('friday last week')  );
			$endDate = date("Y-m-d 23:59:00",strtotime('friday this week')  );

			$criteria->addBetweenCondition("t.date_created",$startingDate,$endDate);
			$criteria->order = "date_created DESC";
			$criteria->distinct = true;
			
			$records = Records::model()->findAll($criteria);
			$acct = Accounts::model()->findByPk($accountID);
			$accountName = $acct->claimAccountName;

			$fileName =  sprintf("%s - %s - this -week\'s -submitted-entries", date("Y-m-d") ,  $accountName);
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename=\"$fileName.csv\";" );
			header("Content-Transfer-Encoding: binary");

			if (empty($records)) {
				echo "No Claims Submitted These Week";
				die();
			}

			// extract header from first result
			$isFirst = true;
			foreach ($records as $curRecord) {
				$data = json_decode($curRecord->claimData,true);
				$rowData = "";
				$allowPrint = true;				
				/*check if mobile number exists at blacklist mobile nums*/
				$mobileNumMatch = preg_grep('/0?7\d{9}/', $data);
				if ( count($mobileNumMatch) > 0 ) {
					$mobileNumContainer = array_values($mobileNumMatch)[0];
					$criteria = new CDbCriteria;
					$criteria->compare('mobile_number', $mobileNumContainer);
					$allowPrint = !(BlackListedMobile::model()->exists($criteria) );
				}
				if ($allowPrint) {
					foreach ($data as $curRowData) {
						$rowData=$rowData."\"$curRowData\",";
					}
				}


				if ($isFirst) {
					//print heads
					$headers = "";
					foreach ($data as $key => $value) {
						$headers = $headers."\"$key\",";
					}
					echo $headers."\n";
					$isFirst = false;
				}
				$rowData = str_replace(chr(194)," ",$rowData);
				//prepare data
				if ($allowPrint) {
					echo $rowData."\n";
				}
			}
		}else{
			throw new CHttpException(404,"Yikes , You forgot to pass in the Account ID");
		}		
	}
	public function actionAllMobile()
	{
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"all-mobile-numbers-claimdatastorage.csv\";" );
		header("Content-Transfer-Encoding: binary");
		header('Content-type: text/csv');
        $allRecordsCount = Records::model()->count();
        $limit = 1000;
        $offset = 0;
        echo "Mobile Numbers\n";
        while ($offset <= $allRecordsCount) {
        	$claimData = Yii::app()->db->createCommand()
        							->select("claimData")
        							->from("claimrecord")
        							->limit($limit)
        							->offset($offset)->queryAll();
        	$resultArr = MobileNumberExtractor::extractMultiDimensional($claimData);
        	echo implode(PHP_EOL, $resultArr);
        	$offset = $offset + $limit;
        }
	}
	public function actionMobile()
	{
		if (isset($_REQUEST['accountID'])) {
			$accountMdl = Accounts::model()->findByPk($_REQUEST['accountID']);
			$fileName = $accountMdl->claimAccountName.' - '.date("Y-m-d").'-all-mobilenumbers';
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename=\"$fileName.csv\";" );
			header("Content-Transfer-Encoding: binary");

			$criteria = new CDbCriteria();
			$criteria->compare("account_id",$_REQUEST['accountID']);
			$criteria->order = "date_created DESC";
			$records = Records::model()->findAll($criteria);
			$isFirst = true;
			foreach ($records as $curRecord) {
				$data = json_decode($curRecord->claimData,true);
				if ($isFirst) {
					//print heads
					echo "Mobile Number\n";
					$isFirst = false;
				}
				//retrieve mobile number
				$arrayVals = array_values($data);
				$extractedMobile = MobileNumberExtractor::extractMobileNumbers($arrayVals);
				if (   $extractedMobile != false ) {
					/* check if present at blacklist*/
					$crt = new CDbCriteria;
					$crt->compare('mobile_number' , $extractedMobile);
					if (  !BlackListedMobile::model()->exists($crt)  ) {
						echo $extractedMobile.PHP_EOL;
					}
				}
			}
		}else{
			throw new CHttpException(404,"Yikes , You forgot to pass in the Account ID");
		}
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
