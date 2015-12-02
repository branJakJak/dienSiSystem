<?php 
/**
* DataController
*/
class DataController extends CController
{
	public function actionIndex()
	{
		header("Content-Type: application/json");
		$allowedDispo = array("FISH","SCR","DNC","OPTOUT","5PRESS","5FLAT");
		$jsonMessage = array();

		if ( (  isset($_GET['dispo']) && !empty($_GET['dispo'])  )  && (  isset($_GET['phone_number']) && !empty($_GET['phone_number'])  ) ) {
			$status = $_GET['dispo'];
			$status = strtoupper($status);
			$phone_number = $_GET['phone_number'];
			/*in allowed dispo configuration*/
			if (  in_array($status, $allowedDispo)  ) {
				$newDncCopy = new NewViciCopySource();
				if ($status ===  "DNC") {
					$dncObj = new DNCViciRemote($phone_number);
                    $dncObj->setIpAddress($_SERVER['REMOTE_ADDR']);

                    if (isset($_GET['list_id'])) {
                    	$dncObj->setAdditionalParameters(array("source_id"=>$_GET['list_id']));
                    }

					$jsonMessage = $dncObj->send();
					$newDncCopy->send($phone_number);
				/*end of DNC */
				}else if ($status ===  "OPTOUT") {
					$optOutVici = new OptOutRecordVici($phone_number);

					if (isset($_GET['list_id'])) {
						$optOutVici->setAdditionalParameters(array("source_id"=>$_GET['list_id']));
					}					

                    $optOutVici->setIpAddress($_SERVER['REMOTE_ADDR']);
                    $jsonMessage = $optOutVici->send();
					/*end of optout dispo*/
				}else if ($status == "5PRESS") {
                    $vicipresObj = new ViciPressRemote($phone_number);

					if (isset($_GET['list_id'])) {
						$vicipresObj->setAdditionalParameters(array("source_id"=>$_GET['list_id']));
					}

                    $vicipresObj->setIpAddress($_SERVER['REMOTE_ADDR']);
                    $jsonMessage = $vicipresObj->send();
				}else if ($status == "SCR") {
					$dncObj = new DNCViciRemote($phone_number);
					if (isset($_GET['list_id'])) {
						$dncObj->setAdditionalParameters(array("source_id"=>$_GET['list_id']));
					}
                    $dncObj->setIpAddress($_SERVER['REMOTE_ADDR']);
					$jsonMessage = $dncObj->send();
					$newDncCopy->send($phone_number);
				}else if ($status == "5FLAT") {
					$fiveFlatRemoteObj = new FiveFlatRemote($phone_number);
					if (isset($_GET['list_id'])) {
						$fiveFlatRemoteObj->setAdditionalParameters(array("source_id"=>$_GET['list_id']));
					}
                    $fiveFlatRemoteObj->setIpAddress($_SERVER['REMOTE_ADDR']);
					$jsonMessage = $fiveFlatRemoteObj->send();
				}else if ($status == "5PPBA") {
					$pbavb6Obj = new PBAVB6($phone_number);
					if (isset($_GET['list_id'])) {
						$pbavb6Obj->setAdditionalParameters(array("source_id"=>$_GET['list_id']));
					}
                    $pbavb6Obj->setIpAddress($_SERVER['REMOTE_ADDR']);
					$jsonMessage = $pbavb6Obj->send();
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
