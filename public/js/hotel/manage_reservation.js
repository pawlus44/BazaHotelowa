$('.edit_reservation').click(function(){
	var id_reservation = $(this).data('idreservation');
	var status_reservation = $('input[name=status_reservation]').val();

	$('#reservation-info-'+id_reservation+' td').load(
		'/manage-reservation/get-room-reservation',
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

$('.list_reservation').on('click','.set_status_reservation_button', function(){
	var id_reservation = $(this).data('idreservation');
	var status_reservation = $('#reservation-info-'+id_reservation+' [name=status_reservation]').val();

	//console.log('status ' + status_reservation);

	if($('input[name=status_reservation]').val() != status_reservation){

		$('#reservation-info-'+id_reservation+' td').load(
			'/manage-reservation/set-status-reservation',
			{'id_reservation':id_reservation, 'status_reservation':status_reservation},
			function (responseText, textStatus, XMLHttpRequest) {
			    if (textStatus == "success") {
			         $('#tr_reservation_'+id_reservation).remove();
			         $('#reservation-info-'+id_reservation).remove();
					
					$('.communique')
						.css({'color':'green','font-weight':'bold'})
						.html("Zmiana statusu rezerwacji przebiegła pomyślnie");

			    }
			    if (textStatus == "error") {
					$('.communique')
						.css({'color':'red','font-weight':'bold'})
						.html("Błąd.<br>Status nie został zmieniony");
			    }
			}	
		);

	} else {
		$('.communique')
			.css({'color':'red','font-weight':'bold'})
			.html("Błąd.<br>Status rezerwacji nie został zmieniony");
	}
	

});

$('.list_reservation').on('click','.cancel_status_reservation_button', function(){
	var id_reservation = $(this).data('idreservation');

	$('#reservation-info-'+id_reservation).slideUp();
	//$('#reservation-info-'+id_reservation).html('');
});

