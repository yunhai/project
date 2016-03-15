<?php
class skin_advisorys extends skin_objectadmin{
	
	function replyadvisoryForm($option){
			global $vsLang,$langObject;
			$BWHTML .= <<<EOF
				<div class='ui-dialog ui-widget ui-widget-content ui-corner-all'>
					<form id="formReply" method="post">
						<input type="hidden" name="email" value="{$option['obj']->getEmail()}"/>
						<input type="hidden" name="name"  value="{$option['obj']->getName()}"/>
						<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
							<span class="ui-dialog-title">
								{$vsLang->getWords('advisoryReplyFormTitle','Reply Email')}
							</span>
					       	<span id="buttonSend" class="ui-dialog-title" style="float:right; margin-left: 10px; cursor: pointer;">
								{$vsLang->getWords('advisorys_replyForm_Send','Send Reply')}
							</span>
							
						</div>
						{$option['obj']->getIntro()}
					</form>
				</div>
				
				<script type='text/javascript'>					
					function sendReply(){
						$('#formReply').submit();
						$('#buttonClose').click();
					}
						
					$('#buttonSend').click(function(){
						$('#formReply').submit();
						$('#buttonClose').click();
					});
					
					$('#buttonClose').click(function(){
						$("#replyForm").html('');
					});

					$('#formReply').submit(function(){		
						vsf.submitForm($(this),'advisorys/replyProcess/{$option["obj"]->getId()}/{$option["obj"]->getType()}/','albumn-reply');
						return false;
					});
				</script>
EOF;
			return $BWHTML;
		}
	
	
	function addEditObjForm($objItem, $option = array()) {
		global $vsLang, $bw, $vsSettings,$langObject;

		$BWHTML .= <<<EOF
			<div id="error-message" name="error-message"></div>
			<form id='add-edit-obj-form' name="add-edit-obj-form" method="POST" enctype='multipart/form-data'>
				<input type="hidden" id="obj-cat-id" name="advisoryCatId" value="{$option['categoryId']}" />
				<input type="hidden" id="pageCate" name="pageCate" value="{$bw->input['pageCate']}" />
				<input type="hidden" id="pageIndex" name="pageIndex" value="{$bw->input['pageIndex']}" />
				<input type="hidden" name="advisoryId" value="{$objItem->getId()}" />
				
				<div class='ui-dialog ui-widget ui-widget-content ui-corner-all'>
					<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
						<span class="ui-dialog-title">{$option['formTitle']}</span>
						<span class="ui-dialog-title" id="closePageForm" style="float:right;margin-right:10px;cursor:pointer;">
                                                    {$langObject['itemObjBack']}
                                                </span>
					</div>
					<table class="ui-dialog-content ui-widget-content" style="width:100%;">
						<tr class='smalltitle'>
							<td class="submenu" style="float:left;width:67px">{$langObject['itemObjTitle']}:</td>
							<td colspan="3">
								<input name="advisoryTitle" value="{$objItem->getTitle()}" id="obj-title" style="width:100%"/>
							</td>
						</tr>
						<tr class='smalltitle'>
							<td class="submenu" style="width:67px;"> Email:</td>
							<td><input size="35" name="advisoryEmail" value="{$objItem->getEmail()}" id="obj-email"/></td>
							<if=" $vsSettings->getSystemKey($bw->input[0].'_address', 0) ">
							<td class="submenu" style="width:67px;"> {$langObject['itemObjAddress']}:</td>
							<td><input size="35" name="advisoryAddress" value="{$objItem->getAddress()}" id="obj-email"/></td>
							</if>
						</tr>
						
						<tr class='smalltitle'>
							<td class="submenu" style="width:30px;">{$vsLang->getWords('obj_Fullname', 'Fullname')}: </td>
							<td><input size="35" name="advisoryName" value="{$objItem->getName()}" /></td>
							<if=" $vsSettings->getSystemKey($bw->input[0].'_email_reply', 0) ">
							<td class="submenu">{$vsLang->getWords('obj_reply', 'Reply')}:</td>
							<td>
								<a href="javascript:vsf.popupGet('{$bw->input[0]}/reply/{$objItem->getId()}','albumn-reply',900,600)">
									{$vsLang->getWords('obj_reply', 'Reply')}
								</a>
							</td>
							</if>
							<if=" $vsSettings->getSystemKey($bw->input[0].'_phone', 0) ">
							<td class="submenu" style="width:67px;"> {$vsLang->getWords('obj_phone', 'Điện thoại')}:</td>
							<td class="submenu"><input size="35" name="advisoryPhone" value="{$objItem->getPhone()}" /></td>
							</if>
						</tr>
						<tr class='smalltitle'>
							<td class="submenu" style="width:30px;"> {$langObject['itemObjIndex']}:</td>
                       		<td><input class="numeric" size="15" name="advisoryIndex" value="{$objItem->getIndex()}" /></td>
						</tr>
						<tr class='smalltitle'>
							<td class="submenu">{$langObject['itemObjStatus']}:</td>
							<td>
                            	{$langObject['itemObjDisplay']}
							<input class='c_noneWi{dth' type="radio" name="advisoryStatus" id="advisoryStatus" checked value="1" style='margin-right:3px;'/>

							{$langObject['itemObjHide']}   		
							<input class='c_noneWidth' type="radio" name="advisoryStatus" id="advisoryStatus"  value="0" style='margin-right:3px;'/>
							
							<if="$vsSettings->getSystemKey("{$bw->input[0]}_home",0,$bw->input[0])">
                            	{$langObject['itemObjHome']}
                             	<input class='c_noneWidth' type="radio" name="advisoryStatus" id="advisoryStatus" checked value="2" style='margin-right:3px;'/>
                          	</if>
							</td>
						</tr>
                 		<if="$vsSettings->getSystemKey("{$bw->input[0]}_intro",1,$bw->input[0])">
						<tr class='smalltitle'>
							<td class="submenu" style="width:auto">
								{$vsLang->getWords('obj_Intro', 'Question')}:
							</td>
							<td colspan="3" valgin="center">
								{$objItem->getIntro()}
							</td>
						</tr>
                      	</if>
                   		<if="$vsSettings->getSystemKey("{$bw->input[0]}_content",1,$bw->input[0])">
						<tr class='smalltitle'>
							<td colspan="4" class="submenu" style="width:auto">
								{$vsLang->getWords('obj_Content', 'Answer')}:
							</td>
						</tr>
						<tr class='smalltitle'>
							<td colspan="4" align="center">{$objItem->getContent()}</td>
						</tr>
                                                </if>
						<tr class='smalltitle'>
							<td class="ui-dialog-buttonpanel" colspan="4" align="center">
								<input type="submit" name="submit" value="{$option['formSubmit']}" />
							</td>
						</tr>
					</table>
				</div>
			</form>
			<script language="javascript">
				$(window).ready(function() {
					$("input.numeric").numeric();
                                         $('#obj-category option').each(function(){
							$(this).removeAttr('selected');
						});
					vsf.jRadio('{$objItem->getStatus()}','advisoryStatus');
					vsf.jSelect('{$objItem->getCatId()}','obj-category');
                                       
				});
				$('#add-edit-obj-form').submit(function(){
					var flag  = true;
					var error = "";
					var categoryId = "";
					var count=0;
					
                                        $("#obj-category  option").each(function () {
						count++;
                                                if($(this).attr('selected'))categoryId = $(this).val();
					});

					$('#obj-cat-id').val(categoryId);

					if(categoryId == 0 && count>1){
						error = "<li>{$langObject['categoriesSelected']}</li>";
						flag  = false;
					}

					var title = $("#obj-title").val();
					if(title == 0 || title == ""){
						error += "<li>{$langObject['notItemObjTitle']}</li>";
						flag  = false;
					}

					if(!flag){
						error = "<ul class='ul-popu'>" + error + "</ul>";
						vsf.alert(error);
						return false;
					}
					vsf.uploadFile("add-edit-obj-form", "{$bw->input[0]}", "add-edit-obj-process", "obj-panel","advisorys");
					return false;
				});
				$('#closePageForm').click(function(){
					vsf.get('{$bw->input[0]}/display-obj-list/&pageIndex={$bw->input['pageIndex']}&pageCate={$bw->input['pageCate']}','obj-panel');
					return false;
				});
			</script>
EOF;
	}
	
}
?>