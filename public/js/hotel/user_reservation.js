$('.edit_reservation').click(function(){
	var id_reservation = $(this).data('idreservation');
	var status_reservation = $('input[name=status_reservation]').val();

	$('#reservation-info-'+id_reservation+' td').load(
		'/client-reservation/get-room-reservation',
		{'id_reservation':id_reservation, 'status_reservation':status_reservation},
		function (responseText, textStatus, XMLHttpRequest) {
		    if (textStatus == "success") {
		         $('.reservation-info').hide();
		         $('#reservation-info-'+id_reservation).slideDown();
		    }
		    if (textStatus == "error") {
		         // oh noes!
		    }
		}

	);
});


$('.list_reservation').on('click','.cancel_status_reservation_button', function(){
	var id_reservation = $(this).data('idreservation');

	$('#reservation-info-'+id_reservation).slideUp();
	//$('#reservation-info-'+id_reservation).html('');
});

