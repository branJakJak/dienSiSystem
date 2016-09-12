<?php 
class DeleteInvalidMobileCommand extends CConsoleCommand{
	public function actionIndex()
	{
		set_time_limit(10 * 60); // 10 minutes
		Yii::import("application.models.*");
		$totalCount = BlackListedMobile::model()->count();
		$offset = 0;
		while ($totalCount >= $offset) {
			$criteria = new CDbCriteria;
			$criteria->offset = $offset;
			$criteria->addCondition('trim(mobile_number) NOT REGEXP \'^0?7[0-9]{9}$\'');
			$currentModel = BlackListedMobile::model()->find($criteria);
			echo "Evaluating $currentModel->mobile_number \n";
			$currentModel->mobile_number = trim($currentModel->mobile_number);
			if (!preg_match('/^0?7\d{9}$/', $currentModel->mobile_number)) {
				echo "invalid mobile number : deleting $currentModel->mobile_number \n";
				$currentModel->delete();
			}
			$offset++;
		}
		
	}
}