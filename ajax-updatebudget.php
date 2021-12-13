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
      $budgetInitialID = escape(Input::get('budget1'));
      $nptarget = escape(Input::get('updnptarget1'));
      $percentbudget = escape(Input::get('updpercentbudget1'));
      $initialbudget = escape(Input::get('updinitialbudget1'));

      function exists($data){
       if(empty($data)){
         return "Required";
       }else{
         return "Valid";
       }
       }

     function condition($data1, $data2,$data3){ 
      if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid"){ 
       return "Passed";
      }else{
      return "Failed";
      }
      }

$updatenptargeterror = exists($nptarget);
$updatepercentbudgeterror = exists($percentbudget);
$updateinitialbudgeterror = exists($initialbudget);

if($updatepercentbudgeterror === "Valid"){
    if($percentbudget < 0){
      $updatepercentbudgeterror = "Minimum percent is 0";
    }elseif($percentbudget > 100){
      $updatepercentbudgeterror = "Maximum percent is 100";
    }else{
      $updatepercentbudgeterror = "Valid";
    }
  }else{
    $updatepercentbudgeterror = "Required";
  }
  
$condition = condition($updatenptargeterror, $updatepercentbudgeterror, $updateinitialbudgeterror);
if($condition === "Passed"){
  $budgetinitialobject = new Budgetinitial();
  $updatemainobject = new Mainallocation();
  $subobj = new Suballocation();
  $mainresult= $updatemainobject->searchmainbudgetid($budgetInitialID);

  if($mainresult){
   $budgetinitialobject->updateBudgetInitial(array(
     "netProfitTarget" =>$nptarget,
     "percentBudget" =>$percentbudget,
     "initialBudget" =>$initialbudget,
   ),  $budgetInitialID, "budgetInitialID");

   $updatemainresult = $updatemainobject->searchbudgetmain2($budgetInitialID);
   if($updatemainresult){
    foreach ($updatemainresult as $row) {
      $budgetMainAllocationID = $row->budgetMainAllocationID;
      $budgetallocated = ($row->percentAllocation/100)*$initialbudget;

      $updatemainobject->updatemain(array(
        'budgetAllocated'=>$budgetallocated,
      ), $budgetMainAllocationID, "budgetMainAllocationID"
    );
    }
  }
  $subresult = $subobj->searchsub($budgetMainAllocationID);

  if($subresult){
    foreach($updatemainresult as $row){
      if ($row->categoryName=="Others") {
        $budgetOthers = $budgetallocated;

        foreach($subresult as $row2){
          $budgetSubAllocationID= $row2->budgetSubAllocationID;
          $budgetallocated = ($row2->percentAllocation/100)*$budgetOthers;

          $subobj->updatesub(array(
           "budgetAllocated"=>$budgetallocated,
         ),$budgetSubAllocationID,"budgetSubAllocationID");
        }
      }
    }
  }

}else{
  $budgetinitialobject->updateBudgetInitial(array(
    "netProfitTarget" =>$nptarget,
    "percentBudget" =>$percentbudget,
    "initialBudget" =>$initialbudget,
  ),  $budgetInitialID, "budgetInitialID");
}

   $array = [
   "condition" => $condition,
];
}else{
   $array = 
[
  "condition" => $condition,
  "nptarget" => $updatenptargeterror,
  "percentbudget" => $updatepercentbudgeterror,
  "initialbudget" => $updateinitialbudgeterror,
];
}
echo json_encode($array); 
}
?>