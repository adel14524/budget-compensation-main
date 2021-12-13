<!-- Modal for Add Group-->
<!-- Modal for Delete Group-->
<!-- Modal for Edit Group-->
<!-- Modal for show group membership-->

<script type="text/javascript">
  $(document).ready(function(){
    var form = $('#addgroupform');
    form.on('submit', function(e){
      e.preventDefault();
      e.stopPropagation();
      var addgroupname = document.getElementById("addgroupname").value;
      var grouptype = document.getElementById("grouptype").value;
      var groupstatus = document.getElementById("groupstatus").value;
      var addgroupleader = document.getElementById("addgroupleader").value;
      var grouptypegroupname = $("input:radio[name=grouptypegroupname]:checked").val();

      var alldata = 
      {
        addgroupname:addgroupname,
        grouptype:grouptype,
        groupstatus:groupstatus,
        addgroupleader:addgroupleader,
        grouptypegroupname:grouptypegroupname
      };
      if(grouptypegroupname === "Company"){
        var companyunder = document.getElementById("groupcompanyunder").value;
        alldata.companyunder = companyunder;
      }else if(grouptypegroupname === "Group"){
        var groupunder = document.getElementById("groupgroupunder").value;
        alldata.groupunder = groupunder;
      }
   
      console.log(alldata);
      $.ajax({
        url: "ajax-addgroup.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
        success:function(data){
          var obj = JSON.parse(data);
          if(obj.condition === "Passed"){
            $("#adminaddgroup").modal("hide");
            $("#addgroupundercompany").hide();
            $("#addgroupundergroup").hide();
            getgroupsinfo();
          }else{
            checkvalidity("addgroupnameerror","#addgroupnameerror", "#addgroupname", obj.group);
            checkvalidity("grouptypeerror","#grouptypeerror", "#grouptype", obj.type);
            checkvalidity("groupstatuserror","#groupstatuserror", "#groupstatus", obj.status);
            checkvalidity("grouptypegroupnameerror","#grouptypegroupnameerror", "#grouptypegroupname", obj.grouptype);
            if(obj.grouptypename === "Company"){
              checkvalidity("groupcompanyundererror","#groupcompanyundererror", "#groupcompanyunder", obj.companyunder);
            }else if(obj.grouptypename === "Group"){
              checkvalidity("groupgroupundererror","#groupgroupundererror", "#groupgroupunder", obj.groupunder);
            }

          }
        }
      });
    });

    $("#adminaddgroup").on('hidden.bs.modal', function(){
      document.getElementById("addgroupform").reset(); 
      clearform("#addgroupnameerror", "addgroupnameerror", "#addgroupname");
      clearform("#grouptypeerror", "grouptypeerror", "#grouptype");
      clearform("#groupstatuserror", "groupstatuserror", "#groupstatus");
      clearform("#grouptypegroupnameerror", "grouptypegroupnameerror", "#grouptypegroupname");
      clearform("#groupcompanyundererror", "groupcompanyundererror", "#groupcompanyunder");
      clearform("#groupgroupundererror", "groupgroupundererror", "#groupgroupunder");
    });

    function getgroupsinfo(){
      $.ajax({
        url:"ajax-getviewadmingroups.php?lang=<?php echo $extlg;?>",
        success:function(data){
          $("#groupsinfo").html(data);
        }
      });
    }

  });
