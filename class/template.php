<?php
class Template{
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

	public function addTemplate($fields = array()){
		if(!$this->_db->insert('report_template', $fields)) {
		  throw new Exception('There was a problem adding a template.');
		}
	}

	public function addTemplateCat($fields = array()){
		if(!$this->_db->insert('report_templatecat', $fields)) {
		  throw new Exception('There was a problem adding a template category.');
		}
	}

	public function updateTemplate($fields = array(), $id = null, $templateID){
		if (!$this->_db->update('report_template', $id, $fields, $templateID)) {
		  throw new Exception('There was a problem updating template.');
		}
	}

	public function deleteTemplate($templateID = null){
		if($templateID){
			$field = (is_numeric($templateID)) ? 'templateID' : 'name';
			$data = $this->_db->delete('report_template', array($field, '=', $templateID));
			return $data;
		}
		return false;
	}

	public function deleteTemplateCat($templateID = null){
		if($templateID){
			$field = (is_numeric($templateID)) ? 'templateID' : 'name';
			$data = $this->_db->delete('report_templatecat', array($field, '=', $templateID));
			return $data;
		}
		return false;
	}

	public function searchOnlyTemplate($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'templateID' : 'keyresult';
			$data = $this->_db->get('report_template', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchAllTemplateCat($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'templateID' : 'keyresult';
			$data = $this->_db->get('report_templatecat', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchAllTemplate($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'userID' : 'keyresult';
			$data = $this->_db->get('report_template', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}
}
?>