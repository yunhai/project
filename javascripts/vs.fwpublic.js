if($.browser.msie){
				$(document).ready(function(){
					$('[placeholder]').each(function(){
						if ($(this).val() == '') {
						   $(this).val($(this).attr('placeholder'));
						    $(this).addClass('placeholder');
						  }
					});
				});
    			$('[placeholder]').live('focus',function() {
				  var input = $(this);
				  if (input.val() == input.attr('placeholder')) {
				    input.val('');
				    input.removeClass('placeholder');
				  }
				});
				$('[placeholder]').live('blur',function() {
				  var input = $(this);
				  if (input.val() == '' || input.val() == input.attr('placeholder')) {
				    input.addClass('placeholder');
				    input.val(input.attr('placeholder'));
				  }
				});
				$('form').live('submit',function() {
				  $(this).find('[placeholder]').each(function() {
				    var input = $(this);
				    if (input.val() == input.attr('placeholder')) {
				      input.val('');
				    }
				  })
				});
}