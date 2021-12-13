<?php
require_once 'core/init.php';

if(Input::exists()){

  $budgetInitialID = escape(Input::get('budgetInitialID'));
  $budget = new Budgetinitial();
  $data = $budget->searchBudgetInitial($budgetInitialID);

    $array = [
      "id" => $data->budgetInitialID,
      "corporateID"=>$data->corporateID,
      "company"=>$data->companyID,
      "userID"=>$data->userID,
      "year"=>$data->year,
      "nptarget" =>$data->netProfitTarget,
      "percentbudget"=>$data->percentBudget,
      "initialbudget"=>$data->initialBudget
  ];
  echo json_encode($array);
}
?>