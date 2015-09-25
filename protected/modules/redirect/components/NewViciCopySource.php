<?php 
/**
* NewViciCopySource
*/
class NewViciCopySource
{
	
	public function send($phone_number)
	{
		$url = "https://162.250.124.167/vicidial/non_agent_api.php?";
		$httpParameters = array(
				"source"=>"AddDNCfrom213",
				"user"=>"admin",
				"pass"=>"Mad4itNOW",
				"function"=>"add_mednc",
				"dnc_check"=>"Y",
				"phone_number"=>$phone_number,
			);
		$curlURL = $url.http_build_query($httpParameters);
		$curlres = curl_init($curlURL);
		curl_setopt($curlres, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlres, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curlres, CURLOPT_SSL_VERIFYPEER, false);
		$curlResRaw = curl_exec($curlres);
		Yii::log($curlURL, CLogger::LEVEL_INFO,'info');
		Yii::log($curlResRaw, CLogger::LEVEL_INFO,'info');
	}
}