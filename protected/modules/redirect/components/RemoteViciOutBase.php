<?php 

/**
* RemoteViciOutBase
*/
class RemoteViciOutBase
{
	
	protected $phoneNumber;
	protected $jsonMessage;
    protected $ip_address;


	function __construct($phoneNumber) {
		$this->phoneNumber = $phoneNumber;
	}

    public function setIpAddress($ip_address)
    {
        $this->ip_address = $ip_address;
    }

    public function getIpAddress()
    {
        return $this->ip_address;
    }


	/**
	 * Retrieves json message
	 *
	 * @return string jsonMessage
	 */
	public function getJsonMessage() {
	    return $this->jsonMessage;
	}
	
	/**
	 * Sets value of jsonMessage
	 *
	 * @param string $jsonMessage json message
     * @return $this
     */
	public function setJsonMessage($jsonMessage) {
	    $this->jsonMessage = $jsonMessage;
	    return $this;
	}


	/**
	 * Retrieves phonenumber
	 *
	 * @return string phonenumber
	 */
	public function getPhoneNumber() {
	    return $this->phoneNumber;
	}

    /**
     * Set value of phonenumber
     *
     * @param $phoneNumber
     * @internal param String $newphoneNumber Phonenumber
     * @return $this
     */
	public function setPhoneNumber($phoneNumber) {
	    $this->phoneNumber = $phoneNumber;
	    return $this;
	}

    /**
     * Basic http parameter
     * <pre>
     * source=dncadding&user=apiuserwill&pass=mentalapipassword&function=add_mednc&dnc_check=Y&phone_number=07321654987
     * </pre>
     * @param $httpParams
     * @return mixed
     * @throws Exception
     */
    public function sendToRemoteServer($httpParams){
        if (!isset($httpParams['phone_number'])) {
            throw new Exception("Please provide mobile number parameter");
        }
        $curlURL = "http://213.171.204.244/vicidial/non_agent_api.php?";
        $curlURL .= http_build_query($httpParams);
        $curlres = curl_init($curlURL);
        curl_setopt($curlres, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($curlres);
    }

}