var vsf = {
	get:function(act, id, options) {
	// Luu Quang Vu
	// ********************************************
	// use to remove sub form
	($("div[id]").each(function(){
		if(this.id.indexOf('subForm')!= -1)
			$("#"+this.id).html('');
	}));
	// ********************************************
	var params = {vs: act, ajax:1};
	params = $.extend({}, params,  options);
	var noimage = "";
	if(typeof(noimage)=="undefine" || !noimage && id!='')
		$("#"+id).html('<img src="'+imgurl+'loader.gif"/>');
	$.get(ajaxfile,params,function(data){
		if(id!='') {
			if($("#"+id).length>0) $("#"+id).children().remove();
			data=data.replace("id=\""+id+"\"","");
			data=data.replace("id='"+id+"'","");
			$("#"+id).html(data).css('display','none')

			$("#"+id).fadeIn('slow');
			if($('#page_tabs').html() != null && $('#page_tabs').html() != 'undefined')
				$('#page_tabs').tabs();
		}
	});
},
/******* truyen tham so jquery ajax ************/
popupGet:function(act, id, w, h, title,option) {
if(!this.isDefined(w)) w = 500;
if(!this.isDefined(h)) h = 500;
if(!title)
	title="Thông báo - "+ global_website_title;
if(!$("#"+id).html()){
	$("body").append("<div id='"+id+"' class='"+id+"' >	</div>");
}
vsf.get(act, id,option);
$(document).ready(function() {
	$("#"+id).dialog({modal: true, width:w, height:h, title:title});
	$("#"+id ).bind( "dialogclose", function(event, ui) {
		$(this).remove();
	});
});
},


/**
 * if you not understand this problem please contact tuyenbui@vietsol.net
 */
popupLightGet:function(act, id, w, h,options) {
	var defaults={
			resizable: false,
			width:w,
			height:h,
			bgiframe: true,
			modal: true
	}
	options = $.extend({}, defaults,  options);
	if(!this.isDefined(w)) w = 500;
	if(!this.isDefined(h)) h = 500;
	if(!$("#"+id).html())
		$("body").append("<div id='"+id+"' class='"+id+"' >	</div>");
	vsf.get(act, id);
	$(document).ready(function() {
		$("#"+id).dialog(options);
		$("#"+id ).bind( "dialogclose", function(event, ui) {
			$(this).remove();
		});
		//if you understand this problem contact tuyenbui
		var maxZ = Math.max.apply(null,$.map($('body > *'), function(e,n){
	           if($(e).css('position')=='absolute')
	                return parseInt($(e).css('z-index'))||1 ;
	           })
	    );
		 $("#"+id+",.ui-dialog,.ac_results").css("z-index",maxZ);
	});
},
submitFormFront:function(obj,act,id,options) {
	var defaults={
			json:false,
			sucess: function(data) {
				if(id!='') {
					data=data.replace("id=\""+id+"\"","");
					data=data.replace("id='"+id+"'","");
					$("#"+id).html(data).css('display','none')
					$("#"+id).fadeIn('slow');
				}
			}

	}
	options = $.extend({}, defaults,  options);
	if(typeof(tinyMCE) != "undefined") tinyMCE.triggerSave();
	var params = {
			vs:act,
			ajax: 1
	};
	var count = 0;
	obj
	.find("input[type='radio']:checked, input[checked], input[type='text'], input[type='hidden'], input[type='password'], input[type='submit'], option[selected], textarea")
	.each(function() {
		params[ this.name || this.id || this.parentNode.name || this.parentNode.id ] = this.value;
	});
	$("#"+id).children().remove();
	if(id!='')
		$("#"+id).html('<img src="'+imgurl+'loader.gif"/>');
	if(options.json){
		$.post(ajaxfile,params,
				function(data){
					options.sucess(data)
				},"json"
		);
	}else{
		$.post(ajaxfile,params,
				function(data){
					options.sucess(data)
				}
		);
	}
},
submitForm:function(obj,act,id,options) {
	var defaults={
			json:false,
			sucess: function(data) {
				if(id!='') {
					data=data.replace("id=\""+id+"\"","");
					data=data.replace("id='"+id+"'","");
					$("#"+id).html(data).css('display','none')
					$("#"+id).fadeIn('slow');
					//$('#page_tabs').tabs();
				}
			}

	}
	options = $.extend({}, defaults,  options);
	if(typeof(tinyMCE) != "undefined") tinyMCE.triggerSave();
	var params = {
			vs:act,
			ajax: 1
	};
	var count = 0;
	
	$.each(obj.serializeArray(), function() {
        if (params[this.name]) {
            if (!params[this.name].push) {
            	params[this.name] = [params[this.name]];
            }
            params[this.name].push(this.value || '');
        } else {
        	params[this.name] = this.value || '';
        }
    });
	$("#"+id).children().remove();
	if(id!='')
		$("#"+id).html('<img src="'+imgurl+'loader.gif"/>');
	if(options.json){
		$.post(ajaxfile,params,
				function(data){
					options.sucess(data)
				},"json"
		);
	}else{
		$.post(ajaxfile,params,
				function(data){
					options.sucess(data)
				}
		);
	}
},
submitFormAllCheckBox:function(obj,act,id) {
	if(typeof(tinyMCE) != "undefined") tinyMCE.triggerSave();
	if(id!='')
		$("#"+id).html('<img src="'+imgurl+'loader.gif"/>');
	var params = {
			vs:act,
			ajax: 1
	};
	var count = 0;
	obj
	.find("input[type='radio']:checked, input[type='checkbox'], input[type='text'], input[type='hidden'], input[type='password'], input[type='submit'], option[selected], textarea")
	.each(function() {
		params[ this.name || this.id || this.parentNode.name || this.parentNode.id ] = this.value;
	});
	$.post(ajaxfile,params,function(data) {
		if(id!='') {
			data=data.replace("id=\""+id+"\"","");
			data=data.replace("id='"+id+"'","");
			$("#"+id).html(data).css('display','none')
			$("#"+id).fadeIn('slow');
			$('#page_tabs').tabs();
		}
	});
},

isDefined:function(obj) {
	return (typeof(obj) == "undefined")?  false: true;
},

removeForm:function(id){
	$("#"+id).html('');
},

jSelect:function(the_value,idselect){
	$("#"+idselect+" option").each(function () {
		if(the_value == $(this).val())
			$(this).attr('selected','selected');
	});
},


jCheckbox:function(the_value,id){
	if(!$('#'+id))
		return;
	if(the_value==$('#'+id).val()){
		$('#'+id).attr('checked','checked');
		return true;
	}
},

jRadio:function(the_value,name){
	$("[name="+name+"]").each(function () {
		if(the_value == $(this).val())
		{
			$(this).attr('checked','checked');
		}
	});
},


alert:function (message){
	jAlert(message,'Hộp thông báo');
},

uploadFile:function(formId, module, action, objIdCallBack, fileFolder, utype,callbackfunction){
	var countFile = 0;
	if(typeof(utype) == 'undefined') utype = 1;
	$("#"+formId).find("input[type='file']").each(function(){
		if(this.value&&!this.disabled){
			countFile ++;
		}
	});
	if(typeof(tinyMCE) != "undefined") tinyMCE.triggerSave();
	if(countFile > 0){
		$('#error-message').ajaxStart(function(){
			$(this).html("<img src='"+imgurl+"loader.gif' alt='loading' />");
		});
		var file = "";  
		$("#"+formId).find("input[type='file']").each(function(){
			if(this.value&&!this.disabled){
				var name = this.name;
                var filetitle = $("#"+formId).find("#fileTitle").val();
                var fileindex = $("#"+formId).find("#fileIndex").val();
				var uri = baseUrl+"files/files_uploadfile/&ajax=1&uploadName="+name+"&fileFolder="+fileFolder+"&table="+module+"&fileTitle="+filetitle+"&fileIndex="+fileindex+'&utype='+utype;
				if( this.id==''){
					 this.id=this.name;
				} 
				var id = this.id;
				
				//alert(id);
				$.ajaxFileUpload({
					url:uri,
					secureuri:false,
					fileElementId:id,
					dataType:"json",
					success: function (data, status){
						countFile--;
						if(typeof(data.error) != 'undefined'||data.error==null){
							if(data.error != ''&&data.error!=null){
								jAlert(data.error,"Vietsol Infomation");
							}
							else{
//								var image_up = '';
//								image_up += data.fileImageId + ",";
								$("#"+formId).append("<input hidden='' name='files["+name+"]' value='"+data.id+"'/>");
								if(countFile == 0){
//									if(image_up){
//										$("#"+formId).append("<input type='hidden' name='fileImageId' id='fileImageId' value='"+image_up.substring(0,image_up.length-1)+"'/>");
//									}
									if(typeof(callbackfunction)=='function') {
										vsf.submitForm($('#'+formId), module+'/'+action+'/', '_');
										if(typeof(callbackfunction)=='function') callbackfunction();
									}else{
										vsf.submitForm($('#'+formId), module+'/'+action+'/', objIdCallBack);
									}
									
									return false;
								}
							}
						}
					},
					error: function (data, status, e){
						countFile--;
						$('#error-message').ajaxStop(function(){
							$(this).html(e);
						});
						return false;
					}
				});
			}
		});
	}
	else{
		$('#error-message').ajaxStop(function(){
			$(this).html('');
		});
		if(typeof(callbackfunction)=='function') {
			vsf.submitForm($('#'+formId), module+'/'+action+'/', '_');
			if(typeof(callbackfunction)=='function') callbackfunction();
		}else{
			vsf.submitForm($('#'+formId), module+'/'+action+'/', objIdCallBack);
		}
		return false;
	}
	$('#error-message').ajaxStop(function(){
		$(this).html('');
	});
	return false;
},

checkAll:function (clas,ret){
   
        if(!clas||typeof(clas)=="undefined")clas='myCheckbox';
        if(!ret||typeof(ret)=="undefined")ret='checked-obj';
       
        var checked_status = $("input[name=all]:checked").length;
        var checkedString = '';
        $("input[type=checkbox]").each(function(){
               if($(this).hasClass(clas)){
               this.checked = checked_status;
               if(checked_status) checkedString += $(this).val()+',';
               }
        });
        $("span[acaica="+clas+"]").each(function(){
               if(checked_status)
                      this.style.backgroundPosition = "0 -50px";
               else this.style.backgroundPosition = "0 0";
        });
        checkedString = checkedString.substr(0,checkedString.lastIndexOf(','));
        $('#'+ret).val(checkedString);
       
},
checkObject:function (clas, ireturn){

        if(!clas||typeof(clas)=="undefined")clas='myCheckbox';
        if(!ireturn||typeof(ireturn)=="undefined") ireturn='checked-obj';

	var checkedString = '';
        $("input[type=checkbox]").each(function(){
               if($(this).hasClass(clas)){
                      if(this.checked) checkedString += $(this).val()+',';
               }
        });
        checkedString = checkedString.substr(0,checkedString.lastIndexOf(','));
        $('#'+ireturn).val(checkedString);
        
},
checkValue:function (ireturn){
	if(!ireturn||typeof(ireturn)=="undefined") ireturn ='checked-obj';
     
	if(!$('#'+ireturn).val()||$('#'+ireturn).val()=="") {
                jAlert(
                       global_website_choise ,
                       global_website_title +" Dialog"
                );
                return false;
         }
	return true;
},
removeAccent: function(str) {
	  if(str=="undefined" || !str) return;
	  str= str.toLowerCase();  
	  str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");  
	  str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");  
	  str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");  
	  str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");  
	  str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");  
	  str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");  
	  str= str.replace(/đ/g,"d");  
	  str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|&|#|\[|\]|~|\$|{|}|_/g,"-"); 
	  /* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự - */ 
	  str= str.replace(/-+-/g,"-"); //thay thế 2- thành 1- 
	  str= str.replace(/^\-+|\-+$/g,""); 
	  //cắt bỏ ký tự - ở đầu và cuối chuỗi 
	  return str;  
},
editPermalink: function (){
		var mUrl = $("#mUrl").val();
		
		if(mUrl){
			$("#editable-mUrl").html("<input name='edit-mUrl' id='edit-mUrl' value='"+mUrl+"' type='text' size='32' />");
			$("#ac_edit").removeClass('vs-icon-edit').addClass('icon-enable').attr("onclick","vsf.savePermalink()");
			$("#edit-mUrl").keyup(function(event){
				if(event.keyCode=='32')
					$(this).val(vsf.removeAccent($(this).val())+'-');
				if (event.keyCode == 86) //86 is Paste event
				{
					$(this).val(vsf.removeAccent($(this).val()));
					event.preventDefault();
				}
			});
		}
	},
savePermalink: function (){
		var title = $('#edit-mUrl').val();
		
		if($("#mUrl").attr('data-id')){
			$.ajax({
		        url: ajaxfile+"?vs="+$("#mUrl").attr('data-module')+"/"+$("#mUrl").attr('data-module')+'_checkPermalink'+"&ajax=1&title="+title+"&id="+$("#mUrl").attr('data-id'),
		        success: function (f) {
		        	$("#mUrl").val(f);
		        	$("#editable-mUrl").html(f);
		    		$("#ac_edit").removeClass('icon-enable').addClass('vs-icon-edit').attr("onclick","vsf.editPermalink()");
		        }
		    })
		}
		else{
			$("#mUrl").val(title);
        	$("#editable-mUrl").html(title);
    		$("#ac_edit").removeClass('icon-enable').addClass('vs-icon-edit').attr("onclick","vsf.editPermalink()");
		}
		
		
	},
checkPermalink: function(title,module){
		if(!$("#mUrl").val() && title!=''){
			var title_cate = vsf.removeAccent($("#vs_cate option:selected").html());
			$.ajax({
		        url: ajaxfile+"?vs="+$("#mUrl").attr('data-module')+"/"+$("#mUrl").attr('data-module')+'_checkPermalink'+"&ajax=1&title="+title,
		        success: function (f) {
		        	$("#mUrl").val(f);
		        	$("#edit-slug-box").append(boardUrl+"/"+module+"/"+(title_cate?title_cate+"/":'')+"<span id='editable-mUrl'>"+f+"</span>.html<a onclick='vsf.editPermalink(); return false;' class='icon-wrapper-vs vs-icon-edit' id='ac_edit'></a>").show()
		        }
		    })
			
		}
	}
}
