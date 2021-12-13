<?php
require_once 'core/init.php';
$user = new User();
if(!$user->isLoggedIn()){
  Redirect::to("login.php");
}else{
  $resultresult = $user->data();
  $userlevel = $resultresult->role;
  if($resultresult->verified == false || $resultresult->superadmin == true){
    $user->logout();
    Redirect::to("login.php?error=error");
  }
}
if(Input::exists()){
	$pppattachokrID = escape(Input::get('pppattachokrID'));
	$updatekeyresultprogressID = escape(Input::get('updatekeyresultprogressIDatPPP'));
	$keyresultprogress = escape(Input::get('updatekeyresultprogressatPPP'));
	$confidencelevel = escape(Input::get('confidencelevelatPPP'));
	$KRdescribe = escape(Input::get('KRdescribeatPPP'));
	$keyresultprogressobjectiveID = escape(Input::get('keyresultprogressobjectiveIDatPPP'));
	$pppID = escape(Input::get('attackokrpppID'));
	$userID = $resultresult->userID;

	function exists($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}

	function condition($data1, $data2, $data3){
		if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid"){
			return "Passed";
		}else{
			return "Failed";
		}
	}

	if($keyresultprogress === "0"){
		$keyresultprogress = 0;
		$keyresultprogresserror = "Valid";
	}else{
		$keyresultprogresserror = exists($keyresultprogress);
	}

	if($keyresultprogresserror === "Valid"){
		$keyresultprogress = round($keyresultprogress, 2);
		$keyresultobject = new Keyresult();
	 	$data = $keyresultobject->searchOnlyKeyresult($updatekeyresultprogressID);
		if($data){
			if($data->endvalue > $data->startvalue){
				if($keyresultprogress >= $data->startvalue && $keyresultprogress <= $data->endvalue) {
					$keyresultprogresserror = "Valid";
				}else{
					$keyresultprogresserror = "Must between start and endvalue";
				}
			}else{
				if($keyresultprogress <= $data->startvalue && $keyresultprogress >= $data->endvalue) {
					$keyresultprogresserror = "Valid";
				}else{
					$keyresultprogresserror = "Must between start and endvalue";
				}
			}
		}else{
			$keyresultprogresserror = "Not Valid";
		}
	}

	$allconfidence = array("high", "medium", "low");
	$confidencelevelerror = exists($confidencelevel);
	if($confidencelevelerror === "Valid"){
		if (in_array($confidencelevel, $allconfidence)){
			$confidencelevelerror = "Valid";
		}else{
			$confidencelevelerror = "Invalid";
		}
	}

	$KRdescribeerror = exists($KRdescribe);
	$condition = condition($keyresultprogresserror, $KRdescribeerror, $confidencelevelerror);

	$different = round((($keyresultprogress/$data->endvalue)*100) - (($data->progress/$data->endvalue)*100));
	if($different > 0){
		$type = "increase";
	}elseif($different < 0){
		$type = "decrease";
		$different = -($different);
	}else{
		$type = "same";
		$different = 0;
	}




	if($condition === "Passed"){
		try {
			$loguser = new User();
			$userdetail = $loguser->searchOnly($userID);
			if ($userdetail) {
				if($userdetail->corporateID){
					$logresult = $loguser->checkUpdatebefore($userID, date('Y-m-d'));
					if($logresult == false){
						$loguser->insertlog2(array(
							'userID' => $userID,
							'corporateID' => $userdetail->corporateID,
							'companyID' => null,
							'datetime' => date('Y-m-d'),
							'time' => date('H:i:s')
						));
					}
				}else{
					$logresult = $loguser->checkUpdatebefore($userID, date('Y-m-d'));
					if($logresult == false){
						$loguser->insertlog2(array(
							'userID' => $userID,
							'corporateID' => null,
							'companyID' => $userdetail->companyID,
							'datetime' => date('Y-m-d'),
							'time' => date('H:i:s')
						));
					}
				}
			}

			$keyresultobject = new Keyresult();
			$keyresultobject->updateKeyresult(array(
				'progress' => $keyresultprogress,
				"confidence" => $confidencelevel
			), $updatekeyresultprogressID, "keyresultID");

			$objectiveobject = new Objective();
			$objectiveobject->addObjectiveLog(array(
				"objectiveID" => $keyresultprogressobjectiveID,
				"timestamp" => date('Y-m-d H:i:s'),
				"description" => $resultresult->firstname." ".$resultresult->lastname." update Key Result '".$data->keyresult."' progress from ".number_format($data->progress,0).$data->metric." to ".$keyresultprogress.$data->metric. " with Description <br>'".$KRdescribe."'"
			));

			

			$keyresultobject->addKeyresultLog(array(
				'keyresultID' => $updatekeyresultprogressID,
				'latestvalue' => $keyresultprogress,
				'type' => $type,
				'different' => $different,
				'description' => $KRdescribe,
				'date' => date('Y-m-d H:i:s'),
				'objectiveID' => $keyresultprogressobjectiveID
			));

			$id = $keyresultobject->lastinsertid();
			$PPPOOOobject = new Pppoooreport();
			if($pppattachokrID){
				$PPPOOOobject->updatePPPOKRAttach(array(
					"kr_log_ID" => $id
				), $pppattachokrID, "p_ppp_okr_ID");
			}else{
				$PPPOOOobject->addAttachOKR(array(
					"ppp_ID" => $pppID,
					"okr_ID" => $keyresultprogressobjectiveID,
					"kr_ID" => $updatekeyresultprogressID,
					"kr_log_ID" => $id
				));
			}
			

			$array = [
				"condition" => $condition,
				"pppID" => $pppID
			];
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
	}elseif($condition === "Failed"){
		$array = [
			"updatekeyresultprogressatPPP" => $keyresultprogresserror,
			"confidencelevelatPPP" => $confidencelevelerror,
			"KRdescribeatPPP" => $KRdescribeerror
		];
	}
	echo json_encode($array);
}
?>