Dropzone.autoDiscover = false;
Dropzone.options.hotelLogoForm = {
	autoProcessQueue: true,
    dictDefaultMessage: "Przeciągnij plik tutaj lub kliknij w pole i wybierz plik...<br>"+
    "<span style='color:red'>Aktualne zdjęcie zostanie usunięte!</span>"
    ,
	paramName: "hotel_logo",
    maxFilesize: 1, // MB
    acceptedFiles: 'image/*',
    dictInvalidFileType: 'Wybrany plik nie jest plikiem graficznym.',
    dictMaxFilesExceeded: 'Nie można zapisać więcej niż jeden plik',
    dictRemoveFile:'Usuń element z listy',
    addRemoveLinks: true,
    thumbnailWidth: null,
    thumbnailHeight: null,
    maxFiles: 1,
  	init: function() {
          this.on("success", function(file, response) {
                var response_data = JSON.parse(response);
                /*console.log(response['result_save'] 
                    + 'filename: ' 
                    + response_2['name_uploud_file']);*/

                $('.actually_logo_hootel img').attr('src','/hotel_media/hotel_'+
                                                            response_data ['id'] +
                                                            '/' + 
                                                            response_data ['name_uploud_file']);

        });
    },
  	appendccept: function(file, done) {
      alert("Chyba sie udalo");
  	},
  
}

var myDropzone = new Dropzone("#hotel-logo-form");


$("#save_change_start_page").click(function(){

	myDropzone.processQueue();

});