<!--Modal for Add User-->
<!-- Modal for Delete User-->
<!-- Modal for Edit User-->

<script type="text/javascript">
  $(document).ready(function(){
    $('.userfull').hide();
    var form = $('#adduserform');
    form.on('submit', function(e){
      e.preventDefault();
      e.stopPropagation();
      var adduserfirstname = document.getElementById("adduserfirstname").value;
      var adduserlastname = document.getElementById("adduserlastname").value;
      var adduseremail = document.getElementById("adduseremail").value;
      var adduserjobposition = document.getElementById("adduserjobposition").value;
      var createthemselve = document.getElementById("createthemselve").checked;
      <?php
      if($resultresult->corporateID){
        ?>
        var addusercompany = document.getElementById("addusercompany").value;
        <?php
      }else{
        ?>
        var addusercompany = <?php echo $resultresult->companyID?>;
        <?php
      }
      ?>
      var addusergroup = document.getElementById("addusergroup");
      var str='';
      for (i=0;i< addusergroup.length;i++) { 
          if(addusergroup[i].selected){
              str += addusergroup[i].value + ','; 
          }
      } 
      var str=str.slice(0,str.length -1);
      var adduserrole = document.getElementById("adduserrole").value;
      var asadmin = document.getElementById("asadmin").checked;
      var assupervisor = document.getElementById("assupervisor").checked;
      
      var alldata = 
      {
        adduserfirstname:adduserfirstname,
        adduserlastname:adduserlastname,
        adduserjobposition:adduserjobposition,
        adduseremail:adduseremail,
        addusercompany:addusercompany,
        addusergroup:str,
        adduserrole:adduserrole,
        asadmin:asadmin,
        assupervisor:assupervisor,
        createthemselve:createthemselve
      };
      $.ajax({
        url: "ajax-adduser.php",
        type: "POST",
        data: alldata,
        success:function(data){
          var obj = JSON.parse(data);
          if(obj.exceed === "You have exceed max number of user."){
            $('.before').hide();
            $('.userfull').show();
          }
          if(obj.condition === "Passed"){
            $("#adminadduser").modal("hide");
            getusersinfo();
          }else{
            checkvalidity("adduserfirstnameerror","#adduserfirstnameerror", "#adduserfirstname", obj.firstname);
            checkvalidity("adduserlastnameerror","#adduserlastnameerror", "#adduserlastname", obj.lastname);
            checkvalidity("adduserjobpositionerror","#adduserjobpositionerror", "#adduserjobposition", obj.jobposition);
            checkvalidity("adduseremailerror","#adduseremailerror", "#adduseremail", obj.email);
            checkvalidity("adduserroleerror","#adduserroleerror", "#adduserrole", obj.role);
          }
        }
      });
    });
    
    $("#adminadduser").on('hidden.bs.modal', function(){
      document.getElementById("adduserform").reset(); 
      $('.userfull').hide();
      clearform("#adduserfirstnameerror", "adduserfirstnameerror", "#adduserfirstname");
      clearform("#adduserlastnameerror", "adduserlastnameerror", "#adduserlastname");
      clearform("#adduserjobpositionerror", "adduserjobpositionerror", "#adduserjobposition");
      clearform("#adduseremailerror", "adduseremailerror", "#adduseremail");
      clearform("#adduserroleerror", "adduserroleerror", "#adduserrole");
    });

    function getusersinfo(){
      $.ajax({
        url:"ajax-getviewadminusers.php?lang=<?php echo $extlg;?>",
        success:function(data){
          $("#usersinfo").html(data);
        }
      });
    }

  });
