<?php
class Target{ 
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

	public function addTarget($fields = array()){
		if(!$this->_db->insert('target', $fields)) {
			throw new Exception('There was a problem adding data.');
		}
	}

	public function updateTarget($fields = array(), $id = null, $idname=null){
		if (!$this->_db->update('target', $id, $fields, $idname)) {
			throw new Exception('There was a problem updating activity.');
		}
	}

	public function deleteTarget($id = null){
		if($id){
			$data = $this->_db->delete('target', array("compensationID", '=', $id ));
			return $data;
		}
		return false;
	}

	// public function searchBudget($value = null){
	//       if($value){
	//         $data = $this->_db->get('budget_initial', array("userID", '=', $value));
	//         if($data->count()){
	//           $this->_data = $data->results();
	//           return $this->_data;
	// }
	//       }
	//     }
	    public function searchTarget($value = null){
	          if($value ){
	            $data = $this->_db->get('target', array("compensationID", '=', $value));
	            if($data->count()){
	              $this->_data = $data->results();
	              return $this->_data;
	    }
	          }
	        }
	      
	   
		        public function searchtargetcompensation($compensationID = null){
	        if($compensationID){
	            $field = (is_numeric($compensationID)) ? 'compensationID' : 'target';
	            $data = $this->_db->get('target', array($field, '=', $compensationID));
	            if($data->count()){
	                $this->_data = $data->first();
	                return $this->_data;
	            }
	        }
	        return false;
	    }
	       
	    	        public function searchtargetcompensation2($compensationID = null){
	            if($compensationID){
	                $field = (is_numeric($compensationID)) ? 'compensationID' : 'target';
	                $data = $this->_db->get('target', array($field, '=', $compensationID));
	                if($data->count()){
	                    $this->_data = $data->results();
	                    return $this->_data;
	                }
	            }
	            return false;
	        }

	        public function searchmeasure($measure = null){
	            if($measure){
	                $field = (is_numeric($measure)) ? 'measure' : 'target';
	                $data = $this->_db->get('target', array($field, '=', $measure));
	                if($data->count()){
	                    $this->_data = $data->results();
	                    return $this->_data;
	                }
	            }
	            return false;
	        }

	            public function searchmeasurecompid($value = null,$compensationID=null){
	              if($value && $compensationID){
	                $data = $this->_db->getOne('target', array("measure", '=', $value), array("compensationID", '=', $compensationID) );
	                if($data->count()){
	                  $this->_data = $data->results();
	                  return $this->_data;
	        }
	              }
	            }
}
?>
