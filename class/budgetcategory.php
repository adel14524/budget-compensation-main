<?php
class Budgetcategory{ 
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

	public function addBudgetCatgeory($fields = array()){
		if(!$this->_db->insert('budget_category', $fields)) {
			throw new Exception('There was a problem adding data.');
		}
	}

	public function editbudgetcategory($fields = array(), $id = null, $idname=null){
		if (!$this->_db->update('budget_category', $id, $fields, $idname)) {
			throw new Exception('There was a problem updating activity.');
		}
	}

	public function deletebudgetcategory($id = null){
		if($id){
			$data = $this->_db->delete('budget_category', array("id", '=', $id ));
			return $data;
		}
		return false;
	}

	    public function searchBudgetCategoryByID($id = null){
	        if($id){
	            $field = (is_numeric($id)) ? 'id' : 'id';
	            $data = $this->_db->get('budget_category', array($field, '=', $id));
	            if($data->count()){
	                $this->_data = $data->first();
	                return $this->_data;
	            }
	        }
	        return false;
	    }
	    public function searchBudgetCatOneByCompanyID($value = null){
	          if($value){
	            $data = $this->_db->get('budget_category', array("companyID", '=', $value));
	            if($data->count()){
	              $this->_data = $data->first();
	              return $this->_data;
	    }
	          }
	        }

	        public function searchBudgetCatByCompanyID($value = null){
	          if($value){
	            $data = $this->_db->get('budget_category', array("companyID", '=', $value));
	            if($data->count()){
	              $this->_data = $data->results();
	              return $this->_data;
	    }
	          }
	        }

	        public function searchBudgetCatOneByCorporateID($value = null){
	          if($value){
	            $data = $this->_db->get('budget_category', array("corporateID", '=', $value));
	            if($data->count()){
	              $this->_data = $data->first();
	              return $this->_data;
	    }
	          }
	        }

	        public function searchBudgetCatByCorporateID($value = null){
	          if($value){
	            $data = $this->_db->get('budget_category', array("corporateID", '=', $value));
	            if($data->count()){
	              $this->_data = $data->results();
	              return $this->_data;
	    }
	          }
	        }


}
?>
