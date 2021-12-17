
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
      $budgetExpensesID = escape(Input::get('budgetid'));
      $upddate= escape(Input::get('updatedate1'));
      $updamount = escape(Input::get('updateamount1'));
      $upddesc = escape(Input::get('updatedescription1'));
      $updmonth = escape(Input::get('month'));
      $upddiv = escape(Input::get('div'));
      $updbalance = escape(Input::get('balance'));
      $updbudget = escape(Input::get('budget'));
 

      function exists($data){ 
       if(empty($data)){
         return "Required";
       }else{
         return "Valid";
       }
     }

      function condition($data1, $data2, $data3){ 
        if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid"){ 
           return "Passed";
}
else{
    return "Failed";
}
}

$upddateerror = exists($upddate);
$updamounterror = exists($updamount);
$upddescerror = exists($upddesc);


$condition = condition($upddateerror,$updamounterror,$upddescerror);
if($condition === "Passed"){

   $updateobject = new Expense();
   $updateobject->updateexpand(array(
   "date" =>$upddate,
   "amount" =>$updamount,
   "description" =>$upddesc,
), $budgetExpensesID,"budgetExpensesID");

   $array = 
[
   "condition" => $condition,
   "amount" =>$updamount,
   "month" => $updmonth,
   "div" => $upddiv,
   "balance" => $updbalance,
   "budgetallocated" => $updbudget
];
}
else{
   $array = 
[
  "condition" => $condition,
  /*"upddate" => $upddateerror,
  "updamount" => $updamounterror,
  "upddesc" => $upddescerror,*/
  "date" =>$upddate,
  "amount" =>$updamount,
  "description" =>$upddesc,
  
  
];
}
echo json_encode($array); 
}
?>
