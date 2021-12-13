<?php
require_once 'core/init.php';
$userlevel = "";
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Calendar - DoerHRM</title> 
  <?php
  include 'includes/header.php';
  ?>
</head>


<body>
  <?php include 'includes/topbar.php';?>
  <div class="d-flex" id="wrapper">
    <?php include 'includes/navbar.php';?>
    <div id="page-content-wrapper">
    <div class="container-fluid" id="content"> 
      <div class="row my-4">
        <div class="col">
          <h4 class="m-0"><i class="fa fa-calendar"></i> Calendar</h4>
        </div>
      </div>
      

      <ul class="nav nav-tabs row px-2">
        <li class="nav-item col-12 col-xl-2 p-0">
          <a class="nav-link rounded-0 text-center active" data-toggle="tab" href="#mainAllocation"><span class="font-weight-bold">Expenses</span></a>
        </li>
        <li class="nav-item col-12 col-xl-2 p-0">
          <a class="nav-link rounded-0 text-center" data-toggle="tab" href="#allocation"><span class="font-weight-bold">Overview</span></a>
        </li>
        
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">
        <div class="tab-pane active" id="mainAllocation">
          <div class="row mt-3">
            <div class="col-xl-12 col-12">
              <br>

                <form class="form-inline">
      <select class="form-control" style="width: 25%" id="companyyy" name="companyyy">
                      <option value="">Obsnap Calibration</option>
                      <option value="">Doerpreneur Soft</option>
                      <option value="">Victor Manufacturing</option>
                      <option value="">Obsnap Automation</option>
                      <option value="">Obsnap Instrument</option>
                      <option value="">Permata Bumi</option>
                      <option value="">JS Analytical</option>
                      <option value="">Victor Equipment Resources</option>
                      <option value="">Obsnap International</option>
                      <option value="">Obsnap Instrument(Penang)Sdn Bhd</option>
      </select>
      &nbsp;&nbsp;
      
           <label for="months"></label>
           <select class="form-control" style="width:25%; transition: box-shadow .3s" name="months" id="months">
          <option value="14">Jan - 2020</option>
          <option value="15">Feb- 2020</option>
                    <option value="20">March 2020</option>
                    <option value="77">Apr - 2020</option>
          <option value="78">May - 2020</option>
          <option value="79">June - 2020</option>
                    <option value="92">Aug - 2020</option>
                    <option value="93">Sep - 2020</option>
          <option value="119">Oct - 2020</option>
                    <option value="152">Nov - 2020</option>
                    <option value="200">Dec - 2020</option>
                    
                    </select></form>

    <br>

<div class="card my-3">
                <div class="card-body">
        <div class="row">
        <div class="col-12 col-xl-4">
                <h6>Budget Allocated</h6>RM 1000
        </div>
        
        <div class="col-12 col-xl-4">
        <h6>Total Expenses </h6> RM 800
        </div>
        
        <div class="col-12 col-xl-4">
        <h6>Percentage of Allocation</h6> 20%
        </div>
        </div>
        </div>
        </div>


