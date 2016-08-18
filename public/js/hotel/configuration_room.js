$('#save_room_conf').bind("click", function(){  

    if($(this).val() == 0){
    	$('#container_conf_room_level2').slideDown('slow');
    	$(this).text('Zapisz');
        clearFormById('configuration_room');
    	$(this).val(1);
        
    } else {
      
    	$('.error_form').html('');	
        $('.error_info_manage_conf').text('');	
		//console.log("DATA: " + JSON.stringify(getValuesFromForm('configuration_room')));
        $.ajax({type:"POST",
            url: "/manage-configuration-room/add-room-configuration",
            dataType: "JSON",
            data: getValuesFromForm('configuration_room'),
            success: function( response_data){
                //console.log('SUKCES');
                        if(response_data.result_save == 1){
                                console.log("Zapisano");
                                $('#save_room_conf').val(0);
                                $('#save_room_conf').text('Dodaj nową konfigurację');
                                $('#container_conf_room_level2').slideUp('slow');
                                $('.error_form').html('');
                                
                                $("#table_list_conf_room .clear_tr").remove();

                                $("#table_list_conf_room").append("<tr id='id_conf_"+response_data.id_conf+"'>" +
                                "<td>"+response_data.data['name_configuration']+"</td>"+
                                "<td>" +
                                    "<button class='edit_table_button' data-idconf="+response_data.id_conf+">edytuj</button>"+
                                    "<button class='delete_table_button' style='margin-left:3px;' data-idconf="+response_data.id_conf+">usuń</button>"+
                                "</td>" +
                                "</tr>");
                                clearFormById('configuration_room');
                                //console.log("Z powrotem:" + JSON.stringify(response_data.data))
                        }else if(parseInt(response_data.result_save) == 2){
                            $('#save_room_conf').val(0);
                            $('#save_room_conf').text('Dodaj nową konfigurację');

                            $('#container_conf_room_level2').slideUp('slow');
                            

                            $('#id_conf_'+response_data.id_conf+' td:nth-child(1)').text(response_data.data['name_configuration']);
                            
                            clearFormById('configuration_room');
                            console.log("Z powrotem:" + JSON.stringify(response_data.data));
                        } else {
                                console.log("Nie zapisano");
                                for (row in response_data.error_comunicat ){
                                        var tmp = response_data.error_comunicat[row];
                                        for (row_2 in tmp ){
                                                $('.'+row+'_error').append('<span>'+tmp[row_2]+'</span><br>');
                                                console.log(row);
                                        }
                                }
                        }
            },
            failed: function(){
                        console.log("Error");
            }
        });
    } 
    /*clearFormById('configuration_room');*/
});

$('#table_list_conf_room').on('click','.edit_table_button', function(){
    var id_conf = parseInt($(this).data('idconf'));
    $('.error_info_manage_conf').text('');

    $.ajax({
        type:'POST',
        url: "/manage-configuration-room/get-room-configuration",
        dataType: "JSON",
        data: {'id_conf':id_conf},
        success: function( response_data){

            var res_data =  response_data.data[0];
            // uzupelnienie formularza
            $('[name=name_configuration]').val(res_data['name_configuration']);
            $('#bathroom_in_room-'+res_data['bathroom_in_room']).prop('checked', true);
            $('[name=id_conf]').val(res_data['id']); //hidden

            $.each(response_data.data_equi, function(key,value){
                $('#equipment_room-'+value['id_equipment']).prop('checked',true);
            });

            $('#save_room_conf').val(1);
            $('#save_room_conf').text('Zapisz zmiany');
            $('#container_conf_room_level2').slideDown('slow');
            
        },
        failed: function(){
            //console.log("Error");
        }

    });

});

$('#anuluj_button').click(function(){
   $('#container_conf_room_level2').slideUp('slow');
   clearFormById('configuration_room');
   $('#save_room_conf').text('Dodaj nową konfigurację').val(0);

});

$('#table_list_conf_room').on('click','.delete_table_button', function(){
    var id_conf = parseInt($(this).data('idconf'));
    $('.error_info_manage_conf').text('');
     $.ajax({
        type:'POST',
        url: "/manage-configuration-room/delete-room-configuration",
        dataType: "JSON",
        data: {'id_conf':id_conf},
        success: function( response_data){
            if(response_data.result_save == 1){
                $("tr#id_conf_"+id_conf).remove();
            } else if(response_data.result_save == 3) {
                $('.error_info_manage_conf').text(response_data.error_comunicat);
            }
        },        
        failed: function(){
            console.log('failed');
        }

     });

});

