<?php
require_once 'core/init.php';
if(Input::exists()){
	$requestbacksvID = escape(Input::get('requestbacksvID'));

	$svtraineeobject = new Svtrainee();
    $svtraineeobject->updatesvtraineerelationship(array(
    	"requestat" => date("Y-m-d H:i:s"),
        "replyat" => null,
        "status" => "Requested"
    ),$requestbacksvID ,"svtraineeapprovalID");

    $array = [
        "condition" => "Passed"
    ];

    echo json_encode($array);
}
?>
