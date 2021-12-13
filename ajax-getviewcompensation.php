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

 $company = escape(Input::get('comp'));
 $year = escape(Input::get('year'));

 $compensationobject = new Compensation();
 $data= $compensationobject->searchCompensation($company,$year);

function planType($compensationID){
  $compensationobject = new Compensation();
  $data= $compensationobject->searchbudgetcompensation($compensationID);

 if($data){
    if($data->planType=="onetime"){
    $plantype="<span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: transparent; color: #007bff; border-color: #007bff'>".$data->planType."</span>";
  }
  else if($data->planType=="monthly"){
    $plantype="<span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: transparent; color: green; border-color: green'>".$data->planType."</span>";
  }
  else if($data->planType=="annually"){
    $plantype="<span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: transparent; color: maroon; border-color: maroon'>".$data->planType."</span>";
  }
  
 }
 return $plantype;
}

$view="";

if ($data){
  foreach ($data as $row) {
$targetobject = new Target();
$data2=$targetobject->searchTarget($row->compensationID);
    
if ($data2) {
  foreach ($data2 as $row2) {
    if($row2->performanceMetric=="Revenue"){
      $metric= "<span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: transparent; color: #007bff; border-color: #007bff'>".$row2->performanceMetric."</span>";
    }
    elseif($row2->performanceMetric=="Gross Profit"){
      $metric= "<span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: transparent; color: green; border-color: green'>".$row2->performanceMetric."</span>";
    }
    elseif($row2->performanceMetric=="Key Performance Indicator"){
      $metric= "<span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: transparent; color: yellow; border-color: yellow'>".$row2->performanceMetric."</span>";
    }
  }
}
// print_r($metric)

    $view .= 
        "
        <br>
        <div class='card my-3'>
        <div class='card-body pb-3'>
          <div class='row'>
            <div class='col-12 col-xl-6'>
             <h6 class='mb-n1'><i class='fas fa-bullseye'></i> ".$row->planName."</h6>
             <small>".planType($row->compensationID)."
             </small> 
             <small>".$metric."
             </small> <br>
            </div>
           
          <div class='col-2 col-xl-2 '>
             <b> Start Date </b>
            <div>".$row->start_date."  </div>
          </div>

        <div class='col-2 col-xl-2 '>
          <b>End Date </b>
          <div>".$row->end_date."  </div>
        </div>


        <div class='col-12 col-xl-2 text-right'>
          <button type='button' class='btn btn-sm btn-white dropdown-toggle-split compensationplan' data-companyID='".$row->companyID."' data-toggle='dropdown'><i class='fas fa-ellipsis-v'></i></button>
              <div class='dropdown-menu dropdown-menu-right'>
               <a href='#' class='dropdown-item updateplancompensation' data-toggle='modal' data-backdrop='static' data-target='#updateplancompensation'  data-id='".$row->compensationID."'><i class='far fa-edit'></i> Update </a>
              <a href='#' class='dropdown-item deleteCompensation' data-toggle='modal' data-backdrop='static'     data-target='#deleteCompensation' data-id='".$row->compensationID."'><i class='far fa-trash-alt'></i> Delete </a>
              </div>
        </div>

          </div>

<ul class='nav nav-tabs'>
  <li class='nav-item'>
    <a class='nav-link active' data-toggle='tab' href='#conditiontab".$row->compensationID."'>Condition</a>
  </li>
  <li class='nav-item'>
    <a class='nav-link ' data-toggle='tab' href='#targettab".$row->compensationID."'>Target</a>
  </li>
</ul>

<div class='tab-content'>
  <div class='tab-pane active' id='conditiontab".$row->compensationID."'>
  

 ";
      $conditionobject = new Condition();
      $data3=$conditionobject->searchcondition($row->compensationID);
      $count=0;
      if($data3){

        foreach ($data3 as $row3) {
          $count++;
           $rewardobject= new Reward();
           $data4 =$rewardobject->searchReward($row3->cond_indID);
           $badgeobject= new Badge();
           $data5 =$badgeobject->searchBadge($row3->cond_indID);

      $view.="
       
      <div class='row'>  
      <div class='col-12 col-xl-12 text-right'> 
        <button type='button' class='btn btn-sm btn-white dropdown-toggle-split viewkroption' data-toggle='dropdown'><i class='fas fa-ellipsis-v'></i></button>
        <div class='dropdown-menu dropdown-menu-right'>
          <a href='#' class='dropdown-item updateCondition' data-toggle='modal' data-backdrop='static' data-target='#updateCondition' data-id='".$row3->cond_indID."'><i class='far fa-edit'></i> Update </a>
          <a href='#' class='dropdown-item deleteCondition' data-toggle='modal' data-backdrop='static' data-target='#deleteCondition' data-id='".$row3->cond_indID."'><i class='far fa-trash-alt'></i> Delete </a>
        </div>
      </div>

       <div class='col-sm-2'>          
        <h6 class ='text-secondary'>Condition ".$count.": </h6></div>
        <div class='col-sm-6'>
        <h6> ".$row2->performanceMetric." ".$row3->operator." ".$row3->value." </h6>
       </div>
      </div>

     ";

      if($data4){
        $count1=0;
        foreach ($data4 as $row4) {
          $count1++;
          $view.="

          <div class='row'>
            <div class='col-sm-2'>      
              <h6 class ='text-secondary'>Reward ".$count1.": </h6>
            </div>
          <div class='col-sm-6'>      
            <h6 class='mb-n1'> ".$row4->rewardName." ".$row4->rewardAmt."  </h6>
          </div>
      </div>";
        }
      }
          if ($data5) {
            foreach ($data5 as $row5) {
              // $count1++;
                $view.="
        <div class='row'>
        <div class='col-sm-2'>      
          <h6 class ='text-secondary'>Reward : </h6>
        </div>
          <div class='col-sm-6'>      
                <h6>Badge: ".$row5->badgeQuantity." ".$row5->badgeName."  </h6>
          </div>
        </div><br>
              ";
            
          }          }
                
     
      
 }} $view.="
   <button type='button' class='btn btn-outline-dark btn-block rounded-0 addindCondition ' data-toggle='modal' data-id='".$row->compensationID."' data-backdrop='static' data-target='#addindCondition'><i class='fas fa-plus'></i> Add Condition</button> 

 </div> ";
$view.="
<div class='tab-pane' id='targettab".$row->compensationID."'> ";


if($data2){
      foreach ($data2 as $row1) {
      $userobject= new User();
      $datauser=$userobject->searchOnly($row1->measure);
      if($datauser){
        $firstname=$datauser->firstname;
        $lastname=$datauser->lastname;
        if($datauser->profilepic){
          $pic = "data:image/jpeg;base64,".base64_encode($datauser->profilepic);
        }else{
          $pic = "img/userprofile.png";
        }

        $view.="
        <img src='".$pic."' class='rounded-circle' width='40' height='40'> ".$firstname." ".$lastname."<br>
        ";


      }
     }}

$view.="

</div>
</div>
</div>
</div>
        ";

  }
   }
    
 else{
        $view .= 
          "
          <br>
          <div class='card box rounded-0'>
            <div class='card-body'>
              <b>No data found</b>
            </div>
          </div>
          ";
        }

 echo json_encode($view);
}
?>