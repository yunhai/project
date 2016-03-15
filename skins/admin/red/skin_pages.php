<?php
class skin_pages extends skin_objectadmin{
	
//function addEditObjForm($objItem, $option = array()) {
//		global $vsLang, $bw,$vsSettings,$tableName,$langObject;
//		$BWHTML .= <<<EOF
//			<div id="error-message" name="error-message"></div>
//			<form id='add-edit-obj-form' name="add-edit-obj-form" method="POST" enctype='multipart/form-data'>
//				<input type="hidden" id="obj-cat-id" name="{$tableName}CatId" value="{$option['categoryId']}" />
//				<input type="hidden" name="{$tableName}Id" value="{$objItem->getId()}" />
//				<input type="hidden" name="pageIndex" value="{$bw->input['pageIndex']}" />
//				<input type="hidden" name="pageCate" value="{$bw->input['pageCate']}" />
//             	<input type="hidden" name="searchRecord" value="{$objItem->record}" />
//              	<input type="hidden" name="{$tableName}PostDate" value="{$objItem->getPostDate()}" />
//          		<input type="hidden" name="{$tableName}Image" value="{$objItem->getImage()}" />
//              	<input type="hidden" name="{$tableName}Author" value="{$objItem->getAuthor()}" />
//                <input type="hidden" name="{$tableName}Module" value="{$bw->input['module']}" />            
//				<div class='ui-dialog ui-widget ui-widget-content ui-corner-all'>
//					<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
//						<span class="ui-dialog-title">{$option['formTitle']}</span>
//                                                 <p style="float:right; cursor:pointer;">
//                                                <span class='ui-dialog-title' id='closeObj'>
//                                                 {$langObject['itemObjBack']}
//                                                </span>
//                                            </p>
//					</div>
//					<table class="ui-dialog-content ui-widget-content" style="width:100%;">
//						
//						<tr class='smalltitle'>
//							<td class="label_obj" width="75">{$langObject['itemListTitle']}:</td>
//							<td colspan="3">
//								<input style="width:100%;" name="{$tableName}Title" value="{$objItem->getTitle()}" id="obj-title"/>
//							</td>
//						</tr>
//						
//							
//						<if="$vsSettings->getSystemKey($bw->input[0].'_author',0, $bw->input[0])">
//						<tr class='smalltitle'>
//							<td class="label_obj"  width="75">
//								{$langObject['itemObjAuthor']}:
//							</td>
//							<td colspan="3">
//								<input style="width:100%;" name="{$tableName}Author" value="{$objItem->getAuthor()}"/>
//							</td>
//						</tr>
//						</if>
//
//                     	<if="$vsSettings->getSystemKey($bw->input[0].'_code',0, $bw->input[0])">
//						<tr class='smalltitle'>
//							<td class="label_obj"  width="75">
//								{$langObject['itemObjCode']}:
//							</td>
//							<td colspan="3">
//								<input style="width:40" name="{$tableName}Code" value="{$objItem->getCode()}"/>
//							</td>
//						</tr>
//						</if>
//						
//						
//						<tr class='smalltitle'>
//							<td class="label_obj"  width="75">
//								{$langObject['itemObjIndex']}:
//							</td>
//							<td width="170" colspan="3">
//								<input size="10" class="numeric" name="{$tableName}Index" value="{$objItem->getIndex()}" />
//                               	<span style="margin-right: 20px;margin-left:40px">{$langObject['itemObjStatus']}</span>
//                               	<label>{$langObject['itemObjDisplay']}</label>
//
//								<input name="{$tableName}Status" id="{$tableName}Status1" value='1' class='c_noneWidth' type="radio" checked />
//
//								<label>{$langObject['itemListHide']}</label>
//								<input name="{$tableName}Status" id="{$tableName}Status0" value='0' class='c_noneWidth' type="radio" />
//
//
//								<if=" $vsSettings->getSystemKey($bw->input[0].'_home',0, $bw->input[0]) ">
//								<label>{$langObject['itemListHome']}</label>
//								<input name="{$tableName}Status" id="{$tableName}Status2" value='2' class='c_noneWidth' type="radio" />
//								</if>
//							</td>
//						</tr>
//						
//						<if="$vsSettings->getSystemKey($bw->input[0].'_image',1, $bw->input[0])">
//						<if="$bw->input[0]=='modulehome'">
//						<tr class='smalltitle'>
//							<td class="label_obj">
//								{$langObject['itemObjFile']}:
//							</td>
//							<td>
//								<input onclick="checkedLinkFile($('#link-file').val());" onclicktext="checkedLinkFile($('#link-file').val());" type="radio" id="link-file" name="link-file" value="file" checked="checked"/>
//								<input size="27" type="file" name="{$tableName}IntroImage" id="{$tableName}IntroImage" /><br />
//								 {$vsSettings->getSystemKey($bw->input[0]."_image_timthumb_size","(size:100x100px)", $bw->input[0])}
//							</td>
//							<td colspan="2">
//								{$objItem->createImageCache($objItem->getImage(), 100, 50)}
//								<br/>
//								<if=" $objItem->getImage() && $vsSettings->getSystemKey($bw->input[0].'_image_delete',1, $bw->input[0]) ">
//								<input type="checkbox" name="deleteImage" id="deleteImage" />
//								<label for="deleteImage">{$langObject['itemObjDeleteImage']}</lable>
//								</if>
//							</td>
//						</tr>
//						<else />
//						<tr class='smalltitle'>
//							<td class="label_obj">
//								{$langObject['itemObjLink']}:
//							</td>
//							<td>
//								<input onclick="checkedLinkFile($('#link-text').val());" onclicktext="checkedLinkFile($('#link-text').val());" type="radio" id="link-text" name="link-file" value="link" />
//								<input size="39" type="text" name="txtlink" id="txtlink"/><br/>
//								 {$vsSettings->getSystemKey($bw->input[0]."_image_timthumb_size","(size:100x100px)", $bw->input[0])}
//							</td>
//							<td colspan="2" rowspan="2">
//								{$objItem->createImageCache($objItem->getImage(), 100, 50)}
//								<br/>
//								<if=" $objItem->getImage() && $vsSettings->getSystemKey($bw->input[0].'_image_delete',1, $bw->input[0]) ">
//								{$objItem->getFUllImage($option['file'],$objItem->getImage(),'deleteIntroImage')}
//								</if>
//							</td>
//						</tr>
//
//						<tr class='smalltitle'>
//							<td class="label_obj">
//								{$langObject['itemObjFile']}:
//							</td>
//							<td>
//								<input onclick="checkedLinkFile($('#link-file').val());" onclicktext="checkedLinkFile($('#link-file').val());" type="radio" id="link-file" name="link-file" value="file" checked="checked"/>
//								<input size="27" type="file" name="{$tableName}IntroImage" id="{$tableName}IntroImage" /><br />
//								 <!--{$vsSettings->getSystemKey($bw->input[0]."_image_timthumb_size","(size:100x100px)", $bw->input[0])}-->
//							</td>
//						</tr>
//						</if>						
//						</if>
//						<if=" $vsSettings->getSystemKey($bw->input[0].'_file',0, $bw->input[0]) ">
//						<tr class='smalltitle'>
//							<td class="label_obj">
//								{$langObject['itemObjFileupload']}:
//							</td>
//							<td>
//					
//								<input size="27" type="file" name="{$tableName}Fileupload" id="{$tableName}Fileupload" /><br />
//                               	{$vsSettings->getSystemKey($bw->input[0]."_file_type","(loại file: .doc,.pdf,.zip,.rar)", $bw->input[0])}
//							</td>
//                          	<td style="width:500px">
//                           	{$objItem->getFUllImage($option['file'],$objItem->getFileupload(),'deleteFileupload')}
//                           	</td>
//						</tr>
//						
//						</if>
//						<if=" $vsSettings->getSystemKey($bw->input[0].'_intro',1, $bw->input[0]) ">
//						<tr class='smalltitle'>
//							<td class="label_obj" width="75">
//								{$langObject['itemObjIntro']}:
//							</td>
//							<td colspan="3" valgin="left">
//								{$objItem->getIntro()}
//							</td>
//						</tr>
//						</if>
//						
//						<if="$vsSettings->getSystemKey($bw->input[0].'_content',1, $bw->input[0])">
//						<tr class='smalltitle'>
//							<td colspan="4" align="center">{$objItem->getContent()}</td>
//						</tr>
//						</if>
//						<tr>
//							<td class="ui-dialog-buttonpanel" colspan="4" align="center">
//								<input type="submit" name="submit" value="{$option['formSubmit']}" />
//							</td>
//						</tr>
//					</table>
//				</div>
//			</form>
//			<script language="javascript">
//				$(window).ready(function() {
//                                        $('#obj-category option').each(function(){
//							$(this).removeAttr('selected');
//						});
//					$("input.numeric").numeric();
//					checkedLinkFile();
//					vsf.jRadio('{$objItem->getStatus()}','{$tableName}Status');
//					vsf.jSelect('{$objItem->getCatId()}','obj-category');
//				
//				});
//				
//				$('#txtlink').change(function() {
//					var img_html = '<img src="'+$(this).val()+'" style="width:100px; max-height:115px;" />'; 
//					$('#td-obj-image').html(img_html);
//				});
//				
//				$('#{$tableName}IntroImage').change(function() {
//					var img_name = '<input type="hidden" id="image-name" name="image-name" value="'+$(this).val() +'"/>';
//					$('#td-obj-image').html(img_name);
//				});
//				
//				function checkedLinkFile(value){
//					if(value=='link'){
//						$("#txtlink").removeAttr('disabled');
//						$("#{$tableName}IntroImage").attr('disabled', 'disabled');
//					}else{
//						$("#txtlink").attr('disabled', 'disabled');
//						$("#{$tableName}IntroImage").removeAttr('disabled');
//					}
//				}
//				
//				$('#add-edit-obj-form').submit(function(){
//					var flag  = true;
//					var error = "";
//					var categoryId=0;
//					var count=0;
//
//					$("#obj-category  option").each(function () {
//						count++;
//            			if($(this).attr('selected'))categoryId = $(this).val();
//					});
//
//					$('#obj-cat-id').val(categoryId);
//					
//					if(categoryId == 0 && count>1){
//						error = "<li>{$langObject['itemListChoiseCate']}</li>";
//						flag  = false;
//					}
//					
//					var title = $("#obj-title").val();
//					if(title == 0 || title == ""){
//						error += "<li>{$langObject['notItemObjTitle']}</li>";
//						flag  = false;
//					}
//					if(!flag){
//						error = "<ul class='ul-popu'>" + error + "</ul>";
//						vsf.alert(error);
//						return false;
//					}
//					vsf.uploadFile("add-edit-obj-form", "{$bw->input[0]}", "add-edit-obj-process", "obj-panel","{$bw->input[0]}");
//					return false;
//				});
//              	$('#closeObj').click(function(){                                       
//					vsf.get('{$bw->input[0]}/display-obj-list/{$bw->input['pageCate']}/&pageIndex={$bw->input['pageIndex']}','obj-panel');
//				});
//			</script>
//EOF;
//	}
	
