<?php

class ServerCheck
{
	
	public $_hostname;
	public $_port = "80";
	function __construct($hostname,$port = "80") {
		$this->_hostname = $hostname;
		$this->_port = $port;
	}
	/*
	* @return String contains the status of the site ['OFFLINE','ONLINE']
	*/
	public function getServerStatus()
	{
		$fp = @fsockopen($this->_hostname, $this->_port, $errno, $errstr, 30);
		return (!$fp) ? "OFFLINE":"ONLINE";
	}

}


?>