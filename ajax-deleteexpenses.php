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
$month = escape(Input::get('deletemonth'));
$div = escape(Input::get('deletediv'));
$balance = escape(Input::get('deletebalance'));
$budget = escape(Input::get('deletebudget'));
$amount = escape(Input::get('deleteamount'));
$expensesobject = new Expense();
$expensesobject->deleteexpenses1($budgetExpensesID);

$array = 
[
 "condition" => "Passed",
 "deletemonth" => $month,
 "deletediv" => $div,
 "amountdelete" => $amount,
 "budgetExpensesID" => $budgetExpensesID,
 "deletebalance" => $balance,
 "budgetallocated" => $budget,
];
echo json_encode($array); 
}
?>
