<html>
<head>
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
  <title>Compensation - DoerHRM</title> 
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
            <h4 class="m-0"><i class="fa fa-user"></i> My Plan</h4>
          </div>
        </div>
      </head>
       <script type="text/javascript">
            $(document).ready(function(){

             $.ajax({
              url:"ajax-viewusercompensation.php",
              method:"POST",
              success:function(data){
                  // console.log(data);
                  $("#showusercompensation").html(data); 

                }
              });
            
             });
         </script>
          <div id="showusercompensation"></div>

     
               
<script type="text/javascript">
    $(document).ready(function(){
       $("#sidebar-wrapper .active").removeClass("active");
       $("#userview").addClass("active").addClass("disabled");
       document.getElementById("userview").style.backgroundColor = "DeepSkyBlue";
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
