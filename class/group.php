<?php
class Group{
	private $_db,
			$_data;

	public function __construct($group = null){
		$this->_db = Database::getInstance();
	}

	public function addGroup($fields = array()){
		if(!$this->_db->insert('groups', $fields)) {
		  throw new Exception('There was a problem creating the group.');
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

	public function updateGroup($fields = array(), $id = null, $groupID){
		if (!$this->_db->update('groups', $id, $fields, $groupID)) {
		  throw new Exception('There was a problem updating group.');
		}
	}

	public function deleteGroup($groupID = null){
		if($groupID){
			$field = (is_numeric($groupID)) ? 'groupID' : 'name';
			$data = $this->_db->delete('groups', array($field, '=', $groupID));
			return $data;
		}
		return false;
	}

	public function searchCompany($companyID = null){
		if($companyID){
			$field = (is_numeric($companyID)) ? 'companyID' : 'email';
			$data = $this->_db->get('groups', array($field, '=', $companyID));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchCompanywithType($companyID = null, $type = null){
		if($companyID && $type){
			$field = (is_numeric($companyID)) ? 'companyID' : 'email';
			$data = $this->_db->getOne('groups', array($field, '=', $companyID), array("type", '=', $type));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchCompanywithStatus($companyID = null, $status = null){
		if($companyID && $status){
			$field = (is_numeric($companyID)) ? 'companyID' : 'email';
			$data = $this->_db->getOne('groups', array($field, '=', $companyID), array("status", '=', $status));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchCompanywithTypeandStatus($companyID = null, $type = null, $status = null){
		if($companyID && $type && $status){
			$field = (is_numeric($companyID)) ? 'companyID' : 'email';
			$data = $this->_db->get2('groups', array($field, '=', $companyID), array("type", '=', $type), array("status", '=', $status));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchGroupWithCorporate($corporateID = null){
		if($corporateID){
			$field = (is_numeric($corporateID)) ? 'corporateID' : 'email';
			$data = $this->_db->get('groups', array($field, '=', $corporateID));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchGroupWithCorporatewithType($corporateID = null, $type = null){
		if($corporateID && $type){
			$field = (is_numeric($corporateID)) ? 'corporateID' : 'email';
			$data = $this->_db->getOne('groups', array($field, '=', $corporateID), array("type", '=', $type));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchGroupWithCorporatewithStatus($corporateID = null, $status = null){
		if($corporateID && $status){
			$field = (is_numeric($corporateID)) ? 'corporateID' : 'email';
			$data = $this->_db->getOne('groups', array($field, '=', $corporateID), array("status", '=', $status));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchGroupWithCorporatewiithTypeandStatus($corporateID = null, $type = null, $status = null){
		if($corporateID && $type && $status){
			$field = (is_numeric($corporateID)) ? 'corporateID' : 'email';
			$data = $this->_db->get2('groups', array($field, '=', $corporateID), array("type", '=', $type), array("status", '=', $status));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchGroupMember($groupID = null){
		if($groupID){
			$field = (is_numeric($groupID)) ? 'group_id' : 'email';
			$data = $this->_db->get('group_member', array($field, '=', $groupID));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchGroupInvolve($userID = null){
		if($userID){
			$field = (is_numeric($userID)) ? 'member_id' : 'email';
			$data = $this->_db->get('group_member', array($field, '=', $userID));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchGroupLeadership($userID = null){
		if($userID){
			$field = (is_numeric($userID)) ? 'leaderID' : 'company';
			$data = $this->_db->get('groups', array($field, '=', $userID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}
}
?>