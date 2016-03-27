<?php
class skin_products extends skin_objectadmin{

	function objListHtml($objItems = array(), $option = array()) {
			global $bw, $vsLang, $vsSettings, $vsSetting, $tableName, $vsUser,$langObject;
			$BWHTML .= <<<EOF

					<div class="red">{$option['message']}</div>
					<form id="search-form">
					<div class='ui-dialog ui-widget ui-widget-content ui-corner-all'>
            <div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
            <span class="ui-icon ui-icon-note"></span>
            <span class="ui-dialog-title">Tiêu chí tìm kiếm</span>
          </div>
					<table cellspacing="1" cellpadding="1" id='search-form' width="100%">
						<input type='hidden' name='category-id' value='{$bw->input[2]}' />
						<tr>
							<th>{$langObject['itemObjTitle']}</th>
							<td><input name='search[title]' value='{$bw->input['serach']['title']}' /></td>
						</tr>
						<tr>
							<th>{$langObject['itemObjCode']}</th>
							<td><input name='search[code]' value='{$bw->input['serach']['code']}' /></td>
						</tr>
						<tr>
							<th>{$langObject['itemObjStatus']}</th>
							<td>
								<label for='status-1'>{$langObject['itemObjDisplay']}</label>
								<input name="search[status][1]" id="status-1" value='1' class='c_noneWidth' type="checkbox" />

								<label for='status-0'>{$langObject['itemListHide']}</label>
								<input name="search[status][0]" id="status-0" value='0' class='c_noneWidth' type="checkbox" />

								<label for='status-2'>{$langObject['itemListHome']}</label>
								<input name="search[status][2]" id="status-2" value='2' class='c_noneWidth' type="checkbox" />

								<label for='status-3'>Khuyến mãi</label>
								<input name="search[status][3]" id="status-3" value='3' class='c_noneWidth' type="checkbox" />
							</td>
						</tr>
						<tr>
							<th>{$langObject['itemObjPrice']}</th>
							<td>
								<input name='search[price][min]' value='{$bw->input['serach']['price-min']}' />
								<span> ~ </span>
								<input name='search[price][max]' value='{$bw->input['serach']['price-max']}' />
							</td>
						</tr>
						<tr>
							<td colspan='2' class="ui-dialog-buttonpanel" align="center">
								<input id='search-button' type="button" name="submit" value="Tìm kiếm" />
							</td>
						</tr>
					</table>
				</div>
				</form>
				<div id='obj-container'>
					{$this->objList($objItems, $option)}
				</div>

				<script>
					$('#search-button').click(function() {
						var url = '{$bw->input[0]}/search/';
						if ($('#search-form').data('current-page')) {
							url += $('#search-form').data('current-page');
						}
						vsf.submitForm($('#search-form'), url, 'obj-container');
					});
				</script>
	EOF;
		}

function objList($objItems = array(), $option = array()) {
		global $bw, $vsLang, $vsSettings, $vsSetting, $tableName, $vsUser,$langObject;

				$BWHTML .= <<<EOF
	<form id="obj-list-form">
	<input type="hidden" name="checkedObj" id="checked-obj" value="" />
	<input type="hidden" name="categoryId" value="{$option['categoryId']}" id="categoryId" />
	<div class='ui-dialog ui-widget ui-widget-content ui-corner-all'>
												<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
												<span class="ui-icon ui-icon-note"></span>
												<span class="ui-dialog-title">{$langObject['itemList']}</span>
												</div>
														<if=" $vsSettings->getSystemKey($bw->input['sett'].'_add_hide_show_delete',1, $bw->input['sett']) ">
														<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-corner-all-inner ui-widget-header">
																<li class="ui-state-default ui-corner-top" id="add-objlist-bt"><a href="#" title="{$langObject['itemListAdd']}">{$langObject['itemListAdd']}</a></li>
																<li class="ui-state-default ui-corner-top" id="hide-objlist-bt"><a href="#" title="{$langObject['itemListHide']}">{$langObject['itemListHide']}</a></li>
																<li class="ui-state-default ui-corner-top" id="visible-objlist-bt"><a href="#" title="{$langObject['itemListVisible']}">{$langObject['itemListVisible']}</a></li>
																<if=" $vsSettings->getSystemKey($bw->input['sett'].'_home',0, $bw->input['sett']) ">
																	 <li class="ui-state-default ui-corner-top" id="home-objlist-bt"><a href="#" title="{$langObject['itemListHome']}">{$langObject['itemListHome']}</a></li>
																</if>
																<li class="ui-state-default ui-corner-top" id="promote-objlist-bt"><a href="#" title="{$langObject['itemListAdd']}">Khuyến mãi</a></li>

																<li class="ui-state-default ui-corner-top" id="delete-objlist-bt"><a href="#" title="{$langObject['itemListDelete']}">{$langObject['itemListDelete']}</a></li>

																<if="$vsSettings->getSystemKey($bw->input['sett'].'_search_list',0, $bw->input['sett'])">
																<li class="ui-state-default ui-corner-top" id="insertSearch-objlist-bt"><a href="#" title="{$langObject['itemListInsertSearch']}">{$langObject['itemListInsertSearch']}</a></li>
																</if>
														</ul>
														</if>

			<table cellspacing="1" cellpadding="1" id='objListHtmlTable' width="100%">
				<thead>
						<tr>
								<th width="10"><input type="checkbox" onclick="vsf.checkAll()" onclicktext="vsf.checkAll()" name="all" /></th>
								<th width="60">{$langObject['itemListActive']}</th>
								<th>{$langObject['itemObjTitle']}</td>
								<th width="150">{$langObject['itemObjCode']}</td>
								<th width="150">{$langObject['itemObjPrice']}</td>
								<th width="30">{$langObject['itemObjIndex']}</th>
								<if=" $vsSettings->getSystemKey($bw->input['sett'].'_option', 0, $bw->input['sett'], 1, 1) ">
								<th width="80" align="center">{$langObject['itemListAction']}</th>
								</if>
						</tr>
				</thead>
				<tbody>
					<foreach="$objItems as $obj">
						<tr class="$vsf_class">
							<td align="center">
																	<if="!$vsSettings->getSystemKey($bw->input['sett'].'_code',0) && $obj->getCode()">
																			<img src="{$bw->vars['img_url']}/disabled.png" />
																		<else />
								<input type="checkbox" onclicktext="vsf.checkObject();" onclick="vsf.checkObject();" name="obj_{$obj->getId()}" value="{$obj->getId()}" class="myCheckbox" />
																	</if>
							</td>
							<td style='text-align:center'>{$obj->getStatus('image')}
							</td>
							<td>
								<a href="javascript:vsf.get('{$bw->input[0]}/add-edit-obj-form/{$obj->getId()}/&pageIndex={$bw->input[3]}&pageCate={$bw->input[2]}','obj-panel')"  class="editObj" >
								{$obj->getTitle()}
								</a>
							</td>
							<td>{$obj->getCode()}</td>
							<td>{$obj->getPrice(true, true)}</td>
							<td>{$obj->getIndex()}</td>
							<if=" $vsSettings->getSystemKey($bw->input['sett'].'_option', 0,$bw->input['sett'], 1, 1) ">
							<td>
								{$this->addOtionList($obj,$option['modulecomment'])}
							</td>
							</if>
						</tr>
					</foreach>
				</tbody>
				<tfoot>
					<tr>
						<th colspan='7'>
							<div style='float:right;' <if='$option['search']'>id='search-paging'</if>>{$option['paging']}</div>
						</th>
					</tr>
																										 <tr >
																									<th colspan='6' align="left">
																									<span style="padding-left: 10px;line-height:16px;"><img src="{$bw->vars['img_url']}/enable.png" /> {$langObject['itemListCurrentShow']}</span>
																									<span style="padding-left: 10px;line-height:16px;"><img src="{$bw->vars['img_url']}/disabled.png" /> {$langObject['itemListNotShow']}</span>
																									 <if=" $vsSettings->getSystemKey($bw->input['sett'].'_home',0, $bw->input['sett']) ">
																												<span style="padding-left: 10px;line-height:16px;"><img src="{$bw->vars['img_url']}/home.png" /> {$langObject['itemListHomeShow']}</span>
																									</if>
																												<span style="padding-left: 10px;line-height:16px;"><img src="{$bw->vars['img_url']}/promote.png" width='12' /> Khuyến mãi</span>
																									</th>
																						</tr>
				</tfoot>
			</table>
		</div>
	</form>
	<div class="clear" id="file"></div>

	{$this->addJavaScript()}
	<script>
		$('#search-paging a').click(function(event) {
			event.preventDefault();
			var link = $(this).attr('href');
			link = link.replace("javascript:vsf.get('products/search/",'');
			link = link.replace("','')",'');

			$('#search-form').data("current-page", link);
			$('#search-button').click();
			return false;
		})
	</script>
EOF;
}

function addEditObjForm($objItem, $option = array()) {
	global $vsLang, $bw,$vsSettings,$tableName,$langObject,$vsPrint,$vsMenu;
	$this->model = $vsMenu->getCategoryGroup('model')->getChildren();
	//$this->congsuatlientuc = $vsMenu->getCategoryGroup('congsuatlientuc')->getChildren();

		$BWHTML .= <<<EOF

			<div id="error-message" name="error-message"></div>
			<form id='add-edit-obj-form' name="add-edit-obj-form" method="POST" enctype='multipart/form-data'>
				<input type="hidden" id="obj-cat-id" name="{$tableName}CatId" value="{$option['categoryId']}" />
				<input type="hidden" name="{$tableName}Id" value="{$objItem->getId()}" />
				<input type="hidden" name="{$tableName}SEO" value="{$objItem->getSEO()}" />
				<input type="hidden" name="pageIndex" value="{$bw->input['pageIndex']}" />
				<input type="hidden" name="pageCate" value="{$bw->input['pageCate']}" />
	              	<input type="hidden" name="searchRecord" value="{$objItem->record}" />
	               	<input type="hidden" name="{$tableName}PostDate" value="{$objItem->getPostDate()}" />
	               	<input type="hidden" name="{$tableName}Image" value="{$objItem->getImage()}" />
	               	<input type="hidden" name="{$tableName}Author" value="{$objItem->getAuthor()}" />
	               	<input type="hidden" name="{$tableName}Module" value="{$bw->input['module']}" />
				<div class='ui-dialog ui-widget ui-widget-content ui-corner-all'>
					<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
						<span class="ui-dialog-title">{$option['formTitle']}</span>
                                                 <p style="float:right; cursor:pointer;">
                                                <span class='ui-dialog-title' id='closeObj'>
                                                 {$langObject['itemObjBack']}
                                                </span>
                                            </p>
					</div>
					<table class="ui-dialog-content ui-widget-content" style="width:98%;">

						<tr class='smalltitle'>
							<td class="label_obj" width="75">{$langObject['itemListTitle']}:</td>
							<td colspan="3">
								<input style="width:100%;" name="{$tableName}Title" value="{$objItem->getTitle()}" id="obj-title"/>
							</td>
						</tr>
                                                <tr class='smalltitle'>
							<td class="label_obj"  width="75">
								{$langObject['itemObjIndex']}:
							</td>
							<td width="170" colspan="3">
								<input size="10" class="numeric" name="{$tableName}Index" value="{$objItem->getIndex()}" />
							</td>
						</tr>



						<if="$vsSettings->getSystemKey($bw->input['sett'].'_author',0, $bw->input['sett'])">
						<tr class='smalltitle'>
							<td class="label_obj"  width="75">
								{$langObject['itemObjAuthor']}:
							</td>
							<td colspan="3">
								<input style="width:50%;" name="{$tableName}Author" value="{$objItem->getAuthor()}"/>
							</td>
						</tr>
						</if>

                     	<if="$vsSettings->getSystemKey($bw->input['sett'].'_code',0, $bw->input['sett'])">
						<tr class='smalltitle'>
							<td class="label_obj"  width="75">
								{$langObject['itemObjCode']}:
							</td>
							<td colspan="3">
								<input style="width:50%" name="{$tableName}Code" value="{$objItem->getCode()}"/>
							</td>
						</tr>
						</if>
						<if="$vsSettings->getSystemKey($bw->input['sett'].'_price',0, $bw->input['sett'])">
						<tr class='smalltitle'>
							<td class="label_obj"  width="75">
								{$langObject['itemObjPrice']}:
							</td>
							<td colspan="3">
								<input style="width:40" name="{$tableName}Price" value="{$objItem->getPrice()}"/>
							</td>
						</tr>
						</if>
						<if="$vsSettings->getSystemKey($bw->input['sett'].'_hotprice',0, $bw->input['sett'])">
						<tr class='smalltitle'>
							<td class="label_obj"  width="75">
								{$langObject['itemObjHotPrice']}:
							</td>
							<td colspan="3">
								<input style="width:40" name="{$tableName}HotPrice" value="{$objItem->getHotPrice()}"/>
							</td>
						</tr>
						</if>

						<tr class='smalltitle'>
							<td class="label_obj"  width="75">
								{$langObject['itemObjStatus']}:
							</td>
							<td width="170" colspan="3">
                <label>{$langObject['itemObjDisplay']}</label>
								<input name="{$tableName}Status" id="{$tableName}Status1" value='1' class='c_noneWidth' type="radio" checked />

								<label>{$langObject['itemListHide']}</label>
								<input name="{$tableName}Status" id="{$tableName}Status0" value='0' class='c_noneWidth' type="radio" />

								<label>{$langObject['itemListHome']}</label>
								<input name="{$tableName}Status" id="{$tableName}Status2" value='2' class='c_noneWidth' type="radio" />

								<label>Khuyến mãi</label>
								<input name="{$tableName}Status" id="{$tableName}Status3" value='3' class='c_noneWidth' type="radio" />
							</td>
						</tr>

						<if="$vsSettings->getSystemKey($bw->input['sett'].'_image',1, $bw->input['sett'])">
						<tr class='smalltitle'>
							<td class="label_obj">
								{$langObject['itemObjLink']}:
							</td>
							<td>
								<input onclick="checkedLinkFile($('#link-text').val());" onclicktext="checkedLinkFile($('#link-text').val());" type="radio" id="link-text" name="link-file" value="link" />
								<input size="39" type="text" name="txtlink" id="txtlink"/><br/>
								 {$vsSettings->getSystemKey($bw->input['sett']."_image_timthumb_size","(size:100x100px)", $bw->input['sett'])}
							</td>
							<td colspan="2" rowspan="2">
								{$objItem->createImageCache($objItem->getImage(), 100, 50)}
								<br/>
								<if=" $objItem->getImage() && $vsSettings->getSystemKey($bw->input['sett'].'_image_delete',1, $bw->input['sett']) ">
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
								 <!--{$vsSettings->getSystemKey($bw->input['sett']."_image_timthumb_size","(size:100x100px)", $bw->input['sett'])}-->
							</td>
						</tr>
						</if>
						<if=" $vsSettings->getSystemKey($bw->input['sett'].'_urlvideo',0, $bw->input['sett']) ">
						<tr class='smalltitle'>
							<td class="label_obj"  width="75">
								{$vsLang->getWords("obj_url","Url video")}:
							</td>
							<td colspan="3">
								<input style="width:100%;" name="{$tableName}UrlVideo" value="{$objItem->getUrlVideo()}"/>
							</td>
						</tr>
						</if>


						<if=" $vsSettings->getSystemKey($bw->input['sett'].'_intro',1, $bw->input['sett']) ">
						<tr class='smalltitle'>
							<td class="label_obj" width="75">
								{$langObject['itemObjIntro']}:
							</td>
							<td colspan="3" valgin="left">
								{$objItem->getIntro()}
							</td>
						</tr>
						</if>

						<if="$vsSettings->getSystemKey($bw->input['sett'].'_content',1, $bw->input['sett'])">
						<tr class='smalltitle'>
							<td colspan="4" align="center">{$objItem->getContent()}</td>
						</tr>
						</if>
						<if="$vsSettings->getSystemKey($bw->input['sett'].'_tags',0, $bw->input['sett'])">
						<tr class='smalltitle' >
							<td class="label_obj"  width="75">
								Tags:
							</td>
							<td colspan="3" valgin="left">
								<div id="tag_panel_diplay">
								<script src='{$bw->base_url}tags/get_tag_for_obj/{$bw->input[0]}/{$objItem->getId()}'>
								</script>
								</div>
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
}
?>
