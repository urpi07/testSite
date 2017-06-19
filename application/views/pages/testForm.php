<form method="<?php echo $method ?>" action="<?php echo $table; ?>" id="<?php echo $table; ?>">

<?php
$fieldGroupLimit = 2;
$fieldCounter = 0;

echo "<br>";
if (isset ( $fields )) {
	foreach ( $fields as $field ) {
		
		if ($fieldCounter == 0) {
			echo "<div class='form-group'>";
		}
		
		$fieldName = $field->name;
		$value = ( isset($tableData->$fieldName) ) ? $tableData->$fieldName:"";
		
		echo "<div class='col-sm-6'>";	
		echo "<label> $field->name <label>";
		echo generateField ( $field->name, $field->type, $value );
		echo "</div>";
		
		if (++ $fieldCounter >= $fieldGroupLimit) {
			echo "</div><br>";
			$fieldCounter = 0;
		}
	}
}
?>

<div class="col-sm-offset-5 col-sm-7">
		<button type="submit" class="btn btn-default">Submit</button>
	</div>
</form>

<script>
	$("<?php echo $table; ?>").preventDoubleSubmission();
</script>