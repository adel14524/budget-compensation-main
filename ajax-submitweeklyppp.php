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
	$submitpppID = escape(Input::get('submitpppID'));
	$svquestionnum = escape(Input::get('svquestionnum'));
	$submitpppsummary = escape(Input::get('submitpppsummary'));
	$submitpppchallenge = escape(Input::get('submitpppchallenge'));
	$array = [];
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

	$submitpppsummaryerror = exists($submitpppsummary);
	$array["summary"] = $submitpppsummaryerror;
	$submitpppchallengeerror = exists($submitpppchallenge);
	$array["challenge"] = $submitpppchallengeerror;
	$questionreplyerror = [];
	if($svquestionnum != 0){
		for ($i=1; $i <= $svquestionnum; $i++) { 
			$svquestion[$i] = escape(Input::get('svquestion'.$i));
			$svquestionreply[$i] = escape(Input::get('svquestionreply'.$i));
			$svquestionreplyerror[$i] = exists($svquestionreply[$i]);
			$array["reply".$i] = $svquestionreplyerror[$i];
			$questionreplyerror[$i] = $svquestionreplyerror[$i];
		}
		if (in_array("Required", $array)){
			$allquestionreplyerror = "Invalid";
		}else{
			$allquestionreplyerror = "Valid";
		}

	}else{
		$allquestionreplyerror = "Valid";
	}

	$array["num"] = $svquestionnum;

	$condition = condition($submitpppsummaryerror, $submitpppchallengeerror, $allquestionreplyerror);
	$array["condition"] = $condition;

	$array["pppID"] = $submitpppID;
	if($condition === "Passed"){
		$PPPOOOobject = new Pppoooreport();
		$PPPOOOobject->submitWeeklyPPP(array(
			"ppp_date_submitted" => date('Y-m-d H:i:s'),
			"weeklysummary" => $submitpppsummary,
			"weeklychallenges" => $submitpppchallenge,
			"ppp_status" => "Submitted"
		), $submitpppID, "ppp_ID");

		if($svquestionnum != 0){
			for ($i=1; $i <= $svquestionnum; $i++) { 
				$PPPOOOobject->addPPPSVQuestionreply(array(
					"p_question_ask" => $svquestion[$i],
					"p_question_reply" => $svquestionreply[$i],
					"ppp_ID" => $submitpppID
				));
			}
		}
		
	}


	echo json_encode($array);
}
?>