
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

    /*guna nama kat check validity*/ 
      $cond_indID = escape(Input::get('cond_indID'));
      $operator = escape(Input::get('operator'));
      $set = escape(Input::get('set'));
      $rewardcash= escape(Input::get('rewardcash'));
      // $amountcash= escape(Input::get('amountcash'));
      $rewardpercent= escape(Input::get('rewardpercent'));
      /*$amountpercent= escape(Input::get('amountpercent'));*/
      $rewardbadge= escape(Input::get('rewardbadge'));
      $cashID= escape(Input::get('cashrewardID'));
      $revID= escape(Input::get('revrewardID'));
      $badgerewID= escape(Input::get('badgeID'));

     /* $choosebadge= escape(Input::get('choosebadge'));
      $amountbadge= escape(Input::get('amountbadge'));*/
      $checkboxcash="Valid";
      $checkboxpercent="Valid";
      $checkboxbadge="Valid";
      
      if($operator=="greater"){
        $operator= ">";
      }
      elseif($operator=="less"){
        $operator= "<";
      } 
      elseif($operator=="equal"){
        $operator= "=";
      }

      
      function exists($data){ 
       if(empty($data)){
         return "Required";
       }else{
         return "Valid";
       }
     }
      function exists2($data1 ,$data2){ // to check empty data
       if(empty($data1) || empty($data2) ){
         return "Required";
       }else{
         return "Valid";
       }
     } 

     function condition($data1 , $data2, $data3 ){ 
      if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" ){ 
       return "Passed";
     }
     else{
      return "Failed";
    }
  }

  function checkbox($data1, $data2, $data3){
    if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" ){ 
     return "Valid";
   }else{
    return "Required";
  }

}

if($rewardcash== "true"){
  $amountcash = escape(Input::get('amountcash'));
  $checkboxcash=exists($amountcash);
  $cashrewardID= escape(Input::get('cashrewardID'));
  $cashrewardid = exists($cashrewardID);

}
if ($rewardpercent==="true") {
  $amountpercent = escape(Input::get('amountpercent'));
  $checkboxpercent = exists($amountpercent);
  $revrewardID= escape(Input::get('revrewardID'));
  $revrewardid = exists($revrewardID);

}
if ($rewardbadge==="true" ) {
  $choosebadge = escape(Input::get('choosebadge'));
  $amountbadge = escape(Input::get('amountbadge'));
  $checkboxbadge = exists2($choosebadge, $amountbadge);
  $badgeID= escape(Input::get('badgeID'));
  $badgerewardid = exists($badgeID);

}

$plancheckbox=checkbox($checkboxcash,$checkboxpercent,$checkboxbadge);
$updaddOperatorerror= exists($operator);
$updseterror= exists($set);

$condition = condition( $updaddOperatorerror, $updseterror,$plancheckbox);

