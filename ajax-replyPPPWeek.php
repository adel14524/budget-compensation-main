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
  $pppreply = escape(Input::get('pppreply'));


  $PPPOOOobject = new Pppoooreport();
  $PPPOOOobject->addPPPComment(array(
    "comment" => $pppreply,
    "userID" => $resultresult->userID,
    "ppp_ID" => $pppID,
    "date" => date('Y-m-d H:i:s')
  ));

  $array = 
  [
  	"view" => "Passed",
    "pppID" => $pppID
  ];
  echo json_encode($array);
}
?>