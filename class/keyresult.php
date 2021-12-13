<?php
class Keyresult{
	private $_data,
			$_db,
			$_count;
	
	public function __construct($id = null){
		$this->_db = Database::getInstance();
	}
	
	public function lastinsertid(){
		return $this->_db->lastInsertId();
	}
	
	public function data(){
		return $this->_data;
	}
	
	public static function exists(){
		return (!empty($this->_data)) ? true : false;
	}
	
	//Add Key result - add keyresult to objective
	public function addKeyresult($fields = array()){
		if(!$this->_db->insert('keyresult', $fields)) {
		  throw new Exception('There was a problem adding a key result.');
		}
	}

	//Adding in when update keyresult value - add 1 log whenever update the progress
	public function addKeyresultLog($fields = array()){
		if(!$this->_db->insert('keyresultlog', $fields)) {
		  throw new Exception('There was a problem adding a key result log.');
		}
	}

	public function addcomment($fields = array()){
		if(!$this->_db->insert('okr_comment', $fields)) {
		  throw new Exception('There was a problem adding a comment.');
		}
	}

	public function addlikes($fields = array()){
		if(!$this->_db->insert('okr_likes', $fields)) {
		  throw new Exception('There was a problem adding a like.');
		}
	}

	public function deleteKeyresultLog($keyresultid = null){
		if($keyresultid){
			$field = (is_numeric($keyresultid)) ? 'keyresultID' : 'name';
			$data = $this->_db->delete('keyresultlog', array($field, '=', $keyresultid));
			return $data;
		}
		return false;
	}
	
	//Update key result detail - update detail
	public function updateKeyresult($fields = array(), $id = null, $keyresultID){
		if (!$this->_db->update('keyresult', $id, $fields, $keyresultID)) {
		  throw new Exception('There was a problem updating keyresult.');
		}
	}

	//Search the only key result base on keyresult ID in keyresult table - to view THE key result
	public function searchOnlyKeyresult($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'keyresultID' : 'keyresult';
			$data = $this->_db->get('keyresult', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchOnlyKeyresultLog($id = null){
		if($id){
			$data = $this->_db->get('keyresultlog', array("keyresultlogID", '=', $id));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	//Search latest value - to show the latest progress
	public function searchKeyresultLog($id = null, $date = null){
		if($id){
			$field = (is_numeric($id)) ? 'keyresultID' : 'keyresult';
			$data = $this->_db->getOne('keyresultlog', array($field, '=', $id), array("date", "<=", $date));
			if($data->count()){
				$i =  $data->count();
				$this->_data = $data->results()[$i-1];
				return $this->_data;
			}
		}
	}

	public function searchKeyresultLogDifferent($id = null, $date = null){
		if($id){
			$field = (is_numeric($id)) ? 'objectiveID' : 'keyresult';
			$data = $this->_db->getOne('keyresultlog', array($field, '=', $id), array("date", ">=", $date));
			if($data->count()){
				$i =  $data->count();
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchSpecificKeyresultLog($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'keyresultID' : 'keyresult';
			$data = $this->_db->get('keyresultlog', array($field, '=', $id));
			if($data->count()){
				$i =  $data->count();
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}	

	//Search all log - view all log to show status
	public function searchAllKeyresultLog($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'objectiveID' : 'keyresult';
			$data = $this->_db->get('keyresultlog', array($field, '=', $id));
			if($data->count()){
				$i =  $data->count();
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}	

	public function searchcommentKR($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'keyresultID' : 'keyresult';
			$data = $this->_db->get('okr_comment', array($field, '=', $id));
			if($data->count()){
				$i =  $data->count();
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}	

	public function searchcommentKRAll($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'objectiveID' : 'keyresult';
			$data = $this->_db->get('okr_comment', array($field, '=', $id));
			if($data->count()){
				$i =  $data->count();
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}	

	public function searchOnlycommentKR($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'keyresultID' : 'keyresult';
			$data = $this->_db->get('okr_comment', array($field, '=', $id));
			if($data->count()){
				$i =  $data->count();
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}	

	public function searchOnlylikesKR($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'keyresultID' : 'keyresult';
			$data = $this->_db->get('okr_likes', array($field, '=', $id));
			if($data->count()){
				$i =  $data->count();
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}	

	public function searchlikesKR($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'keyresultID' : 'keyresult';
			$data = $this->_db->get('okr_likes', array($field, '=', $id));
			if($data->count()){
				$i =  $data->count();
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}	

	public function searchlikesKRAll($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'objectiveID' : 'keyresult';
			$data = $this->_db->get('okr_likes', array($field, '=', $id));
			if($data->count()){
				$i =  $data->count();
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}	

	public function searchLikesKRSpecific($id = null, $type = null){
		if($id){
			$field = (is_numeric($id)) ? 'objectiveID' : 'keyresult';
			$data = $this->_db->getOne('okr_likes', array($field, '=', $id), array("type", "=", $type));
			if($data->count()){
				$i =  $data->count();
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	//Search all key result based on Objective ID - View Keyresult of specific objective
	public function searchKeyresult($objectiveID = null){
		if($objectiveID){
			$field = (is_numeric($objectiveID)) ? 'objectiveID' : 'keyresult';
			$data = $this->_db->get('keyresult', array($field, '=', $objectiveID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	//
	public function join($companyID = null){
		if($companyID){
			$field = (is_numeric($companyID)) ? 'companyID' : 'keyresult';
			$data = $this->_db->innerjoin('keyresult', $companyID, array($field, '=', $companyID));
			//print_r($data);
			$this->_data = $data->results();
			return $this->_data;
		}
		
	}
	
	//delete keyresult - delete keyresult
	public function deleteKeyresult($keyresultid = null){
		if($keyresultid){
			$field = (is_numeric($keyresultid)) ? 'keyresultID' : 'name';
			$data = $this->_db->delete('keyresult', array($field, '=', $keyresultid));
			return $data;
		}
		return false;
	}

	public function deleteKeyresultfromObjective($objectiveid = null){
		if($objectiveid){
			$field = (is_numeric($objectiveid)) ? 'objectiveID' : 'name';
			$data = $this->_db->delete('keyresult', array($field, '=', $objectiveid));
			return $data;
		}
		return false;
	}

	public function count(){
		return $this->_count;
	}
}
?>