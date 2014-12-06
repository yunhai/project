<?php
if(!class_exists('skin_board_admin'))
require_once ('./cache/skins/admin/red/skin_board_admin.php');
class skin_menus extends skin_board_admin {

//===========================================================================
// <vsf:MainPage:desc::trigger:>
//===========================================================================
function MainPage() {global $bw;
$BWHTML = "";
//--starthtml--//deleteCategory

//--starthtml--//
$BWHTML .= <<<EOF
        <div id="page_tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all-top">
<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all-inner">
        <li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active"><a href="{$bw->base_url}menus/viewuser/&ajax=1"><span>{$this->getLang()->getWords('menu_user',"User menus")}</span></a></li>
        
EOF;
if(VSFactory::getAdmins()->obj->checkPermission('root_access')) {
$BWHTML .= <<<EOF

        <li class="ui-state-default ui-corner-top"><a href="{$bw->base_url}menus/viewadmin/&ajax=1"><span>{$this->getLang()->getWords('menu_admin',"Admin menus")}</span></a></li>
        
EOF;
}

$BWHTML .= <<<EOF

    </ul>
</div>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:addEditMenuForm:desc::trigger:>
//===========================================================================
function addEditMenuForm($form=array(),$message="",$menu="") {global  $vsMenu,$bw;
$BWHTML = "";
if($form['type']) {
$switchForm = <<<EOF
<button name="switch" onclick="vsf.get('menus/addmenuform/','addeditform_{$menu->isAdmin}');return false;" >{$this->getLang()->getWords('menu_bt_switch_add',"Form Add")}</button>
EOF;
}
if(!$menu->getId())
{$menu->type=0;
$menu->status=1;
$menu->isLink=1;
$menu->isDropdown=0;
}
$pMain= $menu->main?'checked ':'';
$pTop = $menu->top?'checked ':'';
$pRight = $menu->right?'checked ':'';
$pBottom = $menu->bottom?'checked ':'';
$pLeft = $menu->left?'checked ':'';

$this->app_type=APPLICATION_TYPE;



//--starthtml--//
$BWHTML .= <<<EOF
        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all" style="min-height:400px;">
<div >
    <span class="ui-dialog-title">{$form['title']}</span>
    </div>
    <div class="red">{$message}</div>
<form method="post" name="form" id="addEditMenu_{$menu->isAdmin}"  enctype="multipart/form-data">
<input type="hidden" name="formType" value="{$form['type']}" />
<input type="hidden" name="ID" id="ID" value="{$menu->id}" />
<input type="hidden" name="menuIsAdmin" id="menuIsAdmin_{$menu->isAdmin}" value="{$menu->isAdmin}" />
<input type="hidden" name="parentId" id="parentId_{$menu->isAdmin}" value="{$menu->parentId}" />
<table cellpadding="0" cellspacing="1" width="100%">
<tr>
    <td style="width:100px;">{$this->getLang()->getWords('menu_form_name',"Name")}</td>
    <td><input type="text" value="{$menu->title}" name="menuTitle" id="menuTitle{$menu->isAdmin}" size="35" />
    

    </td>
</tr>
<tr>
    <td>{$this->getLang()->getWords('menu_form_link',"Url")}</td>
    <td>
    
    <input type="text" value="{$menu->url}" name="menuUrl" size="35" />
    

</td>
</tr>
<tr>
    <td></td>
    <td>
        {$this->getLang()->getWords('menu_form_type',"Type")}:
        <label ><input type="radio" id="type1" class="checkbox" name="menuType" value="1" />{$this->getLang()->getWords('menu_form_external',"External")}</label>
        <label ><input type="radio" id="type0" class="checkbox"  name="menuType" value="0" />{$this->getLang()->getWords('menu_form_internal',"Internal")}</label>
    </td>
</tr>
<tr>
    <td>{$this->getLang()->getWords('menu_form_index',"Index")}</td>
    <td>
<input type="text" name="menuIndex" size="3" value="{$menu->index}" />
</td>
</tr>
<tr>
    <td></td>
    <td>{$this->getLang()->getWords('menu_form_visible',"Visible")}:
    
       
       <label for="menuStatus_first"><input type="radio" class="checkbox " id="menuStatus_first" name="menuStatus" value="1" />{$this->getLang()->getWords('menu_form_yes',"Yes")}</label>
       <label for="menuStatus_last"><input type="radio" class="checkbox" id="menuStatus_last" name="menuStatus" value="0" />{$this->getLang()->getWords('menu_form_no',"No")}</label>
</td>
</tr>


EOF;
if(VSFactory::getAdmins()->obj->checkPermission('root_access')) {
$BWHTML .= <<<EOF

<tr>
    <td></td>
    <td>
    {$this->getLang()->getWords('menu_form_islink',"Is link")}:
        
        <label><input type="radio" class="checkbox" name="menuIsLink" value="1" />{$this->getLang()->getWords('menu_form_yes',"Yes")}</label>
        
        <label ><input type="radio" class="checkbox" name="menuIsLink" value="0"/>{$this->getLang()->getWords('menu_form_no',"No")}</label>
    </td>
</tr>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if(VSFactory::getAdmins()->obj->checkPermission('root_access')) {
$BWHTML .= <<<EOF

<tr>
    <td>{$this->getLang()->getWords('menu_form_alt',"Description")}</td>
    <td><textarea name="menuAlt" style="width:230px; height: 75px;">{$menu->alt}</textarea>
</tr>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if(VSFactory::getAdmins()->obj->checkPermission('root_access')) {
$BWHTML .= <<<EOF

<tr>
    <td></td>
    <td>
    
{$this->getLang()->getWords('menu_form_dropdown',"Dropdown")}          
         <label><input type="radio" class="checkbox" name="menuIsDropdown" value="1" />{$this->getLang()->getWords('menu_form_yes',"Yes")}</label>
         
         <label><input type="radio" class="checkbox" name="menuIsDropdown" value="0"/>{$this->getLang()->getWords('menu_form_no',"No")}</label>
         
    </td>
</tr> 

EOF;
}

$BWHTML .= <<<EOF

<tr>
    <td>
{$this->getLang()->getWords('menu_form_position',"Position")}
</td>
    <td >

EOF;
if(VSFactory::getAdmins()->obj->checkPermission('root_access')) {
$BWHTML .= <<<EOF

<label for="main"><input type="checkbox"  class="checkbox" id="main" name="posMain" value='1' {$pMain} />{$this->getLang()->getWords('menu_form_main',"Main")}</label>
        <label for="left"><input type="checkbox"  class="checkbox" id="left" name="posLeft" value='1' {$pLeft} />{$this->getLang()->getWords('menu_form_left',"Left")}</label>
        <label for="right"><input type="checkbox"  class="checkbox" id="right" name="posRight" value='1' {$pRight} />{$this->getLang()->getWords('menu_form_right',"Right")}</label>
        
EOF;
}

$BWHTML .= <<<EOF
     
        <label for="top"><input type="checkbox"  class="checkbox" id="top" name="posTop" value='1' {$pTop} />{$this->getLang()->getWords('menu_form_top',"Top")}</label>
        <label for="bottom"><input type="checkbox"  class="checkbox" id="bottom" name="posBottom" value='1' {$pBottom} />{$this->getLang()->getWords('menu_form_bottom',"Bottom")}</label>
</tr>
<tr>
<td>{$this->getLang()->getWords('obj_image_image', "Image")}</td>
<td>
<input size="27" type="file" name="menuImage" id="menuImage"/>
<p>
EOF;
if($this->getSettings()->getSystemKey($option['cate']."_image_size",'')) {
$BWHTML .= <<<EOF
{$this->getSettings()->getSystemKey($option['cate']."_image_size",'')}
EOF;
}

$BWHTML .= <<<EOF
</p>
</td >
</tr>

EOF;
if($menu->getFileId()) {
$BWHTML .= <<<EOF

<tr>
<td></td>
<td>
{$menu->createImageCache($menu->getFileId(),110,110,2)}
<input type="checkbox" name="delimg" value="{$menu->getFileId()}" />Xóa</td>
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF


               
                <tr>
<td>{$this->getLang()->getWords('show_category', "Hiển thị danh mục con")}</td>
<td>
<select name="menuCate" id="menuCate">
                    <option> Chọn danh mục </option>
                    {$this->__foreach_loop__id_547ddc106f2764_28040921($form,$message,$menu)}
                </select>
</td >

</tr>
<tr>
<td colspan="2" align="center">
<input class="ui-state-default ui-corner-all" type="submit" name="submit" value="{$form['submit']}" />
{$switchForm}
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
                vsf.jSelect('{$menu->getCate()}','menuCate');
});
$('#addEditMenu_{$menu->isAdmin}').submit(function(){
if(!$("#menuTitle{$menu->isAdmin}").val()){
vsf.alert("{$this->getLang()->getWords('null_title', 'TiÃªu Ä‘á»� khÃ´ng Ä‘Æ°á»£c Ä‘á»ƒ trá»‘ng!!!')}");
return false;
}
$(this).find("input,select").removeAttr("disabled");
vsf.uploadFile("addEditMenu_{$menu->isAdmin}","{$bw->input[0]}", "addeditmenu/", "addeditform_{$menu->isAdmin}","menus",
1,function(){
vsf.get('menus/getmenulist/{$menu->isAdmin}','menulist_{$menu->isAdmin}');
vsf.get('menus/addmenuform/{$menu->isAdmin}','addeditform_{$menu->isAdmin}');
return false;
}
);
//vsf.get('menus/getmenulist/{$menu->isAdmin}','menulist_{$menu->isAdmin}');
return false;
});
</script>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547ddc106f2764_28040921($form=array(),$message="",$menu="")
{
global  $vsMenu,$bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($form ['list'])){
    foreach( $form ['list'] as $list )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
                        <option value="{$list->getTitle()}"> {$list->getTitle()} </option>
                    
EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:objList:desc::trigger:>
//===========================================================================
function objList($menulist="",$bt_buildCache=false,$message="") {global  $bw;
$BWHTML = "";
//--starthtml--//

if($bt_buildCache&& VSFactory::getAdmins()->obj->checkPermission('root_access')) 
$buildCache = <<<EOF
<button onclick="vsf.get('menus/buildcache/','menulist_{$bw->typemenu}'); return false;">Buid cache</button>
EOF;


//--starthtml--//
$BWHTML .= <<<EOF
        <script type="text/javascript">
function setValue_{$bw->typemenu}(id) {
$('#'+id).val($('#slmenu_{$bw->typemenu}').val());
}

function deleteMenu_{$bw->typemenu}() {
if($('#slmenu_{$bw->typemenu}').val() > 0) {
jConfirm(
'{$this->getLang()->getWords("pages_deleteConfirm","Are you sure to delete these page information?")}', 
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
"{$this->getLang()->getWords('menu_select_to_delete',"Please select a menu to delete!")}",
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
"{$this->getLang()->getWords('menu_select_to_edit',"Please select a menu to edit!")}",
"{$bw->vars['global_websitename']} Dialog"
);
return false;
}
}
</script>
<div class="ui-dialog ui-widget ui-widget-content ui-corner-all2">
<div >
    <span class="ui-dialog-title">{$this->getLang()->getWords('menu_form_menulist','Menu list')}</span>
    </div>
    <div class="error">{$message}</div>
    <table cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td class="ui-dialog-buttonpanel">
            <a href="#" onclick="deleteMenu_{$bw->typemenu}(); return false;" data-title="{$this->getLang()->getWords('action_delete',"Delete")}" title="{$this->getLang()->getWords('action_delete',"Delete")}">
                <img src="{$bw->vars['img_url']}/pixel-vfl3z5WfW.gif" class="icon-wrapper icon-wrapper-vs btnDelete"/>
                </a>
                <a href="#" onclick="editMenu_{$bw->typemenu}(); return false;" data-title="{$this->getLang()->getWords('action_edit',"Edit")}">
                <img src="{$bw->vars['img_url']}/pixel-vfl3z5WfW.gif" class="icon-wrapper icon-wrapper-vs btnEdit"/>
                </a>
            {$buildCache}
            </td>
        </tr>
        <tr align="center">
        <td class="ui-dialog-selectpanel">
            <select multiple="multipless" style="width:100%;height:370px" onchange="setValue_{$bw->typemenu}('parentId_{$bw->typemenu}');" id="slmenu_{$bw->typemenu}">{$menulist}</select>
            </td>
</tr>
    </table>
</div>
<div class="clear"></div>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:objMain:desc::trigger:>
//===========================================================================
function objMain($menulist="",$addeditform="") {global $bw;
$BWHTML = "";
//--starthtml--//


//--starthtml--//
$BWHTML .= <<<EOF
        <div id="menulist_{$bw->typemenu}" class="left-cell">{$menulist}</div>
<div id="addeditform_{$bw->typemenu}" class="right-cell">{$addeditform}</div>
<div class="clear"></div>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:getSimpleListCatHtml:desc::trigger:>
//===========================================================================
function getSimpleListCatHtml($data="",$categoryGroup="") {global  $bw;
$temp = "";
if($bw->input[0]=="reals") $temp = $bw->input[0]."_";
$BWHTML = "";

//--starthtml--//
$BWHTML .= <<<EOF
        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all">
<div >
    <span class="ui-dialog-title">{$this->getLang()->getWords($temp.'category_table_title_header','Categories')}</span>
</div>
<div id="category-message{$categoryGroup->getUrl()}">{$data['message']}{$this->getLang()->getWords($temp.'category_chosen',"Selected categories")}: {$this->getLang()->getWords('category_not_selected',"None")}</div>
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
$("#category-message{$categoryGroup->getUrl()}").html('{$this->getLang()->getWords('category_chosen',"Selected categories")}:'+currentId);
$('#category-parent-id').val(parentId);
}
</script>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:categoryList:desc::trigger:>
//===========================================================================
function categoryList($data="",$categoryGroup="") {global  $bw;
         $vsSettings = $this->vsSettings = VSFactory::getSettings();       
$BWHTML = "";

//--starthtml--//
$BWHTML .= <<<EOF
        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all">
<div class="ui-dialog-buttonpanel">
    
EOF;
if($this->vsSettings->getSystemKey($categoryGroup->getUrl().'_edit_category', 1, $categoryGroup->getUrl())) {
$BWHTML .= <<<EOF

    <a href="#" onclick="deleteCategory{$categoryGroup->getUrl()}(); return false;" data-title="{$this->getLang()->getWords('global_action_delete',"XÃ³a")}" title="{$this->getLang()->getWords('global_action_delete',"XÃ³a")}">
                <img src="{$bw->vars['img_url']}/pixel-vfl3z5WfW.gif" class="icon-wrapper icon-wrapper-vs btnDelete"/>
                </a>
            
EOF;
}

$BWHTML .= <<<EOF

            
EOF;
if($this->vsSettings->getSystemKey($categoryGroup->getUrl().'_delete_category', 1, $categoryGroup->getUrl())) {
$BWHTML .= <<<EOF

        <a href="#" onclick="editCategory{$categoryGroup->getUrl()}(); return false;" data-title="{$this->getLang()->getWords('global_action_edit',"Sá»­a")}">
                <img src="{$bw->vars['img_url']}/pixel-vfl3z5WfW.gif" class="icon-wrapper icon-wrapper-vs btnEdit"/>
                </a>

EOF;
}

$BWHTML .= <<<EOF

                    
EOF;
if($this->vsSettings->getSystemKey($categoryGroup->getUrl().'_arrayImg', 0, $categoryGroup->getUrl())) {
$BWHTML .= <<<EOF

    <input style="width:50px" type="button"  class="icon-wrapper icon-wrapper-vs btnAlbum" onclick="imageCategory{$categoryGroup->getUrl()}()" value="{$this->getLang()->getWords('category_image_bt',"Image")}">

EOF;
}

$BWHTML .= <<<EOF

                
</div>
<div id="category-message{$categoryGroup->getUrl()}" class="message">
{$data['message']}
</div>
<table width="100%" class="ui-dialog-content ui-widget-content" cellpadding="0" cellspacing="0">
    <tr>
        <td>
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
$('#category-parent-id').val(parentId);
}

function deleteCategory{$categoryGroup->getUrl()}() {
var currentId = '';
$("#menus-category{$categoryGroup->getUrl()} option:selected").each(function () {
 currentId += $(this).val() + ',';

});
currentId = currentId.substr(0, currentId.length-1);

if(!currentId){
 vsf.alert('{$this->getLang()->getWords('err_chosen_category', 'HÃ£y chá»�n danh má»¥c!')}');
return false;
}else{
                       var retu = checkCategoryChild( currentId);
                       if(retu > 0){
                        vsf.alert(
                           '{$this->getLang()->getWords('page_delparentcate','KhÃ´ng thá»ƒ xÃ³a danh má»¥c cha. Muá»‘n xÃ³a danh má»¥c nÃ y, báº¡n pháº£i xÃ³a danh má»¥c con trÆ°á»›c!')}'
                        );
                        return false;
                        }else{
                        jConfirm(
'{$this->getLang()->getWords("category_confirm_delete","Báº¡n cÃ³ cháº¯c cháº¯n Ä‘á»ƒ xÃ³a danh má»¥c nÃ y?")}', 
 'Há»™p thÃ´ng bÃ¡o',
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
$('#category-message{$categoryGroup->getUrl()}').html('{$this->getLang()->getWords('err_chosen_category', 'HÃ£y chá»�n danh má»¥c!')}');
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
$('#category-message{$categoryGroup->getUrl()}').html('{$this->getLang()->getWords('err_chosen_category', 'HÃ£y chá»�n danh má»¥c!')}');
$('#menus-category{$categoryGroup->getUrl()}').addClass('ui-state-error');
return false;
}
                        if(co !=1){
                            jAlert(
                                  "{$this->getLang()->getWords('hide_obj_only_cate', "Chá»‰ chá»�n má»™t category!")}");
                            return false;
                        }
                        avascript:vsf.popupGet('gallerys/display-album-tab/category/'+ currentId +'&albumCode=category','album');

return false;
}
</script>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:MainCategories:desc::trigger:>
//===========================================================================
function MainCategories($categoryForm="",$categoryTable="",$str="") {global  $bw;

$BWHTML = "";

//--starthtml--//
$BWHTML .= <<<EOF
        <div id='categoryTabContainer{$str}'>
<div class="left-cell" id="category-table{$str}">{$categoryTable}</div>
<div class="right-cell" id="category-form{$str}">{$categoryForm}</div>
<div class="clear"></div>
</div>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:addEditCategoryForm:desc::trigger:>
//===========================================================================
function addEditCategoryForm($category="",$option="") {global  $bw,$vsUser;
$vsSettings = $this->vsSettings = VSFactory::getSettings();
if( $this->vsSettings->getSystemKey($option['cate'].'_cat_intro_editor_type', 0, $option['cate'], 1, 1) ){
global $vsStd;
$vsStd->requireFile(JAVASCRIPT_PATH."/tiny_mce/tinyMCE.php");
$editor = new tinyMCE();
$editor->setWidth('400px');
$editor->setHeight('150px');
$editor->setToolbar('narrow');
$editor->setTheme("advanced");
$editor->setInstanceName('categoryDesc');
$editor->setValue($category->getAlt());
$category->setAlt($editor->createHtml());
}
if(!$category->getId()){
$category->status=1;
$category->isDropdown=0;
}else
$switchForm = <<<EOF
<button onclick="vsf.get('menus/edit-category/{$option['cate']}/','category-form{$option['cate']}');" ><span><img src="{$bw->vars['img_url']}/pixel-vfl3z5WfW.gif" class="icon-wrapper-vs vs-icon-cancel"></span><span>{$this->getLang()->getWords('menu_bt_switch_add',"Thêm")}</span></button>
EOF;
$checkStatus[$category->status]="checked";
$checkDropdown[$category->isDropdown]="checked";






$BWHTML = "";

//--starthtml--//
$BWHTML .= <<<EOF
        <form id="add-edit-category-form{$option['cate']}" method="post" enctype="multipart/form-data" name='add-edit-category-form{$option['cate']}'>
<input type="hidden" name="categoryGroup" value="{$bw->input[2]}" />
<input type="hidden" name="categoryId" value="{$category->getId()}" id="categoryId"/>
                        
                        <input type="hidden" name="currentId" value="{$category->getId()}" id="currentId"/>
                        <input type="hidden" id="category-parent-idold" name="categoryParentIdOld" value="{$category->getParentId()}" />
<input type="hidden" id="category-parent-id" name="categoryParentId" value="{$category->getParentId()}" />
<input type="hidden" value="{$category->getSlug ()}" name="categorySlug" id="mUrl" data-module="menus" data-id = "{$category->getId()}"/>
<div class="ui-dialog ui-widget ui-widget-content ui-corner-all">
<div >
    <span class="ui-dialog-title">{$option['formTitle']}</span>
    </div>
    <div id="err-category-form-message{$option['cate']}" class="red">{$option['message']}</div>
    <table class="obj_add_edit" width="100%">
    <tr>
    
EOF;
if( $this->vsSettings->getSystemKey($option['cate'].'_cat_title', 1, $option['cate'], 1, 1) ) {
$BWHTML .= <<<EOF

        <td>{$this->getLang()->getWords('category_form_header_name','Name')}</td>
            <td><input id="category-name{$option['cate']}" type="text" name="categoryName" size="36" value="{$category->getTitle()}" /></td>
            
EOF;
}

$BWHTML .= <<<EOF

</tr>
<tr>
            
EOF;
if( $this->vsSettings->getSystemKey($option['cate'].'_cat_status', 0, $option['cate'], 1, 1) ) {
$BWHTML .= <<<EOF

        <td>{$this->getLang()->getWords('category_form_header_status','Status')}</td>
            <td>
            <input type="radio" class="checkbox" name="categoryIsVisible" {$checkStatus[1]} value="1"/> {$this->getLang()->getWords('global_yes','Yes')}
            <div class="clear"></div>
            <input type="radio" class="checkbox"  name="categoryIsVisible" {$checkStatus[0]} value="0"/> {$this->getLang()->getWords('global_no','No')}
            <div class="clear"></div>
            <input type="radio" class="checkbox"  name="categoryIsVisible" {$checkStatus[2]} value="2"/> {$this->getLang()->getWords('global_ishome','Trang chủ')}
            </td>
            
EOF;
}

$BWHTML .= <<<EOF

</tr>

EOF;
if( $this->vsSettings->getSystemKey($option['cate'].'_cat_value', 0, $option['cate'], 1, 1) ) {
$BWHTML .= <<<EOF

<tr>
    
        <td>{$this->getLang()->getWords("category_{$option['cate']}_value",'Value')}</td>
            <td><input id="category-value{$option['cate']}" type="text" name="categoryValue" size="36" value="{$category->getIsLink()}" /></td>
            
</tr>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if( $this->vsSettings->getSystemKey($option['cate'].'_cat_desc', 0, $option['cate'], 1, 1) ) {
$BWHTML .= <<<EOF

<tr>
    <td>{$this->getLang()->getWords('category_form_desc','Mô tả')}</td>
    
EOF;
if($option['cate']=='products') {
$BWHTML .= <<<EOF

    <td><textarea style="width:300px;height:100px" name="categoryDesc1">{$category->getDesc()}</textarea></td>
    
EOF;
}

else {
$BWHTML .= <<<EOF

            <td><input type="text" name="categoryDesc1" size="34" value="{$category->getDesc()}" /></td>
            
EOF;
}
$BWHTML .= <<<EOF

</tr>

EOF;
}

$BWHTML .= <<<EOF

<tr>

EOF;
if( $this->vsSettings->getSystemKey($option['cate'].'_cat_intro', 0, $option['cate'], 1, 1) ) {
$BWHTML .= <<<EOF

        <td>{$this->getLang()->getWords('category_form_header_desc','Description')}</td>
            <td>
            
EOF;
if($this->vsSettings->getSystemKey($option['cate'].'_cat_intro_editor_type', 0, $option['cate'], 1, 1)) {
$BWHTML .= <<<EOF

            {$category->getAlt()}
            
EOF;
}

else {
$BWHTML .= <<<EOF

            <textarea id="category-desc" style="width:294px;" name="categoryDesc">{$category->getAlt()}</textarea>
            
EOF;
}
$BWHTML .= <<<EOF

            </td>
            
EOF;
}

$BWHTML .= <<<EOF

                         </tr>
                         

EOF;
if( $this->vsSettings->getSystemKey($option['cate'].'_cat_index', 1, $option['cate'], 1, 1) ) {
$BWHTML .= <<<EOF

<tr>
    <td>{$this->getLang()->getWords('category_form_header_index','Index')}</td>
            <td><input type="text" name="categoryIndex" size="10" value="{$category->getIndex()}" /></td>
</tr>

EOF;
}

$BWHTML .= <<<EOF




EOF;
if( $this->vsSettings->getSystemKey($option['cate'].'_cat_file', 0, $option['cate'], 1, 1) ) {
$BWHTML .= <<<EOF

<tr>
<td>{$this->getLang()->getWords('obj_image_image', "Image")}</td>
<td>
<input size="27" type="file" name="menuImage" id="menuImage"/>
( Kích thước :{$this->getSettings()->getSystemKey($option['cate']."_cat_image_size",'67x67',$option['cate'])})
</td >
</tr>
<tr>
<td>&nbsp;</td>
<td>
{$category->createImageCache($category->getFileId(),30,30)}
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF




EOF;
if( $this->vsSettings->getSystemKey($option['cate'].'_cat_document', 0, $option['cate'], 1, 1) ) {
$BWHTML .= <<<EOF

<tr>
<td>{$this->getLang()->getWords('obj_image_document', "docuemnt")}</td>
<td>
<input size="27" type="file" name="menuDocument" id="menuDocument"/>

</td >
</tr>

EOF;
}

$BWHTML .= <<<EOF




EOF;
if($category->getBackup()) {
$BWHTML .= <<<EOF

<tr>
    <td> {$this->getLang()->getWords('menu_form_backup',"Retore Link")}</td>
    <td>
        <input type="checkbox" class="checkbox" id="menuRetore" name="menuRetore" value="1" />
        &nbsp; <b>Current link</b>: {$category->getUrl()}
    </td>
    <td  colspan="2">
      <b>Real link</b>: <span style="color:red">{$category->getBackup()}</span>
    </td>
    </tr>
    
EOF;
}

$BWHTML .= <<<EOF

        <tr>
        <td class="ui-dialog-buttonpanel" colspan="3" align="center">
        <input type="button"  class="ui-state-default ui-corner-all" onclick="submitCatForm{$option['cate']}()" value="{$option['formSubmit']}" />
        {$switchForm}
        </td>
</tr>
    </table>
</div>
</form>

<script type="text/javascript">


function submitCatForm{$option['cate']}() {
                                        
if(!$('#category-name{$option['cate']}').val()) {
str = '* {$this->getLang()->getWords('err_category_name_blank','Please enter the category name!')}<br />';
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
                                '{$this->getLang()->getWords('page_emptycateincate','Danh mục cha không thể sửa vào danh mục con!')}',
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
//--endhtml--//
return $BWHTML;
}


}
?>