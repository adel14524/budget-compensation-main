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
	$pppID = escape(Input::get('pppID'));

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

  $pppIDerror = exists($pppID);

  $condition = condition($pppIDerror);

  if($condition === "Passed"){
    $PPPOOOobject = new Pppoooreport();
    $PPPOOOresult = $PPPOOOobject->searchOnlyPPPPlan($pppID);
    $PPPOOOresult1 = $PPPOOOobject->searchOnlyPPPDay($PPPOOOresult->p_ppp_day_ID);

    $PPPOOOobject->addPPPProblem(array(
      "problem" => $PPPOOOresult->plan,
      "p_ppp_ID" => $PPPOOOresult1->p_ppp_ID,
      "status" => "Stuck"
    ));

    $PPPOOOobject->deletePPPPlan($pppID);

    $array = [
      "condition" => $condition,
      "pppday" => $PPPOOOresult->p_ppp_day_ID,
      "pppID" => $PPPOOOresult1->p_ppp_ID
    ];
  }else{
    $array = [
      "condition" => $condition
    ];
  }
}
echo json_encode($array);
?>