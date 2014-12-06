$(document).ready(function(){
		    			$("#page_tabs").tabs({
							fx: { opacity: "toggle" },
							cache: false
						});
		    			$("#page_tabs").bind("tabsselect", function(event, ui) { 
		    			  if(window.location.hash.indexOf(ui.tab.hash)!=0)
					      window.location.hash = ui.tab.hash;
					    });
					    $.address.externalChange(function(event){
						    var name = window.location.hash != "" ? window.location.hash.split("#")[1] : "";
						    var  arr=name.replace(/\/$/,'').split('/');
						    var request='';
						    var callbackid;
						    if(arr.length<=1) {
						    	if(name.length==0) {
						    		var retab=($("#page_tabs").find('li.ui-state-default a') ||
						    			$("#page_tabs").find('li:first a')).attr('href');
						    		//window.location+=retab;
						    		 arr[0]=retab;
						    		//location.reload();
						    		//return;
						    		
						    	}
						    	
						    	$("#page_tabs").tabs( "select" , arr[0] );
//						    	arr[0]='#'+arr[0].replace(/^\#/,'');
								var mde=$(arr[0]).find("input[name='modelName']").val();
								if(typeof(mde)=='undefined') return;
								var mod=$(arr[0]).find("input[name='moduleName']").val();
						    	request=mod+'/'+mde+'_display_tab';
						    	callbackid=$(arr[0]).find('.vs_panel').attr('id');
						    	
						    }else{
						    	$("#page_tabs").tabs( "select" , arr[0] );
							   if(typeof($('#'+arr[0]).find('.vs_panel')[0])=='undefined'){
								    $( "#page_tabs").bind( "tabsload", function(event, ui) {
									     	callbackid=$('#'+arr[0]).find('.vs_panel').attr('id');
										    arr[0]=null;
										    //alert(arr.join('/'));
										    if(callbackid!='undefined'){
										    	request=arr.join('/');
										    	requestData(request,callbackid);
										    	
										    }
									});
									
							    }else{
							    		callbackid=$('#'+arr[0]).find('.vs_panel').attr('id');
									    arr[0]=null;
									    if(callbackid!='undefined'){
									    	request=arr.join('/');
									 	}
							    }
						    }
						    
						    requestData(request,callbackid);
						     
						    
						});
		  			});
		  			function requestData(url,callback){
		  				if(typeof(callback)!='undefined'){
		  				if($("#"+callback).length>0){
		  					$("#"+callback).children().remove();		
						}
							    if(typeof(noimage)=="undefine" || !noimage && callback!='')
									$("#"+callback).html('<img src="'+imgurl+'loader.gif"/>');
							    $.ajax({
									url: baseUrl+url,
									data:'ajax=1',
									success: function(data) {
										$('#'+callback).html(data);
									}
								});
						}
		  			}


		  			
function editImage(el){
	var path=$(el).attr("path");
//	var url="";
//	if($(el).attr("vswidth")) path+="&w="+$(el).attr("vswidth");
//	if($(el).attr("vsheight")) path+="&h="+$(el).attr("vsheight");
	return editImagePath(path,$(el).attr("vswidth"),$(el).attr("vsheight"));
//	var myRef = window.open(boardUrl+'/vsimgeditor/index.php?imagesrc=.'+path,'edit_img_able',	'left=20,top=20,width=850,height=700,toolbar=1,resizable=0,fullscreen=yes,scrollbars=1');
	//myWindow.document.write("<p>This is 'myWindow'</p>")
	
}
function editImagePath(path,w,h){
	var url=path;
	if(w) url+="&w="+w;
	if(h) url+="&h="+h;
	var myRef = window.open(boardUrl+'/vsimgeditor/index.php?imagesrc=.'+url,'edit_img_able',	'left=20,top=20,width=850,height=700,toolbar=1,resizable=0,fullscreen=yes,scrollbars=1');
	return false;
	//myWindow.document.write("<p>This is 'myWindow'</p>")
	
}
$("a.btn_custom_settings").live("click",function(){//alert("sdfsdf");
	if($(this).find("ul.setting_panel").length==0) {
		var el=$(this);
		$.ajax({
			url: baseUrl+'settings/settings_quick_update_form_group/'+$(this).attr("group"),
			type: 'POST',
			//dataType:'json',
			cache: false,
			data: 'ajax=1',
			success: function(data){
			el.append($("<ul class='setting_panel'/>").html(data)
					.append("<li class=\"submit_form\"><input type=\"button\" class='btn_q_setting_save' value=\"Save\"/></li>").show());
			},
			error: function (){
				alert('Có lỗi xảy ra');
			}
		});
	}
		
	if($(this).find("ul.setting_panel").is(':visible')) {
		//$(this).find("ul.setting_panel").hide();
		//return;
	}
	$(this).find("ul.setting_panel").show();
	$(document).click(function(event) {
		  var target = $(event.target);
		  if(target.parents(".btn_custom_settings").length==0&&!target.hasClass("btn_custom_settings")){
			  console.log(target);
			  $(this).find("ul.setting_panel").hide();
		  }
		  
		  
	});
	
});
$("a.btn_custom_settings input.btn_q_setting_save").live("click",function(){
	var form=$("<form/>");
	$(this).parents(".btn_custom_settings").find(" input[type='checkbox'],input[type='hidden']")
	.each(function(){
	//alert(this.name+":"+$(this).val());
		if($(this).attr('type')=='checkbox'){
			if(this.checked)
			form.append($("<textarea />").attr("name",this.name).val(1));
			else form.append($("<textarea />").attr("name",this.name).val(0));
		}else{
			form.append($("<textarea />").attr("name",this.name).val(this.value));
		}
	});
//	alert(form.html());
	$.ajax({
		url: baseUrl+'settings/settings_quick_save_group/',
		type: 'POST',
		dataType:'json',
		cache: false,
		data: 'ajax=1&json=1&'+form.serialize(),
		success: function(data){
			if(data.status==0){
				return false;
			 }
			alert(data.message);
		},
		error: function (){
			alert('Có lỗi xảy ra');
		}
	});
	return false;
});
