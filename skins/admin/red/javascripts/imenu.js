function initMenu(){
	var i = 0;
        if(typeof(urlcate)=='undefined')urlcate = document.location.href;
        $('#menu ul').hide();
	($('#menu li a')).each(function(){
		if(this.href == urlcate){
			$(this).addClass("active");
			$(this).parent().addClass("active");
                        var checkParent = $(this).parent().parent().prev();
                        $(this).parent().parent().parent().parent().prev().addClass("active");
                        //$(this).parent().parent().parent()).prev().addClass("active");
                        $(this).parent().parent().parent().parent().parent().parent().prev().addClass("active");
                        checkParent.addClass("active");
                        $('#menu li .active').each(function(){
                            $(this).next().show();
                        });
			return false;
		}

	});
	
	
	$('#menu li a').click(function(){
		var checkElement = $(this).next();
                var checkParent = $(this).parent().parent();
		if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
				document.location.href = this.href;
			return false;
		}
		if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
			//$('#menu ul:visible').slideUp('normal');
                        checkParent.find('ul:visible').slideUp('normal');
			checkElement.slideDown('normal');
                        return false;
                }
		document.location.href = this.href;
	});


}
$(document).ready(function() {initMenu();});