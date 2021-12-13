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
     
$budgetSubAllocationID = escape(Input::get('deletesubid'));
$expenseobject= new Expense();
$expenseobject->deletesubexpenses($budgetSubAllocationID);
$subobject = new Suballocation();
$subobject->deletesub($budgetSubAllocationID);



$array = 
[
 "condition" => "Passed",
 "budgetSubAllocationID" => $budgetSubAllocationID,
];
echo json_encode($array); 
}
?>
