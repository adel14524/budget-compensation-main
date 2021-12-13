<!-- add plan script  -->
<script type="text/javascript">
  $(document).ready(function(){

   var form = $('#addplanform');
   form.on('submit', function(e){
    e.preventDefault();  
    e.stopPropagation(); 

    document.getElementById("savePlan").innerHTML = "<span class='spinner-border spinner-border-sm'></span> Add";
    document.getElementById("savePlan").disabled = true; 

      var company = document.getElementById("Choosecompany").value;
      // console.log(company);
      var plan = document.getElementById("planName").value;
      var type = document.getElementById("type").value;
      if(type=="onetime"){
        var startdate = document.getElementById("addstartdate").value;
        var enddate = document.getElementById("addenddate").value;
        var month = "--";
        var year = "--";
      }
      else if(type=="monthly"){
        var startdate = document.getElementById("addstartdate2").value;
        var month = document.getElementById("choosemonth").value;
        var date = new Date(startdate);
        var newenddate = new Date(date.setMonth(date.getMonth() + parseInt(month)));
        var d = newenddate.getDate();
        var m =  newenddate.getMonth()+1;
        var y = newenddate.getFullYear();
        var newenddate= y + "-" + m + "-" + d;
        var enddate = document.getElementById("addenddate2").value = newenddate;
        var year = "--";
      }
      else if(type=="annually"){
        var month = "--";
        var year = document.getElementById("yeartype").value;
        var newstartdate = new Date(year, 0, 1);
        var d = newstartdate.getDate();
        var m =  newstartdate.getMonth()+1;
        var y = newstartdate.getFullYear();
        var startdate= y + "-" + m + "-" + d;

        var newenddate = new Date(year, 11, 30);
        var d = newenddate.getDate();
        var m =  newenddate.getMonth()+1;
        var y = newenddate.getFullYear();
        var enddate= y + "-" + m + "-" + d;
        // console.log(startdate);
        // console.log(enddate);

      }
      var measure= document.getElementById("chooseTarget");
      var pm = document.getElementById("choosePM").value;
   
      var corporate = document.getElementById("addcorpplan").value;
      // var company = document.getElementById("addcompplan").value;
      var user = document.getElementById("adduserplan").value;

      var str='';
        for (i=0;i< measure.length;i++) { 
            if(measure[i].selected){
              str += measure[i].value + ','; 
            }
          } 
          var str=str.slice(0,str.length -1);
      
       // console.log(str);

      var alldata = 
      {
      company:company,
      plan:plan,
      type:type,
      startdate:startdate,
      enddate:enddate,
      month:month,
      year:year,
      measure:str,
      pm:pm,
      corporate:corporate,
      user:user,
      };
      // console.log(alldata);

 $.ajax({
  url: "ajax-addcompensation.php",
  type: "POST",
  data: alldata,
  dataType:"json",
  success:function(data){
    document.getElementById("savePlan").innerHTML = "Save";
    document.getElementById("savePlan").disabled = false; 


    if(data.condition === "Passed"){
      document.getElementById("addplanform").reset();
      $("#planmodal").modal("hide");
       getcompensation();
        
    }else{
          checkvalidity("choosecomperror", "#choosecomperror","#Choosecompany",data.company); 
          checkvalidity("planNameError", "#planNameError","#planName",data.planname); 
          checkvalidity("plantypeerror", "#plantypeerror","#plantype",data.plantype);
          if(plantype=="onetime"){
            checkvalidity("addstartdateerror", "#addstartdateerror","#addstartdate",data.startdate); 
            checkvalidity("addenddateerror", "#addenddateerror","#addenddate",data.enddate);
          }
          else if(plantype=="monthly"){
            checkvalidity("addenddate2error", "#addenddate2error","#addenddate2",data.enddate);
            checkvalidity("addstartdate2error", "#addstartdate2error","#addstartdate2",data.startdate);
            checkvalidity("choosemontherror", "#choosemontherror","#choosemonth",data.month);
          }
          else if (plantype=="annually"){
             checkvalidity("yeartypeerror", "#yeartypeerror","#yeartype",data.year); 
          }
          checkvalidity("chooseTargeterror", "#chooseTargeterror","#chooseTarget",data.measure);
          checkvalidity("choosePMerror", "#choosePMerror","#choosePM",data.pm);  
        }
      }
    });
});
   $('#Choosecompany').change(function() {

         var companyID = $(this).val();
         $.ajax({
           url:"ajax-getuserlist.php",
           method:"POST",
           data:{companyID:companyID},
           dataType:"json",
           success:function(data){

               $('#chooseTarget').html(data).selectpicker('refresh');

           }
         });

       });
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
          /*console.log(alldata);*/
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
                  $(document).ready(function(){
                   function selectyear(date) {

                     var day = new Date(date.getFullYear(), 1);
                     $('#yeartype').datepicker('update', day);
                     $('#yeartype').val(day.getFullYear());
                     var alldata = 
                     {
                       year: day.getFullYear(),
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
                   weekpicker = $('#yeartype');
                   weekpicker.datepicker({
                     autoclose: true,
                     forceParse: false,
                     orientation: 'bottom',
                     minViewMode: "years"
                   }).on("changeDate", function(e) {
                     selectyear(e.date);
                   });

                   selectyear(new Date);

                 });
               
  });
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

<script type="text/javascript">
  $(document).ready(function(){
    $('#choosemonth').on('change', function() {

      var startdate = document.getElementById("addstartdate2").value;
      var month = document.getElementById("choosemonth").value;
      var date = new Date(startdate);
      var newenddate = new Date(date.setMonth(date.getMonth() + parseInt(month)));
      var day = ("0" + newenddate.getDate()).slice(-2);
      var month = ("0" + (newenddate.getMonth() + 1)).slice(-2);
      var y = newenddate.getFullYear();
      var newdate = newenddate.getFullYear()+"-"+ month +"-"+day;
      $('#addenddate2').val(newdate);
      // console.log(newenddate);
      var year = "--";
});
  });
</script>




<!-- add plan form -->
<div class="modal fade" id="planmodal">
 <div class="modal-dialog modal-lg">
  <div class="modal-content"> 
    <div class="modal-body">
      <form id="addplanform">
          <div class="row">
            <div class="col-1"></div>
            <div class="col-12 col-sm-10 py-4">
             <div class="modal-header">
              <h6 class="modal-title">Add Plan</h6>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <input class="form-control" type="hidden" id="addcorpplan" name="addcorpplan" value="<?php echo $resultresult->corporateID ?>">
            <input class="form-control" type="hidden" id="addcompplan" name="addcompplan" value="<?php echo $resultresult->companyID ?>">
            <input class="form-control" type="hidden" id="adduserplan" name="adduserplan" value="<?php echo $resultresult->userID ?>">
            <div class="modal-body">
            <div class="form-group">
              <div class="row">
                <div class="col">
                  <label><h6 class="m-0">Company</h6></label>
                  <select class="form-control" id="Choosecompany" name="Choosecompany">
                    <option value="">--</option>
                    <?php foreach($listcompany as $row) 
                    { ?>
                     <option value="<?php echo $row->companyID ?>"><?php echo $row->company ?></option>
                     <?php
                   }
                   ?>
                 </select>
                 <small><span id="choosecomperror"></span></small>
               </div>
             </div>
           </div>

           <div class="form-group">
            <div class="row">
              <div class="col">
                <label><h6 class="m-0">Plan Name</h6></label>
                <input type="text" class="form-control rounded-0" id="planName" name="planName" autocomplete="off">
                <small><span id="planNameError"></span></small>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label><h6 class="m-0">Type</h6></label>
            <select class="form-control" id="type" name="type" >
              <option value="">--</option>
              <option value="onetime">One Time</option>
              <option value="monthly">Monthly</option>
              <option value="annually">Annually</option>
            </select>
            <small><span id="plantypeerror"></span></small>
          </div>
         
                    <div class="row" id="onetimetype" style="display:none">
                      <div class="col-12 col-xl-6">
                        <div class="form-group">
                          <label><h6 class="m-0">Start Date</h6></label>
                          <input type="date" class="form-control selectpicker" id="addstartdate" name="addstartdate" autocomplete="off">
                        </div>
                        <small><span id="addstartdateerror"></span></small>

                      </div>
                      <div class="col-12 col-xl-6">
                        <div class="form-group">
                          <label><h6 class="m-0">End Date</h6></label>
                          <input type="date" class="form-control selectpicker" id="addenddate" name="addenddate" autocomplete="off">
                        </div>
                        <small><span id="addenddateerror"></span></small>
                      </div>
                    </div>

                    <div class="row" id="monthlytype" style="display:none">
                      <div class="col-12 col-xl-6">
                        <div class="form-group">
                          <label><h6 class="m-0">Start Date</h6></label>
                          <input type="date" class="form-control selectpicker" id="addstartdate2" name="addstartdate2" autocomplete="off">
                        </div>
                        <small><span id="addstartdate2error"></span></small>
                      </div>

                      <div class="col-12 col-xl-6">
                       <div class="form-group">
                        <label><h6 class="m-0">Month</h6></label>
                        <select class="form-control" id="choosemonth" name="choosemonth">
                          <option value="">--</option>
                          <option value="1">1 month</option>
                          <option value="2">2 months</option>
                          <option value="3">3 months</option>
                          <option value="4">4 months</option>
                          <option value="5">5 months</option>
                          <option value="6">6 months</option>
                          <option value="7">7 months</option>
                          <option value="8">8 months</option>
                          <option value="9">9 months</option>
                          <option value="10">10 months</option>
                          <option value="11">11 months</option>
                          <option value="12">12 months</option>

                          <small><span id="choosemontherror"></span></small>
                        </select>
                      </div>
                    </div>

                      <div class="col-12 col-xl-6">
                        <div class="form-group">
                          <label><h6 class="m-0">End Date</h6></label>
                          <input type="date" class="form-control selectpicker" id="addenddate2" name="addenddate2" autocomplete="off">
                        </div>
                        <small><span id="addenddate2error"></span></small>
                      </div>
                    </div>

                    <div class="row" id="annuallytype" style="display:none">
                      <div class="col-12 col-xl-6">
                        <div class="form-group">
                          <label><h6 class="m-0">Year</h6></label>
                          <input class="form-control" id="yeartype" >
                        </div>
                        <small><span id="yeartypeerror"></span></small>

                      </div>
                    </div>

                    <div class="form-group">
                      <form class="form-inline">
                         <label><h6 class="m-0">Measure Performance </h6></label>
                        <select class="form-control mb-2 mr-sm-2 chooseTarget selectpicker" id="chooseTarget" name="chooseTarget" multiple>
                         <option value="">--</option> 
                       </select>
                      <small><span id="chooseTargeterror"></span></small>

                     </form>
                     <div class="form-group">
                      <label><h6 class="m-0">Performance Metric</h6></label>
                      <select class="form-control" id="choosePM" name="choosePM">
                        <option value="">--</option>
                        <option value="Revenue">Revenue</option>
                        <option value="Gross Profit">Gross Profit</option>
                        <option value="Key Performance Indicator">Key Performance Indicator</option>
                        <small><span id="choosePMerror"></span></small>
                      </select>
                    </div>
                </div>

                 <div class="row">
                  <div class="col text-right">
                  <button name="submit" value="submit" type="submit" id="savePlan" class="btn btn-primary shadow-sm">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancelplan">Cancel</button>
                  </div>
                </div>
              </div>
            
            </div></div>
       
          </form></div></div>     </div></div>
          
<script>
  $(document).ready(function(){
      $('#type').on('change', function() {
        if ( this.value == 'onetime')
        {
          $("#onetimetype").show();
          $("#monthlytype").hide();
          $("#annuallytype").hide();
        }
        else if(this.value == 'monthly'){
          $("#monthlytype").show();
          $("#onetimetype").hide();
          $("#annuallytype").hide();

        }
        else if(this.value == 'annually'){
          $("#annuallytype").show();
          $("#onetimetype").hide();
          $("#monthlytype").hide();
        }
        
        else
        {
          $("#onetimetype").hide();
          $("#monthlytype").hide();
          $("#annuallytype").hide();

        }
      });
      });
</script>


<!-- update plan script  -->
<script type="text/javascript">
  $(document).ready(function(){

    $(document).on('click', ".updateplancompensation", function(){
      var compensationID = $(this).data('id');
      $.ajax({
        url: "ajax-getcompensation.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: {compensationID:compensationID},
        dataType:"json",
        success:function(data){
          $("#updcompensationid").val(data.id);
          $("#updplancompany").val(data.company);
          $("#updplanName").val(data.planname);
         
          $("#updtype").val(data.type);
          if(data.type=="onetime"){
            $("#updstartdate").val(data.startdate);
            $("#updenddate").val(data.enddate);
          }
          else if(data.type=="monthly"){
            $("#updstartdate2").val(data.startdate);
            $("#updenddate2").val(data.enddate);
            $("#updchoosemonth").val(data.month);
          }
          else if(data.type=="annually"){
            $("#updyeartype").val(data.year);
          }
          $('#updchooseTarget').selectpicker('val',data.measure).selectpicker('refresh');
          // console.log(data.target);
          $("#updchoosePM").val(data.pm);
          $("#updtargetid").val(data.target);

       }
     });  
    });

    var form = $('#updplanform');
    form.on('submit', function(e){
      e.preventDefault();
      e.stopPropagation();
      document.getElementById("saveupdPlan").innerHTML = "<span class='spinner-border spinner-border-sm'></span> Updating";// Refer to 8)
      document.getElementById("saveupdPlan").disabled = true; 
      var compensationID = document.getElementById("updcompensationid").value;
      var company = document.getElementById("updplancompany").value;
      var planname = document.getElementById("updplanName").value;
      var type = document.getElementById("updtype").value;
      if (type=="onetime") {
        var startdate = document.getElementById("updstartdate").value;
        var enddate = document.getElementById("updenddate").value;
        var month = "--";
        var year = "--";

      }
      else if (type=="monthly") {
        var startdate = document.getElementById("updstartdate2").value;
        var enddate = document.getElementById("updenddate2").value;
        var month = document.getElementById("updchoosemonth").value;

        var date = new Date(startdate);
        var newenddate = new Date(date.setMonth(date.getMonth() + parseInt(month)));
        var d = newenddate.getDate();
        var m =  newenddate.getMonth()+1;
        var y = newenddate.getFullYear();
        var newenddate= y + "-" + m + "-" + d;
        var enddate = document.getElementById("updstartdate2").value = newenddate;
        var year = "--";
      }
      else if (type=="annually") {
        var month = "--";
        var year = document.getElementById("updyeartype").value;
        var newstartdate = new Date(year, 0, 1);
        var d = newstartdate.getDate();
        var m =  newstartdate.getMonth()+1;
        var y = newstartdate.getFullYear();
        var startdate= y + "-" + m + "-" + d;

        var newenddate = new Date(year, 11, 30);
        var d = newenddate.getDate();
        var m =  newenddate.getMonth()+1;
        var y = newenddate.getFullYear();
        var enddate= y + "-" + m + "-" + d;
      }
      var measure = document.getElementById("updchooseTarget");
      var pm = document.getElementById("updchoosePM").value;
      var target =  document.getElementById("updtargetid").value; 

      var str='';
        for (i=0;i< measure.length;i++) { 
            if(measure[i].selected){
              str += measure[i].value + ','; 
            }
          } 
          var str=str.slice(0,str.length -1);
      
       var alldata = 
       {
        compensationID:compensationID, /**/
        company:company,
        planname:planname,
        type:type,
        startdate:startdate,
        enddate:enddate,
        month:month,
        year:year,
        measure:str,
        pm:pm,
        target:target
      };

      // console.log(alldata);
      $.ajax({
        url: "ajax-updatecompensation.php",
        type: "POST",
        data: alldata,
        dataType:"json",
        success:function(data){
          document.getElementById("saveupdPlan").innerHTML = "Confirm";// Refer to 8)
          document.getElementById("saveupdPlan").disabled = false; // Refer to 8)
          if(data.condition === "Passed"){
            $("#updateplancompensation").modal("hide");
             getcompensation();
           
          }else{
            checkvalidity("updplancompanyerror","#updplancompanyerror", "#updplancompany", data.company);/*data.update keno guna dkt ajax belah kanan*/
            checkvalidity("updplanNameerror","#updplanNameerror", "#updplanName", data.planname);
            checkvalidity("updplantypeerror","#updplantypeerror", "#updtype", data.type);
            if (data.type=="onetime") {
              checkvalidity("updstartdateerror","#updstartdateerror", "#updstartdate", data.startdate);
               checkvalidity("updenddateerror","#updenddateerror", "#updenddate", data.enddate);
            }
            else if(data.type=="monthly"){
              checkvalidity("updstartdate2error","#updstartdate2error", "#updstartdate2", data.startdate);
               checkvalidity("updenddate2error","#updenddate2error", "#updenddate2", data.enddate);
               checkvalidity("updchoosemontherror","#updchoosemontherror", "#updchoosemonth", data.month);
            }
            else if(data.type=="annually"){
               checkvalidity("updyeartype","#updyeartypeerror", "#updyeartype", data.year);
            }
           checkvalidity("updchooseTargeterror", "#updchooseTargeterror","#updchooseTarget",data.measure); 
           checkvalidity("updchoosePMerror", "#updchoosePMerror","#updchoosePM",data.pm); 
          }
        }
      });
    });

   
      $(document).on('click', ".compensationplan", function(){
          var companyID = $(this).data("companyid");
          // console.log(companyID);

          $.ajax({
            url:"ajax-getuserlist.php",
            method:"POST",
            data:{companyID:companyID},
            dataType:"json",
            success:function(data){

                $('#updchooseTarget').html(data).selectpicker('refresh');
            }
          });
        });

                     $(document).ready(function(){
                      function selectyear(date) {

                        var day = new Date(date.getFullYear(), 1);
                        $('#updyeartype').datepicker('update', day);
                        $('#updyeartype').val(day.getFullYear());
                        var alldata = 
                        {
                          year: day.getFullYear(),
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
                      weekpicker = $('#updyeartype');
                      weekpicker.datepicker({
                        autoclose: true,
                        forceParse: false,
                        orientation: 'bottom',
                        minViewMode: "years"
                      }).on("changeDate", function(e) {
                        selectyear(e.date);
                      });

                      selectyear(new Date);

                    });

     });
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
       /*console.log(alldata);*/
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

<script type="text/javascript">
  $(document).ready(function(){
    $('#updchoosemonth').on('change', function() {

      var startdate = document.getElementById("updstartdate2").value;
      var month = document.getElementById("updchoosemonth").value;
      var date = new Date(startdate);
      var newenddate = new Date(date.setMonth(date.getMonth() + parseInt(month)));
      var day = ("0" + newenddate.getDate()).slice(-2);
      var month = ("0" + (newenddate.getMonth() + 1)).slice(-2);
      var y = newenddate.getFullYear();
      var newdate = newenddate.getFullYear()+"-"+ month +"-"+day;
      $('#updenddate2').val(newdate);
      // console.log(newenddate);
      var year = "--";
});
  });
</script>


 <div class="modal-body">
<form id="updplanform">
<div class="modal fade" id="updateplancompensation" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
         <div class="row"> 
          <div class="col-1"></div>
          <div class="col-12 col-sm-10 py-4">
           <div class="modal-header">
                  <h6 class="modal-title">Update Plan</h6>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
           <br>
           <input class="form-control" type="hidden" id="updtargetid" name="updtargetid" value="">
           <input class="form-control" type="hidden" id="updcompensationid" name="updcompensationid" value="">
           <input class="form-control" type="hidden" id="updcorpplan" name="updcorpplan" value="<?php echo $resultresult->corporateID ?>">
           <input class="form-control" type="hidden" id="updcompplan" name="updcompplan" value="<?php echo $resultresult->companyID ?>">
           <input class="form-control" type="hidden" id="upduserplan" name="upduserplan" value="<?php echo $resultresult->userID ?>">
              <div class="form-group">
                <div class="row">
                  <div class="col">
                    <label><h6 class="m-0">Company</h6></label>
                    <select class="form-control updplancompany" disabled id="updplancompany" name="updplancompany">
                      <option value=""></option>
                              <?php foreach($listcompany as $row) 
                      { ?>
                       <option value="<?php echo $row->companyID ?>"><?php echo $row->company ?></option>
                       <?php
                      }
                      ?>
                    </select>
                    <small><span id="updplancompanyerror"></span></small>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="row">
                  <div class="col">
                    <label><h6 class="m-0">Plan Name</h6></label>
                    <input type="text" class="form-control rounded-0" id="updplanName" name="updplanName" autocomplete="off">
                    <small><span id="updplanNameerror"></span></small>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label><h6 class="m-0">Type</h6></label>
                <select class="form-control" id="updtype" name="updtype" disabled>
                  <option value="">--</option>
                  <option value="onetime">One Time</option>
                  <option value="monthly">Monthly</option>
                  <option value="annually">Annually</option>
                </select>
                <small><span id="updplantypeerror"></span></small>
              </div>

              <div class="row" id="updonetimetype" style="display:none">
                <div class="col-12 col-xl-6">
                  <div class="form-group">
                    <label><h6 class="m-0">Start Date</h6></label>
                    <input type="date" class="form-control selectpicker" id="updstartdate" name="updstartdate" autocomplete="off">
                  </div>
                  <small><span id="updstartdateerror"></span></small>

                </div>
                <div class="col-12 col-xl-6">
                  <div class="form-group">
                    <label><h6 class="m-0">End Date</h6></label>
                    <input type="date" class="form-control selectpicker" id="updenddate" name="updenddate" autocomplete="off">
                  </div>
                  <small><span id="updenddateerror"></span></small>
                </div>
              </div>

              <div class="row" id="updmonthlytype" style="display:none">
                <div class="col-12 col-xl-6">
                  <div class="form-group">
                    <label><h6 class="m-0">Start Date</h6></label>
                    <input type="date" class="form-control selectpicker" id="updstartdate2" name="updstartdate2" autocomplete="off">
                  </div>
                  <small><span id="updstartdate2error"></span></small>
                </div>

                  <div class="col-12 col-xl-6">
                   <div class="form-group">
                    <label><h6 class="m-0">Month</h6></label>
                    <select class="form-control" id="updchoosemonth" name="updchoosemonth">
                      <option value="">--</option>
                      <option value="1">1 month</option>
                      <option value="2">2 months</option>
                      <option value="3">3 months</option>
                      <option value="4">4 months</option>
                      <option value="5">5 months</option>
                      <option value="6">6 months</option>
                      <option value="7">7 months</option>
                      <option value="8">8 months</option>
                      <option value="9">9 months</option>
                      <option value="10">10 months</option>
                      <option value="11">11 months</option>
                      <option value="12">12 months</option>

                      <small><span id="updchoosemontherror"></span></small>
                    </select>
                  </div>
                </div>

                <div class="col-12 col-xl-6">
                  <div class="form-group">
                    <label><h6 class="m-0">End Date</h6></label>
                    <input type="date" class="form-control selectpicker" id="updenddate2" name="updenddate2" autocomplete="off" disabled>
                  </div>
                  <small><span id="updenddate2error"></span></small>
                </div>
              </div>

              <div class="row" id="updannuallytype" style="display:none">
                <div class="col-12 col-xl-6">
                  <div class="form-group">
                    <label><h6 class="m-0">Year</h6></label>
                    <input class="form-control" id="updyeartype" >
                  </div>
                  <small><span id="updyeartypeerror"></span></small>

                </div>
              </div>

              <div class="form-group">
                <form class="form-inline">
                 <label><h6 class="m-0">Measure Performance </h6></label>
                 <select class="form-control mb-2 mr-sm-2 updchooseTarget selectpicker" id="updchooseTarget" name="updchooseTarget" multiple>
                  
                   <small><span id="updchooseTargeterror"></span></small>
                 </select>
               </form>
             </div>
              <div class="form-group">
               <label><h6 class="m-0">Performance Metric</h6></label>
               <select class="form-control" id="updchoosePM" name="updchoosePM">
                 <option value="">--</option>
                 <option value="Revenue">Revenue</option>
                 <option value="Gross Profit">Gross Profit</option>
                 <option value="Key Performance Indicator">Key Performance Indicator</option>
                 <small><span id="updchoosePMerror"></span></small>
               </select>
             </div>

            <div class="row">
              <div class="col text-right">
                <button name="submit" value="submit" type="submit" id="saveupdPlan" class="btn btn-primary shadow-sm">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancelplanupd">Cancel</button>
              </div>
            </div>
           </div>                          
         </div></div>    
      </form></div>

    </div>     
    </div></div>
                        
              <script>
                $(document).ready(function(){
                    // $('#updtype').on('change', function() {
                $(document).on('click', ".updateplancompensation", function(){
                  var compensationID = $(this).data('id');

                   $.ajax({
                     url: "ajax-getcompensation.php?lang=<?php echo $extlg;?>",
                     type: "POST",
                     data: {compensationID:compensationID},
                     dataType:"json",
                     success:function(data){
                     
                       $("#updtype").val(data.type);

                        if (data.type == 'onetime')
                      {
                        $("#updonetimetype").show();
                        $("#updmonthlytype").hide();
                        $("#updannuallytype").hide();
                      }
                      else if(data.type == 'monthly'){
                        $("#updmonthlytype").show();
                        $("#updonetimetype").hide();
                        $("#updannuallytype").hide();
                      }
                      else if(data.type == 'annually'){
                        $("#updannuallytype").show();
                        $("#updonetimetype").hide();
                        $("#updmonthlytype").hide();
                      }
                      else
                      {
                        $("#updonetimetype").hide();
                        $("#updmonthlytype").hide();
                        $("#updannuallytype").hide();
                      }
                    }
                  }); 
                     
                    });
                    });
                  </script>



                  <script type="text/javascript">

                   $(document).ready(function(){
                    var form = $('#deletecompensationform');

                    $(document).on('click', ".deleteCompensation", function(){
                      var compensationID = $(this).data('id');

                      $("#deletecompensationid").val(compensationID);
                      console.log(compensationID);


                    });

                    form.on('submit', function(e){
                      e.preventDefault();
                      e.stopPropagation();
                      var compensationID = document.getElementById("deletecompensationid").value;
                      var alldata = "deletecompensationid="+compensationID;
                      console.log(alldata);
                      $.ajax({
                        url: "ajax-deletecompensation.php?lang=<?php echo $extlg;?>",
                        type: "POST",
                        data: alldata,
                        success:function(data){
                          var obj = JSON.parse(data);
                          console.log(obj);
                          if(obj.condition === "Passed"){
                            $("#deleteCompensation").modal("hide"); 
                            getcompensation();
                          }
                        }
                      });
                    });

                    $("#deleteCompensation").on('hidden.bs.modal', function(){
                      document.getElementById("deletecompensationform").reset(); 
                    });

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
                         /*console.log(alldata);*/
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

                });  
              </script>



          <!-- delete compensation -->
          <div class="modal fade" id="deleteCompensation">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Delete</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <form id="deletecompensationform">
                  <input type="text" class="form-control" name="deletecompensationid" id="deletecompensationid">
                <div class="modal-body"> Are you sure you want to delete this? </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                  <button name="delete" value="delete" type="delete" class="btn btn-primary shadow-sm">Delete</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
              </form>
              </div>
            </div>
          </div>


         <!-- add condition individual target script -->
         <script type="text/javascript">

           $(document).ready(function(){
             $(document).on('click', ".addindCondition", function(){
               var compensationID = $(this).data('id');
               $.ajax({
                 url: "ajax-getpm.php?lang=<?php echo $extlg;?>",
                 type: "POST",
                 data: {compensationID:compensationID},
                 dataType:"json",
                 success:function(data){
                   $("#pm").val(data.pm);  
                  
                }
              });  
             });


            var form = $('#addindtargetform');
            form.on('submit', function(e){
             e.preventDefault();  
             e.stopPropagation(); 

             document.getElementById("saveIndCond").innerHTML = "<span class='spinner-border spinner-border-sm'></span> Add";
             document.getElementById("saveIndCond").disabled = true; 
               
             var compensationID = document.getElementById("compensationplanid").value;
             var operator = document.getElementById("addOperator").value;
             var amount = document.getElementById("set").value;
             var rewardcash = document.getElementById("rewardcash").checked;
             var rewardpercent = document.getElementById("rewardpercent").checked;
             var rewardbadge = document.getElementById("rewardbadge").checked;
             var alldata = 
           {
             compensationID:compensationID,
             operator:operator,
             amount:amount,
             rewardcash:rewardcash,
             /*amountcash:amountcash,*/
             rewardpercent:rewardpercent,
             /*amountpercent:amountpercent,*/
             rewardbadge:rewardbadge,
             /*choosebadge:choosebadge,
             amountbadge:amountbadge,*/
           };

             if (rewardcash == true){
               var amountcash = document.getElementById("setamount").value;
               alldata.amountcash=amountcash;
             }
             if (rewardpercent == true){
              var amountpercent = document.getElementById("setpercent").value;
              alldata.amountpercent=amountpercent;
            }
            if (rewardbadge == true){
              var choosebadge = document.getElementById("choosebadge").value;
              var amountbadge = document.getElementById("setbadge").value;
               alldata.choosebadge=choosebadge;
               alldata.amountbadge=amountbadge;
            }


          console.log(alldata);

          $.ajax({
           url: "ajax-addcondition.php",
           type: "POST",
           data: alldata,
           dataType:"json",
           success:function(data){
             document.getElementById("saveIndCond").innerHTML = "Save";
             document.getElementById("saveIndCond").disabled = false; 


             if(data.condition === "Passed"){
                document.getElementById("addindtargetform").reset();
               $("#addindCondition").modal("hide");
               getcompensation();

             }else{
               checkvalidity("addOperatorerror", "#addOperatorerror","#addOperator",data.operator); 
               checkvalidity("seterror", "#seterror","#set",data.amount); 

               // checkvalidity("rewardcasherror", "#rewardcasherror","#rewardcash",data.rewardcash);
               if(rewardcash==true){
                 checkvalidity("setamounterror", "#setamounterror","#setamount",data.setamount);}
             
               // checkvalidity("rewardpercenterror", "#rewardpercenterror","#rewardpercent",data.rewardpercent);
               if(rewardpercent==true){
                 checkvalidity("setpercenterror", "#setpercenterror","#setpercenterror",data.setpercent);
               }
               
               // checkvalidity("rewardbadgeerror", "#rewardbadgeerror","#rewardbadge",data.rewardbadge); 
               if(rewardbadge==true){
               checkvalidity("choosebadgeerror", "#choosebadgeerror","#choosebadge",data.choosebadge); 
               checkvalidity("setbadgeerror", "#setbadgeerror","#setbadge",data.setbadge); 
               }
                 }
               }


             });
         });
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
                   /*console.log(alldata);*/
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

          
          });
               

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

         <!-- add condition individual target form -->
           <div class="modal-body" >
             <form id="addindtargetform">
             <div class="form-group">
               <div class="modal fade" id="addindCondition">
                 <div class="modal-dialog modal-lg">
                   <div style="padding:60px" class="modal-content">
                     <div class="modal-header">
                       <h6 class="modal-title">Add Individual Condition</h6>
                       <button type="button" class="close" data-dismiss="modal">&times;</button>
                     </div>
                   <input type="hidden" class="form-control" name="companyplanid" id="companyplanid">
                   <input type="hidden" class="form-control" name="compensationplanid" id="compensationplanid">
                     <!-- Modal body -->
                     <div class="modal-body">
                       <div class="form-group">
                          <label><h6 class="m-0">CONDITION</h6></label><br>
                         <div class="row">
                           <div class="col-4 col-xl-4 ">
                           <input type="pm" class="form-control mb-2 mr-sm-2"  type ="text" id="pm" name="pm" readonly>
                         <br><small><span id="pmerror"></span></small>
                       </div>
                          
                           <div class="col-2 col-xl-2 ">
                           <select class="form-control  mb-2 mr-sm-2" id="addOperator" name="addOperator">
                            <option value="greater">></option>
                            <option value="less"><</option>
                            <option value="equal">=</option>
                          </select>
                        <br><small><span id="addOperatorerror"></span></small>
                      </div>
                          
                          <div class="col-2 col-xl-4 ">
                          <input class="form-control mb-2 mr-sm-2" type="text" id="set" name="set" >
                          
                        <small><span id="seterror"></span></small></div>
                        </div>
                      </div>

                      <div class="form-group">
                       <label><h6 class="m-0">REWARDS</h6></label><br><br>
                        <div class="row">
                         <div class="col-2 col-xl-4 ">
                         <label><h6><input type="checkbox" id="rewardcash" name="rewardcash" value="cash"> Cash </h6></label><br><small><span id="rewardcasherror"></span></small></div>
                         <div class="col-2 col-xl-4 ">
                         <input class="form-control" placeholder="amount" type="text" id="setamount" name="setamount" readonly >
                         <br> <small><span id="setamounterror"></span></small>
                          </div></div>
                         
                         <br>
                         <div class="row">
                         <div class="col-2 col-xl-4 ">
                         <label><h6><input type="checkbox" id="rewardpercent"  name="rewardpercent" value="percentrevenue"> % Revenue</h6></label><br><small><span id="rewardpercenterror"></span></small></div>
                         <div class="col-2 col-xl-4 ">
                         <input class="form-control" placeholder="percent" type="text" id="setpercent" name="setpercent" readonly>
                         <br><small><span id="setpercenterror"></span></small>
                          </div></div>
                        
                         <br>
                         <div class="row">
                         <div class="col-2 col-xl-4 ">
                         <label><h6><input type="checkbox" id="rewardbadge" name="rewardbadge" value="badge"> Badge</h6></label><br><small><span id="rewardbadgeerror"></span></small></div>
                         <div class="col-2 col-xl-4 ">
                         <select class="form-control  mb-2 mr-sm-2" id="choosebadge" name="choosebadge" disabled>
                            <option value="silver">Silver</option>
                            <option value="bronze">Bronze</option>
                            <option value="gold">Gold</option>
                          </select>
                          </div><small><span id="choosebadgeerror"></span></small><div class="col-2 col-xl-4 ">
                         <input class="form-control" placeholder="value" type="text" id="setbadge" name="setbadge"  readonly>
                         <br><small><span id="setbadgeerror"></span></small>
                          </div></div>
                     </div> 
                   </div> 

                   
                   <div class="col text-right">
                <button id="saveIndCond" name="submit" value="submit" type="submit" class="btn btn-primary shadow-sm">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancelIndPlan">Cancel</button>
                 </div>
                 </div> 
               </div>
             </div>
           </div>
         </form>
         </div>

         <script>
           $(document).ready(function(){
             $("#rewardcash").change(function () {
               if ($(this).is(":checked")) {
                 $("#setamount").removeAttr("readonly");
               }
               else{
                 $("#setamount").removeAttr("readonly",true);

               }
             });

           });

           $(document).ready(function(){
             $("#rewardpercent").change(function () {
               if ($(this).is(":checked")) {
                 $("#setpercent").removeAttr("readonly");
               }
               else{
                 $("#setpercent").removeAttr("readonly",true);

               }
             });

           });

            $(document).ready(function(){
             $("#rewardbadge").change(function () {
               if ($(this).is(":checked")) {
                 $("#choosebadge").removeAttr("disabled");
                 $("#setbadge").removeAttr("readonly");

               }
               else{
                 $("#choosebadge").removeAttr("disabled",true);
                  $("#setbadge").removeAttr("readonly",true);

               }
             });

           });
         </script>

         <!-- delete condition script -->

         <script type="text/javascript">
            $(document).ready(function(){
             var form = $('#deleteconditionform');

             $(document).on('click', ".deleteCondition", function(){
               var cond_indID = $(this).data('id');
               
                   $("#deleteconditionid").val(cond_indID);
                   console.log(cond_indID);
                 
               
             });

             form.on('submit', function(e){
               e.preventDefault();
               e.stopPropagation();
               var cond_indID = document.getElementById("deleteconditionid").value;
               var alldata = "deleteconditionid="+cond_indID;
               console.log(alldata);
               $.ajax({
                 url: "ajax-deletecondition.php?lang=<?php echo $extlg;?>",
                 type: "POST",
                 data: alldata,
                 success:function(data){
                   var obj = JSON.parse(data);
                   console.log(obj);
                   if(obj.condition === "Passed"){
                     $("#deleteCondition").modal("hide"); 
                     getcompensation();
                   }
                 }
               });
             });

             $("#deleteCondiition").on('hidden.bs.modal', function(){
               document.getElementById("deleteconditionform").reset(); 
             });

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
             /* console.log(alldata);*/
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
             
           });  
         </script>



         <!-- delete condition -->
         <div class="modal fade" id="deleteCondition">
           <div class="modal-dialog modal-lg">
             <div class="modal-content">
               <!-- Modal Header -->
               <div class="modal-header">
                 <h4 class="modal-title">Delete</h4>
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <!-- Modal body -->
               <form id="deleteconditionform">
                 <input type="text" class="form-control" name="deleteconditionid" id="deleteconditionid">
               <div class="modal-body"> Are you sure you want to delete this? </div>
               <!-- Modal footer -->
               <div class="modal-footer">
                 <button name="delete" value="delete" type="delete" class="btn btn-primary shadow-sm">Delete</button>
                 <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
               </div>
             </form>
             </div>
           </div>
         </div>



         <!-- update condition individual target form -->
         <script type="text/javascript">
           $(document).ready(function(){
              $(document).on('click', ".updateCondition", function(){
               var cond_indid = $(this).data('id');
             $("#updconditionplanid").val(cond_indid);
             
               $.ajax({
                 url: "ajax-getcondition.php?lang=<?php echo $extlg;?>",
                 type: "POST",
                 data: {cond_indid:cond_indid},
                 dataType:"json",
                 success:function(data){

                   $("#updconditionplanid").val(data.id);
                   /*  console.log(data.id);*/
                   /*$("#updcompanyplanid").val(data.company);*/
                   $("#badgeid").val(data.badgeID);
                   $("#cashrewardid").val(data.cashrewardID);
                   $("#revrewardid").val(data.revrewardID);
                   $("#updpm").val(data.condition);
                   if(data.operator==">"){
                   $("#updaddOperator").val("greater");
                   }
                   else if(data.operator=="<"){
                    $("#updaddOperator").val("less");
                   } 
                   else if(data.operator=="="){
                    $("#updaddOperator").val("equal");
                   }

                   $("#updset").val(data.set);
                   $("#updrewardcash").val(data.rewardcash);
                   if(data.rewardcash){
                     $("#updrewardcash").prop('checked', true);
                     $("#updsetamount").val(data.amountcash);
                     $("#updsetamount").removeAttr("readonly");
                   }

                   $("#updrewardpercent").val(data.rewardpercent);
                   if(data.rewardpercent){
                     $("#updrewardpercent").prop('checked', true);
                     $("#updsetpercent").val(data.amountpercent);
                     $("#updsetpercent").removeAttr("readonly");

                   }

                   $("#updrewardbadge").val(data.rewardbadge);
                   if(data.choosebadge){
                    $("#updrewardbadge").prop('checked', true);
                    $("#updchoosebadge").val(data.choosebadge);
                    $("#updsetbadge").val(data.amountbadge);
                    $("#updchoosebadge").removeAttr("disabled"); 
                    $("#updsetbadge").removeAttr("readonly"); 
                    } 

                  }
              });  
             });


             var form = $('#updateconditionform');
             form.on('submit', function(e){
               e.preventDefault();
               e.stopPropagation();
               document.getElementById("updIndCond").innerHTML = "<span class='spinner-border spinner-border-sm'></span> updating";// Refer to 8)
               document.getElementById("updIndCond").disabled = true; // Refer to 8)
               var cond_indID = document.getElementById("updconditionplanid").value;
               var operator = document.getElementById("updaddOperator").value;
               var set = document.getElementById("updset").value;
               var rewardcash = document.getElementById("updrewardcash").checked;
               // var amountcash = document.getElementById("updsetamount").value;
               var rewardpercent = document.getElementById("updrewardpercent").checked;
               // var amountpercent = document.getElementById("updsetpercent").value;
               var rewardbadge = document.getElementById("updrewardbadge").checked;
               // var choosebadge = document.getElementById("updchoosebadge").value;
               // var amountbadge = document.getElementById("updsetbadge").value;
               var badgeID = document.getElementById("badgeid").value;
               var cashrewardID = document.getElementById("cashrewardid").value;
               var revrewardID = document.getElementById("revrewardid").value;

                     // console.log(rewardcash);
                     
                var alldata = 
                {
                 cond_indID:cond_indID, /**/
                 operator:operator,
                 set:set,
                 rewardcash:rewardcash,
                 amountcash:amountcash,
                 rewardpercent:rewardpercent,
                 amountpercent:amountpercent,
                 rewardbadge:rewardbadge,
                 choosebadge:choosebadge,
                 amountbadge:amountbadge,
                 badgeID:badgeID,
                 cashrewardID:cashrewardID,
                 revrewardID:revrewardID,

                 
               };
                if (rewardcash == true){
                  var amountcash = document.getElementById("updsetamount").value;
                  alldata.amountcash=amountcash;
                }
                if (rewardpercent == true){
                 var amountpercent = document.getElementById("updsetpercent").value;
                 alldata.amountpercent=amountpercent;
               }
               if (rewardbadge == true){
                 var choosebadge = document.getElementById("updchoosebadge").value;
                 var amountbadge = document.getElementById("updsetbadge").value;
                  alldata.choosebadge=choosebadge;
                  alldata.amountbadge=amountbadge;
               }
              /* console.log(alldata);*/
               $.ajax({
                 url: "ajax-updatecondition.php",
                 type: "POST",
                 data: alldata,
                 dataType:"json",
                 success:function(data){
                   document.getElementById("updIndCond").innerHTML = "Confirm";// Refer to 8)
                   document.getElementById("updIndCond").disabled = false; // Refer to 8)
                   if(data.condition === "Passed"){
                     $("#updateCondition").modal("hide");
                     getcompensation();

                   }else{
                     checkvalidity("updaddOperatorerror","#updaddOperatorerror", "#updaddOperator", data.operator);/*data.update keno guna dkt ajax belah kanan*/
                     checkvalidity("updseterror","#updseterror", "#updseterror", data.set);
                     checkvalidity("updrewardcasherror","#updrewardcasherror", "#updrewardcash", data.rewardcash);
                     if(data.rewardcash){
                       $("#updrewardcash").prop('checked', true);
                       checkvalidity("updsetamounterror","#updsetamounterror", "#updsetamount", data.amountcash);   }

                     checkvalidity("updrewardpercenterror","#updrewardpercenterror", "#updrewardpercent", data.rewardpercent);
                     if(data.rewardpercent){
                       $("#updrewardpercent").prop('checked', true);
                       checkvalidity("updsetpercenterror","#updsetpercenterror", "#updsetpercent", data.amountpercent);
                     }

                     checkvalidity("updrewardbadgeerror","#updrewardbadgeerror", "#updrewardbadge", data.rewardbadge);
                     if(data.rewardbadge){
                       $("#updrewardbadge").prop('checked', true);
                       checkvalidity("updchoosebadgeerror","#updchoosebadgeerror", "#updchoosebadge", data.choosebadge);   
                       checkvalidity("updsetbadgeerror", "#updsetbadgeerror","#updsetbadge",data.amountbadge);

                     }         

                   }
                 }
               });
             });

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
                   /*console.log(alldata);*/
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

              });

         $(document).on('hidden.bs.modal','#updateCondition', function () {
          document.getElementById("updateconditionform").reset();
         })


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
           
             <div class="modal fade" id="updateCondition">
               <div class="modal-body" >
             <form id="updateconditionform">
             <div class="form-group">
                 <div class="modal-dialog modal-lg">
                   <div style="padding:60px" class="modal-content">
                     <div class="modal-header">
                       <h6 class="modal-title">Update Individual Condition</h6>
                       <button type="button" class="close" data-dismiss="modal">&times;</button>
                     </div>
                <!--    <input type="text" class="form-control" name="updcompanyplanid" id="updcompanyplanid"> -->
                   <input type="hidden" class="form-control" name="badgeid" id="badgeid">
                   <input type="hidden" class="form-control" name="cashrewardid" id="cashrewardid">
                   <input type="hidden" class="form-control" name="revrewardid" id="revrewardid">
                   <input type="hidden" class="form-control" name="updconditionplanid" id="updconditionplanid">
                     <!-- Modal body -->
                     <div class="modal-body">
                       <div class="form-group">
                          <label><h6 class="m-0">CONDITION</h6></label><br>
                         <div class="row">
                           <div class="col-4 col-xl-4 ">
                           <input type="pm" class="form-control mb-2 mr-sm-2"  type ="text" id="updpm" name="updpm" readonly></div>
                           <small><span id="updpmerror"></span></small>
                           <div class="col-2 col-xl-2 ">
                           <select class="form-control  mb-2 mr-sm-2" id="updaddOperator" name="updaddOperator">
                            <option value="greater">></option>
                            <option value="less"><</option>
                            <option value="equal">=</option>
                          </select></div>
                          <small><span id="updaddOperatorerror"></span></small>
                          <div class="col-2 col-xl-4 ">
                          <input class="form-control mb-2 mr-sm-2" type="text" id="updset" name="updset" >
                          &nbsp;</div><small><span id="updseterror"></span></small>
                        </div>
                      </div>

                      <div class="form-group">
                       <label><h6 class="m-0">REWARDS</h6></label><br><br>
                        <div class="row">
                         <div class="col-2 col-xl-4 ">
                         <label><h6><input type="checkbox" id="updrewardcash" name="updrewardcash" value="Cash"> Cash </h6></label><small><span id="updrewardcasherror"></span></small></div>
                         <div class="col-2 col-xl-4 ">
                         <input class="form-control" placeholder="amount" type="text" id="updsetamount" name="setamount" readonly >
                          </div> <small><span id="updsetamounterror"></span></small></div>
                         
                         <br>
                         <div class="row">
                         <div class="col-2 col-xl-4 ">
                         <label><h6><input type="checkbox" id="updrewardpercent"  name="updrewardpercent" value="Revenue"> % Revenue</h6></label><small><span id="updrewardpercenterror"></span></small></div>
                         <div class="col-2 col-xl-4 ">
                         <input class="form-control" placeholder="percent" type="text" id="updsetpercent" name="setpercent" readonly>
                          </div><small><span id="updsetpercenterror"></span></small></div>
                        
                         <br>
                         <div class="row">
                         <div class="col-2 col-xl-4 ">
                         <label><h6><input type="checkbox" id="updrewardbadge" name="updrewardbadge" value="Badge"> Badge</h6></label><small><span id="updrewardbadgeerror"></span></small></div>
                         <div class="col-2 col-xl-4 ">
                         <select class="form-control  mb-2 mr-sm-2" id="updchoosebadge" name="updchoosebadge" disabled>
                            <option value="silver">Silver</option>
                            <option value="bronze">Bronze</option>
                            <option value="gold">Gold</option>
                          </select>
                          </div><small><span id="updchoosebadgeerror"></span></small><div class="col-2 col-xl-4 ">
                         <input class="form-control" placeholder="value" type="text" id="updsetbadge" name="updsetbadge"  readonly>
                          </div><small><span id="updsetbadgeerror"></span></small></div>
                     </div> 
                   </div> 

                   
                   <div class="col text-right">
                <button id="updIndCond" name="submit" value="submit" type="submit" class="btn btn-primary shadow-sm">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancelupdPlan">Cancel</button>
                 </div>
                 </div> 
               </div>
             </div>
         </form>
           </div>
         </div>

         <script>
           $(document).ready(function(){
             $("#updrewardcash").change(function () {
               if ($(this).is(":checked")) {
                 $("#updsetamount").removeAttr("readonly");
               }
               else{
                 $("#updsetamount").removeAttr("readonly",true);

               }
             });

           });

           $(document).ready(function(){
             $("#updrewardpercent").change(function () {
               if ($(this).is(":checked")) {
                 $("#updsetpercent").removeAttr("readonly");
               }
               else{
                 $("#updsetpercent").removeAttr("readonly",true);

               }
             });

           });

            $(document).ready(function(){
             $("#updrewardbadge").change(function () {
               if ($(this).is(":checked")) {
                 $("#updchoosebadge").removeAttr("disabled");
                 $("#updsetbadge").removeAttr("readonly");

               }
               else{
                 $("#updchoosebadge").removeAttr("disabled",true);
                  $("#updsetbadge").removeAttr("readonly",true);

               }
             });

           });
         </script>

<!-- script update details -->
       <script type="text/javascript">
         $(document).ready(function(){
          $(document).on('click', "#updatetarget", function(){
            var compensationID = $(this).data('id');
            $.ajax({
              url: "ajax-getpm.php?lang=<?php echo $extlg;?>",
              type: "POST",
              data: {compensationID:compensationID},
              dataType:"json",
              success:function(data){
                $("#updcompensationid1").val(data.id);  
             }
           });  
          });

           var form = $('#updateactualform');
           form.on('submit', function(e){
             e.preventDefault();
             e.stopPropagation();
             document.getElementById("saveactual").innerHTML = "<span class='spinner-border spinner-border-sm'></span> Updating";
             document.getElementById("saveactual").disabled = true;
             var data = $('#updateactualform').serialize();
             var compensationID = document.getElementById("updcompensationid1").value;
             
             var alldata = ""+data+"&updcompensationid1="+compensationID;

             $.ajax({
               url: "ajax-updateactual.php",
               type: "POST",
               data: alldata,
               dataType:"json",
               success:function(data){
                 document.getElementById("saveactual").innerHTML = "Confirm";
                 document.getElementById("saveactual").disabled = false; 
                 if(data.condition === "Passed"){
                  document.getElementById("updateactualform").reset();
                  // $("#updatetarget").hide();
                   $("#updateactualpm").modal("hide");
                   getCompanyview();

                 }else{
                   checkvalidity("updatenptargeterror","#updatenptargeterror", "#updatenptarget", data.nptarget);
                   checkvalidity("actual1error","#actual1error", "#actualvalue2", data.actual);
                 }
                             
               }
             });
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
         });
       </script>

<!-- update actual pm modal -->
<div class="modal fade" id="updateactualpm">
 <div class="modal-dialog modal-lg">
   <div style="padding:70px" class="modal-content">
    <div class="modal-header">
     <h6 class="modal-title">Update Details</h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <button type="button" class="close" data-dismiss="modal">&times;</button>
   </div>

   <div class="modal-body">
    <form id="updateactualform">
      <input type="hidden" class="form-control" name="updcompensationid1" id="updcompensationid1">

    <script type="text/javascript">
      $(document).ready(function(){
       $(document).on('click', "#updatetarget", function(){
         var compensationID = $(this).data('id');

         function gettargetview(){ 
           var alldata = 
           { compensationID:compensationID,}; 
           $.ajax({
             url:"ajax-getviewtarget.php",
             method:"POST",
             data:alldata,
             success:function(data){
               $("#showtargetview").html(data);
             }
           });
         }
         gettargetview();
       });
     });
   </script>

    <div id="showtargetview"></div>
</form>
   </div>
 </div>
</div>
</div>


<!-- view commission form -->
<div class="modal-body" >
  <form id="updateactualpmform">
    <div class="form-group">
      <div class="modal fade" id="updateactualpmmodal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content" style="padding: 50px">
            <div class="modal-body">

             <script type="text/javascript">
               $(document).ready(function(){
                $(document).on('click', "#viewdetails", 
                  function(){
                  var compensationID = $(this).data('id');

                  function gettargetview(){ 
                    var alldata = 
                    { compensationID:compensationID,}; 
                    $.ajax({
                      url:"ajax-viewdetails.php",
                      method:"POST",
                      data:alldata,
                      success:function(data){
                        $("#showviewdetails").html(data);
                      }
                    });
                  }
                  gettargetview();
                });
              });
            </script>

            <div id="showviewdetails"></div>

          </div>

        </div>
      </div>
    </div>
  </div>
</form>
</div>

<!-- user level view  -->
<div class="modal-body" >
  <form id="userdetailsform">
    <div class="form-group">
      <div class="modal fade" id="userdetailsmodal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content" style="padding: 50px">
            <div class="modal-body">

             <script type="text/javascript">
               $(document).ready(function(){
                $(document).on('click', "#userdetails", function(){
                  var compensationID = $(this).data('id');
                  
                  function gettargetview(){ 
                    var alldata = 
                    { compensationID:compensationID,}; 

                    $.ajax({
                      url:"ajax-userdetails.php",
                      method:"POST",
                      data:alldata,
                      success:function(data){
                        $("#showuserview").html(data);
                      }
                    });
                  }
                  gettargetview();
                });
              });
            </script>
            <div id="showuserview"></div>

          </div>

        </div>
      </div>
    </div>
  </div>
</form>
</div>

<!--view badges  -->
<div class="modal-body" >
  <form id="badgesdetailsform">
    <div class="form-group">
      <div class="modal fade" id="badgesdetailsmodal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content" style="padding: 50px">
            <!-- <div class="modal-header">
                       <h6 class="modal-title">Badges</h6>
                       <button type="button" class="close" data-dismiss="modal">&times;</button>
                     </div> -->
                     <div class="modal-body">
                        <!-- <tbody>
                          Your total badges : 5    
                        </tbody> -->
             <script type="text/javascript">
               $(document).ready(function(){
                $(document).on('click', "#badgesdetails", function(){
                  var userID = $(this).data('id');
                  
                  function gettargetview(){ 
                    var alldata = 
                    { userID:userID,}; 

                    $.ajax({
                      url:"ajax-badgesdetails.php",
                      method:"POST",
                      data:alldata,
                      success:function(data){
                        $("#showbadgesview").html(data);
                      }
                    });
                  }
                  gettargetview();
                });
              });
            </script>
            <div id="showbadgesview">hfghg</div>
        </div>
      </div>
    </div>
  </div>
</form>
</div>