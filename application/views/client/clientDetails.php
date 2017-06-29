<div class="" id="mycontent">
	<?php			
		if( isset($clientInfo) && isset($clientInfo["data"])){
			$client = $clientInfo["data"][0];
	?>
		<div class="row">
			<div class="col-md-3">
				<img src="assets/img/male_profilePic.png" class="img-rounded thumbFrame" alt="profile pic">
			</div>
			<div class="col-md-9">
				<h3><?php echo $client->firstName." ". $client->lastName ?></h3><br>
				<span class="bold">Phone: </span> <?php echo $client->phoneNumber;  ?> 
				<span class="bold">Email: </span> <?php echo $client->email; ?><br>				
				<span class="bold">Address: </span> <?php echo $client->address; ?>
			</div>
		</div>
	<?php 
		}
		else{
			echo "<h4>User not found.</h4>";
		}
	?>

	<button type="button" class="btn" data-toggle="modal" data-target="#newLoan" id="btnNewLoan">New Loan</button><br><br>
	<div class="panel panel-default">
		<div class="panel-heading">Loans</div>
		<div class="panel-body">
					
			<?php				
				if( isset($result) && count($result["data"]) > 0 ){
					$loans = $result["data"];
			?>
				<table class="table-bordered" id="loanTable">
					<?php 
						$tableHeaders = array("Date Applied", "Amount", "Interest", "Status", "Edit", "Delete");
						
						echo "<tr>\n";
						foreach($tableHeaders as $header){							
							echo "\t<th>$header</th>\n";							
						}
						echo "</tr>\n";
						
						if(isset($loans) ){
							foreach($loans as $loan){
								
								$date = date_create($loan->dateApplied);
								$dateApplied = date_format($date,"M d, Y");
								echo "<tr>\n";
								echo "\t<td>$dateApplied</td>\n";
								echo "\t<td>$loan->loanAmount</td>\n";
								echo "\t<td>$loan->interest</td>\n";
								echo "\t<td>$loan->loanStatus</td>\n";
								echo "\t<td>".
										"<span class='btnEdit' onclick='getLoan($loan->id)'>".
										"<i class='fa fa-pencil-square-o' aria-hidden='true'></i>&nbsp".
										"Edit</span></td>\n";
								echo "\t<td>".
										"<span class='btnDelete' " .
										"data-toggle='modal' data-target='#deleteModal' " .
										"onclick='setLoanToDelete($loan->id)'>".
										"<i class='fa fa-times' aria-hidden='true'></i>&nbsp".
										"Delete</span></td>\n";
								echo "</tr>\n";
							}
						}
						
						?>
				</table>
			<?php } //end of if  ?>
		</div>
	</div>
	
	<!-- Start of loan modal -->
	<div id="newLoan" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">New Loan</h4>
				</div>
				<div class="modal-body">
					<!-- start Loan Form -->
					<form class="form-horizontal">
						<div class="form-group">
							<div class="col-md-6">
								<input type="text" name="amount" required
									placeholder="Loan Amount" class="form-control" id="amount" />
							</div>
							
							<div class="col-md-6">
								<input type="text" name="interest" required
									placeholder="Interest" class="form-control" id="interest" />
							</div>	
							
							<input type="hidden" value="<?php echo $client->id; ?>" id="clientId" />						
						</div>
						
						<div class="form-group">
							<div class="col-md-6">
								<input type="text" name="loanTenure" required
									placeholder="Loan Tenure" class="form-control" id="loanTenure" />								
							</div>
							
							<div class="col-md-6">
								<select name="tenurePeriod" id="tenurePeriod" class="form-control">
									<option selected disabled hidden>Tenure Period</option>
									<?php
										$tenures = array("days", "weeks", "months", "years");
										
										foreach($tenures as $tenure){
											echo "<option value='$tenure'>$tenure</option>";
										}
									?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-6">
								<input type="text" name="collateral" class="form-control" id="collateral" placeholder="Collateral">
							</div>
							
							<div class="col-md-6">
								
								<select name="loanStatus" class="form-control" id="loanStatus">
									<option value="" selected disabled hidden>Loan Status</option>
									<?php
										//	TODO: may want to store this in the database
										$loanStatus = array("For Approval", //Loan request have been made, reviewing request
												"Declined",  //Loan request was denied
												"Approved",  //Loan request was approved
												"Cash Received", //Loan amount was receivd by the debtor
												"Paid",  //Loan amount has been completely paid
												"Delayed", 	// payments have been delayed
												"Default",  //Debtor defaulted and cannot pay the loaned amount
												"In Payment" // payment is being received on time
										);
										
										foreach($loanStatus as $status){
											echo "<option value='$status'>$status</option>";
										}
									?>									
								</select>								
							</div>							
						</div>
						
						<div class="form-group">
							<div class="col-md-12">
								<textarea cols="3" rows="3" name="comment" placeholder="comments" class="form-control" id="comments"></textarea>							
							</div>
						</div>
					</form>
					<!-- end Loan Form -->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" id="submitLoan">Submit</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>
	<!-- End of loan modal -->
	
	<!-- okModal -->
	<div id="okModal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="okModalTitle">Modal Header</h4>
				</div>
				<div class="modal-body" id="okModalBody">
					<p>Some text in the modal.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
				</div>
			</div>

		</div>
	</div>
	<!-- End of okModal -->

	<!--  okCancelModal -->
	<div id="okCancelModal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="okCancelModal">Modal Header</h4>
				</div>
				<div class="modal-body" id="okCancelBody">
					<p>Some text in the modal.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" id="okBtn">OK</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</div>

		</div>
	</div>
	<!-- End of okCancelModal -->


