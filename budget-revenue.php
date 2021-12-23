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
$companyobject = new Company();
$listcompany = $companyobject->searchCompanyCorporate( $resultresult->corporateID); 

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
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.4.1/dist/chart.min.js"></script>
</head>
<body>
  <?php include 'includes/topbar.php';?>
  <div class="d-flex" id="wrapper">
    <?php include 'includes/navbar.php';?>
    <center>

  <head>
        <script>
          $(document).ready(function(){
          function monthrevenue(date) {

           var day = new Date(date.getFullYear(), 1);
           $('#revenueyear').datepicker('update', day);
           $('#revenueyear').val(day.getFullYear());
          var comp = document.getElementById("companyrevenue").value; 
           var alldata = 
           {
             comp:comp,
             year: day.getFullYear(),
           };
           console.log(alldata);
           $.ajax({
           url:"ajax-getviewrevenue.php",
           data: alldata,
           dataType: "json",
           method: "POST",
           success:function(data){
           $("#showrevenueview").html(data); 
           }
           });
           $.ajax({
            url:"ajax-viewcost.php",
            data: alldata,
            dataType: "json",
            method: "POST",
            success:function(data){
              $("#showcostview").html(data); 
            }
           });
           }

           weekpicker = $('#revenueyear');
           weekpicker.datepicker({
             autoclose: true,
             forceParse: false,
             orientation: 'bottom',
             minViewMode: "years"
             }).on("changeDate", function(e) {
               monthrevenue(e.date);
         });
               monthrevenue(new Date);
          });
       </script>

    </head>
    </center>
          <br>
          <br>
          

<!-- revenue page -->
            <div id="page-content-wrapper">
            <div class="container-fluid" id="revenue"> 
            <div class="row my-4">
            <div class="col">
                <h4 class="m-0"><i class="fas fa-dollar-sign"></i> Revenue</h4>
            </div>
            </div>
