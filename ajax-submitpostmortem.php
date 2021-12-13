<?php
require_once 'core/init.php';
if(Input::exists()){
	$replypostmortemID = escape(Input::get('replypostmortemID'));
	$replypostmortemreply = escape(Input::get('replypostmortemreply'));

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

	$replypostmortemreplyerror = exists($replypostmortemreply);

	$condition = condition($replypostmortemreplyerror);
	if($condition === "Passed"){
		try {
			$ppp121report = new Ppp121report();
			$ppp121report->replyPostmortem(array(
				"reply" => $replypostmortemreply,
				"status" => "Replied",
				"submitat" => date("Y-m-d H:i:s")
			),$replypostmortemID, "postmortemID");
			$array = [
				"reply" => $replypostmortemreplyerror,
				"condition" => $condition
			];
		} catch (Exception $e) {
			
		}
	}else{
		$array = [
			"reply" => $replypostmortemreplyerror,
			"condition" => $condition
		];
	}
	echo json_encode($array);
}
?>