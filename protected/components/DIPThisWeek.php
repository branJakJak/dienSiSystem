<?php 


/**
* DIPThisWeek
*/
class DIPThisWeek
{

	public function getTotal()
	{
		$totalContainer = 0;
		$startingDate = date("Y-m-d 12:00:00",strtotime('friday last week')  );
		$endDate = date("Y-m-d 23:59:00",strtotime('friday this week')  );
		$recordsSubmittedToday = Yii::app()->db->createCommand("select ip_address,count(ip_address) as 'count' from claimrecord where date_created >= '$startingDate' and date_created <= '$endDate' group by ip_address")->queryAll();
		
		foreach ($recordsSubmittedToday as $value) {
			if (intval($value['count']) >= 2) {
				$totalContainer = $totalContainer +1;
			}
		}
		return $totalContainer;
	}


}

?>