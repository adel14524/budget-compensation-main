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
	$monthlyplan = escape(Input::get('monthlyplan'));
	$monthlyplanID = escape(Input::get('monthlyplanID'));

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

	$monthlyplanerror = exists($monthlyplan);

	$condition = condition($monthlyplanerror);

	if($condition === "Passed"){
		$PPPOOOobject = new Pppoooreport();
		$PPPOOOobject->updateMonthlyPlan(array(
			"ppp_monthly_plan" => $monthlyplan
		), $monthlyplanID, "ppp_monthly_ID");
		$array = [
			"monthlyplan" => $monthlyplanerror,
			"condition" => $condition
		];
	}else{
		$array = [
			"monthlyplan" => $monthlyplanerror,
			"condition" => $condition
		];
	}
	echo json_encode($array);
	
}
?>