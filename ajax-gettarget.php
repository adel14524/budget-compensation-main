<?php
require_once 'core/init.php';
if(Input::exists()){
  $compensationID = escape(Input::get('compensationID'));


  $target = new Target();
  $data2 = $target->searchTarget($compensationID);

 if($data2){
  foreach($data2 as $row){
    $userobj = new User();
    $data = $userobj->searchUserID($data2->measure);

  if($data){
      foreach ($data as $row2) {
        $firstname= $row2->firstname;
        $lastname = $row2->lastname;
    }
    }
    }
    }
    $array = [
    "id" => $data2->compensationID,
    "measure" => $data2->measure, 
    "fname"=>$firstname,
    "lname"=>$lastname,   
  ];
  echo json_encode($array);
}
?>