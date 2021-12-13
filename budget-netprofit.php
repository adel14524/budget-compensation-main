
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
    <title>Net Profit - DoerHRM</title> 
    <?php
    include 'includes/header.php';
    ?>
  </head>
  
  <body>
    <?php include 'includes/topbar.php';?>
    <div class="d-flex" id="wrapper">
      <?php include 'includes/navbar.php';?>
      <div id="page-content-wrapper">
        <div class="container-fluid" id="net-profit"> 
          <div class="row my-4">
            <div class="col">
              <h4 class="m-0"><i class="fas fa-hand-holding-usd"></i>Net Profit Overview</h4>
            </div>
          </div>
          <script src="https://cdn.jsdelivr.net/npm/chart.js@3.4.1/dist/chart.min.js">  
          </script>




          <meta name="viewport" content="width=device-width, initial-scale=1">


          <form class="form-inline">
            <select class="form-control" style="width:25%; transition: box-shadow .3s;" id="companyyy" name="companyyy">
              
                    <?php foreach($listcompany as $row) 
            { ?>

             <option value="<?php echo $row->companyID ?>"><?php echo $row->company ?></option>
             <?php

            }
            ?>
            </select>

            <script type="text/javascript"> 

          $(document).ready(function(){

            $(document).on('click', ".setGP", function(){

             var companyID = document.getElementById("companyyy").value; 
             var npyear = document.getElementById("netprofityear").value; 


             { $("#choosegpcomp").val(companyID); 
             $("#choosegpyear").val(npyear);     
           }

         });
          });
        </script>

            &nbsp;&nbsp;

<!-- add gross profit -->

<script>
 $(document).ready(function(){
  function selectgp(date) {

    var day = new Date(date.getFullYear(), 1);
    $('#netprofityear').datepicker('update', day);
    $('#netprofityear').val(day.getFullYear());
    var comp = document.getElementById("companyyy").value; 
    /* var year = document.getElementById("netprofityear").value; */
    var alldata = 
    {
      comp:comp,
      year: day.getFullYear(),
    };
    console.log(alldata);
    $.ajax({
      url:"ajax-viewgp.php",
      data: alldata,
      dataType: "json",
      method: "POST",
      success:function(data){
            $("#showgpview").html(data); // This is A
          }
        });
  }

  weekpicker = $('#netprofityear');
  weekpicker.datepicker({
    autoclose: true,
    forceParse: false,
    orientation: 'bottom',
    minViewMode: "years"
  }).on("changeDate", function(e) {
    selectgp(e.date);
  });

  selectgp(new Date);

 
});
</script>
         <div class="col px-2">
                           <input class="form-control" style="width: 30%; transition: box-shadow .3s;" id="netprofityear">
                         </div>
          </form>
     <!--      <div style="float:right">
           <button type="button" class="btn btn-primary shadow-sm setGP" data-toggle="modal" data-target="#gpmodal">Add GP</button>   
           </div> -->
         <br>

         <script type="text/javascript">
          $(document).ready(function(){

           function getnetprofit($year){ 
            weekpicker = $('#netprofityear');
            weekpicker.datepicker({
              autoclose: true,
              forceParse: false,
              orientation: 'bottom',
              minViewMode: "years"
            }).on("changeDate", function(e) {
              selectgp(e.date);
            });

            selectgp(new Date);
          }

          function selectgp(){
           var comp = document.getElementById("companyyy").value;
           var year = document.getElementById("netprofityear").value; 
           var alldata = 
           {
            comp:comp,
            year:year,
          };
          console.log(alldata);
          $.ajax({
            url:"ajax-viewgp.php",
            data: alldata,
            dataType: "json",
            method: "POST",
            success:function(data){
          $("#showgpview").html(data); // This is A
        }
      });

        }
        getnetprofit();

      });
    </script>

    <div id="showgpview"></div>   

<!-- <script type="text/javascript">
               $(document).ready(function(){
                var companyID = document.getElementById("companyyy").value; 
                var year = document.getElementById("netprofityear").value; 

                var alldata ={

                  companyid:companyID,
                  year:year,
                }


                function getnpchartview(){ 
                 $.ajax({
                  url:"ajax-getviewnpchart.php",
                  data: alldata,
                  dataType: "json",
                  method: "POST",
                   success:function(data){
                     $("#shownpchartview").html(data);
                   }
                 });
               }
               getnpchartview(); 
             });
           </script> -->

           <!-- <script type="text/javascript">
               $(document).ready(function(){
                 function getnpchartview($year){
                   weekpicker = $('#netprofityear');
                   weekpicker.datepicker({
                       autoclose: true,
                       forceParse: false,
                       orientation: 'bottom',
                       minViewMode: "years"
                   }).on("changeDate", function(e) {
                       getnpchart(e.date);
                   });
                   getnpchart(new Date);
                 }
                function getnpchart(date){ 
                   var day = new Date(date.getFullYear(), 1);
                   $('#netprofityear').datepicker('update', day);
                   $('#netprofityear').val(day.getFullYear());
                  var comp = document.getElementById("companyyy").value; 
                   var alldata = 
                   {
                     comp:comp,
                     year: day.getFullYear(),
                   };
                 $.ajax({
                  url:"ajax-getviewnpchart.php",
                  data: alldata,
                  dataType: "json",
                  method: "POST",
                   success:function(data){
                     $("#shownpchartview").html(data);
                   }
                 });
               }
               getnpchartview(); 
             });
           </script>
              <div id="shownpchartview"></div> -->
            </div>
            </div>

        <!-- <script type="text/javascript">
          $(document).ready(function(){
           $("#sidebar-wrapper .active").removeClass("active");
           $("#netprofit").addClass("active").addClass("disabled");
           document.getElementById("netprofit").style.backgroundColor = "DeepSkyBlue";
         });
       </script> -->
     </div>


<?php
include 'includes/form.php';
?>
<?php
include 'includes/footer.php';
?>
   </body>
   </html>
 </head>

  