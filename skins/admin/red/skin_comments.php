<?php
class skin_comments extends skin_objectadmin{
	
	
	
	function displayPanelCommentPopup($option){
		global $vsLang;
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
	
	function formPopup($option){
		$count = count($option['list']);
		$BWHTML .= <<<EOF
		<form method="POST" name="form_update_comment" id="form_update_comment">
		<input type="hidden" name="strIds" value="{$option['strIds']}" />
		<input type="hidden" name="objectId" value="{$option['objectId']}" />
		<input type="hidden" name="tableName" value="{$option['tableName']}" />
		<if="$count">
						<foreach="$option['list'] as $obj">
							{$this->displayCommentPopup($obj)}
						</foreach>
					</if>
					</form>
EOF;
return $BWHTML;					
		
	}
	function displayCommentPopup($obj){
		global $vsLang;
		
		$BWHTML .= <<<EOF
		<div id="commentPopup" class="comment_popup">
			<div class="comment_option">
				<p><label>{$vsLang->getWords('global_text_hide', 'Hide')}</label><input type='radio'  name='ra_comment_{$obj->getId()}' value='0'/></p>
				<p><label>{$vsLang->getWords('global_text_display', 'Display')}</label><input type='radio'  name='ra_comment_{$obj->getId()}' value='1'/></p>
				<p><label>{$vsLang->getWords('global_text_delete', 'Delete')}</label><input type='radio'  name='ra_comment_{$obj->getId()}' value='3'/></p>
			</div>
			<div id='comment_panel' name="comment_panel" class="comment_panel">
				<!--<p><label>{$vsLang->getWords('global_text_name', 'Name')}</label><input type="text" name="commentTitle_{$obj->getId()}" id="commentTitle_{$obj->getId()}" class="comment_title" value="{$obj->getTitle()}"/>-->
				<p><label>{$vsLang->getWords('global_text_name', 'Name')}</label><input type="text" name="commentAuthor_{$obj->getId()}" id="commentAuthor_{$obj->getId()}" class="comment_author" value="{$obj->getAuthor()}"/>
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
			$(window).ready(function() {
				vsf.jRadio('{$obj->getStatus()}','ra_comment_{$obj->getId()}');
			});
		</script>
EOF;
return $BWHTML;
	}
						
	
}
?>