<?php 
/**
* DataController
*/
class DataController extends CController
{
	public function actionIndex()
	{
		Yii::import('application.modules.dnc.components.*');
		$allowedDispo = array("FISH","SCR","DNC");
		$jsonMessage = array();
		if ( (  isset($_GET['dispo']) && !empty($_GET['dispo'])  )  && (  isset($_GET['phone_number']) && !empty($_GET['phone_number'])  ) ) {
			$status = $_GET['dispo'];
			$status = strtoupper($status);
			$phone_number = $_GET['phone_number'];
			if ( in_array($status, $allowedDispo)	 ) {
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
