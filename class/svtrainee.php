<?php
class Svtrainee{
	private $_data,
			$_db;
	
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

	public function addtrainee($fields = array()){
		if(!$this->_db->insert('report_sv_trainee', $fields)) {
		  throw new Exception('There was a problem create a relationship between SV and trainee.');
		}
	}

	public function addsvtraineerelationship($fields = array()){
		if(!$this->_db->insert('report_sv_trainee_approval', $fields)) {
		  throw new Exception('There was a problem create a relationship between SV and trainee.');
		}
	}

	public function updateTrainee($fields = array(), $id = null, $traineeID){
		if (!$this->_db->update('report_sv_trainee', $id, $fields, $traineeID)) {
		  throw new Exception('There was a problem updating trainee settings.');
		}
	}

	public function updatesvtraineerelationship($fields = array(), $id = null, $svtraineeID){
		if (!$this->_db->update('report_sv_trainee_approval', $id, $fields, $svtraineeID)) {
		  throw new Exception('There was a problem updating SV and trainee relationship.');
		}
	}

	public function deleteTrainee($traineeID = null){
		if($traineeID){
			$field = (is_numeric($traineeID)) ? 'sv_traineeID' : 'name';
			$data = $this->_db->delete('report_sv_trainee', array($field, '=', $traineeID));
			return $data;
		}
		return false;
	}

	public function searchAllTrainee($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'supervisorID' : 'keyresult';
			$data = $this->_db->get('report_sv_trainee', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchAllTraineeApproval($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'userID' : 'keyresult';
			$data = $this->_db->get('report_sv_trainee_approval', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchAllTraineeApprovalSV($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'supervisorID' : 'keyresult';
			$data = $this->_db->get('report_sv_trainee_approval', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchAllSupervisor($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'userID' : 'keyresult';
			$data = $this->_db->get('report_sv_trainee', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchAllBecomeTraineeCorporate($id = null, $role = null){
		if($id){
			$data = $this->_db->get2('user', array("corporateID", '=', $id), array("status", '=', "Active"), array("role", '=', $role));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchAllBecomeTraineeCompany($id = null, $role = null){
		if($id){
			$data = $this->_db->get2('user', array("companyID", '=', $id), array("status", '=', "Active"), array("role", '=', $role));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchOnlyTrainee($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'sv_traineeID' : 'keyresult';
			$data = $this->_db->get('report_sv_trainee', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchOnlyTraineeSV($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'svtraineeapprovalID' : 'keyresult';
			$data = $this->_db->get('report_sv_trainee_approval', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchSVTrainee($supervisorID = null, $traineeID = null){
		if($supervisorID && $traineeID){
			$supervisorfield = (is_numeric($supervisorID)) ? 'supervisorID' : 'keyresult';
			$traineefield = "userID";
			$data = $this->_db->getOne('report_sv_trainee', array($supervisorfield, '=', $supervisorID), array($traineefield, '=', $traineeID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchSVTraineeApproval($supervisorID = null, $traineeID = null){
		if($supervisorID && $traineeID){
			$supervisorfield = (is_numeric($supervisorID)) ? 'supervisorID' : 'keyresult';
			$traineefield = "userID";
			$data = $this->_db->getOne('report_sv_trainee_approval', array($supervisorfield, '=', $supervisorID), array($traineefield, '=', $traineeID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchSVroleCorporate($corporateID = null, $role = null){
		if($corporateID && $role){
			$corporatefield = "corporateID";
			$rolefield = "role";
			$becomesupervisorfield = "becomesupervisor";
			$statusfield = "status";
			$data = $this->_db->get3('user', array($corporatefield, '=', $corporateID), array($rolefield, '=', $role), array($becomesupervisorfield, '=', true), array($statusfield, '=', "Active"));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchSVroleCompany($companyID = null, $role = null){
		if($companyID && $role){
			$corporatefield = "companyID";
			$rolefield = "role";
			$becomesupervisorfield = "becomesupervisor";
			$statusfield = "status";
			$data = $this->_db->get3('user', array($corporatefield, '=', $companyID), array($rolefield, '=', $role), array($becomesupervisorfield, '=', true), array($statusfield, '=', "Active"));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}
}
?>

