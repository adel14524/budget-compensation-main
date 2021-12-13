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

  $company = escape(Input::get('comp')); 
  $year = escape(Input::get('year')); 
  $revenueobject = new Revenue();
  if($resultresult->userID){

    $data = $revenueobject->searchRevenueestimate($company,$year,"estimatedrev");
    $data2 = $revenueobject->searchRevenueactual($company,$year,"actualrev");
  }
  $view = "";

  if($data && $data2){
 
        $view .= 
        "
       <div class='table-responsive text-nowrap'>
       <!-- <button type='button' style='float:right' class='btn btn-sm btn-white dropdown-toggle-split viewkroption' data-toggle='dropdown'><i class='far fa-edit'></i></button>
       <div class='dropdown-menu dropdown-menu-right'>
       <a href='#' class='dropdown-item updrevenue' data-id='".$data->budgetRevenueID."' data-toggle='modal' data-backdrop='static' data-target='#updestimaterev'><i class='far fa-edit'></i> Update Estimated  </a>
       <a href='#' class='dropdown-item updrevenue'  data-id='".$data2->budgetRevenueID."' data-toggle='modal' data-backdrop='static' data-target='#updestimaterev'><i class='far fa-edit'></i> Update Actual</a></div> -->
       <table style='text-align:center; width:100%;' class='table'>

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
           $revenueobj =$revenueobject->searchRevenueEstLog($company,$year,"estimatedrev");
           $revenueobj2 =$revenueobject->searchRevenueActLog($company,$year,"actualrev");
        
           $view .=
            "
           <tbody>
             <tr style='text-align:center;'>
               <td style='vertical-align:middle;'><b>January</b> </td>
               <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='".$janestimate."' id='addcost' name='addcost'><small><span id='costerror'></span></small></div></td>
               <td style='vertical-align:middle;'><a href ='#janestimated' class='' data-toggle='modal' data-target='#janestimated' ><i class='fas fa-history'></i> </a></td>
               <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='".$janactual."' id='addcost' name='addcost'><small><span id='costerror'></span></small></div></td>
               <td style='vertical-align:middle;'> <a href ='#janactual' class='' data-toggle='modal' data-target='#janactual' ><i class='fas fa-history'></i> </a></td>

               <div class='modal fade' id='janestimated'>
               <div class='modal-dialog modal-lg'>
               <div class='modal-content' style='padding: 70px'>

               <div class='modal-header'>
                  <h6 class='modal-title'> History</h6>
                  <button type='button' class='close' data-dismiss='modal'>&times;</button>
               </div>
               <div class='modal-body' >
               <div class='form-group'>
                  <label><b>Projected Revenue</b></label><br>
                             ";
                if ($revenueobj){
                    $prevjan="";

                    foreach($revenueobj as $row){
                      $janlog= $row->januaryLog;
                      $janaction=$row->action;
                      $jantime=$row->time;
                      $currentjan=$janlog;
                      $curjanaction=$janaction;
                      $curjantime=$jantime;

                     if($currentjan==$prevjan){
                          $show="";
                      }
                      else {
                          $show="<label>".$curjanaction." on ".$curjantime." : " .$currentjan."</label><br>";
                           }
                          $prevjan=$currentjan;
                          $view.= $show;
                      }
                      }
                          $view.="
                           
                   <br>
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
                       
                    <label><b>Actual Revenue</b></label><br>
                                ";
                                          if ($revenueobj2){
                                            $prevjan2="";

                                           foreach($revenueobj2 as $row2){
                                            $janlog2= $row2->januaryLog;
                                            $janaction2=$row2->action;
                                            $jantime2=$row2->time;
                                            $currentjan2=$janlog2;
                                            $curjanaction2=$janaction2;
                                            $curjantime2=$jantime2;

                                            if($currentjan2==$prevjan2){
                                              $show="";
                                            }
                                            else {
                                              $show="<label>".$curjanaction2." on ".$curjantime2." : " .$currentjan2."</label><br>";
                                            }
                                            $prevjan2=$currentjan2;
                                            $view.= $show;

                                            }
                                           }
                                   
              
                                
                             $view.="
                          
                                   
                      <br>
                         </div>
                       </div>
                     </div>
                   </div>
                   </div>   
           </tr>
           <tr style='text-align:center;'>
             <td style='vertical-align:middle;'><b>February</b> </td>
             <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='".$febestimate."' id='addcost' name='addcost'><small><span id='costerror'></span></small></div></td>
             <td style='vertical-align:middle;'> <a href ='#febestimated' class='' data-toggle='modal' data-target='#febestimated' ><i class='fas fa-history'></i> </a></td>
             <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='".$febactual."' id='addcost' name='addcost'><small><span id='costerror'></span></small></div></td>
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
                   
                     
                             <label><b>Projected Revenue</b></label><br>
                             ";
                                       if ($revenueobj){
                                        $prevfeb="";

                                        foreach($revenueobj as $row){
                                         $feblog= $row->februaryLog;
                                         $febaction=$row->action;
                                         $febtime=$row->time;
                                         $currentfeb=$feblog;
                                         $curfebaction=$febaction;
                                         $curfebtime=$febtime;

                                         if($currentfeb==$prevfeb){
                                           $show="";
                                         }
                                         else {
                                           $show="<label>".$curfebaction." on ".$curfebtime." : " .$currentfeb."</label><br>";
                                         }
                                         $prevfeb=$currentfeb;
                                         $view.= $show;

                                        }
                             }
                          $view.="
                       
                                   
                   <br>
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
                       
                        
                                <label><b>Actual Revenue</b></label><br>
                                ";
                                                    if ($revenueobj2){
                                                     $prevfeb2="";

                                                     foreach($revenueobj2 as $row2){
                                                      $feblog2= $row2->februaryLog;
                                                      $febaction2=$row2->action;
                                                      $febtime2=$row2->time;
                                                      $currentfeb2=$feblog2;
                                                      $curfebaction2=$febaction2;
                                                      $curfebtime2=$febtime2;

                                                      if($currentfeb2==$prevfeb2){
                                                        $show="";
                                                      }
                                                      else {
                                                        $show="<label>".$curfebaction2." on ".$curfebtime2." : " .$currentfeb2."</label><br>";
                                                      }
                                                      $prevfeb2=$currentfeb2;
                                                      $view.= $show;

                                                     }
                                          }
                             $view.="
                          
                                  
                      <br>
                         </div>
                       </div>
                     </div>
                   </div>
                   </div>   
             
           </tr>  

           <tr style='text-align:center;'>
             <td style='vertical-align:middle;'><b>March</b> </td>
             <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='".$marestimate."' id='addcost' name='addcost'><small><span id='costerror'></span></small></div></td>
             <td style='vertical-align:middle;'> <a href ='#marestimated' class='' data-toggle='modal' data-target='#marestimated' ><i class='fas fa-history'></i> </a></td>
             <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='".$maractual."' id='addcost' name='addcost'><small><span id='costerror'></span></small></div></td>
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
                   
                     
                             <label><b>Projected Revenue</b></label><br>
                             ";
                                                if ($revenueobj){
                                                 $prevmar="";

                                                 foreach($revenueobj as $row){
                                                  $marlog= $row->marchLog;
                                                  $maraction=$row->action;
                                                  $martime=$row->time;
                                                  $currentmar=$marlog;
                                                  $curmaraction=$maraction;
                                                  $curmartime=$martime;

                                                  if($currentmar==$prevmar){
                                                    $show="";
                                                  }
                                                  else {
                                                    $show="<label>".$curmaraction." on ".$curmartime." : " .$currentmar."</label><br>";
                                                  }
                                                  $prevmar=$currentmar;
                                                  $view.= $show;

                                                 }
                                      }
                          $view.="
                       
                                
                   <br>
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
                      
                        
                                <label><b>Actual Revenue</b></label><br>
                                ";
                                                  if ($revenueobj2){
                                                   $prevmar2="";

                                                   foreach($revenueobj2 as $row2){
                                                    $marlog2= $row2->marchLog;
                                                    $maraction2=$row2->action;
                                                    $martime2=$row2->time;
                                                    $currentmar2=$marlog2;
                                                    $curmaraction2=$maraction2;
                                                    $curmartime2=$martime2;

                                                    if($currentmar2==$prevmar2){
                                                      $show="";
                                                    }
                                                    else {
                                                      $show="<label>".$curmaraction2." on ".$curmartime2." : " .$currentmar2."</label><br>";
                                                    }
                                                    $prevmar2=$currentmar2;
                                                    $view.= $show;

                                                   }
                                        }
                             $view.="
                          
                                 
                      <br>
                         </div>
                       </div>
                     </div>
                   </div>
                   </div>   
           </tr>  

           <tr style='text-align:center;'>
             <td style='vertical-align:middle;'><b>April</b> </td>
             <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='".$aprestimate."' id='addcost' name='addcost'><small><span id='costerror'></span></small></div></td>
             <td style='vertical-align:middle;'> <a href ='#aprestimated' class='' data-toggle='modal' data-target='#aprestimated' ><i class='fas fa-history'></i> </a></td>
             <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='".$apractual."' id='addcost' name='addcost'><small><span id='costerror'></span></small></div></td>
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
                  
                     
                             <label><b>Projected Revenue</b></label><br>
                             ";
                                                 if ($revenueobj){
                                                  $prevapr="";

                                                  foreach($revenueobj as $row){
                                                   $aprlog= $row->aprilLog;
                                                   $apraction=$row->action;
                                                   $aprtime=$row->time;
                                                   $currentapr=$aprlog;
                                                   $curapraction=$apraction;
                                                   $curaprtime=$aprtime;

                                                   if($currentapr==$prevapr){
                                                     $show="";
                                                   }
                                                   else {
                                                     $show="<label>".$curapraction." on ".$curaprtime." : " .$currentapr."</label><br>";
                                                   }
                                                   $prevapr=$currentapr;
                                                   $view.= $show;

                                                  }
                                       }
                          $view.="
                       
                               
                   <br>
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
                      
                        
                                <label><b>Actual Revenue</b></label><br>
                                ";
                                                    if ($revenueobj2){
                                                     $prevapr2="";

                                                     foreach($revenueobj2 as $row2){
                                                      $aprlog2= $row2->aprilLog;
                                                      $apraction2=$row2->action;
                                                      $aprtime2=$row2->time;
                                                      $currentapr2=$aprlog2;
                                                      $curapraction2=$apraction2;
                                                      $curaprtime2=$aprtime2;

                                                      if($currentapr2==$prevapr2){
                                                        $show="";
                                                      }
                                                      else {
                                                        $show="<label>".$curapraction2." on ".$curaprtime2." : " .$currentapr2."</label><br>";
                                                      }
                                                      $prevapr2=$currentapr2;
                                                      $view.= $show;

                                                     }
                                          }
                             $view.="
                          
                                  
                      <br>
                         </div>
                       </div>
                     </div>
                   </div>
                   </div>   
           </tr>  

           <tr style='text-align:center;'>
             <td style='vertical-align:middle;'><b>May</b> </td>
             <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='".$mayestimate."' id='addcost' name='addcost'><small><span id='costerror'></span></small></div></td>
             <td style='vertical-align:middle;'> <a href ='#mayestimated' class='' data-toggle='modal' data-target='#mayestimated' ><i class='fas fa-history'></i> </a></td>
             <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='".$mayactual."' id='addcost' name='addcost'><small><span id='costerror'></span></small></div></td>
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
                  
                     
                             <label><b>Projected Revenue</b></label><br>
                             ";
                                                if ($revenueobj){
                                                 $prevmay="";

                                                 foreach($revenueobj as $row){
                                                  $maylog= $row->mayLog;
                                                  $mayaction=$row->action;
                                                  $maytime=$row->time;
                                                  $currentmay=$maylog;
                                                  $curmayaction=$mayaction;
                                                  $curmaytime=$maytime;

                                                  if($currentmay==$prevmay){
                                                    $show="";
                                                  }
                                                  else {
                                                    $show="<label>".$curmayaction." on ".$curmaytime." : " .$currentmay."</label><br>";
                                                  }
                                                  $prevmay=$currentmay;
                                                  $view.= $show;

                                                 }
                                      }
                          $view.="
                       
                               
                   <br>
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
                       
                        
                                <label><b>Actual Revenue</b></label><br>
                                ";
                                                 if ($revenueobj2){
                                                  $prevmay2="";

                                                  foreach($revenueobj2 as $row2){
                                                   $maylog2= $row2->mayLog;
                                                   $mayaction2=$row2->action;
                                                   $maytime2=$row2->time;
                                                   $currentmay2=$maylog2;
                                                   $curmayaction2=$mayaction2;
                                                   $curmaytime2=$maytime2;

                                                   if($currentmay2==$prevmay2){
                                                     $show="";
                                                   }
                                                   else {
                                                     $show="<label>".$curmayaction2." on ".$curmaytime2." : " .$currentmay2."</label><br>";
                                                   }
                                                   $prevmay2=$currentmay2;
                                                   $view.= $show;

                                                  }
                                       }
                             $view.="
                          
                                   
                      <br>
                         </div>
                       </div>
                     </div>
                   </div>
                   </div>   
                        
           </tr>  

           <tr style='text-align:center;'>
             <td style='vertical-align:middle;'><b>June</b> </td>
             <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='".$junestimate."' id='addcost' name='addcost'><small><span id='costerror'></span></small></div></td>
             <td style='vertical-align:middle;'> <a href ='#junestimated' class='' data-toggle='modal' data-target='#junestimated' ><i class='fas fa-history'></i> </a></td>
             <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='".$junactual."' id='addcost' name='addcost'><small><span id='costerror'></span></small></div></td>
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
                
                     
                             <label><b>Projected Revenue</b></label><br>
                             ";
                                               if ($revenueobj){
                                                $prevjun="";

                                                foreach($revenueobj as $row){
                                                 $junlog= $row->juneLog;
                                                 $junaction=$row->action;
                                                 $juntime=$row->time;
                                                 $currentjun=$junlog;
                                                 $curjunaction=$junaction;
                                                 $curjuntime=$juntime;

                                                 if($currentjun==$prevjun){
                                                   $show="";
                                                 }
                                                 else {
                                                   $show="<label>".$curjunaction." on ".$curjuntime." : " .$currentjun."</label><br>";
                                                 }
                                                 $prevjun=$currentjun;
                                                 $view.= $show;

                                                }
                                     }
                          $view.="
                       
                           
                   <br>
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
              >
                        
                                <label><b>Actual Revenue</b></label><br>
                                ";
                                                 if ($revenueobj2){
                                                  $prevjun2="";

                                                  foreach($revenueobj2 as $row2){
                                                   $junlog2= $row2->juneLog;
                                                   $junaction2=$row2->action;
                                                   $juntime2=$row2->time;
                                                   $currentjun2=$junlog2;
                                                   $curjunaction2=$junaction2;
                                                   $curjuntime2=$juntime2;

                                                   if($currentjun2==$prevjun2){
                                                     $show="";
                                                   }
                                                   else {
                                                     $show="<label>".$curjunaction2." on ".$curjuntime2." : " .$currentjun2."</label><br>";
                                                   }
                                                   $prevjun2=$currentjun2;
                                                   $view.= $show;

                                                  }
                                       }
                             $view.="
                          
                                
                      <br>
                         </div>
                       </div>
                     </div>
                   </div>
                   </div>   
           </tr>  

           <tr style='text-align:center;'>
             <td style='vertical-align:middle;'><b>July</b> </td>
             <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='".$julestimate."' id='addcost' name='addcost'><small><span id='costerror'></span></small></div></td>
             <td style='vertical-align:middle;'> <a href ='#julestimated' class='' data-toggle='modal' data-target='#julestimated' ><i class='fas fa-history'></i> </a></td>
             <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='".$julactual."' id='addcost' name='addcost'><small><span id='costerror'></span></small></div></td>
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
                   
                    
                            <label><b>Projected Revenue</b></label><br>
                            ";
                                               if ($revenueobj){
                                                $prevjul="";

                                                foreach($revenueobj as $row){
                                                 $jullog= $row->julyLog;
                                                 $julaction=$row->action;
                                                 $jultime=$row->time;
                                                 $currentjul=$jullog;
                                                 $curjulaction=$julaction;
                                                 $curjultime=$jultime;

                                                 if($currentjul==$prevjul){
                                                   $show="";
                                                 }
                                                 else {
                                                   $show="<label>".$curjulaction." on ".$curjultime." : " .$currentjul."</label><br>";
                                                 }
                                                 $prevjul=$currentjul;
                                                 $view.= $show;

                                                }
                                     }
                         $view.="
                      
                                  
                  <br>
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
                  
                       
                               <label><b>Actual Revenue</b></label><br>
                               ";
                                                if ($revenueobj2){
                                                 $prevjul2="";

                                                 foreach($revenueobj2 as $row2){
                                                  $jullog2= $row2->julyLog;
                                                  $julaction2=$row2->action;
                                                  $jultime2=$row2->time;
                                                  $currentjul2=$jullog2;
                                                  $curjulaction2=$julaction2;
                                                  $curjultime2=$jultime2;

                                                  if($currentjul2==$prevjul2){
                                                    $show="";
                                                  }
                                                  else {
                                                    $show="<label>".$curjulaction2." on ".$curjultime2." : " .$currentjul2."</label><br>";
                                                  }
                                                  $prevjul2=$currentjul2;
                                                  $view.= $show;

                                                 }
                                      }
                            $view.="
                         
                                   
                     <br>
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>   
                        
           </tr>  

           <tr style='text-align:center;'>
             <td style='vertical-align:middle;'><b>August</b> </td>
             <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='".$augestimate."' id='addcost' name='addcost'><small><span id='costerror'></span></small></div></td>
             <td style='vertical-align:middle;'> <a href ='#augestimated' class='' data-toggle='modal' data-target='#augestimated' ><i class='fas fa-history'></i> </a></td>
             <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='".$augactual."' id='addcost' name='addcost'><small><span id='costerror'></span></small></div></td>
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
                 
                    
                            <label><b>Projected Revenue</b></label><br>
                            ";
                                               if ($revenueobj){
                                                $prevaug="";

                                                foreach($revenueobj as $row){
                                                 $auglog= $row->augustLog;
                                                 $augaction=$row->action;
                                                 $augtime=$row->time;
                                                 $currentaug=$auglog;
                                                 $curaugaction=$augaction;
                                                 $curaugtime=$augtime;

                                                 if($currentaug==$prevaug){
                                                   $show="";
                                                 }
                                                 else {
                                                   $show="<label>".$curaugaction." on ".$curaugtime." : " .$currentaug."</label><br>";
                                                 }
                                                 $prevaug=$currentaug;
                                                 $view.= $show;

                                                }
                                     }
                         $view.="
                      
                               
                  <br>
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
                      
                       
                               <label><b>Actual Revenue</b></label><br>
                               ";
                                            if ($revenueobj2){
                                             $prevaug2="";

                                             foreach($revenueobj2 as $row2){
                                              $auglog2= $row2->augustLog;
                                              $augaction2=$row2->action;
                                              $augtime2=$row2->time;
                                              $currentaug2=$auglog2;
                                              $curaugaction2=$augaction2;
                                              $curaugtime2=$augtime2;

                                              if($currentaug2==$prevaug2){
                                                $show="";
                                              }
                                              else {
                                                $show="<label>".$curaugaction2." on ".$curaugtime2." : " .$currentaug2."</label><br>";
                                              }
                                              $prevaug2=$currentaug2;
                                              $view.= $show;

                                             }
                                  }
                            $view.="
                         
                                     
                     <br>
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>   
                        
           </tr>  

           <tr style='text-align:center;'>
             <td style='vertical-align:middle;'><b>September</b> </td>
             <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='".$sepestimate."' id='addcost' name='addcost'><small><span id='costerror'></span></small></div></td>
             <td style='vertical-align:middle;'> <a href ='#sepestimated' class='' data-toggle='modal' data-target='#sepestimated' ><i class='fas fa-history'></i> </a></td>
             <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='".$sepactual."' id='addcost' name='addcost'><small><span id='costerror'></span></small></div></td>
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
                    
                    
                            <label><b>Projected Revenue</b></label><br>
                            ";
                                            if ($revenueobj){
                                             $prevsep="";

                                             foreach($revenueobj as $row){
                                              $seplog= $row->septemberLog;
                                              $sepaction=$row->action;
                                              $septime=$row->time;
                                              $currentsep=$seplog;
                                              $cursepaction=$sepaction;
                                              $curseptime=$septime;

                                              if($currentsep==$prevsep){
                                                $show="";
                                              }
                                              else {
                                                $show="<label>".$cursepaction." on ".$curseptime." : " .$currentsep."</label><br>";
                                              }
                                              $prevsep=$currentsep;
                                              $view.= $show;

                                             }
                                  }
                         $view.="
                      
                            
                  <br>
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
                     
                       
                               <label><b>Actual Revenue</b></label><br>
                               ";
                                             if ($revenueobj2){
                                              $prevsep2="";

                                              foreach($revenueobj2 as $row2){
                                               $seplog2= $row2->septemberLog;
                                               $sepaction2=$row2->action;
                                               $septime2=$row2->time;
                                               $currentsep2=$seplog2;
                                               $cursepaction2=$sepaction2;
                                               $curseptime2=$septime2;

                                               if($currentsep2==$prevsep2){
                                                 $show="";
                                               }
                                               else {
                                                 $show="<label>".$cursepaction2." on ".$curseptime2." : " .$currentsep2."</label><br>";
                                               }
                                               $prevsep2=$currentsep2;
                                               $view.= $show;

                                              }
                                   }
                            $view.="
                         
                                   
                     <br>
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>   
           </tr>  

           <tr style='text-align:center;'>
             <td style='vertical-align:middle;'><b>October</b> </td>
             <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='".$octestimate."' id='addcost' name='addcost'><small><span id='costerror'></span></small></div></td>
             <td style='vertical-align:middle;'> <a href ='#octestimated' class='' data-toggle='modal' data-target='#octestimated' ><i class='fas fa-history'></i> </a></td>
             <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='".$octactual."' id='addcost' name='addcost'><small><span id='costerror'></span></small></div></td>
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
                   
                    
                            <label><b>Projected Revenue</b></label><br>
                            ";
                                             if ($revenueobj){
                                              $prevoct="";

                                              foreach($revenueobj as $row){
                                               $octlog= $row->octoberLog;
                                               $octaction=$row->action;
                                               $octtime=$row->time;
                                               $currentoct=$octlog;
                                               $curoctaction=$octaction;
                                               $curocttime=$octtime;

                                               if($currentoct==$prevoct){
                                                 $show="";
                                               }
                                               else {
                                                 $show="<label>".$curoctaction." on ".$curocttime." : " .$currentoct."</label><br>";
                                               }
                                               $prevoct=$currentoct;
                                               $view.= $show;

                                              }
                                   }
                         $view.="
                      
                             
                  <br>
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
                      
                       
                               <label><b>Actual Revenue</b></label><br>
                               ";
                                            if ($revenueobj2){
                                             $prevoct2="";

                                             foreach($revenueobj2 as $row2){
                                              $octlog2= $row2->octoberLog;
                                              $octaction2=$row2->action;
                                              $octtime2=$row2->time;
                                              $currentoct2=$octlog2;
                                              $curoctaction2=$octaction2;
                                              $curocttime2=$octtime2;

                                              if($currentoct2==$prevoct2){
                                                $show="";
                                              }
                                              else {
                                                $show="<label>".$curoctaction2." on ".$curocttime2." : " .$currentoct2."</label><br>";
                                              }
                                              $prevoct2=$currentoct2;
                                              $view.= $show;

                                             }
                                  }
                            $view.="
                         
                                 
                     <br>
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>   
                        
           </tr>  

           <tr style='text-align:center;'>
             <td style='vertical-align:middle;'><b>November</b> </td>
             <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='".$novestimate."' id='addcost' name='addcost'><small><span id='costerror'></span></small></div></td>
             <td style='vertical-align:middle;'> <a href ='#novestimated' class='' data-toggle='modal' data-target='#novestimated' ><i class='fas fa-history'></i> </a></td>
             <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='".$novactual."' id='addcost' name='addcost'><small><span id='costerror'></span></small></div></td>
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
                  
                   
                           <label><b>Projected Revenue</b></label><br>
                           ";
                                       if ($revenueobj){
                                        $prevnov="";

                                        foreach($revenueobj as $row){
                                         $novlog= $row->novemberLog;
                                         $novaction=$row->action;
                                         $novtime=$row->time;
                                         $currentnov=$novlog;
                                         $curnovaction=$novaction;
                                         $curnovtime=$novtime;

                                         if($currentnov==$prevnov){
                                           $show="";
                                         }
                                         else {
                                           $show="<label>".$curnovaction." on ".$curnovtime." : " .$currentnov."</label><br>";
                                         }
                                         $prevnov=$currentnov;
                                         $view.= $show;

                                        }
                             }
                        $view.="
                     
                                
                 <br>
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
                     
                      
                              <label><b>Actual Revenue</b></label><br>
                              ";
                                       if ($revenueobj2){
                                        $prevnov2="";

                                        foreach($revenueobj2 as $row2){
                                         $novlog2= $row->novemberLog;
                                         $novaction2=$row->action;
                                         $novtime2=$row->time;
                                         $currentnov2=$novlog2;
                                         $curnovaction2=$novaction2;
                                         $curnovtime2=$novtime2;

                                         if($currentnov2==$prevnov2){
                                           $show="";
                                         }
                                         else {
                                           $show="<label>".$curnovaction2." on ".$curnovtime2." : " .$currentnov2."</label><br>";
                                         }
                                         $prevnov2=$currentnov2;
                                         $view.= $show;

                                        }
                             }
                           $view.="
                        
                                 
                    <br>
                       </div>
                     </div>
                   </div>
                 </div>
                 </div>   
                        
           </tr>  

           <tr style='text-align:center;'>
             <td style='vertical-align:middle;'><b>December</b> </td>
             <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='".$decestimate."' id='addcost' name='addcost'><small><span id='costerror'></span></small></div></td>
             <td style='vertical-align:middle;'> <a href ='#decestimated' class='' data-toggle='modal' data-target='#decestimated' ><i class='fas fa-history'></i> </a></td>
             <td><div class='form-group' align='center' style='margin-bottom:0.2rem;'><input class='form-control' style='max-width:110px; text-align:center;' type='number' value='".$decactual."' id='addcost' name='addcost'><small><span id='costerror'></span></small></div></td>
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
                     
                     
                             <label><b>Projected Revenue</b></label><br>
                             ";
                             if ($revenueobj){
                               $prevdec="";

                               foreach($revenueobj as $row){
                                $declog= $row->decemberLog;
                                $decaction=$row->action;
                                $dectime=$row->time;
                                $currentdec=$declog;
                                $curdecaction=$decaction;
                                $curdectime=$dectime;

                                if($currentdec==$prevdec){
                                  $show="";
                                }
                                else {
                                  $show="<label>".$curdecaction." on ".$curdectime." : " .$currentdec."</label><br>";
                                }
                                $prevdec=$currentdec;
                                $view.= $show;

                              }
                            }
                          $view.="
                       
                                  
                   <br>
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
                       
                        
                                <label><b>Actual Revenue</b></label><br>
                                ";
                                if ($revenueobj2){
                                 $prevdec2="";

                                 foreach($revenueobj2 as $row2){
                                  $declog2= $row2->decemberLog;
                                  $decaction2=$row2->action;
                                  $dectime2=$row2->time;
                                  $currentdec2=$declog2;
                                  $curdecaction2=$decaction2;
                                  $curdectime2=$dectime2;

                                  if($currentdec2==$prevdec2){
                                    $show="";
                                  }
                                  else {
                                    $show="<label>".$curdecaction2." on ".$curdectime2." : " .$currentdec2."</label><br>";
                                  }
                                  $prevdec2=$currentdec2;
                                  $view.= $show;

                                }
                              }
                             $view.="
                          
                               
                      <br>
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

 elseif($data!=null && $data2 == null){
 
        $view .= 
        "
        <div class='col-xl-12 col-6 text-right'>
          <button type='button' class='btn btn-primary shadow-sm saverev1 ' data-toggle='modal' data-backdrop='static' data-target='#addRevenue'><i class='fas fa-plus'></i> Add Revenue</button>
        </div><br>

       <div class='table-responsive text-nowrap'>
       <button type='button' style='float:right' class='btn btn-sm btn-white dropdown-toggle-split viewkroption' data-toggle='dropdown'><i class='far fa-edit'></i></button>
       <div class='dropdown-menu dropdown-menu-right'>
       <a href='#' class='dropdown-item updrevenue' data-id='".$data->budgetRevenueID."' data-toggle='modal' data-backdrop='static' data-target='#updestimaterev'><i class='far fa-edit'></i> Update Estimated  </a>
       </div>
       <table style='text-align:center; width:100%;' class='table'>

            <thead>
              <tr>
                <th>Month</th>
                <th>Projected Revenue</th>
                <th>History</th>
                <th>Actual Revenue</th>
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

           
             $janactual = "-";
             $febactual = "-";   
             $maractual ="-";
             $apractual = "-";
             $mayactual = "-";
             $junactual = "-";
             $julactual = "-";
             $augactual ="-";
             $sepactual = "-";
             $octactual = "-";
             $novactual = "-";
             $decactual = "-";
           
           $revenueobject = new Revenue();
           $revenueobj =$revenueobject->searchRevenueEstLog($company,$year,"estimatedrev");
           $revenueobj2 =$revenueobject->searchRevenueActLog($company,$year,"actualrev");
        
           $view .=
            "
           <tbody>
             <tr style='text-align:center;'>
               <td><b>January</b> </td>
               <td>".$janestimate."</td>
               <td> <a href ='#janestimated' class='' data-toggle='modal' data-target='#janestimated' ><i class='fas fa-history'></i> </a></td>
               <td>".$janactual."</td>
               <td> </td>

               <div class='modal fade' id='janestimated'>
               <div class='modal-dialog modal-lg'>
               <div class='modal-content' style='padding: 70px'>

               <div class='modal-header'>
                  <h6 class='modal-title'> History</h6>
                  <button type='button' class='close' data-dismiss='modal'>&times;</button>
               </div>
               <div class='modal-body' >
               <div class='form-group'>
                  <label><b>Projected Revenue</b></label><br>
                             ";
                if ($revenueobj){
                    $prevjan="";

                    foreach($revenueobj as $row){
                      $janlog= $row->januaryLog;
                      $janaction=$row->action;
                      $jantime=$row->time;
                      $currentjan=$janlog;
                      $curjanaction=$janaction;
                      $curjantime=$jantime;

                     if($currentjan==$prevjan){
                          $show="";
                      }
                      else {
                          $show="<label>".$curjanaction." on ".$curjantime." : " .$currentjan."</label><br>";
                           }
                          $prevjan=$currentjan;
                          $view.= $show;
                      }
                      }
                          $view.="
                           
                   <br>
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
                       
                    <label><b>Actual Revenue</b></label><br>
                                ";
                                          if ($revenueobj2){
                                            $prevjan2="";

                                           foreach($revenueobj2 as $row2){
                                            $janlog2= $row2->januaryLog;
                                            $janaction2=$row2->action;
                                            $jantime2=$row2->time;
                                            $currentjan2=$janlog2;
                                            $curjanaction2=$janaction2;
                                            $curjantime2=$jantime2;

                                            if($currentjan2==$prevjan2){
                                              $show="";
                                            }
                                            else {
                                              $show="<label>".$curjanaction2." on ".$curjantime2." : " .$currentjan2."</label><br>";
                                            }
                                            $prevjan2=$currentjan2;
                                            $view.= $show;

                                            }
                                           }
                                   
              
                                
                             $view.="
                          
                                   
                      <br>
                         </div>
                       </div>
                     </div>
                   </div>
                   </div>   
           </tr>
           <tr style='text-align:center;'>
             <td><b>February</b> </td>
             <td>".$febestimate."</td>
             <td> <a href ='#febestimated' class='' data-toggle='modal' data-target='#febestimated' ><i class='fas fa-history'></i> </a></td>
             <td>".$febactual."</td>
             <td> </td>

             <div class='modal fade' id='febestimated'>
               <div class='modal-dialog modal-lg'>
                 <div class='modal-content' style='padding: 70px'>

                   <div class='modal-header'>
                     <h6 class='modal-title'> History</h6>
                     <button type='button' class='close' data-dismiss='modal'>&times;</button>
                   </div>
                   <div class='modal-body' >
                     <div class='form-group'>
                   
                     
                             <label><b>Projected Revenue</b></label><br>
                             ";
                                       if ($revenueobj){
                                        $prevfeb="";

                                        foreach($revenueobj as $row){
                                         $feblog= $row->februaryLog;
                                         $febaction=$row->action;
                                         $febtime=$row->time;
                                         $currentfeb=$feblog;
                                         $curfebaction=$febaction;
                                         $curfebtime=$febtime;

                                         if($currentfeb==$prevfeb){
                                           $show="";
                                         }
                                         else {
                                           $show="<label>".$curfebaction." on ".$curfebtime." : " .$currentfeb."</label><br>";
                                         }
                                         $prevfeb=$currentfeb;
                                         $view.= $show;

                                        }
                             }
                          $view.="
                       
                                   
                   <br>
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
                       
                        
                                <label><b>Actual Revenue</b></label><br>
                                ";
                                                    if ($revenueobj2){
                                                     $prevfeb2="";

                                                     foreach($revenueobj2 as $row2){
                                                      $feblog2= $row2->februaryLog;
                                                      $febaction2=$row2->action;
                                                      $febtime2=$row2->time;
                                                      $currentfeb2=$feblog2;
                                                      $curfebaction2=$febaction2;
                                                      $curfebtime2=$febtime2;

                                                      if($currentfeb2==$prevfeb2){
                                                        $show="";
                                                      }
                                                      else {
                                                        $show="<label>".$curfebaction2." on ".$curfebtime2." : " .$currentfeb2."</label><br>";
                                                      }
                                                      $prevfeb2=$currentfeb2;
                                                      $view.= $show;

                                                     }
                                          }
                             $view.="
                          
                                  
                      <br>
                         </div>
                       </div>
                     </div>
                   </div>
                   </div>   
             
           </tr>  

           <tr style='text-align:center;'>
             <td><b>March</b> </td>
             <td>".$marestimate."</td>
             <td> <a href ='#marestimated' class='' data-toggle='modal' data-target='#marestimated' ><i class='fas fa-history'></i> </a></td>
             <td>".$maractual."</td>
             <td> </td>

             <div class='modal fade' id='marestimated'>
               <div class='modal-dialog modal-lg'>
                 <div class='modal-content' style='padding: 70px'>

                   <div class='modal-header'>
                     <h6 class='modal-title'> History</h6>
                     <button type='button' class='close' data-dismiss='modal'>&times;</button>
                   </div>
                   <div class='modal-body' >
                     <div class='form-group'>
                   
                     
                             <label><b>Projected Revenue</b></label><br>
                             ";
                                                if ($revenueobj){
                                                 $prevmar="";

                                                 foreach($revenueobj as $row){
                                                  $marlog= $row->marchLog;
                                                  $maraction=$row->action;
                                                  $martime=$row->time;
                                                  $currentmar=$marlog;
                                                  $curmaraction=$maraction;
                                                  $curmartime=$martime;

                                                  if($currentmar==$prevmar){
                                                    $show="";
                                                  }
                                                  else {
                                                    $show="<label>".$curmaraction." on ".$curmartime." : " .$currentmar."</label><br>";
                                                  }
                                                  $prevmar=$currentmar;
                                                  $view.= $show;

                                                 }
                                      }
                          $view.="
                       
                                
                   <br>
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
                      
                        
                                <label><b>Actual Revenue</b></label><br>
                                ";
                                                  if ($revenueobj2){
                                                   $prevmar2="";

                                                   foreach($revenueobj2 as $row2){
                                                    $marlog2= $row2->marchLog;
                                                    $maraction2=$row2->action;
                                                    $martime2=$row2->time;
                                                    $currentmar2=$marlog2;
                                                    $curmaraction2=$maraction2;
                                                    $curmartime2=$martime2;

                                                    if($currentmar2==$prevmar2){
                                                      $show="";
                                                    }
                                                    else {
                                                      $show="<label>".$curmaraction2." on ".$curmartime2." : " .$currentmar2."</label><br>";
                                                    }
                                                    $prevmar2=$currentmar2;
                                                    $view.= $show;

                                                   }
                                        }
                             $view.="
                          
                                 
                      <br>
                         </div>
                       </div>
                     </div>
                   </div>
                   </div>   
           </tr>  

           <tr style='text-align:center;'>
             <td><b>April</b> </td>
             <td>".$aprestimate."</td>
             <td> <a href ='#aprestimated' class='' data-toggle='modal' data-target='#aprestimated' ><i class='fas fa-history'></i> </a></td>
             <td>".$apractual."</td>
             <td> </td>

             <div class='modal fade' id='aprestimated'>
               <div class='modal-dialog modal-lg'>
                 <div class='modal-content' style='padding: 70px'>

                   <div class='modal-header'>
                     <h6 class='modal-title'> History</h6>
                     <button type='button' class='close' data-dismiss='modal'>&times;</button>
                   </div>
                   <div class='modal-body' >
                     <div class='form-group'>
                  
                     
                             <label><b>Projected Revenue</b></label><br>
                             ";
                                                 if ($revenueobj){
                                                  $prevapr="";

                                                  foreach($revenueobj as $row){
                                                   $aprlog= $row->aprilLog;
                                                   $apraction=$row->action;
                                                   $aprtime=$row->time;
                                                   $currentapr=$aprlog;
                                                   $curapraction=$apraction;
                                                   $curaprtime=$aprtime;

                                                   if($currentapr==$prevapr){
                                                     $show="";
                                                   }
                                                   else {
                                                     $show="<label>".$curapraction." on ".$curaprtime." : " .$currentapr."</label><br>";
                                                   }
                                                   $prevapr=$currentapr;
                                                   $view.= $show;

                                                  }
                                       }
                          $view.="
                       
                               
                   <br>
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
                      
                        
                                <label><b>Actual Revenue</b></label><br>
                                ";
                                                    if ($revenueobj2){
                                                     $prevapr2="";

                                                     foreach($revenueobj2 as $row2){
                                                      $aprlog2= $row2->aprilLog;
                                                      $apraction2=$row2->action;
                                                      $aprtime2=$row2->time;
                                                      $currentapr2=$aprlog2;
                                                      $curapraction2=$apraction2;
                                                      $curaprtime2=$aprtime2;

                                                      if($currentapr2==$prevapr2){
                                                        $show="";
                                                      }
                                                      else {
                                                        $show="<label>".$curapraction2." on ".$curaprtime2." : " .$currentapr2."</label><br>";
                                                      }
                                                      $prevapr2=$currentapr2;
                                                      $view.= $show;

                                                     }
                                          }
                             $view.="
                          
                                  
                      <br>
                         </div>
                       </div>
                     </div>
                   </div>
                   </div>   
           </tr>  

           <tr style='text-align:center;'>
             <td><b>May</b> </td>
             <td>".$mayestimate."</td>
             <td> <a href ='#mayestimated' class='' data-toggle='modal' data-target='#mayestimated' ><i class='fas fa-history'></i> </a></td>
             <td>".$mayactual."</td>
             <td> </td>

             <div class='modal fade' id='mayestimated'>
               <div class='modal-dialog modal-lg'>
                 <div class='modal-content' style='padding: 70px'>

                   <div class='modal-header'>
                     <h6 class='modal-title'> History</h6>
                     <button type='button' class='close' data-dismiss='modal'>&times;</button>
                   </div>
                   <div class='modal-body' >
                     <div class='form-group'>
                  
                     
                             <label><b>Projected Revenue</b></label><br>
                             ";
                                                if ($revenueobj){
                                                 $prevmay="";

                                                 foreach($revenueobj as $row){
                                                  $maylog= $row->mayLog;
                                                  $mayaction=$row->action;
                                                  $maytime=$row->time;
                                                  $currentmay=$maylog;
                                                  $curmayaction=$mayaction;
                                                  $curmaytime=$maytime;

                                                  if($currentmay==$prevmay){
                                                    $show="";
                                                  }
                                                  else {
                                                    $show="<label>".$curmayaction." on ".$curmaytime." : " .$currentmay."</label><br>";
                                                  }
                                                  $prevmay=$currentmay;
                                                  $view.= $show;

                                                 }
                                      }
                          $view.="
                       
                               
                   <br>
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
                       
                        
                                <label><b>Actual Revenue</b></label><br>
                                ";
                                                 if ($revenueobj2){
                                                  $prevmay2="";

                                                  foreach($revenueobj2 as $row2){
                                                   $maylog2= $row2->mayLog;
                                                   $mayaction2=$row2->action;
                                                   $maytime2=$row2->time;
                                                   $currentmay2=$maylog2;
                                                   $curmayaction2=$mayaction2;
                                                   $curmaytime2=$maytime2;

                                                   if($currentmay2==$prevmay2){
                                                     $show="";
                                                   }
                                                   else {
                                                     $show="<label>".$curmayaction2." on ".$curmaytime2." : " .$currentmay2."</label><br>";
                                                   }
                                                   $prevmay2=$currentmay2;
                                                   $view.= $show;

                                                  }
                                       }
                             $view.="
                          
                                   
                      <br>
                         </div>
                       </div>
                     </div>
                   </div>
                   </div>   
                        
           </tr>  

           <tr style='text-align:center;'>
             <td><b>June</b> </td>
             <td>".$junestimate."</td>
             <td> <a href ='#junestimated' class='' data-toggle='modal' data-target='#junestimated' ><i class='fas fa-history'></i> </a></td>
             <td>".$junactual."</td>
             <td> </td>

             <div class='modal fade' id='junestimated'>
               <div class='modal-dialog modal-lg'>
                 <div class='modal-content' style='padding: 70px'>

                   <div class='modal-header'>
                     <h6 class='modal-title'> History</h6>
                     <button type='button' class='close' data-dismiss='modal'>&times;</button>
                   </div>
                   <div class='modal-body' >
                     <div class='form-group'>
                
                     
                             <label><b>Projected Revenue</b></label><br>
                             ";
                                               if ($revenueobj){
                                                $prevjun="";

                                                foreach($revenueobj as $row){
                                                 $junlog= $row->juneLog;
                                                 $junaction=$row->action;
                                                 $juntime=$row->time;
                                                 $currentjun=$junlog;
                                                 $curjunaction=$junaction;
                                                 $curjuntime=$juntime;

                                                 if($currentjun==$prevjun){
                                                   $show="";
                                                 }
                                                 else {
                                                   $show="<label>".$curjunaction." on ".$curjuntime." : " .$currentjun."</label><br>";
                                                 }
                                                 $prevjun=$currentjun;
                                                 $view.= $show;

                                                }
                                     }
                          $view.="
                       
                           
                   <br>
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
              >
                        
                                <label><b>Actual Revenue</b></label><br>
                                ";
                                                 if ($revenueobj2){
                                                  $prevjun2="";

                                                  foreach($revenueobj2 as $row2){
                                                   $junlog2= $row2->juneLog;
                                                   $junaction2=$row2->action;
                                                   $juntime2=$row2->time;
                                                   $currentjun2=$junlog2;
                                                   $curjunaction2=$junaction2;
                                                   $curjuntime2=$juntime2;

                                                   if($currentjun2==$prevjun2){
                                                     $show="";
                                                   }
                                                   else {
                                                     $show="<label>".$curjunaction2." on ".$curjuntime2." : " .$currentjun2."</label><br>";
                                                   }
                                                   $prevjun2=$currentjun2;
                                                   $view.= $show;

                                                  }
                                       }
                             $view.="
                          
                                
                      <br>
                         </div>
                       </div>
                     </div>
                   </div>
                   </div>   
           </tr>  

           <tr style='text-align:center;'>
             <td><b>July</b> </td>
             <td>".$julestimate."</td>
             <td> <a href ='#julestimated' class='' data-toggle='modal' data-target='#julestimated' ><i class='fas fa-history'></i> </a></td>
             <td>".$julactual."</td>
             <td> </td>

            <div class='modal fade' id='julestimated'>
              <div class='modal-dialog modal-lg'>
                <div class='modal-content' style='padding: 70px'>

                  <div class='modal-header'>
                    <h6 class='modal-title'> History</h6>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                  </div>
                  <div class='modal-body' >
                    <div class='form-group'>
                   
                    
                            <label><b>Projected Revenue</b></label><br>
                            ";
                                               if ($revenueobj){
                                                $prevjul="";

                                                foreach($revenueobj as $row){
                                                 $jullog= $row->julyLog;
                                                 $julaction=$row->action;
                                                 $jultime=$row->time;
                                                 $currentjul=$jullog;
                                                 $curjulaction=$julaction;
                                                 $curjultime=$jultime;

                                                 if($currentjul==$prevjul){
                                                   $show="";
                                                 }
                                                 else {
                                                   $show="<label>".$curjulaction." on ".$curjultime." : " .$currentjul."</label><br>";
                                                 }
                                                 $prevjul=$currentjul;
                                                 $view.= $show;

                                                }
                                     }
                         $view.="
                      
                                  
                  <br>
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
                  
                       
                               <label><b>Actual Revenue</b></label><br>
                               ";
                                                if ($revenueobj2){
                                                 $prevjul2="";

                                                 foreach($revenueobj2 as $row2){
                                                  $jullog2= $row2->julyLog;
                                                  $julaction2=$row2->action;
                                                  $jultime2=$row2->time;
                                                  $currentjul2=$jullog2;
                                                  $curjulaction2=$julaction2;
                                                  $curjultime2=$jultime2;

                                                  if($currentjul2==$prevjul2){
                                                    $show="";
                                                  }
                                                  else {
                                                    $show="<label>".$curjulaction2." on ".$curjultime2." : " .$currentjul2."</label><br>";
                                                  }
                                                  $prevjul2=$currentjul2;
                                                  $view.= $show;

                                                 }
                                      }
                            $view.="
                         
                                   
                     <br>
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>   
                        
           </tr>  

           <tr style='text-align:center;'>
             <td><b>August</b> </td>
             <td>".$augestimate."</td>
             <td> <a href ='#augestimated' class='' data-toggle='modal' data-target='#augestimated' ><i class='fas fa-history'></i> </a></td>
             <td>".$augactual."</td>
             <td> </td>

            <div class='modal fade' id='augestimated'>
              <div class='modal-dialog modal-lg'>
                <div class='modal-content' style='padding: 70px'>

                  <div class='modal-header'>
                    <h6 class='modal-title'> History</h6>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                  </div>
                  <div class='modal-body' >
                    <div class='form-group'>
                 
                    
                            <label><b>Projected Revenue</b></label><br>
                            ";
                                               if ($revenueobj){
                                                $prevaug="";

                                                foreach($revenueobj as $row){
                                                 $auglog= $row->augustLog;
                                                 $augaction=$row->action;
                                                 $augtime=$row->time;
                                                 $currentaug=$auglog;
                                                 $curaugaction=$augaction;
                                                 $curaugtime=$augtime;

                                                 if($currentaug==$prevaug){
                                                   $show="";
                                                 }
                                                 else {
                                                   $show="<label>".$curaugaction." on ".$curaugtime." : " .$currentaug."</label><br>";
                                                 }
                                                 $prevaug=$currentaug;
                                                 $view.= $show;

                                                }
                                     }
                         $view.="
                      
                               
                  <br>
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
                      
                       
                               <label><b>Actual Revenue</b></label><br>
                               ";
                                            if ($revenueobj2){
                                             $prevaug2="";

                                             foreach($revenueobj2 as $row2){
                                              $auglog2= $row2->augustLog;
                                              $augaction2=$row2->action;
                                              $augtime2=$row2->time;
                                              $currentaug2=$auglog2;
                                              $curaugaction2=$augaction2;
                                              $curaugtime2=$augtime2;

                                              if($currentaug2==$prevaug2){
                                                $show="";
                                              }
                                              else {
                                                $show="<label>".$curaugaction2." on ".$curaugtime2." : " .$currentaug2."</label><br>";
                                              }
                                              $prevaug2=$currentaug2;
                                              $view.= $show;

                                             }
                                  }
                            $view.="
                         
                                     
                     <br>
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>   
                        
           </tr>  

           <tr style='text-align:center;'>
             <td><b>September</b> </td>
             <td>".$sepestimate."</td>
             <td> <a href ='#sepestimated' class='' data-toggle='modal' data-target='#sepestimated' ><i class='fas fa-history'></i> </a></td>
             <td>".$sepactual."</td>
             <td> </td>

            <div class='modal fade' id='sepestimated'>
              <div class='modal-dialog modal-lg'>
                <div class='modal-content' style='padding: 70px'>

                  <div class='modal-header'>
                    <h6 class='modal-title'> History</h6>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                  </div>
                  <div class='modal-body' >
                    <div class='form-group'>
                    
                    
                            <label><b>Projected Revenue</b></label><br>
                            ";
                                            if ($revenueobj){
                                             $prevsep="";

                                             foreach($revenueobj as $row){
                                              $seplog= $row->septemberLog;
                                              $sepaction=$row->action;
                                              $septime=$row->time;
                                              $currentsep=$seplog;
                                              $cursepaction=$sepaction;
                                              $curseptime=$septime;

                                              if($currentsep==$prevsep){
                                                $show="";
                                              }
                                              else {
                                                $show="<label>".$cursepaction." on ".$curseptime." : " .$currentsep."</label><br>";
                                              }
                                              $prevsep=$currentsep;
                                              $view.= $show;

                                             }
                                  }
                         $view.="
                      
                            
                  <br>
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
                     
                       
                               <label><b>Actual Revenue</b></label><br>
                               ";
                                             if ($revenueobj2){
                                              $prevsep2="";

                                              foreach($revenueobj2 as $row2){
                                               $seplog2= $row2->septemberLog;
                                               $sepaction2=$row2->action;
                                               $septime2=$row2->time;
                                               $currentsep2=$seplog2;
                                               $cursepaction2=$sepaction2;
                                               $curseptime2=$septime2;

                                               if($currentsep2==$prevsep2){
                                                 $show="";
                                               }
                                               else {
                                                 $show="<label>".$cursepaction2." on ".$curseptime2." : " .$currentsep2."</label><br>";
                                               }
                                               $prevsep2=$currentsep2;
                                               $view.= $show;

                                              }
                                   }
                            $view.="
                         
                                   
                     <br>
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>   
           </tr>  

           <tr style='text-align:center;'>
             <td><b>October</b> </td>
             <td>".$octestimate."</td>
             <td> <a href ='#octestimated' class='' data-toggle='modal' data-target='#octestimated' ><i class='fas fa-history'></i> </a></td>
             <td>".$octactual."</td>
             <td> </td>

            <div class='modal fade' id='octestimated'>
              <div class='modal-dialog modal-lg'>
                <div class='modal-content' style='padding: 70px'>

                  <div class='modal-header'>
                    <h6 class='modal-title'> History</h6>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                  </div>
                  <div class='modal-body' >
                    <div class='form-group'>
                   
                    
                            <label><b>Projected Revenue</b></label><br>
                            ";
                                             if ($revenueobj){
                                              $prevoct="";

                                              foreach($revenueobj as $row){
                                               $octlog= $row->octoberLog;
                                               $octaction=$row->action;
                                               $octtime=$row->time;
                                               $currentoct=$octlog;
                                               $curoctaction=$octaction;
                                               $curocttime=$octtime;

                                               if($currentoct==$prevoct){
                                                 $show="";
                                               }
                                               else {
                                                 $show="<label>".$curoctaction." on ".$curocttime." : " .$currentoct."</label><br>";
                                               }
                                               $prevoct=$currentoct;
                                               $view.= $show;

                                              }
                                   }
                         $view.="
                      
                             
                  <br>
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
                      
                       
                               <label><b>Actual Revenue</b></label><br>
                               ";
                                            if ($revenueobj2){
                                             $prevoct2="";

                                             foreach($revenueobj2 as $row2){
                                              $octlog2= $row2->octoberLog;
                                              $octaction2=$row2->action;
                                              $octtime2=$row2->time;
                                              $currentoct2=$octlog2;
                                              $curoctaction2=$octaction2;
                                              $curocttime2=$octtime2;

                                              if($currentoct2==$prevoct2){
                                                $show="";
                                              }
                                              else {
                                                $show="<label>".$curoctaction2." on ".$curocttime2." : " .$currentoct2."</label><br>";
                                              }
                                              $prevoct2=$currentoct2;
                                              $view.= $show;

                                             }
                                  }
                            $view.="
                         
                                 
                     <br>
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>   
                        
           </tr>  

           <tr style='text-align:center;'>
             <td><b>November</b> </td>
             <td>".$novestimate."</td>
             <td> <a href ='#novestimated' class='' data-toggle='modal' data-target='#novestimated' ><i class='fas fa-history'></i> </a></td>
             <td>".$novactual."</td>
             <td> </td>

           <div class='modal fade' id='novestimated'>
             <div class='modal-dialog modal-lg'>
               <div class='modal-content' style='padding: 70px'>

                 <div class='modal-header'>
                   <h6 class='modal-title'> History</h6>
                   <button type='button' class='close' data-dismiss='modal'>&times;</button>
                 </div>
                 <div class='modal-body' >
                   <div class='form-group'>
                  
                   
                           <label><b>Projected Revenue</b></label><br>
                           ";
                                       if ($revenueobj){
                                        $prevnov="";

                                        foreach($revenueobj as $row){
                                         $novlog= $row->novemberLog;
                                         $novaction=$row->action;
                                         $novtime=$row->time;
                                         $currentnov=$novlog;
                                         $curnovaction=$novaction;
                                         $curnovtime=$novtime;

                                         if($currentnov==$prevnov){
                                           $show="";
                                         }
                                         else {
                                           $show="<label>".$curnovaction." on ".$curnovtime." : " .$currentnov."</label><br>";
                                         }
                                         $prevnov=$currentnov;
                                         $view.= $show;

                                        }
                             }
                        $view.="
                     
                                
                 <br>
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
                     
                      
                              <label><b>Actual Revenue</b></label><br>
                              ";
                                       if ($revenueobj2){
                                        $prevnov2="";

                                        foreach($revenueobj2 as $row2){
                                         $novlog2= $row->novemberLog;
                                         $novaction2=$row->action;
                                         $novtime2=$row->time;
                                         $currentnov2=$novlog2;
                                         $curnovaction2=$novaction2;
                                         $curnovtime2=$novtime2;

                                         if($currentnov2==$prevnov2){
                                           $show="";
                                         }
                                         else {
                                           $show="<label>".$curnovaction2." on ".$curnovtime2." : " .$currentnov2."</label><br>";
                                         }
                                         $prevnov2=$currentnov2;
                                         $view.= $show;

                                        }
                             }
                           $view.="
                        
                                 
                    <br>
                       </div>
                     </div>
                   </div>
                 </div>
                 </div>   
                        
           </tr>  

           <tr style='text-align:center;'>
             <td><b>December</b> </td>
             <td>".$decestimate."</td>
             <td> <a href ='#decestimated' class='' data-toggle='modal' data-target='#decestimated' ><i class='fas fa-history'></i> </a></td>
             <td>".$decactual."</td>
             <td> </td>
             <div class='modal fade' id='decestimated'>
               <div class='modal-dialog modal-lg'>
                 <div class='modal-content' style='padding: 70px'>

                   <div class='modal-header'>
                     <h6 class='modal-title'> History</h6>
                     <button type='button' class='close' data-dismiss='modal'>&times;</button>
                   </div>
                   <div class='modal-body' >
                     <div class='form-group'>
                     
                     
                             <label><b>Projected Revenue</b></label><br>
                             ";
                             if ($revenueobj){
                               $prevdec="";

                               foreach($revenueobj as $row){
                                $declog= $row->decemberLog;
                                $decaction=$row->action;
                                $dectime=$row->time;
                                $currentdec=$declog;
                                $curdecaction=$decaction;
                                $curdectime=$dectime;

                                if($currentdec==$prevdec){
                                  $show="";
                                }
                                else {
                                  $show="<label>".$curdecaction." on ".$curdectime." : " .$currentdec."</label><br>";
                                }
                                $prevdec=$currentdec;
                                $view.= $show;

                              }
                            }
                          $view.="
                       
                                  
                   <br>
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
                       
                        
                                <label><b>Actual Revenue</b></label><br>
                                ";
                                if ($revenueobj2){
                                 $prevdec2="";

                                 foreach($revenueobj2 as $row2){
                                  $declog2= $row2->decemberLog;
                                  $decaction2=$row2->action;
                                  $dectime2=$row2->time;
                                  $currentdec2=$declog2;
                                  $curdecaction2=$decaction2;
                                  $curdectime2=$dectime2;

                                  if($currentdec2==$prevdec2){
                                    $show="";
                                  }
                                  else {
                                    $show="<label>".$curdecaction2." on ".$curdectime2." : " .$currentdec2."</label><br>";
                                  }
                                  $prevdec2=$currentdec2;
                                  $view.= $show;

                                }
                              }
                             $view.="
                          
                               
                      <br>
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

if($data==null && $data2 != null){
 
        $view .= 
        "
        <div class='col-xl-12 col-12 text-right'>
          <button type='button' class='btn btn-primary shadow-sm saverev1 ' data-toggle='modal' data-backdrop='static' data-target='#addRevenue'><i class='fas fa-plus'></i> Add Revenue</button>
        </div>

       <div class='table-responsive text-nowrap'>
       <button type='button' style='float:right' class='btn btn-sm btn-white dropdown-toggle-split viewkroption' data-toggle='dropdown'><i class='far fa-edit'></i></button>
       <div class='dropdown-menu dropdown-menu-right'>
       <a href='#' class='dropdown-item updrevenue'  data-id='".$data2->budgetRevenueID."' data-toggle='modal' data-backdrop='static' data-target='#updestimaterev'><i class='far fa-edit'></i> Update Actual  </a></div>
       <table style='text-align:center; width:100%;' class='table'>

            <thead>
              <tr>
                <th>Month</th>
                <th>Estimated Revenue</th>
                <th></th>
                <th>Actual Revenue</th>
                <th></th>
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

             $janestimate = "-";
             $febestimate = "-";   
             $marestimate = "-";
             $aprestimate = "-";
             $mayestimate = "-";
             $junestimate = "-";
             $julestimate = "-";
             $augestimate ="-";
             $sepestimate = "-";
             $octestimate ="-";
             $novestimate = "-";
             $decestimate = "-";
           
           $revenueobject = new Revenue();
           $revenueobj =$revenueobject->searchRevenueEstLog($company,$year,"estimatedrev");
           $revenueobj2 =$revenueobject->searchRevenueActLog($company,$year,"actualrev");
        
           $view .=
            "
           <tbody>
             <tr style='text-align:center;'>
               <td><b>January</b> </td>
               <td>".$janestimate."</td>
               <td> </td>
               <td>".$janactual."</td>
               <td> <a href ='#janactual' class='' data-toggle='modal' data-target='#janactual' ><i class='fas fa-history'></i> </a></td>

               <div class='modal fade' id='janestimated'>
               <div class='modal-dialog modal-lg'>
               <div class='modal-content' style='padding: 70px'>

               <div class='modal-header'>
                  <h6 class='modal-title'> History</h6>
                  <button type='button' class='close' data-dismiss='modal'>&times;</button>
               </div>
               <div class='modal-body' >
               <div class='form-group'>
                  <label><b>Estimated Revenue</b></label><br>
                             ";
                if ($revenueobj){
                    $prevjan="";

                    foreach($revenueobj as $row){
                      $janlog= $row->januaryLog;
                      $janaction=$row->action;
                      $jantime=$row->time;
                      $currentjan=$janlog;
                      $curjanaction=$janaction;
                      $curjantime=$jantime;

                     if($currentjan==$prevjan){
                          $show="";
                      }
                      else {
                          $show="<label>".$curjanaction." on ".$curjantime." : " .$currentjan."</label><br>";
                           }
                          $prevjan=$currentjan;
                          $view.= $show;
                      }
                      }
                          $view.="
                           
                   <br>
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
                       
                    <label><b>Actual Revenue</b></label><br>
                                ";
                                          if ($revenueobj2){
                                            $prevjan2="";

                                           foreach($revenueobj2 as $row2){
                                            $janlog2= $row2->januaryLog;
                                            $janaction2=$row2->action;
                                            $jantime2=$row2->time;
                                            $currentjan2=$janlog2;
                                            $curjanaction2=$janaction2;
                                            $curjantime2=$jantime2;

                                            if($currentjan2==$prevjan2){
                                              $show="";
                                            }
                                            else {
                                              $show="<label>".$curjanaction2." on ".$curjantime2." : " .$currentjan2."</label><br>";
                                            }
                                            $prevjan2=$currentjan2;
                                            $view.= $show;

                                            }
                                           }
                                   
              
                                
                             $view.="
                          
                                   
                      <br>
                         </div>
                       </div>
                     </div>
                   </div>
                   </div>   
           </tr>
           <tr style='text-align:center;'>
             <td><b>February</b> </td>
             <td>".$febestimate."</td>
             <td> </td>
             <td>".$febactual."</td>
             <td> <a href ='#febactual' class='' data-toggle='modal' data-target='#febactual' ><i class='fas fa-history'></i> </a></td>

             <div class='modal fade' id='febestimated'>
               <div class='modal-dialog modal-lg'>
                 <div class='modal-content' style='padding: 70px'>

                   <div class='modal-header'>
                     <h6 class='modal-title'> History</h6>
                     <button type='button' class='close' data-dismiss='modal'>&times;</button>
                   </div>
                   <div class='modal-body' >
                     <div class='form-group'>
                   
                     
                             <label><b>Estimated Revenue</b></label><br>
                             ";
                                       if ($revenueobj){
                                        $prevfeb="";

                                        foreach($revenueobj as $row){
                                         $feblog= $row->februaryLog;
                                         $febaction=$row->action;
                                         $febtime=$row->time;
                                         $currentfeb=$feblog;
                                         $curfebaction=$febaction;
                                         $curfebtime=$febtime;

                                         if($currentfeb==$prevfeb){
                                           $show="";
                                         }
                                         else {
                                           $show="<label>".$curfebaction." on ".$curfebtime." : " .$currentfeb."</label><br>";
                                         }
                                         $prevfeb=$currentfeb;
                                         $view.= $show;

                                        }
                             }
                          $view.="
                       
                                   
                   <br>
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
                       
                        
                                <label><b>Actual Revenue</b></label><br>
                                ";
                                                    if ($revenueobj2){
                                                     $prevfeb2="";

                                                     foreach($revenueobj2 as $row2){
                                                      $feblog2= $row2->februaryLog;
                                                      $febaction2=$row2->action;
                                                      $febtime2=$row2->time;
                                                      $currentfeb2=$feblog2;
                                                      $curfebaction2=$febaction2;
                                                      $curfebtime2=$febtime2;

                                                      if($currentfeb2==$prevfeb2){
                                                        $show="";
                                                      }
                                                      else {
                                                        $show="<label>".$curfebaction2." on ".$curfebtime2." : " .$currentfeb2."</label><br>";
                                                      }
                                                      $prevfeb2=$currentfeb2;
                                                      $view.= $show;

                                                     }
                                          }
                             $view.="
                          
                                  
                      <br>
                         </div>
                       </div>
                     </div>
                   </div>
                   </div>   
             
           </tr>  

           <tr style='text-align:center;'>
             <td><b>March</b> </td>
             <td>".$marestimate."</td>
             <td> </td>
             <td>".$maractual."</td>
             <td> <a href ='#maractual' class='' data-toggle='modal' data-target='#maractual' ><i class='fas fa-history'></i> </a></td>

             <div class='modal fade' id='marestimated'>
               <div class='modal-dialog modal-lg'>
                 <div class='modal-content' style='padding: 70px'>

                   <div class='modal-header'>
                     <h6 class='modal-title'> History</h6>
                     <button type='button' class='close' data-dismiss='modal'>&times;</button>
                   </div>
                   <div class='modal-body' >
                     <div class='form-group'>
                   
                     
                             <label><b>Estimated Revenue</b></label><br>
                             ";
                                                if ($revenueobj){
                                                 $prevmar="";

                                                 foreach($revenueobj as $row){
                                                  $marlog= $row->marchLog;
                                                  $maraction=$row->action;
                                                  $martime=$row->time;
                                                  $currentmar=$marlog;
                                                  $curmaraction=$maraction;
                                                  $curmartime=$martime;

                                                  if($currentmar==$prevmar){
                                                    $show="";
                                                  }
                                                  else {
                                                    $show="<label>".$curmaraction." on ".$curmartime." : " .$currentmar."</label><br>";
                                                  }
                                                  $prevmar=$currentmar;
                                                  $view.= $show;

                                                 }
                                      }
                          $view.="
                       
                                
                   <br>
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
                      
                        
                                <label><b>Actual Revenue</b></label><br>
                                ";
                                                  if ($revenueobj2){
                                                   $prevmar2="";

                                                   foreach($revenueobj2 as $row2){
                                                    $marlog2= $row2->marchLog;
                                                    $maraction2=$row2->action;
                                                    $martime2=$row2->time;
                                                    $currentmar2=$marlog2;
                                                    $curmaraction2=$maraction2;
                                                    $curmartime2=$martime2;

                                                    if($currentmar2==$prevmar2){
                                                      $show="";
                                                    }
                                                    else {
                                                      $show="<label>".$curmaraction2." on ".$curmartime2." : " .$currentmar2."</label><br>";
                                                    }
                                                    $prevmar2=$currentmar2;
                                                    $view.= $show;

                                                   }
                                        }
                             $view.="
                          
                                 
                      <br>
                         </div>
                       </div>
                     </div>
                   </div>
                   </div>   
           </tr>  

           <tr style='text-align:center;'>
             <td><b>April</b> </td>
             <td>".$aprestimate."</td>
             <td> </td>
             <td>".$apractual."</td>
             <td> <a href ='#apractual' class='' data-toggle='modal' data-target='#apractual' ><i class='fas fa-history'></i> </a></td>

             <div class='modal fade' id='aprestimated'>
               <div class='modal-dialog modal-lg'>
                 <div class='modal-content' style='padding: 70px'>

                   <div class='modal-header'>
                     <h6 class='modal-title'> History</h6>
                     <button type='button' class='close' data-dismiss='modal'>&times;</button>
                   </div>
                   <div class='modal-body' >
                     <div class='form-group'>
                  
                     
                             <label><b>Estimated Revenue</b></label><br>
                             ";
                                                 if ($revenueobj){
                                                  $prevapr="";

                                                  foreach($revenueobj as $row){
                                                   $aprlog= $row->aprilLog;
                                                   $apraction=$row->action;
                                                   $aprtime=$row->time;
                                                   $currentapr=$aprlog;
                                                   $curapraction=$apraction;
                                                   $curaprtime=$aprtime;

                                                   if($currentapr==$prevapr){
                                                     $show="";
                                                   }
                                                   else {
                                                     $show="<label>".$curapraction." on ".$curaprtime." : " .$currentapr."</label><br>";
                                                   }
                                                   $prevapr=$currentapr;
                                                   $view.= $show;

                                                  }
                                       }
                          $view.="
                       
                               
                   <br>
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
                      
                        
                                <label><b>Actual Revenue</b></label><br>
                                ";
                                                    if ($revenueobj2){
                                                     $prevapr2="";

                                                     foreach($revenueobj2 as $row2){
                                                      $aprlog2= $row2->aprilLog;
                                                      $apraction2=$row2->action;
                                                      $aprtime2=$row2->time;
                                                      $currentapr2=$aprlog2;
                                                      $curapraction2=$apraction2;
                                                      $curaprtime2=$aprtime2;

                                                      if($currentapr2==$prevapr2){
                                                        $show="";
                                                      }
                                                      else {
                                                        $show="<label>".$curapraction2." on ".$curaprtime2." : " .$currentapr2."</label><br>";
                                                      }
                                                      $prevapr2=$currentapr2;
                                                      $view.= $show;

                                                     }
                                          }
                             $view.="
                          
                                  
                      <br>
                         </div>
                       </div>
                     </div>
                   </div>
                   </div>   
           </tr>  

           <tr style='text-align:center;'>
             <td><b>May</b> </td>
             <td>".$mayestimate."</td>
             <td> </td>
             <td>".$mayactual."</td>
             <td> <a href ='#mayactual' class='' data-toggle='modal' data-target='#mayactual' ><i class='fas fa-history'></i> </a></td>

             <div class='modal fade' id='mayestimated'>
               <div class='modal-dialog modal-lg'>
                 <div class='modal-content' style='padding: 70px'>

                   <div class='modal-header'>
                     <h6 class='modal-title'> History</h6>
                     <button type='button' class='close' data-dismiss='modal'>&times;</button>
                   </div>
                   <div class='modal-body' >
                     <div class='form-group'>
                  
                     
                             <label><b>Estimated Revenue</b></label><br>
                             ";
                                                if ($revenueobj){
                                                 $prevmay="";

                                                 foreach($revenueobj as $row){
                                                  $maylog= $row->mayLog;
                                                  $mayaction=$row->action;
                                                  $maytime=$row->time;
                                                  $currentmay=$maylog;
                                                  $curmayaction=$mayaction;
                                                  $curmaytime=$maytime;

                                                  if($currentmay==$prevmay){
                                                    $show="";
                                                  }
                                                  else {
                                                    $show="<label>".$curmayaction." on ".$curmaytime." : " .$currentmay."</label><br>";
                                                  }
                                                  $prevmay=$currentmay;
                                                  $view.= $show;

                                                 }
                                      }
                          $view.="
                       
                               
                   <br>
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
                       
                        
                                <label><b>Actual Revenue</b></label><br>
                                ";
                                                 if ($revenueobj2){
                                                  $prevmay2="";

                                                  foreach($revenueobj2 as $row2){
                                                   $maylog2= $row2->mayLog;
                                                   $mayaction2=$row2->action;
                                                   $maytime2=$row2->time;
                                                   $currentmay2=$maylog2;
                                                   $curmayaction2=$mayaction2;
                                                   $curmaytime2=$maytime2;

                                                   if($currentmay2==$prevmay2){
                                                     $show="";
                                                   }
                                                   else {
                                                     $show="<label>".$curmayaction2." on ".$curmaytime2." : " .$currentmay2."</label><br>";
                                                   }
                                                   $prevmay2=$currentmay2;
                                                   $view.= $show;

                                                  }
                                       }
                             $view.="
                          
                                   
                      <br>
                         </div>
                       </div>
                     </div>
                   </div>
                   </div>   
                        
           </tr>  

           <tr style='text-align:center;'>
             <td><b>June</b> </td>
             <td>".$junestimate."</td>
             <td> </td>
             <td>".$junactual."</td>
             <td> <a href ='#junactual' class='' data-toggle='modal' data-target='#junactual' ><i class='fas fa-history'></i> </a></td>

             <div class='modal fade' id='junestimated'>
               <div class='modal-dialog modal-lg'>
                 <div class='modal-content' style='padding: 70px'>

                   <div class='modal-header'>
                     <h6 class='modal-title'> History</h6>
                     <button type='button' class='close' data-dismiss='modal'>&times;</button>
                   </div>
                   <div class='modal-body' >
                     <div class='form-group'>
                
                     
                             <label><b>Estimated Revenue</b></label><br>
                             ";
                                               if ($revenueobj){
                                                $prevjun="";

                                                foreach($revenueobj as $row){
                                                 $junlog= $row->juneLog;
                                                 $junaction=$row->action;
                                                 $juntime=$row->time;
                                                 $currentjun=$junlog;
                                                 $curjunaction=$junaction;
                                                 $curjuntime=$juntime;

                                                 if($currentjun==$prevjun){
                                                   $show="";
                                                 }
                                                 else {
                                                   $show="<label>".$curjunaction." on ".$curjuntime." : " .$currentjun."</label><br>";
                                                 }
                                                 $prevjun=$currentjun;
                                                 $view.= $show;

                                                }
                                     }
                          $view.="
                       
                           
                   <br>
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
              >
                        
                                <label><b>Actual Revenue</b></label><br>
                                ";
                                                 if ($revenueobj2){
                                                  $prevjun2="";

                                                  foreach($revenueobj2 as $row2){
                                                   $junlog2= $row2->juneLog;
                                                   $junaction2=$row2->action;
                                                   $juntime2=$row2->time;
                                                   $currentjun2=$junlog2;
                                                   $curjunaction2=$junaction2;
                                                   $curjuntime2=$juntime2;

                                                   if($currentjun2==$prevjun2){
                                                     $show="";
                                                   }
                                                   else {
                                                     $show="<label>".$curjunaction2." on ".$curjuntime2." : " .$currentjun2."</label><br>";
                                                   }
                                                   $prevjun2=$currentjun2;
                                                   $view.= $show;

                                                  }
                                       }
                             $view.="
                          
                                
                      <br>
                         </div>
                       </div>
                     </div>
                   </div>
                   </div>   
           </tr>  

           <tr style='text-align:center;'>
             <td><b>July</b> </td>
             <td>".$julestimate."</td>
             <td> </td>
             <td>".$julactual."</td>
             <td> <a href ='#julactual' class='' data-toggle='modal' data-target='#julactual' ><i class='fas fa-history'></i> </a></td>

            <div class='modal fade' id='julestimated'>
              <div class='modal-dialog modal-lg'>
                <div class='modal-content' style='padding: 70px'>

                  <div class='modal-header'>
                    <h6 class='modal-title'> History</h6>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                  </div>
                  <div class='modal-body' >
                    <div class='form-group'>
                   
                    
                            <label><b>Estimated Revenue</b></label><br>
                            ";
                                               if ($revenueobj){
                                                $prevjul="";

                                                foreach($revenueobj as $row){
                                                 $jullog= $row->julyLog;
                                                 $julaction=$row->action;
                                                 $jultime=$row->time;
                                                 $currentjul=$jullog;
                                                 $curjulaction=$julaction;
                                                 $curjultime=$jultime;

                                                 if($currentjul==$prevjul){
                                                   $show="";
                                                 }
                                                 else {
                                                   $show="<label>".$curjulaction." on ".$curjultime." : " .$currentjul."</label><br>";
                                                 }
                                                 $prevjul=$currentjul;
                                                 $view.= $show;

                                                }
                                     }
                         $view.="
                      
                                  
                  <br>
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
                  
                       
                               <label><b>Actual Revenue</b></label><br>
                               ";
                                                if ($revenueobj2){
                                                 $prevjul2="";

                                                 foreach($revenueobj2 as $row2){
                                                  $jullog2= $row2->julyLog;
                                                  $julaction2=$row2->action;
                                                  $jultime2=$row2->time;
                                                  $currentjul2=$jullog2;
                                                  $curjulaction2=$julaction2;
                                                  $curjultime2=$jultime2;

                                                  if($currentjul2==$prevjul2){
                                                    $show="";
                                                  }
                                                  else {
                                                    $show="<label>".$curjulaction2." on ".$curjultime2." : " .$currentjul2."</label><br>";
                                                  }
                                                  $prevjul2=$currentjul2;
                                                  $view.= $show;

                                                 }
                                      }
                            $view.="
                         
                                   
                     <br>
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>   
                        
           </tr>  

           <tr style='text-align:center;'>
             <td><b>August</b> </td>
             <td>".$augestimate."</td>
             <td> </td>
             <td>".$augactual."</td>
             <td> <a href ='#augactual' class='' data-toggle='modal' data-target='#augactual' ><i class='fas fa-history'></i> </a></td>

            <div class='modal fade' id='augestimated'>
              <div class='modal-dialog modal-lg'>
                <div class='modal-content' style='padding: 70px'>

                  <div class='modal-header'>
                    <h6 class='modal-title'> History</h6>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                  </div>
                  <div class='modal-body' >
                    <div class='form-group'>
                 
                    
                            <label><b>Estimated Revenue</b></label><br>
                            ";
                                               if ($revenueobj){
                                                $prevaug="";

                                                foreach($revenueobj as $row){
                                                 $auglog= $row->augustLog;
                                                 $augaction=$row->action;
                                                 $augtime=$row->time;
                                                 $currentaug=$auglog;
                                                 $curaugaction=$augaction;
                                                 $curaugtime=$augtime;

                                                 if($currentaug==$prevaug){
                                                   $show="";
                                                 }
                                                 else {
                                                   $show="<label>".$curaugaction." on ".$curaugtime." : " .$currentaug."</label><br>";
                                                 }
                                                 $prevaug=$currentaug;
                                                 $view.= $show;

                                                }
                                     }
                         $view.="
                      
                               
                  <br>
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
                      
                       
                               <label><b>Actual Revenue</b></label><br>
                               ";
                                            if ($revenueobj2){
                                             $prevaug2="";

                                             foreach($revenueobj2 as $row2){
                                              $auglog2= $row2->augustLog;
                                              $augaction2=$row2->action;
                                              $augtime2=$row2->time;
                                              $currentaug2=$auglog2;
                                              $curaugaction2=$augaction2;
                                              $curaugtime2=$augtime2;

                                              if($currentaug2==$prevaug2){
                                                $show="";
                                              }
                                              else {
                                                $show="<label>".$curaugaction2." on ".$curaugtime2." : " .$currentaug2."</label><br>";
                                              }
                                              $prevaug2=$currentaug2;
                                              $view.= $show;

                                             }
                                  }
                            $view.="
                         
                                     
                     <br>
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>   
                        
           </tr>  

           <tr style='text-align:center;'>
             <td><b>September</b> </td>
             <td>".$sepestimate."</td>
             <td> </td>
             <td>".$sepactual."</td>
             <td> <a href ='#sepactual' class='' data-toggle='modal' data-target='#sepactual' ><i class='fas fa-history'></i> </a></td>

            <div class='modal fade' id='sepestimated'>
              <div class='modal-dialog modal-lg'>
                <div class='modal-content' style='padding: 70px'>

                  <div class='modal-header'>
                    <h6 class='modal-title'> History</h6>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                  </div>
                  <div class='modal-body' >
                    <div class='form-group'>
                    
                    
                            <label><b>Estimated Revenue</b></label><br>
                            ";
                                            if ($revenueobj){
                                             $prevsep="";

                                             foreach($revenueobj as $row){
                                              $seplog= $row->septemberLog;
                                              $sepaction=$row->action;
                                              $septime=$row->time;
                                              $currentsep=$seplog;
                                              $cursepaction=$sepaction;
                                              $curseptime=$septime;

                                              if($currentsep==$prevsep){
                                                $show="";
                                              }
                                              else {
                                                $show="<label>".$cursepaction." on ".$curseptime." : " .$currentsep."</label><br>";
                                              }
                                              $prevsep=$currentsep;
                                              $view.= $show;

                                             }
                                  }
                         $view.="
                      
                            
                  <br>
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
                     
                       
                               <label><b>Actual Revenue</b></label><br>
                               ";
                                             if ($revenueobj2){
                                              $prevsep2="";

                                              foreach($revenueobj2 as $row2){
                                               $seplog2= $row2->septemberLog;
                                               $sepaction2=$row2->action;
                                               $septime2=$row2->time;
                                               $currentsep2=$seplog2;
                                               $cursepaction2=$sepaction2;
                                               $curseptime2=$septime2;

                                               if($currentsep2==$prevsep2){
                                                 $show="";
                                               }
                                               else {
                                                 $show="<label>".$cursepaction2." on ".$curseptime2." : " .$currentsep2."</label><br>";
                                               }
                                               $prevsep2=$currentsep2;
                                               $view.= $show;

                                              }
                                   }
                            $view.="
                         
                                   
                     <br>
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>   
           </tr>  

           <tr style='text-align:center;'>
             <td><b>October</b> </td>
             <td>".$octestimate."</td>
             <td> </td>
             <td>".$octactual."</td>
             <td> <a href ='#octactual' class='' data-toggle='modal' data-target='#octactual' ><i class='fas fa-history'></i> </a></td>

            <div class='modal fade' id='octestimated'>
              <div class='modal-dialog modal-lg'>
                <div class='modal-content' style='padding: 70px'>

                  <div class='modal-header'>
                    <h6 class='modal-title'> History</h6>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                  </div>
                  <div class='modal-body' >
                    <div class='form-group'>
                   
                    
                            <label><b>Estimated Revenue</b></label><br>
                            ";
                                             if ($revenueobj){
                                              $prevoct="";

                                              foreach($revenueobj as $row){
                                               $octlog= $row->octoberLog;
                                               $octaction=$row->action;
                                               $octtime=$row->time;
                                               $currentoct=$octlog;
                                               $curoctaction=$octaction;
                                               $curocttime=$octtime;

                                               if($currentoct==$prevoct){
                                                 $show="";
                                               }
                                               else {
                                                 $show="<label>".$curoctaction." on ".$curocttime." : " .$currentoct."</label><br>";
                                               }
                                               $prevoct=$currentoct;
                                               $view.= $show;

                                              }
                                   }
                         $view.="
                      
                             
                  <br>
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
                      
                       
                               <label><b>Actual Revenue</b></label><br>
                               ";
                                            if ($revenueobj2){
                                             $prevoct2="";

                                             foreach($revenueobj2 as $row2){
                                              $octlog2= $row2->octoberLog;
                                              $octaction2=$row2->action;
                                              $octtime2=$row2->time;
                                              $currentoct2=$octlog2;
                                              $curoctaction2=$octaction2;
                                              $curocttime2=$octtime2;

                                              if($currentoct2==$prevoct2){
                                                $show="";
                                              }
                                              else {
                                                $show="<label>".$curoctaction2." on ".$curocttime2." : " .$currentoct2."</label><br>";
                                              }
                                              $prevoct2=$currentoct2;
                                              $view.= $show;

                                             }
                                  }
                            $view.="
                         
                                 
                     <br>
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>   
                        
           </tr>  

           <tr style='text-align:center;'>
             <td><b>November</b> </td>
             <td>".$novestimate."</td>
             <td> </td>
             <td>".$novactual."</td>
             <td> <a href ='#novactual' class='' data-toggle='modal' data-target='#novactual' ><i class='fas fa-history'></i> </a></td>

           <div class='modal fade' id='novestimated'>
             <div class='modal-dialog modal-lg'>
               <div class='modal-content' style='padding: 70px'>

                 <div class='modal-header'>
                   <h6 class='modal-title'> History</h6>
                   <button type='button' class='close' data-dismiss='modal'>&times;</button>
                 </div>
                 <div class='modal-body' >
                   <div class='form-group'>
                  
                   
                           <label><b>Estimated Revenue</b></label><br>
                           ";
                                       if ($revenueobj){
                                        $prevnov="";

                                        foreach($revenueobj as $row){
                                         $novlog= $row->novemberLog;
                                         $novaction=$row->action;
                                         $novtime=$row->time;
                                         $currentnov=$novlog;
                                         $curnovaction=$novaction;
                                         $curnovtime=$novtime;

                                         if($currentnov==$prevnov){
                                           $show="";
                                         }
                                         else {
                                           $show="<label>".$curnovaction." on ".$curnovtime." : " .$currentnov."</label><br>";
                                         }
                                         $prevnov=$currentnov;
                                         $view.= $show;

                                        }
                             }
                        $view.="
                     
                                
                 <br>
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
                     
                      
                              <label><b>Actual Revenue</b></label><br>
                              ";
                                       if ($revenueobj2){
                                        $prevnov2="";

                                        foreach($revenueobj2 as $row2){
                                         $novlog2= $row->novemberLog;
                                         $novaction2=$row->action;
                                         $novtime2=$row->time;
                                         $currentnov2=$novlog2;
                                         $curnovaction2=$novaction2;
                                         $curnovtime2=$novtime2;

                                         if($currentnov2==$prevnov2){
                                           $show="";
                                         }
                                         else {
                                           $show="<label>".$curnovaction2." on ".$curnovtime2." : " .$currentnov2."</label><br>";
                                         }
                                         $prevnov2=$currentnov2;
                                         $view.= $show;

                                        }
                             }
                           $view.="
                        
                                 
                    <br>
                       </div>
                     </div>
                   </div>
                 </div>
                 </div>   
                        
           </tr>  

           <tr style='text-align:center;'>
             <td><b>December</b> </td>
             <td>".$decestimate."</td>
             <td> </td>
             <td>".$decactual."</td>
             <td> <a href ='#decactual' class='' data-toggle='modal' data-target='#decactual' ><i class='fas fa-history'></i> </a></td>
             <div class='modal fade' id='decestimated'>
               <div class='modal-dialog modal-lg'>
                 <div class='modal-content' style='padding: 70px'>

                   <div class='modal-header'>
                     <h6 class='modal-title'> History</h6>
                     <button type='button' class='close' data-dismiss='modal'>&times;</button>
                   </div>
                   <div class='modal-body' >
                     <div class='form-group'>
                     
                     
                             <label><b>Estimated Revenue</b></label><br>
                             ";
                             if ($revenueobj){
                               $prevdec="";

                               foreach($revenueobj as $row){
                                $declog= $row->decemberLog;
                                $decaction=$row->action;
                                $dectime=$row->time;
                                $currentdec=$declog;
                                $curdecaction=$decaction;
                                $curdectime=$dectime;

                                if($currentdec==$prevdec){
                                  $show="";
                                }
                                else {
                                  $show="<label>".$curdecaction." on ".$curdectime." : " .$currentdec."</label><br>";
                                }
                                $prevdec=$currentdec;
                                $view.= $show;

                              }
                            }
                          $view.="
                       
                                  
                   <br>
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
                       
                        
                                <label><b>Actual Revenue</b></label><br>
                                ";
                                if ($revenueobj2){
                                 $prevdec2="";

                                 foreach($revenueobj2 as $row2){
                                  $declog2= $row2->decemberLog;
                                  $decaction2=$row2->action;
                                  $dectime2=$row2->time;
                                  $currentdec2=$declog2;
                                  $curdecaction2=$decaction2;
                                  $curdectime2=$dectime2;

                                  if($currentdec2==$prevdec2){
                                    $show="";
                                  }
                                  else {
                                    $show="<label>".$curdecaction2." on ".$curdectime2." : " .$currentdec2."</label><br>";
                                  }
                                  $prevdec2=$currentdec2;
                                  $view.= $show;

                                }
                              }
                             $view.="
                          
                               
                      <br>
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


        elseif($data==null && $data2==null){
          $view .= 
          "
          <div class='col-xl-12 col-6 text-right'>
            <button type='button' class='btn btn-primary shadow-sm saverev1 ' data-toggle='modal' data-backdrop='static' data-target='#addRevenue'><i class='fas fa-plus'></i> Add Revenue</button>
          </div><br>

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