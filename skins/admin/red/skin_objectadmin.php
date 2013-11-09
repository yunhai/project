<?php
class skin_objectadmin{

	function objListHtml($objItems = array(), $option = array()) {
		global $bw, $vsLang, $vsSettings, $vsSetting, $tableName, $vsUser,$langObject;
                $this->objcallback = "obj-panel-callback";
		if($option['comment_panel']){
			$this->objcallback = "comment-callback";
		}
		$BWHTML .= <<<EOF
		
			<div class="red">{$option['message']}</div>
			<form id="obj-list-form">
			<input type="hidden" name="checkedObj" id="checked-obj" value="" />
			<input type="hidden" name="categoryId" value="{$option['categoryId']}" id="categoryId" />
			<div class='ui-dialog ui-widget ui-widget-content ui-corner-all'>
                            <div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
                            <span class="ui-icon ui-icon-note"></span>
                            <span class="ui-dialog-title">{$langObject['itemList']}</span>
                            </div>
                                <if=" $vsSettings->getSystemKey($bw->input[0].'_add_hide_show_delete',1, $bw->input[0]) ">
                                <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-corner-all-inner ui-widget-header">
                                    <li class="ui-state-default ui-corner-top" id="add-objlist-bt"><a href="#" title="{$langObject['itemListAdd']}">{$langObject['itemListAdd']}</a></li>
                                    <li class="ui-state-default ui-corner-top" id="hide-objlist-bt"><a href="#" title="{$langObject['itemListHide']}">{$langObject['itemListHide']}</a></li>
                                    <li class="ui-state-default ui-corner-top" id="visible-objlist-bt"><a href="#" title="{$langObject['itemListVisible']}">{$langObject['itemListVisible']}</a></li>
                                    <if=" $vsSettings->getSystemKey($bw->input[0].'_home',0, $bw->input[0]) ">
                                       <li class="ui-state-default ui-corner-top" id="home-objlist-bt"><a href="#" title="{$langObject['itemListHome']}">{$langObject['itemListHome']}</a></li>
                                    </if>
                                    <li class="ui-state-default ui-corner-top" id="delete-objlist-bt"><a href="#" title="{$langObject['itemListDelete']}">{$langObject['itemListDelete']}</a></li>
                                    <if="$vsSettings->getSystemKey($bw->input[0].'_category_list', 0, $bw->input[0])">
                                    <li class="ui-state-default ui-corner-top" id="change-objlist-bt"><a href="#" title="{$langObject['itemListChangeCate']}">{$langObject['itemListChangeCate']}</a></li>
                                    </if>
                                    <if="$vsSettings->getSystemKey($bw->input[0].'_search_list',0, $bw->input[0])">
                                    <li class="ui-state-default ui-corner-top" id="insertSearch-objlist-bt"><a href="#" title="{$langObject['itemListInsertSearch']}">{$langObject['itemListInsertSearch']}</a></li>
                                    </if>
                                </ul>
                                </if>
					<table cellspacing="1" cellpadding="1" id='objListHtmlTable' width="100%">
						<thead>
						    <tr>
						        <th width="10"><input type="checkbox" onclick="vsf.checkAll()" name="all" /></th>
						        <th width="60">{$langObject['itemListActive']}</th>
						        <th>{$langObject['itemListTitle']}</td>
								<if=" $vsSettings->getSystemKey($bw->input[0].'_index', 1, $bw->input[0], 1, 1) ">
						        <th width="30">{$langObject['itemListIndex']}</th>
								</if>
						        <if=" $vsSettings->getSystemKey($bw->input[0].'_option', 0, $bw->input[0], 1, 1) ">
						        <th width="80" align="center">{$langObject['itemListAction']}</th>
						        </if>
						    </tr>
						</thead>
						<tbody>
							<foreach="$objItems as $obj">
								<tr class="$vsf_class">
									<td align="center">
                                                                                <if="!$vsSettings->getSystemKey($bw->input[0].'_code',0) && $obj->getCode()">
                                                                                    <img src="{$bw->vars['img_url']}/disabled.png" />
                                                                                <else />
										<input type="checkbox" onclick="vsf.checkObject();" name="obj_{$obj->getId()}" value="{$obj->getId()}" class="myCheckbox" />
                                                                                </if>
									</td>
									<td style='text-align:center'>{$obj->getStatus('image')}</td>
									
									<td>
										<a href="javascript:vsf.get('{$bw->input[0]}/add-edit-obj-form/{$obj->getId()}/&pageIndex={$bw->input[3]}&pageCate={$bw->input[2]}','obj-panel')"  class="editObj" >
										{$obj->getTitle()}
										</a>
									</td>
									<if=" $vsSettings->getSystemKey($bw->input[0].'_index', 1, $bw->input[0], 1, 1) ">
									<td>{$obj->getIndex()}</td>
									</if>
									<if=" $vsSettings->getSystemKey($bw->input[0].'_option', 0, $bw->input[0], 1, 1) ">
									<td>
										{$this->addOtionList($obj,$this->objcallback,$option)}
									</td>
									</if>
								</tr>
							</foreach>
						</tbody>
						<tfoot>
							<tr>
								<th colspan='5'>
									<div style='float:right;'>{$option['paging']}</div>
								</th>
							</tr>
                                                         <tr >
                                                      <th colspan='6' align="left">
                                                      <span style="padding-left: 10px;line-height:16px;"><img src="{$bw->vars['img_url']}/enable.png" /> {$langObject['itemListCurrentShow']}</span>
                                                      <span style="padding-left: 10px;line-height:16px;"><img src="{$bw->vars['img_url']}/disabled.png" /> {$langObject['itemListNotShow']}</span>
                                                       <if=" $vsSettings->getSystemKey($bw->input[0].'_home',0, $bw->input[0]) ">
                                                            <span style="padding-left: 10px;line-height:16px;"><img src="{$bw->vars['img_url']}/home.png" /> {$langObject['itemListHomeShow']}</span>
                                                      </if>
                                                      </th>
                                                </tr>
						</tfoot>
					</table>
				</div>
			</form>
			<div class="clear" id="file"></div>
                        <div id='commentList'></div>
			{$this->addJavaScript()}
EOF;
	}
        
