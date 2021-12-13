<?php
class Pppoooreport{
	private $_data,
			$_db,
			$_id;
	
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
	
	public function addMonthlyPlan($fields = array()){
		if(!$this->_db->insert('p_monthly_plan', $fields)) {
		  throw new Exception('There was a problem adding a plan.');
		}
	}

	public function addPPPSVQuestionreply($fields = array()){
		if(!$this->_db->insert('p_question_reply', $fields)) {
		  throw new Exception('There was a problem adding a question reply.');
		}
	}
	
	public function updateMonthlyPlan($fields = array(), $id = null, $planID){
		if (!$this->_db->update('p_monthly_plan', $id, $fields, $planID)) {
		  throw new Exception('There was a problem updating plan.');
		}
	}

	public function submitWeeklyPPP($fields = array(), $id = null, $pppID){
		if (!$this->_db->update('p_ppp', $id, $fields, $pppID)) {
		  throw new Exception('There was a problem submit weekly ppp.');
		}
	}

	public function searchMonthlyPlan($userID = null, $month = null, $year = null){
		if($userID && $month && $year){
			$data = $this->_db->get2('p_monthly_plan', array("userID", '=', $userID), array("month", '=', $month), array("year", '=', $year));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchOnlyMonthlyPlan($ppp_monthly_ID = null){
		if($ppp_monthly_ID){
			$data = $this->_db->get('p_monthly_plan', array("ppp_monthly_ID", '=', $ppp_monthly_ID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchAllMonthlyPlan($userID = null){
		if($userID){
			$data = $this->_db->get('p_monthly_plan', array("userID", '=', $userID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function addCategory($fields = array()){
		if(!$this->_db->insert('p_category', $fields)) {
		  throw new Exception('There was a problem adding a category.');
		}
	}

	public function addCategoryUsage($fields = array()){
		if(!$this->_db->insert('p_category_usage', $fields)) {
		  throw new Exception('There was a problem adding a category usage.');
		}
	}

	public function addAttachOKR($fields = array()){
		if(!$this->_db->insert('p_ppp_okr', $fields)) {
		  throw new Exception('There was a problem adding a PPP OKR attach.');
		}
	}

	public function updateCategory($fields = array(), $id = null, $planID){
		if (!$this->_db->update('p_category', $id, $fields, $planID)) {
		  throw new Exception('There was a problem updating category.');
		}
	}

	public function updateCategoryUsage($fields = array(), $id = null, $planID){
		if (!$this->_db->update('p_category_usage', $id, $fields, $planID)) {
		  throw new Exception('There was a problem updating category usage.');
		}
	}

	public function updatePPPOKRAttach($fields = array(), $id = null, $planID){
		if (!$this->_db->update('p_ppp_okr', $id, $fields, $planID)) {
		  throw new Exception('There was a problem updating okr attach.');
		}
	}

	public function searchOnlyCategory($ppp_category_ID = null){
		if($ppp_category_ID){
			$data = $this->_db->get('p_category', array("ppp_category_ID", '=', $ppp_category_ID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchAllCategory($userID = null){
		if($userID){
			$data = $this->_db->get('p_category', array("userID", '=', $userID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchAllAttachOKR($ppp_ID = null){
		if($ppp_ID){
			$data = $this->_db->get('p_ppp_okr', array("ppp_ID", '=', $ppp_ID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchCategoryUsage($pppID = null){
		if($pppID){
			$data = $this->_db->get('p_category_usage', array("p_ppp_day_ID", '=', $pppID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchOnlyCategoryUsage($pppID = null){
		if($pppID){
			$data = $this->_db->get('p_category_usage', array("p_category_usage_ID", '=', $pppID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchCategoryUsageBefore($dayID = null, $catID = null){
		if($dayID && $catID){
			$data = $this->_db->getOne('p_category_usage', array("p_ppp_day_ID", '=', $dayID), array("p_category_ID", '=', $catID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchOKRAttachBefore($ppp_ID = null, $okr_ID = null, $kr_ID = null){
		if($ppp_ID && $okr_ID && $kr_ID){
			$data = $this->_db->get2('p_ppp_okr', array("ppp_ID", '=', $ppp_ID), array("okr_ID", '=', $okr_ID), array("kr_ID", '=', $kr_ID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchOnlyOKRAttach($ppp_ID = null){
		if($ppp_ID){
			$data = $this->_db->get('p_ppp_okr', array("p_ppp_okr_ID", '=', $ppp_ID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function deleteCategory($ppp_category_ID = null){
		if($ppp_category_ID){
			$data = $this->_db->delete('p_category', array("ppp_category_ID", '=', $ppp_category_ID));
			return $data;
		}
		return false;
	}

	public function addQuestion($fields = array()){
		if(!$this->_db->insert('p_question', $fields)) {
		  throw new Exception('There was a problem adding a question.');
		}
	}

	public function updateQuestion($fields = array(), $id = null, $questionID){
		if (!$this->_db->update('p_question', $id, $fields, $questionID)) {
		  throw new Exception('There was a problem updating question.');
		}
	}

	public function searchOnlyQuestion($questionID = null){
		if($questionID){
			$data = $this->_db->get('p_question', array("ppp_questions_ID", '=', $questionID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchAllQuestion($userID = null){
		if($userID){
			$data = $this->_db->get('p_question', array("userID", '=', $userID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchQuestionReply($pppID = null){
		if($pppID){
			$data = $this->_db->get('p_question_reply', array("ppp_ID", '=', $pppID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function deleteQuestion($questionID = null){
		if($questionID){
			$data = $this->_db->delete('p_question', array("ppp_questions_ID", '=', $questionID));
			return $data;
		}
		return false;
	}

	public function addPPPUser($fields = array()){
		if(!$this->_db->insert('p_superior_user', $fields)) {
		  throw new Exception('There was a problem adding a PPP relationship.');
		}
	}

	public function updatePPPUser($fields = array(), $id = null, $questionID){
		if (!$this->_db->update('p_superior_user', $id, $fields, $questionID)) {
		  throw new Exception('There was a problem updating PPP relationship.');
		}
	}

	public function searchOnlyPPPUser($questionID = null){
		if($questionID){
			$data = $this->_db->get('p_superior_user', array("p_superior_user_ID", '=', $questionID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchOnlyPPPUserbySVandTrainee($superiorID = null, $userID = null){
		if($superiorID && $userID){
			$data = $this->_db->getOne('p_superior_user', array("superiorID", '=', $superiorID), array("userID", '=', $userID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchAllPPPSuperior($userID = null){
		if($userID){
			$data = $this->_db->get('p_superior_user', array("superiorID", '=', $userID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchAllPPPUser($userID = null){
		if($userID){
			$data = $this->_db->get('p_superior_user', array("userID", '=', $userID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function deletePPPUser($questionID = null){
		if($questionID){
			$data = $this->_db->delete('p_superior_user', array("p_superior_user_ID", '=', $questionID));
			return $data;
		}
		return false;
	}

	public function addPPP($fields = array()){
		if(!$this->_db->insert('p_ppp', $fields)) {
		  throw new Exception('There was a problem adding a ppp.');
		}
	}

	public function addoneonone($fields = array()){
		if(!$this->_db->insert('p_onetoone', $fields)) {
		  throw new Exception('There was a problem adding a one on one.');
		}
	}

	public function addtalkingpoint($fields = array()){
		if(!$this->_db->insert('p_onetoone_talkingpoint', $fields)) {
		  throw new Exception('There was a problem adding a one on one talking point.');
		}
	}

	public function addActionItem($fields = array()){
		if(!$this->_db->insert('p_onetoone_actionitems', $fields)) {
		  throw new Exception('There was a problem adding a one on one Action Item.');
		}
	}

	public function addPPPHistory($fields = array()){
		if(!$this->_db->insert('p_ppp_history', $fields)) {
		  throw new Exception('There was a problem adding a ppp history.');
		}
	}

	public function addPPPDays($fields = array()){
		if(!$this->_db->insert('p_ppp_day', $fields)) {
		  throw new Exception('There was a problem adding a ppp history.');
		}
	}

	public function addPPPDailyPlan($fields = array()){
		if(!$this->_db->insert('p_ppp_plan', $fields)) {
		  throw new Exception('There was a problem adding a ppp plan.');
		}
	}

	public function addPPPProblem($fields = array()){
		if(!$this->_db->insert('p_ppp_problems', $fields)) {
		  throw new Exception('There was a problem adding a ppp problem.');
		}
	}

	public function addPPPComment($fields = array()){
		if(!$this->_db->insert('p_ppp_comments', $fields)) {
		  throw new Exception('There was a problem adding a ppp problem.');
		}
	}

	public function addPPPLikes($fields = array()){
		if(!$this->_db->insert('p_ppp_likes', $fields)) {
		  throw new Exception('There was a problem adding a ppp likes.');
		}
	}

	public function updatePPP($fields = array(), $id = null, $ppp_ID){
		if (!$this->_db->update('p_ppp', $id, $fields, $ppp_ID)) {
		  throw new Exception('There was a problem updating ppp.');
		}
	}

	public function updateOOO($fields = array(), $id = null, $ppp_ID){
		if (!$this->_db->update('p_onetoone', $id, $fields, $ppp_ID)) {
		  throw new Exception('There was a problem updating one on one.');
		}
	}

	public function updateOOOTalkingPoint($fields = array(), $id = null, $ppp_ID){
		if (!$this->_db->update('p_onetoone_talkingpoint', $id, $fields, $ppp_ID)) {
		  throw new Exception('There was a problem updating one on one talkingpoint.');
		}
	}

	public function updateOOOActionItem($fields = array(), $id = null, $ppp_ID){
		if (!$this->_db->update('p_onetoone_actionitems', $id, $fields, $ppp_ID)) {
		  throw new Exception('There was a problem updating one on one actionitem.');
		}
	}

	public function updatePPPProblem($fields = array(), $id = null, $ppp_ID){
		if (!$this->_db->update('p_ppp_problems', $id, $fields, $ppp_ID)) {
		  throw new Exception('There was a problem updating ppp problem.');
		}
	}

	public function updatePPPPlan($fields = array(), $id = null, $ppp_ID){
		if (!$this->_db->update('p_ppp_plan', $id, $fields, $ppp_ID)) {
		  throw new Exception('There was a problem updating ppp plan.');
		}
	}

	public function searchOnlyPPP($ppp_ID = null){
		if($ppp_ID){
			$data = $this->_db->get('p_ppp', array("ppp_ID", '=', $ppp_ID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchOnlyOneOnOne($oooID = null){
		if($oooID){
			$data = $this->_db->get('p_onetoone', array("p_onetoone_ID", '=', $oooID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchOnlyOOOTalkingPoint($onetooneID = null){
		if($onetooneID){
			$data = $this->_db->get('p_onetoone_talkingpoint', array("talkingpointID", '=', $onetooneID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchOnlyOOOActionItems($onetooneID = null){
		if($onetooneID){
			$data = $this->_db->get('p_onetoone_actionitems', array("actionitemID", '=', $onetooneID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchOOOActionItems($onetooneID = null){
		if($onetooneID){
			$data = $this->_db->get('p_onetoone_actionitems', array("p_onetoone_ID", '=', $onetooneID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchOOOTalkingPoint($onetooneID = null, $userID = null){
		if($onetooneID && $userID){
			$data = $this->_db->getOne('p_onetoone_talkingpoint', array("onetooneID", '=', $onetooneID), array("userID", '=', $userID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchOneOnOne_1($status = null, $userID = null){
		if($status && $userID){
			$data = $this->_db->get2_1('p_onetoone', array("status", '=', $status), array("receiver_ID", '=', $userID), array("initiator_ID", '=', $userID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchOneOnOne($status = null, $userID = null){
		if($status && $userID){
			$data = $this->_db->getOne('p_onetoone', array("status", '=', $status), array("receiver_ID", '=', $userID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchOneOnOneSV($status = null, $userID = null){
		if($status && $userID){
			$data = $this->_db->getOne('p_onetoone', array("status", '=', $status), array("initiator_ID", '=', $userID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchOnlyPPPProblem($ppp_ID = null){
		if($ppp_ID){
			$data = $this->_db->get('p_ppp_problems', array("p_ppp_problem_ID", '=', $ppp_ID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchOnlyPPPPlan($ppp_ID = null){
		if($ppp_ID){
			$data = $this->_db->get('p_ppp_plan', array("p_ppp_plan_ID", '=', $ppp_ID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchOnlyPPPDay($ppp_ID = null){
		if($ppp_ID){
			$data = $this->_db->get('p_ppp_day', array("p_ppp_day_ID", '=', $ppp_ID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchPPPDailyPlan($ppp_ID = null){
		if($ppp_ID){
			$data = $this->_db->get('p_ppp_plan', array("p_ppp_day_ID", '=', $ppp_ID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchPPPDailyComment($ppp_ID = null){
		if($ppp_ID){
			$data = $this->_db->get('p_ppp_comments', array("ppp_days_ID", '=', $ppp_ID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchPPPDailylikes($ppp_ID = null){
		if($ppp_ID){
			$data = $this->_db->get('p_ppp_likes', array("ppp_days_ID", '=', $ppp_ID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchPPPDailylikeswithtypes($ppp_ID = null, $type = null){
		if($ppp_ID && $type){
			$data = $this->_db->getOne('p_ppp_likes', array("ppp_days_ID", '=', $ppp_ID), array("type", '=', $type));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchPPPlikes($ppp_ID = null){
		if($ppp_ID){
			$data = $this->_db->get('p_ppp_likes', array("ppp_ID", '=', $ppp_ID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchPPPlikeswithtype($ppp_ID = null, $type = null){
		if($ppp_ID && $type){
			$data = $this->_db->getOne('p_ppp_likes', array("ppp_ID", '=', $ppp_ID), array("type", '=', $type));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchPPPHistory($ppp_ID = null){
		if($ppp_ID){
			$data = $this->_db->get('p_ppp_history', array("p_ppp_ID", '=', $ppp_ID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchPPPDays($ppp_ID = null){
		if($ppp_ID){
			$data = $this->_db->get('p_ppp_day', array("p_ppp_ID", '=', $ppp_ID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchPPPComments($ppp_ID = null){
		if($ppp_ID){
			$data = $this->_db->get('p_ppp_comments', array("ppp_ID", '=', $ppp_ID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchPPPProblem($ppp_ID = null){
		if($ppp_ID){
			$data = $this->_db->get('p_ppp_problems', array("p_ppp_ID", '=', $ppp_ID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchOnlyPPPbytimeandSV($startdate = null, $enddate = null, $reviewerID = null, $userID = null){
		if($startdate && $enddate && $reviewerID && $userID){
			$data = $this->_db->get3('p_ppp', array("startdate", '>=', $startdate), array("enddate", '<=', $enddate), array("reviewerID", '=', $reviewerID), array("userID", '=', $userID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchOnlyPPPbytimeandyourself($startdate = null, $enddate = null, $userID = null){
		if($startdate && $enddate && $userID){
			$data = $this->_db->get2('p_ppp', array("startdate", '>=', $startdate), array("enddate", '<=', $enddate), array("userID", '=', $userID));
			if($data->count()){
				$this->_data = $data->first();
				return $this->_data;
			}
		}
	}

	public function searchOnlyPPPbytimeandyourselfAll($startdate = null, $enddate = null, $userID = null){
		if($startdate && $enddate && $userID){
			$data = $this->_db->get2('p_ppp', array("startdate", '>=', $startdate), array("enddate", '<=', $enddate), array("userID", '=', $userID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchOnlyPPPbytimeandSVSubmitted($startdate = null, $enddate = null, $reviewerID = null){
		if($startdate && $enddate && $reviewerID){
			$data = $this->_db->get2('p_ppp', array("startdate", '>=', $startdate), array("enddate", '<=', $enddate), array("reviewerID", '=', $reviewerID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function searchAllPPPbyuserID($userID = null, $reviewerID = null){
		if($userID){
			$data = $this->_db->getOne('p_ppp', array("userID", '=', $userID), array("reviewerID", '=', $reviewerID));
			if($data->count()){
				$this->_data = $data->results();
				return $this->_data;
			}
		}
	}

	public function deletePPP($ppp_ID = null){
		if($ppp_ID){
			$data = $this->_db->delete('p_ppp', array("ppp_ID", '=', $ppp_ID));
			return $data;
		}
		return false;
	}

	public function deletePPPPlan($ppp_ID = null){
		if($ppp_ID){
			$data = $this->_db->delete('p_ppp_plan', array("p_ppp_plan_ID", '=', $ppp_ID));
			return $data;
		}
		return false;
	}

	public function deleteTalkingPoint($talkingpointID = null){
		if($talkingpointID){
			$data = $this->_db->delete('p_onetoone_talkingpoint', array("talkingpointID", '=', $talkingpointID));
			return $data;
		}
		return false;
	}

	public function deleteActionItem($actionitemID = null){
		if($actionitemID){
			$data = $this->_db->delete(' p_onetoone_actionitems', array("actionitemID", '=', $actionitemID));
			return $data;
		}
		return false;
	}

}
?>