<?php 

/**
* HtAccessBuilder
*/
class HtAccessBuilder
{
	public static function build()
	{
		$builder = new HtAccessBuilder;
		$htaccessStr = $builder->buildHtAccessString();
		$htaccessFile = Yii::getPathOfAlias("application")."/../.htaccess";
		$writeResult = file_put_contents($htaccessFile, $htaccessStr);
		if ($writeResult === FALSE) {
			throw new Exception("Cannot write new htaccess configuration to .htaccess");
		}
	}
	private function buildHtAccessString()
	{
		/* build htaccess header string*/
		$htaccessStr = <<<EOL
# index file can be index.php, home.php, default.php etc.

# Rewrite engine
RewriteEngine On

# condition with escaping special chars
RewriteCond $1 !^(index\.php|robots\.txt|favicon\.ico)
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ claimdatastorage/index.php/$1 [L,QSA]	

Order allow,deny
EOL;
		/*get all ip address*/
		$allIpAddresses = Ip::model()->findAll();
		foreach ($allIpAddresses as $currentIpAddress) {
		$tempIpaddress = $currentIpAddress->ip_address;
		/*append ip addreeeses*/
		$htaccessStr = $htaccessStr.<<<EOL

Allow from $tempIpaddress
EOL;
		}
		/*build htaccess footer*/
		$htaccessStr = $htaccessStr.<<<EOL

Deny from all
EOL;
		return $htaccessStr;
	}
}

?>