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
  $subcategory = escape(Input::get('subC'));
  $subpercent = escape(Input::get('subP'));
  $subcomp= escape(Input::get('compadd'));
 /* $subcomp = escape(Input::get('subcomp'));*/
  $subyear = escape(Input::get('subyear'));
  $addsubuser= escape(Input::get('addsubuser'));
  $addsubcorporate= escape(Input::get('addsubcorporate'));
  $initial= escape(Input::get('budgetothers'));


      function exists($data){ // to check empty data
       if(empty($data)){
         return "Required";
       }else{
         return "Valid";
       }
     }

     function subcalc( $subcomp,$subyear,$subpercent){
      $mainallocationobject = new Mainallocation();
      $data = $mainallocationobject->searchmain($subcomp,$subyear);

      $lastid=0;
      if($data){
        foreach ($data as $key) {
          if($key->categoryName ==="Others")
          {
            $lastid=$key->budgetMainAllocationID;

          }

        }
      }
     /* print_r($lastid);*/

      $Subobject = new Suballocation();
      $datatrue = $Subobject->searchsuballocation($lastid);
      
      $sum=0;
      if ($datatrue){
       foreach ($datatrue as $row ) {

         $sum += $row->percentAllocation;
       }
     }

     $total = (int)$subpercent+ $sum;

     if(($total) > 100){
      return "Sub Allocation exceed 100%. Current allocation: ".$total;
    }else{
      return "Valid" ;
    }
  }

      function condition ($data1, $data2, $data3){ 
        if($data1 === "Valid" && $data2 === "Valid" && $data3 === "Valid" ){ 
           return "Passed";
}else{
    return "Failed";
}
}


$budget2 = ((int)$subpercent/100)*(int)$initial;


$subcategoryerror = exists($subcategory);
$addsubcomperror = exists($subcomp);
$subpercenterror = exists($subpercent);
if($subpercenterror=== "Valid" ){

$percent1error = subcalc($subcomp,$subyear,$subpercent); 
}
else 
{
    $percent1error ="Required";
}


$lastid=0;
$condition = condition($subcategoryerror, $subpercenterror, $percent1error);
if($condition === "Passed"){
$mainallocationobject = new Mainallocation();
$data = $mainallocationobject->searchmain($subcomp,$subyear);
if($data){
  foreach ($data as $key) {
    if($key->categoryName ==="Others")
    {
      $lastid=$key->budgetMainAllocationID;
    }
   
  }
}
   $subobject = new Suballocation();
   $subobject->addsub(array(
     'categoryName' =>$subcategory,
     'percentAllocation' =>$subpercent,
     'budgetAllocated'=>$budget2,
     'budgetMainAllocationID'=>$lastid,
));

   $array = 
[
   "condition" => $condition,
    
];
}else{
   $array = 
[
  "condition" => $condition,
  "subcategory" => $subcategoryerror,
  "subpercent" => $percent1error,
  "subpercent1" =>$subpercenterror,
  /*"addsubcomp"=> $addsubcomperror,
  'budgetAllocated'=>$budget2,*/

 
];
}
echo json_encode($array); // For AJAX, always must return some value back to where you call which can refer to javascript, for here, we return an array with condition and error. 
}
?>
