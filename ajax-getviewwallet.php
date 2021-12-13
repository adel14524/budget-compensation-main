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
    $company_id = escape(Input::get('companyID'));
	$dept_id = escape(Input::get('department'));

	$Walletsetupobject = new Walletsetup();
	
//	if($resultresult->company_id && $resultresult->dept_id ){
  	$data1 = $Walletsetupobject->searchwallet($company_id ,$dept_id);
	print_r($company_id);
	print($dept_id);
 	

$view = 
" 
";
if($data1){
	  foreach ($data1 as $row) {
		
		  $view .= 
		"
		<div class='table-responsive text-nowrap'>
	<table style='width:65%;' class='table table-bordered'>
		<thead-dark>
		
		<tr style='text-align: center;'>
		
		<th class='th-sm' style='width: 5%;'>Wallet</th>
		<th class='th-sm' style='width:5%; text-align: center'>Weightage</th>
			<th class='th-sm' style='width:20%; text-align: center'>Description</th>
		<th class='th-sm' style='width:5% ;'>Action</th>';
		
		<tbody>
		<tr style='text-align: center;'>
			
			<th><input type='text' name='wallet' class='form-control' style='text-align: center;' class='form-control' value='".$row->wallet."'></th>	
			<th width=''><input type='text' name='weightage' style='text-align: center;'  class='form-control' value='".$row->weightage."'></th>	
			<th width=''><input type='textarea' name='description' style='text-align: center;'  class='form-control' value='". $row->wallt_type."'></th>
			<th width=''><input type='submit' name='delete' style='text-align: center;'  class='btn btn-danger' value='Delete'></th>	
				
		</tr>		
		</tbody>
		</table></div>
		";	}
}

else{
	$view .= 
	"
<li class='list-group-item'>
	    No data 
	</li>
	";
}}
$view .= 
"
</ul>
";

echo $view;
?>
