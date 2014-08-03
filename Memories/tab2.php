<div class="span2">
	<div class="input-control select">
		<label>From Case Month</label>
        <select id="d_fromCaseMonth">
        	
            <option value = "1">January</option>
            <option value = "2">February</option>
            <option value = "3">March</option>
            <option value = "4">April</option>
            <option value = "5">May</option>
            <option value = "6">June</option>
            <option value = "7">July</option>
            <option value = "8">August</option>
            <option value = "9">September</option>
            <option value = "10">October</option>
            <option value = "11">November</option>
            <option value = "12">December</option>
            
        </select>
	</div>

	<div class="input-control select">
		<label>And Case year</label>
    	<select id="d_fromSelectYear" class ="rep_years">
        	
    	</select>
	</div>
</div>

<div class="span2">
	<div class="input-control select">
		<label>To Case Month</label>
        <select id="d_toCaseMonth">
        	
            <option value = "1">January</option>
            <option value = "2">February</option>
            <option value = "3">March</option>
            <option value = "4">April</option>
            <option value = "5">May</option>
            <option value = "6">June</option>
            <option value = "7">July</option>
            <option value = "8">August</option>
            <option value = "9">September</option>
            <option value = "10">October</option>
            <option value = "11">November</option>
            <option value = "12">December</option>
            
        </select>
	</div>

	<div class="input-control select">
		<label>And Case year</label>
    	<select id="d_toSelectYear" class ="rep_years">
        	
    	</select>
	</div>
</div>

<div class="offset1 span2">
	<div class="input-control select">
		<label>From(Year Group):</label>
    	<select id="d_frmYearGroup" class ="rep_years">
        
    	</select>
	</div>

	<div class="input-control select">
		<label>To(Year Group):</label>
    	<select id="d_toYearGroup" class ="rep_years">
        
    	</select>
	</div>
</div>

<div class="span2">
	<button id="showDiseaseInfo" class="big bg-color-green fg-color-white" style="margin-top:2em">
		Show Disease Info
	</button>
</div>



<br />
<br />

<div class="span8" style="margin-top:2em;">
	<h3 id="d_InfoHeader" style="margin-left:1em;">Disease Info for January 2013 for 2013 YearGroup</h3>
</div>

<div id="diseaseInfotable" style="display:none;">

</div>

