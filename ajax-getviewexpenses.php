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
 $month = escape(Input::get('month'));
 $comp = escape(Input::get('comp'));

$Expense1object = new Expense();
$Bonusobject= new Calculation();

function totalexpenses($budgetSubAllocationID,$month,$year){
$total=0;
$Expenseobject = new Expense();
   $dataexpenses = $Expenseobject->searchexpensessubid($budgetSubAllocationID,$month,$year);
   if($dataexpenses){
  foreach ($dataexpenses as $row) {
$total+=$row->amount;
    }
  }
return $total;
}

function totalbonus($comp,$month,$year){
$totalbonus=0;
$Bonusobject = new Calculation();
   $databonus = $Bonusobject->searchBonus($comp,$month,$year);
   if($databonus){
  foreach ($databonus as $row1) {
$totalbonus+=$row1->Total_Bonus;
    }
  }

return $totalbonus;

}


$mainallocationobject = new Mainallocation();
$data2 = $mainallocationobject->searchmain($comp,$year);
$suballocationobject = new Suballocation();

$grandtotal=$Expense1object->searchexpensestotal($comp,$month,$year);
$grandtotalbonus=$Bonusobject->searchbonustotal($comp,$month,$year);
$grand=$grandtotal->total+ $grandtotalbonus->total;
$othersallocation=0;
$bonusallocation=0;

$view="";
  

if ($data2){
foreach ($data2 as $row2) {
  if($row2->categoryName == "Bonus"){
    $bonusallocation=$row2->budgetAllocated;
  }
  elseif($row2->categoryName ==="Others")
    {
      $data3 = $suballocationobject->searchsub($row2->budgetMainAllocationID);
      if($data3){

  foreach ($data3 as $row3) {
   $othersallocation+=$row3->budgetAllocated;
  }
}}
}

$budgetallocation=($othersallocation + $bonusallocation)/12;
$budgetallocation= round($budgetallocation);
$percentofuse=($grand/$budgetallocation)*100;
$percent= round($percentofuse);

$view.= "
<div class='card my-3'>
                  <div class='card-body'>
                    <div class='row'>
                      <div class='col-12 col-xl-4'>
                        <h6>Budget Allocated</h6>".$budgetallocation." 
                      </div>

                      <div class='col-12 col-xl-4'>
                        <h6>Total Expenses </h6>   ".$grand."                   
                        </div>

                      <div class='col-12 col-xl-4'>
                        <h6>Percentage of Use</h6>".$percent." %
                      </div>
                    </div>
                  </div>
                </div>


";}

if($data2){
  foreach ($data2 as $row2) {
    $grandtotalbonus=0;
    if($row2->categoryName ==="Bonus")
    {
    $totalbonus=totalbonus($comp,$month,$year);
    $grandtotalbonus+=$totalbonus;

    
    $view .= 
    "
 <br>
    <div class='card my-3'>
      <div class='card-body pb-3'>
       <div class='row'>
         <div class='col-12 col-xl-6'>
              <h6 class='mb-n1'><i class='fas fa-bullseye'></i>  ".$row2->categoryName."<i class=''></i> </h6>
            <small><span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: transparent; color: #007bff; border-color: #007bff'></span> <span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: transparent; color: #007bff; border-color: #007bff'></span> </small> <br>  
          </div>

          <div class='col-12 col-xl-4 text-center'>
           <div><b>Amount</b></div>
           <div>".$totalbonus."</div>
          </div>

          <div class='col-12 col-xl-2 text-right'> 
             <a href='#dah1' data-toggle='collapse'> </a>
            <br>
          </div> 

    </div>

        <ul class='nav nav-tabs'>
          <li class='nav-item'>
          <a class='nav-link active' data-toggle='tab' href='#kr1018'>Amount</a>
          </li>
        </ul>
";

$calculationobject = new Calculation();
$databonus = $calculationobject->searchBonus($comp,$month,$year);

  if($databonus){

  foreach ($databonus as $rowbonus) {

$view.="
<div class='row'>
&nbsp;    &nbsp;       
<p class='m-0 pt-2'>
<small class='text-secondary'>Amount: </small> ".$rowbonus->Total_Bonus." <br><br>
</p>

</div> 


    ";
  }}
  $view.="

</div>
</div>
";
  }

    elseif($row2->categoryName ==="Others")
    {
      $data3 = $suballocationobject->searchsub($row2->budgetMainAllocationID);
      $grandtotal=0;
      if($data3){

  foreach ($data3 as $row3) {
    $totalexpenses=totalexpenses($row3->budgetSubAllocationID,$month,$year);
    $grandtotal+=$totalexpenses;
     $view .= 
    "
 <br>
    <div class='card my-3'>
      <div class='card-body pb-3'>
       <div class='row'>
         <div class='col-12 col-xl-6'>
              <h6 class='mb-n1'><i class='fas fa-bullseye'></i>  ".$row3->categoryName."<i class=''></i> </h6>
            <small><span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: transparent; color: #007bff; border-color: #007bff'></span> <span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: transparent; color: #007bff; border-color: #007bff'></span> </small> <br>  
          </div>

          <div class='col-12 col-xl-4 text-center'>
           <div><b>Amount(RM)</b></div>
           <div> ".$totalexpenses."</div>
          </div>

          <div class='col-12 col-xl-2 text-right'> 
             <a href='#dah1' data-toggle='collapse'></a>
            <br>
          </div> 

    </div>

        <ul class='nav nav-tabs'>
          <li class='nav-item'>
          <a class='nav-link active' data-toggle='tab' href='#kr1018'>Amount</a>
          </li>
        </ul>
        <br>

          
    ";
    $Expenseobject = new Expense();
   $dataexpenses = $Expenseobject->searchexpensessubid($row3->budgetSubAllocationID,$month,$year);
   if($dataexpenses){
  foreach ($dataexpenses as $row4) {

    $view.="
    <div class='row'>
    &nbsp;    &nbsp; 
    <p class='m-0 pt-2'>
    <small class='text-secondary'>Amount: </small> ".$row4->amount."
    </p>




    <div class='col-12 col-xl-12 text-right'> 
    <button type='button' class='btn btn-sm btn-white dropdown-toggle-split viewkroption' data-toggle='dropdown'><i class='fas fa-ellipsis-v'></i></button>
    <div class='dropdown-menu dropdown-menu-right'>
    <a href='#' class='dropdown-item updateExpenses' data-toggle='modal' data-backdrop='static' data-target='#updateExpenses' data-id='".$row4->budgetExpensesID."'><i class='far fa-edit'></i> Update </a>
    <a href='#' class='dropdown-item deleteExpenses' data-toggle='modal' data-backdrop='static' data-target='#deleteExpense' data-id='".$row4->budgetExpensesID."'><i class='far fa-trash-alt'></i> Delete </a>
    </div></div></div><br>
    ";

  }}

    $view.="

    
    <button type='button' class='btn btn-outline-dark btn-block rounded-0 addCompExpenses ' data-toggle='modal' data-id='".$row3->budgetSubAllocationID."' data-backdrop='static' data-target='#addCompensation1'><i class='fas fa-plus'></i> Add Expenses</button>

    </div>
    </div>

    ";
    
}
}
  }}
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

  echo json_encode($view);
}
?>