<!-- Compensation -->

        <div class="card my-3">
      <div class="card-body pb-3">
            <div class="row">
            <div class="col-12 col-xl-6">
              <h6 class="mb-n1"><i class="fas fa-bullseye"></i> <i class="fas fa-exclamation-circle text-danger alignstatus"></i> Compensation</h6>
              <small><span class="badge badge-pill badge-primary" style="border: 1px solid #007bff; background-color: transparent; color: #007bff; border-color: #007bff"></span> <span class="badge badge-pill badge-primary" style="border: 1px solid #007bff; background-color: transparent; color: #007bff; border-color: #007bff"></span> </small> <br>  
            </div>
      
           <div class="col-12 col-xl-4 text-center">
            <div><b>Amount</b></div>
      <div> RM 1000</div>
            </div>
      
           <div class="col-12 col-xl-2 text-right"> 
               <a href="#dah1" data-toggle="collapse"> <i class="fas fa-history"></i></a>
         <button type="button" class="btn btn-sm btn-white dropdown-toggle-split viewkroption" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
               <div class="dropdown-menu dropdown-menu-right">
               <a href="#" class="dropdown-item editKR" data-id="2344" data-toggle="modal" data-backdrop="static" data-target="#editPlan"><i class="far fa-edit"></i> Edit </a>
               <a href="#" class="dropdown-item deleteKR" data-id="2344" data-toggle="modal" data-backdrop="static" data-target="#deleteplan"><i class="far fa-trash-alt"></i> Delete </a>
          </div>
           <br>
          </div>  
          </div>
      
                <ul class="nav nav-tabs">
                  <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#kr1018">Amount</a>
                  </li>
                </ul>
        
              
                      <div class="row">
                        <div class="col-12 col-xl-6">
                          <p class="m-0 pt-2">
                            <small class="text-secondary">Amount 1 : </small>
                               RM1500
                           </p>
                        </div>
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    
                       &nbsp;
                   
                        <div class="col-12 col-xl-2 text-right"> 
                        
                      <button type="button" class="btn btn-sm btn-white dropdown-toggle-split viewkroption" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item editKR" data-id="2344" data-toggle="modal" data-backdrop="static" data-target="#editKeyResult"><i class="far fa-edit"></i> Edit </a>
                        <a href="#" class="dropdown-item deleteKR" data-id="2344" data-toggle="modal" data-backdrop="static" data-target="#deletekeyresult"><i class="far fa-trash-alt"></i> Delete </a>
                      </div></div></div>
                    <br>
                  
                      <div class="row">
                        <div class="col-12 col-xl-6">
                          <p class="m-0 pt-2">
                            <small class="text-secondary">Amount 2 : </small>
                               RM1500
                           </p>
                        </div>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    
                       &nbsp;
                   
                        <div class="col-12 col-xl-2 text-right"> 
                        
                      <button type="button" class="btn btn-sm btn-white dropdown-toggle-split viewkroption" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item editKR" data-id="2344" data-toggle="modal" data-backdrop="static" data-target="#editKeyResult"><i class="far fa-edit"></i> Edit </a>
                        <a href="#" class="dropdown-item deleteKR" data-id="2344" data-toggle="modal" data-backdrop="static" data-target="#deletekeyresult"><i class="far fa-trash-alt"></i> Delete </a>
                      </div>
                        </div> 
                        <br><br>
                        <button type="button" class="btn btn-outline-dark btn-block addKeyResult rounded-0" data-toggle="modal" data-id="1018" data-backdrop="static" data-target="#addCompensation"><i class="fas fa-plus"></i> Add Expenses</button>
                  <div class="col-12">
                        <div class="collapse" id="dah1">
                          <div class="card my-2 rounded-0">
                            <div class="card-body" style="max-height: 300px; overflow-y: scroll">
                              <b>Expenses History</b>
                              <p>22/1/2021 Compensation added 100 </p>
                <p>24/1/2021 Compensation deleted 100 </p>
                                <center><button type="button" class="btn btn-sm btn-block btn-secondary rounded-0" onclick="loadlatestdaprogress(2487)">Show All Remarks</button></center>
                    
                            </div>
                          </div>
                        </div>
                      </div>

                         </div> 
                        </div>

                        <div class="card-body pb-3">
            <div class="row">
            <div class="col-12 col-xl-6">
              <h6 class="mb-n1"><i class="fas fa-bullseye"></i> <i class="fas fa-exclamation-circle text-danger alignstatus"></i> Expand</h6>
              <small><span class="badge badge-pill badge-primary" style="border: 1px solid #007bff; background-color: transparent; color: #007bff; border-color: #007bff"></span> <span class="badge badge-pill badge-primary" style="border: 1px solid #007bff; background-color: transparent; color: #007bff; border-color: #007bff"></span> </small> <br>  
            </div>
      
           <div class="col-12 col-xl-4 text-center">
            <div><b>Amount</b></div>
      <div> RM 1000</div>
            </div>
      
           <div class="col-12 col-xl-2 text-right"> 
               <a href="#dah2" data-toggle="collapse"> <i class="fas fa-history"></i></a>
         <button type="button" class="btn btn-sm btn-white dropdown-toggle-split viewkroption" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
               <div class="dropdown-menu dropdown-menu-right">
               <a href="#" class="dropdown-item editKR" data-id="2344" data-toggle="modal" data-backdrop="static" data-target="#editPlan"><i class="far fa-edit"></i> Edit </a>
               <a href="#" class="dropdown-item deleteKR" data-id="2344" data-toggle="modal" data-backdrop="static" data-target="#deleteplan"><i class="far fa-trash-alt"></i> Delete </a>
          </div>
           <br>
          </div>  
          </div>
      
                <ul class="nav nav-tabs">
                  <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#kr1018">Amount</a>
                  </li>
                </ul>
        
                        
                
                      <div class="row">
                        <div class="col-12 col-xl-6">
                          <p class="m-0 pt-2">
                            <small class="text-secondary">Amount 1 : </small>
                               RM1500
                           </p>
                        </div>
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    
                       &nbsp;
                   
                        <div class="col-12 col-xl-2 text-right"> 
                        
                      <button type="button" class="btn btn-sm btn-white dropdown-toggle-split viewkroption" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item editKR" data-id="2344" data-toggle="modal" data-backdrop="static" data-target="#editKeyResult"><i class="far fa-edit"></i> Edit </a>
                        <a href="#" class="dropdown-item deleteKR" data-id="2344" data-toggle="modal" data-backdrop="static" data-target="#deletekeyresult"><i class="far fa-trash-alt"></i> Delete </a>
                      </div></div></div>
                    <br>
                  
                      <div class="row">
                        <div class="col-12 col-xl-6">
                          <p class="m-0 pt-2">
                            <small class="text-secondary">Amount 2 : </small>
                               RM1500
                           </p>
                        </div>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    
                       &nbsp;
                   
                        <div class="col-12 col-xl-2 text-right"> 
                        
                      <button type="button" class="btn btn-sm btn-white dropdown-toggle-split viewkroption" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item editKR" data-id="2344" data-toggle="modal" data-backdrop="static" data-target="#editKeyResult"><i class="far fa-edit"></i> Edit </a>
                        <a href="#" class="dropdown-item deleteKR" data-id="2344" data-toggle="modal" data-backdrop="static" data-target="#deletekeyresult"><i class="far fa-trash-alt"></i> Delete </a>
                      </div>
                        </div> 
                        <br><br>
                        <button type="button" class="btn btn-outline-dark btn-block addKeyResult rounded-0" data-toggle="modal" data-id="1018" data-backdrop="static" data-target="#addAmountExpand"><i class="fas fa-plus"></i> Add Expenses</button>
                  <div class="col-12">
                        <div class="collapse" id="dah2">
                          <div class="card my-2 rounded-0">
                            <div class="card-body" style="max-height: 300px; overflow-y: scroll">
                              <b>Expenses History</b>
                              <p>22/1/2021 Expand added 100 </p>
                <p>24/1/2021 Expand deleted 100 </p>
                                <center><button type="button" class="btn btn-sm btn-block btn-secondary rounded-0" onclick="loadlatestdaprogress(2487)">Show All Remarks</button></center>
                    
                            </div>
                          </div>
                        </div>
                      </div>

                         </div> 
                        </div>


                        <!-- Backup-->
                        <div class="card-body pb-3">
            <div class="row">
            <div class="col-12 col-xl-6">
              <h6 class="mb-n1"><i class="fas fa-bullseye"></i> <i class="fas fa-exclamation-circle text-danger alignstatus"></i> Backup</h6>
              <small><span class="badge badge-pill badge-primary" style="border: 1px solid #007bff; background-color: transparent; color: #007bff; border-color: #007bff"></span> <span class="badge badge-pill badge-primary" style="border: 1px solid #007bff; background-color: transparent; color: #007bff; border-color: #007bff"></span> </small> <br>  
            </div>
      
           <div class="col-12 col-xl-4 text-center">
            <div><b>Amount</b></div>
      <div> RM 1000</div>
            </div>
      
           <div class="col-12 col-xl-2 text-right"> 
               <a href="#dah3" data-toggle="collapse"> <i class="fas fa-history"></i></a>
         <button type="button" class="btn btn-sm btn-white dropdown-toggle-split viewkroption" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
               <div class="dropdown-menu dropdown-menu-right">
               <a href="#" class="dropdown-item editKR" data-id="2344" data-toggle="modal" data-backdrop="static" data-target="#editPlan"><i class="far fa-edit"></i> Edit </a>
               <a href="#" class="dropdown-item deleteKR" data-id="2344" data-toggle="modal" data-backdrop="static" data-target="#deleteplan"><i class="far fa-trash-alt"></i> Delete </a>
          </div>
           <br>
          </div>  
          </div>
      
                <ul class="nav nav-tabs">
                  <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#kr1018">Amount</a>
                  </li>
                </ul>
        
                        
                 
                      <div class="row">
                        <div class="col-12 col-xl-6">
                          <p class="m-0 pt-2">
                            <small class="text-secondary">Amount 1 : </small>
                               RM1500
                           </p>
                        </div>
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    
                       &nbsp;
                   
                        <div class="col-12 col-xl-2 text-right"> 
                        
                      <button type="button" class="btn btn-sm btn-white dropdown-toggle-split viewkroption" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item editKR" data-id="2344" data-toggle="modal" data-backdrop="static" data-target="#editKeyResult"><i class="far fa-edit"></i> Edit </a>
                        <a href="#" class="dropdown-item deleteKR" data-id="2344" data-toggle="modal" data-backdrop="static" data-target="#deletekeyresult"><i class="far fa-trash-alt"></i> Delete </a>
                      </div></div></div>
                    <br>
                 
                      <div class="row">
                        <div class="col-12 col-xl-6">
                          <p class="m-0 pt-2">
                            <small class="text-secondary">Amount 2 : </small>
                               RM1500
                           </p>
                        </div>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    
                       &nbsp;
                   
                        <div class="col-12 col-xl-2 text-right"> 
                        
                      <button type="button" class="btn btn-sm btn-white dropdown-toggle-split viewkroption" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item editKR" data-id="2344" data-toggle="modal" data-backdrop="static" data-target="#editKeyResult"><i class="far fa-edit"></i> Edit </a>
                        <a href="#" class="dropdown-item deleteKR" data-id="2344" data-toggle="modal" data-backdrop="static" data-target="#deletekeyresult"><i class="far fa-trash-alt"></i> Delete </a>
                      </div>
                        </div> 
                        <br><br>
                        <button type="button" class="btn btn-outline-dark btn-block addKeyResult rounded-0" data-toggle="modal" data-id="1018" data-backdrop="static" data-target="#addAmountBackup"><i class="fas fa-plus"></i> Add Expenses</button>
                  <div class="col-12">
                        <div class="collapse" id="dah3">
                          <div class="card my-2 rounded-0">
                            <div class="card-body" style="max-height: 300px; overflow-y: scroll;">
                              <b>Expenses History</b>
                              <p>22/1/2021 Backup added 100 </p>
                      <p>24/1/2021 Backup deleted 100 </p>
                                <center><button type="button" class="btn btn-sm btn-block btn-secondary rounded-0" onclick="loadlatestdaprogress(2487)">Show All Remarks</button></center>
                    
                            </div>
                          </div>
                        </div>
                      </div>

                         </div> 
                        </div>


                        <!-- bonus -->
        <div class="card-body pb-3">
            <div class="row">
            <div class="col-12 col-xl-6">
              <h6 class="mb-n1"><i class="fas fa-bullseye"></i> <i class="fas fa-exclamation-circle text-danger alignstatus"></i> Bonus & Incentives</h6>
              <small><span class="badge badge-pill badge-primary" style="border: 1px solid #007bff; background-color: transparent; color: #007bff; border-color: #007bff"></span> <span class="badge badge-pill badge-primary" style="border: 1px solid #007bff; background-color: transparent; color: #007bff; border-color: #007bff"></span> </small> <br>  
            </div>
      
           <div class="col-12 col-xl-4 text-center">
            <div><b>Amount</b></div>
      <div> RM 1000</div>
            </div>
      
           <div class="col-12 col-xl-2 text-right"> 
               <a href="#dah4" data-toggle="collapse"> <i class="fas fa-history"></i></a>
         <button type="button" class="btn btn-sm btn-white dropdown-toggle-split viewkroption" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
               <div class="dropdown-menu dropdown-menu-right">
               <a href="#" class="dropdown-item editKR" data-id="2344" data-toggle="modal" data-backdrop="static" data-target="#editPlan"><i class="far fa-edit"></i> Edit </a>
               <a href="#" class="dropdown-item deleteKR" data-id="2344" data-toggle="modal" data-backdrop="static" data-target="#deleteplan"><i class="far fa-trash-alt"></i> Delete </a>
          </div>
           <br>
          </div>  
          </div>
      
                <ul class="nav nav-tabs">
                  <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#kr1018">Amount</a>
                  </li>
                </ul>
        
                        
                 
                      <div class="row">
                        <div class="col-12 col-xl-6">
                          <p class="m-0 pt-2">
                            <small class="text-secondary">Amount 1 : </small>
                               RM1500
                           </p>
                        </div>
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    
                       &nbsp;
                   
                        <div class="col-12 col-xl-2 text-right"> 
                        
                      <button type="button" class="btn btn-sm btn-white dropdown-toggle-split viewkroption" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item editKR" data-id="2344" data-toggle="modal" data-backdrop="static" data-target="#editKeyResult"><i class="far fa-edit"></i> Edit </a>
                        <a href="#" class="dropdown-item deleteKR" data-id="2344" data-toggle="modal" data-backdrop="static" data-target="#deletekeyresult"><i class="far fa-trash-alt"></i> Delete </a>
                      </div></div></div>
                    <br>
                 
                      <div class="row">
                        <div class="col-12 col-xl-6">
                          <p class="m-0 pt-2">
                            <small class="text-secondary">Amount 2 : </small>
                               RM1500
                           </p>
                        </div>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    &nbsp;    
                       &nbsp;
                   
                        <div class="col-12 col-xl-2 text-right"> 
                        
                      <button type="button" class="btn btn-sm btn-white dropdown-toggle-split viewkroption" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item editKR" data-id="2344" data-toggle="modal" data-backdrop="static" data-target="#editKeyResult"><i class="far fa-edit"></i> Edit </a>
                        <a href="#" class="dropdown-item deleteKR" data-id="2344" data-toggle="modal" data-backdrop="static" data-target="#deletekeyresult"><i class="far fa-trash-alt"></i> Delete </a>
                      </div>
                        </div> 
                        <br><br>
                        <button type="button" class="btn btn-outline-dark btn-block addKeyResult rounded-0" data-toggle="modal" data-id="1018" data-backdrop="static" data-target="#addAmountBonus"><i class="fas fa-plus"></i> Add Expenses</button>
                  <div class="col-12">
                        <div class="collapse" id="dah4">
                          <div class="card my-2 rounded-0">
                            <div class="card-body" style="max-height: 300px; overflow-y: scroll">
                              <b>Expenses History</b>
                              <p>22/1/2021 Bonus added 100 </p>
                <p>24/1/2021 Bonus deleted 100 </p>
                                <center><button type="button" class="btn btn-sm btn-block btn-secondary rounded-0" onclick="loadlatestdaprogress(2487)">Show All Remarks</button></center>
                    
                            </div>
                          </div>
                        </div>
                      </div>

                         </div> 
                        </div>



                       </div>

              </div>
          </div>


        </div>
