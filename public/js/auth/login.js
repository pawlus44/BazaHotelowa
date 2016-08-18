$(document).ready(function(){
	$('#buttom_login').click(function(){
		var data_form = getValuesFromForm('form_login');
		var redirect_name = $('[name=redirect_name]').val();

			$.ajax({type:"POST",
	            url: "/auth-user/login-form-process-ajax",
	            dataType: "JSON",
	            data: getValuesFromForm('form_login'),
	            beforeSend: function(){
	            },
	            success: function( response_data){
	            	if(response_data.result == 1){
	            		if(redirect_name == 'reservation'){
	            			$('.container-login-form').slideUp();
	            			$('.login_info_required').css('color','green').text('Zalogowano!');
	            		} else {
	            			window.location.replace('http://'+window.location.host+response_data.redirect_to);
	            		}

	            	} else if(response_data.result == 2){
	            		$('.komunikat').html("<span style='color:red;''>"
	            							+ response_data.communique
	            							+ "</span>"
	            							);
	            	}
	            }
        	})

		
	});
});