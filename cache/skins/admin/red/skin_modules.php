<?php
if(!class_exists('skin_objectadmin'))
require_once ('./cache/skins/admin/red/skin_objectadmin.php');
class skin_modules extends skin_objectadmin {

//===========================================================================
// <vsf:addEditObjForm:desc::trigger:>
//===========================================================================
function addEditObjForm($obj="",$option=array()) {global $bw;

//--starthtml--//
$BWHTML .= <<<EOF
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
<td style="width: 111px;"><label>{$this->getLang()->getWords('title')}</label></td>
<td>
<input  name="{$this->modelName}[title]" id="{$this->modelName}_title" type="textbox" value="{$obj->getTitle()}" style='width:100%' />
</td>
</tr>
<tr>
<td style="width: 111px;"><label>{$this->getLang()->getWords('class','Class Name')}</label></td>
<td>
<input  name="{$this->modelName}[class]" id="{$this->modelName}_title" type="textbox" value="{$obj->getClass()}" style='width:100%' />
</td>
</tr>
<!--

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_status",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<tr>
<td style="width: 121px;"><label>{$this->getLang()->getWords('status')}</label></td>
<td>
<label>
<input 
EOF;
if($obj->getStatus()=='0') {
$BWHTML .= <<<EOF
checked='checked'
EOF;
}

$BWHTML .= <<<EOF
  name="{$this->modelName}[status]" id="{$this->modelName}_status_0" type="radio" value="0"  />
<img title="{$this->getLang()->getWords('hide')}" src="{$bw->vars['img_url']}/status_0.png"/>
</label>
<label>
<input 
EOF;
if($obj->getStatus()==1||$obj->getStatus()==null) {
$BWHTML .= <<<EOF
checked='checked'
EOF;
}

$BWHTML .= <<<EOF
  name="{$this->modelName}[status]" id="{$this->modelName}_status_1" type="radio" value="1"  />
<img title="{$this->getLang()->getWords('visible')}" src="{$bw->vars['img_url']}/status_1.png"/>
</label>
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF

-->

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_index",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<tr>
<td><label>{$this->getLang()->getWords("index")}</label></td>
<td>
<input  name="{$this->modelName}[index]" id="{$this->modelName}_index" type="textbox" value="{$obj->getIndex()}" />
</td>
</tr>
<tr>
<td><label>{$this->getLang()->getWords("isParent",'Is parent')}</label></td>
<td>
<input  name="{$this->modelName}[isParent]" id="{$this->modelName}_isParent" type="checkbox" 
EOF;
if($obj->getIsParent()) {
$BWHTML .= <<<EOF
checked='checked'
EOF;
}

$BWHTML .= <<<EOF
 value="1" />
</td>
</tr>
<tr>
<td><label>{$this->getLang()->getWords("isAdmin",'Is admin')}</label></td>
<td>
<input  name="{$this->modelName}[isAdmin]" id="{$this->modelName}_isAdmin" type="checkbox" 
EOF;
if($obj->getIsAdmin()) {
$BWHTML .= <<<EOF
checked='checked'
EOF;
}

$BWHTML .= <<<EOF
 value="1" />
</td>
</tr>
<tr>
<td><label>{$this->getLang()->getWords("isUser",'Is user')}</label></td>
<td>
<input  name="{$this->modelName}[isUser]" id="{$this->modelName}_isUser" type="checkbox" 
EOF;
if($obj->getisUser()) {
$BWHTML .= <<<EOF
checked='checked'
EOF;
}

$BWHTML .= <<<EOF
 value="1" />
</td>
</tr>
<tr>
<td><label>{$this->getLang()->getWords("virtual",'virtual')}</label></td>
<td>
<input  name="{$this->modelName}[virtual]" id="{$this->modelName}_virtual" type="checkbox" 
EOF;
if($obj->getVirtual()) {
$BWHTML .= <<<EOF
checked='checked'
EOF;
}

$BWHTML .= <<<EOF
 value="1" />
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF

<tr>
<td><label>{$this->getLang()->getWords('parent')}</label></td>
<td>
<select name="{$this->modelName}[parent]">
<option value="0">Select parent</option>
{$this->__foreach_loop__id_5483ca98296133_39604155($obj,$option)}
</select>
</td>
</tr>

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_intro",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<tr>
<td><label>{$this->getLang()->getWords('intro')}</label></td>
<td>
<textarea id="{$this->modelName}_intro" name="{$this->modelName}[intro]" style="width: 100%; height: 111px;">{$obj->getIntro()}</textarea>
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF

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
var frm=$(this);
if($("#{$this->modelName}_title").val().length<3){
message+='{$this->getLang()->getWords('error_title')}{$this->DS}n';
flag=true;
}

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_intro",1,$bw->input[0])) {
$BWHTML .= <<<EOF

if($("#{$this->modelName}_intro").val().length<3){
message+='{$this->getLang()->getWords('error_intro')}{$this->DS}n';
flag=true;
}

EOF;
}

$BWHTML .= <<<EOF

if(flag){
jAlert(message);
return false;
}
vsf.uploadFile("frm_add_edit_obj", "{$bw->input[0]}", "{$this->modelName}_add_edit_process", "vs_panel_{$this->modelName}","{$bw->input[0]}",1,
function(){
var hashbase=frm.parents('.ui-tabs-panel').attr('id');
window.location.hash=hashbase+"/{$bw->input['back']}";
}
);
return false;
});
$(".frm_close").click(function(){
var hashbase=$(this).parents('.ui-tabs-panel').attr('id');
window.location.hash=hashbase+"{$bw->input['back']}";
return false;
});
////////*********************select file field*************************/
$("input[type='radio']").change(function(){
if($(this).val()=='link'||$(this).val()=='file'){
$("input[name='"+this.name+"']").each(function(){
if($(this).attr("checked")){
$("#"+$(this).attr('obj')).removeAttr("disabled");
}else{
$("#"+$(this).attr('obj')).attr("disabled","disabled");
}
});
}
});
</script>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_5483ca98296133_39604155($obj="",$option=array())
{
global $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['parent'])){
    foreach( $option['parent'] as $p )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<option 
EOF;
if($p->getClass()==$obj->getParent()) {
$BWHTML .= <<<EOF
selected='selected'
EOF;
}

$BWHTML .= <<<EOF
 value="{$p->getClass()}">{$p->getClass()} ({$p->getTitle()})</option>

EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:getListItemTable:desc::trigger:>
//===========================================================================
function getListItemTable($objItems=array(),$option=array()) {    global $bw;

//--starthtml--//
$BWHTML .= <<<EOF
        <div class="ui-dialog">
<div >
<span class="ui-dialog-title">{$this->getLang()->getWords($this->modelName,$this->modelName)}</span>
</div>

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_search_form",1,$bw->input[0])) {
$BWHTML .= <<<EOF

{$this->getSearchForm($option)}

EOF;
}

$BWHTML .= <<<EOF

<form class="frm_obj_list" id="frm_obj_list">
<div>

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_add',1)) {
$BWHTML .= <<<EOF

<input type="button" class="btnAdd" id="btn-add-obj" value="{$this->getLang()->getWords('action_add')}"/>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_delete',1)) {
$BWHTML .= <<<EOF

<input type="button"  class="btnDelete" id="btn-delete-obj" value="{$this->getLang()->getWords('action_delete')}"/>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_disable',1)) {
$BWHTML .= <<<EOF

<input type="button" class="btnDisable" id="btn-disable-obj" value="{$this->getLang()->getWords('action_hide')}"/>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_visible',1)) {
$BWHTML .= <<<EOF

<input type="button" class="btnEnable" id="btn-enable-obj" value="{$this->getLang()->getWords('action_visible')}"/>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_status_home",0,$bw->input[0])) {
$BWHTML .= <<<EOF

<input type="button" class="btnHome" id="btn-home-obj" value="{$this->getLang()->getWords('action_home')}"/>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_index",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<input type="button" class="btnIndexChange" id="btn-index-change-obj" value="{$this->getLang()->getWords('action_index_change')}"/>

EOF;
}

