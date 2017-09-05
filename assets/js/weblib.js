/**
 * Prerequiste is jquery
 */

// jQuery plugin to prevent double submission of forms
jQuery.fn.preventDoubleSubmission = function() {
  $(this).on('submit',function(e){
    var $form = $(this);

    if ($form.data('submitted') === true) {
      // Previously submitted - don't submit again
      e.preventDefault();
    } else {
      // Mark it so that the next submit can be ignored
      $form.data('submitted', true);
    }
  });

  // Keep chainability
  return this;
};

function sendAjax(payload, successCB, failCB, debugMode){

	if(debugMode){
		console.log("Send AJAX payload " + JSON.stringify(payload));
	}
	
	$("body").css("cursor", "progress");
	$.ajax(payload)
	.done( successCB )
	.fail( failCB );
}

function completeSubmit(myform){
	console.log("Set cursor to default");	
	$("body").css("cursor", "default");
	myform.data('submitted', false);		
}

function getFormData(form){
	
	var formData = {};
	
	if(form){
		
		form.find(':input').each(function(){
			
			if(this.attr('type') == 'radio'){			
				formData[$(this).attr('name')] = $(this).find(':checked').val();
			}
			else{
				formData[$(this).attr('name')] = $(this).val();	
			}
			
		});
		
		form.find('textarea').each(function(){
			formData[$(this).attr('name')] = $(this).val();
		});
		
		form.find('select').each(function(){
			formData[$(this).attr('name')] = $(this).find(':selected').text();
		});
		
		
	}
	
	return formData;
}