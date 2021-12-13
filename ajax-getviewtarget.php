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
  $compensationID = escape(Input::get('compensationID'));

  $target = new Target();
  $data = $target->searchTarget($compensationID);
// print_r($data);
$view='';

    $targetid =array();
if($data){
  foreach ($data as $row) {

    array_push($targetid,$row->targetID);

    $user = new User();
    $data2 = $user->searchOnly($row->measure);

    $fname = $data2->firstname;
    $lname = $data2->lastname;
    
      $view.='

      <div class="form-group">
        <label><h6 class="m-0">Name :</h6></label>
        <input class="form-control" type="text" id="targetname" name="targetname[]" value="'.$fname.' '.$lname.'">
      </div>

      <div class="form-group">
        <label><h6 class="m-0">Actual </h6></label>
        <input class="form-control" type="text" id="actualvalue2" name="actualvalue2[]" >
        <small><span id="actual1error"></span></small>
      </div>

        <input type="hidden" class="form-control" name="updtargetid1[]" id="updtargetid1" value="'.$row->targetID.'">
        <input type="hidden" class="form-control" name="measureid[]" id="measureid" value="'.$row->measure.'">

      ';  
  }
  
  $view.='
 
  <button name="submit" value="submit" type="submit" id="saveactual" class="btn btn-primary shadow-sm">Save</button>
  <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancelactual">Cancel</button>


  ';
}

 echo $view;
}
?>
