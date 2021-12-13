<?php
class Grossprofit {
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

    public function addgrossprofit($fields = array()){
		if(!$this->_db->insert('budget_gross_profit', $fields)) {
		  throw new Exception('There was a problem adding data.');
		}
		
	}

    public function updategrossprofit($fields = array(), $id = null,$idname=null){
	    if (!$this->_db->update('budget_gross_profit', $id, $fields, $idname)) {
		  throw new Exception('There was a problem updating activity.');
		}
	}



     public function readgrossprofit($id = null){
	 if($id){
	      $data = $this->_db->read('budget_gross_profit', array("budgetGrossProfitID", '=', $id ));
return $data;
	 }
	  return false;
	}

 public function deletegrossprofit($id = null){
	 if($id){
	      $data = $this->_db->delete('budget_gross_profit', array("budgetGrossProfitID", '=', $id ));
return $data;
	 }
	  return false;
	}

       public function searchgrossprofit($value = null, $year=null){
	  if($value){
	    $data = $this->_db->getOne('budget_gross_profit', array("companyID", '=', $value), array("year", '=', $year));
	    if($data->count()){
	      $this->_data = $data->results();
	      return $this->_data;
}
	  }
	}

	 

	public function searchbudgetgrossprofit($budgetGrossProfitID = null){
        if($budgetGrossProfitID){
            $field = (is_numeric($budgetGrossProfitID)) ? 'budgetGrossProfitID' : 'budget_gross_profit';
            $data = $this->_db->get('budget_gross_profit', array($field, '=', $budgetGrossProfitID));
            if($data->count()){
                $this->_data = $data->first();
                return $this->_data;
            }
        }
        return false;
    }



}
?>
