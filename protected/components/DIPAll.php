<?php 

/**
* DIPAll
*/
class DIPAll
{
	public function getTotal()
	{
		$totalContainer = 0;
		$recordsSubmittedToday = Yii::app()->db->createCommand("select ip_address,count(ip_address) as 'count' from claimrecord group by ip_address")->queryAll();
	
		foreach ($recordsSubmittedToday as $value) {
			if (intval($value['count']) >= 2) {
				$totalContainer = $totalContainer +1;
			}
		}

		return $totalContainer;		
	}
}
?>