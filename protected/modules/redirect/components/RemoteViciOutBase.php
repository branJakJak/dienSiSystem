<?php 

/**
* RemoteViciOutBase
*/
class RemoteViciOutBase
{
	
	protected $phoneNumber;
	protected $jsonMessage;
    protected $ip_address;
    protected $additionalParameters = array();
    const SERVER_IP_ADDDRESS = '149.202.73.207';//213.171.204.244


	function __construct($phoneNumber) {
        $this->setPhoneNumber($phoneNumber);
	}

    /**
     * Additional parameters to be sent to 213.171.204.244 dialer
     *
     * @return mixed Parameters to be prepended
     */
    public function getAdditionalParameters() {
        return $this->additionalParameters;
    }
    
    /**
     * Sets the additional parameters to be prepended
     *
     * @param Mixed $newadditionalParameters Parameters to be prepended
     */
    public function setAdditionalParameters($additionalParameters) {
        $this->additionalParameters = $additionalParameters;
    
        return $this;
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
	    $this->phoneNumber = doubleval($phoneNumber);
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
        $curlURL = "http://".RemoteViciOutBase::SERVER_IP_ADDDRESS."/vicidial/non_agent_api.php?";
        $curlURL .= http_build_query($httpParams);
        $curlres = curl_init($curlURL);
        curl_setopt($curlres, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($curlres);
    }

}