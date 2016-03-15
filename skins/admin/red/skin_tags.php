<?php
class skin_tags {
	function managerObjHtml() {
		global $bw, $vsLang, $vsSettings;
		$BWHTML = "";
		$BWHTML .= <<<EOF
<script></script>
<div id="page_tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all-top">
	<ul id="tabs_nav" class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all-inner">
    	<li class="ui-state-default ui-corner-top">
        	<a href="{$bw->base_url}{$bw->input[0]}/display_obj_tab_tags/&ajax=1">{$vsLang->getWords('tab_module_tags','tags')}</a>
        </li>
        <if="$vsSettings->getSystemKey($bw->input[0].'display_obj_help_tags',1)">
        <li class="ui-state-default ui-corner-top">
        	<a href="{$bw->base_url}{$bw->input[0]}/display_obj_help_tags/&ajax=1">{$vsLang->getWords('tab_help_tags','Develops guides')}</a>
        </li>
        </if>
        <if="$vsSettings->getSystemKey($bw->input[0].'_setting_tab',1)">	
        <li class="ui-state-default ui-corner-top">
        	<a href="{$bw->base_url}settings/moduleObjTab/{$bw->input[0]}/&ajax=1">{$vsLang->getWords('tab_user_SS','SystemSetting')}</a></li>
        </if>	
		<div class="clear"></div>
</ul>
<div class="clear"></div>
</div>
<div id="temp"></div>

EOF;
		return $BWHTML;
	}
#more_template#

	
	function addEditObjFormTags($obj, $option = array()) {
		global $vsLang, $bw, $vsSettings;
		$BWHTML .= <<<EOF
			<div id="error-message" name="error-message"></div>
			<form id='obj_form_tags' name="add-edit-obj-form" method="POST"  enctype='multipart/form-data'>
				<input type="hidden" name="userId" value="{$obj->getId()}" />
				<input type="hidden" name="group" id="group" value="" />
				<div class='ui-dialog ui-widget ui-widget-content ui-corner-all'>
					<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
						<span class="ui-dialog-title">{$vsLang->getWords('add_edit_tags',"Add edit tags")}</span>
						<span class="ui-dialog-title close_text" style="float:right;"><a href="javascript:vsf.get('{$bw->input[0]}/display_obj_tab_tags/','obj_panel_tags')" title="{$vsLang->getWords('close',"close")}">{$vsLang->getWords('close',"close")}</a></span>
					</div>
					<table class="ui-dialog-content ui-widget-content">
					
			<tr>
					<if="$vsSettings->getSystemKey($bw->input[0].'_text',1)">
						<td class="label_obj">{$vsLang->getWords('tags_text_name', 'text')}:</td>
						<td colspan="2"><input size="25" type="text" name="tags[text]" value="{$obj->getText()}" id="tags_obj_text"/></td>
					</if>
			</tr>
			
					<input type="hidden" value="{$obj->getId()}" name="tags[id]"/>
						
						<tr>
							<td class="ui-dialog-buttonpanel" colspan="4" align="center">
								<input type="submit" name="submit" value="<if="$obj->getId()">{$vsLang->getWords('edit',"Edit")}<else />{$vsLang->getWords('add',"Add")}</if>" />
							</td>
						</tr>
					</table>
				</div>
			</form>
			
			<script language="javascript">
				function checkObject() {
					var checkedString = '';
					$("input[type=checkbox]").each(function(){
						if($(this).hasClass('myCheckboxG')){
							if(this.checked) checkedString += $(this).val()+',';
						}
					});
					checkedString = checkedString.substr(0,checkedString.lastIndexOf(','));
					$('#group').val(checkedString);
				}
				function updateobjListHtml(categoryId){
					vsf.get('{$bw->input[0]}/display-obj-list/'+categoryId+'/','obj_panel_tags');
				}
				function alertError(message){
					jAlert(
						message,
						'{$bw->vars['global_websitename']} Dialog'
					);
				}
				$(window).ready(function() {
					vsf.jRadio('{}','userGender');
					vsf.jCheckbox('{$obj->getStatus()}','tagstatus');
					vsf.jCheckbox('{}','userDealer');
					<if="count($option['cur_groups'])">
						<foreach="$option['cur_groups'] as $key=>$group">
						vsf.jCheckbox('{$key}',"group{$key}");
						</foreach>
					</if>
					
				});
				$('#obj_form_tags').submit(function(){
					var flag  = true;
					var error = "";
					var categoryId;
					var count=0;
					$("#obj-category option:selected").each(function () {
						categoryId = $(this).val();
						count=1;
					});
					
					$('#obj-cat-id').val(categoryId);
					
					var text = $("#tags_obj_text").val();
					if(text == null || text == ""){
						error += "<li>{$vsLang->getWords('text_is_not_null', 'text is not null!!!')}</li>";
						flag  = false;
					}
				
				
					
					if(!flag){
						error = "<ul class='ul-popu'>" + error + "</ul>";
						alertError(error);
						return false;
					}
					checkObject();
					vsf.uploadFile("obj_form_tags", "{$bw->input[0]}", "add_obj_form_tags", "obj_panel_tags","tags");
					//vsf.submitForm($('#obj_form_tags'),'{$bw->input[0]}/add_obj_form_tags','obj_panel_tags');
					return false;
				});
				
			</script>
EOF;
		
	}
	
	
	

