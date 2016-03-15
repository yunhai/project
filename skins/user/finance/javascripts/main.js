$(document).ready(function(){
$(window).load(function(){
    $('#min-menu-page li.have-child > a').click(function(){
        $(this).parent().find('.lv2:first').slideToggle(function(){
            if(!$(this).is(":hidden")){ // Open
                $(this).parent('.have-child').addClass('expand');
            }else{
                $(this).parent('.have-child').removeClass('expand');
            }
        });
            return false;
    });

    $('#min-menu-page li.have2 > a').click(function(){
        $(this).parent().find('ul:first').slideToggle(function(){
            if(!$(this).is(":hidden")){ // Open
                $(this).parent('.have2').addClass('expand');
            }else{
                $(this).parent('.have2').removeClass('expand');
            }
        });
            return false;
    });

    });
});