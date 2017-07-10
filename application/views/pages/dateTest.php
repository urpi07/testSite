<div class="container">
<?php
if(isset($dateInterval)){
	foreach ($dateInterval as $interval){
		$dateString = $interval->format('Y-m-d H:i:s');
		echo "<p> $dateString </p>\n";
	}
}
?>
</div>
