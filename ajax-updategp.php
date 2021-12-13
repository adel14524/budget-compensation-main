
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
      $budgetGrossProfitID = escape(Input::get('gpid'));
      $updgpJan= escape(Input::get('updgpJan'));
      $updgpFeb= escape(Input::get('updgpFeb'));
      $updgpMar= escape(Input::get('updgpMar'));
      $updgpApr= escape(Input::get('updgpApr'));
      $updgpMay= escape(Input::get('updgpMay'));
      $updgpJun= escape(Input::get('updgpJun'));
      $updgpJul= escape(Input::get('updgpJul'));
      $updgpAug= escape(Input::get('updgpAug'));
      $updgpSept= escape(Input::get('updgpSept'));
      $updgpOct= escape(Input::get('updgpOct'));
      $updgpNov= escape(Input::get('updgpNov'));
      $updgpDec= escape(Input::get('updgpDec'));
      
 

      function exists($data){ 
       if(empty($data)){
         return "Required";
       }else{
         return "Valid";
       }
     }

      function condition($data1, $data2, $data3, $data4, $data5, $data6, $data7, $data8, $data9, $data10, $data11, $data12){ 
        if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 === "Valid" && $data5 === "Valid" && $data6 === "Valid" && $data7 === "Valid"&& $data8 === "Valid" && $data9 === "Valid" && $data10 === "Valid" && $data11 === "Valid" && $data12 === "Valid"){ 
           return "Passed";
}
else{
    return "Failed";
}
}

$updgpJanerror = exists($updgpJan);
$updgpFeberror = exists($updgpFeb);
$updgpMarerror = exists($updgpMar);
$updgpAprerror = exists($updgpApr);
$updgpMayerror = exists($updgpMay);
$updgpJunerror = exists($updgpJun);
$updgpJulerror = exists($updgpJul);
$updgpAugerror = exists($updgpAug);
$updgpSepterror = exists($updgpSept);
$updgpOcterror = exists($updgpOct);
$updgpNoverror = exists($updgpNov);
$updgpDecerror = exists($updgpDec);


$condition = condition($updgpJanerror,$updgpFeberror,$updgpMarerror,$updgpAprerror,$updgpMayerror,$updgpJunerror,$updgpJulerror,$updgpAugerror,$updgpSepterror,$updgpOcterror,$updgpNoverror,$updgpDecerror);
if($condition === "Passed"){

   $updategpobject = new Grossprofit();
   $updategpobject->updategrossprofit(array(
   /*"companyID" =>$updcomp1,*/

   "january" =>$updgpJan,
   "february" =>$updgpFeb,
   "march" =>$updgpMar,
   "april" =>$updgpApr,
   "may" =>$updgpMay,
   "june" =>$updgpJun,
   "july" =>$updgpJul,
   "august" =>$updgpAug,
   "september" =>$updgpSept,
   "october" =>$updgpOct,
   "november" =>$updgpNov,
   "december" =>$updgpDec,
   
), $budgetGrossProfitID,"budgetGrossProfitID");

   $array = 
[
   "condition" => $condition,
];
}
else{
   $array = 
[
  "condition" => $condition,
  "updgpJan" => $updgpJanerror,
  "updgpFeb" => $updgpFeberror,
  "updgpMar" => $updgpMarerror,
  "updgpApr" => $updgpAprerror,
  "updgpMay" => $updgpMayerror,
  "updgpJun" => $updgpJunerror,
  "updgpJul" => $updgpJulerror,
  "updgpAug" => $updgpAugerror,
  "updgpSept" => $updgpSepterror,
  "updgpOct" => $updgpOcterror,
  "updgpNov" => $updgpNoverror,
  "updgpDec" => $updgpDecerror,
 
  
  
];
}
echo json_encode($array); 
}
?>
