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