<?php
if(!class_exists('skin_objectadmin'))
require_once ('./cache/skins/admin/red/skin_objectadmin.php');
class skin_products extends skin_objectadmin {

//===========================================================================
// <vsf:addEditObjForm:desc::trigger:>
//===========================================================================
function addEditObjForm($objItem="",$option=array()) {global $vsLang, $bw,$vsSettings,$tableName,$langObject, $vsMenu;
$option['phukien'] = $vsMenu->getCategoryGroup("phukien")->getChildren();


//--starthtml--//
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


EOF;
if( $vsSettings->getSystemKey($bw->input[0].'_price', 1, $bw->input[0]) ) {
$BWHTML .= <<<EOF

<tr class='smalltitle'>
<td class="label_obj" width="75">{$vsLang->getWords('itemListPrice',"Price")}:</td>
<td colspan="3">
<input width="75" name="{$tableName}Price" value="{$objItem->getPrice()}" id="obj-title"/>
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF


                     
EOF;
if($vsSettings->getSystemKey($bw->input[0].'_code',0, $bw->input[0])) {
$BWHTML .= <<<EOF

<tr class='smalltitle'>
<td class="label_obj" width="75">
{$langObject['itemObjCode']}:
</td>
<td colspan="3">
<input style="width:40" name="{$tableName}Code" value="{$objItem->getCode()}"/>
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF


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



EOF;
if( $vsSettings->getSystemKey($bw->input[0].'_home', 0, $bw->input[0]) ) {
$BWHTML .= <<<EOF

<label>{$langObject['itemListHome']}</label>
<input name="{$tableName}Status" id="{$tableName}Status2" value='2' class='c_noneWidth' type="radio" />

EOF;
}

$BWHTML .= <<<EOF

</td>
</tr>


EOF;
if($vsSettings->getSystemKey($bw->input[0].'_image', 1, $bw->input[0])) {
$BWHTML .= <<<EOF

<tr class='smalltitle'>
<td class="label_obj">
{$langObject['itemObjFile']}:
</td>
<td>
<input size="27" type="file" name="{$tableName}IntroImage" id="{$tableName}IntroImage" /><br />
 {$vsSettings->getSystemKey($bw->input[0]."_image_timthumb_size","(size:100x100px)", $bw->input[0])}
</td>
<td colspan="2" rowspan="2">
{$objItem->createImageCache($objItem->getImage(), 100, 50)}
<br/>

EOF;
if( $objItem->getImage() && $vsSettings->getSystemKey($bw->input[0].'_image_delete',1, $bw->input[0]) ) {
$BWHTML .= <<<EOF

<input type="checkbox" name="deleteImage" id="deleteImage" />
<label for="deleteImage">{$langObject['itemObjDeleteImage']}</lable>

EOF;
}

$BWHTML .= <<<EOF

</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF


<tr class='smalltitle'>
<td class="label_obj" width="75">{$vsLang->getWords('itemPrice',"Price")}:</td>
<td >
<input style="width:100%;" name="{$tableName}Price" value="{$objItem->getPrice()}" "/>
</td>
</tr>


EOF;
if( $vsSettings->getSystemKey($bw->input[0].'_intro', 1, $bw->input[0]) ) {
$BWHTML .= <<<EOF

<tr class='smalltitle'>
<td class="label_obj" width="75">
{$langObject['itemObjIntro']}:
</td>
<td colspan="3" valgin="left">
{$objItem->getIntro()}
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF




EOF;
if($vsSettings->getSystemKey($bw->input[0].'_content',1, $bw->input[0])) {
$BWHTML .= <<<EOF

<tr class='smalltitle'>
<td colspan="4" align="center">{$objItem->getContent()}</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF

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
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:managerObjHtml:desc::trigger:>
//===========================================================================
function managerObjHtml() {global $bw, $vsLang,$vsSettings,$langObject;

//--starthtml--//
$BWHTML .= <<<EOF
        <div id="page_tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all-top">
<ul id="tabs_nav" class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-corner-all-inner">
                    
EOF;
if($bw->input['module'] == 'pages' ) {
$BWHTML .= <<<EOF

                                    <li class="ui-state-default ui-corner-top">
                                            <a href="{$bw->base_url}pages/displayVirtualTab/&ajax=1">
                                                    <span>{$langObject['tabVirtualModule']}</span>
                                            </a>
                                    </li>
        
EOF;
}

$BWHTML .= <<<EOF

        
    <li class="ui-state-default ui-corner-top">
        <a href="{$bw->base_url}{$bw->input[0]}/display-obj-tab/&ajax=1"><span>{$vsLang->getWords("tab_obj_objes_{$bw->input[0]}","{$bw->input[0]}")}</span></a>
        </li>
                                
        
EOF;
if($vsSettings->getSystemKey($bw->input[0].'_category_tab',0, "{$bw->input[0]}", 1, 1)) {
$BWHTML .= <<<EOF

                                        <li class="ui-state-default ui-corner-top">
                                        <a href="{$bw->base_url}menus/display-category-tab/{$bw->input[0]}/&ajax=1">
                                        <span>{$langObject['categoriesTitle']}</span></a>
                                </li>
        
EOF;
}

$BWHTML .= <<<EOF

        
        
EOF;
if($vsSettings->getSystemKey($bw->input[0].'_setting_tab',0, "{$bw->input[0]}", 1, 1)) {
$BWHTML .= <<<EOF

        <li class="ui-state-default ui-corner-top">
        <a href="{$bw->base_url}settings/moduleObjTab/{$bw->input[0]}/&ajax=1">
<span>Settings</span>
</a>
        </li>
        
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
// <vsf:objListHtml:desc::trigger:>
//===========================================================================
function objListHtml($objItems=array(),$option=array()) {global $bw, $vsLang, $vsSettings, $vsSetting, $tableName, $vsUser,$langObject;
$this->objcallback = "obj-panel-callback";
if($option['comment_panel']){
$this->objcallback = "comment-callback";
}

//--starthtml--//
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
                                
EOF;
if( $vsSettings->getSystemKey($bw->input[0].'_add_hide_show_delete',1, $bw->input[0]) ) {
$BWHTML .= <<<EOF

                                <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-corner-all-inner ui-widget-header">
                                    <li class="ui-state-default ui-corner-top" id="add-objlist-bt"><a href="#" title="{$langObject['itemListAdd']}">{$langObject['itemListAdd']}</a></li>
                                    <li class="ui-state-default ui-corner-top" id="hide-objlist-bt"><a href="#" title="{$langObject['itemListHide']}">{$langObject['itemListHide']}</a></li>
                                    <li class="ui-state-default ui-corner-top" id="visible-objlist-bt"><a href="#" title="{$langObject['itemListVisible']}">{$langObject['itemListVisible']}</a></li>
                                    
EOF;
if( $vsSettings->getSystemKey($bw->input[0].'_home',0, $bw->input[0]) ) {
$BWHTML .= <<<EOF

                                       <li class="ui-state-default ui-corner-top" id="home-objlist-bt"><a href="#" title="{$langObject['itemListHome']}">{$langObject['itemListHome']}</a></li>
                                    
EOF;
}

$BWHTML .= <<<EOF

                                    <li class="ui-state-default ui-corner-top" id="delete-objlist-bt"><a href="#" title="{$langObject['itemListDelete']}">{$langObject['itemListDelete']}</a></li>
                                    
EOF;
if($vsSettings->getSystemKey($bw->input[0].'_category_list', 0, $bw->input[0])) {
$BWHTML .= <<<EOF

                                    <li class="ui-state-default ui-corner-top" id="change-objlist-bt"><a href="#" title="{$langObject['itemListChangeCate']}">{$langObject['itemListChangeCate']}</a></li>
                                    
EOF;
}

$BWHTML .= <<<EOF

                                    
EOF;
if($vsSettings->getSystemKey($bw->input[0].'_search_list',0, $bw->input[0])) {
$BWHTML .= <<<EOF

                                    <li class="ui-state-default ui-corner-top" id="insertSearch-objlist-bt"><a href="#" title="{$langObject['itemListInsertSearch']}">{$langObject['itemListInsertSearch']}</a></li>
                                    
EOF;
}

$BWHTML .= <<<EOF

                                </ul>
                                
EOF;
}

$BWHTML .= <<<EOF

<table cellspacing="1" cellpadding="1" id='objListHtmlTable' width="100%">
<thead>
    <tr>
        <th width="10"><input type="checkbox" onclick="vsf.checkAll()" name="all" /></th>
        <th width="60">{$langObject['itemListActive']}</th>
        <th>{$langObject['itemListTitle']}</td>


EOF;
if( $vsSettings->getSystemKey($bw->input[0].'_index', 1, $bw->input[0], 1, 1) ) {
$BWHTML .= <<<EOF

        <th width="100">Giá</th>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if( $vsSettings->getSystemKey($bw->input[0].'_index', 1, $bw->input[0], 1, 1) ) {
$BWHTML .= <<<EOF

        <th width="30">{$langObject['itemListIndex']}</th>

EOF;
}

$BWHTML .= <<<EOF

        
EOF;
if( $vsSettings->getSystemKey($bw->input[0].'_option', 0, $bw->input[0], 1, 1) ) {
$BWHTML .= <<<EOF

        <th width="80" align="center">{$langObject['itemListAction']}</th>
        
EOF;
}

$BWHTML .= <<<EOF

    </tr>
</thead>
<tbody>
{$this->__foreach_loop__id_527ceeb4e27a8($objItems,$option)}
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
                                                       
EOF;
if( $vsSettings->getSystemKey($bw->input[0].'_home',0, $bw->input[0]) ) {
$BWHTML .= <<<EOF

                                                            <span style="padding-left: 10px;line-height:16px;"><img src="{$bw->vars['img_url']}/home.png" /> {$langObject['itemListHomeShow']}</span>
                                                      
EOF;
}

$BWHTML .= <<<EOF

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
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_527ceeb4e27a8($objItems=array(),$option=array())
{
global $bw, $vsLang, $vsSettings, $vsSetting, $tableName, $vsUser,$langObject;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach( $objItems as $obj )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<tr class="$vsf_class">
<td align="center">
                                                                                
EOF;
if(!$vsSettings->getSystemKey($bw->input[0].'_code',0) && $obj->getCode()) {
$BWHTML .= <<<EOF

                                                                                    <img src="{$bw->vars['img_url']}/disabled.png" />
                                                                                
EOF;
}

else {
$BWHTML .= <<<EOF

<input type="checkbox" onclick="vsf.checkObject();" name="obj_{$obj->getId()}" value="{$obj->getId()}" class="myCheckbox" />
                                                                                
EOF;
}
$BWHTML .= <<<EOF

</td>
<td style='text-align:center'>{$obj->getStatus('image')}</td>

<td>
<a href="javascript:vsf.get('{$bw->input[0]}/add-edit-obj-form/{$obj->getId()}/&pageIndex={$bw->input[3]}&pageCate={$bw->input[2]}','obj-panel')"  class="editObj" >
{$obj->getTitle()}
</a>
</td>
<td>{$obj->getPrice(true, true)}</td>

EOF;
if( $vsSettings->getSystemKey($bw->input[0].'_index', 1, $bw->input[0], 1, 1) ) {
$BWHTML .= <<<EOF

<td>{$obj->getIndex()}</td>

EOF;
}

$BWHTML .= <<<EOF



EOF;
if( $vsSettings->getSystemKey($bw->input[0].'_option', 0, $bw->input[0], 1, 1) ) {
$BWHTML .= <<<EOF

<td>
{$this->addOtionList($obj,$this->objcallback,$option)}
</td>

EOF;
}

$BWHTML .= <<<EOF

</tr>

EOF;
$vsf_count++;
    }
    return $BWHTML;
}


}?>