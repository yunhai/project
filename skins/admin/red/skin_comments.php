<?php
class skin_comments {
    
	function displayPanelCommentPopup($option){
		global $vsLang,$vsPrint;
		$count = count($option['list']);
		
		$BWHTML .= <<<EOF
		<div class="divbu">
	
			<div id="panelCommentPopup" class="panel_comment_popup">
				<div class="list_comment_header" id="list_comment_header" name="list_comment_header">
					<!--<input class="bt_header" type='button' id='bt_comment_hide' name='bt_comment_hide' value='{$vsLang->getWords('global_text_hide', 'Hide')}'/>
					<input class="bt_header" type='button' id='bt_comment_display' name='bt_comment_display' value='{$vsLang->getWords('global_text_display', 'Display')}'/>
					<input class="bt_header" type='button' id='bt_comment_delete' name='bt_comment_delete' value='{$vsLang->getWords('global_text_delete', 'Delete')}'/>
					-->
					<input type='button' onclick="submitUpdate();" class='bt_comment_update' name='bt_comment_delete' value="{$vsLang->getWords('global_text_update', 'Update')}"/>
					
				</div>
				<div id="form_popup">
					<form method="POST" name="form_update_comment" id="form_update_comment">
						<input type="hidden" name="strIds" value="{$option['strIds']}" />
						<input type="hidden" name="objectId" value="{$option['objectId']}" />
						<input type="hidden" name="tableName" value="{$option['tableName']}" />
							<if="$count">
							<foreach="$option['list'] as $obj">
								<input type="hidden" name="id_action" value="" />
								{$this->displayCommentPopup($obj)}
							</foreach>
							</if>
					</form>
				</div>
			</div>
		<div class="list_comment_header" id="list_comment_header" name="list_comment_header">
		<input type='button' onclick="submitUpdate();" class='bt_comment_update' name='bt_comment_delete' value="{$vsLang->getWords('global_text_update', 'Update')}"/>
		</div>
		<script>
			function submitUpdate(){
				$("#commentPopup p input").each(function(){
						if($(this).val() == '')
							vsf.alert("{$vsLang->getWords('global_name_title_null','Name or Title not null!!!')}");
							return false;	
					});
					vsf.submitForm($("#form_update_comment"), "comments/update-all", "form_popup");
					return false;
			}
		</script>
		</div>
EOF;
return $BWHTML;
	}
        
        
	function displayCommentPopup($obj){
		global $vsLang;
		
		$BWHTML .= <<<EOF
		<div id="commentPopup" class="comment_popup">
			<div class="comment_option">
				<div>
					<label>{$vsLang->getWords('global_text_hide', 'Hide')}</label>
					<input type='radio' name='ra_comment_{$obj->getId()}' value='0' />
				</div>
				<div>
					<label>{$vsLang->getWords('global_text_display', 'Display')}</label>
					<input type='radio' name='ra_comment_{$obj->getId()}' value='1'/>
				</div>
				<div>
					<label>{$vsLang->getWords('global_text_delete', 'Delete')}</label>
					<input type='radio' name='ra_comment_{$obj->getId()}' value='3'/>
				</div>
			</div>
			<div id='comment_panel' name="comment_panel" class="comment_panel">
				<p><label>{$vsLang->getWords('global_text_name', 'Name')}</label><input type="text" name="commentAuthor_{$obj->getId()}" id="commentAuthor_{$obj->getId()}" class="comment_author" value="{$obj->getName()}"/>
				<div class="clear_left"></div>
				</p>
				<p><label>{$vsLang->getWords('global_text_email', 'Email')}</label><input type="text" name="commentEmail_{$obj->getId()}" id="commentEmail_{$obj->getId()}" class="comment_email" value="{$obj->getEmail()}"/>
				<div class="clear_left"></div>
				</p>
				<p><label>{$vsLang->getWords('global_text_content', 'Content')}</label><textarea id="commentContent_{$obj->getId()}" name="commentContent_{$obj->getId()}" class="comment_content">{$obj->getContent()}</textarea></p>
			</div>
		</div>
		<div class="clear"></div>
		
		<script>
			$(document).ready(function() {
				vsf.jRadio('{$obj->getStatus()}','ra_comment_{$obj->getId()}');
			});
		</script>
EOF;
return $BWHTML;
	}
        
        
	function formPopup($option){
		$count = count($option['list']);
		$BWHTML .= <<<EOF
		<form method="POST" name="form_update_comment" id="form_update_comment">
						<input type="hidden" name="strIds" value="{$option['strIds']}" />
						<input type="hidden" name="objectId" value="{$option['objectId']}" />
						<input type="hidden" name="tableName" value="{$option['tableName']}" />
							<if="$count">
						<foreach="$option['list'] as $obj">
							<input type="hidden" name="id_action" value="" />
							{$this->displayCommentPopup($obj)}
						</foreach>
						</if>
					</form>
EOF;
return $BWHTML;					
		
	}
	
