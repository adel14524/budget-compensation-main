<?php
require_once 'core/init.php';
$userlevel = "";
$user = new User();
if(!$user->isLoggedIn()){
  Redirect::to("login.php");
}else{
  $resultresult = $user->data();
  $userlevel = $resultresult->role;
  if($resultresult->verified == false || $resultresult->superadmin == true){
    $user->logout();
    Redirect::to("login.php?error=error");
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Calendar - DoerHRM</title> 
  <?php
  include 'includes/header.php';
  ?>
</head>
<?php

  $year = date("Y");
  $date = new DateTime();
  $week = $date->format("W");
  $currentweek = $week+0;
  $nextweek = $week+1;

  $day = date('w');
  $thisweek_start = date('j M Y', strtotime('monday this week'));
  $thisweek_end = date('j M Y', strtotime('sunday this week'));

  
  $thisweek_startsql = new DateTime($thisweek_start);
  $thisweek_startsqlformat = $thisweek_startsql->format('Y-m-d H:i:s');
  $thisweek_endsql = new DateTime($thisweek_end);
  $thisweek_endsqlformat = $thisweek_endsql->format('Y-m-d H:i:s');

?>
<style type="text/css">
  .fc-scroller {
    overflow-y: hidden !important;
  }
</style>
<script type="text/javascript">
  $(document).ready(function(){
    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            vars[key] = value;
        });
        return vars;
    }
    var lang = getUrlVars()["lang"];
    if(lang === "en"){
      var langset = "en";
    }else if(lang === "zh"){
      var langset = "zh-cn";
    }else if(lang === "bm"){
      var langset = "ms";
    }else{
      var langset = "en";
    }


    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'interaction','bootstrap','dayGrid', 'timeGrid', 'list'],
      header: { 
        left: 'today prev,next',
        center: 'title',
        right: 'dayGridMonth,listWeek',
      },
      locale: langset,
      themeSystem: 'bootstrap',
      selectable: true,
      eventStartEditable: false,
      firstDay: 1,
      navLinks: true,
      nowIndicator: true,
      businessHours: {
        daysOfWeek: [ 1, 2, 3, 4, 5 ], 
      },
      titleFormat: {
        month: 'short',
        year: 'numeric',
        day: 'numeric'
      },
      
      select: function(info){
        var start = moment(info.startStr).format('YYYY-MM-DD hh:mm A');
        var end = moment(info.endStr).subtract(1, 'seconds').format('YYYY-MM-DD hh:mm A');
        $('#addplanstartdate').val(start);
        $('#addplanenddate').val(end);
        $('#addplandaily').modal();
      },

      eventClick: function(info) {
        if(info.event.extendedProps.userID == <?php echo $resultresult->userID?>){
          $("#editplanid").val(info.event.id);
          $('#editplanowner').val(info.event.extendedProps.user);
          $('#editplanstatus').val(info.event.extendedProps.status);
          $('#editplannamedaily').val(info.event.title);
          var start = moment(info.event.start).format('YYYY-MM-DD hh:mm A');
          var end = moment(info.event.end).format('YYYY-MM-DD hh:mm A');
          $('#editplanstartdate').val(start);
          $('#editplanenddate').val(end);
          $('#editplan').modal();
        }else{
          $("#viewplanid").val(info.event.id);
          $('#viewplanowner').val(info.event.extendedProps.user);
          $('#viewplanstatus').val(info.event.extendedProps.status);
          $('#viewplannamedaily').val(info.event.title);
          var start = moment(info.event.start).format('YYYY-MM-DD hh:mm A');
          var end = moment(info.event.end).format('YYYY-MM-DD hh:mm A');
          $('#viewplanstartdate').val(start);
          $('#viewplanenddate').val(end);
          $('#viewplan').modal();
        }
      }
    });

    calendar.render();
  });