<script type="text/javascript">
	$(document).ready(function(){
		
		$("#d_fromCaseMonth").change(function(){
			writeHeader();
		});

		$("#d_toCaseMonth").change(function(){
			writeHeader();
		});

		$("#d_fromSelectYear").change(function(){
			writeHeader();			
		});

		$("#d_toSelectYear").change(function(){
			writeHeader();
		});

		$("#d_frmYearGroup").change(function(){
			writeHeader();
		});
		$("#d_toYearGroup").change(function(){
			writeHeader();
		});


		function writeHeader(){
			
			if (!isValidRequest()){
				$("#showDiseaseInfo").prop("disabled",true);
				$("#showDiseaseInfo").removeClass("bg-color-green");
				$("#showDiseaseInfo").addClass("fg-color-darken");
				$("#d_InfoHeader").addClass('border-color-red');
				$("#d_InfoHeader").addClass('fg-color-red');
				$("#d_InfoHeader").html(constructHeader() + " *INVALID!");
			}else{
				$("#showDiseaseInfo").prop("disabled",false);
				$("#showDiseaseInfo").removeClass("fg-color-darken");
				$("#showDiseaseInfo").addClass("bg-color-green");
				$("#d_InfoHeader").removeClass('border-color-red');
				$("#d_InfoHeader").removeClass('fg-color-red');
				$("#d_InfoHeader").html(constructHeader());
			}	
		}

		function isValidRequest(){
			var fromMonthNyear = Number.parseInt($("#d_fromCaseMonth").val()) + Number.parseInt($("#d_fromSelectYear").val()) * 100;
			var toMonthNyear = Number.parseInt($("#d_toCaseMonth").val()) + Number.parseInt($("#d_toSelectYear").val()) * 100;
			
			var fromYearGrup = Number.parseInt($("#d_frmYearGroup").val());
			var toYearGroup = Number.parseInt($("#d_toYearGroup").val());
			
			if (fromMonthNyear > toMonthNyear){
				return false;
			}

			if (fromYearGrup > toYearGroup){
				return false;
			}

			return true;
		
		}

		function constructHeader(){
			//when a month is changed, check if both the years (to and from years) are the same!
			//if same then check if month is the same to month is the same
			//else charlie mabr3 ... just follow the code u will get it
			//check if to and from yeargroups are the same

			//then use the statement: Case Month $monthName for $yeargroup yeargroup
			var fromMonthWord = $("#d_fromCaseMonth option:selected").text();
			var toMonthWord = $("#d_toCaseMonth option:selected").text();
			var fromYear = $("#d_fromSelectYear").val();
			var toYear = $("#d_toSelectYear").val();

			var fromYearGroup = $("#d_frmYearGroup").val();
			var toYearGroup = $("#d_toYearGroup").val();

			var d_headerForDemInfo = "";

			//For clarity sake, this line is commented out ... 
			//headerForDemInfo = ((isToFromMonthsSame() && isToFromYearSame()) ? "Info for "+fromMonthWord+" "+ fromYear+" " : "Info from "+fromMonthWord+" "+fromYear+" to "+toMonthWord+" "+toYear+" ");

			if (isToFromMonthsSame()){
				if (isToFromYearSame()){
					//Info For $month $year for Year group
					//same month same years
					d_headerForDemInfo = "Disease Info for "+fromMonthWord+" "+ fromYear+" ";
				}else{//same months but different years
					d_headerForDemInfo = "Disease Info from "+fromMonthWord+" "+fromYear+" to "+toMonthWord+" "+toYear+" ";
				}
			}else{
				d_headerForDemInfo = "Disease Info from "+fromMonthWord+" "+ fromYear+" to "+toMonthWord+" "+toYear+" ";
				
				//different month but same year
				if (isToFromYearSame()){ 
					d_headerForDemInfo = "Disease Info from "+fromMonthWord+" to "+toMonthWord+" "+toYear+" ";
				}
			}

			if (istoFromYearGroupSame()){
				//For same Year Group				
				d_headerForDemInfo += "for "+fromYearGroup+" YearGroup";
			}else{
				//for different year group
				d_headerForDemInfo += "from "+fromYearGroup+" to "+toYearGroup+" YearGroup";
			}


			return d_headerForDemInfo;
		}


		function isToFromMonthsSame(){

			return ($("#d_fromCaseMonth").val() === $("#d_toCaseMonth").val());

		}

		function isToFromYearSame(){
			
			return ($("#d_fromSelectYear").val() === $("#d_toSelectYear").val())
		
		}

		function istoFromYearGroupSame(){

			return ($("#d_frmYearGroup").val() === $("#d_toYearGroup").val());

		}



		/////////////The Main Deal is HERE!!!\\\\\\\\\\\\\  @#$%^&*()_+=-

		var diseaseChartDataArray = [];
		var diseaseGraphLabels = [];
		var arrOfDiseaseValues = [];
		var diseaseDataSets = [];
		var graphArray  = [];
		var myLineChart;

		var arrayDiseaseDataObjects = [];
		var arrayYearGroupLabels = [];
		var yearGroupIndex = 0;

		$("#showDiseaseInfo").click(function(){
			var url = "functional/getDiseaseInfo.php";
			$.get(url,
				  {fromMonth:$("#d_fromCaseMonth").val(),
					  fromYear:$("#d_fromSelectYear").val(),
					  toMonth:$("#d_toCaseMonth").val(),
					  toYear:$("#d_toSelectYear").val(),
					  fromYearGroup:$("#d_frmYearGroup").val(),
					  toYearGroup:$("#d_toYearGroup").val()
				  },

			    function (response){
				  		//console.log(response);
			  		try{
				  		var jsonDiseaseCount = JSON.parse(response);
				  		//console.log(jsonDiseaseCount);
				  	 	$("#diseaseInfotable").html("");

				  	 	var bufferDiseaseTable = "";
				  	 	var prevYearGroup = "";
				  	 	var tableHeaders;

				  	// 	graphArray  = [];
				  		//var drawnTableHeader = false;
				  	 	for(var i=0; i < jsonDiseaseCount.d_monthInfoPerYeargroup.length; i++){
				  	 		
				  	 		var ygTemp = jsonDiseaseCount.d_monthInfoPerYeargroup[i];
				  	 		//ygTemp is a year group eg: 2013, 2014 etc
				  	 		for(var j in ygTemp){
				  	 			//console.log(ygTemp[j]);
				  	 			var ygs = ygTemp[j];
				  	 			var twoDimArrIndex = 0;
				  	 			var sumTotal = [];
				  	 			
				  	 			for(var d_ygsInfo in ygs){
				  	 				var d_ygsInfoArr = ygs[d_ygsInfo];
				  	 				var tableHeaders = Object.keys(d_ygsInfoArr);

				  	 					/////////   BEGIN TABLE HEADER CREATION \\\\\\
										if (d_ygsInfoArr.yeargroup != prevYearGroup){
											bufferDiseaseTable += "<h4 id='tableDiseaseHeader"+i+"' class='span3 fg-color-black border-color-green' style='padding:10px;'>"+d_ygsInfoArr.yeargroup+" Year Group</h4>";
											bufferDiseaseTable += "<table id='tablesOfDiseaseCounts"+i+"'>"+	
													"<thead><tr>";

											for(var k=0;k<tableHeaders.length-1;k++){
												bufferDiseaseTable += "<td>"+tableHeaders[k]+"</td>"
												arrOfDiseaseValues[k] = [];
											}

											bufferDiseaseTable += "</tr></thead>"+
																	"<tbody style='text-align:center;'>";	
											
										}

										////////   END OF TABLE HEADERS \\\\\\\\\\\\\\

										//////////   CREATING ROWS N COLUMNS \\\\\\\\\\										

										bufferDiseaseTable += "<tr>";
										for(var k=0; k < tableHeaders.length-1; k++){
											//column values
											bufferDiseaseTable += "<td>"+d_ygsInfoArr[tableHeaders[k]]+"</td>";	
											//malaria, meales, flu, stomach, other
											//suming takes place here!

											if (sumTotal[0] != 0){//initializing the sumTotal Array;
												for(var l=0;l <tableHeaders.length-1;l++){
													sumTotal[l] = 0;
												}
											}

											if (k == 0){ //calculating sums for the various diseases I got
												sumTotal[k] = 0;	
											}else{
												sumTotal[k] += Number(d_ygsInfoArr[tableHeaders[k]]);
											}
											
											var diseaseObj = {};//initializing the diseaseObj
											
											diseaseObj['disease'] = tableHeaders[k];
											diseaseObj['value'] =  d_ygsInfoArr[tableHeaders[k]];

											arrOfDiseaseValues[k][twoDimArrIndex] = diseaseObj;
											
										}
										//graph labels...
										diseaseGraphLabels.push(d_ygsInfoArr[tableHeaders[0]]);

										twoDimArrIndex++;
										bufferDiseaseTable += "</tr>";

									prevYearGroup = d_ygsInfoArr.yeargroup;
									/////////// END CREATING ROWS n COLUMNS  \\\\\\\\\\\\
				  	 			}

				  	 			bufferDiseaseTable += "<tr>";
				  	 			bufferDiseaseTable += "<td>TOTALS:</td>";
				  	 			
				  	 			for(var m = 1;m < sumTotal.length;m++){
				  	 				bufferDiseaseTable += "<td>"+sumTotal[m]+"</td>";
				  	 			}

				  	 			bufferDiseaseTable += "</tr>";

				  	 			//this is where I create a dataObject of the disesase
				  	 			//a is starting from 1 becos, the index 0 contains month-year information
				  	 			
			  	 				arrayDiseaseDataObjects[yearGroupIndex] = [];
				  	 			

				  	 			for(var a=1; a < arrOfDiseaseValues.length; a++){
				  	 				//console.log(arrOfDiseaseValues[a]);
				  	 				//so for one disease, put its values in the tempArr
				  	 				var tempArr = [];
				  	 				for(var b=0; b < arrOfDiseaseValues[a].length; b++){
				  	 					
				  	 					//createDiseaseDataObject(arrOfDiseaseValues[a][b].disease, arrOfDiseaseValues[a][b].value);
				  	 					//console.log(arrOfDiseaseValues[a][b].disease +" "+arrOfDiseaseValues[a][b].value);
				  	 					//create a new TEMP array
				  	 					tempArr[b] = Number(arrOfDiseaseValues[a][b].value);	
				  	 				}	

				  	 				var diseaseInfo = createDiseaseDataObject(
				  	 					arrOfDiseaseValues[a][0].disease, tempArr, 
				  	 					Math.abs(Math.ceil(39/a)), Math.abs(Math.ceil(91/a)), Math.abs(Math.ceil(179/a)));

				  	 				arrayDiseaseDataObjects[yearGroupIndex][a-1] = diseaseInfo;
				  	 				tempArr = [];
				  	 			}

				  	 			diseaseDataSets.push(arrayDiseaseDataObjects[yearGroupIndex][0]);
				  	 			arrayYearGroupLabels[yearGroupIndex] = diseaseGraphLabels;

				  	 			yearGroupIndex++;
				  	 			var theData = constructData(diseaseGraphLabels, diseaseDataSets);
				  	 			
				  	 			bufferGraph(theData);

				  	 			diseaseGraphLabels = [];
				  	 			diseaseDataSets = [];


				  	 			bufferDiseaseTable += "</tbody></table>";
				  	 			bufferDiseaseTable += "<a id='showGraph' style='cursor:pointer;'>Show Graph </a>";
								bufferDiseaseTable += "<div class = 'linegraphs' style='width:80%;'>"+
								 							"<div>"+
								 								"<canvas id='diseaseCanvas"+i+"' class='graphcanvas' height='450' width='600' data-graphNum = '"+i+"' style='display:block';></canvas>"+// height='450' width='600'
								 							"</div>";

								 						    for (var d_chks = 1; d_chks < tableHeaders.length-1; d_chks++){
								 						    	
								 						    	if (d_chks == 1){
								 						    		bufferDiseaseTable += "<label class='input-control checkbox' style='margin-bottom:4em;'>"+
																		        		"<input type='checkbox' class='diseaseDataObject' checked value= '1' data-chkgraphnum = '"+i+"' data-objectindex = "+(d_chks-1)+">"+
																			    	    "<span class='helper'>"+tableHeaders[d_chks]+"</span>"+
																		    			"</label>";	
								 						    	}else{
								 						    		bufferDiseaseTable += "<label class='input-control checkbox' style='margin-bottom:4em;'>"+
																		        		"<input type='checkbox' class='diseaseDataObject' data-chkgraphnum = '"+i+"' data-objectindex = "+(d_chks-1)+">"+
																			    	    "<span class='helper'>"+tableHeaders[d_chks]+"</span>"+
																		    			"</label>";	
								 						    	}											    
								 						    }
								 						bufferDiseaseTable += "</div>";
				  	 		}
				  	 	}
				  	 	
							// setChartData(malaria_num,flu_num,measles_num,bites_num,stomach_num,other_num,i);
							
							// bufferDiseaseTable += "<a id='showGraph' style='cursor:pointer;'>Show Graph </a>"
						$("#diseaseInfotable").append(bufferDiseaseTable);
						$("#diseaseInfotable").fadeIn(200);

						//console.log(diseaseChartDataArray);

						for(var i=0;i<diseaseChartDataArray.length;i++){
							var canvasId = "diseaseCanvas"+i;
							drawDiseaseGraph(canvasId, diseaseChartDataArray[i], 1);
						}
							// bufferDiseaseTable = "";

					  	$(".diseaseDataObject").click(function(){

					  		var chosenGraphNum = $(this).data("chkgraphnum");

					  		$(".diseaseDataObject").each(function(){
					  			if ($(this).data("chkgraphnum") === chosenGraphNum){
					  				if ($(this).is(":checked")){
		 								console.log($(this).data("objectindex")+" "+$(this).data("chkgraphnum"));
		 								//trying to access the data objects for a particular yeargroup to redraw the graph
		 								var diseaseDataObject = arrayDiseaseDataObjects[Number($(this).data("chkgraphnum"))][Number($(this).data("objectindex"))];
		 								diseaseDataSets.push(diseaseDataObject);

		 							}
					  		};

					  	});

					  		var theDiseaseData = constructData(arrayYearGroupLabels[Number($(this).data("chkgraphnum"))], diseaseDataSets);
		 					var canvasIndex = Number($(this).data("chkgraphnum"));
		 					var canvasId = "diseaseCanvas"+canvasIndex;
		 					
		 					diseaseDataSets = [];
		 					drawDiseaseGraph(canvasId, theDiseaseData, 1);
						});

				    }catch(e){
				     	console.log(e);
				     	displayError("An error occured. Press F5 to refresh","Unexpected Error!");
				    }

		    	}
		    );
		});

		function drawDiseaseGraph(canvasId, chartData, lineOrBar){//bar = 0, line = 1
			try{
				var theDiseaseGraphCanvas = document.getElementById(canvasId).getContext("2d");
				$("#"+canvasId).html("");

				if (chartData.datasets[0].data.length == 1){
					lineOrBar = 0;
				}

				try{
					if (lineOrBar == 0){
						return new Chart(theDiseaseGraphCanvas).Bar(chartData,{
			   				responsive:true
			   			});
					}else{
						return new Chart(theDiseaseGraphCanvas).Line(chartData,{
			   				responsive:true
					 	});
					}
				
				}catch(e){
					console.log("problem with graph "+e);
				}
		}catch(f){

		}
		}

		function createDiseaseDataObject(labelString, dataArray,red,green,blue){
			var diseaseDataObject = {
										label: labelString,
										fillColor : "rgba("+red+","+green+","+blue+","+"0.2)",
										strokeColor : "rgba("+red+","+green+","+blue+","+"1)",
										pointColor : "rgba("+red+","+green+","+blue+","+"1)",
										pointStrokeColor : "#fff",
										pointHighlightFill : "#fff",
										pointHighlightStroke : "rgba("+red+","+green+","+blue+","+"1)",
										data: dataArray
									};

			return diseaseDataObject;
		}

		function constructData(labelArray, datasetArray){
			var data = {
							labels: labelArray,
							datasets: datasetArray
						}

			return data;
		}

		function bufferGraph(data){
			diseaseChartDataArray.push(data);
		}
	
		
		// function setChartData(malaria,flu,measles,bite,stomachAche,others,index){
		// 	var lineChartData = {
		// 	labels : ["Malaria","Flu","Measles","Bite","Stomach Ache","Others"],
		// 	datasets : [
		// 		{
		// 			label: "Trend of Diseases",
		// 			fillColor : "rgba(220,220,220,0.2)",
		// 			strokeColor : "rgba(220,220,220,1)",
		// 			pointColor : "rgba(220,220,220,1)",
		// 			pointStrokeColor : "#fff",
		// 			pointHighlightFill : "#fff",
		// 			pointHighlightStroke : "rgba(220,220,220,1)",
		// 			data : [malaria,flu,measles,bite,stomachAche,others]
		// 		}
		// 		]
		// 	}

		// 	bufferGraphs(index, lineChartData);
		// }

		
		// function bufferGraphs(index, chartData){
		// 	graphArray[index] = chartData;
		// }

		// function drawLineGraph(graphDataArray, valueCount){
		// 	for(var i=0; i<valueCount; i++){
				
		// 		var ctx = document.getElementById("diseaseCanvas"+i).getContext("2d");
		// 		myLineChart = new Chart(ctx).Line(graphDataArray[i], {
		// 			responsive: true
				
		// 		});	
		// 		ctx.canvas.height = 450;
		// 		ctx.canvas.width = 600;
		// 	}
			
		// }

	});
</script>