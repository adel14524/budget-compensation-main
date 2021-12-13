<?php
class Company{
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
	
	public function addCompany($fields = array()){
		if(!$this->_db->insert('company', $fields)) {
		  throw new Exception('There was a problem adding a company.');
		}
	}
	
	public function searchAllCompany(){
		$data = $this->_db->getall('company');
		if($data->count()){
			$this->_data = $data->results();
			return $this->_data;
		}
		return false;
	}

	public function updateCompany($fields = array(), $id = null, $companyID){
		if (!$this->_db->update('company', $id, $fields, $companyID)) {
		  throw new Exception('There was a problem updating objective.');
		}
	}
	
	public function searchCompany($companyID = null){
		if($companyID){
			$field = (is_numeric($companyID)) ? 'companyID' : 'company';
			$data = $this->_db->get('company', array($field, '=', $companyID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchCompanyCorporate($corporateID = null){
		if($corporateID){
			$field = (is_numeric($corporateID)) ? 'corporateID' : 'company';
			$data = $this->_db->get('company', array($field, '=', $corporateID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchCompanyCorporateStatus($corporateID = null, $status = null){
		if($corporateID && $status){
			$field = (is_numeric($corporateID)) ? 'corporateID' : 'company';
			$data = $this->_db->getOne('company', array($field, '=', $corporateID), array("status", '=', $status));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchCompanyMember($companyID = null){
		if($companyID){
			$field = (is_numeric($companyID)) ? 'companyID' : 'company';
			$data = $this->_db->get('user', array($field, '=', $companyID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchCompanyLeadership($userID = null){
		if($userID){
			$field = (is_numeric($userID)) ? 'leaderID' : 'company';
			$data = $this->_db->get('company', array($field, '=', $userID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}
	
	public function deleteCompany($companyID = null){
		if($companyID){
			$field = (is_numeric($companyID)) ? 'companyID' : 'name';
			$data = $this->_db->delete('company', array($field, '=', $companyID));
			return $data;
		}
		return false;
	}
}
?>