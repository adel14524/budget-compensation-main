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
 $budgetinitialobject = new Budgetinitial();
 $companyobject = new Company ();

    if($resultresult->userID){
    $data = $budgetinitialobject->searchBudget($resultresult->userID,$year);
  }
  if ($userlevel == "Chief"){
    $listcompany = $companyobject->searchCompanyCorporate($resultresult->corporateID);  

    $view = "";

    if($data){
            $view .= 
            "
           <div class='table-responsive text-nowrap'>
             <table  class='table '>
               <thead>
                 <tr style='text-align:center;'>
                   <th>COMPANY</th>
                   <th>NET PROFIT</th>
                   <th>PERCENTAGE OF ALLOCATION</th>
                   <th>INITIAL BUDGET</th>
                   <th>ACTION</th>
                 </tr>
               </thead>
               ";
               foreach ($data as $row) {
                $companyresult = $companyobject->searchCompany($row->companyID);
                $companyname = $companyresult ->company;
    $view .=
    "
             <tbody>
               <tr style='text-align:center;'>
                 <td><b>".$companyname."</b> </td>
                 <td>".$row->netProfitTarget."</td>
                 <td>".$row->percentBudget."</td>
                 <td>".$row->initialBudget."</td>
                 <td class='editDelBtn'>
                               <div class='dropdown'>
                                 <button type='button' data-toggle='dropdown' class='btn btn-sm btn-white dropdown-toggle-split
                                  '><i class='fas fa-ellipsis-v'></i></button>
                                 <div class='dropdown-menu dropdown-menu-right'>
                                   <a class='dropdown-item updatebudgetinitial' data-toggle='modal' data-target='#updatebudgett' data-id='".$row->budgetInitialID."'><i class='fas fa-chart-line'></i>  Update</a>
                                   <a class='dropdown-item deleteBudgetInitial' data-toggle='modal' data-target='#delbudget' data-id='".$row->budgetInitialID."'><i class='far fa-trash-alt'></i>  Delete</a>
                                 </div>
                               </div>
                            
                             </td>              
               </tr>
            ";
    }
    $view.=
    "
               </tbody>
              </table>
            </div> ";}

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
  elseif ($userlevel== "Superior"){
    $listcompany = $companyobject->searchCompanyLeadership($resultresult->userID);  
    $view = "";

    if($listcompany){
            $view .= 
            "
           <div class='table-responsive text-nowrap'>
             <table  class='table '>
               <thead>
                 <tr style='text-align:center;'>
                   <th>COMPANY</th>
                   <th>NET PROFIT</th>
                   <th>PERCENTAGE OF ALLOCATION</th>
                   <th>INITIAL BUDGET</th>
                   <th>ACTION</th>
                 </tr>
               </thead>
               ";
               foreach ($listcompany as $data) {
                $budgetresult = $budgetinitialobject->searchBudgetCompany2($data->companyID,$year);
                if($budgetresult){


               foreach ($budgetresult as $row) {
                $companyresult = $companyobject->searchCompany($row->companyID);
                $companyname = $companyresult ->company;
    $view .=
    "
             <tbody>
               <tr style='text-align:center;'>
                 <td><b>".$companyname."</b> </td>
                 <td>".$row->netProfitTarget."</td>
                 <td>".$row->percentBudget."</td>
                 <td>".$row->initialBudget."</td>
                 <td class='editDelBtn'>
                               <div class='dropdown'>
                                 <button type='button' data-toggle='dropdown' class='dots'><i class='fas fa-ellipsis-v'></i></button>
                                 <div class='dropdown-menu dropdown-menu-right'>
                                   <a class='dropdown-item updatebudgetinitial' data-toggle='modal' data-target='#updatebudgett' data-id='".$row->budgetInitialID."'><i class='fas fa-chart-line'></i>  Update</a>
                                   <a class='dropdown-item deleteBudgetInitial' data-toggle='modal' data-target='#delbudget' data-id='".$row->budgetInitialID."'><i class='far fa-trash-alt'></i>  Delete</a>
                                 </div>
                               </div>
                            
                             </td>              
               </tr>
            ";
    }}}
    $view.=
    "
               </tbody>
              </table>
            </div> ";}

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
  // print_r($year);

      echo json_encode($view);
        // echo ($view);
}
?>