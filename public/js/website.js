$(document).ready(function(){
    /* ustalenie wysyokosci bocznych div z background gradient*/

    var cl_green = '#09b32e';
    var cl_orange = '#eacf16';
    var cl_red = '#ca401a';
    var cl_blue = '#0f71f4';
    var cl_normal = '#0398ca'; 

    $('#my_left_border, #my_right_border').height($('#page_container').height());

    $('#header_menu_house').hover(function(){
        $(this).html('');
        $(this).html("<img src='/images/main_page/house-blue.png'/>");

    }, function(){
        $(this).html('');
        $(this).html("<img src='/images/main_page/house.png'/>");
    });

    $('#main_panel_menu li').css('padding-top','8px');


    $('#main_panel_menu li').hover(function(){
        if($(this).hasClass('br_red')){
            $(this).addClass("li_hover ").css('padding-top','4px').css('border-color',cl_red);
        } else if($(this).hasClass('br_orange')){
            $(this).addClass("li_hover ").css('padding-top','4px').css('border-color',cl_orange);
        } else if($(this).hasClass('br_normal')){
            $(this).addClass("li_hover ").css('padding-top','4px').css('border-color',cl_normal);
        }
        
        
    },function(){
        if($(this).hasClass('li_active')){
            $(this).removeClass("li_hover").css('padding-top', '4px');
        } else {
            $(this).removeClass("li_hover").css('padding-top', '8px');
        }

    });

    $('#main_panel_menu li').click(function(){
        $('#main_panel_menu li').removeClass("li_active").css('padding-top','8px');
        $(this).addClass("li_active").css('padding-top','4px');
    });

    var poczatkowe = 100;
    $('.menu_sidebar li').click(function(){
        //$('.menu_sidebar li').removeClass("li_active_2");
       // $(this).addClass("li_active_2");
       poczatkowe = poczatkowe + 13;
        //console.log(poczatkowe+"Cos nie działa");
    });


   /*$('.vertical_align').each(function(){
       var height_parent = 0.5 *  $(this).parent().height();
       var height_this=  $(this).height();
       var height_prev = 0.5 * $(this).parent().prev().height();

       var new_padding_top = height_prev - height_this;

       console.log('Nowa wysokosc: '+new_padding_top+" Wysokosc rodzica: "+height_parent + " Wys własna: " +height_this );
       console.log('Wys. brata: '+height_prev);

       $(this).parent().css('padding-top',new_padding_top);


   })*/

    $('.center_container').each(center);



   function center(){
       console.log('cuda na kiju');
       var max_height=0;

        $(this).children().each(function(){
            if($(this).height() > max_height){
                max_height = $(this).height();
            }
        });

        $(this).children().each(function(){
            var this_hight = $(this).height();

            var new_pad_top = (0.5 * max_height ) - (0.5 * this_hight);
            $(this).height(max_height).css('padding-top',new_pad_top);
        });

   }
 



});