</script>
<!-- Modal for Add Group-->
<div class="modal fade" id="adminaddgroup">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h6 class="modal-title text-white"><?php echo $array['new']?> <?php echo $array['group']?></h6>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="addgroupform">
          <div class="form-group">
            <div class="row">
              <div class="col-2"><label><?php echo $array['group']?> :</label></div>
              <div class="col">
                <input type="text" class="form-control form-control-sm shadow-sm" id="addgroupname" name="addgroupname">
                <small><span id="addgroupnameerror"></span></small>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-2"><label><?php echo $array['type']?> :</label></div>
              <div class="col">
                <select class="form-control form-control-sm shadow-sm" id="grouptype" name="grouptype">
                  <option value="">--</option>
                  <option value="Department"><?php echo $array['department']?></option>
                  <option value="Team"><?php echo $array['team']?></option>
                  <option value="Project"><?php echo $array['project']?></option>
                  <option value="Campaign"><?php echo $array['campaign']?></option>
                </select>
                <small><span id="grouptypeerror"></span></small>
              </div>
              <div class="col-2"><label><?php echo $array['status']?> :</label></div>
              <div class="col">
                <select class="form-control form-control-sm shadow-sm" id="groupstatus" name="groupstatus">
                  <option value="">--</option>
                  <option value="Active"><?php echo $array['active']?></option>
                  <option value="Not Active"><?php echo $array['notactive']?></option>
                </select>
                <small><span id="groupstatuserror"></span></small>
              </div>
            </div> 
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-2"><label><?php echo $array['leader']?> :</label></div>
              <div class="col">
                <select class="form-control form-control-sm shadow-sm" id="addgroupleader" name="addgroupleader">
                  <option value="">--</option>
                  <?php
                  $userobject = new User();
                  if($resultresult->corporateID){
                    $userresultcorporate = $user->searchChiefToBecomeLeader($resultresult->corporateID, "Chief");
                    if($userresultcorporate){
                      foreach ($userresultcorporate as $row) {
                        ?>
                        <option value="<?php echo $row->userID?>"><?php echo $row->firstname." ".$row->lastname." - ".$row->email;?></option>
                        <?php
                      }
                    }
                    $userresultcompany = $user->searchSuperiorToBecomeLeader($resultresult->corporateID, "Superior");
                    if($userresultcompany){
                      foreach ($userresultcompany as $row) {
                        ?>
                        <option value="<?php echo $row->userID?>"><?php echo $row->firstname." ".$row->lastname?></option>
                        <?php
                      }
                    }
                    $userresult = $userobject->searchManagerToBecomeLeader($resultresult->corporateID, "Manager");
                  }else{

                    $userresultcompany = $user->searchSuperiorToBecomeLeaderCompany($resultresult->companyID, "Superior");
                    if($userresultcompany){
                      foreach ($userresultcompany as $row) {
                        ?>
                        <option value="<?php echo $row->userID?>"><?php echo $row->firstname." ".$row->lastname." - ".$row->email;?></option>
                        <?php
                      }
                    }
                    $userresult = $userobject->searchManagerToBecomeLeaderCompany($resultresult->companyID, "Manager");
                  }
                  
                  if($userresult){
                    foreach ($userresult as $row) {
                      ?>
                      <option value="<?php echo $row->userID;?>"><?php echo $row->firstname." ".$row->lastname." - ".$row->email;?></option>
                      <?php
                    }
                  }
                  ?>
                </select>
                <small><span class="text-secondary"><i><?php echo $array['optional']?></i></span></small>
              </div>
            </div>   
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-2"><label><?php echo $array['group']?> <?php echo $array['type']?> : </label></div>
              <div class="col">
                <div class="row">
                  <div class="col">
                    <div class="custom-control custom-radio">
                      <input type="radio" class="custom-control-input" id="grouptypecompany" name="grouptypegroupname" value="Company">
                      <label class="custom-control-label" for="grouptypecompany"><?php echo $array['company']?></label>
                    </div>
                  </div>
                  <div class="col">
                    <div class="custom-control custom-radio">
                      <input type="radio" class="custom-control-input" id="grouptypegroup" name="grouptypegroupname" value="Group">
                      <label class="custom-control-label" for="grouptypegroup"><?php echo $array['group']?></label>
                    </div>
                  </div>
                </div>
                <small><span id="grouptypegroupnameerror"></span></small>
              </div>
            </div>
          </div>

          <div id="addgroupundercompany">
            <div class="form-group">
              <div class="row">
                <div class="col-2"><label><?php echo $array['company']?> :</label></div>
                <div class="col">
                  <select class="form-control form-control-sm shadow-sm" id="groupcompanyunder" name="groupcompanyunder">
                    <option value="">--</option>
                    <?php
                    if($resultresult->corporateID){
                      $companyobject = new Company();
                      $companyresult = $companyobject->searchCompanyCorporate($resultresult->corporateID);
                      if($companyresult){
                        foreach ($companyresult as $row) {
                          ?>
                          <option value="<?php echo $row->companyID?>"><?php echo $row->company;?></option>
                          <?php
                        }
                      }
                    }else{
                      $companyobject = new Company();
                      $companyresult = $companyobject->searchCompany($resultresult->companyID);
                      ?>
                      <option value="<?php echo $companyresult->companyID?>"><?php echo $companyresult->company;?></option>
                      <?php
                    }
                    ?>
                  </select>
                  <small><span id="groupcompanyundererror"></span></small>
                </div>
              </div>
            </div>
          </div>
          
          <div id="addgroupundergroup">
            <div class="form-group">
              <div class="row">
                <div class="col-2"><label><?php echo $array['group']?> :</label></div>
                <div class="col">
                  <select class="form-control form-control-sm shadow-sm" id="groupgroupunder" name="groupgroupunder">
                    <option value="">--</option>
                    <?php
                    if($resultresult->corporateID){
                      $groupobject = new Group();
                      $groupresult = $groupobject->searchGroupWithCorporate($resultresult->corporateID);
                      if($groupresult){
                        foreach ($groupresult as $row) {
                          ?>
                          <option value="<?php echo $row->groupID?>"><?php echo $row->groups?></option>
                          <?php
                        }
                      }
                    }else{
                      $groupobject = new Group();
                      $groupresult = $groupobject->searchCompany($resultresult->companyID);
                      if($groupresult){
                        foreach ($groupresult as $row) {
                          ?>
                          <option value="<?php echo $row->groupID?>"><?php echo $row->groups?></option>
                          <?php
                        }
                      }
                    }
                    ?>
                  </select>
                  <small><span id="groupgroupundererror"></span></small>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col text-right">
              <button name="submit" value="submit" type="submit" class="btn btn-primary shadow-sm"><?php echo $array['create']?></button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo $array['cancel']?></button>
            </div>
          </div>

          
        </form> 
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    var form = $('#admindeletegroupform');

    $(document).on('click', ".deleteGroup", function(){
      var groupID = $(this).data('id');
      $.ajax({
        url:"ajax-getgroup.php?lang=<?php echo $extlg;?>",
        method:"POST",
        data:{groupID:groupID},
        dataType:"json",
        success:function(data){
          $("#deletegroupid").val(data.id);
        }
      });
    });

    form.on('submit', function(e){
      e.preventDefault();
      e.stopPropagation();
      var deletegroupid = document.getElementById("deletegroupid").value;
      var alldata = 
      {
        deletegroupid:deletegroupid
      };
      console.log(alldata);
      $.ajax({
        url: "ajax-deletegroup.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
        success:function(data){
          var obj = JSON.parse(data);
          console.log(obj);
          if(obj.condition === "Passed"){
            $("#admindeletegroup").modal("hide");
            getgroupsinfo();
          } 
        }
      });
    });

    $("#admindeletegroup").on('hidden.bs.modal', function(){
      document.getElementById("editcompanyform").reset(); 
    });

    function getgroupsinfo(){
      $.ajax({
        url:"ajax-getviewadmingroups.php?lang=<?php echo $extlg;?>",
        success:function(data){
          $("#groupsinfo").html(data);
        }
      });
    }

  
  });  
