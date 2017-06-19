<div class="panel panel-default">
	<div class="panel-heading"><h3>System Users</h3></div>

	<div class="panel-body">

		<!-- New User Form -->
		<div id="newUser" class="collapse">
			<form method="POST" class="form-horizontal" action="userAccount"
				id="newusers">
				<div class="panel panel-default">
					<div class="panel-body inner-panel">
						<!-- TODO: Upload of the profile image -->
				<?php //print_r(apache_request_headers()); ?>
				<h4>New User</h4>
				
						<div class="form-group">
							<div class="col-sm-4">
								<img src="assets/img/male_profilePic.png" class="img-thumbnail" alt="profile picture" id="profilePic">
							</div>
							
							<div class="col-md-5 imgUplader">
								<span class="btn btn-default btn-file"> Upload Picture <input
									type="file">
								</span>
							</div>
						</div>						
										
						<div class="form-group">
							<div class="col-sm-4">
								<input type="text" name="firstName" required
									placeholder="First Name" class="form-control" id="firstName"/>
							</div>
							<div class="col-sm-4">
								<input type="text" name="lastName" required
									placeholder="Last Name" class="form-control" id="lastName"/>
							</div>
							<div class="col-sm-4">
								<input type="text" name="middleName" required
									placeholder="Middle Name" class="form-control" id="middleName"/>
							</div>
						</div>
																
						<div class="form-group">
							<div class="col-sm-4">Birthdate</div><br>
							<div class="col-sm-2">
								<select name="birthMonth" class="form-control" id="birthMonth" required>
									<option selected disabled hidden>Month</option>
									<?php 
									$months = array("January","February","March",
											"April","May","June",
											"July","August","September",
											"October","November","December");
									
									$monthValue = 1;
									foreach($months as $month){
										echo "<option value='$monthValue'>$month</option>";
										$monthValue++;
									}
									
									?>
								</select>
							</div>
							<div class="col-sm-2">
								<select name="birthDate" class="form-control" id="birthDate" required>
									<option selected disabled hidden>Date</option>
									<?php
										for($date = 1; $date < 32; $date++){
											echo "<option value='$date'>$date</option>";
										}
									?>
								</select>
							</div>
							
							<div class="col-sm-2">
								<select name="birthYear" class="form-control" id="birthYear" required>
									<option selected disabled hidden>Year</option>
									<?php
										$currentYear = date('Y');
										$yearLimit = $currentYear - 150;
										
										while($currentYear >= $yearLimit){
											echo "<option value='$currentYear'>$currentYear</option>";
											$currentYear--;
										}
									?>
								</select>
							</div>
							
							<div class="col-sm-3">
								<select class="form-control" name="gender" id="gender" required>
									<option selected disabled hidden>[Gender]</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>
							</div>

							<div class="col-sm-3">
								<select name="privilege" class="form-control" id="privilege" required>
									<option selected disabled hidden>[Privilege]</option>
								<?php
								if (isset ( $privileges )) {
									foreach ( $privileges as $privilege ) {
										?>
									<option value=<?php echo $privilege["id"]?>><?php echo $privilege["type"]?></option>
								<?php
									}
								}
								?>
								</select>
							</div>
							
							

						</div>

						<div class="form-group">										
							<div class="col-sm-3">
								<input type="email" name="email" required placeholder="Email" id="email"
									class="form-control" />
							</div>
							
							<div class="col-sm-6">
								<input type="text" name="address" required placeholder="Address" id="address"
									class="form-control" />
							</div>							
							
							<div class="col-sm-3">
								<input type="text" name="phoneNumber" required id="phone"
									placeholder="Phone  Number" class="form-control" />
							</div>									
						</div>

						<div class="col-sm-offset-5 col-sm-7">
							<button type="submit" class="btn btn-default" id="editSubmit">Submit</button>
						</div>

					</div>
				</div>

				<div class="panel panel-default" id="credentialPanel">
					<div class="panel-body inner-panel">
						<h4>User Credentials:</h4>

						<div class="form-group">
							<div class="col-sm-2"></div>
							<label class="control-label col-sm-2" for="username">User Name: </label>
							<div class="col-sm-4">
								<input type="text" name="username" required id="username"
									placeholder="User Name" class="form-control" />
							</div>
							<div class="col-sm-2"></div>
						</div>

						<div class="form-group">
							<div class="col-sm-2"></div>
							<label class="control-label col-sm-2" for="password">Password: </label>
							<div class="col-sm-4">
								<input type="password" name="password" required id="password"
									class="form-control" />
							</div>
							<div class="col-sm-2"></div>
						</div>

						<div class="form-group">
							<div class="col-sm-2"></div>
							<label class="control-label col-sm-2" for="vpassword">Verify
								Password: </label>
							<div class="col-sm-4">
								<input type="password" name="vpassword" required id="vpassword"
									class="form-control" />
							</div>
							<div class="col-sm-2"></div>
						</div>


						<div class="col-sm-offset-5 col-sm-7">
							<button type="submit" class="btn btn-default">Submit</button>							
						</div>
					</div>
				</div>
			</form>			
				
		</div>

		<!-- End of New User Form -->

		<button type="button" class="btn btn-primary" data-toggle="collapse"
			data-target="#newUser" id="btnNewUser">New User</button>
		<br>
		<br>
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
	if (isset ( $users )) {
		foreach ( $users as $user ) {
			echo "<tr>\n";
			echo "\t<td>$user->id</td>\n";
			echo "\t<td>$user->firstName</td>\n";
			echo "\t<td>$user->lastName</td>\n";
			echo "\t<td>$user->middleName</td>\n";
			echo "\t<td>$user->phone</td>\n";
			echo "\t<td><button type='button' class='btn btn-primary' " . "onclick='getUser($user->id)'>Edit</button></td>\n";
			echo "\t<td><button type='button' class='btn btn-success' class='btnDelete' " . "data-toggle='modal' data-target='#deleteModal' " . "onclick='setItemToDelete($user->id)'>Delete</button></td>\n";
			echo "</tr>\n";
		}
	}
	?>
	
	</table>
		</div>

		<div id="deleteModal" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Delete User</h4>
					</div>
					<div class="modal-body">
						<p>Are you sure you want to delete this user??</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"
							data-toggle="deleteModal" id="confirmUserDelete">YES</button>
						<button type="button" class="btn btn-default" data-dismiss="modal"
						  	data-toggle="deleteModal" id="cancelUserDelete">CANCEL</button>
					</div>
				</div>

			</div>
		</div> <!-- End of the deleteModal dialog -->
		
		<div id="addUserModal" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Success</h4>
					</div>
					<div class="modal-body">
						<p>User was successfully added.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal" 
							data-toggle="#addUserModal" id="okAddUser">OK</button>						
					</div>
				</div>

			</div>
		</div> <!-- End of the addUserModal dialog -->

		<div id="errorModal" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title" id="errorModalTitle">Delete User</h4>
					</div>
					<div class="modal-body" >
						<p id="errorMessage">Error adding user.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"
							data-target="#errorModal" id="okErrorModal">OK</button>
					</div>
				</div>

			</div>
		</div>
		<!-- End of the addUserModal dialog -->

		<ul class="pagination">
			<li><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>
			<li><a href="#">5</a></li>
		</ul>


	</div>	<!-- end of panel-body -->