	function managerObjHtml() {
		global $bw, $vsLang, $vsSettings;
		$BWHTML = "";
		$BWHTML .= <<<EOF
<div id="page_tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all-top">
	<ul id="tabs_nav" class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all-inner">
    	<li class="ui-state-default ui-corner-top">
        	<a href="{$bw->base_url}{$bw->input[0]}/display_obj_tab_comments/{$bw->input[1]}/{$bw->input[2]}//&ajax=1">{$vsLang->getWords('tab_module_comments','comments')}</a></li>
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

	
	function addEditObjFormComments($obj, $option = array()) {
		global $vsLang, $bw, $vsSettings;
	
		$BWHTML .= <<<EOF
			<div id="error-message" name="error-message"></div>
			<form id='obj_form_comments' name="add-edit-obj-form" method="POST"  enctype='multipart/form-data'>
				<input type="hidden" name="userId" value="{$obj->getId()}" />
				<input type="hidden" name="group" id="group" value="" />
				<div class='ui-dialog ui-widget ui-widget-content ui-corner-all'>
					<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
						<span class="ui-dialog-title">{$vsLang->getWords('add_edit_comments',"Add edit comments")}</span>
						<span class="ui-dialog-title close_text" style="float:right;">
							<a href="javascript:vsf.get('{$bw->input[0]}/display_obj_tab_comments/','obj_panel_comments')" title="{$vsLang->getWords('close',"close")}" style='color: #FFF;'>
								{$vsLang->getWords('global_obj_back', "close")}
							</a>
						</span>
					</div>
					<table class="ui-dialog-content ui-widget-content">
					
			
			
			<tr>
					<if="$vsSettings->getSystemKey($bw->input[0].'_title',1)">
						<td class="label_obj">{$vsLang->getWords('comments_title_name', 'title')}:</td>
						<td colspan="2"><input size="25" type="text" name="comments[title]" value="{$obj->getTitle()}" id="comments_obj_title"/></td>
					</if>
			</tr>
			<tr>
					<if="$vsSettings->getSystemKey($bw->input[0].'_name',1)">
						<td class="label_obj">{$vsLang->getWords('comments_name', 'Tên người gửi')}:</td>
						<td colspan="2">
						<input type="text" name="comments[name]" value="{$obj->getName()}" size='53'/>
						</td>
					</if>
			</tr>
			<tr>
					<if="$vsSettings->getSystemKey($bw->input[0].'_email',1)">
						<td class="label_obj">{$vsLang->getWords('comments_email', 'Email')}:</td>
						<td colspan="2">
						<input type="text" name="comments[email]" value="{$obj->getEmail()}" size='53'/>
						</td>
					</if>
			</tr>
			<if="$vsSettings->getSystemKey($bw->input[0].'_image',1)">
			<tr>
					
						<td class="label_obj">{$vsLang->getWords('comments_image_name', 'image')}:</td>
						<td colspan="2"><input size="25" type="file" name="file_image"  id="file_image"/></td>
					</if>
			</tr>
				<if="$obj->getImage()">
					<tr>
								<td class="label_obj"></td>
								<td colspan="2">
					{$obj->createImageCache($obj->getImage(),100,100)}
								</td>
					</tr>
				</if>
			</if>
			
					<php>
					global $vsStd;
					$vsStd->requireFile(JAVASCRIPT_PATH."/tiny_mce/tinyMCE.php");
					$editor = new tinyMCE();
					$editor->setWidth('100%');
					$editor->setHeight('150px');
					$editor->setToolbar('narrow');
					$editor->setTheme("advanced");
					$editor->setInstanceName('comments[content]');
					$editor->setValue($obj->getContent());
					$valueForHtml=$editor->createHtml();
					</php>
			<tr>
					<if="$vsSettings->getSystemKey($bw->input[0].'_content',1)">
					
						<td class="label_obj">{$vsLang->getWords('comments_content_name', 'content')}:</td>
						<td colspan="2">{$valueForHtml}</td>
					</if>
			</tr>
			
			<tr>
					<if="$vsSettings->getSystemKey($bw->input[0].'_status',1)">
						<td class="label_obj">{$vsLang->getWords('comments_status_name', 'status')}:</td>
						<td colspan="2">
							<label><input size="25" type="radio" name="cstatus" value="0" />{$vsLang->getWords('unapprove_obj_bt','unapprove')} </label>
							<label><input size="25" type="radio" name="cstatus" value="1" />{$vsLang->getWords('approve_obj_bt','approve')} </label>
						</td>
					</if>
			</tr>
			
					<input type="hidden" value="{$obj->getId()}" name="comments[id]"/>
						
						<tr>
							<td class="ui-dialog-buttonpanel" colspan="4" align="center">
								<input type="submit" name="submit" value="<if="$obj->getId()">{$vsLang->getWords('edit',"Edit")}<else />{$vsLang->getWords('add',"Add")}</if>" />
								<input type="button" id='closeForm' value='{$vsLang->getWords('global_close_form', 'Back')}' />
							</td>
						</tr>
					</table>
				</div>
			</form>
			
			<script language="javascript">
				$('#closeForm').click(function(){
					vsf.get('{$bw->input[0]}/display_obj_tab_comments/','obj_panel_comments')
				});
				$(document).ready(function(){
					vsf.jSelect('{$obj->getStatus()}', 'cstatus');
				});
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
					vsf.get('{$bw->input[0]}/display-obj-list/'+categoryId+'/','obj_panel_comments');
				}
				function alertError(message){
					jAlert(
						message,
						'{$bw->vars['global_websitename']} Dialog'
					);
				}
				$(window).ready(function() {
					vsf.jRadio('{}','userGender');
					vsf.jRadio({$obj->getStatus()},'cstatus');
					vsf.jCheckbox('{}','userDealer');
					<if="count($option['cur_groups'])">
						<foreach="$option['cur_groups'] as $key=>$group">
						vsf.jCheckbox('{$key}',"group{$key}");
						</foreach>
					</if>
					
				});
				$('#obj_form_comments').submit(function(){
					var flag  = true;
					var error = "";
					var categoryId;
					var count=0;
					$("#obj-category option:selected").each(function () {
						categoryId = $(this).val();
						count=1;
					});
					
					$('#obj-cat-id').val(categoryId);
					
					if(!flag){
						error = "<ul class='ul-popu'>" + error + "</ul>";
						alertError(error);
						return false;
					}
					checkObject();
					vsf.uploadFile("obj_form_comments", "{$bw->input[0]}", "add_obj_form_comments", "obj_panel_comments","comments");
					return false;
				});
				
			</script>
EOF;
		
	}
	
	
	

