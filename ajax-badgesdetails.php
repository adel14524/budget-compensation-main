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
  $userID = escape(Input::get('userID')); 

  $userbadgeobject = new Badgeuser();
  $badge=$userbadgeobject->searchBadgeUser($userID);
    $view="";
    $view.="<div class='modal-header'>
      <h6 class='modal-title'>My Badges</h6>
      <button type='button' class='close' data-dismiss='modal'>&times;</button>
      </div>";
    
      $totalb=0;
      $totals=0;
      $totalg=0;
      if($badge){
        foreach($badge as $row){
          $badgenew=$row->badgeID;
          $badgecheck= new Badge();
          $badgecheckresult=$badgecheck->searchbadgeid($badgenew);
          if($badgecheckresult){ 
           
            foreach($badgecheckresult as $row1){ 
              if($row1->badgeName=="bronze"){ 
              $quantity=$row1->badgeQuantity; 
              $totalb= $totalb+$quantity;
              }
              elseif($row1->badgeName=="silver"){ 
              $quantity=$row1->badgeQuantity; 
              $totals= $totals+$quantity;
              }
              elseif($row1->badgeName=="gold"){ 
              $quantity=$row1->badgeQuantity; 
              $totalg= $totalg+$quantity;
              }
            }       
          } 
        }
          $view.="
          <center>
          <br>
          <table>
          <tr>
          <div class='row'>
          <div class='col-2 col-xl-4'>
          Silver <i class='fas fa-award' style='font-size:24px; vertical-align: sub; color:silver;'></i>&nbsp <h4 class='text-primary'>".$totals."</h4>
          </div>
          <div class='col-2 col-xl-4'>
          Bronze <i class='fas fa-award' style='font-size:24px; vertical-align: sub; color:#966F33;'></i>&nbsp<h4 class='text-primary'>".$totalb."</h4></div>
          <div class='col-2 col-xl-4' style='float:right'>
          Gold <i class='fas fa-award' style='font-size:24px; vertical-align: sub; color:#cd7f32;'></i>&nbsp<h4 class='text-primary'>".$totalg."</h4>
          </div>   
          </div>   
          </tr> 
          </table>
          </center>
        ";
        
      }
      else{
          $view.="
          <center>
          <br>
          <table>
          <tr>
          <div class='row'>
          <div class='col-2 col-xl-4'>
          Silver <i class='fas fa-award' style='font-size:24px; vertical-align: sub; color:silver;'></i>&nbsp <h4 class='text-primary'>".$totals."</h4>
          </div>
          <div class='col-2 col-xl-4'>
          Bronze <i class='fas fa-award' style='font-size:24px; vertical-align: sub; color:#966F33;'></i>&nbsp<h4 class='text-primary'>".$totalb."</h4></div>
          <div class='col-2 col-xl-4' style='float:right'>
          Gold <i class='fas fa-award' style='font-size:24px; vertical-align: sub; color:#cd7f32;'></i>&nbsp<h4 class='text-primary'>".$totalg."</h4>
          </div>   
          </div>   
          </tr> 
          </table>
          </center>
        ";

      }
     
     
    
 echo $view;
}
?>


