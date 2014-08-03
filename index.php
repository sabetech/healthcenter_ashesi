<?php include("views/header.php"); ?>
	<body class = "metrouicss bg-color-blue" > <!--style="background-color:#ddddff;-->
		<div class="nav-bar">
		    <div class="nav-bar-inner padding10">
		        <span class="pull-menu"></span>

		        <a href="/healthcenter"><span class="element brand">
		            <img class="place-left" src="images/logo32.png" style="height: 20px">
		            Ashesi Health Center <small>v 1</small>
		        </span></a>

		        <div class="divider"></div>

		    </div>
		</div>
	<div class="page secondary with-sidebar">
			<div class="page-header">
				<div class="page-header-content">
					<h1 id="globalHeader" class="fg-color-white">Overview<small>.</small></h1>
				</div>
			</div>
			
			<div class="grid">
				<div class="row">
					<div class="span4"> <!--Sidebar-->
						<div class="page-sidebar">
							<ul style="overflow: visible">
								<li id="li_Overview"><a id="overview">
									<i class="icon-info-2"></i>
										Overview
									</a>
								</li>

								<li id="li_AddNew" >
									<a id="addNewCase">
										<i class="icon-plus-2"></i>
										Add-New Health Case
									</a>
								
								</li>

								<li id="li_ShowAllCases">
									<a id="showAllCases">
										<i class="icon-list"></i>
										Show Health Cases
									</a>
								</li>
								
								
								<li id="li_Reports" >
									<a id="reports">
										<i class="icon-cabinet"></i>
										Reports
									</a>
								
								</li>
								
							</ul>
						</div>
					</div>

				<div class="page-region">
						<div class="page-region-content">
							<div id="divOverview" style="display:none"> <!--HomePage(Overview)-->
								<?php include ("views/overview.php"); ?>
							</div>

							<div id="divAddNewCase" style="display:none"> <!--Add New Case(Overview)-->
								<?php include ("views/addNewCase.php"); ?>
							</div>

							<div id="divShowCases" style="display:none"> <!--showCase(Overview)-->
								<?php include ("views/showcases.php"); ?>
							</div>

							<div id="divReports" style="display:none"> <!--Reports-->
								<?php include ("views/reports.php"); ?>
							</div>
						</div>
				</div>	
			</div>
		</div>	
		
		
			<div class="message-dialog" id ="errMsgDiv" style="z-index:6;display:none;">
					<div style='text-align:center;'> <!--I want to center the error message!!-->
						<h2 id="confirmation" class="fg-color-white"></h2>
						<p id="msg" ></p>
						<button id="closemsg" class="place-right">OK</button>
					</div>
			</div>
			
			<div id="errBackGrnd" class="bg-color-darken" style="width:100%;height:100%;top:0px;opacity:0.5;z-index:5;display:none;position:fixed;">
			</div>
	</body>

</html>