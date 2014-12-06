<?php

class skin_documents extends skin_objectadmin {
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
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_image_field",1,$bw->input[0])">
					<th class="img">{$this->getLang()->getWords($this->modelName.'_image')}</th>
				</if>
				<th class="title">{$this->getLang()->getWords("title")}</th>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_category_list",0,$bw->input[0])">
					<th>{$this->getLang()->getWords("category")}</th>
				</if>
				<th class="status">{$this->getLang()->getWords("status")}</th>
				<th class="date">{$this->getLang()->getWords("postdate")}</th>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_index",1,$bw->input[0])">
				<th class="index">{$this->getLang()->getWords("index")}</th>
				</if>
				<th class="action">{$this->getLang()->getWords("action")}</th>
			</tr>
		</thead>
		<tbody>
		<if="is_array($objItems)">
		<foreach="$objItems as $item">
		<php>
		$files=new files();
		$file=$files->getObjectById($item->getImage());
		</php>
			<tr class="$vsf_class">
				<td><input onClick="checkRow()" class="btn_checkbox" value="{$item->getId()}" type="checkbox" /></td>
				<td>{$item->getId()}</td>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_image_field",1,$bw->input[0])">
					<td> <a onClick="btnEditItem_Click({$item->getId()})" href="#">
					<if="$file">
					<img src="{$bw->vars['img_url']}/icons/{$file->getType()}.png"/> {$file->getTitle()}
					</if>
					</a></td>
				</if>
				<td>{$item->getTitle()}</td>
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
				<td>{$this->dateTimeFormat($item->getPostDate(),"d/m/Y") }</td>
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
					<td style="width: 111px;"><label>{$this->getLang()->getWords('title')}</label></td>
					<td>
					<input  name="{$this->modelName}[title]" id="{$this->modelName}_title" type="textbox" value="{$obj->getTitle()}" style='width:100%' />
					</td>
				</tr>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_status",1,$bw->input[0])">
				<tr>
					<td style="width: 121px;"><label>{$this->getLang()->getWords('status')}</label></td>
					<td>
					<label>
						<input <if="$obj->getStatus()=='0'">checked='checked'</if>  name="{$this->modelName}[status]" id="{$this->modelName}_status_0" type="radio" value="0"  />
						{$this->getLang()->getWords('hide')}
						<!--<img title="{$this->getLang()->getWords('hide')}" src="{$bw->vars['img_url']}/status_0.png"/>-->
					</label>
					<label>
						<input <if="$obj->getStatus()==1||$obj->getStatus()==null">checked='checked'</if>  name="{$this->modelName}[status]" id="{$this->modelName}_status_1" type="radio" value="1"  />
						{$this->getLang()->getWords('visible')}
						<!--<img title="{$this->getLang()->getWords('visible')}" src="{$bw->vars['img_url']}/status_1.png"/>-->
					</label>
					<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_status_home",0,$bw->input[0])">
					<label>
						<input  <if="$obj->getStatus()==2">checked='checked'</if>  name="{$this->modelName}[status]" id="{$this->modelName}_status_2" type="radio" value="2"  />
						{$this->getLang()->getWords('home')}
						<!--<img title="{$this->getLang()->getWords('home')}" src="{$bw->vars['img_url']}/status_2.png"/>-->
					</label>
					</if>
					</td>
				</tr>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_category_list",0,$bw->input[0])">
				<tr>
					<td><label>{$this->getLang()->getWords("category")}</label></td>
					<td>
					<select  name="{$this->modelName}[catId]">
							{$this->model->getCategories()->getChildrenBoxOption($obj->getCatId())}
					</select>
					<br>
					</td>
				</tr>
				</if>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_index",1,$bw->input[0])">
				<tr>
					<td><label>{$this->getLang()->getWords("index")}</label></td>
					<td>
					<input  name="{$this->modelName}[index]" id="{$this->modelName}_index" type="textbox" value="{$obj->getIndex()}" />
					</td>
				</tr>
				</if>
				<tr>
					<td>
					<label>{$this->getLang()->getWords($this->modelName.'_image')}</label>
					<br/>
					{$this->getSettings()->getSystemKey('max_size_text','Max 10Mb')}
					</td>
					<td>
					<div style="float:left;width:300px">
						<label>
							<input   type="file" value="" style='width:250px;'  id="image-file" name="image"/>
						</label>
					</div>
					<div style="float:left;width:200px">
					<php>
					$files=new files();
					$file=$files->getObjectById($obj->getImage());
					</php>
					<if="$file">
					<img src="{$bw->vars['img_url']}/icons/{$file->getType()}.png"/> {$file->getTitle()}
					</if>
					</div>
					</td>
				</tr>
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_intro",1,$bw->input[0])">
				<tr>
					<td><label>{$this->getLang()->getWords('intro')}</label></td>
					<td>
					<textarea id="{$this->modelName}_intro" name="{$this->modelName}[intro]" style="width: 100%; height: 111px;">{$obj->getIntro()}</textarea>
					</td>
				</tr>
				</if>
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
				if($("#{$this->modelName}_title").val().length<3){
					message+='{$this->getLang()->getWords('error_title')}{$this->DS}n';
					flag=true;
				}
				<if="$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_intro",1,$bw->input[0])">
				if($("#{$this->modelName}_intro").val().length<3){
					message+='{$this->getLang()->getWords('error_intro')}{$this->DS}n';
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
			//vsf.get('{$bw->input[0]}/{$this->modelName}_display_tab&pageIndex={$bw->input['pageIndex']}&vdata={$_REQUEST['vdata']}','vs_panel_{$this->modelName}');
			vsf.get('{$bw->input[0]}/{$this->modelName}_display_tab','vs_panel_{$this->modelName}',{vdata:'{$_REQUEST['vdata']}',pageIndex:'{$bw->input['pageIndex']}'});
			return false;
		});
		////////*********************select file field*************************/
//						$("input[type='radio']").change(function(){
//							if($(this).val()=='link'||$(this).val()=='file'){
//							
//								$("input[name='"+this.name+"']").each(function(){
//										if($(this).attr("checked")){
//											$("#"+$(this).attr('obj')).removeAttr("disabled");
//										}else{
//											$("#"+$(this).attr('obj')).attr("disabled","disabled");
//										}
//								});
//								
//							}
//						});
		</script>
		
EOF;
	}



}
