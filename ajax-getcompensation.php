<?php
require_once 'core/init.php';
if(Input::exists()){
  $compensationID = escape(Input::get('compensationID'));

  $compensation = new Compensation();
  $data = $compensation->searchcompensation1($compensationID);
  

  $measure=array();
  $targetid=array();
  if($data){
  $target = new Target();
  $data2 = $target->searchtargetcompensation2($compensationID);
  

  foreach($data2 as $row)
  {
   array_push($measure, $row->measure);  
   array_push($targetid, $row->targetID);

   $pm=$row->performanceMetric; 
  }
 
  }
    $array = [
    "id" => $data->compensationID,
    "planname" => $data->planName,
    "type" => $data->planType,
    "startdate" => $data->start_date,
    "enddate" => $data->end_date,
    "month" => $data->month,
    "year" => $data->year,
    "measure" => $measure,
    "pm"=> $pm,
    "company" => $data->companyID,
    "target"=>$targetid,
    
  ];


  echo json_encode($array);
}
?>