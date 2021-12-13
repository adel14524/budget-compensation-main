
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
      $budgetRevenueID = escape(Input::get('budgetRevenueID'));
      $updyear = escape(Input::get('updyear'));
      $updrevtype = escape(Input::get('updrevtype'));
      $updrevjan= escape(Input::get('updrevjan'));
      $updrevfeb= escape(Input::get('updrevfeb'));
      $updrevmar= escape(Input::get('updrevmar'));
      $updrevapr= escape(Input::get('updrevapr'));
      $updrevmay= escape(Input::get('updrevmay'));
      $updrevjun= escape(Input::get('updrevjun'));
      $updrevjul= escape(Input::get('updrevjul'));
      $updrevaug= escape(Input::get('updrevaug'));
      $updrevsep= escape(Input::get('updrevsep'));
      $updrevoct= escape(Input::get('updrevoct'));
      $updrevnov= escape(Input::get('updrevnov'));
      $updrevdec= escape(Input::get('updrevdec'));
      $updrevcorporate= escape(Input::get('updrevcorporate'));
      $updrevuser= escape(Input::get('updrevuser'));
      $updrevcompany= escape(Input::get('updrevcompany'));

 
      function exists($data){ 
       if(empty($data)){
         return "Required";
       }else{
         return "Valid";
       }
     }

      function condition($data1, $data2, $data3, $data4, $data5, $data6, $data7, $data8, $data9, $data10, $data11, $data12, $data13){ 
        if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 === "Valid" && $data5 === "Valid" && $data6 === "Valid" && $data7 === "Valid" && $data8 === "Valid" && $data9 === "Valid" && $data10 === "Valid" && $data11 === "Valid" && $data12 === "Valid"  && $data13 === "Valid"){ 
           return "Passed";
}
else{
    return "Failed";
}
}

$updyearerror = exists($updyear);
$updrevtypeerror = exists($updrevtype);
$updrevJanerror = exists($updrevjan);
$updrevFeberror = exists($updrevfeb);
$updrevMarerror = exists($updrevmar);
$updrevAprerror = exists($updrevapr);
$updrevMayerror = exists($updrevmay);
$updrevJunerror = exists($updrevjun);
$updrevJulerror = exists($updrevjul);
$updrevAugerror = exists($updrevaug);
$updrevSeperror = exists($updrevsep);
$updrevOcterror = exists($updrevoct);
$updrevNoverror = exists($updrevnov);
$updrevDecerror = exists($updrevdec);

$condition = condition($updrevtypeerror,$updrevJanerror,$updrevFeberror,$updrevMarerror,$updrevAprerror,$updrevMayerror, $updrevJunerror,$updrevJulerror,$updrevAugerror,$updrevSeperror,$updrevOcterror, $updrevNoverror, $updrevDecerror);

if($condition === "Passed"){

   $revenueobject = new Revenue();
   $revenueobject->updateRevenue(array(
   "year" =>$updyear,
   "typeRevenue" =>$updrevtype,
   "january" =>$updrevjan,
   "february" =>$updrevfeb,
   "march" =>$updrevmar,
   "april" =>$updrevapr,
   "may" =>$updrevmay,
   "june" =>$updrevjun,
   "july" =>$updrevjul,
   "august" =>$updrevaug,
   "september" =>$updrevsep,
   "october" =>$updrevoct,
   "november" =>$updrevnov,
   "december" =>$updrevdec,

), $budgetRevenueID,"budgetRevenueID");

      $revenueobject = new Revenue();
      $revenueobject->addRevenueLog(array(
        'budgetRevenueID'=>$budgetRevenueID,
       'typeRevenueLog'=>$updrevtype,
       'yearLog'=> $updyear,
        'januaryLog' =>$updrevjan,
        'februaryLog' =>$updrevfeb,
        'marchLog' =>$updrevmar,
        'aprilLog' =>$updrevapr,
        'mayLog' =>$updrevmay,
        'juneLog' =>$updrevjun,
        'julyLog' =>$updrevjul,
        'augustLog' =>$updrevaug,
        'septemberLog' =>$updrevsep,
        'octoberLog' =>$updrevoct,
        'novemberLog' =>$updrevnov,
        'decemberLog' =>$updrevdec,
        'action' =>"update",

        'userID' =>$updrevuser,
        'corporateID' =>$updrevcorporate,
        'companyID' =>$updrevcompany,
   ));
   $array = 
[
   "condition" => $condition,
];
}
else{
   $array = 
[
  "condition" => $condition,
  "updrevtype" => $updrevtypeerror,
  "updrevjan" => $updrevJanerror,
  "updrevfeb" => $updrevFeberror,
  "updrevmar" => $updrevMarerror,
  "updrevapr" => $updrevAprerror,
  "updrevmay" => $updrevMayerror,
  "updrevjun" => $updrevJunerror,
  "updrevjul" => $updrevJulerror,
  "updrevaug" => $updrevAugerror,
  "updrevsep" => $updrevSeperror,
  "updrevoct" => $updrevOcterror,
  "updrevnov" => $updrevNoverror,
  "updrevdec" => $updrevDecerror,
];
}
echo json_encode($array); 
}
?>
