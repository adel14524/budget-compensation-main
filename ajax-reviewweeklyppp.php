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
	$reviewweeklypppID = escape(Input::get('reviewweeklypppID'));
	$svreviewppp = escape(Input::get('svreviewppp'));
	$scheduleonetoone = escape(Input::get('scheduleonetoone'));
	

	function exists($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}

	function condition($data1){
		if($data1 === "Valid"){
			return "Passed";
		}else{
			return "Failed";
		}
	}

	function condition2($data1, $data2, $data3, $data4){
		if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 === "Valid"){
			return "Passed";
		}else{
			return "Failed";
		}
	}

	$svreviewppperror = exists($svreviewppp);

	if($scheduleonetoone === "true"){
		$scheduleooodateatppp = escape(Input::get('scheduleooodateatppp'));
		$scheduleoooduration = escape(Input::get('scheduleoooduration'));

		$scheduleonetoonedetail = escape(Input::get('scheduleonetoonedetail'));

		$scheduleooodateatppperror = exists($scheduleooodateatppp);
		if($scheduleooodateatppperror === "Valid"){
			$dateandtime = date("Y-m-d H:i:s", strtotime($scheduleooodateatppp));
			$now = date("Y-m-d H:i:s");
			if($now < $dateandtime){
				$scheduleooodateatppperror = "Valid";
			}else{
				$scheduleooodateatppperror = "Invalid";
			}
		}

		$scheduleooodurationerror = exists($scheduleoooduration);
		$scheduleonetoonedetailerror = exists($scheduleonetoonedetail);


		$condition = condition2($svreviewppperror, $scheduleooodateatppperror, $scheduleooodurationerror, $scheduleonetoonedetailerror);
		if($condition != "Passed"){
			$array2 = 
			[
				"condition" => $condition,
				"review" => $svreviewppperror,
				"schedule" => $scheduleonetoone,
				"date" => $scheduleooodateatppperror,
				"duration" => $scheduleooodurationerror,
				"detail" => $scheduleonetoonedetailerror
			];
		}
	}else{
		$condition = condition($svreviewppperror);
		if($condition != "Passed"){
			$array2 = 
			[
				"condition" => $condition,
				"schedule" => $scheduleonetoone,
				"review" => $svreviewppperror
			];
		}
	}

	if($condition === "Passed"){
		$PPPOOOobject = new Pppoooreport();
		$PPPOOOobject->updatePPP(array(
			"ppp_date_reviewed" => date('Y-m-d H:i:s'),
			"ppp_review" => $svreviewppp,
			"ppp_status" => "Reviewed"
		), $reviewweeklypppID, "ppp_ID");

		if($scheduleonetoone === "true"){
			$scheduleooodateatppp = date("Y-m-d H:i:s", strtotime($scheduleooodateatppp));
			$scheduleoootimeendatppp = date("Y-m-d H:i:s", strtotime("+".$scheduleoooduration." minutes", strtotime($scheduleooodateatppp)));
			$PPPOOOresult = $PPPOOOobject->searchOnlyPPP($reviewweeklypppID);
			$PPPOOOobject->addoneonone(array(
				"time" => $scheduleooodateatppp,
				"timeend" => $scheduleoootimeendatppp,
				"detail" => $scheduleonetoonedetail,
				"receiver_ID" => $PPPOOOresult->userID,
				"initiator_ID" => $PPPOOOresult->reviewerID,
				"status" => "Pending"
			));
		}
		$array2 = 
		[
			"condition" => $condition,
			"pppID" => $reviewweeklypppID
		];
	}

	echo json_encode($array2);
}
?>