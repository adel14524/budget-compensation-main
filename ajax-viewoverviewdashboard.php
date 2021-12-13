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

    if ($data2) {
        $amountbonus1=0;$amountbonus2=0;$amountbonus3=0;$amountbonus4=0;$amountbonus5=0;
        $amountbonus6=0;$amountbonus7=0;$amountbonus8=0;$amountbonus9=0;$amountbonus10=0;
        $amountbonus11=0;$amountbonus12=0;

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

        $view ="
            <style type='text/css'>
            .box:hover {
                box-shadow: 0 3px 20px rgba(0, 0, 0, 0.25); 
            }
            </style>
            <br>
            <div class='card-deck mr-0'>
                <div class='card my-3 box' style='background-color:#05B78A; transition: box-shadow .3s; color: #ffffff; border-radius: 11px;'>
                    <div class='card-body p-3'>
                        <div class='m-2'><img src='https://img.icons8.com/ios-filled/45/ffffff/total-sales-1.png'/></div>
                        <h2 class='m-3'><b>RM&nbsp;100,000</b></h2>
                        <h6 class='m-3' style='font-weight: normal;'>Total Revenue</h6>
                    </div>
                </div>
                <div class='card my-3 box' style='background-color:#DC3545; transition: box-shadow .3s; color: #ffffff; border-radius: 11px;'>
                    <div class='card-body p-3'>
                        <div class='m-2'><img src='https://img.icons8.com/material-outlined/45/ffffff/cost.png'/></div>
                        <h2 class='m-3'><b>RM&nbsp;".$totalexp."</b></h2>
                        <h6 class='m-3' style='font-weight: normal;'>Total Expenses</h6>
                    </div>
                </div>
                <div class='card my-3 box' style='background-color:#080A33; transition: box-shadow .3s; color: #ffffff; border-radius: 11px;'>
                    <div class='card-body p-3'>
                        <div class='m-3'><img src='https://img.icons8.com/external-itim2101-lineal-itim2101/45/ffffff/external-profit-currency-and-money-itim2101-lineal-itim2101.png'/></div>
                        <h2 class='m-3'><b>RM&nbsp;40,275</b></h2>
                        <h6 class='m-3' style='font-weight: normal;'>Total Profit</h6>
                    </div>
                </div>
            </div>

            <div class='card-deck m-0'>
                <!-- Budget Allocation card -->
                <div class='card mr-3 box' style='transition: box-shadow .3s; color:##2E2C38; border-radius: 11px; margin:16px 0;'>
                    <div class='card-body p-3'>
                        <h3 class='m-3'><strong><em>Budget Allocation</em></strong></h3>
                        <br>
                        <h5 class='m-3'><small>Initial Budget (RM)</small></h5>
                        <h5 class='m-3'><b>RM&nbsp;11,000</b></h5>
                        <br>
                        <div class='row'>
                            <div class='col-12'>
                                <canvas id='marexpensesChart' width='30' height='17'></canvas>
                                <script type='text/javascript'>
                                    var cntxt = document.getElementById('marexpensesChart').getContext('2d');
                                    var expchart = new Chart(cntxt, {
                                        type: 'doughnut',
                                        data: {
                                            labels: ['Bonus', 'Salary', 'Operation Cost', 'Overhead Cost'],
                                            datasets: [{
                                                label: 'First Dataset',
                                                data: [300,200,200,400],
                                                backgroundColor: [
                                                    'rgba(8,10,51,1)',
                                                    'rgba(5,183,138,1)',
                                                    'rgba(220,53,69,1)',
                                                    'rgba(224,228,232,1)',
                                                ],
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
                                <button type='button' class='btn btn-outline-primary shadow-sm m-3' data-id='' data-toggle='modal' data-backdrop='static' data-target=''>View More...</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- My Compensation Plan card -->
                <div class='card mx-3 box mybox' style='transition: box-shadow .3s; color:##2E2C38; border-radius: 11px; margin:16px 0;'>
                    <div class='card-body p-3 mb-0'>
                        <h3 class='m-3'><strong><em>My Compensation Plan</em></strong></h3>
                        <br>
                        <div class='row' style='height:52vh;overflow-y:scroll;'>
                            <div class='col-12'>
                                <div class='row'>
                                    <div class='col-8'>
                                        <h6 class='m-3'><strong>Plan August 2021</strong></h6>
                                        <small class='text-secondary m-3'>Onetime</small>
                                    </div>
                                    <div class='col-4 text-center' style='margin:0 auto;'>
                                        <h6 class='m-3' style='color:#6CDB50;'><strong>Achieved</strong></h6>
                                    </div>
                                </div>
                                <p><div class='dropdown-divider border-2'></div></p>
                                <div class='row'>
                                    <div class='col-8'>
                                        <h6 class='m-3'><strong>Plan August 2021</strong></h6>
                                        <small class='text-secondary m-3'>Onetime</small>
                                    </div>
                                    <div class='col-4 text-center' style='margin:0 auto;'>
                                        <h6 class='m-3' style='color:#6CDB50;'><strong>Achieved</strong></h6>
                                    </div>
                                </div>
                                <p><div class='dropdown-divider border-2'></div></p>
                                <div class='row'>
                                    <div class='col-8'>
                                        <h6 class='m-3'><strong>Plan August 2021</strong></h6>
                                        <small class='text-secondary m-3'>Onetime</small>
                                    </div>
                                    <div class='col-4 text-center' style='margin:0 auto;'>
                                        <h6 class='m-3' style='color:#6CDB50;'><strong>Achieved</strong></h6>
                                    </div>
                                </div>
                                <p><div class='dropdown-divider border-2'></div></p>
                                <div class='row'>
                                    <div class='col-8'>
                                        <h6 class='m-3'><strong>Plan August 2021</strong></h6>
                                        <small class='text-secondary m-3'>Onetime</small>
                                    </div>
                                    <div class='col-4 text-center' style='margin:0 auto;'>
                                        <h6 class='m-3' style='color:#6CDB50;'><strong>Achieved</strong></h6>
                                    </div>
                                </div>
                                <p><div class='dropdown-divider border-2'></div></p>
                                <div class='row'>
                                    <div class='col-8'>
                                        <h6 class='m-3'><strong>Plan August 2021</strong></h6>
                                        <small class='text-secondary m-3'>Onetime</small>
                                    </div>
                                    <div class='col-4 text-center' style='margin:0 auto;'>
                                        <h6 class='m-3' style='color:#6CDB50;'><strong>Achieved</strong></h6>
                                    </div>
                                </div>
                                <p><div class='dropdown-divider border-2'></div></p>
                                <div class='row'>
                                    <div class='col-8'>
                                        <h6 class='m-3'><strong>Plan August 2021</strong></h6>
                                        <small class='text-secondary m-3'>Onetime</small>
                                    </div>
                                    <div class='col-4 text-center' style='margin:0 auto;'>
                                        <h6 class='m-3' style='color:#6CDB50;'><strong>Achieved</strong></h6>
                                    </div>
                                </div>
                                <p><div class='dropdown-divider border-2'></div></p>
                                <div class='row'>
                                    <div class='col-8'>
                                        <h6 class='m-3'><strong>Plan August 2021</strong></h6>
                                        <small class='text-secondary m-3'>Onetime</small>
                                    </div>
                                    <div class='col-4 text-center' style='margin:0 auto;'>
                                        <h6 class='m-3' style='color:#6CDB50;'><strong>Achieved</strong></h6>
                                    </div>
                                </div>
                                <p><div class='dropdown-divider border-2'></div></p>
                            </div>
                        </div>
                        <br>
                        <div class='row'>
                            <div class='col-12 text-right'>
                                <button type='button' class='btn btn-outline-primary shadow-sm m-3' data-id='' data-toggle='modal' data-backdrop='static' data-target=''>View More...</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                                                        data: [20000,45000,70000,54210,85685,10000,8000,57601,11000,22000,54123,44000],
                                                        borderColor: 'rgba(0,123,255,1)',
                                                        fill:false,
                                                        tension:0,
                                                        },
                                                        {
                                                        label: 'Actual Revenue',
                                                        data: [40000,75000,85000,95000,110000,64000,75200,63000,75000,74000,80000,78000],
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
                                    <button type='button' class='btn btn-outline-primary shadow-sm mr-3' data-id='' data-toggle='modal' data-backdrop='static' data-target=''>View More...</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                                                    label: 'Category1',
                                                    data: [2000,4000,7000,5000,7000,1000,800,500,1000,2000,4000,1020],
                                                    backgroundColor: 'rgba(8,10,51,1)',
                                                    },
                                                    {
                                                    label: 'Category2',
                                                    data: [100,50,400,200,300,500,1000,800,100,500,600,300],
                                                    backgroundColor: 'rgba(224,228,232,1)',
                                                    },
                                                    {
                                                    label: 'Category3',
                                                    data: [100,50,400,200,300,500,1000,800,100,500,600,300],
                                                    backgroundColor: 'rgba(5,183,138,1)',
                                                    },
                                                    {
                                                    label: 'Category4',
                                                    data: [100,50,400,200,300,500,1000,800,100,500,600,300],
                                                    backgroundColor: 'rgba(5,42,229,1)',
                                                }],
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
                                    </script>
                                </div>
                            </div>
                            <br>
                            <div class='row'>
                                <div class='col-12 text-right'>
                                    <button type='button' class='btn btn-outline-primary shadow-sm m-3' data-id='' data-toggle='modal' data-backdrop='static' data-target=''>View More...</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                                                    data: [20000,45000,70000,54210,85685,10000,8000,57601,11000,22000,54123,44000],
                                                    borderColor: 'rgba(117,200,103,1)',
                                                    fill:false,
                                                    tension:0,
                                                    },
                                                    {
                                                    label: 'Expenses',
                                                    data: [40000,75000,85000,95000,110000,64000,75200,63000,75000,74000,80000,78000],
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

                <!-- My Badges Card -->
                <div class='card mx-3 box' style='transition: box-shadow .3s; color:##2E2C38; border-radius: 11px; margin:16px 0; max-width:30%;'>
                    <div class='card-body p-3'>
                        <h3 class='m-3'><strong><em>My Badges</em></strong></h3>
                        <br>
                        <div class='row p-3'>
                            <div class='col-12 text-center'>
                                <h6 class='mb-3'><strong>Gold</strong></h6>
                                <i class='fas fa-award mb-2' style='font-size:28px; color:#cd7f32;'></i>
                                <h2 class='text-primary'>0</h2>
                            </div>
                        </div>
                        <div class='row p-3'>
                            <div class='col-6 text-center'>
                                <h6 class='mb-3'><strong>Silver</strong></h6>
                                <i class='fas fa-award mb-2' style='font-size:28px; color:silver;'></i>
                                <h2 class='text-primary'>1</h2>
                            </div>
                            <div class='col-6 text-center'>
                                <h6 class='mb-3'><strong>Bronze</strong></h6>
                                <i class='fas fa-award mb-2' style='font-size:28px; color:#966F33;'></i>
                                <h2 class='text-primary'>2</h2>
                            </div>
                        </div>
                        <br><br>
                        <div class='row'>
                            <div class='col-12 my-3 text-right' style='position:absolute; bottom:0; right:0;'>
                                <button type='button' class='btn btn-outline-primary shadow-sm m-3' data-id='' data-toggle='modal' data-backdrop='static' data-target=''>View More...</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                                                        data: [20000,45000,70000,54210,85685,10000,8000,57601,11000,22000,54123,44000],
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
                                    <button type='button' class='btn btn-outline-primary shadow-sm mr-3' data-id='' data-toggle='modal' data-backdrop='static' data-target=''>View More...</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ";
    } 
}



echo json_encode($view);

?>