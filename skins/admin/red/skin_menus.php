<?php
class skin_menus {
function MainPage() {
global $bw, $vsLang;
$BWHTML = "";
//--starthtml--//
$BWHTML .= <<<EOF
<div id="page_tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all-top">
	<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all-inner">
        <li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active"><a href="{$bw->base_url}menus/viewuser/&ajax=1"><span>{$vsLang->getWords('menu_user',"User menus")}</span></a></li>
        <li class="ui-state-default ui-corner-top"><a href="{$bw->base_url}menus/viewadmin/&ajax=1"><span>{$vsLang->getWords('menu_admin',"Admin menus")}</span></a></li>
    </ul>
</div>
EOF;
return $BWHTML;	
}

function addEditMenuForm($form = array(), $message = "", $menu) {
global $vsLang, $vsMenu,$bw;
$BWHTML = "";
if($form['type']) {
	$switchForm = <<<EOF
<input class="button" type="button" value="{$vsLang->getWords('menu_bt_switch_add',"Form Add")}" name="switch" onclick="vsf.get('menus/addmenuform/','addeditform_{$menu->isAdmin}');" />
EOF;
}
if(!$menu->getId())
{	$menu->type=0;
	$menu->status=1;
	$menu->isLink=1;
	$menu->isDropdown=0;
}
$pMain		= $menu->main?'checked ':'';
$pTop 		= $menu->top?'checked ':'';
$pRight 	= $menu->right?'checked ':'';
$pBottom 	= $menu->bottom?'checked ':'';
$pLeft 		= $menu->left?'checked ':'';

$BWHTML .= <<<EOF
<div class="ui-dialog ui-widget ui-widget-content ui-corner-all" style="min-height:400px;">
	<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
    	<span class="ui-dialog-title">{$vsLang->getWords('group_box_title','Group Admin List')}</span>
    </div>
    <div class="red">{$message}</div>
<form method="post" name="form" id="addEditMenu_{$menu->isAdmin}"  enctype="multipart/form-data">
<input type="hidden" name="formType" value="{$form['type']}" />
<input type="hidden" name="ID" id="ID" value="{$menu->id}" />
<input type="hidden" name="menuIsAdmin" id="menuIsAdmin_{$menu->isAdmin}" value="{$menu->isAdmin}" />
<input type="hidden" name="parentId" id="parentId_{$menu->isAdmin}" value="{$menu->parentId}" />
<table cellpadding="0" cellspacing="1" width="100%">
<thead>
	<tr>
    	<th colspan="4">{$form['title']}</th>
	</tr>
</thead>
<tr>
    <td>{$vsLang->getWords('menu_form_name',"Name")}</td>
    <td><input type="text" value="{$menu->title}" name="menuTitle" id="menuTitle{$menu->isAdmin}" size="35" /></td>
    <td>{$vsLang->getWords('menu_form_visible',"Visible")}</td>
    <td>
       <input type="radio" class="checkbox " id="menuStatus_first" name="menuStatus" value="1" />
       <label for="menuStatus_first">{$vsLang->getWords('menu_form_yes',"Yes")}</label>
       <div class="clear"></div>
       <input type="radio" class="checkbox" id="menuStatus_last" name="menuStatus" value="0" />
       <label for="menuStatus_last">{$vsLang->getWords('menu_form_no',"No")}</label>
    </td>
</tr>
<tr>
    <td>{$vsLang->getWords('menu_form_link',"Url")}</td>
    <td><input type="text" value="{$menu->url}" name="menuUrl" size="35" /></td>
    <td>{$vsLang->getWords('menu_form_index',"Index")}</td>
    <td><input type="text" name="menuIndex" size="3" value="{$menu->index}" /></td>
</tr>
<tr>
    <td>{$vsLang->getWords('menu_form_type',"Type")}</td>
    <td>
        <input type="radio" class="checkbox" name="menuType" value="1" />
        <label for="menuType_first">{$vsLang->getWords('menu_form_external',"External")}</label>
        <div class="clear"></div>
        <input type="radio" class="checkbox"  name="menuType" value="0" />
        <label for="menuType_last">{$vsLang->getWords('menu_form_internal',"Internal")}</label>
    </td>
    <td> {$vsLang->getWords('menu_form_islink',"Is link")}</td>
    <td>
        <input type="radio" class="checkbox" name="menuIsLink" value="1" />
        <label for="menuIsLink_first">{$vsLang->getWords('menu_form_yes',"Yes")}</label>
        <div class="clear"></div>
        <input type="radio" class="checkbox" name="menuIsLink" value="0"/>
        <label for="menuIsLink_last">{$vsLang->getWords('menu_form_no',"No")}</label>
    </td>
</tr>
<tr>
    <td>{$vsLang->getWords('menu_form_alt',"Description")}</td>
    <td><textarea name="menuAlt" style="width:230px; height: 75px;">{$menu->alt}</textarea></td>
    <td>{$vsLang->getWords('menu_form_dropdown',"Dropdown")}</td>
    <td>
         <input type="radio" class="checkbox" name="menuIsDropdown" value="1" /> 
         <label for="menuIsDropDown_first">{$vsLang->getWords('menu_form_yes',"Yes")}</label>
         <div class="clear"></div>
         <input type="radio" class="checkbox" name="menuIsDropdown" value="0"/>
         <label for="menuIsDropDown_last">{$vsLang->getWords('menu_form_no',"No")}</label>
    </td>
</tr>
<tr>
    <td>{$vsLang->getWords('menu_form_position',"Position")}</td>
    <td>
    	 <input type="checkbox"  class="checkbox" id="main" name="posMain" value='1' {$pMain} />
        <label for="main">{$vsLang->getWords('menu_form_main',"Main")}</label>
        <div class="clear"></div>
        <input type="checkbox"  class="checkbox" id="top" name="posTop" value='1' {$pTop} />
        <label for="top">{$vsLang->getWords('menu_form_top',"Top")}</label>
        <div class="clear"></div>
        <input type="checkbox"  class="checkbox" id="right" name="posRight" value='1' {$pRight} />
        <label for="right">{$vsLang->getWords('menu_form_right',"Right")}</label>
        <div class="clear"></div>
        <input type="checkbox"  class="checkbox" id="bottom" name="posBottom" value='1' {$pBottom} />
        <label for="bottom">{$vsLang->getWords('menu_form_bottom',"Bottom")}</label>
        <div class="clear"></div>
        <input type="checkbox"  class="checkbox" id="left" name="posLeft" value='1' {$pLeft} />
        <label for="left">{$vsLang->getWords('menu_form_left',"Left")}</label>
    </td>
    <td colspan="2" align="center" class="ui-dialog-buttonpanel">{$switchForm} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<input class="ui-state-default ui-corner-all" type="submit" name="submit" value="{$form['submit']}" /></td>
</tr>
<if="$menu->getBackup()">
	<tr>
	    <td> {$vsLang->getWords('menu_form_backup',"Retore Link")}</td>
	    <td>
	        <input type="checkbox" class="checkbox" id="menuRetore" name="menuRetore" value="1" />
	        &nbsp; <b>Current link</b>: {$menu->getUrl()}
	    </td>
	    <td  colspan="2">
	       <b>Real link</b>: <span style="color:red">{$menu->getBackup()}</span>
	    </td>
    </tr>
    </if>
<tr>
	<td>{$vsLang->getWords('obj_image_image', "Image")}</td>
	<td>
		<input size="27" type="file" name="menuImage" id="menuImage"/>
	</td >
	<td colspan="2"  align="center">
		{$menu->createImageCache($menu->getFileId(),30,30)}
	</td>
</tr>
</table>
</form>
</div>
<div class="clear"></div>
<script>
	$(window).ready(function() {
		vsf.jRadio('{$menu->getStatus()}','menuStatus');
		vsf.jRadio('{$menu->getType()}','menuType');
		vsf.jRadio('{$menu->getIsDropdown()}','menuIsDropdown');
		vsf.jRadio('{$menu->getIsLink()}','menuIsLink');
	});
	$('#addEditMenu_{$menu->isAdmin}').submit(function(){
		if(!$("#menuTitle{$menu->isAdmin}").val()){
			vsf.alert("{$vsLang->getWords('null_title', 'Tiêu đề không được để trống!!!')}");
			return false;
		}
		
		vsf.uploadFile("addEditMenu_{$menu->isAdmin}","{$bw->input[0]}", "addeditmenu/", "addeditform_{$menu->isAdmin}","menus");
		
		vsf.get('menus/getmenulist/{$menu->isAdmin}','menulist_{$menu->isAdmin}');
		return false;
	});
</script>
EOF;
//--endhtml--//

return $BWHTML;
    }

function objList($menulist = "", $bt_buildCache=false, $message = "") {
global $vsLang, $bw;
$BWHTML = "";
//--starthtml--//

if($bt_buildCache) 
$buildCache = <<<EOF
<a href="#" onclick="vsf.get('menus/buildcache/','menulist_{$bw->typemenu}'); return false;" title="{$vsLang->getWords('menu_form_build_cache',"Build cache")}">
    <img src="{$bw->vars['img_url']}/cache.png" />
</a>
EOF;

$BWHTML .= <<<EOF
<script type="text/javascript">
function setValue_{$bw->typemenu}(id) {
	$('#'+id).val($('#slmenu_{$bw->typemenu}').val());
}

function deleteMenu_{$bw->typemenu}() {
	if($('#slmenu_{$bw->typemenu}').val() > 0) {
		jConfirm(
			'{$vsLang->getWords("pages_deleteConfirm","Are you sure to delete these page information?")}', 
			'{$bw->vars['global_websitename']} Dialog', 
			function(r){
				if(r){
					vsf.get('menus/deletemenu/'+$('#slmenu_{$bw->typemenu}').val()+'/','menulist_{$bw->typemenu}');
				}
			}
		);
	}
	else {
		jAlert(
			"{$vsLang->getWords('menu_select_to_delete',"Please select a menu to delete!")}",
			"{$bw->vars['global_websitename']} Dialog"
		);
		return false;
	}
}

function editMenu_{$bw->typemenu}() {
	if($('#slmenu_{$bw->typemenu}').val() > 0) {
		vsf.get('menus/editmenu/'+$('#slmenu_{$bw->typemenu}').val()+'/','addeditform_{$bw->typemenu}');
	}
	else {
		jAlert(
			"{$vsLang->getWords('menu_select_to_edit',"Please select a menu to edit!")}",
			"{$bw->vars['global_websitename']} Dialog"
		);
		return false;
	}
}
</script>
<div class="ui-dialog ui-widget ui-widget-content ui-corner-all2">
	<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
    	<span class="ui-dialog-title">{$vsLang->getWords('menu_form_menulist','Menu list')}</span>
    </div>
    <div class="error">{$message}</div>
    <table cellpadding="0" cellspacing="0" width="100%">
    	<tr>
        	<td class="ui-dialog-buttonpanel">
            	<a href="#" onclick="deleteMenu_{$bw->typemenu}(); return false;" title="{$vsLang->getWords('menu_form_delete',"Delete")}">
                	<img src="{$bw->vars['img_url']}/del.png" />
                </a>
                <a href="#" onclick="editMenu_{$bw->typemenu}(); return false;" title="{$vsLang->getWords('menu_form_edit',"Edit")}">
                	<img src="{$bw->vars['img_url']}/edit.png" />
                </a>
            {$buildCache}
            </td>
        </tr>
        <tr align="center">
        	<td class="ui-dialog-selectpanel">
            <select multiple="multiple" style="width:281px" onchange="setValue_{$bw->typemenu}('parentId_{$bw->typemenu}');" id="slmenu_{$bw->typemenu}" size="20">{$menulist}</select>
            </td>
		</tr>
    </table>
</div>
<div class="clear"></div>
EOF;
//--endhtml--//

return $BWHTML;	
}

function objMain($menulist, $addeditform) {
global $bw;
$BWHTML = "";
//--starthtml--//

$BWHTML .= <<<EOF
<div id="menulist_{$bw->typemenu}" class="left-cell">{$menulist}</div>
<div id="addeditform_{$bw->typemenu}" class="right-cell">{$addeditform}</div>
<div class="clear"></div>
EOF;
//--endhtml--//

return $BWHTML;
}

function getSimpleListCatHtml($data,$categoryGroup) {
		global $vsLang, $bw;
		$temp = "";
		if($bw->input[0]=="reals") $temp = $bw->input[0]."_";
		$BWHTML = "";
		$BWHTML .= <<<EOF
			<div class="ui-dialog ui-widget ui-widget-content ui-corner-all">
				<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
				    <span class="ui-dialog-title">{$vsLang->getWords($temp.'category_table_title_header','Categories')}</span>
				</div>
				<div id="category-message{$categoryGroup->getUrl()}">{$data['message']}{$vsLang->getWords($temp.'category_chosen',"Selected categories")}: {$vsLang->getWords('category_not_selected',"None")}</div>
				<table width="100%" class="ui-dialog-content ui-widget-content" cellpadding="0" cellspacing="0">
				    <tr>
				        <td width="200">
							{$data['html']}
				        </td>
				    </tr>
				</table>
			</div>
		<script type="text/javascript">
			function setValue_category{$categoryGroup->getUrl()}() {
				var currentId = '';
				var parentId = '';
				$("#menus-category{$categoryGroup->getUrl()} option:selected").each(function () {
				    currentId += $(this).val() + ',';
				    parentId = $(this).val();
				});
				
				currentId = currentId.substr(0, currentId.length-1);
				$("#category-message{$categoryGroup->getUrl()}").html('{$vsLang->getWords('category_chosen',"Selected categories")}:'+currentId);
				$('#category-parent-id').val(parentId);
			}
		</script>
EOF;
	}