</div>

<script>

var formMode;
var loanForm;
var idToEdit, idToDelete;
var amount, interest, comments, loanStatus, collateral, 
	loanTenure, tenurePeriod, clientId;
var payLoad = {url: "loan",
		method: "",
		data: {}};

//Possible candidate for generic library
function setFormMode(mode){

	console.log("setFormMode " + mode);
	formMode = mode;
	switch(mode){
		case "post": //add
			payLoad.method = "POST";
			break;
		case "put": //edit
			payLoad.method = "PUT";
			break;
		case "get": //get
			payLoad.method = "GET";
			payLoad.data = {id: idToEdit};
			break;
		case "delete":
			payLoad.method = "DELETE";
			payLoad.data = {id: idToDelete};
			break;
	}
}

function getArgs(){

	return { "amount": amount, "debtorId": clientId,
				"comments": comments, "loanStatus": loanStatus,
				"collateral": collateral, "loanTenure": loanTenure,
				"tenurePeriod": tenurePeriod, "interest": interest
			};
}

function resetForm(){
	var data = { "loanAmount": "", "debtorId": clientId,
			"comments": "", "loanStatus": "",
			"collateral": "", "loanTenure": "",
			"tenurePeriod": "", "interest": ""
		};	

	populateForm(data);
}

function populateForm(data){

	console.log("Populate form " + JSON.stringify(data));
	
	if(data){
		amount = (data.loanAmount) ? data.loanAmount : "";
		interest = (data.interest) ? data.interest : "";
		comments = (data.comments) ? data.comments : "";
		loanStatus = (data.loanStatus) ? data.loanStatus : "";
		collateral = (data.collateral) ? data.collateral : "";
		loanTenure = (data.loanTenure) ? data.loanTenure : "";
		tenurePeriod = (data.tenurePeriod) ? data.tenurePeriod : "";
		
		$("#amount").val(amount); 
		$("#interest").val(interest); 
		$("#comments").val(comments); 
		$("#loanStatus").val(loanStatus); 
		$("#collateral").val(collateral); 
		$("#loanTenure").val(loanTenure); 
		$("#tenurePeriod").val(tenurePeriod);		
	}	
}

function getLoan(id){
	if(id){
		idToEdit = id;
		setFormMode("get");
		payLoad.data = { id: idToEdit };
		sendAjax(payLoad, getDone, genericFailed, true);
	}	
}

