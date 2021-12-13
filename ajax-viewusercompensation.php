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


$usercompensationobject = new Compensation();
$targetobject= new Target();
$targetresult=$targetobject->searchmeasure($resultresult->userID);


$view="";
$view.="<div class='col-xl-12 col-12 text-right'>
      <button type='button' class='btn btn-primary shadow-sm' data-toggle='modal' data-id='".$resultresult->userID."' data-backdrop='static' data-target='#badgesdetailsmodal' id='badgesdetails'>My Badges</button>
    </div><br>";
  

if($targetresult){
  $view.="
  <div class='table-responsive text-nowrap'>
  <table class='table table-hover'>
  <thead>
  <tr>
  <th>Plan Name</th>
  <th>Type</th>
  <th>Action</th>
  </tr>
  </thead>";
   
foreach($targetresult as $row1 ){
$data = $usercompensationobject->searchCompensationbyid($row1->compensationID); 

if($data){ 

foreach($data as $row){

$view.="

 <tbody>
  <tr>
  <td>".$row->planName."</td>
  <td>".$row->planType."</td>
  <td class='editDelBtn' data-toggle='modal' data-id=".$row->compensationID." data-target='#userdetailsmodal' id='userdetails'><a href='#userdetails' >View Details</a></td>

  </tr>

  ";
}
  
}
}

$view.="
    </tbody></table></div>
  ";
}
 else{
  $view.= 
          "
          <br>
          <div class='card box rounded-0'>
            <div class='card-body'>
              <b>No data found</b>
            </div>
          </div>
          ";
 }

 


 echo $view;

?>