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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home - DoerHRM</title> 
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
        <div class="row my-5">
          <div class="col">
            <h1 class="font-weight-light">Welcome Back, <?php echo $user->data()->firstname." ".$user->data()->lastname?></h1>
          </div>
          <div class="col-4 text-right">
            <div class="dropdown">
              <?php
              $groupobject = new Group();
              $groupresult = $groupobject->searchGroupInvolve($resultresult->userID);
              if($groupresult){
                $numgroup = count($groupresult);
              }else{
                $numgroup = 0;
              }
              ?>
              <button type="button" class="btn btn-warning rounded-0" data-toggle="dropdown">
                <span class="font-weight-bold">All Group Involve (<?php echo $numgroup;?>)</span>
              </button>
              <div class="dropdown-menu dropdown-menu-right">
              <?php
              if($groupresult){
                foreach ($groupresult as $row) {
                  $groupdetail = $groupobject->find($row->group_id);
                  if($groupdetail){
                    ?>
                    <a class="dropdown-item" href="viewgroup.php?id=<?php echo $groupdetail->groupID;?>"><?php echo $groupdetail->groups;?></a>
                    <?php
                  }
                }
              }else{
                ?>
                <a class="dropdown-item" href="#">--</a>
                <?php
              }
              ?>
              </div>
            </div>
          </div>
        </div>

        <style type="text/css">
          .box {
            transition: box-shadow .3s;
          }
          .box:hover {
            box-shadow: 0 0 20px rgba(0, 123, 255,.5); 
          }
        </style>
        <div class="row">
          <div class="col-12 col-xl-6 p-0">
            <div class="card m-2 box rounded-0">
              <div class="card-body">
                <h5>Check In</h5>
                <p class="m-0">Your Check In status for this week <span class="badge badge-success">Done</span></p>
                <p class="m-0"><span class="text-danger"><b>1</b> Problem</span>, <span class="text-info"><b>2</b> Plan</span></p>
                <a href="home-yourppp?lang=<?php echo $extlg?>" class="stretched-link"></a>
              </div>
            </div>
          </div>  

          <?php
          if($navbarpackage === "Basic" || $navbarpackage === "Pro" || $navbarpackage === "Business" || $navbarpackage === "Enterprise"){
            ?>
            <div class="col-12 col-xl-6 p-0">
              <div class="card m-2 box rounded-0">
                <div class="card-body">
                  <h5>1 on 1s</h5>
                  <p class="m-0">You have <span class="text-primary font-weight-bold">7</span> 1 on 1 in pending</p>
                  <p class="m-0"><span class="text-danger"><b>3</b> dued</span>, <span class="text-info"><b>4</b> up ahead</span></p>
                  <a href="home-youronetoone?lang=<?php echo $extlg?>" class="stretched-link"></a>
                </div>
              </div>
            </div>  
            <div class="col-12 col-xl-6 p-0">
              <div class="card m-2 box rounded-0">
                <div class="card-body">
                  <h5>Calendar</h5>
                  <p class="m-0">You have <span class="text-primary font-weight-bold">3</span> scheduled events</p>
                  <p class="m-0"><span class="text-danger"><b>1</b> Dued</span>, <span class="text-info"><b>2</b> In progress</span></p>
                  <a href="home-calendar?lang=<?php echo $extlg?>" class="stretched-link"></a>
                </div>
              </div>
            </div>  
            <?php
          }


          if($navbarpackage === "Pro" || $navbarpackage === "Business" || $navbarpackage === "Enterprise"){
            ?>
            <div class="col-12 col-xl-6 p-0">
              <div class="card m-2 box rounded-0">
                <div class="card-body">
                  <h5>OKR</h5>
                  <p class="m-0">You have <span class="text-primary font-weight-bold">3</span> Objectives</p>
                  <p class="m-0"><span class="text-danger"><b>1</b> Lagging</span>, <span class="text-info"><b>2</b> On track</span></p>
                  <a href="home-yourokr2?lang=<?php echo $extlg?>" class="stretched-link"></a>
                </div>
              </div>
            </div>  
            <?php
          }
          ?>
          
          
          
          
        </div>  
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function(){
       $("#sidebar-wrapper .active").removeClass("active");
       $("#dashboardtab").addClass("active").addClass("disabled");
       document.getElementById("dashboardtab").style.backgroundColor = "DeepSkyBlue";
    });
  </script>
  <?php
  include 'includes/footer.php';
  ?>
</body>
</html>