	function addJavaScript() {
		global $bw, $vsLang, $vsSettings, $vsSetting, $tableName, $vsUser,$langObject;
		$BWHTML .= <<<EOF
			<script type="text/javascript">
				
				$('#add-objlist-bt').click(function(){
					vsf.get('{$bw->input[0]}/add-edit-obj-form/&pageIndex={$bw->input[3]}&pageCate={$bw->input[2]}','obj-panel');
				});
				
				$('#hide-objlist-bt').click(function() {
					if(vsf.checkValue())
                   	vsf.get('{$bw->input[0]}/hide-checked-obj/'+$('#checked-obj').val()+'/'+ $("#idCategory").val() +'/&pageIndex={$bw->input[3]}&pageCate={$bw->input[2]}', 'obj-panel');
				});
				
				$('#visible-objlist-bt').click(function() {
					if(vsf.checkValue())
                 	vsf.get('{$bw->input[0]}/visible-checked-obj/'+$('#checked-obj').val()+'/'+ $("#idCategory").val() +'/&pageIndex={$bw->input[3]}&pageCate={$bw->input[2]}', 'obj-panel');
				});

              	 $('#home-objlist-bt').click(function() {
					if(vsf.checkValue())
                    vsf.get('{$bw->input[0]}/home-checked-obj/'+$('#checked-obj').val()+'/'+ $("#idCategory").val() +'/&pageIndex={$bw->input[3]}&pageCate={$bw->input[2]}', 'obj-panel');
				});           
				 
				
				$('#delete-objlist-bt').click(function() {
					if(vsf.checkValue())
                                            jConfirm(
                                                    "{$langObject['itemListConfirmDelete']}",
                                                    "{$bw->vars['global_websitename']} Dialog",
                                                    function(r) {
                                                            if(r) {
                                                                    var lists = $('#checked-obj').val();
                                                                    vsf.get('{$bw->input[0]}/delete-obj/'+lists+'/&pageIndex={$bw->input[3]}&pageCate={$bw->input[2]}','obj-panel');
                                                            }
                                                    }
                                            );
				});
				
			$('#change-objlist-bt').click(function() {
                            var categoryId = 0;
                            var count = 0;
                            if(vsf.checkValue()){
                                $("#obj-category  option").each(function () {
                                                                count++;
                                    if($(this).attr('selected'))categoryId = $(this).val();
                                });
                            if(categoryId == 0 && count>1){
                                  jAlert("{$langObject['itemListChoiseCate']}",
                                          '{$bw->vars['global_websitename']} Dialog'
                                   );
                                   return false;
                            }
                            vsf.get('{$bw->input[0]}/change-objlist-bt/'+$('#checked-obj').val()+'/'+ categoryId +'/&pageIndex={$bw->input[3]}&pageCate={$bw->input[2]}', 'obj-panel');
                     }
				});
			$('#insertSearch-objlist-bt').click(function() {        
             	vsf.get('{$bw->input[0]}/insertSearch-objlist-bt/&pageIndex={$bw->input[3]}&pageCate={$bw->input[2]}', 'obj-panel');
				});
			</script>
EOF;
	}        

