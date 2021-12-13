<!-- Modal for Add Company-->
<!-- Modal for Delete Company-->
<!-- Modal for Edit Company-->
<!-- Modal for show company membership-->
<?php
if($resultresult->corporateID){
?>
<script type="text/javascript">
  $(document).ready(function(){
    var form = $('#addcompanyform');
    form.on('submit', function(e){
      e.preventDefault();
      e.stopPropagation();
      var addcompanyname = document.getElementById("addcompanyname").value;
      var addcompanyleader = document.getElementById("addcompanyleader").value;
      var companystatus = document.getElementById("companystatus").value;
      var alldata = 
      {
        addcompanyname:addcompanyname,
        addcompanyleader:addcompanyleader,
        companystatus:companystatus
      };
      console.log(alldata);
      $.ajax({
        url: "ajax-addcompany.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
        success:function(data){
          var obj = JSON.parse(data);
          console.log(obj);
          if(obj.condition === "Passed"){
            $("#adminaddcompany").modal("hide");
            getcompaniesinfo();
          }else{
            checkvalidity("addcompanynameerror","#addcompanynameerror", "#addcompanyname", obj.company);
            checkvalidity("companystatuserror","#companystatuserror", "#companystatus", obj.status);
          }
        }
      });
    });
    

    $("#adminaddcompany").on('hidden.bs.modal', function(){
      document.getElementById("addcompanyform").reset(); 
      clearform("#addcompanynameerror", "addcompanynameerror", "#addcompanyname");
      clearform("#companystatuserror", "companystatuserror", "#companystatus");
    });
  });
</script>
<!-- Modal for Add Company-->
<div class="modal" id="adminaddcompany">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-12"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
          <div class="col-1"></div>
          <div class="col-12 col-sm-10 py-4">
            <h4 class="modal-title"><?php echo $array['new']?> <?php echo $array['company']?></h4>
            <form class="mt-5" id="addcompanyform">
              <div class="form-group">
                <label><h6 class="m-0">COMPANY NAME</h6></label>
                <input type="text" class="form-control" id="addcompanyname" autocomplete="off">
                <small><span id="addcompanynameerror"></span></small>
              </div>
              <div class="form-group">
                <label><h6 class="m-0">LEADER <i class='fas fa-question-circle text-secondary' data-toggle="tooltip" title="Only Superior or higher level user can become leader."></i></h6></label>
                <select class="form-control" id="addcompanyleader" name="addcompanyleader">
                  <option value="">--</option>
                  <?php
                  $user = new User();
                  $userresult = $user->searchChiefToBecomeLeader($resultresult->corporateID, "Chief");
                  if($userresult){
                    foreach ($userresult as $row) {
                      ?>
                      <option value="<?php echo $row->userID?>"><?php echo $row->firstname." ".$row->lastname?></option>
                      <?php
                    }
                  }
                  ?>
                  <?php
                  $user = new User();
                  $userresult = $user->searchSuperiorToBecomeLeader($resultresult->corporateID, "Superior");
                  if($userresult){
                    foreach ($userresult as $row) {
                      ?>
                      <option value="<?php echo $row->userID?>"><?php echo $row->firstname." ".$row->lastname?></option>
                      <?php
                    }
                  }
                  ?>
                </select>
                <small><span class="text-secondary"><i><?php echo $array['optional']?></i></span></small>
              </div>
              <div class="form-group">
                <label><h6 class="m-0">STATUS</h6></label>
                <select class="form-control" id="companystatus">
                  <option value="">--</option>
                  <option value="Active"><?php echo $array['active']?></option>
                  <option value="Not Active"><?php echo $array['notactive']?></option>
                </select>
                <small><span id="companystatuserror"></span></small>
              </div>
              <div class="row">
                <div class="col text-right">
                  <button name="submit" value="submit" type="submit" class="btn btn-primary shadow-sm">CREATE</button>
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
<?php
}else{
  
}
?>

