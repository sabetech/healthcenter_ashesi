<?php
	require_once("HealthCenterAPI.php");

	$healthAPIInstnace = new HealthCenterAPI();
	
	$fromMonth = $_REQUEST['fromMonth'];
	$fromYear = $_REQUEST['fromYear'];
	$toMonth = $_REQUEST['toMonth'];
	$toYear = $_REQUEST['toYear'];
	
	$fromYearGroup = $_REQUEST['fromYearGroup'];
	$toYearGroup = $_REQUEST['toYearGroup'];

	$response = $healthAPIInstnace->generateDemInfo($fromMonth, $fromYear, $toMonth, $toYear, $fromYearGroup,$toYearGroup);

	if ($response == 'failure'){
		echo $response;	
	}else{
		echo $response;
	}
	

?>