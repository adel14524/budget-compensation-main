
<script type="text/javascript">
  $(document).ready(function(){
    $('.after').hide();
    var form = $('#addtimeframeform');
    form.on('submit', function(e){
      e.preventDefault();
      e.stopPropagation();
      var timeframedes = document.getElementById("timeframedes").value;
      var timeframestartdate = document.getElementById("timeframestartdate").value;
      var timeframeenddate = document.getElementById("timeframeenddate").value;
      var timeframestatusad = document.getElementById("timeframestatusad").value;
      var alldata = 
      {
        timeframedes:timeframedes,
        timeframestartdate:timeframestartdate,
        timeframeenddate:timeframeenddate,
        timeframestatusad:timeframestatusad,

      };
      console.log(alldata);
      $.ajax({
        url: "ajax-addtimeframe.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
        success:function(data){
          var obj = JSON.parse(data);
          console.log(obj);
          if(obj.condition === "Passed"){
            $("#addtimeframemodal").modal("hide");
            gettimeframeinfo();
          }else{
            checkvalidity("timeframeerror","#timeframeerror", "#timeframedes", obj.timeframe);
            checkvalidity("timeframestartdateerror","#timeframestartdateerror", "#timeframestartdate", obj.startdate);
            checkvalidity("timeframeenddateerror","#timeframeenddateerror", "#timeframeenddate", obj.enddate);
            checkvalidity("timeframestatusaderror","#timeframestatusaderror", "#timeframestatusad", obj.status);
          }
        }
      });
    });

    $("#addtimeframemodal").on('hidden.bs.modal', function(){
      document.getElementById("addtimeframeform").reset(); 
      clearform("#timeframeerror", "timeframeerror", "#timeframedes");
      clearform("#timeframestartdateerror", "timeframestartdateerror", "#timeframestartdate");
      clearform("#timeframeenddateerror", "timeframeenddateerror", "#timeframeenddate");
      clearform("#timeframestatusaderror", "timeframestatusaderror", "#timeframestatusad");
    });

    function gettimeframeinfo(){
      $.ajax({
        url:"ajax-getviewadmintimeframes.php?lang=<?php echo $extlg;?>",
        success:function(data){
          $("#timeframesinfo").html(data);
        }
      });
    }

  });
