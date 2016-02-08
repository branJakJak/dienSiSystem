<?php 
/**
 * 
 */
class Pdly5 extends RemoteViciOutBase
{
    public function send()
    {
        $httpParameters = array(
            "source"=>"5PDLY",
            "user"=>"apiuserwill",
            "pass"=>"mentalapipassword",
            "function"=>"add_lead",
            "phone_number"=>$this->getPhoneNumber(),
            "phone_code"=>"44",
            "list_id"=>"822016",
        );
        $httpParameters = array_merge($httpParameters, $this->getAdditionalParameters());
        $res = $this->sendToRemoteServer($httpParameters);
        $jsonMessage['vici_res'] = $res;
        return $jsonMessage;
    }
}