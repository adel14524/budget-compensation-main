<?php
class Objective{
	private $_data,
			$_db;
	
	public function __construct(){
		$this->_db = Database::getInstance();
	}

	public function lastinsertid(){
		return $this->_db->lastInsertId();
	}

	public function data(){
		return $this->_data;
	}

	public function addObjective($fields= array()){
		if(!$this->_db->insert('objective2', $fields)) {
		  throw new Exception('There was a problem adding an objective.');
		}
	}

	public function addObjectiveLog($fields= array()){
		if(!$this->_db->insert('okr_log', $fields)) {
		  throw new Exception('There was a problem adding an OKR log.');
		}
	}

	public function updateObjective($fields = array(), $id = null, $objectiveID){
		if (!$this->_db->update('objective2', $id, $fields, $objectiveID)) {
		  throw new Exception('There was a problem updating objective.');
		}
	}

	public function deleteObjective($objectiveID = null){
		if($objectiveID){
			$field = (is_numeric($objectiveID)) ? 'objectiveID' : 'name';
			$data = $this->_db->delete('objective2', array($field, '=', $objectiveID));
			return $data;
		}
		return false;
	}

	public function searchObjectiveLog($ID = null){
		if($ID){
			$field = (is_numeric($ID)) ? 'objectiveID' : 'objective';
			$data = $this->_db->get('okr_log', array($field, '=', $ID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchOnlyObjective($ID = null){
		if($ID){
			$field = (is_numeric($ID)) ? 'objectiveID' : 'objective';
			$data = $this->_db->get('objective2', array($field, '=', $ID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchObjectiveBasedOnCorporateList($ID = null){
		if($ID){
			$field = (is_numeric($ID)) ? 'corporateID' : 'objective';
			$data = $this->_db->get('objective2', array($field, '=', $ID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchObjectiveBasedOnCorporateListTimeframe($ID = null, $timeframe = null){
		if($ID){
			$field = (is_numeric($ID)) ? 'corporateID' : 'objective';
			$data = $this->_db->getOne('objective2', array($field, '=', $ID), array("timeframeid", '=', $timeframe));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchObjectiveBasedOnCompanyList($ID = null){
		if($ID){
			$field = (is_numeric($ID)) ? 'companyID' : 'objective';
			$data = $this->_db->get('objective2', array($field, '=', $ID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchObjectiveBasedOnCompanyListTimeframe($ID = null, $timeframe = null){
		if($ID){
			$field = (is_numeric($ID)) ? 'companyID' : 'objective';
			$data = $this->_db->getOne('objective2', array($field, '=', $ID), array("timeframeid", '=', $timeframe));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}
	
	public function searchObjectiveBasedOnParentID($parentID){
		if($parentID){
			$field = "parent_id";
			$data = $this->_db->get('objective2', array($field, "=", $parentID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchObjectiveBasedOnCorporateTimeframe($ID = null, $timeframeID = null){
		if($ID && $timeframeID){
			$field = (is_numeric($ID)) ? 'corporateID' : 'objective';
			$fieldtimeframe = "timeframeid";
			$data = $this->_db->get2('objective2', array($field, '=', $ID), array($fieldtimeframe, "=", $timeframeID), array("type", "=", "Corporate"));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchObjectiveBasedOnCompanyTimeframe($ID = null, $timeframeID = null){
		if($ID && $timeframeID){
			$field = (is_numeric($ID)) ? 'companyID' : 'objective';
			$fieldtimeframe = "timeframeid";
			$data = $this->_db->get2('objective2', array($field, '=', $ID), array($fieldtimeframe, "=", $timeframeID), array("type", "=", "Company"));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchObjectiveBasedOnGroupTimeframe($ID = null, $timeframeID = null){
		if($ID && $timeframeID){
			$field = (is_numeric($ID)) ? 'groupID' : 'objective';
			$fieldtimeframe = "timeframeid";
			$data = $this->_db->get2('objective2', array($field, '=', $ID), array($fieldtimeframe, "=", $timeframeID), array("type", "=", "Group"));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchObjectiveBasedOnPersonalTimeframe($ID = null, $timeframeID = null){
		if($ID && $timeframeID){
			$field = (is_numeric($ID)) ? 'userID' : 'objective';
			$fieldtimeframe = "timeframeid";
			$data = $this->_db->get2('objective2', array($field, '=', $ID), array($fieldtimeframe, "=", $timeframeID), array("type", "=", "Personal"));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchObjectiveBasedOnCorporate($ID = null){
		if($ID){
			$field = (is_numeric($ID)) ? 'corporateID' : 'objective';
			$data = $this->_db->get2('objective2', array($field, '=', $ID), array("type", "=", "Corporate"), array("status", "=", "Active"));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchObjectiveBasedOnCompany($ID = null){
		if($ID){
			$field = (is_numeric($ID)) ? 'companyID' : 'objective';
			$data = $this->_db->get2('objective2', array($field, '=', $ID), array("type", "=", "Company"), array("status", "=", "Active"));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchObjectiveBasedOnGroup($ID = null){
		if($ID){
			$field = (is_numeric($ID)) ? 'groupID' : 'objective';
			$data = $this->_db->get2('objective2', array($field, '=', $ID), array("type", "=", "Group"), array("status", "=", "Active"));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchObjectiveBasedOnPersonal($ID = null){
		if($ID){
			$field = (is_numeric($ID)) ? 'userID' : 'objective';
			$data = $this->_db->get2('objective2', array($field, '=', $ID), array("type", "=", "Personal"), array("status", "=", "Active"));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function buildtree($id){
	  $objectiveobject = new Objective();
	  $objectiveresult = $objectiveobject->searchObjectiveBasedOnParentID($id);

	  $arr = [];
	  if($objectiveresult){
	    foreach ($objectiveresult as $row) {
	      $result = $this->buildtree($row->objectiveID);
	      $arr[] = $result;
	    }
	  }
	  $keyresultobject = new Keyresult();
	  $keyresultresult = $keyresultobject->searchKeyresult($id);
	  if($keyresultresult){
	    foreach ($keyresultresult as $row) {
	      $score = (($row->progress-$row->startvalue)/($row->endvalue-$row->startvalue))*100;
	      array_push($arr,$score);
	    }
	  }
	  return $arr;
	}

	public function buildtree2($id, $date = null){
	  $objectiveobject = new Objective();
	  $objectiveresult = $objectiveobject->searchObjectiveBasedOnParentID($id);

	  $arr = [];
	  if($objectiveresult){
	    foreach ($objectiveresult as $row) {
	      $result = $this->buildtree2($row->objectiveID, $date);
	      $arr[] = $result;
	    }
	  }
	  $keyresultobject = new Keyresult();
	  $keyresultresult = $keyresultobject->searchKeyresult($id);
	  if($keyresultresult){
	    foreach ($keyresultresult as $row) {
	    	$keyresultobject3 = new Keyresult();
	    	$logresult = $keyresultobject3->searchKeyresultLog($row->keyresultID, $date);
	      	
	      	if($logresult){
	      		$latestscore = $logresult->latestvalue;
	      		$score = (($latestscore-$row->startvalue)/($row->endvalue-$row->startvalue))*100;
	      		array_push($arr,$score);
	      	}

	    }
	  }
	  return $arr;
	}

	public function getAvg($arr){
	  foreach ($arr as $key => &$value) {
	    if(is_array($value)){
	      $value = $this->getAvg($value);
	    }
	  }
	  if(count($arr) == 0){
	  	$count = 1;
	  }else{
	  	$count = count($arr);
	  }
	  $avg = array_sum($arr)/$count;
	  return $avg;
	}

	public function getOKRscoreweightage($objectiveID){
		$keyresultobject = new Keyresult();
	    $keyresultresult = $keyresultobject->searchKeyresult($objectiveID);
	    if($keyresultresult){
	    	$okrscoretotal = 0;
	    	foreach ($keyresultresult as $row1) {
	    		$krscore = round(($row1->progress - $row1->startvalue) / ($row1->endvalue - $row1->startvalue)*$row1->weightage);
	    		if($krscore >= $row1->weightage){
	    			$krscore = $row1->weightage;
	    		}
	    		$okrscoretotal += $krscore;
	    	}
	    }else{
	    	$okrscoretotal = 0;
	    }
	    return $okrscoretotal;
	}

	public function getOKRscoreweightagetimeframe($objectiveID, $date = null){
		$keyresultobject = new Keyresult();
	    $keyresultresult = $keyresultobject->searchKeyresult($objectiveID);
	    $okrscoretotal = 0;
	    if($keyresultresult){
		    foreach ($keyresultresult as $row) {
		    	$logresult = $keyresultobject->searchKeyresultLog($row->keyresultID, $date);
		      	if($logresult){
		      		$latestscore = $logresult->latestvalue;
		      		$score = (($latestscore-$row->startvalue)/($row->endvalue-$row->startvalue))*$row->weightage;
		      		$okrscoretotal += $score;
		      	}
		    }
		}else{
			$okrscoretotal = 0;
		}
	    return $okrscoretotal;
	}

	public function searchforrootcorporate($objectiveID){
		$objectiveresult = $this->searchOnlyObjective($objectiveID);
		if($objectiveresult){
			if($objectiveresult->parent_id){
				$result = $this->searchforrootcorporate($objectiveresult->parent_id);
				return $result;
			}else{
				return $objectiveresult->type;
			}
		}
		
	}

}
?>