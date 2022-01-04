<?php
class Expense {
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

    public function addexpand($fields = array()){
		if(!$this->_db->insert('budget_expenses', $fields)) {
		  throw new Exception('There was a problem adding data.');
		}
		
	}

    public function updateexpand($fields = array(), $id = null,$idname=null){
	    if (!$this->_db->update('budget_expenses', $id, $fields, $idname)) {
		  throw new Exception('There was a problem updating activity.');
		}
	}


     public function readexpand($id = null){
	 if($id){
	      $data = $this->_db->read('budget_expenses', array("budgetExpensesID", '=', $id ));
return $data;
	 }
	  return false;
	}

 public function deleteexpenses1($id = null){
	 if($id){
	      $data = $this->_db->delete('budget_expenses', array("budgetExpensesID", '=', $id ));
return $data;
	 }
	  return false;
	}
	 public function deletesubexpenses($id = null){
		 if($id){
		      $data = $this->_db->delete('budget_expenses', array("budgetSubAllocationID", '=', $id ));
	return $data;
		 }
		  return false;
		}

       public function searchExpense($value = null,$month = null,$year=null){
	  if($value && $year && $month){
	    $data = $this->_db->get2('budget_expenses', array("companyID", '=', $value), array("EXTRACT(MONTH FROM date)", "=", $month), array("EXTRACT(YEAR FROM date)", "=", $year));
	    if($data->count()){
	      $this->_data = $data->results();
	      return $this->_data;
}
	  }
	}

	 public function searchexpensessubid($value = null,$month = null,$year = null){
	  if($value && $month && $year){
	    $data = $this->_db->get2('budget_expenses', array("budgetSubAllocationID", '=', $value), array("EXTRACT(MONTH FROM date)", "=", $month), array("EXTRACT(YEAR FROM date)", "=", $year));
	    if($data->count()){
	      $this->_data = $data->results();
	      return $this->_data;
}
	  }
	}

	 public function searchexpensestotal($value = null,$month = null,$year = null){
	  if($value && $month && $year){
	    $data = $this->_db->getsum('budget_expenses', array("companyID", '=', $value), array("EXTRACT(MONTH FROM date)", "=", $month), array("EXTRACT(YEAR FROM date)", "=", $year));
	    if($data->count()){
	      $this->_data = $data->first();
	      return $this->_data;
}
	  }
	}

	public function searchbudgetexpenses($budgetExpensesID = null){
        if($budgetExpensesID){
            $field = (is_numeric($budgetExpensesID)) ? 'budgetExpensesID' : 'budget_expenses';
            $data = $this->_db->get('budget_expenses', array($field, '=', $budgetExpensesID));
            if($data->count()){
                $this->_data = $data->first();
                return $this->_data;
            }
        }
        return false;
    }
    public function searchbudgetsubid($budgetSubAllocationID = null){
        if($budgetSubAllocationID){
            $field = (is_numeric($budgetSubAllocationID)) ? 'budgetSubAllocationID' : 'budget_expenses';
            $data = $this->_db->get('budget_expenses', array($field, '=', $budgetSubAllocationID));
            if($data->count()){
                $this->_data = $data->results();
                return $this->_data;
            }
        }
        return false;
    }
	
	public function searchbudgetsubidmonth($budgetSubAllocationID = null,$month = null){
        if($budgetSubAllocationID && $month){
            $field = (is_numeric($budgetSubAllocationID)) ? 'budgetSubAllocationID' : 'budget_expenses';
            $data = $this->_db->getOne('budget_expenses', array($field, '=', $budgetSubAllocationID), array("EXTRACT(MONTH FROM date)", '=', $month));
            if($data->count()){
                $this->_data = $data->results();
                return $this->_data;
            }
        }
        return false;
    }



}
?>
