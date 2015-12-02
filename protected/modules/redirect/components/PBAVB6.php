<?php 

/**
* PBAVB6
*/
class PBAVB6 extends RemoteViciOutBase
{
    public function send()
    {
        $httpParameters = array(
            "source"=>"5PRESSPBA",
            "user"=>"apiuserwill",
            "pass"=>"mentalapipassword",
            "function"=>"add_lead",
            "phone_number"=>$this->getPhoneNumber(),
            "phone_code"=>"44",
            "list_id"=>"777",
            "dnc_check"=>"Y",
            "duplicate_check"=>"DUPLIVE",
            "add_to_hopper"=>"Y",
            "hopper_priority"=>"45",
        );
        $httpParameters = array_merge($httpParameters, $this->getAdditionalParameters());
        $res = $this->sendToRemoteServer($httpParameters);
        $jsonMessage['vici_res'] = $res;
        return $jsonMessage;
    }	
}