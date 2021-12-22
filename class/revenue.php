<?php
class Revenue{
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

	public function addRevenue($fields = array()){
		if(!$this->_db->insert('budget_revenue', $fields)) {
			throw new Exception('There was a problem adding data.');
		}
	}

	public function addRevenueLog($fields = array()){
		if(!$this->_db->insert('revenuelog', $fields)) {
			throw new Exception('There was a problem adding data.');
		}
	}

	public function addCostLog($fields = array()){
		if(!$this->_db->insert('revenuelog', $fields)) {
			throw new Exception('There was a problem adding data.');
		}
	}

	public function updateRevenue($fields = array(), $id = null, $idname = null){
		if (!$this->_db->update('budget_revenue', $id, $fields, $idname)) {
			throw new Exception('There was a problem updating activity.');
		}
	}

	public function updateCost($fields = array(), $id = null, $idname = null){
		if (!$this->_db->update('budget_revenue', $id, $fields, $idname)) {
			throw new Exception('There was a problem updating activity.');
		}
	}

	public function deleteRevenue($id = null){
		if($id){
			$data = $this->_db->delete('budget_revenue', array("budgetRevenueID", '=', $id ));
			return $data;
		}
		return false;
	}


	public function searchRevenue($value = null){
		if($value){
			$data = $this->_db->get('budget_revenue', array("budgetRevenueID", '=', $value));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}


	public function searchRevenueEstLog($budgetRevenueID =null){
		if($budgetRevenueID){
			$data = $this->_db->get('revenuelog', array("budgetRevenueID", '=', $budgetRevenueID));
			// $field = (is_numeric($revenueLogID)) ? 'revenueLogID' : 'revenuelog';
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}
	public function searchRevenueActLog($budgetRevenueID =null){
		if($budgetRevenueID){
			$data = $this->_db->get('revenuelog', array("budgetRevenueID", '=', $budgetRevenueID));
			// $field = (is_numeric($revenueLogID)) ? 'revenueLogID' : 'revenuelog';
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}
	public function searchCostOfGoodSoldLog($budgetRevenueID =null){
		if($budgetRevenueID){
			$data = $this->_db->get('revenuelog', array("budgetRevenueID", '=', $budgetRevenueID));
			// $field = (is_numeric($revenueLogID)) ? 'revenueLogID' : 'revenuelog';
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchRevenueestimate($value = null, $year =null, $typeRevenue=null){
		if($value){
			$data = $this->_db->get2('budget_revenue', array("companyID", '=', $value), array("year", '=', $year), array("typeRevenue", '=', $typeRevenue));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}	
	public function searchRevenueactual($value = null, $year =null, $typeRevenue= null){
		if($value){
			$data = $this->_db->get2('budget_revenue', array("companyID", '=', $value), array("year", '=', $year), array("typeRevenue", '=', $typeRevenue));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}
	public function searchCostOfGoodSold($value = null, $year =null, $typeRevenue= null){
		if($value){
			$data = $this->_db->get2('budget_revenue', array("companyID", '=', $value), array("year", '=', $year), array("typeRevenue", '=', $typeRevenue));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}
	public function searchRev($value = null, $year =null){
		if($value && $year){
			$data = $this->_db->getOne('budget_revenue', array("companyID", '=', $value), array("year", '=', $year));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}
}
?>
