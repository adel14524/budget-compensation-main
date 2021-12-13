
<?php
require_once 'core/init.php';
if(Input::exists()){
  $budgetinitialID = escape(Input::get('budgetinitialID'));

  $mainallocate = new Mainallocation();
  $data = $mainallocate->searchbudgetmain2($budgetinitialID);
  // $data2 = $mainallocate->searchbudgetmain3($budgetMainAllocationID);

  $budgetinitial =new Budgetinitial();
  $budgetresult =$budgetinitial->searchBudgetInitial($budgetinitialID);

  $category=array();
// print_r($category);
  foreach($data as $row)
  {
   array_push($category, $row->budgetMainAllocationID); 
   // array_push($percent, $row->percentAllocation); 
  
  }
  foreach ($category as $row1) 
  {
    $data2=$mainallocate->searchbudget($row1);

    foreach($data2 as $row2){
      if($row2->categoryName==="Bonus"){
        $bonus=$row2;
     }
     elseif($row2->categoryName==="Others"){
        $others=$row2;
     }
    }
  }
    $array = [
    "id"=> $bonus->budgetMainAllocationID,
    "id2"=> $others->budgetMainAllocationID,
    "budget"=>$budgetresult->initialBudget,
    "bonus"=>$bonus->percentAllocation,
    "others"=>$others->percentAllocation,
    "company"=>$bonus->companyID,
    "corporate"=>$bonus->corporateID,
    "user"=>$bonus->userID,
    "year"=>$bonus->year,

    // "id"=> $data2->budgetMainAllocationID,
    // "updpercent"=>$percent,
     ];
  echo json_encode($array);
}
?>