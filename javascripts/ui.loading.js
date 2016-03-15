/*
 Version 1.1

 author: tongnguyen
 Start Date: 2/08/2010
 Finish Date: 2/08/210

 Usage:
		jAlert( message, [title, callback] )
		jConfirm( message, [title, callback] )
		jPrompt( message, [value, title, callback] )

 History:

		1.00 - Released (29 December 2008)

 License:

*/
(function($) {

	$.loadings = {

		
		loading: function(message,image) {
			if( message == null ) message = 'Hệ thống đang xử lý vui lòng chờ...';
			$.loadings._show( message,image);
		},


		// Private methods

		_show: function(msg,image) {

			$.alerts._hide();
			$.alerts._overlay('show');
			$("BODY").append(
			    	    "'<div  id='imgLOAD' style='text-align:center;display:block;position:fixed;top:200px;right:500px;border:1px solid gray;padding:10px; background: #e3e2df; width:200px;z-index:1002;' align='center'"+
	  "'</div><div id='WholePage'></div>'");

			$("#imgLOAD").append("<b>"+msg+"</b><br /><br /><img src='"+image+"' alt='' >");
			// IE6 Fix
			var pos = ($.browser.msie && parseInt($.browser.version) <= 6 ) ? 'absolute' : 'fixed';

			$("#popup_over").css({
				position: pos
			});
                        $("#imgLOAD").css({
				position: pos
			});
			

			$.alerts._reposition();
			$.alerts._maintainPosition(true);
			
		},

		_hide: function() {
			$("#imgLOAD").remove();
			$.alerts._overlay('hide');
			$.alerts._maintainPosition(false);
		},

		_overlay: function(status) {
			switch( status ) {
				case 'show':
					$.alerts._overlay('hide');
					$("BODY").append('<div id="popup_over" class="ui-widget-overlay"></div>');
					$("#popup_over").css({
                                                position: 'absolute',
						zIndex: 1001,
						top: '0px',
						left: '0px',
						width: '100%',
						height: $(document).height()
					});
				break;
				case 'hide':
					$("#popup_over").remove();
				break;
			}
		},
		
		_reposition: function() {
			var top = (($(window).height() / 2) - ($("#imgLOAD").outerHeight() / 2)) + $.alerts.verticalOffset;
			var left = (($(window).width() / 2) - ($("#imgLOAD").outerWidth() / 2)) + $.alerts.horizontalOffset;
			if( top < 0 ) top = 0;
			if( left < 0 ) left = 0;

			$("#imgLOAD").css({
				top: top + 'px',
				left: left + 'px'
			});
			$("#popup_over").height( $(document).height() );
		},

		

	}

	// Shortuct functions
	Sloading = function(message,image) {
		$.loadings.loading(message, image);
	}
})(jQuery);