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

$view = "";
$view .=
"
<table style='text-align:center; width:100%;' class='table'>

    <thead>
        <tr>
            <th>Month</th>
            <th>Cost of Goods Sold (RM)</th>
            <th>History</th>
        </tr>
    </thead>
";

$view .=
"
<script src='extensions/editable/bootstrap-table-editable.js'></script>
<tbody>
    <tr style='text-align:center;'>
        <td style='vertical-align:middle;'><b>January</b> </td>
        <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='5000' id='addcostjan' name='addcostjan'><small><span id='costerror'></span></small></div></td>
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
                            <label><b>Cost of Goods Sold</b></label><br>

                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </tr>
    <tr style='text-align:center;'>
        <td style='vertical-align:middle;'><b>February</b> </td>
        <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='4000' id='addcostfeb' name='addcostfeb'><small><span id='costerror'></span></small></div></td>
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
                            <label><b>Cost of Goods Sold</b></label><br>

                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </tr>
    <tr style='text-align:center;'>
        <td style='vertical-align:middle;'><b>March</b> </td>
        <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='2000' id='addcostmar' name='addcostmar'><small><span id='costerror'></span></small></div></td>
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
                            <label><b>Cost of Goods Sold</b></label><br>

                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </tr>
    <tr style='text-align:center;'>
        <td style='vertical-align:middle;'><b>April</b> </td>
        <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='1500' id='addcostapr' name='addcostapr'><small><span id='costerror'></span></small></div></td>
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
                            <label><b>Cost of Goods Sold</b></label><br>

                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </tr>
    <tr style='text-align:center;'>
        <td style='vertical-align:middle;'><b>May</b> </td>
        <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='200' id='addcostmay' name='addcostmay'><small><span id='costerror'></span></small></div></td>
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
                            <label><b>Cost of Goods Sold</b></label><br>

                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </tr>
    <tr style='text-align:center;'>
        <td style='vertical-align:middle;'><b>Jun</b> </td>
        <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='600' id='addcostjun' name='addcostjun'><small><span id='costerror'></span></small></div></td>
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
                            <label><b>Cost of Goods Sold</b></label><br>

                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </tr>
    <tr style='text-align:center;'>
        <td style='vertical-align:middle;'><b>July</b> </td>
        <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='1000' id='addcostjuly' name='addcostjuly'><small><span id='costerror'></span></small></div></td>
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
                            <label><b>Cost of Goods Sold</b></label><br>

                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </tr>
    <tr style='text-align:center;'>
        <td style='vertical-align:middle;'><b>August</b> </td>
        <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='700' id='addcostaug' name='addcostaug'><small><span id='costerror'></span></small></div></td>
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
                            <label><b>Cost of Goods Sold</b></label><br>

                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </tr>
    <tr style='text-align:center;'>
        <td style='vertical-align:middle;'><b>September</b> </td>
        <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='3000' id='addcostsept' name='addcostsept'><small><span id='costerror'></span></small></div></td>
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
                            <label><b>Cost of Goods Sold</b></label><br>

                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </tr>
    <tr style='text-align:center;'>
        <td style='vertical-align:middle;'><b>October</b> </td>
        <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='1200' id='addcostoct' name='addcostoct'><small><span id='costerror'></span></small></div></td>
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
                            <label><b>Cost of Goods Sold</b></label><br>

                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </tr>
    <tr style='text-align:center;'>
        <td style='vertical-align:middle;'><b>November</b> </td>
        <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='800' id='addcostnov' name='addcostnov'><small><span id='costerror'></span></small></div></td>
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
                            <label><b>Cost of Goods Sold</b></label><br>

                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </tr>
    <tr style='text-align:center;'>
        <td style='vertical-align:middle;'><b>December</b> </td>
        <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='4500' id='addcostdec' name='addcostdec'><small><span id='costerror'></span></small></div></td>
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
                            <label><b>Cost of Goods Sold</b></label><br>

                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </tr>
    </form>
</tbody>
";

echo json_encode($view);