	function objListHtmlComments($option) {
		global $vsLang, $bw, $vsSettings;
		$BWHTML = "";
		$count = 0;
		
$BWHTML .= <<<EOF
<script type='text/javascript'>
	function checkObject() {
		var checkedString = '';
		$("input[class=myCheckbox]").each(function(){
			if(this.checked) checkedString += $(this).val()+',';
		});
		$('#checked-obj-comments').val(checkedString);
	}
	
	$('#hide-objlist-bt-comments').click(function() {
		if($('#checked-obj-comments').val()=='') {
			jAlert(
				"{$vsLang->getWords('visible_obj_confirm_hide', "You haven't choose any items to hide!")}",
				"{$bw->vars['global_websitename']} Dialog"
			);
			return false;
		}
		vsf.submitForm($('#obj_list_form_comments'),'{$bw->input[0]}/hide_checked_obj_comments/','obj_panel_comments');
	});
	
	$('#visible-objlist-bt-comments').click(function() {
		if($('#checked-obj-comments').val()=='') {
			jAlert(
				"{$vsLang->getWords('visible_obj_confirm_noitem', "You haven't choose any items to visible!")}",
				"{$bw->vars['global_websitename']} Dialog"
			);
			return false;
		}
		vsf.submitForm($('#obj_list_form_comments'),'{$bw->input[0]}/visible_checked_obj_comments/','obj_panel_comments');
	});
	$('#approve-objlist-bt-comments').click(function() {
		if($('#checked-obj-comments').val()=='') {
			jAlert(
				"{$vsLang->getWords('visible_obj_confirm_noitem', "You haven't choose any items to visible!")}",
				"{$bw->vars['global_websitename']} Dialog"
			);
			return false;
		}
		vsf.submitForm($('#obj_list_form_comments'),'{$bw->input[0]}/approve_checked_obj_comments/','obj_panel_comments');
	});
	$('#unapprove-objlist-bt-comments').click(function() {
		if($('#checked-obj-comments').val()=='') {
			jAlert(
				"{$vsLang->getWords('visible_obj_confirm_noitem', "You haven't choose any items to visible!")}",
				"{$bw->vars['global_websitename']} Dialog"
			);
			return false;
		}
		vsf.submitForm($('#obj_list_form_comments'),'{$bw->input[0]}/unapprove_checked_obj_comments/','obj_panel_comments');
	});	
	$('#delete-objlist-bt_comments').click(function() {
		if($('#checked-obj-comments').val()=='') {
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
					vsf.submitForm($('#obj_list_form_comments'),'{$bw->input[0]}/delete_checked_obj_comments/','obj_panel_comments');
					//vsf.get('{$bw->input[0]}/add-obj-form/','obj_panel_comments');
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
		$('#checked-obj-comments').val(checkedString);
	}
	function checkObjectU() {
		var checkedString = '';
		$("input[type=checkbox]").each(function(){
			if($(this).hasClass('myCheckboxU')){
				if(this.checked) checkedString += $(this).val()+',';
			}
		});
		checkedString = checkedString.substr(0,checkedString.lastIndexOf(','));
		$('#checked-obj-comments').val(checkedString);
	}
	function deleteObj(id){
		$('#checked-obj-comments').val(id);
		$('#delete-objlist-bt_comments').click();
	}
	<if="$option['error']">
		jAlert(
						'{$option['error']}',
						'{$bw->vars['global_websitename']} Dialog'
					);
	</if>
</script>
<div id="obj_panel_comments">
<div class="ui-dialog ui-widget ui-widget-content ui-corner-all">
		<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
			<span class="ui-dialog-title">{$vsLang->getWords('comments_list','Danh sách phản hồi')}</span>
		</div>
		<form id="obj_list_form_comments">
<div style="padding: 0pt 10px; background:#ccc;">
<h3 style="display: block; float: left; width: 80px; line-height: 28px;">Tìm kiếm:</h3>
		<label>Nhóm:
		<select name="comments[group]" id="sl_group_comm">
		<foreach="$option['module_list'] as $index=> $group">
			<option <if="$index==$option['module']">selected='selected'</if> value="$index">{$vsLang->getWords("group_$group", $group)}</option>
		</foreach>
		</select>
		</label>
		<input name="comments[objId]" id="comments_obj_id" type="hidden" value="{$option['objId']}" />
		
		<script>
//		$("#sl_group_comm").change(function(){
//		vsf.get('comments/display_obj_tab_comments/'+$("#sl_group_comm").val()+"/"+$("#comments_obj_id").val()+"/"+$("#sl_status_comm").val()+'/2.vsf','obj_panel_comments');
		});
		</script>
		<label>
		Trạng thái:
		<select name="comments[status]" id="sl_status_comm">
			<option selected='selected' value="all">Tất cả</option>
			<option value="0">{$vsLang->getWords('unapprove_obj_bt','unapprove')}</option>
			<option value="1">{$vsLang->getWords('approve_obj_bt','approve')}</option>
		</select>
		</label>
                        <a class="ui-state-default ui-corner-all ui-state-focus" id="search_coment" style="float: right; margin-right: 442px; line-height: 20px;margin-top:5px" title="Click here to search this content!">Tìm kiếm</a>
		<script>
		$(document).ready(function(){
			vsf.jSelect('{$option['status']}', 'sl_status_comm');
		});
		
		$(document).ready(function(){
			vsf.jSelect('{$option['status']}', 'sl_status_comm');
			vsf.jSelect('{$bw->input[2]}', 'sl_group_comm');
			vsf.jSelect('{$bw->input[3]}', 'comments_obj_id');
		});
		$('#search_coment').click(function(){
                 			vsf.get('comments/display_obj_tab_comments/'+$("#sl_group_comm").val()+"/"+$("#comments_obj_id").val()+"/"+$("#sl_status_comm").val()+'/2.vsf','obj_panel_comments');      
                        });
//		$("#sl_status_comm").change(function(){
//			vsf.get('comments/display_obj_tab_comments/'+$("#sl_group_comm").val()+"/"+$("#comments_obj_id").val()+"/"+$("#sl_status_comm").val()+'/2.vsf','obj_panel_comments');
//		});
		</script>
</div>
	<input type="hidden" name="checkedObj" id="checked-obj-comments" value="" />
	<div class="ui-dialog ui-widget ui-widget-content ui-corner-all" style="margin-right:3px;">
		<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-corner-all-inner ui-widget-header">
	        <!--
	        <li class="ui-state-default ui-corner-top" id="add-objlist-bt-comments">
	        	<a href="javascript:vsf.get('{$bw->input[0]}/edit_obj_form_comments/','obj_panel_comments')" title="{$vsLang->getWords('hide_obj_alt_bt',"Hide selected {$bw->input[0]}")}">
					{$vsLang->getWords('add_obj_bt','Add')}
				</a>
			</li>
	        <li class="ui-state-default ui-corner-top" id="visible-objlist-bt-comments">
	        	<a href="#" title="{$vsLang->getWords('trash_obj_alt_bt',"Visible selected {$bw->input[0]} ")}">
					{$vsLang->getWords('trash_obj_bt','Trash')}
				</a>
			</li>
			-->
			<li class="ui-state-default ui-corner-top" id="approve-objlist-bt-comments">
				<a href="#" title="{$vsLang->getWords('approve_obj_alt_bt',"approve selected {$bw->input[0]} ")}">
					{$vsLang->getWords('approve_obj_bt','approve')}
				</a>
			</li>
			<li class="ui-state-default ui-corner-top" id="unapprove-objlist-bt-comments">
				<a href="#" title="{$vsLang->getWords('unapprove_obj_alt_bt',"approve selected {$bw->input[0]} ")}">
					{$vsLang->getWords('unapprove_obj_bt','unapprove')}
				</a>
			</li>
	        <li class="ui-state-default ui-corner-top" id="delete-objlist-bt_comments">
	        	<a href="#" title="{$vsLang->getWords('delete_obj_alt_bt',"Delete selected {$bw->input[0]}")}">
					{$vsLang->getWords('delete_obj_bt','Delete')}
				</a>
			</li>
	    </ul>
		<table  cellpadding="1" cellspacing="1" style="width:100%">
			<thead>
			<tr>
				<th width='10'>	<input type="checkbox" onclick="checkAllU()" onclicktext="checkAllU()" name="allU" /></th>
				<th width=''>{$vsLang->getWords('comments_status_head_text',"Status")}</th>
				<th width=''>{$vsLang->getWords('comments_title_head_text',"title")}</th>
				<th width='150'>{$vsLang->getWords('comments_name_head_text',"Người gửi")}</th>
				<th width='70'>{$vsLang->getWords('comments_detail_head_text',"Chi tiết")}</th>
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
                       	$intro=VSFTextCode::cutString(strip_tags($obj->getContent()),50);
           			</php>     
			    	
           			
           			
           			<tr class='$class'>
						<td width='10'>
							<input type="checkbox" onclicktext="checkObjectU({$obj->getId()});" onclick="checkObjectU({$obj->getId()});" name="obj_{$obj->getId()}" value="{$obj->getId()}" class="myCheckboxU" />
						</td>
						<td width='10' align='center'>
							{$obj->getStatus('image')}
						</td>
						<td>
							<a href="javascript:vsf.get('{$bw->input[0]}/edit_obj_form_comments/{$obj->getId()}/','obj_panel_comments')" title='{$vsLang->getWords('newsItem_EditObjTitle',"Click here to edit this {$bw->input[0]}")}'>
                       			{$intro}{$obj->getTitle()}
                            </a>
						</td>
						<td>
							{$obj->getName()}
						</td>
						<td>
							<a href="{$bw->vars['board_url']}/{$obj->getModule()}/detail/{$obj->getObjId()}/" target="_blank;" title='{$vsLang->getWords('comments_viewdetail',"Click here to view detail")}' class='ui-state-default ui-corner-all ui-state-focus'>
								{$vsLang->getWords('detail','Chi tiết')}
							</a>
						</td>
</tr>
           			
           			
           			
				</foreach>
				<tr>
					<td colspan='5' align='right'>	{$option['paging']}</td>
				</tr>
				</if>
			</tbody>
		</table>
	</div>
</form>
</div>
</div>
EOF;
		
		return $BWHTML;
	}
	
	
	
	

}
?>