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
     
$cond_indID = escape(Input::get('deleteconditionid'));


$badgeobject = new Badge();
$badgeobject->deleteBadge($cond_indID);
$rewardobject = new Reward();
$rewardobject->deleteReward($cond_indID);
$conditionobject = new Condition();
$conditionobject->deleteCondition($cond_indID);


// $targetobject = new Target();
// $targetobject->deleteTarget($compensationID);


$array = 
[
 "condition" => "Passed",
 "cond_indID" =>$cond_indID
];
echo json_encode($array); 
}
?>
