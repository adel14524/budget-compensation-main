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
$companyobject= new Company();
if ($userlevel == "Chief"){
  $listcompany = $companyobject->searchCompanyCorporate($resultresult->corporateID);  
}
elseif ($userlevel== "Superior"){
  $listcompany = $companyobject->searchCompanyLeadership($resultresult->userID);  
}
// $companyobject= new Company();
  // $listcompany = $companyobject->searchCompanyCorporate($resultresult->corporateID);

  $companymember = $companyobject->searchCompanyMember($resultresult->companyID);  


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Compensation -DoerHRM</title> 
  <?php
  include 'includes/header.php';
  ?>

<body>
  <?php include 'includes/topbar.php';?>
  <div class="d-flex" id="wrapper">
    <?php include 'includes/navbar.php';?>
    <div id="page-content-wrapper">
      <div class="container-fluid" id="content"> 
      <div class="row my-4">
      <div class="col">
          <h4 class="m-0"><i class="fas fa-dollar-sign"></i> Compensation</h4>
      </div>
      </div>

      <ul class="nav nav-tabs row px-2">
        <li class="nav-item col-12 col-xl-2 p-0">
          <a class="nav-link rounded-0 text-center active" data-toggle="tab" href="#viewPlan"><span class="font-weight-bold"> View Plan</span></a>
        </li>
        <li class="nav-item col-12 col-xl-2 p-0">
          <a class="nav-link rounded-0 text-center" data-toggle="tab" href="#addPlan"><span class="font-weight-bold">Add Plan </span></a>
        </li>
        
</ul>
  
<style>
#info th {
  border: 1px solid #ddd;
  padding: 8px;
  color: black;
}
</style>
<style>
.box{
  color: black;
  padding: 20px;
  display: none;
  margin-top: 20px;
}
</style>
    <br>
    <div class="tab-content">
      <div class="tab-pane active" id="viewPlan">
        <div class="row mt-3">
          <div class="col-12 col-xl-5 px-2">
            <div class="form-group">
              <input class="form-control" type="text" id="searchcompensation" placeholder="Search..">
            </div>
          </div>
          <select class="form-control" style="width: 40%" id="filterplancompany" name="filterplancompany">
           <option value="All">All Companies</option>
           <?php foreach($listcompany as $row) 
           { ?>
             <option value="<?php echo $row->companyID ?>"><?php echo $row->company ?></option>
             <?php
           }
           ?>
         </select>

       </div>
       <script type="text/javascript">
        $(document).ready(function(){
         $('#filterplancompany').change(function () {
          var value1 = $(this).val(); 
          var alldata = 
          {
           companyID:value1,
         };

         $.ajax({
          url:"ajax-viewcompensationplan.php",
          method:"POST",
          data:alldata,
          success:function(data){
                  // console.log(data);
                  $("#showcompensationplan").html(data); 

                }
              });
       }); 
       });
     </script>
<br>

<script type="text/javascript">
  $(document).ready(function(){
    $("#searchcompensation").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#searchcompensationlist .searchcompensation").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

    $("a[href='#viewPlan']").on('show.bs.tab', function(e) {
      getCompanyview();
    });

    function getCompanyview(){ 
      var value1 = document.getElementById("filterplancompany").value;
      var alldata = 
      {
       companyID:value1,
     }; 
     $.ajax({
      url:"ajax-viewcompensationplan.php",
      method:"POST",
      data:alldata,
      success:function(data){
        $("#showcompensationplan").html(data);
      }
    });
   }
   getCompanyview(); 
 });
