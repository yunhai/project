<?php

class skin_contacts extends skin_objectadmin {


	function objListHtml($option = array()) {
		global $bw;
		$BWHTML .= <<<EOF
		<div class="vs_panel" id="vs_panel_{$this->modelName}">
		<div class="ui-dialog">
<div >
<span class="ui-dialog-title">{$this->getLang()->getWords($this->modelName,$this->modelName)}</span>
</div>
<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_search_form",1,$bw->input[0])">
<form class="frm_search" id="frm_search">
	<label>
		{$this->getLang()->getWords('id')}
		<input size="2" type="text"  name='search[id]' value="{$bw->input['search']['id']}"/>
	</label>
	<label>
		{$this->getLang()->getWords('title')}
		<input  name='search[title]' size="25" type="text" value="{$bw->input['search']['title']}"/>
	</label>
	
	
	
	<input class="btnSearch" type="submit" value="Search" />
</form>
</if>
		<form class="frm_obj_list" id="frm_obj_list">
		<div class="vs-button">
			{$this->addOption()}
		</div>
		<div id="{$this->modelName}_item_panel">
		{$option['table']}
		</div>
		
		</form>
		</div>
		<script>
			var objChecked=new Array();
			function checkAllClick(){
				var check=$("#vs_panel_{$this->modelName}  .check_alll").attr("checked");
				objChecked=new Array();
				$("#vs_panel_{$this->modelName} .btn_checkbox").each(function(){
					if(check){
						$(this).attr("checked","checked").change();
						objChecked.push($(this).val());
					}else{
						$(this).attr("checked","").change();
					}
				});
			}
			function checkRow(){
				objChecked=new Array();
				$(".btn_checkbox").each(function(){
					if($(this).attr("checked")){
						objChecked.push($(this).val());
						$(this).change();
					}
				});
			}
			$(".btn_checkbox").change(function(){
				if($(this).attr("checked")){
					$(this).parents("tr").addClass("marked");
				}else{
					$(this).parents("tr").removeClass("marked");
				}
				
			});
			////////////
			
			$("#vs_panel_{$this->modelName} #btn-delete-obj").click(function(){
				if(objChecked.length==0){
					alert("{$this->getLang()->getWords('error_none_select')}");
					return false;
				}
				jConfirm(
                     "{$this->getLang()->getWords('yesno_delete')}?",
                     "{$bw->vars['global_websitename']} Dialog",
                     function(r){
						if(r){
							vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_delete/'+objChecked,'vs_panel_{$this->modelName}');
						}
					 }
				);
				return false;
			});
			$("#vs_panel_{$this->modelName} #btn-disable-obj").click(function(){
				if(objChecked.length==0){
					alert("{$this->getLang()->getWords('error_none_select')}");
					return false;
				}
				vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_hide_checked/'+objChecked,'vs_panel_{$this->modelName}');
				return false;
			});
			$("#vs_panel_{$this->modelName} #btn-enable-obj").click(function(){
				if(objChecked.length==0){
					alert("{$this->getLang()->getWords('error_none_select')}");
					return false;
				}
				vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_visible_checked/'+objChecked,'vs_panel_{$this->modelName}');
				return false;
			});
			
			function btnReadItem_Click(id){
					vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_read/'+id,'vs_panel_{$this->modelName}');
					return false;
			}
			function btnRemoveItem_Click(id){
				jConfirm(
                     "{$this->getLang()->getWords('yesno_delete')}?",
                     "{$bw->vars['global_websitename']} Dialog",
                     function(r){
						if(r){
							vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_delete/'+id,'vs_panel_{$this->modelName}');
						}
					 }
				);
					return false;
			}
			
		</script>
		</div>
EOF;
return $BWHTML;
	}
	
	function getListItemTable($objItems=array(),$option=array()){
		global $bw;
		
		$BWHTML .= <<<EOF
		
		<input type="hidden" name="catId" value="{$bw->input['catId']}"/>
		<input type="hidden" name="pageIndex" value="{$bw->input['pageIndex']}"/>
		<table class="obj_list">
		<thead>
			<tr>
				<th class="cb"><input type="checkbox" onClick="checkAllClick()" class="check_alll" name=""/></th>
				<th class="title">Họ tên</th>
				<th>Email</th>
				<th class="date">{$this->getLang()->getWords("date")}</th>
				<th class="action">{$this->getLang()->getWords("action")}</th>
			</tr>
		</thead>
		<tbody>
		<if="is_array($objItems)">
		<foreach="$objItems as $item">
			<tr class="$vsf_class">
				<td style="text-align: center;"><input onClick="checkRow()" class="btn_checkbox" value="{$item->getId()}" type="checkbox" /></td>
				<td> <a href="#" onClick="btnReadItem_Click({$item->getId()})">{$item->getTitle()}</a></td>
				<td>{$item->getEmail()}</td>
				<td>{$this->dateTimeFormat($item->getPostDate(),"d/m/Y")}</td>
				
				<td class="action">
				{$this->addOtionList($item)}
				</td>
			</tr>
		</foreach>
		</if>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="7">{$option['paging']}</th>
			</tr>
		</tfoot>
		</table>
		<if="$option['vdata']">
		<input type="hidden" value='{$option['vdata']}' name="vdata"/>
		</if>
		<script>
		<if="$option['message']">
		jAlert('{$option['message']}');
		</if>
		</script>
EOF;
	}

	function addOtionList($obj) {
           global  $bw;
            $BWHTML .= <<<EOF
            	
            	<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_delete',1)">
				<input value="Xóa" type="button" onClick="btnRemoveItem_Click({$obj->getId()})" class="btnDelete">
				</if>
				
EOF;
            return $BWHTML;
        }
        
        
    

