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

  $mainobject = new Mainallocation();
  $data = $mainobject->searchmainallocation($company,$year);

  if($data){
   
}
  $view="";
  if($data){
        $view.= 
        "
      <br><br>
      <div class='table-responsive-sm text-nowrap'>

      <table class='table' >
        <thead>
          <tr style='background-color:lightgrey;'>
            <th scope='col'>Category</th>
            <th scope='col'>JAN</th>
            <th scope='col'>FEB</th>
            <th scope='col'>MAR</th>
            <th scope='col'>APR</th>
            <th scope='col'>MAY</th>
            <th scope='col'>JUN</th>
            <th scope='col'>JUL</th>
            <th scope='col'>AUG</th>
            <th scope='col'>SEP</th>
            <th scope='col'>OCT</th>
            <th scope='col'>NOV</th>
            <th scope='col'>DEC</th>
            <th scope='col'>TOTAL</th>
          </tr>
        </thead>
        ";
        $monthlyb=0;
        $monthlyo=0;
        $totalb=0;
        $totalo=0;
        foreach ($data as $row) {
          $total2=0;
          $total3=0;
         
        if($row->categoryName==="Bonus")
        { 
        
          $catName= $row->categoryName;
          $monthly = round(($row->budgetAllocated)/12);
          $monthlyb = ($row->budgetAllocated)/12;
           /*print_r($monthlyb);*/
          $total =$row->budgetAllocated;
          $totalb =$row->budgetAllocated;
          $view .=
          "
                            <tbody>
                              <tr >
                                <td>".$catName."</td>
                                <td>".$monthly."</td>
                                <td>".$monthly."</td>
                                <td>".$monthly."</td>
                                <td>".$monthly."</td>
                                <td>".$monthly."</td>
                                <td>".$monthly."</td>
                                <td>".$monthly."</td>
                                <td>".$monthly."</td>
                                <td>".$monthly."</td>
                                <td>".$monthly."</td>
                                <td>".$monthly."</td>
                                <td>".$monthly."</td>
                                <td>".$total."</td>
                              </tr>
                              ";
              }
      if($row->categoryName==="Others")
      {

        $suballocationobject = new Suballocation();
        $data1 = $suballocationobject->searchsub1($row->budgetMainAllocationID);
        $totalo=0;
        $monthlyo=0;
        if($data1)
        {
         foreach ($data1 as $abc) {

         $catName= $abc->categoryName;
         $dataresult=$abc->budgetAllocated;
         $monthly = round($dataresult/12);
         $monthlyo+= $dataresult/12;
        /* print_r($monthlyo);*/
         $total=$dataresult;
         $totalo+=$dataresult;

         $view .=
         "
                           <tbody>
                             <tr >
                               <td>".$catName."</td>
                               <td>".$monthly."</td>
                               <td>".$monthly."</td>
                               <td>".$monthly."</td>
                               <td>".$monthly."</td>
                               <td>".$monthly."</td>
                               <td>".$monthly."</td>
                               <td>".$monthly."</td>
                               <td>".$monthly."</td>
                               <td>".$monthly."</td>
                               <td>".$monthly."</td>
                               <td>".$monthly."</td>
                               <td>".$monthly."</td>
                               <td>".$total."</td>
                             </tr>
                             ";         }
       
        }
      }
    $grandtotal2=$totalb+$totalo;
    }
    $grandtotal=round(floatval($monthlyb)+floatval($monthlyo));
   /* print_r($monthlyo);*/
   
$view.=
"<tr >
                      <td>GRAND TOTAL</td>
                      <td>".$grandtotal."</td>
                      <td>".$grandtotal."</td>
                      <td>".$grandtotal."</td>
                      <td>".$grandtotal."</td>
                      <td>".$grandtotal."</td>
                      <td>".$grandtotal."</td>
                      <td>".$grandtotal."</td>
                      <td>".$grandtotal."</td>
                      <td>".$grandtotal."</td>
                      <td>".$grandtotal."</td>
                      <td>".$grandtotal."</td>
                      <td>".$grandtotal."</td>
                      <td>".$grandtotal2."</td>
                    </tr>
                 </tbody>
               </table>
               </div>
               ";}
               
               else{
          $view .= 
          "<br>
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