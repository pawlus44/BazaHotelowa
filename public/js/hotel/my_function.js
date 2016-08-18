function setValuesInForm(data_form, form){
	var id_form = "#"+form;

	$.each(data_form,function(key,value){

		//console.log('key' + key);

		if($("[name='"+key+"']").length != 0){
			var actualy_object = $("[name='"+key+"']");
			var input = $(actualy_object).prop('type');
			console.log('input ' + input);
			switch(input){
				case "text":
					$(actualy_object).val(value);
				break;
				case "textarea":
					$(actualy_object).val(value);
				break;
				case "select-one":
					var list_option = $('option',actualy_object);
					$.each(list_option, function(){
						if($(this).val() == $(actualy_object).val(value)){
							$(this).prop('selected');
						}
					});
				break
			}

		} else if($("[name='"+value+"[]']").length != 0) {

		}
	});


}

function getValuesFromForm(form){
	var id_form = "#"+form;

	var list_input_html =  {
        'hidden': {'name':"input", 'type':'hidden', 'value':'none'},
		'text': 	{'name':'input',	'type':'text',		'value' : 'none'	},
		'password': 	{'name':'input',	'type':'password',		'value' : 'none'	},
		'textarea': {'name':'textarea',	'type':'none', 		'value':'none'		},
		'radio': 	{'name':'input',	'type':'radio', 	'value':'single' , 'type_value':'checked'	},
		'checkbox': {'name': 'input',	'type':'checkbox', 	'value':'multi'	 , 'type_value':'checked'	},
		'select' : 	{'name':'select',	'type':'none', 		'value':'select' , 'type_value':'selected'}
	};

	var data = {};
	var name_input = '';
	var form_element_list = {};
	var form_element_list_len = 0;


	$.each(list_input_html,function(name,propertis){
		name_input = '';
		form_element_list = {};
		form_element_list_len = 0;

		if(propertis['type'] != 'none'){
			name_input = id_form + ' ' + propertis['name'] + '[type=' + propertis['type'] + ']';
		} else {
			name_input = id_form + ' ' + propertis['name'];
		}

		form_element_list = $(name_input);
		form_element_list_len = form_element_list.length;

		for(i=0; i<form_element_list_len; i++){
			
			if(propertis['value'] == 'none'){
				data[$(form_element_list[i]).attr('name')] = $(form_element_list[i]).val();		
			} else if(propertis['value'] == 'single') {
				data[$(form_element_list[i]).attr('name')] = 
				$('[name='+ $(form_element_list[i]).attr('name') +']:'+ propertis['type_value']).val();
			} else if (propertis['value'] == 'select') {
				data[$(form_element_list[i]).attr('name')]=
				$('[name='+ $(form_element_list[i]).attr('name') + "] option:selected").val();

			} else if(propertis['value'] == 'multi') {
				if($(form_element_list[i]).is(':'+propertis['type_value'])){
					name_tmp = $(form_element_list[i]).attr('name').replace('[]','');

					if( data[name_tmp] == undefined){
						data[name_tmp] = [];
						table_tmp=[];
					} else {
						table_tmp = data[name_tmp];
					}

					
					table_tmp.push( $(form_element_list[i]).val());
					data[name_tmp]=table_tmp;
				}
			}

		}			
	});
 return data;
};

function clearFormById(form){
    $('#'+form).trigger('reset');
    $('#'+form+" [type=hidden]").val('');
    $('#'+form+" [type=radio").prop('checked',false);
    $('#'+form+" [type=checkbox").prop('checked',false);
}