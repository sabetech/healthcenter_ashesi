	<div class="span3">
		<label>Show From:</label>
		<div style="width:200px" class="input-control text datepicker" data-role="datepicker">
			<input id="fromDate" type="text" />
				<button class="btn-date"></button>
			</div>
	</div>
	
	<div class="span3">
		<label>To:</label>
		<div style="width:200px" class="input-control text datepicker" data-role="datepicker" >
			<input id="toDate" type="text" />
			<button class="btn-date"></button>
		</div>
	</div>
	
<div class="span1">
		<button id="refreshInv" class="image-button fg-color-white bg-color-green big"> 
			Show
			<i class="icon-loop"></i>
		</button>
</div>

<div id="casestable" class="span12" style="display:none">
	<table class ="bg-color-white striped hovered">
		<thead>
			<tr>
				<th>Name:</th>
				<th>Case Date</th>
				<th>Gender</th>
				<th>Faculty</th>
				<th>Year Group</th>
				<th>Mastercard</th>
				<th>Nationality</th>
				<th>Condition</th>
				<th>Details</th>
				<th>Remedy</th>
			</tr>
		</thead>
		
		<tbody>

		</tbody>
	</table>
</div>


<script type = "text/javascript">
	$(document).ready(function(){
		$("#li_ShowAllCases").click(function(){
			switchContentDiv("#divShowCases", 200);
			$("#globalHeader").html("Show Cases<small>.</small>");
		});

		$("#refreshInv").click(function(){
			$("#casestable").fadeIn();
			var url = "functional/getCases.php";
			//console.log("do u feel me");
			$.get(url,
				  {fromdate:$("#fromDate").val(),
				   toDate:$("#toDate").val()},
				   
				   function(response){
				   		try{	
				   			//console.log(response);
				   			var responseJSON = JSON.parse(response);
				   			var table = $("#casestable tbody");
				   			for(var i=0; i < responseJSON.length; i++){
				   				// console.log(responseJSON[i]);
				   				//tablepopulation
				   				table.append("<tr><td>"+responseJSON[i].person_name+"</td>"+
				   					"<td style='width:6em;'>"+responseJSON[i].case_date+"</td>"+
				   					"<td>"+responseJSON[i].gender+"</td>"+
				   					"<td>"+responseJSON[i].facultyorstaff+"</td>"+
				   					"<td>"+responseJSON[i].yeargroup+"</td>"+
				   					"<td>"+responseJSON[i].mastercard+"</td>"+
				   					"<td>"+responseJSON[i].nationality+"</td>"+
				   					"<td>"+responseJSON[i].condition+"</td>"+
				   					"<td>"+responseJSON[i].details+"</td>"+
				   					"<td>"+responseJSON[i].remedy+"</td></tr>");
				   			}

				   		}catch(e){
				   			console.log("ouch"+e);
				   		}
				   });
		});
	});
</script>