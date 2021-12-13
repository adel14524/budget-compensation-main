
<?php
require_once 'core/init.php';
if(Input::exists()){
  $budgetRevenueID = escape(Input::get('budgetRevenueID'));

  $revenueobject = new Revenue();
  $data = $revenueobject->searchRevenue($budgetRevenueID);
  
    $array = [
    "id"=> $data->budgetRevenueID,
    "updyear"=>$data->year,
    "updrevtype"=>$data->typeRevenue,
    "updrevjan" => $data->january,
    "updrevfeb" => $data->february,
    "updrevmar" => $data->march,
    "updrevapr" => $data->april,
    "updrevmay" => $data->may,
    "updrevjun" => $data->june,
    "updrevjul" => $data->july,
    "updrevaug" => $data->august,
    "updrevsep" => $data->september,
    "updrevoct" => $data->october,
    "updrevnov" => $data->november,
    "updrevdec" => $data->december,
    "company" => $data->companyID,
    "corporate" => $data->corporateID,
    "user" => $data->userID,


    
  ];


  echo json_encode($array);
}
?>