function setLoanToDelete(id){
	if(id){
		idToDelete = id;
		setFormMode("delete");

		$("#okCancelTitle").html("Confirm Delete");
		$("#okCancelBody").html("Are you sure you want to delete loan id " + idToDelete );
		$("#okCancelModal").modal();
	}
}

//Possible candidate for generic library
function showError(data){

	if(data){
		if(data.title){
			$("#okModalTitle").html(data.title)
		}

		if(data.message){

			var message = ""
			if(Array.isArray(data.message)){

				for(var i=0,len=data.message.length;i<len;i++){
					message = message + data.message[i] + " " + "<br>";
				}
			}
			else if( typeof data.message ===  "string"){
				message = data.message;
			}
			else{ //handle an object
				for( var key in data.message ){
					if(data.message.hasOwnProperty(key)){
						message = message + key + ": " + data.message[key] + "<br>";
					}
				}
			}
			$("#okModalBody").html(message);
		}		
	}

	$("#okModal").modal();

}

function validateForm(){

	console.log("validating the form");
	var validationResult = true;	

	amount = $("#amount").val(); 
	interest = $("#interest").val(); 
	comments = $("#comments").val(); 
	loanStatus = $("#loanStatus").val(); 
	collateral = $("#collateral").val(); 
	loanTenure = $("#loanTenure").val(); 
	tenurePeriod = $("#tenurePeriod").val();
	clientId = $("#clientId").val();

	if( amount ){
		validationResult = !isNaN(amount);
	}

	if(interest){
		validationResult = !isNaN(interest);
	}

	if( !loanStatus || !collateral || !loanTenure || !tenurePeriod){
		validationResult = false;
	}

	return validationResult;
}

//calback functions
function genericFailed(data){
	console.log(payLoad.method + " failed data: " + JSON.stringify(data));

	var returnData = JSON.parse(data);	
	completeSubmit(loanForm);
	args.data = null;
	showError(data);	
}

function genericDone(data){
	completeSubmit(loanForm);
	console.log(payLoad.method + "done data: " + JSON.stringify(data));
	var returnData = JSON.parse(data);
	
	if(returnData){				
		if(returnData.result == 1){
			payLoad.data = null;			
			location.reload();
		}
		else{
			showError(returnData);
		}
	}
	else{
		showGenericError();
	}
}

function getDone(data){
	completeSubmit(loanForm);
	console.log("get done data: " + JSON.stringify(data));
	var returnData = JSON.parse(data);

	if(returnData){
		if(returnData.result == 1){
			populateForm(returnData.data);
			$("#newLoan").modal();
			setFormMode("put");
		}
		else{
			showError(returnData)
		}		
	}
	else{
		showGenericError();
	}
}

function showGenericError(){

	var err = { "title": "Generic Error",
				"message": "An error have occured please contact the administrator."};
	showError(err);
}

$(document).ready(function(){

	loanForm = $("#newLoan");

	$("#submitLoan").click(function(event){

	    if (loanForm.data('submitted') === true) {
		      // Previously submitted - don't submit again	
			  console.log("form was already submitted.");	      
		} 
	    else {
			
			if(validateForm()){
				
				payLoad.data = getArgs();
				console.log("Sending Payload: " + JSON.stringify(payLoad));
				
				if(formMode == "post"){				
					sendAjax(payLoad, genericDone, genericFailed, true);
				}
				else if(formMode == "put"){
					payLoad.data.id = idToEdit;
					sendAjax(payLoad, genericDone, genericFailed, true);
				}			
			}
			else{
				showError({title: "Validation Failed", message:"Double check your entries."});
			}
	    }		
	});

	$("#okBtn").click(function(event){
		payLoad.data = {"id": idToDelete }

		console.log("delete payload " + JSON.stringify(payLoad));
		sendAjax(payLoad, genericDone, genericFailed);
	});

	$("#btnNewLoan").click(function(ev){
		setFormMode("post");
	});

});	
</script>