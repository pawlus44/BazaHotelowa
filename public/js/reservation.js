$(function() {
    $.datepicker.regional['pl'] = {
                closeText: 'Zamknij',
                prevText: '&#x3c;Poprzedni',
                nextText: 'Następny&#x3e;',
                currentText: 'Dziś',
                monthNames: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec',
                'Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'],
                monthNamesShort: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec',
                'Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'],
                dayNames: ['Niedziela','Poniedzialek','Wtorek','Środa','Czwartek','Piątek','Sobota'],
                dayNamesShort: ['Nie','Pn','Wt','Śr','Czw','Pt','So'],
                dayNamesMin: ['N','Pn','Wt','Śr','Cz','Pt','So'],
                weekHeader: 'Tydz',
                dateFormat: 'yy-mm-dd',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['pl']);


    $( "#from" ).datepicker({
      defaultDate: "+1w",
      minDate: +1,
      changeMonth: true,
      numberOfMonths: 2,
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to" ).datepicker({
      defaultDate: "+1w",
      minDate: +2,
      changeMonth: true,
      numberOfMonths: 2,
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });

    $('.get_info_reservation').click(function(){
        var date_start = $('#from').val();
        var date_stop = $('#to').val();
        var id_hotel = $(this).data('idhotel');

        if( date_start == '' || date_stop == '' ){
            $('.errors_data').html("Nie określono okresu rezerwacji!<br>").slideDown();
        } else if(date_start == date_stop){
            $('.errors_data').html("Początkowy dzień rezerwacji nie może być taki sam jak dzień końcowy<br>").slideDown();
        } else {
            $('.errors_data').slideUp();

            $('.info_reservation').load('/index/reservation-room-info', 
                                        {'date_start':date_start,
                                        'date_stop':date_stop,
                                        'id_hotel':id_hotel});
        }
    });

    $('.hotel_panel').on('click','#save_reservation',function(){
        var date_start = $('#from').val();
        var date_stop = $('#to').val();
        var id_hotel = $('.get_info_reservation').data('idhotel');

        //var data = getValuesFromForm('table-list-reservation');
        var data = {};
        var info_reservation = {};

        data['date_start'] = date_start;
        data['date_stop'] = date_stop;
        data['id_hotel'] = id_hotel;
        var length_info = 0;

        $.each($('#table-list-reservation input[type=checkbox]:checked'),function(){
            info_reservation[$(this).val()]={
                'number_bad' : $(this).data('number_bad'),
                'id_configuration' : $(this).data('idconf')
            };
            length_info++;
        });

        data['room_reserve'] = info_reservation;
        //console.log(JSON.stringify(info_reservation));


        if(length_info == 0){
            $('.errors_data_save').html("Nie wybrano żadnego pokoju").slideDown();
        } else if(length_info > 3){
            $('.errors_data_save').html("Jednorazowo można zarezerwować trzy pokoje.").slideDown();
        } else {
            $('.errors_data_save').slideUp();
            $('.save_reservation_result').load('/index/save-reservation-room', 
                                            data
                                            );
        }
    });


});