</div> <!-- end of panel -->

<!-- TODO: add a pagination component -->
<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
<script>

	var itemTodelete = 0;
	var itemToEdit = 0;
	var formMode;  //can either be "add" or "edit"

	//email regular expression
    var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    var emailElement = $("#email");;
    var vpassElement =	$("#vpassword");         		   
    
	//data fields holder
	var birthMonth,	birthDate, birthYear, gender, privilege;	
	var firstName, lastName, middleName, email,	address, phone,	username, password,	vpassword;	
	var $form = $("#newusers");	

	function setItemToDelete(id){
		itemToDelete = id;		
	}

	function getUser(id){

		if(id){
			$("body").css("cursor", "progress");
			console.log("getting user: " + id);
			itemToEdit = id;
			
			$.ajax({
				url: "user",
				method: "GET",
				data: {id: id}
			})
			.done(function(data){

				console.log("done data " + JSON.stringify(data));
				var getData = JSON.parse(data);
				if(getData && getData.result == 1){
					$("#credentialPanel").hide();
					populateFields(getData.user);	
					$("#newUser").collapse();
					setFormMode("edit");
					console.log("getUser id form mode: " + formMode);							
				}
				else{					
					showError(getData);
				}
				$("body").css("cursor", "default");
			})
			.fail(function(data){
				console.log("failed data " + JSON.stringify(data));
				showError(data);
				$("body").css("cursor", "default");
			});				
		}	
	}

	function setFormMode(mode){

		var editSubmitBtn = $("#editSubmit");

		formMode = mode;
		
		switch(mode){
			case "add":			
				editSubmitBtn.hide();
				$("#username").attr("required", "required");
				$("#password").attr("required", "required");
				$("#vpassword").attr("required", "required");	
				editSubmitBtn.attr("disabled", "disabled");		
				break;
	
			case "edit":
				editSubmitBtn.show();
				$("#username").removeAttr("required");
				$("#password").removeAttr("required");
				$("#vpassword").removeAttr("required");				
				editSubmitBtn.removeAttr("disabled");
				break;
		}
	}
	
	function editUser(args){

		$("body").css("cursor", "progress");
		$.ajax({
			url: "user",
			method: "PUT",
			data : args 
		})
		.done(function(data){

			console.log("update data " + data);
			var retData = JSON.parse(data);

			if(retData && retData.result == 1){
				loadPage("users");
			}
			else{
				showError(retData);
			}
			
			completeSubmit();
		})
		.fail(function(data){
			completeSubmit();
		});						
	}

	function completeSubmit(){
		$("body").css("cursor", "default");
		$form.data('submitted', false);		
	}

	function addUser(args){

		$("body").css("cursor", "progress");
		$.ajax({
			url: "users/userAccount",
			method: "POST",
			data: args
		})
		.done(function(data){

			console.log("Post data " + JSON.stringify(data));
			var returnVal = JSON.parse(data);
			
			if(returnVal && returnVal.result == 1){ //add was a success
				$("#addUserModal").modal();
				resetUserForm();
			}
			else{ //failure
				showError(returnVal);
			}

			completeSubmit();
		})
		.fail(function(data){
			console.log("post failure "+ JSON.stringify(data));
			resetUserForm();
			completeSubmit();			
		});			
	}

	function showError(data){

		if(data){
			if(data.title){
				$("#errorModalTitle").html(data.title.toString());
			}

			if(data.message){
				$("#errorMessage").html(data.message.toString());
			}
		}		
		
		$("#errorModal").modal();		
	}

	function populateFields(data){

		if(data.birthdate){
			var birthDate = data.birthdate.toString().split("-");			
					
			$("#birthYear").val( birthDate[0]);
			$("#birthMonth").val( parseInt(birthDate[1]) );
			$("#birthDate").val( parseInt(birthDate[2]) );						
		}

		if(data.gender){
			$("#gender").val(data.gender);
		}

		if(data.privilege){
			$("#privilege").val(data.privilege);
		}
		
		if(data.firstName){
			$("#firstName").val(data.firstName);
		}

		if(data.lastName){
			$("#lastName").val(data.lastName);
		}

		if(data.middleName){
			$("#middleName").val(data.middleName);	
		}

		if(data.email){
			$("#email").val(data.email);
		}

		if(data.address){
			$("#address").val(data.address);
		}

		if(data.phone){
			$("#phone").val(data.phone);	
		}		
	}

	function resetUserForm(){
		//clear all the fields
		$("#birthMonth").prop('selectedIndex', 0);
		$("#birthDate").prop('selectedIndex', 0);
		$("#birthYear").prop('selectedIndex', 0);
		$("#gender").prop('selectedIndex', 0);
		$("#privilege").prop('selectedIndex', 0);
		
		$("#firstName").val("");
		$("#lastName").val("");
		$("#middleName").val("");
		$("#email").val("");
		$("#address").val("");
		$("#phone").val("");
		$("#username").val("");
		$("#password").val("");
		$("#vpassword").val("");		
	}

	function createAccountArgs(){

		var args;

		switch(formMode){
		case "add":
			args = {
					"birthMonth":birthMonth,"birthDate":birthDate,"birthYear":birthYear,
					"gender":gender,"privilege":privilege,"firstName":firstName,
					"lastName":lastName,"middleName":middleName,"email":email,
					"address":address,"phone":phone,"username":username,
					"password":password,"vpassword":vpassword, "phoneNumber": phone			    	
				};
			break;

		case "edit":
			args = {
					"birthMonth":birthMonth,"birthDate":birthDate,"birthYear":birthYear,
					"gender":gender,"privilege":privilege,"firstName":firstName,
					"lastName":lastName,"middleName":middleName,"email":email,
					"address":address,"phone":phone, "phoneNumber": phone			    	
				};
			break;
		}
		return args;
	}

	function performValidation(){
		
	    console.log("process the form");
	    var validationSuccess = true;        		  
	    
		//some front end validation
		birthMonth = $("#birthMonth").val();
		birthDate = $("#birthDate").val();
		birthYear = $("#birthYear").val();
		gender = $("#gender").val();
		privilege = $("#privilege").val();
		
		firstName = $("#firstName").val();
		lastName = $("#lastName").val();
		middleName = $("#middleName").val();
		email = emailElement.val();
		address = $("#address").val();
		phone = $("#phone").val();
		username = $("#username").val();
		password = $("#password").val();
		vpassword = vpassElement.val();	

		if(password != vpassword){
			console.log(password + " is not equal to " + vpassword);
			vpassElement.addClass(".has-error");
			validationSuccess = false;
		}		

		if( !expr.test(email) ){
			console.log(email + "is not a valid email");
			emailElement.addClass(".has-error");
			validationSuccess = false;
		}

		return validationSuccess;
	}
	
	$(document).ready(function(){ 	

		setFormMode("add");
		//refresh the page after adding a new user
		$("#okAddUser").click(function(event){
			$(this).attr("disabled", "disabled");
			console.log("reloading the page");
			loadPage("users");
		});	

		$("#confirmUserDelete").click(function(event){

			$("#confirmUserDelete").attr("disabled", "disabled");
			$("body").css("cursor", "progress");
			if(itemToDelete){

				$.ajax({
					url: "user",
					method:"DELETE",
					data: {id: itemToDelete}
				})
				.done(function(data){

					console.log("Delete data " +  JSON.stringify(data));
					var deleteVal = JSON.parse(data);
					
					if(deleteVal && deleteVal.result == 1){
						console.log("reload the page " + data.result);
						loadPage("users");
					}
					else{
						console.log("show Error");
						showError(deleteVal);
					}
					
					$("body").css("cursor", "default");
				})
				.fail(function(data){
					$("body").css("cursor", "default");
				})
			}
		});

		$("#cancelUserDelete").click(function(event){
			$("#cancelUserDelete").attr("disabled", "disabled");
			$("#deleteModal").modal();
		});

		//$("#okErrorModal").click(function(event){
			//$(this).modal();
			//$(this).attr("disabled", "disabled");
		//});
		
		//disable/reenable buttons after finishing transitions,
		//to prevent unnecessary call.
		$("#deleteModal").on("hidden.bs.modal", function(event){
			$("#cancelUserDelete").removeAttr("disabled");
			$("#confirmUserDelete").attr("disabled", "disabled");
		});

		$("#addUserModal").on("hidden.bs.modal", function(event){
			$("#okAddUser").removeAttr("disabled");
		});

		$("#errorModal").on("hidden.bs.modal", function(event){
			$("#okErrorModal").removeAttr("disabled");
		});
		//---- end of section ----

		//submit a new user
		$("#newusers").submit(function(event){					   

		    console.log("Submitting the form");		    
		    event.preventDefault();
		    
		    if ($form.data('submitted') === true) {
		      // Previously submitted - don't submit again	
			  console.log("form was already submitted.");	      
		    } 
		    else {				
				if(!performValidation()){
					console.log("Error in validation")
					return;
				}

		    	var args = createAccountArgs();
				
				//Form submission through ajax
				console.log("submmitting via ajax");
				$("body").css("cursor", "progress");

				switch(formMode){
					case "add":
						addUser(args);				
					break;

					case "edit":
						args.id = itemToEdit;
						editUser(args);
					break;
				}
			    
		      // Mark it so that the next submit can be ignored		      		     		      
		      $form.data('submitted', true);
		    }			
		});
 
		//reset the new user form
		var newUser = $("#newUser");
		var btnNewUser = $("#btnNewUser");
		
		newUser.on("show.bs.collapse", function(){
			btnNewUser.text("Cancel");			
		});

		newUser.on("hide.bs.collapse", function(){
			btnNewUser.text("New User");
			$("#credentialPanel").show();
			resetUserForm();
			setFormMode("add");
			console.log("form mode: " + formMode);
		}); 	
	});
</script>