	function addOtionList($obj,$dd,$option) {
            global $vsLang, $bw,$vsSettings,$tableName;
            
            $BWHTML .= <<<EOF
                <if="$vsSettings->getSystemKey($bw->input[0].'_multi_file',0, $bw->input[0], 1, 1)">
                    <a class="ui-state-default ui-corner-all ui-state-focus" href="javascript:;" onclick="vsf.popupGet('gallerys/display-album-tab/{$bw->input[0]}/{$obj->getId()}&albumCode=image','albumn')">
                            {$vsLang->getWords('global_album','Album')}
                    </a>
                </if>
                                <if=" $vsSettings->getSystemKey($bw->input[0].'_comment',0, $bw->input[0], 1, 1) && in_array($obj->getId(),$option['forecastcomment'])">
                    <a onclick="vsf.popupGet('comments/display_panel_popup_comment/products_comments/{$obj->getId()}','comment-panel-callback', 520,500)"  class="ui-state-default ui-corner-all ui-state-focus" href="javascript:;" >
                            {$vsLang->getWords('comment','Comments')}
                    </a>
                </if>
                 <if="$bw->input[0]=='quangcao'">           
				<a class="ui-state-default ui-corner-all ui-state-focus" href="javascript:;" onclick="vsf.popupGet('gallerys/display-album-tab/{$bw->input[0]}/{$obj->getId()}&albumCode=image1','albumn')">
                            {$vsLang->getWords('global_album','Album')}
                    </a>
                    
                </if>
EOF;
            return $BWHTML;
        }

