<?php 

class DeleteEmptyDataCommand extends CConsoleCommand{
	public function actionIndex($accountId)
	{
		Yii::import("application.models.*");
		$criteria = new CDbCriteria;
		$criteria->compare('account_id' , $account_id);
		$records = Records::model()->findAll();
		foreach ($records as $value) {
			$dataArr = json_decode(  $value->claimData , 	true );
			if (   empty($dataArr['Title'])   ||    empty($dataArr['Firstname'])  ) {
				echo "$value->record_id \n ";
			}
		}
	}
}