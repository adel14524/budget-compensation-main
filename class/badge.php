<?php
class Badge{ 
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

	public function addBadge($fields = array()){
		if(!$this->_db->insert('badge', $fields)) {
			throw new Exception('There was a problem adding data.');
		}
	}

		public function updateBadge($fields = array(), $id = null, $idname=null){
		if (!$this->_db->update('badge', $id, $fields, $idname)) {
			throw new Exception('There was a problem updating activity.');
		}
	}

	public function deleteBadge($id = null){
		if($id){
			$data = $this->_db->delete('badge', array("cond_indID", '=', $id ));
			return $data;
		}
		return false;
	}
	public function deleteBadgeid($id = null){
		if($id){
			$data = $this->_db->delete('badge', array("badgeID", '=', $id ));
			return $data;
		}
		return false;
	}

	public function searchBadge($value = null){
	      if($value){
	        $data = $this->_db->get('badge', array("cond_indID", '=', $value));
	        if($data->count()){
	          $this->_data = $data->results();
	          return $this->_data;
	}
	      }
	    }
	    public function searchBadge2($value = null){
	          if($value){
	            $data = $this->_db->get('badge', array("cond_indID", '=', $value));
	            if($data->count()){
	              $this->_data = $data->first();
	              return $this->_data;
	    }
	          }
	        }

	        public function searchbadgeid($value = null){
	              if($value){
	                $data = $this->_db->get('badge', array("badgeID", '=', $value));
	                if($data->count()){
	                  $this->_data = $data->results();
	                  return $this->_data;
	        }
	              }
	            }
	  
	    	    public function searchcompensationbadge($cond_indID = null){
	            if($cond_indID){
	                $field = (is_numeric($cond_indID)) ? 'cond_indID' : 'badge';
	                $data = $this->_db->get('badge', array($field, '=', $cond_indID));
	                if($data->count()){
	                    $this->_data = $data->results();
	                    return $this->_data;
	                }
	            }
	            return false;
	        }

}
?>
