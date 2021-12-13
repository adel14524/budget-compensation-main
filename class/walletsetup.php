<?php
class Walletsetup {
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

    public function addwallet($fields = array()){
		if(!$this->_db->insert('wallet', $fields)) {
		  throw new Exception('There was a problem adding data.');
		}
	}

    public function updatewallet($fields = array(), $id = null,$idname=null){
	    if (!$this->_db->update('wallet', $id, $fields, $idname)) {
		  throw new Exception('There was a problem updating activity.');
		}
	}

     public function deletewallet($id = null){
	 if($id){
	      $data = $this->_db->delete('wallet', array("wallet_id", '=', $id ));
     return $data;
	 }
	  return false;
	}


      public function searchwallet($company_id = null , $dept_id = null){
      if($company_id && $dept_id){
        $data = $this->_db->getOne('wallet', array($company_id, '=', $company_id),array($dept_id, '=', $dept_id));
        if($data->count()){
          $this->_data = $data->results();
          return $this->_data;
            }
          }
    }

////                For get function, depends on how many parameter you have you will use different function
//                1 parameter = get('table_name',para1 = null)
//                2 parameter = getOne('table_name',para1, para2)
//                3 parameter = get2('table_name', para1, para2, para3)
//                4 parameter = get3('table_name' ,para1, para2, para3, para4)
//                5 parameter = get4('table_name', para1, para2, para3, para4, para5)
//
//                Para1,2,3 = array("column_name", '=' ,  $id)                
//
//                …currently don’t have query more than 5 parameter, in case that it’s needed, please inform the person in charge.
//
//
//           As for first or results(), if you only want to get 1 row of data at any table in database, use first() .
//           If you need to get more than 1 row of data, then use results() .
               
}
?>
