<?php
if(!class_exists('skin_objectadmin'))
require_once ('./cache/skins/admin/red/skin_objectadmin.php');
class skin_tags extends skin_objectadmin {

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
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_image_field",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<th class="img">{$this->getLang()->getWords("image")}</th>

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

<th class="status">{$this->getLang()->getWords("count")}</th>

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_postdate",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<th class="date">{$this->getLang()->getWords("postdate")}</th>

EOF;
}

$BWHTML .= <<<EOF


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

{$this->__foreach_loop__id_547ddc10a259b5_93148687($objItems,$option)}

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
</div>
<div class="more_action">
<img width="38" height="22" alt="With selected:" src="{$bw->vars['img_url']}/arrow_ltr.png" class="selectallarrow">

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_category_list",0,$bw->input[0])) {
$BWHTML .= <<<EOF

<label>Move selected to 
<select name='toCatId'>
{$this->model->getCategories()->getChildrenBoxOption()}
</select>
</label>
<input type="button" class="btnOk" name="" onClick="changCate()"  value="go"/>
<br>

EOF;
}

$BWHTML .= <<<EOF


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
function __foreach_loop__id_547ddc10a259b5_93148687($objItems=array(),$option=array())
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
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_image_field",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<td> <a onClick="btnEditItem_Click({$item->getId()},this);return false;" href="">{$item->createImageCache($item->getImage(),100,50)}</a></td>

EOF;
}

$BWHTML .= <<<EOF

<td><a onClick="btnEditItem_Click({$item->getId()},this);return false;" href="">{$item->getTitle()}</a></td>

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

<td class="status">{$this->numberFormat($item->getCount())}</td>

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_postdate",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<td>{$this->dateTimeFormat($item->getPostDate(),"d/m/Y") }</td>

EOF;
}

$BWHTML .= <<<EOF


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
// <vsf:getTagScript:desc::trigger:>
//===========================================================================
function getTagScript($option="") {global $vsLang, $bw,$vsSettings;
$BWHTML = "";
$count = 0;
$html=str_replace(array("\n","\""), array(" ","\\\""), $this->getHTML($option));

//--starthtml--//
$BWHTML .= <<<EOF
        $("#tag_panel_diplay").html("$html");
$(document).click(function(event){
             var tar=$(event.target);
             if(tar.parents("#tag_panel_selection").length==0){
             $("#tag_panel_selection_tag").hide();
             }
});
$("#tag_panel_selection_tag a").click(function(){
var mySplitResult = $("#tag_panel_selection_text").val().split(",");
for(i = 0; i < mySplitResult.length; i++){
if($(this).text()==mySplitResult[i].replace(/^\s+|\s+$/g,"")) return false;
}
if($("#tag_panel_selection_text").val().replace(/^\s+|\s+$/g,"").length==0)
$("#tag_panel_selection_text").val($(this).text());
else $("#tag_panel_selection_text").val($("#tag_panel_selection_text").val()+","+$(this).text());
return false;
});
$("#tag_panel_selection_text").focus(function(){
             $("#tag_panel_selection_tag").fadeIn("slow");
});
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:getHTML:desc::trigger:>
//===========================================================================
function getHTML($option="") {global $vsLang, $bw,$vsSettings;
$BWHTML = "";
$count = 0;

//--starthtml--//
$BWHTML .= <<<EOF
        <div id="tag_panel_selection" style="position: relative; width: 95%; height: auto; float: left;">
            <input type="text" style="width:90%;"  id="tag_panel_selection_text" name="tags_submit_list" value="{$option['taged']}">
            <div id="tag_panel_selection_tag" style=" background: #ddd;display:none;">
            <div style="">
            
EOF;
if($option['newtag']) {
$BWHTML .= <<<EOF

     {$this->__foreach_loop__id_547ddc10a35246_52349121($option)}

EOF;
}

$BWHTML .= <<<EOF

</div>
            </div>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547ddc10a35246_52349121($option="")
{
global $vsLang, $bw,$vsSettings;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['newtag'])){
    foreach( $option['newtag'] as $tag )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
               
<a href="#" style="font-size:{$tag->size}px;">{$tag->getTitle()}</a>,

EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}


}
?>