<br>
        <!-- Sub Allocation -->
        <div class="tab-pane" id="allocation">

          <br>
          <table  style="width:100%" class="table ">
            <thead>
                        <tr style="background-color:lightgray">
                            <th scope="col">Month</th>
                            <th scope="col">Budget</th>
                            <th scope="col">Actual</th>
                            <th scope="col">Balance</th>
                            <th scope="col">% of Expenses</th>
                        </tr>
                    </thead>
                    <tr  >
                            <td>January</td>
                            <td>833.30</td>
                            <td>400</td>
                            <td>433.30</td>
                            <td><div class="container">
                          <div class="progress">
                          <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="48" aria-valuemin="0" aria-valuemax="100" style="width:48%">
                            48% </div></div></div></td>
                        </tr>

                        <tr >
                          <td>February</td>
                          <td>833.30</td>
                          <td>550</td>
                          <td>283.30</td>
                          <td><div class="container">
                               <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:66%">
                                66% </div></div></div></td>
                        </tr>
                        <tr  >
                          <td>March</td>
                          <td>833.30</td>
                          <td>400</td>
                          <td>433.30</td>
                          <td><div class="container">
                            <div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:48%">
                            48% </div></div></div></td>
                          </tr>
                          <tr  >
                              <td>April</td>
                              <td>833.30</td>
                              <td>1000</td>
                              <td>166.70</td>
                              <td><div class="container">
                              <div class="progress">
                              <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:120%">
                                -120% </div></div></div></td>
                            </tr>
                            <tr  >
                              <td>May</td>
                              <td>833.30</td>
                              <td>300</td>
                              <td>533.30</td>
                              <td><div class="container">
                              <div class="progress">
                              <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:36%">
                                36% </div></div></div></td>
                            </tr>
                            <tr  >
                              <td>June</td>
                              <td>833.30</td>
                              <td>400</td>
                              <td>433.30</td>
                              <td><div class="container">
                              <div class="progress">
                              <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:48%">
                              48% </div></div></div></td>
                            </tr>
                            <tr  >
                              <td>July</td>
                              <td>833.30</td>
                              <td>400</td>
                              <td>433.30</td>
                              <td><div class="container">
                              <div class="progress">
                              <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:48%">
                              48% </div></div></div></td>
                            </tr>
                            <tr  >
                              <td>August</td>
                              <td>833.30</td>
                              <td>400</td>
                              <td>433.30</td>
                              <td><div class="container">
                              <div class="progress">
                              <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:48%">
                              48% </div></div></div></td>
                            </tr>
                            <tr  >
                              <td>September</td>
                              <td>833.30</td>
                              <td>1000</td>
                              <td>166.70</td>
                              <td><div class="container">
                              <div class="progress">
                              <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:120%">
                                  -120% </div></div></div></td>
                            </tr>
                            <tr  >
                               <td>October</td>
                               <td>833.30</td>
                               <td>400</td>
                               <td>433.30</td>
                               <td><div class="container">
                               <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:48%">
                                48% </div></div></div></td>
                            </tr>
                            <tr  >
                                <td>November</td>
                                <td>833.30</td>
                                <td>400</td>
                                <td>433.30</td>
                                <td><div class="container">
                                <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:48%">
                                48% </div></div></div></td>
                            </tr>
                            <tr  >
                                <td>December</td>
                                <td>833.30</td>
                                <td>400</td>
                                <td>433.30</td>
                                <td><div class="container">
                                <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:48%">
                                48% </div></div></div></td>
                              </tr>

                            <tr > 
                              <center>
                                <th scope="col">TOTAL</th>
                                <th scope="col">10000</th>
                                <th scope="col">6000</th>
                                <th scope="col">3949.60</th>
                                <th scope="col"><div class="container">
                                <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:60%">
                                60% </div></div></div></th>
                            </center></tr>
                  </table>

                  <br>
                  <!-- <div id="page-content-wrapper">
                    <div class="container-fluid" id="content"> 
                    <div class="row my-4">
                    <div class="col">
                          <h4 class="m-0"><i class="fa fa-bar-chart"></i> Expenses Graph</h4>
                    </div>
                    
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart', 'bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var chartDiv = document.getElementById('chart_div');
        var data = google.visualization.arrayToDataTable([
          ['Profit', 'Actual', 'Budget'],
          ['Jan', 18000, 20000],
          ['Feb', 24000, 20000],
          ['Mar', 30000, 14000],
          ['Apr', 50000, 60000],
          ['May', 30000, 45000],
          ['Jun', 50000, 60000],
          ['Jul', 50000, 60000],
          ['Aug', 50000, 60000],
          ['Sep', 50000, 60000],
          ['Oct', 50000, 60000],
          ['Nov', 50000, 60000],
          ['Dec', 60000, 80000]
        ]);

        var classicOptions = {
          width: 1000,
          series: {
            0: {targetAxisIndex: 0},
           
          },
          title: '',
          vAxes: {
            // Adds titles to each axis.
            0: {title: ''},
            
          }
        };
        function drawClassicChart() {
          var classicChart = new google.visualization.ColumnChart(chartDiv);
          classicChart.draw(data, classicOptions);
          button.innerText = 'Change to Material';
          button.onclick = drawMaterialChart;
        }
        drawClassicChart();
    };
    </script>
    <!--  <div class="table-responsive text-nowrap">
    <div id="chart_div" style="width: 1000px; height: 1000px"></div></div>
 -->