</script>
<div id="showcompensationplan"></div>
           </div>

           <!-- Modal Header -->
           <div class="tab-pane" id="addPlan">
            <div id="page-content-wrapper">
              <div class="container-fluid" id="addPlan">
               <div class="row">
                 <div class="col-xl-12 col-12 pb-5">
                  <br>
                  <div class="row">
                    <select class="form-control" style="width: 40%" id="filterCompany" name="filterCompany">

                      <?php foreach($listcompany as $row) 
                      { ?>

                       <option value="<?php echo $row->companyID ?>"><?php echo $row->company ?></option>
                       <?php

                     }
                     ?>
                   </select> &nbsp;&nbsp;
                   
                   <script type="text/javascript"> 
                    $(document).ready(function(){
                      $(document).on('click', ".addplanconditionmodal", function(){
                       var companyID = document.getElementById("filterCompany").value; 
                       var inputValue = $(this).data("id");

                       { $("#addcondcompany").val(companyID);  
                       $("#compensationid").val(inputValue);     
                     }
                   });
                    });
                  </script>
                  
                  <script type="text/javascript"> 
                    $(document).ready(function(){
                      $(document).on('click', ".addindCondition", function(){
                       var companyID = document.getElementById("filterCompany").value; 
                       var inputValue = $(this).data("id");

                       { $("#companyplanid").val(companyID);  
                       $("#compensationplanid").val(inputValue);
                     }
                   });
                    });
                  </script>

                  <script>
                   $(document).ready(function(){
                    function selectcompensation(date) {

                      var day = new Date(date.getFullYear(), 1);
                      $('#compensationyear').datepicker('update', day);
                      $('#compensationyear').val(day.getFullYear());
                      var comp = document.getElementById("filterCompany").value; 
                      var alldata = 
                      {
                        comp:comp,
                        year: day.getFullYear(),
                      };
                      $.ajax({
                        url:"ajax-getviewcompensation.php",
                        data: alldata,
                        dataType: "json",
                        method: "POST",
                        success:function(data){
                          $("#viewcompensation").html(data); 
                        }
                      });   
                    }
                    weekpicker = $('#compensationyear');
                    weekpicker.datepicker({
                      autoclose: true,
                      forceParse: false,
                      orientation: 'bottom',
                      minViewMode: "years"
                    }).on("changeDate", function(e) {
                      selectcompensation(e.date);
                    });
                    selectcompensation(new Date);
                  });
                </script>

                <div class="col px-2">
                 <input class="form-control" id="compensationyear">
               </div>

             </div> 
           </div>
           <div class="col"></div>
           <div class="col-xl-3 col-6 text-right">
            <button type="button" class="btn btn-primary shadow-sm" data-toggle="modal" data-backdrop="static" data-target="#planmodal"><i class="fas fa-plus"></i> Add Plan</button>
          </div>                 
        </div>

        <script type="text/javascript">
          $(document).ready(function(){

           function getcompensation($year){ 
            weekpicker = $('#compensationyear');
            weekpicker.datepicker({
              autoclose: true,
              forceParse: false,
              orientation: 'bottom',
              minViewMode: "years"
            }).on("changeDate", function(e) {
              selectcompensation(e.date);
            });

            selectcompensation(new Date);
          }

          function selectcompensation(date){
           var comp = document.getElementById("filterCompany").value;
           var year = document.getElementById("compensationyear").value; 
           var alldata = 
           {
            comp:comp,
            year:year,
          };
          $.ajax({
            url:"ajax-getviewcompensation.php",
            data: alldata,
            dataType: "json",
            method: "POST",
            success:function(data){
          $("#viewcompensation").html(data); // This is A
        }
      });

        }
        getcompensation();

      });
    </script> 

    <div id='viewcompensation'></div>
  </div>
</div>
<script>
  $(document).ready(function(){
    $('input[type="radio"]').click(function(){
      var inputValue = $(this).attr("value");
      var targetBox = $("." + inputValue);
      $(".box").not(targetBox).hide();
      $(targetBox).show();
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function(){
   $("#sidebar-wrapper .active").removeClass("active");
   $("#compplan").addClass("active").addClass("disabled");
   document.getElementById("compplan").style.backgroundColor = "DeepSkyBlue"
 });
</script>

</div>

<br>
</div>
</div>
</div>
</div> 
          
        

  <?php include 'includes/footer.php';?>
  <?php include 'includes/form.php';?>

</body>
</html>


