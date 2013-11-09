/*
 * jQuery Autocomplete plugin 1.1
 *
 * Copyright (c) 2009 JÃ¶rn Zaefferer
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 * Revision: $Id: jquery.autocomplete.js 14 2009-08-22 10:29:29Z joern.zaefferer $
 */
var realUrl="";
var aliasUrl="";
var currentSeoIdInput="";
;(function($) {
	$.fn.extend({
		vsSeo: function(seoId, options) {
		options = $.extend({}, $.vsSeo.defaults,  options);
		realUrl=options.realUrl;
		aliasUrl= strim_decode(options.aliasUrl,options.space);
		// if highlight is set to false, replace it with a do-nothing function
		//options.highlight = options.highlight || function(value) { return value; };

		// if the formatMatch option is not specified, then use formatItem for backwards compatibility
		//options.formatMatch = options.formatMatch || options.formatItem;
		function strim_decode(str,space) {  
			str= str.toLowerCase();  
			str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");  
			str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");  
			str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");  
			str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");  
			str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");  
			str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");  
			str= str.replace(/đ/g,"d");  
			str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g,"-"); 
			str= str.replace(/-+-/g,"-"); //thay thế 2- thành 1- 
			str= str.replace(/^\-+|\-+$/g,"");  
			str= str.replace(/\s+/,space);
			return str;  
		} 
		return this.each(function() {
			new $.vsSeo($(this),seoId, options);
		});
	},
	unvsSeo: function() {
		return;
	}
	});

	$.vsSeo = function(input, seoId, options) {
		if(input.parents("form:first").find("input[name='seoId']").length==0){
			input.parents("form:first").append("<input name='seoId' type='hidden' value='"+seoId+"' />");
		}
		currentSeoIdInput=input.parents("form:first").find("input[name='seoId']");

		switch(options.type) {
			case "bind":
				var icon=$("<div class='"+options.iconClass+"'>&nbsp;</div>");
				$(icon).insertAfter(input);
				input.css("float", "left");
				input.width(input.width()-icon.width()-5);
				icon
				.css("float","left")
				.css("margin-left","5px")
				.click(function(){
					show();
				});
			break;
			case "mouseover":
				input.mouseover(function(){
					show();
				});
				input.mouseout(function(){
					box.hide();
				});
			break;
			case "dbclick":
				input.dblclick(function () { 
				      show();
				    });
			break;
			case "click":
				input.click(function(){
					show();
				});
			break;
			default:
				var icon=$("<div class='"+options.iconClass+"'>&nbsp;</div>");
			$(icon).insertAfter(input);
			input.css("float","left");
			input.width(input.width()-icon.width()-5);
			icon
			.css("float","left")
			.css("margin-left","5px")
			.click(function(){
				show();
			});
			break;
		}
		function show(){//alert(ajaxfile+"vs="+options.module+"/"+options.action+"/"+seoId);
			if(!seoId) seoId = currentSeoIdInput.val();
			vsf.popupLightGet(options.module+"/"+options.action+"/"+currentSeoIdInput.val(), 
			options.elementId, options.width, options.height,{
				modal: true, zIndex:1500,
			});
			
			 var maxZ = Math.max.apply(null,$.map($('body > *'), function(e,n){
		           if($(e).css('position')=='absolute')
		                return parseInt($(e).css('z-index'))||1 ;
		           })
		    );
			 $("#"+options.elementId+",.ui-dialog,.ac_results").css("z-index",maxZ);
		}
	};
	$.vsSeo.defaults = {
			iconClass:"_seo_icon_class",
			module:"urlalias",
			action:"showAddEditForm",
			elementId:"seoelement",
			width:800,
			height:400,
			loadingClass: "ac_loading",
			title: "Vs tip",
			zIndex:1000,
			realUrl:"",
			aliasUrl:"",
			space:"-",
			type: "bind"  //click, mouseover, dbclick, bind
	};	
})(jQuery);
