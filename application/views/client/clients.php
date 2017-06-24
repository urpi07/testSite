<div class="" id="mycontent">
	<div class="modal fade" role="dialog" id="newClientModal" >
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Modal Header</h4>
				</div>
				<div class="modal-body">
					<!-- Start of client form -->
					<form class="form-horizontal" id="newClientForm">
						<div class="form-group" >
							<div class="col-md-5 popupImageUpload">
								<span class="btn btn-default btn-file"> Upload Picture <input
									type="file">
								</span>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-6">
								<input type="text" name="firstName" required
									placeholder="First Name" class="form-control" id="firstName" />
							</div>
							<div class="col-sm-6">
								<input type="text" name="lastName" required
									placeholder="Last Name" class="form-control" id="lastName" />
							</div>
						</div>
						
						<div class="form-group">
						
							<div class="col-sm-5">
								<input type="text" name="middleName" required
									placeholder="Middle Name" class="form-control" id="middleName" />
							</div>

							<div class="col-sm-4">
								<input type="email" name="email" required placeholder="Email"
									id="email" class="form-control" />
							</div>

							<div class="col-sm-3">
								<select class="form-control" name="gender" id="gender" required>
									<option selected disabled hidden>[Gender]</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>
							</div>
																			
						</div>						

						<div class="form-group">
							<!-- start of the form group -->
							<div class="col-sm-4">Birthdate</div>
							<br>
							<div class="col-sm-5">
								<select name="birthMonth" class="form-control" id="birthMonth"
									required>
									<option selected disabled hidden>Month</option>
									<?php
									$months = array (
											"January",
											"February",
											"March",
											"April",
											"May",
											"June",
											"July",
											"August",
											"September",
											"October",
											"November",
											"December" 
									);
									
									$monthValue = 1;
									foreach ( $months as $month ) {
										echo "<option value='$monthValue'>$month</option>";
										$monthValue ++;
									}
									
									?>
								</select>
							</div>
							<div class="col-sm-3">
								<select name="birthDate" class="form-control" id="birthDate"
									required>
									<option selected disabled hidden>Date</option>
									<?php
									for($date = 1; $date < 32; $date ++) {
										echo "<option value='$date'>$date</option>";
									}
									?>
								</select>
							</div>

							<div class="col-sm-4">
								<select name="birthYear" class="form-control" id="birthYear"
									required>
									<option selected disabled hidden>Year</option>
									<?php
									$currentYear = date ( 'Y' );
									$yearLimit = $currentYear - 150;
									
									while ( $currentYear >= $yearLimit ) {
										echo "<option value='$currentYear'>$currentYear</option>";
										$currentYear --;
									}
									?>
								</select>
							</div>
						</div>
						<!--  end of the select form group -->

						<div class="form-group">
							<div class="col-sm-6">
								<input type="text" name="address" required placeholder="Address"
									id="address" class="form-control" />
							</div>

							<div class="col-sm-6">
								<input type="text" name="phoneNumber" required id="phone"
									placeholder="Phone  Number" class="form-control" />
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<textarea cols="3" rows="3" name="comment"
									placeholder="comments" class="form-control" id="comments"></textarea>
							</div>
						</div>

					</form>
					<!-- End of client form -->
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-default" id="btnSubmit">Submit</button>
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
			<button type="button" class="btn btn-primary" data-toggle="modal"
				data-target="#newClientModal" id="btnNewClient">New Client</button>

			<br> <br>

			<div class="table-responsive">
				<table class="table-bordered" id="usersTable">
			<?php
			
			// var_dump($users);
			$tableHeaders = array (
					"ID",
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
					echo "\t<td>".
							"<span class='btnEdit' onclick='getClient($client->id)'>".
							"<i class='fa fa-pencil-square-o' aria-hidden='true'></i>&nbsp".
							"Edit</span></td>\n";
					echo "\t<td>".
							"<span class='btnDelete' " .
							"data-toggle='modal' data-target='#deleteModal' " .
							"onclick='setClientToDelete($client->id)'>".
							"<i class='fa fa-times' aria-hidden='true'></i>&nbsp".
							"Delete</span></td>\n";
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
</div>

<!-- Modals for our messages -->

<!-- OK modal -->
<div id="messageModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="messageTitle">Modal Header</h4>
			</div>
			<div class="modal-body" id="messageBody">
				
			</div>
			<div class="modal-footer" id="messageFooter">
				<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
			</div>
		</div>

	</div>
</div>

<!-- OK Cancel modal -->
<div id="okCancelModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="okCancelTitle">Modal Header</h4>
			</div>
			<div class="modal-body" id="okCancelBody">
				
			</div>
			<div class="modal-footer" id="okCancelFooter">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="okBtn">OK</button>
				<button type="button" class="btn btn-default" data-dismiss="modal" id="cancelBtn">Cancel</button>
			</div>
		</div>

	</div>
</div>

<script>

var clientForm = $("#newClientForm");
var itemToDelete, itemToEdit;
var formMode;
var args = {
	url: "client",
	method: "",
	data: {}
};

//email regular expression
var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
var emailElement = $("#email");;        		  

//data fields holder
var birthMonth,	birthDate, birthYear, gender, privilege;	
var firstName, lastName, middleName, email,	address, phone;	

function setFormMode(mode){

	console.log("setFormMode " + mode);
	formMode = mode;
	switch(mode){
		case "post": //add
			args.method = "POST";
			break;
		case "put": //edit
			args.method = "PUT";
			break;
		case "get": //get
			args.method = "GET";
			args.data = {id: itemToEdit};
			break;
		case "delete":
			args.method = "DELETE";
			args.data = {id: itemToDelete};
			break;
	}
}

function completeSubmit(){
	console.log("Set cursor to default");	
	$("body").css("cursor", "default");
	clientForm.data('submitted', false);		
}

function populateForm(data){

	if(data){
		console.log("populating the form " + JSON.stringify(data));
		if(data.birthdate){
			var birthDate = data.birthdate.toString().split("-");			
			
			$("#birthYear").val( birthDate[0]);
			$("#birthMonth").val( parseInt(birthDate[1]) );
			$("#birthDate").val( parseInt(birthDate[2]) );		
		}
		else{
			$("#birthMonth").prop('selectedIndex', 0);
			$("#birthDate").prop('selectedIndex', 0);
			$("#birthYear").prop('selectedIndex', 0);			
		}

		if(data.gender || data.gender == ""){
			$("#gender").prop('selectedIndex', 0);
		}
		else{
			$("#gender").val(data.gender);
		}		

		data.firstName = (data.firstName) ? data.firstName : "";
		data.lastName = (data.lastName) ? data.lastName : "";
		data.middleName = (data.middleName) ? data.middleName : "";
		data.comments = (data.comments) ? data.comments : "";
		data.phone = (data.phone) ? data.phone : "";
		data.address = (data.address) ? data.address : "";		
		data.email = (data.email) ? data.email : "";				
		
		$("#firstName").val(data.firstName);
		$("#lastName").val(data.lastName);
		$("#middleName").val(data.middleName);
		$("#comments").val(data.comment);
		$("#phone").val(data.phone);
		$("#address").val(data.address);		
		$("#email").val(data.email);		
	}
}

function resetForm(){

	var data = {
		firstName: "", lastName: "", middleName: "",
		phone: "", email: "", address:"", 
		comment: "", gender: ""
	};

	console.log("data reset form " + JSON.stringify(data));
	populateForm(data);
}

function setClientToDelete(id){
	itemToDelete = id;
	args.data = {id: itemToDelete};
	setFormMode("delete");

	$("#okCancelHeader").html("Delete Confirmation");
	$("#okCancelBody").html("Are you sure you want to delete this client record?");
	$("#okCancelModal").modal();	
}

function sendAjax(payload, successCB, failCB){

	console.log("Send AJAX payload " + JSON.stringify(payload));
	$("body").css("cursor", "progress");
	$.ajax(payload)
	.done( successCB )
	.fail( failCB );
}

//POST callbacks
function postDone(data){

	completeSubmit();
	console.log("post done data: " + JSON.stringify(data));
	
	var returnData = JSON.parse(data);

	if(returnData && returnData.result == 1){		
		args.data = null;

		location.reload(); //refresh to see the changes		
	}
	else{
		showError(returnData);
	}

}

function genericFailed(data){
	console.log(args.method + " failed data: " + JSON.stringify(data));

	var returnData = JSON.parse(data);	
	completeSubmit();
	args.data = null;
	showError(data);
}

function submitForm(){
	
	if(validateForm()){
		
		args.data = getFormArgs(); 
		console.log("submitting the form on " + formMode);
		console.log("payload " + JSON.stringify(args));
		if(formMode == "post"){
			sendAjax(args, postDone, genericFailed);
		}
		else if(formMode == "put"){
			args.data.id = itemToEdit;
			sendAjax(args, putDone, genericFailed);
		}		
	}	
}

//put callbacks
function putDone(data){
	
	completeSubmit();	
	console.log("put done data: " + JSON.stringify(data));
	
	var returnData = JSON.parse(data);

	if(returnData && returnData.result == 1){			
		args.data = null;
		location.reload(); //refresh to see the changes		
	}
	else{
		showError(returnData);
	}
}

//delete callbacks
function deleteDone(data){
	completeSubmit();
	console.log("delete success data: " + JSON.stringify(data));

	var returnData = JSON.parse(data);

	if(returnData && returnData.result == 1){		
		args.data = null;	
		location.reload(); //refresh to see the changes		
	}	
	else{
		showError(returnData);
	}
}

function showError(data){

	console.log("Showing Error " + JSON.stringify(data));
	if(data){

		if(data.title){
			$("#messageTitle").html(data.title);
		}

		if(data.message){

			var message = ""
			if(Array.isArray(data.message)){

				for(var i=0,len=data.message.length;i<len;i++){
					message = message + data.message[i] + " ";
				}
			}
			else if( typeof data.message ===  "string"){
				message = data.message;
			}
			else{ //handle an object
				for( var key in data.message ){
					if(data.message.hasOwnProperty(key)){
						message = message + key + ": " + data.message[key];
					}
				}
			}
			$("#messageBody").html(message);
		}
	}

	$("#messageModal").modal();
}

function getClient(id){	
	itemToEdit = id;
	args.data = {id:itemToEdit};
	setFormMode("get");
	sendAjax(args, getDone, genericFailed);
}

//get callbacks
function getDone(data){
	completeSubmit();
	console.log("get done data: " + JSON.stringify(data));
	
	var returnData = JSON.parse(data);	

	if(returnData && returnData.result == 1){
		//clean up
		args.data = null;		
		setFormMode("put");
		populateForm(returnData.data[0]);
		$("#newClientModal").modal();			
	}
	else{
		showError(returnData);
	}
}

//validate form must be called first before getArgs
function getFormArgs(){

	var birthdate = birthYear + "-" + birthMonth + "-" + birthDate;
	
	return {"firstName": firstName, "lastName": lastName, "middleName": middleName,
		"phone": phone, "address": address, "comments": comments, "email": email,
		"birthdate":birthdate, "gender": gender};
}

function validateForm(){

    console.log("process the form");
    var validationSuccess = true;        		  
    
	//some front end validation
	birthMonth = $("#birthMonth").val();
	birthDate = $("#birthDate").val();
	birthYear = $("#birthYear").val();
	gender = $("#gender").val();	
	
	firstName = $("#firstName").val();
	lastName = $("#lastName").val();
	middleName = $("#middleName").val();
	email = emailElement.val();
	address = $("#address").val();
	phone = $("#phone").val();
	comments = $("#comments").val();

	if( !expr.test(email) ){
		console.log(email + "is not a valid email");
		emailElement.addClass(".has-error");
		validationSuccess = false;
	}	

	return validationSuccess;
}


$(document).ready(function(){

	$("#okCancelModal").on("hide.bs.modal", function(event){
		console.log("cancelBtn formMode " + formMode);
		if(formMode == "put"){
			resetForm();
			setFormMode("post");
		}

		completeSubmit();		
	});		

	$("#btnSubmit").click(function(event){

	    console.log("Submitting the form");		    
	    event.preventDefault();
	    
	    if (clientForm.data('submitted') === true) {
	      // Previously submitted - don't submit again	
		  console.log("form was already submitted.");	      
	    } 
	    else {		    
		    submitForm();
	    }				
	});	

	$("#btnNewClient").click(function(event){
		setFormMode("post");
		resetForm();
	});

	$("#okBtn").click(function(event){		
		if(formMode == "delete"){
			console.log("deleting record ");
			sendAjax(args, deleteDone, genericFailed);
		}
	});	

});

</script>
