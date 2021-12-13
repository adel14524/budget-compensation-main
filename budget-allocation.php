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
$listcompany = $companyobject->searchCompanyCorporate($resultresult->corporateID);

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
  <title>Allocation - DoerHRM</title> 
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
            <h4 class="m-0"><i class="fa fa-calendar"></i>  Allocation</h4>
          </div>
        </div>
         <form class="form-inline">
          <select class="form-control" style="width: 25%" id="addmaincomp1" name="addmaincomp1">
           
            <?php foreach($listcompany as $row) 
            { ?>

             <option value="<?php echo $row->companyID ?>"><?php echo $row->company ?></option>
             <?php

           }
           ?>

         </select>
          <script type="text/javascript"> 
          $(document).ready(function(){

            $(document).on('click', ".saveMain1", function(){

               var companyID = document.getElementById("addmaincomp1").value; 
               var year = document.getElementById("mainallocationyear").value; 
               var initial = document.getElementById("initialLabel"); 
               var budgetid = document.getElementById("budgetinitialid").value;

             { 
              $("#addmaincomp").val(companyID);
             $("#addallocationyear").val(year);
             $("#budgetid").val(budgetid);     

             console.log(initial);
             if(initial!=null){
                  var initialdata = initial.textContent;
             $("#initialBudget").val(initialdata);      

             }else{
             $("#initialBudget").val(initialdata);      
             }
           }
         });

             $(document).on('click', ".saveSub1", function(){

             var companyID = document.getElementById("addmaincomp1").value; 
               var year = document.getElementById("mainallocationyear").value; 
               var initialsub = document.getElementById("initialsublabel"); 

             { $("#addsubcomp").val(companyID);
             $("#suballocationyear").val(year);     
              if(initialsub!=null){
                   var initialsubdata = initialsub.textContent;
              $("#initialsubBudget").val(initialsubdata);      

              }else{
              $("#initialsubBudget").val(0);      
              }
           }
         });
          });
        </script>
         &nbsp;&nbsp;
         
         <script>
           $(document).ready(function(){
        function selectmonth(date) {

            var day = new Date(date.getFullYear(), 1);
            $('#mainallocationyear').datepicker('update', day);
            $('#mainallocationyear').val(day.getFullYear());
           var comp = document.getElementById("addmaincomp1").value; 
            var alldata = 
            {
              comp:comp,
              year: day.getFullYear(),
            };
            console.log(alldata);
            $.ajax({
        url:"ajax-viewmain.php",
        data: alldata,
        dataType: "json",
        method: "POST",
        success:function(data){
          $("#showmainview").html(data); // This is A
        }
      });
          }
          weekpicker = $('#mainallocationyear');
          weekpicker.datepicker({
              autoclose: true,
              forceParse: false,
              orientation: 'bottom',
              minViewMode: "years"
          }).on("changeDate", function(e) {
              selectmonth(e.date);
          });
          selectmonth(new Date);

      //     function selectmonth1() {
      //      var comp = document.getElementById("addmaincomp1").value; 
      //      var year = document.getElementById("mainallocationyear").value; 
      //       var alldata = 
      //       {
      //         comp:comp,
      //         year:year,
      //       };
      //       console.log(alldata);
      //       $.ajax({
      //   url:"ajax-viewmain.php",
      //   data: alldata,
      //   dataType: "json",
      //   method: "POST",
      //   success:function(data){
      //     $("#showmainview").html(data); // This is A
      //   }
      // });
      //     }
      //     selectmonth1();

          });

        </script>
         <div class="col px-2">
                           <input class="form-control" style="width: 30%" id="mainallocationyear">
                         </div></form>
