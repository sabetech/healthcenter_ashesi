if ($dbVar->get_num_rows() > 0){
					$jsonFormatedDiseaseInfo = "{\"diseaseInfo\":[";
					
					$someCount=0;

					while($yearGroupDisease = mysql_fetch_assoc($yearGroupDiseaseInfo)){
						$currentYeargroup = $yearGroupDisease['yeargroup'];

						$malariaCount = $this->countMalaria($currentYeargroup);
						$fluCount = $this->countFlu($currentYeargroup);
						$measlesCount = $this->countMeasles($currentYeargroup);
						$biteCount = $this->countBite($currentYeargroup);
						$stomachAcheCount = $this->countStomachAche($currentYeargroup);
						$otherCount = $this->countOther($currentYeargroup);

						if ($someCount > 0){
							$jsonFormatedDiseaseInfo .= ",";
						}


						$jsonFormatedDiseaseInfo .= "{\"yeargroup\":\"$currentYeargroup\",
												      \"malaria\":\"$malariaCount\",
													  \"flu\":\"$fluCount\",
													  \"measles\":\"$measlesCount\",
													  \"bites\":\"$biteCount\",
													  \"stomachAche\":\"$stomachAcheCount\",
													  \"otherCount\":\"$otherCount\"}";

						$someCount++;
					}

					$jsonFormatedDiseaseInfo .= "]}";