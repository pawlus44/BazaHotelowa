$(document).ready(function(){
	var availableCity = {};
    
    $.ajax({type:"POST",
    url: "/index/get-list-city",
    dataType: "JSON",
    data: {},
    success: function( response_data){
        	//console.log(JSON.stringify(response_data));
        	availableCity = response_data;
        	$("#city").autocomplete({
      			source: availableCity
    		});
        },
        failed: function(){
                    console.log("Error");
        }
    });
});

$('#search_hotel_button').click(function(){
	$('#search_hotel_results').load(
		'/index/action-search-hotel',
		getValuesFromForm('search_panel'),
		function (responseText, textStatus, XMLHttpRequest) {
		    if (textStatus == "success") {
		    }
		    if (textStatus == "error") {
		         // oh noes!
		    }
		}

	);
});