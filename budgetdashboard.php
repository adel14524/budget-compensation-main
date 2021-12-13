<?php
require_once 'core/init.php';
$userlevel = "";
$user = new User();
if(!$user->isLoggedIn()){
  Redirect::to("login.php");
}else{
  $resultresult = $user->data();
  $userlevel = $resultresult-> role;
  if($resultresult->verified == false || $resultresult->superadmin == true){
    $user->logout();
    Redirect::to("login.php?error=error");
  }
}
$companyobject= new Company();
$listcompany = $companyobject->searchCompanyCorporate($resultresult->corporateID);

if ($userlevel == "Chief"){
  $listcompany = $companyobject->searchCompanyCorporate($resultresult->corporateID);  
}
elseif ($userlevel== "Superior"){
  $listcompany = $companyobject->searchCompanyLeadership($resultresult->userID);  
}
?>

<style>
.modal-content { float: "center";
padding: 70px;
}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Expenses - DoerHRM</title> 
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
                        <h4 class="m-0"><i class="fa fa-chart-line mr-2"></i>Dashboard</h4>
                    </div>
                </div>

                <form class="form-inline">
                  <select class="form-control" style="width: 25%; transition: box-shadow .3s;" id="compdashboard" name="compdashboard">
                      <?php foreach($listcompany as $row) 
                      { 
                      ?>
                        <option value="<?php echo $row->companyID ?>"><?php echo $row->company ?></option>
                      <?php
                      }
                      ?>
                  </select>

                  <script type="text/javascript">
                    $(document).ready(function(){
                      function selectmonthexpenses(date) {
                        var day = new Date(date.getFullYear(), 1);
                        $('#dashboardyear').datepicker('update', day);
                        $('#dashboardyear').val(day.getFullYear());
                        var comp = document.getElementById("compdashboard").value;
                        var alldata = 
                        {
                          year: day.getFullYear(),
                          comp:comp,
                        };
                        // console.log(alldata);
                        $.ajax({
                          url:"ajax-viewoverviewdashboard.php",
                          data: alldata,
                          dataType: "json",
                          method: "POST",
                          success:function(data){
                            console.log(data);
                            $("#showoverviewdashboard").html(data); // This is A
                          }
                        });
                      }
                      weekpicker = $('#dashboardyear');
                      weekpicker.datepicker({
                        autoclose: true,
                        forceParse: false,
                        orientation: 'bottom',
                        minViewMode: "years"
                      }).on("changeDate", function(e) {
                        selectmonthexpenses(e.date);
                      });
                      selectmonthexpenses(new Date);
                    });
                  </script>

                  <div class="col px-2">
                    <input class="form-control" style="width: 30%; transition: box-shadow .3s;" id="dashboardyear">
                  </div>
                </form>

                <div id="showoverviewdashboard"></div>
            </div>
        </div>
    </div>
  
    <script type="text/javascript">
      $(document).ready(function(){
        $("#sidebar-wrapper .active").removeClass("active");
        $("#budgetdashboard").addClass("active").addClass("disabled");
        document.getElementById("budgetdashboard").style.backgroundColor = "DeepSkyBlue"
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