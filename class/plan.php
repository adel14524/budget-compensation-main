<?php
class Plan{
	private $_data,
			$_db,
			$_id;
	
	public function __construct($id = null){
		$this->_db = Database::getInstance();
	}

	public function lastinsertid(){
		return $this->_db->lastInsertId();
	}

	public function data(){
		return $this->_data;
	}
	
	public static function exists(){
		return (!empty($this->_data)) ? true : false;
	}
	
	public function addPlan($fields = array()){
		if(!$this->_db->insert('plan', $fields)) {
		  throw new Exception('There was a problem adding a plan.');
		}
	}
	
	public function updatePlan($fields = array(), $id = null, $planID){
		if (!$this->_db->update('plan', $id, $fields, $planID)) {
		  throw new Exception('There was a problem updating plan.');
		}
	}

	public function searchOnlyPlan($id = null){
		if($id){
			$field = "planID";
			$data = $this->_db->get('plan', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchPlan($ID = null){
		if($ID){
			$field = (is_numeric($ID)) ? 'userID' : 'objective';
			$data = $this->_db->get('plan', array($field, '=', $ID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchPlanStatus($userID = null, $status = null, $startdate = null, $enddate = null){
		if($userID && $status && $startdate && $enddate){
			$userIDfield = 'userID';
			$statusfield = 'status';
			$startdatefield = 'startdate';
			$enddatefield = 'enddate';

			
			
			$data = $this->_db->get3_1('plan', array($userIDfield, '=', $userID), array($statusfield, '=', $status), array($startdatefield, '>=', $startdate), array($startdatefield, '<=', $enddate), array($enddatefield, '>=', $startdate), array($enddatefield, '<=', $enddate));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchPlanCorporate($ID = null){
		if($ID){
			$field = (is_numeric($ID)) ? 'corporateID' : 'objective';
			$data = $this->_db->get('plan', array($field, '=', $ID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchPlanCompany($ID = null){
		if($ID){
			$field = (is_numeric($ID)) ? 'companyID' : 'objective';
			$data = $this->_db->get('plan', array($field, '=', $ID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchPlanGroup($ID = null){
		if($ID){
			$field = (is_numeric($ID)) ? 'groupID' : 'objective';
			$data = $this->_db->get('plan', array($field, '=', $ID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}
	
	public function deletePlan($planID = null){
		if($planID){
			$field = (is_numeric($planID)) ? 'planID' : 'name';
			$data = $this->_db->delete('plan', array($field, '=', $planID));
			return $data;
		}
		return false;
	}
}
?>