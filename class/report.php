<?php
class Report{
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

	public function submitReport($fields= array()){
		if(!$this->_db->insert('report', $fields)) {
		  throw new Exception('There was a problem submit report.');
		}
	}

	public function searchReport($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'reportID' : 'objective';
			$data = $this->_db->get('report', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function evaluateReport($fields = array(), $id = null, $reportID){
		if (!$this->_db->update('report', $id, $fields, $reportID)) {
		  throw new Exception('There was a problem evaluate report.');
		}
	}

	public function searchReportThisWeek($userID = null, $week = null, $year = null){
		if($week && $userID && $year){
			$data = $this->_db->get2('report', array("week", '=', $week), array("userID", '=', $userID), array("year", '=', $year));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchReportBasedCorporate($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'corporateID' : 'objective';
			$data = $this->_db->get('report', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchReportBasedCorporateEvaluated($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'corporateID' : 'objective';
			$data = $this->_db->getOne('report', array($field, '=', $id), array("supervisorevaluate", "=", "Evaluated"));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchReportBasedCompany($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'companyID' : 'objective';
			$data = $this->_db->get('report', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchReportBasedCompanyEvaluated($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'companyID' : 'objective';
			$data = $this->_db->getOne('report', array($field, '=', $id), array("supervisorevaluate", "=", "Evaluated"));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchReportSupervisor($id = null, $week = null, $year = null){
		if($id){
			$field = (is_numeric($id)) ? 'tosupervisor' : 'objective';
			$fieldweek = "week";
			$fieldyear = "year";
			$data = $this->_db->get2('report', array($field, '=', $id), array($fieldweek, '=', $week), array($fieldyear, '=', $year));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchReportBetweenDate($id = null, $start = null, $end = null){
		if($id){
			$field = (is_numeric($id)) ? 'tosupervisor' : 'objective';
			$fieldbetween = "submitat";
			$data = $this->_db->get2('report', array($field, '=', $id), array($fieldbetween, '>', $start), array($fieldbetween, '<', $end));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchReportReview($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'supervisorevaluate' : 'objective';
			$data = $this->_db->get('report', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchReportOwner($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'userID' : 'objective';
			$data = $this->_db->getDesc('report', array($field, '=', $id), "submitat");
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

}
?>