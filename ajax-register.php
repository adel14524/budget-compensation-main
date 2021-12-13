<?php
require_once 'core/init.php';
if(Input::exists()){
	$password = escape(Input::get('password'));
	$confirmpassword = escape(Input::get('confirmpassword'));
	$email = escape(Input::get('email'));
	$vkey = escape(Input::get('vkey'));

	function exists($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}

	function condition($data1, $data2){
		if($data1 === "Valid" && $data2 === "Valid"){
			return "Passed";
		}else{
			return "Failed";
		}
	}
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	$emailerror = exists($email);
	if($emailerror === "Valid"){
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  $emailerror = "Invalid email";
		}else{
			$emailerror = "Valid";
		}
	}

	$passworderror = exists($password);
	if($passworderror === "Valid"){
		if ((strlen($password) < 8 || strlen($password) > 16) || preg_match("/\s/", $password) || !preg_match("/\d/", $password) || !preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/\W/", $password)) {
		    $passworderror = "Password must contain [8-16] length, no space, [0-9] digit, [A-Z], [a-z] and special character";
		}
	}
	
	$confirmpassworderror = exists($confirmpassword);
	if($confirmpassworderror === "Valid"){
		if ((strlen($confirmpassword) < 8 || strlen($confirmpassword) > 16) || preg_match("/\s/", $confirmpassword) || !preg_match("/\d/", $confirmpassword) || !preg_match("/[A-Z]/", $confirmpassword) || !preg_match("/[a-z]/", $confirmpassword) || !preg_match("/\W/", $confirmpassword)) {
		    $passworderror = "Password must contain [8-16] length, no space, [0-9] digit, [A-Z], [a-z] and special character";
		}
	}
	if($passworderror === "Valid" && $confirmpassworderror === "Valid"){
		if($password != $confirmpassword){
			$confirmpassworderror = "Password not match!";
		}else{
			$confirmpassworderror = "Valid";
		}
	}

	$condition = condition($passworderror, $confirmpassworderror);

	if($condition === "Passed"){
		try {
			$user = new User();

			$userobject = $user->searchTwo(escape(Input::get('email')), escape(Input::get('vkey')));
		  	if($userobject){
		  		$userID = $userobject->userID;

		  		$salt = Hash::salt(32);

		  		$user->update(array(
		  			"password" => Hash::make($password, $salt),
		  			"salt" => $salt,
		  			"verified" => 1,
		  			"status" => "Active",
		  			"time" => date("Y-m-d H:i:s")
		  		), $userID, "userID");
		  		
		  		$array = [
					"condition" => $condition,
					"id" => $userID
				];
			}else{
				$array = [
					"condition" => $condition,
					"combination" => false
				];
			}
			

		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
	}elseif($condition === "Failed"){
		$array = [
			"password" => $passworderror,
			"confirmpassword" => $confirmpassworderror,
			"condition" => $condition,
			"email" => $email
		];
	}
	echo json_encode($array);
}
?>