$BWHTML .= <<<EOF

<input type="file" name="fileimport" id="file_import_module" />
<input type="button" class="btImport" id="btn-submit-import" value="{$this->getLang()->getWords('import')}"/>
<!--btnAdd,btnEdit,btnDelete,btnReview,btnDisable,btnEnable,btnOk,btnSearch,btnIndexChange-->
</div>
<div id="{$this->modelName}_item_panel">
<input type="hidden" name="catId" value="{$bw->input['catId']}"/>
<input type="hidden" name="pageIndex" value="{$bw->input['pageIndex']}"/>
<table class="obj_list">
<thead>
<tr>
<th class="cb"><input type="checkbox" onClick="checkAllClick()" class="check_alll" name=""/></th>
<th class="id">{$this->getLang()->getWords("id")}</th>

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_class_field",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<th class="img">{$this->getLang()->getWords("class",'Class Name')}</th>

EOF;
}

$BWHTML .= <<<EOF

<th class="title">{$this->getLang()->getWords("title")}</th>

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_category_list",0,$bw->input[0])) {
$BWHTML .= <<<EOF

<th>{$this->getLang()->getWords("category")}</th>

EOF;
}

$BWHTML .= <<<EOF

<th class="status">{$this->getLang()->getWords("status")}</th>
<th class="date">{$this->getLang()->getWords("postdate")}</th>

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_index",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<th class="index">{$this->getLang()->getWords("index")}</th>

