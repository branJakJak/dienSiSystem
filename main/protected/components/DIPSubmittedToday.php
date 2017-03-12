<?php 


/**
* 
*/
class DIPSubmittedToday
{
	/**
	 * Get total number of Ip Address records submitted today
	 * @return [type] [description]
	 */
	public function getTotal()
	{
		$totalContainer = 0;
		$recordsSubmittedToday = Yii::app()->db->createCommand("select ip_address,count(ip_address) as 'count' from claimrecord where date(now()) = date(date_created) group by ip_address")->queryAll();
		
		foreach ($recordsSubmittedToday as $value) {
			if (intval($value['count']) >= 2) {
				$totalContainer = $totalContainer +1;
			}
		}
		return $totalContainer;
	}
}
?>