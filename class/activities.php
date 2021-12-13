<?php
class Activities{
	private $_data,
			$_db;
	
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
	
	public function addActivities($fields = array()){
		if(!$this->_db->insert('activities', $fields)) {
		  throw new Exception('There was a problem adding a key result.');
		}
	}

	public function addActivitiesLog($fields = array()){
		if(!$this->_db->insert('activitieslog', $fields)) {
		  throw new Exception('There was a problem adding a activities log.');
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

	public function deleteActivitiesLog($activitiesID = null){
		if($activitiesID){
			$field = (is_numeric($activitiesID)) ? 'activitiesID' : 'name';
			$data = $this->_db->delete('activitieslog', array($field, '=', $activitiesID));
			return $data;
		}
		return false;
	}
	
	public function updateActivities($fields = array(), $id = null, $activitiesID){
		if (!$this->_db->update('activities', $id, $fields, $activitiesID)) {
		  throw new Exception('There was a problem updating activity.');
		}
	}

	public function searchOnlyActivities($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'activitiesID' : 'keyresult';
			$data = $this->_db->get('activities', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchOnlyActivitiesLog($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'activitieslogID' : 'keyresult';
			$data = $this->_db->get('activitieslog', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchActivitiesLog($id = null, $date = null){
		if($id){
			$field = (is_numeric($id)) ? 'activitiesID' : 'keyresult';
			$data = $this->_db->getOne('activitieslog', array($field, '=', $id), array("date", "<", $date));
			if($data->count()){
				$i =  $data->count();
				$this->_data = $data->results()[$i-1];
				return $this->_data;
			}
		}
	}

	public function searchAllActivitiesLog($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'activitiesID' : 'keyresult';
			$data = $this->_db->get('activitieslog', array($field, '=', $id));
			if($data->count()){
				$i =  $data->count();
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}	

	public function searchActivitiesLogDifferent($id = null, $date = null){
		if($id){
			$field = (is_numeric($id)) ? 'objectiveID' : 'keyresult';
			$data = $this->_db->getOne('activitieslog', array($field, '=', $id), array("date", ">=", $date));
			if($data->count()){
				$i =  $data->count();
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchcommentDA($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'activitiesID' : 'keyresult';
			$data = $this->_db->get('okr_comment', array($field, '=', $id));
			if($data->count()){
				$i =  $data->count();
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}	

	public function searchOnlycommentDA($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'activitiesID' : 'keyresult';
			$data = $this->_db->get('okr_comment', array($field, '=', $id));
			if($data->count()){
				$i =  $data->count();
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}	

	public function searchOnlylikesDA($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'activitiesID' : 'keyresult';
			$data = $this->_db->get('okr_likes', array($field, '=', $id));
			if($data->count()){
				$i =  $data->count();
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}	

	public function searchlikesDA($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'activitiesID' : 'keyresult';
			$data = $this->_db->get('okr_likes', array($field, '=', $id));
			if($data->count()){
				$i =  $data->count();
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}	

	public function searchAllActivitiesLogOKR($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'objectiveID' : 'keyresult';
			$data = $this->_db->get('activitieslog', array($field, '=', $id));
			if($data->count()){
				$i =  $data->count();
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}	

	

	public function searchActivities($objectiveID = null){
		if($objectiveID){
			$field = (is_numeric($objectiveID)) ? 'objectiveID' : 'keyresult';
			$data = $this->_db->get('activities', array($field, '=', $objectiveID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchActivitiesKR($keyresultID = null){
		if($keyresultID){
			$field = (is_numeric($keyresultID)) ? 'keyresultID' : 'keyresult';
			$data = $this->_db->get('activities', array($field, '=', $keyresultID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function join($companyID = null){
		if($companyID){
			$field = (is_numeric($companyID)) ? 'companyID' : 'activities';
			$data = $this->_db->innerjoin2('keyresult', $companyID, array($field, '=', $companyID));
			//print_r($data);
			$this->_data = $data->results();
			return $this->_data;
		}
		
	}

	
	
	public function deleteActivities($activitiesID = null){
		if($activitiesID){
			$field = (is_numeric($activitiesID)) ? 'activitiesID' : 'name';
			$data = $this->_db->delete('activities', array($field, '=', $activitiesID));
			return $data;
		}
		return false;
	}

	public function deleteActivitiesfromObjective($objectiveID = null){
		if($objectiveID){
			$field = (is_numeric($objectiveID)) ? 'objectiveID' : 'name';
			$data = $this->_db->delete('activities', array($field, '=', $objectiveID));
			return $data;
		}
		return false;
	}
}
?>