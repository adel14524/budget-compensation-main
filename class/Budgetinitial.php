<?php
class Budgetinitial{ 
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

	public function addBudgetInitial($fields = array()){
		if(!$this->_db->insert('budget_initial', $fields)) {
			throw new Exception('There was a problem adding data.');
		}
	}

	public function updateBudgetInitial($fields = array(), $id = null, $idname=null){
		if (!$this->_db->update('budget_initial', $id, $fields, $idname)) {
			throw new Exception('There was a problem updating activity.');
		}
	}

	public function deleteBudgetInitial($id = null){
		if($id){
			$data = $this->_db->delete('budget_initial', array("budgetInitialID", '=', $id ));
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
	    public function searchBudget($value = null, $year=null){
	          if($value){
	            $data = $this->_db->getOne('budget_initial', array("userID", '=', $value), array("year", '=', $year));
	            if($data->count()){
	              $this->_data = $data->results();
	              return $this->_data;
	    }
	          }
	        }
	    public function searchBudgetInitial($budgetInitialID = null){
	        if($budgetInitialID){
	            $field = (is_numeric($budgetInitialID)) ? 'budgetInitialID' : 'budget_initial';
	            $data = $this->_db->get('budget_initial', array($field, '=', $budgetInitialID));
	            if($data->count()){
	                $this->_data = $data->first();
	                return $this->_data;
	            }
	        }
	        return false;
	    }
	    public function searchBudgetCompany($value = null, $year=null){
	          if($value){
	            $data = $this->_db->getOne('budget_initial', array("companyID", '=', $value), array("year", '=', $year));
	            if($data->count()){
	              $this->_data = $data->first();
	              return $this->_data;
	    }
	          }
	        }
	        public function searchBudgetCompany2($value = null,$year){
	              if($value){
	                $data = $this->_db->getOne('budget_initial', array("companyID", '=', $value), array("year", '=', $year));
	                if($data->count()){
	                  $this->_data = $data->results();
	                  return $this->_data;
	        }
	              }
	            }
	            public function searchcompanyyear($value = null, $year=null){
	                    if($value && $year){
	                        $data = $this->_db->getOne('budget_initial', array("companyID", '=', $value), array("year", '=', $year));
	                        if($data->count()){
	                            $this->_data = $data->results();
	                            return $this->_data;
	                        }
	                    }
	                }
	         public function searchyear($userID=null){
	                 if($userID){
	                     $data = $this->_db->get('budget_initial', array("userID", '=', $userID));
	                     if($data->count()){
	                         $this->_data = $data->results();
	                         return $this->_data;
	                     }
	                 }
	             }
	// public function searchBudgetInitial($value = null){
	// 	if($value){
	// 		$data = $this->_db->get('budget_initial', array("budgetInitialID", '=', $value));
	// 		if($data->count()){
	// 			$this->_data = $data->results();
	// 			return $this->_data;
	// 		}
	// 	}
	// }

	
	// public function search($corporateID = null){
	// 	if($corporateID){
	// 		$field = (is_numeric($corporateID)) ? 'corporateID' : 'corporate';
	// 		$data = $this->_db->get('corporate', array($field, '=', $corporateID));
	// 		if($data->count()){
	// 			$this->_data = $data->first();
	// 			return $this->_data;
	// 		}
	// 	}
	// 	return false;
	// }

}
?>
