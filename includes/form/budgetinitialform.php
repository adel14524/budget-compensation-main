<!-- modal set net profit -->
<!-- modal add expenses -->
<!-- modal add categories -->


<script type="text/javascript">
  $(document).ready(function(){
   var form = $('#setnetprofitform');
   form.on('submit', function(e){
    e.preventDefault();  
    e.stopPropagation(); 

    document.getElementById("saveNP").innerHTML = "<span class='spinner-border spinner-border-sm'></span> Add";
    document.getElementById("saveNP").disabled = true; 

       var addcompanyyy = document.getElementById("addbudgetcompany").value;
      var addbudgetcorporate = document.getElementById("addbudgetcorporate").value;
      var addbudgetcompany = document.getElementById("addbudgetcompany").value;
      var addbudgetuser = document.getElementById("addbudgetuser").value;
      var addyear = document.getElementById("addyear").value;
      var addnptarget = document.getElementById("addnptarget").value;
      var addpercentbudget = document.getElementById("addpercentbudget").value;
      var addinitialbudget = document.getElementById("addinitialbudget").value;

      var alldata = 
      {
        addcompanyyy:addcompanyyy,
        addbudgetcorporate:addbudgetcorporate,
        addbudgetcompany:addbudgetcompany,
        addbudgetuser:addbudgetuser,
        addyear:addyear,
        addnptarget:addnptarget,
        addpercentbudget:addpercentbudget,
        addinitialbudget:addinitialbudget,
      };
 console.log(alldata);
 $.ajax({
  url: "ajax-addbudget.php",
  type: "POST",
  data: alldata,
  dataType:"json",
  success:function(data){
    document.getElementById("saveNP").innerHTML = "Save";
    document.getElementById("saveNP").disabled = false; 


    if(data.condition === "Passed"){
       document.getElementById("setnetprofitform").reset();
      $("#setnetprofit").modal("hide");
      getviewbudget();


    }else{
           checkvalidity("addcompanyyyerror", "#addcompanyyyerror","#addbudgetcompany",data.company); 
          checkvalidity("addyearerror", "#addyearerror","#addyear",data.year); 
          checkvalidity("addnptargeterror", "#addnptargeterror","#addnptarget",data.nptarget); 
          checkvalidity("addpercentbudgeterror", "#addpercentbudgeterror","#addpercentbudget",data.percentbudget); 
          checkvalidity("addinitialbudgeterror", "#addinitialbudgeterror","#addinitialbudget",data.initialbudget); 

        }
      }
    });
});
 });


         function getviewbudget($year){
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
         }

       function selectmonthnp(date) {

           var day = new Date(date.getFullYear(), 1);
           $('#budgetyear').datepicker('update', day);
           $('#budgetyear').val(day.getFullYear());
      
           var alldata = 
           {
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
         };

function checkvalidity(data1, data2, data3, data4){ //for show the validity error out
  document.getElementById(data1).innerHTML = data4;
  if(data4 === "Required"){
    $(data2).removeClass("text-success").addClass("text-danger");
    $(data3).removeClass("border-success").addClass("border-danger");
  }else if(data4 === "Valid"){
    $(data2).removeClass("text-danger").addClass("text-success");
    $(data3).removeClass("border-danger").addClass("border-success");
  }else{
    $(data2).removeClass("text-success").addClass("text-danger");
    $(data3).removeClass("border-success").addClass("border-danger");
  }
}
function clearform(data1, data2, data3){ //clear the error whenever close the modal
  $(data1).removeClass("text-success").removeClass("text-danger");
  document.getElementById(data2).textContent="";
  $(data3).removeClass("border-success").removeClass("border-danger");
}
</script>
<script>
           $(document).ready(function(){
        function selectmonth0(date) {
          var company= document.getElementById("addbudgetcompany").value;
            var day = new Date(date.getFullYear(), 1);
            $('#addyear').datepicker('update', day);
            $('#addyear').val(day.getFullYear());
           // var comp = document.getElementById("addmaincomp1").value; 
            var alldata = 
            {
              company:company,
              year: day.getFullYear(),
            };
            console.log(alldata);
            $.ajax({
        url:"ajax-gettotalbudget.php",
        data: alldata,
        method: "POST",
        success:function(data){
          $("#addinitialbudget").val(data); // This is A
        }
      });
          }

          weekpicker = $('#addyear');
          weekpicker.datepicker({
              autoclose: true,
              forceParse: false,
              orientation: 'bottom',
              minViewMode: "years"
          }).on("changeDate", function(e) {
              selectmonth0(e.date);
          });
          selectmonth0(new Date);
           });
        </script>

<!-- modal set net profit -->
<div class="modal fade" id="setnetprofit">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="padding: 70px">
      <div class="modal-header">
        <h6 class="modal-title">Set Net Profit Condition</h6>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <br>
      <!-- Modal body -->
      <div class="modal-body">
        <form id="setnetprofitform">
          <div class="form-group">
            <label>
              <h6 class="m-0">Company</h6></label>
              <select class="form-control" id="addbudgetcompany" name="addbudgetcompany">
                <option></option>
                        <?php foreach($listcompany as $row) 
                { ?>
                 <option value="<?php echo $row->companyID ?>"><?php echo $row->company ?></option>
                 <?php
                }
                ?>
              </select>
              <small><span id="addcompanyyyerror"></span></small> 
            </div>
           
            <div class="form-group">
              <label><h6 class="m-0">Year</h6></label>
              <input class="form-control" id="addyear">
                              <small><span id="addyearerror"></span></small>
              </div>
              <div class="form-group">
                <label><h6 class="m-0">Net Profit Target</h6></label>
                  <input class="form-control" type="number" id="addnptarget" name="addnptarget"> 
                  <small><span id="addnptargeterror"></span></small> 
                </div>
                <div class="form-group">
                  <label>
                    <h6 class="m-0">Percentage of Budget </h6></label>
                    <input class="form-control" type="number" id="addpercentbudget" name="addpercentbudget"> 
                    <small><span id="addpercentbudgeterror"></span></small> 
                  </div>
                  <div class="form-group">
                    <label>
                      <h6 class="m-0">Initial Budget</h6></label>
                      <input class="form-control" type="number" id="addinitialbudget" name="addinitialbudget">
                      <small><span id="addinitialbudgeterror"></span></small> 
                      <!-- <a href="#dah2489" data-toggle="collapse" id="getbudget"> <i class="fas fa-download"></i></a> -->

                  </div>
                    <br>
                    <input class="form-control" type="hidden" id="addbudgetcorporate" name="addbudgetcorporate" value="<?php echo $resultresult->corporateID ?>">
                   
                    <input class="form-control" type="hidden" id="addbudgetuser" name="addabudgetuser" value="<?php echo $resultresult->userID ?>">

                    <center>
                      <button name="saveNP" value="submit" type="submit" id="saveNP" class="btn btn-primary shadow-sm">Save</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </center>
                  </form>
                </div>
              </div>
            </div>
          </div>

<!-- delete script -->
          <script type="text/javascript">
             $(document).ready(function(){
              var form = $('#deletebudgetform');

              $(document).on('click', ".deleteBudgetInitial", function(){
                var budgetInitialID = $(this).data('id');
               
                    $("#deletebudgetid").val(budgetInitialID);
                    console.log(budgetInitialID);
                             });
              form.on('submit', function(e){
                e.preventDefault();
                e.stopPropagation();
                var deletebudgetid = document.getElementById("deletebudgetid").value;
                var alldata = "deletebudgetid="+deletebudgetid;
                document.getElementById("delNP").innerHTML = "<span class='spinner-border spinner-border-sm'></span> Add";
                document.getElementById("delNP").disabled = true; 

                console.log(alldata);
                $.ajax({
                  url: "ajax-deletebudget.php?lang=<?php echo $extlg;?>",
                  type: "POST",
                  data: alldata,
                  success:function(data){

                    document.getElementById("delNP").innerHTML = "Save";
                    document.getElementById("delNP").disabled = false; 

                    var obj = JSON.parse(data);
                    console.log(obj);
                    if(obj.condition === "Passed"){
                      $("#delbudget").modal("hide"); 
                      getviewbudget();
                    }
                  }
                });
              });

              $("#delbudget").on('hidden.bs.modal', function(){
                document.getElementById("deletebudgetform").reset(); 
              });

               function getviewbudget($year){
                 weekpicker = $('#addyear');
                 weekpicker.datepicker({
                     autoclose: true,
                     forceParse: false,
                     orientation: 'bottom',
                     minViewMode: "years"
                 }).on("changeDate", function(e) {
                     selectmonthbudget(e.date);
                 });
                 selectmonthbudget(new Date);
               }

             function selectmonthbudget(date) {

                 var day = new Date(date.getFullYear(), 1);
                 $('#addyear').datepicker('update', day);
                 $('#addyear').val(day.getFullYear());
            
                 var alldata = 
                 {
            
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
               };

              
            });  
          </script>
          <!-- Modal Delete  set net profit  -->
          <div class="modal fade" id="delbudget">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Delete</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <form id="deletebudgetform">
                  <input type="hidden" class="form-control" name="deletebudgetid" id="deletebudgetid">
                <div class="modal-body"> Are you sure you want to delete this budget? </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                  <button name="delNP" id="delNP" value="delete" type="delete" class="btn btn-primary shadow-sm">Delete</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </form>
                </div>
              </div>
            </div>
          </div>
          <!-- End delete modal -->


   <!-- update budget script  -->
   <script type="text/javascript">
     $(document).ready(function(){

       $(document).on('click', ".updatebudgetinitial", function(){
         var budgetInitialID = $(this).data('id');
         $.ajax({
           url: "ajax-getBudget.php?lang=<?php echo $extlg;?>",
           type: "POST",
           data: {budgetInitialID:budgetInitialID},
           dataType:"json",
           success:function(data){
             $("#updatebudgetid").val(data.id);
             $("#updatebudgetcompany").val(data.company);
             $("#updateyear").val(data.year);
             $("#updatenptarget").val(data.nptarget);
             $("#updatepercentbudget").val(data.percentbudget);
             $("#updateinitialbudget").val(data.initialbudget);
             // console.log(data.year);
           }
         });
         
       });

       var form = $('#updatenetprofitform');
       form.on('submit', function(e){
         e.preventDefault();
         e.stopPropagation();
         document.getElementById("updateNP").innerHTML = "<span class='spinner-border spinner-border-sm'></span> Updating";
         document.getElementById("updateNP").disabled = true; 

         var budget = document.getElementById("updatebudgetid").value;
         // var updcompany = document.getElementById("updatebudgetcompany").value;
         // var updyear = document.getElementById("updateyear").value;
         var updnptarget = document.getElementById("updatenptarget").value;
         var updpercentbudget = document.getElementById("updatepercentbudget").value;
         var updinitialbudget = document.getElementById("updateinitialbudget").value;


         var alldata = 
         {
           budget1:budget,
           // updcompany1:updcompany,
           // updyear1:updyear,
           updnptarget1:updnptarget,
           updpercentbudget1:updpercentbudget,
           updinitialbudget1:updinitialbudget
         };
         console.log(alldata);
         $.ajax({
           url: "ajax-updatebudget.php",
           type: "POST",
           data: alldata,
           dataType:"json",
           success:function(data){
             document.getElementById("updateNP").innerHTML = "Confirm";
             document.getElementById("updateNP").disabled = false; 
             if(data.condition === "Passed"){
              document.getElementById("updatenetprofitform").reset();
               $("#updatebudgett").modal("hide");
               getviewbudget();

            
             }else{
            
               checkvalidity("updatenptargeterror","#updatenptargeterror", "#updatenptarget", data.nptarget);
               checkvalidity("updatepercentbudgeterror","#updatepercentbudgeterror", "#updatepercentbudget", data.percentbudget);
               checkvalidity("updateinitialbudgeterror","#updateinitialbudgeterror", "#updateinitialbudget", data.initialbudget);

             }
           }
         });
       });
     });

         function getviewbudget($year){
           weekpicker = $('#budgetyear');
           weekpicker.datepicker({
               autoclose: true,
               forceParse: false,
               orientation: 'bottom',
               minViewMode: "years"
           }).on("changeDate", function(e) {
               selectmonthbudget(e.date);
           });
           selectmonthbudget(new Date);
         }
       function selectmonthbudget(date) {
           var day = new Date(date.getFullYear(), 1);
           $('#budgetyear').datepicker('update', day);
           $('#budgetyear').val(day.getFullYear());
           var alldata = 
           {
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
         };
     function checkvalidity(data1, data2, data3, data4){
       document.getElementById(data1).innerHTML = data4;
       if(data4 === "Required"){
         $(data2).removeClass("text-success").addClass("text-danger");
         $(data3).removeClass("border-success").addClass("border-danger");
       }else if(data4 === "Valid"){
         $(data2).removeClass("text-danger").addClass("text-success");
         $(data3).removeClass("border-danger").addClass("border-success");
       }else{
         $(data2).removeClass("text-success").addClass("text-danger");
         $(data3).removeClass("border-success").addClass("border-danger");
       }
     }

     function clearform(data1, data2, data3){
       $(data1).removeClass("text-success").removeClass("text-danger");
       document.getElementById(data2).textContent="";
       $(data3).removeClass("border-success").removeClass("border-danger");
     }

   </script>
   <script>
    $(document).ready(function(){
      function selectmonthnp(date) {

       var day = new Date(date.getFullYear(), 1);
       $('#updateyear').datepicker('update', day);
       $('#updateyear').val(day.getFullYear());
       var alldata = 
       {
         year: day.getFullYear(),
       };
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

     weekpicker = $('#updateyear');
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

<!-- modal edit net profit -->
<div class="modal fade" id="updatebudgett">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="padding: 70px">
      <div class="modal-header">
        <h6 class="modal-title">Set Net Profit Condition</h6>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <br>
      <!-- Modal body -->
      <div class="modal-body">
        <form id="updatenetprofitform">
          <input type="hidden" class="form-control" name="updatebudgetid" id="updatebudgetid">
          <div class="form-group">
            <label>
              <h6 class="m-0">Company</h6></label>
              <select class="form-control" id="updatebudgetcompany" name="updatebudgetcompany" disabled>
                <option></option>

                        <?php foreach($listcompany as $row) 
                { ?>
                 <option value="<?php echo $row->companyID ?>"><?php echo $row->company ?></option>
                 <?php
                }
                ?>
              </select>
              <small><span id="updatecompanyyyerror"></span></small> 
            </div>
            <div class="form-group">
              <label>
                <h6 class="m-0">Year</h6></label>
              <input class="form-control" id="updateyear" disabled>
                <small><span id="updateyearerror"></span></small>
                </select>
                <small><span id="updateyearerror"></span></small>
              </div>
              <div class="form-group">
                <label>
                  <h6 class="m-0">Net Profit Target</h6></label>
                  <input class="form-control" type="number" id="updatenptarget" name="updatenptarget"> 
                  <small><span id="updatenptargeterror"></span></small> 
                </div>
                <div class="form-group">
                  <label>
                    <h6 class="m-0">Percentage of Budget </h6></label>
                    <input class="form-control" type="number" id="updatepercentbudget" name="updatepercentbudget"> 
                    <small><span id="updatepercentbudgeterror"></span></small> 
                  </div>
                  <div class="form-group">
                    <label>
                      <h6 class="m-0">Initial Budget</h6></label>
                      <input class="form-control" type="number" id="updateinitialbudget" name="updateinitialbudget">
                      <small><span id="updateinitialbudgeterror"></span></small> 
                      <!-- <a href="#dah2489" data-toggle="collapse"> <i class="fas fa-download"></i></a> -->
                    </div>
                    <br>
                 
                    <center>
                      <button name="updateNP" value="submit" type="submit" id="updateNP" class="btn btn-primary shadow-sm">Save</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </center>
                  </form>
                </div>
              </div>
            </div>
          </div>