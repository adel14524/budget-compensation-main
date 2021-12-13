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
 

$mainallocationobject = new Mainallocation();
$data2 = $mainallocationobject->searchmain($comp,$year);


function totalnp($data,$data2,$comp,$year){
  $Expense1object = new Expense();
  $suballocationobject = new Suballocation();
  $status="";
  $totalnp=0;
  $netprofit1=0;
  $netprofit2=0;
  $netprofit3=0;
  $netprofit4=0;
  $netprofit5=0;
  $netprofit6=0;
  $netprofit7=0;
  $netprofit8=0;
  $netprofit9=0;
  $netprofit10=0;
  $netprofit11=0;
  $netprofit12=0;

 $initialobject= new Budgetinitial();
  $initialresult=$initialobject->searchcompanyyear($comp,$year);
  if ($data2){
  $amountbonus1=0;$amountbonus2=0;$amountbonus3=0;$amountbonus4=0;$amountbonus5=0;
  $amountbonus6=0;$amountbonus7=0;$amountbonus8=0;$amountbonus9=0;$amountbonus10=0;
  $amountbonus11=0;$amountbonus12=0;
  foreach ($data2 as $row) {
    if($row->categoryName == "Others"){
      $new = $suballocationobject->searchsub($row->budgetMainAllocationID);
      $amountsub1=0;
      $amountsub2=0;
      $amountsub3=0;
      $amountsub4=0;
      $amountsub5=0;
      $amountsub6=0;
      $amountsub7=0;
      $amountsub8=0;
      $amountsub9=0;
      $amountsub10=0;
      $amountsub11=0;
      $amountsub12=0;
      foreach ($new as $row) { 
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

 elseif($row->categoryName=="Bonus"){
        $Bonusobject= new Calculation();
        $bonusresult=$Bonusobject->searchbonusmainid($row->budgetMainAllocationID);

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


foreach ($data as $row) {
 $netprofit1=$row->january-$actual1;
 $netprofit2=$row->february-$actual2;
 $netprofit3=$row->march-$actual3;
 $netprofit4=$row->april-$actual4;
 $netprofit5=$row->may-$actual5;
 $netprofit6=$row->june-$actual6;
 $netprofit7=$row->july-$actual7;
 $netprofit8=$row->august-$actual8;
 $netprofit9=$row->september-$actual9;
 $netprofit10=$row->october-$actual10;
 $netprofit11=$row->november-$actual11;
 $netprofit12=$row->december-$actual12;

}


$totalnp=$netprofit1+$netprofit2+$netprofit3+$netprofit4+$netprofit5+$netprofit6+$netprofit7+$netprofit8+$netprofit9+$netprofit10+$netprofit11+$netprofit12;

   if($initialresult){
    foreach($initialresult as $rowinitial){
      if($totalnp>=$rowinitial->netProfitTarget){

        $status="Achieved";
      }
      else{
        $status=" Not Achieved";
      }
    }
  }
    return $status;
  }

}


function totalbudget($data,$data2,$comp,$year){
  $Expense1object = new Expense();
  $suballocationobject = new Suballocation();
   $status="";
   $totalnp=0;
 $netprofit1=0;
 $netprofit2=0;
 $netprofit3=0;
 $netprofit4=0;
 $netprofit5=0;
 $netprofit6=0;
 $netprofit7=0;
 $netprofit8=0;
 $netprofit9=0;
 $netprofit10=0;
 $netprofit11=0;
 $netprofit12=0;

 $initialobject= new Budgetinitial();
  $initialresult=$initialobject->searchcompanyyear($comp,$year);
  if ($data2){
  $amountbonus1=0;$amountbonus2=0;$amountbonus3=0;$amountbonus4=0;$amountbonus5=0;
  $amountbonus6=0;$amountbonus7=0;$amountbonus8=0;$amountbonus9=0;$amountbonus10=0;
  $amountbonus11=0;$amountbonus12=0;
  foreach ($data2 as $row) {
    if($row->categoryName == "Others"){
      $new = $suballocationobject->searchsub($row->budgetMainAllocationID);
      $amountsub1=0;
      $amountsub2=0;
      $amountsub3=0;
      $amountsub4=0;
      $amountsub5=0;
      $amountsub6=0;
      $amountsub7=0;
      $amountsub8=0;
      $amountsub9=0;
      $amountsub10=0;
      $amountsub11=0;
      $amountsub12=0;
      foreach ($new as $row) { 
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

  elseif($row->categoryName=="Bonus"){
        $Bonusobject= new Calculation();
        $bonusresult=$Bonusobject->searchbonusmainid($row->budgetMainAllocationID);

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


if($data){
  foreach ($data as $row) {
   $netprofit1=$row->january-$actual1;
   $netprofit2=$row->february-$actual2;
   $netprofit3=$row->march-$actual3;
   $netprofit4=$row->april-$actual4;
   $netprofit5=$row->may-$actual5;
   $netprofit6=$row->june-$actual6;
   $netprofit7=$row->july-$actual7;
   $netprofit8=$row->august-$actual8;
   $netprofit9=$row->september-$actual9;
   $netprofit10=$row->october-$actual10;
   $netprofit11=$row->november-$actual11;
   $netprofit12=$row->december-$actual12;

 }

 $totalnp=$netprofit1+$netprofit2+$netprofit3+$netprofit4+$netprofit5+$netprofit6+$netprofit7+$netprofit8+$netprofit9+$netprofit10+$netprofit11+$netprofit12;
}
else{
  $totalnp=0;
}

if($initialresult){
  foreach($initialresult as $rowinitial){
    if($totalnp>=$rowinitial->netProfitTarget){

      $status="Achieved";
      $percentinitial=$rowinitial->percentBudget;
      $budgetallocated=($percentinitial/100)*$totalnp;
    }
    else{
      $status=" Not Achieved";
      $percentinitial=0;
      $budgetallocated=0;
    }
  }
}
else{
  $budgetallocated=0;
}

return $budgetallocated;
}

}


$Grossobject = new Grossprofit();
$data = $Grossobject->searchgrossprofit($comp,$year);

$totalbudget=totalbudget($data,$data2,$comp,$year);



  $Expense1object = new Expense();
 
  $netprofitnew="";
  if($data){
   $netprofitnew=totalnp($data,$data2,$comp,$year);  
 }



$initialobject= new Budgetinitial();
$initialresult=$initialobject->searchcompanyyear($comp,$year);
$percentinitial=0;
$budgetallocated=0;
if($initialresult){
  foreach($initialresult as $rowinitial ){
    if($netprofitnew=="Achieved"){
 $percentinitial=$rowinitial->percentBudget;
    }
    else{
      $percentinitial=0;
    }   
  }

}

$view="";


 $revenueobject = new Revenue (); 
 $revresult = $revenueobject->searchRev($comp,$year);

 if($data && $data2 ){
  $amountbonus1=0;$amountbonus2=0;$amountbonus3=0;$amountbonus4=0;$amountbonus5=0;
  $amountbonus6=0;$amountbonus7=0;$amountbonus8=0;$amountbonus9=0;$amountbonus10=0;
  $amountbonus11=0;$amountbonus12=0;
    
  foreach ($data2 as $row) {
            $suballocationobject = new Suballocation();
            if($row->categoryName == "Others"){
              $new = $suballocationobject->searchsub($row->budgetMainAllocationID);
              $amountsub1=0;
              $amountsub2=0;
              $amountsub3=0;
              $amountsub4=0;
              $amountsub5=0;
              $amountsub6=0;
              $amountsub7=0;
              $amountsub8=0;
              $amountsub9=0;
              $amountsub10=0;
              $amountsub11=0;
              $amountsub12=0;
              foreach ($new as $row) { 
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

         elseif($row->categoryName=="Bonus"){
        $Bonusobject= new Calculation();
        $bonusresult=$Bonusobject->searchbonusmainid($row->budgetMainAllocationID);

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

       foreach ($data as $row) {
         $netprofit1=$row->january-$actual1;
         $netprofit2=$row->february-$actual2;
         $netprofit3=$row->march-$actual3;
         $netprofit4=$row->april-$actual4;
         $netprofit5=$row->may-$actual5;
         $netprofit6=$row->june-$actual6;
         $netprofit7=$row->july-$actual7;
         $netprofit8=$row->august-$actual8;
         $netprofit9=$row->september-$actual9;
         $netprofit10=$row->october-$actual10;
         $netprofit11=$row->november-$actual11;
         $netprofit12=$row->december-$actual12;

         $totalnp=$netprofit1+$netprofit2+$netprofit3+$netprofit4+$netprofit5+$netprofit6+$netprofit7+$netprofit8+$netprofit9+$netprofit10+$netprofit11+$netprofit12;

         $view .=
  "
<canvas id='myChart' width='100' height='50'></canvas>
          <script>
          var ctx = document.getElementById('myChart').getContext('2d');
          var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels:['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November','December'],
              datasets: [{
                label: 'Net Profit ".$year."',
                data: [".$netprofit1.",".$netprofit2.",".$netprofit3.",".$netprofit4.",".$netprofit5.",".$netprofit6.",".$netprofit7.",".$netprofit8.",".$netprofit9.",".$netprofit10.",".$netprofit11.",".$netprofit12."],
                backgroundColor:
                'rgba(54, 162, 235, 0.2)',
                borderColor: 
                'rgba(54, 162, 235, 1)',
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
  ";
       }

   
  

}





echo json_encode($view);
}
?>