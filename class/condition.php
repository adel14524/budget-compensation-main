<?php
class Condition{ 
	private $_data,
	$_db;
	
	public function __construct($id = null){
		$this->_db = Database::getInstance();
	}
	
	public function data(){
		return $this->_data;
	}

	public function lastinsertid(){
		return $this->_db->lastInsertId();
	}

	public static function exists(){
		return (!empty($this->_data)) ? true : false;
	}

	public function addCondition($fields = array()){
		if(!$this->_db->insert('cond_individual', $fields)) {
			throw new Exception('There was a problem adding data.');
		}
	}

	public function updateCondition($fields = array(), $id = null, $idname=null){
		if (!$this->_db->update('cond_individual', $id, $fields, $idname)) {
			throw new Exception('There was a problem updating activity.');
		}
	}

	public function deleteCondition($id = null){
		if($id){
			$data = $this->_db->delete('cond_individual', array("cond_indID", '=', $id ));
			return $data;
		}
		return false;
	}


	    public function searchcondition($value = null){
	      if($value){
	        $data = $this->_db->get('cond_individual', array("compensationID", '=', $value));
	        if($data->count()){
	          $this->_data = $data->results();
	          return $this->_data;
	}
	      }
	    }

	    public function searchcompensationcondition($cond_indID = null){
	           if($cond_indID){
	               $field = (is_numeric($cond_indID)) ? 'cond_indID' : 'cond_indID';
	               $data = $this->_db->get('cond_individual', array($field, '=', $cond_indID));
	               if($data->count()){
	                   $this->_data = $data->first();
	                   return $this->_data;
	               }
	           }
	           return false;
	       }

}
?>