</div></div></div> -->
                  
        </div>
</div>
        <!-- Add expenses -->




</div></div></div>
<!-- Add expand -->
<div class="modal-body" >
          <div class="form-group">
                  <div class="modal fade" id="addAmountExpand">
            <div class="modal-dialog modal-lg">
              <div class="modal-content" style="padding: 70px">
        <div class="modal-header">
                  <h6 class="modal-title">Expenses Details</h6>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <br>
                <!-- Modal body -->
        <div class="modal-body">
        
        <div class="form-group">
                    <label><h6 class="m-0">Category</h6></label>
           <input class="form-control" readonly placeholder="Expand" type="text" id="catexpand" name="catexpand" >
                    
                  
                        <label><h6 class="m-0">Date</h6></label>
                        <input type="date" class="form-control selectpicker" id="dateexpand" name="dateexpand" autocomplete="off">
                     <br>
                  
                
                  <div class="form-group">
                    <label><h6 class="m-0">Amount </h6></label>
           <input class="form-control" type="text" id="amountexpand" name="amountexpand" >
                    
                  </div>
          <div class="form-group">
                    <label><h6 class="m-0">Description </h6></label>
           <textarea class="form-control" type="text" id="descexpand" name="descexpand" ></textarea>
                    
                  </div>
          <br>
