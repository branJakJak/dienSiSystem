<?php 


/**
* 	DuplicateSummaryUtility
*/
class DuplicateSummaryUtility
{
	public static function getTotalNum($whatReport)
	{
		$rep = new $whatReport();
		return $rep->getTotal();
	}
}