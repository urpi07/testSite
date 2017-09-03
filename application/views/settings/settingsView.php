<div class="" id="mycontent">

	<!-- Generic message modal -->
	<div id="messageModal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="messageTitle">Modal Header</h4>
				</div>
				<div class="modal-body" id="messageBody">
					<p>Some text in the modal.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>

	<div id="newSettings" class="modal fade" role="dialog">
		<div class="modal-dialog">
	
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">New Settings</h4>
				</div>
				<div class="modal-body">
					<form id="newSettingForm" class="form-horizontal">
						<div class="form-group">
							<div class="col-sm-6">
								<input type="text" name="name" required
									placeholder="Settings Name" class="form-control" id="name" />
							</div>
							<div class="col-sm-6">
								<input type="text" name="value" required
									placeholder="Settings Value" class="form-control" id="value" />
							</div>						
						</div>
						
						<div class="form-group">
							<div class="col-sm-12">
									<textarea cols="3" rows="3" name="description"
										placeholder="Description" class="form-control" id="description"></textarea>						
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="btnOk">OK</button>
					<button type="button" class="btn btn-default" data-dismiss="modal" id="btnCancel">Cancel</button>
				</div>
			</div>
	
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading"><h4>Settings</h4></div>
		<div class="panel-body">
			
			<div class="row row-bordered">
				<button type="button" class="btn btn-default btn-new-setting" data-toggle="modal" 
				data-target="#newSettings" id="btnNewSettings">New Setting</button>
			</div>
			
			<form id="settingsForm">
				<?php
				if (isset ( $data ) && isset( $data["data"]) ) {
					$settings = $data["data"];
					foreach ( $settings as $setting) {
				?>
					<div class="row row-bordered">
						<div class="col-md-6" class="settingName">
							<?php echo ucfirst($setting['name']); ?> 
						</div>
						<div class="col-md-6">
							<input type ='text' value="<?php echo $setting['value']; ?>"
							name="<?php echo $setting["id"]; ?>" class="form-control settingValue" />
						</div>												
					
						<div class="col-md-6">
							<span class='settingDescription' name="<?php echo $setting["id"]?>">
							<?php echo $setting['description']; ?></span>
						</div>
					</div>
				<?php 
					}
				}
				?>
		
				<button type="button" class="btn btn-default" id="btnUpdate">Save</button>
				<button type="button" class="btn btn-default" id="btnCancel">Cancel</button>
			</form>
		</div> <!-- End of panel body -->
	</div> <!-- end of panel -->

</div>

<script>
	var debugMode = true;
	var name, value, description;
	var formMode, itemToEdit, newSettingsForm, settingsForm;
	var payLoad = {"url": "settings",
					"method": "",
					"data": ""};
	
	function setFormMode(mode){
		payLoad.method = mode;
		formMode = mode;
	}
	
	function getFormArgs(){
		name = $("#name").val();
		value = $("#value").val();
		description = $("#description").val();
		
		return {"name": name, "value": value, "description": description};
	}

	function populateForm(data){

		if(data){
			var nameVal = (data.name)? data.name.toString() : "";
			var valueVal = (data.value)? data.value.toString(): "";
			var descriptionVal = (data.description) ? data.description.toString() : "";

			$("#name").val(nameVal);
			$("#value").val(valueVal);
			$("#description").val(descriptionVal);			
		}
	}

	function resetForm(){
		var data = {"name": "", "value": "", "description": ""};
		populateForm(data);
	}

	function validateForm(){		
		return (!!name && !!value);
	}

	function submitForm(){

		payLoad.data = getFormArgs(); 
		if(validateForm()){
						
			console.log("submitting the form on " + formMode);
			console.log("payload " + JSON.stringify(payLoad));
			if(formMode == "post"){			
				sendAjax(payLoad, postDone, genericFailed, debugMode);
			}		
		}	
	}

	function postDone(data){
		completeSubmit(newSettingsForm);
		console.log("post done data: " + JSON.stringify(data));
		
		var returnData = JSON.parse(data);

		if(returnData && returnData.result == 1){		
			payLoad.data = null;

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
						message = message + data.message[i] + " "  + "<br>";
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
				$("#messageBody").html(message);
			}
		}

		$("#messageModal").modal();
	}

	function genericFailed(data){		
		console.log(payLoad.method + " failed data: " + JSON.stringify(data));

		var returnData = JSON.parse(data);	
		completeSubmit(newSettingsForm);
		payLoad.data = null;
		showError(data);		
	}

	function updateForm(){
		
	}

	function validateSettingsForm(){
		
	}

	function getSettingsFormArgs(){
	}

	//this is for the settings save button.	
	$(document).ready(function(){

		newSettingsForm = $("#newSettingForm");
		settingsForm = $('#settingsForm');

		$("#btnUpdate").click(function(event){
			setFormMode("put");
		    event.preventDefault();
		    
		    if (settingsForm.data('submitted') === true) {
		      // Previously submitted - don't submit again	
			  console.log("form was already submitted.");	      
		    } 
		    else {		    
			    updateForm();
		    }	
		});
					
		$("#btnOk").click(function(event){
			
		    console.log("Submitting the form");		    
		    event.preventDefault();
		    
		    if (newSettingsForm.data('submitted') === true) {
		      // Previously submitted - don't submit again	
			  console.log("form was already submitted.");	      
		    } 
		    else {		    
			    submitForm();
		    }			
		});

		$("#btnNewSettings").click(function(event){
			setFormMode("post");
		});
	});
</script>