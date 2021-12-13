<?php
class Timeframe{
	private $_data,
			$_db;
	
	public function __construct(){
		$this->_db = Database::getInstance();
	}
	
	public function data(){
		return $this->_data;
	}
	
	public function lastinsertid(){
		return $this->_db->lastInsertId();
	}

	public static function exists($name){
		return (!empty($this->_data)) ? true : false;
	}
	
	public function addTimeframe($fields = array()){
		if(!$this->_db->insert('timeframe', $fields)) {
		  throw new Exception('There was a problem adding a timeframe.');
		}
	}

	public function deleteTimeframe($timeframeID = null){
		if($timeframeID){
			$field = "timeframeid";
			$data = $this->_db->delete('timeframe', array($field, '=', $timeframeID));
			return $data;
		}
		return false;
	}

	public function editTimeframe($fields = array(), $id = null, $dependID = null){
		if (!$this->_db->update('timeframe', $id, $fields, $dependID)) {
		  throw new Exception('There was a problem updating the timeframe.');
		}
	}

	public function searchOnlyTimeframe($timeframeID = null){
		if($timeframeID){
			$field = (is_numeric($timeframeID)) ? 'timeframeid' : 'email';
			$data = $this->_db->get('timeframe', array($field, '=', $timeframeID));
			
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchCorporateTimeframe($corporateID = null){
		if($corporateID){
			$field = (is_numeric($corporateID)) ? 'corporateID' : 'corporate';
			$data = $this->_db->get('timeframe', array($field, '=', $corporateID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchCorporateActiveTimeframe($corporateID = null){
		if($corporateID){
			$field = (is_numeric($corporateID)) ? 'corporateID' : 'corporate';
			$fieldstatus = "status";
			$statusvalue = "Active";
			$data = $this->_db->getOne('timeframe', array($field, '=', $corporateID), array($fieldstatus, "=", $statusvalue));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchCompanyTimeframe($companyID = null){
		if($companyID){
			$field = (is_numeric($companyID)) ? 'companyID' : 'company';
			$data = $this->_db->get('timeframe', array($field, '=', $companyID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchCompanyActiveTimeframe($corporateID = null){
		if($corporateID){
			$field = (is_numeric($corporateID)) ? 'companyID' : 'corporate';
			$fieldstatus = "status";
			$statusvalue = "Active";
			$data = $this->_db->getOne('timeframe', array($field, '=', $corporateID), array($fieldstatus, "=", $statusvalue));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	
}
?>