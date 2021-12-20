    


<script type="text/javascript">
$(document).ready(function(){

    $(document).on('click', ".addCompExpenses", function(){
             var companyID = document.getElementById("addamountcompany").value; 
             var inputValue = $(this).data("id");
             var div = $(this).data("place");
             var month = $(this).data("month");
             var balance = $(this).data("balance");
             var budgetallocated = $(this).data("budget");
             { $("#addamount").val(companyID);  
             $("#subid").val(inputValue); 
             $("#div").val(div); 
             $("#month").val(month); 
             $("#balance").val(balance); 
             $("#budgetallocated").val(budgetallocated); 
           }
         });


     var form = $('#addexpenses');
     form.on('submit', function(e){
        e.preventDefault();  
        e.stopPropagation(); 

        document.getElementById("saveExp").innerHTML = "<span class='spinner-border spinner-border-sm'></span> Add";
        document.getElementById("saveExp").disabled = true;

       var datecomp = document.getElementById("datecomp").value;
       var amountcomp = document.getElementById("amountcomp").value;
       var desccomp = document.getElementById("desccomp").value;
       var addamountuser = document.getElementById("addamountuser").value;
       var addamountcompany = document.getElementById("addamount").value;
       var addamountcorporate = document.getElementById("addamountcorporate").value;
       var suballocationid = document.getElementById("subid").value;
       var div = document.getElementById("div").value;
       var month = document.getElementById("month").value;
       var balance = document.getElementById("balance").value;
       var budgetallocated = document.getElementById("budgetallocated").value;


       var alldata = 
{
     datecomp:datecomp,
     amountcomp:amountcomp,
     /*catcomp:catcomp,*/
     desccomp:desccomp,
     addamountuser:addamountuser,
     addamountcompany:addamountcompany,
     addamountcorporate:addamountcorporate,
     suballocationid:suballocationid,
     div:div,
     month:month,
     balance:balance,
     budgetallocated:budgetallocated
};
console.log(alldata);
$.ajax({
  url: "ajax-addexpenses.php",
  type: "POST",
  data: alldata,
  dataType:"json",
  success:function(data){
    document.getElementById("saveExp").innerHTML = "Add";
    document.getElementById("saveExp").disabled = false;
    if(data.condition === "Passed"){
      document.getElementById("addexpenses").reset();
      $("#addCompensation1").modal("hide");
      selectmonthaddexpenses(data.month,data.balance,data.budgetallocated,data.amountcomp,data.div); 
    }else{

      checkvalidity("datecomperror", "#datecomperror","#datecomp",data.datecomp ); 
      checkvalidity("amountcomperror", "#amountcomperror","#amountcomp",data.amountcomp ); 
      checkvalidity("desccomperror", "#desccomperror","#desccomp",data.desccomp );
    }
  }

});
});
});

