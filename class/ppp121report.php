<?php
class Ppp121report{
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

	public function submitPPP($fields = array()){
		if(!$this->_db->insert('report_ppp', $fields)) {
		  throw new Exception('There was a problem adding a PPP.');
		}
	}

	public function submitPPPtemplatecat($fields = array()){
		if(!$this->_db->insert('report_ppp_templatecat', $fields)) {
		  throw new Exception('There was a problem adding a PPP template category.');
		}
	}

	public function submitPPPattach($fields = array()){
		if(!$this->_db->insert('report_ppp_attach', $fields)) {
		  throw new Exception('There was a problem adding a PPP attachment.');
		}
	}

	public function submit121($fields = array()){
		if(!$this->_db->insert('report_121', $fields)) {
		  throw new Exception('There was a problem adding a 1 to 1.');
		}
	}

	public function submit121templatecat($fields = array()){
		if(!$this->_db->insert('report_121_templatecat', $fields)) {
		  throw new Exception('There was a problem adding a 1 to 1 template category.');
		}
	}

	public function submit121attach($fields = array()){
		if(!$this->_db->insert('report_121_attach', $fields)) {
		  throw new Exception('There was a problem adding a 1 to 1 attachment.');
		}
	}

	public function evaluatePPP($fields = array(), $id = null, $pppID){
		if (!$this->_db->update('report_ppp', $id, $fields, $pppID)) {
		  throw new Exception('There was a problem evaluate PPP.');
		}
	}

