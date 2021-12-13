
<?php
require_once 'core/init.php';
if(Input::exists()){
  $budgetGrossProfitID = escape(Input::get('budgetGrossProfitID'));

  $gprofit = new Grossprofit();
  $data = $gprofit->searchbudgetgrossprofit($budgetGrossProfitID);




    $array = [
    "id"=> $data->budgetGrossProfitID,
    "updgpJan"=>$data->january,
    "updgpFeb"=>$data->february,
    "updgpMar"=>$data->march,
    "updgpApr"=>$data->april,
    "updgpMay"=>$data->may,
    "updgpJun"=>$data->june,
    "updgpJul"=>$data->july,
    "updgpAug"=>$data->august,
    "updgpSept"=>$data->september,
    "updgpOct"=>$data->october,
    "updgpNov"=>$data->november,
    "updgpDec"=>$data->december,
    
 

   
    
  ];


  echo json_encode($array);
}
?>