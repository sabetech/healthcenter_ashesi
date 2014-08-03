
<div style='width:40%'>
	<h2>Add Case</h2>
	
	<div class="hero-unit" style="margin-left:3em;">
		<div class="padding5 offset1" style="margin-left:1em;">
			
			<label>Name:</label>
			<span class="fg-color-red" id="Name_error"></span>
			<div class="input-control text">
				<input type="text" id="txtName" placeholder="Type in the Name of the person"/>
				<button class="btn-clear"></button>
			</div>
			
			
			<div>
				<label>Date:</label>
				<div style="width:100%;" class="input-control text datepicker" data-role="datepicker">
					<input id="dateOfCase" type="text" />
						<button class="btn-date"></button>
				</div>
			</div>
			
			<div class="divider"></div>

			<br />
			
			<label>Gender</label>		
				<label class="input-control radio " onclick="">
		            <input type="radio" name="sex" value="male" checked="">
		            <span class="helper">male</span>
				</label>

				<label class="input-control radio" onclick="">
		            <input type="radio" name="sex" value="female" checked="">
		            <span class="helper">female</span>
				</label>
			
			<br />

			<div>
				<label class="input-control checkbox">
			        <input id= "facultyOrStaff" type="checkbox" name="facultystaff">
			        <span class="helper">Faculty/Staff?</span>
			    </label>
			</div>

			<br />

			<div class="input-control select">
				<label>Select Year Group</label>
				<select id = "selectYearGroup" name="yeargroup">
				</select>
			</div>

			<div class="input-control select">
				<label>Nationality</label>
				<select id = "selectNationality" name="nationlity">
					<option value="international">International</option>
					<option value="ghanaian">Ghanaian</option>
				</select>
			</div>

			<div class="input-control select">
				<label>Mastercard</label>
				<select id = "selectMasterCard" name="mastercard">
					<option value="1">Yes</option>
					<option value="0">No</option>
				</select>
			</div>		

			<div class="input-control select">
				<label>Condition</label>
				<select id = "selectCondition" name="condition">
					
					<option value="malaria">malaria</option>
					<option value="flu">flu</option>
					<option value="stomach ache">stomach ache</option>
					<option value="other">other</option>

				</select>
			</div>

			<div id ="divDiseaseName" class="input-control text" style="display:none;">
				<input type="text" id="txtdiseaseName" placeholder="Type in specific condition"/>
				<button class="btn-clear"></button>
			</div>	

			<div  class="input-control textarea" >
	       		<label>Details</label>
	       		<textarea id="details"></textarea>
	    	</div>

			<div  class="input-control textarea" >
				<label>Remedy</label>
	       		<textarea id="remedy"></textarea>
	    	</div>    	
			
			<button id="addcase" class="bg-color-green fg-color-white place-right">
				Save Case 
			</button>

		</div>
	</div>
</div>

<script type = "text/javascript">

	$(document).ready(function(){
		$("#li_AddNew").click(function(){
			switchContentDiv("#divAddNewCase", 200);
			$("#globalHeader").html("Add New Case<small>.</small>");
		});

		for (var i=2013;i<2040;i++){
			$("#selectYearGroup").append("<option>"+i+"</option>");	
		}

		$("#facultyOrStaff").click(function(){
			if ($("#facultyOrStaff").is(":checked")) {

				$("#selectYearGroup").attr("disabled","disabled");
				$("#selectNationality").attr("disabled","disabled");
				$("#selectMasterCard").attr("disabled","disabled");

			}else{

				$("#selectYearGroup").removeAttr("disabled");
				$("#selectNationality").removeAttr("disabled");
				$("#selectMasterCard").removeAttr("disabled");

			}
		});

		$("#selectCondition").change(function(){
			if (($("#selectCondition option:selected").text()) === "other"){
				$("#divDiseaseName").fadeIn(200);
			}else{
				$("#divDiseaseName").fadeOut(200);
			}
			
		})

		/////////////////// The DEAL IS HERE!! \\\\\\\\\
		$("#addcase").click(function(){
			var url = "functional/saveCase.php";
			var facultyorstaff = 0;
			
			//validate here!

			if ($("#facultyOrStaff").is(':checked')) {
				facultyorstaff = 1;
			}

			if ($("#txtName").val() == ""){
				$("#Name_error").html("Please type in name");
				return;
			}

			var healthCondition = "";

			if (($("#selectCondition option:selected").text()) === "other"){
				if ($("#txtdiseaseName").val() == ""){
					displayError("Please Type In a Specific Condition. If the name is not known, you can write \"other\"","Please Enter Condition");
					return;
				}
				healthCondition = $("#txtdiseaseName").val();
			}else{
				healthCondition = $("#selectCondition").val();
			}				

			var yearGroupChosen = 0;
			var nationalityChosen = "N/A";
			var mastercardChosen = -1;

			if ($("#facultyOrStaff").is(':checked')) {

				yearGroupChosen = 0;
				nationalityChosen = "N/A";
				mastercardChosen = -1;

			}else{

				yearGroupChosen = $("#selectYearGroup").val();
				nationalityChosen = $("#selectNationality").val();
				mastercardChosen = $("#selectMasterCard").val();
			}

			$.post(url,
						{personName: $("#txtName").val(),
						 case_date: $("#dateOfCase").val(),
						 gender: $("input:radio[name='sex']:checked").val(),
						 yeargroup: yearGroupChosen,
						 facultystaff: facultyorstaff,
						 nationlity: nationalityChosen,
						 mastercard: mastercardChosen,
						 condition: healthCondition,
						 details: $("#details").val(),
						 remedy: $("#remedy").val()},

						 function(response){
						 	try{
						 		var jsonReply = JSON.parse(response);
						 		
						 		if (jsonReply.response == "success"){
						 			displayNotice("Case Added successfully!","Success");
						 			
						 			$("#txtName").val("");
						 			$("#details").val("");
						 			$("#remedy").val("");


						 		}else{
						 			displayError("Case Not Added!","Error");
						 		}

						 	}catch(e){
						 		console.log("Json Wrong");
						 	}
						 });
		 });

		
	});

</script>
