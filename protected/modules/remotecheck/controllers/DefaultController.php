<?php

class DefaultController extends Controller
{
	public function actionIndex($mobileNumber)
	{
		header("Content-Type: application/json");
		$jsonMessage =  array();
		$mobileNumber = doubleval($mobileNumber);
		$isBlackListed = BlackListedMobile::model()->exists("mobile_number = :mobile_number", array('mobile_number'=>$mobileNumber));
		if ($isBlackListed) {
			$jsonMessage = array(
				"status"=>"blacklisted",
			);
		}else{
			$jsonMessage = array(
				"status"=>"clean",
			);
		}
		echo json_encode($jsonMessage);
	}
}