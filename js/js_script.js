//Admin Dashboard Loader

function getcorporateinfo(){
  $.ajax({
    url:"ajax-getviewadmincorporate.php",
    success:function(data){
      $("#corporateinfo").html(data);
    }
  });
}

function getcorporateinfoprofilepic(){
  $.ajax({
    url:"ajax-getviewadmincorporateprofilepic.php",
    success:function(data){
      $("#corporateinfoprofilepic").html(data);
    }
  });
}

function getcompaniesinfo(){
  $.ajax({
    url:"ajax-getviewadmincompanies.php?lang=<?php echo $extlg;?>",
    success:function(data){
      $("#companiesinfo").html(data);
    }
  });
}

function getcompaniespublicinfo(){
  $.ajax({
    url:"ajax-getviewpubliccompanies.php?lang=<?php echo $extlg;?>",
    success:function(data){
      $("#companiespublicinfo").html(data);
    }
  });
}

function getcompanyinfo(){
  $.ajax({
    url:"ajax-getviewadmincompany.php?lang=<?php echo $extlg;?>",
    success:function(data){
      $("#companyinfo").html(data);
    }
  });
}

function getcompanyinfoprofilepic(){
  $.ajax({
    url:"ajax-getviewadmincompanyprofilepic.php",
    success:function(data){
      $("#companyinfoprofilepic").html(data);
    }
  });
}


function getgroupsinfo(){
  $.ajax({
    url:"ajax-getviewadmingroups.php?lang=<?php echo $extlg;?>",
    success:function(data){
      $("#groupsinfo").html(data);
    }
  });
}

function getgroupspublicinfo(){
  $.ajax({
    url:"ajax-getviewpublicgroups.php?lang=<?php echo $extlg;?>",
    success:function(data){
      $("#groupspublicinfo").html(data);
    }
  });
}

function getusersinfo(){
  $.ajax({
    url:"ajax-getviewadminusers.php?lang=<?php echo $extlg;?>",
    success:function(data){
      $("#usersinfo").html(data);
    }
  });
}

function getuserspublicinfo(){
  $.ajax({
    url:"ajax-getviewpublicusers.php?lang=<?php echo $extlg;?>",
    success:function(data){
      $("#userspublicinfo").html(data);
    }
  });
}

function gettimeframeinfo(){
  $.ajax({
    url:"ajax-getviewadmintimeframes.php?lang=<?php echo $extlg;?>",
    success:function(data){
      $("#timeframesinfo").html(data);
    }
  });
}

function getokr(filtertimeframe, filterID = null){
  $("#loading").show();
  $(".filter_data").hide();
  var alldata = 
  {
    filtertimeframe:filtertimeframe,
    filterID:filterID
  };
  $.ajax({
    url:"ajax-getobjectivelist5.php?lang=<?php echo $extlg;?>",
    method:"POST",
    data:alldata,
    dataType:"json",
    success:function(data){
      $("#loading").hide();
      $(".filter_data").show();
      $(".filter_data").html(data.output);
    }
  });
}

function getokr2(filtertimeframe, filterID, role){
  $("#loading").show();
  $("#showchart").hide();
  $(".filter_data").hide();
  var alldata = 
  {
    filtertimeframe:filtertimeframe,
    filterID:filterID,
    role:role
  };

  $.ajax({
    url:"ajax-getobjectivelist.php?lang=<?php echo $extlg;?>",
    method:"POST",
    data:alldata,
    dataType:"json",
    success:function(data){
      $("#loading").hide();
      $("#showchart").show();
      $(".filter_data").show();
      $(".filter_data").html(data.output);
      var averagescore = data.averageobjectivescore;
      if(data.objectiveshow == 1){
        $("#showchart").html("<div class='row'><div class='col-xl-3 col-12 mb-3'><div class='card shadow-sm'><div class='card-header'><?php echo $array['overallprogress']?></div><div class='card-body'><canvas id='pie' height='200'></canvas><h4 class='text-center mb-n2'>"+Number(averagescore).toFixed(2)+"%</h4></div></div></div><div class='col-xl-9 col-12'><div class='card'><div class='card-header'><?php echo $array['progresstimeline']?></div><div class='card-body'><canvas id='myChart6' height='63'></canvas></div></div></div></div>");
        var pie1 = document.getElementById('pie').getContext('2d');
        var doughnut = new Chart(pie1, {
          type: 'doughnut',
          data: {
              labels: ["<?php echo $array['currentprogress']?>", "<?php echo $array['togo']?>"],
              datasets: [{
                  data: [Number(averagescore).toFixed(2), Number(100-averagescore).toFixed(2)],
                  backgroundColor: [
                    'rgba(54, 162, 235, 0.9)',
                    'rgba(255, 99, 132, 0.9)'
                  ],
                  borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)'
                  ],
                  borderWidth: 5
              }]
          },
          options:{
            legend: {
              display: false
            },
            cutoutPercentage: 70,
            rotation: -3.15,
            circumference: 3.15,

          }
        });

        var start = moment(data.startdate).format('YYYY-MM-DD hh:mm');
        var end = moment(data.enddate).format('YYYY-MM-DD hh:mm');

        var ctx4 = document.getElementById('myChart6').getContext('2d');
        var myChart4 = new Chart(ctx4, {
          type: 'line',
          data: {
              labels: data.alldate,
              datasets: [
              {
                  label: "<?php echo $array['progress']?>",
                  data: data.test,
                  backgroundColor: 'rgba(255, 99, 132, 1)',
                  borderColor: 'rgba(255, 99, 132, 1)',
                  borderWidth: 3,
                  fill: false
              },
              {
                  label: "<?php echo $array['expected']?>",
                  data: data.expectscore,
                  backgroundColor: 'rgba(54, 162, 235, 1)',
                  borderColor: 'rgba(54, 162, 235, 1)',
                  borderWidth: 3,
                  fill: false
              }
              ]
          },
          options: {
            responsive: true,
            tooltips: {
                mode: 'index'
            },
            legend: {
              position: 'right',
              align: 'center'
            },
            elements: {
                point:{
                    radius: 0
                }
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        lineWidth: 0
                    }
                }],
                yAxes: [{
                    gridLines: {
                        lineWidth: 0
                    }   
                }]
            }
          }
        });
      }else{
        $("#showchart").html("");
      }
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