<center><button name="submitExp" value="submitExp" type="submit" class="btn btn-primary shadow-sm">Save</button>
 <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button></center>

</div>
</div>
             
</div>
</div>
</div>

</div>
</div>
<!-- add backup -->
<div class="modal-body" >
          <div class="form-group">
                  <div class="modal fade" id="addAmountBackup">
            <div class="modal-dialog modal-lg">
              <div class="modal-content" style="padding: 70px">
        <div class="modal-header">
                  <h6 class="modal-title">Expenses Details</h6>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <br>
                <!-- Modal body -->
        <div class="modal-body">
        
        <div class="form-group">
                    <label><h6 class="m-0">Category</h6></label>
           <input class="form-control" readonly placeholder="Backup" type="text" id="catbackup" name="catbackup" >
                    
                  
                        <label><h6 class="m-0">Date</h6></label>
                        <input type="date" class="form-control selectpicker" id="datebackup" name="datebackup" autocomplete="off">
                     <br>
                  
                
                  <div class="form-group">
                    <label><h6 class="m-0">Amount </h6></label>
           <input class="form-control" type="text" id="amountbackup" name="amountbackup" >
                    
                  </div>
          <div class="form-group">
                    <label><h6 class="m-0">Description </h6></label>
           <textarea class="form-control" type="text" id="descbackup" name="descbackup" ></textarea>
                    
                  </div>
          <br>
