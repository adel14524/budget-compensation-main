
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

  $compensationID = escape(Input::get('updcompensationid1'));

  $conditionobj = new Condition();
  $data = $conditionobj->searchcondition($compensationID);

  $targetID = count($_POST["updtargetid1"]);
  $actual = count($_POST["actualvalue2"]);
  $measure = count($_POST["measureid"]);
  // print_r($data);

  function conditioncheck($data, $data2,$count){
    $reward = new Reward();
    $badge = new Badge();

    $result=array();
    $rewardobj =null;
    $badgeobj =null;
    
    $status="Not Achieved";
    if($count > 1){
      for ($i=0; $i <$count ; $i++) { 
        if ($i+1==$count) {
          if ($data2 > $data[$i]->value ) {
            $status="Achieved";
            $rewardobj = $reward->searchReward($data[$i]->cond_indID);
            $badgeobj = $badge->searchBadge($data[$i]->cond_indID);

          }
        }
        else {
          if ($data2 > $data[$i]->value && $data2 < $data[$i+1]->value ) {
            $status="Achieved";
            $rewardobj = $reward->searchReward($data[$i]->cond_indID);
            $badgeobj = $badge->searchBadge($data[$i]->cond_indID);

          }
          elseif ($data2 > $data[$i+1]->value ) {
            $status="Achieved";
            $rewardobj = $reward->searchReward($data[$i+1]->cond_indID);
            $badgeobj = $badge->searchBadge($data[$i+1]->cond_indID);
          }
        }
      } 
    }
    array_push($result,$status);
    array_push($result,$rewardobj);
    array_push($result,$badgeobj);


    return $result;
  }

  function condition($data1){ 
    if($data1 === "Valid"){ 
     return "Passed";
   }
   else{
    return "Failed";
  }
}
  $actual1error= "Valid";

  $condition = condition( $actual1error);

  if($condition === "Passed"){

    for($i=0; $i<$targetID; $i++) {
     
      if(trim($_POST["updtargetid1"][$i] != '') && trim($_POST["actualvalue2"][$i] != '') && trim($_POST["measureid"][$i] != '')) {

        $j=0;
        $actualval = $_POST["actualvalue2"][$i];
        $status="Not achieved";
        $countcond=count($data);
        list($status,$reward,$badgeobj) = conditioncheck($data,$actualval,$countcond); 

        $targetobject = new Target();
        $targetobject->updateTarget(array( 
          "measure" =>$_POST["measureid"][$i],
          "actual" =>$_POST["actualvalue2"][$i],
          "status" =>$status,
        ),$_POST["updtargetid1"][$i],"targetID"); 

        if($badgeobj){
          foreach ($badgeobj as $row) {
            $badgeuserobject = new Badgeuser();
            $badgeuserobject->addBadgeuser(array(
               "userID"=>$_POST["measureid"][$i],
               "badgeID"=>$row->badgeID,
            ));

          }
        }
       
      }
    }
   $array = 
   [
     "condition" => $condition,
   ];
 }
 else{
   $array = 
   [
    "condition" => $condition,
    "actual" =>$actual,

  ];
}
echo json_encode($array); 
}
?>
