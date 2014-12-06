<?php
class skin_vlanguages  extends skin_objectadmin {
function getListItemTable($objItems=array(),$option=array()){
		    global $bw;
		   
		$BWHTML .= <<<EOF
		
		
		<input type="hidden" name="catId" value="{$bw->input['catId']}"/>
		<input type="hidden" name="pageIndex" value="{$bw->input['pageIndex']}"/>
		<table class="obj_list">
		<thead>
			<tr>
				<th class="cb"><input type="checkbox" onClick="checkAllClick()" class="check_alll" name=""/></th>
				<th class="id">{$this->getLang()->getWords("id")}</th>
				<th class="title">{$this->getLang()->getWords("name", 'name')}</th>
				<th class="title">{$this->getLang()->getWords("admindefault", 'admin default')}</th>
				<th class="title">{$this->getLang()->getWords("userdefault", 'user default')}</th>
				<th class="status">{$this->getLang()->getWords("status")}</th>

				<th class="action">{$this->getLang()->getWords("action")}</th>
			</tr>
		</thead>
		<tbody>
		<if="is_array($objItems)">
		<foreach="$objItems as $item">
			<tr class="$vsf_class">
				<td><input onClick="checkRow()" class="btn_checkbox" value="{$item->getId()}" type="checkbox" /></td>
				<td>{$item->getId()}</td>
				<td>{$item->getName()}</td>
				<td class="status"><img src="{$bw->vars['img_url']}/status_{$item->getAdmindefault()}.png"/></td>
				<td class="status"><img src="{$bw->vars['img_url']}/status_{$item->getUserdefault()}.png"/></td>
				<td class="status"><img src="{$bw->vars['img_url']}/status_{$item->getStatus()}.png"/></td>
				<td class="action">
				{$this->addOtionList($item)}
				</td>
			</tr>
		</foreach>
		</if>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="10">{$option['paging']}</th>
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

function addEditObjForm($obj, $option = array()) {
		global $bw;
		$BWHTML .= <<<EOF
		<div class="vs_panel" id="vs_panel_{$this->modelName}">
		<div class="ui-dialog">
<div >
<span class="ui-dialog-title">{$this->getLang()->getWords('add_edit_'.$bw->input[0].'_'.$this->modelName,'Add edit '.$this->modelName)}</span>

<a href="#" class="ui-dialog-titlebar-close ui-corner-all frm_close" role="button" id="frm_close">{$this->getLang()->getWords('close')}</a>
</div>

		<form class="frm_add_edit_obj" id="frm_add_edit_obj"  method="POST" enctype='multipart/form-data'>
		<input type="hidden" value="{$bw->input['vdata']}" name="vdata"/>
		<input type="hidden" value="{$bw->input['pageIndex']}" name="pageIndex"/>
		<input type="hidden" value="{$obj->getId()}" name="{$this->modelName}[id]"/>
			<table class="obj_add_edit">
				<tbody>
				<tr>
					<td style="width: 111px;"><label>{$this->getLang()->getWords('name', 'name')}</label></td>
					<td>
					<input name="{$this->modelName}[name]" id="{$this->modelName}_name" type="textbox" value="{$obj->getName()}" style='width:100%' />
					</td>
				</tr>
				<tr>
					<td style="width: 111px;"><label>{$this->getLang()->getWords('code', 'code')}</label></td>
					<td>
					<input name="{$this->modelName}[code]" id="{$this->modelName}_code" type="textbox" value="{$obj->getCode()}" style='width:100%' />
					</td>
				</tr>
				<tr>
					<td style="width: 121px;"><label>{$this->getLang()->getWords('status')}</label></td>
					<td>
					<label>
						<input <if="$obj->getStatus()=='0'">checked='checked'</if>  name="{$this->modelName}[status]" id="{$this->modelName}_status_0" type="radio" value="0"  />
						<img title="{$this->getLang()->getWords('hide')}" src="{$bw->vars['img_url']}/status_0.png"/>
					</label>
					<label>
						<input <if="$obj->getStatus()==1||$obj->getStatus()==null">checked='checked'</if>  name="{$this->modelName}[status]" id="{$this->modelName}_status_1" type="radio" value="1"  />
						<img title="{$this->getLang()->getWords('visible')}" src="{$bw->vars['img_url']}/status_1.png"/>
					</label>
				</tr>
				<tr>
					<td style="width: 121px;"><label>{$this->getLang()->getWords('admindefault', 'Admin Default')}</label></td>
					<td>
					<label>
						<input <if="$obj->getAdmindefault()=='0'">checked='checked'</if>  name="{$this->modelName}[adminDefault]" id="{$this->modelName}_admindefault_0" type="radio" value="0"  />
						<img title="{$this->getLang()->getWords('hide')}" src="{$bw->vars['img_url']}/status_0.png"/>
					</label>
					<label>
						<input <if="$obj->getAdmindefault()==1||$obj->getAdmindefault()==null">checked='checked'</if>  name="{$this->modelName}[adminDefault]" id="{$this->modelName}_admindefault_1" type="radio" value="1"  />
						<img title="{$this->getLang()->getWords('visible')}" src="{$bw->vars['img_url']}/status_1.png"/>
					</label>
				</tr>
				<tr>
					<td style="width: 121px;"><label>{$this->getLang()->getWords('userdefault', 'User Default')}</label></td>
					<td>
					<label>
						<input <if="$obj->getUserdefault()=='0'">checked='checked'</if>  name="{$this->modelName}[userDefault]" id="{$this->modelName}_userdefault_0" type="radio" value="0"  />
						<img title="{$this->getLang()->getWords('hide')}" src="{$bw->vars['img_url']}/status_0.png"/>
					</label>
					<label>
						<input <if="$obj->getUserdefault()==1||$obj->getUserdefault()==null">checked='checked'</if>  name="{$this->modelName}[userDefault]" id="{$this->modelName}_userdefault_1" type="radio" value="1"  />
						<img title="{$this->getLang()->getWords('visible')}" src="{$bw->vars['img_url']}/status_1.png"/>
					</label>
				</tr>
				
				<tr>
				<td></td>
				<td>
				<center>
				<input type="submit" value="{$this->getLang()->getWords('accept')}" class="btnOk"/>
				<input type="button" id="frm_close" value="{$this->getLang()->getWords("Cancel")}" class="btnCancel frm_close"/>
				</center>
				</td>
				</tr>
				</tbody>
			</table>
		</form>
		</div>
		<script>
		$("#frm_add_edit_obj").submit(function(){
				var flag=false;
				var message="";
				if($("#{$this->modelName}_name").val().length<3){
					message+='{$this->getLang()->getWords('error_name')}{$this->DS}n';
					flag=true;
				}
				
				if(flag){
					jAlert(message);
					return false;
				}
				vsf.uploadFile("frm_add_edit_obj", "{$bw->input[0]}", "{$this->modelName}_add_edit_process", "vs_panel_{$this->modelName}","{$bw->input[0]}");
				return false;
		});
		$(".frm_close").click(function(){
			vsf.get('{$bw->input[0]}/{$this->modelName}_display_tab','vs_panel_{$this->modelName}',{vdata:'{$_REQUEST['vdata']}',pageIndex:'{$bw->input['pageIndex']}'});
			return false;
		});
		</script>
EOF;
	}

function objListHtml($option = array()) {
		global $bw;
		$BWHTML .= <<<EOF
		<div class="vs_panel" id="vs_panel_{$this->modelName}">
		<div class="ui-dialog">
<div >
<span class="ui-dialog-title">{$this->getLang()->getWords($this->modelName,$this->modelName)}</span>
</div>

		<form class="frm_obj_list" id="frm_obj_list">
		<div>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_add',1)">
				<input type="button" class="btnAdd" id="btn-add-obj" value="{$this->getLang()->getWords('action_add')}"/>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_delete',1)">
				<input type="button"  class="btnDelete" id="btn-delete-obj" value="{$this->getLang()->getWords('action_delete')}"/>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_disable',1)">
				<input type="button" class="btnDisable" id="btn-disable-obj" value="{$this->getLang()->getWords('action_hide')}"/>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_visible',1)">
				<input type="button" class="btnEnable" id="btn-enable-obj" value="{$this->getLang()->getWords('action_visible')}"/>
				</if>
				<!--btnAdd,btnEdit,btnDelete,btnReview,btnDisable,btnEnable,btnOk,btnSearch,btnIndexChange-->
		</div>
		<div id="{$this->modelName}_item_panel">
		{$option['table']}
		</div>
		<div class="more_action">
		<img width="38" height="22" alt="With selected:" src="{$bw->vars['img_url']}/arrow_ltr.png" class="selectallarrow">
		<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_category_list",0,$bw->input[0])">
			<label>Move selected to 
			<select name='toCatId'>
			{$this->model->getCategories()->getChildrenBoxOption()}
			</select>
			</label>
			<input type="button" class="btnOk" name="" onClick="changCate()"  value="go"/>
			<br>
		</if>
		<!--MORE_ACTION-->
		</div>
		</form>
		
		
		</div>
		<script>
			var objChecked=new Array();
			////////////////checked
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
			
			$("#vs_panel_{$this->modelName} #btn-add-obj").click(btnAdd_Click);
			
			
			function btnAdd_Click(){
				vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_add_edit_form/','vs_panel_{$this->modelName}');
			}
			function btnEditItem_Click(id){
					vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_add_edit_form/'+id,'vs_panel_{$this->modelName}');
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
			function changCate(){
				if(objChecked.length){
				vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_change_cate/'+objChecked,'vs_panel_{$this->modelName}');
				}else{
					jAlert("{$this->getLang()->getWords('error_none_select')}");
				}
				return false;
			}
			//alert($("#frm_search").html());
			$("#vs_panel_{$this->modelName} #frm_search").submit(function(){
				vsf.submitForm($("#vs_panel_{$this->modelName} #frm_search"),'{$bw->input[0]}/{$this->modelName}_search','{$this->modelName}_item_panel');
				return false;
			});
		</script>
		</div>
EOF;
return $BWHTML;
	}
}
?>