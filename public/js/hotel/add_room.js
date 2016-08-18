$('#save_room').click(function(){

	if($(this).val() == 0){
    	$('#container_room_level2').slideDown('slow');
    	$(this).text('Zapisz');
        clearFormById('room_details');
    	$(this).val(1);
        
    } else {
    	$('.error_form').html('');	

    	$.ajax({type:"POST",
            url: "/manage-room/add-room",
            dataType: "JSON",
            data: getValuesFromForm('room_details'),
            beforeSend: function(){
                //console.log('test bs ' + JSON.stringify(getValuesFromForm('room_details')));
            },
            success: function( response_data){
                if(response_data.result_save == 1){
                            $('#save_room').val(0);
                            $('#save_room').text('Dodaj pokój');
                            $('#container_room_level2').slideUp('slow');
                            $('.error_form').html('');
                            
                            $("#table_list_room .clear_tr").remove();

                             $("#table_list_room").append("<tr id='id_room_"+response_data.id_room+"'>" +
                            "<td>"+response_data.data['name_room']+"</td>" +
                            "<td>"+response_data.data['name_configuration']+".</td>" +
                            "<td>"+response_data.data['number_bad']+".os</td>"+
                            "<td>" +
                                "<button class='edit_table_button' data-idroom="+response_data.id_room+">edytuj</button>"+
                                "<button class='delete_table_button' style='margin-left: 4px;' data-idroom="+response_data.id_room+">usuń</button>"+
                            "</td>" +
                            "</tr>");
                               
                        }else if(parseInt(response_data.result_save) == 3){
                            $('#save_room').val(0);
                            $('#save_room').text('Dodaj nową konfigurację');
                            $('#room_details').trigger('reset');
                            $('#container_room_level2').slideUp('slow');

                            
                            var res_data = response_data.data_update;
                            //console.log("Po edycji: " + res_data.id_room);

                            $("#id_room_"+response_data.id_room+" td:nth-child(1)").text(res_data['name_room']);
                            $("#id_room_"+response_data.id_room+" td:nth-child(2)").text(res_data['name_configuration']);
                            $("#id_room_"+response_data.id_room+" td:nth-child(3)").text(res_data['number_bad']);
                            
                        } else if(parseInt(response_data.result_save) == 0) {
                            //console.log(JSON.stringify(response_data.error_comunicat));
                                for (row in response_data.error_comunicat ){
                                        var tmp = response_data.error_comunicat[row];
                                        for (row_2 in tmp ){
                                                $('.'+row+'_error').append('<span>'+tmp[row_2]+'</span><br>');
                                                //console.log(tmp[row_2]);
                                        }
                                }
                        }
            },
            failed: function(){
                        //console.log("Error");
            },
            ajaxError: function(){
                //console.log("Error");
            }
        });

    }
});


$("#table_list_room").on('click', '.edit_table_button', function(){
    var id_room = parseInt($(this).data('idroom'));
    $('#room_details [name=id_room').val(id_room);
    //console.log('ID room' + id_room);
    $.ajax({
        type:'POST',
        url: "/manage-room/get-room-info",
        dataType: "JSON",
        data: {'id_room':id_room},
        success: function( response_data){
            if(response_data.result_save == 1){
                var res_data =  response_data.singleRoom[0];

                
                $('#container_room_level2').slideDown('slow');
                $('#save_room').val(1);
                $('#save_room').text('Zapisz');

                setValuesInForm(res_data,'room_details');

            }
            
        }
    })
});

$("#table_list_room").on('click', '.delete_table_button', function(){
   var id_room = parseInt($(this).data('idroom'));  
     $.ajax({
        type:'POST',
        url: "/manage-room/delete-room",
        dataType: "JSON",
        data: {'id_room':id_room},
        success: function( response_data){
            if(response_data.result_save){
                $("tr#id_room_"+id_room).remove();
                  //console.log("Usunieto");

            } else {
                //console.log("Nie usunieto");
            }

        },        
        failed: function(){
            //console.log("Error");
        }

    });
});

$('#anuluj_button').click(function(){
   $('#container_room_level2').slideUp('slow');
   $('#save_room').text('Dodaj nową konfigurację').val(0);
});