	function readContact($contact, $contactProfile){
			global $bw;
			
			
			
		
			$BWHTML .= <<<EOF
				<div id='viewFormContainer' class='ui-dialog ui-widget ui-widget-content ui-corner-all'>
				    <div >
						<span class="ui-dialog-title">{$this->getLang()->getWords('contactReadTitle','Read Email')}: {$contact->getTitle()}</span>
				        	<p style="float:right; cursor:pointer;">
							<span class='ui-dialog-title' id='closeread'>
								{$this->getLang()->getWords('obj_back', 'Back')}
							</span>
						</p>
				        </a>
					</div>
					
					<table cellpadding="1" cellspacing="1" border="0" class="ui-dialog-content ui-widget-content" width="100%">
						<if=" $this->getSettings()->getSystemKey("contact_form_name", 1, "contacts", 0, 1)">
						
						</if>
						<tr class="smalltitle">
				        	<td class='left' width="100">Tiêu đề:</td>
				             <td>{$contact->getTitle()}</td>
						</tr>
						
						<tr class="smalltitle">
				        	<td class='left' width="100">{$this->getLang()->getWords('Email')}:</td>
				             <td>{$contact->getEmail()}</td>
						</tr>
						
						
						
						
				        <tr class="smalltitle">
				        	<td class='left' width="100">{$this->getLang()->getWords('contactTime','Thời gian')}:</td>
				            <td>{$this->dateTimeFormat($contact->getPostDate(),"d/m/Y")}</td>
						</tr>
				        <tr>
				        	<td valign="top" class="smalltitle">{$this->getLang()->getWords('contactMessage','Message')}:</td>
				            <td class="ui-dialog-buttonpanel smalltitle">
				            	<input id='replyButton' value="{$this->getLang()->getWords('contactReply','Reply')}" type="button" />
							</td>
						</tr>
				        <tr>
				        	<td colspan="2" valign="top" style='padding: 2px 0;'>
				            	<div style="background-color: #EBEEF7; padding: 5px;">
									{$contact->getContent()}
				               	</div>
							</td>
						</tr>
					</table>
					
				</div>

				<script type='text/javascript'>
					$('#closeread').click(function(){
						vsf.get('{$this->modelName}/{$this->modelName}_display_tab/{$bw->input[2]}', 'vs_panel_{$this->modelName}');
					});
				
					$('#replyButton').click(function(){
						vsf.get('contacts/{$this->modelName}_reply/{$contact->getId()}/&pageIndex={$bw->input[2]}', 'vs_panel_{$this->modelName}');
					});
				</script>
EOF;
			return $BWHTML;
		}

		
	function replyContactForm($obj, $option){
		global $bw;
		
			$this->prehtml = <<<EOF
				{$this->dateTimeFormat($obj->getPostDate(),"d/m/Y")} <strong>{$obj->getName()} <i>&lt;{$obj->getEmail()}&gt;</i></strong>:<br />
				<blockquote style="border-left: 2px solid rgb(16, 16, 255); margin: 0pt 0pt 0pt 0.8ex; padding-left: 1ex; background:#F4F4F4;">
		        	<b>{$this->getLang()->getWords('reply_from','From')}:</b>
					{$obj->getEmail()} <{$obj->getEmail()}> <br />
					<b>{$this->getLang()->getWords('reply_subject','Subject')}:</b> 
					{$obj->getTitle()}	<br />
		        	<b>{$this->getLang()->getWords('reply_to','To')}:</b> 
					{$this->getSettings()->getSystemKey ( "email_admin", "vuongnguyen0712@gmail.com", "configs" )}<br />
		        	<b>{$this->getLang()->getWords('content', 'Content')}:</b><br />
					{$obj->getContent()}
		        </blockquote><br/><br/>
EOF;
			
			$BWHTML .= <<<EOF
				<div class='ui-dialog ui-widget ui-widget-content ui-corner-all'>
					<form id="formReply" method="post">
						<input type="hidden" name="{$this->modelName}[isubmit]" value="reply"/>
						<input type="hidden" name="{$this->modelName}[email]" value="{$obj->getEmail()}"/>
						<input type="hidden" name="{$this->modelName}[name]"  value="{$obj->getName()}"/>
						<div >
							<span class="ui-dialog-title">
								{$this->getLang()->getWords('contactReplyFormTitle','Reply Email')}
							</span>
							
							
							<p style="float:right; cursor:pointer;">
							<span class='ui-dialog-title' id='buttonClose'>
								{$this->getLang()->getWords('obj_back', 'Back')}
							</span>
						</p>
						</div>
						<br />
						{$this->createEditor($this->prehtml, "{$this->modelName}[content]", "100%", "500px")}
					</form>
					<input id="reply" type="submit" class="btnOk" value="{$this->getLang()->getWords('contacts_replyForm_Send','Send Reply')}">
						
					</a>
					<div class="clear"></div>
				</div>

				<script type='text/javascript'>
					$('#buttonClose').click(function(){
						vsf.get('{$this->modelName}/{$this->modelName}_display_tab/{$bw->input['pageIndex']}', 'vs_panel_{$this->modelName}');
					});
				
					$('#reply').click(function(){
					
						vsf.submitForm($('#formReply'), 'contacts/{$this->modelName}_reply/{$obj->getId()}/&pageIndex={$bw->input['pageIndex']}', 'vs_panel_{$this->modelName}');
						return false;
					});
				</script>
EOF;
			return $BWHTML;
		}
}