<div>
	<div class="page-control span10" data-role="page-control">
        <!-- Responsive controls -->
        <span class="menu-pull"></span> 
        <div class="menu-pull-bar">Dem Info</div>
        <!-- Tabs -->
        <ul >
            <li class="active">
            	<a href="#tab1">
            		Dem Info
            	</a>
            </li>
            
            <li>
            	<a href="#tab2">
            		Disease Info
            	</a>
            </li>
        </ul>

        <!-- Tabs content -->
        <div class="frames">
            <div class="frame active bg-color-blueLight" id="tab1" style="min-height:15em;">

            	<?php include ("reports/tab1.php"); ?><!-- Page for tab 1 for a Tabbed page -->
            </div>

            <div class="frame bg-color-blueLight" id="tab2" style="min-height:15em;"> <!-- Page for tab 1 for a Tabbed page -->

            	<?php include ("reports/tab2.php"); ?>

            </div>
        </div>
    </div>
</div>



<script type = "text/javascript">
	$(document).ready(function(){
		$("#li_Reports").click(function(){
			switchContentDiv("#divReports",200);
			$("#globalHeader").html("Reports<small>.</small>");
		});

	});
</script>