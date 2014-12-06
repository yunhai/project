<?php
if(!class_exists('skin_objectadmin'))
require_once ('./cache/skins/admin/red/skin_objectadmin.php');
class skin_settings extends skin_objectadmin {

//===========================================================================
// <vsf:getSearchForm:desc::trigger:>
//===========================================================================
function getSearchForm($option=array()) {global $bw;
$token = base64_encode ( time () );

//--starthtml--//
$BWHTML .= <<<EOF
        <form class="frm_search" id="frm_search">
<label>
{$this->getLang()->getWords('title','Tiêu đề')}
<input  name='search[title]' size="25" type="text" value="{$bw->input['search']['title']}"/>
</label>
<label>
{$this->getLang()->getWords("modules",'Modules')}
<select name='search[catName]'>
<option value="-1">{$this->getLang()->getWords("all",'Tất cả')}</option>
{$this->__foreach_loop__id_547ddc10989dd9_74007952($option)}
</select>
</label>
<input type="hidden" id="sorder" value="{$option['s_order']}" name="search[s_order]"/>
<input type="hidden" id="sfield" value="{$option['s_ofield']}" name="search[s_ofield]"/>
<input type="hidden" value="$token" name="token"/>
<button  class="btnSearch" type="submit"><span><img src="{$bw->vars['img_url']}/pixel-vfl3z5WfW.gif" class="icon-wrapper-vs vs-icon-search"></span><span>{$this->getLang()->getWords('search','Tìm kiếm')}<span></button>
</form>
<script>
function orderItem(field, order){
$("#sfield").val(field);
$("#sorder").val(order);
$("#vs_panel_{$this->modelName} #frm_search").submit();
}
$("#vs_panel_{$this->modelName} #frm_search").submit(function(){
var hashbase=$(this).parents('.ui-tabs-panel').attr('id');
window.location.hash=hashbase+"/{$bw->input[0]}/{$this->modelName}_search/&"+$(this).serialize();
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
function __foreach_loop__id_547ddc10989dd9_74007952($option=array())
{
global $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['categorys'])){
    foreach( $option['categorys'] as $cat )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<option 
EOF;
if($cat->getUrl()==$bw->input['search']['catName']) {
$BWHTML .= <<<EOF
selected='selected'
EOF;
}

$BWHTML .= <<<EOF
 value="{$cat->getUrl()}">{$cat->getTitle()}</option>

EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:getListItemTable:desc::trigger:>
//===========================================================================
function getListItemTable($objItems=array(),$option=array()) {global $bw;


//--starthtml--//
$BWHTML .= <<<EOF
        <div class="ui-dialog">
<span class="ui-dialog-title">{$this->getLang()->getWords($this->modelName."_title","Danh sách bài viết")}</span>

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_search_form",1,$bw->input[0])) {
$BWHTML .= <<<EOF

{$this->getSearchForm($option)}

EOF;
}

$BWHTML .= <<<EOF

<form class="frm_obj_list" id="frm_obj_list">
<div class="vs-button">
{$this->addOption()}
</div>
<div id="{$this->modelName}_item_panel">
<input type="hidden" name="catId" value="{$bw->input['catId']}"/>
<input type="hidden" name="pageIndex" value="{$bw->input['pageIndex']}"/>
<table class="obj_list setting_list">
<thead>
<tr>
<th class="check-column" scope="col"><input type="checkbox" onClick="checkAllClick()" class="check_all" name=""/></th>
<th onclick="orderItem('id', '{$option['s_order']}')" class="id" scope="col">{$this->getLang()->getWords("id")}</th>
<th onclick="orderItem('title', '{$option['s_order']}')" class="title setting_title" scope="col">{$this->getLang()->getWords("title","Tiêu đề")}</th>

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_category_list",0,$bw->input[0])) {
$BWHTML .= <<<EOF

<th>{$this->getLang()->getWords("category",'Danh mục')}</th>

EOF;
}

$BWHTML .= <<<EOF

<!--
<th onclick="" class="status" scope="col">{$this->getLang()->getWords("Shared","Chia sẻ")}</th>
-->
<th class="value_setting" scope="col">Value</th>
</tr>
</thead>
<tbody>

EOF;
if($objItems) {
$BWHTML .= <<<EOF

{$this->__foreach_loop__id_547ddc1098f0b4_60156707($objItems,$option)}

EOF;
}

else {
$BWHTML .= <<<EOF

<tr><td colspan="10">{$this->getLang()->getWords("no_data","Hiện không có dữ liệu")}</td></tr>

EOF;
}
$BWHTML .= <<<EOF

</tbody>
<tfoot>
<tr>
<th colspan="3">{$this->addOption()}</th>
<th colspan="10" class="pagination">{$option['paging']}</th>
</tr>
</tfoot>
</table>
</div>

EOF;
if($this->getSettings()->getSystemKey($bw->input[0]."_category_list",0,$bw->input[0]) and $this->model->getCategories()->getChildren()) {
$BWHTML .= <<<EOF

<div class="more_action">
<label>{$this->getLang()->getWords("move_to_categories","Di chuyển đến")} 
<select name='toCatId'>
{$this->model->getCategories()->getChildrenBoxOption()}
</select>
</label>
<input type="button" class="icon-wrapper icon-wrapper-vs btnGo" name="" onClick="changCate()"  title="{$this->getLang()->getWords("move_to_categories","Di chuyển đến")} "/>
</div>

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

</form>
</div>
<script>
function updateRoot(element){
var value=$(element).attr("value")==0?1:0;
var id=$(element).attr("vsid");
$.ajax({
url: baseUrl+'settings/settings_update_root_status/',
type: 'POST',
dataType:'json',
cache: false,
data: 'ajax=1&id='+id+'&value='+value,
success: function(data){
if(data.status==0){
 alert(data.message);
return false;
 }
$(element).attr("value",data.value);
if(data.value==0){
$(element).removeClass("unshared");
$(element).addClass("shared");
}else{
$(element).removeClass("shared");
$(element).addClass("unshared");
}
},
error: function (){
alert('Có lỗi xảy ra');
}
});
}
var objChecked=new Array();
////////////////checked
function checkAllClick(){
var check=$("#vs_panel_{$this->modelName}  .check_all").attr("checked");
objChecked=new Array();
$("#vs_panel_{$this->modelName} .btn_checkbox").each(function(){
if(check=='checked'){
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
$("#vs_panel_{$this->modelName} #frm_obj_list").submit(function(){
});
$("#vs_panel_{$this->modelName} #btn-delete-obj").click(function(){
if(objChecked.length==0){
vsf.alert("{$this->getLang()->getWords('global_error_none_select','Vui lòng chọn một hay nhiều tin')}");
return false;
}
jConfirm(
                     "{$this->getLang()->getWords('global_yesno_delete','Bạn có chắc chắn muốn xóa nó?')}?",
                     "Hộp thông báo",
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
alert("{$this->getLang()->getWords('global_error_none_select','Vui lòng chọn một hay nhiều tin')}");
return false;
}
vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_hide_checked/'+objChecked,'vs_panel_{$this->modelName}');
return false;
});
$("#vs_panel_{$this->modelName} #btn-enable-obj").click(function(){
if(objChecked.length==0){
vsf.alert("{$this->getLang()->getWords('global_error_none_select','Vui lòng chọn một hay nhiều tin')}");
return false;
}
vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_visible_checked/'+objChecked,'vs_panel_{$this->modelName}');
return false;
});
$("#vs_panel_{$this->modelName} #btn-home-obj").click(function(){
if(objChecked.length==0){
vsf.alert("{$this->getLang()->getWords('global_error_none_select','Vui lòng chọn một hay nhiều tin')}");
return false;
}
vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_home_checked/'+objChecked,'vs_panel_{$this->modelName}');
return false;
});
$("#vs_panel_{$this->modelName} #btn-trash-obj").click(function(){
if(objChecked.length==0){
vsf.alert("{$this->getLang()->getWords('global_error_none_select','Vui lòng chọn một hay nhiều tin')}");
return false;
}
vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_trash_checked/'+objChecked,'vs_panel_{$this->modelName}');
return false;
});
$("#vs_panel_{$this->modelName} #btn-index-change-obj").click(function(){
vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_value_change/','vs_panel_{$this->modelName}');
return false;
});


$("#vs_panel_{$this->modelName} #btn-add-obj").click(btnAdd_Click);

function btnAdd_Click(){
var hashbase=$(this).parents('.ui-tabs-panel').attr('id');
window.location.hash=hashbase+"/{$bw->input[0]}/{$this->modelName}_add_edit_form/";
}
function btnEditItem_Click(id,c){
var hashbase=$(c).parents('.ui-tabs-panel').attr('id');
window.location.hash=hashbase+"/{$bw->input[0]}/{$this->modelName}_add_edit_form/"+id+'&{$bw->input['back']}';
return false;
}
function btnRemoveItem_Click(id){
jConfirm(
                     "{$this->getLang()->getWords('global_yesno_delete')}?",
                     "Hộp thông báo",
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
vsf.alert("{$this->getLang()->getWords('global_error_none_select')}");
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
function __foreach_loop__id_547ddc1098f0b4_60156707($objItems=array(),$option=array())
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
<th class="check-column check_td" scope="row"><input onClick="checkRow()"  value="{$item->getId()}" type="checkbox" class="btn_checkbox"/></th>
<td>{$item->getId()}</td>
<td>
<span class="share">

EOF;
if($item->getRoot()) {
$BWHTML .= <<<EOF

<a href="" title="{$this->getLang()->getWords('Unshared',"Chưa chia sẻ")}" class="icon-wrapper-vs unshared" onCLick="updateRoot(this);return false;" vsid="{$item->getId()}" value="{$item->getRoot()}">&nbsp;</a>

EOF;
}

else {
$BWHTML .= <<<EOF

<a href="" title="{$this->getLang()->getWords('shared',"Chia sẻ")}" class="icon-wrapper-vs shared" onCLick="updateRoot(this);return false;" vsid="{$item->getId()}" value="{$item->getRoot()}">&nbsp;</a>

EOF;
}
$BWHTML .= <<<EOF

</span>
<a onClick="btnEditItem_Click({$item->getId()},this);return false;" href="">{$item->getTitle()}</a>
<div class="clear"></div>
<span class="setting_intro">{$item->getIntro()}</span>
</td>

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_category_list",0,$bw->input[0])) {
$BWHTML .= <<<EOF

<td>

EOF;
if($item->getCatId()) {
$BWHTML .= <<<EOF

{$this->getMenu()->getCategoryById($item->getCatId())->getTitle()}

EOF;
}

$BWHTML .= <<<EOF

</td>

EOF;
}

$BWHTML .= <<<EOF

<!--
<td class="status">

EOF;
if($item->getRoot()) {
$BWHTML .= <<<EOF

<a href="" title="{$this->getLang()->getWords('Unshared',"Chưa chia sẻ")}" class="icon-wrapper-vs unshared" onCLick="updateRoot(this);return false;" vsid="{$item->getId()}" value="{$item->getRoot()}">&nbsp;</a>

EOF;
}

else {
$BWHTML .= <<<EOF

<a href="" title="{$this->getLang()->getWords('shared',"Chia sẻ")}" class="icon-wrapper-vs shared" onCLick="updateRoot(this);return false;" vsid="{$item->getId()}" value="{$item->getRoot()}">&nbsp;</a>

EOF;
}
$BWHTML .= <<<EOF

</td>
-->

EOF;
if($item->showHTMLForm()) {
$BWHTML .= <<<EOF

<td>{$item->showHTMLForm()}</td>

EOF;
}

else {
$BWHTML .= <<<EOF

<td>
<input type="text" name="value[{$item->getId()}]"  value="{$this->get(htmlspecialchars($item->getValue()))}" />
</td>

EOF;
}
$BWHTML .= <<<EOF


</tr>

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
//input text
$inputtext="<input id='el_{id}' type='text' value='{value}'  name='value[{id}]'  />";
$input_text= htmlentities($inputtext);
//Select
$sele1="<select id='el_{id}' name='value[{id}]'>";
$sele2="<option value='1'>1</option>";
$sele3="<option value='2'>2</option>";
$sele4="<option value='3'>3</option>";
$sele5="</select>";
$sele6="<script>
   $('#el_{id}').val({value});
</script>
";
$input_sel1= htmlentities($sele1);
$input_sel2= htmlentities($sele2);
$input_sel3= htmlentities($sele3);
$input_sel4= htmlentities($sele4);
$input_sel5= htmlentities($sele5);
$input_sel6= htmlentities($sele6);
$textarea="<textarea style='width:100%; height:100px' id='el_{id}' name='value[{id}]'>{value}</textarea>";
$area= htmlentities($textarea);
$check1="<label><input id='el_{id}_0'  type='radio' value='0'  name='value[{id}]'  />Yes</label>";
$check2="<label><input id='el_{id}_1'  type='radio' value='1'  name='value[{id}]'  />No</label>";
$check3="<script>
   $('#el_{id}_{value}').attr('checked','checked');
</script>";
$chec1=htmlentities($check1);
$chec2=htmlentities($check2);
$chec3=htmlentities($check3);
$seo = "style='display:none'";
if ($obj->getMTitle() or $obj->getMKeyword() or $obj->getMUrl() or $obj->getMIntro()){
$seo = "";
}

//--starthtml--//
$BWHTML .= <<<EOF
        <div class="vs_panel" id="vs_panel_{$this->modelName}">
<div class="ui-dialog">
<form class="frm_add_edit_obj" id="frm_add_edit_obj"  method="POST" enctype='multipart/form-data'>
<input type="hidden" value="{$bw->input['vdata']}" name="vdata"/>
<input type="hidden" value="{$bw->input['pageIndex']}" name="pageIndex"/>
<input type="hidden" value="{$obj->getId()}" name="{$this->modelName}[id]" />
<!--<input type="hidden" value="{$obj->getSlug ()}" name="{$this->modelName}[mUrl]" id="mUrl" data-module="{$this->modelName}" data-id = "{$obj->getId()}" />-->
<table class="obj_add_edit" width="100%">
<thead>
<tr>
<th colspan="2">
<span class="ui-dialog-title-form">{$this->getLang()->getWords('add_edit_'.$bw->input[0],'Thêm/Sửa tin')}</span>
<div class="vs-buttons">
<button type="submit" ><span><img src="{$bw->vars['img_url']}/pixel-vfl3z5WfW.gif" class="icon-wrapper-vs vs-icon-accept"></span><span>{$this->getLang()->getWords('global_accept')}</span></button>
<button type="button" id="frm_close" class="btnCancel frm_close"><span><img src="{$bw->vars['img_url']}/pixel-vfl3z5WfW.gif" class="icon-wrapper-vs vs-icon-cancel"></span><span>{$this->getLang()->getWords("global_cancel")}</span></button>
</div>
</th>
</tr>
</thead>
<tbody>
<tr>
<td style="width: 111px;"><label>{$this->getLang()->getWords('title','Tiêu đề')}</label></td>
<td>
<input  name="{$this->modelName}[title]" id="{$this->modelName}_title" type="text" value="{$obj->getTitle()}" style='width:99%' onBlur="vsf.checkPermalink($('#{$this->modelName}_title').val(),'{$bw->input[0]}')"/>
</td>
</tr>
<tr>
</tr>

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_key",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<tr>
<td><label>Key</label></td>
<td>
<input style='width:50%'  name="{$this->modelName}[key]" id="{$this->modelName}_key" type="text" value="{$obj->getKey()}" />
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF

<tr>
<td><label>Group</label></td>
<td>
<textarea  style='width:50%'  name="group" id="{$this->modelName}_group">{$option['group_string']}</textarea>
</td>
</tr>
<tr>
<td><label>Value</label></td>
<td>
<input style='width:50%'  name="{$this->modelName}[value]" id="{$this->modelName}_value" type="text" value="{$obj->getValue()}" />
</td>
</tr>

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_value",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<tr>
<td><label>HTLM admin form</label></td>
<td>
<textarea id="{$this->modelName}_htmlValue" name="{$this->modelName}[htmlValue]" style="width: 99%; height: 111px;">{$this->get(htmlentities($obj->getHtmlValue()))}</textarea>
Example:<br />
<table class="example" border='1px'>
<tr>
<td>Textbox: </td>
<td>{$input_text}</td>
</tr>
<tr>
<td>Selectbox: </td>
<td>
{$input_sel1}<br />
{$input_sel2}<br />
{$input_sel3}<br />
{$input_sel4}<br />
{$input_sel5}<br />
{$input_sel6}<br />
</td>
</tr>
<tr>
<td>Textarea: </td>
<td>{$area}</td>
</tr>
<tr>
<td>Checkbox: </td>
<td>
{$chec1}<br />
{$chec2}<br />
{$chec3}
</td>
</tr>
<tr>
<td>Editor: </td>
<td>editor</td>

</tr>
</table>
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_status",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<tr>
<td style="width: 121px;"><label>{$this->getLang()->getWords('status','Trạng thái')}</label></td>
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
{$this->getLang()->getWords('global_hide','Ẩn')}
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
{$this->getLang()->getWords('global_visible','Hiện')}
</label>

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_status_home",0,$bw->input[0])) {
$BWHTML .= <<<EOF

<label>
<input  
EOF;
if($obj->getStatus()==2) {
$BWHTML .= <<<EOF
checked='checked'
EOF;
}

$BWHTML .= <<<EOF
  name="{$this->modelName}[status]" id="{$this->modelName}_status_2" type="radio" value="2"  />
{$this->getLang()->getWords('global_home','Trang chủ')}
</label>

EOF;
}

$BWHTML .= <<<EOF

</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF



EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_index",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<tr>
<td><label>{$this->getLang()->getWords("index",'Thứ tự')}</label></td>
<td>
<input  name="{$this->modelName}[index]" id="{$this->modelName}_index" type="text" value="{$obj->getIndex()}" />
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF



EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_intro",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<tr>
<td><label>{$this->getLang()->getWords('intro','Mô tả')}</label></td>
<td>

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_editor_intro",0,$bw->input[0])) {
$BWHTML .= <<<EOF

{$this->createEditor($obj->getIntro(), "{$this->modelName}[intro]", "100%", "111px","full")}

EOF;
}

else {
$BWHTML .= <<<EOF

<textarea id="{$this->modelName}_intro" name="{$this->modelName}[intro]" style="width: 99%; height: 111px;">{$obj->getIntro()}</textarea>

EOF;
}
$BWHTML .= <<<EOF

</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF



<tr style="border:none">
<td class="vs-button" colspan="2" >
<button type="submit" ><span><img src="{$bw->vars['img_url']}/pixel-vfl3z5WfW.gif" class="icon-wrapper-vs vs-icon-accept"></span><span>{$this->getLang()->getWords('global_accept')}</span></button>
<button type="button" id="frm_close" class="btnCancel frm_close"><span><img src="{$bw->vars['img_url']}/pixel-vfl3z5WfW.gif" class="icon-wrapper-vs vs-icon-cancel"></span><span>{$this->getLang()->getWords("global_cancel")}</span></button>
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
///alert(window.location.hash);
//vsf.get('{$bw->input[0]}/{$this->modelName}_display_tab&pageIndex={$bw->input['pageIndex']}&vdata={$_REQUEST['vdata']}','vs_panel_{$this->modelName}');
//vsf.get('{$bw->input[0]}/{$this->modelName}_display_tab','vs_panel_{$this->modelName}',{vdata:'{$_REQUEST['vdata']}',pageIndex:'{$bw->input['pageIndex']}'});
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
// <vsf:addOption:desc::trigger:>
//===========================================================================
function addOption() {global $bw;

//--starthtml--//
$BWHTML .= <<<EOF
        <input type="button" class="icon-wrapper icon-wrapper-vs btnValueChange" id="btn-index-change-obj" title="Lưu thay đổi"/>
<input type="button"  class="icon-wrapper icon-wrapper-vs btnDelete" id="btn-delete-obj" title="{$this->getLang()->getWords('global_action_delete','Xóa')}"/>
EOF;
//--endhtml--//
return $BWHTML;
}


}
?>