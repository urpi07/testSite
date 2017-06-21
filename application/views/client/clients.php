<div class="modal fade" role="dialog" id="newClientModal">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Modal Header</h4>
			</div>
			<div class="modal-body">
				<p>Some text in the modal.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>


<!-- Actual content -->
<div class="panel panel-default">
	<div class="panel-heading">
		<h3>Clients</h3>
	</div>
	<div class="panel-body">
		<button type="button" class="btn btn-primary" data-toggle="collapse"
			data-target="#newClientModal" id="btnNewClient">New Client</button>

		<br> <br>

		<div class="table-responsive">
			<table class="table-bordered" id="usersTable">
			<?php
			
			// var_dump($users);
			$tableHeaders = array (
					"Id",
					"First Name",
					"Last Name",
					"Middle Name",
					"Number",
					"Edit",
					"Delete" 
			);
			// Table headers
			echo "<tr>\n";
			foreach ( $tableHeaders as $headers ) {
				echo "\t<th>$headers</th>\n";
			}
			echo "</tr>\n";
			
			// Actual Data if any:
			if (isset ( $clients )) {
				foreach ( $clients as $client ) {
					echo "<tr>\n";
					echo "\t<td>$client->id</td>\n";
					echo "\t<td>$client->firstName</td>\n";
					echo "\t<td>$client->lastName</td>\n";
					echo "\t<td>$client->middleName</td>\n";
					echo "\t<td>$client->phoneNumber</td>\n";
					echo "\t<td><button type='button' class='btn btn-primary' " . "onclick='getUser($client->id)'>Edit</button></td>\n";
					echo "\t<td><button type='button' class='btn btn-success' class='btnDelete' " . "data-toggle='modal' data-target='#deleteModal' " . "onclick='setClientToDelete($client->id)'>Delete</button></td>\n";
					echo "</tr>\n";
				}
			}
			?>
	
	</table>
		</div>
	</div>
	<!-- End of panel body -->
</div>
<!-- End of Panel -->

<script>


var clientForm = $("#newClientForm");

function completeSubmit(){
	clientForm.data('submitted', false);	
}

function clientValidation(data){
	
}

function sendAjax(payload, successCB, failCB){
	$.ajax(payload)
	.done( successCB )
	.fail( failCB );
}

$(document).load(function(){

	clientForm.submit(function(){

	    console.log("Submitting the form");		    
	    event.preventDefault();
	    
	    if (clientForm.data('submitted') === true) {
	      // Previously submitted - don't submit again	
		  console.log("form was already submitted.");	      
	    } 
	    else {
	    }		
	});
});

</script>