	function displayVirtualTab($option=array()){
		global $vsLang, $bw;

		$BWHTML = <<<EOF
			<div id='virtualTabContainer'>
				<div class="left-cell">
					<div class="ui-dialog ui-widget ui-widget-content ui-corner-all">
						<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
							<span class="ui-icon ui-icon-triangle-1-e"></span>
							<span class="ui-dialog-title">{$vsLang->getWords('pages_virtual_module_title_header','Virtual Module')}</span>
						</div>

						<div id="virtualForm">{$option['form']}</div>
					</div>
				</div>
				<div class='right-cell' id="mainPageContainer">
					{$option['list']}
				</div>
				<div class="clear"></div>
			</div>
EOF;
				return $BWHTML;
	}

	function displayVirtualItemContainer($virtualList = array(), $option=array()){
		global $vsLang, $bw;
		$message = $vsLang->getWords('pages_deleteConfirm_NoItem', "You haven't choose any items!");


		$BWHTML .= <<<EOF
        	<input type='hidden' id="checked-obj1" value=""/>
			<div class='ui-dialog ui-widget ui-widget-content ui-corner-all'>
			    <div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
			        <span class="ui-icon ui-icon-triangle-1-e"></span>
			        <span class="ui-dialog-title">
						{$vsLang->getWords('virtual_list','List of Virtual Module')}
					</span>

			        <p class="closeObj">
			        	<span id="deleteVirtual">Delete</span>
			        </p>
			    </div>
				<table cellspacing="1" cellpadding="1" id='productListTable' width="100%">
					<thead>
					    <tr>
					        <th width="15"><input type="checkbox" onclick="vsf.checkAll('myCheckbox1','checked-obj1')" onclicktext="vsf.checkAll('myCheckbox1','checked-obj1')" name="all" /></th>
					        <th >{$vsLang->getWords('pages_virtual_labelStatus', 'Tên module')}</td>
                                                <th >{$vsLang->getWords('pages_virtual_Parent', 'Parent')}</td>
                                                <th >{$vsLang->getWords('pages_virtual_Settings', 'pSettings')}</td>
					    </tr>
					</thead>
					<tbody>
						<if=" count($virtualList) > 0">
						<foreach="$virtualList as $virtual">
							<tr>
								<td align="center" width="15">
									<input type="checkbox" onclicktext="vsf.checkObject('myCheckbox1','checked-obj1');" onclick="vsf.checkObject('myCheckbox1','checked-obj1');" name="obj_{$virtual->getId()}" value="{$virtual->getId()}" class="myCheckbox1" />
								</td>
								<td>
									<a href="javascript:vsf.get('pages/virtualForm/{$virtual->getId()}','virtualForm')" title='{$vsLang->getWords('edit_virtual_module_title','Click here to edit')}' class="editObj">
										<strong>{$virtual->getTitle()} ({$virtual->getClass()})</strong>
									</a>
									<br />
									<div class="desctext">{$virtual->getIntro()}</div>
								</td>
                                                                <td>
									{$virtual->getParent()}
								</td>
                                                                <td>
									{$virtual->getSettings()}
								</td>        
							</tr>
						</foreach>
						</if>
					</tbody>
				</table>
			</div>
			<script type='text/javascript'>
				$('#deleteVirtual').click(function(){
                                if(vsf.checkValue('checked-obj1'))
					jConfirm(
						'{$vsLang->getWords("delete_virtual_confirm","Are you sure to delete these information?")}',
						'{$bw->vars['global_websitename']} Dialog',
						function(r){
							if(r){
								jsonStr = $('#checked-obj1').val();
								vsf.get('pages/deleteVirtual/'+jsonStr+'/', 'virtualTabContainer');
							}
						}
					);
				});

			</script>
EOF;
		return $BWHTML;

	}