</script>
<!-- Modal for Delete Group-->
<div class="modal fade" id="admindeletegroup">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h6 class="modal-title text-white" id="scoreboardModalLabel"><?php echo $array['delete']?> <?php echo $array['group']?></h6>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="admindeletegroupform">
          <?php echo $array['deletegroup']?>
          <input type="hidden" name="deletegroupid" id="deletegroupid">
          <div class="row">
            <div class="col text-right">
              <button name="submit" value="submit" type="submit" class="btn btn-primary shadow-sm"><?php echo $array['delete']?></button>
              <button type="button" class="btn btn-danger" data-dismiss="modal" id="closedeletegroup"><?php echo $array['cancel']?></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    var form = $('#editgroupform');

    $(document).on('click', ".editGroup", function(){
      var groupID = $(this).data('id');
      $.ajax({
        url:"ajax-getgroup.php?lang=<?php echo $extlg;?>",
        method:"POST",
        data:{groupID:groupID},
        dataType:"json",
        success:function(data){
          $("#editgroupname").val(data.group);
          $("#editgroupid").val(data.id);
          document.getElementById("editgrouptype").value = data.type;
          document.getElementById("editgroupleader").value = data.leader;
          document.getElementById("editgroupstatus").value = data.status;
          if(data.corporateID){
            if(data.companyID){
              document.getElementById("editgroupcompanyunder").value = data.companyID;
              document.getElementById("editgrouptypecompany").checked = true;
              $("#editgroupundercompany").show();
            }else if(data.parentID){
              document.getElementById("editgroupgroupunder").value = data.parentID;
              document.getElementById("editgrouptypegroup").checked = true;
              $("#editgroupundergroup").show();
            }
          }else{
            if(data.companyID){
              document.getElementById("editgroupcompanyunder").value = data.companyID;
              document.getElementById("editgrouptypecompany").checked = true;
              $("#editgroupundercompany").show();
            }else if(datacompanyID && data.parentID){
              document.getElementById("editgroupgroupunder").value = data.parentID;
              document.getElementById("editgrouptypegroup").checked = true;
              $("#editgroupundergroup").show();
            }
          }

          var button = $('#editgroupbutton');
          var orig = [];

          $.fn.getType = function () {
              return this[0].tagName == "INPUT" ? $(this[0]).attr("type").toLowerCase() : this[0].tagName.toLowerCase();
          }

          $("#editgroupform :input").each(function () {
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

          $('#editgroupform').bind('change keyup', function () {

              var disable = true;
              $("#editgroupform :input").each(function () {
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
      var editgroupid = document.getElementById("editgroupid").value;
      var editgroupname = document.getElementById("editgroupname").value;
      var editgrouptype = document.getElementById("editgrouptype").value;
      var editgroupstatus = document.getElementById("editgroupstatus").value;
      var editgroupleader = document.getElementById("editgroupleader").value;
      var editgrouptypegroupname = $("input:radio[name=editgrouptypegroupname]:checked").val();

      var alldata = 
      {
        editgroupid:editgroupid,
        editgroupname:editgroupname,
        editgrouptype:editgrouptype,
        editgroupstatus:editgroupstatus,
        editgroupleader:editgroupleader,
        editgrouptypegroupname:editgrouptypegroupname
      };

      if(editgrouptypegroupname === "Company"){
        var editcompanyunder = document.getElementById("editgroupcompanyunder").value;
        alldata.editcompanyunder = editcompanyunder;
      }else if(editgrouptypegroupname === "Group"){
        var editgroupunder = document.getElementById("editgroupgroupunder").value;
        alldata.editgroupunder = editgroupunder;
      }
      $.ajax({
        url: "ajax-editgroup.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
        success:function(data){
          var obj = JSON.parse(data);
          console.log(obj);
          if(obj.condition === "Passed"){
            $("#admineditgroup").modal("hide");
            getgroupsinfo();
          }else{
            checkvalidity("editgroupnameerror","#editgroupnameerror", "#editgroupname", obj.group);
            checkvalidity("editgrouptypeerror","#editgrouptypeerror", "#editgrouptype", obj.type);
            checkvalidity("editgroupstatuserror","#editgroupstatuserror", "#editgroupstatus", obj.status);
            checkvalidity("editgrouptypegroupnameerror","#editgrouptypegroupnameerror", "#editgrouptypegroupname", obj.grouptype);
            if(obj.grouptypename === "Company"){
              checkvalidity("editgroupcompanyundererror","#editgroupcompanyundererror", "#editgroupcompanyunder", obj.companyunder);
            }else if(obj.grouptypename === "Group"){
              checkvalidity("editgroupgroupundererror","#editgroupgroupundererror", "#editgroupgroupunder", obj.groupunder);
            }
          }
        }
      });
    });

    $("#admineditgroup").on('hidden.bs.modal', function(){
      $("#editgroupundercompany").hide();
      $("#editgroupundergroup").hide();
      document.getElementById("editgroupform").reset(); 
      clearform("#editgroupnameerror", "editgroupnameerror", "#editgroupname");
      clearform("#editgrouptypeerror", "editgrouptypeerror", "#editgrouptype");
      clearform("#editgroupstatuserror", "editgroupstatuserror", "#editgroupstatus");
      clearform("#editgrouptypegroupnameerror", "editgrouptypegroupnameerror", "#editgrouptypegroupname");
      clearform("#editgroupcompanyundererror", "editgroupcompanyundererror", "#editgroupcompanyunder");
      clearform("#editgroupgroupundererror", "editgroupgroupundererror", "#editgroupgroupunder");
    });

    function getgroupsinfo(){
      $.ajax({
        url:"ajax-getviewadmingroups.php?lang=<?php echo $extlg;?>",
        success:function(data){
          $("#groupsinfo").html(data);
        }
      });
    }

  });  

</script>
<!-- Modal for Edit Group-->
<div class="modal fade" id="admineditgroup">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h6 class="modal-title text-white" id="scoreboardModalLabel"><?php echo $array['edit']?> <?php echo $array['group']?></h6>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="editgroupform">
          <div class="form-group">
            <div class="row">
              <div class="col-2"><label><?php echo $array['group']?> :</label></div>
              <div class="col">
                <input type="hidden" class="form-control form-control-sm shadow-sm" id="editgroupid" name="editgroupid">
                <input type="text" class="form-control form-control-sm shadow-sm" id="editgroupname" name="editgroupname">
                <small><span id="editgroupnameerror"></span></small>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-2"><label><?php echo $array['type']?> :</label></div>
              <div class="col">
                <select class="form-control form-control-sm shadow-sm" id="editgrouptype" name="editgrouptype">
                  <option value="">--</option>
                  <option value="Department"><?php echo $array['department']?></option>
                  <option value="Team"><?php echo $array['team']?></option>
                  <option value="Project"><?php echo $array['project']?></option>
                  <option value="Campaign"><?php echo $array['campaign']?></option>
                </select>
                <small><span id="editgrouptypeerror"></span></small>
              </div>
              <div class="col-2"><label><?php echo $array['status']?> :</label></div>
              <div class="col">
                <select class="form-control form-control-sm shadow-sm" id="editgroupstatus" name="editgroupstatus">
                  <option value="">--</option>
                  <option value="Active"><?php echo $array['active']?></option>
                  <option value="Not Active"><?php echo $array['notactive']?></option>
                </select>
                <small><span id="editgroupstatuserror"></span></small>
              </div>
            </div> 
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-2"><label><?php echo $array['leader']?> :</label></div>
              <div class="col">
                <select class="form-control form-control-sm shadow-sm" id="editgroupleader" name="editgroupleader">
                  <option value="">--</option>
                  <?php
                  $userobject = new User();
                  if($resultresult->corporateID){
                    $userresultcorporate = $user->searchChiefToBecomeLeader($resultresult->corporateID, "Chief");
                    if($userresultcorporate){
                      foreach ($userresultcorporate as $row) {
                        ?>
                        <option value="<?php echo $row->userID?>"><?php echo $row->firstname." ".$row->lastname." - ".$row->email;?></option>
                        <?php
                      }
                    }
                    $userresultcompany = $user->searchSuperiorToBecomeLeader($resultresult->corporateID, "Superior");
                    if($userresultcompany){
                      foreach ($userresultcompany as $row) {
                        ?>
                        <option value="<?php echo $row->userID?>"><?php echo $row->firstname." ".$row->lastname?></option>
                        <?php
                      }
                    }
                    $userresult = $userobject->searchManagerToBecomeLeader($resultresult->corporateID, "Manager");
                  }else{

                    $userresultcompany = $user->searchSuperiorToBecomeLeaderCompany($resultresult->companyID, "Superior");
                    if($userresultcompany){
                      foreach ($userresultcompany as $row) {
                        ?>
                        <option value="<?php echo $row->userID?>"><?php echo $row->firstname." ".$row->lastname." - ".$row->email;?></option>
                        <?php
                      }
                    }
                    $userresult = $userobject->searchManagerToBecomeLeaderCompany($resultresult->companyID, "Manager");
                  }
                  
                  if($userresult){
                    foreach ($userresult as $row) {
                      ?>
                      <option value="<?php echo $row->userID;?>"><?php echo $row->firstname." ".$row->lastname." - ".$row->email;?></option>
                      <?php
                    }
                  }
                  ?>
                </select>
                <small><span class="text-secondary"><i><?php echo $array['optional']?></i></span></small>
              </div>
            </div>   
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-2"><label><?php echo $array['group']?> <?php echo $array['type']?> : </label></div>
              <div class="col">
                <div class="row">
                  <div class="col">
                    <div class="custom-control custom-radio">
                      <input type="radio" class="custom-control-input" id="editgrouptypecompany" name="editgrouptypegroupname" value="Company">
                      <label class="custom-control-label" for="editgrouptypecompany"><?php echo $array['company']?></label>
                    </div>
                  </div>
                  <div class="col">
                    <div class="custom-control custom-radio">
                      <input type="radio" class="custom-control-input" id="editgrouptypegroup" name="editgrouptypegroupname" value="Group">
                      <label class="custom-control-label" for="editgrouptypegroup"><?php echo $array['group']?></label>
                    </div>
                  </div>
                </div>
                <small><span id="editgrouptypegroupnameerror"></span></small>
              </div>
            </div>
          </div>

          <div id="editgroupundercompany">
            <div class="form-group">
              <div class="row">
                <div class="col-2"><label><?php echo $array['company']?> :</label></div>
                <div class="col">
                  <select class="form-control form-control-sm shadow-sm" id="editgroupcompanyunder" name="editgroupcompanyunder">
                    <option value="">--</option>
                    <?php
                    if($resultresult->corporateID){
                      $companyobject = new Company();
                      $companyresult = $companyobject->searchCompanyCorporate($resultresult->corporateID);
                      if($companyresult){
                        foreach ($companyresult as $row) {
                          ?>
                          <option value="<?php echo $row->companyID?>"><?php echo $row->company;?></option>
                          <?php
                        }
                      }
                    }else{
                      $companyobject = new Company();
                      $companyresult = $companyobject->searchCompany($resultresult->companyID);
                      ?>
                      <option value="<?php echo $companyresult->companyID?>"><?php echo $companyresult->company;?></option>
                      <?php
                    }
                    ?>
                  </select>
                  <small><span id="editgroupcompanyundererror"></span></small>
                </div>
              </div>
            </div>
          </div>
          
          <div id="editgroupundergroup">
            <div class="form-group">
              <div class="row">
                <div class="col-2"><label><?php echo $array['group']?> :</label></div>
                <div class="col">
                  <select class="form-control form-control-sm shadow-sm" id="editgroupgroupunder" name="editgroupgroupunder">
                    <option value="">--</option>
                    <?php
                    if($resultresult->corporateID){
                      $groupobject = new Group();
                      $groupresult = $groupobject->searchGroupWithCorporate($resultresult->corporateID);
                      if($groupresult){
                        foreach ($groupresult as $row) {
                          ?>
                          <option value="<?php echo $row->groupID?>"><?php echo $row->groups?></option>
                          <?php
                        }
                      }
                    }else{
                      $groupobject = new Group();
                      $groupresult = $groupobject->searchCompany($resultresult->companyID);
                      if($groupresult){
                        foreach ($groupresult as $row) {
                          ?>
                          <option value="<?php echo $row->groupID?>"><?php echo $row->groups?></option>
                          <?php
                        }
                      }
                    }
                    ?>
                  </select>
                  <small><span id="editgroupgroupundererror"></span></small>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col text-right">
              <button id="editgroupbutton" name="submit" value="submit" type="submit" class="btn btn-primary shadow-sm" disabled><?php echo $array['edit']?></button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo $array['cancel']?></button>
            </div>
          </div>

          
        </form>
      </div>
      
        
     
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click', ".showgroupmember", function(){
      var groupID = $(this).data('id');
      var alldata =
      {
        groupID:groupID
      };
      $.ajax({
        url: "ajax-getgroupmember.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
        dataType:"json",
        success:function(data){
          $("#showmemberID").html(data.html);
          $("#groupname").val(data.name);
        }
      });
    });
  });
</script>
<!-- Modal for show group membership-->
<div class="modal fade" id="adminshowgroupmember">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h6 class="modal-title text-white" id="scoreboardModalLabel"><?php echo $array['group']?> <?php echo $array['membership']?></h6>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="row">
            <div class="col-2"><label><?php echo $array['group']?> :</label></div>
            <div class="col"><input type="text" class="form-control-plaintext form-control-sm" id="groupname" name="groupname" readonly></div>
          </div>
        </div>
        <div class="my-3" id="showmemberID"></div>
        <button type="button" class="btn btn-danger float-right" data-dismiss="modal"><?php echo $array['cancel']?></button>
      </div>
    </div>
  </div>
</div>