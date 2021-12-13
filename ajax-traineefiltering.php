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
    Redirect::to("login.php");
  }
}
if(Input::exists()){
	$startdate = escape(Input::get('startdate'));
	$enddate = escape(Input::get('enddate'));

	if($startdate != "Invalid date"){
		$startdate = $startdate;
	}else{
		$startdate = date("Y-m-d");
	}

	if($enddate != "Invalid date"){
		$enddate = $enddate;
	}else{
		$enddate = date("Y-m-d");
	}

	$output = "";
	$ppp121reportobject = new Ppp121report();
	$order = "odd";
	$pppreportresult = $ppp121reportobject->searchPPPreportlist($resultresult->userID, $startdate, $enddate);
	if($pppreportresult){
		foreach ($pppreportresult as $row) {
			$userobject = new User();
			$userresult = $userobject->searchOnly($row->supervisorID);
			if($userresult){
	            if($userresult->profilepic){
	                $pic = "data:image/jpeg;base64,".base64_encode($userresult->profilepic);
	            }else{
	              $pic = "img/userprofile.png";
	            }
	        }
	        if($row->status === "Submitted"){
				$button = "
				<button type='button' class='btn btn-sm btn-white viewPPP' data-id='".$row->pppID."' data-toggle='modal' data-target='#employeeviewPPP'><i class='fas fa-search'></i></button>
				";
			}elseif($row->status === "Evaluated"){
				$button = "
				<button type='button' class='btn btn-sm btn-white viewPPP' data-id='".$row->pppID."' data-toggle='modal' data-target='#employeeviewPPPfull'><i class='fas fa-search'></i></button>
				";
			}
			$output .= "
			<tr role='row' class='".$order."'>
              <td class='sorting_1'><img src='".$pic."' class='rounded-circle' width='30' height='30' style='object-fit: cover;'></img> ".$userresult->firstname." ".$userresult->lastname."</td>
              <td>PPP</td>
              <td>".$row->submitat."</td>
              <td>".$row->timeframe."</td>
              <td>".$row->status."</td>
              <td>".$button."</td>
            </tr>";
            if($order == "even"){
            	$order = "odd";
            }else{
            	$order = "even";
            }
            
		}
	}else{
		$output .= "";
	}
	$otoreportresult = $ppp121reportobject->search121reportlist($resultresult->userID, $startdate, $enddate);
	if($otoreportresult){
		foreach ($otoreportresult as $row) {
			$userobject = new User();
			$userresult = $userobject->searchOnly($row->supervisorID);
			if($userresult){
	            if($userresult->profilepic){
	                $pic = "data:image/jpeg;base64,".base64_encode($userresult->profilepic);
	            }else{
	              $pic = "img/userprofile.png";
	            }
	        }
	        if($row->status === "Submitted"){
				$button = "
				<button type='button' class='btn btn-sm btn-white view121' data-id='".$row->onetooneID."' data-toggle='modal' data-target='#employeeview121'><i class='fas fa-search'></i></button>
				";
			}elseif($row->status === "Approved"){
				$button = "
				<button type='button' class='btn btn-sm btn-white view121' data-id='".$row->onetooneID."' data-toggle='modal' data-target='#employeeview121approve'><i class='fas fa-search'></i></button>
				";
			}elseif($row->status === "Rejected"){
				$button = "
				<button type='button' class='btn btn-sm btn-white view121' data-id='".$row->onetooneID."' data-toggle='modal' data-target='#employeeview121'><i class='fas fa-search'></i></button>
				";
			}elseif($row->status === "Done"){
				$button = "
				<button type='button' class='btn btn-sm btn-white view121' data-id='".$row->onetooneID."' data-toggle='modal' data-target='#employeeview121done'><i class='fas fa-search'></i></button>
				";
			}elseif($row->status === "Commented"){
				$button = "
				<button type='button' class='btn btn-sm btn-white view121' data-id='".$row->onetooneID."' data-toggle='modal' data-target='#employeeview121commented'><i class='fas fa-search'></i></button>
				";
			}
			$output .= "
			<tr role='row' class='".$order."'>
              <td><img src='".$pic."' class='rounded-circle' width='30' height='30' style='object-fit: cover;'></img> ".$userresult->firstname." ".$userresult->lastname."</td>
              <td>1 to 1</td>
              <td>".$row->submitat."</td>
              <td>".$row->timeframe."</td>
              <td>".$row->status."</td>
              <td>".$button."</td>
            </tr>";
            if($order == "even"){
            	$order = "odd";
            }else{
            	$order = "even";
            }
		}
	}else{
		$output .= "";
	}

	$array = [
		"startdate" => $startdate,
		"enddate" => $enddate,
		"output" => $output
		
	];
	echo json_encode($array);
}
?>