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

 $year = escape(Input::get('year'));
 $comp = escape(Input::get('comp'));

$budgetInitialobject= new Budgetinitial();
$data1= $budgetInitialobject->searchBudgetCompany($comp, $year);

 $mainallocationobject = new Mainallocation();
 $data = $mainallocationobject->searchmain($comp,$year);


 $totalBudget=0;

  function totalBudget($data1,$data2){
    $total=0;
    $count=count($data1);
    if($count>0){
      foreach ($data1 as $row) {
        $budget = ($row->percentAllocation/100)*$data2;
        $total+= $budget;
      }
    }
return $total;
  }

  $view="";
  if($data1 ){

    
    $view .= 
    "
    <div class='card my-3'>
      <div class='card-body'>
        <div class='row'> 
          <div class='col-12 col-xl-4'>
          <input type='hidden' id='budgetinitialid' name='budgetinitialid' value='".$data1->budgetInitialID."' >
            <h6>Initial Budget (RM)</h6><label id='initialLabel'> ".$data1->initialBudget."</label>
          </div>
          ";

           if($data){
          $totalBudget=totalBudget($data,$data1->initialBudget);
         
           }
           $freebudget=$data1->initialBudget-$totalBudget;
          $view.="
          <div class='col-12 col-xl-4'>
            <h6>Budget Allocated (RM) </h6> ".$totalBudget."
          </div>
          <div class='col-12 col-xl-4'>
            <h6>Budget to be Allocated (RM)</h6> ".$freebudget."
          </div>
        </div>
      </div>
    </div>
              ";
  }
  else{
    $totalBudget="--";
    $freebudget="--";
    $view .= 
    "
    <div class='card my-3'>
      <div class='card-body'>
        <div class='row'> 
          <div class='col-12 col-xl-4'>
          <input type='text' id='budgetinitialid' name='budgetinitialid' value='---' >
          <input class='form-control' type='hidden' id='suballocationid' name='suballocationid' value='0' >

            <h6>Initial Budget (RM)</h6>---
          </div>
          <div class='col-12 col-xl-4'>
            <h6>Budget Allocated (RM) </h6> ".$totalBudget."
          </div>
          <div class='col-12 col-xl-4'>
            <h6>Budget to be Allocated (RM)</h6> ".$freebudget."
          </div>
        </div>
      </div>
    </div>

    
    <div class='card box rounded-0'>
    <div class='card-body'>
    <b>Please set budget at Budget Setup first</b>
    </div>
    </div>
              ";
  }
if($data1){
  if($data){
    $addmain="";
    $editmain="<button type='button' style='float:right' class='btn btn-sm btn-white dropdown-toggle-split viewkroption' data-toggle='dropdown'><i class='fas fa-ellipsis-v'></i></button>";
  }
   else{
    $addmain="<button style='float:right' type='button' class='btn btn-primary shadow-sm saveMain1' data-toggle='modal' data-target='#mainmodal'>Set Main</button><br><br>";
    $editmain="";
  }
  $view.=" 
  ".$addmain."".$editmain."
  ";

  if($data) {
    $view.="
    
    <div class='dropdown-menu dropdown-menu-right'>
    <a href='#' class='dropdown-item updatemainmodal' data-id='".$data1->budgetInitialID."' data-toggle='modal' data-backdrop='static' data-target='#updatemainmodal'><i class='far fa-edit'></i> Edit </a></div>
    <table  style='width:100%' class='table'>
    <thead>
    <tr style='text-align: center;'>
    <th >Category</th>
    <th >Percentage of Allocation (%)</th>
    <th >Budget Allocated (RM)</th>
    </tr>
    </thead>
    ";
    $lastid=0;  
    foreach ($data as $row) {

      if($row->categoryName ==="Others" )
      {
        $lastid=$row->budgetMainAllocationID;
      }
      $budget = ($row->percentAllocation/100)*$data1->initialBudget;

      $view .=
      "
      <tbody>
      <tr style='text-align:center;' >
      <td>".$row->categoryName."</td>
      <td>".$row->percentAllocation."</td>
      <td> ".$budget."</td>

      </tr>
      ";
    }
    $view.=
"
</tbody>
</table>
<input class='form-control' type='hidden' id='suballocationid' name='suballocationid' value='".$lastid."' >
               ";
  }
  elseif($data==null){
    $view .= 
    "
    <input class='form-control' type='hidden' id='suballocationid' name='suballocationid' value='0' >
    <div class='card box rounded-0'>
    <div class='card-body'>
    <b>No data found</b>
    </div>
    </div>


    ";
  }

}
           
echo json_encode($view);
}
?>