<div class="span2">
	<div class="input-control select">
		<label>From Case Month</label>
        <select id="fromCaseMonth">
        	
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
    	<select id="fromSelectYear" class ="rep_years">
        	
    	</select>
	</div>
</div>

<div class="span2">
	<div class="input-control select">
		<label>To Case Month</label>
        <select id="toCaseMonth">
        	
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
    	<select id="toSelectYear" class ="rep_years">
        	
    	</select>
	</div>
</div>

<div class="offset1 span2">
	<div class="input-control select">
		<label>From(Year Group):</label>
    	<select id="frmYearGroup" class ="rep_years">
        
    	</select>
	</div>

	<div class="input-control select">
		<label>To(Year Group):</label>
    	<select id="toYearGroup" class ="rep_years">
        
    	</select>
	</div>


</div>

<div class="span2">
	
	<button id="showDemInfo" class="big bg-color-green fg-color-white" style="margin-top:2em">
		Show Dem Info
	</button>

</div>

	
<br />
<br />

<div class="span8" style="margin-top:2em;">
	<h3 id="demInfoHeader" style="margin-left:1em;">Info of January 2013 for 2013 YearGroup</h3>
</div>
<div id="divTablesOfCounts1" style="display:none;">
	
</div>




<script type = "text/javascript">
	$(document).ready(function(){
		for (var i=2013;i<2040;i++){
			$(".rep_years").append("<option value='"+i+"'>"+i+"</option>");	
		}

		
		$("#fromCaseMonth").change(function(){
			writeHeader();
		});

		$("#toCaseMonth").change(function(){
			writeHeader();
		});

		$("#fromSelectYear").change(function(){
			writeHeader();			
		});

		$("#toSelectYear").change(function(){
			writeHeader();
		});

		$("#frmYearGroup").change(function(){
			writeHeader();
		});
		$("#toYearGroup").change(function(){
			writeHeader();
		});


		function writeHeader(){
			
			if (!isValidRequest()){
				$("#showDemInfo").prop("disabled",true);
				$("#showDemInfo").removeClass("bg-color-green");
				$("#showDemInfo").addClass("fg-color-darken");
				$("#demInfoHeader").addClass('border-color-red');
				$("#demInfoHeader").addClass('fg-color-red');
				$("#demInfoHeader").html(constructHeader() + " *INVALID!");
			}else{
				$("#showDemInfo").prop("disabled",false);
				$("#showDemInfo").removeClass("fg-color-darken");
				$("#showDemInfo").addClass("bg-color-green");
				$("#demInfoHeader").removeClass('border-color-red');
				$("#demInfoHeader").removeClass('fg-color-red');
				$("#demInfoHeader").html(constructHeader());
			}

			
		}

		function isValidRequest(){
			var fromMonthNyear = Number.parseInt($("#fromCaseMonth").val()) + Number.parseInt($("#fromSelectYear").val()) * 100; //find out why i multiplied by 10
			var toMonthNyear = Number.parseInt($("#toCaseMonth").val()) + Number.parseInt($("#toSelectYear").val()) * 100;
			
			var fromYearGrup = Number.parseInt($("#frmYearGroup").val());
			var toYearGroup = Number.parseInt($("#toYearGroup").val());
			
			if (fromMonthNyear > toMonthNyear){
				return false;
			}

			if (fromYearGrup > toYearGroup){
				return false;
			}

			return true;

			//return (Number.parseInt($("#fromCaseMonth").val()) + Number.parseInt($("#fromSelectYear").val()) <= Number.parseInt($("#toCaseMonth").val()) + Number.parseInt($("#toSelectYear").val())) || (fromYearGrup <= toYearGroup));
			//again commented out just so I don't tempt a maintainer to curse my family tree ... :D
		}

		function constructHeader(){
			//when a month is changed, check if both the years (to and from years) are the same!
			//if same then check if month is the same to month is the same
			//else charlie mabr3 ... just follow the code u will get it
			//check if to and from yeargroups are the same

			//then use the statement: Case Month $monthName for $yeargroup yeargroup
			var fromMonthWord = $("#fromCaseMonth option:selected").text();
			var toMonthWord = $("#toCaseMonth option:selected").text();
			var fromYear = $("#fromSelectYear").val();
			var toYear = $("#toSelectYear").val();

			var fromYearGroup = $("#frmYearGroup").val();
			var toYearGroup = $("#toYearGroup").val();

			var headerForDemInfo = "";

			//For clarity sake, this line is commented out ... 
			//headerForDemInfo = ((isToFromMonthsSame() && isToFromYearSame()) ? "Info for "+fromMonthWord+" "+ fromYear+" " : "Info from "+fromMonthWord+" "+fromYear+" to "+toMonthWord+" "+toYear+" ");

			if (isToFromMonthsSame()){
				if (isToFromYearSame()){
					//Info For $month $year for Year group
					//same month same years
					headerForDemInfo = "Info for "+fromMonthWord+" "+ fromYear+" ";
				}else{//same months but different years
					headerForDemInfo = "Info from "+fromMonthWord+" "+fromYear+" to "+toMonthWord+" "+toYear+" ";
				}
			}else{//difference month different year
				headerForDemInfo = "Info from "+fromMonthWord+" "+ fromYear+" to "+toMonthWord+" "+toYear+" ";

				if (isToFromYearSame()){ //different month but same year
					headerForDemInfo = "Info from "+fromMonthWord+" to "+toMonthWord+" "+toYear+" ";
				}
			}

			if (istoFromYearGroupSame()){
				//For Year Group
				headerForDemInfo += "for "+fromYearGroup+" YearGroup";
			}else{
				headerForDemInfo += "from "+fromYearGroup+" to "+toYearGroup+" YearGroup";
			}

			return headerForDemInfo;
		}


		function isToFromMonthsSame(){

			return ($("#fromCaseMonth").val() === $("#toCaseMonth").val());

		}

		function isToFromYearSame(){
			
			return ($("#fromSelectYear").val() === $("#toSelectYear").val())
		
		}

		function istoFromYearGroupSame(){

			return ($("#frmYearGroup").val() === $("#toYearGroup").val());

		}

		//some global variables
		var chartDataArray = [];
		var graphLabels = [];
		var arrayTwoDimOfDataObjects = [];
		var yearGroupGraphLabels = [];
		
		var tempMales = [];
		var tempFemales = [];
		var tempMastercard = [];
		var tempInternational = [];
		var tempGhanaian = [];

		var arrOfSumData = [];
		var arrOfSumLabels= [];

		var datasetsArray = [];
		//Global Variables ends here
		
		/////////////The Main Deal is HERE!!!\\\\\\\\\\\\\
		var myGraphs = [];
		var yearGroupIndex = 0;

		////I know I should have broken parts of this function into functions ... please do that ... Thanks
		$("#showDemInfo").click(function(){
			yearGroupIndex = 0;
			//get values here based on selection
			var url = "functional/getDemInfo.php";
			$.get(url,
					 {fromMonth:$("#fromCaseMonth").val(),
					  fromYear:$("#fromSelectYear").val(),
					  toMonth:$("#toCaseMonth").val(),
					  toYear:$("#toSelectYear").val(),
					  fromYearGroup:$("#frmYearGroup").val(),
					  toYearGroup:$("#toYearGroup").val()},

					  function(response){
					  		try{	

					  			//console.log(response);
					  			varJson = JSON.parse(response);
					  			console.log(varJson);

					  			$("#divTablesOfCounts1").html("");
					  			var bufferTables ="";
					  			var previousYrGroup = "";

					 			for(var i=0;i < varJson.monthInfoPerYeargroup.length;i++){
					 				
					 				var temp = varJson.monthInfoPerYeargroup[i];
					 				//temp is a year group eg: 2013, 2014 etc
					 				for(var j in temp){
					 					//j are arrays of values in temp like {male:3,female:3},{male:3,female:3} etc
					 					var ygs = temp[j];
					 					var sumMale=0;
					 					var sumFemale=0;
					 					var sumInternational=0;
					 					var sumMasterCard=0;
					 					var sumGhanaian=0;
					 					var sumTotals = 0;

										for(var ygsInfo in ygs){
											var ygsInfoArr = ygs[ygsInfo];
											//console.log(ygsInfo);
											//ygsInfo is an array instance of j;

											//console.log(ygsInfoArr.yeargroup+" fds "+previousYrGroup);
											if (ygsInfoArr.yeargroup != previousYrGroup){
												bufferTables += "<h4 id='tableHeader"+i+"' class='span3 fg-color-black border-color-green' style='padding:10px;'>"+j+" Year Group</h4>";
												bufferTables += "<table id='tablesOfCounts"+ygsInfo+"'>"+
														 		"<thead>"+
													 			"<tr>"+
													 				"<th>Month-Year</th>"+
													 				"<th>Male</th>"+
																	"<th>Female</th>"+
																	"<th>Mastercard</th>"+
																	"<th>International</th>"+
																	"<th>Ghanaian</th>"+
																	"<th>Total</th></tr>";
												bufferTables += "</thead>"+
														 		"<tbody style='text-align:center;'>";

												//store data of values

											}

											var maleFemaleTotal = (Number(ygsInfoArr.males) + Number(ygsInfoArr.females));
											bufferTables += "<tr>"+
									 							"<td>"+ygsInfoArr.monthYear+"</td>"+
									 							"<td>"+ygsInfoArr.males+"</td>"+
									 							"<td>"+ygsInfoArr.females+"</td>"+
									 							"<td>"+ygsInfoArr.mastercards+"</td>"+
									 							"<td>"+ygsInfoArr.internationals+"</td>"+
									 							"<td>"+ygsInfoArr.ghanaians+"</td>"+
									 							"<td>"+maleFemaleTotal+"</td>"+
								 							"</tr>";

								 							sumMale += Number(ygsInfoArr.males);
								 							sumFemale += Number(ygsInfoArr.females);
								 							sumMasterCard += Number(ygsInfoArr.mastercards);
								 							sumInternational += Number(ygsInfoArr.internationals);
								 							sumGhanaian += Number(ygsInfoArr.ghanaians);
								 							sumTotals += maleFemaleTotal;

								 			tempMales.push(Number(ygsInfoArr.males));
								 			tempFemales.push(Number(ygsInfoArr.females));
								 			tempMastercard.push(Number(ygsInfoArr.mastercards));
								 			tempInternational.push(Number(ygsInfoArr.internationals));
								 			tempGhanaian.push(Number(ygsInfoArr.ghanaians));

								 			graphLabels.push(ygsInfoArr.monthYear);

								 			previousYrGroup = ygsInfoArr.yeargroup;	
		 								}
		 								//the totals
		 								bufferTables += "<tr>"+
									 							"<td>Totals</td>"+
									 							"<td>"+sumMale+"</td>"+
									 							"<td>"+sumFemale+"</td>"+
									 							"<td>"+sumMasterCard+"</td>"+
									 							"<td>"+sumInternational+"</td>"+
									 							"<td>"+sumGhanaian+"</td>"+
									 							"<td>"+sumTotals+"</td>"+
								 							"</tr>";

		 								//make a call to create dataobject
		 								var maleDataObject = createDataObject("maleDataset", tempMales, 220, 220, 220);
		 								var femaleDataObject = createDataObject("femaleDataset",tempFemales, 151, 187, 205);
		 								var masterCardDataObject = createDataObject("masterCardDataset", tempMastercard, 200, 81, 7);
		 								var internationDataObject = createDataObject("internationalDataset", tempInternational, 121,43,84);
		 								var ghanaianDataObject = createDataObject("ghanaianDataset", tempGhanaian,100,55,121);

		 								

		 								tempMales = [];
		 								tempFemales = [];
		 								tempMastercard = [];
		 								tempInternational = [];
		 								tempGhanaian = [];
		 								//after am done here, I will push into the dataset array
		 								//a dataset is collection of dataObjects;
		 								
		 								datasetsArray.push(maleDataObject);
		 								//datasetsArray.push(femaleDataObject);
		 								//datasetsArray.push(masterCardDataObject);
		 								//datasetsArray.push(internationDataObject);
		 								//datasetsArray.push(ghanaianDataObject);

		 								//push female
		 								//push international and so on...
		 								//createDataSets(datasetsArray);

		 								//initialize twoDimensional array in javascript ... creepy :\ :/
	 									arrayTwoDimOfDataObjects[yearGroupIndex] = [];
		 							

		 								arrayTwoDimOfDataObjects[yearGroupIndex][0] = maleDataObject; //this yearGroupIndex helps me store the databobjects according to the yeargroup
		 								arrayTwoDimOfDataObjects[yearGroupIndex][1] = femaleDataObject;
		 								arrayTwoDimOfDataObjects[yearGroupIndex][2] = masterCardDataObject;
		 								arrayTwoDimOfDataObjects[yearGroupIndex][3] = internationDataObject;
		 								arrayTwoDimOfDataObjects[yearGroupIndex][4] = ghanaianDataObject;
		 								//arrayTwoDimOfDataObjects[yearGroupIndex][5] = totalDataObject; ... not logical to do this

		 								yearGroupGraphLabels[yearGroupIndex] = graphLabels;

		 								arrOfSumData[yearGroupIndex] = [];

		 								arrOfSumData[yearGroupIndex] = [sumMale, sumFemale, sumMasterCard, sumInternational, sumGhanaian];
		 				
		 								//arrayOfDatasetsArray.push(datasetsArray);
		 								
		 								var theData = constructData(graphLabels, datasetsArray);
		 								
		 								graphLabels = [];//Clearing an Array ByVAL
		 								datasetsArray = [];//Clearing an Array ByVAL //funny huh! array byVal

		 								bufferGraph(theData);
		 								//console.log(theData);

									}
									//Male, Female, International, Mastercard, International, Ghanaian
									yearGroupIndex++;//about to get the data for the next year Group

									bufferTables += "</tbody></table>";

									bufferTables +=  "<div class = 'linegraph' style='width:80%'>"+
														"<div>"+
															"<canvas id='demInfoCanvas"+i+"' class='graphcanvas' height='450' width='600' ></canvas>"+// height='450' width='600'
																
														"</div>"+
														
														"<br />"+
														
														"<div><button class='showBarGraph bg-color-green fg-color-white' data-chkgraphnum = '"+i+"'>Show Bar Graph</button></div>"+

													 	"<br />"+

													 	"<div id='checkboxes"+i+"''>"+
														 	"<label class='input-control checkbox' style='margin-bottom:4em;'>"+
													        		"<input type='checkbox' id ='male' class='dataObject' checked value= '1' data-chkgraphnum = '"+i+"' data-objectindex = 0>"+
														    	    "<span class='helper'>Male</span>"+
													    	"</label>"+
													    	"<label class='input-control checkbox' style='margin-bottom:4em;'>"+
													        		"<input type='checkbox' id = 'female' class='dataObject' data-chkgraphnum = '"+i+"' data-objectindex = 1>"+
														    	    "<span class='helper'>Female</span>"+
													    	"</label>"+
													    	"<label class='input-control checkbox' style='margin-bottom:4em;'>"+
													        		"<input type='checkbox' id = 'mastercard' class='dataObject' data-chkgraphnum = '"+i+"'data-objectindex = 2>"+
														    	    "<span class='helper'>Mastercard</span>"+
													    	"</label>"+
													    	"<label class='input-control checkbox' style='margin-bottom:4em;'>"+
													        		"<input type='checkbox' id = 'international' class='dataObject' data-chkgraphnum = '"+i+"' data-objectindex = 3>"+
														    	    "<span class='helper'>International</span>"+
													    	"</label>"+
													    	"<label class='input-control checkbox' style='margin-bottom:4em;'>"+
													        		"<input type='checkbox' id = 'ghanaian' class='dataObject' data-chkgraphnum = '"+i+"' data-objectindex = 4>"+
														    	    "<span class='helper'>Ghanaian</span>"+
													    	"</label>"+
													    	"</div>"+
													 "</div>";
													 

				 				}
				 			
				 				arrOfSumLabels[0]= "Male";
				 				arrOfSumLabels[1]= "Female";
				 				arrOfSumLabels[2]= "Mastercard";
				 				arrOfSumLabels[3]= "International";
				 				arrOfSumLabels[4]= "Ghanaians";



  				 				$("#divTablesOfCounts1").append(bufferTables);
  				 				$("#divTablesOfCounts1").fadeIn(200);

  				 				for(var i=0;i < chartDataArray.length;i++){
  				 					
  				 					var canvasId = "demInfoCanvas"+i;
  				 					myGraphs[i] = drawTheGraph(canvasId, chartDataArray[i], 1);
  				 					myGraphs[i].generateLegend();

  				 				}

  				 				

  				 				$(".showGraphClass").click(function(){
  				 					//determine which graph to show
  				 					//console.log($(this).prop('id'));
  				 					/*var anchorCanvasId = $(this).prop('id');
  				 					
  				 					var indexOfDash = anchorCanvasId.indexOf('-');
  				 					var canvasId = anchorCanvasId.substr(0 , indexOfDash);

  				 					//console.log(canvasId);
									//show the graph of the currently clicked item
									$("#"+canvasId).css({height:'450px',
				  							           	 width:'600px'});

									var theGraphCanvas = document.getElementById(canvasId).getContext("2d");
									
									var graphIndex = $(this).data();
									//console.log(graphIndex.graphnum);
									var theChart = new Chart(theGraphCanvas).Line(chartDataArray[graphIndex.graphnum],{
									 	responsive:true
									 });

									theGraphCanvas.canvas.height = 450;
									theGraphCanvas.canvas.width = 600;

									//$("#"+canvasId).show();*/

  				 				});

  				 				$(".dataObject").click(function(){
  				 					showLineGraph($(this)); 
  				 				});

								$(".showBarGraph").click(function(){
									if ($(this).html() == "Show Bar Graph"){
										var yearGroupIndex = Number($(this).data("chkgraphnum"));
										$("#checkboxes"+yearGroupIndex+"").hide();
										showBarGraph($(this));
										$(this).html("Show Line Graph");
									}else{
										var yearGroupIndex = Number($(this).data("chkgraphnum"));

										showLineGraph($(this));

										$("#checkboxes"+yearGroupIndex+"").show();
										$(this).html("Show Bar Graph");
									}
									
								});

					  		}catch(e){
					  			console.log(e);
					  			displayError("Please Check the date/yeargroup range","Could Not get Data!");
					  		}
					  		
					  });


			
		});
	

		function showBarGraph(currentGraph){
			//yearGroupIndex is the same as the i use around ... not really ... just be weary
			
			var yearGroupIndex = Number(currentGraph.data("chkgraphnum"));
			var sumDataObject = createDataObject("Sum Of Values", arrOfSumData[yearGroupIndex], 0);

			datasetsArray.push(sumDataObject);
			
			var myBarChartData = constructData(arrOfSumLabels, datasetsArray);

			var canvasId = "demInfoCanvas"+yearGroupIndex;
			myGraphs[yearGroupIndex].destroy();
			myGraphs[yearGroupIndex] = drawTheGraph(canvasId, myBarChartData, 0);
			datasetsArray = [];

		}

		function showLineGraph(currentGraph){
			var chosenGraphNum = currentGraph.data("chkgraphnum");

			$(".dataObject").each(function(){

				if ($(this).data("chkgraphnum") === chosenGraphNum){
					
					if ($(this).is(":checked")){
						console.log($(this).data("objectindex")+" "+$(this).data("chkgraphnum"));
						//trying to access the data objects for a particular yeargroup to redraw the graph
						var dataObject = arrayTwoDimOfDataObjects[Number($(this).data("chkgraphnum"))][Number($(this).data("objectindex"))];
						datasetsArray.push(dataObject);
					}
				}
				//console.log($(this).data());
			});

			//default value to display line graph for
			if (datasetsArray.length == 0){
				var dataObject = arrayTwoDimOfDataObjects[Number(currentGraph.data("chkgraphnum"))][0];
				datasetsArray.push(dataObject);
			}

			//console.log(datasetsArray);

			var theData = constructData(yearGroupGraphLabels[Number(currentGraph.data("chkgraphnum"))], datasetsArray);
			var canvasIndex = Number(currentGraph.data("chkgraphnum"));
			var canvasId = "demInfoCanvas"+canvasIndex;
			
			datasetsArray = [];
			myGraphs[canvasIndex].destroy();
			myGraphs[canvasIndex] = drawTheGraph(canvasId, theData, 1);

		}
///I AM DRAWYING THE GRAPH FROM HERE!!!! ... I need a canvas and data!!! you need know more about the data structure/object about the chart
		
		function drawTheGraph(canvasId, chartData, lineOrBar){//bar is 0, line is 1
			try{
				//var canvasId = "demInfoCanvas"+canvasId;
				var theGraphCanvas = document.getElementById(canvasId).getContext("2d");
				$("#"+canvasId).html("");
		
				//you can force line or bar graph here depending on chartData.labels.length OR chartData.datasets[0].data.length
				if (chartData.datasets[0].data.length == 1){
					lineOrBar = 0;
				}
			
				if (lineOrBar == 0){
					return new Chart(theGraphCanvas).Bar(chartData,{
						responsive:true,
						legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
						
					});
				}else{
					return new Chart(theGraphCanvas).Line(chartData,{// line graph
	   					responsive:true,
	   					legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
			 		});
			 		//document.getElementById('legend').innerHTML = chart.generateLegend();	
				}
				
			}catch(e){
				console.log("problem with graph "+e);
			}	
		}

///////Drawing the graph has to independent of whether or not it is a line or bar graph 
		
		//////////// ALL THESE ARE HELPER FUNCTIONS TO HELP DRAW CHARTS OO HMM \\\\\\\\\\\
		function createDataObject(labelstring,dataArray,red,green,blue){
			var dataObject = {
								title: labelstring,//label for the data object
								fillColor : "rgba("+red+","+green+","+blue+","+"0.25)",
								strokeColor : "rgba("+red+","+green+","+blue+","+"1)",
								pointColor : "rgba("+red+","+green+","+blue+","+"1)",
								pointStrokeColor : "#fff",
								pointHighlightFill : "#fff",
								pointHighlightStroke : "rgba("+red+","+green+","+blue+","+"1)",
								data: dataArray
							 };

			return dataObject;
		}

		//currently unused ... what redundant! ... redundant piece of code!
		function createDataSets(dataObjectsArray){
			var dataset = dataObjectsArray;
			return dataset;
		}//End of Redundant code ...

		function constructData(labelArray,datasetArray){
			var data = {
						labels: labelArray, 
						datasets: datasetArray
						}

			return data;
		}

		function bufferGraph(data){
			chartDataArray.push(data);
		}

		function resetDatasetArray(datasetsArray){
			//This empties the dataset array BYREF ... take note byREF!!!
			while(datasetsArray.length > 0){
				datasetsArray.pop();
			}
		}
		
		////////////////// END HELPER FUNCTIONS TO DRAW GRAPHS \\\\\\\\\\\
		
	});
</script>