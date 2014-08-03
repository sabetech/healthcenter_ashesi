<?php
	
	require_once("HealthCenterAPI.php");

	$healthAPIInstnace = new HealthCenterAPI();
	
	
	$fromdate = $_REQUEST['fromdate'];
	$todate = $_REQUEST['toDate'];

	$response = $healthAPIInstnace->getCases($fromdate, $todate);

	echo $response;

?>