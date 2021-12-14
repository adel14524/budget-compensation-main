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
      $datecomp = escape(Input::get('datecomp'));
      /*$catcomp = escape(Input::get('catcomp'));*/
      $amountcomp = escape(Input::get('amountcomp'));
      $desccomp = escape(Input::get('desccomp'));
     $addamountuser= escape(Input::get('addamountuser'));
     $suballocationid= escape(Input::get('suballocationid'));
     $div = escape(Input::get('div'));
     $month = escape(Input::get('month'));
     
      $addamountcompany= escape(Input::get('addamountcompany'));
       $addamountcorporate= escape(Input::get('addamountcorporate'));

      function exists($data){ // to check empty data
       if(empty($data)){
         return "Required";
       }else{
         return "Valid";
       }
     }

      function condition ($data1, $data2, $data3){ 
        if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" ){ 
           return "Passed";
}else{
    return "Failed";
}
}

$datecomperror = exists($datecomp);
/*$catcomperror = exists($catcomp);*/
$amountcomperror = exists($amountcomp);
$desccomperror = exists($desccomp);


$condition = condition(/*$catcomperror,*/$datecomperror, $amountcomperror, $desccomperror);
if($condition === "Passed"){

   $budgetexpensesobject = new Expense();
   $budgetexpensesobject->addexpand(array(
     'date' =>$datecomp,
     /*'categoryName' =>$catcomp,*/
     'amount' =>$amountcomp,
     'description' =>$desccomp,
     'userID' =>$addamountuser,
     'companyID' =>$addamountcompany,
     'corporateID' =>$addamountcorporate,
     'budgetSubAllocationID' =>$suballocationid,

));
   $array = 
[
   "condition" => $condition,
   "div" => $div,
   "date" => $datecomp,
   "month" => $month

];
}else{
   $array = 
[
  "condition" => $condition,
  "datecomp" => $datecomperror,
 /* "catcomp" => $catcomperror,*/
  "amountcomp" => $amountcomperror,
  "desccomp" => $desccomperror,
];
}
echo json_encode($array); // For AJAX, always must return some value back to where you call which can refer to javascript, for here, we return an array with condition and error. 
}
?>
