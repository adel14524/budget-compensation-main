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
	function exists($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}

	function condition($data1, $data2, $data3, $data4, $data5, $data6, $data7, $data8){
		if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 === "Valid" && $data5 === "Valid" && $data6 === "Valid" && $data7 === "Valid" && $data8 === "Valid"){
			return "Passed";
		}else{
			return "Failed";
		}
	}

	function condition1($data1, $data2, $data3, $data4, $data5, $data6){
		if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 === "Valid" && $data5 === "Valid" && $data6 === "Valid"){
			return "Passed";
		}else{
			return "Failed";
		}
	}


	$selectsupervisor = escape(Input::get('selectsupervisor'));
	$ppp121opt = escape(Input::get('ppp121opt'));
	$selectreporttimeframe = escape(Input::get('selectreporttimeframe'));

	$selectsupervisorerror = exists($selectsupervisor);
	if($selectsupervisorerror === "Valid" && ($ppp121opt === "PPP" || $ppp121opt === "1to1")){
		$ppp121opteerror = "Valid";
		$selectreporttimeframeerror = exists($selectreporttimeframe);
		if($selectreporttimeframeerror === "Valid"){
			$ppp121reportobject1 = new Ppp121report();
			if($ppp121opt === "PPP"){
				if($selectreporttimeframe === "Daily"){
				 $ppp121reportresult1 = $ppp121reportobject1->searchPPPtraineeOnetimeframe($resultresult->userID, $selectsupervisor, date("Y-m-d"), $selectreporttimeframe);
				 if($ppp121reportresult1){
				 	$selectreporttimeframeerror = "You already submitted the PPP report for today";
				 }else{
				 	$selectreporttimeframeerror = "Valid";
				 }
				}elseif($selectreporttimeframe === "Weekly"){
				 $ppp121reportresult1 = $ppp121reportobject1->searchPPPtraineeTwotimeframe($resultresult->userID, $selectsupervisor, date('Y-m-d', strtotime('monday this week')), date('Y-m-d', strtotime('sunday this week')), $selectreporttimeframe);
				 if($ppp121reportresult1){
				 	$selectreporttimeframeerror = "You already submitted the PPP report for this week";
				 }else{
				 	$selectreporttimeframeerror = "Valid";
				 }
				}elseif($selectreporttimeframe === "Monthly"){
				 $ppp121reportresult1 = $ppp121reportobject1->searchPPPtraineeTwotimeframe($resultresult->userID, $selectsupervisor, date('Y-m-d', strtotime('first day of this month')), date('Y-m-d', strtotime('last day of this month')), $selectreporttimeframe);
				 if($ppp121reportresult1){
				 	$selectreporttimeframeerror = "You already submitted the PPP report for this month";
				 }else{
				 	$selectreporttimeframeerror = "Valid";
				 }
				}elseif($selectreporttimeframe === "Quarterly"){
					$month = date("m");
					if($month >= 1 && $month <= 3){
						$firstdate = date('Y-01-01');
						$lastdate = date('Y-03-31');
					}elseif($month >= 4 && $month <= 6){
						$firstdate = date('Y-04-01');
						$lastdate = date('Y-06-30');
					}elseif($month >= 7 && $month <= 9){
						$firstdate = date('Y-07-01');
						$lastdate = date('Y-09-30');
					}elseif($month >= 10 && $month <= 12){
						$firstdate = date('Y-10-01');
						$lastdate = date('Y-12-31');
					}

				 $ppp121reportresult1 = $ppp121reportobject1->searchPPPtraineeTwotimeframe($resultresult->userID, $selectsupervisor, $firstdate, $lastdate, $selectreporttimeframe);
				 if($ppp121reportresult1){
				 	$selectreporttimeframeerror = "You already submitted the PPP report for this quarter";
				 }else{
				 	$selectreporttimeframeerror = "Valid";
				 }
				}
			}elseif($ppp121opt === "1to1"){
				if($selectreporttimeframe === "Daily"){
					$ppp121reportresult1 = $ppp121reportobject1->search121traineeOnetimeframe($resultresult->userID, $selectsupervisor, date("Y-m-d"), $selectreporttimeframe);
					if($ppp121reportresult1){
					 	$selectreporttimeframeerror = "You already submitted the 1 to 1 report for today";
					}else{
					 	$selectreporttimeframeerror = "Valid";
					}
				}elseif($selectreporttimeframe === "Weekly"){
					$ppp121reportresult1 = $ppp121reportobject1->search121traineeTwotimeframe($resultresult->userID, $selectsupervisor, date('Y-m-d', strtotime('monday this week')), date('Y-m-d', strtotime('sunday this week')), $selectreporttimeframe);
					if($ppp121reportresult1){
					 	$selectreporttimeframeerror = "You already submitted the 1 to 1 report for this week";
					}else{
					 	$selectreporttimeframeerror = "Valid";
					}
				}elseif($selectreporttimeframe === "Monthly"){
					$ppp121reportresult1 = $ppp121reportobject1->search121traineeTwotimeframe($resultresult->userID, $selectsupervisor, date('Y-m-d', strtotime('first day of this month')), date('Y-m-d', strtotime('last day of this month')), $selectreporttimeframe);
					if($ppp121reportresult1){
					 	$selectreporttimeframeerror = "You already submitted the 1 to 1 report for this month";
					}else{
					 	$selectreporttimeframeerror = "Valid";
					}
				}elseif($selectreporttimeframe === "Quarterly"){
					$month = date("m");
					if($month >= 1 && $month <= 3){
						$firstdate = date('Y-01-01');
						$lastdate = date('Y-03-31');
					}elseif($month >= 4 && $month <= 6){
						$firstdate = date('Y-04-01');
						$lastdate = date('Y-06-30');
					}elseif($month >= 7 && $month <= 9){
						$firstdate = date('Y-07-01');
						$lastdate = date('Y-09-30');
					}elseif($month >= 10 && $month <= 12){
						$firstdate = date('Y-10-01');
						$lastdate = date('Y-12-31');
					}
					$ppp121reportresult1 = $ppp121reportobject1->search121traineeTwotimeframe($resultresult->userID, $selectsupervisor, $firstdate, $lastdate, $selectreporttimeframe);
					if($ppp121reportresult1){
					 	$selectreporttimeframeerror = "You already submitted the 1 to 1 report for this quarter";
					}else{
					 	$selectreporttimeframeerror = "Valid";
					}
				}
			}
			
		}
	}else{
		$ppp121opteerror = "Required";
		$selectreporttimeframeerror = "";
	}
	
	if($ppp121opt === "1to1"){
		$submit121method = escape(Input::get('submit121method'));
		$submit121methoderror = exists($submit121method);
		$submit121date = escape(Input::get('submit121date'));
		$submit121dateerror = exists($submit121date);
	}else{
		$submit121methoderror = "";
		$submit121dateerror = "";
	}
	

	$selectprogresstemplate = escape(Input::get('selectprogresstemplate'));
	if($selectprogresstemplate === "Default"){
		$submitreportprogresstextarea = escape(Input::get('submitreportprogresstextarea'));
		$submitreportprogresstextareaerror = exists($submitreportprogresstextarea);
		$progressvalueerror = "";
		$progressnum = "";
		if($submitreportprogresstextareaerror === "Valid"){
			$progresscondition = "Valid";
		}else{
			$progresscondition = "Required";
		}
	}else{
		$submitreportprogresstextarea = escape(Input::get('submitreportprogresstextarea'));
		$submitreportprogresstextareaerror = exists($submitreportprogresstextarea);
		$progressnum = escape(Input::get('progressnum'));
		$progressdescription = [];
		$progressvalue = [];
		$progressvalueerror = [];
		for ($i=1; $i <= $progressnum; $i++) { 
			$progressdescription[$i] = escape(Input::get('progressdescription'.$i));
			$progressvalue[$i] = escape(Input::get('progressvalue'.$i));
			$progressvalueerror[$i] = exists($progressvalue[$i]);
		}
		if (in_array("Required", $progressvalueerror)){
			$progresscondition = "Invalid";
		}else{
			$progresscondition = "Valid";
		}
	}

	$selectproblemtemplate = escape(Input::get('selectproblemtemplate'));
	if($selectproblemtemplate === "Default"){
		$submitreportproblemtextarea = escape(Input::get('submitreportproblemtextarea'));
		$submitreportproblemtextareaerror = exists($submitreportproblemtextarea);
		$problemvalueerror = "";
		$problemnum = "";
		if($submitreportproblemtextareaerror === "Valid"){
			$problemcondition = "Valid";
		}else{
			$problemcondition = "Required";
		}
	}else{
		$submitreportproblemtextarea = escape(Input::get('submitreportproblemtextarea'));
		$submitreportproblemtextareaerror = exists($submitreportproblemtextarea);
		$problemnum = escape(Input::get('problemnum'));
		$problemdescription = [];
		$problemvalue = [];
		$problemvalueerror = [];
		for ($i=1; $i <= $problemnum; $i++) { 
			$problemdescription[$i] = escape(Input::get('problemdescription'.$i));
			$problemvalue[$i] = escape(Input::get('problemvalue'.$i));
			$problemvalueerror[$i] = exists($problemvalue[$i]);
		}
		if (in_array("Required", $problemvalueerror)){
			$problemcondition = "Invalid";
		}else{
			$problemcondition = "Valid";
		}
	}

	$selectnextplantemplate = escape(Input::get('selectnextplantemplate'));
	if($selectnextplantemplate === "Default"){
		$submitreportnextplantextarea = escape(Input::get('submitreportnextplantextarea'));
		$submitreportnextplantextareaerror = exists($submitreportnextplantextarea);
		$planvalueerror = "";
		$plannum = "";
		if($submitreportnextplantextareaerror === "Valid"){
			$plancondition = "Valid";
		}else{
			$plancondition = "Required";
		}
	}else{
		$submitreportnextplantextarea = escape(Input::get('submitreportnextplantextarea'));
		$submitreportnextplantextareaerror = exists($submitreportnextplantextarea);
		$plannum = escape(Input::get('plannum'));
		$plandescription = [];
		$planvalue = [];
		$planvalueerror = [];
		for ($i=1; $i <= $plannum; $i++) { 
			$plandescription[$i] = escape(Input::get('plandescription'.$i));
			$planvalue[$i] = escape(Input::get('planvalue'.$i));
			$planvalueerror[$i] = exists($planvalue[$i]);
		}
		if (in_array("Required", $planvalueerror)){
			$plancondition = "Invalid";
		}else{
			$plancondition = "Valid";
		}
	}

	if($ppp121opt === "1to1"){
		$condition = condition($selectsupervisorerror, $ppp121opteerror, $selectreporttimeframeerror, $progresscondition, $problemcondition, $plancondition, $submit121methoderror, $submit121dateerror);
	}else{
		$condition = condition1($selectsupervisorerror, $ppp121opteerror, $selectreporttimeframeerror, $progresscondition, $problemcondition, $plancondition);
	}

	if($condition === "Passed"){
		try {
			$ppp121reportobject = new Ppp121report();
			if($ppp121opt === "1to1"){
				$pppid = "";
				$ppp121reportobject->submit121(array(
					"timeframe" => $selectreporttimeframe,
					"submitat" => date("Y-m-d H:i:s"),
					"userID" => $resultresult->userID,
					"supervisorID" => $selectsupervisor,
					"status" => "Submitted",
					"progress" => $submitreportprogresstextarea,
					"problem" => $submitreportproblemtextarea,
					"nextplan" => $submitreportnextplantextarea,
					"method" => $submit121method,
					"dateat" => $submit121date
				));
				$onetooneid = $ppp121reportobject->lastinsertid();

				if($selectprogresstemplate != "Default"){
					for ($i=1; $i <= $progressnum; $i++) { 
						$ppp121reportobject->submit121templatecat(array(
							"type" => "progress",
							"catdescription" => $progressdescription[$i],
							"121ID" => $onetooneid,
							"Description" => $progressvalue[$i]
						));
					}
				}

				if($selectproblemtemplate != "Default"){
					for ($i=1; $i <= $problemnum; $i++) { 
						$ppp121reportobject->submit121templatecat(array(
							"type" => "problem",
							"catdescription" => $problemdescription[$i],
							"121ID" => $onetooneid,
							"Description" => $problemvalue[$i]
						));
					}
				}

				if($selectnextplantemplate != "Default"){
					for ($i=1; $i <= $plannum; $i++) { 
						$ppp121reportobject->submit121templatecat(array(
							"type" => "problem",
							"catdescription" => $plandescription[$i],
							"121ID" => $onetooneid,
							"Description" => $planvalue[$i]
						));
					}
				}
			}else{
				$onetooneid = "";
				$ppp121reportobject->submitPPP(array(
					"timeframe" => $selectreporttimeframe,
					"submitat" => date("Y-m-d H:i:s"),
					"userID" => $resultresult->userID,
					"supervisorID" => $selectsupervisor,
					"status" => "Submitted",
					"progress" => $submitreportprogresstextarea,
					"problem" => $submitreportproblemtextarea,
					"nextplan" => $submitreportnextplantextarea
				));
				$pppid = $ppp121reportobject->lastinsertid();

				if($selectprogresstemplate != "Default"){
					for ($i=1; $i <= $progressnum; $i++) { 
						$ppp121reportobject->submitPPPtemplatecat(array(
							"type" => "progress",
							"catdescription" => $progressdescription[$i],
							"pppID" => $pppid,
							"Description" => $progressvalue[$i]
						));
					}
				}

				if($selectproblemtemplate != "Default"){
					for ($i=1; $i <= $problemnum; $i++) { 
						$ppp121reportobject->submitPPPtemplatecat(array(
							"type" => "problem",
							"catdescription" => $problemdescription[$i],
							"pppID" => $pppid,
							"Description" => $problemvalue[$i]
						));
					}
				}

				if($selectnextplantemplate != "Default"){
					for ($i=1; $i <= $plannum; $i++) { 
						$ppp121reportobject->submitPPPtemplatecat(array(
							"type" => "plan",
							"catdescription" => $plandescription[$i],
							"pppID" => $pppid,
							"Description" => $planvalue[$i]
						));
					}
				}
			}
			$array = [
				"supervisor" => $selectsupervisorerror,
				"ppp121opt" => $ppp121opteerror,
				"timeframe" => $selectreporttimeframeerror,
				"progress" => $submitreportprogresstextareaerror,
				"problem" => $submitreportproblemtextareaerror,
				"plan" => $submitreportnextplantextareaerror,
				"method" => $submit121methoderror,
				"date" => $submit121dateerror,
				"tprogress" => $progressvalueerror,
				"tprogressnum" => $progressnum,
				"tproblem" => $problemvalueerror,
				"tproblemnum" => $problemnum,
				"tplan" => $planvalueerror,
				"tplannum" => $plannum,
				"condition" => $condition,
				"onetooneid" => $onetooneid,
				"pppid" => $pppid,
				"type" => $ppp121opt 

			];
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}else{
		$array = [
			"supervisor" => $selectsupervisorerror,
			"ppp121opt" => $ppp121opteerror,
			"timeframe" => $selectreporttimeframeerror,
			"progress" => $submitreportprogresstextareaerror,
			"problem" => $submitreportproblemtextareaerror,
			"plan" => $submitreportnextplantextareaerror,
			"method" => $submit121methoderror,
			"date" => $submit121dateerror,
			"tprogress" => $progressvalueerror,
			"tprogressnum" => $progressnum,
			"tproblem" => $problemvalueerror,
			"tproblemnum" => $problemnum,
			"tplan" => $planvalueerror,
			"tplannum" => $plannum,
			"condition" => $condition,
			"progresscondition" => $progresscondition,
			"problemcondition" => $problemcondition,
			"plancondition" => $plancondition

		];
	}

	
	echo json_encode($array);
}
?>