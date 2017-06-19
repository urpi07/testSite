 <div class="container form-container">	
	<form method="POST" class="form-horizontal" action="userCreated" id="newusers">
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- TODO: Upload of the profile image -->
				<?php //print_r(apache_request_headers()); ?>
				<h3>New User</h3>
				<div class="form-group">
					<div class="col-sm-5">
						<input type="text" name="firstName" required
							placeholder="First Name" class="form-control" />
					</div>
					<div class="col-sm-5">
						<input type="text" name="lastName" required
							placeholder="Last Name" class="form-control" />
					</div>
					<div class="col-sm-2">
						<input type="text" name="middleName" required
							placeholder="Middle Name" class="form-control" />
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-4">
						<input type="text" placeholder="Birth Date" class="form-control"
							id="bday" name="birthdate">
					</div>

					<div class="col-sm-4">
						<select class="form-control" name="gender">
							<option value="">[Gender]</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
						</select>
					</div>
					<div class="col-sm-4">
						<input type="email" name="email" required placeholder="Email"
							class="form-control" />
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-8">
						<input type="text" name="address" required placeholder="Address"
							class="form-control" />
					</div>
					<div class="col-sm-4">
						<input type="text" name="phoneNumber" required
							placeholder="Phone  Number" class="form-control" />
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-8">
						<select name="privilege" class="form-control">
							<option value="-1" selected>[Select Privilege]</option>
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
					<div class="col-sm-4">
						<input type="text" name="profileImage" placeholder="Profile Image"
							class="form-control" />
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-body">				
				<h4>User Credentials:</h4>

				<div class="form-group">
					<div class="col-sm-2"></div>
					<label class="control-label col-sm-2" for="username">User Name: </label>
					<div class="col-sm-4">
						<input type="text" name="username" required
							placeholder="User Name" class="form-control" />
					</div>
					<div class="col-sm-2"></div>
				</div>

				<div class="form-group">
					<div class="col-sm-2"></div>
					<label class="control-label col-sm-2" for="password">Password: </label>
					<div class="col-sm-4">
						<input type="password" name="password" required
							class="form-control" />
					</div>
					<div class="col-sm-2"></div>
				</div>

				<div class="form-group">
					<div class="col-sm-2"></div>
					<label class="control-label col-sm-2" for="vpassword">Verify
						Password: </label>
					<div class="col-sm-4">
						<input type="password" name="vpassword" required
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
	
	<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
	<script>
	$(document).ready(function(){		
		$("newusers").preventDoubleSubmission();
		$('#bday').datepicker();
	});
	</script>
