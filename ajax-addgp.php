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
     
      $gpJan = escape(Input::get('G1'));
      $gpFeb = escape(Input::get('G2'));
      $gpMar = escape(Input::get('G3'));
      $gpApr= escape(Input::get('G4'));
      $gpMay= escape(Input::get('G5'));
      $gpJun= escape(Input::get('G6'));
      $gpJul= escape(Input::get('G7'));
      $gpAug= escape(Input::get('G8'));
      $gpSept= escape(Input::get('G9'));
      $gpOct= escape(Input::get('G10'));
      $gpNov= escape(Input::get('G11'));
      $gpDec= escape(Input::get('G12'));
     
      $addgpuser= escape(Input::get('addgpuser'));
      $choosegpcomp= escape(Input::get('choosegpcomp'));
      $choosegpyear= escape(Input::get('choosegpyear'));
      $addgpcorporate= escape(Input::get('addgpcorporate'));

      function exists($data){ // to check empty data
       if(empty($data)){
         return "Required";
       }else{
         return "Valid";
       }
     }

      function condition ($data1, $data2, $data3, $data4, $data5, $data6, $data7, $data8, $data9, $data10, $data11, $data12){ 
        if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 === "Valid" && $data5 === "Valid" && $data6 === "Valid" && $data7 === "Valid" && $data8 === "Valid" && $data9 === "Valid" && $data10 === "Valid" && $data11 === "Valid" && $data12 === "Valid"){ 
           return "Passed";
}else{
    return "Failed";
}
}


$gpJanerror = exists($gpJan);
$gpFeberror = exists($gpFeb);
$gpMarerror = exists($gpMar);
$gpAprerror = exists($gpApr);
$gpMayerror = exists($gpMay);
$gpJunerror = exists($gpJun);
$gpJulerror = exists($gpJul);
$gpAugerror = exists($gpAug);
$gpSepterror = exists($gpSept);
$gpOcterror = exists($gpOct);
$gpNoverror = exists($gpNov);
$gpDecerror = exists($gpDec);


$condition = condition($gpJanerror, $gpFeberror, $gpMarerror, $gpAprerror, $gpMayerror, $gpJunerror, $gpJulerror, $gpAugerror, $gpSepterror,$gpOcterror, $gpNoverror, $gpDecerror);
if($condition === "Passed"){

   $gpobject = new Grossprofit();
   $gpobject->addgrossprofit(array(
     
     'january' =>$gpJan,
     'february' =>$gpFeb,
     'march' =>$gpMar,
     'april' =>$gpApr,
     'may' =>$gpMay,
     'june' =>$gpJun,
     'july' =>$gpJul,
     'august' =>$gpAug,
     'september' =>$gpSept,
     'october' =>$gpOct,
     'november' =>$gpNov,
     'december' =>$gpDec,
     'userID' =>$addgpuser,
     'companyID' =>$choosegpcomp,
      'year' =>$choosegpyear,
     'corporateID' =>$addgpcorporate,
));

   $array = 
[
   "condition" => $condition,
];
}else{
   $array = 
[
  "condition" => $condition,
 
  "gpJan" => $gpJanerror,
  "gpFeb" => $gpFeberror,
  "gpMar" => $gpMarerror,
  "gpApr" => $gpAprerror,
  "gpMay" => $gpMayerror,
  "gpJun" => $gpJunerror,
  "gpJul" => $gpJulerror,
  "gpAug" => $gpAugerror,
  "gpSept" => $gpSepterror,
  "gpOct" => $gpOcterror,
  "gpNov" => $gpNoverror,
  "gpDec" => $gpDecerror,
];
}
echo json_encode($array); // For AJAX, always must return some value back to where you call which can refer to javascript, for here, we return an array with condition and error. 
}
?>
