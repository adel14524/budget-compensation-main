<!-- Modal for Add Plan Daily-->
<!-- Modal for View, Edit & Delete Plan-->
<!-- Modal for Add Report-->

<!-- Modal for Add Plan Daily-->
<script type="text/javascript">
  $(document).ready(function(){
    var form = $('#addplanform');
    form.on('submit', function(e){
      e.preventDefault();
      e.stopPropagation();
      var plan = document.getElementById("addplannamedaily").value;
      var startdate = document.getElementById("addplanstartdate").value;
      var enddate = document.getElementById("addplanenddate").value;
      var id = <?php echo $resultresult->userID;?>;
      var alldata = "addplannamedaily="+plan+"&addplanstartdate="+startdate+"&addplanenddate="+enddate+"&userID="+id;
      console.log(alldata);
      $.ajax({
        url: "ajax-addplan.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
        success:function(data){
          var obj = JSON.parse(data);
          console.log(obj);
          if(obj.condition === "Passed"){
            $("#addplandaily").modal("hide");
            
          }else{
            checkvalidity("addplannamedailyerror","#addplannamedailyerror", "#addplannamedaily", obj.plan);
            checkvalidity("addplanstartdateerror","#addplanstartdateerror", "#addplanstartdate", obj.startdate);
            checkvalidity("addplanenddateerror","#addplanenddateerror", "#addplanenddate", obj.enddate);
          }
          
        }
      });
    });

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

    function modalformrefresh(){
      $('.after').hide();
      $('.before').show();
      document.getElementById("addplanform").reset(); 
      clearform("#addplannamedailyerror", "addplannamedailyerror", "#addplannamedaily");
      clearform("#addplanstartdateerror", "addplanstartdateerror", "#addplanstartdate");
      clearform("#addplanenddateerror", "addplanenddateerror", "#addplanenddate");
    }
  });
</script>
<div class="modal" id="addplandaily">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        
        
        <div class="row">
          <div class="col-12"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
          <div class="col-1"></div>
          <div class="col-12 col-sm-10 py-4">
            <h4 class="modal-title" id="scoreboardModalLabel">Create a new Plan</h4>
            <form class="mt-5" id="addplanform">
              <div class="form-group">
                <label><h6 class="m-0">PLAN</h6></label>
                <input type="text" class="form-control rounded-0" rows="5" id="addplannamedaily" name="addplannamedaily" autocomplete="off">
                <small><span id="addplannamedailyerror"></span></small> 
              </div>

              <div class="row">
                <div class="col-12 col-xl-6">
                  <div class="form-group">
                    <label><h6 class="m-0">START DATE</h6></label>
                    <input type="text" class="form-control rounded-0" id="addplanstartdate" name="addplanstartdate" autocomplete="off">
                    <small><span id="addplanstartdateerror"></span></small>
                    <script type="text/javascript">
                      $(function () {
                        $('#addplanstartdate').datetimepicker({
                          format:"YYYY-MM-DD hh:mm A",
                          widgetPositioning: {
                              vertical: 'bottom'
                          }
                        });
                      });
                    </script>
                  </div>
                </div>
                <div class="col-12 col-xl-6">
                  <div class="form-group">
                    <label><h6 class="m-0">END DATE</h6></label>
                    <input type="text" class="form-control rounded-0" id="addplanenddate" name="addplanenddate" autocomplete="off">
                    <small><span id="addplanenddateerror"></span></small>
                    <script type="text/javascript">
                      $(function () {
                        $('#addplanenddate').datetimepicker({
                          format:"YYYY-MM-DD hh:mm A",
                          widgetPositioning: {
                              vertical: 'bottom'
                          }
                        });
                      });
                    </script>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12 col-xl-6">
                  <div class="form-group">
                    <label><h6 class="m-0">ASSIGN USER</h6></label>
                    <select class="form-control rounded-0" id="sel1">
                      <option>--</option>
                      <option>User 1</option>
                      <option>User 2</option>
                      <option>User 3</option>
                      <option>User 4</option>
                    </select>
                  </div> 
                </div>
                <div class="col-12 col-xl-6">
                  <div class="form-group">
                    <label><h6 class="m-0">TYPE</h6></label>
                    <select class="form-control rounded-0">
                      <option>--</option>
                      <option>Site works</option>
                      <option>Appointment</option>
                      <option>Business Meeting</option>
                    </select>
                  </div> 
                </div>
              </div>

              <div class="row">
                <div class="col-12 col-xl-6">
                  <div class="form-group">
                    <label><h6 class="m-0">PRIORITY</h6></label>
                    <select class="form-control rounded-0">
                      <option>--</option>
                      <option>High</option>
                      <option>Low</option>
                    </select>
                  </div> 
                </div>
              </div>

              <div class="form-group">
                <label><h6 class="m-0">DESCRIPTION</h6></label>
                <textarea class="form-control rounded-0" rows="4" id="comment"></textarea>
              </div> 

              <div class="form-group">
                <label><h6 class="m-0">TAGS</h6></label>
                <select class="form-control border selectpicker rounded-0" data-live-search="true" data-size="5" multiple>
                  <option data-content="<span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: white; color: #007bff; border-color: #007bff;'>Product</span>"></option>
                  <option data-content="<span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: white; color: #007bff; border-color: #007bff;'>Location</span>"></option>
                  <option data-content="<span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: white; color: #007bff; border-color: #007bff;'>KL</span>"></option>
                  <option data-content="<span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: white; color: #007bff; border-color: #007bff;'>PJ</span>"></option>
                  <option data-content="<span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: white; color: #007bff; border-color: #007bff;'>Meter</span>"></option>
                </select>
              </div> 

              <button name="addplanbutton" value="addplanbutton" type="submit" class="btn btn-primary shadow-sm float-right"><?php echo $array['create']?></button>
            </form>
          </div>
          <div class="col-1"></div>
        </div>
      </div>
    </div>
  </div>
