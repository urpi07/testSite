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
						<div class="form-group">

							<div class="col-md-5">
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
						
							<div class="col-sm-3">
								<input type="text" name="middleName" required
									placeholder="Middle Name" class="form-control" id="middleName" />
							</div>						
						
							<div class="col-sm-3">
								<select class="form-control" name="gender" id="gender" required>
									<option selected disabled hidden>[Gender]</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>
							</div>
													
							<div class="col-sm-3">
								<input type="email" name="email" required placeholder="Email"
									id="email" class="form-control" />
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
					echo "\t<td><button type='button' class='btn btn-primary' " . "onclick='getClient($client->id)'>Edit</button></td>\n";
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
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

class MyModal {
	var header, footer, body;

	constructor(header, body, footer){
		this.header = header;
		this.body = body;
		this.footer = footer;
	}
}

//email regular expression
var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
var emailElement = $("#email");;        		  

//data fields holder
var birthMonth,	birthDate, birthYear, gender, privilege;	
var firstName, lastName, middleName, email,	address, phone;	

function setFormMode(mode){

	formMode = mode;
	switch(mode){
		case "post": //add
			args.method: "POST";
			break;
		case "put": //edit
			args.method: "PUT";
			break;
		case "get": //get
			args.method: "GET";
			args.data = {id: itemToGet};
			break;
		case "delete":
			args.method: "DELETE";
			args.data = {id: itemToDelete};
			break;
	}
}

function completeSubmit(){
	$("body").css("cursor", "default");
	clientForm.data('submitted', false);		
}

function populateForm(data){

	if(data){
		if(data.birthdate){
			var birthDate = data.birthdate.toString().split("-");			
			
			$("#birthYear").val( birthDate[0]);
			$("#birthMonth").val( parseInt(birthDate[1]) );
			$("#birthDate").val( parseInt(birthDate[2]) );		
		}

		data.firstName = (data.firstName) ? data.firstName : "";
		data.lastName = (data.lastName) ? data.lastName : "";
		data.middleName = (data.middleName) ? data.middleName : "";
		data.comments = (data.comments) ? data.comments : "";
		data.phone = (data.phone) ? data.phone : "";
		data.address = (data.address) ? data.address : "";
		data.gender = (data.gender) ? data.gender : "";
		data.email = (data.email) ? data.email : "";				
		
		$("#firstName").val(data.firstName);
		$("#lastName").val(data.lastName);
		$("#middleName").val(data.middleName);
		$("#comments").val(data.comments);
		$("#phone").val(data.phone);
		$("#address").val(data.address);
		$("#gender").val(data.gender);
		$("#email").val(data.email);		
	}

}

function resetForm(){

	data = {
		firstName: "", lastName: "", middleName: "",
		phone: "", email: "", address:"", 
		comments: "", gender: "", birthdate: ""
	};
	
	populateForm(data);
}

function setItemToDelete(id){
	itemToDelete = id;
}

function setItemToEdit(id){
	itemToEdit = id;
	setFormMode("GET");
}

function getClient(){
	
}

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

function submitForm(){

	if(validateForm()){
		args.data = getFormArgs(); 
		sendAjax(args, postDone, postFailed);
	}	
}

//POST callbacks
function postDone(data){

	completeSubmit();
	//clean up
	args.data = null;
}

function postFailed(data){
	completeSubmit();
	args.data = null;
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

	if( !expr.test(email) ){
		console.log(email + "is not a valid email");
		emailElement.addClass(".has-error");
		validationSuccess = false;
	}	

	return validationSuccess;
}


$(document).load(function(){

	var okModal = new MyModal( $("#okHeader"), $("#okBody"), $("#okFooter") );
	var okCancelModal = new MyModal( $("#okCancelHeader"), $("#okCancelBody"), $("#okCancelFooter") );

	$("#btnSubmit").click(function(){

	    console.log("Submitting the form");		    
	    event.preventDefault();
	    
	    if (clientForm.data('submitted') === true) {
	      // Previously submitted - don't submit again	
		  console.log("form was already submitted.");	      
	    } 
	    else {
		    setFormMode("post");
		    submitForm();
	    }		
		
	});	
});

</script>
