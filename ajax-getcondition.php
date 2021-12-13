<?php
require_once 'core/init.php';
if(Input::exists()){
  $cond_indid = escape(Input::get('cond_indid'));

  $condition = new Condition();
  $data = $condition->searchcompensationcondition($cond_indid);

  $compensation = new Compensation();
  $data4 = $compensation->searchbudgetcompensation($data->compensationID);

  $target = new Target();
  $data5 = $target->searchtargetcompensation($data4->compensationID);

  $reward = new Reward();
  $data2 = $reward->searchcompensationreward($cond_indid);
  
  $badge = new Badge();
  $data3 = $badge->searchcompensationbadge($cond_indid);

  $cashrewardid="";
  $revrewardid="";
 
    $rewardcash="";
    $amountcash="";
  
    $rewardpercent="";
    $amountpercent="";
  
  if($data3){
    foreach($data3 as $row1){
     $choosebadge=$row1->badgeName;
     $amountbadge =$row1->badgeQuantity;
     $badgeID=$row1->badgeID;
    }
  }
  else{
    $choosebadge="";
     $amountbadge ="";
     $badgeID="";
  }

 $rewardcash="";
  if($data2){
    foreach($data2 as $row){
      if($row->rewardName=="Cash"){
       $cashrewardid=$row->reward_indID;
       // $cash=$row;
       // if($cash){ 
          $rewardcash=$row->rewardName;
          $amountcash=$row->rewardAmt;
        // }
        /*else{
          $rewardcash="";
          $amountcash="";
        }*/
      }

      if($row->rewardName=="Revenue"){
        $revrewardid=$row->reward_indID;        
        $rewardpercent=$row->rewardName;
        $amountpercent=$row->rewardAmt;
        /*else{
          $rewardpercent="";
          $amountpercent="";
        }*/
      }
    }
  }
  
    $array = [
    "id" => $data->cond_indID,
    "operator" => $data->operator,
    "condition"=>$data5->performanceMetric,
    "set" => $data->value,
    "rewardcash" => $rewardcash,
    "amountcash" => $amountcash, 
    "rewardpercent" => $rewardpercent,
    "amountpercent"=> $amountpercent,
    "choosebadge"=> $choosebadge,
    "amountbadge" => $amountbadge,
    "cashrewardID"=>$cashrewardid,
    "revrewardID"=>$revrewardid,
    "badgeID"=>$badgeID,
    
  ];


  echo json_encode($array);
}
?>