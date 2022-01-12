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
  $budgetallocated = escape(Input::get('budgetallocated'));
  $balance = escape(Input::get('balance'));
  $othersallocation=0;
  $bonusallocation=0;

  $Expense1object = new Expense();
  $Bonusobject= new Calculation();

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

  function getCategory($month,$year,$comp,$balance){
    $mainallocationobject1 = new Mainallocation();
    $category_data = $mainallocationobject1->searchmain($comp,$year);
    $suballocationobject1 = new Suballocation();
    $budgetcatObj = new Budgetcategory();
    $categoryList = array();
    $colorList = array();
    $amountList = array();
    $resultList = array();
    
    array_push($categoryList,"Bonus");
    array_push($colorList,"rgb(224, 228, 232)");

    if($category_data){
      foreach ($category_data as $category_row){
        if($category_row->categoryName ==="Bonus"){
          $totalbonus = totalbonus($comp,$month,$year);
          array_push($amountList,$totalbonus);
        }
        elseif($category_row->categoryName ==="Others") {
          $datasub = $suballocationobject1->searchsub($category_row->budgetMainAllocationID);
          if($datasub){
            foreach($datasub as $rowsub){
              $categorydata = $budgetcatObj->searchBudgetCategoryByID($rowsub->categoryID);
              $totalexp = totalexpenses($rowsub->budgetSubAllocationID,$month,$year);

              if ($categorydata) {
                array_push($categoryList,$categorydata->category);
                array_push($colorList,$categorydata->rgb);
              }
              array_push($amountList,$totalexp);
              
            }
          }
        }
      }
    }

    if ($balance < 0) {
      $balance = 0;
    }

    array_push($categoryList,"The Amount Left (RM)");
    array_push($colorList, "rgb(237, 242, 89)");
    array_push($amountList,$balance);
    array_push($resultList,$categoryList);
    array_push($resultList,$amountList);
    array_push($resultList,$colorList);
    return $resultList;
  }

  function totalbonus($comp,$month,$year){
    $totalbonus=0;
    $Bonusobject = new Calculation();
      $databonus = $Bonusobject->searchBonus($comp,$month,$year);
      if($databonus){
        foreach ($databonus as $row1) {
          $totalbonus+=$row1->Total_Bonus; 
        }
      }
    return $totalbonus;
  }

  function progressbar($month,$comp,$year){
    $mainallocationobject1 = new Mainallocation();
    $data1 = $mainallocationobject1->searchmain($comp,$year);
    $suballocationobject1 = new Suballocation();
    $expensesobject = new Expense();
    $bonusallocation=0;
    $othersallocation=0;

    if ($data1) {
      $amountbonus=0;
      foreach ($data1 as $row) {
        $data3 = $suballocationobject1->searchsub($row->budgetMainAllocationID);
        $amountsub=0;
        if ($row->categoryName=="Bonus") {
          $bonusobject = new Calculation();
          $bonusresult=$bonusobject->searchbonusmainid($row->budgetMainAllocationID);
          $bonusallocation=$row->budgetAllocated;

          if($bonusresult){
            foreach ($bonusresult as $row1) {
              $expmonth = date("m",strtotime($row1->date));
              if($expmonth == $month){
                $amountbonus+=$row1->Total_Bonus;
              }
            }
          }
        }
        elseif ($row->categoryName=="Others") {
          foreach ($data3 as $row3) {
            $expensesresult = $expensesobject->searchbudgetsubid($row3->budgetSubAllocationID);
            if($expensesresult){
              foreach ($expensesresult as $row) {
                $expmonth = date("m",strtotime($row->date));

                if ($expmonth == $month) {
                  $amountsub+=$row->amount;
                }
              }
            }
          }
        }
        if ($data3) {
          foreach ($data3 as $row5) {
            $othersallocation+=$row5->budgetAllocated;
          }
        }
      }
    }

    $actual = $amountbonus + $amountsub;
    $budgetallocation = round(($othersallocation + $bonusallocation)/12);
    $percent = round(($actual/$budgetallocation)*100);

    if ($percent == 100 ) {
      $expensesprogress = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent."%;'><b>".$percent."%</b></div></div>";
    }elseif ($percent >= 80 && $percent <= 99) {
      $expensesprogress = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-warning' style='width:".$percent."%;' ><b>".$percent."%</b></div></div>";
    }elseif ($percent >= 0 && $percent <= 79) {
      $expensesprogress = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-info' style='width:".$percent."%;'><b>".$percent."%</b></div></div>";
    }elseif ($percent > 100) {
      $expensesprogress = "<div class='progress' style='width:80%; margin:0 auto;'><div class='progress-bar bg-danger' style='width:".$percent."%;'><b>".$percent."%</b></div></div>";
    }

    return $expensesprogress;
  }

  $mainallocationobject = new Mainallocation();
  $data2 = $mainallocationobject->searchmain($comp,$year);
  $suballocationobject = new Suballocation();
  $budgetcatObj = new Budgetcategory();

  $grandtotal=$Expense1object->searchexpensestotal($comp,$month,$year);
  $grandtotalbonus=$Bonusobject->searchbonustotal($comp,$month,$year);
  $grand=$grandtotal->total+ $grandtotalbonus->total;
  $othersallocation=0;
  $bonusallocation=0;

  $view="
  <div class='card my-2'>
    <div class='card-body pb-3'>
      <div class='row'>
        <div class='col-sm-12 col-lg-7' style='height:430px;overflow-y:scroll;'>";

  if($data2){
    foreach ($data2 as $row2){
      $grandtotalbonus=0;
      if($row2->categoryName ==="Bonus"){
        $totalbonus=totalbonus($comp,$month,$year);
        $grandtotalbonus+=$totalbonus;

        $view .= "
        <div class='card my-3'>
        <div class='card-body pb-3'>
          <div class='row'>
            <div class='col-8 text-left'>
              <h6 class='mb-1'><i class='fas fa-bullseye'></i>&nbsp;&nbsp;".$row2->categoryName."<i class=''></i></h6>
              <small><span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: transparent; color: #007bff; border-color: #007bff'></span> <span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: transparent; color: #007bff; border-color: #007bff'></span> </small> <br>
            </div>

            <div class='col-4 text-center'>
              <div><b>Total Amount (RM)</b></div>
              <div>".$totalbonus."</div>
            </div>
          </div>
          <p><div class='dropdown-divider border-2'></div></p>
        ";


        $calculationobject = new Calculation();
        $databonus = $calculationobject->searchBonus($comp,$month,$year);

        if($databonus){

          $view .="
          <div class='card my-2'>
          <div class='card-body pb-3' style='height:300px;overflow-y:scroll;'>
          ";

          foreach ($databonus as $rowbonus){
            $view .= "
            <div class='row'>
            <div class='col-8 text-left'>
              <h6><b>Bonus</b></h6>
              <small class='text-secondary'>".$rowbonus->date."</small>
            </div>

            <div class='col-4 text-center'>
              <h4><b>RM ".$rowbonus->Total_Bonus."</b></h4>
            </div>
          </div>
          <p><div class='dropdown-divider border-2'></div></p>
            ";
          }

          $view .="
          </div>
          </div>
          ";
        }

        $view.="</div>
        </div>";
      }
      elseif($row2->categoryName ==="Others"){
        $data3 = $suballocationobject->searchsub($row2->budgetMainAllocationID);
        $grandtotal=0;

        if($data3){
          $view .="
          ";
          foreach ($data3 as $row3){
            $categorydata = $budgetcatObj->searchBudgetCategoryByID($row3->categoryID);
            $totalexpenses=totalexpenses($row3->budgetSubAllocationID,$month,$year);
            $grandtotal+=$totalexpenses;

            if ($categorydata) {
              $view .= "
                <div class='card my-3'>
                <div class='card-body pb-3'>
                  <div class='row'>
                    <div class='col-8 text-left'>
                      <h6 class='mb-1'><i class='fas fa-bullseye'></i>&nbsp;&nbsp;".$categorydata->category."<i class=''></i></h6>
                      <small><span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: transparent; color: #007bff; border-color: #007bff'></span> <span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: transparent; color: #007bff; border-color: #007bff'></span> </small> <br>
                    </div>

                    <div class='col-4 text-center'>
                      <div><b>Total Amount (RM)</b></div>
                      <div>".$totalexpenses."</div>
                    </div>
                  </div>
                  <p><div class='dropdown-divider border-2'></div></p>
              ";
            }

            

            $Expenseobject = new Expense();
            $dataexpenses = $Expenseobject->searchexpensessubid($row3->budgetSubAllocationID,$month,$year);
            if($dataexpenses){

              $view .="
              <div class='card my-2'>
                <div class='card-body pb-3' style='height:300px;overflow-y:scroll;'>
              ";
              foreach ($dataexpenses as $row4){
                $view .= "
                <div class='row'>
                <div class='col-7 text-left'>
                  <h6><b>".$row4->description."</b></h6>
                  <small class='text-secondary'>".$row4->date."</small>
                </div>

                <div class='col-3 text-center'>
                  <h4><b>RM ".$row4->amount."</b></h4>
                </div>

                <div class='col-2 text-right'>
                  <button type='button' class='btn btn-sm btn-white dropdown-toggle-split viewkroption' data-toggle='dropdown'><i class='fas fa-ellipsis-v'></i></button>
                  <div class='dropdown-menu dropdown-menu-right'>
                    <a href='#' class='dropdown-item updateExpenses' data-toggle='modal' data-backdrop='static' data-target='#updateExpenses' data-id='".$row4->budgetExpensesID."' data-month='".$month."' data-place='showexpenses".$month."' data-balance='".$balance."' data-budget='".$budgetallocated."'><i class='far fa-edit'></i> Update </a>
                    <a href='#' class='dropdown-item deleteExpenses' data-toggle='modal' data-backdrop='static' data-target='#deleteExpense' data-id='".$row4->budgetExpensesID."' data-month='".$month."' data-place='showexpenses".$month."' data-balance='".$balance."' data-budget='".$budgetallocated."' data-amount='".$row4->amount."'><i class='far fa-trash-alt'></i> Delete</a>
                  </div>
                </div>
                </div>
                <p><div class='dropdown-divider border-2'></div></p>
                ";
              }

              $view .="
                  </div>
                </div>
              ";
            }
            $view .="
            <div class='row'>
                    <div class='col-12 text-right'>
                      <button type='button' class='btn btn-primary shadow-sm addCompExpenses mt-2' data-id='".$row3->budgetSubAllocationID."' data-place='showexpenses".$month."' data-month='".$month."' data-balance='".$balance."' data-budget='".$budgetallocated."' data-toggle='modal' data-backdrop='static' data-target='#addCompensation1'><i class='fas fa-plus'></i> Add Expenses </button>
                    </div>
                  </div>
            </div>

            </div>      
            ";
          }

          $view.="";
        }
        $view.="
        ";
      }
    }
  
    list($expcategoryList,$expamount,$color) = getCategory($month,$year,$comp,$balance);

    $view.="
      </div>
        <div class='col-sm-12 col-lg-5'>
          <canvas id='expensesChart".$month."' width='30' height='18'>
            <script type=''>
              var cntxt = document.getElementById('expensesChart".$month."').getContext('2d');
              var expchart = new Chart(cntxt, {
                type: 'doughnut',
                data: {
                  labels: ".json_encode($expcategoryList).",
                  datasets: [{
                    label: 'First Dataset',
                    data: ".json_encode($expamount).",
                    backgroundColor: ".json_encode($color).",
                    hoverOffset: 4
                  }],
                }, 
                options:{
                  responsive: true,
                  legend:{
                      position: 'top',
                  },
                },
              });
            </script>
            </canvas>
          <div class='row'>
            <div class='col-12 mt-3'>
            <h4><small class='text-secondary'>Expenses Budget:&nbsp;&nbsp;</small>RM&nbsp;".$budgetallocated."</h4>
            </div>
          </div>
        </div>
          </div>
          </div>
          </div>";

    $progress = progressbar($month,$comp,$year);

    $array = [
      "view" => $view,
      "grandtotal" => $grand,
      "balance" => $balance,
      "month" => $month,
      "progressvalue" => $progress,
      "budgetallocated" => $budgetallocated
    ];   
  }
  else{
    $view.="
        <br><br>
        <div class='card box rounded-0'>
          <div class='card-body text-center'>
            <b>No data found. Please allocate your budget first</b><br><br>
            <div class='text-center'>
              <a href='budget-allocation.php'>
                <button type='button' class='btn btn-success shadow-sm'>Go to Allocation</button>
              </a>
            </div>
          </div>
        </div>
    ";

    $array = [
      "view" => $view
    ];
  }

echo json_encode($array);
}
?>