function selectmonthaddexpenses(month,balance,budget,amount,place) {
  var comp = document.getElementById("addamountcompany").value;
  var year = document.getElementById("expensesyear").value;
  var div = place;
  var month = month;
  var balance = balance - amount;
  var budgetallocated = budget;
  var alldata = 
  {
    year: year,
    month: month,
    comp:comp,
    div:div,
    balance:balance,
    budgetallocated:budgetallocated
  };
  console.log(alldata);
  $.ajax({
    url:"ajax-viewexpenses.php",
    data: alldata,
    dataType: "json",
    method: "POST",
    success:function(data){
      // console.log(data);
      $("#" + div).html(data.view); // This is A
      var actualid = document.getElementById("actual" + data.month);
      var balanceid = document.getElementById("balance" + data.month);
      var progressid = document.getElementById("expensesprogress" + data.month);
      actualid.innerHTML = data.grandtotal;
      balanceid.innerHTML = data.balance;
      progressid.innerHTML = data.progressvalue;
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

function clearform(data1, data2, data3,data4, data5){ //clear the error whenever close the modal
  $(data1).removeClass("text-success").removeClass("text-danger");
  document.getElementById(data2).textContent="";
  $(data3).removeClass("border-success").removeClass("border-danger");
}
</script>

<!-- add expenses -->
<div class="modal fade" id="addCompensation1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="padding: 70px">
      <div class="modal-header">
        <h6 class="modal-title">Expenses Details</h6>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form id="addexpenses">
        <br>

        <div class="modal-body">
          <input class="form-control" type="hidden" id="addamount" name="addamount" value="">
          <input class="form-control" type="hidden" id="subid" name="subid" value="">
          <input class="form-control" type="hidden" id="div" name="div" value="">
          <input class="form-control" type="hidden" id="month" name="month" value="">
          <input class="form-control" type="hidden" id="balance" name="balance" value="">
          <input class="form-control" type="hidden" id="budgetallocated" name="budgetallocated" value="">


          <div class="form-group">
            <label><h6 class="m-0">Date</h6></label>
            <input type="date" class="form-control selectpicker" id="datecomp" name="datecomp" autocomplete="off">
            <small><span id="datecomperror"></span></small>
          </div>

          <div class="form-group">
            <label><h6 class="m-0">Amount </h6></label>
            <input class="form-control" type="number" id="amountcomp" name="amountcomp" >
            <small><span id="amountcomperror"></span></small>
          </div>


          <div class="form-group">
            <label><h6 class="m-0">Description </h6></label>
            <textarea class="form-control" type="text" id="desccomp" name="desccomp "></textarea>
            <small><span id="desccomperror"></span></small>
          </div>

          <br>
          <center><button name="submit" id="saveExp" value="submit" type="submit" class="btn btn-primary shadow-sm">Save</button>
           <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button></center>


         </div></form>
         <input class="form-control" type="hidden" id="addamountuser" name="addamountuser" value="<?php echo $resultresult->userID ?>">

         <input class="form-control" type="hidden" id="addamountcorporate" name="addamountcorporate" value="<?php echo $resultresult->corporateID ?>">

       </div>
     </div>

   </div>



<!-- delete -->
<script type="text/javascript">
 $(document).ready(function(){
  var form = $('#deleteexpensesform');

  $(document).on('click', ".deleteExpenses", function(){
    var budgetExpensesID = $(this).data('id');
    var delmonth = $(this).data('month');
    var deldiv = $(this).data('place');
    var delbalance = $(this).data('balance');
    var delbudgetallocated = $(this).data('budget');
    var delamount = $(this).data('amount');
    {
      $("#deleteexpensesid").val(budgetExpensesID);
      $("#deletemonth").val(delmonth);
      $("#deletediv").val(deldiv);
      $("#deletebalance").val(delbalance);
      $("#deletebudget").val(delbudgetallocated);
      $("#deleteamount").val(delamount);
    }
    
  });

  form.on('submit', function(e){
    e.preventDefault();
    e.stopPropagation();
    var deleteexpensesid = document.getElementById("deleteexpensesid").value;
    var delmonth = document.getElementById("deletemonth").value;
    var deldiv = document.getElementById("deletediv").value;
    var delbalance = document.getElementById("deletebalance").value;
    var delbudgetallocated = document.getElementById("deletebudget").value;
    var delamount = document.getElementById("deleteamount").value;
    var alldata = 
    {
      deleteexpensesid:deleteexpensesid,
      deletemonth:delmonth,
      deletediv:deldiv,
      deletebalance:delbalance,
      deletebudget:delbudgetallocated,
      deleteamount:delamount,
    } 
    console.log(alldata);
    $.ajax({
      url: "ajax-deleteexpenses.php?lang=<?php echo $extlg;?>",
      type: "POST",
      data: alldata,
      success:function(data){
        var obj = JSON.parse(data);
        console.log(obj);
        if(obj.condition === "Passed"){
          $("#deleteExpense").modal("hide"); 
          selectdeletemonthexpenses(obj.deletemonth,obj.deletediv,obj.amountdelete,obj.deletebalance,obj.budgetallocated);
        }
      }
    });
  });

  $("#deleteExpense").on('hidden.bs.modal', function(){
    document.getElementById("admindeleteuserform").reset(); 
  });
});  

 function selectdeletemonthexpenses(month,place,amount,balance,budget) {
   var deletemonth = month;
   var year = document.getElementById("expensesyear").value;
   var comp = document.getElementById("addamountcompany").value;
   var balance = Number(balance) + Number(amount);
   var budgetallocated = budget;
   var div = place;
   var alldata = 
   {
     year:year,
     comp:comp,
     month:deletemonth,
     balance:balance,
     budgetallocated:budgetallocated
   };
   console.log(alldata);
   $.ajax({
     url:"ajax-viewexpenses.php",
     data: alldata,
     dataType: "json",
     method: "POST",
     success:function(data){
       console.log(data);
       $("#" + div).html(data.view); // This is A
       var actualid = document.getElementById("actual" + data.month);
       var balanceid = document.getElementById("balance" + data.month);
       var progressid = document.getElementById("expensesprogress" + data.month);
       actualid.innerHTML = data.grandtotal;
       balanceid.innerHTML = data.balance;
       progressid.innerHTML = data.progressvalue;
     }
   });
 }
</script>

<!-- delete expenses -->
<div class="modal fade" id="deleteExpense">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="padding:70px">
      <div class="modal-header">
        <h4 class="modal-title">Delete</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form id="deleteexpensesform">
        <input type="hidden" class="form-control" name="deleteexpensesid" id="deleteexpensesid">
        <input type="hidden" class="form-control" name="deletemonth" id="deletemonth">
        <input type="hidden" class="form-control" name="deletediv" id="deletediv">
        <input type="hidden" class="form-control" name="deletebalance" id="deletebalance">
        <input type="hidden" class="form-control" name="deletebudget" id="deletebudget">
        <input type="hidden" class="form-control" name="deleteamount" id="deleteamount">
        <div class="modal-body"> Are you sure you want to delete this? </div>
        <div class="modal-footer">
          <button name="delete" value="delete" type="delete" class="btn btn-primary shadow-sm">Delete</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- update expenses -->

<script type="text/javascript">
  $(document).ready(function(){

    $(document).on('click', ".updateExpenses", function(){
      var budgetExpensesID = $(this).data('id');
      var month = $(this).data('month');
      var div = $(this).data('place');
      var balance = $(this).data('balance');
      var budgetallocated = $(this).data('budget');
      var alldata = 
      {
        budgetExpensesID:budgetExpensesID,
        month:month,
        div:div,
        balance:balance,
        budgetallocated:budgetallocated,
      }
      $.ajax({
        url: "ajax-getexpenses.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
        dataType:"json",
        success:function(data){
          $("#updateexpensesid").val(data.id);
          $("#upddate").val(data.date);
          $("#updamount").val(data.amount);
          $("#upddesc").val(data.description);
          $("#updmonth").val(data.month);
          $("#upddiv").val(data.div);
          $("#updbalance").val(data.balance);
          $("#updbudget").val(data.budgetallocated);
        }
      });
    });
    var form = $('#updateexpensesform');
    form.on('submit', function(e){
      e.preventDefault();
      e.stopPropagation();
      document.getElementById("submitupdate").innerHTML = "<span class='spinner-border spinner-border-sm'></span> Updating";
      document.getElementById("submitupdate").disabled = true; 
      var budgetExpensesID = document.getElementById("updateexpensesid").value;
      var month = document.getElementById("updmonth").value;
      var div = document.getElementById("upddiv").value;
      var balance = document.getElementById("updbalance").value;
      var budgetallocated = document.getElementById("updbudget").value;
      var updateamount = document.getElementById("updamount").value;
      var updatedesc = document.getElementById("upddesc").value;
      var updatedate = document.getElementById("upddate").value;
      var comp = document.getElementById("addamountcompany").value;
      var year = document.getElementById("expensesyear").value;

      var alldata = 
      {
        budgetid:budgetExpensesID, 
        updateamount1:updateamount,
        updatedescription1:updatedesc,
        updatedate1:updatedate,
        month:month,
        div:div,
        balance:balance,
        budget:budgetallocated,
        comp:comp,
        year:year
      };
      console.log(alldata);
      $.ajax({
        url: "ajax-updateexpenses.php",
        type: "POST",
        data: alldata,
        dataType:"json",
        success:function(data){
          document.getElementById("submitupdate").innerHTML = "Confirm";// Refer to 8)
          document.getElementById("submitupdate").disabled = false; // Refer to 8)
          if(data.condition === "Passed"){
            $("#updateExpenses").modal("hide");
            selectmonthexpenses(data.month,data.div,data.balance,data.budgetallocated);
          
          }else{
            checkvalidity("upddateerror","#upddateerror", "#upddate", data.upddate);/*data.update keno guna dkt ajax belah kanan*/
            checkvalidity("updamounterror","#updamounterror", "#updamount", data.updamount);
            checkvalidity("upddescerror","#upddescerror", "#upddesc", data.upddesc);
          }
        }
      });
    });
  });

  function selectmonthexpenses(month,place,balance,budget) {
    var month = month;
    var div = place;
    var budgetallocated = budget;
    var balance = balance;
    var comp = document.getElementById("addamountcompany").value;
    var year = document.getElementById("expensesyear").value;
    var alldata = 
    {
      month: month,
      year: year,
      comp:comp,
      div:div,
      budgetallocated:budgetallocated,
      balance:balance
    };
    console.log(alldata);
    $.ajax({
      url:"ajax-viewexpenses.php",
      data: alldata,
      dataType: "json",
      method: "POST",
      success:function(data){
        console.log(data);
        $("#" + div).html(data.view); // This is A
        newbalance = Number(data.budgetallocated) - Number(data.grandtotal);
        var actualid = document.getElementById("actual" + data.month);
        var balanceid = document.getElementById("balance" + data.month);
        var progressid = document.getElementById("expensesprogress" + data.month);
        actualid.innerHTML = data.grandtotal;
        balanceid.innerHTML = newbalance;
        progressid.innerHTML = data.progressvalue;
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

<!--  update form-->

<div class="modal-body" >
  <form id="updateexpensesform">
    <div class="form-group">
      <div class="modal fade" id="updateExpenses">
        <div class="modal-dialog modal-lg">
          <div class="modal-content" style="padding: 70px">

            <div class="modal-header">
              <h6 class="modal-title">Expenses Details</h6>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <input type="hidden" class="form-control" name="updateexpensesid" id="updateexpensesid">
            <input type="hidden" class="form-control" name="updmonth" id="updmonth">
            <input type="hidden" class="form-control" name="upddiv" id="upddiv">
            <input type="hidden" class="form-control" name="updbalance" id="updbalance">
            <input type="hidden" class="form-control" name="updbudget" id="updbudget">
            <div class="modal-body">

             <div class="form-group">
              <label><h6 class="m-0">Date</h6></label>
              <input type="date" class="form-control selectpicker" id="upddate" name="upddate" autocomplete="off">
              <small><span id="upddateerror"></span></small>
            </div>

            <div class="form-group">
              <label><h6 class="m-0">Amount </h6></label>
              <input class="form-control" type="number" id="updamount" name="updamount" >
              <small><span id="updamounterror"></span></small>
            </div>

            <div class="form-group">
              <label><h6 class="m-0">Description </h6></label>
              <textarea class="form-control" type="text" id="upddesc" name="upddesc "></textarea>
              <small><span id="upddescerror"></span></small>
            </div>

            <br>
            <center><button name="submit" id="submitupdate" value="submit" type="submit" class="btn btn-primary shadow-sm">Save</button>
             <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button></center>
           </div>
         </div>
       </div>
     </div>
   </div>
 </form>
</div>
        




<!-- add main allocation -->
<script type="text/javascript">
  $(document).ready(function(){
   var form = $('#mainform');
   form.on('submit', function(e){
    e.preventDefault();  
    e.stopPropagation(); 

    document.getElementById("saveMain").innerHTML = "<span class='spinner-border spinner-border-sm'></span> Adding";
    document.getElementById("saveMain").disabled = true;
    var data = $('#mainform').serialize();

    var alldata = data;
    $.ajax({
      url: "ajax-addmain.php",
      type: "POST",
      data: alldata,
      dataType:"json",
      success:function(data){
        document.getElementById("saveMain").innerHTML = "Add";
        document.getElementById("saveMain").disabled = false;
        if(data.condition === "Passed"){
          document.getElementById("mainform").reset();

          $("#mainmodal").modal("hide");
          getviewmain(); 
        }else{
          checkvalidity("bonuspercenterror", "#bonuspercenterror","#bonuspercent",data.percent ); 
        }
      }
    });
  });
 });
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
       $("#showmainview").html(data); 
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

function clearform(data1, data2, data3,data4, data5){
  $(data1).removeClass("text-success").removeClass("text-danger");
  document.getElementById(data2).textContent="";
  $(data3).removeClass("border-success").removeClass("border-danger");
}
</script>

<div class="modal fade" id="mainmodal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="padding: 70px">
      <div class="modal-body"  >
        <form id="mainform">
          <div class="form-group">

            <div class="modal-header">
              <h6 class="modal-title">Allocation Amount</h6>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <div class="form-group">
              <input class="form-control" type="hidden" id="budgetid" name="budgetid" value="">

              <input class="form-control" type="hidden" id="initialBudget" name="initialBudget" value="">
              <input class="form-control" type="hidden" id="addmaincomp" name="addmaincomp" value="">
              <input class="form-control" type="hidden" id="addallocationyear" name="addallocationyear" value="">
              <input class="form-control" type="hidden" id="addmainuser" name="addmainuser" value="<?php echo $resultresult->userID ?>">

              <input class="form-control" type="hidden" id="addmaincorporate" name="addmaincorporate" value="<?php echo $resultresult->corporateID ?>">

              <div class="row">
                <div class="col-12 col-xl-6">
                  <label><h6 class="m-0">Category </h6></label>
                  <input class="form-control" type="text" value="Bonus" id="bonuscat" name="category[]" placeholder="Bonus" readonly>
                  <small><span id="bonuserror"></span></small><br>
                  <input class="form-control" type="text" value="Others" id="otherscat" name="category[]" placeholder="Others" readonly >
                  <small><span id="otherserror"></span></small><br>
                </div>

                <div class="col-12 col-xl-6" id="bonuspercent">
                 <label><h6 class="m-0">Percent of Allocation </h6></label>
                 <input class="form-control" type="text" id="bonuspercent1" name="percent[]" ><br>
                 <input class="form-control" type="text" id="otherspercent" name="percent[]" >
                 <small><span id="otherspercenterror"></span></small><br>
                 <small><span id="bonuspercenterror"></span></small><br>
               </div>

             </div>
             <br>

             <center><button name="submit" id="saveMain" value="submit" type="submit" class="btn btn-primary shadow-sm">Save</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button></center>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- update main -->

<script type="text/javascript">
  $(document).ready(function(){

    $(document).on('click', ".updatemainmodal", function(){
      var budgetinitialID = $(this).data('id');
      console.log(budgetinitialID);

      $.ajax({
        url: "ajax-getmain.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: {budgetinitialID:budgetinitialID},
        dataType:"json",
        success:function(data){
          $("#updmainid").val(data.id);
          $("#updmainid2").val(data.id2);
          $("#updinitialBudget").val(data.budget);
          $("#updmaincompid").val(data.company);
          $("#updmaincorporate").val(data.corporate);
          $("#updmainuser").val(data.user);
          $("#updallocationyear").val(data.year);
          $("#updbonuspercent1").val(data.bonus);
          $("#updotherspercent").val(data.others);
        }
      });
    });

    var form = $('#updatemainform');
    form.on('submit', function(e){
      e.preventDefault();
      e.stopPropagation();
      document.getElementById("updMain").innerHTML = "<span class='spinner-border spinner-border-sm'></span> Updating";
      document.getElementById("updMain").disabled = true; 
      var id = document.getElementById("updmainid").value;
      var id2 = document.getElementById("updmainid2").value;
      var budget = document.getElementById("updinitialBudget").value;

      var company = document.getElementById("updmaincompid").value;
      var corporate = document.getElementById("updmaincorporate").value;
      var user = document.getElementById("updmainuser").value;
      var year = document.getElementById("updallocationyear").value;
      var bonuscat = document.getElementById("updbonuscat").value;
      var otherscat = document.getElementById("updotherscat").value;
      var bonusper = document.getElementById("updbonuspercent1").value;
      var othersper = document.getElementById("updotherspercent").value;

      var alldata = {
        id:id,
        id2:id2,
        budget:budget,
        company:company,
        corporate:corporate,
        user:user,
        year:year,
        bonuscat:bonuscat,
        otherscat:otherscat,
        bonusper:bonusper,
        othersper:othersper,
      };
      $.ajax({
        url: "ajax-updatemain.php",
        type: "POST",
        data: alldata,
        dataType:"json",
        success:function(data){
          document.getElementById("updMain").innerHTML = "Confirm";// Refer to 8)
          document.getElementById("updMain").disabled = false; // Refer to 8)
          if(data.condition === "Passed"){
           document.getElementById("updatemainform").reset();
           $("#updatemainmodal").modal("hide");
           getviewmain();

         }else{

          checkvalidity("updbonuspercenterror","#updbonuspercenterror", "#updbonuspercent1", data.updbonus);

        }
      }
    });
    });
  });

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
       $("#showmainview").html(data);
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


<div class="modal fade" id="updatemainmodal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="padding: 70px">
      <div class="modal-body"  >
        <form id="updatemainform">
          <div class="form-group">
            <div class="modal-header">
              <h6 class="modal-title">Main Allocation</h6>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <div class="form-group">
              <input class="form-control" type="hidden" id="updmainid" name="updmainid" value="">
              <input class="form-control" type="hidden" id="updmainid2" name="updmainid2" value="">
              <input class="form-control" type="hidden" id="updinitialBudget" name="updinitialBudget" value="">
              <input class="form-control" type="hidden" id="updmaincompid" name="updmaincompid" value="">
              <input class="form-control" type="hidden" id="updallocationyear" name="updallocationyear" value="">
              <input class="form-control" type="hidden" id="updmainuser" name="updmainuser" value="<?php echo $resultresult->userID ?>">

              <input class="form-control" type="hidden" id="updmaincorporate" name="updmaincorporate" value="<?php echo $resultresult->corporateID ?>">

              <div class="row">
                <div class="col-12 col-xl-6">
                  <label><h6 class="m-0">Category </h6></label>
                  <input class="form-control" type="text" value="Bonus" id="updbonuscat" name="updcategory[]" placeholder="Bonus" readonly><br>
                  
                  <input class="form-control" type="text" value="Others" id="updotherscat" name="updcategory[]" placeholder="Others" readonly >
                  <small><span id="updotherserror"></span></small><br>
                  <small><span id="updbonuserror"></span></small><br>
                </div>

                <div class="col-12 col-xl-6" id="updbonuspercent">
                 <label><h6 class="m-0">Percent of Allocation </h6></label>
                 <input class="form-control" type="text" id="updbonuspercent1" name="updpercent[]" ><br>
                 
                 <input class="form-control" type="text" id="updotherspercent" name="updpercent[]" >
                 <small><span id="updotherspercenterror"></span></small><br>
                 <small><span id="updbonuspercenterror"></span></small><br>
               </div>
             </div>
             <br>
             <center><button name="submit" id="updMain" value="submit" type="submit" class="btn btn-primary shadow-sm">Save</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button></center>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

 

            <!-- add sub -->
            <script type="text/javascript">
              $(document).ready(function(){
               var form = $('#subform');
               form.on('submit', function(e){
                e.preventDefault();  
                e.stopPropagation(); 

                document.getElementById("saveSub").innerHTML = "<span class='spinner-border spinner-border-sm'></span> Adding";
                document.getElementById("saveSub").disabled = true;


                var sub1 = document.getElementById("subcategory").value;
                var sub2 = document.getElementById("subpercent").value;
                var subcomp = document.getElementById("addsubcomp").value;
                var subyear = document.getElementById("suballocationyear").value;
                var budgetothers = document.getElementById("initialsubBudget").value;

                var addsubuser = document.getElementById("addsubuser").value;
                var addsubcomp = document.getElementById("addsubcomp").value;
                var addsubcorporate = document.getElementById("addsubcorporate").value;

                var alldata = 
                {

                 subC:sub1,
                 subP:sub2,
                 subcomp:subcomp,
                 subyear:subyear,
                 budgetothers:budgetothers,
                 addsubuser: addsubuser,
                 compadd:addsubcomp,
                 addsubcorporate:addsubcorporate,
               };
               $.ajax({
                url: "ajax-addsub.php",
                type: "POST",
                data: alldata,
                dataType:"json",
                success:function(data){
                  document.getElementById("saveSub").innerHTML = "Add";
                  document.getElementById("saveSub").disabled = false;
                  if(data.condition === "Passed"){
                    document.getElementById("subform").reset();
                    $("#submodal").modal("hide");
                    getviewsub();
                  }else{

                    checkvalidity("subcategoryerror", "#subcategoryerror","#subcategory",data.subcategory );
                    checkvalidity("subpercenterror", "#subpercenterror","#subpercent",data.subpercent );
                  }


                  function getviewsub($year){
                    weekpicker = $('#mainallocationyear');
                    weekpicker.datepicker({
                      autoclose: true,
                      forceParse: false,
                      orientation: 'bottom',
                      minViewMode: "years"
                    }).on("changeDate", function(e) {
                      selectmonthsub(e.date);
                    });
                    selectmonthsub(new Date);
                  }
                }
              });
             });
             });
              function selectmonthsub(date) {
                var subid = document.getElementById("suballocationid").value;


                var day = new Date(date.getFullYear(), 1);
                $('#mainallocationyear').datepicker('update', day);
                $('#mainallocationyear').val(day.getFullYear());
                var comp = document.getElementById("addmaincomp1").value; 
                var alldata = 
                {
                  subid:subid,
                  comp:comp,
                  year: day.getFullYear(),
                };
                console.log(alldata);
                $.ajax({
                  url:"ajax-viewsub.php",
                  data: alldata,
                  dataType: "json",
                  method: "POST",
                  success:function(data){
                    $("#showsubview").html(data); 
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

              function clearform(data1, data2, data3,data4, data5){ 
                $(data1).removeClass("text-success").removeClass("text-danger");
                document.getElementById(data2).textContent="";
                $(data3).removeClass("border-success").removeClass("border-danger");
              }

            </script>

    <div class="modal fade" id="submodal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content" style="padding: 70px">
          <div class="modal-body"  >
            <form id="subform">
              <div class="form-group">


                <div class="modal-header">
                  <h6 class="modal-title">Sub Allocation Amount</h6>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <br>
                <input class="form-control" type="hidden" id="initialsubBudget" name="initialsubBudget" value="">
                <label><h6 class="m-0">Company </h6></label>
                <select class="form-control" style="transition: box-shadow .3s" disabled name="addsubcomp" id="addsubcomp">

                  <?php foreach($listcompany as $row) 
                  { ?>
                   <option value="<?php echo $row->companyID ?>"><?php echo $row->company ?></option>
                   <?php
                 }
                 ?>
               </select>
               <small><span id="addsubcomperror"></span></small>

               <div class="form-group">
                <label><h6 class="m-0">Year </h6></label>
                <input class="form-control" disabled type="text" id="suballocationyear" name="suballocationyear" value="">
                <input class="form-control" type="hidden" id="addsubuser" name="addsubuser" value="<?php echo $resultresult->userID ?>">
                <input class="form-control" type="hidden" id="addsubcorporate" name="addmaincorporate" value="<?php echo $resultresult->corporateID ?>">

                <label><h6 class="m-0">Category </h6></label>
                <input class="form-control" type="text" id="subcategory" name="subcategory" >
                <small><span id="subcategoryerror"></span></small>

              </div>
              <div class="form-group">
                <label><h6 class="m-0">Percent of Allocation </h6></label>
                <input class="form-control" type="text" id="subpercent" name="subpercent" >
                <small><span id="subpercenterror"></span></small>
              </div>

              <br>
              <center><button name="submit" id="saveSub" value="submit" type="submit" class="btn btn-primary shadow-sm">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button></center>
              </div>
            </form>

          </div>
        </div>

      </div>
    </div>

<!-- update sub script -->
<script type="text/javascript">
  $(document).ready(function(){

    $(document).on('click', ".updatesub", function(){
      var budgetSubAllocationID = $(this).data('id');
      $.ajax({
        url: "ajax-getsub.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: {budgetSubAllocationID:budgetSubAllocationID},
        dataType:"json",
        success:function(data){
          $("#updsubid").val(data.id);
          $("#updsubcategory").val(data.updsubcategory);
          $("#updsubpercent").val(data.updsubpercent);
          $("#updmainidsub").val(data.mainid);
          $("#updbudgetothers").val(data.budgetothers);
        }
      });
    });

    var form = $('#updatesubform');
    form.on('submit', function(e){
      e.preventDefault();
      e.stopPropagation();
      document.getElementById("updSub").innerHTML = "<span class='spinner-border spinner-border-sm'></span> Updating";
      document.getElementById("updSub").disabled = true; 
      var budgetSubAllocationID = document.getElementById("updsubid").value;
      var mainid = document.getElementById("updmainidsub").value;
      var budgetothers = document.getElementById("updbudgetothers").value;
      var updsubcomp = document.getElementById("updsubcomp").value;
      var updsubcategory = document.getElementById("updsubcategory").value;
      var updsubpercent = document.getElementById("updsubpercent").value;
     
      var alldata = 
      {
        subid:budgetSubAllocationID, 
        mainid:mainid,
        budgetothers:budgetothers,
        updsubcomp:updsubcomp,
        subcate:updsubcategory,
        subper:updsubpercent,
      };
      $.ajax({
        url: "ajax-updatesub.php",
        type: "POST",
        data: alldata,
        dataType:"json",
        success:function(data){
          document.getElementById("updSub").innerHTML = "Confirm";
          document.getElementById("updSub").disabled = false; 
          if(data.condition === "Passed"){
           document.getElementById("updatesubform").reset();
            $("#updatesub").modal("hide");
            getviewsub();
        
          }else{
            checkvalidity("updsubpercenterror","#updsubpercenterror", "#updsubpercent", data.updsubpercent); 
          }
        }
      });
    });
  });
      function getviewsub($year){
        weekpicker = $('#mainallocationyear');
        weekpicker.datepicker({
            autoclose: true,
            forceParse: false,
            orientation: 'bottom',
            minViewMode: "years"
        }).on("changeDate", function(e) {
            selectmonthsub(e.date);
        });
        selectmonthsub(new Date);
      }

    function selectmonthsub(date) {
      var subid = document.getElementById("suballocationid").value;

        var day = new Date(date.getFullYear(), 1);
        $('#mainallocationyear').datepicker('update', day);
        $('#mainallocationyear').val(day.getFullYear());
       var comp = document.getElementById("addmaincomp1").value; 
        var alldata = 
        {
          subid:subid,
          comp:comp,
          year: day.getFullYear(),
        };
        console.log(alldata);
        $.ajax({
    url:"ajax-viewsub.php",
    data: alldata,
    dataType: "json",
    method: "POST",
    success:function(data){
      $("#showsubview").html(data); 
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


<div class="modal fade" id="updatesub">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="padding: 70px">
      <div class="modal-body"  >
        <form id="updatesubform">
          <div class="form-group">
            <div class="modal-header">
              <h6 class="modal-title">Sub Allocation</h6>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <input type="hidden" class="form-control" name="updmainidsub" id="updmainidsub">

            <input type="hidden" class="form-control" name="updsubid" id="updsubid">
            <input type="hidden" class="form-control" name="updbudgetothers" id="updbudgetothers">

            <label><h6 class="m-0">Company </h6></label>
            <select class="form-control" disabled style="transition: box-shadow .3s" id="updsubcomp">

              <?php foreach($listcompany as $row) 
              { ?>
               <option value="<?php echo $row->companyID ?>"><?php echo $row->company ?></option>
               <?php
             }
             ?>
           </select>
           <small><span id="updsubcomperror"></span></small>

           <div class="form-group">
            <label><h6 class="m-0">Category </h6></label>
            <input class="form-control"  type="text" disabled id="updsubcategory">

            <small><span id="updsubcategoryerror"></span></small>
          </div>

          <div class="form-group">
            <label><h6 class="m-0">Percent of Allocation </h6></label>
            <input class="form-control"  type="text" id="updsubpercent">
            <small><span id="updsubpercenterror"></span></small>
          </div>

          <br>
          <center><button name="submit" id="updSub" value="submit" type="submit" class="btn btn-primary shadow-sm">Update</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button></center>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
    <!-- delete sub -->
    <script type="text/javascript">
     $(document).ready(function(){
      var form = $('#deletesubform');

      $(document).on('click', ".deletesub", function(){
        var budgetSubAllocationID = $(this).data('id');

        $("#deletesubid").val(budgetSubAllocationID);
      });

      form.on('submit', function(e){
        e.preventDefault();
        e.stopPropagation();
        var deletesubid = document.getElementById("deletesubid").value;
        var alldata = "deletesubid="+deletesubid;
        console.log(alldata);
        $.ajax({
          url: "ajax-deletesub.php?lang=<?php echo $extlg;?>",
          type: "POST",
          data: alldata,
          success:function(data){
            var obj = JSON.parse(data);
          // console.log(obj);
          if(obj.condition === "Passed"){
            $("#deletesubmodal").modal("hide"); 
            getviewsub();

          }
        }
      });
      });

      $("#deletesubmodal").on('hidden.bs.modal', function(){
      });
      function getviewsub($year){
        weekpicker = $('#mainallocationyear');
        weekpicker.datepicker({
          autoclose: true,
          forceParse: false,
          orientation: 'bottom',
          minViewMode: "years"
        }).on("changeDate", function(e) {
          selectmonthsub(e.date);
        });
        selectmonthsub(new Date);
      }

      function selectmonthsub(date) {
        var subid = document.getElementById("suballocationid").value;


        var day = new Date(date.getFullYear(), 1);
        $('#mainallocationyear').datepicker('update', day);
        $('#mainallocationyear').val(day.getFullYear());
        var comp = document.getElementById("addmaincomp1").value; 
        var alldata = 
        {
          subid:subid,
          comp:comp,
          year: day.getFullYear(),
        };
        console.log(alldata);
        $.ajax({
          url:"ajax-viewsub.php",
          data: alldata,
          dataType: "json",
          method: "POST",
          success:function(data){
        $("#showsubview").html(data); // This is A
      }
    });
      };


    });  
  </script>
<!-- delete sub modal -->
<div class="modal fade" id="deletesubmodal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="padding:70px">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Delete</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <form id="deletesubform">
        <input type="hidden" class="form-control" name="deletesubid" id="deletesubid">
        <div class="modal-body"> Are you sure you want to delete this? </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button name="delete" value="delete" type="delete" class="btn btn-primary shadow-sm">Delete</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div></form>
      </div>
    </div>
  </div>

  <!-- script add revenue  -->
  <script type="text/javascript">
    $(document).ready(function(){
     var form = $('#addRevenueForm');
     form.on('submit', function(e){
      e.preventDefault();  
      e.stopPropagation(); 

      document.getElementById("saveRev").innerHTML = "<span class='spinner-border spinner-border-sm'></span> Saving";
      document.getElementById("saveRev").disabled = true; 

      var addCorp = document.getElementById("addrevcorporate").value;
      var addrevcompany = document.getElementById("addrevcompany").value;
      var addUser = document.getElementById("addrevuser").value;
      var addRevyear = document.getElementById("addrevenueyear").value;
      var addRevType = document.getElementById("revtype").value;
      var addJanRev = document.getElementById("revJan").value;
      var addFebRev = document.getElementById("revFeb").value;
      var addMarRev = document.getElementById("revMar").value;
      var addAprRev = document.getElementById("revApr").value;
      var addMayRev = document.getElementById("revMay").value;
      var addJunRev = document.getElementById("revJun").value;
      var addJulRev = document.getElementById("revJul").value;
      var addAugRev = document.getElementById("revAug").value;
      var addSepRev = document.getElementById("revSep").value;
      var addOctRev = document.getElementById("revOct").value;
      var addNovRev = document.getElementById("revNov").value;
      var addDecRev = document.getElementById("revDec").value;


      var alldata = 
      {
       addrevcorp:addCorp,
       addrevcompany:addrevcompany,
       addrevuser:addUser,
       year:addRevyear,
       addtyperev:addRevType,
       janrev:addJanRev,
       febrev:addFebRev,
       marrev:addMarRev,
       aprrev:addAprRev,
       mayrev:addMayRev,
       junrev:addJunRev,
       julrev:addJulRev,
       augrev:addAugRev,
       seprev:addSepRev,
       octrev:addOctRev,
       novrev:addNovRev,
       decrev:addDecRev,

     };
     $.ajax({
      url: "ajax-addrevenue.php",
      type: "POST",
      data: alldata,
      dataType:"json",
      success:function(data){
        document.getElementById("saveRev").innerHTML = "Saving";
        document.getElementById("saveRev").disabled = false; 

        if(data.condition === "Passed"){
         document.getElementById("addRevenueForm").reset();
         $("#addRevenue").modal("hide");
         getviewrev();

       }else{
        checkvalidity("revtypeerror", "#revtypeerror","#revtype",data.typeRevenue); 
        checkvalidity("revJanerror", "#revJanerror","#revJan",data.jan); 
        checkvalidity("revFeberror", "#revFeberror","#revFeb",data.feb); 
        checkvalidity("revMarerror", "#revMarerror","#revMar",data.mar); 
        checkvalidity("revAprerror", "#revAprerror","#revApr",data.apr); 
        checkvalidity("revMayerror", "#revMayerror","#revMay",data.may); 
        checkvalidity("revJunerror", "#revJunerror","#revJun",data.jun); 
        checkvalidity("revJulerror", "#revJulerror","#revJul",data.jul); 
        checkvalidity("revAugerror", "#revAugerror","#revAug",data.aug); 
        checkvalidity("revSeperror", "#revSeperror","#revSep",data.sep); 
        checkvalidity("revOcterror", "#revOcterror","#revOct",data.oct); 
        checkvalidity("revNoverror", "#revNoverror","#revNov",data.nov); 
        checkvalidity("revDecerror", "#revDecerror","#revDec",data.dec); 
      }
    }
  });
   });
   });
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

        <!-- add revenue form  -->
        <div class="modal fade" id="addRevenue" aria-hidden="true" style="display: none;">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-body">
                <div class="row">
                  <div class="col-12"><button type="button" class="close" data-dismiss="modal">×</button></div>
                  <div class="col-1"></div>
                  <div class="col-12 col-sm-10 py-4">
                    <h4 class="modal-title">Revenue</h4>
                    <form class="mt-5" id="addRevenueForm">
                      <div class="form-group">
                        <div class="row">
                          <div class="col">
                            <label><h6 class="m-0">Revenue Type</h6></label>
                            <select class="form-control" id="revtype" name="revtype">
                              <option value="estimatedrev">Estimated</option>
                              <option value="actualrev">Actual</option>
                            </select>
                            <small><span id="revtypeerror"></span></small>
                          </div>
                        </div>
                      </div>
                      <br>
                      <input class="form-control" type="hidden" id="addrevcorporate" name="addrevcorporate" value="<?php echo $resultresult->corporateID ?>">
                      <input class="form-control" type="text" id="addrevcompany" name="addrevcompany" value="">
                      <input class="form-control" type="hidden" id="addrevuser" name="addrevuser" value="<?php echo $resultresult->userID ?>">
                      <input class="form-control" type="hidden" id="addrevenueyear" name="addrevenueyear" value="">

                      <div class="form-group">
                       <label><h6 class="m-0">January </h6></label>
                       <input class="form-control" type="text" id="revJan" name="revJan"><span id="revJanerror"></span>
                     </div>
                     <div class="form-group">
                       <label><h6 class="m-0">February </h6></label>
                       <input class="form-control" type="text" id="revFeb" name="revFeb"><span id="revFeberror"></span>
                       </div>
                       <div class="form-group">
                         <label><h6 class="m-0">March </h6></label>
                         <input class="form-control" type="text" id="revMar" name="revMar"><span id="revMarerror"></span>
                       </div>
                       <div class="form-group">
                         <label><h6 class="m-0">April </h6></label>
                         <input class="form-control" type="text" id="revApr" name="revApr"><span id="revAprerror"></span>
                       </div>
                       <div class="form-group">
                         <label><h6 class="m-0">May</h6></label>
                         <input class="form-control" type="text" id="revMay" name="revMay"><span id="revMayerror"></span>
                       </div>
                       <div class="form-group">
                         <label><h6 class="m-0">Jun </h6></label>
                         <input class="form-control" type="text" id="revJun" name="revJun"><span id="revJunerror"></span>
                       </div>
                       <div class="form-group">
                         <label><h6 class="m-0">July</h6></label>
                         <input class="form-control" type="text" id="revJul" name="revJul"><span id="revJulerror"></span>
                       </div>
                       <div class="form-group">
                         <label><h6 class="m-0">August </h6></label>
                         <input class="form-control" type="text" id="revAug" name="revAug"><span id="revAugerror"></span>
                       </div>
                       <div class="form-group">
                         <label><h6 class="m-0">September </h6></label>
                         <input class="form-control" type="text" id="revSep" name="revSep"><span id="revSeperror"></span>
                       </div>
                       <div class="form-group">
                         <label><h6 class="m-0">October </h6></label>
                         <input class="form-control" type="text" id="revOct" name="revOct"><span id="revOcterror"></span>
                       </div>
                       <div class="form-group">
                         <label><h6 class="m-0">November </h6></label>
                         <input class="form-control" type="text" id="revNov" name="revNov"><span id="revNoverror"></span>
                       </div>
                       <div class="form-group">
                         <label><h6 class="m-0">December </h6></label>
                         <input class="form-control" type="text" id="revDec" name="revDec"><span id="revDecerror"></span>
                       </div>

                       <div class="row">
                        <div class="col text-right">
                          <button id="saveRev" name="saveRev" value="submit" type="submit" class="btn btn-primary shadow-sm" >Save</button>
                          <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancel">Cancel</button>
                        </div>
                      </div>
                    </form>
                  </div></div></div></div>           
                </div></div>

                      
    <!-- update estimated revenue script -->
    <script type="text/javascript">
      $(document).ready(function(){

        $(document).on('change', ".updrev", function(){
          var budgetRevenueID = $(this).data('id');
          var type = $(this).data('type');
          var column = $(this).data('column');
          var month = $(this).data('month');
          var prev = $(this).data('prev');
          if (type == "estimatedrev") {
            var value = document.getElementById("estimated" + month).value;
          }
          else{
            var value = document.getElementById("actual" + month).value;
          }
          var alldata = 
          {
            budgetRevenueID:budgetRevenueID,
            type:type,
            column:column,
            month:month,
            value:value,
            prev:prev
          }
          console.log(alldata);
          $.ajax({
            url: "ajax-updaterevenue.php",
            type: "POST",
            data: alldata,
            dataType:"json",
            success:function(data){
              if(data.condition === "Passed"){
               $("#revtable").DataTable().destroy();
               getviewrev();
              }
              else{
                checkvalidity("estimatederror" + data.month, "#estimatederror" + data.month,"#estimated" + data.month,data.value); 
              }
              // $("#updestimateid").val(data.id);
              // $("#updyear").val(data.updyear);
              // $("#updrevtype").val(data.updrevtype);
              // $("#updrevJan").val(data.updrevjan);
              // $("#updrevFeb").val(data.updrevfeb);
              // $("#updrevMar").val(data.updrevmar);
              // $("#updrevApr").val(data.updrevapr);
              // $("#updrevMay").val(data.updrevmay);
              // $("#updrevJun").val(data.updrevjun);
              // $("#updrevJul").val(data.updrevjul);
              // $("#updrevAug").val(data.updrevaug);
              // $("#updrevSep").val(data.updrevsep);
              // $("#updrevOct").val(data.updrevoct);
              // $("#updrevNov").val(data.updrevnov);
              // $("#updrevDec").val(data.updrevdec);  
              // $("#updrevcompany").val(data.company);  
              // $("#updrevcorporate").val(data.corporate);  
              // $("#updrevuser").val(data.user);  
            }
          });
        });

        // var form = $('#updateRevenueForm');
        // form.on('submit', function(e){
        //   e.preventDefault();
        //   e.stopPropagation();
        //   document.getElementById("saveupdrevenue").innerHTML = "<span class='spinner-border spinner-border-sm'></span> Updating";
        //   document.getElementById("saveupdrevenue").disabled = true; 
        //   var budgetRevenueID = document.getElementById("updestimateid").value;
        //   var updyear = document.getElementById("updyear").value;
        //   var updrevtype = document.getElementById("updrevtype").value;
        //   var updrevJan = document.getElementById("updrevJan").value;
        //   var updrevFeb = document.getElementById("updrevFeb").value;
        //   var updrevMar = document.getElementById("updrevMar").value;
        //   var updrevApr = document.getElementById("updrevApr").value;
        //   var updrevMay = document.getElementById("updrevMay").value;
        //   var updrevJun = document.getElementById("updrevJun").value;
        //   var updrevJul = document.getElementById("updrevJul").value;
        //   var updrevAug = document.getElementById("updrevAug").value;
        //   var updrevSep = document.getElementById("updrevSep").value;
        //   var updrevOct = document.getElementById("updrevOct").value;
        //   var updrevNov = document.getElementById("updrevNov").value;
        //   var updrevDec = document.getElementById("updrevDec").value;

        //   var updrevcorporate = document.getElementById("updrevcorporate").value;
        //   var updrevuser = document.getElementById("updrevuser").value;
        //   var updrevcompany = document.getElementById("updrevcompany").value;

        //   var alldata = 
        //   {
        //     budgetRevenueID:budgetRevenueID,
        //     updyear:updyear,
        //     updrevtype:updrevtype,
        //     updrevjan:updrevJan,
        //     updrevfeb:updrevFeb,
        //     updrevmar:updrevMar,
        //     updrevapr:updrevApr,
        //     updrevmay:updrevMay,
        //     updrevjun:updrevJun,
        //     updrevjul:updrevJul,
        //     updrevaug:updrevAug,
        //     updrevsep:updrevSep,
        //     updrevoct:updrevOct,
        //     updrevnov:updrevNov,
        //     updrevdec:updrevDec, 
        //     updrevcorporate:updrevcorporate, 
        //     updrevuser:updrevuser, 
        //     updrevcompany:updrevcompany, 

        //   };
        //   console.log(alldata);
        //   $.ajax({
        //     url: "ajax-updaterevenue.php",
        //     type: "POST",
        //     data: alldata,
        //     dataType:"json",
        //     success:function(data){
        //       document.getElementById("saveupdrevenue").innerHTML = "Confirm";
        //       document.getElementById("saveupdrevenue").disabled = false; 
        //       if(data.condition === "Passed"){
        //        $("#updestimaterev").modal("hide");
        //        getviewrev();
        //        getchartview();

        //      }else{
        //       checkvalidity("updrevtypeerror", "#updrevtypeerror","#updrevtype",data.updrevtype); 
        //       checkvalidity("updrevJanerror", "#updrevJanerror","#updrevJan",data.updrevjan); 
        //       checkvalidity("updrevFeberror", "#updrevFeberror","#updrevFeb",data.updrevfeb); 
        //       checkvalidity("updrevMarerror", "#updrevMarerror","#updrevMar",data.updrevmar); 
        //       checkvalidity("updrevAprerror", "#updrevAprerror","#updrevApr",data.updrevapr); 
        //       checkvalidity("updrevMayerror", "#updrevMayerror","#updrevMay",data.updrevmay); 
        //       checkvalidity("updrevJunerror", "#updrevJunerror","#updrevJun",data.updrevjun); 
        //       checkvalidity("updrevJulerror", "#updrevJulerror","#updrevJul",data.updrevjul); 
        //       checkvalidity("updrevAugerror", "#updrevAugerror","#updrevAug",data.updrevaug); 
        //       checkvalidity("updrevSeperror", "#updrevSeperror","#updrevSep",data.updrevsep); 
        //       checkvalidity("updrevOcterror", "#updrevOcterror","#updrevOct",data.updrevoct); 
        //       checkvalidity("updrevNoverror", "#updrevNoverror","#updrevNov",data.updrevnov); 
        //       checkvalidity("updrevDecerror", "#updrevDecerror","#updrevDec",data.updrevdec); 
        //     }
        //   }
        // });
        // });
});

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
      
    }

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
               
                <!-- updaterevenue form -->

                <div class="modal fade" id="updestimaterev" aria-hidden="true" style="display: none;">
                 <div class="modal-dialog modal-lg">
                   <div class="modal-content">
                     <div class="modal-body">
                       <div class="row">
                         <div class="col-12"><button type="button" class="close" data-dismiss="modal">×</button></div>
                         <div class="col-1"></div>
                         <div class="col-12 col-sm-10 py-4">
                           <h4 class="modal-title">Revenue </h4>
                           <form class="mt-5" id="updateRevenueForm">
                             <div class="form-group">
                               <div class="row">
                                 <div class="col">
                                   <label><h6 class="m-0">Revenue Type</h6></label>
                                   <select class="form-control" id="updrevtype" name="updrevtype">
                                     <option value="estimatedrev">Estimated</option>
                                     <option value="actualrev">Actual</option>
                                   </select>
                                   <small><span id="updrevtypeerror"></span></small>
                                 </div>
                               </div>
                             </div>
                             <br>
                             <input class="form-control" type="hidden" id="updyear" name="updyear" value="">
                             <input class="form-control" type="hidden" id="updrevcorporate" name="updrevcorporate" value="<?php echo $resultresult->corporateID ?>">
                             <input class="form-control" type="hidden" id="updrevcompany" name="updrevcompany" value="">
                             <input class="form-control" type="hidden" id="updrevuser" name="updrevuser" value="<?php echo $resultresult->userID ?>">
                             
                             <input class="form-control" type="hidden" id="updestimateid" name="updestimateid" value="">


                             <div class="form-group">
                              <label><h6 class="m-0">January </h6></label>
                              <input class="form-control" type="text" id="updrevJan" name="updrevJan"><span id="updrevJanerror"></span>
                            </div>
                            <div class="form-group">
                              <label><h6 class="m-0">February </h6></label>
                              <input class="form-control" type="text" id="updrevFeb" name="updrevFeb"><span id="updrevFeberror"></span>
                              </div>
                              <div class="form-group">
                                <label><h6 class="m-0">March </h6></label>
                                <input class="form-control" type="text" id="updrevMar" name="updrevMar"><span id="updrevMarerror"></span>
                              </div>
                              <div class="form-group">
                                <label><h6 class="m-0">April </h6></label>
                                <input class="form-control" type="text" id="updrevApr" name="updrevApr"><span id="updrevAprerror"></span>
                              </div>
                              <div class="form-group">
                                <label><h6 class="m-0">May</h6></label>
                                <input class="form-control" type="text" id="updrevMay" name="updrevMay"><span id="updrevMayerror"></span>
                              </div>
                              <div class="form-group">
                                <label><h6 class="m-0">Jun </h6></label>
                                <input class="form-control" type="text" id="updrevJun" name="updrevJun"><span id="updrevJunerror"></span>
                              </div>
                              <div class="form-group">
                                <label><h6 class="m-0">July</h6></label>
                                <input class="form-control" type="text" id="updrevJul" name="updrevJul"><span id="updrevJulerror"></span>
                              </div>
                              <div class="form-group">
                                <label><h6 class="m-0">August </h6></label>
                                <input class="form-control" type="text" id="updrevAug" name="updrevAug"><span id="updrevAugerror"></span>
                              </div>
                              <div class="form-group">
                                <label><h6 class="m-0">September </h6></label>
                                <input class="form-control" type="text" id="updrevSep" name="updrevSep"><span id="updrevSeperror"></span>
                              </div>
                              <div class="form-group">
                                <label><h6 class="m-0">October </h6></label>
                                <input class="form-control" type="text" id="updrevOct" name="updrevOct"><span id="updrevOcterror"></span>
                              </div>
                              <div class="form-group">
                                <label><h6 class="m-0">November </h6></label>
                                <input class="form-control" type="text" id="updrevNov" name="updrevNov"><span id="updrevNoverror"></span>
                              </div>
                              <div class="form-group">
                                <label><h6 class="m-0">December </h6></label>
                                <input class="form-control" type="text" id="updrevDec" name="updrevDec"><span id="updrevDecerror"></span>
                              </div>

                              <div class="row">
                               <div class="col text-right">
                                 <button id="saveupdrevenue" name="saveupdrevenue" value="submit" type="submit" class="btn btn-primary shadow-sm" >Save</button>
                                 <button type="button" class="btn btn-danger" data-dismiss="modal" id="">Cancel</button>
                               </div>
                             </div>
                           </form>
                         </div></div></div></div>           
                       </div>
                     </div>

  <!-- addgross profit -->

  <script type="text/javascript">
    $(document).ready(function(){
     var form = $('#gpform');
     form.on('submit', function(e){
      e.preventDefault();  
      e.stopPropagation(); 

      document.getElementById("savegp").innerHTML = "<span class='spinner-border spinner-border-sm'></span> Adding";
      document.getElementById("savegp").disabled = true;


      var gp1 = document.getElementById("gpJan").value;
      var gp2 = document.getElementById("gpFeb").value;
      var gp3 = document.getElementById("gpMar").value;
      var gp4 = document.getElementById("gpApr").value;
      var gp5 = document.getElementById("gpMay").value;
      var gp6 = document.getElementById("gpJun").value;
      var gp7 = document.getElementById("gpJul").value;
      var gp8 = document.getElementById("gpAug").value;
      var gp9 = document.getElementById("gpSept").value;
      var gp10 = document.getElementById("gpOct").value;
      var gp11 = document.getElementById("gpNov").value;
      var gp12 = document.getElementById("gpDec").value;
      var addgpuser = document.getElementById("addgpuser").value;
      var choosegpcomp = document.getElementById("choosegpcomp").value;
      var choosegpyear= document.getElementById("choosegpyear").value;
      var addgpcorporate = document.getElementById("addgpcorporate").value;

      var alldata = 
      {
       G1:gp1,
       G2:gp2,
       G3:gp3,
       G4:gp4,
       G5:gp5,
       G6:gp6,
       G7:gp7,
       G8:gp8,
       G9:gp9,
       G10:gp10,
       G11:gp11,
       G12:gp12,
       
       addgpuser: addgpuser,
       choosegpcomp:choosegpcomp,
       choosegpyear:choosegpyear,
       addgpcorporate:addgpcorporate,
     };
     $.ajax({
      url: "ajax-addgp.php",
      type: "POST",
      data: alldata,
      dataType:"json",
      success:function(data){
        document.getElementById("savegp").innerHTML = "Add";
        document.getElementById("savegp").disabled = false;
        if(data.condition === "Passed"){
          document.getElementById("gpform").reset();
          $("#gpmodal").modal("hide");
          getGPview();
        }else{
         checkvalidity("gpJanerror", "#gpJanerror","#gpJan",data.gpJan );
         checkvalidity("gpFeberror", "#gpFeberror","#gpFeb",data.gpFeb );
         checkvalidity("gpMarerror", "#gpMarerror","#gpMar",data.gpMar );
         checkvalidity("gpAprerror", "#gpAprerror","#gpApr",data.gpApr );
         checkvalidity("gpMayerror", "#gpMayerror","#gpMay",data.gpMay);
         checkvalidity("gpJunerror", "#gpJunerror","#gpJun",data.gpJun );
         checkvalidity("gpJulerror", "#gpJulerror","#gpJul",data.gpJul );
         checkvalidity("gpAugerror", "#gpAugerror","#gpAug",data.gpAug );
         checkvalidity("gpSepterror", "#gpSepterror","#gpSept",data.gpSept );
         checkvalidity("gpOcterror", "#gpOcterror","#gpOct",data.gpOct );
         checkvalidity("gpNoverror", "#gpNoverror","#gpNov",data.gpNov );
         checkvalidity("gpDecerror", "#gpDecerror","#gpDec",data.gpDec ); 
       }
  }
  });
   });
  });
    function getGPview(){ 
          $.ajax({
            url:"ajax-viewgp.php",
            success:function(data){
              $("#showgpview").html(data);
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
    function clearform(data1, data2, data3,data4, data5){ 
      $(data1).removeClass("text-success").removeClass("text-danger");
      document.getElementById(data2).textContent="";
      $(data3).removeClass("border-success").removeClass("border-danger");
    }
  </script>

  <div class="modal fade" id="gpmodal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="padding: 70px">
        <div class="modal-body"  >
          <form id="gpform">
            <div class="form-group">


              <div class="modal-header">
                <h6 class="modal-title">Gross Profit</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <br>
              <input class="form-control" type="hidden" id="choosegpcomp" name="choosegpcomp" value="">
              <input class="form-control" type="hidden" id="choosegpyear" name="choosegpyear" value="">
              <input class="form-control" type="hidden" id="addgpuser" name="addgpuser" value="<?php echo $resultresult->userID ?>">

              <input class="form-control" type="hidden" id="addgpcorporate" name="addgpcorporate" value="<?php echo $resultresult->corporateID ?>">


              <div class="form-group">
                <label><h6 class="m-0">January </h6></label>
                <input class="form-control" type="text" id="gpJan" name="gpJan"><span id="gpJanerror"></span>
              </div>
              <div class="form-group">
                <label><h6 class="m-0">February </h6></label>
                <input class="form-control" type="text" id="gpFeb" name="gpFeb"><span id="gpFeberror"></span>
              </div>
              <div class="form-group">
                <label><h6 class="m-0">March </h6></label>
                <input class="form-control" type="text" id="gpMar" name="gpMar"><span id="gpMarerror"></span>
              </div>
              <div class="form-group">
                <label><h6 class="m-0">April </h6></label>
                <input class="form-control" type="text" id="gpApr" name="gpApr"><span id="gpAprerror"></span>
              </div>
              <div class="form-group">
                <label><h6 class="m-0">May</h6></label>
                <input class="form-control" type="text" id="gpMay" name="gpMay"><span id="gpMayerror"></span>
              </div>
              <div class="form-group">
                <label><h6 class="m-0">Jun </h6></label>
                <input class="form-control" type="text" id="gpJun" name="gpJun"><span id="gpJunerror"></span>
              </div>
              <div class="form-group">
                <label><h6 class="m-0">July</h6></label>
                <input class="form-control" type="text" id="gpJul" name="gpJul"><span id="gpJulerror"></span>
              </div>
              <div class="form-group">
                <label><h6 class="m-0">August </h6></label>
                <input class="form-control" type="text" id="gpAug" name="gpAug"><span id="gpAugerror"></span>
              </div>
              <div class="form-group">
                <label><h6 class="m-0">September </h6></label>
                <input class="form-control" type="text" id="gpSept" name="gpSept"><span id="gpSepterror"></span>
              </div>
              <div class="form-group">
                <label><h6 class="m-0">October </h6></label>
                <input class="form-control" type="text" id="gpOct" name="gpOct"><span id="gpOcterror"></span>
              </div>
              <div class="form-group">
                <label><h6 class="m-0">November </h6></label>
                <input class="form-control" type="text" id="gpNov" name="gpNov"><span id="gpNoverror"></span>
              </div>
              <div class="form-group">
                <label><h6 class="m-0">December </h6></label>
                <input class="form-control" type="text" id="gpDec" name="gpDec"><span id="gpDecerror"></span>
              </div>

              <br>
              <center><button name="submit" value="submit" id="savegp" type="submit" class="btn btn-primary shadow-sm">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button></center>
              </div>
            </form>

          </div>
        </div>

      </div></div>

      <!-- update gross profit -->

      <script type="text/javascript">
        $(document).ready(function(){

          $(document).on('click', ".updategpmodal", function(){
            var budgetGrossProfitID = $(this).data('id');
            $.ajax({
              url: "ajax-getgrossprofit.php?lang=<?php echo $extlg;?>",
              type: "POST",
              data: {budgetGrossProfitID:budgetGrossProfitID},
              dataType:"json",
              success:function(data){
                $("#updgpid").val(data.id);
                $("#updgpJan").val(data.updgpJan);
                $("#updgpFeb").val(data.updgpFeb);
                $("#updgpMar").val(data.updgpMar);
                $("#updgpApr").val(data.updgpApr);
                $("#updgpMay").val(data.updgpMay);
                $("#updgpJun").val(data.updgpJun);
                $("#updgpJul").val(data.updgpJul);
                $("#updgpAug").val(data.updgpAug);
                $("#updgpSept").val(data.updgpSept);
                $("#updgpOct").val(data.updgpOct);
                $("#updgpNov").val(data.updgpNov);
                $("#updgpDec").val(data.updgpDec);
              }
            });
          });
          var form = $('#updategpform');
          form.on('submit', function(e){
            e.preventDefault();
            e.stopPropagation();
            document.getElementById("updsavegp").innerHTML = "<span class='spinner-border spinner-border-sm'></span> Updating";
            document.getElementById("updsavegp").disabled = true; 
            var budgetGrossProfitID = document.getElementById("updgpid").value;
            var updgpJan = document.getElementById("updgpJan").value;
            var updgpFeb = document.getElementById("updgpFeb").value;
            var updgpMar = document.getElementById("updgpMar").value;
            var updgpApr = document.getElementById("updgpApr").value;
            var updgpMay = document.getElementById("updgpMay").value;
            var updgpJun = document.getElementById("updgpJun").value;
            var updgpJul = document.getElementById("updgpJul").value;
            var updgpAug = document.getElementById("updgpAug").value;
            var updgpSept = document.getElementById("updgpSept").value;
            var updgpOct = document.getElementById("updgpOct").value;
            var updgpNov = document.getElementById("updgpNov").value;
            var updgpDec = document.getElementById("updgpDec").value;
            
            var alldata = 
            {
              gpid:budgetGrossProfitID,
              updgpJan:updgpJan,
              updgpFeb:updgpFeb,
              updgpMar:updgpMar,
              updgpApr:updgpApr,
              updgpMay:updgpMay,
              updgpJun:updgpJun,
              updgpJul:updgpJul,
              updgpAug:updgpAug,
              updgpSept:updgpSept,
              updgpOct: updgpOct,
              updgpNov:updgpNov,
              updgpDec:updgpDec,
              
            };
            $.ajax({
              url: "ajax-updategp.php",
              type: "POST",
              data: alldata,
              dataType:"json",
              success:function(data){
                document.getElementById("updsavegp").innerHTML = "Confirm";
                document.getElementById("updsavegp").disabled = false; 
                if(data.condition === "Passed"){
                 document.getElementById("updategpform").reset();
                 
                  $("#updategpmodal").modal("hide");
                  getGPview();
                  
                }else{
                  checkvalidity("updgpJanerror","#updgpJanerror", "#updgpJan", data.updgpJan);
                  checkvalidity("updgpFeberror","#updgpFeberror", "#updgpFeb", data.updgpFeb);
                  checkvalidity("updgpMarerror","#updgpMarerror", "#updgpMar", data.updgpMar);
                  checkvalidity("updgpAprerror","#updgpAprerror", "#updgpApr", data.updgpApr);
                  checkvalidity("updgpMayerror","#updgpMayerror", "#updgpMay", data.updgpMay);
                  checkvalidity("updgpJunerror","#updgpJunerror", "#updgpJun", data.updgpJun);
                  checkvalidity("updgpJulerror","#updgpJulerror", "#updgpJul", data.updgpJul);
                  checkvalidity("updgpAugerror","#updgpAugerror", "#updgpAug", data.updgpAug);
                  checkvalidity("updgpSepterror","#updgpSepterror", "#updgpSept", data.updgpSept);
                  checkvalidity("updgpOcterror","#updgpOcterror", "#updgpOct", data.updgpOct);
                  checkvalidity("updgpNoverror","#updgpNoverror", "#updgpNov", data.updgpNov);
                  checkvalidity("updgpDecerror","#updgpDecerror", "#updgpDec", data.updgpDec);
                }
              }
            });
          });
        });
            
          function getGPview(){ 
            $.ajax({
              url:"ajax-viewgp.php",
              success:function(data){
                      $("#showgpview").html(data); 
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

      <div class="modal fade" id="updategpmodal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content" style="padding: 70px">
            <div class="modal-body"  >
              <form id="updategpform">
                <div class="form-group">


                  <div class="modal-header">
                    <h6 class="modal-title"> Update Gross Profit</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <br>
                  <input class="form-control" type="hidden" id="updgpid" name="updgpid" value="">
                  <input class="form-control" type="hidden" id="updgpuser" name="updgpuser" value="<?php 
                  echo $resultresult->userID ?>">

                  <input class="form-control" type="hidden" id="updgpcorporate" name="updgpcorporate" value="<?php echo $resultresult->corporateID ?>">


                  <div class="form-group">
                    <label><h6 class="m-0">January </h6></label>
                    <input class="form-control" type="text" id="updgpJan" name="updgpJan"><span id="updgpJanerror"></span>
                  </div>
                  <div class="form-group">
                    <label><h6 class="m-0">February </h6></label>
                    <input class="form-control" type="text" id="updgpFeb" name="updgpFeb"><span id="updgpFeberror"></span>
                  </div>
                  <div class="form-group">
                    <label><h6 class="m-0">March </h6></label>
                    <input class="form-control" type="text" id="updgpMar" name="updgpMar"><span id="updgpMarerror"></span>
                  </div>
                  <div class="form-group">
                    <label><h6 class="m-0">April </h6></label>
                    <input class="form-control" type="text" id="updgpApr" name="updgpApr"><span id="updgpAprerror"></span>
                  </div>
                  <div class="form-group">
                    <label><h6 class="m-0">May</h6></label>
                    <input class="form-control" type="text" id="updgpMay" name="updgpMay"><span id="updgpMayerror"></span>
                  </div>
                  <div class="form-group">
                    <label><h6 class="m-0">Jun </h6></label>
                    <input class="form-control" type="text" id="updgpJun" name="updgpJun"><span id="updgpJunerror"></span>
                  </div>
                  <div class="form-group">
                    <label><h6 class="m-0">Julai</h6></label>
                    <input class="form-control" type="text" id="updgpJul" name="gpJul"><span id="updgpJulerror"></span>
                  </div>
                  <div class="form-group">
                    <label><h6 class="m-0">August </h6></label>
                    <input class="form-control" type="text" id="updgpAug" name="updgpAug"><span id="updgpAugerror"></span>
                  </div>
                  <div class="form-group">
                    <label><h6 class="m-0">September </h6></label>
                    <input class="form-control" type="text" id="updgpSept" name="updgpSept"><span id="updgpSepterror"></span>
                  </div>
                  <div class="form-group">
                    <label><h6 class="m-0">October </h6></label>
                    <input class="form-control" type="text" id="updgpOct" name="updgpOct"><span id="updgpOcterror"></span>
                  </div>
                  <div class="form-group">
                    <label><h6 class="m-0">November </h6></label>
                    <input class="form-control" type="text" id="updgpNov" name="updgpNov"><span id="updgpNoverror"></span>
                  </div>
                  <div class="form-group">
                    <label><h6 class="m-0">December </h6></label>
                    <input class="form-control" type="text" id="updgpDec" name="updgpDec"><span id="updgpDecerror"></span>
                  </div>

                  <br>
                  <center><button name="submit" value="submit" id="updsavegp" type="submit" class="btn btn-primary shadow-sm">Update</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button></center>
                  </div>
                </form>
                
              </div>
            </div>

          </div>
        </div>
    