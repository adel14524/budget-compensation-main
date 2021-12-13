<div class="tab-pane" id="usermanage">
  <div class="row my-3">
    <div class="col px-2">
      <input class="form-control rounded-0" id="searchusers" type="text" placeholder="Search..">
    </div>
    <div class="col px-2">
       <select class="form-control rounded-0" id="selectusersrole">
          <option value="All">All</option>
          <option value="Chief">Chief</option>
          <option value="Superior">Superior</option>
          <option value="Manager">Manager</option>
          <option value="Personal">Personal</option>
        </select>
    </div>
    <div class="col px-2">
       <select class="form-control rounded-0" id="selectusersstatus">
          <option value="All">All</option>
          <option value="Active">Active</option>
          <option value="Inactive">Inactive</option>
        </select>
    </div>
    <div class="col-2 px-2">
      <button type="button" class="btn btn-primary rounded-0 btn-block float-right" data-toggle="modal" data-backdrop='static' data-target="#adminadduser"><i class='fas fa-plus'></i> <?php echo $array['add']?> <?php echo $array['users']?></button>
    </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function(){
      $("#searchusers").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#showuserslist .searchusers").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });

      $('#selectusersrole').change(function () {
        var role = document.getElementById("selectusersrole").value;
        var status = document.getElementById("selectusersstatus").value;
        if(role === "All" && status === "All"){
          $(".all").show();
        }else if(role != "All" && status === "All"){
          $(".all").hide();
          $("."+role+"").show();
        }else if(role === "All" && status != "All"){
          $(".all").hide();
          $("."+status+"").show();
        }else if(role != "All" && status != "All"){
          $(".all").hide();
          $("."+role+"."+status+"").show();
        }
      });

      $('#selectusersstatus').change(function () {
        var role = document.getElementById("selectusersrole").value;
        var status = document.getElementById("selectusersstatus").value;
        if(role === "All" && status === "All"){
          $(".all").show();
        }else if(role != "All" && status === "All"){
          $(".all").hide();
          $("."+role+"").show();
        }else if(role === "All" && status != "All"){
          $(".all").hide();
          $("."+status+"").show();
        }else if(role != "All" && status != "All"){
          $(".all").hide();
          $("."+role+"."+status+"").show();
        }
      });

      $("a[href='#usermanage']").on('show.bs.tab', function(e) {
        getusersinfo();
      });
    });
  </script>
  <div id="usersinfo"></div>
</div>