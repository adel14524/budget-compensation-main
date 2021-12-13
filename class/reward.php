<?php
class Reward{ 
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

	public function addReward($fields = array()){
		if(!$this->_db->insert('reward_individual', $fields)) {
			throw new Exception('There was a problem adding data.');
		}
	}

	public function updateReward($fields = array(), $id = null, $idname=null){
		if (!$this->_db->update('reward_individual', $id, $fields, $idname)) {
			throw new Exception('There was a problem updating activity.');
		}
	}

	public function deleteReward($id = null){
		if($id){
			$data = $this->_db->delete('reward_individual', array("cond_indID", '=', $id ));
			return $data;
		}
		return false;
	}
	public function deleteRewardID($id = null){
		if($id){
			$data = $this->_db->delete('reward_individual', array("reward_indID", '=', $id ));
			return $data;
		}
		return false;
	}

	     public function searchReward($value = null){
	       if($value){
	         $data = $this->_db->get('reward_individual', array("cond_indID", '=', $value));
	         if($data->count()){
	           $this->_data = $data->results();
	           return $this->_data;
	 }
	       }
	     }

	     public function searchcompensationreward($cond_indID = null){
	             if($cond_indID){
	                 $field = (is_numeric($cond_indID)) ? 'cond_indID' : 'reward_individual';
	                 $data = $this->_db->get('reward_individual', array($field, '=', $cond_indID));
	                 if($data->count()){
	                     $this->_data = $data->results();
	                     return $this->_data;
	                 }
	             }
	             return false;
	         }
	   

}
?>