	function categoryList($data, $categoryGroup) {
		global $vsLang, $bw, $vsSettings;
                
		$BWHTML = "";
		$BWHTML .= <<<EOF
			<div class="ui-dialog ui-widget ui-widget-content ui-corner-all">
				<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
				    <span class="ui-dialog-title">{$vsLang->getWords('category_table_title_header','Categories')}</span>
				</div>
				<div id="category-message{$categoryGroup->getUrl()}" class="message">
					{$data['message']}
					{$vsLang->getWords('category_chosen',"Selected categories")}: {$vsLang->getWords('category_not_selected',"None")}
				</div>
				<table width="100%" class="ui-dialog-content ui-widget-content" cellpadding="0" cellspacing="0">
				    <tr>
				        <td width="200">
							{$data['html']}
				        </td>
				        <td id="second" class="second" style="text-align:center">
				        <if="$vsSettings->getSystemKey($categoryGroup->getUrl().'_edit_category', 1, $categoryGroup->getUrl())">
					        <input style="width:50px;margin-bottom:20px" type="button"   class="ui-state-default ui-corner-all" onclick="editCategory{$categoryGroup->getUrl()}()" value="{$vsLang->getWords('category_edit_bt',"Edit")}">
					    </if>
					<if="$vsSettings->getSystemKey($categoryGroup->getUrl().'_delete_category', 1, $categoryGroup->getUrl())">
					        <input style="width:50px;margin-bottom:20px" type="button"  class="ui-state-default ui-corner-all" onclick="deleteCategory{$categoryGroup->getUrl()}()" value="{$vsLang->getWords('category_delete_bt',"Delete")}">
					   	</if>
                                        <if="$vsSettings->getSystemKey($categoryGroup->getUrl().'_arrayImg', 0, $categoryGroup->getUrl())">
					        <input style="width:50px" type="button"  class="ui-state-default ui-corner-all" onclick="imageCategory{$categoryGroup->getUrl()}()" value="{$vsLang->getWords('category_image_bt',"Image")}">
					</if>
				        </td>

				    </tr>
				</table>
			</div>
			<script type="text/javascript">
                                       
					function setValue_category{$categoryGroup->getUrl()}() {
						var currentId = '';
						var parentId = '';
						$("#menus-category{$categoryGroup->getUrl()} option:selected").each(function () {
						    currentId += $(this).val() + ',';
						    parentId = $(this).val();
						});
						
						currentId = currentId.substr(0, currentId.length-1);
						$("#category-message{$categoryGroup->getUrl()}").html('{$vsLang->getWords('category_chosen',"Selected categories")}:'+currentId);
						$('#category-parent-id').val(parentId);
					}
				
					function deleteCategory{$categoryGroup->getUrl()}() {
						var currentId = '';
						$("#menus-category{$categoryGroup->getUrl()} option:selected").each(function () {
							 currentId += $(this).val() + ',';
							
						});
						currentId = currentId.substr(0, currentId.length-1);
						
						if(!currentId){
							$('#category-message{$categoryGroup->getUrl()}').html('{$vsLang->getWords('err_chosen_category', 'Please choose category to perform your action!')}');
							$('#menus-category{$categoryGroup->getUrl()}').addClass('ui-state-error');
							return false;
						}else{
	                       	var retu = checkCategoryChild( currentId);
	                       	if(retu > 0){
		                        jAlert(
		                           '{$vsLang->getWords('page_delparentcate','Không thể xóa danh mục cha. Muốn xóa danh mục này, bạn phải xóa danh mục con trước!')}',
		                           '{$bw->vars['global_websitename']} Dialog'
		                        );
		                        return false;
	                        }else{
	                        	jConfirm(
									'{$vsLang->getWords("category_confirm_delete","Are you sure to delete these categories information?")}', 
						 			'{$bw->vars["global_websitename"]} Dialog',
						 			function(r){
						 			if(r){
						 				vsf.get('menus/delete-category/{$categoryGroup->getUrl()}/'+currentId+'/','category-table{$categoryGroup->getUrl()}');
						 			}
						 			});
							} 	
	                    }
	                }

					function checkCategoryChild(idparent){
                    var count = 0;
                    $('#menus-category{$categoryGroup->getUrl()} .parent'+idparent).each(function(){
                    	count ++ ;
					});
                    return count;
               		}
					
					function editCategory{$categoryGroup->getUrl()}() {
						temp = $("#menus-category{$categoryGroup->getUrl()} option:selected");
						currentId = $(temp[0]).val();
						if(currentId==0) {
							$('#category-message{$categoryGroup->getUrl()}').html('{$vsLang->getWords('err_chosen_category', 'Please choose category to perform your action!')}');
							$('#menus-category{$categoryGroup->getUrl()}').addClass('ui-state-error');
							return false;
						}
	
						vsf.get('menus/edit-category/{$categoryGroup->getUrl()}/'+currentId+'/','category-form{$categoryGroup->getUrl()}');
						return false;
					}

                       function imageCategory{$categoryGroup->getUrl()}() {
                                                var co = 0;
						var currentId = '';
								$("#menus-category{$categoryGroup->getUrl()} option:selected").each(function () {
							        currentId += $(this).val() + ',';
                                    co += 1;
							    });
						 currentId = currentId.substr(0, currentId.length-1);

						if(currentId==0) {
							$('#category-message{$categoryGroup->getUrl()}').html('{$vsLang->getWords('err_chosen_category', 'Please choose category to perform your action!')}');
							$('#menus-category{$categoryGroup->getUrl()}').addClass('ui-state-error');
							return false;
						}
                        if(co !=1){
                            jAlert(
                                  "{$vsLang->getWords('hide_obj_only_cate', "Chỉ chọn một category!")}",
                                  "{$bw->vars['global_websitename']} Dialog"
                            );
                            return false;
                        }
                        avascript:vsf.popupGet('gallerys/display-album-tab/category/'+ currentId +'&albumCode=category','album');

						return false;
					}
				</script>
EOF;
	}

