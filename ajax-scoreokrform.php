<?php
require_once 'core/init.php';
$user = new User();
if(!$user->isLoggedIn()){
  Redirect::to("login.php");
}else{
  $resultresult = $user->data();
  $userlevel = $resultresult->role;
  if($resultresult->verified == false || $resultresult->superadmin == true){
    $user->logout();
    Redirect::to("login.php?error=error");
  }
}
if(Input::exists()){
  $krscore = Input::get('krscore');
  $scorekrid = Input::get('scorekrid');

  function exists($data){
    if(empty($data)){
      return "Required";
    }else{
      return "Valid";
    }
  }

  function condition($data1){
    if($data1 === "Valid"){
      return "Passed";
    }else{
      return "Failed";
    }
  }

  $krscoreerrorarray = [];
  for ($i=0; $i < count($krscore); $i++) { 
    if($_POST["krscore"][$i] === "0"){
      $krscoreerror = "Valid";
    }else{
      $krscoreerror = exists($_POST["krscore"][$i]);
    }
    if($krscoreerror === "Valid"){
      if($_POST["krscore"][$i] < 0 || $_POST["krscore"][$i] > 1){
        $krscoreerror = "Must between 0 to 1";
      }else{
        $krscoreerror = "Valid";
      }
    }
    array_push($krscoreerrorarray, $krscoreerror);
  }

  $krscoreerrorarraycheck = array_unique($krscoreerrorarray);

  if(count($krscoreerrorarraycheck) == 1 && $krscoreerrorarraycheck[0] === "Valid"){
    $krscoreerror = "Valid";
  }else{
    $krscoreerror = "Invalid";
  }

  $condition = condition($krscoreerror);

  if($condition === "Passed"){
    try{
      for ($i=0; $i < count($scorekrid); $i++) { 
        $keyresultobject = new Keyresult();
        $keyresultobject->updateKeyresult(array(
          'score' => $_POST["krscore"][$i]
        ), $_POST["scorekrid"][$i], "keyresultID");
      }
      
    }catch (Exception $e){
      echo $e->getMessage();
    }
    $array = [
      "condition" => $condition
    ];
  }else{
    $array = [
      "condition" => $condition,
      "score" => $krscoreerrorarray,
      "error" => $krscoreerror
    ];
  }
  

    echo json_encode($array);
}
?>