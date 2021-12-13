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
  $companyobject= new Company();
  if ($userlevel == "Chief"){
    $listcompany = $companyobject->searchCompanyCorporate($resultresult->corporateID);  


  }
  elseif ($userlevel== "Superior"){
    $listcompany = $companyobject->searchCompanyLeadership($resultresult->userID);  
  }
  
?>

  <!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Budgeting - DoerHRM</title> 
    <?php
    include 'includes/header.php';
    ?>
  </head>
  <script>
             $(document).ready(function(){
          function selectmonthnp(date) {

              var day = new Date(date.getFullYear(), 1);
              $('#budgetyear').datepicker('update', day);
              $('#budgetyear').val(day.getFullYear());
             // var comp = document.getElementById("addmaincomp1").value; 
              var alldata = 
              {
                // comp:comp,
                year: day.getFullYear(),
              };
              console.log(alldata);
              $.ajax({
          url:"ajax-getviewbudgetinitial.php",
          data: alldata,
          dataType: "json",
          method: "POST",
          success:function(data){
            $("#showbudgetview11").html(data); // This is A
          }
        });
            }

            weekpicker = $('#budgetyear');
            weekpicker.datepicker({
                autoclose: true,
                forceParse: false,
                orientation: 'bottom',
                minViewMode: "years"
            }).on("changeDate", function(e) {
                selectmonthnp(e.date);
            });
            selectmonthnp(new Date);
             });
          </script>

     
  <body>
    <?php include 'includes/topbar.php';?>
    <div class="d-flex" id="wrapper">
      <?php include 'includes/navbar.php';?>
      <div id="page-content-wrapper">
        <div class="container-fluid" id="content"> 
          <div class="row my-4">
            <div class="col">
              <h4 class="m-0"><i class="fas fa-dollar-sign"></i> Budget Setup</h4>
            </div>
          </div>
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <style>
          * {
            box-sizing: border-box;
          }
          /* Create two equal columns that floats next to each other */
          .column {
            padding: 10px;
            height: 300px; /* Should be removed. Only for demonstration */
          }
          /* Clear floats after the columns */
          .row:after {
            content: "";
            display: table;
            clear: both;
          }
        </style>
       <div class="col px-2">
                         <input style="width: 20%" class="form-control" id="budgetyear">
                       </div>

        <button style="float: right;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#setnetprofit">Set Net Profit Condition</button>

        <br><br>
        <br>    
       <!-- <script type="text/javascript">
         $(document).ready(function(){

           function getbudgetview(){ // Depends on requirement, sometime we have loader with parameters
             $.ajax({
               url:"ajax-getviewbudgetinitial.php",
               success:function(data){
                 $("#showbudgetview").html(data); // This is A
               }
             });
           }
           getbudgetview(); 
         });
       </script> -->
       
       <div id="showbudgetview11"></div>

       </div></div></div>

        <script type="text/javascript">
          $(document).ready(function(){
           $("#sidebar-wrapper .active").removeClass("active");
           $("#budgetsetup").addClass("active").addClass("disabled");
           document.getElementById("budgetsetup").style.backgroundColor = "DeepSkyBlue";
         });
       </script>

       <!-- /#wrapper -->
       <?php include 'includes/form.php';?>
       <?php include 'includes/footer.php';?>
    
   </body>
   </html>
