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
     
$compensationID = escape(Input::get('deletecompensationid'));
$conditionobject= new Condition();

$conditionresult=$conditionobject->searchcondition($compensationID);
if($conditionresult){
  foreach($conditionresult as $row){
   
    $badgeobject = new Badge();

    $badgeid= $badgeobject->searchBadge($row->cond_indID);
    if($badgeid){
      foreach ($badgeid as $row1) {
        $newbadgeid = $row1->badgeID;
        $badgeuserobject = new Badgeuser();
        $badgeuserobject->deleteBadgeid($newbadgeid);
      }
    }
    $badgeobject->deleteBadge($row->cond_indID);
    $rewardobject= new Reward();
    $rewardobject->deleteReward($row->cond_indID);
    $conditionobject->deleteCondition($row->cond_indID);
  }
}
// print_r($newbadgeid);

$targetobject = new Target();
$targetobject->deleteTarget($compensationID);
$compensationobject = new Compensation();
$compensationobject->deleteCompensation($compensationID);

$array = 
[
 "condition" => "Passed",
 "compensationID" =>$compensationID,
];
echo json_encode($array); 
}
?>