</script>
<div class="modal fade" id="addtimeframemodal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h6 class="modal-title text-white" id="activitiesModalLabel"><?php echo $array['new']?> <?php echo $array['timeframe']?></h6>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="addtimeframeform">
          <div class="form-group">
            <div class="row">
              <div class="col-2"><label><?php echo $array['timeframe']?> :</label></div>
              <div class="col">
                <input type="text" class="form-control form-control-sm shadow-sm" id="timeframedes" name="timeframedes" autocomplete="off">
                <small><span id="timeframeerror"></span></small>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-2"><label><?php echo $array['startdate']?> :</label></div>
              <div class="col">
                <input type="text" class="form-control form-control-sm" id="timeframestartdate" name="timeframestartdate" autocomplete="off">
                <small><span id="timeframestartdateerror"></span></small>
                <script type="text/javascript">
                  $(function () {
                    $('#timeframestartdate').datetimepicker({
                      format:"YYYY-MM-DD"
                    });
                  });
                </script>
              </div>
              <div class="col-2"><label><?php echo $array['enddate']?> :</label></div>
              <div class="col">
                <input type="text" class="form-control form-control-sm" id="timeframeenddate" name="timeframeenddate" autocomplete="off">
                <small><span id="timeframeenddateerror"></span></small>
                <script type="text/javascript">
                  $(function () {
                    $('#timeframeenddate').datetimepicker({
                      format:"YYYY-MM-DD"
                    });

                    $("#timeframestartdate").on("dp.change", function (e) {
                      $('#timeframeenddate').data("DateTimePicker").minDate(e.date);
                    });
                    $("#timeframeenddate").on("dp.change", function (e) {
                        $('#timeframestartdate').data("DateTimePicker").maxDate(e.date);
                    });
                  });
                </script>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-2"><label><?php echo $array['status']?> :</label></div>
              <div class="col">
                <select class="form-control form-control-sm shadow-sm" id="timeframestatusad" name="timeframestatusad">
                  <option value="">--</option>
                  <option value="Active"><?php echo $array['active']?></option>
                  <option value="Not Active"><?php echo $array['notactive']?></option>
                </select>
                <small><span id="timeframestatusaderror"></span></small>
              </div>
            </div>
          </div>

          <button name="submittimeframe" value="submittimeframe" type="submit" class="btn btn-primary shadow-sm float-right"><?php echo $array['create']?></button>
        </form>
        
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
  $(document).ready(function(){
    $('.after').hide();
    var form = $('#edittimeframeform');

    $(document).on('click', ".editTimeframe", function(){
      var timeframeID = $(this).data('id');
      $.ajax({
        url:"ajax-gettimeframe.php?lang=<?php echo $extlg;?>",
        method:"POST",
        data:{timeframeID:timeframeID},
        dataType:"json",
        success:function(data){
          $("#edittimeframeid").val(data.id);
          $("#edittimeframedes").val(data.timeframe);
          $("#edittimeframestartdate").val(data.startdate);
          $("#edittimeframeenddate").val(data.enddate);
          document.getElementById("edittimeframestatusad").value = data.status;

          var button = $('#edittimeframebutton');
          var orig = [];

          $.fn.getType = function () {
              return this[0].tagName == "INPUT" ? $(this[0]).attr("type").toLowerCase() : this[0].tagName.toLowerCase();
          }

          $("#edittimeframeform :input").each(function () {
              var type = $(this).getType();
              var tmp = {
                  'type': type,
                  'value': $(this).val()
              };
              if (type == 'radio') {
                  tmp.checked = $(this).is(':checked');
              }
              orig[$(this).attr('id')] = tmp;
          });

          $('#edittimeframeform').bind('change keyup', function () {

              var disable = true;
              $("#edittimeframeform :input").each(function () {
                  var type = $(this).getType();
                  var id = $(this).attr('id');

                  if (type == 'text' || type == 'select' || type == 'number') {
                      disable = (orig[id].value == $(this).val());
                  } else if (type == 'radio' || type == 'checkbox') {
                      disable = (orig[id].checked == $(this).is(':checked'));
                  }

                  if (!disable) {
                      return false; // break out of loop
                  }
              });

              button.prop('disabled', disable);
          });

        }
      });
    });

    form.on('submit', function(e){
      e.preventDefault();
      e.stopPropagation();
      var edittimeframeid = document.getElementById("edittimeframeid").value;
      var edittimeframedes = document.getElementById("edittimeframedes").value;
      var edittimeframestartdate = document.getElementById("edittimeframestartdate").value;
      var edittimeframeenddate = document.getElementById("edittimeframeenddate").value;
      var edittimeframestatusad = document.getElementById("edittimeframestatusad").value;
      var alldata = 
      {
        edittimeframeid:edittimeframeid,
        edittimeframedes:edittimeframedes,
        edittimeframestartdate:edittimeframestartdate,
        edittimeframeenddate:edittimeframeenddate,
        edittimeframestatusad:edittimeframestatusad
      };
      console.log(alldata);
      $.ajax({
        url: "ajax-edittimeframe.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
        success:function(data){
          var obj = JSON.parse(data);
          console.log(obj);
          if(obj.condition === "Passed"){
            $("#edittimeframemodal").modal("hide");
            gettimeframeinfo();
          }else{
            checkvalidity("edittimeframeerror","#edittimeframeerror", "#edittimeframedes", obj.timeframe);
            checkvalidity("edittimeframestartdateerror","#edittimeframestartdateerror", "#edittimeframestartdate", obj.startdate);
            checkvalidity("edittimeframeenddateerror","#edittimeframeenddateerror", "#edittimeframeenddate", obj.enddate);
            checkvalidity("edittimeframestatusaderror","#edittimeframestatusaderror", "#edittimeframestatusad", obj.status);
          }
        }
      });
    });

    $("#edittimeframemodal").on('hidden.bs.modal', function(){
      document.getElementById("edittimeframeform").reset(); 
      clearform("#edittimeframeerror", "edittimeframeerror", "#edittimeframedes");
      clearform("#edittimeframestartdateerror", "edittimeframestartdateerror", "#edittimeframestartdate");
      clearform("#edittimeframeenddateerror", "edittimeframeenddateerror", "#edittimeframeenddate");
      clearform("#edittimeframestatusaderror", "edittimeframestatusaderror", "#edittimeframestatusad");
    });

    function gettimeframeinfo(){
      $.ajax({
        url:"ajax-getviewadmintimeframes.php?lang=<?php echo $extlg;?>",
        success:function(data){
          $("#timeframesinfo").html(data);
        }
      });
    }
  });
