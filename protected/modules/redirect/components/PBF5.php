<?php 

/**
* PBF5
*/
class PBF5 extends RemoteViciOutBase
{
    public function send()
    {
        $httpParameters = array(
            "source"=>"5PRESS",
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
        $httpParameters = array_merge($this->getAdditionalParameters() , $httpParameters);
        $httpParameters['source_id'] = $httpParameters['list_id'];
        // $httpParameters['add_to_hopper'] = "Y";
        // $httpParameters['hopper_priority'] = "45";
        // $httpParameters['source'] = intval($httpParameters['list_id']);
        // $httpParameters['list_id'] = "PIF5";
        $res = $this->sendToRemoteServer($httpParameters);
        $jsonMessage['vici_res'] = $res;
        return $jsonMessage;
    }	
}