</script>
<body>
  <?php include 'includes/topbar.php';?>
  <div class="d-flex" id="wrapper">
    <?php include 'includes/navbar.php';?>
    <div id="page-content-wrapper">
    <div class="container-fluid" id="content"> 
      <div class="row my-4">
        <div class="col">
          <h4 class="m-0"><i class="fa fa-calendar"></i> Calendar</h4>
        </div>
      </div>
      

      <ul class="nav nav-tabs row px-2">
        <li class="nav-item col-12 col-xl-2 p-0">
          <a class="nav-link rounded-0 text-center active" data-toggle="tab" href="#calendarshow"><span class="font-weight-bold">CALENDAR</span></a>
        </li>
        <li class="nav-item col-12 col-xl-2 p-0">
          <a class="nav-link rounded-0 text-center" data-toggle="tab" href="#tags"><span class="font-weight-bold">MANAGE TAGS</span></a>
        </li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">
        <div class="tab-pane active" id="calendarshow">
          <div class="row mt-3">
            <div class="col-xl-12 col-12">
              <div class="row mb-3">
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 px-2">
                   <select class="form-control selectpicker rounded-0 border">
                      <option value="">All Groups</option>
                      <option value="">Group 1</option>
                      <option value="">Group 2</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 px-2">
                   <select class="form-control selectpicker rounded-0 border">
                      <option value="">All User</option>
                      <option value="">User 1</option>
                      <option value="">User 2</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 px-2">
                   <select class="form-control selectpicker rounded-0 border">
                      <option value="">All Priorities</option>
                      <option value="">High</option>
                      <option value="">Low</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 px-2">
                   <select class="form-control selectpicker rounded-0 border">
                      <option value="">All Status</option>
                      <option value="">Done</option>
                      <option value="">In Progress</option>
                      <option value="">Issue</option>
                      <option value="">Stuck</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 px-2">
                   <select class="form-control selectpicker rounded-0 border">
                      <option value="">All Type</option>
                      <option value="">Check In</option>
                      <option value="">1 on 1</option>
                      <option value="">Appointment</option>
                      <option value="">Business Meeting</option>
                      <option value="">Site Works</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 px-2">
                  <select class="form-control selectpicker rounded-0 border">
                    <option value="">All Tags</option>
                    <option value="">Tag 1</option>
                    <option value="">Tag 2</option>
                  </select>
                </div>
              </div>
              <div class="mb-5" id='calendar'></div>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="tags">
          <div class="row mt-3">
            <div class="col-12 col-xl-5 px-2">
              <div class="form-group">
                <input class="form-control rounded-0" type="text" placeholder="Search..">
              </div>
            </div>
            <div class="col-12 col-xl-5 px-2">
              <div class="form-group">
                <select class="form-control rounded-0">
                  <option value="All">All</option>
                  <option value="">Location</option>
                  <option value="">Product</option>
                  <option value="">Others</option>
                </select>
              </div>
            </div>
            <div class="col-12 col-xl-2 px-2">
              <button class="btn btn-primary btn-block rounded-0" data-toggle="modal" data-target="#addtags">Add Tags</button>
            </div>
          </div>

          <ul class='list-group list-group-flush my-3'>
            <li class='list-group-item'>
              <div class='row'>
                <div class='col'>KL</div>
                <div class='col'>Location</div>
                <div class='col text-right'>
                  <a class='' data-toggle='modal' data-target='#edittags' href='#'>Edit</a> | 
                  <a class='' data-toggle='modal' data-target='#deletetags' href='#'>Delete</a>
                </div>
              </div>
            </li>
            <li class='list-group-item'>
              <div class='row'>
                <div class='col'>PJ</div>
                <div class='col'>Location</div>
                <div class='col text-right'>
                  <a class='' data-toggle='modal' data-target='#edittags' href='#'>Edit</a> | 
                  <a class='' data-toggle='modal' data-target='#deletetags' href='#'>Delete</a>
                </div>
              </div>
            </li>
            <li class='list-group-item'>
              <div class='row'>
                <div class='col'>Instrument</div>
                <div class='col'>Product</div>
                <div class='col text-right'>
                  <a class='' data-toggle='modal' data-target='#edittags' href='#'>Edit</a> | 
                  <a class='' data-toggle='modal' data-target='#deletetags' href='#'>Delete</a>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>

      
    </div>
  </div>
</div>
  <script type="text/javascript">
    $(document).ready(function(){
       $("#sidebar-wrapper .active").removeClass("active");
       $("#calendartab").addClass("active").addClass("disabled");
       document.getElementById("calendartab").style.backgroundColor = "DeepSkyBlue";
    });
  </script>
  <?php
  include 'includes/footer.php';
  ?>
</body>
</html>