</div>




<script type="text/javascript">
  $(document).ready(function(){
    $('.delete').hide();

    $(document).on('click', ".getPlan", function(){
      var planID = $(this).data('id');
      $.ajax({
        url:"ajax-getplan.php?lang=<?php echo $extlg;?>",
        method:"POST",
        data:{planID:planID},
        dataType:"json",
        success:function(data){
          $("#viewplanowner").val(data.userID);
          $("#viewplannamedaily").val(data.plan);
          $("#viewplanstartdate").val(data.startdate);
          $("#viewplanenddate").val(data.enddate);
          document.getElementById("viewplanstatus").value = data.status;
        }
      });
    });

    $(document).on('click', "#closeviewplanmodal", function(){
      modalformrefresh();
      $("#viewplan").modal("hide");
      location.reload();
    });

    function modalformrefresh(){
      $('.after').hide();
      $('.before').show();
      document.getElementById("viewplanform").reset(); 
    }
  });
</script>

<!-- Modal for View Plan-->
<div class="modal" id="viewplan">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-12"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
          <div class="col-1"></div>
          <div class="col-12 col-sm-10 py-4">
            <h4 class="modal-title">View Plan</h4>
            <form class="mt-5" id="viewplanform">
              <div class="form-group">
                <label><h6 class="m-0">OWNER</h6></label>
                <input type="text" class="form-control rounded-0 border" id="viewplanowner" readonly>
              </div>

              <div class="form-group">
                <label><h6 class="m-0">PLAN</h6></label>
                <input type="text" class="form-control rounded-0 border" id="viewplannamedaily" readonly>
              </div>

              <div class="form-group">
                <div class="row">
                  <div class="col">
                    <label><h6 class="m-0">START DATE</h6></label>
                    <input type="text" class="form-control rounded-0 border" id="viewplanstartdate" autocomplete="off" readonly>
                  </div>
                  <div class="col">
                    <label><h6 class="m-0">END DATE</h6></label>
                    <input type="text" class="form-control rounded-0 border" id="viewplanenddate" autocomplete="off" readonly>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label><h6 class="m-0">STATUS</h6></label>
                <select class="form-control rounded-0" id="viewplanstatus" disabled>
                  <option value=""></option>
                  <option value="Stuck"><?php echo $array['stuck']?></option>
                  <option value="Issue"><?php echo $array['issue']?></option>
                  <option value="In Progress"><?php echo $array['inprogress']?></option>
                  <option value="Done"><?php echo $array['done']?></option>
                </select>
              </div>

               <div class="row">
                <div class="col-12 col-xl-6">
                  <div class="form-group">
                    <label for="sel1"><h6 class="m-0">PRIORITY</h6></label>
                    <select class="form-control rounded-0" disabled>
                      <option>--</option>
                      <option selected>High</option>
                      <option>Low</option>
                    </select>
                  </div> 
                </div>
                <div class="col-12 col-xl-6">
                  <div class="form-group">
                    <label><h6 class="m-0">TYPE</h6></label>
                    <select class="form-control rounded-0" disabled>
                      <option>--</option>
                      <option>Site works</option>
                      <option selected>Appointment</option>
                      <option>Business Meeting</option>
                    </select>
                  </div> 
                </div>
              </div>

              <div class="form-group">
                <label><h6 class="m-0">DESCRIPTION</h6></label>
                <textarea class="form-control rounded-0" rows="4" disabled></textarea>
              </div> 

              <div class="form-group">
                <label for="sel1"><h6 class="m-0">TAGS</h6></label>
                <select class="form-control border selectpicker rounded-0" data-live-search="true" data-size="5" multiple disabled>
                  <option data-content="<span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: white; color: #007bff; border-color: #007bff;'>Product</span>" selected></option>
                  <option data-content="<span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: white; color: #007bff; border-color: #007bff;'>Location</span>" selected></option>
                  <option data-content="<span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: white; color: #007bff; border-color: #007bff;'>KL</span>"></option>
                  <option data-content="<span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: white; color: #007bff; border-color: #007bff;'>PJ</span>"></option>
                  <option data-content="<span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: white; color: #007bff; border-color: #007bff;'>Meter</span>"></option>
                </select>
              </div> 
              

            </form>
          </div>
          <div class="col-1"></div>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- Edit Plan-->
