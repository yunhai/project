<?php

class skin_assessments extends skin_objectadmin {

	function addEditObjForm($obj, $option = array()) {
		global $bw;
		
		
		//echo 123; exit();
		
		$BWHTML .= <<<EOF
		
		

		<div class="vs_panel" id="vs_panel_{$this->modelName}">
		<div class="ui-dialog">
		
		<form class="frm_add_edit_obj" id="frm_add_edit_obj"  method="POST" enctype='multipart/form-data'>
		<input type="hidden" value="{$bw->input['vdata']}" name="vdata"/>
		<input type="hidden" value="{$bw->input['pageIndex']}" name="pageIndex"/>
		<input type="hidden" value="{$obj->getId()}" name="{$this->modelName}[id]" />
		<!--<input type="hidden" value="{$obj->getSlug ()}" name="{$this->modelName}[mUrl]" id="mUrl" data-module="{$this->modelName}" data-id = "{$obj->getId()}" />-->
			<table class="obj_add_edit" width="100%">
				<thead>
					<tr>
						<th colspan="2">
							<span class="ui-dialog-title-form">{$this->getLang()->getWords('add_edit_'.$bw->input[0],'Thêm/Sửa tin')}</span>
							<a class="btn_custom_settings icon-wrapper-vs" 
							group="{$bw->input[0]}_{$this->modelName}_form">
							</a>
							<div class="vs-buttons">
								
								<button type="button" id="frm_close" class="btnCancel frm_close"><span><img src="{$bw->vars['img_url']}/pixel-vfl3z5WfW.gif" class="icon-wrapper-vs vs-icon-cancel"></span><span>{$this->getLang()->getWords("global_cancel")}</span></button>
							</div>
						</th>
					</tr>
					
				</thead>
				<tbody>
				<tr>
					<td><label>Họ tên</label></td>
					<td>
					{$obj->getName()}
					</td>
				</tr>
				<tr>
					<td><label>Điện thoại</label></td>
					<td>
					{$obj->getPhone()}
					</td>
				</tr>
				<tr>
					<td><label>Địa chỉ</label></td>
					<td>
					{$obj->getAddress()}
					</td>
				</tr>
				<tr>
					<td><label>Email</label></td>
					<td>
					{$obj->getEmail()}
					</td>
				</tr>
				<tr>
					<td><label>Tên sản phẩm</label></td>
					<td>
					{$obj->getTitle()}
					</td>
				</tr>
				<tr>
					<td><label>Đánh giá</label></td>
					<td>
					{$obj->getAssessment()}
					
					
					</td>
				</tr>
				<tr>
					<td><label>Mức giá mong muốn</label></td>
					<td>
					{$obj->getContent()}
					</td>
				</tr>
				
				
				
				
				
				<tr>
					<td></td>
					<td><if="$this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_seo_option','SEO Option',$bw->input[0].'_'.$this->modelName.'_form')">
						<button onclick="$('#seo').toggle();return false;">Seo option</button>
					</if>
				</tr></td>	

				<if="$this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_seo_option','SEO Option',$bw->input[0].'_'.$this->modelName.'_form')">
					<tr id="seo" $seo>
						<td><label>{$this->getLang()->getWords('seo')}</label></td>
						<td>
							<label>Slug:<input type="text" style="width:100%" value="{$obj->getSlug()}" name="{$this->modelName}[slug]" /></label>
							<label>Meta Title:<input type="text" style="width:100%" value="{$obj->getMTitle()}" name="{$this->modelName}[mTitle]" /></label>
							<label>Meta Description:<textarea style="width:100%"   name="{$this->modelName}[mIntro]" >{$obj->getMIntro()}</textarea></label>
							<label>Meta Keyword:<textarea style="width:100%"   name="{$this->modelName}[mKeyword]" >{$obj->getMKeyword()}</textarea></label>
						</td>
					</tr>
				</if>
				<tr style="border:none">
					<td class="vs-button" colspan="2" >
					
						
						<button type="button" id="frm_close" class="btnCancel frm_close"><span><img src="{$bw->vars['img_url']}/pixel-vfl3z5WfW.gif" class="icon-wrapper-vs vs-icon-cancel"></span><span>{$this->getLang()->getWords("global_cancel")}</span></button>
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
       

}
