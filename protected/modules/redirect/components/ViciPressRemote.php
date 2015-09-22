<?php


class ViciPressRemote extends RemoteViciOutBase
{

    public function send()
    {
        $httpParameters = array(
            "source" => "5press",
            "user" => "apiuserwill",
            "pass" => "mentalapipassword",
            "function" => "add_lead",
            "phone_number" => $this->getPhoneNumber()
        );
        $res = $this->sendToRemoteServer($httpParameters);
        $jsonMessage['vici_res'] = $res;
        return $jsonMessage;
    }


}