	function objListHtmlTags($option) {
		global $vsLang, $bw,$vsSettings;
		require_once LIBS_PATH.'DateTime.class.php';
		$BWHTML = "";
		$count = 0;
$BWHTML .= <<<EOF
<script type='text/javascript'>

	function checkObject() {
		var checkedString = '';
		$("input[class=myCheckbox]").each(function(){
			if(this.checked) checkedString += $(this).val()+',';
		});
		$('#checked-obj-tags').val(checkedString);
	}
	
	$('#hide-objlist-bt-tags').click(function() {
		if($('#checked-obj-tags').val()=='') {
			jAlert(
				"{$vsLang->getWords('visible_obj_confirm_hide', "You haven't choose any items to hide!")}",
				"{$bw->vars['global_websitename']} Dialog"
			);
			return false;
		}
		vsf.submitForm($('#obj_list_form_tags'),'{$bw->input[0]}/hide_checked_obj_tags/','obj_panel_tags');
	});
	
	$('#visible-objlist-bt-tags').click(function() {
		if($('#checked-obj-tags').val()=='') {
			jAlert(
				"{$vsLang->getWords('visible_obj_confirm_noitem', "You haven't choose any items to visible!")}",
				"{$bw->vars['global_websitename']} Dialog"
			);
			return false;
		}
		vsf.submitForm($('#obj_list_form_tags'),'{$bw->input[0]}/visible_checked_obj_tags/','obj_panel_tags');
	});
	
	$('#delete-objlist-bt_tags').click(function() {
		if($('#checked-obj-tags').val()=='') {
			jAlert(
				"{$vsLang->getWords('delete_obj_confirm_noitem', "You haven't choose any items to delete!")}",
				"{$bw->vars['global_websitename']} Dialog"
			);
			return false;
		}
		jConfirm(
			"{$vsLang->getWords('obj_delete_confirm', "Are you sure want to delete this {$bw->input[0]}?")}",
			"{$bw->vars['global_websitename']} Dialog",
			function(r) {
				if(r) {
					vsf.submitForm($('#obj_list_form_tags'),'{$bw->input[0]}/delete_checked_obj_tags/','obj_panel_tags');
					//vsf.get('{$bw->input[0]}/add-obj-form/','obj_panel_tags');
				}
			}
		);
	});
	
	$(document).ready(function(){
		<if="$option['message']">
			vsf.alert("{$option['message']}");
		</if>
	});
	function checkAllU() {
		var checked_status = $("input[name=allU]:checked").length;
		var checkedString = '';
		$("input[type=checkbox]").each(function(){
			if($(this).hasClass('myCheckboxU')){
			this.checked = checked_status;
			if(checked_status) checkedString += $(this).val()+',';
			}
		});
		$("span[acaica=myCheckboxU]").each(function(){
			if(checked_status)
				this.style.backgroundPosition = "0 -50px";
			else this.style.backgroundPosition = "0 0";
		});
		checkedString = checkedString.substr(0,checkedString.lastIndexOf(','));
		$('#checked-obj-tags').val(checkedString);
	}
	function checkObjectU() {
		var checkedString = '';
		$("input[type=checkbox]").each(function(){
			if($(this).hasClass('myCheckboxU')){
				if(this.checked) checkedString += $(this).val()+',';
			}
		});
		checkedString = checkedString.substr(0,checkedString.lastIndexOf(','));
		$('#checked-obj-tags').val(checkedString);
	}
	function deleteObj(id){
		$('#checked-obj-tags').val(id);
		$('#delete-objlist-bt_tags').click();
	}
	<if="$option['error']">
		jAlert(
						'{$option['error']}',
						'{\$bw->vars['global_websitename']} Dialog'
					);
	</if>
</script>
<div id="obj_panel_tags">
<form id="obj_list_form_tags">
	<input type="hidden" name="checkedObj" id="checked-obj-tags" value="" />
	<div class="ui-dialog ui-widget ui-widget-content ui-corner-all">
		<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
			<span class="ui-dialog-title">{$vsLang->getWords('tags_list','List of tags')}</span>
		</div>
		<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-corner-all-inner ui-widget-header">
	        <li class="ui-state-default ui-corner-top" id="add-objlist-bt-tags"><a href="javascript:vsf.get('{$bw->input[0]}/edit_obj_form_tags/','obj_panel_tags')" title="{$vsLang->getWords('hide_obj_alt_bt',"Hide selected {$bw->input[0]}")}">{$vsLang->getWords('add_obj_bt','Add')}</a></li>
	        <li class="ui-state-default ui-corner-top" id="hide-objlist-bt-tags"><a href="#" title="{$vsLang->getWords('hide_obj_alt_bt',"Hide selected {$bw->input[0]}")}">{$vsLang->getWords('hide_obj_bt','Hide')}</a></li>
	        <li class="ui-state-default ui-corner-top" id="visible-objlist-bt-tags"><a href="#" title="{$vsLang->getWords('visible_obj_alt_bt',"Visible selected {$bw->input[0]} ")}">{$vsLang->getWords('visible_obj_bt','Visible')}</a></li>
	        <li class="ui-state-default ui-corner-top" id="delete-objlist-bt_tags"><a href="#" title="{$vsLang->getWords('delete_obj_alt_bt',"Delete selected {$bw->input[0]}")}">{$vsLang->getWords('delete_obj_bt','Delete')}</a></li>
	    </ul>
		<table  cellpadding="1" cellspacing="1" style="width:100%">
			<thead>
				
			<tr>
	<th width='10'>	<input type="checkbox" onclick="checkAllU()" onclicktext="checkAllU()" name="allU" /></th><th width=''>{$vsLang->getWords('tags_text_head_text',"text")}</th>
<th width=''>{$vsLang->getWords('tags_dateTime_head_text',"dateTime")}</th>
</tr>
			
			
			</thead>
			<tbody>
				<if="count($option['pageList'])">
				<foreach="$option['pageList'] as $obj">
					<php> 
						$count++;
						if($count%2)
                               $class='old';
                       	else $class= 'even';
           			</php>     
			    	
           			
           			
           			<tr class='$class'>
						<td width='10'>
							<input type="checkbox" onclicktext="checkObjectU({$obj->getId()});" onclick="checkObjectU({$obj->getId()});" name="obj_{$obj->getId()}" value="{$obj->getId()}" class="myCheckboxU" />
						</td>
			<td><a href="javascript:vsf.get('{$bw->input[0]}/edit_obj_form_tags/{$obj->getId()}/','obj_panel_tags')" title='{$vsLang->getWords('newsItem_EditObjTitle',"Click here to edit this {$bw->input[0]}")}'>
                               {$obj->getText()}
                            </a></td>
                            <php>
                            $obj->setDateTime(VSFDateTime::getDate($obj->getDateTime()));
                            </php>
<td>{$obj->getDateTime()}</td>
						</tr>
           			
           			
           			
				</foreach>
				<tr>
					<td colspan='6' style='text-align: right;'>	{$option['paging']}</td>
				</tr>
				</if>
			</tbody>
		</table>
	</div>
</form>
</div>
EOF;
		
		return $BWHTML;
	}
function getHTML($option){
		global $vsLang, $bw,$vsSettings;
		$BWHTML = "";
		$count = 0;
$BWHTML .= <<<EOF
<div id="tag_panel_selection" style="position: relative; width: 95%; height: auto; float: left;">
            <input type="text" style="width:90%"  id="tag_panel_selection_text" name="tags_submit_list" value="{$option['taged']}">
            <div id="tag_panel_selection_tag" style=" background: #ddd">
            <div style="">
            <if="$option['newtag']">
     <foreach="$option['newtag'] as $tag">       
		<a href="#" style="font-size:{$tag->size}px;">{$tag->getText()}</a>,
	</foreach>
	</if>

</div>
            </div>
EOF;
		
		return $BWHTML;
	}
	function getTagScript($option){
		global $vsLang, $bw,$vsSettings;
		$BWHTML = "";
		$count = 0;
	$html=str_replace(array("\n","\""), array(" ","\\\""), $this->getHTML($option));

$BWHTML .= <<<EOF
$("#tag_panel_diplay").html("$html");
$(document).click(function(event){
             	var tar=$(event.target);
             	if(tar.parents("#tag_panel_selection").length==0){
             			$("#tag_panel_selection_tag").hide();
             	}
				
});
$("#tag_panel_selection_tag a").click(function(){
			var mySplitResult = $("#tag_panel_selection_text").val().split(",");
			for(i = 0; i < mySplitResult.length; i++){
				if($(this).text()==mySplitResult[i].replace(/^\s+|\s+$/g,"")) return false;
			}
			if($("#tag_panel_selection_text").val().replace(/^\s+|\s+$/g,"").length==0)
			$("#tag_panel_selection_text").val($(this).text());
			else $("#tag_panel_selection_text").val($("#tag_panel_selection_text").val()+","+$(this).text());
		
		return false;
});
$("#tag_panel_selection_text").focus(function(){
             	$("#tag_panel_selection_tag").fadeIn("slow");
});
EOF;
		
		return $BWHTML;
	}
function getHTML($option){
		global $vsLang, $bw,$vsSettings;
		$BWHTML = "";
		$count = 0;
$BWHTML .= <<<EOF
<div id="tag_panel_selection" style="position: relative; width: 95%; height: auto; float: left;">
            <input type="text" style="width:90%"  id="tag_panel_selection_text" name="tags_submit_list" value="{$option['taged']}">
            <div id="tag_panel_selection_tag" style=" background: #ddd">
            <div style="">
            <if="$option['newtag']">
     <foreach="$option['newtag'] as $tag">       
		<a href="#" style="font-size:{$tag->size}px;">{$tag->getText()}</a>,
	</foreach>
	</if>

</div>
            </div>
EOF;
		
		return $BWHTML;
	}
	function helpGuide($option){
		global $vsLang, $bw,$vsSettings;
		$BWHTML = "";
		$html = 0;
		$htmlForm="
				<div id=\"tag_panel_diplay\">
							<script src='{\$bw->base_url}tags/get_tag_for_obj/{\$bw->input[0]}/{\$objItem->getId()}'>
							</script>
				</div>
		";
		$htmlForm=htmlspecialchars($htmlForm);
		$htmlProcess="
				/**add tags process***/
			require_once CORE_PATH.'tags/tags.php';
			\$tags=new tags();
			\$tags->addTagForContentId(\$bw->input[0], \$this->module->obj->getId(), \$bw->input['tags_submit_list']);
			/****/
		";
		$htmlProcess=htmlspecialchars($htmlProcess);
		$htmlCode="
				/**get tags for module***/
			require_once CORE_PATH.'tags/tags.php';
			\$tags=new tags();
			\$tags->getTagsForModule(\"news\");//news is module name
			/****/
			/**get tags for a article***/
			require_once CORE_PATH.'tags/tags.php';
			\$tags=new tags();
			\$tags->getTagByContent(\"news\",252);////news is module name and 252 is artile id
			/****/
		";
		$htmlCode=htmlspecialchars($htmlCode);
	$html=str_replace(array("\n","\""), array(" ","\\\""), $this->getHTML($option));

$BWHTML .= <<<EOF
<p>
Copy this code to insert object form:<br/>
<textarea style="width:700px;height:117px;">{$htmlForm}</textarea>
</p>
<p>
Copy this code to insert object process:<br/>
<textarea style="width:700px;height:117px;">{$htmlProcess}</textarea>
</p>
<p>
When get tags using:<br/>
<textarea style="width:700px;height:117px;">{$htmlCode}</textarea>
</p>

EOF;
		
		return $BWHTML;
	}
	
}
?>