<script type="text/javascript">
  $(document).ready(function(){
    $('.delete').hide();

    $(document).on('click', ".editPlan", function(){
      var planID = $(this).data('id');
      $.ajax({
        url:"ajax-getplan.php?lang=<?php echo $extlg;?>",
        method:"POST",
        data:{planID:planID},
        dataType:"json",
        success:function(data){
          $("#editplanid").val(data.id);
          $("#editplanowner").val(data.userID);
          $("#editplannamedaily").val(data.plan);
          $("#editplanstartdate").val(data.startdate);
          $("#editplanenddate").val(data.enddate);
          document.getElementById("editplanstatus").value = data.status;



  
     

        }
      });
    });


    var form = $('#editplanform');
    form.on('submit', function(e){
      e.preventDefault();
      e.stopPropagation();
      var alldata = form.serialize();
      console.log(alldata);
      $.ajax({
        url: "ajax-editplan.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
        success:function(data){
          var obj = JSON.parse(data);
          console.log(obj);
          if(obj.condition === "Passed"){
            $('.before').hide();
            $('.after').show();
          }else{
            checkvalidity("editplannamedailyerror","#editplannamedailyerror", "#editplannamedaily", obj.plan);
            checkvalidity("editplanstartdateerror","#editplanstartdateerror", "#editplanstartdate", obj.startdate);
            checkvalidity("editplanenddateerror","#editplanenddateerror", "#editplanenddate", obj.enddate);
          }
          
        }
      });
    });

    $(document).on('click', "#closeeditplanmodal", function(){
      modalformrefresh();
      $("#viewplan").modal("hide");
      location.reload(); 
      
    });

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

    function modalformrefresh(){
      $('.after').hide();
      $('.before').show();
      document.getElementById("editplanform").reset(); 
      clearform("#editplannamedailyerror", "editplannamedailyerror", "#editplannamedaily");
      clearform("#editplanstartdateerror", "editplanstartdateerror", "#editplanstartdate");
      clearform("#editplanenddateerror", "editplanenddateerror", "#editplanenddate");
      clearform("#editplanstatuserror", "editplanstatuserror", "#editplanstatus");
    }
  });
