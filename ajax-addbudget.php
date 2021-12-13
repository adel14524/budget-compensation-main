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
      $company = escape(Input::get('addbudgetcompany'));
      $addbudgetcorporate = escape(Input::get('addbudgetcorporate'));
      $addbudgetuser = escape(Input::get('addbudgetuser'));
      $year = escape(Input::get('addyear'));
      $nptarget = escape(Input::get('addnptarget'));
      $percentbudget = escape(Input::get('addpercentbudget'));
      $initialbudget = escape(Input::get('addinitialbudget'));

      function exists($data){ // to check empty data
       if(empty($data)){
         return "Required";
       }else{
         return "Valid";
       }
     } 

     function condition ($data1, $data2, $data3, $data4){ 
      if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 === "Valid" ){ 
       return "Passed";
     }else{
      return "Failed";
    }
  }

$addcompanyyyerror = exists($company);
$addyearerror = exists($year);
$addnptargeterror = exists($nptarget);
$addpercentbudgeterror = exists($percentbudget);
$addinitialbudgeterror = exists($initialbudget);


if($addpercentbudgeterror === "Valid"){
    if($percentbudget < 0){
      $addpercentbudgeterror = "Minimum percent is 0";
    }elseif($percentbudget > 100){
      $addpercentbudgeterror = "Maximum percent is 100";
    }else{
      $addpercentbudgeterror = "Valid";
    }
  }else{
    $addpercentbudgeterror = "Required";
  }

$condition = condition( $addcompanyyyerror, $addyearerror, $addnptargeterror, $addpercentbudgeterror, $addinitialbudgeterror);
if($condition === "Passed"){

 $budgetinitialobject = new Budgetinitial();
 $budgetinitialobject->addBudgetInitial(array(
  'corporateID' =>$addbudgetcorporate,
  'companyID' =>$company,
  'userID' =>$addbudgetuser,
  'year' =>$year,
  'netProfitTarget' =>$nptarget, 
  'percentBudget' =>$percentbudget,
  'initialBudget' =>$initialbudget, 
));

 $array = 
 [
   "condition" => $condition, 
 ];
}else{
 $array = 
 [
  "condition" => $condition,
  "company" => $addcompanyyyerror,
  "year" => $addyearerror,
  "nptarget" => $addnptargeterror,
  "percentbudget" => $addpercentbudgeterror,
  "initialbudget" => $addinitialbudgeterror,
  // "percentbudget" => $percent1error,

];
}
echo json_encode($array);
}
?>