<form class="form-inline">
     <label for="ccompany"></label>
              <select class="form-control" style="width:25%; transition: box-shadow .3s;" name="companyrevenue" id="companyrevenue">
                 <?php foreach($listcompany as $row) 
                 { ?>
                  <option value="<?php echo $row->companyID ?>"><?php echo $row->company ?></option>
                  <?php
                }
                ?>
                    </select>
                    <!-- <script type="text/javascript"> 
                      $(document).ready(function(){
                        $(document).on('click', ".saverev1", function(){
                         var companyID = document.getElementById("companyrevenue").value; 
                         var year = document.getElementById("revenueyear").value; 

                         { $("#addrevcompany").val(companyID);
                         $("#addrevenueyear").val(year);
                       }
                     });
                      });
                    </script>

                    <script type="text/javascript"> 
                      $(document).ready(function(){
                        $(document).on('click', ".revhistory", function(){
                         var companyID = document.getElementById("companyrevenue").value; 
                         var year = document.getElementById("revenueyear").value; 

                         { $("#addrevcompany").val(companyID);
                         $("#addrevenueyear").val(year);
                       }
                     });
                      });
                    </script> -->
          &nbsp;&nbsp;
             <div class="col px-2">
              <input class="form-control" id="revenueyear" style="width:30%; transition: box-shadow .3s;">
          
            </div>
         
              </form>
    <br>
    <ul class="nav nav-tabs row px-2">
          <li class="nav-item col-12 col-xl-2 p-0">
            <a class="nav-link rounded-0 text-center active" data-toggle="tab" id="rev" href="#revenue1"><span class="font-weight-bold">Revenue</span></a>
          </li>
          <li class="nav-item col-12 col-xl-2 p-0">
            <a class="nav-link rounded-0 text-center" data-toggle="tab" id="cogs" href="#cost"><span class="font-weight-bold">Cost of Goods Sold</span></a>
          </li>
    </ul>
    <br>

    <script>
      $(document).ready(function(){

        function getviewrev($year){
          weekpicker = $('#revenueyear');
          weekpicker.datepicker({
            autoclose: true,
            forceParse: false,
            orientation: 'bottom',
            minViewMode: "years"
          }).on("changeDate", function(e) {
            monthrevenue(e.date);
          });
          monthrevenue(new Date);
        }
        
        function monthrevenue(date) {

          var day = new Date(date.getFullYear(), 1);
          $('#revenueyear').datepicker('update', day);
          $('#revenueyear').val(day.getFullYear());
          var comp = document.getElementById("companyrevenue").value; 
          var alldata = 
          {
            comp:comp,
            year: day.getFullYear(),
          };
          console.log(alldata);
          $.ajax({
            url:"ajax-getviewrevenue.php",
            data: alldata,
            dataType: "json",
            method: "POST",
            success:function(data){
              $("#showrevenueview").html(data); 
            }
          });
          $.ajax({
            url:"ajax-viewcost.php",
            data: alldata,
            dataType: "json",
            method: "POST",
            success:function(data){
              $("#showcostview").html(data); 
            }
          });
          getviewrev();     
        }});
      </script>

      <!-- Revenue Tab -->
      <div class="tab-content">
            <div class="tab-pane active" id="revenue1">
              <div class="row mt-3">
                <div class="col-xl-12 col-12">
                  <div id="showrevenueview"></div> 
                </div>
              </div>
            </div>

            <!-- Cost of Goods Sold Tab-->
            <div class="tab-pane" id="cost">
              <br>
              <script type="text/javascript">
              $(document).ready(function(){
                $(document).on('click', "#cogs", function(){
                  var companyID = document.getElementById("companyrevenue").value; 
                  var year = document.getElementById("revenueyear").value;
                  var alldata={
                    comp:companyID,
                    year:year,
                  }

                    $.ajax({
                    url:"ajax-viewcost.php",
                    data: alldata,
                    dataType: "json",
                    method: "POST",
                    success:function(data){
                        $("#showcostview").html(data); 
                      }
                    });
                });
                $(document).on('click', "#rev", function(){
                  var companyID = document.getElementById("companyrevenue").value; 
                  var year = document.getElementById("revenueyear").value;
                  var alldata={
                    comp:companyID,
                    year:year,
                  }

                    $.ajax({
                    url:"ajax-getviewrevenue.php",
                    data: alldata,
                    dataType: "json",
                    method: "POST",
                    success:function(data){
                        $("#showrevenueview").html(data); 
                      }
                    });
                });
                          }); 
            </script>
            
            <div id="showcostview"></div> 
            </div>
      </div>
              <!-- graph revenue
              <script type="text/javascript">
               $(document).ready(function(){
                 function getchartview($year){
                   weekpicker = $('#revenueyear');
                   weekpicker.datepicker({
                     autoclose: true,
                     forceParse: false,
                     orientation: 'bottom',
                     minViewMode: "years"
                   }).on("changeDate", function(e) {
                     getchart(e.date);
                   });
                   getchart(new Date);
                 }
                 
                 function getchart(date){ 
                   var day = new Date(date.getFullYear(), 1);
                   $('#revenueyear').datepicker('update', day);
                   $('#revenueyear').val(day.getFullYear());
                   var comp = document.getElementById("companyrevenue").value; 
                   var alldata = 
                   {
                     comp:comp,
                     year: day.getFullYear(),
                   };
                   $.ajax({
                    url:"ajax-getviewrevchart.php",
                    data: alldata,
                    dataType: "json",
                    method: "POST",
                    success:function(data){
                     $("#showchartview").html(data);
                   }
                 });
                 }
                 getchartview(); 
               });
             </script>
          <div id="showchartview"></div> -->
         
<script type="text/javascript">
    $(document).ready(function(){
       $("#sidebar-wrapper .active").removeClass("active");
       $("#budgetrevenue").addClass("active").addClass("disabled");
       document.getElementById("budgetrevenue").style.backgroundColor = "DeepSkyBlue";
    });
  </script>

  <?php include 'includes/footer.php';?>
  <?php include 'includes/form.php';?>

</div>
</div>
  </body>
</head>
</html>


