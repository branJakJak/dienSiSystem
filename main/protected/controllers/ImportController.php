<?php

class ImportController extends DncMainController
{
	public function actionIndex()
	{
		/*Requirement*/
		/*AccountID*/
		if (isset($_REQUEST['account_id'])) {
			header('Access-Control-Allow-Origin: *'); 
			$messageResult = array();
			// Save: IP address , Summary , json encoded data , accountID
			$account_id = $_REQUEST['account_id'];
			$data = $_REQUEST['data'];
			$ipAddress = $_REQUEST['ip_address'];
			$otherInformation = $_REQUEST['other_info'];
			$newRecord = new Records();
			$newRecord->account_id = $account_id;
			$newRecord->claimData = $data;
			$newRecord->ip_address = $ipAddress;
			$newRecord->other_information = $otherInformation;
			if ($newRecord->save()) {
				$messageResult['type'] = "success";
				$messageResult['message'] = "Record saved!";
			}else{
				$messageResult['type'] = "failed";
				$messageResult['message'] = "Record failed to save!";
			}
			echo json_encode($messageResult);
		}else{
			throw new CHttpException(404,"Sorry we cant process your request");
		}
	}

	/*
	* Process imported file and insert it on database;
	*/
	public function actionFile()
	{

		$uploadedFile = CUploadedFile::getInstanceByName("import_file");
		if (isset($uploadedFile)) {
			echo "Configure the date and IP";
			$csvFile = fopen($uploadedFile->tempName, "r");
			$headers = fgetcsv($csvFile);
			$isFirstRow = true;
			while (!feof($csvFile)) {
				if ($isFirstRow) {
					$isFirstRow = false;
					continue;
				}else{
					/*get out if empty!*/
					$curRow = fgetcsv($csvFile);
					$curRow = preg_replace("/\r(?!\n)/", '', $curRow);
					if (empty($curRow)) {
						continue;
					}
					$processData = array_flip($headers);
					$counter = 0;
					foreach ($processData as $key => $value) {
						$processData[$key] = $curRow[$value];
					}
					$processData = array_map('utf8_encode', $processData);
					$newRecord = new Records("old_file");
					$newRecord->account_id = intval($uploadedFile->getName());
					$newRecord->claimData = json_encode($processData);
					$newRecord->ip_address = $curRow[2];//for now
					$dt = date_create_from_format("m/d/Y H:i",$curRow[1]);
					// $newRecord->date_created = $dt->format("Y-m-d H:i:s");
					// $newRecord->date_updated = $dt->format("Y-m-d H:i:s");
					$newRecord->date_created = $dt->format("Y-m-d H:i:s");
					$newRecord->date_updated = $dt->format("Y-m-d H:i:s");
					$newRecord->other_information = "none";
					if (!$newRecord->save()) {
						Yii::app()->user->setFlash('error', CHtml::errorSummary($newRecord));
					}else{
						Yii::app()->user->setFlash('success', '<strong>Well done!</strong> Data imported.');
					}
				}
			}
		}	
		$this->render("import");
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