if($condition === "Passed"){
   $conditionobject = new Condition();
   $conditionobject->updateCondition(array( 

   "operator" =>$operator,
   "value" =>$set,
 ),$cond_indID,"cond_indID");
 
    $rewardobject = new Reward();
    $rewardresult=$rewardobject->searchReward($cond_indID);

     // if($rewardresult){
     //   foreach($rewardresult as $row){
     //     if($rewardcash== "true"){
     //      $cash="Cash";
     //    }
     //    elseif($rewardpercent== "true"){
     //      $percent="Revenue";
     //    }

       //  if($row->rewardName!=$cash){
       //    print_r("hello1");
       //   $rewardobject = new Reward();
       //   $rewardobject->deleteReward($reward_indID);

       //   $updaddOperatorerror="Valid";
       //   $updseterror="Valid";
       //   $updrewardcasherror = "Valid";
       //   $updsetamounterror= "Valid";
       //   $updrewardpercenterror ="Valid";
       //   $updsetpercenterror ="Valid";
       //   $updrewardbadgeerror="Valid";
       //   $updchoosebadgeerror= "Valid";
       //   $updsetbadgeerror ="Valid";
       // }
       // elseif($row->rewardName!=$percent){
       //    print_r("hello2");
       //   $rewardobject = new Reward();
       //   $rewardobject->deleteReward($reward_indID);
       //  $updaddOperatorerror="Valid";
       //  $updseterror="Valid";
       //  $updrewardcasherror = "Valid";
       //  $updsetamounterror= "Valid";
       //  $updrewardpercenterror ="Valid";
       //  $updsetpercenterror ="Valid";
       //  $updrewardbadgeerror="Valid";
       //  $updchoosebadgeerror= "Valid";
       //  $updsetbadgeerror ="Valid";
       // }
    //   }
    // }
    // if($rewardresult){
    //   foreach($rewardresult as $row){
    //     $cashcheck=false;
    //     $revcheck=false;
    //     if($row->rewardName=="Cash"){
    //       $cashcheck= true;
    //     }
    //     else{
    //       $cashcheck= false;
    //     }
    //     if($row->rewardName=="Revenue"){
    //       $revcheck= true;
    //     }
    //     else{
    //       $revcheck= false;
    //     }
    //   }
    if($rewardcash === "true"){
      if($cashrewardid ==="Valid"){
        $rewardobject = new Reward();
        $rewardobject->updateReward(array(
         "rewardName" =>"Cash",
         "rewardAmt" =>$amountcash,
        ),$cashrewardID,"reward_indID");
      }
      elseif($cashrewardid==="Required"){
        $rewardobject = new Reward();
        $rewardobject->addReward(array(
         "rewardName" =>"Cash",
         "rewardAmt" =>$amountcash,
         "cond_indID"=>$cond_indID,
        ));
      }
    }
    else {
      if($cashID){
        $rewardobject = new Reward();
        $rewardobject->deleteRewardID($cashID);
      }
    }

    if($rewardpercent === "true"){
      if($revrewardid ==="Valid"){
        $rewardobject = new Reward();
        $rewardobject->updateReward(array(
         "rewardName" =>"Revenue",
         "rewardAmt" =>$amountpercent,
        ),$revrewardID,"reward_indID");
      }
      elseif($revrewardid==="Required"){
        $rewardobject = new Reward();
        $rewardobject->addReward(array(
         "rewardName" =>"Revenue",
         "rewardAmt" =>$amountpercent,
         "cond_indID"=>$cond_indID,
        ));
      }
    }
    else {
      if($revID){
        $rewardobject = new Reward();
        $rewardobject->deleteRewardID($revID);
      }
    }

    if($rewardbadge === "true"){
      if($badgerewardid ==="Valid"){
        $badgeobject = new Badge();
        $badgeobject->updateBadge(array(
         "badgeName" =>$choosebadge,
         "badgeQuantity" =>$amountbadge,
        ),$badgeID,"badgeID");
      }
      elseif($badgerewardid==="Required"){
      $badgeobject = new Badge();
      $badgeobject->addBadge(array(
       "badgeName" =>$choosebadge,
       "badgeQuantity" =>$amountbadge,
       "cond_indID" =>$cond_indID,
      ));
      }
    }
    else {
      if($badgerewID){
        $badgeobject = new Badge();
        $badgeobject->deleteBadgeid($badgerewID);
      }
    }
      
      // if($revcheck== true){
      //   $rewardobject = new Reward();
      //   $rewardobject->updateReward(array(
      //   "rewardName" =>"Revenue",
      //   "rewardAmt" =>$amountpercent,
      //  ),$reward_indID,"reward_indID");
      // }
      // elseif($revcheck== false){
      //    $rewardobject = new Reward();
      //    $rewardobject->addReward(array(
      //    "rewardName" =>"Revenue",
      //    "rewardAmt" =>$amountpercent,
      //    "cond_indID"=>$cond_indID,
      //   ));
      // }
    // }
   // if($badgeID){
   //  if($rewardbadge==="true"){
   //    $badgeobject = new Badge();
   //    $badgeobject->updateBadge(array(
   //      "badgeName" =>$choosebadge,
   //      "badgeQuantity" =>$amountbadge,
   //    ),$badgeID,"badgeID");
   //  }
   // }
   // else{
   //  if($rewardbadge==="true"){
   //    $badgeobject = new Badge();
   //    $badgeobject->addBadge(array(
   //      "badgeName" =>$choosebadge,
   //      "badgeQuantity" =>$amountbadge,
   //      "cond_indID"=>$cond_indID,
   //    ));
   //  }
   // }
    
   $array = 
[
   "condition" => $condition,
];
}
else{
   $array = 
[
  "condition" => $condition,
  "operator" => $updaddOperatorerror,
  "set" => $updseterror,
  "rewardcash"=> $updrewardcasherror,
  "amountcash" => $updsetamounterror,
  "rewardpercent"=> $updrewardpercenterror,
  "amountpercent" => $updsetpercenterror,
  "rewardbadge"=> $updrewardbadgeerror,
  "choosebadge" => $updchoosebadgeerror,
  "amountbadge"=>$updsetbadgeerror, 

  "operator" =>$operator,
  "value" =>$set,
  "rewardName" =>$rewardcash,
  "rewardAmt" =>$amountcash,
  "badgeName" =>$choosebadge,
  "badgeQuantity" =>$amountbadge,
];
}
echo json_encode($array); 
}
?>
