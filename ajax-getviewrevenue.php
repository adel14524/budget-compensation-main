<?php
require_once 'core/init.php';
$user = new User();
if (!$user->isLoggedIn()) {
  Redirect::to("login.php");
} else {
  $resultresult = $user->data();
  $userlevel = $resultresult->role;
  if ($resultresult->verified == false || $resultresult->superadmin == true) {
    $user->logout();
    Redirect::to("login.php?error=error");
  }
}
if (Input::exists()) {

  $company = escape(Input::get('comp'));
  $year = escape(Input::get('year'));
  $revenueobject = new Revenue();
  $budgetobject = new Budgetinitial();
  if ($resultresult->userID) {

    $data = $revenueobject->searchRevenueestimate($company, $year, "estimatedrev");
    $data2 = $revenueobject->searchRevenueactual($company, $year, "actualrev");
    $data3 = $budgetobject->searchBudgetCompany($company, $year);
  }
  $view = "";

  if ($data3) {
    if ($data && $data2) {

      $view .="
        <!-- <div class='col-xl-12 col-6 text-right'>
          <button type='button' class='btn btn-success shadow-sm saverev1 ' data-toggle='modal' data-backdrop='static' data-target='#baselineValue'> Get Actual Revenue from Baseline</button>
        </div> --><br>
  
        <div class='table-responsive text-nowrap'>
        <table style='text-align:center; width:100%;' class='table' id='revtable'>
          <thead>
            <tr>
              <th>Month</th>
              <th>Projected Revenue (RM)</th>
              <th>History</th>
              <th>Actual Revenue (RM)</th>
              <th>History</th>
            </tr>
          </thead>
      ";

      if ($data) {
        $janestimate = $data->january;
        $febestimate = $data->february;
        $marestimate = $data->march;
        $aprestimate = $data->april;
        $mayestimate = $data->may;
        $junestimate = $data->june;
        $julestimate = $data->july;
        $augestimate = $data->august;
        $sepestimate = $data->september;
        $octestimate = $data->october;
        $novestimate = $data->november;
        $decestimate = $data->december;
      }

      if ($data2) {
        $janactual = $data2->january;
        $febactual = $data2->february;
        $maractual = $data2->march;
        $apractual = $data2->april;
        $mayactual = $data2->may;
        $junactual = $data2->june;
        $julactual = $data2->july;
        $augactual = $data2->august;
        $sepactual = $data2->september;
        $octactual = $data2->october;
        $novactual = $data2->november;
        $decactual = $data2->december;
      }

      $revenueobject = new Revenue();
      $revenueobj = $revenueobject->searchRevenueEstLog($data->budgetRevenueID);
      $revenueobj2 = $revenueobject->searchRevenueActLog($data2->budgetRevenueID);


      $view .= "
          <tbody>
            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>January</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $janestimate . "' id='estimated1' name='estimated1' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='january' data-month='1' data-prev='" . $janestimate . "'><small><span id='estimatederror1'></span></small></div></td>
              <td style='vertical-align:middle;'><a href ='#janestimated' class='' data-toggle='modal' data-target='#janestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $janactual . "' id='actual1' name='actual1' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='january' data-month='1' data-prev='" . $janactual . "'><small><span id='actualerror1'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#janactual' class='' data-toggle='modal' data-target='#janactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='janestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'>History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>January - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj) {
        foreach ($revenueobj as $row) {
          if ($row->revMonth == "January") {
            $janaction = $row->action;
            $janlog = $row->newValue;
            $prevlog = $row->previousValue;
            $jantime = $row->time;

            $show = "<label>" . $janaction . " on " . $jantime . " : From RM " . $prevlog . " to RM " . $janlog . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "         
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='janactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>    
                        <label><b>January - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2) {
        foreach ($revenueobj2 as $row2) {
          if ($row2->revMonth == "January") {
            $janlog2 = $row2->newValue;
            $janaction2 = $row2->action;
            $jantime2 = $row2->time;
            $prevlog2 = $row2->previousValue;

            $show = "<label>" . $janaction2 . " on " . $jantime2 . " : From RM " . $prevlog2 . " to RM " . $janlog2 . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "         
                        </div>                    
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            </tr>

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>February</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $febestimate . "' id='estimated2' name='estimated2'  data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='february' data-month='2' data-prev='" . $febestimate . "'><small><span id='estimatederror2'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#febestimated' class='' data-toggle='modal' data-target='#febestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $febactual . "' id='actual2' name='actual2' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='february' data-month='2' data-prev='" . $febactual . "'><small><span id='actualerror2'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#febactual' class='' data-toggle='modal' data-target='#febactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='febestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>February - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj) {
        foreach ($revenueobj as $row) {
          if ($row->revMonth == "February") {
            $feblog = $row->newValue;
            $febaction = $row->action;
            $febtime = $row->time;
            $febprevlog = $row->previousValue;

            $show = "<label>" . $febaction . " on " . $febtime . " : From RM " . $febprevlog . " to RM " . $feblog . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='febactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>February - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2) {
        foreach ($revenueobj2 as $row2) {
          if ($row2->revMonth == "February") {
            $feblog2 = $row2->newValue;
            $febaction2 = $row2->action;
            $febtime2 = $row2->time;
            $febprevlog2 = $row2->previousValue;

            $show = "<label>" . $febaction2 . " on " . $febtime2 . " : From RM " . $febprevlog2 . " to RM " . $feblog2 . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "                       
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>    
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>March</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $marestimate . "' id='estimated3' name='estimated3' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='march' data-month='3' data-prev='" . $marestimate . "'><small><span id='estimatederror3'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#marestimated' class='' data-toggle='modal' data-target='#marestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $maractual . "' id='actual3' name='actual3' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='march' data-month='3' data-prev='" . $maractual . "'><small><span id='actualerror3'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#maractual' class='' data-toggle='modal' data-target='#maractual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='marestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>March - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj) {
        foreach ($revenueobj as $row) {
          if ($row->revMonth == "March") {
            $marlog = $row->newValue;
            $maraction = $row->action;
            $martime = $row->time;
            $marprevlog = $row->previousValue;

            $show = "<label>" . $maraction . " on " . $martime . " : From RM " . $marprevlog . " to RM " . $marlog . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "                        
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='maractual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>March - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2) {
        foreach ($revenueobj2 as $row2) {
          if ($row2->revMonth == "March") {
            $marlog2 = $row2->newValue;
            $maraction2 = $row2->action;
            $martime2 = $row2->time;
            $marprevlog2 = $row2->previousValue;

            $show = "<label>" . $maraction2 . " on " . $martime2 . " : From RM " . $marprevlog2 . " to RM " . $marlog2 . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "               
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>April</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $aprestimate . "' id='estimated4' name='estimated4' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='april' data-month='4' data-prev='" . $aprestimate . "'><small><span id='estimatederror4'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#aprestimated' class='' data-toggle='modal' data-target='#aprestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $apractual . "' id='actual4' name='actual4' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='april' data-month='4' data-prev='" . $apractual . "'><small><span id='actualerror4'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#apractual' class='' data-toggle='modal' data-target='#apractual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='aprestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>April - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj) {
        foreach ($revenueobj as $row) {
          if ($row->revMonth == "April") {
            $aprlog = $row->newValue;
            $apraction = $row->action;
            $aprtime = $row->time;
            $aprprevlog = $row->previousValue;

            $show = "<label>" . $apraction . " on " . $aprtime . " : From RM " . $aprprevlog . " to " . $aprlog . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "           
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='apractual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>April - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2) {
        foreach ($revenueobj2 as $row2) {
          if ($row2->revMonth == "April") {
            $aprlog2 = $row2->newValue;
            $apraction2 = $row2->action;
            $aprtime2 = $row2->time;
            $aprprevlog2 = $row2->previousValue;

            $show = "<label>" . $apraction2 . " on " . $aprtime2 . " : From RM " . $aprprevlog2 . " to RM " . $aprlog2 . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>May</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $mayestimate . "' id='estimated5' name='estimated5' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='may' data-month='5' data-prev='" . $mayestimate . "'><small><span id='estimatederror5'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#mayestimated' class='' data-toggle='modal' data-target='#mayestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $mayactual . "' id='actual5' name='actual5' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='may' data-month='5' data-prev='" . $mayactual . "'><small><span id='actualerror5'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#mayactual' class='' data-toggle='modal' data-target='#mayactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='mayestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>May - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj) {
        foreach ($revenueobj as $row) {
          if ($row->revMonth == "May") {
            $maylog = $row->newValue;
            $mayaction = $row->action;
            $maytime = $row->time;
            $mayprevlog = $row->previousValue;

            $show = "<label>" . $mayaction . " on " . $maytime . " : From RM " . $mayprevlog . " to RM " . $maylog . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "                    
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='mayactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>May - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2) {
        foreach ($revenueobj2 as $row2) {
          if ($row2->revMonth == "May") {
            $maylog2 = $row2->newValue;
            $mayaction2 = $row2->action;
            $maytime2 = $row2->time;
            $mayprevlog2=$row2->previousValue;

            $show = "<label>" . $mayaction2 . " on " . $maytime2 . " : From RM " . $mayprevlog2 . " to RM ".$maylog2."</label><br>";
            $view .= $show;
          } 
        }
      }

      $view .= "                              
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>                
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>June</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $junestimate . "' id='estimated6' name='estimated6' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='june' data-month='6' data-prev='" . $junestimate . "'><small><span id='estimatederror6'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#junestimated' class='' data-toggle='modal' data-target='#junestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $junactual . "' id='actual6' name='actual6' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='june' data-month='6' data-prev='" . $junactual . "'><small><span id='actualerror6'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#junactual' class='' data-toggle='modal' data-target='#junactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='junestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>June - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "June") {
            $junlog= $row->newValue;
            $junaction=$row->action;
            $juntime=$row->time;
            $junprevlog=$row->previousValue;

            $show="<label>".$junaction." on ".$juntime." : From RM " .$junprevlog." to RM ".$junlog."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "                
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='junactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>June - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        foreach($revenueobj2 as $row2){
          if ($row2->revMonth == "June") {
            $junlog2= $row2->newValue;
            $junaction2=$row2->action;
            $juntime2=$row2->time;
            $junprevlog2=$row2->previousValue;

            $show="<label>".$junaction2." on ".$juntime2." : From RM " .$junprevlog2." to RM ".$junlog2."</label><br>";       
            $view.= $show;
          }
        }
      }

      $view .= "                      
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>July</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $julestimate . "' id='estimated7' name='estimated7' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='july' data-month='7' data-prev='" . $julestimate . "'><small><span id='estimatederror7'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#julestimated' class='' data-toggle='modal' data-target='#julestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $julactual . "' id='actual7' name='actual7' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='july' data-month='7' data-prev='" . $julactual . "'><small><span id='actualerror7'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#julactual' class='' data-toggle='modal' data-target='#julactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='julestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>July - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "July") {
            $jullog= $row->newValue;
            $julaction=$row->action;
            $jultime=$row->time;
            $julprevlog=$row->previousValue;

            $show="<label>".$julaction." on ".$jultime." : From RM " .$julprevlog." to RM " .$jullog."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "                        
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='julactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>July - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        foreach($revenueobj2 as $row2){
          if ($row2->revMonth == "July") {
            $jullog2= $row2->newValue;
            $julaction2=$row2->action;
            $jultime2=$row2->time;
            $julprevlog2=$row2->previousValue;

            $show="<label>".$julaction2." on ".$jultime2." : From RM " .$julprevlog2." to RM " .$jullog2."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "                         
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>               
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>August</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $augestimate . "' id='estimated8' name='estimated8' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='august' data-month='8' data-prev='" . $augestimate . "'><small><span id='estimatederror8'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#augestimated' class='' data-toggle='modal' data-target='#augestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $augactual . "' id='actual8' name='actual8' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='august' data-month='8' data-prev='" . $augactual . "'><small><span id='actualerror8'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#augactual' class='' data-toggle='modal' data-target='#augactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='augestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>August - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "August") {
            $auglog= $row->newValue;
            $augaction=$row->action;
            $augtime=$row->time;
            $augprevlog=$row->previousValue;

            $show="<label>".$augaction." on ".$augtime." : From RM " .$augprevlog." to RM " .$auglog."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "                      
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='augactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>August - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        foreach($revenueobj2 as $row2){
          if ($row2->revMonth == "August") {
            $auglog2= $row2->newValue;
            $augaction2=$row2->action;
            $augtime2=$row2->time;
            $augprevlog2=$row2->previousValue;

            $show="<label>".$augaction2." on ".$augtime2." : From RM " .$augprevlog2." to RM " .$auglog2."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "
                          
                                      
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>                
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>September</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $sepestimate . "' id='estimated9' name='estimated9' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='september' data-month='9' data-prev='" . $sepestimate . "'><small><span id='estimatederror9'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#sepestimated' class='' data-toggle='modal' data-target='#sepestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $sepactual . "' id='actual9' name='actual9' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='september' data-month='9' data-prev='" . $sepactual . "'><small><span id='actualerror9'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#sepactual' class='' data-toggle='modal' data-target='#sepactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='sepestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>September - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "September") {
            $seplog= $row->newValue;
            $sepaction=$row->action;
            $septime=$row->time;
            $sepprevlog=$row->previousValue;

            $show="<label>".$sepaction." on ".$septime." : From RM " .$sepprevlog." to RM " .$seplog."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "      
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='sepactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>September - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        foreach($revenueobj2 as $row2){
          if ($row2->revMonth == "September") {
            $seplog2= $row2->newValue;
            $sepaction2=$row2->action;
            $septime2=$row2->time;
            $sepprevlog2=$row2->previousValue;

            $show="<label>".$sepaction2." on ".$septime2." : From RM " .$sepprevlog2." to RM " .$seplog2."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "              
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>October</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $octestimate . "' id='estimated10' name='estimated10' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='october' data-month='10' data-prev='" . $octestimate . "'><small><span id='estimatederror10'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#octestimated' class='' data-toggle='modal' data-target='#octestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $octactual . "' id='actual10' name='actual10' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='october' data-month='10' data-prev='" . $octactual . "'><small><span id='actualerror10'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#octactual' class='' data-toggle='modal' data-target='#octactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='octestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>October - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "October") {
            $octlog= $row->newValue;
            $octaction=$row->action;
            $octtime=$row->time;
            $octprevlog=$row->previousValue;

            $show="<label>".$octaction." on ".$octtime." : From RM " .$octprevlog." to RM " .$octlog."</label><br>";
            $view.= $show;

          }
        }
      }

      $view .= "          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='octactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>October - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        foreach($revenueobj2 as $row2){
          if ($row2->revMonth == "October") {
            $octlog2= $row2->newValue;
            $octaction2=$row2->action;
            $octtime2=$row2->time;
            $octprevlog2=$row2->previousValue;

            $show="<label>".$octaction2." on ".$octtime2." : From RM " .$octprevlog2." to RM " .$octlog2."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "              
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>               
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>November</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $novestimate . "' id='estimated11' name='estimated11' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='november' data-month='11' data-prev='" . $novestimate . "'><small><span id='estimatederror11'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#novestimated' class='' data-toggle='modal' data-target='#novestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $novactual . "' id='actual11' name='actual11' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='november' data-month='11' data-prev='" . $novactual . "'><small><span id='actualerror11'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#novactual' class='' data-toggle='modal' data-target='#novactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='novestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>November - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "November") {
            $novlog= $row->newValue;
            $novaction=$row->action;
            $novtime=$row->time;
            $novprevlog=$row->previousValue;

            $show="<label>".$novaction." on ".$novtime." : From RM " .$novprevlog." to RM " .$novlog."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "               
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='novactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>November - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        foreach($revenueobj2 as $row2){
          if ($row2->revMonth == "November") {
            $novlog2= $row2->newValue;
            $novaction2=$row2->action;
            $novtime2=$row2->time;
            $novprevlog2=$row2->previousValue;

            $show="<label>".$novaction2." on ".$novtime2." : From RM " .$novprevlog2." to RM " .$novlog2."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "                   
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>               
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>December</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $decestimate . "' id='estimated12' name='estimated12' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='december' data-month='12' data-prev='" . $decestimate . "'><small><span id='estimatederror12'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#decestimated' class='' data-toggle='modal' data-target='#decestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $decactual . "' id='actual12' name='actual12' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='december' data-month='12' data-prev='" . $decactual . "'><small><span id='actualerror12'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#decactual' class='' data-toggle='modal' data-target='#decactual' ><i class='fas fa-history'></i> </a></td>
              <div class='modal fade' id='decestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>December - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "December") {
            $declog= $row->newValue;
            $decaction=$row->action;
            $dectime=$row->time;
            $decprevlog=$row->previousValue;

            $show="<label>".$decaction." on ".$dectime." : From RM " .$decprevlog." to RM " .$declog."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "                         
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='decactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>December - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        $prevdec2="";

        foreach($revenueobj2 as $row2){
          $declog2= $row2->newValue;
          $decaction2=$row2->action;
          $dectime2=$row2->time;
          $decprevlog2=$row2->previousValue;

          $show="<label>".$decaction2." on ".$dectime2." : From RM " .$decprevlog2." to RM " .$declog2."</label><br>";
          $view.= $show;

        }
      }

      $view .= "           
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            </tr>
          </tbody>
        </table>
        </div> 
      ";
    }
    /*view estimate*/ 
    elseif ($data != null && $data2 == null) {
      $view .="
        <!-- <div class='col-xl-12 col-6 text-right'>
          <button type='button' class='btn btn-success shadow-sm saverev1 ' data-toggle='modal' data-backdrop='static' data-target='#addRevenue'> Get Actual Revenue from Baseline</button>
        </div> --><br>
  
        <div class='table-responsive text-nowrap'>
        <table style='text-align:center; width:100%;' class='table' id='revtable'>
          <thead>
            <tr>
              <th>Month</th>
              <th>Projected Revenue (RM)</th>
              <th>History</th>
              <th>Actual Revenue (RM)</th>
              <th>History</th>
            </tr>
          </thead>
      ";

      if ($data) {
        $janestimate = $data->january;
        $febestimate = $data->february;
        $marestimate = $data->march;
        $aprestimate = $data->april;
        $mayestimate = $data->may;
        $junestimate = $data->june;
        $julestimate = $data->july;
        $augestimate = $data->august;
        $sepestimate = $data->september;
        $octestimate = $data->october;
        $novestimate = $data->november;
        $decestimate = $data->december;
      }

      if ($data2 == null) {
        $revenueobject = new Revenue();
        $revenueobject->addRevenue(array(
          'typeRevenue' => 'actualrev',
          'year' => $year,
          'january' => null,
          'february' => null,
          'march' => null,
          'april' => null,
          'may' => null,
          'june' => null,
          'july' => null,
          'august' => null,
          'september' => null,
          'october' => null,
          'november' => null,
          'december' => null,

          'userID' => $resultresult->userID,
          'corporateID' => $resultresult->corporateID,
          'companyID' => $company,
        ));
        $id = $revenueobject->lastInsertId();

        $data2 = $revenueobject->searchRevenueactual($company, $year, "actualrev");

        $janactual = $data2->january;
        $febactual = $data2->february;
        $maractual = $data2->march;
        $apractual = $data2->april;
        $mayactual = $data2->may;
        $junactual = $data2->june;
        $julactual = $data2->july;
        $augactual = $data2->august;
        $sepactual = $data2->september;
        $octactual = $data2->october;
        $novactual = $data2->november;
        $decactual = $data2->december;
      }

      $revenueobject = new Revenue();
      $revenueobj = $revenueobject->searchRevenueEstLog($data->budgetRevenueID);
      $revenueobj2 = $revenueobject->searchRevenueActLog($data2->budgetRevenueID);

      $view .= "
          <tbody>
            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>January</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $janestimate . "' id='estimated1' name='estimated1' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='january' data-month='1' data-prev='" . $janestimate . "'><small><span id='estimatederror1'></span></small></div></td>
              <td style='vertical-align:middle;'><a href ='#janestimated' class='' data-toggle='modal' data-target='#janestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $janactual . "' id='actual1' name='actual1' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='january' data-month='1' data-prev='" . $janactual . "'><small><span id='actualerror1'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#janactual' class='' data-toggle='modal' data-target='#janactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='janestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'>History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>January - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj) {
        foreach ($revenueobj as $row) {
          if ($row->revMonth == "January") {
            $janaction = $row->action;
            $janlog = $row->newValue;
            $prevlog = $row->previousValue;
            $jantime = $row->time;

            $show = "<label>" . $janaction . " on " . $jantime . " : From RM " . $prevlog . " to RM " . $janlog . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "         
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='janactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>    
                        <label><b>January - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2) {
        foreach ($revenueobj2 as $row2) {
          if ($row2->revMonth == "January") {
            $janlog2 = $row2->newValue;
            $janaction2 = $row2->action;
            $jantime2 = $row2->time;
            $prevlog2 = $row2->previousValue;

            $show = "<label>" . $janaction2 . " on " . $jantime2 . " : From RM " . $prevlog2 . " to RM " . $janlog2 . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "         
                        </div>                    
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            </tr>

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>February</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $febestimate . "' id='estimated2' name='estimated2'  data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='february' data-month='2' data-prev='" . $febestimate . "'><small><span id='estimatederror2'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#febestimated' class='' data-toggle='modal' data-target='#febestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $febactual . "' id='actual2' name='actual2' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='february' data-month='2' data-prev='" . $febactual . "'><small><span id='actualerror2'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#febactual' class='' data-toggle='modal' data-target='#febactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='febestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>February - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj) {
        foreach ($revenueobj as $row) {
          if ($row->revMonth == "February") {
            $feblog = $row->newValue;
            $febaction = $row->action;
            $febtime = $row->time;
            $febprevlog = $row->previousValue;

            $show = "<label>" . $febaction . " on " . $febtime . " : From RM " . $febprevlog . " to RM " . $feblog . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='febactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>February - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2) {
        foreach ($revenueobj2 as $row2) {
          if ($row2->revMonth == "February") {
            $feblog2 = $row2->newValue;
            $febaction2 = $row2->action;
            $febtime2 = $row2->time;
            $febprevlog2 = $row2->previousValue;

            $show = "<label>" . $febaction2 . " on " . $febtime2 . " : From RM " . $febprevlog2 . " to RM " . $feblog2 . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "                       
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>    
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>March</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $marestimate . "' id='estimated3' name='estimated3' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='march' data-month='3' data-prev='" . $marestimate . "'><small><span id='estimatederror3'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#marestimated' class='' data-toggle='modal' data-target='#marestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $maractual . "' id='actual3' name='actual3' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='march' data-month='3' data-prev='" . $maractual . "'><small><span id='actualerror3'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#maractual' class='' data-toggle='modal' data-target='#maractual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='marestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>March - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj) {
        foreach ($revenueobj as $row) {
          if ($row->revMonth == "March") {
            $marlog = $row->newValue;
            $maraction = $row->action;
            $martime = $row->time;
            $marprevlog = $row->previousValue;

            $show = "<label>" . $maraction . " on " . $martime . " : From RM " . $marprevlog . " to RM " . $marlog . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "                        
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='maractual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>March - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2) {
        foreach ($revenueobj2 as $row2) {
          if ($row2->revMonth == "March") {
            $marlog2 = $row2->newValue;
            $maraction2 = $row2->action;
            $martime2 = $row2->time;
            $marprevlog2 = $row2->previousValue;

            $show = "<label>" . $maraction2 . " on " . $martime2 . " : From RM " . $marprevlog2 . " to RM " . $marlog2 . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "               
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>April</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $aprestimate . "' id='estimated4' name='estimated4' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='april' data-month='4' data-prev='" . $aprestimate . "'><small><span id='estimatederror4'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#aprestimated' class='' data-toggle='modal' data-target='#aprestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $apractual . "' id='actual4' name='actual4' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='april' data-month='4' data-prev='" . $apractual . "'><small><span id='actualerror4'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#apractual' class='' data-toggle='modal' data-target='#apractual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='aprestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>April - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj) {
        foreach ($revenueobj as $row) {
          if ($row->revMonth == "April") {
            $aprlog = $row->newValue;
            $apraction = $row->action;
            $aprtime = $row->time;
            $aprprevlog = $row->previousValue;

            $show = "<label>" . $apraction . " on " . $aprtime . " : From RM " . $aprprevlog . " to " . $aprlog . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "           
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='apractual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>April - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2) {
        foreach ($revenueobj2 as $row2) {
          if ($row2->revMonth == "April") {
            $aprlog2 = $row2->newValue;
            $apraction2 = $row2->action;
            $aprtime2 = $row2->time;
            $aprprevlog2 = $row2->previousValue;

            $show = "<label>" . $apraction2 . " on " . $aprtime2 . " : From RM " . $aprprevlog2 . " to RM " . $aprlog2 . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>May</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $mayestimate . "' id='estimated5' name='estimated5' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='may' data-month='5' data-prev='" . $mayestimate . "'><small><span id='estimatederror5'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#mayestimated' class='' data-toggle='modal' data-target='#mayestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $mayactual . "' id='actual5' name='actual5' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='may' data-month='5' data-prev='" . $mayactual . "'><small><span id='actualerror5'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#mayactual' class='' data-toggle='modal' data-target='#mayactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='mayestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>May - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj) {
        foreach ($revenueobj as $row) {
          if ($row->revMonth == "May") {
            $maylog = $row->newValue;
            $mayaction = $row->action;
            $maytime = $row->time;
            $mayprevlog = $row->previousValue;

            $show = "<label>" . $mayaction . " on " . $maytime . " : From RM " . $mayprevlog . " to RM " . $maylog . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "                    
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='mayactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>May - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2) {
        foreach ($revenueobj2 as $row2) {
          if ($row2->revMonth == "May") {
            $maylog2 = $row2->newValue;
            $mayaction2 = $row2->action;
            $maytime2 = $row2->time;
            $mayprevlog2=$row2->previousValue;

            $show = "<label>" . $mayaction2 . " on " . $maytime2 . " : From RM " . $mayprevlog2 . " to RM ".$maylog2."</label><br>";
            $view .= $show;
          } 
        }
      }

      $view .= "                              
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>                
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>June</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $junestimate . "' id='estimated6' name='estimated6' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='june' data-month='6' data-prev='" . $junestimate . "'><small><span id='estimatederror6'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#junestimated' class='' data-toggle='modal' data-target='#junestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $junactual . "' id='actual6' name='actual6' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='june' data-month='6' data-prev='" . $junactual . "'><small><span id='actualerror6'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#junactual' class='' data-toggle='modal' data-target='#junactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='junestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>June - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "June") {
            $junlog= $row->newValue;
            $junaction=$row->action;
            $juntime=$row->time;
            $junprevlog=$row->previousValue;

            $show="<label>".$junaction." on ".$juntime." : From RM " .$junprevlog." to RM ".$junlog."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "                
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='junactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>June - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        foreach($revenueobj2 as $row2){
          if ($row2->revMonth == "June") {
            $junlog2= $row2->newValue;
            $junaction2=$row2->action;
            $juntime2=$row2->time;
            $junprevlog2=$row2->previousValue;

            $show="<label>".$junaction2." on ".$juntime2." : From RM " .$junprevlog2." to RM ".$junlog2."</label><br>";       
            $view.= $show;
          }
        }
      }

      $view .= "                      
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>July</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $julestimate . "' id='estimated7' name='estimated7' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='july' data-month='7' data-prev='" . $julestimate . "'><small><span id='estimatederror7'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#julestimated' class='' data-toggle='modal' data-target='#julestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $julactual . "' id='actual7' name='actual7' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='july' data-month='7' data-prev='" . $julactual . "'><small><span id='actualerror7'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#julactual' class='' data-toggle='modal' data-target='#julactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='julestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>July - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "July") {
            $jullog= $row->newValue;
            $julaction=$row->action;
            $jultime=$row->time;
            $julprevlog=$row->previousValue;

            $show="<label>".$julaction." on ".$jultime." : From RM " .$julprevlog." to RM " .$jullog."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "                        
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='julactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>July - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        foreach($revenueobj2 as $row2){
          if ($row2->revMonth == "July") {
            $jullog2= $row2->newValue;
            $julaction2=$row2->action;
            $jultime2=$row2->time;
            $julprevlog2=$row2->previousValue;

            $show="<label>".$julaction2." on ".$jultime2." : From RM " .$julprevlog2." to RM " .$jullog2."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "                         
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>               
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>August</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $augestimate . "' id='estimated8' name='estimated8' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='august' data-month='8' data-prev='" . $augestimate . "'><small><span id='estimatederror8'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#augestimated' class='' data-toggle='modal' data-target='#augestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $augactual . "' id='actual8' name='actual8' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='august' data-month='8' data-prev='" . $augactual . "'><small><span id='actualerror8'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#augactual' class='' data-toggle='modal' data-target='#augactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='augestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>August - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "August") {
            $auglog= $row->newValue;
            $augaction=$row->action;
            $augtime=$row->time;
            $augprevlog=$row->previousValue;

            $show="<label>".$augaction." on ".$augtime." : From RM " .$augprevlog." to RM " .$auglog."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "                      
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='augactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>August - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        foreach($revenueobj2 as $row2){
          if ($row2->revMonth == "August") {
            $auglog2= $row2->newValue;
            $augaction2=$row2->action;
            $augtime2=$row2->time;
            $augprevlog2=$row2->previousValue;

            $show="<label>".$augaction2." on ".$augtime2." : From RM " .$augprevlog2." to RM " .$auglog2."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "
                          
                                      
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>                
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>September</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $sepestimate . "' id='estimated9' name='estimated9' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='september' data-month='9' data-prev='" . $sepestimate . "'><small><span id='estimatederror9'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#sepestimated' class='' data-toggle='modal' data-target='#sepestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $sepactual . "' id='actual9' name='actual9' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='september' data-month='9' data-prev='" . $sepactual . "'><small><span id='actualerror9'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#sepactual' class='' data-toggle='modal' data-target='#sepactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='sepestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>September - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "September") {
            $seplog= $row->newValue;
            $sepaction=$row->action;
            $septime=$row->time;
            $sepprevlog=$row->previousValue;

            $show="<label>".$sepaction." on ".$septime." : From RM " .$sepprevlog." to RM " .$seplog."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "      
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='sepactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>September - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        foreach($revenueobj2 as $row2){
          if ($row2->revMonth == "September") {
            $seplog2= $row2->newValue;
            $sepaction2=$row2->action;
            $septime2=$row2->time;
            $sepprevlog2=$row2->previousValue;

            $show="<label>".$sepaction2." on ".$septime2." : From RM " .$sepprevlog2." to RM " .$seplog2."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "              
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>October</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $octestimate . "' id='estimated10' name='estimated10' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='october' data-month='10' data-prev='" . $octestimate . "'><small><span id='estimatederror10'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#octestimated' class='' data-toggle='modal' data-target='#octestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $octactual . "' id='actual10' name='actual10' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='october' data-month='10' data-prev='" . $octactual . "'><small><span id='actualerror10'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#octactual' class='' data-toggle='modal' data-target='#octactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='octestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>October - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "October") {
            $octlog= $row->newValue;
            $octaction=$row->action;
            $octtime=$row->time;
            $octprevlog=$row->previousValue;

            $show="<label>".$octaction." on ".$octtime." : From RM " .$octprevlog." to RM " .$octlog."</label><br>";
            $view.= $show;

          }
        }
      }

      $view .= "          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='octactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>October - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        foreach($revenueobj2 as $row2){
          if ($row2->revMonth == "October") {
            $octlog2= $row2->newValue;
            $octaction2=$row2->action;
            $octtime2=$row2->time;
            $octprevlog2=$row2->previousValue;

            $show="<label>".$octaction2." on ".$octtime2." : From RM " .$octprevlog2." to RM " .$octlog2."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "              
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>               
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>November</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $novestimate . "' id='estimated11' name='estimated11' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='november' data-month='11' data-prev='" . $novestimate . "'><small><span id='estimatederror11'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#novestimated' class='' data-toggle='modal' data-target='#novestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $novactual . "' id='actual11' name='actual11' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='november' data-month='11' data-prev='" . $novactual . "'><small><span id='actualerror11'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#novactual' class='' data-toggle='modal' data-target='#novactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='novestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>November - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "November") {
            $novlog= $row->newValue;
            $novaction=$row->action;
            $novtime=$row->time;
            $novprevlog=$row->previousValue;

            $show="<label>".$novaction." on ".$novtime." : From RM " .$novprevlog." to RM " .$novlog."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "               
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='novactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>November - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        foreach($revenueobj2 as $row2){
          if ($row2->revMonth == "November") {
            $novlog2= $row2->newValue;
            $novaction2=$row2->action;
            $novtime2=$row2->time;
            $novprevlog2=$row2->previousValue;

            $show="<label>".$novaction2." on ".$novtime2." : From RM " .$novprevlog2." to RM " .$novlog2."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "                   
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>               
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>December</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $decestimate . "' id='estimated12' name='estimated12' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='december' data-month='12' data-prev='" . $decestimate . "'><small><span id='estimatederror12'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#decestimated' class='' data-toggle='modal' data-target='#decestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $decactual . "' id='actual12' name='actual12' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='december' data-month='12' data-prev='" . $decactual . "'><small><span id='actualerror12'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#decactual' class='' data-toggle='modal' data-target='#decactual' ><i class='fas fa-history'></i> </a></td>
              <div class='modal fade' id='decestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>December - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "December") {
            $declog= $row->newValue;
            $decaction=$row->action;
            $dectime=$row->time;
            $decprevlog=$row->previousValue;

            $show="<label>".$decaction." on ".$dectime." : From RM " .$decprevlog." to RM " .$declog."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "                         
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='decactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>December - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        $prevdec2="";

        foreach($revenueobj2 as $row2){
          $declog2= $row2->newValue;
          $decaction2=$row2->action;
          $dectime2=$row2->time;
          $decprevlog2=$row2->previousValue;

          $show="<label>".$decaction2." on ".$dectime2." : From RM " .$decprevlog2." to RM " .$declog2."</label><br>";
          $view.= $show;

        }
      }

      $view .= "           
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            </tr>
          </tbody>
        </table>
        </div> 
      ";
    }
    /*view actual*/ 
    elseif ($data == null && $data2 !== null) {
      $view .="
        <!-- <div class='col-xl-12 col-6 text-right'>
          <button type='button' class='btn btn-success shadow-sm saverev1 ' data-toggle='modal' data-backdrop='static' data-target='#addRevenue'> Get Actual Revenue from Baseline</button>
        </div> --><br>
  
        <div class='table-responsive text-nowrap'>
        <table style='text-align:center; width:100%;' class='table' id='revtable'>
          <thead>
            <tr>
              <th>Month</th>
              <th>Projected Revenue (RM)</th>
              <th>History</th>
              <th>Actual Revenue (RM)</th>
              <th>History</th>
            </tr>
          </thead>
      ";

      if ($data2) {
        $janactual = $data2->january;
        $febactual = $data2->february;
        $maractual = $data2->march;
        $apractual = $data2->april;
        $mayactual = $data2->may;
        $junactual = $data2->june;
        $julactual = $data2->july;
        $augactual = $data2->august;
        $sepactual = $data2->september;
        $octactual = $data2->october;
        $novactual = $data2->november;
        $decactual = $data2->december;
      }

      if ($data == null) {
        $revenueobject = new Revenue();
        $revenueobject->addRevenue(array(
          'typeRevenue' => 'estimatedrev',
          'year' => $year,
          'january' => null,
          'february' => null,
          'march' => null,
          'april' => null,
          'may' => null,
          'june' => null,
          'july' => null,
          'august' => null,
          'september' => null,
          'october' => null,
          'november' => null,
          'december' => null,

          'userID' => $resultresult->userID,
          'corporateID' => $resultresult->corporateID,
          'companyID' => $company,
        ));
        $id = $revenueobject->lastInsertId();

        $data = $revenueobject->searchRevenueestimate($company, $year, "estimatedrev");

        $janestimate = $data->january;
        $febestimate = $data->february;
        $marestimate = $data->march;
        $aprestimate = $data->april;
        $mayestimate = $data->may;
        $junestimate = $data->june;
        $julestimate = $data->july;
        $augestimate = $data->august;
        $sepestimate = $data->september;
        $octestimate = $data->october;
        $novestimate = $data->november;
        $decestimate = $data->december;
      }

      $revenueobject = new Revenue();
      $revenueobj = $revenueobject->searchRevenueEstLog($data->budgetRevenueID);
      $revenueobj2 = $revenueobject->searchRevenueActLog($data2->budgetRevenueID);

      $view .= "
          <tbody>
            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>January</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $janestimate . "' id='estimated1' name='estimated1' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='january' data-month='1' data-prev='" . $janestimate . "'><small><span id='estimatederror1'></span></small></div></td>
              <td style='vertical-align:middle;'><a href ='#janestimated' class='' data-toggle='modal' data-target='#janestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $janactual . "' id='actual1' name='actual1' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='january' data-month='1' data-prev='" . $janactual . "'><small><span id='actualerror1'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#janactual' class='' data-toggle='modal' data-target='#janactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='janestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'>History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>January - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj) {
        foreach ($revenueobj as $row) {
          if ($row->revMonth == "January") {
            $janaction = $row->action;
            $janlog = $row->newValue;
            $prevlog = $row->previousValue;
            $jantime = $row->time;

            $show = "<label>" . $janaction . " on " . $jantime . " : From RM " . $prevlog . " to RM " . $janlog . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "         
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='janactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>    
                        <label><b>January - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2) {
        foreach ($revenueobj2 as $row2) {
          if ($row2->revMonth == "January") {
            $janlog2 = $row2->newValue;
            $janaction2 = $row2->action;
            $jantime2 = $row2->time;
            $prevlog2 = $row2->previousValue;

            $show = "<label>" . $janaction2 . " on " . $jantime2 . " : From RM " . $prevlog2 . " to RM " . $janlog2 . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "         
                        </div>                    
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            </tr>

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>February</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $febestimate . "' id='estimated2' name='estimated2'  data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='february' data-month='2' data-prev='" . $febestimate . "'><small><span id='estimatederror2'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#febestimated' class='' data-toggle='modal' data-target='#febestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $febactual . "' id='actual2' name='actual2' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='february' data-month='2' data-prev='" . $febactual . "'><small><span id='actualerror2'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#febactual' class='' data-toggle='modal' data-target='#febactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='febestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>February - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj) {
        foreach ($revenueobj as $row) {
          if ($row->revMonth == "February") {
            $feblog = $row->newValue;
            $febaction = $row->action;
            $febtime = $row->time;
            $febprevlog = $row->previousValue;

            $show = "<label>" . $febaction . " on " . $febtime . " : From RM " . $febprevlog . " to RM " . $feblog . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='febactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>February - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2) {
        foreach ($revenueobj2 as $row2) {
          if ($row2->revMonth == "February") {
            $feblog2 = $row2->newValue;
            $febaction2 = $row2->action;
            $febtime2 = $row2->time;
            $febprevlog2 = $row2->previousValue;

            $show = "<label>" . $febaction2 . " on " . $febtime2 . " : From RM " . $febprevlog2 . " to RM " . $feblog2 . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "                       
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>    
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>March</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $marestimate . "' id='estimated3' name='estimated3' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='march' data-month='3' data-prev='" . $marestimate . "'><small><span id='estimatederror3'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#marestimated' class='' data-toggle='modal' data-target='#marestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $maractual . "' id='actual3' name='actual3' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='march' data-month='3' data-prev='" . $maractual . "'><small><span id='actualerror3'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#maractual' class='' data-toggle='modal' data-target='#maractual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='marestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>March - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj) {
        foreach ($revenueobj as $row) {
          if ($row->revMonth == "March") {
            $marlog = $row->newValue;
            $maraction = $row->action;
            $martime = $row->time;
            $marprevlog = $row->previousValue;

            $show = "<label>" . $maraction . " on " . $martime . " : From RM " . $marprevlog . " to RM " . $marlog . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "                        
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='maractual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>March - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2) {
        foreach ($revenueobj2 as $row2) {
          if ($row2->revMonth == "March") {
            $marlog2 = $row2->newValue;
            $maraction2 = $row2->action;
            $martime2 = $row2->time;
            $marprevlog2 = $row2->previousValue;

            $show = "<label>" . $maraction2 . " on " . $martime2 . " : From RM " . $marprevlog2 . " to RM " . $marlog2 . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "               
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>April</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $aprestimate . "' id='estimated4' name='estimated4' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='april' data-month='4' data-prev='" . $aprestimate . "'><small><span id='estimatederror4'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#aprestimated' class='' data-toggle='modal' data-target='#aprestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $apractual . "' id='actual4' name='actual4' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='april' data-month='4' data-prev='" . $apractual . "'><small><span id='actualerror4'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#apractual' class='' data-toggle='modal' data-target='#apractual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='aprestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>April - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj) {
        foreach ($revenueobj as $row) {
          if ($row->revMonth == "April") {
            $aprlog = $row->newValue;
            $apraction = $row->action;
            $aprtime = $row->time;
            $aprprevlog = $row->previousValue;

            $show = "<label>" . $apraction . " on " . $aprtime . " : From RM " . $aprprevlog . " to " . $aprlog . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "           
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='apractual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>April - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2) {
        foreach ($revenueobj2 as $row2) {
          if ($row2->revMonth == "April") {
            $aprlog2 = $row2->newValue;
            $apraction2 = $row2->action;
            $aprtime2 = $row2->time;
            $aprprevlog2 = $row2->previousValue;

            $show = "<label>" . $apraction2 . " on " . $aprtime2 . " : From RM " . $aprprevlog2 . " to RM " . $aprlog2 . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>May</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $mayestimate . "' id='estimated5' name='estimated5' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='may' data-month='5' data-prev='" . $mayestimate . "'><small><span id='estimatederror5'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#mayestimated' class='' data-toggle='modal' data-target='#mayestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $mayactual . "' id='actual5' name='actual5' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='may' data-month='5' data-prev='" . $mayactual . "'><small><span id='actualerror5'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#mayactual' class='' data-toggle='modal' data-target='#mayactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='mayestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>May - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj) {
        foreach ($revenueobj as $row) {
          if ($row->revMonth == "May") {
            $maylog = $row->newValue;
            $mayaction = $row->action;
            $maytime = $row->time;
            $mayprevlog = $row->previousValue;

            $show = "<label>" . $mayaction . " on " . $maytime . " : From RM " . $mayprevlog . " to RM " . $maylog . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "                    
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='mayactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>May - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2) {
        foreach ($revenueobj2 as $row2) {
          if ($row2->revMonth == "May") {
            $maylog2 = $row2->newValue;
            $mayaction2 = $row2->action;
            $maytime2 = $row2->time;
            $mayprevlog2=$row2->previousValue;

            $show = "<label>" . $mayaction2 . " on " . $maytime2 . " : From RM " . $mayprevlog2 . " to RM ".$maylog2."</label><br>";
            $view .= $show;
          } 
        }
      }

      $view .= "                              
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>                
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>June</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $junestimate . "' id='estimated6' name='estimated6' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='june' data-month='6' data-prev='" . $junestimate . "'><small><span id='estimatederror6'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#junestimated' class='' data-toggle='modal' data-target='#junestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $junactual . "' id='actual6' name='actual6' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='june' data-month='6' data-prev='" . $junactual . "'><small><span id='actualerror6'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#junactual' class='' data-toggle='modal' data-target='#junactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='junestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>June - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "June") {
            $junlog= $row->newValue;
            $junaction=$row->action;
            $juntime=$row->time;
            $junprevlog=$row->previousValue;

            $show="<label>".$junaction." on ".$juntime." : From RM " .$junprevlog." to RM ".$junlog."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "                
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='junactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>June - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        foreach($revenueobj2 as $row2){
          if ($row2->revMonth == "June") {
            $junlog2= $row2->newValue;
            $junaction2=$row2->action;
            $juntime2=$row2->time;
            $junprevlog2=$row2->previousValue;

            $show="<label>".$junaction2." on ".$juntime2." : From RM " .$junprevlog2." to RM ".$junlog2."</label><br>";       
            $view.= $show;
          }
        }
      }

      $view .= "                      
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>July</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $julestimate . "' id='estimated7' name='estimated7' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='july' data-month='7' data-prev='" . $julestimate . "'><small><span id='estimatederror7'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#julestimated' class='' data-toggle='modal' data-target='#julestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $julactual . "' id='actual7' name='actual7' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='july' data-month='7' data-prev='" . $julactual . "'><small><span id='actualerror7'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#julactual' class='' data-toggle='modal' data-target='#julactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='julestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>July - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "July") {
            $jullog= $row->newValue;
            $julaction=$row->action;
            $jultime=$row->time;
            $julprevlog=$row->previousValue;

            $show="<label>".$julaction." on ".$jultime." : From RM " .$julprevlog." to RM " .$jullog."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "                        
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='julactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>July - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        foreach($revenueobj2 as $row2){
          if ($row2->revMonth == "July") {
            $jullog2= $row2->newValue;
            $julaction2=$row2->action;
            $jultime2=$row2->time;
            $julprevlog2=$row2->previousValue;

            $show="<label>".$julaction2." on ".$jultime2." : From RM " .$julprevlog2." to RM " .$jullog2."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "                         
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>               
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>August</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $augestimate . "' id='estimated8' name='estimated8' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='august' data-month='8' data-prev='" . $augestimate . "'><small><span id='estimatederror8'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#augestimated' class='' data-toggle='modal' data-target='#augestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $augactual . "' id='actual8' name='actual8' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='august' data-month='8' data-prev='" . $augactual . "'><small><span id='actualerror8'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#augactual' class='' data-toggle='modal' data-target='#augactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='augestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>August - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "August") {
            $auglog= $row->newValue;
            $augaction=$row->action;
            $augtime=$row->time;
            $augprevlog=$row->previousValue;

            $show="<label>".$augaction." on ".$augtime." : From RM " .$augprevlog." to RM " .$auglog."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "                      
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='augactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>August - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        foreach($revenueobj2 as $row2){
          if ($row2->revMonth == "August") {
            $auglog2= $row2->newValue;
            $augaction2=$row2->action;
            $augtime2=$row2->time;
            $augprevlog2=$row2->previousValue;

            $show="<label>".$augaction2." on ".$augtime2." : From RM " .$augprevlog2." to RM " .$auglog2."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "
                          
                                      
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>                
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>September</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $sepestimate . "' id='estimated9' name='estimated9' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='september' data-month='9' data-prev='" . $sepestimate . "'><small><span id='estimatederror9'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#sepestimated' class='' data-toggle='modal' data-target='#sepestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $sepactual . "' id='actual9' name='actual9' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='september' data-month='9' data-prev='" . $sepactual . "'><small><span id='actualerror9'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#sepactual' class='' data-toggle='modal' data-target='#sepactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='sepestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>September - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "September") {
            $seplog= $row->newValue;
            $sepaction=$row->action;
            $septime=$row->time;
            $sepprevlog=$row->previousValue;

            $show="<label>".$sepaction." on ".$septime." : From RM " .$sepprevlog." to RM " .$seplog."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "      
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='sepactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>September - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        foreach($revenueobj2 as $row2){
          if ($row2->revMonth == "September") {
            $seplog2= $row2->newValue;
            $sepaction2=$row2->action;
            $septime2=$row2->time;
            $sepprevlog2=$row2->previousValue;

            $show="<label>".$sepaction2." on ".$septime2." : From RM " .$sepprevlog2." to RM " .$seplog2."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "              
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>October</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $octestimate . "' id='estimated10' name='estimated10' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='october' data-month='10' data-prev='" . $octestimate . "'><small><span id='estimatederror10'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#octestimated' class='' data-toggle='modal' data-target='#octestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $octactual . "' id='actual10' name='actual10' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='october' data-month='10' data-prev='" . $octactual . "'><small><span id='actualerror10'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#octactual' class='' data-toggle='modal' data-target='#octactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='octestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>October - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "October") {
            $octlog= $row->newValue;
            $octaction=$row->action;
            $octtime=$row->time;
            $octprevlog=$row->previousValue;

            $show="<label>".$octaction." on ".$octtime." : From RM " .$octprevlog." to RM " .$octlog."</label><br>";
            $view.= $show;

          }
        }
      }

      $view .= "          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='octactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>October - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        foreach($revenueobj2 as $row2){
          if ($row2->revMonth == "October") {
            $octlog2= $row2->newValue;
            $octaction2=$row2->action;
            $octtime2=$row2->time;
            $octprevlog2=$row2->previousValue;

            $show="<label>".$octaction2." on ".$octtime2." : From RM " .$octprevlog2." to RM " .$octlog2."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "              
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>               
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>November</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $novestimate . "' id='estimated11' name='estimated11' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='november' data-month='11' data-prev='" . $novestimate . "'><small><span id='estimatederror11'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#novestimated' class='' data-toggle='modal' data-target='#novestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $novactual . "' id='actual11' name='actual11' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='november' data-month='11' data-prev='" . $novactual . "'><small><span id='actualerror11'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#novactual' class='' data-toggle='modal' data-target='#novactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='novestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>November - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "November") {
            $novlog= $row->newValue;
            $novaction=$row->action;
            $novtime=$row->time;
            $novprevlog=$row->previousValue;

            $show="<label>".$novaction." on ".$novtime." : From RM " .$novprevlog." to RM " .$novlog."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "               
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='novactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>November - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        foreach($revenueobj2 as $row2){
          if ($row2->revMonth == "November") {
            $novlog2= $row2->newValue;
            $novaction2=$row2->action;
            $novtime2=$row2->time;
            $novprevlog2=$row2->previousValue;

            $show="<label>".$novaction2." on ".$novtime2." : From RM " .$novprevlog2." to RM " .$novlog2."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "                   
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>               
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>December</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $decestimate . "' id='estimated12' name='estimated12' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='december' data-month='12' data-prev='" . $decestimate . "'><small><span id='estimatederror12'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#decestimated' class='' data-toggle='modal' data-target='#decestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $decactual . "' id='actual12' name='actual12' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='december' data-month='12' data-prev='" . $decactual . "'><small><span id='actualerror12'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#decactual' class='' data-toggle='modal' data-target='#decactual' ><i class='fas fa-history'></i> </a></td>
              <div class='modal fade' id='decestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>December - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "December") {
            $declog= $row->newValue;
            $decaction=$row->action;
            $dectime=$row->time;
            $decprevlog=$row->previousValue;

            $show="<label>".$decaction." on ".$dectime." : From RM " .$decprevlog." to RM " .$declog."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "                         
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='decactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>December - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        $prevdec2="";

        foreach($revenueobj2 as $row2){
          $declog2= $row2->newValue;
          $decaction2=$row2->action;
          $dectime2=$row2->time;
          $decprevlog2=$row2->previousValue;

          $show="<label>".$decaction2." on ".$dectime2." : From RM " .$decprevlog2." to RM " .$declog2."</label><br>";
          $view.= $show;

        }
      }

      $view .= "           
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            </tr>
          </tbody>
        </table>
        </div> 
      ";
    } 
    elseif ($data == null && $data2 == null) {
      $view .="
        <!-- <div class='col-xl-12 col-6 text-right'>
          <button type='button' class='btn btn-success shadow-sm saverev1 ' data-toggle='modal' data-backdrop='static' data-target='#addRevenue'> Get Actual Revenue from Baseline</button>
        </div> --> <br>
  
        <div class='table-responsive text-nowrap'>
        <table style='text-align:center; width:100%;' class='table' id='revtable'>
          <thead>
            <tr>
              <th>Month</th>
              <th>Projected Revenue (RM)</th>
              <th>History</th>
              <th>Actual Revenue (RM)</th>
              <th>History</th>
            </tr>
          </thead>
      ";

      if ($data == null && $data2 == null) {
        $revenueobject = new Revenue();
        $revenueobject->addRevenue(array(
          'typeRevenue' => 'estimatedrev',
          'year' => $year,
          'january' => null,
          'february' => null,
          'march' => null,
          'april' => null,
          'may' => null,
          'june' => null,
          'july' => null,
          'august' => null,
          'september' => null,
          'october' => null,
          'november' => null,
          'december' => null,

          'userID' => $resultresult->userID,
          'corporateID' => $resultresult->corporateID,
          'companyID' => $company,
        ));
        $id = $revenueobject->lastInsertId();

        $revenueobject1 = new Revenue();
        $revenueobject1->addRevenue(array(
          'typeRevenue' => 'actualrev',
          'year' => $year,
          'january' => null,
          'february' => null,
          'march' => null,
          'april' => null,
          'may' => null,
          'june' => null,
          'july' => null,
          'august' => null,
          'september' => null,
          'october' => null,
          'november' => null,
          'december' => null,

          'userID' => $resultresult->userID,
          'corporateID' => $resultresult->corporateID,
          'companyID' => $company,
        ));
        $id = $revenueobject->lastInsertId();

        $data = $revenueobject->searchRevenueestimate($company, $year, "estimatedrev");

        $janestimate = $data->january;
        $febestimate = $data->february;
        $marestimate = $data->march;
        $aprestimate = $data->april;
        $mayestimate = $data->may;
        $junestimate = $data->june;
        $julestimate = $data->july;
        $augestimate = $data->august;
        $sepestimate = $data->september;
        $octestimate = $data->october;
        $novestimate = $data->november;
        $decestimate = $data->december;

        $data2 = $revenueobject->searchRevenueactual($company, $year, "actualrev");

        $janactual = $data2->january;
        $febactual = $data2->february;
        $maractual = $data2->march;
        $apractual = $data2->april;
        $mayactual = $data2->may;
        $junactual = $data2->june;
        $julactual = $data2->july;
        $augactual = $data2->august;
        $sepactual = $data2->september;
        $octactual = $data2->october;
        $novactual = $data2->november;
        $decactual = $data2->december;
      }

      $revenueobject = new Revenue();
      $revenueobj = $revenueobject->searchRevenueEstLog($data->budgetRevenueID);
      $revenueobj2 = $revenueobject->searchRevenueActLog($data2->budgetRevenueID);

      $view .= "
          <tbody>
            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>January</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $janestimate . "' id='estimated1' name='estimated1' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='january' data-month='1' data-prev='" . $janestimate . "'><small><span id='estimatederror1'></span></small></div></td>
              <td style='vertical-align:middle;'><a href ='#janestimated' class='' data-toggle='modal' data-target='#janestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $janactual . "' id='actual1' name='actual1' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='january' data-month='1' data-prev='" . $janactual . "'><small><span id='actualerror1'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#janactual' class='' data-toggle='modal' data-target='#janactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='janestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'>History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>January - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj) {
        foreach ($revenueobj as $row) {
          if ($row->revMonth == "January") {
            $janaction = $row->action;
            $janlog = $row->newValue;
            $prevlog = $row->previousValue;
            $jantime = $row->time;

            $show = "<label>" . $janaction . " on " . $jantime . " : From RM " . $prevlog . " to RM " . $janlog . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "         
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='janactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>    
                        <label><b>January - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2) {
        foreach ($revenueobj2 as $row2) {
          if ($row2->revMonth == "January") {
            $janlog2 = $row2->newValue;
            $janaction2 = $row2->action;
            $jantime2 = $row2->time;
            $prevlog2 = $row2->previousValue;

            $show = "<label>" . $janaction2 . " on " . $jantime2 . " : From RM " . $prevlog2 . " to RM " . $janlog2 . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "         
                        </div>                    
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            </tr>

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>February</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $febestimate . "' id='estimated2' name='estimated2'  data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='february' data-month='2' data-prev='" . $febestimate . "'><small><span id='estimatederror2'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#febestimated' class='' data-toggle='modal' data-target='#febestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $febactual . "' id='actual2' name='actual2' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='february' data-month='2' data-prev='" . $febactual . "'><small><span id='actualerror2'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#febactual' class='' data-toggle='modal' data-target='#febactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='febestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>February - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj) {
        foreach ($revenueobj as $row) {
          if ($row->revMonth == "February") {
            $feblog = $row->newValue;
            $febaction = $row->action;
            $febtime = $row->time;
            $febprevlog = $row->previousValue;

            $show = "<label>" . $febaction . " on " . $febtime . " : From RM " . $febprevlog . " to RM " . $feblog . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='febactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>February - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2) {
        foreach ($revenueobj2 as $row2) {
          if ($row2->revMonth == "February") {
            $feblog2 = $row2->newValue;
            $febaction2 = $row2->action;
            $febtime2 = $row2->time;
            $febprevlog2 = $row2->previousValue;

            $show = "<label>" . $febaction2 . " on " . $febtime2 . " : From RM " . $febprevlog2 . " to RM " . $feblog2 . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "                       
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>    
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>March</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $marestimate . "' id='estimated3' name='estimated3' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='march' data-month='3' data-prev='" . $marestimate . "'><small><span id='estimatederror3'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#marestimated' class='' data-toggle='modal' data-target='#marestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $maractual . "' id='actual3' name='actual3' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='march' data-month='3' data-prev='" . $maractual . "'><small><span id='actualerror3'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#maractual' class='' data-toggle='modal' data-target='#maractual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='marestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>March - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj) {
        foreach ($revenueobj as $row) {
          if ($row->revMonth == "March") {
            $marlog = $row->newValue;
            $maraction = $row->action;
            $martime = $row->time;
            $marprevlog = $row->previousValue;

            $show = "<label>" . $maraction . " on " . $martime . " : From RM " . $marprevlog . " to RM " . $marlog . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "                        
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='maractual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>March - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2) {
        foreach ($revenueobj2 as $row2) {
          if ($row2->revMonth == "March") {
            $marlog2 = $row2->newValue;
            $maraction2 = $row2->action;
            $martime2 = $row2->time;
            $marprevlog2 = $row2->previousValue;

            $show = "<label>" . $maraction2 . " on " . $martime2 . " : From RM " . $marprevlog2 . " to RM " . $marlog2 . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "               
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>April</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $aprestimate . "' id='estimated4' name='estimated4' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='april' data-month='4' data-prev='" . $aprestimate . "'><small><span id='estimatederror4'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#aprestimated' class='' data-toggle='modal' data-target='#aprestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $apractual . "' id='actual4' name='actual4' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='april' data-month='4' data-prev='" . $apractual . "'><small><span id='actualerror4'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#apractual' class='' data-toggle='modal' data-target='#apractual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='aprestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>April - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj) {
        foreach ($revenueobj as $row) {
          if ($row->revMonth == "April") {
            $aprlog = $row->newValue;
            $apraction = $row->action;
            $aprtime = $row->time;
            $aprprevlog = $row->previousValue;

            $show = "<label>" . $apraction . " on " . $aprtime . " : From RM " . $aprprevlog . " to " . $aprlog . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "           
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='apractual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>April - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2) {
        foreach ($revenueobj2 as $row2) {
          if ($row2->revMonth == "April") {
            $aprlog2 = $row2->newValue;
            $apraction2 = $row2->action;
            $aprtime2 = $row2->time;
            $aprprevlog2 = $row2->previousValue;

            $show = "<label>" . $apraction2 . " on " . $aprtime2 . " : From RM " . $aprprevlog2 . " to RM " . $aprlog2 . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>May</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $mayestimate . "' id='estimated5' name='estimated5' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='may' data-month='5' data-prev='" . $mayestimate . "'><small><span id='estimatederror5'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#mayestimated' class='' data-toggle='modal' data-target='#mayestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $mayactual . "' id='actual5' name='actual5' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='may' data-month='5' data-prev='" . $mayactual . "'><small><span id='actualerror5'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#mayactual' class='' data-toggle='modal' data-target='#mayactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='mayestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>May - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj) {
        foreach ($revenueobj as $row) {
          if ($row->revMonth == "May") {
            $maylog = $row->newValue;
            $mayaction = $row->action;
            $maytime = $row->time;
            $mayprevlog = $row->previousValue;

            $show = "<label>" . $mayaction . " on " . $maytime . " : From RM " . $mayprevlog . " to RM " . $maylog . "</label><br>";
            $view .= $show;
          }
        }
      }

      $view .= "                    
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='mayactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>May - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2) {
        foreach ($revenueobj2 as $row2) {
          if ($row2->revMonth == "May") {
            $maylog2 = $row2->newValue;
            $mayaction2 = $row2->action;
            $maytime2 = $row2->time;
            $mayprevlog2=$row2->previousValue;

            $show = "<label>" . $mayaction2 . " on " . $maytime2 . " : From RM " . $mayprevlog2 . " to RM ".$maylog2."</label><br>";
            $view .= $show;
          } 
        }
      }

      $view .= "                              
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>                
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>June</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $junestimate . "' id='estimated6' name='estimated6' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='june' data-month='6' data-prev='" . $junestimate . "'><small><span id='estimatederror6'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#junestimated' class='' data-toggle='modal' data-target='#junestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $junactual . "' id='actual6' name='actual6' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='june' data-month='6' data-prev='" . $junactual . "'><small><span id='actualerror6'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#junactual' class='' data-toggle='modal' data-target='#junactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='junestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>June - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "June") {
            $junlog= $row->newValue;
            $junaction=$row->action;
            $juntime=$row->time;
            $junprevlog=$row->previousValue;

            $show="<label>".$junaction." on ".$juntime." : From RM " .$junprevlog." to RM ".$junlog."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "                
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='junactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>June - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        foreach($revenueobj2 as $row2){
          if ($row2->revMonth == "June") {
            $junlog2= $row2->newValue;
            $junaction2=$row2->action;
            $juntime2=$row2->time;
            $junprevlog2=$row2->previousValue;

            $show="<label>".$junaction2." on ".$juntime2." : From RM " .$junprevlog2." to RM ".$junlog2."</label><br>";       
            $view.= $show;
          }
        }
      }

      $view .= "                      
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>July</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $julestimate . "' id='estimated7' name='estimated7' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='july' data-month='7' data-prev='" . $julestimate . "'><small><span id='estimatederror7'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#julestimated' class='' data-toggle='modal' data-target='#julestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $julactual . "' id='actual7' name='actual7' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='july' data-month='7' data-prev='" . $julactual . "'><small><span id='actualerror7'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#julactual' class='' data-toggle='modal' data-target='#julactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='julestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>July - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "July") {
            $jullog= $row->newValue;
            $julaction=$row->action;
            $jultime=$row->time;
            $julprevlog=$row->previousValue;

            $show="<label>".$julaction." on ".$jultime." : From RM " .$julprevlog." to RM " .$jullog."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "                        
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='julactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>July - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        foreach($revenueobj2 as $row2){
          if ($row2->revMonth == "July") {
            $jullog2= $row2->newValue;
            $julaction2=$row2->action;
            $jultime2=$row2->time;
            $julprevlog2=$row2->previousValue;

            $show="<label>".$julaction2." on ".$jultime2." : From RM " .$julprevlog2." to RM " .$jullog2."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "                         
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>               
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>August</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $augestimate . "' id='estimated8' name='estimated8' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='august' data-month='8' data-prev='" . $augestimate . "'><small><span id='estimatederror8'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#augestimated' class='' data-toggle='modal' data-target='#augestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $augactual . "' id='actual8' name='actual8' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='august' data-month='8' data-prev='" . $augactual . "'><small><span id='actualerror8'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#augactual' class='' data-toggle='modal' data-target='#augactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='augestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>August - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "August") {
            $auglog= $row->newValue;
            $augaction=$row->action;
            $augtime=$row->time;
            $augprevlog=$row->previousValue;

            $show="<label>".$augaction." on ".$augtime." : From RM " .$augprevlog." to RM " .$auglog."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "                      
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='augactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>August - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        foreach($revenueobj2 as $row2){
          if ($row2->revMonth == "August") {
            $auglog2= $row2->newValue;
            $augaction2=$row2->action;
            $augtime2=$row2->time;
            $augprevlog2=$row2->previousValue;

            $show="<label>".$augaction2." on ".$augtime2." : From RM " .$augprevlog2." to RM " .$auglog2."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "
                          
                                      
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>                
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>September</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $sepestimate . "' id='estimated9' name='estimated9' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='september' data-month='9' data-prev='" . $sepestimate . "'><small><span id='estimatederror9'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#sepestimated' class='' data-toggle='modal' data-target='#sepestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $sepactual . "' id='actual9' name='actual9' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='september' data-month='9' data-prev='" . $sepactual . "'><small><span id='actualerror9'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#sepactual' class='' data-toggle='modal' data-target='#sepactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='sepestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>September - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "September") {
            $seplog= $row->newValue;
            $sepaction=$row->action;
            $septime=$row->time;
            $sepprevlog=$row->previousValue;

            $show="<label>".$sepaction." on ".$septime." : From RM " .$sepprevlog." to RM " .$seplog."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "      
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='sepactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>September - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        foreach($revenueobj2 as $row2){
          if ($row2->revMonth == "September") {
            $seplog2= $row2->newValue;
            $sepaction2=$row2->action;
            $septime2=$row2->time;
            $sepprevlog2=$row2->previousValue;

            $show="<label>".$sepaction2." on ".$septime2." : From RM " .$sepprevlog2." to RM " .$seplog2."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "              
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>October</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $octestimate . "' id='estimated10' name='estimated10' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='october' data-month='10' data-prev='" . $octestimate . "'><small><span id='estimatederror10'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#octestimated' class='' data-toggle='modal' data-target='#octestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $octactual . "' id='actual10' name='actual10' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='october' data-month='10' data-prev='" . $octactual . "'><small><span id='actualerror10'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#octactual' class='' data-toggle='modal' data-target='#octactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='octestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>October - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "October") {
            $octlog= $row->newValue;
            $octaction=$row->action;
            $octtime=$row->time;
            $octprevlog=$row->previousValue;

            $show="<label>".$octaction." on ".$octtime." : From RM " .$octprevlog." to RM " .$octlog."</label><br>";
            $view.= $show;

          }
        }
      }

      $view .= "          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='octactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>October - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        foreach($revenueobj2 as $row2){
          if ($row2->revMonth == "October") {
            $octlog2= $row2->newValue;
            $octaction2=$row2->action;
            $octtime2=$row2->time;
            $octprevlog2=$row2->previousValue;

            $show="<label>".$octaction2." on ".$octtime2." : From RM " .$octprevlog2." to RM " .$octlog2."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "              
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>               
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>November</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $novestimate . "' id='estimated11' name='estimated11' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='november' data-month='11' data-prev='" . $novestimate . "'><small><span id='estimatederror11'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#novestimated' class='' data-toggle='modal' data-target='#novestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $novactual . "' id='actual11' name='actual11' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='november' data-month='11' data-prev='" . $novactual . "'><small><span id='actualerror11'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#novactual' class='' data-toggle='modal' data-target='#novactual' ><i class='fas fa-history'></i> </a></td>

              <div class='modal fade' id='novestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>November - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "November") {
            $novlog= $row->newValue;
            $novaction=$row->action;
            $novtime=$row->time;
            $novprevlog=$row->previousValue;

            $show="<label>".$novaction." on ".$novtime." : From RM " .$novprevlog." to RM " .$novlog."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "               
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='novactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>November - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        foreach($revenueobj2 as $row2){
          if ($row2->revMonth == "November") {
            $novlog2= $row2->newValue;
            $novaction2=$row2->action;
            $novtime2=$row2->time;
            $novprevlog2=$row2->previousValue;

            $show="<label>".$novaction2." on ".$novtime2." : From RM " .$novprevlog2." to RM " .$novlog2."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "                   
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>               
            </tr>  

            <tr style='text-align:center;'>
              <td style='vertical-align:middle;'><b>December</b> </td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $decestimate . "' id='estimated12' name='estimated12' data-id='" . $data->budgetRevenueID . "' data-type='estimatedrev' data-column='december' data-month='12' data-prev='" . $decestimate . "'><small><span id='estimatederror12'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#decestimated' class='' data-toggle='modal' data-target='#decestimated' ><i class='fas fa-history'></i> </a></td>
              <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updrev' style='max-width:110px; text-align:center;' type='number' value='" . $decactual . "' id='actual12' name='actual12' data-id='" . $data2->budgetRevenueID . "' data-type='actualrev' data-column='december' data-month='12' data-prev='" . $decactual . "'><small><span id='actualerror12'></span></small></div></td>
              <td style='vertical-align:middle;'> <a href ='#decactual' class='' data-toggle='modal' data-target='#decactual' ><i class='fas fa-history'></i> </a></td>
              <div class='modal fade' id='decestimated'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>December - Projected Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj){
        foreach($revenueobj as $row){
          if ($row->revMonth == "December") {
            $declog= $row->newValue;
            $decaction=$row->action;
            $dectime=$row->time;
            $decprevlog=$row->previousValue;

            $show="<label>".$decaction." on ".$dectime." : From RM " .$decprevlog." to RM " .$declog."</label><br>";
            $view.= $show;
          }
        }
      }

      $view .= "                         
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   

              <div class='modal fade' id='decactual'>
                <div class='modal-dialog modal-lg'>
                  <div class='modal-content' style='padding: 70px'>
                    <div class='modal-header'>
                      <h6 class='modal-title'> History</h6>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body' >
                      <div class='form-group'>
                        <label><b>December - Actual Revenue</b></label><br><br>
                        <div style='height:200px;overflow-y:scroll;'>
      ";

      if ($revenueobj2){
        $prevdec2="";

        foreach($revenueobj2 as $row2){
          $declog2= $row2->newValue;
          $decaction2=$row2->action;
          $dectime2=$row2->time;
          $decprevlog2=$row2->previousValue;

          $show="<label>".$decaction2." on ".$dectime2." : From RM " .$decprevlog2." to RM " .$declog2."</label><br>";
          $view.= $show;

        }
      }

      $view .= "           
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
            </tr>
          </tbody>
        </table>
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
  echo json_encode($view);
}
