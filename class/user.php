<?php
class User{
	private $_db,
			$_data,
			$_sessionName,
			$_cookieName,
			$_isLoggedIn;
	
	public function __construct($user = null){
		$this->_db = Database::getInstance();
		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookie_name');
		if(!$user){
			if(Session::exists($this->_sessionName)){
				$user = Session::get($this->_sessionName);
				if($this->find($user)){
					$this->_isLoggedIn = true;
				}else{
					self::logout();
				}
			}
		}else{
			$this->find($user);
		}
	}

	public function find($user = null){
		if($user){
			$field = (is_numeric($user)) ? 'userID' : 'email';
			$data = $this->_db->get('user', array($field, '=', $user));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function lastinsertid(){
		return $this->_db->lastInsertId();
	}
	
	public function create($fields = array()){
		if(!$this->_db->insert('user', $fields)) {
		  throw new Exception('There was a problem creating the profile.');
		}
	}

	public function insertlog($fields = array()){
		if(!$this->_db->insert('loginlog', $fields)) {
		  throw new Exception('There was a problem adding log.');
		}
	}

	public function upgradelog($fields = array(), $id = null, $dependID = null){
		if (!$this->_db->update('loginlog', $id, $fields, $dependID)) {
		  throw new Exception('There was a problem upgrade the setup.');
		}
	}

	public function insertChangeofUserLog($fields = array()){
		if(!$this->_db->insert('noosuserchange', $fields)) {
		  throw new Exception('There was a problem adding user change log.');
		}
	}

	public function upgradeuserchangelog($fields = array(), $id = null, $dependID = null){
		if (!$this->_db->update('noosuserchange', $id, $fields, $dependID)) {
		  throw new Exception('There was a problem upgrade the setup.');
		}
	}

	public function insertlog2($fields = array()){
		if(!$this->_db->insert('updatelog', $fields)) {
		  throw new Exception('There was a problem adding log.');
		}
	}

	public function addinviteuser($fields = array()){
		if(!$this->_db->insert('potential_user_invite', $fields)) {
		  throw new Exception('There was a problem adding log.');
		}
	}

	public function updateinviteuser($fields = array(), $id = null, $invitedID = null){
		if (!$this->_db->update('potential_user_invite', $id, $fields, $invitedID)) {
		  throw new Exception('There was a problem update the invited user status.');
		}
	}

	public function upgradeupdatelog($fields = array(), $id = null, $dependID = null){
		if (!$this->_db->update('updatelog', $id, $fields, $dependID)) {
		  throw new Exception('There was a problem upgrade the setup.');
		}
	}

	public function checkLogInbefore($userID = null, $date = null){
		if($userID){
			$field = (is_numeric($userID)) ? 'userID' : 'userID';
			$data = $this->_db->getOne('loginlog', array($field, '=', $userID), array("datetime", "=", $date));
			
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
		return false;
	}

	public function checkLoginResultCorporate($corporateID = null){
		if($corporateID){
			$field = (is_numeric($corporateID)) ? 'corporateID' : 'corporateID';
			$data = $this->_db->get('loginlog', array($field, '=', $corporateID));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchCountriesCode(){
		$data = $this->_db->getall('countries');
		if($data->count()){
			$this->_data = $data->results();
			return $this->_data;
		}
	}

	public function searchUserByCompany($companyID = null){
	        if($companyID){
	            $data = $this->_db->get('user', array("companyID", '=', $companyID));
	            if($data->count()){
	                $this->_data = $data->results();
	                return $this->_data;
	            }
	        }
	        return false;
	    }

	public function searchinviteduseremailduplicate($email = null){
		if($email){
			$data = $this->_db->get('potential_user_invite', array("email", '=', $email));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchinviteduserphonenumberduplicate($phone = null){
		if($phone){
			$data = $this->_db->get('potential_user_invite', array("phone_num", '=', $phone));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
		return false;
	}


	public function checkLoginResultCompany($companyID = null){
		if($companyID){
			$field = (is_numeric($companyID)) ? 'companyID' : 'companyID';
			$data = $this->_db->get('loginlog', array($field, '=', $companyID));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}


	public function checkUpdatebefore($userID = null, $date = null){
		if($userID){
			$field = (is_numeric($userID)) ? 'userID' : 'userID';
			$data = $this->_db->getOne('updatelog', array($field, '=', $userID), array("datetime", "=", $date));
			
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
		return false;
	}

	public function getLogCorporate($corporateID = null, $date = null){
		if($corporateID){
			$field = (is_numeric($corporateID)) ? 'corporateID' : 'corporateID';
			$data = $this->_db->getOne('loginlog', array($field, '=', $corporateID), array("datetime", "=", $date));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function getUpdateCorporate($corporateID = null, $date = null){
		if($corporateID){
			$field = (is_numeric($corporateID)) ? 'corporateID' : 'corporateID';
			$data = $this->_db->getOne('updatelog', array($field, '=', $corporateID), array("datetime", "=", $date));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function getLogCompany($userID = null, $date = null){
		if($userID){
			$field = (is_numeric($userID)) ? 'companyID' : 'companyID';
			$data = $this->_db->getOne('loginlog', array($field, '=', $userID), array("datetime", "=", $date));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function getUpdateCompany($userID = null, $date = null){
		if($userID){
			$field = (is_numeric($userID)) ? 'companyID' : 'companyID';
			$data = $this->_db->getOne('updatelog', array($field, '=', $userID), array("datetime", "=", $date));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function getLoginCorporateTimeframe($corporateID = null, $startdate = null, $enddate = null){
		if($corporateID && $startdate && $enddate){
			$field = (is_numeric($corporateID)) ? 'corporateID' : 'companyID';
			$data = $this->_db->get2('loginlog', array($field, '=', $corporateID), array("datetime", ">=", $startdate), array("datetime", "<=", $enddate));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function getUpdateCorporateTimeframe($corporateID = null, $startdate = null, $enddate = null){
		if($corporateID && $startdate && $enddate){
			$field = (is_numeric($corporateID)) ? 'corporateID' : 'companyID';
			$data = $this->_db->get2('updatelog', array($field, '=', $corporateID), array("datetime", ">=", $startdate), array("datetime", "<=", $enddate));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function getLoginCompanyTimeframe($companyID = null, $startdate = null, $enddate = null){
		if($companyID && $startdate && $enddate){
			$field = (is_numeric($companyID)) ? 'companyID' : 'companyID';
			$data = $this->_db->get2('loginlog', array($field, '=', $companyID), array("datetime", ">=", $startdate), array("datetime", "<=", $enddate));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function getUpdateCompanyTimeframe($companyID = null, $startdate = null, $enddate = null){
		if($companyID && $startdate && $enddate){
			$field = (is_numeric($companyID)) ? 'companyID' : 'companyID';
			$data = $this->_db->get2('updatelog', array($field, '=', $companyID), array("datetime", ">=", $startdate), array("datetime", "<=", $enddate));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function insertmembership($fields = array()){
		if(!$this->_db->insert('group_member', $fields)) {
		  throw new Exception('There was a problem create the relationship.');
		}
	}

	public function deletemembership($userID = null){
		if($userID){
			$field = (is_numeric($userID)) ? 'member_id' : 'name';
			$data = $this->_db->delete('group_member', array($field, '=', $userID));
			return $data;
		}
		return false;
	}

	public function deleteUser($userID = null){
		if($userID){
			$field = (is_numeric($userID)) ? 'userID' : 'name';
			$data = $this->_db->delete('user', array($field, '=', $userID));
			return $data;
		}
		return false;
	}

	public function update($fields = array(), $id = null, $dependID = null){
		if (!$this->_db->update('user', $id, $fields, $dependID)) {
		  throw new Exception('There was a problem updating the profile.');
		}
	}

	public function upgradeSetup($fields = array(), $id = null, $dependID = null){
		if (!$this->_db->update('user', $id, $fields, $dependID)) {
		  throw new Exception('There was a problem upgrade the user detail.');
		}
	}
	
	public function searchOnly($userID = null){
		if($userID){
			$field = (is_numeric($userID)) ? 'userID' : 'email';
			$data = $this->_db->get('user', array($field, '=', $userID));
			
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchTwo($email = null, $vkey = null){
		if($email && $vkey){
			$fieldemail = 'email';
			$fieldvkey = 'vkey';
			$verified = false;
			$data = $this->_db->getTwo('user', array($fieldemail, '=', $email), array($fieldvkey, '=', $vkey), $verified);
			
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchChiefToBecomeLeader($corporateID = null, $userrole = null){
		if($corporateID && $userrole){
			$fieldecorporateID = 'corporateID';
			$fieldrole = 'role';
			$verified = true;
			$data = $this->_db->getTwo('user', array($fieldecorporateID, '=', $corporateID), array($fieldrole, '=', $userrole), $verified);
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchSuperiorToBecomeLeader($corporateID = null, $userrole = null){
		if($corporateID && $userrole){
			$fieldecorporateID = 'corporateID';
			$fieldrole = 'role';
			$verified = true;
			$data = $this->_db->getTwo('user', array($fieldecorporateID, '=', $corporateID), array($fieldrole, '=', $userrole), $verified);
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchSuperiorToBecomeLeaderCompany($corporateID = null, $userrole = null){
		if($corporateID && $userrole){
			$fieldecorporateID = 'companyID';
			$fieldrole = 'role';
			$verified = true;
			$data = $this->_db->getTwo('user', array($fieldecorporateID, '=', $corporateID), array($fieldrole, '=', $userrole), $verified);
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchManagerToBecomeLeader($corporateID = null, $userrole = null){
		if($corporateID && $userrole){
			$fieldecorporateID = 'corporateID';
			$fieldrole = 'role';
			$verified = true;
			$data = $this->_db->getTwo('user', array($fieldecorporateID, '=', $corporateID), array($fieldrole, '=', $userrole), $verified);
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchManagerToBecomeLeaderCompany($corporateID = null, $userrole = null){
		if($corporateID && $userrole){
			$fieldecorporateID = 'companyID';
			$fieldrole = 'role';
			$verified = true;
			$data = $this->_db->getTwo('user', array($fieldecorporateID, '=', $corporateID), array($fieldrole, '=', $userrole), $verified);
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchSuperadmin(){
		$field = "superadmin";
		$superadmin = true;
		$data = $this->_db->get('user', array($field, '=', $superadmin));
		
		if($data->count()){
			$this->_data = $data->results();
			return $this->_data;
		}
		return false;
	}

	public function searchSupervisor($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'yoursupervisor' : 'email';
			$data = $this->_db->getOne('user', array($field, '=', $id), array("status", "=", "Active"));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchBecomeSupervisorCorporate($corporateID = null){
		if($corporateID){
			$fieldecorporateID = (is_numeric($corporateID)) ? 'corporateID' : 'email';
			$fieldsupervisor = "becomesupervisor";
			$supervisor = true;
			$verified = true;
			$data = $this->_db->getTwo('user', array($fieldecorporateID, '=', $corporateID), array($fieldsupervisor, '=', $supervisor), $verified);
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchBecomeSupervisorCompany($companyID = null){
		if($companyID){
			$fieldecorporateID = (is_numeric($companyID)) ? 'companyID' : 'email';
			$fieldsupervisor = "becomesupervisor";
			$supervisor = true;
			$verified = true;
			$data = $this->_db->getTwo('user', array($fieldecorporateID, '=', $companyID), array($fieldsupervisor, '=', $supervisor), $verified);
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchWithCompany($companyID = null){
		if($companyID){
			$field = (is_numeric($companyID)) ? 'companyID' : 'email';
			$data = $this->_db->get('user', array($field, '=', $companyID));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchWithCompanyOKR($companyID = null){
		if($companyID){
			$field = (is_numeric($companyID)) ? 'companyID' : 'email';
			$data = $this->_db->getOne('user', array($field, '=', $companyID), array('status', '=', 'Active'));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchWithCorporate($corporateID = null){
		if($corporateID){
			$field = (is_numeric($corporateID)) ? 'corporateID' : 'email';
			$data = $this->_db->get('user', array($field, '=', $corporateID));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchWithCorporateOKR($corporateID = null){
		if($corporateID){
			$field = (is_numeric($corporateID)) ? 'corporateID' : 'email';
			$data = $this->_db->getOne('user', array($field, '=', $corporateID), array('status', '=', 'Active'));
			
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
		return false;
	}

	public function searchAllUser(){
		$field = "superadmin";
		$superadmin = false;
		$data = $this->_db->get('user', array($field, '=', $superadmin));
		if($data->count()){
			$this->_data = $data->results();
			return $this->_data;
		}
		return false;
	}

	

	public function verify($email = null, $vkey = null)
	{
		$to = $email;
		$subject = "Profile Verification";
		$txt = "http://localhost/craftgoal/register.php?email=".$email."&vkey=".$vkey;
		$headers = "From: admin@doer.com";
		 
		try{
			mail($to,$subject,$txt,$headers);
		}catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function forgetpassword($email = null, $password = null)
	{
		$to = $email;
		$subject = "New Password";
		$txt = "Your latest password for email ".$email." is ".$password;
		$headers = "From: admin@doer.com";
		 
		try{
			mail($to,$subject,$txt,$headers);
		}catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
	public function login($email = null, $password = null, $remember = false){
		if(!$email && !$password && $this->exists() ){
			Session::put($this->_sessionName, $this->data()->userID);
		}else{
			$user = $this->find($email);
			if($user){
				if($this->data()->password === $password){
					Session::put($this->_sessionName, $this->data()->userID);
					
					if($remember){
						$hash = Hash::unique();
						$hashCheck = $this->_db->get('user_session', array('user_id', '=', $this->data()->userID));
						
						if(!$hashCheck->count()){
							$this->_db->insert('user_session', array(
								'user_id' => $this->data()->userID,
								'hash' => $hash
							));
						}else{
							$hash = $hashCheck->first()->hash;
						}
						
						Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
					}
					return true;
				}
			}			
		}
		return false;
	}
	
	public function exists(){
		return (!empty($this->_data)) ? true : false;
	}
	
	public function logout(){
		$this->_db->delete('user_session', array('user_id', '=', $this->data()->userID));
		Session::delete($this->_sessionName);
		Cookie::delete($this->_cookieName);
	}
	
	public function data(){
		return $this->_data;
	}
	
	public function isLoggedIn(){
		return $this->_isLoggedIn;
	}

	public function searchUserID($userID = null){
	        if($userID){
	            $data = $this->_db->get('user', array("userID", '=', $userID));
	            if($data->count()){
	                $this->_data = $data->results();
	                return $this->_data;
	            }
	        }
	        return false;
	    }

}
?>