</script>

<!-- Modal for Edit Plan-->
<div class="modal" id="editplan">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-12"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
          <div class="col-1"></div>
          <div class="col-12 col-sm-10 py-4">
            <h4 class="modal-title">Edit Plan</h4>
            <form class="mt-5" id="editplanform">
              <div class="form-group">
                <label><h6 class="m-0">OWNER</h6></label>
                <input type="hidden" name="editplanid" id="editplanid">
                <input type="text" class="form-control rounded-0" id="editplanowner" name="editplanowner" readonly>
              </div>

              <div class="form-group">
                <label><h6 class="m-0">PLAN</h6></label>
                <input type="text" class="form-control rounded-0" rows="5" id="editplannamedaily" autocomplete="off">
                <small><span id="editplannamedailyerror"></span></small>
              </div>

              <div class="form-group">
                <div class="row">
                  <div class="col">
                    <label><h6 class="m-0">START DATE</h6></label>
                    <input type="text" class="form-control rounded-0" id="editplanstartdate" name="editplanstartdate" autocomplete="off">
                    <small><span id="editplanstartdateerror"></span></small>
                    <script type="text/javascript">
                      $(function () {
                        $('#editplanstartdate').datetimepicker({
                          format:"YYYY-MM-DD HH:mm a"
                        });
                      });
                    </script>
                  </div>
                  <div class="col">
                    <label><h6 class="m-0">END DATE</h6></label>
                    <input type="text" class="form-control rounded-0" id="editplanenddate" name="editplanenddate" autocomplete="off">
                    <small><span id="editplanenddateerror"></span></small>
                    <script type="text/javascript">
                      $(function () {
                        $('#editplanenddate').datetimepicker({
                          format:"YYYY-MM-DD HH:mm a"
                        });
                      });
                    </script>
                  </div>
                </div>
              </div>
              <?php

              ?>
              <div class="form-group">
                <label><h6 class="m-0">STATUS</h6></label>
                <select class="form-control rounded-0" id="editplanstatus">
                  <option value=""></option>
                  <option value="Stuck"><?php echo $array['stuck']?></option>
                  <option value="Issue"><?php echo $array['issue']?></option>
                  <option value="In Progress"><?php echo $array['inprogress']?></option>
                  <option value="Done"><?php echo $array['done']?></option>
                </select>
                <small><span id="editplanstatuserror"></span></small>
              </div>

              <div class="row">
                <div class="col-12 col-xl-6">
                  <div class="form-group">
                    <label for="sel1"><h6 class="m-0">PRIORITY</h6></label>
                    <select class="form-control rounded-0">
                      <option>--</option>
                      <option>High</option>
                      <option>Low</option>
                    </select>
                  </div> 
                </div>
                <div class="col-12 col-xl-6">
                  <div class="form-group">
                    <label><h6 class="m-0">TYPE</h6></label>
                    <select class="form-control rounded-0">
                      <option>--</option>
                      <option>Site works</option>
                      <option>Appointment</option>
                      <option>Business Meeting</option>
                      <option>Others</option>
                    </select>
                  </div> 
                </div>
              </div>

              <div class="form-group">
                <label><h6 class="m-0">DESCRIPTION</h6></label>
                <textarea class="form-control rounded-0 shadow-sm" rows="4"></textarea>
              </div> 

              <div class="form-group">
                <label for="sel1"><h6 class="m-0">TAGS</h6></label>
                <select class="form-control shadow-sm selectpicker rounded-0 border" data-live-search="true" data-size="5" multiple>
                  <option data-content="<span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: white; color: #007bff; border-color: #007bff;'>Product</span>"></option>
                  <option data-content="<span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: white; color: #007bff; border-color: #007bff;'>Location</span>"></option>
                  <option data-content="<span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: white; color: #007bff; border-color: #007bff;'>KL</span>"></option>
                  <option data-content="<span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: white; color: #007bff; border-color: #007bff;'>PJ</span>"></option>
                  <option data-content="<span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: white; color: #007bff; border-color: #007bff;'>Meter</span>"></option>
                </select>
              </div> 
              
              <div class="float-right">
                <button id="editpppbutton" value="editplanbutton" type="submit" class="btn btn-primary">UPDATE</button>
                <button id="deletepppbutton" value="deleteplanbutton" type="submit" class="btn btn-danger">DELETE</button>
              </div>
            </form>
          </div>
          <div class="col-1"></div>
        </div>

      </div>

    </div>
  </div>
