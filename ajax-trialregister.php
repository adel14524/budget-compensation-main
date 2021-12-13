<?php
require_once 'core/init.php';
if(Input::exists()){
  $firstname = escape(Input::get('firstname'));
  $lastname = escape(Input::get('firstname'));
  $email = escape(Input::get('trialemail'));
  $companyname = escape(Input::get('trialcompanyname'));

  function exists($data){
    if(empty($data)){
      return "Required";
    }else{
      return "Valid";
    }
  }

  function condition($data1, $data2, $data3, $data4){
    if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 === "Valid"){
      return "Passed";
    }else{
      return "Failed";
    }
  }

  $firstnameerror = exists($firstname);
  if($firstnameerror === "Valid"){
    if (!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
      $firstnameerror = "Only letters and white space allowed";
    }else{
      $firstnameerror = "Valid";
    }
  }
  $lastnameerror = exists($lastname);
  if($lastnameerror === "Valid"){
    if (!preg_match("/^[a-zA-Z ]*$/", $lastname)) {
      $lastnameerror = "Only letters and white space allowed";
    }else{
      $lastnameerror = "Valid";
    }
  }
  $email = filter_var($email, FILTER_SANITIZE_EMAIL);
  $emailerror = exists($email);
  if($emailerror === "Valid"){
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailerror = "Invalid email";
    }else{
      $emailerror = "Valid";
      $checkuser = new User();
      $userdata = $checkuser->find($email);
      if($userdata == true){
        $emailerror = "This Email owner is registered user";
      }else{
        $emailerror = "Valid";
        $userinvitedemail = $checkuser->searchinviteduseremailduplicate($email);
        if($userinvitedemail){
          $emailerror = "Valid";
          $userobject = new User();
          $userobject->updateinviteuser(array(
            "status" => "Done"
          ), $userinvitedemail->user_invite_ID, "user_invite_ID");
        }else{
          $emailerror = "Valid";
        }
      }
    }
  }
  $companyerror = exists($companyname);
  if($companyerror === "Valid"){
    $checkcompany = new Company();
    $companydata = $checkcompany->searchCompany($companyname);
    if($companydata == true){
      $companyerror = "Company Name duplicated";
    }else{
      $companyerror = "Valid";
    }
  }
  

  $condition = condition($firstnameerror, $lastnameerror, $emailerror, $companyerror);

  if($condition === "Passed"){
    try{
      //$effectiveDate = strtotime("+14 days", strtotime(date("Y-m-d H:i:s")));
      //$expiretime = date("Y-m-d H:i:s", $effectiveDate);
      $company = new Company();
      $user1 = new User();
      $vkey = uniqid();

      $company->addCompany(array(
        "company" => $companyname,
        "status" => "Active",
        "corporateID" => null,
        "create_at" => date('Y-m-d H:i:s'),
        "scale" => 20,
        "expiredate" => null,
        "package" => "Trial"
      ));
      $id = $company->lastinsertid();

      $user1->create(array(
        "firstname" => $firstname,
        "lastname" => $lastname,
        "email" => $email,
        "role" => "Superior",
        "corporateID" => null,
        "companyID" => $id,
        "admin" => 1,
        "becomesupervisor" => true,
        "status" => "Active",
        "vkey" => $vkey,
        "superadmin" => 0,
        "verified" => 0,
        "time" => date('Y-m-d H:i:s')
      ));
      $lid = $user1->lastinsertid();

      //$user1->verify($email, $vkey);

      $company->updateCompany(array(
        "leaderID" => $lid
      ), $id, "companyID");

      $timeframename = array("Q1 - ".date("Y"), "Q2 - ".date("Y"), "Q3 - ".date("Y"), "Q4 - ".date("Y"));
      $timeframesdate = array(date("Y")."-01-01 00:00:00", date("Y")."-04-01 00:00:00", date("Y")."-07-01 00:00:00", date("Y")."-10-01 00:00:00");
      $timeframeedate = array(date("Y")."-03-31 23:59:00", date("Y")."-06-30 23:59:00", date("Y")."-09-30 23:59:00", date("Y")."-12-31 23:59:00");

      $timeframeobject = new Timeframe();
      for ($i=0; $i < 4; $i++) { 
        $timeframeobject->addTimeframe(array(
          "timeframe" => $timeframename[$i],
          "startdate" => $timeframesdate[$i],
          "enddate" => $timeframeedate[$i],
          "status" => "Active",
          "corporateID" => null,
          "companyID" => $id,
          "creatorID" => $lid
        ));
      }

      $array = [
			"condition" => $condition
		];
    }catch (Exception $e) {
      echo $e->getMessage();
    }
  }else{
  	$array = [
		"condition" => $condition,
    "firstname" => $firstnameerror,
    "lastname" => $lastnameerror,
		"email" => $emailerror,
		"company" => $companyerror,
		"emaildesc" => $email,
		"companydesc" => $companyname
	];
  }

  echo json_encode($array);
}

?>