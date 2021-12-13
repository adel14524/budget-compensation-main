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
  $budgetInitialID = escape(Input::get('deletebudgetid'));
  $mainobject = new Mainallocation();
  
  
  $mainobj= $mainobject->searchmainsub($budgetInitialID);
  if($mainobj){
    foreach($mainobj as $row){
      $mainid= $row->budgetMainAllocationID;
      $subobject = new Suballocation();
      $subobject->deleteAllSub($mainid);

    }
  }
  $mainobject->deletemain($budgetInitialID);

  $budgetInitialobject = new Budgetinitial();
  $budgetInitialobject->deleteBudgetInitial($budgetInitialID);

  $array = 
  [
   "condition" => "Passed",
   "budgetInitialID" => $budgetInitialID,

 ];
 echo json_encode($array);
}
?>
