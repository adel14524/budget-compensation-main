
<?php
require_once 'core/init.php';
if(Input::exists()){
  $budgetExpensesID = escape(Input::get('budgetExpensesID'));

  $expenses = new Expense();
  $data = $expenses->searchbudgetexpenses($budgetExpensesID);




    $array = [
    "id" => $data->budgetExpensesID,
    "date" => $data->date,
    "amount" => $data->amount,
    "description" => $data->description,
    /*"corporateID" => $data->corporateID,
    "companyID" => $data->companyID,
    "userID" => $data->userID,*/
    "budgetSubAllocationID" => $data->budgetSubAllocationID,
    
  ];


  echo json_encode($array);
}
?>