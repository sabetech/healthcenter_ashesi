<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
	<head>
		<meta charset="utf-8">
	    <meta name="viewport" content="target-densitydpi=device-dpi, width=device-width, initial-scale=1.0, maximum-scale=1">
	    <meta name="description" content="Health Center Recording System">
	    <meta name="author" content="Albert Kofi Mensah-Ansah">

     	<link href="css/modern.css" rel="stylesheet">
		<link href="css/modern-responsive.css" rel="stylesheet">
	 	<link href="css/site.css" rel="stylesheet" type="text/css">


	 	<script type="text/javascript" src="js/assets/jquery-1.9.0.min.js"></script>
	    <script type="text/javascript" src="js/assets/jquery.mousewheel.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.10/js/jquery-ui-1.10.3.custom.min.js"></script>
	    <script type="text/javascript" src="js/assets/moment.js"></script>
	    <script type="text/javascript" src="js/assets/moment_langs.js"></script>

	    <script type="text/javascript" src="js/modern/dropdown.js"></script>
	    <script type="text/javascript" src="js/modern/accordion.js"></script>
	    <script type="text/javascript" src="js/modern/buttonset.js"></script>
	    <script type="text/javascript" src="js/modern/carousel.js"></script>
	    <script type="text/javascript" src="js/modern/input-control.js"></script>
	    <script type="text/javascript" src="js/modern/pagecontrol.js"></script>
	    <script type="text/javascript" src="js/modern/rating.js"></script>
	    <script type="text/javascript" src="js/modern/slider.js"></script>
	    <script type="text/javascript" src="js/modern/tile-slider.js"></script>
	    <script type="text/javascript" src="js/modern/tile-drag.js"></script>
	    <script type="text/javascript" src="js/modern/calendar.js"></script>
	    <script type="text/javascript" src="js/holder/holder.js"></script>
	    <script type="text/javascript" src="Chart.js-master/Chart.js"></script>

	    <script type = "text/javascript">


	    	var currentContentDiv = "#divOverview";

	    	function switchContentDiv(divName, switchSpeed){
				$(currentContentDiv).fadeOut(switchSpeed, function(){
					$(divName).fadeIn(switchSpeed, function(){
						currentContentDiv = divName;
					});
				});
			}

			$(document).ready(function(){
	    		switchContentDiv("#divOverview",200);
	    	});

			function displayNotice(msg,msgType){
				$("#errMsgDiv").css('box-shadow','10px 10px 5px #888888');
				document.getElementById('errMsgDiv').style.position = 'fixed';
				
				$("#errMsgDiv").addClass("bg-color-green fg-color-white");
				
				$("#confirmation").html(msgType);
				$("#msg").html(msg);
				$("#errBackGrnd").fadeIn(100);
				$("#errMsgDiv").fadeIn(200);

				closeDialog();
			}
	
			function displayError(msg,msgType){
				$("#errMsgDiv").css('box-shadow','10px 10px 5px #888888');
				document.getElementById('errMsgDiv').style.position = 'fixed';
				
				$("#errMsgDiv").addClass("bg-color-red fg-color-white");
				
				$("#confirmation").html(msgType);
				$("#msg").html(msg);
				$("#errBackGrnd").fadeIn(100);
				$("#errMsgDiv").fadeIn(200);

				closeDialog();
			}

			function closeDialog(){
				$("#closemsg").click(function(){
					$("#errMsgDiv").removeClass("bg-color-green bg-color-red fg-color-white");
					$("#errBackGrnd").fadeOut();
					$("#errMsgDiv").fadeOut();
				});
			}
	    </script>

		<title>Health Center</title>
	</head>