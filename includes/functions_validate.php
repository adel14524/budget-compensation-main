<?php
function exists($data){
	if(empty($data)){
		return "Required";
	}else{
		return "Valid";
	}
}

function conditions1($data1){
	if($data1 === "Valid"){
		return "Passed";
	}else{
		return "Failed";
	}
}

function conditions2($data1, $data2){
	if($data1 === "Valid" && $data2 === "Valid"){
		return "Passed";
	}else{
		return "Failed";
	}
}

function conditions3($data1, $data2, $data3){
	if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid"){
		return "Passed";
	}else{
		return "Failed";
	}
}

function conditions4($data1, $data2, $data3, $data4){
	if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 === "Valid"){
		return "Passed";
	}else{
		return "Failed";
	}
}

function conditions5($data1, $data2, $data3, $data4, $data5){
	if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 === "Valid" && $data5 === "Valid"){
		return "Passed";
	}else{
		return "Failed";
	}
}

function conditions6($data1, $data2, $data3, $data4, $data5, $data6){
	if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 === "Valid" && $data5 === "Valid" && $data6 === "Valid"){
		return "Passed";
	}else{
		return "Failed";
	}
}

function conditions7($data1, $data2, $data3, $data4, $data5, $data6, $data7){
	if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 === "Valid" && $data5 === "Valid" && $data6 === "Valid" && $data7 === "Valid"){
		return "Passed";
	}else{
		return "Failed";
	}
}

function conditions8($data1, $data2, $data3, $data4, $data5, $data6, $data7, $data8){
	if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 === "Valid" && $data5 === "Valid" && $data6 === "Valid" && $data7 === "Valid" && $data8 === "Valid"){
		return "Passed";
	}else{
		return "Failed";
	}
}

function conditions9($data1, $data2, $data3, $data4, $data5, $data6, $data7, $data8, $data9){
	if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 === "Valid" && $data5 === "Valid" && $data6 === "Valid" && $data7 === "Valid" && $data8 === "Valid" && $data9 === "Valid"){
		return "Passed";
	}else{
		return "Failed";
	}
}

function conditions10($data1, $data2, $data3, $data4, $data5, $data6, $data7, $data8, $data9, $data10){
	if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 === "Valid" && $data5 === "Valid" && $data6 === "Valid" && $data7 === "Valid" && $data8 === "Valid" && $data9 === "Valid" $data10 === "Valid"){
		return "Passed";
	}else{
		return "Failed";
	}
}
?>