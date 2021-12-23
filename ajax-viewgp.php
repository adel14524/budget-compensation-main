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
  $month = escape(Input::get('month'));

  $mainallocationobject = new Mainallocation();
  $data2 = $mainallocationobject->searchmain($comp,$year);

  function totalnpstatus($data,$data2,$comp,$year){
    $Expense1object = new Expense();
    $suballocationobject = new Suballocation();

    $status="";
    $totalnp=0;$netprofit1=0;$netprofit2=0;$netprofit3=0;$netprofit4=0;$netprofit5=0;$netprofit6=0;
    $netprofit7=0;$netprofit8=0;$netprofit9=0;$netprofit10=0;$netprofit11=0;$netprofit12=0;

    $initialobject= new Budgetinitial();
    $initialresult=$initialobject->searchcompanyyear($comp,$year);

    if ($data2) {
      $amountbonus1=0;$amountbonus2=0;$amountbonus3=0;$amountbonus4=0;$amountbonus5=0;
      $amountbonus6=0;$amountbonus7=0;$amountbonus8=0;$amountbonus9=0;$amountbonus10=0;
      $amountbonus11=0;$amountbonus12=0;

      foreach ($data2 as $row) {
        if ($row->categoryName == "Bonus") {
          $Bonusobject= new Calculation();
          $bonusresult=$Bonusobject->searchbonusmainid($row->budgetMainAllocationID);

          if ($bonusresult) {
            foreach ($bonusresult as $row) {
              $month = date("m",strtotime($row->date));

              if ($month == "01") {
                $amountbonus1+=$row->Total_Bonus;
              }
              elseif ($month == "02") {
                $amountbonus2+=$row->Total_Bonus;
              }
              elseif ($month == "03") {
                $amountbonus3+=$row->Total_Bonus;
              }
              elseif ($month == "04") {
                $amountbonus4+=$row->Total_Bonus;
              }
              elseif ($month == "05") {
                $amountbonus5+=$row->Total_Bonus;
              }
              elseif ($month == "06") {
                $amountbonus6+=$row->Total_Bonus;
              }
              elseif ($month == "07") {
                $amountbonus7+=$row->Total_Bonus;
              }
              elseif ($month == "08") {
                $amountbonus8+=$row->Total_Bonus;
              }
              elseif ($month == "09") {
                $amountbonus9+=$row->Total_Bonus;
              }
              elseif ($month == "10") {
                $amountbonus10+=$row->Total_Bonus;
              }
              elseif ($month == "11") {
                $amountbonus11+=$row->Total_Bonus;
              }
              elseif ($month == "12") {
                $amountbonus12+=$row->Total_Bonus;
              }
            }
          }
        }
        elseif ($row->categoryName == "Others") {
          $new = $suballocationobject->searchsub($row->budgetMainAllocationID);

          $amountsub1=0;$amountsub2=0;$amountsub3=0;$amountsub4=0;$amountsub5=0;$amountsub6=0;
          $amountsub7=0;$amountsub8=0;$amountsub9=0;$amountsub10=0;$amountsub11=0;$amountsub12=0;

          foreach ($new as $row) {
            $expensesresult=$Expense1object->searchbudgetsubid($row->budgetSubAllocationID);

            if ($expensesresult) {
              foreach ($expensesresult as $row) {
                $month = date("m",strtotime($row->date));

                if ($month == "01") {
                  $amountsub1+=$row->amount;
                }
                elseif ($month == "02") {
                  $amountsub2+=$row->amount;
                }
                elseif ($month == "03") {
                  $amountsub3+=$row->amount;
                }
                elseif ($month == "04") {
                  $amountsub4+=$row->amount;
                }
                elseif ($month == "05") {
                  $amountsub5+=$row->amount;
                }
                elseif ($month == "06") {
                  $amountsub6+=$row->amount;
                }
                elseif ($month == "07") {
                  $amountsub7+=$row->amount;
                }
                elseif ($month == "08") {
                  $amountsub8+=$row->amount;
                }
                elseif ($month == "09") {
                  $amountsub9+=$row->amount;
                }
                elseif ($month == "10") {
                  $amountsub10+=$row->amount;
                }
                elseif ($month == "11") {
                  $amountsub11+=$row->amount;
                }
                elseif ($month == "12") {
                  $amountsub12+=$row->amount;
                }
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
    }
  }

  $view="";

  $view.="
    <div class='card my-3'>
      <div class='card-body'>
        <div class='row'>
          <div class='col-12 col-xl-4'>
            <h6>Budget Status</h6>".$netprofitnew."
          </div>

          <div class='col-12 col-xl-4'>
            <h6>Next Year Budget Allocation (%)</h6>".$percentinitial."
          </div>

          <div class='col-12 col-xl-4'>
            <h6>Next Year Total Budget (RM)</h6>".$totalbudget."
          </div>
        </div>
      </div>
    </div>
  ";

  $revenueobject = new Revenue (); 
  $revresult = $revenueobject->searchRev($comp,$year);

  $revenueobject1 = new Revenue ();
  $costresult = $revenueobject1->searchCostOfGoodSold($comp,$year,"costgoodsold");

  if($costresult && $data2 && $revresult){
    $amountbonus1=0;$amountbonus2=0;$amountbonus3=0;$amountbonus4=0;$amountbonus5=0;
    $amountbonus6=0;$amountbonus7=0;$amountbonus8=0;$amountbonus9=0;$amountbonus10=0;
    $amountbonus11=0;$amountbonus12=0;

    foreach ($revresult as $row1){
      if($row1->typeRevenue==="actualrev"){
        foreach ($data2 as $row) {
          $suballocationobject = new Suballocation();

          if($row->categoryName == "Others"){
            $new = $suballocationobject->searchsub($row->budgetMainAllocationID);
            
            $amountsub1=0;$amountsub2=0;$amountsub3=0;$amountsub4=0;$amountsub5=0;$amountsub6=0;
            $amountsub7=0;$amountsub8=0;$amountsub9=0;$amountsub10=0;$amountsub11=0;$amountsub12=0;

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

        foreach ($costresult as $row) {
          $grossprofit1=0;$grossprofit2=0;$grossprofit3=0;$grossprofit4=0;$grossprofit5=0;$grossprofit6=0;
          $grossprofit7=0;$grossprofit8=0;$grossprofit9=0;$grossprofit10=0;$grossprofit11=0;$grossprofit12=0;

          $netprofit1=0;$netprofit2=0;$netprofit3=0;$netprofit4=0;$netprofit5=0;$netprofit6=0;
          $netprofit7=0;$netprofit8=0;$netprofit9=0;$netprofit10=0;$netprofit11=0;$netprofit12=0;

          $grossprofit1=$row1->january - $row->january;
          $grossprofit2=$row1->february - $row->february;
          $grossprofit3=$row1->march - $row->march;
          $grossprofit4=$row1->april - $row->april;
          $grossprofit5=$row1->may - $row->may;
          $grossprofit6=$row1->june - $row->june;
          $grossprofit7=$row1->july - $row->july;
          $grossprofit8=$row1->august - $row->august;
          $grossprofit9=$row1->september - $row->september;
          $grossprofit10=$row1->october - $row->october;
          $grossprofit11=$row1->november - $row->november;
          $grossprofit12=$row1->december - $row->december;

          $netprofit1=$grossprofit1 - $actual1;
          $netprofit2=$grossprofit2 - $actual2;
          $netprofit3=$grossprofit3 - $actual3;
          $netprofit4=$grossprofit4 - $actual4;
          $netprofit5=$grossprofit5 - $actual5;
          $netprofit6=$grossprofit6 - $actual6;
          $netprofit7=$grossprofit7 - $actual7;
          $netprofit8=$grossprofit8 - $actual8;
          $netprofit9=$grossprofit9 - $actual9;
          $netprofit10=$grossprofit10 - $actual10;
          $netprofit11=$grossprofit11 - $actual11;
          $netprofit12=$grossprofit12 - $actual12;

          $totalnp=$netprofit1+$netprofit2+$netprofit3+$netprofit4+$netprofit5+$netprofit6+$netprofit7+$netprofit8+$netprofit9+$netprofit10+$netprofit11+$netprofit12;

          $view .="
            <table class='table'>
              <thead>
                <tr style='text-align: center'>
                  <th >Month</th>
                  <th >Revenue (RM)</th>
                  <th >Cost of Goods Sold (RM)</th> 
                  <th >Gross Profit (RM)</th> 
                  <th >Expenses (RM)</th> 
                  <th >Net Profit (RM)</th>
                </tr>
              </thead>

              <div class='table-responsive text-nowrap'>
              <br>
              <tbody style='text-align: center'>
                <tr>
                  <td><b>January</b></td>
                  <td>".$row1->january."</td>
                  <td></td>
                  <td>".$row->january."</td>
                  <td>".$actual1."</td>
                  <td>".$netprofit1."</td>
                </tr>
                <tr>
                  <td><b>February</b></td>
                  <td>".$row1->february."</td>
                  <td></td>
                  <td>".$row->february."</td>
                  <td>".$actual2."</td>
                  <td>".$netprofit2."</td>
                </tr>
                <tr>
                  <td><b>March</b></td>
                  <td>".$row1->march."</td>
                  <td></td>
                  <td>".$row->march."</td>
                  <td>".$actual3."</td>
                  <td>".$netprofit3."</td>
                </tr>
                <tr>
                  <td><b>April</b></td>
                  <td>".$row1->april."</td>
                  <td></td>
                  <td>".$row->april."</td>
                  <td>".$actual4."</td>
                  <td>".$netprofit4."</td>
                </tr>
                <tr>
                  <td><b>May</b></td>
                  <td>".$row1->may."</td>
                  <td></td>
                  <td>".$row->may."</td>
                  <td>".$actual5."</td>
                  <td>".$netprofit5."</td>
                </tr>
                <tr>
                  <td><b>June</b></td>
                  <td>".$row1->june."</td>
                  <td></td>
                  <td>".$row->june."</td>
                  <td>".$actual6."</td>
                  <td>".$netprofit6."</td>
                </tr>
                <tr>
                  <td><b>July</b></td>
                  <td>".$row1->july."</td>
                  <td></td>
                  <td>".$row->july."</td>
                  <td>".$actual7."</td>
                  <td>".$netprofit7."</td>
                </tr>
                <tr>
                  <td><b>August</b></td>
                  <td>".$row1->august."</td>
                  <td></td>
                  <td>".$row->august."</td>
                  <td>".$actual8."</td>
                  <td>".$netprofit8."</td>
                </tr>
                <tr>
                  <td><b>September</b></td>
                  <td>".$row1->september."</td>
                  <td></td>
                  <td>".$row->september."</td>
                  <td>".$actual9."</td>
                  <td>".$netprofit9."</td>
                </tr>
                <tr>
                  <td><b>October</b></td>
                  <td>".$row1->october."</td>
                  <td></td>
                  <td>".$row->october."</td>
                  <td>".$actual10."</td>
                  <td>".$netprofit10."</td>
                </tr>
                <tr>
                  <td><b>November</b></td>
                  <td>".$row1->november."</td>
                  <td></td>
                  <td>".$row->november."</td>
                  <td>".$actual11."</td>
                  <td>".$netprofit11."</td>
                </tr>
                <tr>
                  <td><b>December</b></td>
                  <td>".$row1->december."</td>
                  <td></td>
                  <td>".$row->december."</td>
                  <td>".$actual2."</td>
                  <td>".$netprofit12."</td>
                </tr>

                <tr>
                  <td><b>TOTAL<b></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td><b>".$totalnp."<b></td>
                </tr>
              </tbody>
            </table>     
          ";
        }
      }
    }
  }
  
echo json_encode($view);
}
?>