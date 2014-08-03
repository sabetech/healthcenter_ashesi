<?php
	require_once("healthDB_API.php");

	class HealthCenterAPI{
		var $dbVar;
		var $fromMonth;
		var $fromYear;
		var $toMonth;
		var $toYear;

		function HealthCenterAPI(){
			global $dbVar;
			$dbVar = new healthDB_API();	
		}

		function saveCase($person_name, $caseDate,$gender, $yeargroup,
		 $facultyorstaff,$nationality,$mastercard,$condition,$details,$remedy){

			global $dbVar;
			if ($dbVar->connect()){
				
				$case_date = $this->formatDate($caseDate);

				$query = "INSERT INTO health_case 
				(`person_name`, `case_date`, `gender`, `yeargroup`, 
					`facultyorstaff`, `nationality`, `mastercard`, `condition`, `details`, `remedy`)
				VALUES
				('$person_name', '$case_date','$gender', '$yeargroup',
					'$facultyorstaff','$nationality','$mastercard','$condition','$details','$remedy')";

				$result = $dbVar->runQuery($query);
				if ($result){

					return "{\"response\":\"success\"}";
				}

			}
		}

		function formatDate($date){
			return date('Y-m-d',strtotime($date));
		}

		function getCases($from, $to){
			global $dbVar;
			if ($dbVar->connect()){
				
				$from = $this->formatDate($from);
				$to = $this->formatDate($to);

				$query = "SELECT * FROM health_case WHERE case_date >= '$from' AND case_date <= '$to'";
				$result = $dbVar->runQuery($query);

				if ($dbVar->get_num_rows() > 0){
					$json_result_cases = "";
					$count = 0;
					while($cases = $dbVar->fetch()){
						$person_name = $cases['person_name'];
						$case_date = $cases['case_date'];
						$gender = $cases['gender'];
						$facultyorstaff= $cases['facultyorstaff'];
						$yeargroup = $cases['yeargroup'];
						$nationality = $cases['nationality'];
						$mastercard = $cases['mastercard'];
						$condition = $cases['condition'];
						$details = $cases['details'];
						$remedy = $cases['remedy'];

						//if count is more 0, add the array signs else starting appending commas

						if ($count > 0){
							$json_result_cases .= ",";
						}else{
							$json_result_cases .= "[";
						}

						if ($facultyorstaff == '0'){
							$facultyorstaff = "no";
						}

						if ($yeargroup == '0'){
							$yeargroup = "N/A";
						}

						if ($mastercard == '0'){
							$mastercard = "no";
						}

						if ($mastercard == '1'){
							$mastercard = "yes";	
						}

						if ($mastercard == '-1'){
							$mastercard = "N/A";
						}

						$newDateFormat = new DateTime($case_date);
						$case_date = date_format($newDateFormat, 'd M y');

						$json_result_cases .= "{\"person_name\":\"$person_name\",
											   \"case_date\":\"$case_date\",
											   \"gender\":\"$gender\",
											   \"facultyorstaff\":\"$facultyorstaff\",
											   \"yeargroup\":\"$yeargroup\",
											   \"nationality\":\"$nationality\",
											   \"mastercard\":\"$mastercard\",
											   \"condition\":\"$condition\",
											   \"details\":\"$details\",
											   \"remedy\":\"$remedy\"}";


						$count++;
					}
						$json_result_cases .= "]";
					return $json_result_cases;
				}else{
					$json_result_cases = "{\"status\":\"failure\"}";
				}


			}
			

		}

		function getYearGroups($startingYearGroup, $endYearGroup){
			//pssst ... look for the comment "//get range of yeargroupsss.."
		}

		function countAllMale(){

		}

		//getting the number males belonging to certain year group. When a person belongs to a yeargroup
		//he /she cannot be a faculty or staff;
		function countMales($monthAndYearArray, $yearGroup){

			return $this->getCountsForMonths($monthAndYearArray[0],$monthAndYearArray[1], "gender = 'male'","gender", "maleCount",$yearGroup);
				
		}

		function countFemales($monthAndYearArray, $yearGroup){
			
			return $this->getCountsForMonths($monthAndYearArray[0],$monthAndYearArray[1], "gender='female'","gender", "femaleCount", $yearGroup);
			
		}

		function countMasterCard($monthAndYearArray, $yearGroup){
			
			return $this->getCountsForMonths($monthAndYearArray[0],$monthAndYearArray[1], "mastercard = '1'", "mastercard", "mastercardCount",$yearGroup);

		}

		function countInternationalStudents($monthAndYearArray, $yearGroup){
			
			return $this->getCountsForMonths($monthAndYearArray[0], $monthAndYearArray[1], "nationality = 'international'", "nationality","nationalityCount", $yearGroup);

		}

		function countGhanaian($monthAndYearArray, $yearGroup){
			
			return $this->getCountsForMonths($monthAndYearArray[0],$monthAndYearArray[1], "nationality = 'ghanaian'", "nationality","nationalityCount", $yearGroup);

		}

		function countFacultyMale(){
			
			return $this->countFaculty("faculty","facultyorstaff = '1'"); //1 for male
		
		}

		function countFacultyFemale(){

			return $this->countFaculty("faculty","facultyorstaff = '0'"); //obviously ...

		}

		function countBasedOnYearGroup($subject,$alias, $WHERE_CLAUSE,$yeargroup){
			global $dbVar;
			global $fromMonth;
			global $fromYear;
			global $toMonth;
			global $toYear;

			if ($dbVar->connect()){
				$query = "SELECT COUNT(`$subject`) as $alias, CONCAT( CAST( MONTH( case_date ) AS CHAR( 2 ) ) , '-', CAST( YEAR( case_date ) AS CHAR( 4 ) ) ) AS MonthYear FROM health_case WHERE $WHERE_CLAUSE AND yeargroup = '$yeargroup' AND month(case_date) between '$fromMonth' AND '$toMonth' AND year(case_date) between '$fromYear' AND '$toYear' GROUP BY CONCAT( CAST( MONTH( case_date ) AS CHAR( 2 ) ) ,  '-', CAST( YEAR( case_date ) AS CHAR( 4 ) ) ) ";
				
				//echo $query; Debugging things

				//return 0;
				 $dbVar->runQuery($query);	
				
				 if ($dbVar->get_num_rows() > 0){
				 	while($num = $dbVar->fetch()){//here am getting numbers of subjects for month-year

				 	}
				 	return $num[$alias]; //number of subjects 
				 }else{
				 	return 0; 
				 }
			}
		}

		function countFaculty($alias,$WHERE_CLAUSE){
			global $dbVar;
			if ($dbVar->connect()){
				$query = "SELECT COUNT(gender) as $alias FROM health_case WHERE $WHERE_CLAUSE AND facultyorstaff = '1'";

				$dbVar->runQuery($query);

				if($dbVar->get_num_rows() > 0){
					$num = $dbVar->fetch();
					return $num[$alias];//number of faculty based on gender
				}else{
					return 0;
				}
			}
		}


		function getMonthYears($yeargroup){
			global $dbVar;
			global $fromMonth;
			global $fromYear;
			global $toMonth;
			global $toYear;

			if ($dbVar->connect()){
				//isn't she a beauty ...! :-)
				$query = "SELECT CONCAT( CAST( MONTH( case_date ) AS CHAR( 2 ) ) ,  '-', CAST( YEAR( 		  case_date ) AS CHAR( 4 ) ) ) AS MonthYear
						  FROM health_case
					      WHERE yeargroup = $yeargroup
					      AND MONTH( case_date ) 
                          BETWEEN ( '$fromMonth' ) 
						  AND ( '$toMonth' ) 
						  AND YEAR( case_date ) 
					      BETWEEN ( '$fromYear' ) 
                          AND ( '$toYear' ) 
						  GROUP BY CONCAT( CAST( MONTH( case_date ) AS CHAR( 2 ) ) ,  '-', CAST( YEAR( case_date ) AS CHAR( 4 ) ) ) ";

				$dbVar->runQuery($query);

				$monthYearArr = array();
				if ($dbVar->get_num_rows() > 0){
					$i = 0;
					while($myMonthYear = $dbVar->fetch()){
						$monthYearArr[$i] = $myMonthYear['MonthYear'];
						$i++;
					}
					return $monthYearArr;
				}

			}


		}

		function getCountsForMonths($month,$year,$WHERE_CLAUSE, $subject, $alias, $yeargroup){
			global $dbVar;
			if ($dbVar->connect()){

				$query = "SELECT COUNT( $subject ) As $alias
				 FROM health_case
				 WHERE $WHERE_CLAUSE
				 AND MONTH( case_date ) = '$month'
				 AND YEAR( case_date ) = '$year'
				 AND yeargroup = '$yeargroup'";

				 $dbVar->runQuery($query);

				 if ($dbVar->get_num_rows() > 0){
				 	$countVar = $dbVar->fetch();
				 	return $countVar[$alias];
				 }else{
				 	return 0;
				 }
			}


		}


		function getArrayOfCounts($subject,$alias, $WHERE_CLAUSE,$yeargroup){
			global $dbVar;
			global $fromMonth;
			global $fromYear;
			global $toMonth;
			global $toYear;

			if($dbVar->connect()){
				//if you touch this query, your computer will explode!!
				$query = "SELECT COUNT(`$subject`) as $alias, CONCAT( CAST( MONTH( case_date ) AS CHAR( 2 ) ) , '-', CAST( YEAR( case_date ) AS CHAR( 4 ) ) ) AS MonthYear FROM health_case WHERE $WHERE_CLAUSE AND yeargroup = '$yeargroup' AND month(case_date) between '$fromMonth' AND '$toMonth' AND year(case_date) between '$fromYear' AND '$toYear' GROUP BY CONCAT( CAST( MONTH( case_date ) AS CHAR( 2 ) ) ,  '-', CAST( YEAR( case_date ) AS CHAR( 4 ) ) ) ";

				$dbVar->runQuery($query);

				if($dbVar->get_num_rows() > 0){
					$subjArray = array();
					while($subjectMonthValuePair = $dbVar->fetch()){
						$monthyear = $subjectMonthValuePair['MonthYear'];
						$subjAlias = $subjectMonthValuePair[$alias];

						$subjArray[$monthyear] = $subjAlias;
						
					}
					//var_dump($subjArray); 
					return $subjArray;
				}else{
					return null;
				}
			}
		}
		//Male	Female	Mastercard	International	Ghanaian

		function generateDemInfo($casefromMonth, $casefromYear, $casetoMonth, $casetoYear, $startYearGroup, $endyearGroup){
				global $dbVar;
				global $fromMonth;
				global $fromYear;
				global $toMonth;
				global $toYear;

				$fromMonth = $casefromMonth;
				$fromYear = $casefromYear;
				$toMonth = $casetoMonth;
				$toYear = $casetoYear;

				if ($dbVar->connect()){//get range of yeargroupsss..
					$query = "SELECT yeargroup FROM health_case WHERE yeargroup >= '$startYearGroup' AND yeargroup <= '$endyearGroup' group by yeargroup";
					
					$dbVar->runQuery($query);	 
					$year_group_results = $dbVar->getResult();
					
					if ($dbVar->get_num_rows() > 0){
						
						$jsonFormattedArray = "{\"monthInfoPerYeargroup\":[";

						$shdPutComma = 0;
						while($yeargroupRow = mysql_fetch_assoc($year_group_results)){

							$currentYeargroup = $yeargroupRow['yeargroup'];
							$monthYearArr = $this->getMonthYears($currentYeargroup);

							if ($shdPutComma > 0){
								$jsonFormattedArray .= ",";
							}

							$jsonFormattedArray .= "{\"$currentYeargroup\":[";
							$shdPutComma2 = 0;
							for($i=0;$i < count($monthYearArr);$i++){
								
								$monthAndYearArr = explode('-', $monthYearArr[$i]);

								//with month and year, count male,female,international,etc 
								//for each month and year for a specific yearGroup
								$maleCount = $this->countMales($monthAndYearArr, $currentYeargroup);
								$femaleCount = $this->countFemales($monthAndYearArr, $currentYeargroup);
								$mastercardCount = $this->countMasterCard($monthAndYearArr, $currentYeargroup);

								$internationalCount = $this->countInternationalStudents($monthAndYearArr, $currentYeargroup);

								$ghanaianCount = $this->countGhanaian($monthAndYearArr, $currentYeargroup);

								if ($shdPutComma2 > 0 ){
									$jsonFormattedArray .= ",";
								}

								$monthYearArr_temp = $monthYearArr[$i];

								$jsonFormattedArray .= "{\"males\":\"$maleCount\",
														 \"females\":\"$femaleCount\",
														 \"mastercards\":\"$mastercardCount\",
														 \"internationals\":\"$internationalCount\",
														 \"ghanaians\":\"$ghanaianCount\",
														 \"monthYear\":\"$monthYearArr_temp\",
														 \"yeargroup\":\"$currentYeargroup\"}";

								$shdPutComma2++;
							}

							$jsonFormattedArray .= "]}";
							$shdPutComma++;

						}
						$jsonFormattedArray .= "]}";
						
						return $jsonFormattedArray;

					}else{
						//error saying out of bounds year group No data for that yeargroup
						return "failure";
					}
				}
				
		}

		function generateDiseaseInfo($casefromMonth, $casefromYear, $casetoMonth, $casetoYear, $startYearGroup, $endyearGroup){
			global $dbVar;
			global $fromMonth;
			global $fromYear;
			global $toMonth;
			global $toYear;

			$fromMonth = $casefromMonth;
			$fromYear = $casefromYear;
			$toMonth = $casetoMonth;
			$toYear = $casetoYear;

			if ($dbVar->connect()){
				$query = "SELECT yeargroup FROM health_case WHERE yeargroup >= '$startYearGroup' AND yeargroup <= '$endyearGroup' group by yeargroup";
				
				$dbVar->runQuery($query);	 
				$yearGroupDiseaseInfo = $dbVar->getResult();

				if ($dbVar->get_num_rows() > 0){
					$jsonFormatedDiseaseInfo = "{\"d_monthInfoPerYeargroup\":[";

					$diseases = $this->getDiseasesForRange();
					
					$diseaseNamesArray = array();
					$diseaseNameIndex = 0;
					while($disease = mysql_fetch_assoc($diseases)){

						$diseaseName = $disease['condition'];
						$diseaseNamesArray[$diseaseNameIndex] = $diseaseName;
						$diseaseNameIndex++;

					}

					$d_shdPutComma = 0;
					while($yeargroupRow = mysql_fetch_assoc($yearGroupDiseaseInfo)){

						$currentYeargroup = $yeargroupRow['yeargroup'];
						$monthYearArr = $this->getMonthYears($currentYeargroup);
						
						//conditional comma goes here
						if ($d_shdPutComma >0){
							$jsonFormatedDiseaseInfo .= ",";
						}

						$jsonFormatedDiseaseInfo .= "{\"$currentYeargroup\":[";

						//{d_monthInfoPerYG:[{2013:[{monthY:7-2014, malaria:14,flu:12, stomachAche:0},
						//							{monthY:8-2014, malaria:5,flu:5, stomachAche:1}]},
					    //				 	 {2014:[{monthY:7-2014, malaria:14,flu:12, stomachAche:0}]}]}


						$d_shdPutComma2 = 0;
						for($i=0;$i < count($monthYearArr);$i++){
								
							$monthAndYearArr = explode('-', $monthYearArr[$i]);

							//this is where I count the diseases in the DB
							//get required dataset
							//Month-Year | Malaria | Flu
							//  7-2014	 |   45    | 12
							//so now that i have month-year and the diseases, lets count them

							//another conditional comma, ie theres another month of disease for that yearGroup
							if ($d_shdPutComma2 > 0){
								$jsonFormatedDiseaseInfo .= ",";
							}

							$monthYearArr_temp = $monthYearArr[$i];
							$jsonFormatedDiseaseInfo .= "{\"Month-Year\":\"$monthYearArr_temp\"";

							for($j=0; $j < count($diseaseNamesArray); $j++){

								$diseaseName = $diseaseNamesArray[$j];
								$diseaseCount = $this->countDisease($diseaseName,$monthAndYearArr,$currentYeargroup);

								$jsonFormatedDiseaseInfo .= ",\"$diseaseName\":\"$diseaseCount\"";

							}

							$jsonFormatedDiseaseInfo .= ",\"yeargroup\":\"$currentYeargroup\"}";
							$d_shdPutComma2++;
						}

						$jsonFormatedDiseaseInfo .= "]}";
						$d_shdPutComma++;

					}

					$jsonFormatedDiseaseInfo .= "]}";

				}
				return $jsonFormatedDiseaseInfo;
			}
		}
	

		function countDisease($diseaseName,$monthAndYearArr,$yeargroup){
			global $dbVar;
			if ($dbVar->connect()){
				$theMonth = $monthAndYearArr[0];
				$theYear = $monthAndYearArr[1];

				$query = "SELECT count( `condition` ) AS diseaseCount FROM health_case
						  WHERE `condition` = '$diseaseName'
						  AND MONTH( case_date ) = '$theMonth'
						  AND YEAR( case_date ) ='$theYear'
						  AND yeargroup = '$yeargroup'";	
				
				//echo $query; //Debugging things :)

				$dbVar->runQuery($query);
				 
				$diseaseCount = mysql_fetch_assoc($dbVar->getResult());

				return $diseaseCount['diseaseCount'];
			}
		}


		function getRequiredDataset($subject, $alias, $WHERE_CLAUSE, $yeargroup){
			//nonesense code
			$query = "SELECT $subject FROM health_case 
					  WHERE $WHERE_CLAUSE
					  GROUP BY $subject";
			//nonesense code ends here!
		}

		function getDiseasesForRange(){
			global $dbVar;
			global $fromMonth;
			global $fromYear;
			global $toMonth;
			global $toYear;

			if ($dbVar->connect()){
				$query = "SELECT `condition`
						  FROM health_case
						  WHERE MONTH(case_date) BETWEEN
						  $fromMonth AND $toMonth
						  AND YEAR(case_date) BETWEEN
						  $fromYear AND $toYear
						  GROUP BY `condition`";

				$dbVar->runQuery($query);
				
				return $dbVar->getResult();
			}
		}


//hello ... actually i am not using these functions below ... they were not generic enough\\
//i just left it there just so u could have an idea of how quick i wanted to finish this thingy
		function countMalaria($yearGroup){
			
			return $this->countBasedOnYearGroup("condition","disease","`condition` = 'malaria'",$yearGroup);
		
		}

		function countFlu($yearGroup){

			return $this->countBasedOnYearGroup("condition","disease","`condition` = 'flu'",$yearGroup);

		}

		function countMeasles($yearGroup){

			return $this->countBasedOnYearGroup("condition","disease","`condition` = 'measles'",$yearGroup);

		}

		function countBite($yearGroup){
			
			return $this->countBasedOnYearGroup("condition","disease","`condition` = 'bite'",$yearGroup);
		
		}

		function countStomachAche($yearGroup){

			return $this->countBasedOnYeargroup("condition","disease","`condition` = 'stomach ache'", $yearGroup);

		}

		function countOther($yearGroup){
			
			return $this->countBasedOnYearGroup("condition","disease","`condition` = 'other'",$yearGroup);
		
		}
	}

?>