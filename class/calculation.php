<?php
class Calculation{
	private $_db,
			$_data;

	public function __construct($group = null){
		$this->_db = Database::getInstance();
	}

	public function addCalculation($fields = array()){
		if(!$this->_db->insert('calculation', $fields)) {
		  throw new Exception('There was a problem creating the group.');
		}
	}

	public function addCalculationInBonus($fields = array()){
		if(!$this->_db->insert('bonus_calculation', $fields)) {
		  throw new Exception('There was a problem creating the group.');
		}
	}
		public function SearchBonusCalculation ($company_id = null,$dept_id = null, $year = null){
      if($company_id ){
        $data = $this->_db->get2('bonus_calculation', array("company_id", '=', $company_id),array("dept_id", '=',$dept_id),array("year", '=', "$year"));
        if($data->count()){
          $this->_data = $data->results();
          return $this->_data;
            }
          }
    }
	public function find($group = null){
		if($group){
			$field = (is_numeric($group)) ? 'groupID' : 'group';
			$data = $this->_db->get('groups', array($field, '=', $group));
			
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchOnlyGroup($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'groupID' : 'group';
			$data = $this->_db->get('groups', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchbonusmainid($budgetMainAllocationID = null){
        if($budgetMainAllocationID){
            $field = (is_numeric($budgetMainAllocationID)) ? 'budgetMainAllocationID' : 'bonus_calculation';
            $data = $this->_db->get('bonus_calculation', array($field, '=', $budgetMainAllocationID));
            if($data->count()){
                $this->_data = $data->results();
                return $this->_data;
            }
        }
        return false;
    }

	public function updateCalc($fields = array(), $id = null, $groupID){
		if (!$this->_db->update('groups', $id, $fields, $groupID)) {
		  throw new Exception('There was a problem updating group.');
		}
	}

	public function deleteCalc($id = null){
		if($id){
			
			$data = $this->_db->delete('calculation', array("calc_id", '=', $id));
			return $data;
		}
		return false;
	}

	public function searchCalc($companyID = null, $department_id = null, $year = null){
		if($companyID && $department_id && $year){
			
			$data = $this->_db->get2('calculation', array("comp_id" ,'=', $companyID), array("dept_id", '=', $department_id), array("year" ,'=', $year));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}
	
	
public function searchTrue($companyID = null , $year = null){
		if($companyID  && $year){
			
			$data = $this->_db->getOne('calculation', array("comp_id" ,'=', $companyID), array("year" ,'=', $year));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	 public function searchBonus($value= null, $month = null, $year = null){
        if($value && $month && $year){

           $data = $this->_db->get2('bonus_calculation', array("company_id", '=', $value), array("EXTRACT(MONTH FROM date)", "=", $month), array("EXTRACT(YEAR FROM date)", "=", $year));
            if($data->count()){
                $this->_data = $data->results();
                return $this->_data;
            }
        }
        return false;
    }

     public function searchbonustotal($value = null,$month = null,$year = null){
	  if($value && $month && $year){
	    $data = $this->_db->getsumbonus('bonus_calculation', array("company_id", '=', $value), array("EXTRACT(MONTH FROM date)", "=", $month), array("EXTRACT(YEAR FROM date)", "=", $year));
	    if($data->count()){
	      $this->_data = $data->first();
	      return $this->_data;
}
	  }
	}
	
	public function searchCalcByDate($companyID = null, $department_id = null, $date = null){
        if($companyID && $department_id && $date){

            $data = $this->_db->get2('calculation', array("comp_id" ,'=', $companyID), array("dept_id", '=', $department_id), array("date" ,'=', $date));

            if($data->count()){
                $this->_data = $data->results();
                return $this->_data;
            }
        }
        return false;
    }
	public function searchCalcByDate2($companyID = null, $department_id = null, $date = null){
        if($companyID && $department_id && $date){

            $data = $this->_db->get2('bonus_calculation', array("company_id" ,'=', $companyID), array("dept_id", '=', $department_id), array("date" ,'=', $date));

            if($data->count()){
                $this->_data = $data->results();
                return $this->_data;
            }
        }
        return false;
    }
    // SELECT * FROM calculation WHERE comp_id = 3 AND dept_id =1 AND year = 2021 GROUP BY date

    public function searchCalcGroup($company_id = null, $dept_ids = null, $year = null){
        if($company_id && $dept_ids && $year){

            $data = $this->_db->getGroupS('calculation', array("comp_id" ,'=', $company_id), array("dept_id", '=', $dept_ids), array("year" ,'=', $year), "date");

            if($data->count()){
                $this->_data = $data->results();
                return $this->_data;
            }
        }
        return false;
    }
	
	  public function searchCalcGroup2($company_id = null, $dept_ids = null, $year = null){
        if($company_id && $dept_ids && $year){

            $data = $this->_db->getGroupS('bonus_calculation', array("company_id" ,'=', $company_id), array("dept_id", '=', $dept_ids), array("year" ,'=', $year), "date");

            if($data->count()){
                $this->_data = $data->results();
                return $this->_data;
            }
        }
        return false;
    }
	public function searchCalcByDateFirstRow($companyID = null, $department_id = null, $date = null){
        if($companyID && $department_id && $date){

            $data = $this->_db->get2('calculation', array("comp_id" ,'=', $companyID), array("dept_id", '=', $department_id), array("date" ,'=', $date));

            if($data->count()){
                $this->_data = $data->first();
                return $this->_data;
            }
        }
        return false;
    }
	
}
?>