
<div id="sidebar-wrapper">
  <style type="text/css">
    #navbar::-webkit-scrollbar {
        display: none;
    }

    #navbar {
      -ms-overflow-style: none; 
      scrollbar-width: none; 
    }

    .border-3 {
      border-width:5px !important;
    }

    .radius{
      border-top-right-radius: 50px;
      border-bottom-right-radius: 50px;
    }
  </style>
  <?php
  if($resultresult->superadmin){
  ?>
  <div class="list-group list-group-flush" id="navbar" style="overflow-y: scroll; height: 200px;">
    <a class="list-group-item list-group-item-light border-0"><b><?php echo $array['home'];?></b></a>
    <a href="home-dashboard.php?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius" id="superadmindashboardtab">
      <div class="row">
        <div class="col-2"><i class="fa fa-dashboard"></i></div>
        <div class="col">Super Admin Dashboard</div>
      </div>
    </a>
  </div>
  <?php
  }else{
  ?>

  <?php
  if($resultresult->corporateID){
    $corporateobject = new Corporate();
    $corporateresult = $corporateobject->searchCorporate($resultresult->corporateID);
    if($corporateresult){
      if($corporateresult->package === "Trial"){
        $navbarpackage = "Trial";
      }elseif($corporateresult->package === "Free"){
        $navbarpackage = "Free";
      }elseif($corporateresult->package === "Basic"){
        $navbarpackage = "Basic";
      }elseif($corporateresult->package === "Pro"){
        $navbarpackage = "Pro";
      }elseif($corporateresult->package === "Business"){
        $navbarpackage = "Business";
      }elseif($corporateresult->package === "Enterprise"){
        $navbarpackage = "Enterprise";
      }
    }
  }else{
    $companyobject = new Company();
    $companyresult = $companyobject->searchCompany($resultresult->companyID);
    if($companyresult){
      if($companyresult->package === "Trial"){
        $navbarpackage = "Trial";
      }elseif($companyresult->package === "Free"){
        $navbarpackage = "Free";
      }elseif($companyresult->package === "Basic"){
        $navbarpackage = "Basic";
      }elseif($companyresult->package === "Pro"){
        $navbarpackage = "Pro";
      }elseif($companyresult->package === "Business"){
        $navbarpackage = "Business";
      }elseif($companyresult->package === "Enterprise"){
        $navbarpackage = "Enterprise";
      }
    }
  }
  ?>

  <div class="list-group list-group-flush" id="navbar" style="overflow-y: auto;">

    <a class="list-group-item list-group-item-light border-0"></a>
    <a href="home-dashboard?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius" id="dashboardtab">
      <div class="row">
        <div class="col-2"><i class="fa fa-dashboard"></i></div>
        <div class="col"><?php echo $array['dashboard'];?></div>
      </div>
    </a>
    <?php


    if($navbarpackage === "Basic" || $navbarpackage === "Pro" || $navbarpackage === "Business" || $navbarpackage === "Enterprise"){
      if($userlevel=="Chief" || $userlevel=="Superior" || $userlevel=="Manager" ){

      ?>
      <a href="home-calendar?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius" id="calendartab">
        <div class="row">
          <div class="col-2"><i class="fas fa-money-check-alt"></i></div>
          <div class="col">Calendar</div>
        </div>
      </a>

      <a href="budgetdashboard.php?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius" id="budgetdashboard">
        <div class="row">
          <div class="col-2"><i class="fas fa-money-check-alt"></i></div>
          <div class="col">Dashboard</div>
        </div>
      </a>

      <a href="budget-setup.php?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius" id="budgetsetup">
        <div class="row">
          <div class="col-2"><i class="fas fa-money-check-alt"></i></div>
          <div class="col">Budget Setup</div>
        </div>
      </a>
      
      <a href="budget-allocation.php?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius" id="budgetallocation">
        <div class="row">
          <div class="col-2"><i class="fas fa-money-check-alt"></i></div>
          <div class="col"> Allocation</div>
        </div>
      </a>
      

      <a href="budget-revenue.php?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius" id="budgetrevenue">
        <div class="row">
          <div class="col-2"><i class="fas fa-money-check-alt"></i></div>
          <div class="col"> Revenue </div>
        </div>
      </a>


      <a href="budgetexpense.php?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius" id="expenses">
        <div class="row">
          <div class="col-2"><i class="fas fa-money-check-alt"></i></div>
          <div class="col"> Expenses </div>
        </div>
      </a>

      <a href="budget-netprofit.php?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius" id="netprofit">
        <div class="row">
          <div class="col-2"><i class="fas fa-money-check-alt"></i></div>
          <div class="col">Net Profit </div>
        </div>
      </a>

      <a href="plan-tab.php?lang=<? echo $extlg?>" class="list-group-item list-group-item-action border-0 radius" id="compplan">
        <div class="row">
          <div class="col-2"><i class="fas fa-money-check-alt"></i></div>
          <div class="col"> Compensation </div>
        </div>
      </a>

      <a href="user-view.php?lang=<? echo $extlg?>" class="list-group-item list-group-item-action border-0 radius" id="userview">
        <div class="row">
          <div class="col-2"><i class="fas fa-money-check-alt"></i></div>
          <div class="col"> My Plan </div>
        </div>
      </a>
      <?php
   }
   elseif($userlevel=="Personal"){
     ?>
      <a href="user-view.php?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius" id="userview">
     <div class="row">
       <div class="col-2"><i class="fas fa-money-check-alt"></i></div>
       <div class="col">My Plan</div>
     </div>
   </a>
   <?php
   }
    }
    ?>
    <a class="list-group-item list-group-item-light border-0"></a>
  </div>
  <?php
  }
  ?>
</div>

  



