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
$companyID= escape(Input::get('companyID'));
$compensationplanobject = new Compensation();

$view="";
if($companyID=="All"){
 $data = $compensationplanobject->searchAllCompensationcorp($resultresult->corporateID); 
 if($data){
  $view.="
  <div class='table-responsive text-nowrap' id='searchcompensationlist'>
  <table class='table table-hover'>
  <thead>
  <tr >
  <th>Company</th>
  <th>Plan Name</th>
  <th>Type</th>
  <th>Performance Metric</th>
  <th>Duration</th>
  <th></th>
  <th></th>
  </tr>
  </thead>";

  foreach($data as $row){
    $companyobject = new Company();
    $companyresult = $companyobject->searchCompany($row->companyID);
    $companyname = $companyresult->company; 

    $target = new Target();
    $targetresult = $target->searchtargetcompensation($row->compensationID);
    $actualvalue = $targetresult->actual;

        $view.="
          
          <tbody>
          <tr class='searchcompensation'>
          <td>".$companyname."</td>
          <td>".$row->planName."</td>
          <td>".$row->planType."</td>
          <td>".$targetresult->performanceMetric."</td>
          <td>".$row->start_date."  ".$row->end_date."</td>";
          if($actualvalue){
            $view.="
           <td><button style='cursor:not-allowed;' class='badge badge-primary' data-toggle='modal' id='updatetarget' data-id='".$row->compensationID."' data-target='#updateactualpm' disabled>Update</button></td>";
          }
          else{
            $view.="
            <td><button class='badge badge-primary' data-toggle='modal' id='updatetarget' data-id='".$row->compensationID."' data-target='#updateactualpm'>Update</button></td>";
          }

          $view.="
          <td class='editDelBtn' data-toggle='modal' data-id='".$row->compensationID."'  id='viewdetails' data-target='#updateactualpmmodal'><a href='#updateactualpmmodal' >View Details</a></td>
          </tr>
          </tbody>
          ";
}
  $view.="</table></div>
  "
;
}
}

else{
  $data2=$compensationplanobject->searchCompanyCompensation($companyID);

if($data2){
  $view.="<div class='table-responsive text-nowrap'>
<table class='table table-hover'>
  <thead>
    <tr >
    <th>Company</th>
    <th>Plan Name</th>
    <th>Type</th>
    <th>Duration</th>
    <th></th>
    <th></th>

    </tr>
  </thead>";

  foreach($data2 as $row){
    $companyobject = new Company();
    $companyresult = $companyobject->searchCompany($row->companyID);
    $companyname = $companyresult->company; 
    $target = new Target();
    $targetresult = $target->searchtargetcompensation($row->compensationID);
    $actualvalue = $targetresult->actual;

$view.="
  
  <tbody>
  <tr>
  <td>".$companyname."</td>
  <td>".$row->planName."</td>
  <td>".$row->planType."</td>
  <td>".$row->start_date."  ".$row->end_date."</td>";
  if($actualvalue){
    $view.="
   <td><button style='cursor:not-allowed;' class='badge badge-primary' data-toggle='modal' id='updatetarget' data-id='".$row->compensationID."' data-target='#updateactualpm' disabled>Update</button></td>";
  }
  else{
    $view.="
    <td><button class='badge badge-primary' data-toggle='modal' id='updatetarget' data-id='".$row->compensationID."' data-target='#updateactualpm'>Update</button></td>";
  }

  $view.="
  
  <td class='editDelBtn' data-toggle='modal' data-id='".$row->compensationID."'  id='viewdetails' data-target='#updateactualpmmodal'><a href='#updateactualpmmodal' >View Details</a></td>  </tr>
  </tbody>
  ";
}
  $view.="</table></div>
  <script>
  function disable(i){
      $('#updatetarget'+i).prop(\"disabled\",true);
  }
  </script>
  "
;
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

}


 echo $view;
}
?>