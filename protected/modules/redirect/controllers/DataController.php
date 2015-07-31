<?php 
/**
* DataController
*/
class DataController extends CController
{
	public function actionIndex()
	{
		Yii::import('application.modules.dnc.components.*');
		$jsonMessage = array();
		if ( (  isset($_GET['status']) && !empty($_GET['status'])  )  && (  isset($_GET['phone_number']) && !empty($_GET['phone_number'])  ) ) {
			$status = $_GET['status'];
			$status = strtolower($status);
			$phone_number = $_GET['phone_number'];
			if ( $status == 'dnc' ) {
				$res = VicidialReportSend::send($phone_number);
				$jsonMessage['vici_res'] = $res;
				$mdl = new BlackListedMobile;
				$mdl->mobile_number = $phone_number;
				$mdl->ip_address = $_SERVER['REMOTE_ADDR'];
				$mdl->origin = "public_url";
				try {
					if ($mdl->save(false)) {
						$jsonMessage['dnc.website'] = "saving dnc.website saved";
					}else{
						$jsonMessage['dnc.website'] = "cant save to dnc.website";
						$jsonMessage['dnc.website']['message'] = CHtml::errorSummary($mdl);
					}
				} catch (Exception $e) {
					$jsonMessage['dnc.website'] = "fatal error";
					$jsonMessage['dnc.website']['message'] = $e->getMessage();
				}
				echo json_encode($jsonMessage);
			}else{
				die();
			}
		}else{
			die();
		}
	}
}