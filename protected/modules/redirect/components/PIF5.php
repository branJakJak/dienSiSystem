<?php 

/**
* PIF5
*/
class PIF5 extends RemoteViciOutBase
{
    public function send()
    {
        $httpParameters = array(
            "user"=>"apiuserwill",
            "pass"=>"mentalapipassword",
            "function"=>"add_lead",
            "phone_number"=>$this->getPhoneNumber(),
            "phone_code"=>"44",
            // "list_id"=>"550", //dont blame me
            // "dnc_check"=>"Y",
            // "duplicate_check"=>"DUPLIVE",
            "add_to_hopper"=>"Y",
            "hopper_priority"=>"45"
        );
        $httpParameters = array_merge($httpParameters, $this->getAdditionalParameters());
        $httpParameters['add_to_hopper'] = "Y";
        $httpParameters['hopper_priority'] = "45";
        $httpParameters['source'] = intval($httpParameters['list_id']);
        $httpParameters['list_id'] = "PIF5";
        $res = $this->sendToRemoteServer($httpParameters);
        $jsonMessage['vici_res'] = $res;
        return $jsonMessage;
    }	
}