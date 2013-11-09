<?php
class skin_supports extends skin_objectadmin{
	function objListHtml($objItems = array(), $option = array()) {
		global $bw, $vsLang, $vsSettings,$langObject;
		$BWHTML .= <<<EOF
			<div class="red">{$option['message']}</div>
			<form id="obj-list-form">
				<input type="hidden" name="checkedObj" id="checked-obj" value="" />
				<input type="hidden" name="categoryId" value="{$option['categoryId']}" id="categoryId" />
				<div class='ui-dialog ui-widget ui-widget-content ui-corner-all'>
				    <div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
				        <span class="ui-icon ui-icon-note"></span>
				        <span class="ui-dialog-title">{$vsLang->getWords('obj_objListHtmlTitle',"Support Item List")}</span>
				    </div>
				    <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-corner-all-inner ui-widget-header">
				    	<li class="ui-state-default ui-corner-top">
				    		<a href="#" title="{$vsLang->getWords('support_nick',"Add Nick")}" onclick="addPage();" id="addPage">
								{$vsLang->getWords('support_nick',"Add Nick")}
							</a>
						</li>
				    	<li class="ui-state-default ui-corner-top">
                                            <a id="hide-objlist-bt" title="{$langObject['itemListHide']}" onclick="displayPage(0);" href="#">
                                                {$langObject['itemListHide']}
                                            </a>
                                        </li>
				   	<li class="ui-state-default ui-corner-top">
                                            <a id="visible-objlist-bt" title="{$langObject['itemListVisible']}" onclick="displayPage(1);" href="#">
                                                {$langObject['itemListVisible']}
                                            </a>
                                        </li>

				       <li class="ui-state-default ui-corner-top">
				        	<a id="delete-objlist-bt" title="{$langObject['itemListDelete']}" onclick="deletePage();" href="#">
				        	{$langObject['itemListDelete']}
							</a>
						</li>
				    </ul>
					<table cellspacing="1" cellpadding="1" id='objListHtmlTable' width="100%">
						<thead>
						    <tr>
						        <th width="15"><input type="checkbox" onclick="vsf.checkAll()" onclicktext="checkAll()" name="all" /></th>
						        <th width="50">{$langObject['itemListActive']}</th>
						        <th>{$vsLang->getWords('support_nickname', 'Nick name')}</td>
						        <th width="50">{$langObject['itemListIndex']}</th>

						        <if=" $vsSettings->getSystemKey($bw->input[0].'_option', 0, "supports", 1, 1) ">
						        <th width="100">{$langObject['itemListOption']}</th>
						        </if>
						    </tr>
						</thead>
						<tbody>
							<if=" count($objItems) ">
							<foreach=" $objItems as $obj ">
								<tr class="$class">
									<td align="center">
										<input type="checkbox" onclick="vsf.checkObject();" name="obj_{$obj->getId()}" value="{$obj->getId()}" class="myCheckbox" />
									</td>
									<td align="center">
										{$obj->getStatus("image")}
									</td>
									<td>
										<a href="#" onclick="editPage({$obj->getId()})"  class="editObj" >
											{$obj->getNick()}
										</a>
									</td>
									<td align="center">{$obj->getIndex()}</td>
									<if=" $vsSettings->getSystemKey($bw->input[0].'_option', 0, "supports", 1, 1) ">
									<td></td>
									</if>
								</tr>
							</foreach>
							</if>
						</tbody>
                                                <tfoot>
							<tr>
								<th colspan='5'>
									<div style='float:right;'>{$option['paging']}</div>
								</th>
							</tr>
                                                        <tr>
								<th colspan='5'>
									<span style="padding-left: 10px;line-height:16px;"><img src="{$bw->vars['img_url']}/enable.png" /> {$langObject['itemListCurrentShow']}</span>
                                                                        <span style="padding-left: 10px;line-height:16px;"><img src="{$bw->vars['img_url']}/disabled.png" /> {$langObject['itemListNotShow']}</span>
								</th>
							</tr>
						</tfoot>
					</table>
                                        {$option['info']}
				</div>
			</form>
		<script type="text/javascript">
				function addPage(){
					vsf.get('{$bw->input[0]}/add-edit-obj-form/&pageIndex={$bw->input[3]}&pageCate={$bw->input[2]}','obj-panel');
				}

				$('#hide-objlist-bt').click(function() {
					if(vsf.checkValue())
                                            vsf.get('{$bw->input[0]}/hide-checked-obj/'+$('#checked-obj').val()+'/'+ $("#idCategory").val() +'/&pageIndex={$bw->input[3]}&pageCate={$bw->input[2]}', 'obj-panel');
				});

				$('#visible-objlist-bt').click(function() {
					if(vsf.checkValue())
                                            vsf.get('{$bw->input[0]}/visible-checked-obj/'+$('#checked-obj').val()+'/'+ $("#idCategory").val() +'/&pageIndex={$bw->input[3]}&pageCate={$bw->input[2]}', 'obj-panel');
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

				function editPage(id){
					vsf.get('{$bw->input[0]}/add-edit-obj-form/'+id,'obj-panel');
					return false;
				}

		</script>

EOF;
	}

	function addEditObjForm($objItem, $option = array()) {
		global $vsLang, $bw, $vsSettings,$langObject;
		$option['setting'] = $vsSettings;
		$option['bw'] = $bw;

		$BWHTML .= <<<EOF
			<div id="error-message" name="error-message"></div>
			<form id='add-edit-obj-form' name="add-edit-obj-form" method="POST"  enctype='multipart/form-data'>
				<input type="hidden" id="obj-cat-id" name="supportCatId" value="{$option['categoryId']}" />
				<input type="hidden" name="supportId" value="{$objItem->getId()}" />
				<input type="hidden" id="pageCate" name="pageCate" value="{$bw->input['pageCate']}" />
				<input type="hidden" id="pageIndex" name="pageIndex" value="{$bw->input['pageIndex']}" />
				<div class='ui-dialog ui-widget ui-widget-content ui-corner-all'>
					<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
						<span class="ui-dialog-title">{$option['formTitle']}</span>
						<p style="float:right; cursor:pointer;">
							<span class='ui-dialog-title' id='close'>
								{$langObject['itemObjBack']}
							</span>
						</p>
					</div>
					<table class="ui-dialog-content ui-widget-content">
						<if=" $vsSettings->getSystemKey($bw->input[0].'_nick',1, "supports", 1, 1) ">
						<tr>
							<td class="label_obj">{$vsLang->getWords('support_nickname', 'Nick name')}:</td>
							<td><input size="35" type="text" name="supportNick" value="{$objItem->getNick()}" id="obj-nick"/></td>
						</tr>
						</if>

						<if=" $vsSettings->getSystemKey($bw->input[0].'_title',1, "supports", 1, 1) ">
						<tr>
							<td class="label_obj">{$vsLang->getWords('support_title', 'Title')}:</td>
							<td><input size="35" type="text" name="supportTitle" value="{$objItem->getTitle()}" id="obj-nick"/></td>
						</tr>
						</if>
						
						<if=" $vsSettings->getSystemKey($bw->input[0].'_index', 1, "supports", 1, 1) ">
						<tr>
							<td class="label_obj">{$langObject['itemObjIndex']}:</td>
							<td><input size="4" type="text" name="supportIndex" value="{$objItem->getIndex()}" id="obj-Index" class="numeric"/></td>
						</tr>
						</if>

						<if=" $vsSettings->getSystemKey($bw->input[0].'_type', 1, "supports", 1, 1) ">
						<tr>
							<td class="label_obj">{$langObject['itemObjType']}:</td>
							<td>
								<select name="supportType" id="supportType">
									<option value="1"> Skype </option>
									<option value="2"> Yahoo </option>
								</select>
							</td>
						</tr>
						</if>

						<if=" $vsSettings->getSystemKey($bw->input[0].'_image', 0, "supports", 1, 1) ">
						<tr>
							<td class="label_obj">{$vsLang->getWords('support_Avatar', "Avatar")}:</td>
							<td>
								<input size="27" type="file" name="avatar" id="avatar" />
							</td>
						</tr>
						<tr>
							<td class="label_obj" colspan="2" align="left">
								{$objItem->createImageCache($objItem->getAvatar(), $vsSettings->getSystemKey($bw->input[0]."_image_timthumb_width", 100, $bw->input[0], 1, 1), $vsSettings->getSystemKey($bw->input[0]."_image_timthumb_height", 100, $bw->input[0], 1, 1), $vsSettings->getSystemKey($bw->input[0]."_image_timthumb_type", 0, $bw->input[0], 1, 1), $vsSettings->getSystemKey($bw->input[0]."_image_timthumb_noimage", 0, $bw->input[0], 1, 1))}<br />
							</td>
						</tr>
						</if>


						<if=" $vsSettings->getSystemKey($bw->input[0].'_intro', 0, "supports", 1, 1) ">
						<tr>
							<td class="label_obj">{$langObject['itemObjIntro']}:</td>
							<td colspan="2">{$objItem->getIntro()}</td>
						</tr>
						</if>

						<if=" $vsSettings->getSystemKey($bw->input[0].'_nickicon', 1, "supports", 1, 1) ">
						<tr>
							<td class="label_obj">{$vsLang->getWords('support_icon_online','Icon Online')}:</td>
							<td colspan="4" align="center">
							<if="count($option['icon_online'])">
							<foreach="$option['icon_online'] as $icon">
								<p class="nickicon" style="width:auto">
									<input type="radio" value="{$icon->getId()}" name="supportImageOnline" >
									<span>
										{$icon->createImageCache($icon->getFileId(), $option['setting']->getSystemKey($option['bw']->input[0]."_icon_timthumb_width", 60, $option['bw']->input[0], 1, 1), $option['setting']->getSystemKey($option['bw']->input[0]."_icon_timthumb_height", 20, $option['bw']->input[0], 1, 1), $option['setting']->getSystemKey($option['bw']->input[0]."_icon_timthumb_type", 0, $option['bw']->input[0], 1, 1), $option['setting']->getSystemKey($option['bw']->input[0]."_icon_timthumb_noimage", 0, $option['bw']->input[0], 1, 1))}<br />
									</span>
								</p>
							</foreach>
							</if>
							</td>
						</tr>
						<tr>
                                                <td class="label_obj">{$vsLang->getWords('support_icon_offline','Icon Offline')}:</td>
                                                <td colspan="4" align="center">
                                                <if="count($option['icon_offline'])">
                                                <foreach="$option['icon_offline'] as $icon">
                                                        <p class="nickicon" style="width:auto">
                                                                <input type="radio" value="{$icon->getId()}"  name="supportImageOffline" >
                                                                <span>
                                                                        {$icon->createImageCache($icon->getFileId(), $option['setting']->getSystemKey($option['bw']->input[0]."_icon_timthumb_width", 60, $option['bw']->input[0], 1, 1), $option['setting']->getSystemKey($option['bw']->input[0]."_icon_timthumb_height", 20, $option['bw']->input[0], 1, 1), $option['setting']->getSystemKey($option['bw']->input[0]."_icon_timthumb_type", 0, $option['bw']->input[0], 1, 1), $option['setting']->getSystemKey($option['bw']->input[0]."_icon_timthumb_noimage", 0, $option['bw']->input[0], 1, 1))}<br />
                                                                </span>
                                                        </p>
                                                </foreach>
                                                </if>
                                                </td>
						</tr>
						</if>

						<if=" $vsSettings->getSystemKey($bw->input[0].'_status', 1, "supports", 1, 1) ">
						<tr>
							<td class="label_obj">{$langObject['itemObjStatus']}:</td>
							<td>
								{$langObject['itemObjDisplay']}
		            			<input name="supportStatus" type="radio" class='checkbox' value="1" />

								{$langObject['itemObjHide']}
		            			<input name="supportStatus" type="radio" class='checkbox' value="0" />
							</td>
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
			<script type="text/javascript">
					vsf.jSelect('{$objItem->getCatId()}',"obj-category");
					vsf.jSelect('{$objItem->getType()}',"supportType");
					vsf.jRadio('{$objItem->getStatus()}',"supportStatus");


					<if="count($option['icon_offline'])">
						<foreach="$option['icon_offline'] as $key=>$icon">
							vsf.jRadio('{$objItem->getImageOffline()}','supportImageOffline');
						</foreach>
					</if>
					<if="count($option['icon_online'])">
						<foreach="$option['icon_online'] as $key=>$icon">
							vsf.jRadio('{$objItem->getImageOnline()}','supportImageOnline');
						</foreach>
					</if>


				$(window).ready(function(){
					$("input.numeric").numeric();
                   $('#close').click(function(){
					vsf.get('supports/display-obj-list/{$objItem->getCatId()}','obj-panel');
					});
					$('#obj-category').removeClass('ui-state-error ui-corner-all-inner');
                });

				$('#add-edit-obj-form').submit(function(){
					var flag  = true;
					var error = "";
					var categoryId = 0;
					var count=0;
					$("#obj-category  option").each(function () {
						count++;
					});
					$("#obj-category option:selected").each(function () {
						categoryId = $(this).val();
					});
					$('#obj-cat-id').val(categoryId);
					if(categoryId == null && count){
						error = "<li>{$langObject['itemListChoiseCate']}</li>";
						flag  = false;
					}

					if({$vsSettings->getSystemKey($bw->input[0].'_category_list', 1, "supports", 1, 1)})
                       if(!($("#obj-category option:selected").val()&&$("#obj-category option:selected").val()!=0)){
                           error = "<li>{$langObject['itemListChoiseCate']}</li>";
                           flag  = false;
                           $('#obj-category').addClass('ui-state-error ui-corner-all-inner');
                      }

					var title = $("#obj-nick").val();
					if(title == null || title == ""){
						error += "<li>{$langObject['notItemObjTitle']}</li>";
						flag  = false;
						$('#obj-nick').addClass('ui-state-error ui-corner-all-inner');
					}

					if(!flag){
						error = "<ul class='ul-popu'>" + error + "</ul>";
						alertError(error);
						return false;
					}

					vsf.uploadFile("add-edit-obj-form", "{$bw->input[0]}", "add-edit-obj-process", "obj-panel","{$bw->input[0]}");
					return false;
				});

				function updateobjListHtml(categoryId){
					vsf.get('{$bw->input[0]}/display-obj-list/'+categoryId+'/','obj-panel');
				}
				function alertError(message){
					jAlert(
						message,
						'{$bw->vars['global_websitename']} Dialog'
					);
				}
			</script>
EOF;
	}
function managerObjHtml() {
		global $bw, $vsLang,$vsSettings,$langObject;
		$BWHTML .= <<<EOF
			<div id="page_tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all-top">
				<ul id="tabs_nav" class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-corner-all-inner">
			    	<li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active">
			        	<a href="{$bw->base_url}{$bw->input[0]}/display-obj-tab/&ajax=1"><span>{$vsLang->getWords('tab_obj_objes',"{$bw->input[0]}")}</span></a>
			        </li>
					<if="$vsSettings->getSystemKey('supports_category_tab',0, "supports", 1, 1)">
						<li class="ui-state-default ui-corner-top">
				        	<a href="{$bw->base_url}menus/display-category-tab/{$bw->input[0]}/&ajax=1"><span>{$langObject['categoriesTitle']}</span></a>
				        </li>
			        </if>
			        <if="$vsSettings->getSystemKey('supports_nickicon_tab',0, "supports", 1, 1)">
			        <li class="ui-state-default ui-corner-top">
			        	<a href="{$bw->base_url}menus/display-category-tab/nickicons/&ajax=1"><span>{$vsLang->getWords('support_nickicons','Tiện ích')}</span></a>
			        </li>
			       </if>
			        <if="$vsSettings->getSystemKey('supports_setting_tab',0, "supports", 1, 1)">
				        <li class="ui-state-default ui-corner-top">
				        	<a href="{$bw->base_url}settings/moduleObjTab/{$bw->input[0]}/&ajax=1">
								<span>{$vsLang->getWords("tab_{$bw->input[0]}_Setting",'Support Settings')}</span>
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