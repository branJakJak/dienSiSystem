<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		header('Content-Type: application/json');
		$resultJson = array(
			"application_status"=>"ok",
			"database_status"=>"",
			);
		try {
			Yii::app()->db;
			$resultJson['database_status'] = "ok";
		} catch (Exception $e) {
			$resultJson['database_status'] = "error";
		}
		echo json_encode($resultJson);
	}
}f