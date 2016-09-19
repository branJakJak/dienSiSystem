<?php 
 /**
 * 
 */
class ExportAllFlightSiteRecords
{
 
	private $model;
	private $exportType;
	private $configurations;
	/**
	 * [__construct description]
	 * @param Accounts $model          [description]
	 * @param [type]   $exportType     [description]
	 * @param [type]   $configurations [description]
	 */
	function __construct(Accounts $model , $exportType , $configurations) {
		$this->model = $model;
		$this->exportType = $exportType;
		$this->configurations = $configurations;
	}
	private function retrieveDataRecords(){
		$records = null;
		/*using export type specified above*/
		if ($this->exportType === 'all') {
			$criteria = new CDbCriteria();
			$criteria->compare("account_id",$this->model->account_id );
			$criteria->order = "date_created DESC";
			$criteria->distinct = true;
			$records = Records::model()->findAll($criteria);
		}else if ($this->exportType === 'this week') {
	        $criteria = new CDbCriteria();
	        $criteria->compare("account_id",$this->model->account_id);
			$startingDate = date("Y-m-d 12:00:00",strtotime('friday last week')  );
			$endDate = date("Y-m-d 23:59:00",strtotime('friday this week')  );
			$criteria->addBetweenCondition("t.date_created",$startingDate,$endDate);
			$criteria->order = "date_created DESC";
			$criteria->distinct = true;
			$records = Records::model()->findAll($criteria);
		}else if ($this->exportType === 'today') {
			$criteria = new CDbCriteria();
			$criteria->compare("account_id",$_REQUEST['accountID']);
			$criteria->addCondition("date(date_created) = date(now())");
			$criteria->order = "date_created DESC";
			//$criteria->group = "ip_address";
			$criteria->distinct = true;
			$records = Records::model()->findAll($criteria);
		}else if ($this->exportType === 'range') {
			/*get claims between */
			$criteria = new CDbCriteria;
			$dateFrom = DateTime::createFromFormat("m/d/Y",$this->configurations['dateFrom']);
			$dateTo = DateTime::createFromFormat("m/d/Y",$this->configurations['dateTo']);
			$dateFromStr = $dateFrom->format('Y-m-d');
			$dateToStr = $dateTo->format('Y-m-d');
			$criteria->compare("account_id",$this->model->account_id);
			$criteria->addBetweenCondition(  'date_created'  , $dateFromStr , $dateToStr );
			$criteria->order = "date_created DESC";
			$criteria->distinct = true;
			$records = Records::model()->findAll($criteria);
		}
		return $records;
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


		// $criteria = new CDbCriteria();
		// $criteria->compare("account_id",$this->model->account_id );
		// $criteria->order = "date_created DESC";
		// $criteria->distinct = true;
		// $records = Records::model()->findAll($criteria);
		$records = $this->retrieveDataRecords();

		$isFirst = true;
		$tempfile = tempnam(sys_get_temp_dir(), "tempDownload");
		$filehandle = fopen($tempfile, "r+");
		foreach ($records as $curRecord) {
			$data = json_decode($curRecord->claimData,true);
			$firstname = "";
			if (isset($data['First name'])) {
				$firstname = $data['First name'];
			}else if (isset($data['First Name'])) {
				$firstname = @$data['First Name'];
			}else if (isset($data['Firstname'])){
				$firstname = @$data['Firstname'];
			}

			$otherPassengerNames = "";
			if (isset($data['Other Passenger name'])) {
				$otherPassengerNames  = $data['Other Passenger name'];
			}else if (isset($data['Other Passenger'])) {
				$otherPassengerNames  = $data['Other Passenger'];
			}else if (isset($data['Other Passenger Name'])) {
				$otherPassengerNames = $data['Other Passenger Name'];
			}


			$emailAddress = "";
			if (isset($data['Email'])) {
				$emailAddress = $data['Email'];
			}else if (isset($data['email'])) {
				$emailAddress = $data['email'];
			}

			$airline = "";
			if (isset($data["Airline"])) {
				$airline = $data["Airline"];
			} 

			$address1  = "";
			if (isset($data['address1'])) {
				$address1  = $data['address1'];
			}


			$reasonForDelay = "";
			if(  isset($data['Reason of delay']  )  ){
				$reasonForDelay = $data['Reason of delay'];
			}else if ( isset($data['Reason for Delay']) ){	
				$reasonForDelay = $data['Reason for Delay'];
			}

			$mobileNumber = "";
			if (isset($data['Mobile No.'])) {
				$mobileNumber = $_data['Mobile No.'];
			}else if (isset($data['Mobile Number'])) {
				$mobileNumber = $data['Mobile Number'];
			}

			$flightDate = "";
			if (isset($data["Flight Date"])) {
				$flightDate = $data["Flight Date"];
			}else if (isset($data["Flight date"])) {
				$flightDate = $data["Flight Date"];
			}
			$reArrangedData = array(
				$data['Date Submitted'],
				$data['Title'],
				$firstname,
				$data['Surname'],
				intval( $data['address1'] ),
				$data['address1'],
				$data['address2'],
				$data['city'],
				$data['zip'],
				$data['Date of Birth'],
				$emailAddress,
				$mobileNumber,
				OtherPassengerUtility::computeTotalNumOfPassenger($otherPassengerNames),
				OtherPassengerUtility::getAdditionalPassengerNames($otherPassengerNames),
				OtherPassengerUtility::getAdditionalPassengerEmails($otherPassengerNames),
				$data['Hours'],	
				$data['Minutes'],
				$data["Flight Number"],
				$flightDate,
				$airline,	
				$data["Departure Airport"],
				$data["Arrival Airport"],
				$data["Actual Arrival"],
				$data["Actual Departure"],
				$data["Flight Distance"],
				$data["Scheduled Arrival"],
				$data["Scheduled Departure"],
				$data["Flight Status (km)"],
				$reasonForDelay,
			);

			$rowData = "";
			$allowPrint = true;
			if ($isFirst) {
				//print heads
				$headers = "";
				$keys = array(
						"Date Submitted",
						"Title",
						"First Name",
						"Surname",
						"House Number/Name",
						"Address 1",
						"Address 2",
						"Town/City",
						"Postcode",
						"DOB",
						"Email",
						"Mobile Number",
						"Total Number Passengers",
						"Additional Passenger Names",
						"Additional Passenger Emails",
						"Length of Delay (Hours)",
						"Length of Delay (Minutes)",
						"Flight Number",
						"Flight Date",
						"Airline",
						"Departure Airport",
						"Arrival Airport",
						"Actual Arrival Date/Time",
						"Actual Departure Date/Time",
						"Flight Distance",
						"Scheduled Arrival Date/Time",
						"Scheduled Departure Date/Time",
						"Delayed/Cancelled",
						"Reason For Failure",
				);
				$headers  = implode(",", $keys)."\n";
				echo $headers;
				$isFirst = false;
			}
			/*check if mobile number exists at blacklist mobile nums*/
			$mobileNumMatch = preg_grep('/0?7\d{9}/', $reArrangedData);
			if ( count($mobileNumMatch) > 0 ) {
				$mobileNumContainer = array_values($mobileNumMatch)[0];
				$criteria = new CDbCriteria;
				$criteria->compare('mobile_number', $mobileNumContainer);
				$allowPrint = !(BlackListedMobile::model()->exists($criteria) );
			}
			if ($allowPrint) {

				$tempVals = array_values($reArrangedData);
				if ($this->model->account_id == 4 && !empty($tempVals[1]) && !empty($tempVals[2]) ) {
					/*check if title , firstname and lastname contains data*/	
					fputcsv($filehandle, $reArrangedData);
				}
				if ($this->model->account_id != 4) {
					fputcsv($filehandle, $reArrangedData);
				}
			}
		}
		rewind($filehandle);
		fpassthru($filehandle);
		unlink($tempfile);
		die();
	}/*end of function*/
}
