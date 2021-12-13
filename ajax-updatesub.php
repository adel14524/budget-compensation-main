
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
      $budgetSubAllocationID = escape(Input::get('subid'));

     /* print_r($budgetSubAllocationID);*/
      $budgetMainAllocationID = escape(Input::get('mainid'));
      $budgetothers = escape(Input::get('budgetothers'));
      $updsubpercent= escape(Input::get('subper'));
      $updsubcategory= escape(Input::get('subcate'));
      $updsubcomp= escape(Input::get('updsubcomp'));

      
      function exists($data){ 
       if(empty($data)){
         return "Required";
       }else{
         return "Valid";
       }
     }

      function updsubcalc($updsubcomp,$budgetMainAllocationID, $budgetSubAllocationID,$updsubpercent){
      $mainallocationobject = new Mainallocation();
      $data = $mainallocationobject->searchmain1($updsubcomp);
      $updatesubobject = new Suballocation();
      $datatrue = $updatesubobject->searchsubmainallocation($budgetMainAllocationID);
      $databaru = $updatesubobject->searchbudgetsubid($budgetSubAllocationID);
      $prevpercent = $databaru->percentAllocation;
      
      $sum=0;
      if ($datatrue){
       foreach ($datatrue as $row ) {

         $sum += $row->percentAllocation;
       }
     }
     $total = ($updsubpercent+$sum)-$prevpercent;
     

     if(($total) > 100){
      return "Sub Allocation exceed 100%. Current allocation: ".$total;
    }else{
      return "Valid" ;
    }
  }

      function condition($data1, $data2){ 
        if($data1 === "Valid" && $data2 === "Valid" ){ 
           return "Passed";
}
else{
    return "Failed";
}
}


$updsubpercenterror = exists($updsubpercent);
if($updsubpercenterror=== "Valid" ){

$percent1error = updsubcalc($updsubcomp,$budgetMainAllocationID, $budgetSubAllocationID,$updsubpercent); 
}
else 
{
    $percent1error ="Required";
}

$lastid=0;
$condition = condition($updsubpercenterror, $percent1error);
if($condition === "Passed"){
   $budget = ($updsubpercent/100)*$budgetothers;
    
    $mainallocationobject = new Mainallocation();
$data = $mainallocationobject->searchmain1($updsubcomp);
if($data){
  foreach ($data as $key) {
    if($key->categoryName ==="Others")
    {
      $lastid=$key->budgetMainAllocationID;
    }
   
  }
}
  $updatesubobject = new Suballocation();
   $updatesubobject->updatesub(array(
   'categoryName' =>$updsubcategory,
   'percentAllocation' =>$updsubpercent,
   'budgetAllocated'=>$budget,
   /*'budgetMainAllocationID'=>$lastid,*/
   
), $budgetSubAllocationID,"budgetSubAllocationID");

   $array = 
[
   "condition" => $condition,
];
}
else{
   $array = 
[
  "condition" => $condition,
  "updsubpercent" => $percent1error,
  "updsubpercent1" => $updsubpercenterror,
 
];
}
echo json_encode($array); 
}
?>
