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

      $compensationID = escape(Input::get('compensationID'));
      $company= escape(Input::get('company'));
      $planname= escape(Input::get('planname'));
      $type= escape(Input::get('type'));
      if($type=="onetime"){
        $startdate= escape(Input::get('startdate'));
        $enddate= escape(Input::get('enddate'));
        $month= escape(Input::get('month'));
        $year= escape(Input::get('year'));

      }
      if($type=="monthly"){
        $startdate= escape(Input::get('startdate'));
        $enddate= escape(Input::get('enddate'));
        $month= escape(Input::get('month'));
        $year= escape(Input::get('year'));
      }
      if($type=="annually"){
        $startdate= escape(Input::get('startdate'));
        $enddate= escape(Input::get('enddate'));
        $month= escape(Input::get('month'));
        $year= escape(Input::get('year'));

      }
      $measure= escape(Input::get('measure'));
      $pm= escape(Input::get('pm'));
      $target= escape(Input::get('target'));

      function exists($data){ 
       if(empty($data)){
         return "Required";
       }else{
         return "Valid";
       }
     }

      function condition7($data1 , $data2, $data3, $data4, $data5, $data6, $data7 ){ 
        if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 === "Valid" && $data5 === "Valid" && $data6 === "Valid" && $data7 === "Valid" ){ 
           return "Passed";
        }
        else{
              return "Failed";
        }
        }

        function condition8($data1 , $data2, $data3, $data4, $data5, $data6, $data7, $data8 ){ 
          if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 === "Valid" && $data5 === "Valid" && $data6 === "Valid" && $data7 === "Valid" && $data8 === "Valid" ){ 
             return "Passed";
          }
          else{
                return "Failed";
          }
          }
  
$updplancompanyerror= exists($company);
$updplanNameerror= exists($planname);
$updplantypeerror= exists($type);
$updchooseTargeterror= exists($measure);
$updchoosePMerror= exists($pm);

if($type=="onetime"){
  $updstartdateerror= exists($startdate);
  $updenddateerror= exists($enddate);

  $condition = condition7($updplancompanyerror,$updplanNameerror,$updplantypeerror, $updstartdateerror,$updenddateerror,$updchooseTargeterror,$updchoosePMerror);
}
else if($type=="monthly"){
  $updstartdateerror= exists($startdate);
  $updenddateerror= exists($enddate);
  $updchoosemontherror= exists($month);
  $condition = condition8($updplancompanyerror,$updplanNameerror,$updplantypeerror, $updstartdateerror,$updchoosemontherror,$updenddateerror,$updchooseTargeterror,$updchoosePMerror);
}
else if($type=="annually"){
  $updstartdateerror= exists($startdate);
  $updenddateerror= exists($enddate);
  $updyeartypeerror= exists($year);
  $condition = condition8($updplancompanyerror,$updplanNameerror,$updplantypeerror, $updyeartypeerror,$updstartdateerror,$updenddateerror, $updchooseTargeterror,$updchoosePMerror);
}

if($condition === "Passed"){

   $updatecompensationobject = new Compensation();
   $updatecompensationobject->updateCompensation(array(
   "companyID" =>$company,
   "planName" =>$planname,
   "planType" =>$type,
   "start_date" =>$startdate,
   "end_date" =>$enddate,
   "month" =>$month,
   "year" =>$year,

), $compensationID,"compensationID");

   if($measure){
     $measure= explode(",",$measure);
     $target= explode(",",$target);
     for ($i=0; $i < count($measure); $i++) { 
      $targetobject = new Target();
      $targetobject->updateTarget(array(
         "performanceMetric" =>$pm,
         "measure" =>$measure[$i],
       ),$target[$i],"targetID");
     }
   } 
   else{
    if($measure=="Required"){
      $measure= explode(",",$measure);
      $target= explode(",",$target);
      for ($i=0; $i < count($measure); $i++) { 
      $targetobject->addTarget(array(
      "performanceMetric"=>$pm,
      "measure"=>$measure[$i],
      "compensationID"=>$compensationID,
      ));
    }
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
  "company" => $updplancompanyerror,
  "planname" => $updplanNameerror,
  "startdate" => $updstartdateerror,
  "enddate" => $updenddateerror,
  "month" => $updchoosemontherror,
  "year" => $updyeartypeerror,
  "type" => $updplantypeerror,
  "measure" => $updchooseTargeterror,
  "pm"=> $updchoosePMerror,  
];
}
echo json_encode($array); 
}
?>
