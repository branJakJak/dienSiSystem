<?php 
/**
* DataController
*/
class DataController extends CController
{
	public function actionIndex()
	{
		// header("Content-Type: application/json");
		$allowedDispo = array("FISH","SCR","DNC","OPTOUT","5press");
		$jsonMessage = array();
		if ( (  isset($_GET['dispo']) && !empty($_GET['dispo'])  )  && (  isset($_GET['phone_number']) && !empty($_GET['phone_number'])  ) ) {
			$status = $_GET['dispo'];
			$status = strtoupper($status);
			$phone_number = $_GET['phone_number'];
			/*in allowed dispo configuration*/
			if (  in_array($status, $allowedDispo)  ) {
				if ($status ===  "DNC") {
					$dncObj = new DNCViciRemote($phone_number);
                    $dncObj->setIpAddress($_SERVER['REMOTE_ADDR']);
					$jsonMessage = $dncObj->send();
				/*end of DNC */
				}else if ($status ===  "OPTOUT") {
					$optOutVici = new OptOutRecordVici($phone_number);
                    $optOutVici->setIpAddress($_SERVER['REMOTE_ADDR']);
                    $jsonMessage = $optOutVici->send();
					/*end of optout dispo*/
				}else if ($status == "") {
                    $vicipresObj = new ViciPressRemote($phone_number);
                    $vicipresObj->setIpAddress($_SERVER['REMOTE_ADDR']);
                    $jsonMessage = $vicipresObj->send();
				}
			}
			/*end of allowed*/
		}
		else{
			die();
		}
        echo json_encode($jsonMessage);
	}
}
