<?php 


/**
* SeedBlackListedCommand
*/
class SeedBlackListedCommand extends CConsoleCommand
{
	public function actionIndex($count)
	{
		Yii::import("application.models.*");
		echo "Preparing to seed blacklisted mobile . ";
		$dates = array(
				date("Y-m-d H:i:s",strtotime("monday this week")),
				date("Y-m-d H:i:s",strtotime("tuesday this week")),
				date("Y-m-d H:i:s",strtotime("wednesday this week")),
				date("Y-m-d H:i:s",strtotime("thursday this week")),
				date("Y-m-d H:i:s",strtotime("friday this week")),
				date("Y-m-d H:i:s",strtotime("saturday this week")),
				date("Y-m-d H:i:s",strtotime("sunday this week"))
			);
		foreach ($dates as $value) {
			foreach (range(0, $count) as $value1) {
				$bl1 = new BlackListedMobile();
				$bl1->mobile_number = sprintf("07%d",rand(111111111,999999999));
				$bl1->date_created = $value;
				$bl1->ip_address = "127.0.0.1";
				$bl1->origin = "test";
				if ($bl1->save()) {
					echo "New Mobile number saved:$value1".PHP_EOL;
				}else{
					echo "Failed to create new blacklisted mobile".PHP_EOL;
					echo CHtml::errorSummary($bl1).PHP_EOL;
					echo $bl1->mobile_number;
					die();
				}
			}

		}
	}
}