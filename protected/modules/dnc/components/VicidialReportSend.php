<?php 

/**
* VicidialReportSend
*/
class VicidialReportSend
{
	public static function send($mobileNumber)
	{
		$mobileNumber = doubleval($mobileNumber);
		$curlURL = "http://213.171.204.244/vicidial/non_agent_api.php?source=dncadding&user=apiuserwill&pass=mentalapipassword&function=add_mednc&dnc_check=Y&phone_number=$mobileNumber";
		$curlres = curl_init($curlURL);
		curl_setopt($curlres, CURLOPT_RETURNTRANSFER, true);
		return curl_exec($curlres);
	}
}