<script type="text/javascript">
  $(document).ready(function(){
    var form = $('#editcompanyform');

    $(document).on('click', ".editCompany", function(){
      var companyID = $(this).data('id');
      $.ajax({
        url:"ajax-getcompany.php?lang=<?php echo $extlg;?>",
        method:"POST",
        data:{companyID:companyID},
        dataType:"json",
        success:function(data){
          console.log(data);
          $("#editcompanyname").val(data.company);
          $("#editcompanyid").val(data.id);
          document.getElementById("editcompanyleader").value = data.leader;
          <?php
          if($resultresult->corporateID){
            ?>
          document.getElementById("editcompanystatus").value = data.status;
            <?php
          }
          ?>

          var button = $('#editcompanybutton');
          var orig = [];

          $.fn.getType = function () {
              return this[0].tagName == "INPUT" ? $(this[0]).attr("type").toLowerCase() : this[0].tagName.toLowerCase();
          }

          $("#editcompanyform :input").each(function () {
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

          $('#editcompanyform').bind('change keyup', function () {

              var disable = true;
              $("#editcompanyform :input").each(function () {
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
      var editcompanyname = document.getElementById("editcompanyname").value;
      var editcompanyleader = document.getElementById("editcompanyleader").value;
      var editcompanyid = document.getElementById("editcompanyid").value;
      <?php
      if($resultresult->corporateID){
        ?>
          var editcompanystatus = document.getElementById("editcompanystatus").value;
        <?php
      }else{
        ?>
        var editcompanystatus = "Active";
        <?php
      }
      ?>
      
      var alldata = 
      {
        editcompanyname:editcompanyname,
        editcompanyleader:editcompanyleader,
        editcompanyid:editcompanyid,
        editcompanystatus:editcompanystatus
      };
      $.ajax({
        url: "ajax-editcompany.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
        success:function(data){
          var obj = JSON.parse(data);
          if(obj.condition === "Passed"){
            $("#admineditcompany").modal("hide");
            getcompaniesinfo();
          }else{
            checkvalidity("editcompanynameerror","#editcompanynameerror", "#editcompanyname", obj.company);
            checkvalidity("editcompanyleadererror","#editcompanyleadererror", "#editcompanyleadererror", obj.leader);
            checkvalidity("editcompanystatuserror","#editcompanystatuserror", "#editcompanystatus", obj.status);
          }
        }
      });
    });
    
    $("#admineditcompany").on('hidden.bs.modal', function(){
      document.getElementById("editcompanyform").reset(); 
      clearform("#editcompanynameerror", "editcompanynameerror", "#editcompanyname");
      clearform("#editcompanyleadererror", "editcompanyleadererror", "#editcompanyleader");
      clearform("#editcompanystatuserror", "editcompanystatuserror", "#editcompanystatus");
    });
    
  });  

</script>
<!-- Modal for Edit Company-->
<div class="modal fade" id="admineditcompany">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-12"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
          <div class="col-1"></div>
          <div class="col-12 col-sm-10 py-4">
            <h4 class="modal-title"><?php echo $array['edit']?> <?php echo $array['company']?></h4>
            <form class="mt-5" id="editcompanyform">
              <div class="form-group">
                <label><h6 class="m-0">COMPANY NAME</h6></label>
                <input type="hidden" class="form-control form-control-sm shadow-sm" id="editcompanyid" name="editcompanyid">
                <input type="text" class="form-control" id="editcompanyname" autocomplete="off">
                <small><span id="editcompanynameerror"></span></small>
              </div>
              <div class="form-group">
                <label><h6 class="m-0">LEADER <i class='fas fa-question-circle text-secondary' data-toggle="tooltip" title="Only Superior or higher level user can become leader."></i></h6></label>
                <select class="form-control" id="editcompanyleader">
                  <option value="">--</option>
                  <?php
                  if($resultresult->corporateID){
                    $userresult = $user->searchChiefToBecomeLeader($resultresult->corporateID, "Chief");
                    if($userresult){
                      foreach ($userresult as $row) {
                        ?>
                        <option value="<?php echo $row->userID?>"><?php echo $row->firstname." ".$row->lastname?></option>
                        <?php
                      }
                    }
                    $usersuperiorresult = $user->searchSuperiorToBecomeLeader($resultresult->corporateID, "Superior");
                  }else{
                    $usersuperiorresult = $user->searchSuperiorToBecomeLeaderCompany($resultresult->companyID, "Superior");
                  }
                  
                  if ($usersuperiorresult) {
                    foreach ($usersuperiorresult as $row) {
                    ?>
                    <option value="<?php echo $row->userID?>"><?php echo $row->firstname." ".$row->lastname." - ".$row->email?></option>
                    <?php
                    }
                  }
                  ?>
                </select>
                <small><span id="editcompanyleadererror"></span></small>
              </div>
              <?php
              if($resultresult->corporateID){
                ?>
                <div class="form-group">
                  <label><h6 class="m-0">STATUS</h6></label>
                    <select class="form-control" id="editcompanystatus">
                      <option value="">--</option>
                      <option value="Active"><?php echo $array['active']?></option>
                      <option value="Not Active"><?php echo $array['notactive']?></option>
                    </select>
                    <small><span id="editcompanystatuserror"></span></small>
                </div>
                <?php
              }
              ?>
              
              <div class="row">
                <div class="col text-right">
                  <button id="editcompanybutton" name="submit" value="submit" type="submit" class="btn btn-primary shadow-sm" disabled>EDIT</button>
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

<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click', ".showcompanymember", function(){
      var companyID = $(this).data('id');
      var alldata = "companyID="+companyID;
      $.ajax({
        url: "ajax-getcompanymember.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
        dataType:"json",
        success:function(data){
          $("#showcompanymemberID").html(data.html);
          $("#showcompanyname").val(data.name);
        }
      });
    });
  });
</script>
<!-- Modal for show company membership-->
<div class="modal fade" id="adminshowcompanymember">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h6 class="modal-title text-white" id="scoreboardModalLabel"><?php echo $array['company']?> <?php echo $array['membership']?></h6>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">

        <div class="form-group">
          <div class="row">
            <div class="col-2"><label><?php echo $array['company']?> :</label></div>
            <div class="col">
              <input type="text" class="form-control-plaintext form-control-sm" id="showcompanyname" name="showcompanyname" readonly>
            </div>
          </div>
        </div>
        <div class="my-3" id="showcompanymemberID"></div>
        <button type="button" class="btn btn-danger float-right" data-dismiss="modal"><?php echo $array['no']?></button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function(){
    var form = $('#admindeletecompanyform');

    $(document).on('click', ".deleteCompany", function(){
      var companyID = $(this).data('id');
      $.ajax({
        url:"ajax-getcompany.php?lang=<?php echo $extlg;?>",
        method:"POST",
        data:{companyID:companyID},
        dataType:"json",
        success:function(data){
          $("#deletecompanyid").val(data.id);
        }
      });
    });

    form.on('submit', function(e){
      e.preventDefault();
      e.stopPropagation();
      var deletecompanyid = document.getElementById("deletecompanyid").value;
      var alldata = 
      {
        deletecompanyid:deletecompanyid
      };
      $.ajax({
        url: "ajax-deletecompany.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
        success:function(data){
          var obj = JSON.parse(data);
          if(obj.condition === "Passed"){
            $("#admindeletecompany").modal("hide");
            getcompaniesinfo();
          }
        }
      });
    });

    $("#admindeletecompany").on('hidden.bs.modal', function(){
      document.getElementById("editcompanyform").reset(); 
      clearform("#editcompanynameerror", "editcompanynameerror", "#editcompanyname");
    });
   
  });  
</script>
<div class="modal fade" id="admindeletecompany">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-12"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
          <div class="col-1"></div>
          <div class="col-12 col-sm-10 py-4">
            <h4 class="modal-title"><?php echo $array['delete']?> <?php echo $array['company']?></h4>

            <form class="mt-5" id="admindeletecompanyform">
              <div class="row">
                <div class="col">
                  <?php echo $array['deletecompany']?>
                </div>
              </div>
              <input type="hidden" id="deletecompanyid" name="deletecompanyid">
              <div class="row">
                <div class="col text-right">
                  <button name="submit" value="submit" type="submit" class="btn btn-primary shadow-sm"><?php echo $array['delete']?></button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal" id="closedeleteentitymodal"><?php echo $array['cancel']?></button>
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