	function addEditObjForm($objItem, $option = array()) {
		global $vsLang, $bw,$vsSettings,$tableName,$langObject;
		$BWHTML .= <<<EOF
			<div id="error-message" name="error-message"></div>
			<form id='add-edit-obj-form' name="add-edit-obj-form" method="POST" enctype='multipart/form-data'>
				<input type="hidden" id="obj-cat-id" name="{$tableName}CatId" value="{$option['categoryId']}" />
				<input type="hidden" name="{$tableName}Id" value="{$objItem->getId()}" />
				<input type="hidden" name="pageIndex" value="{$bw->input['pageIndex']}" />
				<input type="hidden" name="pageCate" value="{$bw->input['pageCate']}" />
				<input type="hidden" name="searchRecord" value="{$objItem->record}" />
				<input type="hidden" name="{$tableName}PostDate" value="{$objItem->getPostDate()}" />
				<input type="hidden" name="{$tableName}Image" value="{$objItem->getImage()}" />
				<input type="hidden" name="{$tableName}Author" value="{$objItem->getAuthor()}" />
				
				<div class='ui-dialog ui-widget ui-widget-content ui-corner-all'>
					<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
						<span class="ui-dialog-title">{$option['formTitle']}</span>
                                                 <p style="float:right; cursor:pointer;">
                                                <span class='ui-dialog-title' id='closeObj'>
                                                 {$langObject['itemObjBack']}
                                                </span>
                                            </p>
					</div>
					<table class="ui-dialog-content ui-widget-content" style="width:100%;">
						<tr class='smalltitle'>
							<td class="label_obj" width="75">
							{$langObject['itemListTitle']}:
							</td>
							<td colspan="3">
								<input style="width:100%;" name="{$tableName}Title" value="{$objItem->getTitle()}" id="obj-title"/>
							</td>
						</tr>

						
                     	<if="$vsSettings->getSystemKey($bw->input[0].'_code', 0, $bw->input[0])">
						<tr class='smalltitle'>
							<td class="label_obj"  width="75">
								{$langObject['itemObjCode']}:
							</td>
							<td colspan="3">
								<input style="width:40" name="{$tableName}Code" value="{$objItem->getCode()}"/>
							</td>
						</tr>
						</if>
						
						
						<tr class='smalltitle'>
							<td class="label_obj"  width="75">
								{$langObject['itemObjIndex']}:
							</td>
							<td>
								<input size="10" class="numeric" name="{$tableName}Index" value="{$objItem->getIndex()}" />
                               	<span style="margin-right: 20px;margin-left:40px">{$langObject['itemObjStatus']}</span>
                               	<label>{$langObject['itemObjDisplay']}</label>

								<input name="{$tableName}Status" id="{$tableName}Status1" value='1' class='c_noneWidth' type="radio" checked />

								<label>{$langObject['itemListHide']}</label>
								<input name="{$tableName}Status" id="{$tableName}Status0" value='0' class='c_noneWidth' type="radio" />


								<if=" $vsSettings->getSystemKey($bw->input[0].'_home',0, $bw->input[0]) ">
								<label>{$langObject['itemListHome']}</label>
								<input name="{$tableName}Status" id="{$tableName}Status2" value='2' class='c_noneWidth' type="radio" />
								</if>
							</td>
							<td colspan="2" rowspan="2">
								{$objItem->createImageCache($objItem->getImage(), 100, 50)}
								<br/>
								<if=" $objItem->getImage() && $vsSettings->getSystemKey($bw->input[0].'_image_delete',1, $bw->input[0]) ">
								<input type="checkbox" name="deleteImage" id="deleteImage" />
								<label for="deleteImage">{$langObject['itemObjDeleteImage']}</lable>
								</if>
							</td>
						</tr>
						
						<if="$vsSettings->getSystemKey($bw->input[0].'_image',1, $bw->input[0])">
						<tr class='smalltitle'>
							<td class="label_obj">
								{$langObject['itemObjFile']}:
							</td>
							<td>
								<input size="27" type="file" name="{$tableName}Image" id="{$tableName}Image" />
								{$vsSettings->getSystemKey($bw->input[0]."_image_timthumb_size","(size:100x100px)", $bw->input[0])}
							</td>
						</tr>						
						</if>

						<if=" $vsSettings->getSystemKey($bw->input[0].'_document', 0, $bw->input[0]) ">
                        <tr class='smalltitle'>
							<td class="label_obj">
								{$vsLang->getWords($bw->input[0]. '_document','Document')}:
							</td>
							<td colspan='3'>
								<input size="27" type="file" name="{$tableName}Document" id="{$tableName}Document" /><br />
								<if=" $objItem->getDocument() ">
									<input type="checkbox" name="deleteDocument" id="deleteDocument" />
									<a href="{$bw->vars['board_url']}/files/download/{$objItem->getDocument()}">
										{$vsLang->getWords('xoa_file','xóa File')}
									</a>
								</if>
								
							</td>
						</tr>
						</if>
                                                                 
						
						<if=" $vsSettings->getSystemKey($bw->input[0].'_intro',1, $bw->input[0]) ">
						<tr class='smalltitle'>
							<td class="label_obj" width="75">
								{$langObject['itemObjIntro']}:
							</td>
							<td colspan="3" valgin="left">
								{$objItem->getIntro()}
							</td>
						</tr>
						</if>
						
						<if="$vsSettings->getSystemKey($bw->input[0].'_content',1, $bw->input[0])">
						<tr class='smalltitle'>
							<td colspan="4" align="center">{$objItem->getContent()}</td>
						</tr>
						</if>
						<tr>
							<td class="ui-dialog-buttonpanel" colspan="4" align="center">
								<input type="submit" name="submit" value="{$option['formSubmit']}" />
							</td>
						</tr>
					</table>
				</div>
			</form>
			<script language="javascript">
				$(window).ready(function() {
					$('#obj-category option').each(function(){
						$(this).removeAttr('selected');
					});
					$("input.numeric").numeric();
					
					vsf.jRadio('{$objItem->getStatus()}','{$tableName}Status');
					vsf.jSelect('{$objItem->getCatId()}','obj-category');
				
				});
				
				$('#add-edit-obj-form').submit(function(){
					var flag  = true;
					var error = "";
					var categoryId=0;
					var count=0;

					$("#obj-category  option").each(function () {
						count++;
            			if($(this).attr('selected'))categoryId = $(this).val();
					});

					$('#obj-cat-id').val(categoryId);
					
					if(categoryId == 0 && count>1){
						error = "<li>{$langObject['itemListChoiseCate']}</li>";
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
					vsf.uploadFile("add-edit-obj-form", "{$bw->input[0]}", "add-edit-obj-process", "obj-panel","{$bw->input[0]}");
					return false;
				});
              	$('#closeObj').click(function(){                                       
					vsf.get('{$bw->input[0]}/display-obj-list/{$bw->input['pageCate']}/&pageIndex={$bw->input['pageIndex']}','obj-panel');
				});
			</script>
EOF;
	}

	function categoryList($data = array()) {
		global $vsLang, $bw,$vsSettings,$langObject;
		$BWHTML .= <<<EOF
			<div class="ui-dialog ui-widget ui-widget-content ui-corner-all">
				<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
					<span class="ui-icon ui-icon-triangle-1-e"></span>
					<span class="ui-dialog-title">{$langObject['categoriesTitle']}</span>
				</div>
				<table width="100%" cellpadding="0" cellspacing="1">
					<tr>
				    	<th id="obj-category-message" colspan="2">{$data['message']}{$langObject['categoriesSelected']}: {$langObject['categoriesNone']}</th>
				    </tr>
				    <tr>
				        <td width="220">
				        {$data['html']}
				        </td>
				    	<td align="center">
                                            <a class="ui-state-default ui-corner-all ui-state-focus" href="javascript:;" id="view-obj-bt" >
                                                    {$langObject['categoriesView']}
                                            </a>
                                            <if=" $vsSettings->getSystemKey($bw->input[0].'_rss_button',0,$bw->input[0],1,1) ">
                                            <a class="ui-state-default ui-corner-all ui-state-focus" href="javascript:;" id="rss-obj-bt" >
                                                    {$langObject['categoriesRSS']}
                                            </a>
                                            </if>
				        </td>
					</tr>
				</table>
			</div>
                        <div  id="result_rss"></div>
			<script type="text/javascript">
				$('#view-obj-bt').click(function() {
					var categoryId = '';
					$("#obj-category option:selected").each(function () {
						categoryId = $(this).val();
					});
					vsf.get('{$bw->input[0]}/display-obj-list/'+categoryId+'/','obj-panel');
				});
                                $('#rss-obj-bt').click(function() {
                                var categoryId = '';
                                $("#obj-category option:selected").each(function () {
                                        categoryId = $(this).val();
                                });
                                vsf.get('{$bw->input[0]}/create_rss_file/'+categoryId+'/','result_rss');
				});
				$('#add-obj-bt').click(function(){
//					var categoryId = '';
//					$("#obj-category option:selected").each(function () {
//						categoryId=$(this).val();
//					});
//					$("#idCategory").val(categoryId);
					vsf.get('{$bw->input[0]}/add-edit-obj-form/', 'obj-panel');
				});
				var parentId = '';
				$('#obj-category').change(function() {
					var currentId = '';
					var parentId = '';
					$("#obj-category option:selected").each(function () {
						currentId += $(this).val() + ',';
						parentId = $(this).val();
					});
					currentId = currentId.substr(0, currentId.length-1);
					$("#obj-category-message").html('{$langObject['categoriesSelected']}:'+currentId);
					$('#obj-cat-id').val(parentId);
				});
			</script>
EOF;
	}

	function displayObjTab($option) {
		global $bw,$vsSettings,$langObject;
                
		$BWHTML .= <<<EOF
		<if="$vsSettings->getSystemKey($bw->input[0].'_category_list',1, $bw->input[0])">
	        <div class='left-cell'><div id='category-panel'>{$option['categoryList']}</div></div>
			<input type="hidden" id="idCategory" name="idCategory" />
			<div id="obj-panel" class="right-cell">{$option['objList']}</div>
			<div class="clear"></div>
		<else />
			<input type="hidden" id="idCategory" name="idCategory" />
			<div id="obj-panel" style="width:100%" class="right-cell">{$option['objList']}</div>
			<div class="clear"></div>
                </if>
			
EOF;
		return $BWHTML;
	}
	
	function managerObjHtml() {
		global $bw, $vsLang,$vsSettings,$langObject;
		$BWHTML .= <<<EOF
			<div id="page_tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all-top">
				<ul id="tabs_nav" class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-corner-all-inner">
                                <if="$bw->input['module'] == 'pages' ">
                                    <li class="ui-state-default ui-corner-top">
                                            <a href="{$bw->base_url}pages/displayVirtualTab/&ajax=1">
                                                    <span>{$langObject['tabVirtualModule']}</span>
                                            </a>
                                    </li>
	        		</if>
			    	<li class="ui-state-default ui-corner-top">
			        	<a href="{$bw->base_url}{$bw->input[0]}/display-obj-tab/&ajax=1"><span>{$vsLang->getWords("tab_obj_objes_{$bw->input[0]}","{$bw->input[0]}")}</span></a>
			        </li>
                                <if="$vsSettings->getSystemKey($bw->input[0].'_category_tab',0, "{$bw->input[0]}", 1, 1)">
                                        <li class="ui-state-default ui-corner-top">
                                        <a href="{$bw->base_url}menus/display-category-tab/{$bw->input[0]}/&ajax=1">
                                        <span>{$langObject['categoriesTitle']}</span></a>
                                </li>
			        </if>
			        
			        <if="$vsSettings->getSystemKey($bw->input[0].'_setting_tab',0, "{$bw->input[0]}", 1, 1)">
				        <li class="ui-state-default ui-corner-top">
				        	<a href="{$bw->base_url}settings/moduleObjTab/{$bw->input[0]}/&ajax=1">
								<span>Settings</span>
							</a>
			        	</li>
		        	</if>
				</ul>
			</div>
EOF;
		return $BWHTML;
	}
}
?>