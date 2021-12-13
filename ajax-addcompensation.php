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
      $company = escape(Input::get('company'));
      $planname = escape(Input::get('plan'));
      $plantype = escape(Input::get('type'));
      if($plantype=="onetime"){
        $startdate = escape(Input::get('startdate'));
        $enddate = escape(Input::get('enddate'));
        $month = escape(Input::get('month'));
        $year = escape(Input::get('year'));
      }
      elseif($plantype=="monthly"){
        $startdate = escape(Input::get('startdate'));
        $enddate = escape(Input::get('enddate'));
        $month = escape(Input::get('month'));
        $year = escape(Input::get('year'));
      }
      elseif($plantype=="annually"){
      $startdate = escape(Input::get('startdate'));
      $enddate = escape(Input::get('enddate'));
      $month = escape(Input::get('month'));
      $year = escape(Input::get('year'));
      }

      $measure = escape(Input::get('measure'));
      $pm = escape(Input::get('pm'));

      $corporate = escape(Input::get('corporate'));
      // $company = escape(Input::get('company'));
      $user = escape(Input::get('user'));


      function exists($data){ // to check empty data
       if(empty($data)){
         return "Required";
       }else{
         return "Valid";
       }
     } 
     // function maincalc($addbudgetuser,$year,$percentbudget){
     //         $budgetobject = new Budgetinitial();
     //          $datatrue = $budgetobject->searchBudget($addbudgetuser,$year,$percentbudget);
             
     //         if(($percentbudget) > 100){
     //             return "Percentage of budget exceed 100%." ;
     //         }else{
     //             return "Valid" ;
     //         }
     //     }
   
      function condition ($data1, $data2, $data3, $data4,$data5,$data6,$data7){ 
        if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 === "Valid" && $data5 === "Valid" && $data6 === "Valid" && $data7 === "Valid" ){ 
           return "Passed";
        }else{
          return "Failed";
        }
        }

        function condition2 ($data1, $data2, $data3, $data4,$data5,$data6){ 
          if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 === "Valid" && $data5 === "Valid" && $data6 === "Valid"){ 
             return "Passed";
          }else{
            return "Failed";
          }
          }
          function condition3 ($data1, $data2, $data3, $data4,$data5,$data6,$data7,$data8){ 
            if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 === "Valid" && $data5 === "Valid" && $data6 === "Valid" && $data7 === "Valid" && $data8 === "Valid" ){ 
               return "Passed";
            }else{
              return "Failed";
            }
            }

$choosecomperror = exists($company);
$planNameError = exists($planname);
$plantypeerror = exists($plantype);
$chooseTargeterror = exists($measure);
$choosePMerror = exists($pm);
if($plantype=="onetime"){
  $addstartdateerror =  exists($startdate);
  $addenddateerror = exists($enddate);

  $condition = condition( $choosecomperror, $planNameError, $plantypeerror, $addstartdateerror, 
    $addenddateerror, $chooseTargeterror,$choosePMerror);

}
elseif($plantype=="monthly"){
  $addstartdate2error =  exists($startdate);
  $addenddate2error =  exists($enddate);
  $choosemontherror =  exists($month);


  $condition = condition3( $choosecomperror, $planNameError, $plantypeerror, $addstartdate2error, $addenddate2error, $choosemontherror, $chooseTargeterror,$choosePMerror);

}
elseif($plantype=="annually"){
$yeartypeerror =  exists($year);

$condition = condition2($choosecomperror, $planNameError, $plantypeerror, $yeartypeerror, $chooseTargeterror,$choosePMerror);

}
if($condition === "Passed"){

   $compensationobject = new Compensation();
   $compensationobject->addCompensation(array(
    'corporateID' =>$corporate,
    'companyID' =>$company,
    'userID' =>$user,
     'planName' =>$planname,
     'planType' =>$plantype, 
     'start_date' =>$startdate, 
     'end_date' =>$enddate,
     'month' =>$month,
     'year'=>$year,
     

));$compensationid = $compensationobject->lastinsertid();

    $targetobject= new Target();

          if($measure){
            $measure= explode(",",$measure);
            for ($i=0; $i < count($measure); $i++) { 
              $targetobject->addTarget(array(
                // "targetType" =>$target,
                "performanceMetric" =>$pm,
                "compensationID" =>$compensationid,
                "measure" =>$measure[$i],

              ));
            }
          } 
   $array = 
[
   "condition" => $condition, 
];

}else{
   $array = 
[
  "condition" => $condition,
  

];
}
echo json_encode($array); // For AJAX, always must return some value back to where you call which can refer to javascript, for here, we return an array with condition and error. 
}
?>