	function virtualForm($module="", $option=''){
		global $vsLang;

		$BWHTML = <<<EOF
			    <form id="editVirtualForm" method="post">
			    	<input class="input" type="hidden" value="{$module->getId()}" name="moduleId" />
			    	<input class="input" type="hidden" value="{$module->getTitle()}" name="oldModuleTitle" />
					<table cellpadding="0" cellspacing="1" width="100%">
				    	<tr>
				        	<th>{$vsLang->getWords('module_list_name','Title')}</th>
				            <td><input id="moduleTitle" type="text" value="{$module->getTitle()}" name="moduleTitle" /></td>
				        </tr>
				        <tr>
				        	<th>{$vsLang->getWords('module_list_desc','Intro')}</th>
				            <td><textarea cols="18" rows="5" name="moduleIntro">{$module->getIntro()}</textarea></td>
				        </tr>
                                        <tr>
				        	<th>{$vsLang->getWords('module_list_pr','Parent')}</th>
				            <td>
				            	<select name="moduleParent" id="moduleParent">
                                                    <option value="pages">Pages </option>
                                                    <option value="partners">Partners </option>
                                                    <option value="pcontacts">P Contact </option>
                                                    <option value="advisorys">Advisorys </option>
                                                    <option value="gallerys">Gallerys </option>
                                                    <option value="products">Products </option>
                                                </select>
				            </td>
				        </tr>
                                        <tr>
				        	<th>{$vsLang->getWords('pages_virtual_Settings', 'pSettings')}</th>
				            <td>
				            	<input id="moduleSettings" type="text" value="{$module->getSettings()}" name="moduleSettings" />
				            </td>
				        </tr>        
				        <tr>
				        	<th>{$vsLang->getWords('module_list_use','Base')}</th>
				            <td>
				            	{$vsLang->getWords('module_list_use_admin','Admin')}
				            	<input type="checkbox" name="moduleIsAdmin" id="moduleIsAdmin" value="1" />

				            	{$vsLang->getWords('module_list_use_user','User')}
				            	<input type="checkbox" name="moduleIsUser" id="moduleIsUser" value="1" />
				            </td>
				        </tr>
				        <tr>
				        	<th>&nbsp;</th>
				            <td>
				            	<button class="ui-state-default ui-corner-all" type="submit">
				            		{$option['submitValue']}
				            	</button>
			            	</td>
				        </tr>
				    </table>
				</form>

			<div id="result"></div>
			<script type="text/javascript">
				$(window).ready(function() {
					vsf.jCheckbox('{$module->getAdmin()}','moduleIsAdmin');
					vsf.jCheckbox('{$module->getUser()}','moduleIsUser');
                                        vsf.jSelect('{$module->getParent()}','moduleParent');
				});
				$('#editVirtualForm').submit(function(){
					if(!$('#moduleTitle').val()){
						jAlert(
		        			'{$vsLang->getWords('page_virtualModule_empty','This field can not be empty!')}',
		        			'{$bw->vars['global_websitename']} Dialog'
	        			);
		        		$('#moduleTitle').focus();
						$('#moduleTitle').addClass('ui-state-error ui-corner-all-inner');
		        		return false;
					}
		        	vsf.submitForm($('#editVirtualForm'),'pages/editVirtual/', 'virtualTabContainer');
		        	return false;
				});
			</script>
EOF;
			return $BWHTML;
	}
}
?>