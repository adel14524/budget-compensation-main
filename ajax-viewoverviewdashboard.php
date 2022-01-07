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

    $budgetobject = new Budgetinitial();
    $compbudget = $budgetobject->searchBudgetCompany($comp,$year);

    $mainallocationobject = new Mainallocation();
    $suballocationobject = new Suballocation();
    $Bonusobject = new Calculation();

    $data2 = $mainallocationobject->searchmain($comp,$year);

    $bonusallocation = $mainallocationobject->searchmaincategory($comp,$year,"Bonus");

    if ($bonusallocation) {
        $bonusdata=$Bonusobject->searchbonusmainid($bonusallocation->budgetMainAllocationID);
    }
    
    $othersallocation = $mainallocationobject->searchmaincategory($comp,$year,"Others");

    if ($othersallocation) {
        $othersdata = $suballocationobject->searchsub($othersallocation->budgetMainAllocationID);
    }
    
    $revenueobject = new Revenue();
    $actualrevdata = $revenueobject->searchRevenueactual($comp,$year,"actualrev");

    $costobject = new Revenue();
    $costdata1 = $costobject->searchCostOfGoodSold($comp,$year,"costgoodsold");

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

    function totalexpensesyear($maindata){
        if ($maindata) {
            $amountbonus1=0;$amountbonus2=0;$amountbonus3=0;$amountbonus4=0;$amountbonus5=0;
            $amountbonus6=0;$amountbonus7=0;$amountbonus8=0;$amountbonus9=0;$amountbonus10=0;
            $amountbonus11=0;$amountbonus12=0;

            $suballocationobject = new Suballocation();

            foreach ($maindata as $row) {
                $data3 = $suballocationobject->searchsub($row->budgetMainAllocationID);

                $amountsub1=0;$amountsub2=0;$amountsub3=0;$amountsub4=0;$amountsub5=0;
                $amountsub6=0;$amountsub7=0;$amountsub8=0;$amountsub9=0; $amountsub10=0;
                $amountsub11=0;$amountsub12=0;

                if ($row->categoryName == "Bonus") {
                    $Bonusobject= new Calculation();
                    $bonusresult=$Bonusobject->searchbonusmainid($row->budgetMainAllocationID);
                    $bonusallocation=$row->budgetAllocated;

                    if ($bonusresult) {
                        foreach ($bonusresult as $row1) {
                            $month = date("m",strtotime($row1->date));

                            if ($month == "01") {
                                $amountbonus1 += $row1->Total_Bonus;
                            }
                            elseif ($month == "02") {
                                $amountbonus2 += $row1->Total_Bonus;
                            }
                            elseif ($month == "03") {
                                $amountbonus3 += $row1->Total_Bonus;
                            }
                            elseif ($month == "04") {
                                $amountbonus4 += $row1->Total_Bonus;
                            }
                            elseif ($month == "05") {
                                $amountbonus5 += $row1->Total_Bonus;
                            }
                            elseif ($month == "06") {
                                $amountbonus6 += $row1->Total_Bonus;
                            }
                            elseif ($month == "07") {
                                $amountbonus7 += $row1->Total_Bonus;
                            }
                            elseif ($month == "08") {
                                $amountbonus8 += $row1->Total_Bonus;
                            }
                            elseif ($month == "09") {
                                $amountbonus9 += $row1->Total_Bonus;
                            }
                            elseif ($month == "10") {
                                $amountbonus10 += $row1->Total_Bonus;
                            }
                            elseif ($month == "11") {
                                $amountbonus11 += $row1->Total_Bonus;
                            }
                            elseif ($month == "12") {
                                $amountbonus12 += $row1->Total_Bonus;
                            }
                        }
                    }
                }
                elseif ($row->categoryName == "Others") {
                    foreach ($data3 as $row2) {
                        $Expense1object = new Expense();
                        $expensesresult=$Expense1object->searchbudgetsubid($row2->budgetSubAllocationID);

                        if ($expensesresult) {
                            foreach ($expensesresult as $row3) {
                                $month = date("m",strtotime($row3->date));

                                if ($month == "01") {
                                    $amountsub1 += $row3->amount;
                                }
                                elseif ($month == "02") {
                                    $amountsub2 += $row3->amount;
                                }
                                elseif ($month == "03") {
                                    $amountsub3 += $row3->amount;
                                }
                                elseif ($month == "04") {
                                    $amountsub2 += $row3->amount;
                                }
                                elseif ($month == "05") {
                                    $amountsub2 += $row3->amount;
                                }
                                elseif ($month == "06") {
                                    $amountsub2 += $row3->amount;
                                }
                                elseif ($month == "07") {
                                    $amountsub2 += $row3->amount;
                                }
                                elseif ($month == "08") {
                                    $amountsub2 += $row3->amount;
                                }
                                elseif ($month == "09") {
                                    $amountsub2 += $row3->amount;
                                }
                                elseif ($month == "10") {
                                    $amountsub2 += $row3->amount;
                                }
                                elseif ($month == "11") {
                                    $amountsub2 += $row3->amount;
                                }
                                elseif ($month == "12") {
                                    $amountsub2 += $row3->amount;
                                }
                            }
                        }
                    }
                }

                if ($data3) {
                    $othersallocation=0;
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

            $totalexp = $actual1 + $actual2 + $actual3 + $actual4 + $actual5 + $actual6 + $actual7 + $actual8 + $actual9 + $actual10 + $actual11 + $actual12;
        }
        else{
            $totalexp = 0;
        }

        return $totalexp; 
    }

    function totalrevyear($revenuedata){
        if ($revenuedata) {
            $revJan=0;$revFeb=0;$revMar=0;$revApr=0;$revMay=0;$revJun=0;
            $revJul=0;$revAug=0;$revSep=0;$revOct=0;$revNov=0;$revDec=0;

            $revJan = $revenuedata->january;
            $revFeb = $revenuedata->february;
            $revMar = $revenuedata->march;
            $revApr = $revenuedata->april;
            $revMay = $revenuedata->may;
            $revJun = $revenuedata->june;
            $revJul = $revenuedata->july;
            $revAug = $revenuedata->august;
            $revSep = $revenuedata->september;
            $revOct = $revenuedata->october;
            $revNov = $revenuedata->november;
            $revDec = $revenuedata->december;

            $totalrev = $revJan + $revFeb + $revMar + $revApr + $revMay + $revJun + $revJul + $revAug + $revSep + $revOct + $revNov + $revDec;
            
        }
        else{
            $totalrev = 0;
        }

        return $totalrev;
    }

    function totalnetprofityear($revenuedata,$maindata,$costdata){
        $Expense1object = new Expense();
        $suballocationobject = new Suballocation();

        if ($revenuedata) {
            if ($maindata) {
                $amountbonus1=0;$amountbonus2=0;$amountbonus3=0;$amountbonus4=0;$amountbonus5=0;
                $amountbonus6=0;$amountbonus7=0;$amountbonus8=0;$amountbonus9=0;$amountbonus10=0;
                $amountbonus11=0;$amountbonus12=0;

                foreach ($maindata as $row) {
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
        
                if($costdata) {
                    $grossprofit1=$revenuedata->january - $costdata->january;
                    $grossprofit2=$revenuedata->february - $costdata->february;
                    $grossprofit3=$revenuedata->march - $costdata->march;
                    $grossprofit4=$revenuedata->april - $costdata->april;
                    $grossprofit5=$revenuedata->may - $costdata->may;
                    $grossprofit6=$revenuedata->june - $costdata->june;
                    $grossprofit7=$revenuedata->july - $costdata->july;
                    $grossprofit8=$revenuedata->august - $costdata->august;
                    $grossprofit9=$revenuedata->september - $costdata->september;
                    $grossprofit10=$revenuedata->october - $costdata->october;
                    $grossprofit11=$revenuedata->november - $costdata->november;
                    $grossprofit12=$revenuedata->december - $costdata->december;

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
                }
                else {
                    $grossprofit1=$revenuedata->january - 0;
                    $grossprofit2=$revenuedata->february - 0;
                    $grossprofit3=$revenuedata->march - 0;
                    $grossprofit4=$revenuedata->april - 0;
                    $grossprofit5=$revenuedata->may - 0;
                    $grossprofit6=$revenuedata->june - 0;
                    $grossprofit7=$revenuedata->july - 0;
                    $grossprofit8=$revenuedata->august - 0;
                    $grossprofit9=$revenuedata->september - 0;
                    $grossprofit10=$revenuedata->october - 0;
                    $grossprofit11=$revenuedata->november - 0;
                    $grossprofit12=$revenuedata->december - 0;

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
                }
        
                $totalnp = $netprofit1+$netprofit2+$netprofit3+$netprofit4+$netprofit5+$netprofit6+$netprofit7+$netprofit8+$netprofit9+$netprofit10+$netprofit11+$netprofit12;
            }
            else{
                if($costdata) {
                    $grossprofit1=$revenuedata->january - $costdata->january;
                    $grossprofit2=$revenuedata->february - $costdata->february;
                    $grossprofit3=$revenuedata->march - $costdata->march;
                    $grossprofit4=$revenuedata->april - $costdata->april;
                    $grossprofit5=$revenuedata->may - $costdata->may;
                    $grossprofit6=$revenuedata->june - $costdata->june;
                    $grossprofit7=$revenuedata->july - $costdata->july;
                    $grossprofit8=$revenuedata->august - $costdata->august;
                    $grossprofit9=$revenuedata->september - $costdata->september;
                    $grossprofit10=$revenuedata->october - $costdata->october;
                    $grossprofit11=$revenuedata->november - $costdata->november;
                    $grossprofit12=$revenuedata->december - $costdata->december;

                    $netprofit1=$grossprofit1 - 0;
                    $netprofit2=$grossprofit2 - 0;
                    $netprofit3=$grossprofit3 - 0;
                    $netprofit4=$grossprofit4 - 0;
                    $netprofit5=$grossprofit5 - 0;
                    $netprofit6=$grossprofit6 - 0;
                    $netprofit7=$grossprofit7 - 0;
                    $netprofit8=$grossprofit8 - 0;
                    $netprofit9=$grossprofit9 - 0;
                    $netprofit10=$grossprofit10 - 0;
                    $netprofit11=$grossprofit11 - 0;
                    $netprofit12=$grossprofit12 - 0;
                }
                else {
                    $grossprofit1=$revenuedata->january - 0;
                    $grossprofit2=$revenuedata->february - 0;
                    $grossprofit3=$revenuedata->march - 0;
                    $grossprofit4=$revenuedata->april - 0;
                    $grossprofit5=$revenuedata->may - 0;
                    $grossprofit6=$revenuedata->june - 0;
                    $grossprofit7=$revenuedata->july - 0;
                    $grossprofit8=$revenuedata->august - 0;
                    $grossprofit9=$revenuedata->september - 0;
                    $grossprofit10=$revenuedata->october - 0;
                    $grossprofit11=$revenuedata->november - 0;
                    $grossprofit12=$revenuedata->december - 0;

                    $netprofit1=$grossprofit1 - 0;
                    $netprofit2=$grossprofit2 - 0;
                    $netprofit3=$grossprofit3 - 0;
                    $netprofit4=$grossprofit4 - 0;
                    $netprofit5=$grossprofit5 - 0;
                    $netprofit6=$grossprofit6 - 0;
                    $netprofit7=$grossprofit7 - 0;
                    $netprofit8=$grossprofit8 - 0;
                    $netprofit9=$grossprofit9 - 0;
                    $netprofit10=$grossprofit10 - 0;
                    $netprofit11=$grossprofit11 - 0;
                    $netprofit12=$grossprofit12 - 0;
                }
        
                $totalnp = $netprofit1+$netprofit2+$netprofit3+$netprofit4+$netprofit5+$netprofit6+$netprofit7+$netprofit8+$netprofit9+$netprofit10+$netprofit11+$netprofit12;
            }
        }
        else{
            if ($maindata) {
                $amountbonus1=0;$amountbonus2=0;$amountbonus3=0;$amountbonus4=0;$amountbonus5=0;
                $amountbonus6=0;$amountbonus7=0;$amountbonus8=0;$amountbonus9=0;$amountbonus10=0;
                $amountbonus11=0;$amountbonus12=0;

                foreach ($maindata as $row) {
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
        
                if($costdata) {
                    $grossprofit1=0 - $costdata->january;
                    $grossprofit2=0 - $costdata->february;
                    $grossprofit3=0 - $costdata->march;
                    $grossprofit4=0 - $costdata->april;
                    $grossprofit5=0 - $costdata->may;
                    $grossprofit6=0 - $costdata->june;
                    $grossprofit7=0 - $costdata->july;
                    $grossprofit8=0 - $costdata->august;
                    $grossprofit9=0 - $costdata->september;
                    $grossprofit10=0 - $costdata->october;
                    $grossprofit11=0 - $costdata->november;
                    $grossprofit12=0 - $costdata->december;

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
                }
                else {
                    $grossprofit1=0 - 0;
                    $grossprofit2=0 - 0;
                    $grossprofit3=0 - 0;
                    $grossprofit4=0 - 0;
                    $grossprofit5=0 - 0;
                    $grossprofit6=0 - 0;
                    $grossprofit7=0 - 0;
                    $grossprofit8=0 - 0;
                    $grossprofit9=0 - 0;
                    $grossprofit10=0 - 0;
                    $grossprofit11=0 - 0;
                    $grossprofit12=0 - 0;

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
                }
        
                $totalnp = $netprofit1+$netprofit2+$netprofit3+$netprofit4+$netprofit5+$netprofit6+$netprofit7+$netprofit8+$netprofit9+$netprofit10+$netprofit11+$netprofit12;
            }
            else{
                if($costdata) {
                    $grossprofit1=0 - $costdata->january;
                    $grossprofit2=0 - $costdata->february;
                    $grossprofit3=0 - $costdata->march;
                    $grossprofit4=0 - $costdata->april;
                    $grossprofit5=0 - $costdata->may;
                    $grossprofit6=0 - $costdata->june;
                    $grossprofit7=0 - $costdata->july;
                    $grossprofit8=0 - $costdata->august;
                    $grossprofit9=0 - $costdata->september;
                    $grossprofit10=0 - $costdata->october;
                    $grossprofit11=0 - $costdata->november;
                    $grossprofit12=0 - $costdata->december;

                    $netprofit1=$grossprofit1 - 0;
                    $netprofit2=$grossprofit2 - 0;
                    $netprofit3=$grossprofit3 - 0;
                    $netprofit4=$grossprofit4 - 0;
                    $netprofit5=$grossprofit5 - 0;
                    $netprofit6=$grossprofit6 - 0;
                    $netprofit7=$grossprofit7 - 0;
                    $netprofit8=$grossprofit8 - 0;
                    $netprofit9=$grossprofit9 - 0;
                    $netprofit10=$grossprofit10 - 0;
                    $netprofit11=$grossprofit11 - 01;
                    $netprofit12=$grossprofit12 - 0;
                }
                else {
                    $grossprofit1=0 - 0;
                    $grossprofit2=0 - 0;
                    $grossprofit3=0 - 0;
                    $grossprofit4=0 - 0;
                    $grossprofit5=0- 0;
                    $grossprofit6=0 - 0;
                    $grossprofit7=0 - 0;
                    $grossprofit8=0 - 0;
                    $grossprofit9=0 - 0;
                    $grossprofit10=0- 0;
                    $grossprofit11=0 - 0;
                    $grossprofit12=0 - 0;

                    $netprofit1=$grossprofit1 - 0;
                    $netprofit2=$grossprofit2 - 0;
                    $netprofit3=$grossprofit3 - 0;
                    $netprofit4=$grossprofit4 - 0;
                    $netprofit5=$grossprofit5 - 0;
                    $netprofit6=$grossprofit6 - 0;
                    $netprofit7=$grossprofit7 - 0;
                    $netprofit8=$grossprofit8 - 0;
                    $netprofit9=$grossprofit9 - 0;
                    $netprofit10=$grossprofit10 - 0;
                    $netprofit11=$grossprofit11 - 01;
                    $netprofit12=$grossprofit12 - 0;
                }
        
                $totalnp = $netprofit1+$netprofit2+$netprofit3+$netprofit4+$netprofit5+$netprofit6+$netprofit7+$netprofit8+$netprofit9+$netprofit10+$netprofit11+$netprofit12;
            }
        
        }
        return $totalnp;
    }

    function categorybudgetallocation($maindata){
        $suballocationobject1 = new Suballocation();
        $categoryList = array();
        $colorList = array();
        $amountList = array();
        $resultList = array();

        array_push($categoryList,"Bonus");
        array_push($colorList,"rgb(237, 242, 89)");

        if($maindata){
            foreach ($maindata as $categoryrow) {
                if ($categoryrow->categoryName === "Bonus") {
                    $bonusallocated = $categoryrow->budgetAllocated;
                    array_push($amountList,$bonusallocated);
                }
                elseif ($categoryrow->categoryName === "Others") {
                    $datasub = $suballocationobject1->searchsub($categoryrow->budgetMainAllocationID);
                    if ($datasub) {
                        foreach ($datasub as $rowsub) {
                            $categorydata = $suballocationobject1->searchcategory($rowsub->categoryID);

                            if ($categorydata) {
                                foreach ($categorydata as $categoryrow) {
                                    array_push($categoryList,$categoryrow->category);
                                    array_push($colorList,$categoryrow->rgb);
                                }
                            }
                            $othersallocated = $rowsub->budgetAllocated;
                            array_push($amountList,$othersallocated);
                        }
                    }
                }
            }
        }

        array_push($resultList,$categoryList);
        array_push($resultList,$amountList);
        array_push($resultList,$colorList);

        return $resultList;
    }

    function bonuscategory($bonusresult){
        $amountbonus1=0;$amountbonus2=0;$amountbonus3=0;$amountbonus4=0;$amountbonus5=0;
        $amountbonus6=0;$amountbonus7=0;$amountbonus8=0;$amountbonus9=0;$amountbonus10=0;
        $amountbonus11=0;$amountbonus12=0;
        $bonusamount = array();
            
        if ($bonusresult) {
            foreach ($bonusresult as $row1) {
                $month = date("m",strtotime($row1->date));

                if ($month == "01") {
                    $amountbonus1 += $row1->Total_Bonus;
                }
                elseif ($month == "02") {
                    $amountbonus2 += $row1->Total_Bonus;
                }
                elseif ($month == "03") {
                    $amountbonus3 += $row1->Total_Bonus;
                }
                elseif ($month == "04") {
                    $amountbonus4 += $row1->Total_Bonus;
                }
                elseif ($month == "05") {
                    $amountbonus5 += $row1->Total_Bonus;
                }
                elseif ($month == "06") {
                    $amountbonus6 += $row1->Total_Bonus;
                }
                elseif ($month == "07") {
                    $amountbonus7 += $row1->Total_Bonus;
                }
                elseif ($month == "08") {
                    $amountbonus8 += $row1->Total_Bonus;
                }
                elseif ($month == "09") {
                    $amountbonus9 += $row1->Total_Bonus;
                }
                elseif ($month == "10") {
                    $amountbonus10 += $row1->Total_Bonus;
                }
                elseif ($month == "11") {
                    $amountbonus11 += $row1->Total_Bonus;
                }
                elseif ($month == "12") {
                    $amountbonus12 += $row1->Total_Bonus;
                }
            }
            array_push($bonusamount,$amountbonus1);
            array_push($bonusamount,$amountbonus2);
            array_push($bonusamount,$amountbonus3);
            array_push($bonusamount,$amountbonus4);
            array_push($bonusamount,$amountbonus5);
            array_push($bonusamount,$amountbonus6);
            array_push($bonusamount,$amountbonus7);
            array_push($bonusamount,$amountbonus8);
            array_push($bonusamount,$amountbonus9);
            array_push($bonusamount,$amountbonus10);
            array_push($bonusamount,$amountbonus11);
            array_push($bonusamount,$amountbonus12);
        }  
        return $bonusamount;
    }

    function otherscategory($dataothers){
        $month = array("01","02","03","04","05","06","07","08","09","10","11","12");
        $suballocationobject = new Suballocation();
        $arrayresult = array();
        $categoryList = array();
        $colorList = array();
        $resultList = array();
  
        foreach ($dataothers as $row2) {
            $subamount = array();
            $categorydata = $suballocationobject->searchcategory($row2->categoryID);

            if ($categorydata) {
                foreach ($categorydata as $categoryrow) {
                    array_push($categoryList,$categoryrow->category);
                    array_push($colorList,$categoryrow->rgb);
                }
            }
            
            foreach ($month as $keymonth) {
                $Expense1object = new Expense();
                $expensesresult=$Expense1object->searchbudgetsubidmonth($row2->budgetSubAllocationID,$keymonth);

                if ($expensesresult) {
                    $totalmonth = 0;
                    foreach ($expensesresult as $row3) {
                        $totalmonth += $row3->amount;
                    }
                    array_push($subamount,$totalmonth);
                }
                else{
                    array_push($subamount,0);
                }
            } 
            array_push($arrayresult,$subamount);
        }
        array_push($resultList,$categoryList);
        array_push($resultList,$arrayresult);
        array_push($resultList,$colorList);

        return $resultList;
    }

    $view = "";

    if ($compbudget) {
        if ($data2) {
            $totalexp = totalexpensesyear($data2);
            $totalrevenue = totalrevyear($actualrevdata);
            $totalnetprofit = totalnetprofityear($actualrevdata,$data2,$costdata1);

            $view ="
                <style type='text/css'>
                .box:hover {
                    box-shadow: 0 3px 20px rgba(0, 0, 0, 0.25); 
                }
                </style>
                <br>
                <div class='card-deck mr-0'>
                    <div class='card my-3 box' style='background-color:rgb(0,225,188); transition: box-shadow .3s; color: #ffffff; border-radius: 11px;'>
                        <div class='card-body p-3'>
                            <div class='m-2'><img src='https://img.icons8.com/ios-filled/45/ffffff/total-sales-1.png'/></div>
                            <h2 class='m-3'><b>RM&nbsp;".number_format($totalrevenue)."</b></h2>
                            <h6 class='m-3' style='font-weight: normal;'>Total Revenue</h6>
                        </div>
                    </div>
                    <div class='card my-3 box' style='background-color:#F53240; transition: box-shadow .3s; color: #ffffff; border-radius: 11px;'>
                        <div class='card-body p-3'>
                            <div class='m-2'><img src='https://img.icons8.com/material-outlined/45/ffffff/cost.png'/></div>
                            <h2 class='m-3'><b>RM&nbsp;".number_format($totalexp)."</b></h2>
                            <h6 class='m-3' style='font-weight: normal;'>Total Expenses</h6>
                        </div>
                    </div>
                    <div class='card my-3 box' style='background-color:#0375B4; transition: box-shadow .3s; color: #ffffff; border-radius: 11px;'>
                        <div class='card-body p-3'>
                            <div class='m-3'><img src='https://img.icons8.com/external-itim2101-lineal-itim2101/45/ffffff/external-profit-currency-and-money-itim2101-lineal-itim2101.png'/></div>
                            <h2 class='m-3'><b>RM&nbsp;".number_format($totalnetprofit)."</b></h2>
                            <h6 class='m-3' style='font-weight: normal;'>Total Profit</h6>
                        </div>
                    </div>
                </div>
            ";

            if ($compbudget) {
                $initialbudget = $compbudget->initialBudget;
            }

            list($allocationcategoryList, $allocationamountList,$color) = categorybudgetallocation($data2);

            $view .="
                <div class='card-deck m-0'>
                    <!-- Budget Allocation card -->
                    <div class='card mr-3 box' style='transition: box-shadow .3s; color:##2E2C38; border-radius: 11px; margin:16px 0;'>
                        <div class='card-body p-3'>
                            <h3 class='m-3'><strong><em>Budget Allocation</em></strong></h3>
                            <br>
                            <h5 class='m-3'><small>Initial Budget (RM)</small></h5>
                            <h5 class='m-3'><b>RM&nbsp;".number_format($initialbudget)."</b></h5>
                            <br>
                            <div class='row'>
                                <div class='col-12'>
                                    <canvas id='allocationChart' width='30' height='17'></canvas>
                                    <script type='text/javascript'>
                                        var cntxt = document.getElementById('allocationChart').getContext('2d');
                                        var expchart = new Chart(cntxt, {
                                            type: 'doughnut',
                                            data: {
                                                labels: ".json_encode($allocationcategoryList).",
                                                datasets: [{
                                                    label: 'First Dataset',
                                                    data: ".json_encode($allocationamountList).",
                                                    backgroundColor: ".json_encode($color).",
                                                    hoverOffset: 4
                                                }],
                                            },
                                            options:{
                                                legend:{
                                                    position: 'right',
                                                },
                                            },
                                        });
                                    </script>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-12 text-right'>
                                    <a href='budget-allocation.php'>
                                        <button type='button' class='btn btn-outline-primary shadow-sm m-3' data-id='' data-toggle='modal' data-backdrop='static' data-target=''>View More...</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
            ";
            $usercompensationobject = new Compensation();
            $targetobject= new Target();
            $targetresult=$targetobject->searchmeasure($resultresult->userID);
            
            if ($targetresult) {

                $view .="
                    <!-- My Compensation Plan card -->
                    <div class='card mx-3 box mybox' style='transition: box-shadow .3s; color:##2E2C38; border-radius: 11px; margin:16px 0;'>
                        <div class='card-body p-3 mb-0'>
                            <h3 class='m-3'><strong><em>My Compensation Plan</em></strong></h3>
                            <br>
                            <div class='row' style='height:52vh;overflow-y:scroll;'>
                                <div class='col-12'>
                ";

                foreach ($targetresult as $targetrow) {
                    $myplandata = $usercompensationobject->searchCompensationbyid($targetrow->compensationID);

                    if ($myplandata) {
                        foreach ($myplandata as $planrow) {  
                            $view .="
                                    <div class='row'>
                                        <div class='col-8'>
                                            <h6 class='m-3'><strong>".$planrow->planName."</strong></h6>
                                            <small class='text-secondary m-3'>".$planrow->planType."</small>
                                        </div>
                            ";

                            if ($targetrow->status == "Achieved") {
                                $view .="
                                        <div class='col-4 text-right' style='margin:0 auto;'>
                                            <h6 class='m-3' style='color:#6CDB50;'><strong>".$targetrow->status."</strong></h6>
                                        </div>
                                ";
                            }
                            elseif ($targetrow->status == "Not Achieved") {
                                $view .="
                                        <div class='col-4 text-right' style='margin:0 auto;'>
                                            <h6 class='m-3' style='color:#DC3545;'><strong>".$targetrow->status."</strong></h6>
                                        </div>
                                ";
                            }

                            $view .="          
                                    </div>
                                    <p><div class='dropdown-divider border-2'></div></p>
                            ";
                        }
                    }
                }
                $view .="
                                </div>
                            </div>
                            <br>
                            <div class='row'>
                                <div class='col-12 text-right'>
                                    <a href='user-view.php'>
                                        <button type='button' class='btn btn-outline-primary shadow-sm m-3' data-id='' data-toggle='modal' data-backdrop='static' data-target=''>View More...</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                ";
            }

            $view .="
                </div>
            ";

            $projrevdata = $revenueobject->searchRevenueestimate($comp,$year,"estimatedrev");
            if ($projrevdata && $actualrevdata) {
                $view .="
                <!-- Revenue Card -->
                <div class='row'>
                    <div class='col-12'>
                        <div class='card mr-3 box' style='transition: box-shadow .3s; color:##2E2C38; border-radius: 11px; margin:16px 0;'>
                            <div class='card-body p-3 mb-3'>
                                <h3 class='m-3'><strong><em>Revenue</em></strong></h3>
                                <div class='row'>
                                    <div class='col-12'>
                                        <canvas id='revchart' width='50' height='16'>
                                            <script type='text/javascript'>
                                                var cntxt = document.getElementById('revchart').getContext('2d');
                                                var rev = new Chart(cntxt, {
                                                    type: 'line',
                                                    data: {
                                                        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                                                        datasets: [{
                                                            label: 'Projected Revenue',
                                                            data: [".$projrevdata->january.", ".$projrevdata->february.", ".$projrevdata->march.", ".$projrevdata->april.", ".$projrevdata->may.", ".$projrevdata->june.",".$projrevdata->july.",".$projrevdata->august.",".$projrevdata->september.",".$projrevdata->october.",".$projrevdata->november.",".$projrevdata->december."],
                                                            borderColor: 'rgba(0,123,255,1)',
                                                            fill:false,
                                                            tension:0,
                                                            },
                                                            {
                                                            label: 'Actual Revenue',
                                                            data: [".$actualrevdata->january.", ".$actualrevdata->february.", ".$actualrevdata->march.", ".$actualrevdata->april.", ".$actualrevdata->may.", ".$actualrevdata->june.",".$actualrevdata->july.",".$actualrevdata->august.",".$actualrevdata->september.",".$actualrevdata->october.",".$actualrevdata->november.",".$actualrevdata->december."],
                                                            borderColor: 'rgba(248,90,62,1)',
                                                            fill:false,
                                                            tension:0,
                                                        }],
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
                                </div>
                                <br>
                                <div class='row'>
                                    <div class='col-12 text-right'>
                                        <a href='budget-revenue.php'>
                                            <button type='button' class='btn btn-outline-primary shadow-sm mr-3' data-id='' data-toggle='modal' data-backdrop='static' data-target=''>View More...</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ";
            } 

            list($category,$totalamount,$categoryColor) = otherscategory($othersdata);  
            $bonusdata1 = bonuscategory($bonusdata);
            
            $view .="
                <!-- Expenses Card -->
                <div class='row'>
                    <div class='col-12'>
                        <div class='card mr-3 box' style='transition: box-shadow .3s; color:##2E2C38; border-radius: 11px; margin:16px 0;'>
                            <div class='card-body p-3 mb-3'>
                                <h3 class='m-3'><strong><em>Expenses</em></strong></h3>
                                <div class='row'>
                                    <div class='col-12'>
                                        <div style='height:400px;width:100%;'><canvas id='expchart'></canvas></div>
                                        <script type='text/javascript'>
                                            var cntxt = document.getElementById('expchart').getContext('2d');
                                            var exp = new Chart(cntxt, {
                                                type: 'bar',
                                                data: {
                                                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                                                    datasets: [{
                                                        label: 'Bonus',
                                                        data: ".json_encode($bonusdata1).",
                                                        backgroundColor: 'rgb(237, 242, 89)',
                                                        },
            ";
                                                for ($i=0; $i < count($category); $i++) { 
                                                    $view .="

                                                        {
                                                            label: '".$category[$i]."',
                                                            data: ".json_encode($totalamount[$i]).",
                                                            backgroundColor: '".$categoryColor[$i]."',
                                                        },
                                                    ";
                                                }

            $view .="
                                                ],
                                                },
                                                options: {
                                                    tooltips: {
                                                        displayColors: true,
                                                        callbacks:{
                                                            mode: 'x',
                                                        },
                                                    },
                                                    scales: {
                                                        xAxes: [{
                                                            stacked: true,
                                                        }],
                                                        yAxes: [{
                                                            stacked: true,
                                                            ticks: {
                                                                beginAtZero: false,
                                                            },
                                                            type: 'linear',
                                                        }]
                                                    },
                                                    responsive: true,
                                                    maintainAspectRatio: false,
                                                    legend: { 
                                                        position: 'top' 
                                                    },
                                                } 
                                            });
                                            
                                            function bgRGBcolor(){

                                                var randomR = Math.floor((Math.random() * 130) + 100);
                                                var randomG = Math.floor((Math.random() * 130) + 100);
                                                var randomB = Math.floor((Math.random() * 130) + 100);
                                             
                                                var graphBackground = \"rgb(\" 
                                                         + randomR + \", \" 
                                                         + randomG + \", \" 
                                                         + randomB + \")\";
                                             
                                             
                                                return graphBackground;
                                            }
                                        </script>

                                    </div>
                                </div>
                                <br>
                                <div class='row'>
                                    <div class='col-12 text-right'>
                                        <a href='budgetexpense.php'>
                                            <button type='button' class='btn btn-outline-primary shadow-sm m-3' data-id='' data-toggle='modal' data-backdrop='static' data-target=''>View More...</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ";

            $amountbonus1=0;$amountbonus2=0;$amountbonus3=0;$amountbonus4=0;$amountbonus5=0;
            $amountbonus6=0;$amountbonus7=0;$amountbonus8=0;$amountbonus9=0;$amountbonus10=0;
            $amountbonus11=0;$amountbonus12=0;

            $suballocationobject = new Suballocation();

            if ($actualrevdata) {
                foreach ($data2 as $row) {
                    $data3 = $suballocationobject->searchsub($row->budgetMainAllocationID);

                    $amountsub1=0;$amountsub2=0;$amountsub3=0;$amountsub4=0;$amountsub5=0;
                    $amountsub6=0;$amountsub7=0;$amountsub8=0;$amountsub9=0; $amountsub10=0;
                    $amountsub11=0;$amountsub12=0;

                    if ($row->categoryName == "Bonus") {
                        $Bonusobject= new Calculation();
                        $bonusresult=$Bonusobject->searchbonusmainid($row->budgetMainAllocationID);
                        $bonusallocation=$row->budgetAllocated;

                        if ($bonusresult) {
                            foreach ($bonusresult as $row1) {
                                $month = date("m",strtotime($row1->date));

                                if ($month == "01") {
                                    $amountbonus1 += $row1->Total_Bonus;
                                }
                                elseif ($month == "02") {
                                    $amountbonus2 += $row1->Total_Bonus;
                                }
                                elseif ($month == "03") {
                                    $amountbonus3 += $row1->Total_Bonus;
                                }
                                elseif ($month == "04") {
                                    $amountbonus4 += $row1->Total_Bonus;
                                }
                                elseif ($month == "05") {
                                    $amountbonus5 += $row1->Total_Bonus;
                                }
                                elseif ($month == "06") {
                                    $amountbonus6 += $row1->Total_Bonus;
                                }
                                elseif ($month == "07") {
                                    $amountbonus7 += $row1->Total_Bonus;
                                }
                                elseif ($month == "08") {
                                    $amountbonus8 += $row1->Total_Bonus;
                                }
                                elseif ($month == "09") {
                                    $amountbonus9 += $row1->Total_Bonus;
                                }
                                elseif ($month == "10") {
                                    $amountbonus10 += $row1->Total_Bonus;
                                }
                                elseif ($month == "11") {
                                    $amountbonus11 += $row1->Total_Bonus;
                                }
                                elseif ($month == "12") {
                                    $amountbonus12 += $row1->Total_Bonus;
                                }
                            }
                        }
                    }
                    elseif ($row->categoryName == "Others") {
                        foreach ($data3 as $row2) {
                            $Expense1object = new Expense();
                            $expensesresult=$Expense1object->searchbudgetsubid($row2->budgetSubAllocationID);

                            if ($expensesresult) {
                                foreach ($expensesresult as $row3) {
                                    $month = date("m",strtotime($row3->date));

                                    if ($month == "01") {
                                        $amountsub1 += $row3->amount;
                                    }
                                    elseif ($month == "02") {
                                        $amountsub2 += $row3->amount;
                                    }
                                    elseif ($month == "03") {
                                        $amountsub3 += $row3->amount;
                                    }
                                    elseif ($month == "04") {
                                        $amountsub4 += $row3->amount;
                                    }
                                    elseif ($month == "05") {
                                        $amountsub5 += $row3->amount;
                                    }
                                    elseif ($month == "06") {
                                        $amountsub6 += $row3->amount;
                                    }
                                    elseif ($month == "07") {
                                        $amountsub7 += $row3->amount;
                                    }
                                    elseif ($month == "08") {
                                        $amountsub8 += $row3->amount;
                                    }
                                    elseif ($month == "09") {
                                        $amountsub9 += $row3->amount;
                                    }
                                    elseif ($month == "10") {
                                        $amountsub10 += $row3->amount;
                                    }
                                    elseif ($month == "11") {
                                        $amountsub11 += $row3->amount;
                                    }
                                    elseif ($month == "12") {
                                        $amountsub12 += $row3->amount;
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


                $janactual = $actualrevdata->january;
                $febactual = $actualrevdata->february;
                $maractual = $actualrevdata->march;
                $apractual = $actualrevdata->april;
                $mayactual = $actualrevdata->may;
                $junactual = $actualrevdata->june;
                $julactual = $actualrevdata->july;
                $augactual = $actualrevdata->august;
                $sepactual = $actualrevdata->september;
                $octactual = $actualrevdata->october;
                $novactual = $actualrevdata->november;
                $decactual = $actualrevdata->december;



                $view .="
                    <div class='card-deck m-0'>
                        <!-- Expenses vs Revenue Card -->
                        <div class='card mr-3 box' style='transition: box-shadow .3s; color:##2E2C38; border-radius: 11px; margin:16px 0; max-width:70%;'>
                            <div class='card-body p-3'>
                                <h3 class='m-3'><strong><em>Expenses vs Revenue</em></strong></h3>
                                <div class='row'>
                                    <div class='col-12'>
                                        <canvas id='revexpchart' width='60' height='28'>
                                            <script type='text/javascript'>
                                                var cntxt = document.getElementById('revexpchart').getContext('2d');
                                                var revexp = new Chart(cntxt, {
                                                    type: 'line',
                                                    data: {
                                                        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                                                        datasets: [{
                                                            label: 'Revenue',
                                                            data: [".$janactual.", ".$febactual.", ".$maractual.", ".$apractual.", ".$mayactual.", ".$junactual.",".$julactual.",".$augactual.",".$sepactual.",".$octactual.",".$novactual.",".$decactual."],
                                                            borderColor: 'rgba(117,200,103,1)',
                                                            fill:false,
                                                            tension:0,
                                                            },
                                                            {
                                                            label: 'Expenses',
                                                            data: [".$actual1.", ".$actual2.", ".$actual3.", ".$actual4.", ".$actual5.", ".$actual6.",".$actual7.",".$actual8.",".$actual9.",".$actual10.",".$actual11.",".$actual12."],
                                                            borderColor: 'rgba(220,53,69,1)',
                                                            fill:false,
                                                            tension:0,
                                                        }],
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
                                </div>
                            </div>
                        </div>
                ";
            }
            else{
                foreach ($data2 as $row) {
                    $data3 = $suballocationobject->searchsub($row->budgetMainAllocationID);

                    $amountsub1=0;$amountsub2=0;$amountsub3=0;$amountsub4=0;$amountsub5=0;
                    $amountsub6=0;$amountsub7=0;$amountsub8=0;$amountsub9=0; $amountsub10=0;
                    $amountsub11=0;$amountsub12=0;

                    if ($row->categoryName == "Bonus") {
                        $Bonusobject= new Calculation();
                        $bonusresult=$Bonusobject->searchbonusmainid($row->budgetMainAllocationID);
                        $bonusallocation=$row->budgetAllocated;

                        if ($bonusresult) {
                            foreach ($bonusresult as $row1) {
                                $month = date("m",strtotime($row1->date));

                                if ($month == "01") {
                                    $amountbonus1 += $row1->Total_Bonus;
                                }
                                elseif ($month == "02") {
                                    $amountbonus2 += $row1->Total_Bonus;
                                }
                                elseif ($month == "03") {
                                    $amountbonus3 += $row1->Total_Bonus;
                                }
                                elseif ($month == "04") {
                                    $amountbonus4 += $row1->Total_Bonus;
                                }
                                elseif ($month == "05") {
                                    $amountbonus5 += $row1->Total_Bonus;
                                }
                                elseif ($month == "06") {
                                    $amountbonus6 += $row1->Total_Bonus;
                                }
                                elseif ($month == "07") {
                                    $amountbonus7 += $row1->Total_Bonus;
                                }
                                elseif ($month == "08") {
                                    $amountbonus8 += $row1->Total_Bonus;
                                }
                                elseif ($month == "09") {
                                    $amountbonus9 += $row1->Total_Bonus;
                                }
                                elseif ($month == "10") {
                                    $amountbonus10 += $row1->Total_Bonus;
                                }
                                elseif ($month == "11") {
                                    $amountbonus11 += $row1->Total_Bonus;
                                }
                                elseif ($month == "12") {
                                    $amountbonus12 += $row1->Total_Bonus;
                                }
                            }
                        }
                    }
                    elseif ($row->categoryName == "Others") {
                        foreach ($data3 as $row2) {
                            $Expense1object = new Expense();
                            $expensesresult=$Expense1object->searchbudgetsubid($row2->budgetSubAllocationID);

                            if ($expensesresult) {
                                foreach ($expensesresult as $row3) {
                                    $month = date("m",strtotime($row3->date));

                                    if ($month == "01") {
                                        $amountsub1 += $row3->amount;
                                    }
                                    elseif ($month == "02") {
                                        $amountsub2 += $row3->amount;
                                    }
                                    elseif ($month == "03") {
                                        $amountsub3 += $row3->amount;
                                    }
                                    elseif ($month == "04") {
                                        $amountsub4 += $row3->amount;
                                    }
                                    elseif ($month == "05") {
                                        $amountsub5 += $row3->amount;
                                    }
                                    elseif ($month == "06") {
                                        $amountsub6 += $row3->amount;
                                    }
                                    elseif ($month == "07") {
                                        $amountsub7 += $row3->amount;
                                    }
                                    elseif ($month == "08") {
                                        $amountsub8 += $row3->amount;
                                    }
                                    elseif ($month == "09") {
                                        $amountsub9 += $row3->amount;
                                    }
                                    elseif ($month == "10") {
                                        $amountsub10 += $row3->amount;
                                    }
                                    elseif ($month == "11") {
                                        $amountsub11 += $row3->amount;
                                    }
                                    elseif ($month == "12") {
                                        $amountsub12 += $row3->amount;
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


                $janactual = 0;
                $febactual = 0;
                $maractual = 0;
                $apractual = 0;
                $mayactual = 0;
                $junactual = 0;
                $julactual = 0;
                $augactual = 0;
                $sepactual = 0;
                $octactual = 0;
                $novactual = 0;
                $decactual = 0;



                $view .="
                    <div class='card-deck m-0'>
                        <!-- Expenses vs Revenue Card -->
                        <div class='card mr-3 box' style='transition: box-shadow .3s; color:##2E2C38; border-radius: 11px; margin:16px 0; max-width:70%;'>
                            <div class='card-body p-3'>
                                <h3 class='m-3'><strong><em>Expenses vs Revenue</em></strong></h3>
                                <div class='row'>
                                    <div class='col-12'>
                                        <canvas id='revexpchart' width='60' height='28'>
                                            <script type='text/javascript'>
                                                var cntxt = document.getElementById('revexpchart').getContext('2d');
                                                var revexp = new Chart(cntxt, {
                                                    type: 'line',
                                                    data: {
                                                        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                                                        datasets: [{
                                                            label: 'Revenue',
                                                            data: [".$janactual.", ".$febactual.", ".$maractual.", ".$apractual.", ".$mayactual.", ".$junactual.",".$julactual.",".$augactual.",".$sepactual.",".$octactual.",".$novactual.",".$decactual."],
                                                            borderColor: 'rgba(117,200,103,1)',
                                                            fill:false,
                                                            tension:0,
                                                            },
                                                            {
                                                            label: 'Expenses',
                                                            data: [".$actual1.", ".$actual2.", ".$actual3.", ".$actual4.", ".$actual5.", ".$actual6.",".$actual7.",".$actual8.",".$actual9.",".$actual10.",".$actual11.",".$actual12."],
                                                            borderColor: 'rgba(220,53,69,1)',
                                                            fill:false,
                                                            tension:0,
                                                        }],
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
                                </div>
                            </div>
                        </div>
                ";
            }

            $userbadgeobject = new Badgeuser();
            $badge = $userbadgeobject->searchBadgeUser($resultresult->userID);

            $totalbronze=0;
            $totalsilver=0;
            $totalgold=0;
            
            $view .="
                    <!-- My Badges Card -->
                    <div class='card mx-3 box' style='transition: box-shadow .3s; color:##2E2C38; border-radius: 11px; margin:16px 0; max-width:30%;'>
                        <div class='card-body p-3'>
                            <h3 class='m-3'><strong><em>My Badges</em></strong></h3>
                            <br>
            ";

            if ($badge) {
                foreach ($badge as $row) {
                    $badgecheck= new Badge();
                    $badgecheckresult=$badgecheck->searchbadgeid($row->badgeID);

                    if($badgecheckresult){ 
                        foreach($badgecheckresult as $row1){ 
                            if ($row1->badgeName == "bronze"){ 
                                $quantity=$row1->badgeQuantity; 
                                $totalbronze= $totalbronze+$quantity;
                            }
                            elseif ($row1->badgeName == "silver"){ 
                                $quantity=$row1->badgeQuantity; 
                                $totalsilver= $totalsilver+$quantity;
                            }
                            elseif ($row1->badgeName == "gold"){ 
                                $quantity=$row1->badgeQuantity; 
                                $totalgold= $totalgold+$quantity;
                            }
                        }       
                    } 
                }

                $view .="
                            <div class='row p-3'>
                                <div class='col-12 text-center'>
                                    <h6 class='mb-3'><strong>Gold</strong></h6>
                                    <i class='fas fa-award mb-2' style='font-size:28px; color:#cd7f32;'></i>
                                    <h2 class='text-primary'>".$totalgold."</h2>
                                </div>
                            </div>
                            <div class='row p-3'>
                                <div class='col-6 text-center'>
                                    <h6 class='mb-3'><strong>Silver</strong></h6>
                                    <i class='fas fa-award mb-2' style='font-size:28px; color:silver;'></i>
                                    <h2 class='text-primary'>".$totalsilver."</h2>
                                </div>
                                <div class='col-6 text-center'>
                                    <h6 class='mb-3'><strong>Bronze</strong></h6>
                                    <i class='fas fa-award mb-2' style='font-size:28px; color:#966F33;'></i>
                                    <h2 class='text-primary'>".$totalbronze."</h2>
                                </div>
                            </div>
                ";
            }
            else{
                $view .="
                            <div class='row p-3'>
                                <div class='col-12 text-center'>
                                    <h6 class='mb-3'><strong>Gold</strong></h6>
                                    <i class='fas fa-award mb-2' style='font-size:28px; color:#cd7f32;'></i>
                                    <h2 class='text-primary'>".$totalgold."</h2>
                                </div>
                            </div>
                            <div class='row p-3'>
                                <div class='col-6 text-center'>
                                    <h6 class='mb-3'><strong>Silver</strong></h6>
                                    <i class='fas fa-award mb-2' style='font-size:28px; color:silver;'></i>
                                    <h2 class='text-primary'>".$totalsilver."</h2>
                                </div>
                                <div class='col-6 text-center'>
                                    <h6 class='mb-3'><strong>Bronze</strong></h6>
                                    <i class='fas fa-award mb-2' style='font-size:28px; color:#966F33;'></i>
                                    <h2 class='text-primary'>".$totalbronze."</h2>
                                </div>
                            </div>
                ";
            }

            $view .="
                            <br><br>
                            <div class='row'>
                                <div class='col-12 my-3 text-right' style='position:absolute; bottom:0; right:0;'>
                                    <a href='user-view.php'>
                                        <button type='button' class='btn btn-outline-primary shadow-sm m-3' data-id='' data-toggle='modal' data-backdrop='static' data-target=''>View More...</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ";

            if ($actualrevdata) {
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

                if ($costdata1) {
                    $grossprofit1=0;$grossprofit2=0;$grossprofit3=0;$grossprofit4=0;$grossprofit5=0;$grossprofit6=0;
                    $grossprofit7=0;$grossprofit8=0;$grossprofit9=0;$grossprofit10=0;$grossprofit11=0;$grossprofit12=0;

                    $netprofit1=0;$netprofit2=0;$netprofit3=0;$netprofit4=0;$netprofit5=0;$netprofit6=0;
                    $netprofit7=0;$netprofit8=0;$netprofit9=0;$netprofit10=0;$netprofit11=0;$netprofit12=0;


                    $grossprofit1=$actualrevdata->january - $costdata1->january;
                    $grossprofit2=$actualrevdata->february - $costdata1->february;
                    $grossprofit3=$actualrevdata->march - $costdata1->march;
                    $grossprofit4=$actualrevdata->april - $costdata1->april;
                    $grossprofit5=$actualrevdata->may - $costdata1->may;
                    $grossprofit6=$actualrevdata->june - $costdata1->june;
                    $grossprofit7=$actualrevdata->july - $costdata1->july;
                    $grossprofit8=$actualrevdata->august - $costdata1->august;
                    $grossprofit9=$actualrevdata->september - $costdata1->september;
                    $grossprofit10=$actualrevdata->october - $costdata1->october;
                    $grossprofit11=$actualrevdata->november - $costdata1->november;
                    $grossprofit12=$actualrevdata->december - $costdata1->december;

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


                    $view .="
                        <!-- Net Profit Card -->
                        <div class='row'>
                            <div class='col-12'>
                                <div class='card mr-3 box' style='transition: box-shadow .3s; color:##2E2C38; border-radius: 11px; margin:16px 0;'>
                                    <div class='card-body p-3 mb-3'>
                                        <h3 class='m-3'><strong><em>Net Profit</em></strong></h3>
                                        <div class='row'>
                                            <div class='col-12'>
                                                <canvas id='netprofitchart' width='50' height='16'>
                                                    <script type='text/javascript'>
                                                        var cntxt = document.getElementById('netprofitchart').getContext('2d');
                                                        var rev = new Chart(cntxt, {
                                                            type: 'line',
                                                            data: {
                                                                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                                                                datasets: [{
                                                                    label: 'Net Profit',
                                                                    data: [".$netprofit1.", ".$netprofit2.", ".$netprofit3.", ".$netprofit4.", ".$netprofit5.", ".$netprofit6.",".$netprofit7.",".$netprofit8.",".$netprofit9.",".$netprofit10.",".$netprofit11.",".$netprofit12."],
                                                                    borderColor: 'rgba(218,36,200,1)',
                                                                    fill:false,
                                                                    tension:0,
                                                                }],
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
                                        </div>
                                        <br>
                                        <div class='row'>
                                            <div class='col-12 text-right'>
                                                <a href='budget-netprofit.php'>
                                                    <button type='button' class='btn btn-outline-primary shadow-sm mr-3' data-id='' data-toggle='modal' data-backdrop='static' data-target=''>View More...</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";

                }
                else {
                    $grossprofit1=0;$grossprofit2=0;$grossprofit3=0;$grossprofit4=0;$grossprofit5=0;$grossprofit6=0;
                    $grossprofit7=0;$grossprofit8=0;$grossprofit9=0;$grossprofit10=0;$grossprofit11=0;$grossprofit12=0;

                    $netprofit1=0;$netprofit2=0;$netprofit3=0;$netprofit4=0;$netprofit5=0;$netprofit6=0;
                    $netprofit7=0;$netprofit8=0;$netprofit9=0;$netprofit10=0;$netprofit11=0;$netprofit12=0;


                    $grossprofit1=$actualrevdata->january - 0;
                    $grossprofit2=$actualrevdata->february - 0;
                    $grossprofit3=$actualrevdata->march - 0;
                    $grossprofit4=$actualrevdata->april - 0;
                    $grossprofit5=$actualrevdata->may - 0;
                    $grossprofit6=$actualrevdata->june - 0;
                    $grossprofit7=$actualrevdata->july - 0;
                    $grossprofit8=$actualrevdata->august - 0;
                    $grossprofit9=$actualrevdata->september - 0;
                    $grossprofit10=$actualrevdata->october - 0;
                    $grossprofit11=$actualrevdata->november - 0;
                    $grossprofit12=$actualrevdata->december - 0;

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


                    $view .="
                        <!-- Net Profit Card -->
                        <div class='row'>
                            <div class='col-12'>
                                <div class='card mr-3 box' style='transition: box-shadow .3s; color:##2E2C38; border-radius: 11px; margin:16px 0;'>
                                    <div class='card-body p-3 mb-3'>
                                        <h3 class='m-3'><strong><em>Net Profit</em></strong></h3>
                                        <div class='row'>
                                            <div class='col-12'>
                                                <canvas id='netprofitchart' width='50' height='16'>
                                                    <script type='text/javascript'>
                                                        var cntxt = document.getElementById('netprofitchart').getContext('2d');
                                                        var rev = new Chart(cntxt, {
                                                            type: 'line',
                                                            data: {
                                                                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                                                                datasets: [{
                                                                    label: 'Net Profit',
                                                                    data: [".$netprofit1.", ".$netprofit2.", ".$netprofit3.", ".$netprofit4.", ".$netprofit5.", ".$netprofit6.",".$netprofit7.",".$netprofit8.",".$netprofit9.",".$netprofit10.",".$netprofit11.",".$netprofit12."],
                                                                    borderColor: 'rgba(218,36,200,1)',
                                                                    fill:false,
                                                                    tension:0,
                                                                }],
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
                                        </div>
                                        <br>
                                        <div class='row'>
                                            <div class='col-12 text-right'>
                                                <a href='budget-netprofit.php'>
                                                    <button type='button' class='btn btn-outline-primary shadow-sm mr-3' data-id='' data-toggle='modal' data-backdrop='static' data-target=''>View More...</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                }  
            }
            else {
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


                $view .="
                    <!-- Net Profit Card -->
                    <div class='row'>
                        <div class='col-12'>
                            <div class='card mr-3 box' style='transition: box-shadow .3s; color:##2E2C38; border-radius: 11px; margin:16px 0;'>
                                <div class='card-body p-3 mb-3'>
                                    <h3 class='m-3'><strong><em>Net Profit</em></strong></h3>
                                    <div class='row'>
                                        <div class='col-12'>
                                            <canvas id='netprofitchart' width='50' height='16'>
                                                <script type='text/javascript'>
                                                    var cntxt = document.getElementById('netprofitchart').getContext('2d');
                                                    var rev = new Chart(cntxt, {
                                                        type: 'line',
                                                        data: {
                                                            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                                                            datasets: [{
                                                                label: 'Net Profit',
                                                                data: [".$netprofit1.", ".$netprofit2.", ".$netprofit3.", ".$netprofit4.", ".$netprofit5.", ".$netprofit6.",".$netprofit7.",".$netprofit8.",".$netprofit9.",".$netprofit10.",".$netprofit11.",".$netprofit12."],
                                                                borderColor: 'rgba(218,36,200,1)',
                                                                fill:false,
                                                                tension:0,
                                                            }],
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
                                    </div>
                                    <br>
                                    <div class='row'>
                                        <div class='col-12 text-right'>
                                            <a href='budget-netprofit.php'>
                                                <button type='button' class='btn btn-outline-primary shadow-sm mr-3' data-id='' data-toggle='modal' data-backdrop='static' data-target=''>View More...</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ";
            }
        }
        else{
            $view.="
                <br><br>
                <div class='card box rounded-0'>
                <div class='card-body text-center'>
                    <b>Oppss ! Please allocate your budget first</b><br><br>
                    <div class='text-center'>
                    <a href='budget-allocation.php'>
                        <button type='button' class='btn btn-success shadow-sm'>Go to Allocation</button>
                    </a>
                    </div>
                </div>
                </div>
            ";
        }
    }
    else {
        $view.="
            <br><br>
            <div class='card box rounded-0'>
                <div class='card-body text-center'>
                <b>No data found. Please setup you budget first</b><br><br>
                <div class='text-center'>
                    <a href='budget-setup.php'>
                    <button type='button' class='btn btn-success shadow-sm'>Go to Budget Setup</button>
                    </a>
                </div>
                </div>
            </div>
        ";
    }
}



echo json_encode($view);

?>