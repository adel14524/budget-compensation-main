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
      $operator = escape(Input::get('operator'));
      $amount = escape(Input::get('amount'));
      $rewardcash = escape(Input::get('rewardcash'));
      $rewardpercent = escape(Input::get('rewardpercent')); 
      $rewardbadge = escape(Input::get('rewardbadge'));
      $checkboxcash="Valid";
      $checkboxpercent="Valid";
      $checkboxbadge="Valid";

      $condrestrict= new Condition();
      $conditionresult = $condrestrict->searchcondition($compensationID);

      $newcond=0;
      if($conditionresult){
        foreach ($conditionresult as $row) {
          $newcond = $row->value;
        }

      }


      if($operator=="greater"){
        $operator= ">";
      }
      elseif($operator=="less"){
        $operator= "<";
      } 
      elseif($operator=="equal"){
        $operator= "=";
      }

      function exists2($data1 ,$data2){ // to check empty data
       if(empty($data1) ||empty($data2) ){
         return "Required";
       }else{
         return "Valid";
       }
     } 

      function exists($data){ // to check empty data
       if(empty($data)){
         return "Required";
       }else{
         return "Valid";
       }
     } 
    
     function condition($data1, $data2, $data3){ 
      if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" ){ 
       return "Passed";
     }else{
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

 if($rewardcash==="true"){
  $setamount = escape(Input::get('amountcash'));
  $checkboxcash=exists($setamount);
}
if ($rewardpercent==="true") {
  $setpercent = escape(Input::get('amountpercent'));
  $checkboxpercent=exists($setpercent);
}
if ($rewardbadge==="true" ) {
  $choosebadge = escape(Input::get('choosebadge'));
  $setbadge = escape(Input::get('amountbadge'));
  $checkboxbadge=exists2($choosebadge, $setbadge);
}

  $plancheckbox=checkbox($checkboxcash,$checkboxpercent,$checkboxbadge);
  $addOperatorerror = exists($operator);
  $seterror = exists($amount);
  if($amount >= $newcond){
      $seterror = "Valid";
    }else{
      $seterror = "Value must be greater than the previous condition!";
    }

  $condition = condition( $addOperatorerror, $seterror,$plancheckbox);

    if($condition === "Passed"){

     $conditionobject = new Condition();
     $conditionobject->addCondition(array(
      'compensationID'=>$compensationID,
      'operator' =>$operator,
      'value' =>$amount,          

    ));$conditionID = $conditionobject->lastinsertid();
     if($rewardcash==="true"){
     /* print_r($checkboxcash);*/
      $rewardobject= new Reward();
      $rewardobject->addReward(array(
      'rewardName' =>"Cash",
      'rewardAmt' =>$setamount,
      'cond_indID'=>$conditionID,

    ));
     }
      if($rewardpercent==="true"){
      $rewardobject= new Reward();
      $rewardobject->addReward(array(
      'rewardName' =>"Revenue",
      'rewardAmt' =>$setpercent,
      'cond_indID'=>$conditionID,

    ));
     }
      if($rewardbadge==="true"){
      $badgeobject= new Badge();
      $badgeobject->addBadge(array(
      'badgeName' =>$choosebadge,
      'badgeQuantity' =>$setbadge,
      'cond_indID'=>$conditionID,

    ));
     }

     $array = 
     [
       "condition" => $condition,
       "plancheckbox" => $plancheckbox,
       "checkboxcash"=> $checkboxcash,
      "checkboxpercent"=> $checkboxpercent,
      "checkboxbadge"=> $checkboxbadge,
      "rewardbadge" => $rewardbadge,
       "rewardcash" => $rewardcash,
      "rewardpercent" => $rewardpercent,
     ];

   }
   else{

    $array = 
    [
      "condition" => $condition,
      "operator" => $addOperatorerror,
      "amount" => $seterror,
      "plancheckbox" => $plancheckbox,
      "checkboxcash"=> $checkboxcash,
      "checkboxpercent"=> $checkboxpercent,
      "checkboxbadge"=> $checkboxbadge,
      "rewardbadge" => $rewardbadge,
      "rewardcash" => $rewardcash,
      "rewardpercent" => $rewardpercent,

      
    ];
  }


echo json_encode($array); // For AJAX, always must return some value back to where you call which can refer to javascript, for here, we return an array with condition and error. 
}
?>
