<?php
class Compensation{ 
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

	public function addCompensation($fields = array()){
		if(!$this->_db->insert('compensation', $fields)) {
			throw new Exception('There was a problem adding data.');
		}
	}

	public function updateCompensation($fields = array(), $id = null, $idname=null){
		if (!$this->_db->update('compensation', $id, $fields, $idname)) {
			throw new Exception('There was a problem updating activity.');
		}
	}

	public function deleteCompensation($id = null){
		if($id){
			$data = $this->_db->delete('compensation', array("compensationID", '=', $id ));
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
	    public function searchCompensation($value = null,$year=null){
	          if($value && $year){
	            $data = $this->_db->getOne('compensation', array("companyID", '=', $value), array("EXTRACT(YEAR FROM start_date)", "=", $year));
	            if($data->count()){
	              $this->_data = $data->results();
	              return $this->_data;
	    }
	          }
	        }
	            public function searchCompensationbyid($value = null){
	              if($value){
	                $data = $this->_db->get('compensation', array("compensationID", '=', $value));
	                if($data->count()){
	                  $this->_data = $data->results();
	                  return $this->_data;
	        }
	              }
	            }
	        public function searchAllCompensation($value = null){
	          if($value){
	            $data = $this->_db->get('compensation', array("userID", '=', $value));
	            if($data->count()){
	              $this->_data = $data->results();
	              return $this->_data;
	    }
	          }
	        }
	            public function searchAllCompensationcorp($value = null){
	              if($value){
	                $data = $this->_db->get('compensation', array("corporateID", '=', $value));
	                if($data->count()){
	                  $this->_data = $data->results();
	                  return $this->_data;
	        }
	              }
	            }
	        public function searchCompanyCompensation($value = null){
	          if($value){
	            $data = $this->_db->get('compensation', array("companyID", '=', $value));
	            if($data->count()){
	              $this->_data = $data->results();
	              return $this->_data;
	    }
	          }
	        }

	        public function searchbudgetcompensation($compensationID = null){
        if($compensationID){
            $field = (is_numeric($compensationID)) ? 'compensationID' : 'compensation';
            $data = $this->_db->get('compensation', array($field, '=', $compensationID));
            if($data->count()){
                $this->_data = $data->first();
                return $this->_data;
            }
        }
        return false;
    }
    	   //      public function searchbudgetcompensation2($compensationID = null){
        //     if($compensationID){
        //         $field = (is_numeric($compensationID)) ? 'compensationID' : 'compensation';
        //         $data = $this->_db->get('compensation', array($field, '=', $compensationID));
        //         if($data->count()){
        //             $this->_data = $data->results();
        //             return $this->_data;
        //         }
        //     }
        //     return false;
        // }
    	       public function searchcompensation1($value = null){
    	         if($value){
    	           $data = $this->_db->get('compensation', array("compensationID", '=', $value));
    	           if($data->count()){
    	             $this->_data = $data->first();
    	             return $this->_data;
    	   }
    	         }
    	       }


}
?>
