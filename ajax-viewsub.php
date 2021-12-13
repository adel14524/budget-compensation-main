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
  $budgetMainAllocationID = escape(Input::get('subid'));
  $budgetInitialID = escape(Input::get('budgetinitialid'));

  function totalBudget2($data1,$data2){
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

  if($budgetMainAllocationID!="0"){
    $mainobject = new Mainallocation();
    $mainresult = $mainobject->searchbudgetmain($budgetMainAllocationID);
    $main2=$mainresult->budgetAllocated;

    $suballocationobject = new Suballocation();
    if($resultresult->userID){
      $data = $suballocationobject->searchsub($budgetMainAllocationID);
    }
    $totalBudget=0;

    if($data){
      $totalBudget=totalBudget2($data,$main2);
    }
    $freebudget=$main2-$totalBudget;

    $view = "<div class='card my-3'>
    <div class='card-body'>
    <div class='row'>  
    <div class='col-12 col-xl-4'>
    <h6>Initial Budget (RM)</h6><label id='initialsublabel'>".$main2."</label>
    </div>
    <div class='col-12 col-xl-4'>
    <h6>Budget Allocated (RM)</h6>".$totalBudget."
    </div>

    <div class='col-12 col-xl-4'>
    <h6>Budget to be Allocated (RM)</h6>".$freebudget."
    </div>
    </div>
    </div>
    </div>

    <button style='float:right' type='button' class='btn btn-primary shadow-sm saveSub1' data-toggle='modal' data-target='#submodal'>Set Sub</button><br><br>
    ";


    if($data){

      $view .= 
      "
      <table  style='width:100%' class='table'>
      <thead>
      <tr style='text-align: center;'>
      <th >Category</th>
      <th >Percentage of Allocation (%)</th>
      <th >Budget Allocated (RM)</th>
      <th >Action</th>

      </tr>
      </thead>

      ";
      foreach ($data as $row) {
        $budgetsub = ($row->percentAllocation/100)*$main2;

        $view .=
        "
        <tbody>
        <tr style='text-align:center;' >
        <td>".$row->categoryName."</td>
        <td>".$row->percentAllocation."</td>
        <td>".$budgetsub."</td>
        <td><button type='button' class='btn btn-sm btn-white dropdown-toggle-split viewkroption' data-toggle='dropdown'><i class='fas fa-ellipsis-v'></i></button>
        <div class='dropdown-menu dropdown-menu-right'>
        <a href='#'' class='dropdown-item updatesub' data-id='".$row->budgetSubAllocationID."' data-toggle='modal' data-backdrop='static' data-target='#updatesub'><i class='far fa-edit'></i> Edit </a>
        <a href='#' class='dropdown-item deletesub' data-toggle='modal' data-backdrop='static' data-target='#deletesubmodal' data-id='".$row->budgetSubAllocationID."'><i class='far fa-trash-alt'></i> Delete </a></td>

        </tr>
        ";
      }

      $view.=
      "
      </tbody>
      </table>

      ";
    }

    else{
      $view .= 
      "
      <div class='card box rounded-0'>
      <div class='card-body'>
      <b>No data found</b>
      </div>
      </div>

      ";
    }
  }

  elseif($budgetMainAllocationID=="0" && $budgetInitialID=="---" ){
    $view .= 
      "
      <div class='card box rounded-0'>
      <div class='card-body'>
      <b>No budget being setup</b>
      </div>
      </div>
      ";
  }
  else{
    $view .= 
      "
      <div class='card box rounded-0'>
      <div class='card-body'>
      <b>No main added</b>
      </div>
      </div>
      ";
  }

echo json_encode($view);
}
?>