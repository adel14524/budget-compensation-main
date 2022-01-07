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
            <h4 class="m-0"><i class="fa fa-calendar"></i> Expenses</h4>
          </div>
        </div>

        <form class="form-inline">
          <select class="form-control" style="width: 25%; transition: box-shadow .3s;" id="addamountcompany" name="addamountcompany">
           
            <?php foreach($listcompany as $row) 
            { ?>

             <option value="<?php echo $row->companyID ?>"><?php echo $row->company ?></option>
             <?php

           }
           ?>
         </select>

         <script type="text/javascript"> 
          $(document).ready(function(){
          
          });
        </script>
        
        <script type="text/javascript">
          $(document).ready(function(){
            function selectmonthexpenses(date) {
              var day = new Date(date.getFullYear(), 1);
              $('#expensesyear').datepicker('update', day);
              $('#expensesyear').val(day.getFullYear());
              var comp = document.getElementById("addamountcompany").value;
              var alldata = 
              {
                year: day.getFullYear(),
                comp:comp,
              };
              // console.log(alldata);
              $.ajax({
                url:"ajax-viewoverviewexpenses.php",
                data: alldata,
                dataType: "json",
                method: "POST",
                success:function(data){
                  // console.log(data);
          $("#showoverviewexpenses").html(data); // This is A
        }
      });
            }
            weekpicker = $('#expensesyear');
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
        &nbsp;&nbsp;
      

        <div class="col px-2">
         <input class="form-control" style="width: 30%; transition: box-shadow .3s;" id="expensesyear">
          </div>
          </form>


          <!-- <ul class="nav nav-tabs row px-2">
            <li class="nav-item col-12 col-xl-2 p-0">
              <a class="nav-link rounded-0 text-center active" data-toggle="tab" href="#mainAllocation"><span class="font-weight-bold">Expenses</span></a>
            </li>
            <li class="nav-item col-12 col-xl-2 p-0">
              <a class="nav-link rounded-0 text-center" data-toggle="tab" id="overviewallocation" href="#overviewall"><span class="font-weight-bold">Overview</span></a>
            </li>

          </ul> -->


          <!-- Tab panes -->
          <!-- <div class="tab-content">
            <div class="tab-pane active" id="mainAllocation">
              <div class="row mt-3">
                <div class="col-xl-12 col-12">
                  <br><br>

                  <div id="showexpensesview"></div> 

                  <br>
                </div>
              </div>
            </div>
            <br> -->

            <!-- Overview -->

            <!-- <div class="tab-pane" id="overviewall" >
              <script type="text/javascript">
                $(document).ready(function(){
                  $(document).on('click', "#overviewallocation", function(){

                    var companyID = document.getElementById("addamountcompany").value; 
                    var year = document.getElementById("expensesyear").value; 

                    var alldata = 
                    {
                      comp:companyID,
                      year:year,
                    };
                    $.ajax({
                      url:"ajax-viewoverviewexpenses.php",
                      data: alldata,
                      dataType: "json",
                      method: "POST",
                      success:function(data){
            $("#showoverviewexpenses").html(data); // This is A
          }
          });
                  });
                });

              </script>

              <div id="showoverviewexpenses"></div> 

            </div>
          </div> -->

          <div id="showoverviewexpenses"></div> 
        </div></div></div>



 <script type="text/javascript">
  $(document).ready(function(){
   $("#sidebar-wrapper .active").removeClass("active");
   $("#expenses").addClass("active").addClass("disabled");
   document.getElementById("expenses").style.backgroundColor = "DeepSkyBlue"
 });
</script>

<?php
//include 'includes/form.php';
?>
<?php
include 'includes/footer.php';
?>

</body>
</html>


