<?php

class skin_orders extends skin_objectadmin {

function getSearchForm($option=array()){
		    global $bw;
		    $token=base64_encode(time());
		$BWHTML .= <<<EOF
		<form class="frm_search" id="frm_search">
	<label>
		{$this->getLang()->getWords('id')}
		<input size="2" type="text"  name='search[id]' value="{$bw->input['search']['id']}"/>
	</label>
	<label>
		{$this->getLang()->getWords('title')}
		<input  name='search[title]' size="25" type="text" value="{$bw->input['search']['title']}"/>
	</label>
	<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_category_list",0,$bw->input[0])">
	<label>
		{$this->getLang()->getWords("category")}
		<select name='search[catId]'>
		<option value="-1">{$this->getLang()->getWords("All")}</option>
		{$this->model->getCategories()->getChildrenBoxOption($bw->input['search']['catId'])}
		</select>
	</label>
	</if>
	<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_status",1,$bw->input[0])">
	<label>
		{$this->getLang()->getWords('status')}
		<select name='search[status]'>
		<option <if="$bw->input['search']['status']==-1">selected='selected'</if> value="-1">{$this->getLang()->getWords('all')}</option>
		<option <if="$bw->input['search']['status']=='0'">selected='selected'</if> value="0">{$this->getLang()->getWords('order_status_0','Mới đặt')}</option>
		<option <if="$bw->input['search']['status']==1">selected='selected'</if> value="1">{$this->getLang()->getWords('order_status_1','Chấp nhận')}</option>
		<option <if="$bw->input['search']['status']==2">selected='selected'</if> value="2">{$this->getLang()->getWords('order_status_2','Đã giao')}</option>
		</select>
	</label>
	</if>
	<input type="hidden" value="$token" name="token"/>
	<input  class="btnSearch" type="submit" value="{$this->getLang()->getWords('Search')}"/>
</form>
<script>
//////////search...............
			//alert($("#frm_search").html());
			$("#vs_panel_{$this->modelName} #frm_search").submit(function(){
				//vsf.submitForm($("#vs_panel_{$this->modelName} #frm_search"),'{$bw->input[0]}/{$this->modelName}_search','{$this->modelName}_item_panel');
				var hashbase=$(this).parents('.ui-tabs-panel').attr('id');
				window.location.hash=hashbase+"/{$bw->input[0]}/{$this->modelName}_search/&"+$(this).serialize();
				return false;
			});

</script>
EOF;
return $BWHTML;
	}
function addEditObjForm($obj, $option = array()) {
		global $bw;
		
	
		
		$BWHTML .= <<<EOF
		<div class="vs_panel" id="vs_panel_{$this->modelName}">
		<div class="ui-dialog">
<div >
<span class="ui-dialog-title">{$this->getLang()->getWords('order_item_list','Danh sách hóa đơn')}</span>

<a href="#" class="ui-dialog-titlebar-close ui-corner-all frm_close" role="button" id="frm_close">{$this->getLang()->getWords('close')}</a>
</div>
		<form class="frm_add_edit_obj" id="frm_add_edit_obj"  method="POST" enctype='multipart/form-data'>
		<input type="hidden" value="{$bw->input['vdata']}" name="vdata"/>
		<input type="hidden" value="{$bw->input['pageIndex']}" name="pageIndex"/>
		<input type="hidden" value="{$obj->getId()}" name="{$this->modelName}[id]"/>
			<table class="obj_add_edit">
				<tbody>
				<tr>
					<td style="width: 111px;"><label>{$this->getLang()->getWords('title')}</label></td>
					<td>
					<input name="{$this->modelName}[title]" id="{$this->modelName}_title" type="textbox" value="{$obj->getTitle()}" style='width:100%;background:#E5EFFD' />
					</td>
				</tr>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_status",1,$bw->input[0])">
				<tr>
					<td style="width: 121px;"><label>{$this->getLang()->getWords('status')}</label></td>
					<td>
					<label>
						<input <if="$obj->getStatus()==-1">checked='checked'</if>  name="{$this->modelName}[status]" id="{$this->modelName}_status_-1" type="radio" value="-1"  />
						{$this->getLang()->getWords('order_status_-1','Hủy')}
					</label>
					<label>
						<input <if="$obj->getStatus()=='0'">checked='checked'</if>  name="{$this->modelName}[status]" id="{$this->modelName}_status_0" type="radio" value="0"  />
							{$this->getLang()->getWords('order_status_0','Mới đặt')}
					</label>
					<label>
						<input <if="$obj->getStatus()==1||$obj->getStatus()==null">checked='checked'</if>  name="{$this->modelName}[status]" id="{$this->modelName}_status_1" type="radio" value="1"  />
					{$this->getLang()->getWords('order_status_1','Chấp nhận')}
					</label>
					<label>
						<input  <if="$obj->getStatus()==2">checked='checked'</if>  name="{$this->modelName}[status]" id="{$this->modelName}_status_2" type="radio" value="2"  />
						{$this->getLang()->getWords('order_status_2','Đã giao')}
					</label>
					</td>
				</tr>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_code", 0, $bw->input[0])">
				<tr>
					<td><label>{$this->getLang()->getWords("code")}</label></td>
					<td>
					<input  name="{$this->modelName}[code]" id="{$this->modelName}_code" type="textbox" value="{$obj->getCode()}" />
					</td>
				</tr>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_intro",1,$bw->input[0])">
				<tr>
					<td><label>{$this->getLang()->getWords('order_intro','Thông tin thêm')}</label></td>
					<td>
					<textarea id="{$this->modelName}_intro" name="{$this->modelName}[intro]" style="width: 100%; height: 111px;" readonly>{$obj->getIntro()}</textarea>
					</td>
				</tr>
				</if>
				<tr>
					<td colspan="2">
					
						<table style="width:100%;">
							<tr>
							<th>
							Tên sản phẩm 
							</th>
							<th style="width: 59px;"> 
							Số lượng
							</th>
							<th style="width: 169px;"> 
							Đơn giá
							</th>
							<th style="width: 169px;"> 	
							Thành tiền
							</th>
							</tr>
							<foreach="$option['order_items'] as $item">
							<tr>
								<td style="text-align:center;">{$item->getTitle()}</td>
								<td style="text-align:center;">{$item->getQuantity()}</td>
								<td style="text-align:right;">{$this->numberFormat($item->getPrice(),0)} {$this->getLang()->getWords('currency','VNĐ')}</td>
								<td style="text-align:right;">{$this->numberFormat($item->total,0)} {$this->getLang()->getWords('currency','VNĐ')}</td>
							</tr>
							</foreach>
							<tr>
							<th colspan="3" style="text-align:right;">Tổng cộng</th>
							<th style="text-align:right;">{$this->numberFormat($option['total'],0)} {$this->getLang()->getWords('currency','VNĐ')}</th>
							</tr>
						</table>
					</td>
				</tr>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_content",1,$bw->input[0])">
				<tr>
					<td><label>{$this->getLang()->getWords('content')}</label></td>
					<td>
					{$this->createEditor($obj->getContent(), "{$this->modelName}[content]", "100%", "333px","full")}
					</td>
				</tr>
				</if>
				<tr>
				<td></td>
				<td>
				<center>
				<input type="submit" value="{$this->getLang()->getWords('accept')}" class="btnOk"/>
				<!--<input  value="In đơn hàng" type="button" class="btnOk" onclick="PrintSubject()"/>-->
				</center>
				</td>
				</tr>
				</tbody>
			</table>
		</form>
		
		
		</div>
		<script>
		function PrintSubject()
{
w=open("{$bw->base_url}orders/orders_display_tab/&q={$obj->getId()}", '_blank', '');
return false;
} 
		$("#frm_add_edit_obj").submit(function(){
				var flag=false;
				var message="";
				var frm=$(this);
				if($("#{$this->modelName}_title").val().length<3){
					message+='{$this->getLang()->getWords('error_title')}{$this->DS}n';
					flag=true;
				}
				if(flag){
					jAlert(message);
					return false;
				}
				vsf.uploadFile("frm_add_edit_obj", "{$bw->input[0]}", "{$this->modelName}_add_edit_process", "vs_panel_{$this->modelName}","{$bw->input[0]}",1,
							function(){
								var hashbase=frm.parents('.ui-tabs-panel').attr('id');
								window.location.hash=hashbase+"/{$bw->input['back']}";	
							}
				);
				return false;
		});
		$(".frm_close").click(function(){
			var hashbase=$(this).parents('.ui-tabs-panel').attr('id');
			window.location.hash=hashbase+"{$bw->input['back']}";
				///alert(window.location.hash);
			//vsf.get('{$bw->input[0]}/{$this->modelName}_display_tab&pageIndex={$bw->input['pageIndex']}&vdata={$_REQUEST['vdata']}','vs_panel_{$this->modelName}');
			//vsf.get('{$bw->input[0]}/{$this->modelName}_display_tab','vs_panel_{$this->modelName}',{vdata:'{$_REQUEST['vdata']}',pageIndex:'{$bw->input['pageIndex']}'});
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
		<table class="obj_list">
		<thead>
			<tr>
				<input type="button"  class="btnDelete" id="btn-delete-obj" value="{$this->getLang()->getWords('delete')}"/>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_disable',1)">
				<input type="button" class="btnAction" id="btn-disable-obj" value="{$this->getLang()->getWords('order_status_0','Mới đặt')}"/>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_visible',1)">
				<input type="button" class="btnAction" id="btn-enable-obj" value="{$this->getLang()->getWords('order_status_1','Chấp nhận')}"/>
				</if>
				<input type="button" class="btnAction" id="btn-home-obj" value="{$this->getLang()->getWords('order_status_2','Đã giao')}"/>

				<!--btnAdd,btnEdit,btnDelete,btnReview,btnDisable,btnEnable,btnOk,btnSearch,btnIndexChange-->
			</tr>	
			</thead>	
		</table>
		<div id="{$this->modelName}_item_panel">
		
		<input type="hidden" name="catId" value="{$bw->input['catId']}"/>
		<input type="hidden" name="pageIndex" value="{$bw->input['pageIndex']}"/>
		<table class="obj_list">
		<thead>
			<tr>
				<th class="cb"><input type="checkbox" onClick="checkAllClick()" class="check_alll" name=""/></th>
				<th class="id">{$this->getLang()->getWords("id")}</th>
				<th >{$this->getLang()->getWords("order_name",'Họ tên')}</th>
				<th >{$this->getLang()->getWords("address",'Địa chỉ')}</th>
				<th >{$this->getLang()->getWords("email",'Email')}</th>
				<th >{$this->getLang()->getWords("phone",'Điện thoại')}</th>
				<th c>{$this->getLang()->getWords("order_time",'TG đặt hàng')}</th>
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
				<td><a onClick="btnEditItem_Click({$item->getId()},this);return false;" href="">{$item->getTitle()}</a></td>
				<td>{$item->getAddress()}</td>
				<td>{$item->getEmail()}</td>
				<td>{$item->getPhone()}</td>
				<td>{$this->dateTimeFormat($item->getPostDate(),"h:i d/m/Y") }</td>
				<td class="status">
				<if="$item->getStatus()==-1">{$this->getLang()->getWords('order_status_-1','Hủy')}</if>
				<if="$item->getStatus()==0">{$this->getLang()->getWords('order_status_0','Mới đặt')}</if>
				<if="$item->getStatus()==1">{$this->getLang()->getWords('order_status_1','Chấp nhận')}</if>
				<if="$item->getStatus()==2">{$this->getLang()->getWords('order_status_2','Đã giao')}</if>
				</td>
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
			$("#vs_panel_{$this->modelName} #btn-cancel-obj").click(function(){
				if(objChecked.length==0){
					alert("{$this->getLang()->getWords('error_none_select')}");
					return false;
				}
				vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_cancel_checked/'+objChecked,'vs_panel_{$this->modelName}');
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
function addOtionList($obj) {
           global  $bw;
            $BWHTML .= <<<EOF
            	<input type="button" onClick="btnEditItem_Click({$obj->getId()},this)" class="btnEdit" value="{$this->getLang()->getWords('order_edit','Xem đơn hàng')}" />
            	<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_delete',1)">
				<input  type="button" onClick="btnRemoveItem_Click({$obj->getId()})" class="btnDelete" value="{$this->getLang()->getWords('delete')}" />
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_review',0, $bw->input[0], 1, 1)">
				<a href="{$bw->vars['board_url']}/{$bw->input[0]}/{$this->modelName}_review" target="_blank" class="btnReview">&nbsp;</a>
				</if>
                <if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_video',0, $bw->input[0], 1, 1)">
                    <a class="ui-state-default ui-corner-all ui-state-focus" href="javascript:;" onclick="vsf.popupGet('gallerys/gallerys_display-album-tab/{$bw->input[0]}/{$obj->getId()}&albumCode=video_{$bw->input[0]}','albumn')">
                            {$this->getLang()->getWords('video')}
                    </a>
               </if>     
               <if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_album',0, $bw->input[0], 1, 1)">
                    <input class="btnAlbum" type="button" onclick="vsf.popupGet('gallerys/gallerys_display-album-tab/{$bw->input[0]}/{$obj->getId()}&albumCode=image','albumn',700,500)" value="{$this->getLang()->getWords('album')}" />
                </if>
                <if=" $this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_comment',0, $bw->input[0], 1, 1)">
                    <a  title="{$this->getLang()->getWords('comment')}" class=" href="comments/comment-tab/{$this->modelName}/{$obj->getId()}" >
                            {$this->getLang()->getWords('comment')}
                    </a>
                </if>
EOF;
            return $BWHTML;
        }
}
