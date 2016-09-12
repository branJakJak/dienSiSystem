<?php 

/**
* 	
*/
class MobileNumberExtractor
{

	public static function extractMobileNumbers($dataDataArr)
	{
		foreach ($dataDataArr as $currentVal) {
			if (preg_match("/07\d{9}/", $currentVal)) {
				return $currentVal;
			}
		}
		return false;
	}
	public static function extractMultiDimensional($rawMulti)
	{
		$resultArr= array();
		foreach ($rawMulti as $currentMulti) {
			if (isset($currentMulti['claimData'])) {
				$currentMulti = json_decode($currentMulti['claimData'], true);
				$tempContainer = array_values($currentMulti);
				$mobileNumContainer = MobileNumberExtractor::extractMobileNumbers($tempContainer);
				/*check if present in table blacklist*/
				$criteria = new CDbCriteria;
				$criteria->compare("mobile_number" , $mobileNumContainer);
				if (  !BlackListedMobile::model()->exists($criteria)  ) {
					$resultArr[] = $mobileNumContainer;
				}
			}
		}
		return $resultArr;
	}

}