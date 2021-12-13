<?php
class Corporate{
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
	
	public function addCorporate($fields = array()){
		if(!$this->_db->insert('corporate', $fields)) {
		  throw new Exception('There was a problem adding a objective.');
		}
	}

	public function addCorporateLeader($fields = array()){
		if(!$this->_db->insert('corporate_leader', $fields)) {
		  throw new Exception('There was a problem adding a leader.');
		}
	}

	public function searchAllCorporate(){
		$data = $this->_db->getall('corporate');
		if($data->count()){
			$this->_data = $data->results();
			return $this->_data;
		}
		return false;
	}
	
	public function updateCorporate($fields = array(), $id = null, $corporateID){
		if (!$this->_db->update('corporate', $id, $fields, $corporateID)) {
		  throw new Exception('There was a problem updating corporate.');
		}
	}
	
	public function searchCorporate($corporateID = null){
		if($corporateID){
			$field = (is_numeric($corporateID)) ? 'corporateID' : 'corporate';
			$data = $this->_db->get('corporate', array($field, '=', $corporateID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchCorporateLeader($userID = null){
		if($userID){
			$field = (is_numeric($userID)) ? 'leaderID' : 'corporate';
			$data = $this->_db->get('corporate', array($field, '=', $userID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
		return false;
	}
	
	public function deleteCorporate($corporateID = null){
		if($corporateID){
			$field = (is_numeric($corporateID)) ? 'corporateID' : 'name';
			$data = $this->_db->delete('corporate', array($field, '=', $corporateID));
			return $data;
		}
		return false;
	}
}
?>