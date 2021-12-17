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

$year = escape(Input::get('year'));
$comp = escape(Input::get('comp'));
$newyear = date('Y', strtotime($year));
$mainallocationobject = new Mainallocation();
$data2 = $mainallocationobject->searchmain($comp,$newyear);

$suballocationobject = new Suballocation();
$othersallocation=0;
$bonusallocation=0;

function totalexpenses($budgetSubAllocationID,$month,$year){
    $total=0;
    $Expenseobject = new Expense();
    $dataexpenses = $Expenseobject->searchexpensessubid($budgetSubAllocationID,$month,$year);
    
    if($dataexpenses){
      foreach ($dataexpenses as $row) {
        $total+=$row->amount;
      }
    }
    return $total;
  }

 $Expense1object = new Expense();
  

$view="";
if ($data2){
  $amountbonus1=0;$amountbonus2=0;$amountbonus3=0;$amountbonus4=0;$amountbonus5=0;
  $amountbonus6=0;$amountbonus7=0;$amountbonus8=0;$amountbonus9=0;$amountbonus10=0;
  $amountbonus11=0;$amountbonus12=0;
foreach ($data2 as $row) 
{
      $data3 = $suballocationobject->searchsub($row->budgetMainAllocationID);
      $amountsub1=0;$amountsub2=0;$amountsub3=0;$amountsub4=0;$amountsub5=0;
      $amountsub6=0;$amountsub7=0;$amountsub8=0;$amountsub9=0; $amountsub10=0;
      $amountsub11=0;$amountsub12=0;

     
      if($row->categoryName=="Bonus"){
        $Bonusobject= new Calculation();
        $bonusresult=$Bonusobject->searchbonusmainid($row->budgetMainAllocationID);
        $bonusallocation=$row->budgetAllocated;


        if($bonusresult){
          foreach($bonusresult as $row){
            $month = date("m",strtotime($row->date));
            if($month=="01"){
             $amountbonus1+=$row->Total_Bonus;
           }
           elseif($month=="02"){
             $amountbonus2+=$row->Total_Bonus;
           }
           elseif($month=="03"){
             $amountbonus3+=$row->Total_Bonus;
           }
           elseif($month=="04"){
             $amountbonus4+=$row->Total_Bonus;
           }
           elseif($month=="05"){
             $amountbonus5+=$row->Total_Bonus;
           }
           elseif($month=="06"){
             $amountbonus6+=$row->Total_Bonus;
           }
           elseif($month=="07"){
             $amountbonus7+=$row->Total_Bonus;

           }
           elseif($month=="08"){
             $amountbonus8+=$row->Total_Bonus;
           }
           elseif($month=="09"){
             $amountbonus9+=$row->Total_Bonus;
           }
           elseif($month=="10"){
             $amountbonus10+=$row->Total_Bonus;
           }
           elseif($month=="11"){
             $amountbonus11+=$row->Total_Bonus;
           }
           elseif($month=="12"){
             $amountbonus12+=$row->Total_Bonus;
           }

         }
       }

     }
       elseif($row->categoryName=="Others"){
         foreach ($data3 as $row) { 
          $expensesresult=$Expense1object->searchbudgetsubid($row->budgetSubAllocationID);
          if($expensesresult){
           foreach ($expensesresult as $row) {
            $month = date("m",strtotime($row->date));

            if($month=="01"){
             $amountsub1+=$row->amount;
           }
           elseif($month=="02"){
             $amountsub2+=$row->amount;
           }
           elseif($month=="03"){
             $amountsub3+=$row->amount;
           }
           elseif($month=="04"){
             $amountsub4+=$row->amount;
           }
           elseif($month=="05"){
             $amountsub5+=$row->amount;
           }
           elseif($month=="06"){
             $amountsub6+=$row->amount;
           }
           elseif($month=="07"){
             $amountsub7+=$row->amount;
           }
           elseif($month=="08"){
             $amountsub8+=$row->amount;
           }
           elseif($month=="09"){
             $amountsub9+=$row->amount;
           }
           elseif($month=="10"){
             $amountsub10+=$row->amount;
           }
           elseif($month=="11"){
             $amountsub11+=$row->amount;
           }
           elseif($month=="12"){
             $amountsub12+=$row->amount;
           }
         }

       }
     }
   }

      if($data3){

  foreach ($data3 as $row) {
   $othersallocation+=$row->budgetAllocated;
  }
}
}
  $actual1=$amountbonus1+$amountsub1;
  $actual2=$amountbonus2+$amountsub2;
  $actual3=$amountbonus3+$amountsub3;
  $actual4=$amountbonus4+$amountsub4;
  $actual5=$amountbonus5+$amountsub5;
  $actual6=$amountbonus6+$amountsub6;
  $actual7=$amountbonus7+$amountsub7;
  $actual8=$amountbonus8+$amountsub8;
  $actual9=$amountbonus9+$amountsub9;
  $actual10=$amountbonus10+$amountsub10;
  $actual11=$amountbonus11+$amountsub11;
  $actual12=$amountbonus12+$amountsub12;
   
 
$budgetallocation=round(($othersallocation + $bonusallocation)/12);

$balance1=$budgetallocation-$actual1;
$balance2=$budgetallocation-$actual2;
$balance3=$budgetallocation-$actual3;
$balance4=$budgetallocation-$actual4;
$balance5=$budgetallocation-$actual5;
$balance6=$budgetallocation-$actual6;
$balance7=$budgetallocation-$actual7;
$balance8=$budgetallocation-$actual8;
$balance9=$budgetallocation-$actual9;
$balance10=$budgetallocation-$actual10;
$balance11=$budgetallocation-$actual11;
$balance12=$budgetallocation-$actual12;


$percent1=round(($actual1/$budgetallocation)*100);
$percent2=round(($actual2/$budgetallocation)*100);
$percent3=round(($actual3/$budgetallocation)*100);
$percent4=round(($actual4/$budgetallocation)*100);
$percent5=round(($actual5/$budgetallocation)*100);
$percent6=round(($actual6/$budgetallocation)*100);
$percent7=round(($actual7/$budgetallocation)*100);
$percent8=round(($actual8/$budgetallocation)*100);
$percent9=round(($actual9/$budgetallocation)*100);
$percent10=round(($actual10/$budgetallocation)*100);
$percent11=round(($actual11/$budgetallocation)*100);
$percent12=round(($actual12/$budgetallocation)*100);


if ($percent6 == 100 ) {
    $expensesprogress6 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent6."%;'><b>".$percent6."%</b></div></div>";
    }elseif ($percent6 >= 80 && $percent6 <= 99) {
      $expensesprogress6 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-warning' style='width:".$percent6."%;' ><b>".$percent6."%</b></div></div>";
    }elseif ($percent6>= 0 && $percent6 <= 79) {
      $expensesprogress6 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-info' style='width:".$percent6."%;'><b>".$percent6."%</b></div></div>";
    }elseif ($percent6 > 100) {
         $expensesprogress6 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent6."%;'><b>".$percent6."%</b></div></div>";
        }

    if ($percent1 == 100 ) {
    $expensesprogress1 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent1."%;'><b>".$percent1."%</b></div></div>";
    }elseif ($percent1 >= 80 && $percent1 <= 99) {
      $expensesprogress1 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-warning' style='width:".$percent1."%;' ><b>".$percent1."%</b></div></div>";
    }elseif ($percent1 >= 0 && $percent1 <= 79) {
     $expensesprogress1 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-info' style='width:".$percent1."%;'><b>".$percent1."%</b></div></div>";
    }elseif ($percent1 > 100) {
         $expensesprogress1 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent1."%;'><b>".$percent1."%</b></div></div>";
        }

    if ($percent2 == 100 ) {
    $expensesprogress2 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent2."%;'><b>".$percent2."%</b></div></div>";
    }elseif ($percent2 >= 80 && $percent2 <= 99) {
      $expensesprogress2 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-warning' style='width:".$percent2."%;' ><b>".$percent2."%</b></div></div>";
    }elseif ($percent2>= 0 && $percent2 <= 79) {
      $expensesprogress2 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-info' style='width:".$percent2."%;'><b>".$percent2."%</b></div></div>";
    }elseif ($percent2 > 100) {
         $expensesprogress2 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent2."%;'><b>".$percent2."%</b></div></div>";
        }

     if ($percent3 == 100 ) {
    $expensesprogress3 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent3."%;'><b>".$percent3."%</b></div></div>";
    }elseif ($percent3 >= 80 && $percent3 <= 99) {
      $expensesprogress3 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-warning' style='width:".$percent3."%;' ><b>".$percent3."%</b></div></div>";
    }elseif ($percent3>= 0 && $percent3 <= 79) {
      $expensesprogress3 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-info' style='width:".$percent3."%;'><b>".$percent3."%</b></div></div>";
    }elseif ($percent3 > 100) {
         $expensesprogress3 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent3."%;'><b>".$percent3."%</b></div></div>";
    }

     if ($percent4 == 100 ) {
    $expensesprogress4 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent4."%;'><b>".$percent4."%</b></div></div>";
    }elseif ($percent4 >= 80 && $percent4 <= 99) {
      $expensesprogress4 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-warning' style='width:".$percent4."%;' ><b>".$percent4."%</b></div></div>";
    }elseif ($percent4>= 0 && $percent4 <= 79) {
      $expensesprogress4 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-info' style='width:".$percent4."%;'><b>".$percent4."%</b></div></div>";
    }elseif ($percent4 > 100) {
         $expensesprogress4 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent4."%;'><b>".$percent4."%</b></div></div>";
        }

     if ($percent5 == 100 ) {
    $expensesprogress5 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent5."%;'><b>".$percent5."%</b></div></div>";
    }elseif ($percent5 >= 80 && $percent5 <= 99) {
      $expensesprogress5 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-warning' style='width:".$percent5."%;' ><b>".$percent5."%</b></div></div>";
    }elseif ($percent5>= 0 && $percent5 <= 79) {
      $expensesprogress5 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-info' style='width:".$percent5."%;'><b>".$percent5."%</b></div></div>";
    }elseif ($percent5 > 100) {
         $expensesprogress5 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent5."%;'><b>".$percent5."%</b></div></div>";
        }

     if ($percent7 == 100 ) {
    $expensesprogress7 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent7."%;'><b>".$percent7."%</b></div></div>";
    }elseif ($percent7 >= 80 && $percent7 <= 99) {
      $expensesprogress7 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-warning' style='width:".$percent7."%;' ><b>".$percent7."%</b></div></div>";
    }elseif ($percent7>= 0 && $percent7 <= 79) {
      $expensesprogress7 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-info' style='width:".$percent7."%;'><b>".$percent7."%</b></div></div>";
    }elseif ($percent7 > 100) {
         $expensesprogress7 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent7."%;'><b>".$percent7."%</b></div></div>";
        }

   if ($percent8 == 100 ) {
    $expensesprogress8 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent8."%;'><b>".$percent8."%</b></div></div>";
    }elseif ($percent8 >= 80 && $percent8 <= 99) {
      $expensesprogress8 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-warning' style='width:".$percent8."%;' ><b>".$percent8."%</b></div></div>";
    }elseif ($percent8>= 0 && $percent8 <= 79) {
      $expensesprogress8 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-info' style='width:".$percent8."%;'><b>".$percent8."%</b></div></div>";
    }elseif ($percent8 > 100) {
         $expensesprogress8 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent8."%;'><b>".$percent8."%</b></div></div>";
        }

 if ($percent9 == 100 ) {
    $expensesprogress9 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent9."%;'><b>".$percent9."%</b></div></div>";
    }elseif ($percent9 >= 80 && $percent9 <= 99) {
      $expensesprogress9 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-warning' style='width:".$percent9."%;' ><b>".$percent9."%</b></div></div>";
    }elseif ($percent9>= 0 && $percent9 <= 79) {
      $expensesprogress9 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-info' style='width:".$percent9."%;'><b>".$percent9."%</b></div></div>";
    }elseif ($percent9 > 100) {
         $expensesprogress9 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent9."%;'><b>".$percent9."%</b></div></div>";
        }


 if ($percent10 == 100 ) {
    $expensesprogress10 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent10."%;'><b>".$percent10."%</b></div></div>";
    }elseif ($percent10 >= 80 && $percent10 <= 99) {
      $expensesprogress10 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-warning' style='width:".$percent10."%;' ><b>".$percent10."%</b></div></div>";
    }elseif ($percent10>= 0 && $percent10 <= 79) {
      $expensesprogress10 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-info' style='width:".$percent10."%;'><b>".$percent10."%</b></div></div>";
    }elseif ($percent10 > 100) {
         $expensesprogress10 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent10."%;'><b>".$percent10."%</b></div></div>";
        }

     if ($percent11 == 100 ) {
    $expensesprogress11 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent11."%;'><b>".$percent11."%</b></div></div>";
    }elseif ($percent11 >= 80 && $percent11 <= 99) {
      $expensesprogress11 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-warning' style='width:".$percent11."%;' ><b>".$percent11."%</b></div></div>";
    }elseif ($percent11>= 0 && $percent11 <= 79) {
      $expensesprogress11 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-info' style='width:".$percent11."%;'><b>".$percent11."%</b></div></div>";
    }elseif ($percent11 > 100) {
         $expensesprogress11 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent11."%;'><b>".$percent11."%</b></div></div>";
        }

 if ($percent12 == 100 ) {
    $expensesprogress12 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent12."%;'><b>".$percent12."%</b></div></div>";
    }elseif ($percent12 >= 80 && $percent12 <= 99) {
      $expensesprogress12 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-warning' style='width:".$percent12."%;' ><b>".$percent12."%</b></div></div>";
    }elseif ($percent12>= 0 && $percent12 <= 79) {
      $expensesprogress12 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-info' style='width:".$percent12."%;'><b>".$percent12."%</b></div></div>";
    }elseif ($percent12 > 100) {
         $expensesprogress12 = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent12."%;'><b>".$percent12."%</b></div></div>";
        }




$view.="
<br><br>

<script type='text/javascript'>
        $(document).ready(function(){
        $(document).on('click', '.viewmore', function(){

          var companyID = ".$comp."; 
          var year = ".$year."; 
          var month = $(this).data('month');
          var div = $(this).data('place');
          var budgetallocated = ".$budgetallocation.";
          var balance = $(this).data('balance');

          var alldata = 
          {
            comp:companyID,
            year:year,
            month:month,
            budgetallocated:budgetallocated,
            balance:balance,
          };
          console.log(alldata);
          $.ajax({
            url:'ajax-viewexpenses.php',
            data: alldata,
            dataType: 'json',
            method: 'POST',
            success:function(data){
  $('#' + div).html(data.view);
}
});
        });
      });
      </script>

<table  style='width:100%; text-align:center;' class='table '>
    <thead>
      <tr >
        <th>
          <div class='row'>
            <div class='col'>Month</div>
            <div class='col'>Expenses Budget (RM)</div>
            <div class='col'>Used Amount (RM)</div>
            <div class='col'>Budget Balance (RM)</div>
            <div class='col'>Percentage of Use (%)</div>
            <div class='col'>Expenses Details</div>
          </div>
        </th>
      </tr>
    </thead>
    ";

    $view.="
    <tr>
    <td>
      <div class='row'>
        <div class='col'><b>January</b></div>
        <div class='col'>".$budgetallocation."</div>
        <div class='col' id='actual1'>".$actual1."</div>
        <div class='col' id='balance1'>".$balance1."</div>
        <div class='col' id='expensesprogress1' style='text-align:center; vertical-align:middle;'>".$expensesprogress1."</div>
        <div class='col'>
          <button class='btn btn-sm btn-link collapsed viewmore' id='janexpensescol' type='button' data-toggle='collapse' data-target='#janexpenses' aria-expanded='false' data-month='1' data-place='showexpenses1' data-balance='".$balance1."'>
            <i class='fas fa-caret-down'></i>
          </button>
        </div>
      </div>
    </td>
    </tr>

    <tr>
    <td class='zeroPadding' style='padding:0 !important;'><div class='collapse out' id='janexpenses'>
    <div id='showexpenses1'></div>
    </div>
    </td>
    </tr>

    <tr >
    <td>
      <div class='row'>
        <div class='col'><b>February</b></div>
        <div class='col'>".$budgetallocation."</div>
        <div class='col' id='actual2'>".$actual2."</div>
        <div class='col' id='balance2'>".$balance2."</div>
        <div class='col' id='expensesprogress2' style='text-align:center; vertical-align:middle;'>".$expensesprogress2."</div>
        <div class='col'>
          <button class='btn btn-sm btn-link collapsed viewmore' type='button' data-toggle='collapse' data-target='#febexpenses' aria-expanded='false' data-month='2' data-place='showexpenses2' data-balance='".$balance2."'>
            <i class='fas fa-caret-down'></i>
          </button>
        </div>
      </div>
    </td>
    </tr>

    <tr>
    <td class='zeroPadding' style='padding:0 !important;'><div class='collapse out' id='febexpenses'>
    <div id='showexpenses2'></div>
    </div></td>
    </tr>

    <tr  >
    <td>
      <div class='row'>
        <div class='col'><b>March</b></div>
        <div class='col'>".$budgetallocation."</div>
        <div class='col' id='actual3'>".$actual3."</div>
        <div class='col' id='balance3'>".$balance3."</div>
        <div class='col' id='expensesprogress3' style='text-align:center; vertical-align:middle;'>".$expensesprogress3."</div>
        <div class='col'>
          <button class='btn btn-sm btn-link collapsed viewmore' type='button' data-toggle='collapse' data-target='#marexpenses' aria-expanded='false'  data-month='3' data-place='showexpenses3' data-balance='".$balance3."'>
            <i class='fas fa-caret-down'></i>
          </button>
        </div>
      </div>
    </td>
    </tr>

    <tr>
    <td class='zeroPadding' style='padding:0 !important;'><div class='collapse out' id='marexpenses'>
    <div id='showexpenses3'></div>
    </div></td>
    </tr>

    <tr>
    <td>
      <div class='row'>
        <div class='col'><b>April</b></div>
        <div class='col'>".$budgetallocation."</div>
        <div class='col' id='actual4'>".$actual4."</div>
        <div class='col' id='balance4'>".$balance4."</div>
        <div class='col' id='expensesprogress4' style='text-align:center; vertical-align:middle;'>".$expensesprogress4."</div>
        <div class='col'>
          <button class='btn btn-sm btn-link collapsed viewmore' type='button' data-toggle='collapse' data-target='#aprexpenses' aria-expanded='false' data-month='4' data-place='showexpenses4' data-balance='".$balance4."'>
            <i class='fas fa-caret-down'></i>
          </button>
        </div>
      </div>
    </td>
    </tr>

    <tr>
    <td class='zeroPadding' style='padding:0 !important;'><div class='collapse out' id='aprexpenses'>
    <div id='showexpenses4'></div>
    </div></td>
    </tr>

    <tr  >
    <td>
      <div class='row'>
        <div class='col'><b>May</b></div>
        <div class='col'>".$budgetallocation."</div>
        <div class='col' id='actual5'>".$actual5."</div>
        <div class='col' id='balance5'>".$balance5."</div>
        <div class='col' id='expensesprogress5' style='text-align:center; vertical-align:middle;'>".$expensesprogress5."</div>
        <div class='col'>
          <button class='btn btn-sm btn-link collapsed viewmore' type='button' data-toggle='collapse' data-target='#mayexpenses' aria-expanded='false' data-month='5' data-place='showexpenses5' data-balance='".$balance5."'>
            <i class='fas fa-caret-down'></i>
          </button>
        </div>
      </div>
    </td>
    </tr>

    <tr>
    <td class='zeroPadding' style='padding:0 !important;'><div class='collapse out' id='mayexpenses'>
    <div id='showexpenses5'></div>
    </div></td>
    </tr>

    <tr  >
    <td>
      <div class='row'>
        <div class='col'><b>June</b></div>
        <div class='col'>".$budgetallocation."</div>
        <div class='col' id='actual6'>".$actual6."</div>
        <div class='col' id='balance6'>".$balance6."</div>
        <div class='col' id='expensesprogress6' style='text-align:center; vertical-align:middle;'>".$expensesprogress6."</div>
        <div class='col'>
          <button class='btn btn-sm btn-link collapsed viewmore' type='button' data-toggle='collapse' data-target='#junexpenses' aria-expanded='false' data-month='6' data-place='showexpenses6' data-balance='".$balance6."'>
            <i class='fas fa-caret-down'></i>
          </button>
        </div>
      </div>
    </td>
    </tr>

    <tr>
    <td class='zeroPadding' style='padding:0 !important;'><div class='collapse out' id='junexpenses'>
    <div id='showexpenses6'></div>
    </div></td>
    </tr>

    <tr  >
    <td>
      <div class='row'>
        <div class='col'><b>July</b></div>
        <div class='col'>".$budgetallocation."</div>
        <div class='col' id='actual7'>".$actual7."</div>
        <div class='col' id='balance7'>".$balance7."</div>
        <div class='col' id='expensesprogress7' style='text-align:center; vertical-align:middle;'>".$expensesprogress7."</div>
        <div class='col'>
          <button class='btn btn-sm btn-link collapsed viewmore' type='button' data-toggle='collapse' data-target='#julyexpenses' aria-expanded='false' data-month='7' data-place='showexpenses7' data-balance='".$balance7."'>
            <i class='fas fa-caret-down'></i>
          </button>
        </div>
      </div>
    </td>
    </tr>

    <tr>
    <td class='zeroPadding' style='padding:0 !important;'><div class='collapse out' id='julyexpenses'>
    <div id='showexpenses7'></div>
    </div></td>
    </tr>

    <tr>
    <td>
      <div class='row'>
        <div class='col'><b>August</b></div>
        <div class='col'>".$budgetallocation."</div>
        <div class='col' id='actual8'>".$actual8."</div>
        <div class='col' id='balance8'>".$balance8."</div>
        <div class='col' id='expensesprogress8' style='text-align:center; vertical-align:middle;'>".$expensesprogress8."</div>
        <div class='col'>
          <button class='btn btn-sm btn-link collapsed viewmore' type='button' data-toggle='collapse' data-target='#augexpenses' aria-expanded='false'data-month='8' data-place='showexpenses8' data-balance='".$balance8."'>
            <i class='fas fa-caret-down'></i>
          </button>
        </div>
      </div>
    </td>
    </tr>

    <tr>
    <td class='zeroPadding' style='padding:0 !important;'><div class='collapse out' id='augexpenses'>
    <div id='showexpenses8'></div>
    </div></td>
    </tr>

    <tr  >
    <td>
      <div class='row'>
        <div class='col'><b>September</b></div>
        <div class='col'>".$budgetallocation."</div>
        <div class='col' id='actual9'>".$actual9."</div>
        <div class='col' id='balance9'>".$balance9."</div>
        <div class='col' id='expensesprogress9' style='text-align:center; vertical-align:middle;'>".$expensesprogress9."</div>
        <div class='col'>
          <button class='btn btn-sm btn-link collapsed viewmore' type='button' data-toggle='collapse' data-target='#septexpenses' aria-expanded='false' data-month='9' data-place='showexpenses9' data-balance='".$balance9."'>
            <i class='fas fa-caret-down'></i>
          </button>
        </div>
      </div>
    </td>
    </tr>

    <tr>
    <td class='zeroPadding' style='padding:0 !important;'><div class='collapse out' id='septexpenses'>
    <div id='showexpenses9'></div>
    </div></td>
    </tr>

    <tr  >
    <td>
      <div class='row'>
        <div class='col'><b>October</b></div>
        <div class='col'>".$budgetallocation."</div>
        <div class='col' id='actual10'>".$actual10."</div>
        <div class='col' id='balance10'>".$balance10."</div>
        <div class='col' id='expensesprogress10' style='text-align:center; vertical-align:middle;'>".$expensesprogress10."</div>
        <div class='col'>
          <button class='btn btn-sm btn-link collapsed viewmore' type='button' data-toggle='collapse' data-target='#octexpenses' aria-expanded='false' data-month='10' data-place='showexpenses10' data-balance='".$balance10."'>
            <i class='fas fa-caret-down'></i>
          </button>
        </div>
      </div>
    </td>
    </tr>

    <tr>
    <td class='zeroPadding' style='padding:0 !important;'><div class='collapse out' id='octexpenses'>
    <div id='showexpenses10'></div>
    </div></td>
    </tr>

    <tr  >
    <td>
      <div class='row'>
        <div class='col'><b>November</b></div>
        <div class='col'>".$budgetallocation."</div>
        <div class='col' id='actual11'>".$actual11."</div>
        <div class='col' id='balance11'>".$balance11."</div>
        <div class='col' id='expensesprogress11' style='text-align:center; vertical-align:middle;'>".$expensesprogress11."</div>
        <div class='col'>
          <button class='btn btn-sm btn-link collapsed viewmore' type='button' data-toggle='collapse' data-target='#novexpenses' aria-expanded='false' data-month='11' data-place='showexpenses11' data-balance='".$balance11."'>
            <i class='fas fa-caret-down'></i>
          </button>
        </div>
      </div>
    </td>
    </tr>

    <tr>
    <td class='zeroPadding' style='padding:0 !important;'><div class='collapse out' id='novexpenses'>
    <div id='showexpenses11'></div>
    </div></td>
    </tr>

    <tr  >
    <td>
      <div class='row'>
        <div class='col'><b>December</b></div>
        <div class='col'>".$budgetallocation."</div>
        <div class='col' id='actual12'>".$actual12."</div>
        <div class='col' id='balance12'>".$balance12."</div>
        <div class='col' id='expensesprogress12' style='text-align:center; vertical-align:middle;'>".$expensesprogress12."</div>
        <div class='col'>
          <button class='btn btn-sm btn-link collapsed viewmore' type='button' data-toggle='collapse' data-target='#decexpenses' aria-expanded='false' data-month='12' data-place='showexpenses12' data-balance='".$balance12."'>
            <i class='fas fa-caret-down'></i>
          </button>
        </div>
      </div>
    </td>
    </tr>

    <tr>
    <td class='zeroPadding' style='padding:0 !important;'><div class='collapse out' id='decexpenses'>
    <div id='showexpenses12'></div>
    </div></td>
    </tr>
   
    </table>

    <script type='text/javascript'>
      $('.collapse').on('show.bs.collapse', function() {
        $(this).parent().removeClass('zeroPadding');
      });
      
      $('.collapse').on('hide.bs.collapse', function() {
        $(this).parent().addClass('zeroPadding');
      });
    </script>
  ";

  $view.="
  
  ";

}
else{
  $view.= 
          "
          <br><br>
          <div class='card box rounded-0'>
            <div class='card-body'>
              <b>No data found</b>
            </div>
          </div>
          ";
}

  echo json_encode($view);
}
?>