	public function searchOnlyPPP($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'pppID' : 'keyresult';
			$data = $this->_db->get('report_ppp', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchPPPtemplateusage($pppID = null, $type = null){
		if($pppID && $type){
			$pppIDfield = "pppID";
			$typefield = "type";
			$data = $this->_db->getOne('report_ppp_templatecat', array($pppIDfield, '=', $pppID), array($typefield, '=', $type));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function search121templateusage($otoID = null, $type = null){
		if($otoID && $type){
			$otoIDfield = "121ID";
			$typefield = "type";
			$data = $this->_db->getOne('report_121_templatecat', array($otoIDfield, '=', $otoID), array($typefield, '=', $type));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}








	public function searchPPPSVdashboard($userID = null, $supervisorID = null, $date = null){
		if($userID && $supervisorID && $date){
			$userIDfield = "userID"; 
			$supervisorIDfield = "supervisorID";
			$datefield = "submitat";
			$data = $this->_db->get2('report_ppp', array($userIDfield, '=', $userID), array($supervisorIDfield, '=', $supervisorID), array($datefield, '>=', $date));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function search121SVdashboard($userID = null, $supervisorID = null, $date = null){
		if($userID && $supervisorID && $date){
			$userIDfield = "userID"; 
			$supervisorIDfield = "supervisorID";
			$datefield = "submitat";
			$data = $this->_db->get2('report_121', array($userIDfield, '=', $userID), array($supervisorIDfield, '=', $supervisorID), array($datefield, '>=', $date));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}



	public function searchPPPtraineelist($supervisorID = null, $date1 = null, $date2 = null){
		if($supervisorID && $date1 && $date2){
			$supervisorIDfield = "supervisorID";
			$datefield = "submitat";
			$data = $this->_db->get2('report_ppp', array($supervisorIDfield, '=', $supervisorID), array($datefield, '>=', $date1), array($datefield, '<=', $date2));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function search121traineelist($supervisorID = null, $date1 = null, $date2 = null){
		if($supervisorID && $date1 && $date2){
			$supervisorIDfield = "supervisorID";
			$datefield = "submitat";
			$data = $this->_db->get2('report_121', array($supervisorIDfield, '=', $supervisorID), array($datefield, '>=', $date1), array($datefield, '<=', $date2));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}


	public function searchPPPreportlist($userID = null, $date1 = null, $date2 = null){
		if($userID && $date1 && $date2){
			$userIDfield = "userID";
			$datefield = "submitat";
			$data = $this->_db->get2('report_ppp', array($userIDfield, '=', $userID), array($datefield, '>=', $date1), array($datefield, '<=', $date2));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function search121reportlist($userID = null, $date1 = null, $date2 = null){
		if($userID && $date1 && $date2){
			$userIDfield = "userID";
			$datefield = "submitat";
			$data = $this->_db->get2('report_121', array($userIDfield, '=', $userID), array($datefield, '>=', $date1), array($datefield, '<=', $date2));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}


















	public function searchPPPtraineeOnetimeframe($userID = null, $supervisorID = null, $date = null, $type = null){
		if($userID && $supervisorID && $date && $type){
			$userIDfield = "userID"; 
			$supervisorIDfield = "supervisorID";
			$datefield = "submitat";
			$typefield = "timeframe";
			$data = $this->_db->get3('report_ppp', array($userIDfield, '=', $userID), array($supervisorIDfield, '=', $supervisorID), array($datefield, '=', $date), array($typefield, '=', $type));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchPPPtraineeTwotimeframe($userID = null, $supervisorID = null, $date1 = null, $date2 = null, $type = null){
		if($userID && $supervisorID && $date1 && $date2 && $type){
			$userIDfield = "userID"; 
			$supervisorIDfield = "supervisorID";
			$datefield = "submitat";
			$typefield = "timeframe";
			$data = $this->_db->get4('report_ppp', array($userIDfield, '=', $userID), array($supervisorIDfield, '=', $supervisorID), array($datefield, '>=', $date1), array($datefield, '<=', $date2), array($typefield, '=', $type));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchPPPtraineeOnetimeframeSV($supervisorID = null, $date = null, $type = null){
		if($supervisorID && $date && $type){
			$supervisorIDfield = "supervisorID";
			$datefield = "submitat";
			$typefield = "timeframe";
			$data = $this->_db->get2('report_ppp', array($supervisorIDfield, '=', $supervisorID), array($datefield, '=', $date), array($typefield, '=', $type));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchPPPtraineeTwotimeframeSV($supervisorID = null, $date1 = null, $date2 = null, $type = null){
		if($supervisorID && $date1 && $date2 && $type){
			$supervisorIDfield = "supervisorID";
			$datefield = "submitat";
			$typefield = "timeframe";
			$data = $this->_db->get3('report_ppp', array($supervisorIDfield, '=', $supervisorID), array($datefield, '>=', $date1), array($datefield, '<=', $date2), array($typefield, '=', $type));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function approve121($fields = array(), $id = null, $onetooneID){
		if (!$this->_db->update('report_121', $id, $fields, $onetooneID)) {
		  throw new Exception('There was a problem at 1 to 1 approval.');
		}
	}

	public function comment121($fields = array(), $id = null, $onetooneID){
		if (!$this->_db->update('report_121', $id, $fields, $onetooneID)) {
		  throw new Exception('There was a problem comment 1 to 1.');
		}
	}

	public function searchOnly121($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'onetooneID' : 'keyresult';
			$data = $this->_db->get('report_121', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function search121traineeOnetimeframe($userID = null, $supervisorID = null, $date = null, $type = null){
		if($userID && $supervisorID && $date && $type){
			$userIDfield = "userID"; 
			$supervisorIDfield = "supervisorID";
			$datefield = "submitat";
			$typefield = "timeframe";
			$data = $this->_db->get3('report_121', array($userIDfield, '=', $userID), array($supervisorIDfield, '=', $supervisorID), array($datefield, '=', $date), array($typefield, '=', $type));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function search121traineeTwotimeframe($userID = null, $supervisorID = null, $date1 = null, $date2 = null, $type = null){
		if($userID && $supervisorID && $date1 && $date2 && $type){
			$userIDfield = "userID"; 
			$supervisorIDfield = "supervisorID";
			$datefield = "submitat";
			$typefield = "timeframe";
			$data = $this->_db->get4('report_121', array($userIDfield, '=', $userID), array($supervisorIDfield, '=', $supervisorID), array($datefield, '>=', $date1), array($datefield, '<=', $date2), array($typefield, '=', $type));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function search121traineeOnetimeframeSV($supervisorID = null, $date = null, $type = null){
		if($supervisorID && $date && $type){
			$supervisorIDfield = "supervisorID";
			$datefield = "submitat";
			$typefield = "timeframe";
			$data = $this->_db->get2('report_121', array($supervisorIDfield, '=', $supervisorID), array($datefield, '=', $date), array($typefield, '=', $type));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function search121traineeTwotimeframeSV($supervisorID = null, $date1 = null, $date2 = null, $type = null){
		if($supervisorID && $date1 && $date2 && $type){
			$supervisorIDfield = "supervisorID";
			$datefield = "submitat";
			$typefield = "timeframe";
			$data = $this->_db->get3('report_121', array($supervisorIDfield, '=', $supervisorID), array($datefield, '>=', $date1), array($datefield, '<=', $date2), array($typefield, '=', $type));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchAllPostMortemSupervisor($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'supervisorID' : 'keyresult';
			$data = $this->_db->get('report_postmortem', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchAllPostMortemTrainee($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'userID' : 'keyresult';
			$data = $this->_db->get('report_postmortem', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchOnlyPostMortem($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'postmortemID' : 'keyresult';
			$data = $this->_db->get('report_postmortem', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function requestPostmortem($fields = array()){
		if(!$this->_db->insert('report_postmortem', $fields)) {
		  throw new Exception('There was a problem request Post Mortem.');
		}
	}

	public function replyPostmortem($fields = array(), $id = null, $postmortemID){
		if (!$this->_db->update('report_postmortem', $id, $fields, $postmortemID)) {
		  throw new Exception('There was a problem reply Post Mortem.');
		}
	}

	public function searchOnlyPPPAttachment($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'pppattachID' : 'keyresult';
			$data = $this->_db->get('report_ppp_attach', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchPPPAttachment($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'pppID' : 'keyresult';
			$data = $this->_db->get('report_ppp_attach', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function search121Attachment($id = null){
		if($id){
			$field = (is_numeric($id)) ? '121ID' : 'keyresult';
			$data = $this->_db->get('report_121_attach', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchOnly121Attachment($id = null){
		if($id){
			$field = (is_numeric($id)) ? 'otoattachID' : 'keyresult';
			$data = $this->_db->get('report_121_attach', array($field, '=', $id));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

}
?>