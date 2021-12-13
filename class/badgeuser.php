<?php
class Badgeuser{ 
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

	public function addBadgeuser($fields = array()){
		if(!$this->_db->insert('badgeuser', $fields)) {
			throw new Exception('There was a problem adding data.');
		}
	}

		public function updateBadgeuser($fields = array(), $id = null, $idname=null){
		if (!$this->_db->update('badgeuser', $id, $fields, $idname)) {
			throw new Exception('There was a problem updating activity.');
		}
	}

	public function deleteBadgeuser($id = null){
		if($id){
			$data = $this->_db->delete('badgeuser', array("cond_indID", '=', $id ));
			return $data;
		}
		return false;
	}

	public function deleteBadgeid($id = null){
		if($id){
			$data = $this->_db->delete('badgeuser', array("badgeID", '=', $id ));
			return $data;
		}
		return false;
	}
	public function searchBadgeUser($value = null){
	      if($value ){
	        $data = $this->_db->get('badgeuser', array("userID", '=', $value));
	        if($data->count()){
	          $this->_data = $data->results();
	          return $this->_data;
	}
	      }
	    }


}
?>
