<?php
	require_once("HealthCenterAPI.php");

	$healthAPIInstnace = new HealthCenterAPI();
	
	$person_name = $_REQUEST['personName'];
	$case_date = $_REQUEST['case_date'];
	$gender = $_REQUEST['gender'];
	$yearGroup = $_REQUEST['yeargroup'];
	$facultyorstaff = $_REQUEST['facultystaff'];
	$nationality = $_REQUEST['nationlity'];
	$mastercard = $_REQUEST['mastercard'];
	$condition = $_REQUEST['condition'];
	$details = $_REQUEST['details'];
	$remedy = $_REQUEST['remedy'];

	$condition = strtolower($condition);

	$reply = $healthAPIInstnace->saveCase($person_name, $case_date, $gender, $yearGroup,
		 $facultyorstaff,$nationality,$mastercard,$condition,$details,$remedy);

	echo $reply;
?>