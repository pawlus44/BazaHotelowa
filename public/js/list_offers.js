$(document).ready(function(){
	$('.slide_desc_hotel').click(function(){
		$(this).parent().children('.desc_hotel_extend').slideToggle(700);

		if($(this).val() == 0){
			$(this).text('ukryj');
			$(this).val(1);
		} else {
			$(this).text('rozwiń');
			$(this).val(0);
		}
	});

	$('.button_hotel_ofert_show').click(function(){
		$('#list_all_ofert_'+$(this).data('idhotel')).slideToggle(700);
	});

});