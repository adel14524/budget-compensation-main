
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
      $updidmain = escape(Input::get('id'));
      $updidmain2 = escape(Input::get('id2'));
      $updmainyear = escape(Input::get('year'));
      $updinitial = escape(Input::get('budget'));
      $updmaincomp= escape(Input::get('company'));
      $updcorporate = escape(Input::get('corporate'));
      $upduser = escape(Input::get('user'));
      $bonus = escape(Input::get('bonuscat'));
      $others = escape(Input::get('otherscat'));
      $updbonus = escape(Input::get('bonusper'));
      $updothers = escape(Input::get('othersper'));
      


      function exists($data)
      { 
       if(empty($data)){
         return "Required";
       }else{
         return "Valid";
       }
      }

     function condition($data1,$data2)
     { 
      if($data1 === "Valid" && $data2 === "Valid"  )
      { 
       return "Passed";
      }
     else{
      return "Failed";
      }
      }

  $updbonuspercenterror = exists($updbonus);
  $updotherspercenterror = exists($updothers);

  if($updbonuspercenterror === "Valid"){
    $sum=$updbonus+$updothers;
     if(($sum) > 100){
        $updbonuspercenterror="Main Allocation exceed 100%. Current allocation:".$sum;
      }else{
       $updbonuspercenterror="Valid";
      }
   
  }else{
    $updbonuspercenterror = "Required";
  }

  $condition = condition($updbonuspercenterror,$updotherspercenterror);
  if($condition === "Passed"){

    $a =floatval($updbonus);
    $b =floatval($updothers);
    $c =floatval($updinitial);


      $budget = ($a/100)*$c;
      $budget2 = ($b/100)*$c;

      $updatemainobject = new Mainallocation();
      $updatemainobject->updatemain(array(
        'categoryName' =>$bonus,
        'percentAllocation' =>$updbonus,
        'budgetAllocated'=>$budget,
        'year'=>$updmainyear,
        'corporateID'=>$updcorporate,
        'companyID'=>$updmaincomp,
        'userID'=>$upduser,
      ), $updidmain, "budgetMainAllocationID"
      );

       $updatemainobject->updatemain(array(
        'categoryName' =>$others,
        'percentAllocation' =>$updothers,
        'budgetAllocated'=>$budget2,
        'year'=>$updmainyear,
        'corporateID'=>$updcorporate,
        'companyID'=>$updmaincomp,
        'userID'=>$upduser,
      ),
       $updidmain2, "budgetMainAllocationID"
      ); 


       $subobj = new Suballocation();
       $subresult = $subobj->searchsub($updidmain2);
       if($subresult){
         foreach($subresult as $row){
           $budgetSubAllocationID= $row->budgetSubAllocationID;
           $budgetallocated = ($row->percentAllocation/100)*$budget2;

            $subobj->updatesub(array(
            "budgetAllocated"=>$budgetallocated,
           
           ),$budgetSubAllocationID,"budgetSubAllocationID");

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
  "updbonus" => $updbonuspercenterror,
  "updothers" => $updotherspercenterror,
  
  
];
}
echo json_encode($array); 
}
?>
