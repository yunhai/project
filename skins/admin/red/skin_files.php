<?php

class skin_files extends skin_objectadmin {
function getListItemTable($objItems=array(),$option=array()){
		    global $bw;
		$BWHTML .= <<<EOF
		<div class="ui-dialog">
		<div >
		<span class="ui-dialog-title">{$this->getLang()->getWords($this->modelName,$this->modelName)}</span>
		</div>
		<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_search_form",1,$bw->input[0])">
		{$this->getSearchForm($option)}
		</if>
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
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_status_home",0,$bw->input[0])">
				<input type="button" class="btnHome" id="btn-home-obj" value="{$this->getLang()->getWords('action_home')}"/>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_index",1,$bw->input[0])">
				<input type="button" class="btnIndexChange" id="btn-index-change-obj" value="{$this->getLang()->getWords('action_index_change')}"/>
				</if>
				<!--btnAdd,btnEdit,btnDelete,btnReview,btnDisable,btnEnable,btnOk,btnSearch,btnIndexChange-->
		</div>
		<div id="{$this->modelName}_item_panel">
		
		<input type="hidden" name="catId" value="{$bw->input['catId']}"/>
		<input type="hidden" name="pageIndex" value="{$bw->input['pageIndex']}"/>
		<table class="obj_list">
		<thead>
			<tr>
				<th class="cb"><input type="checkbox" onClick="checkAllClick()" class="check_alll" name=""/></th>
				<th class="id">{$this->getLang()->getWords("id")}</th>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_image_field",1,$bw->input[0])">
					<th class="img">{$this->getLang()->getWords("image")}</th>
				</if>
				<th class="title">{$this->getLang()->getWords("title")}</th>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_category_list",0,$bw->input[0])">
					<th>{$this->getLang()->getWords("category")}</th>
				</if>
				<th class="status">{$this->getLang()->getWords("status")}</th>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_postdate",1,$bw->input[0])">
				<th class="date">{$this->getLang()->getWords("postdate")}</th>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_index",1,$bw->input[0])">
				<th class="index">{$this->getLang()->getWords("index")}</th>
				</if>
				<th class="action">{$this->getLang()->getWords("action")}</th>
			</tr>
		</thead>
		<tbody>
		<if="is_array($objItems)">
		<foreach="$objItems as $item">
			<tr class="$vsf_class">
				<td><input onClick="checkRow()" class="btn_checkbox" value="{$item->getId()}" type="checkbox" /></td>
				<td>{$item->getId()}</td>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_image_field",1,$bw->input[0])">
					<td> 
					<a onClick="btnEditItem_Click({$item->getId()},this);return false;" href="">
					{$item->createImageCache($item->getId(),100,50)}
					</a>
					</td>
				</if>
				<td><a onClick="btnEditItem_Click({$item->getId()},this);return false;" href="">{$item->getTitle()}</a></td>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_category_list",0,$bw->input[0])">
				<td>
				<if="$this->getMenu()->getCategoryById($item->getCatId())">
				{$this->getMenu()->getCategoryById($item->getCatId())->getTitle()}
				<else />
				{$this->getLang()->getWords("Uncategory")}
				</if>
				</td>
				</if>
				<td class="status"><img src="{$bw->vars['img_url']}/status_{$item->getStatus()}.png"/></td>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_postdate",1,$bw->input[0])">
				<td>{$this->dateTimeFormat($item->getPostDate(),"d/m/Y") }</td>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_index",1,$bw->input[0])">
				<td class="index"><input type="textbox" name="indexitem[{$item->getId()}]" value="{$item->getIndex()}"/></td>
				</if>
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
		<if="$option['vdata']">
		<input type="hidden" value='{$option['vdata']}' name="vdata"/>
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
			$("#vs_panel_{$this->modelName} #frm_obj_list").submit(function(){
				
			});
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
			$("#vs_panel_{$this->modelName} #btn-home-obj").click(function(){
				if(objChecked.length==0){
					alert("{$this->getLang()->getWords('error_none_select')}");
					return false;
				}
				vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_home_checked/'+objChecked,'vs_panel_{$this->modelName}');
				return false;
			});
			$("#vs_panel_{$this->modelName} #btn-index-change-obj").click(function(){
				vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_index_change/','vs_panel_{$this->modelName}');
				return false;
			});
			
			$("#vs_panel_{$this->modelName} #btn-add-obj").click(btnAdd_Click);
			
			
			function btnAdd_Click(){
				var hashbase=$(this).parents('.ui-tabs-panel').attr('id');
				window.location.hash=hashbase+"/{$bw->input[0]}/{$this->modelName}_add_edit_form/";
				///alert(window.location.hash);
				//vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_add_edit_form/','vs_panel_{$this->modelName}');
			}
			function btnEditItem_Click(id,c){
					var hashbase=$(c).parents('.ui-tabs-panel').attr('id');
					window.location.hash=hashbase+"/{$bw->input[0]}/{$this->modelName}_add_edit_form/"+id+'&{$bw->input['back']}';
					///vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_add_edit_form/'+id,'vs_panel_{$this->modelName}');
					//alert(hashbase);
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
		</script>
		
		
		<script>
		<if="$option['message']">
		jAlert('{$option['message']}');
		</if>
		</script>
EOF;
	}
}
