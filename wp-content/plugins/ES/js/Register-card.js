	jQuery(document).ready(function($){

	 

	$('#cardForm').submit(function (e) {
	e.preventDefault();


	 
	var value = $('#cardInput').val();

	cardInput = value.replace(/\s/g, '');


    if (!cardInput) {			 
	$('#cardvalidationMessage').text('Please enter a card hash');
	return;
	}else{
	$('#cardvalidationMessage').text('');
	}   


	$.ajax({
	type: 'POST',
	url: myAjax.ajaxurl,
	data: {
	action: 'Register_card_ajax_action', 
	cardInput:cardInput,
	 

	},
	success: function (response) {
	 var jsonObject = JSON.parse(response);

 
     //alert(JSON.stringify(jsonObject.data.name_on_card));
	 if(jsonObject.status=='success'){
		 	$('#cardinfo').html(`
    <div class="yesrecords records container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="content">
				    <p>Card is registered in the name of user<strong> ${jsonObject.data.name_on_card}.</strong></p>
                     
                </div>
            </div>
        </div>
    </div>
`);
	 }else{
		 	$('#cardinfo').html(`
    <div class="norecords records container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="content">
				    <p><strong>No card is registered</strong></p>
                    
                </div>
            </div>
        </div>
    </div>
`);
	 }
  
	 
	},
	error: function () {
	alert('An error occurred while processing the form');
	}
	});
	});


	});