<?php 

class ImportLargeCsvCommand extends CConsoleCommand{
	public function actionIndex()
	{
		$fileName = "5859-xas.csv";
		$filePath = "/home/server5/public_html/claimdatastorage_temp2/protected/uploaded_files/$fileName";
		$sqlCommand = "LOAD DATA INFILE '%s' INTO TABLE black_listed_mobile FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '%s' IGNORE 0 LINES ('mobile_number');\" ";
		$sqlCommand = sprintf($sqlCommand, $filePath , '\r\n');
		

		$mainCommand = "mysql  --user=server5_ds --password=hitman052529 --database=server5_ds -e 'select now();'"
	}
}