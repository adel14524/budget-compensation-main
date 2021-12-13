<?php
require_once 'core/init.php';
if(Input::exists()){
	$email = Input::get('email');
	$password = Input::get('password');
	$remember = Input::get('remember');

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

	$emailerror = exists($email);
	if($emailerror === "Valid"){
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  $emailerror = "Invalid email";
		}else{
			$emailerror = "Valid";
		}
	}

	$passworderror = exists($password);

	$condition = condition($emailerror, $passworderror);

	if($condition === "Passed"){
		try {
			$loginuser = new User();
			$loginresult = $loginuser->login($email, $password, $remember);
			if($loginresult){
				$result = $loginuser->searchOnly($email);
				if($result){
					$resultemail = $result->email;
					$superadmin = $result->superadmin;
					$userID = $result->userID;
					$corporateID = $result->corporateID;
					$companyID = $result->companyID;
				}
				if($corporateID){
					$logresult = $loginuser->checkLogInbefore($userID, date('Y-m-d'));
					if($logresult == false){
						$loginuser->insertlog(array(
							'userID' => $userID,
							'corporateID' => $corporateID,
							'companyID' => null,
							'datetime' => date('Y-m-d'),
							'time' => date('H:i:s')
						));
					}
					
				}else{
					$logresult = $loginuser->checkLogInbefore($userID, date('Y-m-d'));
					if($logresult == false){
						$loginuser->insertlog(array(
							'userID' => $userID,
							'corporateID' => null,
							'companyID' => $companyID,
							'datetime' => date('Y-m-d'),
							'time' => date('H:i:s')

						));
					}
					
				}
				
				if($superadmin == true){
					$link = "superadmin.php";
				}else{
					$link = "home-dashboard.php";
				}
				
				$array = [
					"condition" => $condition,
					"email" => $resultemail,
					"link" => $link,
					"log" => $logresult
				];
			}else{
				$array = [
					"combination" => 
					"
					<div class='alert alert-danger alert-dismissible'>
				        <button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Combination not found</strong>
				    </div>
					",
					"condition" => $condition
				];
			}

		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
	}elseif($condition === "Failed"){
		$array = [
			"email" => $emailerror,
			"password" => $passworderror,
			"condition" => $condition
		];
	}
	echo json_encode($array);
}
?>