	function MainCategories($categoryForm = "", $categoryTable = "",$str="") {
		global $vsLang, $bw;
				
		$BWHTML = "";
		$BWHTML .= <<<EOF
			<div id='categoryTabContainer{$str}'>
				<div class="left-cell" id="category-table{$str}">{$categoryTable}</div>
				<div class="right-cell" id="category-form{$str}">{$categoryForm}</div>
				<div class="clear"></div>
			</div>
EOF;
	}

	function addEditCategoryForm($category, $option) {
		global $vsLang, $bw,$vsUser, $vsSettings;
		
		if(!$category->getId()){
			$category->status=1;
			$category->isDropdown=0;
		}else
			$switchForm = <<<EOF
				<a class="ui-state-default ui-corner-all ui-state-focus" onclick="vsf.get('menus/edit-category/{$option['cate']}/','category-form{$option['cate']}');" id="search" style="float: right; margin-right: 20px; line-height: 20px;" title="Click here to add category!">{$vsLang->getWords('menu_bt_switch_add',"New Category")}</a>
EOF;
		$checkStatus[$category->status]="checked";
		$checkDropdown[$category->isDropdown]="checked";
		$BWHTML = "";
		$BWHTML .= <<<EOF
			<form id="add-edit-category-form{$option['cate']}" method="post" name='add-edit-category-form{$option['cate']}'>
			<input type="hidden" name="categoryGroup" value="{$bw->input[2]}" />
			<input type="hidden" name="categoryId" value="{$category->getId()}" id="categoryId"/>
                        
                        <input type="hidden" name="currentId" value="{$category->getId()}" id="currentId"/>
                        <input type="hidden" id="category-parent-idold" name="categoryParentIdOld" value="{$category->getParentId()}" />
			<input type="hidden" id="category-parent-id" name="categoryParentId" value="{$category->getParentId()}" />
				<div class="ui-dialog ui-widget ui-widget-content ui-corner-all">
					<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
				    	<span class="ui-dialog-title">{$option['formTitle']}</span>
				    </div>
				    <div id="err-category-form-message{$option['cate']}" class="red">{$option['message']}</div>
				    <table class="ui-dialog-content ui-widget-content" cellpadding="0" cellspacing="0">
				    	<tr>
				    		<if=" $vsSettings->getSystemKey($option['cate'].'_cat_title', 1, $option['cate'], 1, 1) ">
				        	<td>{$vsLang->getWords('category_form_header_name','Name')}</td>
				            <td><input id="category-name{$option['cate']}" type="text" name="categoryName" size="36" value="{$category->getTitle()}" /></td>
				            </if>
				            
				            <if=" $vsSettings->getSystemKey($option['cate'].'_cat_status', 0, $option['cate'], 1, 1) ">
				        	<td>{$vsLang->getWords('category_form_header_status','Status')}</td>
				            <td>
				            	<input type="radio" class="checkbox" name="categoryIsVisible" {$checkStatus[1]} value="1"/> {$vsLang->getWords('global_yes','Yes')}
				            	<div class="clear"></div>
				            	<input type="radio" class="checkbox"  name="categoryIsVisible" {$checkStatus[0]} value="0"/> {$vsLang->getWords('global_no','No')}
				            	<div class="clear"></div>
				            	<!--<input type="radio" class="checkbox"  name="categoryIsVisible" {$checkStatus[2]} value="2"/> {$vsLang->getWords('global_ishome','Trang chủ')}-->
				            </td>
				            </if>
						</tr>
						<tr>
				    		<if=" $vsSettings->getSystemKey($option['cate'].'_cat_value', 0, $option['cate'], 1, 1) ">
				        	<td>{$vsLang->getWords("category_{$option['cate']}_value",'Value')}</td>
				            <td><input id="category-value{$option['cate']}" type="text" name="categoryValue" size="36" value="{$category->getIsLink()}" /></td>
				            </if>
						</tr>
						<tr>
							<if=" $vsSettings->getSystemKey($option['cate'].'_cat_intro', 0, $option['cate'], 1, 1) ">
				        	<td rowspan="2">{$vsLang->getWords('category_form_header_desc','Description')}</td>
				            <td rowspan="2"><textarea id="category-desc" style="width:240px;" name="categoryDesc">{$category->getAlt()}</textarea></td>
				            </if>
				            <if=" $vsSettings->getSystemKey($option['cate'].'_cat_dropdown', 0, $option['cate'], 1, 1) ">
					            <td>{$vsLang->getWords('category_form_header_dropdown','Is dropdown')}</td>
					            <td>
					            	<input type="radio" class="checkbox" name="categoryIsDropdown" {$checkDropdown[1]} value="1"/> {$vsLang->getWords('global_yes','Yes')}
					            	<input type="radio" class="checkbox"  name="categoryIsDropdown" {$checkDropdown[0]} value="0"/> {$vsLang->getWords('global_no','No')}
					            </td>
				            </if>
						</tr>
						<if=" $vsSettings->getSystemKey($option['cate'].'_cat_index', 1, $option['cate'], 1, 1) ">
						<tr>
						    <td>{$vsLang->getWords('category_form_header_index','Index')}</td>
				            <td><input type="text" name="categoryIndex" size="10" value="{$category->getIndex()}" /></td>
						</tr>
						</if>
						
						<if=" $vsSettings->getSystemKey($option['cate'].'_cat_file', 0, $option['cate'], 1, 1) ">
						<tr>
							<td>{$vsLang->getWords('obj_image_image', "Image")}</td>
							<td>
								<input size="27" type="file" name="menuImage" id="menuImage"/>
							</td >
							<td colspan="2" align="center">
								{$category->createImageCache($category->getFileId(),30,30)}
							</td>
						</tr>
						</if>
						<if="$category->getBackup()&&$vsUser->checkRoot()">
						<tr>
						    <td> {$vsLang->getWords('menu_form_backup',"Retore Link")}</td>
						    <td>
						        <input type="checkbox" class="checkbox" id="menuRetore" name="menuRetore" value="1" />
						        &nbsp; <b>Current link</b>: {$category->getUrl()}
						    </td>
						    <td  colspan="2">
						      <b>Real link</b>: <span style="color:red">{$category->getBackup()}</span>
						    </td>
					    </tr>
					    </if>
				        <tr>
				        	<td class="ui-dialog-buttonpanel" colspan="3" align="center">
				        		<input type="button"  class="ui-state-default ui-corner-all" onclick="submitCatForm{$option['cate']}()" value="{$option['formSubmit']}" />
			        		</td>
			        		<td class="ui-dialog-buttonpanel" align="center">
								{$switchForm}
			        		</td>
						</tr>
				    </table>
				</div>
			</form>
			
			<script type="text/javascript">
				function displayDialog(pageId){
					var opacityDiv='<div id="opacity"></div>';
					var containerDiv='<div id="container"></div><div class="clear"></div>';
					$('#vsf-wrapper').append(opacityDiv);
					$('#vsf-wrapper').append(containerDiv);
					vsf.get('pages/displayEditPageTabber/'+pageId,'container');
				}

				function submitCatForm{$option['cate']}() {
                                        
					if(!$('#category-name{$option['cate']}').val()) {
						str = '* {$vsLang->getWords('err_category_name_blank','Please enter the category name!')}<br />';
						$('#err-category-form-message{$option['cate']}').html(str);
						$('#category-name{$option['cate']}').addClass('ui-state-error');
						return false;
					}
                    var id = $('#currentId').val();
                    var check = $('#category-parent-id').val();
                    var oldparrent = $('#category-parent-idold').val();
                    if(id && check){
                       var retu = checkCategoryParent( id ,check);
                       if(retu.length > 0){
                          jAlert(
                                '{$vsLang->getWords('page_emptycateincate','Danh mục cha không thể sửa vào danh mục con!')}',
                                '{$bw->vars['global_websitename']} Dialog'
                          );
                          return false;
                       }
                    }
                    if(check == id) $('#category-parent-id').val(oldparrent);
					vsf.uploadFile("add-edit-category-form{$option['cate']}", "{$bw->input[0]}", "add-edit-category", "categoryTabContainer{$option['cate']}", "{$option['cate']}_category");	
					
				}
                                        
                function checkCategoryParent(idparent,idcheck){
                    var re ="";
                    $('#menus-category{$option['cate']} .parent'+idparent).each(function(){
                    if($(this).val() == idcheck) {
                       re +="co";
                    }
                    else  re += checkCategoryParent($(this).val(),idcheck);
                    });
                    return re;
               }
			</script>
EOF;
	}
	
