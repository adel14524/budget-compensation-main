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
	$updatekeyresultprogressID = escape(Input::get('updatesctivitiesprogressID'));
	$keyresultprogress = escape(Input::get('updateactivityprogress'));
	$KRdescribe = escape(Input::get('activitiesdescribe'));
	$confidencelevel = escape(Input::get('confidencelevelDA'));
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
	$keyresultprogresserror = exists($keyresultprogress);
	if($keyresultprogresserror === "Valid"){
		$keyresultprogress = round($keyresultprogress, 2);
		$keyresultobject = new Activities();
	 	$data = $keyresultobject->searchOnlyActivities($updatekeyresultprogressID);
		if($data){
			if($data->endvalue > $data->startvalue){
				if($keyresultprogress > $data->startvalue) {
					$keyresultprogresserror = "Valid";
				}else{
					$keyresultprogresserror = "Must between start and endvalue";
				}
			}else{
				if($keyresultprogress < $data->startvalue) {
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
			
			$keyresultobject = new Activities();
			$keyresultobject->updateActivities(array(
				'progress' => $keyresultprogress,
				"confidence" => $confidencelevel
			), $updatekeyresultprogressID, "activitiesID");

			$objectiveobject = new Objective();
			$objectiveobject->addObjectiveLog(array(
				"objectiveID" => $data->objectiveID,
				"timestamp" => date('Y-m-d H:i:s'),
				"description" => $resultresult->firstname." ".$resultresult->lastname." update Doer Action '".$data->activities."' progress from ".number_format($data->progress,0).$data->metric." to ".$keyresultprogress.$data->metric." with Description <br>'".$KRdescribe."'"
			));

			$keyresultobject->addActivitiesLog(array(
				'activitiesID' => $updatekeyresultprogressID,
				'latestvalue' => $keyresultprogress,
				'type' => $type,
				'different' => $different,
				'description' => $KRdescribe,
				'date' => date('Y-m-d H:i:s'),
				'objectiveID' => $data->objectiveID
			));
			$array = [
				"condition" => $condition
			];
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
	}elseif($condition === "Failed"){
		$array = [
			"progress" => $keyresultprogresserror,
			"description" => $KRdescribeerror,
			"confidence" => $confidencelevelerror,
			"condition" => $condition
		];
	}
	echo json_encode($array);
}
?>