</script>
<!--Modal for Add User-->
<div class="modal fade" id="adminadduser">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h6 class="modal-title text-white" id="scoreboardModalLabel"><?php echo $array['new']?> <?php echo $array['user']?></h6>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="before">
          <form id="adduserform">

            <div class="form-group">
              <div class="row">
                <div class="col-2"><label><?php echo $array['firstname']?> :</label></div>
                <div class="col">
                  <input type="text" class="form-control form-control-sm shadow-sm" id="adduserfirstname" name="adduserfirstname" autocomplete="off">
                  <small><span id="adduserfirstnameerror"></span></small>
                </div>
                <div class="col-2"><label><?php echo $array['lastname']?> :</label></div>
                <div class="col">
                  <input type="text" class="form-control form-control-sm shadow-sm" id="adduserlastname" name="adduserlastname" autocomplete="off">
                  <small><span id="adduserlastnameerror"></span></small>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row">
                <div class="col-2"><label><?php echo $array['email']?> :</label></div>
                <div class="col">
                  <input type="text" class="form-control form-control-sm shadow-sm" id="adduseremail" name="adduseremail" autocomplete="off">
                  <small><span id="adduseremailerror"></span></small>
                </div>
                <div class="col-2"><label><?php echo $array['jobposition']?> :</label></div>
                <div class="col">
                  <input type="text" class="form-control form-control-sm shadow-sm" id="adduserjobposition" name="adduserjobposition" autocomplete="off">
                  <small><span id="adduserjobpositionerror"></span></small>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row">
                <div class="col">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="createthemselve" name="createthemselve">
                    <label class="custom-control-label" for="createthemselve">Let user create their own password</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row">
                
                <div class="col-2"><label><?php echo $array['role']?> :</label></div>
                <div class="col-4">
                  <select class="form-control form-control-sm shadow-sm" id="adduserrole" name="adduserrole">
                    <option value="">--</option>
                    <?php
                    if($resultresult->corporateID){
                    ?>
                    <option value="Chief"><?php echo $array['chief']?></option>
                    <?php
                    }
                    ?>
                    <option value="Superior"><?php echo $array['superior']?></option>
                    <option value="Manager"><?php echo $array['manager']?></option>
                    <option value="Personal"><?php echo $array['personal']?></option>
                  </select>
                  <small><span id="adduserroleerror"></span></small>
                </div>
                <div class="col">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="asadmin" name="asadmin">
                    <label class="custom-control-label" for="asadmin"><?php echo $array['admin']?></label>
                  </div>
                  <small><span id="adduseradminerror"></span></small>
                </div>
                <div class="col">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="assupervisor" name="assupervisor">
                    <label class="custom-control-label" for="assupervisor"><?php echo $array['supervisor']?></label>
                  </div>
                  <small><span id="adduseradminerror"></span></small>
                </div>
              </div>
              
              
            </div>

            <?php
            if($resultresult->corporateID){
            ?>
            <div class="form-group">
              <div class="row">
                <div class="col-2"><label><?php echo $array['company']?> :</label></div>
                <div class="col">
                  <select class="form-control form-control-sm shadow-sm" id="addusercompany" name="addusercompany">
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
                      }
                    ?>
                  </select>
                  <small><span class="text-secondary"><i><?php echo $array['optional']?></i></span></small>
                </div>
              </div>
            </div>
            <?php
            }
            ?>
            <div class="form-group">
              <div class="row">
                <div class="col-2"><label><?php echo $array['group']?> :</label></div>
                <div class="col">
                  <select class="form-control form-control-sm shadow-sm border selectpicker" id="addusergroup" name="addusergroup" multiple>
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
                  <small><span class="text-secondary"><i><?php echo $array['optional']?></i></span></small>
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
        <div class="userfull">
          <div class="p-5 text-center">
            <i class='fas fa-exclamation-circle text-warning my-3' style='font-size:80px;'></i>
            <h4><?php echo $array['reachmaxnumofuser']?></h4>
            <p><?php echo $array['reachmaxnumofuserexplain']?></p>
          </div>
        </div>   
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
   $(document).ready(function(){
    var form = $('#admindeleteuserform');

    $(document).on('click', ".deleteUser", function(){
      var userID = $(this).data('id');
      $.ajax({
        url:"ajax-getuser.php?lang=<?php echo $extlg;?>",
        method:"POST",
        data:{userID:userID},
        dataType:"json",
        success:function(data){
          $("#deleteuserid").val(data.id);
          console.log(data.id);
        }
      });
    });

    form.on('submit', function(e){
      e.preventDefault();
      e.stopPropagation();
      var deleteuserid = document.getElementById("deleteuserid").value;
      var alldata = "deleteuserid="+deleteuserid;
      console.log(alldata);
      $.ajax({
        url: "ajax-deleteuser.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
        success:function(data){
          var obj = JSON.parse(data);
          console.log(obj);
          if(obj.condition === "Passed"){
            $("#admindeleteuser").modal("hide"); 
            getusersinfo();
          }
        }
      });
    });

    $("#admindeleteuser").on('hidden.bs.modal', function(){
      document.getElementById("admindeleteuserform").reset(); 
    });

    function getusersinfo(){
      $.ajax({
        url:"ajax-getviewadminusers.php?lang=<?php echo $extlg;?>",
        success:function(data){
          $("#usersinfo").html(data);
        }
      });
    }
    
  });  
