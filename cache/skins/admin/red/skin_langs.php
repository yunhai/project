<?php
if(!class_exists('skin_objectadmin'))
require_once ('./cache/skins/admin/red/skin_objectadmin.php');
class skin_langs extends skin_objectadmin {

//===========================================================================
// <vsf:getListItemTable:desc::trigger:>
//===========================================================================
function getListItemTable($objItems=array(),$option=array()) {global $bw;
foreach($objItems as $item){
$item->subhtml = '';
$subhtml = '';
foreach($option['langs'] as $lang){
$code= $lang->getCode();
$subhtml .= "
<td>
<input name=\"{$lang->getCode()}[{$item->getId()}]\" type=\"text\" value=\"".htmlspecialchars($item->$code)."\" style='width:100%' />
</td>
";
}
$item->subhtml = $subhtml;
}

//--starthtml--//
$BWHTML .= <<<EOF
        <form id='langform' action='post'>
<input type="hidden" name="pageIndex" value="{$bw->input['pageIndex']}" />
<table class="obj_list">
<thead>
<tr>
<th class="check-column" scope="col"><input type="checkbox" onClick="checkAllClick()" class="check_all" name=""/></th>
<th class="id">{$this->getLang()->getWords("type", "Type")}</th>
<th class="id">{$this->getLang()->getWords("module", "Module")}</th>
<th class="title">{$this->getLang()->getWords("key", 'Key')}</th>
{$this->__foreach_loop__id_5483ca98104718_96090498($objItems,$option)}
<th class="action">{$this->getLang()->getWords("action")}</th>
</tr>
</thead>
<tbody>

EOF;
if(is_array($objItems)) {
$BWHTML .= <<<EOF

{$this->__foreach_loop__id_5483ca98105604_87321480($objItems,$option)}

EOF;
}

$BWHTML .= <<<EOF

</tbody>
<tfoot>
<tr>
<th colspan="3">
EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_add',1)) {
$BWHTML .= <<<EOF

<input type="button" class="icon-wrapper icon-wrapper-vs btnAdd" id="btn-add-obj" title="{$this->getLang()->getWords('global_action_add','Thêm')}"/>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_delete',1)) {
$BWHTML .= <<<EOF

<input type="button"  class="icon-wrapper icon-wrapper-vs btnDelete" id="btn-delete-obj" title="{$this->getLang()->getWords('global_action_delete','Xóa')}"/>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_update',1)) {
$BWHTML .= <<<EOF

<input type="button"  class="icon-wrapper icon-wrapper-vs btnUpdate" id="btn-update-obj" title="{$this->getLang()->getWords('global_action_update','Cập nhật')}"/>

EOF;
}

$BWHTML .= <<<EOF
</th>
<th colspan="10" class="pagination">{$option['paging']}</th>
</tr>
</tfoot>
</table>
</form>

EOF;
if($option['vdata']) {
$BWHTML .= <<<EOF

<input type="hidden" value='{$option['vdata']}' name="vdata"/>

EOF;
}

$BWHTML .= <<<EOF

<script>

EOF;
if($option['message']) {
$BWHTML .= <<<EOF

jAlert('{$option['message']}');

EOF;
}

$BWHTML .= <<<EOF

</script>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_5483ca98104718_96090498($objItems=array(),$option=array())
{
global $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array( $option['langs'])){
    foreach(  $option['langs'] as $lang )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<th class="title">{$this->getLang()->getWords($lang->getCode(), $lang->getCode())}</th>

EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}


//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_5483ca98105604_87321480($objItems=array(),$option=array())
{
global $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($objItems)){
    foreach( $objItems as $item )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<tr class="$vsf_class">
<th class="check-column check_td" scope="row"><input onClick="checkRow()" class="btn_checkbox" value="{$item->getId()}" type="checkbox" /></th>
<td>{$item->getType()}</td>
<td>{$item->getModule()}</td>
<td>{$item->getKey()}</td>
{$item->subhtml}
<td class="action">
{$this->addOtionList($item)}
</td>
</tr>

EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:objListHtml:desc::trigger:>
//===========================================================================
function objListHtml($option=array()) {global $bw;
if($bw->input['search']&&$bw->input['search']['lang']){
foreach($option['langs'] as $key=>$l){
if(in_array($l->getCode(), $bw->input['search']['lang']))
$l->checked = 'checked'; 
}
}
if(!$bw->input['search']['lang']) {
foreach($option['langs'] as $key=>$l){
$l->checked = 'checked'; 
}
}

//--starthtml--//
$BWHTML .= <<<EOF
        <div class="vs_panel" id="vs_panel_{$this->modelName}">
<div class="ui-dialog">

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_search_form",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<form class="frm_search" id="frm_search">
<label>
{$this->getLang()->getWords('search_key', 'Key')}
<input name='search[title]' size="25" type="text" value="{$bw->input['search']['title']}"/>
</label>
<label>
{$this->getLang()->getWords('search_module', 'Module')}
<input name='search[module]' size="25" type="text" value="{$bw->input['search']['module']}"/>
</label>
<label>
{$this->getLang()->getWords('search_language', 'Languages')}
</label>
{$this->__foreach_loop__id_5483ca9810c9b0_66760376($option)}
<br />
<label>
{$this->getLang()->getWords('search_type', 'Types')}
</label>
<label>
<input type="checkbox" name='search[type][admin]' value="admin" 
EOF;
if( $bw->input['search']['type']['admin'] || $bw->input['search']['type']['admin']===NULL) {
$BWHTML .= <<<EOF
 checked 
EOF;
}

$BWHTML .= <<<EOF
 />
{$this->getLang()->getWords('search_type_admin', 'Admin')}
</label>
<label>
<input type="checkbox" name='search[type][user]' value="user" 
EOF;
if( $bw->input['search']['type']['user']|| $bw->input['search']['type']['user']===NULL ) {
$BWHTML .= <<<EOF
 checked 
EOF;
}

$BWHTML .= <<<EOF
 />
{$this->getLang()->getWords('search_type_user', 'User')}
</label>

EOF;
if( VSFactory::getAdmins()->basicObject->checkPermission('view_root_langs') ) {
$BWHTML .= <<<EOF

<input type="hidden" name='search[root][root]' value="1" 
EOF;
if( $bw->input['search']['root']['root'] || $bw->input['search']['root']['root']===NULL) {
$BWHTML .= <<<EOF
 checked 
EOF;
}

$BWHTML .= <<<EOF
 />
<label>
<input type="checkbox" name='search[root][normal]' value="0" 
EOF;
if( $bw->input['search']['root']['normal'] || $bw->input['search']['root']['normal']===NULL ) {
$BWHTML .= <<<EOF
 checked 
EOF;
}

$BWHTML .= <<<EOF
 />
{$this->getLang()->getWords('search_type_normal', 'Normal')}
</label>

EOF;
}

$BWHTML .= <<<EOF

<button  class="btnSearch" type="submit"><span><img src="{$bw->vars['img_url']}/pixel-vfl3z5WfW.gif" class="icon-wrapper-vs vs-icon-search"></span><span>{$this->getLang()->getWords('search','Tìm kiếm')}<span></button>
</form>

EOF;
}

$BWHTML .= <<<EOF

<form class="frm_obj_list" id="frm_obj_list">
<div class="vs-button">

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_add',1)) {
$BWHTML .= <<<EOF

<input type="button" class="icon-wrapper icon-wrapper-vs btnAdd" id="btn-add-obj" title="{$this->getLang()->getWords('global_action_add','Thêm')}"/>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_delete',1)) {
$BWHTML .= <<<EOF

<input type="button"  class="icon-wrapper icon-wrapper-vs btnDelete" id="btn-delete-obj" title="{$this->getLang()->getWords('global_action_delete','Xóa')}"/>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_update',1)) {
$BWHTML .= <<<EOF

<input type="button"  class="icon-wrapper icon-wrapper-vs btnUpdate" id="btn-update-obj" title="{$this->getLang()->getWords('global_action_update','Cập nhật')}"/>

EOF;
}

$BWHTML .= <<<EOF

</div>
<div id="{$this->modelName}_item_panel">
{$option['table']}
</div>
</form>
</div>
<script>
var objChecked= new Array();
function checkAllClick(){
var check= $("#vs_panel_{$this->modelName} .check_all").attr("checked");
objChecked=new Array();
$("#vs_panel_{$this->modelName} .btn_checkbox").each(function(){
if(check){
$(this).attr("checked","checked").change();
objChecked.push($(this).val());
}else{
$(this).removeAttr("checked").change();
}
});
}
function checkRow(){
objChecked=new Array();
$(".btn_checkbox").each(function(){
if($(this).attr("checked")){
objChecked.push($(this).val());
$(this).change();
}
});
}
$(".btn_checkbox").change(function(){
if($(this).attr("checked")){
$(this).parents("tr").addClass("marked");
}else{
$(this).parents("tr").removeClass("marked");
}
});
////////////
$("#vs_panel_{$this->modelName} #btn-update-obj").click(function(){
vsf.submitFormAllCheckBox($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_update', 'vs_panel_{$this->modelName}');
return false;
});
$("#vs_panel_{$this->modelName} #btn-delete-obj").click(function(){
if(objChecked.length==0){
alert("{$this->getLang()->getWords('error_none_select')}");
return false;
}
jConfirm(
                     "{$this->getLang()->getWords('yesno_delete')}?",
                     "{$bw->vars['global_websitename']} Dialog",
                     function(r){
if(r){
vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_delete/'+objChecked,'vs_panel_{$this->modelName}');
}
 }
);
return false;
});

$("#vs_panel_{$this->modelName} #btn-add-obj").click(btnAdd_Click);

function btnAdd_Click(){
vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_add_edit_form/','vs_panel_{$this->modelName}');
}
function btnEditItem_Click(id){
vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_add_edit_form/'+id,'vs_panel_{$this->modelName}');
return false;
}
function btnRemoveItem_Click(id){
jConfirm(
                     "{$this->getLang()->getWords('yesno_delete')}?",
                     "{$bw->vars['global_websitename']} Dialog",
                     function(r){
if(r){
vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_delete/'+id,'vs_panel_{$this->modelName}');
}
 }
);
return false;
}
//////////search...............
$("#vs_panel_{$this->modelName} #frm_search").submit(function(){
vsf.submitForm($("#vs_panel_{$this->modelName} #frm_search"),'{$bw->input[0]}/{$this->modelName}_search','{$this->modelName}_item_panel');
return false;
});

//////////////root......
var rootChecked = new Array();
function checkAllRootClick(){
var check = $("#vs_panel_{$this->modelName} .check_all_root").attr("checked");
objChecked = new Array();
$("#vs_panel_{$this->modelName} .root_checkbox").each(function(){
if(check){
$(this).val(1);
$(this).attr("checked","checked").change();
rootChecked.push($(this).val());
}else{
$(this).val(0);
$(this).removeAttr("checked").change();
}
});
}
function checkRootRow(){
rootChecked = new Array();
$(".root_checkbox").each(function(){
if($(this).attr("checked")){
$(this).val(1);
rootChecked.push($(this).val());
$(this).change();
}else{
$(this).val(0);
}
});
}
</script>
</div>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_5483ca9810c9b0_66760376($option=array())
{
global $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array( $option['langs'])){
    foreach(  $option['langs'] as $lang  )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<label>
<input type="checkbox" name='search[lang][{$lang->getCode()}]' value="{$lang->getCode()}" {$lang->checked} />
{$lang->getCode()}
</label>

EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:addEditObjForm:desc::trigger:>
//===========================================================================
function addEditObjForm($obj="",$option=array()) {global $bw;
foreach($option['langs'] as $lang){
$func = 'get'.strtoupper($lang->getCode());
$value = $obj->$func();
$subhtml .= <<<EOF
<tr>
<td style="width: 100px;">
<label>{$this->getLang()->getWords($lang->getCode(), $lang->getCode())}</label>
</td>
<td>
<input name="{$this->modelName}[{$lang->getCode()}]" type="text" value="{$value}" style='width:100%' />
</td>
</tr>
</foreach>
EOF;
}

//--starthtml--//
$BWHTML .= <<<EOF
        <div class="vs_panel" id="vs_panel_{$this->modelName}">
<div class="ui-dialog">
<div >
<span class="ui-dialog-title">{$this->getLang()->getWords('add_edit_'.$bw->input[0].'_'.$this->modelName,'Add edit '.$this->modelName)}</span>
</div>
<form class="frm_add_edit_obj" id="frm_add_edit_obj"  method="POST" enctype='multipart/form-data'>
<input type="hidden" value="{$bw->input['vdata']}" name="vdata"/>
<input type="hidden" value="{$bw->input['pageIndex']}" name="pageIndex"/>
<input type="hidden" value="{$obj->getId()}" name="{$this->modelName}[id]"/>
<table class="obj_add_edit">
<tbody>
<tr>
<td style="width: 111px;"><label>{$this->getLang()->getWords('key')}</label></td>
<td>
<input name="{$this->modelName}[key]" id="key" type="textbox" value="{$obj->getKey()}" style='width:100%' />
</td>
</tr>
{$subhtml}
<tr>
<td style="width: 111px;"><label>{$this->getLang()->getWords('module')}</label></td>
<td>
<input name="{$this->modelName}[module]" type="textbox" value="{$obj->getModule()}" style='width:100%' />
</td>
</tr>
<tr>
<td style="width: 111px;"><label>{$this->getLang()->getWords('type')}</label></td>
<td>
<label>
<input name="{$this->modelName}[type]" type="radio" value='admin' checked />
{$this->getLang()->getWords('type_admin', 'admin')}
</label>
<label>
<input name="{$this->modelName}[type]" type="radio" value='user' />
{$this->getLang()->getWords('type_user', 'user')}
</label>
</td>
</tr>
<tr style="border:none">
<td class="vs-button" colspan="2" >
<button type="submit" ><span><img src="{$bw->vars['img_url']}/pixel-vfl3z5WfW.gif" class="icon-wrapper-vs vs-icon-accept"></span><span>{$this->getLang()->getWords('global_accept','Lưu')}</span></button>
<button type="button" id="frm_close" class="btnCancel frm_close"><span><img src="{$bw->vars['img_url']}/pixel-vfl3z5WfW.gif" class="icon-wrapper-vs vs-icon-cancel"></span><span>{$this->getLang()->getWords("global_cancel",'Đóng')}</span></button>
</td>
</tr>
</tbody>
</table>
</form>
</div>
<script>
$(document).ready(function(){
vsf.jRadio('{$obj->getType()}', '{$this->modelName}[type]');
});
$("#frm_add_edit_obj").submit(function(){
vsf.uploadFile("frm_add_edit_obj", "{$bw->input[0]}", "{$this->modelName}_add_edit_process", "vs_panel_{$this->modelName}","{$bw->input[0]}");
return false;
});
$(".frm_close").click(function(){
vsf.get('{$bw->input[0]}/{$this->modelName}_display_tab','vs_panel_{$this->modelName}',{vdata:'{$_REQUEST['vdata']}',pageIndex:'{$bw->input['pageIndex']}'});
return false;
});
</script>
EOF;
//--endhtml--//
return $BWHTML;
}


}
?>