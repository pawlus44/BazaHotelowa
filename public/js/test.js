  $(document).ready(
        function(){

            //By clicking on button submit condition makes validate on empty message
           //unless field message will be not empty  , the programm make send data to
           //controller via ajax
            $("#submitTo").click(function() {
                console.log("Etap 1");
                  var message = $('#message').val();
                  console.log("Etap 2");

                  if (message != '') {
                      console.log("Etap 3");
                      //run ajax
                     /* $.post('/test/ajax',
                                {'message' : message},

                                //callback function
                                function (respond) {

                                     //put respond in class show-msg

                                     $(".show-msg").html(respond);

                         }
                      );*/


                      	$.ajax({
				url: "/test/ajax",
				type: "POST",
				data: {'message' : message}}).
                                    done(function( msg ) {
                                     $(".show-msg").html(msg);
                                });


                  }
                  console.log("Etap po if 1");

            });
            console.log("Etap po if 2");

      });