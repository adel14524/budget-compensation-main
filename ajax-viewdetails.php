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
  $compensationID = escape(Input::get('compensationID'));

  // $compensation =new Compensation();
  // $data= $condition->searchcondition($compensationID);

  $condition =new Condition();
  $data= $condition->searchcondition($compensationID);

  $target = new Target();
  $data2 = $target->searchTarget($compensationID);


  function conditioncheck($data, $data2,$count){
    $reward = new Reward();
    $badgeobject= new Badge();

    $result=array();
    $rewardobj =null;
    $badgeresult =null;


    $status="Not Achieved";
    if($count > 1){
      for ($i=0; $i <$count ; $i++) { 
        if ($i+1==$count) {
          if ($data2 > $data[$i]->value ) {
            $status="Achieved";
            $rewardobj = $reward->searchReward($data[$i]->cond_indID);
            $badgeresult = $badgeobject->searchBadge2($data[$i]->cond_indID);

          }
        }
        else {

          if ($data2 > $data[$i]->value && $data2 < $data[$i+1]->value ) {
            $status="Achieved";
            $rewardobj = $reward->searchReward($data[$i]->cond_indID);
            $badgeresult = $badgeobject->searchBadge2($data[$i]->cond_indID);

          }
          elseif ($data2 > $data[$i+1]->value ) {
            $status="Achieved";
            $rewardobj = $reward->searchReward($data[$i+1]->cond_indID);
            $badgeresult = $badgeobject->searchBadge2($data[$i+1]->cond_indID);

          }
        }
      }
      // }     
    }
    array_push($result,$status);
    array_push($result,$rewardobj);
    array_push($result,$badgeresult);


    return $result;
  }
  $view="";
  $view.="
  <div class='col px-2'>
  <strong style='font-size: 20px;'>Target Details</strong>
  <button type='button' class='close' data-dismiss='modal'>&times;</button>
  </div>
  <hr>

  <table class='table table-borderless table-hover' style='font-size:14px;'>";
  if($data2){
    $conditionarray=array();

    foreach ($data2 as $row) {
      $user = new User();
      $data3 = $user->searchOnly($row->measure);
      $fname = $data3->firstname;
      if($data3->profilepic){
        $pic = "data:image/jpeg;base64,".base64_encode($data3->profilepic);
      }else{
        $pic = "img/userprofile.png";
      }

      if ($data) {

        $i=0;
        $status="Not achieved";
        $countcond=count($data);
        list($status,$reward,$badgeresult) = conditioncheck($data,$row->actual,$countcond); 
      }
      if($reward){

        if($reward[0]->rewardName=="Cash"){
          $amount= $reward[0]->rewardAmt;
          $rev=0;
        }
        if($reward[0]->rewardName=="Revenue"){
          $amount= 0;
          $rev= $reward[0]->rewardAmt;
        }
      }
      else{
        $amount=0;
        $rev=0;
      }

      // if($reward){
      //   $badge = new Badge();
      //   $data3 = $badge->searchBadge2($reward[0]->cond_indID);
      //   if($data3){
      //    $badgeq=$data3->badgeQuantity;
      //    $badge= $data3->badgeName;

      //  }
      //  else{
      //   $badgeq="-";
      //   $badge="-";
      // }}
      // else{
      //   $badgeq="-";
      //   $badge="-";

      // }
      $view.="
      <tr>
      <td style='width:10%'><img src=".$pic." class='rounded-circle' width='50' height='50'></td>
      <td><p>".$fname."</p></td><br>
      <td><b>Status</b><br><br>".$status."</td>
      <td><b>Actual</b><br><br>".$row->actual."</td>
      <td><b>Cash</b><br><br>".$amount."</td> 
      <td><b>% of Revenue</b><br><br>".$rev."</td>
      <td><b>Badge</b><br><br>
";
    if ($badgeresult!=null) {
      $countbadge = $badgeresult->badgeQuantity;
      if ($badgeresult->badgeName == "gold") {
        for ($i=0; $i < $countbadge ; $i++) { 
          $view.= "<i class='fas fa-award' style='font-size:24px; vertical-align: sub; color:#cd7f32;'></i>&nbsp";

        }

      }elseif ($badgeresult->badgeName == "silver") {
       for ($i=0; $i < $countbadge ; $i++) { 
        $view.= "<i class='fas fa-award' style='font-size:24px; vertical-align: sub; color:silver;'></i>&nbsp";

      }
    }
    elseif ($badgeresult->badgeName == "bronze") {
     for ($i=0; $i < $countbadge ; $i++) { 
      $view.= "<i class='fas fa-award' style='font-size:24px; vertical-align: sub; color: #966F33;'></i>&nbsp";

    }
  }
  }}
$view.="
</td>
      <td style='width: 50px; float: right;'></td>
      </tr> ";

    $view.="
    </table>
    </div>
    "; 
   }   
 echo $view;
}
?>


