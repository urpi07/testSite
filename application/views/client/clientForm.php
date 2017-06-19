<div class="container form-container">	
	<form method="POST" class="form-horizontal" action="client" id="clientForm">
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- TODO: Upload of the profile image -->
				<?php //print_r(apache_request_headers()); ?>
				<h3>Client</h3>
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
					<div class="col-sm-12">
						<textarea rows="8" cols="5" placeholder="Comments"
							class="form-control" name="comment"></textarea>
					</div>
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
		$("clientForm").preventDoubleSubmission();
		$('#bday').datepicker();
	});
	</script>

