<?php
require_once 'core/init.php';
if(Input::exists()){
  $companyID = escape(Input::get('companyID'));

  $userobject = new User();
  $data = $userobject->searchUserByCompany($companyID);

  $view = "";
if ($data) {
foreach ($data as $row) {
  $view .= "<option value=".$row->userID.">".$row->firstname." ".$row->lastname."</option>";
}
}
 
  echo json_encode($view);
}
?>