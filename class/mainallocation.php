<?php
class Mainallocation {
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

    public function addmain($fields = array()){
		if(!$this->_db->insert('budget_main_allocation', $fields)) {
		  throw new Exception('There was a problem adding data.');
		}
		
	}

    public function updatemain($fields = array(), $id = null,$idname=null){
	    if (!$this->_db->update('budget_main_allocation', $id, $fields, $idname)) {
		  throw new Exception('There was a problem updating activity.');
		}
	}


     public function readmain($id = null){
	 if($id){
	      $data = $this->_db->read('budget_main_allocation', array("budgetMainAllocationID", '=', $id ));
return $data;
	 }
	  return false;
	}

 public function deletemain($id = null){
	 if($id){
	      $data = $this->_db->delete('budget_main_allocation', array("budgetInitialID", '=', $id ));
return $data;
	 }
	  return false;
	}

       public function searchmain($value = null, $year=null){
	  if($value){
	    $data = $this->_db->getOne('budget_main_allocation', array("companyID", '=', $value), array("year", '=', $year));
	    if($data->count()){
	      $this->_data = $data->results();
	      return $this->_data;
}
	  }
	}
	      
    public function searchmainbudgetid($budgetInitialID=null){
          if($budgetInitialID){
            $data = $this->_db->get('budget_main_allocation', array("budgetInitialID", '=', $budgetInitialID));
            if($data->count()){
              $this->_data = $data->results();
              return $this->_data;
                }
              }
        }      
	public function searchmainallocation($addmaincomp = null , $mainyear = null){
      if($addmaincomp && $mainyear ){
        $data = $this->_db->getOne('budget_main_allocation', array("companyID", '=', $addmaincomp),array("year", '=', $mainyear));
        if($data->count()){
          $this->_data = $data->results();
          return $this->_data;
            }
          }
    }
    	public function searchmainsub($value=null){
          if($value ){
            $data = $this->_db->get('budget_main_allocation', array("budgetInitialID", '=', $value));
            if($data->count()){
              $this->_data = $data->results();
              return $this->_data;
                }
              }
        }


	public function searchbudgetmain($budgetMainAllocationID = null){
        if($budgetMainAllocationID){
            $field = (is_numeric($budgetMainAllocationID)) ? 'budgetMainAllocationID' : 'budget_main_allocation';
            $data = $this->_db->get('budget_main_allocation', array($field, '=', $budgetMainAllocationID));
            if($data->count()){
                $this->_data = $data->first();
                return $this->_data;
            }
        }
        return false;
    }
    public function searchmain1($value = null){
          if($value){
            $data = $this->_db->get('budget_main_allocation', array("companyID", '=', $value));
            if($data->count()){
              $this->_data = $data->results();
              return $this->_data;
    }
          }
        }
    	public function searchbudget($budgetMainAllocationID = null){
            if($budgetMainAllocationID){
                $field = (is_numeric($budgetMainAllocationID)) ? 'budgetMainAllocationID' : 'budget_main_allocation';
                $data = $this->_db->get('budget_main_allocation', array($field, '=', $budgetMainAllocationID));
                if($data->count()){
                    $this->_data = $data->results();
                    return $this->_data;
                }
            }
            return false;
        }

    	public function searchbudgetmain2($budgetinitialID = null){
            if($budgetinitialID){
                $field = (is_numeric($budgetinitialID)) ? 'budgetInitialID' : 'budget_main_allocation';
                $data = $this->_db->get('budget_main_allocation', array($field, '=', $budgetinitialID));
                if($data->count()){
                    $this->_data = $data->results();
                    return $this->_data;
                }
            }
            return false;
        }

        	public function searchbudgetmain3($budgetMainAllocationID = null){
                if($budgetMainAllocationID){
                    $field = (is_numeric($budgetMainAllocationID)) ? 'budgetInitialID' : 'budget_main_allocation';
                    $data = $this->_db->get('budget_main_allocation', array($field, '=', $budgetMainAllocationID));
                    if($data->count()){
                        $this->_data = $data->first();
                        return $this->_data;
                    }
                }
                return false;
            }


}
?>