EOF;
}

$BWHTML .= <<<EOF

<th class="action">{$this->getLang()->getWords("action")}</th>
</tr>
</thead>
<tbody>

EOF;
if(is_array($objItems)) {
$BWHTML .= <<<EOF

{$this->__foreach_loop__id_5483ca982a3e96_11349663($objItems,$option)}

EOF;
}

$BWHTML .= <<<EOF

</tbody>
<tfoot>
<tr>
<th colspan="10">{$option['paging']}</th>
</tr>
</tfoot>
</table>

EOF;
if($option['vdata']) {
$BWHTML .= <<<EOF

<input type="hidden" value='{$option['vdata']}' name="vdata"/>

EOF;
}

$BWHTML .= <<<EOF

<!--MORE_ACTION-->
</div>
</form>
</div>
<script>
var objChecked=new Array();
////////////////checked
function checkAllClick(){
var check=$("#vs_panel_{$this->modelName}  .check_alll").attr("checked");
objChecked=new Array();
$("#vs_panel_{$this->modelName} .btn_checkbox").each(function(){
if(check){
$(this).attr("checked","checked").change();
objChecked.push($(this).val());
}else{
$(this).attr("checked","").change();
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
$("#vs_panel_{$this->modelName} #frm_obj_list").submit(function(){
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
$("#vs_panel_{$this->modelName} #btn-disable-obj").click(function(){
if(objChecked.length==0){
alert("{$this->getLang()->getWords('error_none_select')}");
return false;
}
vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_hide_checked/'+objChecked,'vs_panel_{$this->modelName}');
return false;
});
$("#vs_panel_{$this->modelName} #btn-enable-obj").click(function(){
if(objChecked.length==0){
alert("{$this->getLang()->getWords('error_none_select')}");
return false;
}
vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_visible_checked/'+objChecked,'vs_panel_{$this->modelName}');
return false;
});
$("#vs_panel_{$this->modelName} #btn-home-obj").click(function(){
if(objChecked.length==0){
alert("{$this->getLang()->getWords('error_none_select')}");
return false;
}
vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_home_checked/'+objChecked,'vs_panel_{$this->modelName}');
return false;
});
$("#vs_panel_{$this->modelName} #btn-index-change-obj").click(function(){
vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_index_change/','vs_panel_{$this->modelName}');
return false;
});

$("#vs_panel_{$this->modelName} #btn-submit-import").click(function(){
vsf.uploadFile("frm_obj_list",'{$bw->input[0]}','import_module','vs_panel_{$this->modelName}','import_module');
return false;
});

$("#vs_panel_{$this->modelName} #btn-add-obj").click(btnAdd_Click);

function btnAdd_Click(){
var hashbase=$(this).parents('.ui-tabs-panel').attr('id');
window.location.hash=hashbase+"/{$bw->input[0]}/{$this->modelName}_add_edit_form/";
///alert(window.location.hash);
//vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_add_edit_form/','vs_panel_{$this->modelName}');
}
function btnEditItem_Click(id,c){
var hashbase=$(c).parents('.ui-tabs-panel').attr('id');
window.location.hash=hashbase+"/{$bw->input[0]}/{$this->modelName}_add_edit_form/"+id+'&{$bw->input['back']}';
///vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_add_edit_form/'+id,'vs_panel_{$this->modelName}');
//alert(hashbase);
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
function changCate(){
if(objChecked.length){
vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_change_cate/'+objChecked,'vs_panel_{$this->modelName}');
}else{
jAlert("{$this->getLang()->getWords('error_none_select')}");
}
return false;
}
</script>

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
function __foreach_loop__id_5483ca982a3e96_11349663($objItems=array(),$option=array())
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
<td><input onClick="checkRow()" class="btn_checkbox" value="{$item->getId()}" type="checkbox" /></td>
<td>{$item->getId()}</td>

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_class_field",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<td> <a onClick="btnEditItem_Click({$item->getId()},this);return false;" href="#">{$item->getClass()}</a></td>

EOF;
}

$BWHTML .= <<<EOF

<td>{$item->getTitle()}</td>

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_category_list",0,$bw->input[0])) {
$BWHTML .= <<<EOF

<td>

EOF;
if($this->getMenu()->getCategoryById($item->getCatId())) {
$BWHTML .= <<<EOF

{$this->getMenu()->getCategoryById($item->getCatId())->getTitle()}

EOF;
}

else {
$BWHTML .= <<<EOF

{$this->getLang()->getWords("Uncategory")}

EOF;
}
$BWHTML .= <<<EOF

</td>

EOF;
}

$BWHTML .= <<<EOF

<td class="status"><img src="{$bw->vars['img_url']}/status_{$item->getStatus()}.png"/></td>
<td>{$this->dateTimeFormat($item->getPostDate(),"d/m/Y") }</td>

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_index",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<td class="index"><input type="textbox" name="indexitem[{$item->getId()}]" value="{$item->getIndex()}"/></td>

EOF;
}

$BWHTML .= <<<EOF

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
// <vsf:addOtionList:desc::trigger:>
//===========================================================================
function addOtionList($obj="") {           global  $bw;
            
//--starthtml--//
$BWHTML .= <<<EOF
        <input type="button" onClick="btnEditItem_Click({$obj->getId()},this)" class="btnEdit" value="{$this->getLang()->getWords('edit')}" />
            
EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_delete',1)) {
$BWHTML .= <<<EOF

<input  type="button" onClick="btnRemoveItem_Click({$obj->getId()})" class="btnDelete" value="{$this->getLang()->getWords('delete')}" />

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_review',0, $bw->input[0], 1, 1)) {
$BWHTML .= <<<EOF

<a href="{$bw->vars['board_url']}/{$bw->input[0]}/{$this->modelName}_review" target="_blank" class="btnReview">&nbsp;</a>

EOF;
}

$BWHTML .= <<<EOF

                
EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_video',0, $bw->input[0], 1, 1)) {
$BWHTML .= <<<EOF

                    <a class="ui-state-default ui-corner-all ui-state-focus" href="javascript:;" onclick="vsf.popupGet('gallerys/gallerys_display-album-tab/{$bw->input[0]}/{$obj->getId()}&albumCode=video_{$bw->input[0]}','albumn')">
                            {$this->getLang()->getWords('video')}
                    </a>
               
EOF;
}

$BWHTML .= <<<EOF
     
               
EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_album',0, $bw->input[0], 1, 1)) {
$BWHTML .= <<<EOF

                    <input class="btnAlbum" type="button" onclick="vsf.popupGet('gallerys/gallerys_display-album-tab/{$bw->input[0]}/{$obj->getId()}&albumCode=image','albumn',700,500)" value="{$this->getLang()->getWords('album')}" />
                
EOF;
}

$BWHTML .= <<<EOF

                
EOF;
if( $this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_comment',0, $bw->input[0], 1, 1)) {
$BWHTML .= <<<EOF

                    <a  title="{$this->getLang()->getWords('comment')}" class=" href="comments/comment-tab/{$this->modelName}/{$obj->getId()}" >
                            {$this->getLang()->getWords('comment')}
                    </a>
                
EOF;
}

$BWHTML .= <<<EOF

                
EOF;
if(!$obj->virtual) {
$BWHTML .= <<<EOF

                <input class="btnAction" type="button" onclick="vsf.popupGet('modules/exports/{$obj->getId()}','export_dialog',900,500)" value="Export" />
                
EOF;
}

$BWHTML .= <<<EOF

EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:exportsModule:desc::trigger:>
//===========================================================================
function exportsModule($option=array()) {      global  $bw;
      
       
      
 
       
//--starthtml--//
$BWHTML .= <<<EOF
        <form id="exportForm">
        
        
EOF;
if($option['msg']) {
$BWHTML .= <<<EOF

        <h3>{$option['msg']}</h3>
        </br>Dir:{$option['download']}
        
EOF;
}

$BWHTML .= <<<EOF

        
EOF;
if($option['download']) {
$BWHTML .= <<<EOF

        <h1><a href="{$option['download']}">Download module</a></h1>
        
EOF;
}

$BWHTML .= <<<EOF

        
        
EOF;
if($option['user']) {
$BWHTML .= <<<EOF

<div class="core">
<h3>Skin_user</h3>
{$this->__foreach_loop__id_5483ca982b98b0_65802534($option)}
</div>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($option['admin']) {
$BWHTML .= <<<EOF

<div class="core">
<h3>Skin_admin</h3>
{$this->__foreach_loop__id_5483ca982ba3e9_93970238($option)}
</div>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($option['table']) {
$BWHTML .= <<<EOF

<div class="core">
<h3>Database</h3>
{$this->__foreach_loop__id_5483ca982badd4_31997265($option)}
</div>

EOF;
}

$BWHTML .= <<<EOF

<div class="core" style="display:none;">
{$this->__foreach_loop__id_5483ca982bb763_86470315($option)}
</div>
<input type="hidden" name="namemodule" value="{$option['module']['class']}">

EOF;
if($option['core']) {
$BWHTML .= <<<EOF

<input type="submit" value="Export" id="submit_export"/>

EOF;
}

$BWHTML .= <<<EOF

<script>  
   $("#exportForm").submit(function(){
vsf.submitForm($("#exportForm"),"modules/do_exports","export_dialog");
return false;
});
 </script>
        
        </form>
        
        
        
        <style>
        .core{
        width:260px;
        float:left;
        }
        .core input{
        margin-top:3px;
        float:left;
        }
        .core span{
        display:block;
        float:left;
        padding:0px 0px 4px 4px;
        pad
        }
        #submit_export{
        padding:3px 10px;
        background:#000;
        color:#FFF;
        }
        
        </style>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_5483ca982b98b0_65802534($option=array())
{
      global  $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['user'])){
    foreach( $option['user'] as $value )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<input name="user[$value]" value="{$value}" type="checkbox"/><span>{$value}</span><div class="clear"></div>

EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}


//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_5483ca982ba3e9_93970238($option=array())
{
      global  $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['admin'])){
    foreach( $option['admin'] as $value )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<input name="admin[$value]" value="{$value}" type="checkbox"/><span>{$value}</span><div class="clear"></div>

EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}


//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_5483ca982badd4_31997265($option=array())
{
      global  $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['table'])){
    foreach( $option['table'] as $value )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<input name="database[$value]" value="{$value}" type="checkbox"/><span>{$value}</span><div class="clear"></div>

EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}


//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_5483ca982bb763_86470315($option=array())
{
      global  $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['core'])){
    foreach( $option['core'] as $value )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<input name="core[$value]" value="{$value}" type="hidden"/><span>{$value}</span><div class="clear"></div>

EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}


}
?>