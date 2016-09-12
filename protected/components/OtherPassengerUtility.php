<?php 
/**
* 
*/
class OtherPassengerUtility
{
	
	public static function computeTotalNumOfPassenger($otherPassengerNameStr)
	{
		$numOfPass = 0;
		$rawArrOtherPass = explode(",", $otherPassengerNameStr);
		$rawArrOtherPass=array_filter($rawArrOtherPass);
		$finalArr= array();
		foreach ($rawArrOtherPass as $key => $value) {
			$finalArr[] = preg_replace('/[\(\)]/', "", $value);
		}
		$finalArr = array_filter($finalArr);
		$numOfPass = count($finalArr);
		return $numOfPass;	
	}
	public static function getAdditionalPassengerNames($otherPassengerNameStr)
	{
		$outputString = "";
		$otherPassArr = explode(",", $otherPassengerNameStr);
		foreach ($otherPassArr as $key => $value) {
			if (strpos($value, "(") !== FALSE) {
				$outputString .= substr($value, 0 , strpos($value, "(") );
			}else if (isset($value) && !empty($value)) {
				$outputString .= $value;
			}
			$outputString  .= ',';
		}
		$outputString = rtrim($outputString , ",");
		return $outputString;
	}
	public static function getAdditionalPassengerEmails($otherPassengerNameStr)
	{
		$otherPassArr = explode(",", $otherPassengerNameStr);
		foreach ($otherPassArr as $key => $value) {
			//has email address
			if (strpos($value, "(") !== FALSE) {
					$outputString .= substr(
						$value, 
						strpos($value, "(") +1  , 
						(strpos($value, ")")  - strpos($value, "(") ) -1 
					) . ',';
			}
		}
		$outputString = rtrim($outputString , ",");
		return $outputString;
	}
}