<!-- filter -->
         <br>
        <ul class="nav nav-tabs row px-2">
          <li class="nav-item col-12 col-xl-2 p-0">
            <a class="nav-link rounded-0 text-center active" data-toggle="tab" href="#mainAllocation"><span class="font-weight-bold">Main Allocation</span></a>
          </li>
          <li class="nav-item col-12 col-xl-2 p-0">
            <a class="nav-link rounded-0 text-center" data-toggle="tab" id="sub1" href="#allocation"><span class="font-weight-bold">Sub Allocation</span></a>
          </li>
          <li class="nav-item col-12 col-xl-2 p-0">
            <a class="nav-link rounded-0 text-center" data-toggle="tab" id="monthID" href="#monthly"><span class="font-weight-bold">Monthly Allocation</span></a>
          </li>
        </ul>
        
         <!-- Main Allocation Tab -->
         <div class="tab-content">
          <div class="tab-pane active" id="mainAllocation">
            <div class="row mt-3">
              <div class="col-xl-12 col-12">

             <!--    <script>
                  $(document).ready(function(){
                    function getviewmain($year){
                      weekpicker = $('#mainallocationyear');
                      weekpicker.datepicker({
                          autoclose: true,
                          forceParse: false,
                          orientation: 'bottom',
                          minViewMode: "years"
                      }).on("changeDate", function(e) {
                          selectmonthmain(e.date);
                      });
                      selectmonthmain(new Date);
                    }

                  function selectmonthmain(date) {

                      var day = new Date(date.getFullYear(), 1);
                      $('#mainallocationyear').datepicker('update', day);
                      $('#mainallocationyear').val(day.getFullYear());
                     var comp = document.getElementById("addmaincomp1").value; 
                      var alldata = 
                      {
                        comp:comp,
                        year: day.getFullYear(),
                      };
                      console.log(alldata);
                      $.ajax({
                  url:"ajax-viewmain.php",
                  data: alldata,
                  dataType: "json",
                  method: "POST",
                  success:function(data){
                    $("#showmainview").html(data); // This is A
                  }
                });
                    }

                  getviewmain();
                  });
                  </script> -->

            <div id="showmainview"></div> 
             </div>
           </div>
         </div>

         <!-- Sub Allocation -->
         <div class="tab-pane" id="allocation">
          <br>
          <script type="text/javascript">
            $(document).ready(function(){
              $(document).on('click', "#sub1", function(){
                var subid = document.getElementById("suballocationid").value;
                var budgetinitialid = document.getElementById("budgetinitialid").value;
                var alldata={
                  subid:subid,
                  budgetinitialid:budgetinitialid, 
                }

       $.ajax({
      url:"ajax-viewsub.php",
      data: alldata,
      dataType: "json",
      method: "POST",
      success:function(data){
          $("#showsubview").html(data); // This is A
        }
      });
   });
            });
          </script>

      <div id="showsubview"></div>   
     </div>

     <div class="tab-pane" id="monthly">

     <!-- monthly allocation -->
            <script type="text/javascript">
              $(document).ready(function(){
                $(document).on('click', "#monthID", function(){

                  var companyID = document.getElementById("addmaincomp1").value; 
                    var year = document.getElementById("mainallocationyear").value; 
              
             var alldata = 
                        {
                          comp:companyID,
                          year:year,
                        };
                        // console.log(alldata);
       // Depends on requirement, sometime we have loader with parameters
       $.ajax({
        url:"ajax-viewallocation.php",
        data: alldata,
        dataType: "json",
        method: "POST",
        success:function(data){
            $("#showmonthlyview").html(data); // This is A
          }
        });

     });
              });
             // function getmonthlyview(){
             //    $.ajax({
             //      url:"ajax-viewallocation.php",
             //      success:function(data){
             //        $("#showmonthlyview").html(data); 
             //      }
             //    });
             //  }
            </script>

            <div id="showmonthlyview"></div> 

       
    
        </div>



      </div>

      
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
   $("#sidebar-wrapper .active").removeClass("active");
   $("#budgetallocation").addClass("active").addClass("disabled");
   document.getElementById("budgetallocation").style.backgroundColor = "DeepSkyBlue";
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


