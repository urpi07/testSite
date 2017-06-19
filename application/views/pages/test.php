<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title?></title>			
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap-3.3.7-dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/style.css">
		<script src="<?php echo base_url(); ?>assets/foundation/js/vendor/jquery.js"></script>
	</head>
<body>

	<div class="container">
		<form id="formdb">
			<label>Select Table: </label> <select name="table" id="table">
			<?php
			if (isset ( $tables )) {
				foreach ( $tables as $table ) {
					echo "<option value='$table'>$table</option>";
				}
			}
			?>
		</select> <label>Method: </label> <select name="method" id="method">
			<option value="" selected>Select Value</option>
		<?php
		
		$methods = [ 
				"POST",
				"GET",
				"UPDATE",
				"PUT",
				"DELETE" 
		];
		foreach ( $methods as $method ) {
			echo "<option value='$method'>$method</option>";
		}
		
		?>
		</select>

			<div class="row container" id="id" style="display: none;">
				<input type="text" name="id" placeholder="ID" id="tableId">
			</div>
			<br>
			<br>
			<button type="submit" id="formdb_submit">GO!</button>
		</form>

		<div class="container" id="tableForm"></div>
	</div>

	<script>

		$(document).ready( function(){

			$("#method").change(function(event){
				var val = $(this).val();

				if(val == "PUT" || val == "DELETE" || val == "GET"){
					$("#id").toggle();
				}	
			});

			$("#formdb").submit(function(evt){
				evt.preventDefault();
				var table = $("#table").val();
				var method = $("#method").val();
				var id = $("#tableId").val();
				var data = {};

				console.log("id: " + id);

				if(id){
					data = { "table": table,
						"method": method,
						"id": id };
				}
				else{
					data = { "table": table,
							"method": method };
				}
				
				$.ajax({
					url:"dbForm",
					method: "GET",
					data: data,
					})								 
					 .done(function(data){
						 $("#tableForm").html(data);
					 })
					 .fail(function(){
						 $("#tableForm").html("Error from server");
					 });				
			});
		});
	</script>
</body>
</html>

