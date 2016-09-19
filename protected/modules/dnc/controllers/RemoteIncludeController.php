<?php 
/**
* 	
*/
class RemoteIncludeController extends Controller
{
	public function actionIndex()
	{
		header("Content-Type: application/json");
		$jsonMessage = array(
				"status"=>"error",
				"message"=>"Incomplete parameter",
		);
		if (isset($_GET['mobileNumber']) && !empty($_GET['mobileNumber']) && !empty($_GET['ip_address']) ) {
			$mobilenumber1 = new BlackListedMobile('create');
			$mobilenumber1->mobile_number = $_GET['mobileNumber'];
			$mobilenumber1->origin = $_GET['origin'];
			$mobilenumber1->ip_address = $_GET['ip_address'];
			if($mobilenumber1->save()){


				$vicidialReport = VicidialReportSend::send($mobilenumber1->mobile_number);

				$jsonMessage = array(
					"status"=>"success",
					"message"=>"Added to blacklisted",
					'vicidialRemoteIncludeStatus'=>$vicidialReport,
				);
			}else{
				$jsonMessage = array(
					"status"=>"error",
					"message"=>CHtml::errorSummary($mobilenumber1)
				);
			}
		}else{
			$jsonMessage = array(
					"status"=>"error",
					"message"=>"Invalid mobile number",
			);
		}
		echo json_encode($jsonMessage);
	}
}
