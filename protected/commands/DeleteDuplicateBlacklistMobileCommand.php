<?php 
class DeleteDuplicateBlacklistMobileCommand extends CConsoleCommand{
	public function actionIndex()
	{
		set_time_limit(10 * 60); // 10 minutes
		Yii::import("application.models.*");
		/*retrieve all mobile number having count greater than two or more */
		$totalCount = BlackListedMobile::model()->count();
		$offset = 0;
		while ($totalCount >= $offset) {
			$criteria = new CDbCriteria;
			$criteria->offset = $offset;
			$currentModel = BlackListedMobile::model()->find($criteria);
			$criteria2 = new CDbCriteria;
			$criteria2->compare("mobile_number",$currentModel->mobile_number);
			$criteria2->addCondition("rec_id  <> $currentModel->rec_id");
			$mods = BlackListedMobile::model()->findAll( $criteria2 );
			foreach ($mods as $currentModel) {
				echo "Deleteting $currentModel->mobile_number  , has duplicate \n";
				$currentModel->delete();
			}
			$offset++;
		}
	}
	public function solution2()
	{
		$commandStr = '
		
		'
		$totalNumOfRecWithDups = Yii::app()->db->createCommand('')
	}
}