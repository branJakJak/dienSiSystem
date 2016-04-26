<?php 

/**
* PBF5
*/
class PBF5 extends RemoteViciOutBase
{
    public function send()
    {
        $httpParameters = array(
            "source"=>"PBF5",
            "user"=>"apiuserwill",
            "pass"=>"mentalapipassword",
            "function"=>"add_lead",
            "phone_number"=>$this->getPhoneNumber(),
            "phone_code"=>"44",
            "list_id"=>"770",
            // "dnc_check"=>"Y",
            // "duplicate_check"=>"DUPLIVE",
            "add_to_hopper"=>"Y",
            "hopper_priority"=>"45"
        );
        $httpParameters = array_merge($httpParameters, $this->getAdditionalParameters());
        $httpParameters['list_id'] = intval($httpParameters['list_id']);
        $res = $this->sendToRemoteServer($httpParameters);
        $jsonMessage['vici_res'] = $res;
        return $jsonMessage;
    }	
}