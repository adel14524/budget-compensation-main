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
   
      $mainyear = escape(Input::get('addallocationyear'));
      $initial =escape(Input::get('initialBudget'));
      $addmainuser= escape(Input::get('addmainuser'));
      $addmaincomp= escape(Input::get('addmaincomp'));
      $addmaincorporate= escape(Input::get('addmaincorporate'));
      $addbudgetid= escape(Input::get('budgetid'));


      $category = count($_POST["category"]);
      $percent = count($_POST["percent"]);
     
    // print_r($initial);
    function checkPost($data1, $data2, $number) { //check validity
      for($i=0; $i<$number; $i++) { 
          if(trim($data1[$i] == '') || trim($data2[$i] == '') ) {
            return "Required";  
          }
      }
      return "Valid";
    }
  
      function exists($data){ // to check empty data
       if(empty($data)){
         return "Required";
       }else{
         return "Valid";
       }
     }
    

// function maincalc($addmaincomp,$mainyear, $mainpercent){
//         $Mainobject = new Mainallocation();
//          $datatrue = $Mainobject->searchmainallocation($addmaincomp, $mainyear,$mainpercent);
//         $sum=0;
//              if ($datatrue){
//                  foreach ($datatrue as $row ) {
//                      // echo $row->weightage;
//                      $sum += $row->percentAllocation;
//                  }
//              }
//          $total = $mainpercent+$sum;
//         if(($total) > 100){
//             return "Main Allocation exceed 100%. Current allocation: ".$total;
//         }else{
//             return "Valid" ;
//         }
//     }
    // function calcBudget($addmaincomp,$mainyear, $mainpercent){
    //     $budgetinitialobject= new Budgetinitial();
    //     $budgetresult=$budgetinitialobject->searchBudgetCompany($comp, $year);


    //         $Mainobject = new Mainallocation();
    //          $datapercent = $Mainobject->searchmainallocation($addmaincomp, $mainyear,$mainpercent);

    //       $sum=0;
    //              if ($datapercent){
    //                  foreach ($datapercent as $row ) {
    //                      // echo $row->weightage;
    //                      $budget = $row->percentAllocation*$row->budgetInitial;
    //                  }
    //              }

    //          $total = $budget+$sum;
    //     }
      function condition ($data1){ 
        if($data1 === "Valid"){ 
           return "Passed";
   }else{
    return "Failed";
}
}

// $maincategoryerror = exists($mainyear);
// $mainpercenterror = exists($initial);
// $mainpercenterror = exists($addmainuser);
// $mainpercenterror = exists($addmaincomp);
// $mainpercenterror = exists($addmaincorporate);
$mainerror = checkPost($_POST["category"],$_POST["percent"],$category);                        
// $otherserror = checkPostOthers($_POST["otherscat"],$_POST["otherspercent"],$others);                        


// if($mainpercenterror=== "Valid" ){

// $percent1error = maincalc($addmaincomp, $mainyear,$mainpercent); }
// else 
// {
//     $percent1error ="Required";
// }
$condition = condition($mainerror);
if($condition === "Passed"){

// $budgetobject=new Budgetinitial();
// $a= $budgetobject->searchBudgetCompany($addmaincomp,$mainyear);
// $budgetid =$a->budgetInitialID;

  for($i=0; $i<$category; $i++) {
    if(trim($_POST["category"][$i] != '') && trim($_POST["percent"][$i] != '') ) {
      $init = (int)$initial;
      $perce = (int)$_POST["percent"][$i];

      $budget = ($perce/100)*$init;
      // $budget = (50/100)*1200;


      $mainobject = new Mainallocation();
      $mainobject->addmain(array(
        'year' =>$mainyear,
        'corporateID' =>$addmaincorporate,
        'companyID' =>$addmaincomp,
        'userID' =>$addmainuser,
        'budgetAllocated' =>$budget,

        'categoryName' =>$_POST["category"][$i],
        'percentAllocation'=>$_POST["percent"][$i],
        'budgetInitialID'=>$addbudgetid,
      ));                           
    }
  }
   $array = 
   [
   "condition" => $condition,
   ];
 }
  else{
   $array = 
[
  "condition" => $condition,
  "percent" => $mainerror,

  // "mainpercent1" => $mainpercenterror,
  // "initial"=>$initial,
  // "mainpercent"=>$percent1error,
];
}
echo json_encode($array);
}
?>
