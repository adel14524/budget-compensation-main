<?php
require_once 'core/init.php';
if(Input::exists()){
	$transfercompanyid = escape(Input::get('transfercompanyid'));
	$transfercorporateID = escape(Input::get('transfercorporatename'));

	function exists($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}

	function condition($data1, $data2){
		if($data1 === "Valid" && $data2 === "Valid"){
			return "Passed";
		}else{
			return "Failed";
		}
	}

	$transfercorporateIDerror = exists($transfercorporateID);
	$transfercompanyiderror = exists($transfercompanyid);

	

	$condition = condition($transfercorporateIDerror, $transfercompanyiderror);

	if($condition === "Passed"){
		$companyobject = new Company();
		$companyresult = $companyobject->searchCompany($transfercompanyid);
		if($companyresult){

			$companyobject->updateCompany(array(
				"corporateID" => $transfercorporateID,
				"scale" => null,
				"package" => null,
				"expiredate" => null
			), $transfercompanyid, "companyID");

			$userobject = new User();
			$userobject->upgradeSetup(array(
				"corporateID" => $transfercorporateID,
			), $transfercompanyid ,"companyID");

			$groupobject = new Group();
			$groupobject->updateGroup(array(
				"corporateID" => $transfercorporateID,
			), $transfercompanyid, "companyID");

			$userobject->upgradelog(array(
				"corporateID" => $transfercorporateID,
			), $transfercompanyid ,"companyID");

			$userobject->upgradeuserchangelog(array(
				"corporateID" => $transfercorporateID,
			), $transfercompanyid ,"companyID");

			$objectiveobject = new Objective();
			$objectiveobject->updateObjective(array(
				"corporateID" => $transfercorporateID,
			), $transfercompanyid ,"companyID");

			$timeframeobject = new Timeframe();
			$timeframeobject->editTimeframe(array(
				"corporateID" => $transfercorporateID,
			), $transfercompanyid ,"companyID");

			$userobject->upgradeupdatelog(array(
				"corporateID" => $transfercorporateID,
			), $transfercompanyid ,"companyID");

		}


		$array = [
			"condition" => $condition
		];
	}else{
		$array = [
			"transfer" => $transfercorporateIDerror,
			"condition" => $condition
		];
	}

	echo json_encode($array);
}
?>