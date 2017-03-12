<?php 

/**
* PMK552
*/
class PMK552 extends RemoteViciOutBase
{
    public function send()
    {
    	
        $httpParameters = array(
            "source"=>"PMK552",
            "user"=>"apiuserwill",
            "pass"=>"mentalapipassword",
            "function"=>"add_lead",
            "phone_number"=>$this->getPhoneNumber(),
            "phone_code"=>"44",
            "list_id"=>"552",
            "dnc_check"=>"Y",
            "duplicate_check"=>"DUPLIVE",
            "add_to_hopper"=>"Y",
            "hopper_priority"=>"45"
        );
        $httpParameters = array_merge($this->getAdditionalParameters() , $httpParameters);
        $res = $this->sendToRemoteServer($httpParameters);
        $jsonMessage['vici_res'] = $res;
        return $jsonMessage;
    }
}