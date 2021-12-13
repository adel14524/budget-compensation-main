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
     
$budgetExpensesID = escape(Input::get('deleteexpensesid'));
$expensesobject = new Expense();
$expensesobject->deleteexpenses1($budgetExpensesID);

$array = 
[
 "condition" => "Passed",
 "budgetExpensesID" => $budgetExpensesID,
];
echo json_encode($array); 
}
?>
