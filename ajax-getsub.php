
<?php
require_once 'core/init.php';
if(Input::exists()){
  $budgetSubAllocationID = escape(Input::get('budgetSubAllocationID'));

  $suballocate = new Suballocation();
  $data = $suballocate->searchbudgetsub($budgetSubAllocationID);

  $mainallocate = new Mainallocation();
  $data2 = $mainallocate->searchbudgetmain($data->budgetMainAllocationID);

    $array = [
    "id"=> $data->budgetSubAllocationID,
    /*"updsubcomp"=>$data->companyID,*/
    "updsubcategory" => $data->categoryName,
    "updsubpercent" => $data->percentAllocation,
    "mainid"=>$data->budgetMainAllocationID,
    "budgetothers"=>$data2->budgetAllocated,
  ];


  echo json_encode($array);
}
?>