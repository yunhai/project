<?php
class skin_admins extends skin_objectadmin {

	function getListItemTable($objItems = array(), $option = array()) {
		global $bw;
		$BWHTML .= <<<EOF
		<div class="ui-dialog">
		<div >
		<span class="ui-dialog-title">{$this->getLang()->getWords('admin_list_title','Danh sách tài khoản')}</span>
		</div>
		<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_search_form",1,$bw->input[0])">
		{$this->getSearchForm($option)}
		</if>
		<form class="frm_obj_list" id="frm_obj_list">
		<div class="vs-button">
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_add',1)">
				<input type="button" class="icon-wrapper icon-wrapper-vs btnAdd" id="btn-add-obj" title="{$this->getLang()->getWords('action_add','Thêm')}"/>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_delete',1)">
				<input type="button"  class="icon-wrapper icon-wrapper-vs btnDelete" id="btn-delete-obj" title="{$this->getLang()->getWords('action_delete','Xóa')}"/>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_disable',1)">
				<input type="button" class="icon-wrapper icon-wrapper-vs btnDisable" id="btn-disable-obj" title="{$this->getLang()->getWords('action_hide','Ẩn')}"/>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_visible',1)">
				<input type="button" class="icon-wrapper icon-wrapper-vs btnEnable" id="btn-enable-obj" title="{$this->getLang()->getWords('action_visible','Hiện')}"/>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_status_home",0,$bw->input[0])">
				<input type="button" class="icon-wrapper icon-wrapper-vs btnHome" id="btn-home-obj" title="{$this->getLang()->getWords('action_home','Trang chủ')}"/>
				</if>
		</div>
		<div id="{$this->modelName}_item_panel">
		
		<input type="hidden" name="catId" value="{$bw->input['catId']}"/>
		<input type="hidden" name="pageIndex" value="{$bw->input['pageIndex']}"/>
		<table class="obj_list">
		<thead>
			<tr>
				<th class="check-column" scope="col"><input type="checkbox" onClick="checkAllClick()" class="check_all" name=""/></th>
				<th class="id" scope="col">{$this->getLang()->getWords("id")}</th>
				<th class="title" scope="col">{$this->getLang()->getWords("admins_userName",'Tên đăng nhập')}</th>
				<th class="email" scope="col">{$this->getLang()->getWords("email")}</th>
				<th class="status" scope="col">{$this->getLang()->getWords("status","Trạng thái")}</th>
				<th class="date" scope="col">{$this->getLang()->getWords("lastLogin","Thời gian đăng nhập")}</th>
				<th class="action" scope="col">{$this->getLang()->getWords("action",'Thao tác')}</th>
			</tr>
		</thead>
		<tbody>
		<if="is_array($objItems)">
		<foreach="$objItems as $item">
		<if="!($item->getId()==10&&$this->getAdmin()->basicObject->getId()!=10)">
			<tr class="$vsf_class">
				<th class="check-column check_td" scope="row">
				<if="$this->getAdmin()->basicObject->getId()!=$item->getId()&&$item->getId()!=10">
				<input onClick="checkRow()" class="btn_checkbox" value="{$item->getId()}" type="checkbox" />
				</if>
				</th>
				<td>{$item->getId()}</td>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_name",1,$bw->input[0])">
					<td> <a onClick="btnEditItem_Click({$item->getId()},this);return false;" href="#">{$item->getTitle()}</a></td>
				</if>
				<td>{$item->getEmail()}</td>
				<td class="status">{$item->getStatus('image')}</td>
				<td><if="$item->getLastLogin()">{$this->dateTimeFormat($item->getLastLogin(),"h:i d/m/Y") }<else />{$this->getLang()->getWords('no_login','Chưa đăng nhập lần nào')}</if></td>
				<td class="action">
				{$this->addOtionList($item)}
				</td>
			</tr>
			</if>
		</foreach>
		</if>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="3">
					<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_add',1)">
					<input type="button" class="icon-wrapper icon-wrapper-vs btnAdd" id="btn-add-obj" title="{$this->getLang()->getWords('action_add')}"/>
					</if>
					<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_delete',1)">
					<input type="button"  class="icon-wrapper icon-wrapper-vs btnDelete" id="btn-delete-obj" title="{$this->getLang()->getWords('action_delete')}"/>
					</if>
					<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_disable',1)">
					<input type="button" class="icon-wrapper icon-wrapper-vs btnDisable" id="btn-disable-obj" title="{$this->getLang()->getWords('action_hide')}"/>
					</if>
					<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_visible',1)">
					<input type="button" class="icon-wrapper icon-wrapper-vs btnEnable" id="btn-enable-obj" title="{$this->getLang()->getWords('action_visible')}"/>
					</if>
					<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_status_home",0,$bw->input[0])">
					<input type="button" class="icon-wrapper icon-wrapper-vs btnHome" id="btn-home-obj" title="{$this->getLang()->getWords('action_home')}"/>
					</if>
				</th>
				<th colspan="10" class="pagination">{$option['paging']}</th>
			</tr>
		</tfoot>
		</table>
		<if="$option['vdata']">
		<input type="hidden" value='{$option['vdata']}' name="vdata"/>
		</if>
		<script>
			var objChecked=new Array();
			////////////////checked
			function checkAllClick(){
				var check=$("#vs_panel_{$this->modelName}  .check_all").attr("checked");
				objChecked=new Array();
				$("#vs_panel_{$this->modelName} .btn_checkbox").each(function(){
					if(check){
						$(this).attr("checked","checked").change();
						objChecked.push($(this).val());
					}else{
						$(this).removeAttr("checked").change();
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
					vsf.alert("{$this->getLang()->getWords('global_error_none_select','Vui lòng chọn một hay nhiều tin')}");
					return false;
				}
				jConfirm(
                     "{$this->getLang()->getWords('global_yesno_delete','Bạn có chắc chắn muốn xóa nó?')}?",
                     "Hộp thông báo",
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
					vsf.alert("{$this->getLang()->getWords('global_error_none_select','Vui lòng chọn một hay nhiều tin')}");
					return false;
				}
				vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_hide_checked/'+objChecked,'vs_panel_{$this->modelName}');
				return false;
			});
			$("#vs_panel_{$this->modelName} #btn-enable-obj").click(function(){
				if(objChecked.length==0){
					vsf.alert("{$this->getLang()->getWords('global_error_none_select','Vui lòng chọn một hay nhiều tin')}");
					return false;
				}
				vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_visible_checked/'+objChecked,'vs_panel_{$this->modelName}');
				return false;
			});
			$("#vs_panel_{$this->modelName} #btn-home-obj").click(function(){
				if(objChecked.length==0){
					vsf.alert("{$this->getLang()->getWords('global_error_none_select','Vui lòng chọn một hay nhiều tin')}");
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
			}
			function btnEditItem_Click(id,c){
					var hashbase=$(c).parents('.ui-tabs-panel').attr('id');
					window.location.hash=hashbase+"/{$bw->input[0]}/{$this->modelName}_add_edit_form/"+id+'&{$bw->input['back']}';
					return false;
			}
			function btnRemoveItem_Click(id){
				jConfirm(
                     "{$this->getLang()->getWords('global_yesno_delete','Bạn có chắc chắn muốn xóa nó?')}?",
                     "Hộp thông báo",
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
					vsf.alert("{$this->getLang()->getWords('global_error_none_select','Vui lòng chọn một hay nhiều tin')}");
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

	function addEditObjForm($obj, $option = array()) {
		global $bw;
		$BWHTML .= <<<EOF
		<div class="vs_panel" id="vs_panel_{$this->modelName}">
		<div class="ui-dialog">
<div >
<span class="ui-dialog-title">{$this->getLang()->getWords('add_edit_'.$bw->input[0].'_'.$this->modelName,'Add edit '.$this->modelName)}</span>
</div>
		<form class="frm_add_edit_obj" id="frm_add_edit_obj"  method="POST" enctype='multipart/form-data'>
		<input type="hidden" value="{$bw->input['vdata']}" name="vdata"/>
		<input type="hidden" value="{$bw->input['pageIndex']}" name="pageIndex"/>
		<input type="hidden" value="{$obj->getId()}" name="{$this->modelName}[id]"/>
			<table class="obj_add_edit">
				<tbody>
				<tr>
					<td style="width: 111px;"><label>{$this->getLang()->getWords('admins_userName')}</label></td>
					<td>
					<input  name="{$this->modelName}[title]" id="{$this->modelName}_title" type="text" value="{$obj->getTitle()}" />
					</td>
				</tr>
				<tr>
					<td><label>{$this->getLang()->getWords("admins_password",'Mật khẩu')}</label></td>
					<td>
					<input  name="{$this->modelName}[password]" id="{$this->modelName}_password" type="text" value="" />
					</td>
				</tr>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_status",1,$bw->input[0])">
				<tr>
					<td style="width: 121px;"><label>{$this->getLang()->getWords('status','Trạng thái')}</label></td>
					<td>
					<label>
						<input <if="$obj->getStatus()=='0'">checked='checked'</if>  name="{$this->modelName}[status]" id="{$this->modelName}_status_0" type="radio" value="0"  />
						{$this->getLang()->getWords('hide','Ẩn')}
					</label>
					<label>
						<input <if="$obj->getStatus()==1||$obj->getStatus()==null">checked='checked'</if>  name="{$this->modelName}[status]" id="{$this->modelName}_status_1" type="radio" value="1"  />
						{$this->getLang()->getWords('visible','Hiện')}
					</label>
					</td>
				</tr>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_index",1,$bw->input[0])">
				<tr>
					<td><label>{$this->getLang()->getWords("index",'Thứ tự')}</label></td>
					<td>
					<input  name="{$this->modelName}[index]" id="{$this->modelName}_index" type="text" value="{$obj->getIndex()}" />
					</td>
				</tr>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_image",1,$bw->input[0])">
				<tr>
					<td><label>{$this->getLang()->getWords('admin_image','Hình đại diện')}
							<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_image_size",'')">
							<br/>
							{$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_image_size",'')}
							</if>
						</label>
					</td>
					<td>
					<div style="float:left;width:300px">
						<label>
							<input name="filetype[image]" value="file" type="radio" checked='checked' obj="image-file"/>
							{$this->getLang()->getWords('upload','Tải lên từ máy')}:</label>
						<label>
							<input    type="file" value="" style='width:250px;'  id="image-file" name="image"/>
						</label>
						<br/>
						<label>
							<input name="filetype[image]"   value="link" type="radio" obj="image-link"/>
							{$this->getLang()->getWords('download_from','Tải về từ đường dẫn')}:
						</label>
						<label>
							<input disabled='disabled' type="text" value="" style='width:250px;' id="image-link" name="links[image]"/>
						</label>
					</div>
					<div style="float:left;width:200px">
					<if="$obj->getImage()">
					{$obj->createImageCache($obj->getImage(),100,90)}
					</if>
					</div>
					</td>
				</tr>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_email",1,$bw->input[0])">
				<tr>
					<td><label>{$this->getLang()->getWords("email")}</label></td>
					<td>
					<input  name="{$this->modelName}[email]" id="{$this->modelName}_email" type="text" value="{$obj->getEmail()}" />
					</td>
				</tr>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_address",1,$bw->input[0])">
				<tr>
					<td><label>{$this->getLang()->getWords("address",'Địa chỉ')}</label></td>
					<td>
					<input  name="{$this->modelName}[address]" id="{$this->modelName}_address" type="text" value="{$obj->getAddress()}" />
					</td>
				</tr>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_phone",1,$bw->input[0])">
				<tr>
					<td><label>{$this->getLang()->getWords("phone",'Điện thoại')}</label></td>
					<td>
					<input  name="{$this->modelName}[phone]" id="{$this->modelName}_phone" type="text" value="{$obj->getPhone()}" />
					</td>
				</tr>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_public_group",1,$bw->input[0])">
				<tr>
					<td colspan="2">
					<foreach="$option['groupList'] as $group">
					<if="$group->getId()==1 && $this->getAdmin()->basicObject->getId()!=10">
					
					<else />
						<label>
						<input <if="$option['groupped'][$group->getId()]">checked='checked'</if> type="checkbox" name="group[{$group->getId()}]" value="{$group->getId()}" />
						{$group->getTitle()}
					</label>
					</if>
					</foreach>
					</td>
				</tr>
				</if>
				
				<tr>
				<td class="vs-button" colspan="2">
					<button type="submit" ><span><img src="{$bw->vars['img_url']}/pixel-vfl3z5WfW.gif" class="icon-wrapper-vs vs-icon-accept"></span><span>{$this->getLang()->getWords('global_accept')}</span></button>
					<button type="button" id="frm_close" class="btnCancel frm_close"><span><img src="{$bw->vars['img_url']}/pixel-vfl3z5WfW.gif" class="icon-wrapper-vs vs-icon-cancel"></span><span>{$this->getLang()->getWords("global_cancel",'Đóng')}</span></button>
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
				if($("#{$this->modelName}_title").val().length<3){
					message+='{$this->getLang()->getWords('error_user_name','Tên đăng nhập phải nhiều hơn 3 ký tự')}{$this->DS}n';
					flag=true;
				}
				var filter = /^([a-zA-Z0-9_{$this->DS}.{$this->DS}-])+{$this->DS}@(([a-zA-Z0-9{$this->DS}-])+{$this->DS}.)+([a-zA-Z0-9]{2,4})+$/;
				if (!filter.test($("#{$this->modelName}_email").val())) {
					message+='{$this->getLang()->getWords('error_email','Địa chỉ email không chính xác!')}{$this->DS}n';
					flag=true;
				}
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_public_group",1,$bw->input[0])">
				
				
				</if>
				<if="!$obj->getId()">
				if($("#{$this->modelName}_password").val().length<6){
					message+='{$this->getLang()->getWords('error_password','Mật khẩu ít nhất 6 ký tự')}{$this->DS}n';
					flag=true;
				}
				</if>
				if(flag){
					jAlert(message);
					return false;
				}
				vsf.uploadFile("frm_add_edit_obj", "{$bw->input[0]}", "{$this->modelName}_add_edit_process", "vs_panel_{$this->modelName}","{$bw->input[0]}");
				return false;
		});
		$(".frm_close").click(function(){
			var hashbase=$(this).parents('.ui-tabs-panel').attr('id');
			window.location.hash=hashbase+"{$bw->input['back']}";
			return false;
		});
		////////*********************select file field*************************/
						$("input[type='radio']").change(function(){
							if($(this).val()=='link'||$(this).val()=='file'){
							
								$("input[name='"+this.name+"']").each(function(){
										if($(this).attr("checked")){
											$("#"+$(this).attr('obj')).removeAttr("disabled");
										}else{
											$("#"+$(this).attr('obj')).attr("disabled","disabled");
										}
								});
								
							}
						});
		</script>
		
EOF;
	}

	function addChangInfoForm($obj, $option = array()) {
		global $bw;
		$BWHTML .= <<<EOF
		<div class="vs_panel" id="vs_panel_chang_pass_{$this->modelName}">
		<div class="ui-dialog">
<div >
<span class="ui-dialog-title">{$this->getLang()->getWords('changpassword','Đổi mật khẩu')}</span>

</div>
		<form class="frm_add_edit_obj" id="frm_add_edit_obj"  method="POST" enctype='multipart/form-data'>
		<input type="hidden" value="{$bw->input['vdata']}" name="vdata"/>
		<input type="hidden" value="{$bw->input['pageIndex']}" name="pageIndex"/>
		<input type="hidden" value="{$obj->getId()}" name="{$this->modelName}[id]"/>
			<table class="obj_add_edit">
				<tbody>
				<tr>
					<td style="width: 111px;"><label>{$this->getLang()->getWords('admins_userName')}</label></td>
					<td>
					<input  readonly="readonly" id="{$this->modelName}_title" type="text" value="{$obj->getTitle()}" />
					</td>
				</tr>
				<tr>
					<td><label>{$this->getLang()->getWords("new_password","Mật khẩu mới")}</label></td>
					<td>
					<input  name="{$this->modelName}[password]" id="{$this->modelName}_password" type="password" value="" />
					</td>
				</tr>
				<tr>
					<td><label>{$this->getLang()->getWords("password_confirm",'Xác nhận mật khẩu')}</label></td>
					<td>
					<input  name="{$this->modelName}[password_confirm]" id="{$this->modelName}_password_confirm" type="password" value="" />
					</td>
				</tr>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_image",1,$bw->input[0])">
				<tr>
					<td><label>{$this->getLang()->getWords('image')}
							<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_image_size",'')">
							<br/>
							{$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_image_size",'')}
							</if>
						</label>
					</td>
					<td>
					<div style="float:left;width:300px">
						<label>
							<input name="filetype[image]" value="file" type="radio" checked='checked' obj="image-file"/>
							{$this->getLang()->getWords('upload')}:</label>
						<label>
							<input    type="file" value="" style='width:250px;'  id="image-file" name="image"/>
						</label>
						<br/>
						<label>
							<input name="filetype[image]"   value="link" type="radio" obj="image-link"/>
							{$this->getLang()->getWords('download_from')}:
						</label>
						<label>
							<input disabled='disabled' type="text" value="" style='width:250px;' id="image-link" name="links[image]"/>
						</label>
					</div>
					<div style="float:left;width:200px">
					<if="$obj->getImage()">
					{$obj->createImageCache($obj->getImage(),100,90)}
					</if>
					</div>
					</td>
				</tr>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_intro",1,$bw->input[0])">
				<tr>
					<td><label>{$this->getLang()->getWords('intro')}</label></td>
					<td>
					<textarea id="{$this->modelName}_intro" name="{$this->modelName}[intro]" style="width: 100%; height: 111px;">{$obj->getIntro()}</textarea>
					</td>
				</tr>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_content",1,$bw->input[0])">
				<tr>
					<td><label>{$this->getLang()->getWords('content')}</label></td>
					<td>
					{$this->createEditor($obj->getContent(), "{$this->modelName}[content]", "100%", "333px")}
					</td>
				</tr>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_email",1,$bw->input[0])">
				<tr>
					<td><label>{$this->getLang()->getWords("email")}</label></td>
					<td>
					<input  name="{$this->modelName}[email]" id="{$this->modelName}_email" type="text" value="{$obj->getEmail()}" />
					</td>
				</tr>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_address",1,$bw->input[0])">
				<tr>
					<td><label>{$this->getLang()->getWords("address")}</label></td>
					<td>
					<input  name="{$this->modelName}[address]" id="{$this->modelName}_address" type="text" value="{$obj->getAddress()}" />
					</td>
				</tr>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_phone",1,$bw->input[0])">
				<tr>
					<td><label>{$this->getLang()->getWords("phone")}</label></td>
					<td>
					<input  name="{$this->modelName}[phone]" id="{$this->modelName}_phone" type="text" value="{$obj->getPhone()}" />
					</td>
				</tr>
				</if>
				
				<tr>
				<td class="vs-button" colspan="2">
					<button type="submit" ><span><img src="{$bw->vars['img_url']}/pixel-vfl3z5WfW.gif" class="icon-wrapper-vs vs-icon-accept"></span><span>{$this->getLang()->getWords('global_accept','Lưu')}</span></button>
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
				var filter = /^([a-zA-Z0-9_{$this->DS}.{$this->DS}-])+{$this->DS}@(([a-zA-Z0-9{$this->DS}-])+{$this->DS}.)+([a-zA-Z0-9]{2,4})+$/;
				if (!filter.test($("#{$this->modelName}_email").val())) {
					message+='{$this->getLang()->getWords('error_email','email is not valid!')}{$this->DS}n';
					flag=true;
				}
				
				if($("#{$this->modelName}_password").val()!=$("#{$this->modelName}_password_confirm").val()){
					message+='{$this->getLang()->getWords('error_password_confirm','Password not valid')}{$this->DS}n';
					flag=true;
				}
				if($("#{$this->modelName}_password").val().length>0&&$("#{$this->modelName}_password").val().length<6){
					message+='{$this->getLang()->getWords('error_password','Password must be greater than 6 characters')}{$this->DS}n';
					flag=true;
				}
				if(flag){
					jAlert(message);
					return false;
				}
				vsf.uploadFile("frm_add_edit_obj", "{$bw->input[0]}", "{$this->modelName}_info_form_process", "vs_panel_chang_pass_{$this->modelName}","{$bw->input[0]}");
				return false;
		});
		$(".frm_close").click(function(){
			//vsf.get('{$bw->input[0]}/{$this->modelName}_display_tab&pageIndex={$bw->input['pageIndex']}&vdata={$_REQUEST['vdata']}','vs_panel_{$this->modelName}');
			//vsf.get('{$bw->input[0]}/{$this->modelName}_display_tab','vs_panel_chang_pass_{$this->modelName}',{vdata:'{$_REQUEST['vdata']}',pageIndex:'{$bw->input['pageIndex']}'});
			return false;
		});
		////////*********************select file field*************************/
						$("input[type='radio']").change(function(){
							if($(this).val()=='link'||$(this).val()=='file'){
							
								$("input[name='"+this.name+"']").each(function(){
										if($(this).attr("checked")){
											$("#"+$(this).attr('obj')).removeAttr("disabled");
										}else{
											$("#"+$(this).attr('obj')).attr("disabled","disabled");
										}
								});
								
							}
						});
		</script>
		
EOF;
	}

	function LoginForm($error = "") {
		global $bw;
		$this->vsLang = VSFactory::getLangs ();
		$vsSettings = VSFactory::getSettings ();
		$BWHTML = "";
		$BWHTML .= <<<EOF
<if="$bw->input['ajax']">
        <script>
        $(document).ready(function()
        {
            document.location.href='{$bw->vars['board_url']}/admin.php';
            });
        </script>
<else />
	<div id="header">
				
				
			</div>
	<div id="vsf_wrapper">
		<div class="uvn-login">
			<div class="login-form">
				<p class="title_light">{$this->vsLang->getWords('admins_title_system','Hệ thống')}</p>
				<h1 class="title_bold">{$this->vsLang->getWords('admins_title_system_manager','Quản trị website')}</h1>
				<form action="{$bw->base_url}admins/dologin/" method="post" id="frmlogin">
					<input type="text" name="adminName" id="adminName" placeholder="{$this->vsLang->getWords('admins_userName','Tên đăng nhập')}"/>
					<input id="adminPassword" name="adminPassword" type="password" placeholder="{$this->vsLang->getWords('admins_password','Mật khẩu')}"/>
					<div class="submit-cell">
					<a href="{$bw->base_url}admin/forget_password" >{$this->vsLang->getWords('admins_forget_password','Quên mật khẩu')}</a>
					<button class="log_me_in" type="submit">{$this->vsLang->getWords('admins_logInTitle','Login')}</button>
					<div class="clear"></div>
					</div>
				</form>
				<p class="system_error"></p>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div id="footer">
		<div id="footerWrap">
			
			
		</div>	
	</div>
	<style type="text/css">
.js-fix {
  position:absolute;
  top:52%;
  left:50%;
}
</style>
<script type="text/javascript">
jQuery(document).ready(function(){
	$(".uvn-login").each(function(){
	  //get height and width (unitless) and divide by 2
	  var hWide = ($(this).width())/2; //half the image's width
	  var hTall = ($(this).height())/2; //half the image's height, etc.

	  // attach negative and pixel for CSS rule
	  hWide = '-' + hWide + 'px';
	  hTall = '-' + hTall + 'px';

	  $(this).addClass("js-fix").css({
	    "margin-left" : hWide,
	    "margin-top" : hTall
	  });
	});	});
$("#adminPassword").keydown(function(e){
var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
if(e.keyCode==13)
	$('#frmlogin').submit()
})

$('#frmlogin').submit(function(){
	if(!$("#adminPassword").val()||!$("#adminName").val())
	{
		$('.system_error').css("display","block");
		$('.system_error').html('Tài khoản hoặc mật khẩu không được để trống.');
		return false;
	}
});
function setfocus(){
$("#adminName").focus();
var error = '{$error}';
if(error){
$('.system_error').html(error);
}
}

function detect_caps_lock(D){
D=(D?D:window.event);
var A=(D.which?D.which:(D.keyCode?D.keyCode:(D.charCode?D.charCode:0)));
var C=(D.shiftKey||(D.modifiers&&(D.modifiers&4)));
var B=(D.ctrlKey||(D.modifiers&&(D.modifiers&2)));
return(A>=65&&A<=90&&!C&&!B)||(A>=97&&A<=122&&C)
}
function caps_check(e){
var detected_on = detect_caps_lock(e);
if (!detected_on){
$('.system_error').css("display","");
}
if (detected_on){
$('.system_error').css("display","block");
$('.system_error').html('Mật mã phân biệt chữ HOA - chữ thường.');
}

}
setfocus();
document.getElementById('adminPassword').onkeypress = caps_check;
</script>
</if>
EOF;
		
		return $BWHTML;
	}
}
