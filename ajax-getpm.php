<?php
require_once 'core/init.php';
if(Input::exists()){
  $compensationID = escape(Input::get('compensationID'));

  $compensation = new Compensation();
  $data = $compensation->searchbudgetcompensation($compensationID);

  $target = new Target();
  $data2 = $target->searchTargetCompensation($compensationID);

    $array = [
    "id" => $data->compensationID,
    "planname" => $data->planName,
    "startdate" => $data->start_date,
    "enddate" => $data->end_date,
    "type" => $data->planType,
    // "target" => $data2->targetType,
    "measure" => $data2->measure,
    "pm"=> $data2->performanceMetric,
    "company" => $data->companyID,
    
  ];


  echo json_encode($array);
}
?>