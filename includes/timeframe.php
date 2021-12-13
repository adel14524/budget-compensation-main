<div class="col-3">
  <?php     
    $date = date("Y-m-d H:i:s");
    $timeframeobject = new Timeframe();
    if($resultresult->corporateID){
      $timeframetypeid = $resultresult->corporateID;
      $timeframeresult = $timeframeobject->searchCorporateTimeframe($timeframetypeid);
    }else{
      $timeframetypeid = $resultresult->companyID;
      $timeframeresult = $timeframeobject->searchCompanyTimeframe($timeframetypeid);
    }
  ?>
  <div class="form-group">
    <select class="form-control selectpicker border shadow-sm" id="filter">
      <?php
      foreach ($timeframeresult as $row) {
        if($date >= $row->startdate && $date <= $row->enddate){
          ?>
          <option value="<?php echo $row->timeframeid;?>" selected><?php echo $row->timeframe;?></option>
          <?php
          $timeframespecificid = $row->timeframeid;
        }else{
          ?>
          <option value="<?php echo $row->timeframeid;?>"><?php echo $row->timeframe;?></option>
          <?php
        }
      ?>
      
      <?php
      }

      ?>
    </select>
  </div> 
</div>