	function displayDialog($menulisthtml){
		global $vsMenu, $vsLang;
		
		$BWHTML .= <<<EOF
			<script type='text/javascript'>
				$(document).ready(
						function(){
					$('#dialogOpen').attr('style','width: 100% !important;');
					$('#dialogOpen').click(function(){
						var groupTitle = $('#dialogOpen :selected').text();
						var pageCatId =  $('#dialogOpen :selected').val();
				
	//					if($('#subTitle').length){
						    var advanceTitle = "{$vsLang->getWords('selected_item ','Đang chọn: ')}";		
							advanceTitle += groupTitle;
							var subTitle =  '[' + advanceTitle + ']';
						
							$('#dialog-subtitle').html(subTitle);
	//					}
	//					vsf.get('menus/get-items/'+pageCatId+'/','list-item');
	return true;
					});
				});
			</script>
			<div class="ui-dialog ui-widget ui-widget-content ui-corner-all" style="height:332px;">
				<div id="boxTree" style="float:left;padding-right:5px"><select multiple='multiple' id='dialogOpen' size='20'>{$menulisthtml}</select></div>
				<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner" style="float:left; width: 620px;">
			    	<span class="ui-dialog-title">{$vsLang->getWords('list_item_title','Danh sách')}</span>
			    	<span class="ui-dialog-title" id="dialog-subtitle" style="float:right; padding-right:3px;"></span>
			    	<div id="list-item"></div>
			    </div>
			   <div id="subBoxTree"></div>
			</div>
			
EOF;
	}
}
?>