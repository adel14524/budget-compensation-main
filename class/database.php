<?php
class Database{
	//properties of class Database
	private static $_instance = null;
	private $_pdo, 
			$_query, 
			$_error = false, 
			$_results,
			$_count = 0,
			$_insertid;
			
	//Methods of class Database
	//get connection to database with PDO
	private function __construct(){
		try{
			$this->_pdo = new PDO('mysql:host='.Config::get('database/host').';dbname='.Config::get('database/db'),Config::get('database/username'),Config::get('database/password'));
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	//create instance for connection
	public static function getInstance(){
		if(!isset(self::$_instance)){
			self::$_instance = new Database();
		}
		return self::$_instance;
	}

	public function lastInsertId(){
		return $this->_pdo->lastinsertid();
	}
	
	//execute the sql statement and save to results variable
	public function query($sql, $params = array()){
		$this->_error = false;
		if($this->_query = $this->_pdo->prepare($sql)){
			$x = 1;
			if(count($params)){
				foreach($params as $param){
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}
			if($this->_query->execute()){
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
				
			}else{
				$this->_error = true;
			}
		}
		return $this;
	}

	public function queryall($sql = null){
		$this->_error = false;
		if($this->_query = $this->_pdo->prepare($sql)){

			if($this->_query->execute()){
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
				
			}else{
				$this->_error = true;
			}
		}
		return $this;
	}

	public function actionall($action, $table){
		$sql = "{$action} FROM {$table}";
		if(!$this->queryall($sql)->error()){
			return $this;
		}
		return false;
	}

	public function getall($table){
		return $this->actionall('SELECT *', $table);
	}
	
	//restructure the sql statement from function get and delete
	public function action($action, $table, $where = array()){
		if(count($where) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field 		= $where[0];
			$operator 	= $where[1];
			$value 		= $where[2];
			
			if(in_array($operator, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
				if(!$this->query($sql, array($value))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function actionOne($action, $table, $where1 = array(), $where2 = array()){
		if(count($where1) === 3 && count($where2) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field1 		= $where1[0];
			$operator1 		= $where1[1];
			$value1 		= $where1[2];

			$field2 		= $where2[0];
			$operator2 		= $where2[1];
			$value2 		= $where2[2];
			
			if(in_array($operator1, $operators) && in_array($operator2, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field1} {$operator1} ? AND {$field2} {$operator2} ?";
				if(!$this->query($sql, array($value1, $value2))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function actionTwo($action, $table, $where1 = array(), $where2 = array(), $where3){
		if(count($where1) === 3 && count($where2) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field1 		= $where1[0];
			$operator1 		= $where1[1];
			$value1 		= $where1[2];

			$field2 		= $where2[0];
			$operator2 		= $where2[1];
			$value2 		= $where2[2];
			
			if(in_array($operator1, $operators) && in_array($operator2, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field1} {$operator1} ? AND {$field2} {$operator2} ? AND verified = ?";
				if(!$this->query($sql, array($value1, $value2, $where3))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function action2($action, $table, $where1 = array(), $where2 = array(), $where3 = array()){
		if(count($where1) === 3 && count($where2) === 3 && count($where3) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field1 		= $where1[0];
			$operator1 		= $where1[1];
			$value1 		= $where1[2];

			$field2 		= $where2[0];
			$operator2 		= $where2[1];
			$value2 		= $where2[2];

			$field3 		= $where3[0];
			$operator3 		= $where3[1];
			$value3 		= $where3[2];
			
			if(in_array($operator1, $operators) && in_array($operator2, $operators) && in_array($operator3, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field1} {$operator1} ? AND {$field2} {$operator2} ? AND {$field3} {$operator3} ?";
				if(!$this->query($sql, array($value1, $value2, $value3))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function action2_1($action, $table, $where1 = array(), $where2 = array(), $where3 = array()){
		if(count($where1) === 3 && count($where2) === 3 && count($where3) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field1 		= $where1[0];
			$operator1 		= $where1[1];
			$value1 		= $where1[2];

			$field2 		= $where2[0];
			$operator2 		= $where2[1];
			$value2 		= $where2[2];

			$field3 		= $where3[0];
			$operator3 		= $where3[1];
			$value3 		= $where3[2];
			
			if(in_array($operator1, $operators) && in_array($operator2, $operators) && in_array($operator3, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field1} {$operator1} ? AND ({$field2} {$operator2} ? OR {$field3} {$operator3} ?)";
				if(!$this->query($sql, array($value1, $value2, $value3))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function action3($action, $table, $where1 = array(), $where2 = array(), $where3 = array(), $where4 = array()){
		if(count($where1) === 3 && count($where2) === 3 && count($where3) === 3 && count($where4) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field1 		= $where1[0];
			$operator1 		= $where1[1];
			$value1 		= $where1[2];

			$field2 		= $where2[0];
			$operator2 		= $where2[1];
			$value2 		= $where2[2];

			$field3 		= $where3[0];
			$operator3 		= $where3[1];
			$value3 		= $where3[2];

			$field4 		= $where4[0];
			$operator4 		= $where4[1];
			$value4 		= $where4[2];
			
			if(in_array($operator1, $operators) && in_array($operator2, $operators) && in_array($operator3, $operators) && in_array($operator4, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field1} {$operator1} ? AND {$field2} {$operator2} ? AND ({$field3} {$operator3} ? AND {$field4} {$operator4} ?)";
				if(!$this->query($sql, array($value1, $value2, $value3, $value4))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function action4($action, $table, $where1 = array(), $where2 = array(), $where3 = array(), $where4 = array(), $where5 = array()){
		if(count($where1) === 3 && count($where2) === 3 && count($where3) === 3 && count($where4) === 3 && count($where5) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field1 		= $where1[0];
			$operator1 		= $where1[1];
			$value1 		= $where1[2];

			$field2 		= $where2[0];
			$operator2 		= $where2[1];
			$value2 		= $where2[2];

			$field3 		= $where3[0];
			$operator3 		= $where3[1];
			$value3 		= $where3[2];

			$field4 		= $where4[0];
			$operator4 		= $where4[1];
			$value4 		= $where4[2];

			$field5 		= $where5[0];
			$operator5 		= $where5[1];
			$value5 		= $where5[2];
			
			if(in_array($operator1, $operators) && in_array($operator2, $operators) && in_array($operator3, $operators) && in_array($operator4, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field1} {$operator1} ? AND {$field2} {$operator2} ? AND ({$field3} {$operator3} ? AND {$field4} {$operator4} ? AND {$field5} {$operator5} ?)";
				if(!$this->query($sql, array($value1, $value2, $value3, $value4, $value5))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function action3_1($action, $table, $where1 = array(), $where2 = array(), $where3 = array(), $where4 = array(), $where5 = array(), $where6 = array()){
		if(count($where1) === 3 && count($where2) === 3 && count($where3) === 3 && count($where4) === 3 && count($where5) === 3 && count($where6) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field1 		= $where1[0];
			$operator1 		= $where1[1];
			$value1 		= $where1[2];

			$field2 		= $where2[0];
			$operator2 		= $where2[1];
			$value2 		= $where2[2];

			$field3 		= $where3[0];
			$operator3 		= $where3[1];
			$value3 		= $where3[2];

			$field4 		= $where4[0];
			$operator4 		= $where4[1];
			$value4 		= $where4[2];

			$field5 		= $where5[0];
			$operator5 		= $where5[1];
			$value5 		= $where5[2];

			$field6 		= $where6[0];
			$operator6 		= $where6[1];
			$value6 		= $where6[2];
			
			if(in_array($operator1, $operators) && in_array($operator2, $operators) && in_array($operator3, $operators) && in_array($operator4, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field1} {$operator1} ? AND {$field2} {$operator2} ? AND (({$field3} {$operator3} ? AND {$field4} {$operator4} ?) OR ({$field5} {$operator5} ? AND {$field6} {$operator6} ?))";
				if(!$this->query($sql, array($value1, $value2, $value3, $value4, $value5, $value6))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function actionDesc($action, $table, $where = array(), $where2){
		if(count($where) === 3){
			$operators = array('=','>','<','>=','<=');
			
			$field 		= $where[0];
			$operator 	= $where[1];
			$value 		= $where[2];
			
			if(in_array($operator, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? ORDER BY {$where2} DESC";
				if(!$this->query($sql, array($value))->error()){
					return $this;
				}
			}
		}
		return false;
	}




	
	//select function and pass to function action
	public function get($table, $where){
		return $this->action('SELECT *', $table, $where);
	}

	public function getOne($table, $where1, $where2){
		return $this->actionOne('SELECT *', $table, $where1, $where2);
	}

	public function getTwo($table, $where1, $where2, $where3){
		return $this->actionTwo('SELECT *', $table, $where1, $where2, $where3);
	}

	public function get2($table, $where1, $where2, $where3){
		return $this->action2('SELECT *', $table, $where1, $where2, $where3);
	}

	public function get2_1($table, $where1, $where2, $where3){
		return $this->action2_1('SELECT *', $table, $where1, $where2, $where3);
	}

	public function get3($table, $where1, $where2, $where3, $where4){
		return $this->action3('SELECT *', $table, $where1, $where2, $where3, $where4);
	}

	public function get4($table, $where1, $where2, $where3, $where4, $where5){
		return $this->action4('SELECT *', $table, $where1, $where2, $where3, $where4, $where5);
	}

	public function get3_1($table, $where1, $where2, $where3, $where4, $where5, $where6){
		return $this->action3_1('SELECT *', $table, $where1, $where2, $where3, $where4, $where5, $where6);
	}

	public function getDesc($table, $where1, $where2){
		return $this->actionDesc('SELECT *', $table, $where1, $where2);
	}

	
	
	//delete function and pass to function action
	public function delete($table, $where){
		return $this->action('DELETE ', $table, $where);
	}

	public function deleteOne($table, $where1, $where2){
		return $this->actionOne('DELETE ', $table, $where1, $where2);
	}
	
	//insert function
	public function insert($table, $fields = array()){
		$keys = array_keys($fields);
		$values = null;
		$x = 1;

		foreach($fields as $field) {
			$values .= '?';
			if($x < count($fields)) {
				$values .= ', ';
			}
			$x++;
		}

		$sql = "INSERT INTO {$table} (`" . implode('`,`' , $keys) . "`) VALUES ({$values})";

		if(!$this->query($sql, $fields)->error()) {
			return true;
		}
		return false;
	}
	
	//update function
	public function update($table, $id, $fields, $idname){
		$set = '';
		$x = 1;

		foreach($fields as $name => $value) {
		  $set .= "{$name} = ?";
		  if($x < count($fields)) {
			$set .= ', ';
		  }
		  $x++;
		}

		$sql = "UPDATE {$table} SET {$set} WHERE {$idname} = {$id}";

		if (!$this->query($sql, $fields)->error()) {
		  return true;
		}
		return false;
	}

	//get results
	public function results(){
		return $this->_results;
	}
	
	public function first(){
		return $this->results()[0];
	}
	
	//get errors
	public function error(){
		return $this->_error;
	}
	
	//get count 
	public function count(){
		return $this->_count;
	}
	public function getsum($table, $where1, $where2, $where3){
		return $this->action2('SELECT SUM(amount) as total', $table, $where1, $where2, $where3);
	}

	public function getsumbonus($table, $where1, $where2, $where3){
		return $this->action2('SELECT SUM(Total_Bonus) as total', $table, $where1, $where2, $where3);
	}


}
?>