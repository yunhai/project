<?php
class skin_products extends skin_objectadmin{


	function addEditObjForm($objItem, $option = array()) {
		global $vsLang, $bw,$vsSettings,$tableName,$langObject, $vsMenu;
		$option['phukien'] = $vsMenu->getCategoryGroup("phukien")->getChildren();
		
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
							<td class="label_obj" width="75">{$langObject['itemListTitle']}:</td>
							<td colspan="3">
								<input style="width:100%;" name="{$tableName}Title" value="{$objItem->getTitle()}" id="obj-title"/>
							</td>
						</tr>
						
						<if=" $vsSettings->getSystemKey($bw->input[0].'_price', 1, $bw->input[0]) ">
						<tr class='smalltitle'>
							<td class="label_obj" width="75">{$vsLang->getWords('itemListPrice',"Price")}:</td>
							<td colspan="3">
								<input width="75" name="{$tableName}Price" value="{$objItem->getPrice()}" id="obj-title"/>
							</td>
						</tr>
						</if>
						
                     	<if="$vsSettings->getSystemKey($bw->input[0].'_code',0, $bw->input[0])">
						<tr class='smalltitle'>
							<td class="label_obj" width="75">
								{$langObject['itemObjCode']}:
							</td>
							<td colspan="3">
								<input style="width:40" name="{$tableName}Code" value="{$objItem->getCode()}"/>
							</td>
						</tr>
						</if>
						
						<tr class='smalltitle'>
							<td class="label_obj" width="75">
								{$langObject['itemObjIndex']}:
							</td>
							<td width="170" colspan="3">
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
						</tr>
						
						<if="$vsSettings->getSystemKey($bw->input[0].'_image', 1, $bw->input[0])">
						<tr class='smalltitle'>
							<td class="label_obj">
								{$langObject['itemObjLink']}:
							</td>
							<td>
								<input onclick="checkedLinkFile($('#link-text').val());" onclicktext="checkedLinkFile($('#link-text').val());" type="radio" id="link-text" name="link-file" value="link" />
								<input size="39" type="text" name="txtlink" id="txtlink"/><br/>
								 {$vsSettings->getSystemKey($bw->input[0]."_image_timthumb_size","(size:100x100px)", $bw->input[0])}
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

						<tr class='smalltitle'>
							<td class="label_obj">
								{$langObject['itemObjFile']}:
							</td>
							<td>
								<input onclick="checkedLinkFile($('#link-file').val());" onclicktext="checkedLinkFile($('#link-file').val());" type="radio" id="link-file" name="link-file" value="file" checked="checked"/>
								<input size="27" type="file" name="{$tableName}IntroImage" id="{$tableName}IntroImage" /><br />
								 <!--{$vsSettings->getSystemKey($bw->input[0]."_image_timthumb_size","(size:100x100px)", $bw->input[0])}-->
							</td>
						</tr>						
						</if>
						
						<tr class='smalltitle'>
							<td class="label_obj" width="75">{$vsLang->getWords('itemLabel',"Label")}:</td>
							<td colspan="3">
								<input style="width:100%;" name="{$tableName}Label" value="{$objItem->getLabel()}" />
							</td>
						</tr>
						
						<tr class='smalltitle'>
							<td class="label_obj" width="75">{$vsLang->getWords('itemModel',"Model")}:</td>
							<td colspan="3">
								<input style="width:100%;" name="{$tableName}Model" value="{$objItem->getModel()}" "/>
							</td>
						</tr>
						
						<if=" $vsSettings->getSystemKey($bw->input[0].'_intro', 1, $bw->input[0]) ">
						<tr class='smalltitle'>
							<td class="label_obj" width="75">
								{$langObject['itemObjIntro']}:
							</td>
							<td colspan="3" valgin="left">
								{$objItem->getIntro()}
							</td>
						</tr>
						</if>
						
						<tr class='smalltitle'>
							<td class="label_obj" width="75">
								{$vsLang->getWords('product_spec', 'Spec')}:
							</td>
							<td colspan="3" valgin="left">
								{$objItem->getSpec()}
							</td>
						</tr>
						
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
					checkedLinkFile();
					vsf.jRadio('{$objItem->getStatus()}','{$tableName}Status');
					vsf.jSelect('{$objItem->getCatId()}','obj-category');
				});
				
				$('#txtlink').change(function() {
					var img_html = '<img src="'+$(this).val()+'" style="width:100px; max-height:115px;" />'; 
					$('#td-obj-image').html(img_html);
				});
				
				$('#{$tableName}IntroImage').change(function() {
					var img_name = '<input type="hidden" id="image-name" name="image-name" value="'+$(this).val() +'"/>';
					$('#td-obj-image').html(img_name);
				});
				
				function checkedLinkFile(value){
					if(value=='link'){
						$("#txtlink").removeAttr('disabled');
						$("#{$tableName}IntroImage").attr('disabled', 'disabled');
					}else{
						$("#txtlink").attr('disabled', 'disabled');
						$("#{$tableName}IntroImage").removeAttr('disabled');
					}
				}
				
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