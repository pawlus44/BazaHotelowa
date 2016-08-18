$(document).ready(function(){
   
  $('#edit_user_info_button').click( function(){
      if($(this).val()=="edit"){
          my_load_1('/panel-client/form-user-info', $(this), 'form_user_info');
      } else {
          my_load_2('/panel-client/form-user-info-process', $(this), 'form_user_info');
      }           
  });

  $('#edit_user_address_button').click( function(){
      if($(this).val()=="edit"){
          my_load_1('/panel-client/form-user-address', $(this), 'form_user_address');
      } else {
          my_load_2('/panel-client/form-user-address-process', $(this), 'form_user_address');
      }
  });

  $('#edit_user_contact_button').click( function(){
      if($(this).val()=="edit"){
          my_load_1('/panel-client/form-user-contact', $(this), 'form_user_contact');
      } else {
          my_load_2('/panel-client/form-user-contact-process', $(this), 'form_user_contact');
      }
  });

  $('.row_radio dd br').remove();

  console.log('PATH ' + window.location.pathname);

  var path =  window.location.pathname;

  switch(path) {
    case '/panel-client/profil':
        $('#panel-client-profil li').css('background','#b0b0b0');
        break;
    case '/panel-client/address':
        $('#panel-client-address li').css('background','#b0b0b0');
        break;

    case '/manage-hotel/start':
        $('#manage-hotel-start li').css('background','#b0b0b0');
        break;
    case '/manage-hotel/hotel':
        $('#manage-hotel-hotel li').css('background','#b0b0b0');
        break;   
    case '/manage-media/start':
        $('#manage-media-start li').css('background','#b0b0b0');
        break;
    case '/manage-configuration-room/manage-room':
        $('#manage-configuration-room-manage-room li').css('background','#b0b0b0');
        break;  
    case '/manage-room/room':
        $('#manage-room-room li').css('background','#b0b0b0');
        break;

    case '/manage-reservation/current-reservations':
        $('#manage-reservation-current-reservations li').css('background','#b0b0b0');
        break;
    case '/manage-reservation/waiting-reservations':
        $('#manage-reservation-waiting-reservations li').css('background','#b0b0b0');
        break;   
    case '/manage-reservation/confirmed-reservations':
        $('#manage-reservation-confirmed-reservations li').css('background','#b0b0b0');
        break;
    case '/manage-reservation/archive-reservations':
        $('#manage-reservation-archive-reservations li').css('background','#b0b0b0');
        break;  
    case '/client-reservation/reservations':
        $('#client-reservation-reservations li').css('background','#b0b0b0');
        break;             
  }



});


  var my_load_1 = function(url, my_object, name_form){
          $(my_object).parent().prev().html('');
          $('.'+name_form).show();
         
          $(my_object).parent().prev().load(url, function(){

              $(my_object).html('Zapisz dane');
              $(my_object).attr('value', 'save');
              


             $(this).parent().parent().children().css('height', 'auto').css('padding-top','0');

             var max_height=0;
              $(this).parent().parent().children().each(function(){
                  if($(this).height() > max_height){
                      max_height = $(this).height();
                  }

              });

              $(this).parent().parent().children().each(function(){
                  var this_hight = $(this).height();

                  if(this_hight < max_height){
                    var new_pad_top = (0.5 * max_height ) - (0.5 * this_hight);
                    $(this).height(max_height).css('padding-top',new_pad_top);
                  } 
              });
          });


        
      
};

    var my_load_2 = function(url, my_object, name_form){
          //console.log("test");
   
            var date_for_form = getValuesFromForm(name_form);
            //console.log(JSON.stringify(date_for_form));

         $.ajax({
                 url: url,
                 dataType: "JSON",
                 data:date_for_form,
                 type: "POST",
                 beforeSend: function(){
                  console.log("beforeSend")
                 },
                 success: function(obj){
                  console.log("success")

                     if(obj.isValid == 1){
                            $('.'+name_form).hide();
                            $(my_object).html('Edytuj');
                            $(my_object).attr('value', 'edit');
                            

                            for (row in date_for_form){
                              $('.'+name_form+'_'+row).html(date_for_form[row]);
                            }

                            $('.'+name_form+'_message').removeClass('message_not_ok').addClass('message_ok').html("Dane zostały zmienione");

                     } else {
                        $(my_object).parent().prev().html(obj.form);
                        $('.'+name_form+'_message').addClass('message_not_ok').html("Dane nie zostały zmienione");
                     }

                      $(my_object).parents('.root_edit_container').children().each( function(){
                        $(this).css('height', 'auto');
                        $(this).css('padding-top', '0');
                      });

                      //console.log(obj.isValid);


                     setCenter(my_object);
                     
                 },
                 error : function(){
                  //console.log("Blad");
                 },
                 complete: setCenter(my_object)
                     
            });
};

var setCenter = function(my_object_1){
                      max_height =0;
                      $(my_object_1).parents('.root_edit_container').children().each( function(){

                         if($(this).height()>max_height){
                          max_height = $(this).height();
                         }
                      });

                      
                      $(my_object_1).parents('.root_edit_container').children().each( function(){
                        $(this).css('height', 'auto');
                        $(this).css('padding-top', '0');
                      });

                      $(my_object_1).parents('.root_edit_container').children().each( function(){
                        //console.log($(this).attr('class') +" " + $(this).height() );


                        if($(this).height() < max_height){
                          new_pad_top = (0.5 * max_height ) - (0.5 * $(this).height());
                          $(this).height(max_height).css('padding-top',new_pad_top);
                        } else {
                          $(this).height(max_height);
                        }

                      });

                      
                  };