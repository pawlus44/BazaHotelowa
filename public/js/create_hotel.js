$(document).ready(function(){
	$('#button_save').click(function(){
		$('#hotel_data').submit();
	});

	refresh_hotel(); //do poprawy przy dobrym internecie

	tinymce.init({
        selector: "#basic_description_hotel, #extend_description_hotel",
        language: "pl",
        plugins: [
            "code autolink link image preview anchor searchreplace wordcount visualblocks visualchars code fullscreen paste textcolor colorpicker textpattern table"
        ],
        toolbar: "undo redo | bold italic forecolor | code",
        menubar: false,
        fontsize_formats: "8pt 9pt 10pt 11pt 12pt 16pt 18pt 22pt 26pt 28pt 32pt 36pt 38pt 40pt 42pt",
        height: 150,

        setup: function(ed) {
		    ed.on('keyup', function(e) {
		    	//console.log("Obiket o klasie: "+ tinymce.activeEditor.id);
		    	actualy_id = tinymce.activeEditor.id;
		        number_of_letters = ed.getContent({format : 'text'}).length;
		        //console.log("Ilosc znakow " + number_of_letters);
				
				if(actualy_id === 'extend_description_hotel'){
					
					if(number_of_letters != 0){
						$('#desc_hotel').show();
					} else {
						$('#desc_hotel').hide();
					}
					$('.desc_hotel_extend_input').html(ed.getContent({format : 'raw'}));
				} else if( actualy_id === 'basic_description_hotel' ) {

					if(number_of_letters > 1000){
						if($(".basic_description_hotel_label .error-textarea-basic").length == 0){
							$('.basic_description_hotel_label').
							append("<br><span class='error-textarea-basic' style='color: red; font-size:14px; font-weight:bold'>Przekroczono 1000 znaków</span>");						
						}
					} else {
						$('.basic_description_hotel_label .error-textarea-basic').remove();
					}

					$('.desc_hotel_basic_input').html(ed.getContent({format : 'raw'}));
				}

		    })
		}
    });

	

	$('#name_hotel').keyup(function(){$('.hotel_name_input').html($(this).val());});
	$('#city').keyup(function(){$('.city_input').text($(this).val());});
	$('#street').keyup(function(){$('.street_input').text($(this).val());});
	$('#number_bulid').keyup(function(){$('.no_bulid_input').text($(this).val());});
	$('#zip_code').keyup(function(){$('.post_code_input').html($(this).val());});
	$('#post').keyup(function(){$('.post_city').html($(this).val());});


	$('#desc_hotel').click(function(){

			/*if($(this).html() == 'Rozwiń') {
				$(this).text('Zwiń');
			} else {
				$(this).text('Rozwiń');
			}*/
			$('.desc_hotel_extend_input').slideToggle('slow');
	});

  //  console.log( "Typ hotelu: " + $("#type_of_hotel-element option[selected=selected]").val());   

});

$('#basic_description_hotel-element').click(function(){
	$(obj).attr('contenteditable',true);
})

$("select[name=type_of_hotel]").click(function(){
	//console.log("Hellow okrytny swiecie: " + $(this).val());
	setImageTypeOfHotel($(this).val(), '.hotel_cont_info_2');
});

$(".refresh_button").click(function(){
	//console.log('Klikam, klikam i dalej ...');
 	refresh_hotel();
});


function setImageTypeOfHotel( typOfHotel, nameObject){
    imageName = {1:'/images/type_hotel/one-stars.png',
                 2:'/images/type_hotel/two-stars.png',
                 3:'/images/type_hotel/three-stars.png',
                 4:'/images/type_hotel/four-stars.png',
                 5:'/images/type_hotel/five-stars.png',
                 6:'/images/type_hotel/camping.png',
                 7:'/images/type_hotel/camping-2.png'};
             
    $(nameObject).html("<img src='"+imageName[parseInt(typOfHotel)]+"'>");    
};

function refresh_hotel(){
	$('.hotel_name_input').html();
	$('.city_input').text('');
	$('.street_input').text('');
	$('.no_bulid_input').text('');
	$('.post_code_input').html('');
	$('.post_city').html('');
	$('.desc_hotel_basic_input').html('');
	$('.desc_hotel_extend_input').html('');


	$('.hotel_name_input').html($('#name_hotel').val());
	$('.city_input').text($('#city').val());
	$('.street_input').text($('#street').val());
	$('.no_bulid_input').text($('#number_bulid').val());
	$('.post_code_input').html($('#zip_code').val());
	$('.post_city').html($('#post').val());
	
	setImageTypeOfHotel( $('select[name=type_of_hotel]').val(), '.hotel_cont_info_2');
	//console.log('Basic ' + $('#basic_description_hotel').text());
	
	$('.desc_hotel_basic_input').html( $('#basic_description_hotel').text() );	
	if($('#extend_description_hotel').text().length !== 0){
		$('#desc_hotel').show();
		$('.desc_hotel_extend_input').html( $('#extend_description_hotel').text() );	
	};
}




/* add room configuration*/  

