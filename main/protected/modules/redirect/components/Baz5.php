<?php 
/**
* PRDM5
*/
class Baz5 extends RemoteViciOutBase
{
    public function send()
    {
        $httpParameters = array(
            "user"=>"addnumberto_barry5s",
            "pass"=>"AddMeTOit!!",
            "function"=>"add_5export_list",
            "phone_number"=>$this->getPhoneNumber(),
        );
        $httpParameters = array_merge($httpParameters, $this->getAdditionalParameters());
        $res = $this->sendToRemoteServer($httpParameters);
        $jsonMessage['vici_res'] = $res;
        return $jsonMessage;
    }

    public function sendToRemoteServer($httpParams)
    {
        if (!isset($httpParams['phone_number'])) {
            throw new Exception("Please provide mobile number parameter");
        }
        $curlURL = "https://162.250.124.167/vicidial/add_to_5s.php?";
        $curlURL .= http_build_query($httpParams);
        $curlres = curl_init($curlURL);
        curl_setopt($curlres, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlres, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curlres, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlres, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($curlres);
    }


}