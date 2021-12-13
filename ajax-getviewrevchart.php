<?php
require_once 'core/init.php';
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
if(Input::exists()){

  $company = escape(Input::get('comp')); 
  $year = escape(Input::get('year')); 
  $revenueobject = new Revenue();
  if($resultresult->userID){

    $data = $revenueobject->searchRevenueestimate($company,$year,"estimatedrev");
    $data2 = $revenueobject->searchRevenueactual($company,$year,"actualrev");
  }
  $view = "";
if($data && $data2){

  $view .= 
  "
  <div id='page-content-wrapper'><br><br>
  <canvas id='chart' width='40' height='15'>
  <script>
  var ctx = document.getElementById('chart').getContext('2d');
  var myChart = new Chart(ctx, {
   type: 'bar',
   data: {
     labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
     datasets: [{
       label: 'Estimated Revenue',
       data: [".$data->january.", ".$data->february.", ".$data->march.", ".$data->april.", ".$data->may.", ".$data->june.",".$data->july.",".$data->august.",".$data->september.",".$data->october.",".$data->november.",".$data->december."],
       backgroundColor: 'rgba(75, 192, 192, 0.2)',
       borderColor: 'rgb(75, 192, 192)',
       borderWidth: 1
       },

       {
         label: 'Actual Revenue',
         data: [".$data2->january.", ".$data2->february.", ".$data2->march.", ".$data2->april.", ".$data2->may.", ".$data2->june.",".$data2->july.",".$data2->august.",".$data2->september.",".$data2->october.",".$data2->november.",".$data2->december."],
         backgroundColor: 'rgba(255, 99, 132, 0.2)',
         borderColor: 'rgb(255, 99, 132)',
         borderWidth: 1
         }]
         },
         options: {
           scales: {
             y: {
               beginAtZero: true
             }
           }
         }
         });
         </script>

         </canvas>



         </div> 
  ";
}
    

  
  // else{
  //   $view .= 
  //   "
  //   <div class='card box rounded-0'>
  //   <div class='card-body'>
  //   <b>No data found</b>
  //   </div>
  //   </div>
  //   ";
  // }

  echo json_encode($view);
}
?>