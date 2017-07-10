<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('echoLog'))
{
	function echoLog($message, $isDebugMode)
	{
		// $path = FCPATH.$path;
		if($isDebugMode){
			echo "<br>=========================================================================<br>";
			echo $message;
			echo "<br>=========================================================================<br>";
		}
	}
}

if (!function_exists( 'generateField' )) {
	function generateField($fieldName, $type, $value = "", $lenght = 0) {				
		$element = "<input type='text' placeholder='$fieldName' name='$fieldName' class='form-control' value='$value'>";
		return $element;
	}
}

//assigns the results in one variable
if(!function_exists('setResult')){	
	function setResult($title, $res, $message ){	
		$result = array();
		$result["result"] = $res;
		$result["message"]= $message;
		$result["title"] = $title;
		return $result;
	}
}

if(!function_exists('setQueryError')){
	function setQueryError(){
		return setResult("Query Error", QUERY_ERROR, "Data is not set");
	}
}

if(!function_exists('getInterestAmount')){
	//following the interest formula A = P(1 + rt)
	function getInterestAmount($amount, $interest, $time){
		return $amount * (1 + $interest * $time);
	}
}

// returns an array of time chunks
// $timeMeasure: is in years, months, weeks and days
// $chunkNos: the number of time chunks to be created
// $baseDate: the starting date of the time chunks
// TODO: Not yet thouroughtly test this function
if(!function_exists('getTimeChunks')){
	function getTimeChunks($timeMeasure, $chunkNos, $baseDate){
		
		$result = array();
		if(isset($timeMeasure) && isset($chunkNos) && isset($baseDate)){
						
			$timeMeasure = strtolower($timeMeasure);
			$interval = "";
			
			//TODO: make this more flexible
			switch($timeMeasure){
				case "days":
					$interval = "P1D";
					break;
				case "weeks":
					$interval = "P7D";
					break;
				case "months":
					$interval = "P1M";
					break;
				case "year":
					$interval = "P1Y";
					break;
				default:
					echo "Invalid Time measure";
					return;
					break;
			}
			
			//echo "Interval: $interval";
			$intervalDate = clone $baseDate;			
			$monthDays = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
			
			while($chunkNos > 0){
				$prevDate = clone $intervalDate; //for comparisson purposes.
				$intervalDate = $intervalDate->add( new DateInterval($interval));
				
				//consider leap year and quirks with adding months.
				if($timeMeasure == "months"){
					
					$fprevDate = strtotime($prevDate->format('Y-m-d H:i:s'));
					$fintervalDate = strtotime($intervalDate->format('Y-m-d H:i:s') );
					
					$prevMonth = date("n", $fprevDate);
					$currMonth = date("n", $fintervalDate);
					
					$prevDay = date("d", $fprevDate);
					$currDay = date("d", $fintervalDate);
					
					$prevYear = date("Y", $fprevDate);
					$currYear = date("Y", $fintervalDate);
					
					//special case, payment is every end of the month
					$isEndOfMonth = false;
					
					if($prevDay == $monthDays[$prevMonth-1]){ 						
						$isEndOfMonth = true;
					}					
					
					if($currDay != $prevDay ){ //means we skipped a month
						
						--$currMonth;
						if($currMonth<= 0){ //circular month
							$currMonth= 12;
							$currYear -= 1; 
						}
						
						//check if it is leap year.						
						$monthDays[1] = (date("L", mktime(0, 0, 0, 1, 1, $currYear) ) ) ? 29 : 28;						
						
						$dayLimit = $monthDays[$currMonth-1];																
						$currDay= ( $prevDay > $dayLimit ) ? $dayLimit : $prevDay;												
					}
					
					if($isEndOfMonth){
						$currDay =  $monthDays[$currMonth-1];
					}
					
					$intervalDate = new DateTime("$currMonth/$currDay/$currYear");
				}
								
				array_push($result, $intervalDate);			
				$intervalDate = clone $intervalDate;
				$chunkNos--;
			}
		}
		
		return $result;
	}	
}

if(!function_exists('getTimeChunkswithCutoff')){
	function getTimeChunkswithCutoff($cutOff, $numberOfChunks, $dateStart, $paymentDate){
		$result = array();
		$monthDays = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31); //number of days/month 
		
		if(isset($cutOff) && isset($numberOfChunks) && isset($dateStart)){
			
			$fdateStart = strtotime($dateStart->format('Y-m-d H:i:s'));
			$startDay = date("d", $dateStart);
			$startMonth = date("n", $dateStart);
			$startYear = date("Y", $dateStart);
			
			// date start exceeded cut of then the payment
			//would start 2 months from now
			if($dateStart > $cutOff){ 
				--$numberOfChunks;
				$startMonth += 2;
				$rem = $startMonth % 12;
				
				//exceeded 12 months, add one year and the motnh becomes the remainder
				if( ( ($startMonth/12) > 1) && $rem >= 0){ 									
					$startMonth = ($rem == 0) ? 1 : $rem;				
					$startYear += 1;
				}
				
				if( isset($paymentDate) ){
					$startDay= date("d", $paymentDate);
				}
				
				$dateStart = new DateTime("$startMonth/$startDay/$startYear");
				array_push($result, $dateStart);
			}
			
			while($numberOfChunks > 0){
				$cloneDateStart = clone $dateStart;
				$cloneDateStart->start("P1M");
				$fcloneDateStart = strtotime($fcloneDateStart->format('Y-m-d H:i:s'));
				
				$cloneDay = date("n", $fcloneDateStart);
				$cloneMonth = date("n", $fcloneDateStart);
				$cloneYear = date("Y", $fcloneDateStart);
				
				if($startDay != $cloneDay){
					
					--$cloneMonth;
					if($cloneMonth<= 0){ //circular month
						$cloneMonth = 12;
						$cloneYear-= 1;
					}
					
					//check if it is leap year.
					$monthDays[1] = (date("L", mktime(0, 0, 0, 1, 1, $cloneYear) ) ) ? 29 : 28;
					
					$dayLimit = $monthDays[$cloneMonth-1];
					$newDay = ( $cloneDay > $dayLimit ) ? $dayLimit : $cloneDay;
				}
				
				
				array_push($result, new DateTime("$cloneMonth/$cloneDay/$cloneYear") );
				$numberOfChunks--;
			}
		}
		
		return $result;
	}	
}