<center><button name="submitBackup" value="submitBackup" type="submit" class="btn btn-primary shadow-sm">Save</button>
 <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button></center>

</div>
</div>
             
</div>
</div>
</div>

</div>
</div>
<!-- add bonus -->
<div class="modal-body" >
          <div class="form-group">
                  <div class="modal fade" id="addAmountBonus">
            <div class="modal-dialog modal-lg">
              <div class="modal-content" style="padding: 70px">
        <div class="modal-header">
                  <h6 class="modal-title">Expenses Details</h6>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <br>
                <!-- Modal body -->
        <div class="modal-body">
        
        <div class="form-group">
                    <label><h6 class="m-0">Category</h6></label>
           <input class="form-control" readonly placeholder="Bonus" type="text" id="catbonus" name="catbonus" >
                    
                  
                        <label><h6 class="m-0">Date</h6></label>
                        <input type="date" class="form-control selectpicker" id="datebonus" name="datebonus" autocomplete="off">
                     <br>
                  
                
                  <div class="form-group">
                    <label><h6 class="m-0">Amount </h6></label>
           <input class="form-control" type="text" id="amountbonus" name="amountbonus" >
                    
                  </div>
          <div class="form-group">
                    <label><h6 class="m-0">Description </h6></label>
           <textarea class="form-control" type="text" id="descbonus" name="descbonus" ></textarea>
                    
                  </div>
          <br>
<center><button name="submitBonus" value="submitBonus" type="submit" class="btn btn-primary shadow-sm">Save</button>
 <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button></center>

</div>
</div>
             
</div>
</div>
</div>

</div>
</div>

  <script type="text/javascript">
    $(document).ready(function(){
       $("#sidebar-wrapper .active").removeClass("active");
       $("#calendartab").addClass("active").addClass("disabled");
       document.getElementById("calendartab").style.backgroundColor = "DeepSkyBlue"
    });
  </script>

  <?php
  include 'includes/form.php';
  ?>
  <?php
  include 'includes/footer.php';
  ?>

</body>
</html>