</div>



<!-- Delete Plan -->
<script type="text/javascript">
  $(document).ready(function(){
    var form = $('#deleteplanform');

    $(document).on('click', ".deletePlan", function(){
      var planID = $(this).data('id');
      $.ajax({
        url:"ajax-getplan.php?lang=<?php echo $extlg;?>",
        method:"POST",
        data:{planID:planID},
        dataType:"json",
        success:function(data){
          $("#deletePlanID").val(data.id);
        }
      });
    });

    form.on('submit', function(e){
      e.preventDefault();
      e.stopPropagation();
      var alldata = form.serialize();
      console.log(alldata);
      $.ajax({
        url: "ajax-deleteplan.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
        success:function(data){
          var obj = JSON.parse(data);
          console.log(obj);
          if(obj.condition === "Passed"){
            $('.before').hide();
            $('.after').show();     
          }
        }
      });
    });
    
    $(document).on('click', "#closedeleteplanmodal", function(){
      $("#deleteplan").modal("hide");
      modalformrefresh();
      location.reload();
    });

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

    function modalformrefresh(){
      $('.after').hide();
      $('.before').show();
      document.getElementById("deleteplanform").reset(); 
    }


  });
</script>
<div class="modal fade" id="deleteplan">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h6 class="modal-title text-white"><?php echo $array['delete']?> <?php echo $array['plan']?></h6>
        <button type="button" class="close text-white" id="closedeleteplanmodal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="deleteplanform">
          <div class="row">
            <div class="col">
              <?php echo $array['deleteplan']?>
              <input type="hidden" class="form-control" name="deletePlanID" id="deletePlanID">
            </div>
          </div>
          <div class="row">
            <div class="col text-right">
              <button name="submit" type="submit" class="btn btn-primary shadow-sm mx-1">Delete</button>
            </div>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="addtags">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-12"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
          <div class="col-1"></div>
          <div class="col-12 col-sm-10 py-4">
            <h4 class="modal-title">Add Tags</h4>
            <form class="mt-5" id="">
              <div class="form-group">
                <label><h6 class="m-0">TAG NAME</h6></label>
                <input type="text" class="form-control rounded-0">
              </div>
              <div class="form-group">
                <label><h6 class="m-0">TYPE</h6></label>
                <select class="form-control rounded-0">
                  <option>--</option>
                  <option>Location</option>
                  <option>Product</option>
                  <option>Others</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary float-right">SAVE</button>
            </form>
          </div>
          <div class="col-1"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="edittags">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-12"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
          <div class="col-1"></div>
          <div class="col-12 col-sm-10 py-4">
            <h4 class="modal-title">Edit Tags</h4>
            <form class="mt-5" id="">
              <div class="form-group">
                <label><h6 class="m-0">TAG NAME</h6></label>
                <input type="text" class="form-control rounded-0">
              </div>
              <div class="form-group">
                <label><h6 class="m-0">TYPE</h6></label>
                <select class="form-control rounded-0">
                  <option>--</option>
                  <option>Location</option>
                  <option>Product</option>
                  <option>Others</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary float-right">SAVE</button>
            </form>
          </div>
          <div class="col-1"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="deletetags">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-12"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
          <div class="col-1"></div>
          <div class="col-12 col-sm-10 py-4">
            <h4 class="modal-title">Delete Tags</h4>
            <form class="mt-5" id="">
              Are you sure you want to delete the tag?
              <div class="row">
                <div class="col text-right">
                  <button name="submit" type="submit" class="btn btn-primary shadow-sm mx-1">Yes</button>
                </div>
              </div>
            </form>
          </div>
          <div class="col-1"></div>
        </div>
      </div>
    </div>
  </div>
</div>























