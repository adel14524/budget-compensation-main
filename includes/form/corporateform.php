<script type="text/javascript">
  $(document).ready(function(){
    var form = $('#editcorporateform');
    $(document).on('click', ".editCorporate", function(){
      var corporateID = $(this).data('id');
      $.ajax({
        url:"ajax-getcorporate.php?lang=<?php echo $extlg;?>",
        method:"POST",
        data:{corporateID:corporateID},
        dataType:"json",
        success:function(data){
          $("#corporatenamedes").val(data.corporate);
          $("#corporateid").val(data.id);
          document.getElementById("corporateleader").value = data.leader;

          var button = $('#editcorporatebutton');
          var orig = [];

          $.fn.getType = function () {
              return this[0].tagName == "INPUT" ? $(this[0]).attr("type").toLowerCase() : this[0].tagName.toLowerCase();
          }

          $("#editcorporateform :input").each(function () {
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

          $('#editcorporateform').bind('change keyup', function () {

              var disable = true;
              $("#editcorporateform :input").each(function () {
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
      var corporatename = document.getElementById("corporatenamedes").value;
      var corporateleader = document.getElementById("corporateleader").value;
      var corporateID = document.getElementById("corporateid").value;
      var alldata = 
      {
        corporatename:corporatename,
        corporateleader:corporateleader,
        corporateID:corporateID
      };
      $.ajax({
        url: "ajax-editcorporate.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
        success:function(data){
          var obj = JSON.parse(data);
          if(obj.condition === "Passed"){
            $("#admineditcorporate").modal("hide");
            getcorporateinfo();
          }else{
            checkvalidity("corporatenamedeserror","#corporatenamedeserror", "#corporatenamedes", obj.corporate);
            checkvalidity("corporateleadererror","#corporateleadererror", "#corporateleader", obj.leader);
          }
        }
      });
    });

    $("#admineditcorporate").on('hidden.bs.modal', function(){
      document.getElementById("editcorporateform").reset(); 
      clearform("#corporatenamedeserror", "corporatenamedeserror", "#corporatenamedes");
      clearform("#corporateleadererror", "corporateleadererror", "#corporateleader");
    });

    function getcorporateinfo(){
      $.ajax({
        url:"ajax-getviewadmincorporate.php",
        success:function(data){
          $("#corporateinfo").html(data);
        }
      });
    }

  });  
</script>

<div class="modal" id="admineditcorporate">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-12"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
          <div class="col-1"></div>
          <div class="col-12 col-sm-10 py-4">
            <h4 class="modal-title" id="scoreboardModalLabel"><?php echo $array['edit']?> <?php echo $array['corporate']?></h4>
            <form class="mt-5" id="editcorporateform">
              <div class="form-group">
                <label><h6 class="m-0">CORPORATE NAME</h6></label>
                <input type="hidden" class="form-control" id="corporateid">
                <input type="text" class="form-control" id="corporatenamedes" autocomplete="off">
                <small><span id="corporatenamedeserror"></span></small>
              </div>
              <div class="form-group">
                <label><h6 class="m-0">LEADER <i class='fas fa-question-circle text-secondary' data-toggle="tooltip" title="Only Chief level user can become leader."></i></h6></label>
                <select class="form-control" id="corporateleader" name="corporateleader">
                  <?php
                  $userchiefresult = $user->searchChiefToBecomeLeader($resultresult->corporateID, "Chief");
                  if ($userchiefresult) {
                    foreach ($userchiefresult as $row) {
                    ?>
                    <option value="<?php echo $row->userID?>"><?php echo $row->firstname." ".$row->lastname;?></option>
                    <?php
                    }
                  }
                  ?>
                </select>     
                <small><span id="corporateleadererror"></span></small>  
              </div>
              <div class="row">
                <div class="col text-right">
                  <button id="editcorporatebutton" name="submit" value="submit" type="submit" class="btn btn-primary shadow-sm" disabled>SAVE</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">CANCEL</button>
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