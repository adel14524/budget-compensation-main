
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
  $company = escape(Input::get('comp'));
  $year = escape(Input::get('year'));

  function getbalance($updmonth,$company,$year){
    $mainallocationobject = new Mainallocation();
    $data1 = $mainallocationobject->searchmain($company,$year);
    $suballocationobject = new Suballocation();
    $expensesobject = new Expense();
    $bonusallocation=0;
    $othersallocation=0;

    if ($data1) {
      $amountbonus=0;
      foreach ($data1 as $row) {
        $data3 = $suballocationobject->searchsub($row->budgetMainAllocationID);
        $amountsub=0;
        if ($row->categoryName=="Bonus") {
          $bonusobject = new Calculation();
          $bonusresult=$bonusobject->searchbonusmainid($row->budgetMainAllocationID);
          $bonusallocation=$row->budgetAllocated;

          if($bonusresult){
            foreach ($bonusresult as $row1) {
              $expmonth = date("m",strtotime($row1->date));
              if($expmonth == $updmonth){
                $amountbonus+=$row1->Total_Bonus;
              }
            }
          }
        }
        elseif ($row->categoryName=="Others") {
          foreach ($data3 as $row3) {
            $expensesresult = $expensesobject->searchbudgetsubid($row3->budgetSubAllocationID);
            if($expensesresult){
              foreach ($expensesresult as $row) {
                $expmonth = date("m",strtotime($row->date));

                if ($expmonth == $updmonth) {
                  $amountsub+=$row->amount;
                }
              }
            }
          }
        }
        if ($data3) {
          foreach ($data3 as $row5) {
            $othersallocation+=$row5->budgetAllocated;
          }
        }
      }
    }

    $actual = $amountbonus + $amountsub;
    $budgetallocation = round(($othersallocation + $bonusallocation)/12);
    $newbalance = $budgetallocation - $actual;

    return $newbalance;
  }

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

    $balance = getbalance($updmonth,$company,$year);

    $array = 
    [
      "condition" => $condition,
      "amount" =>$updamount,
      "month" => $updmonth,
      "div" => $upddiv,
      "balance" => $balance,
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
