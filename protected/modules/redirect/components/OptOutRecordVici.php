<?php 

/**
* OptOutRecordVici
*/
class OptOutRecordVici extends RemoteViciOutBase
{

	public function send()
	{
        $httpParameters = array(
            "source"=>"OPTOUTVB",
            "user"=>"apiuserwill",
            "pass"=>"mentalapipassword",
            "function"=>"add_mednc",
            "dnc_check"=>"Y",
            "phone_number"=>$this->getPhoneNumber()
        );
        $res = $this->sendToRemoteServer($httpParameters);
        $jsonMessage['vici_res'] = $res;
		$mdl = new BlackListedMobile;
		$mdl->mobile_number = $this->getPhoneNumber();
		$mdl->ip_address = $this->getIpAddress();
		$mdl->origin = "public_url";
		try {
			if ($mdl->save(false)) {
				$jsonMessage['dnc.website'] = "saving dnc.website saved";
			}else{
				$jsonMessage['dnc.website'] = "cant save to dnc.website";
				$jsonMessage['dnc.website']['message'] = CHtml::errorSummary($mdl);
			}
		} catch (Exception $e) {
			$jsonMessage['dnc.website'] = "fatal error";
			$jsonMessage['dnc.website']['message'] = $e->getMessage();
		}
        return $jsonMessage;
	}

}