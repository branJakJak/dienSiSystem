<?php 
/**
* PB5P
*/
class PB5P extends RemoteViciOutBase
{
    public function send()
    {
        $httpParameters = array(
            "source"=>"PB5P",
            "user"=>"apiuserwill",
            "pass"=>"mentalapipassword",
            "function"=>"add_lead",
            "phone_number"=>$this->getPhoneNumber(),
            "phone_code"=>"44",
            "list_id"=>"444",
            "dnc_check"=>"Y",
            "duplicate_check"=>"DUPLIVE",
            "add_to_hopper"=>"Y",
            "hopper_priority"=>"45"
        );
        $httpParameters = array_merge($this->getAdditionalParameters(),$httpParameters);
        // $httpParameters['list_id'] = '444';
        // $httpParameters['source_id'] = 'PB5P';

        $res = $this->sendToRemoteServer($httpParameters);
        $jsonMessage['vici_res'] = $res;
        return $jsonMessage;
    }
}