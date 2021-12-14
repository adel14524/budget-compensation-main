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

  //  

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
    $categoryList = array();
    $amountList = array();
    $resultList = array();
    
    array_push($categoryList,"Bonus");

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
              $totalexp = totalexpenses($rowsub->budgetSubAllocationID,$month,$year);
              $sub_category = $rowsub->categoryName;
              array_push($amountList,$totalexp);
              array_push($categoryList,$sub_category);
            }
          }
        }
      }
    }

    array_push($categoryList,"The Amount Left (RM)");
    array_push($amountList,$balance);
    array_push($resultList,$categoryList);
    array_push($resultList,$amountList);
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

  $mainallocationobject = new Mainallocation();
  $data2 = $mainallocationobject->searchmain($comp,$year);
  $suballocationobject = new Suballocation();

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
          <div class='card-body pb-3' style='height:500px;overflow-y:scroll;'>
          ";

          foreach ($databonus as $rowbonus){
            $view .= "
            <div class='row'>
            <div class='col-7 text-left'>
              <h6><b>Bonus</b></h6>
              <small class='text-secondary'>".$rowbonus->date."</small>
            </div>

            <div class='col-3 text-center'>
              <h4><b>RM ".$rowbonus->Total_Bonus."</b></h4>
            </div>

            <div class='col-2 text-right'>
              <button type='button' class='btn btn-sm btn-white dropdown-toggle-split viewkroption' data-toggle='dropdown'><i class='fas fa-ellipsis-v'></i></button>
              <div class='dropdown-menu dropdown-menu-right'>
                <a href='#' class='dropdown-item updateExpenses' data-toggle='modal' data-backdrop='static' data-target='#updateExpenses' data-id=''><i class='far fa-edit'></i> Update </a>
                <a href='#' class='dropdown-item deleteExpenses' data-toggle='modal' data-backdrop='static' data-target='#deleteExpense' data-id=''><i class='far fa-trash-alt'></i> Delete</a>
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
            $totalexpenses=totalexpenses($row3->budgetSubAllocationID,$month,$year);
            $grandtotal+=$totalexpenses;

            $view .= "
            <div class='card my-3'>
            <div class='card-body pb-3'>
              <div class='row'>
                <div class='col-8 text-left'>
                  <h6 class='mb-1'><i class='fas fa-bullseye'></i>&nbsp;&nbsp;".$row3->categoryName."<i class=''></i></h6>
                  <small><span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: transparent; color: #007bff; border-color: #007bff'></span> <span class='badge badge-pill badge-primary' style='border: 1px solid #007bff; background-color: transparent; color: #007bff; border-color: #007bff'></span> </small> <br>
                </div>

                <div class='col-4 text-center'>
                  <div><b>Total Amount (RM)</b></div>
                  <div>".$totalexpenses."</div>
                </div>
              </div>
              <p><div class='dropdown-divider border-2'></div></p>

      
            ";

            $Expenseobject = new Expense();
            $dataexpenses = $Expenseobject->searchexpensessubid($row3->budgetSubAllocationID,$month,$year);
            if($dataexpenses){

              $view .="
              <div class='card my-2'>
                <div class='card-body pb-3' style='height:350px;overflow-y:scroll;'>
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
                    <a href='#' class='dropdown-item updateExpenses' data-toggle='modal' data-backdrop='static' data-target='#updateExpenses' data-id=''><i class='far fa-edit'></i> Update </a>
                    <a href='#' class='dropdown-item deleteExpenses' data-toggle='modal' data-backdrop='static' data-target='#deleteExpense' data-id=''><i class='far fa-trash-alt'></i> Delete</a>
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
  
    list($expcategoryList,$expamount) = getCategory($month,$year,$comp,$balance);

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
                    backgroundColor: [
                      'rgba(5,183,138,1)',
                      'rgba(8,10,51,1)',
                      'rgba(5,42,229,1)',
                      'rgba(220,53,69,1)',
                      'rgba(224,228,232,1)',   //find more color
                      'rgba(248,90,62,1)',
                      'rgba(218,36,200,1)'
                    ],
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
      
  }
  else{
    $view.="
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