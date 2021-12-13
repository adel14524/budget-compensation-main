<script type="text/javascript">
$(document).ready(function(){
     var form = $('#form_id);
     form.on('submit', function(e){
        e.preventDefault();  just copy paste this in here whenever you submit 
        e.stopPropagation(); just copy paste this in here whenever you submit 

----------------------- How you get value from form field - start ---------------------------------------------

        var field_name = document.getElementById("field_name").value; -- text, textarea, select
        var field_name= $("input:radio[name=field_name]:checked").val(); -- radio
        var field_name = document.getElementById("field_name").checked; -- checkbox
        
        var field_name = document.getElementById("field_name"); -- select multiple
        var str='';
      for (i=0;i< field_name.length;i++) { 
          if(field_name[i].selected){
              str += field_name[i].value + ','; 
          }
      } 
      var str=str.slice(0,str.length -1);

--------------------- How you get value from form field - end -----------------------------------------------

       var field_id_1 = document.getElementById("field_id_1").value;
       var field_id_2 = document.getElementById("field_id_2").value;
       var alldata = 
{
     field_id_1:field_id_1,
     field_id_2:field_id_2
};
-------This is where we use ajax to send data - start-------
$.ajax({
        url: "your ajax file to do validation and add data into database",
        type: "POST",
        data: alldata,
        dataType:"json",
        success:function(data){
          if(data.condition === "Passed"){
            $("#modal_id").modal("hide");
          }else{
            checkvalidity(“parameter1”, “parameter2”,“parameter3”,“parameter4” ); -- function to show validation error
          }
        }

      });
-------This is where we use ajax to send data - end-------
});
});

function checkvalidity(data1, data2, data3, data4){ ---- for show the validity error out
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

function clearform(data1, data2, data3){ --- clear the error whenever close the modal
  $(data1).removeClass("text-success").removeClass("text-danger");
  document.getElementById(data2).textContent="";
  $(data3).removeClass("border-success").removeClass("border-danger");
}
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
      <form action="save_budget_setup.php" method="get" id="">
        <div class="modal-body">
          <div class="form-group">
            <label>
              <h6 class="m-0">Company</h6></label>
            <select class="form-control" id="companyyy" name="companyyy">
              <option value="">Obsnap Calibration</option>
              <option value="">Doerpreneur Soft</option>
              <option value="">Victor Manufacturing</option>
              <option value="">Obsnap Automation</option>
              <option value="">Obsnap Instrument</option>
              <option value="">Permata Bumi</option>
              <option value="">JS Analytical</option>
              <option value="">Victor Equipment Resources</option>
              <option value="">Obsnap International</option>
              <option value="">Obsnap Instrument(Penang)Sdn Bhd</option>
            </select>
          </div>
          <div class="form-group">
            <label>
              <h6 class="m-0">Year</h6></label>
            <select class="form-control" id="year" name="year">
              <option value="">2021</option>
              <option value="">2020</option>
              <option value="">2019</option>
              <option value="">2018</option>
              <option value="">2017</option>
              <option value="">2016</option>
              <option value="">2015</option>
            </select>
          </div>
          <div class="form-group">
            <label>
              <h6 class="m-0">Net Profit Target</h6></label>
            <input class="form-control" type="text" id="nptarget" name="nptarget"> </div>
          <div class="form-group">
            <label>
              <h6 class="m-0">Percentage of Budget </h6></label>
            <input class="form-control" type="text" id="percentbudget" name="percentbudget"> </div>
          <div class="form-group">
            <label>
              <h6 class="m-0">Initial Budget</h6></label>
            <input class="form-control" type="text" id="initialBudget" name="initialBudget">
            <a href="#dah2489" data-toggle="collapse"> <i class="fas fa-download"></i></a>
          </div>
          <br>
          <center>
            <button name="saveNP" value="submit" type="submit" class="btn btn-primary shadow-sm">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </center>
        </div>
      </form>​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​ </div>
  </div>
</div>
<!-- add expenses -->
<div class="modal-body">
  <div class="form-group">
    <div class="modal fade" id="addAmountCompensation">
      <div class="modal-dialog modal-lg">
        <div class="modal-content" style="padding: 70px">
          <div class="modal-header">
            <h6 class="modal-title">Expenses Details</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <br>
          <!-- Modal body -->
          <div class="modal-body">
            <div class="form-group">
              <label>
                <h6 class="m-0">Category</h6></label>
              <input class="form-control" readonly placeholder="Expand" type="text" id="budget" name="budget"> </div>
            <label>
              <h6 class="m-0">Date</h6></label>
            <input type="date" class="form-control selectpicker" id="addstartdate" name="addstartdate" autocomplete="off">
            <br>
            <div class="form-group">
              <label>
                <h6 class="m-0">Amount </h6></label>
              <input class="form-control" type="text" id="budget" name="budget"> </div>
            <div class="form-group">
              <label>
                <h6 class="m-0">Description </h6></label>
              <textarea class="form-control" type="text" id="budget" name="budget"></textarea>
            </div>
            <br>
            <center>
              <button name="submit" value="submit" type="submit" class="btn btn-primary shadow-sm">Save</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </center>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- add category -->
<div class="modal fade" id="addCategories">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="padding: 70px">
      <div class="modal-header">
        <h6 class="modal-title">Add Category</h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="row">&nbsp;&nbsp;
            <label>
              <h6>Category</h6></label>&nbsp;&nbsp;&nbsp;
            <input type="text" class="form-control" id="addcategori"> 
          </div>
        </div>
        <br>
        <center>
          <button name="submit" value="submit" type="submit" class="btn btn-primary shadow-sm">Save</button>
        </center>
      </div>
    </div>
  </div>
</div>