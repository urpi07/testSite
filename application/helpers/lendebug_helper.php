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