<?php 



/**
* 
*/
class ExportAllRecords
{
	private $model;
	function __construct(Accounts $model) {
		$this->model = $model;
	}
	public function download()
	{
		$fileName = $this->model->claimAccountName.' - '.date("Y-m-d").'-All-entries';
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"$fileName.csv\";" );
		header("Content-Transfer-Encoding: binary");

		$criteria = new CDbCriteria();
		$criteria->compare("account_id",$this->model->account_id );
		$criteria->order = "date_created DESC";
		$criteria->distinct = true;
		
		$records = Records::model()->findAll($criteria);
		$isFirst = true;
		foreach ($records as $curRecord) {
			$data = json_decode($curRecord->claimData,true);
			$rowData = "";
			$allowPrint = true;

			if ($isFirst) {
				//print heads
				$headers = "";
				$keys = array_keys($data);
				$headers  = implode(",", $keys)."\n";
				echo $headers;
				$isFirst = false;

			}
			/*check if mobile number exists at blacklist mobile nums*/
			$mobileNumMatch = preg_grep('/0?7\d{9}/', $data);
			if ( count($mobileNumMatch) > 0 ) {
				$mobileNumContainer = array_values($mobileNumMatch)[0];
				$criteria = new CDbCriteria;
				$criteria->compare('mobile_number', $mobileNumContainer);
				$allowPrint = !(BlackListedMobile::model()->exists($criteria) );
			}
			if ($allowPrint) {
				foreach ($data as $curRowData) {
					$rowData=$rowData."\"$curRowData\",";
				}
			}

			$rowData = str_replace(chr(194)," ",$rowData);
			//prepare data
			if ($allowPrint) {
				echo $rowData."\n";
			}

		}		
	}/*end of function*/
}