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
      $typeRevenue = escape(Input::get('addtyperev'));
      $year = escape(Input::get('year'));
      $jan = escape(Input::get('janrev'));
      $feb = escape(Input::get('febrev'));
      $mar = escape(Input::get('marrev'));
      $apr = escape(Input::get('aprrev'));
      $may = escape(Input::get('mayrev'));
      $jun = escape(Input::get('junrev'));
      $jul = escape(Input::get('julrev'));
      $aug = escape(Input::get('augrev'));
      $sep = escape(Input::get('seprev'));
      $oct = escape(Input::get('octrev'));
      $nov = escape(Input::get('novrev'));
      $dec = escape(Input::get('decrev'));

      $addrevcorporate = escape(Input::get('addrevcorp'));
      $addrevuser = escape(Input::get('addrevuser'));
      $addrevcomp = escape(Input::get('addrevcompany'));


// print_r($addrevcorporate);
      function exists($data){ // to check empty data
       if(empty($data)){
         return "Required";
       }else{
         return "Valid";
       }
     }

      function condition ($data1, $data2, $data3, $data4, $data5, $data6, $data7, $data8, $data9, $data10, $data11, $data12, $data13 ){ 
        if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" && $data4 === "Valid" && $data5 === "Valid" && $data6 === "Valid" && $data7 === "Valid" && $data8 === "Valid" && $data9 === "Valid" && $data10 === "Valid" && $data11 === "Valid" && $data12 === "Valid" && $data13 === "Valid"  ){ 
           return "Passed";
}else{
    return "Failed";
}
}

      $revtypeerror = exists($typeRevenue);
      $revJanerror = exists($jan);
      $revFeberror = exists($feb);
      $revMarerror = exists($mar);
      $revAprerror = exists($apr);
      $revMayerror = exists($may);
      $revJunerror = exists($jun);
      $revJulerror = exists($jul);
      $revAugerror = exists($aug);
      $revSeperror = exists($sep);
      $revOcterror = exists($oct);
      $revNoverror = exists($nov);
      $revDecerror = exists($dec);

$condition = condition($revtypeerror,$revJanerror,$revFeberror,$revMarerror,$revAprerror,$revMayerror,$revJunerror,$revJulerror,$revAugerror,$revSeperror,$revOcterror,$revNoverror,$revDecerror);
if($condition === "Passed"){

   $revenueobject = new Revenue();
   $revenueobject->addRevenue(array(
    'typeRevenue'=>$typeRevenue,
    'year'=> $year,
     'january' =>$jan,
     'february' =>$feb,
     'march' =>$mar,
     'april' =>$apr,
     'may' =>$may,
     'june' =>$jun,
     'july' =>$jul,
     'august' =>$aug,
     'september' =>$sep,
     'october' =>$oct,
     'november' =>$nov,
     'december' =>$dec,

     'userID' =>$addrevuser,
     'corporateID' =>$addrevcorporate,
     'companyID' =>$addrevcomp,
));   $id=$revenueobject->lastInsertId();

      $revenueobject = new Revenue();
      $revenueobject->addRevenueLog(array(
        'budgetRevenueID'=>$id,
       'typeRevenueLog'=>$typeRevenue,
       'yearLog'=> $year,
        'januaryLog' =>$jan,
        'februaryLog' =>$feb,
        'marchLog' =>$mar,
        'aprilLog' =>$apr,
        'mayLog' =>$may,
        'juneLog' =>$jun,
        'julyLog' =>$jul,
        'augustLog' =>$aug,
        'septemberLog' =>$sep,
        'octoberLog' =>$oct,
        'novemberLog' =>$nov,
        'decemberLog' =>$dec,
        'action' =>"add",

        'userID' =>$addrevuser,
        'corporateID' =>$addrevcorporate,
        'companyID' =>$addrevcomp,
   ));
      //    $revenueobject = new Revenue();
      //    $revenueobject->searchRevenueLog(array(
      //      'budgetRevenueID'=>$id,
      //     'typeRevenueLog'=>$typeRevenue,
      //     'yearLog'=> $year,
      //      'januaryLog' =>$jan,
      //      'februaryLog' =>$feb,
      //      'marchLog' =>$mar,
      //      'aprilLog' =>$apr,
      //      'mayLog' =>$may,
      //      'juneLog' =>$jun,
      //      'julyLog' =>$jul,
      //      'augustLog' =>$aug,
      //      'septemberLog' =>$sep,
      //      'octoberLog' =>$oct,
      //      'novemberLog' =>$nov,
      //      'decemberLog' =>$dec,
      //      'action' =>"add",


      //      'userID' =>$addrevuser,
      //      'corporateID' =>$addrevcorporate,
      //      'companyID' =>$addrevcomp,
      // ));
   $array = 
[
   "condition" => $condition,
];
}else{
   $array = 
[
  "condition" => $condition,
  "typeRevenue"=>$revtypeerror,
  "jan" => $revJanerror,
  "feb" => $revFeberror,
  "mar" => $revMarerror,
  "apr" => $revAprerror,
  "may" => $revMayerror,
  "jun" => $revJunerror,
  "jul" => $revJulerror,
  "aug" => $revAugerror,
  "sep" => $revSeperror,
  "oct" => $revOcterror,
  "nov" => $revNoverror,
  "dec" => $revDecerror,

];
}
echo json_encode($array); // For AJAX, always must return some value back to where you call which can refer to javascript, for here, we return an array with condition and error. 
}
?>
