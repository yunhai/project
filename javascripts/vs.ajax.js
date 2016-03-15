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
//	if(typeof(noimage)=="undefine" || !noimage && id!='')
//		$("#"+id).html('<img src="'+imgurl+'loader.gif"/>');
	$.get(ajaxfile,params,function(data){
		if(id!='') {
			data=data.replace("id=\""+id+"\"","");
			data=data.replace("id='"+id+"'","");
			$("#"+id).html(data).css('display','none')

			$("#"+id).fadeIn('slow');
			if($('#page_tabs').html() != null && $('#page_tabs').html() != 'undefined')
				$('#page_tabs').tabs();
		}
	});
},
popupGet:function(act, id, w, h) {
	if(!this.isDefined(w)) w = 500;
	if(!this.isDefined(h)) h = 500;
	if(!$("#"+id).html())
		$("body").append("<div id='"+id+"' class='"+id+"' >	</div>");
	vsf.get(act, id);
	$(document).ready(function() {
		$("#"+id).dialog({modal: true, width:w, height:h});
		$("#"+id ).bind( "dialogclose", function(event, ui) {
			$(this).remove();
		});
		var maxZ = Math.max.apply(null,$.map($('body > *'), function(e,n){
	           if($(e).css('position')=='absolute')
	                return parseInt($(e).css('z-index'))||1 ;
	           })
	    );
		 $("#"+id+",.ui-dialog,.ac_results").css("z-index",maxZ);
	});
},


/**
 * if you not understand this problem please contact tuyenbui@vietsol.net
 */
popupLightGet:function(act, id, options) {
	var defaults={
			resizable: false, 
			bgiframe: true,
			modal: true
	}
	options = $.extend({}, defaults,  options);
	if(!this.isDefined(options['weight'])) w = 818;
	if(!this.isDefined(options['height'])) h = 500;
	
	if(!$("#"+id).html())
		$("body").append("<div id='"+id+"' class='"+id+"' >	</div>");

	vsf.get(act, id, options['params']);
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
	if(id!='')
		$("#"+id).html('<img src="'+imgurl+'loader.gif"/>');
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
	jAlert(
			message,
			global_website_title +" Dialog"
	);
},

uploadFile:function( formId, module, action, objIdCallBack, fileFolder){
	var countFile = 0;
	$("#"+formId).find("input[type='file']").each(function(){
		if(this.value){
			countFile ++;
		}
	});
	if(countFile > 0){
		$('#error-message').ajaxStart(function(){
			$(this).html('<img src="'+imgurl+'loader.gif"/>');
		});
		var file = "";  
		$("#"+formId).find("input[type='file']").each(function(){
			if(this.value){
				var name = this.name;
                                var filetitle = $("#"+formId).find("#fileTitle").val();
                                var fileindex = $("#"+formId).find("#fileIndex").val();
                                var fileurl = $("#"+formId).find("#fileUrl").val();
                                var fileintro = $("#"+formId).find("#fileIntro").val();
				var uri =baseUrl+"files/uploadfile/&ajax=1&uploadName="+name+"&fileFolder="+fileFolder+"&table="+module+"&fileTitle="+filetitle+"&fileIndex="+fileindex+"&fileUrl="+fileurl+"&fileIntro="+fileintro;
				$.ajaxFileUpload({
					url:uri,
					secureuri:false,
					fileElementId:name,
					dataType:"json",
					success: function (data, status)
					{
					countFile--;
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							jAlert(data.error,"Vietsol Infomation");
						}
						else
						{
							file += data.fileId + ",";
							if(countFile == 0){
								$("#"+formId).append("<input type='hidden' name='fileId' id='fileId' value='"+file.substring(0,file.length-1)+"'/>");
								vsf.submitForm($('#'+formId), module+'/'+action+'/', objIdCallBack);
								return false;
							}
						}
					}
					},
					error: function (data, status, e)
					{
						countFile--;
						$('#error-message').ajaxStop(function(){
							$(this).html(e);
						});
						return false;
					}
				}
				)
			}
		});

	}
	else{
		$('#error-message').ajaxStop(function(){
			$(this).html('');
		});
		vsf.submitForm($('#'+formId), module+'/'+action+'/', objIdCallBack);
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
checkObject:function (clas,ret){

        if(!clas||typeof(clas)=="undefined")clas='myCheckbox';
        if(!ret||typeof(ret)=="undefined")ret='checked-obj';

	var checkedString = '';
        $("input[type=checkbox]").each(function(){
               if($(this).hasClass(clas)){
                      if(this.checked) checkedString += $(this).val()+',';
               }
        });
        checkedString = checkedString.substr(0,checkedString.lastIndexOf(','));
        $('#'+ret).val(checkedString);
        
},
checkValue:function (ret){
      if(!ret||typeof(ret)=="undefined")ret='checked-obj';
     
	if(!$('#'+ret).val()||$('#'+ret).val()=="") {
          
                jAlert(
                       global_website_choise ,
                       global_website_title +" Dialog"
                );
                return false;
         }
         return true;
}
}