</script>
<!-- Modal for Delete User-->
<div class="modal fade" id="admindeleteuser">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h6 class="modal-title text-white" id="scoreboardModalLabel"><?php echo $array['delete']?> <?php echo $array['user']?></h6>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="admindeleteuserform">
          <?php echo $array['deleteuser']?>
          <input type="hidden" class="form-control" name="deleteuserid" id="deleteuserid">
          <div class="row mt-3">
            <div class="col text-right">
              <button name="submit" value="deleteobjective" type="submit" class="btn btn-primary shadow-sm mx-1"><?php echo $array['delete']?></button>
              <button type="button" class="btn shadow-sm btn-danger" data-dismiss="modal"><?php echo $array['cancel']?></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    var form = $('#edituserform');

    $(document).on('click', ".editUser", function(){
      var userID = $(this).data('id');
      $.ajax({
        url:"ajax-getuser.php?lang=<?php echo $extlg;?>",
        method:"POST",
        data:{userID:userID},
        dataType:"json",
        success:function(data){
          console.log(data);
          $("#edituserid").val(data.id);
          $("#edituserfirstname").val(data.firstname);
          $("#edituserlastname").val(data.lastname);
          $("#edituserjobposition").val(data.jobposition);
          $("#edituseremail").val(data.email);
          $('#editusergroup').val(data.grouparray);
          
          var grouparraylist = [];
          $.each($("#editusergroup option:selected"), function(){
            grouparraylist.push($(this).text());
          });

          if(data.grouparray.length != 0){
            $(".filter-option-inner-inner").text(grouparraylist.join(", "));
          }else{
            $(".filter-option-inner-inner").text("Nothing selected");
          }
          
          <?php
          if($resultresult->corporateID){
            ?>
            document.getElementById("editusercompany").value = data.companyID;
            <?php
          }
          ?>
          
          document.getElementById("edituserrole").value = data.role;
          if(data.admin == true){
            document.getElementById("editasadmin").checked = true;
          }else{
            document.getElementById("editasadmin").checked = false;
          }
          if(data.becomesupervisor == true){
            document.getElementById("editassupervisor").checked = true;
          }else{
            document.getElementById("editassupervisor").checked = false;
          }
          
          var button = $('#edituserbutton');
          var orig = [];

          $.fn.getType = function () {
              return this[0].tagName == "INPUT" ? $(this[0]).attr("type").toLowerCase() : this[0].tagName.toLowerCase();
          }

          $("#edituserform :input").each(function () {
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

          $('#edituserform').bind('change keyup', function () {

              var disable = true;
              $("#edituserform :input").each(function () {
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
      var edituserid = document.getElementById("edituserid").value;
      var edituserfirstname = document.getElementById("edituserfirstname").value;
      var edituserlastname = document.getElementById("edituserlastname").value;
      var edituseremail = document.getElementById("edituseremail").value;
      var edituserjobposition = document.getElementById("edituserjobposition").value;
      <?php
      if($resultresult->corporateID){
        ?>
        var editusercompany = document.getElementById("editusercompany").value;
        <?php
      }
      ?>
      
      var editusergroup = document.getElementById("editusergroup");
      
      var str='';
      for (i=0;i< editusergroup.length;i++) { 
          if(editusergroup[i].selected){
              str += editusergroup[i].value + ','; 
          }
      } 
      var str=str.slice(0,str.length -1);
      var edituserrole = document.getElementById("edituserrole").value;
      var editasadmin = document.getElementById("editasadmin").checked;
      var editassupervisor = document.getElementById("editassupervisor").checked;
      <?php
      if($resultresult->corporateID){
      ?>
      var alldata = "edituserid="+edituserid+"&edituserfirstname="+edituserfirstname+"&edituserlastname="+edituserlastname+"&edituserjobposition="+edituserjobposition+"&edituseremail="+edituseremail+"&editusercompany="+editusercompany+"&editusergroup="+str+"&edituserrole="+edituserrole+"&editasadmin="+editasadmin+"&editassupervisor="+editassupervisor+"&corporateID="+<?php echo $resultresult->corporateID;?>;
      <?php
      }else{
      ?>
      var alldata = "edituserid="+edituserid+"&edituserfirstname="+edituserfirstname+"&edituserlastname="+edituserlastname+"&edituserjobposition="+edituserjobposition+"&edituseremail="+edituseremail+"&editusercompany="+<?php echo $resultresult->companyID;?>+"&editusergroup="+str+"&edituserrole="+edituserrole+"&editasadmin="+editasadmin+"&editassupervisor="+editassupervisor;
      <?php
      }
      ?>
      console.log(alldata);

      $.ajax({
        url: "ajax-edituser.php",
        type: "POST",
        data: alldata,
        success:function(data){
          var obj = JSON.parse(data);
          console.log(obj);
          if(obj.condition === "Passed"){
            $("#adminedituser").modal("hide");
            getusersinfo();   
          }else{
            checkvalidity("edituserfirstnameerror","#edituserfirstnameerror", "#edituserfirstname", obj.firstname);
            checkvalidity("edituserlastnameerror","#edituserlastnameerror", "#edituserlastname", obj.lastname);
            checkvalidity("edituserjobpositionerror","#edituserjobpositionerror", "#edituserjobposition", obj.jobposition);
            checkvalidity("edituseremailerror","#edituseremailerror", "#edituseremail", obj.email);
            checkvalidity("edituserroleerror","#edituserroleerror", "#edituserrole", obj.role);
          }
        }
      });
    });

    $("#adminedituser").on('hidden.bs.modal', function(){
      document.getElementById("edituserform").reset(); 
      clearform("#edituserfirstnameerror", "edituserfirstnameerror", "#edituserfirstname");
      clearform("#edituserlastnameerror", "edituserlastnameerror", "#edituserlastname");
      clearform("#edituserjobpositionerror", "edituserjobpositionerror", "#edituserjobposition");
      clearform("#edituseremailerror", "edituseremailerror", "#edituseremail");
      clearform("#edituserroleerror", "edituserroleerror", "#edituserrole");
    });

    function getusersinfo(){
      $.ajax({
        url:"ajax-getviewadminusers.php?lang=<?php echo $extlg;?>",
        success:function(data){
          $("#usersinfo").html(data);
        }
      });
    }

  });
</script>
<!-- Modal for Edit User-->
<div class="modal fade" id="adminedituser">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h6 class="modal-title text-white" id="scoreboardModalLabel"><?php echo $array['edit']?> <?php echo $array['user']?></h6>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="edituserform">
          <input type="hidden" name="edituserid" id="edituserid">
          <div class="form-group">
            <div class="row">
              <div class="col-2"><label><?php echo $array['firstname']?> :</label></div>
              <div class="col">
                <input type="text" class="form-control form-control-sm shadow-sm" id="edituserfirstname" name="edituserfirstname" autocomplete="off">
                <small><span id="edituserfirstnameerror"></span></small>
              </div>
              <div class="col-2"><label><?php echo $array['lastname']?> :</label></div>
              <div class="col">
                <input type="text" class="form-control form-control-sm shadow-sm" id="edituserlastname" name="edituserlastname" autocomplete="off">
                <small><span id="edituserlastnameerror"></span></small>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-2"><label><?php echo $array['email']?> :</label></div>
              <div class="col">
                <input type="email" class="form-control form-control-sm shadow-sm" id="edituseremail" name="edituseremail" autocomplete="off">
                <small><span id="edituseremailerror"></span></small>
              </div>
              <div class="col-2"><label><?php echo $array['jobposition']?> :</label></div>
              <div class="col">
                <input type="text" class="form-control form-control-sm shadow-sm" id="edituserjobposition" name="edituserjobposition" autocomplete="off">
                <small><span id="edituserjobpositionerror"></span></small>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              
              <div class="col-2"><label><?php echo $array['role']?> :</label></div>
              <div class="col-4">
                <select class="form-control form-control-sm shadow-sm" id="edituserrole" name="edituserrole">
                  <option value="">--</option>
                  <?php
                  if($resultresult->corporateID){
                  ?>
                  <option value="Chief"><?php echo $array['chief']?></option>
                  <?php
                  }
                  ?>
                  <option value="Superior"><?php echo $array['superior']?></option>
                  <option value="Manager"><?php echo $array['manager']?></option>
                  <option value="Personal"><?php echo $array['personal']?></option>
                </select>
                <small><span id="edituserroleerror"></span></small>
              </div>
              <div class="col">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="editasadmin" name="editasadmin">
                  <label class="custom-control-label" for="editasadmin"><?php echo $array['admin']?></label>
                </div>
                <small><span id="edituseradminerror"></span></small>
              </div>
              <div class="col">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="editassupervisor" name="editassupervisor">
                  <label class="custom-control-label" for="editassupervisor"><?php echo $array['supervisor']?></label>
                </div>
                <small><span id="edituseradminerror"></span></small>
              </div>
            </div>
            
            
          </div>

          <?php
          if($resultresult->corporateID){
          ?>
          <div class="form-group">
            <div class="row">
              <div class="col-2"><label><?php echo $array['company']?> :</label></div>
              <div class="col">
                <select class="form-control form-control-sm shadow-sm select" id="editusercompany" name="editusercompany">
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
                    }
                  ?>
                </select>
                <small><span class="text-secondary"><i><?php echo $array['optional']?></i></span></small>
              </div>
            </div>
          </div>
          <?php
          }
          ?>
          <div class="form-group">
            <div class="row">
              <div class="col-2"><label><?php echo $array['group']?> :</label></div>
              <div class="col">
                <select class="form-control form-control-sm shadow-sm selectpicker" id="editusergroup" name="editusergroup" data-live-search="true" data-size="5" data-selected-text-format="count > 3" multiple>
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
                <small><span class="text-secondary"><i><?php echo $array['optional']?></i></span></small>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col text-right">
              <button name="submit" id="edituserbutton" value="submit" type="submit" class="btn btn-primary shadow-sm" disabled><?php echo $array['edit']?></button>
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
    var form = $('#inviteuserform');
    form.on('submit', function(e){
      e.preventDefault();
      e.stopPropagation();
      var IUorganization = document.getElementById("IUorganization").value;
      var IUfirstname = document.getElementById("IUfirstname").value;
      var IUlastname = document.getElementById("IUlastname").value;
      var IUemail = document.getElementById("IUemail").value;
      var IUcountriescode = document.getElementById("IUcountriescode").value;
      var IUphonenumber = document.getElementById("IUphonenumber").value;
      var alldata = 
      {
        IUorganization:IUorganization,
        IUfirstname:IUfirstname,
        IUlastname:IUlastname,
        IUemail:IUemail,
        IUcountriescode:IUcountriescode,
        IUphonenumber:IUphonenumber
      };
      $.ajax({
        url: "ajax-addinviteuser.php",
        type: "POST",
        data: alldata,
        dataType: "json",
        success:function(data){
          console.log(data);
          if(data.condition === "Passed"){
            $("#inviteusers").modal("hide");
            document.getElementById("totalinviteuser").innerHTML = data.total;
            document.getElementById("totalsuccess").innerHTML = data.invited;
          }else{
            checkvalidity("IUorganizationerror","#IUorganizationerror", "#IUorganization", data.organization);
            checkvalidity("IUfirstnameerror","#IUfirstnameerror", "#IUfirstname", data.firstname);
            checkvalidity("IUlastnameerror","#IUlastnameerror", "#IUlastname", data.lastname);
            checkvalidity("IUemailerror","#IUemailerror", "#IUemail", data.email);
            checkvalidity("IUcountriescodeerror","#IUcountriescodeerror", "#IUcountriescode", data.countrycode);
            checkvalidity("IUphonenumbererror","#IUphonenumbererror", "#IUphonenumber", data.phonenumber);
          }
        }
      });
    });

    $("#inviteusers").on('hidden.bs.modal', function(){
      document.getElementById("inviteuserform").reset(); 
      clearform("#IUorganizationerror", "IUorganizationerror", "#IUorganization");
      clearform("#IUfirstnameerror", "IUfirstnameerror", "#IUfirstname");
      clearform("#IUlastnameerror", "IUlastnameerror", "#IUlastname");
      clearform("#IUemailerror", "IUemailerror", "#IUemail");
      clearform("#IUcountriescodeerror", "IUcountriescodeerror", "#IUcountriescode");
      clearform("#IUphonenumbererror", "IUphonenumbererror", "#IUphonenumber");
    });
  });
</script>
<div class="modal" id="inviteusers">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <a type="button" class="close" data-dismiss="modal">&times;</a>
        <div class="p-5">
          <h4>Invite Users</h4>
          <form id="inviteuserform">
            <div class="form-group">
              Organization <small><span id="IUorganizationerror"></span></small>
              <input type="text" class="form-control" id="IUorganization">
            </div>
            <div class="form-group">
              First Name <small><span id="IUfirstnameerror"></span></small>
              <input type="text" class="form-control" id="IUfirstname">
            </div>
            <div class="form-group">
              Last Name <small><span id="IUlastnameerror"></span></small>
              <input type="text" class="form-control" id="IUlastname">
            </div>
            <div class="form-group">
              Email <small><span id="IUemailerror"></span></small>
              <input type="text" class="form-control" id="IUemail">
            </div>

            <div class="row">
              <div class="col">
                <div class="form-group">
                  Country Code <small><span id="IUcountriescodeerror"></span></small>
                  <select class="form-control selectpicker" id="IUcountriescode" data-live-search="true" data-size="5" data-header="Select your countries">
                    <option value="">--</option>
                    <?php
                    $userobject = new User();
                    $userresult = $userobject->searchCountriesCode();
                    
                    if($userresult){
                      foreach ($userresult as $row) {
                        ?>
                        <option value="<?php echo $row->phonecode;?>"><?php echo $row->phonecode;?></option>
                        <?php
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  Phone Number <small><span id="IUphonenumbererror"></span></small>
                  <input type="number" class="form-control" id="IUphonenumber">
                </div>
              </div>
            </div>

            
            <button type="submit" class="btn btn-block btn-primary">Invite</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function upgradepackage(companyID){
    $.ajax({
      url:"ajax-upgradepackage.php?lang=<?php echo $extlg;?>",
      type: "POST",
      data: {companyID:companyID},
      dataType: "json",
      success:function(data){
        location.reload();
      }
    });
  }
</script>