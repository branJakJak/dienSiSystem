<?php 
/**
* DataController
*/
class DataController extends CController
{
	public function actionIndex()
	{
		header("Content-Type: application/json");
		$allowedDispo = array("FISH","SCR","DNC","OPTOUT","5PRESS","5FLAT","5PPBA","5PRDM","5BAZ","5PDLY","5PLB","5PG");
		$sendToSpreadsheetDispo = array("5PG");
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
				}else if ($status == "5PRDM") {
					$prd5 = new PRDM5($phone_number);
					if (isset($_GET['list_id'])) {
						$prd5->setAdditionalParameters(array("source_id"=>$_GET['list_id']));
					}
                    $prd5->setIpAddress($_SERVER['REMOTE_ADDR']);
					$jsonMessage = $prd5->send();
				}else if ($status == "5BAZ") {
					$prd5 = new Baz5($phone_number);
					if (isset($_GET['list_id'])) {
						$prd5->setAdditionalParameters(array("source_id"=>$_GET['list_id']));
					}
                    $prd5->setIpAddress($_SERVER['REMOTE_ADDR']);
					$jsonMessage = $prd5->send();
				}else if (  $status == "5PDLY"  ) {
					$pdly = new Pdly5($phone_number);
					if (isset($_GET['list_id'])) {
						$pdly->setAdditionalParameters(array("source_id"=>$_GET['list_id']));
					}
                    $pdly->setIpAddress($_SERVER['REMOTE_ADDR']);
					$jsonMessage = $pdly->send();
				}else if (  $status == "5PLB"  ) {
					$plb = new Plbd5($phone_number);
					if (isset($_GET['list_id'])) {
						$plb->setAdditionalParameters(array("source_id"=>$_GET['list_id']));
					}
                    $plb->setIpAddress($_SERVER['REMOTE_ADDR']);
					$jsonMessage = $plb->send();
				}
			}
			/*end of allowed*/
			if (in_array($status, $sendToSpreadsheetDispo)) {
				//if in array of send to spreadsheet
				//send mail
				$mail = new PHPMailer(); // create a new object
				$mail->IsSMTP(); // enable SMTP
				$mail->SMTPDebug = 3; // debugging: 1 = errors and messages, 2 = messages only
				$mail->SMTPAuth = true; // authentication enabled
				$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
				$mail->Host = "smtp.gmail.com";
				$mail->Port = 465; // or 587
				$mail->IsHTML(true);
				$mail->Username = "infoConsultancyTeam@gmail.com";
				$mail->Password = "Newuser123!";
				$mail->SetFrom("infoConsultancyTeam@gmail.com");
				$mail->Subject = "5PF and DELAY8";
				$mail->Body = $phone_number;
				$mail->AddAddress("infoConsultancyTeam@gmail.com");
				 if(!$mail->Send()) {
					$jsonMessage = array(
						"status"=>"failed",
						"description"=>$mail->ErrorInfo,
					);
				 } else {
					$jsonMessage = array(
						"status"=>"ok",
						"description"=>"Phone number sent.",
					);				 	
				 }
			}
		}//end of if requrest is vaild
		else{
			die();
		}
        echo json_encode($jsonMessage);
	}
}
