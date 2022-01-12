<?php
class Suballocation {
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

	public function addsub($fields = array()){
		if(!$this->_db->insert('budget_sub_allocation', $fields)) {
			throw new Exception('There was a problem adding data.');
		}
	}

	public function updatesub($fields = array(), $id = null,$idname=null){
		if (!$this->_db->update('budget_sub_allocation', $id, $fields, $idname)) {
			throw new Exception('There was a problem updating activity.');
		}
	}


	public function readsub($id = null){
		if($id){
			$data = $this->_db->read('budget_sub_allocation', array("budgetSubAllocationID", '=', $id ));
			return $data;
		}
		return false;
	}

	public function deletesub($id = null){
		if($id){
			$data = $this->_db->delete('budget_sub_allocation', array("budgetSubAllocationID", '=', $id ));
			return $data;
		}
		return false;
	}
	
	public function deleteAllSub($id = null){
		if($id){
			$data = $this->_db->delete('budget_sub_allocation', array("budgetMainAllocationID", '=', $id ));
			return $data;
		}
		return false;
	}

	public function searchsub($value = null){
		if($value){
			$data = $this->_db->get('budget_sub_allocation',array("budgetMainAllocationID", '=', $value));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}
	
	public function searchbudgetsubid($value = null){
		if($value){
			$data = $this->_db->get('budget_sub_allocation',array("budgetSubAllocationID", '=', $value));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchsub1($value = null){
		if($value){
			$data = $this->_db->get('budget_sub_allocation',array("budgetMainAllocationID", '=', $value));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchbudgetsub($budgetSubAllocationID = null){
		if($budgetSubAllocationID){
			$field = (is_numeric($budgetSubAllocationID)) ? 'budgetSubAllocationID' : 'budget_sub_allocation';
			$data = $this->_db->get('budget_sub_allocation', array($field, '=', $budgetSubAllocationID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
		return false;
	}
public function searchsuballocation($budgetMainAllocationID=null){
      if($budgetMainAllocationID){
        $data = $this->_db->get('budget_sub_allocation', array("budgetMainAllocationID", '=', $budgetMainAllocationID));
        if($data->count()){
          $this->_data = $data->results();
          return $this->_data;
            }
          }
    }

    public function searchsubmainallocation($budgetMainAllocationID=null){
      if($budgetMainAllocationID){
        $data = $this->_db->get('budget_sub_allocation', array("budgetMainAllocationID", '=', $budgetMainAllocationID));
        if($data->count()){
          $this->_data = $data->results();
          return $this->_data;
            }
          }
    }
   /* public function searchmain1($value = null){
	  if($value){
	    $data = $this->_db->get('budget_main_allocation', array("companyID", '=', $value));
	    if($data->count()){
	      $this->_data = $data->results();
	      return $this->_data;
}
	  }
	}*/

public function searchsuballocation1($budgetSubAllocationID=null){
      if($budgetSubAllocationID){
        $data = $this->_db->get('budget_sub_allocation', array("budgetSubAllocationID", '=', $budgetSubAllocationID));
        if($data->count()){
          $this->_data = $data->results();
          return $this->_data;
            }
          }
    }


}
?>
