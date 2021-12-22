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

if (Input::exists()) {

    /*guna nama kat check validity*/ 
    $budgetRevenueID = escape(Input::get('budgetRevenueID'));
    $updrevtype = escape(Input::get('type'));
    $updcolumn = escape(Input::get('column'));
    $updvalue = escape(Input::get('value'));
    $month = escape(Input::get('month'));
    $prevvalue = escape(Input::get('prev'));

    function exists($data){ 
        if(empty($data)){
            return "Required";
        }
        else{
            return "Valid";
        }
    }

    function month($month){
        if ($month == 1) {
            return "January";
        }
        elseif ($month == 2) {
            return "February";
        }
        elseif ($month == 3) {
            return "March";
        }
        elseif ($month == 4) {
            return "April";
        }
        elseif ($month == 5) {
            return "May";
        }
        elseif ($month == 6) {
            return "June";
        }
        elseif ($month == 7) {
            return "July";
        }
        elseif ($month == 8) {
            return "August";
        }
        elseif ($month == 9) {
            return "September";
        }
        elseif ($month == 10) {
            return "October";
        }
        elseif ($month == 11) {
            return "November";
        }
        elseif ($month == 12) {
            return "December";
        }
    }
    
    function condition($data1){ 
        if($data1 === "Valid"){ 
            return "Passed";
        }
        else{
            return "Failed";
        }
    }

    $updvalueerror = exists($updvalue);

    $condition = condition($updvalueerror);

    if ($condition === "Passed") {
        $revenueobject = new Revenue();
        $revenueobject->updateCost(array(
            $updcolumn =>$updvalue
        ), $budgetRevenueID,"budgetRevenueID");

        $revenueobject = new Revenue();
        $revenueobject->addCostLog(array(
            'budgetRevenueID'=> $budgetRevenueID,
            'revMonth' => month($month),
            'newValue' => $updvalue,
            'previousValue' => $prevvalue,
            'action' => "Update",
        ));

        $array = 
        [
            "condition" => $condition,
            "month" => $month,
            "value" => $updvalue
        ];
    }
    else {
        $array = 
        [
            "condition" => $condition,
            "month" => $month,
            "value" => $updvalue
        ];
    }
    echo json_encode($array);
}
?>