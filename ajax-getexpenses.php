
<?php
require_once 'core/init.php';
if(Input::exists()){
  $budgetExpensesID = escape(Input::get('budgetExpensesID'));
  $month = escape(Input::get('month'));
  $div = escape(Input::get('div'));
  $balance = escape(Input::get('balance'));
  $budgetallocated = escape(Input::get('budgetallocated'));

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
    "month" => $month,
    "div" => $div,
    "balance" => $balance,
    "budgetallocated" => $budgetallocated
  ];


  echo json_encode($array);
}
?>