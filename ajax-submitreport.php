<?php
require_once 'core/init.php';
if(Input::exists()){
	$submitreportweek = escape(Input::get('submitreportweek'));
	$submitreportyear = escape(Input::get('submitreportyear'));
	$submitreportuserID = escape(Input::get('submitreportuserID'));
	$submitreportyoursupervisor = escape(Input::get('submitreportyoursupervisor'));
	$submitreportcorporateID = escape(Input::get('submitreportcorporateID'));
	$submitreportcompanyID = escape(Input::get('submitreportcompanyID'));
	$submitreportprogress = escape(Input::get('submitreportprogress'));
	$submitreportproblem = escape(Input::get('submitreportproblem'));
	$submitreportplan = escape(Input::get('submitreportplan'));

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

	if($submitreportcorporateID){
		$submitreportcorporateID = $submitreportcorporateID;
	}else{
		$submitreportcorporateID = null;
	}

	if($submitreportcompanyID){
		$submitreportcompanyID = $submitreportcompanyID;
	}else{
		$submitreportcompanyID = null;
	}

	$submitreportprogresserror = exists($submitreportprogress);
	$submitreportproblemerror = exists($submitreportproblem);
	$submitreportplanerror = exists($submitreportplan);

	$condition = condition($submitreportplanerror, $submitreportproblemerror, $submitreportprogresserror);

	if($condition === "Passed"){
		try{
			$reportobject = new Report();
			$reportobject->submitReport(array(
				"userID" => $submitreportuserID,
				"corporateID" => $submitreportcorporateID,
				"companyID" => $submitreportcompanyID,
				"tosupervisor" => $submitreportyoursupervisor,
				"week" => $submitreportweek,
				"year" => $submitreportyear,
				"progress" => $submitreportprogress,
				"problem" => $submitreportproblem,
				"nextweekplan" => $submitreportplan,
				"supervisorevaluate" => "Pending",
				"submitat" => date('Y-m-d H:i:s')
			));
			$array = [
		    	"condition" => $condition
			];
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}else{
		$array = [
	    	"condition" => $condition,
	    	"problem" => $submitreportproblemerror,
	    	"plan" => $submitreportplanerror,
	    	"progress" => $submitreportprogresserror
		];
	}
    

	echo json_encode($array);
}
?>