</script>
<div class="modal fade" id="edittimeframemodal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h6 class="modal-title text-white" id="activitiesModalLabel"><?php echo $array['edit']?> <?php echo $array['timeframe']?></h6>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="edittimeframeform">
          <div class="form-group">
            <div class="row">
              <div class="col-2"><label><?php echo $array['timeframe']?> :</label></div>
              <div class="col">
                <input type="hidden" id="edittimeframeid" name="edittimeframeid">
                <input type="text" class="form-control form-control-sm shadow-sm" id="edittimeframedes" name="edittimeframedes" autocomplete="off">
                <small><span id="edittimeframeerror"></span></small>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-2"><label><?php echo $array['startdate']?> :</label></div>
              <div class="col">
                <input type="text" class="form-control form-control-sm" id="edittimeframestartdate" name="edittimeframestartdate" autocomplete="off">
                <small><span id="edittimeframestartdateerror"></span></small>
                <script type="text/javascript">
                  $(function () {
                    $('#edittimeframestartdate').datetimepicker({
                      format:"YYYY-MM-DD"
                    });
                  });
                </script>
              </div>
              <div class="col-2"><label><?php echo $array['enddate']?> :</label></div>
              <div class="col">
                <input type="text" class="form-control form-control-sm" id="edittimeframeenddate" name="edittimeframeenddate" autocomplete="off">
                <small><span id="edittimeframeenddateerror"></span></small>
                <script type="text/javascript">
                  $(function () {
                    $('#edittimeframeenddate').datetimepicker({
                      format:"YYYY-MM-DD"
                    });

                    $("#edittimeframestartdate").on("dp.change", function (e) {
                      $('#edittimeframeenddate').data("DateTimePicker").minDate(e.date);
                    });
                    $("#edittimeframeenddate").on("dp.change", function (e) {
                        $('#edittimeframestartdate').data("DateTimePicker").maxDate(e.date);
                    });
                  });
                </script>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-2"><label><?php echo $array['status']?> :</label></div>
              <div class="col">
                <select class="form-control form-control-sm shadow-sm" id="edittimeframestatusad" name="edittimeframestatusad">
                  <option value="">--</option>
                  <option value="Active"><?php echo $array['active']?></option>
                  <option value="Not Active"><?php echo $array['notactive']?></option>
                </select>
                <small><span id="edittimeframestatusaderror"></span></small>
              </div>
            </div>
          </div>

          <button name="submitedittimeframe" id="edittimeframebutton" value="submitedittimeframe" type="submit" class="btn btn-primary shadow-sm float-right" disabled><?php echo $array['create']?></button>
        </form>
        
      </div>
    </div>
  </div>
</div>




<script type="text/javascript">
  $(document).ready(function(){
    var form = $('#admindeletetimeframeform');

    $(document).on('click', ".deleteTimeframe", function(){
      var timeframeID = $(this).data('id');
      $.ajax({
        url:"ajax-gettimeframe.php?lang=<?php echo $extlg;?>",
        method:"POST",
        data:{timeframeID:timeframeID},
        dataType:"json",
        success:function(data){
          $("#admindeletetimeframeiddes2").val(data.id);
        }
      });
    });

    form.on('submit', function(e){
      e.preventDefault();
      e.stopPropagation();
      var admindeletetimeframeiddes2 = document.getElementById("admindeletetimeframeiddes2").value;
      var alldata = 
      {
        admindeletetimeframeiddes2:admindeletetimeframeiddes2
      };
      console.log(alldata);
      $.ajax({
        url: "ajax-deletetimeframe.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
        success:function(data){
          var obj = JSON.parse(data);
          console.log(obj);
          if(obj.condition === "Passed"){
            $("#admindeletetimeframe").modal("hide");
            gettimeframeinfo();
          }
        }
      });
    });

    $("#admindeletetimeframe").on('hidden.bs.modal', function(){
      document.getElementById("admindeletetimeframeform").reset(); 
    });

    function gettimeframeinfo(){
      $.ajax({
        url:"ajax-getviewadmintimeframes.php?lang=<?php echo $extlg;?>",
        success:function(data){
          $("#timeframesinfo").html(data);
        }
      });
    }
  });  
</script>

<div class="modal fade" id="admindeletetimeframe">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h6 class="modal-title text-white" id="activitiesModalLabel"><?php echo $array['delete']?> <?php echo $array['timeframe']?></h6>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="admindeletetimeframeform">
          <?php echo $array['deletetimeframe']?>
          <br><small><?php echo $array['deletetimeframeexplain']?></small>
          <input type="hidden" name="admindeletetimeframeiddes2" id="admindeletetimeframeiddes2">
          <div class="row">
            <div class="col text-right">
              <button name="submit" value="submit" type="submit" class="btn btn-primary shadow-sm"><?php echo $array['delete']?></button>
              <button type="button" class="btn btn-danger" data-dismiss="modal" id="closedeletetimeframemodal"><?php echo $array['cancel']?></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>