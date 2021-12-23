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

if (Input::exists()) {
    $company = escape(Input::get('comp'));
    $year = escape(Input::get('year'));
    $revenueobject = new Revenue();
    $budgetobject = new Budgetinitial();
    if ($resultresult->userID) {
        $data = $revenueobject->searchCostOfGoodSold($company, $year, "costgoodsold");
        $data2 = $budgetobject->searchBudgetCompany($company, $year);
    }
    
    $view = "";

    if ($data2) {
        if ($data) {
            $view .="
                <div class='table-responsive text-nowrap'>
                <table style='text-align:center; width:100%;' class='table'>

                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Cost of Goods Sold (RM)</th>
                            <th>History</th>
                        </tr>
                    </thead>
            ";

            if ($data) {
                $jancost = $data->january;
                $febcost = $data->february;
                $marcost = $data->march;
                $aprcost = $data->april;
                $maycost = $data->may;
                $juncost = $data->june;
                $julcost = $data->july;
                $augcost = $data->august;
                $sepcost = $data->september;
                $octcost = $data->october;
                $novcost = $data->november;
                $deccost = $data->december;
            }

            $revenueobject = new Revenue();
            $revenueobj = $revenueobject->searchCostOfGoodSoldLog($data->budgetRevenueID);

            $view .="
                    <tbody>
                        <tr style='text-align:center;'>
                            <td style='vertical-align:middle;'><b>January</b> </td>
                            <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updcost' style='max-width:110px; text-align:center;' type='number' value='".$jancost."' id='cost1' name='cost1' data-id='".$data->budgetRevenueID."' data-type='costgoodsold' data-column='january' data-month='1' data-prev='".$jancost."'><small><span id='costerror1'></span></small></div></td>
                            <td style='vertical-align:middle;'> <a href ='#jancost' class='' data-toggle='modal' data-target='#jancost' ><i class='fas fa-history'></i> </a></td>

                            <div class='modal fade' id='jancost'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content' style='padding: 70px'>
                                        <div class='modal-header'>
                                            <h6 class='modal-title'>History</h6>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body' >
                                            <div class='form-group'>
                                                <label><b>January - Cost of Goods Sold</b></label><br><br>
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

            $view .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <tr style='text-align:center;'>
                            <td style='vertical-align:middle;'><b>February</b> </td>
                            <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updcost' style='max-width:110px; text-align:center;' type='number' value='".$febcost."' id='cost2' name='cost2' data-id='".$data->budgetRevenueID."' data-type='costgoodsold' data-column='february' data-month='2' data-prev='".$febcost."'><small><span id='costerror2'></span></small></div></td>
                            <td style='vertical-align:middle;'> <a href ='#febcost' class='' data-toggle='modal' data-target='#febcost' ><i class='fas fa-history'></i> </a></td>

                            <div class='modal fade' id='febcost'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content' style='padding: 70px'>
                                        <div class='modal-header'>
                                            <h6 class='modal-title'>History</h6>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body' >
                                            <div class='form-group'>
                                                <label><b>February - Cost of Goods Sold</b></label><br><br>
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

            $view .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <tr style='text-align:center;'>
                            <td style='vertical-align:middle;'><b>March</b> </td>
                            <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updcost' style='max-width:110px; text-align:center;' type='number' value='".$marcost."' id='cost3' name='cost3' data-id='".$data->budgetRevenueID."' data-type='costgoodsold' data-column='march' data-month='3' data-prev='".$marcost."'><small><span id='costerror3'></span></small></div></td>
                            <td style='vertical-align:middle;'> <a href ='#marcost' class='' data-toggle='modal' data-target='#marcost' ><i class='fas fa-history'></i> </a></td>

                            <div class='modal fade' id='marcost'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content' style='padding: 70px'>
                                        <div class='modal-header'>
                                            <h6 class='modal-title'>History</h6>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body' >
                                            <div class='form-group'>
                                                <label><b>March - Cost of Goods Sold</b></label><br><br>
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

            $view .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <tr style='text-align:center;'>
                            <td style='vertical-align:middle;'><b>April</b> </td>
                            <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updcost' style='max-width:110px; text-align:center;' type='number' value='".$aprcost."' id='cost4' name='cost4' data-id='".$data->budgetRevenueID."' data-type='costgoodsold' data-column='april' data-month='4' data-prev='".$aprcost."'><small><span id='costerror4'></span></small></div></td>
                            <td style='vertical-align:middle;'> <a href ='#aprcost' class='' data-toggle='modal' data-target='#aprcost' ><i class='fas fa-history'></i> </a></td>

                            <div class='modal fade' id='aprcost'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content' style='padding: 70px'>
                                        <div class='modal-header'>
                                            <h6 class='modal-title'>History</h6>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body' >
                                            <div class='form-group'>
                                                <label><b>April - Cost of Goods Sold</b></label><br><br>
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

            $view .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <tr style='text-align:center;'>
                            <td style='vertical-align:middle;'><b>May</b> </td>
                            <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updcost' style='max-width:110px; text-align:center;' type='number' value='".$maycost."' id='cost5' name='cost5' data-id='".$data->budgetRevenueID."' data-type='costgoodsold' data-column='may' data-month='5' data-prev='".$maycost."'><small><span id='costerror5'></span></small></div></td>
                            <td style='vertical-align:middle;'> <a href ='#maycost' class='' data-toggle='modal' data-target='#maycost' ><i class='fas fa-history'></i> </a></td>

                            <div class='modal fade' id='maycost'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content' style='padding: 70px'>
                                        <div class='modal-header'>
                                            <h6 class='modal-title'>History</h6>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body' >
                                            <div class='form-group'>
                                                <label><b>May - Cost of Goods Sold</b></label><br><br>
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

            $view .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <tr style='text-align:center;'>
                            <td style='vertical-align:middle;'><b>Jun</b> </td>
                            <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updcost' style='max-width:110px; text-align:center;' type='number' value='".$juncost."' id='cost6' name='cost6' data-id='".$data->budgetRevenueID."' data-type='costgoodsold' data-column='june' data-month='6' data-prev='".$juncost."'><small><span id='costerror6'></span></small></div></td>
                            <td style='vertical-align:middle;'> <a href ='#juncost' class='' data-toggle='modal' data-target='#juncost' ><i class='fas fa-history'></i> </a></td>

                            <div class='modal fade' id='juncost'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content' style='padding: 70px'>
                                        <div class='modal-header'>
                                            <h6 class='modal-title'>History</h6>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body' >
                                            <div class='form-group'>
                                                <label><b>June - Cost of Goods Sold</b></label><br><br>
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

            $view .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <tr style='text-align:center;'>
                            <td style='vertical-align:middle;'><b>July</b> </td>
                            <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updcost' style='max-width:110px; text-align:center;' type='number' value='".$julcost."' id='cost7' name='cost7' data-id='".$data->budgetRevenueID."' data-type='costgoodsold' data-column='july' data-month='7' data-prev='".$julcost."'><small><span id='costerror7'></span></small></div></td>
                            <td style='vertical-align:middle;'> <a href ='#julycost' class='' data-toggle='modal' data-target='#julycost' ><i class='fas fa-history'></i> </a></td>

                            <div class='modal fade' id='julycost'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content' style='padding: 70px'>
                                        <div class='modal-header'>
                                            <h6 class='modal-title'>History</h6>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body' >
                                            <div class='form-group'>
                                                <label><b>July - Cost of Goods Sold</b></label><br><br>
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

            $view .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <tr style='text-align:center;'>
                            <td style='vertical-align:middle;'><b>August</b> </td>
                            <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updcost' style='max-width:110px; text-align:center;' type='number' value='".$augcost."' id='cost8' name='cost8' data-id='".$data->budgetRevenueID."' data-type='costgoodsold' data-column='august' data-month='8' data-prev='".$augcost."'><small><span id='costerror8'></span></small></div></td>
                            <td style='vertical-align:middle;'> <a href ='#augcost' class='' data-toggle='modal' data-target='#augcost' ><i class='fas fa-history'></i> </a></td>

                            <div class='modal fade' id='augcost'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content' style='padding: 70px'>
                                        <div class='modal-header'>
                                            <h6 class='modal-title'>History</h6>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body' >
                                            <div class='form-group'>
                                                <label><b>August - Cost of Goods Sold</b></label><br><br>
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

            $view .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <tr style='text-align:center;'>
                            <td style='vertical-align:middle;'><b>September</b> </td>
                            <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updcost' style='max-width:110px; text-align:center;' type='number' value='".$sepcost."' id='cost9' name='cost9' data-id='".$data->budgetRevenueID."' data-type='costgoodsold' data-column='september' data-month='9' data-prev='".$sepcost."'><small><span id='costerror9'></span></small></div></td>
                            <td style='vertical-align:middle;'> <a href ='#septcost' class='' data-toggle='modal' data-target='#septcost' ><i class='fas fa-history'></i> </a></td>

                            <div class='modal fade' id='septcost'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content' style='padding: 70px'>
                                        <div class='modal-header'>
                                            <h6 class='modal-title'>History</h6>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body' >
                                            <div class='form-group'>
                                                <label><b>September - Cost of Goods Sold</b></label><br><br>
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

            $view .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <tr style='text-align:center;'>
                            <td style='vertical-align:middle;'><b>October</b> </td>
                            <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updcost' style='max-width:110px; text-align:center;' type='number' value='".$octcost."' id='cost10' name='cost10' data-id='".$data->budgetRevenueID."' data-type='costgoodsold' data-column='october' data-month='10' data-prev='".$octcost."'><small><span id='costerror10'></span></small></div></td>
                            <td style='vertical-align:middle;'> <a href ='#octcost' class='' data-toggle='modal' data-target='#octcost' ><i class='fas fa-history'></i> </a></td>

                            <div class='modal fade' id='octcost'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content' style='padding: 70px'>
                                        <div class='modal-header'>
                                            <h6 class='modal-title'>History</h6>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body' >
                                            <div class='form-group'>
                                                <label><b>October - Cost of Goods Sold</b></label><br><br>
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

            $view .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <tr style='text-align:center;'>
                            <td style='vertical-align:middle;'><b>November</b> </td>
                            <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updcost' style='max-width:110px; text-align:center;' type='number' value='".$novcost."' id='cost11' name='cost11' data-id='".$data->budgetRevenueID."' data-type='costgoodsold' data-column='november' data-month='11' data-prev='".$novcost."'><small><span id='costerror11'></span></small></div></td>
                            <td style='vertical-align:middle;'> <a href ='#novcost' class='' data-toggle='modal' data-target='#novcost' ><i class='fas fa-history'></i> </a></td>

                            <div class='modal fade' id='novcost'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content' style='padding: 70px'>
                                        <div class='modal-header'>
                                            <h6 class='modal-title'>History</h6>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body' >
                                            <div class='form-group'>
                                                <label><b>November - Cost of Goods Sold</b></label><br><br>
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

            $view .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <tr style='text-align:center;'>
                            <td style='vertical-align:middle;'><b>December</b> </td>
                            <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updcost' style='max-width:110px; text-align:center;' type='number' value='".$deccost."' id='cost12' name='cost12' data-id='".$data->budgetRevenueID."' data-type='costgoodsold' data-column='december' data-month='12' data-prev='".$deccost."'><small><span id='costerror12'></span></small></div></td>
                            <td style='vertical-align:middle;'> <a href ='#deccost' class='' data-toggle='modal' data-target='#deccost' ><i class='fas fa-history'></i> </a></td>

                            <div class='modal fade' id='deccost'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content' style='padding: 70px'>
                                        <div class='modal-header'>
                                            <h6 class='modal-title'>History</h6>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body' >
                                            <div class='form-group'>
                                                <label><b> December - Cost of Goods Sold</b></label><br><br>
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

            $view .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                    </tbody>
                </div> 
            ";

        }
        elseif ($data == null) {
            $view .="
                <div class='table-responsive text-nowrap'>
                <table style='text-align:center; width:100%;' class='table'>

                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Cost of Goods Sold (RM)</th>
                            <th>History</th>
                        </tr>
                    </thead>
            ";

            if ($data == null) {
                $revenueobject = new Revenue();
                $revenueobject->addRevenue(array(
                    'typeRevenue' => 'costgoodsold',
                    'year' => $year,
                    'january' => '0',
                    'february' => '0',
                    'march' => '0',
                    'april' => '0',
                    'may' => '0',
                    'june' => '0',
                    'july' => '0',
                    'august' => '0',
                    'september' => '0',
                    'october' => '0',
                    'november' => '0',
                    'december' => '0',

                    'userID' => $resultresult->userID,
                    'corporateID' => $resultresult->corporateID,
                    'companyID' => $company,
                ));
                $id = $revenueobject->lastInsertId();

                $data = $revenueobject->searchCostOfGoodSold($company, $year, "costgoodsold");

                $jancost = $data->january;
                $febcost = $data->february;
                $marcost = $data->march;
                $aprcost = $data->april;
                $maycost = $data->may;
                $juncost = $data->june;
                $julcost = $data->july;
                $augcost = $data->august;
                $sepcost = $data->september;
                $octcost = $data->october;
                $novcost = $data->november;
                $deccost = $data->december;
            }

            $revenueobject = new Revenue();
            $revenueobj = $revenueobject->searchCostOfGoodSoldLog($data->budgetRevenueID);

            $view .="
                    <tbody>
                        <tr style='text-align:center;'>
                            <td style='vertical-align:middle;'><b>January</b> </td>
                            <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updcost' style='max-width:110px; text-align:center;' type='number' value='".$jancost."' id='cost1' name='cost1' data-id='".$data->budgetRevenueID."' data-type='costgoodsold' data-column='january' data-month='1' data-prev='".$jancost."'><small><span id='costerror1'></span></small></div></td>
                            <td style='vertical-align:middle;'> <a href ='#jancost' class='' data-toggle='modal' data-target='#jancost' ><i class='fas fa-history'></i> </a></td>

                            <div class='modal fade' id='jancost'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content' style='padding: 70px'>
                                        <div class='modal-header'>
                                            <h6 class='modal-title'>History</h6>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body' >
                                            <div class='form-group'>
                                                <label><b>January - Cost of Goods Sold</b></label><br><br>
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

            $view .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <tr style='text-align:center;'>
                            <td style='vertical-align:middle;'><b>February</b> </td>
                            <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updcost' style='max-width:110px; text-align:center;' type='number' value='".$febcost."' id='cost2' name='cost2' data-id='".$data->budgetRevenueID."' data-type='costgoodsold' data-column='february' data-month='2' data-prev='".$febcost."'><small><span id='costerror2'></span></small></div></td>
                            <td style='vertical-align:middle;'> <a href ='#febcost' class='' data-toggle='modal' data-target='#febcost' ><i class='fas fa-history'></i> </a></td>

                            <div class='modal fade' id='febcost'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content' style='padding: 70px'>
                                        <div class='modal-header'>
                                            <h6 class='modal-title'>History</h6>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body' >
                                            <div class='form-group'>
                                                <label><b>February - Cost of Goods Sold</b></label><br><br>
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

            $view .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <tr style='text-align:center;'>
                            <td style='vertical-align:middle;'><b>March</b> </td>
                            <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updcost' style='max-width:110px; text-align:center;' type='number' value='".$marcost."' id='cost3' name='cost3' data-id='".$data->budgetRevenueID."' data-type='costgoodsold' data-column='march' data-month='3' data-prev='".$marcost."'><small><span id='costerror3'></span></small></div></td>
                            <td style='vertical-align:middle;'> <a href ='#marcost' class='' data-toggle='modal' data-target='#marcost' ><i class='fas fa-history'></i> </a></td>

                            <div class='modal fade' id='marcost'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content' style='padding: 70px'>
                                        <div class='modal-header'>
                                            <h6 class='modal-title'>History</h6>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body' >
                                            <div class='form-group'>
                                                <label><b>March - Cost of Goods Sold</b></label><br><br>
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

            $view .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <tr style='text-align:center;'>
                            <td style='vertical-align:middle;'><b>April</b> </td>
                            <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updcost' style='max-width:110px; text-align:center;' type='number' value='".$aprcost."' id='cost4' name='cost4' data-id='".$data->budgetRevenueID."' data-type='costgoodsold' data-column='april' data-month='4' data-prev='".$aprcost."'><small><span id='costerror4'></span></small></div></td>
                            <td style='vertical-align:middle;'> <a href ='#aprcost' class='' data-toggle='modal' data-target='#aprcost' ><i class='fas fa-history'></i> </a></td>

                            <div class='modal fade' id='aprcost'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content' style='padding: 70px'>
                                        <div class='modal-header'>
                                            <h6 class='modal-title'>History</h6>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body' >
                                            <div class='form-group'>
                                                <label><b>April - Cost of Goods Sold</b></label><br><br>
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

            $view .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <tr style='text-align:center;'>
                            <td style='vertical-align:middle;'><b>May</b> </td>
                            <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updcost' style='max-width:110px; text-align:center;' type='number' value='".$maycost."' id='cost5' name='cost5' data-id='".$data->budgetRevenueID."' data-type='costgoodsold' data-column='may' data-month='5' data-prev='".$maycost."'><small><span id='costerror5'></span></small></div></td>
                            <td style='vertical-align:middle;'> <a href ='#maycost' class='' data-toggle='modal' data-target='#maycost' ><i class='fas fa-history'></i> </a></td>

                            <div class='modal fade' id='maycost'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content' style='padding: 70px'>
                                        <div class='modal-header'>
                                            <h6 class='modal-title'>History</h6>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body' >
                                            <div class='form-group'>
                                                <label><b>May - Cost of Goods Sold</b></label><br><br>
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

            $view .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <tr style='text-align:center;'>
                            <td style='vertical-align:middle;'><b>Jun</b> </td>
                            <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updcost' style='max-width:110px; text-align:center;' type='number' value='".$juncost."' id='cost6' name='cost6' data-id='".$data->budgetRevenueID."' data-type='costgoodsold' data-column='june' data-month='6' data-prev='".$juncost."'><small><span id='costerror6'></span></small></div></td>
                            <td style='vertical-align:middle;'> <a href ='#juncost' class='' data-toggle='modal' data-target='#juncost' ><i class='fas fa-history'></i> </a></td>

                            <div class='modal fade' id='juncost'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content' style='padding: 70px'>
                                        <div class='modal-header'>
                                            <h6 class='modal-title'>History</h6>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body' >
                                            <div class='form-group'>
                                                <label><b>June - Cost of Goods Sold</b></label><br><br>
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

            $view .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <tr style='text-align:center;'>
                            <td style='vertical-align:middle;'><b>July</b> </td>
                            <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updcost' style='max-width:110px; text-align:center;' type='number' value='".$julcost."' id='cost7' name='cost7' data-id='".$data->budgetRevenueID."' data-type='costgoodsold' data-column='july' data-month='7' data-prev='".$julcost."'><small><span id='costerror7'></span></small></div></td>
                            <td style='vertical-align:middle;'> <a href ='#julycost' class='' data-toggle='modal' data-target='#julycost' ><i class='fas fa-history'></i> </a></td>

                            <div class='modal fade' id='julycost'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content' style='padding: 70px'>
                                        <div class='modal-header'>
                                            <h6 class='modal-title'>History</h6>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body' >
                                            <div class='form-group'>
                                                <label><b>July - Cost of Goods Sold</b></label><br><br>
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

            $view .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <tr style='text-align:center;'>
                            <td style='vertical-align:middle;'><b>August</b> </td>
                            <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updcost' style='max-width:110px; text-align:center;' type='number' value='".$augcost."' id='cost8' name='cost8' data-id='".$data->budgetRevenueID."' data-type='costgoodsold' data-column='august' data-month='8' data-prev='".$augcost."'><small><span id='costerror8'></span></small></div></td>
                            <td style='vertical-align:middle;'> <a href ='#augcost' class='' data-toggle='modal' data-target='#augcost' ><i class='fas fa-history'></i> </a></td>

                            <div class='modal fade' id='augcost'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content' style='padding: 70px'>
                                        <div class='modal-header'>
                                            <h6 class='modal-title'>History</h6>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body' >
                                            <div class='form-group'>
                                                <label><b>August - Cost of Goods Sold</b></label><br><br>
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

            $view .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <tr style='text-align:center;'>
                            <td style='vertical-align:middle;'><b>September</b> </td>
                            <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updcost' style='max-width:110px; text-align:center;' type='number' value='".$sepcost."' id='cost9' name='cost9' data-id='".$data->budgetRevenueID."' data-type='costgoodsold' data-column='september' data-month='9' data-prev='".$sepcost."'><small><span id='costerror9'></span></small></div></td>
                            <td style='vertical-align:middle;'> <a href ='#septcost' class='' data-toggle='modal' data-target='#septcost' ><i class='fas fa-history'></i> </a></td>

                            <div class='modal fade' id='septcost'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content' style='padding: 70px'>
                                        <div class='modal-header'>
                                            <h6 class='modal-title'>History</h6>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body' >
                                            <div class='form-group'>
                                                <label><b>September - Cost of Goods Sold</b></label><br><br>
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

            $view .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <tr style='text-align:center;'>
                            <td style='vertical-align:middle;'><b>October</b> </td>
                            <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updcost' style='max-width:110px; text-align:center;' type='number' value='".$octcost."' id='cost10' name='cost10' data-id='".$data->budgetRevenueID."' data-type='costgoodsold' data-column='october' data-month='10' data-prev='".$octcost."'><small><span id='costerror10'></span></small></div></td>
                            <td style='vertical-align:middle;'> <a href ='#octcost' class='' data-toggle='modal' data-target='#octcost' ><i class='fas fa-history'></i> </a></td>

                            <div class='modal fade' id='octcost'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content' style='padding: 70px'>
                                        <div class='modal-header'>
                                            <h6 class='modal-title'>History</h6>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body' >
                                            <div class='form-group'>
                                                <label><b>October - Cost of Goods Sold</b></label><br><br>
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

            $view .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <tr style='text-align:center;'>
                            <td style='vertical-align:middle;'><b>November</b> </td>
                            <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updcost' style='max-width:110px; text-align:center;' type='number' value='".$novcost."' id='cost11' name='cost11' data-id='".$data->budgetRevenueID."' data-type='costgoodsold' data-column='november' data-month='11' data-prev='".$novcost."'><small><span id='costerror11'></span></small></div></td>
                            <td style='vertical-align:middle;'> <a href ='#novcost' class='' data-toggle='modal' data-target='#novcost' ><i class='fas fa-history'></i> </a></td>

                            <div class='modal fade' id='novcost'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content' style='padding: 70px'>
                                        <div class='modal-header'>
                                            <h6 class='modal-title'>History</h6>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body' >
                                            <div class='form-group'>
                                                <label><b>November - Cost of Goods Sold</b></label><br><br>
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

            $view .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <tr style='text-align:center;'>
                            <td style='vertical-align:middle;'><b>December</b> </td>
                            <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control updcost' style='max-width:110px; text-align:center;' type='number' value='".$deccost."' id='cost12' name='cost12' data-id='".$data->budgetRevenueID."' data-type='costgoodsold' data-column='december' data-month='12' data-prev='".$deccost."'><small><span id='costerror12'></span></small></div></td>
                            <td style='vertical-align:middle;'> <a href ='#deccost' class='' data-toggle='modal' data-target='#deccost' ><i class='fas fa-history'></i> </a></td>

                            <div class='modal fade' id='deccost'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content' style='padding: 70px'>
                                        <div class='modal-header'>
                                            <h6 class='modal-title'>History</h6>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body' >
                                            <div class='form-group'>
                                                <label><b> December - Cost of Goods Sold</b></label><br><br>
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

            $view .="
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                    </tbody>
                </div> 
            ";
        }
    }
    else{
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