<?php
if(!class_exists('skin_board_admin'))
require_once ('./cache/skins/admin/red/skin_board_admin.php');
class skin_objectadmin extends skin_board_admin {

//===========================================================================
// <vsf:objListHtml:desc::trigger:>
//===========================================================================
function objListHtml($option=array()) {global $bw;

//--starthtml--//
$BWHTML .= <<<EOF
        <input type="hidden" name="modelName" class="modelName" value="{$this->modelName}" />
<input type="hidden" name="moduleName" class="modelName" value="{$bw->input[0]}" />
<div class="vs_panel" id="vs_panel_{$this->modelName}">
{$option['table']}
</div>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:getSearchForm:desc::trigger:>
//===========================================================================
function getSearchForm($option=array()) {global $bw;
$token = base64_encode ( time () );

//--starthtml--//
$BWHTML .= <<<EOF
        <form class="frm_search" id="frm_search">
<label>
{$this->getLang()->getWords('id')}
<input size="2" type="text"  name='search[id]' value="{$bw->input['search']['id']}"/>
</label>
<label>
{$this->getLang()->getWords('title','Tiêu đề')}
<input  name='search[title]' size="25" type="text" value="{$bw->input['search']['title']}"/>
</label>

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_category_list",0,$bw->input[0])) {
$BWHTML .= <<<EOF

<label>
{$this->getLang()->getWords("category",'Danh mục')}
<select name='search[catId]'>
<option value="-1">{$this->getLang()->getWords("all",'Tất cả')}</option>
{$this->model->getCategories()->getChildrenBoxOption($bw->input['search']['catId'])}
</select>
</label>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_status",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<label>
{$this->getLang()->getWords('status','Trạng thái')}
<select name='search[status]'>
<option 
EOF;
if($bw->input['search']['status']==-1) {
$BWHTML .= <<<EOF
selected='selected'
EOF;
}

$BWHTML .= <<<EOF
 value="-1">{$this->getLang()->getWords('all')}</option>
<option 
EOF;
if($bw->input['search']['status']=='0') {
$BWHTML .= <<<EOF
selected='selected'
EOF;
}

$BWHTML .= <<<EOF
 value="0">{$this->getLang()->getWords('action_hide','Ẩn')}</option>
<option 
EOF;
if($bw->input['search']['status']==1) {
$BWHTML .= <<<EOF
selected='selected'
EOF;
}

$BWHTML .= <<<EOF
 value="1">{$this->getLang()->getWords('action_visible','Hiện')}</option>
</select>
</label>

EOF;
}

$BWHTML .= <<<EOF

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
// <vsf:getListItemTable:desc::trigger:>
//===========================================================================
function getListItemTable($objItems=array(),$option=array()) {global $bw;
//echo 123; exit();
$setting="{$bw->base_url}settings#settings/settings/settings_search/&search[catName]={$bw->input[0]}";

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
<table class="obj_list">
<thead>
<tr>
<th class="check-column" scope="col"><input type="checkbox" onClick="checkAllClick()" class="check_all" name=""/></th>

EOF;
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_Id','ID',$bw->input[0].'_'.$this->modelName.'_list')) {
$BWHTML .= <<<EOF

<th onclick="orderItem('id', '{$option['s_order']}')" class="id" scope="col">{$this->getLang()->getWords("id")}</th>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_image_field','Image',$bw->input[0].'_'.$this->modelName.'_list')) {
$BWHTML .= <<<EOF

<th class="img">{$this->getLang()->getWords("image","Hình ảnh")}</th>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_title','Title',$bw->input[0].'_'.$this->modelName.'_list')) {
$BWHTML .= <<<EOF

<th onclick="orderItem('title', '{$option['s_order']}')" class="title" scope="col">{$this->getLang()->getWords("title","Tiêu đề")}</th>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_category_list','Category',$bw->input[0].'_'.$this->modelName.'_list')) {
$BWHTML .= <<<EOF

<th>{$this->getLang()->getWords("category",'Danh mục')}</th>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_status','Status',$bw->input[0].'_'.$this->modelName.'_list')) {
$BWHTML .= <<<EOF

<th onclick="orderItem('status', '{$option['s_order']}')" class="status" scope="col">{$this->getLang()->getWords("status","Trạng thái")}</th>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_postdate','postdate',$bw->input[0].'_'.$this->modelName.'_list')) {
$BWHTML .= <<<EOF

<th class="date">{$this->getLang()->getWords("postdate","Ngày đăng")}</th>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_index','index',$bw->input[0].'_'.$this->modelName.'_list')) {
$BWHTML .= <<<EOF

<th class="index" scope="col">{$this->getLang()->getWords("index","Thứ tự")}</th>

EOF;
}

$BWHTML .= <<<EOF

<th class="action" scope="col">{$this->getLang()->getWords("action","Thao tác")}</th>
</tr>
</thead>
<tbody>

EOF;
if($objItems) {
$BWHTML .= <<<EOF

{$this->__foreach_loop__id_5483da325e0271_07422031($objItems,$option)}

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
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_category_list','Category',$bw->input[0].'_'.$this->modelName.'_list') and $this->model->getCategories()->getChildren()) {
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

$("#vs_panel_{$this->modelName} #btn-highlight-obj").click(function(){
if(objChecked.length==0){
vsf.alert("{$this->getLang()->getWords('global_error_none_select','Vui lòng chọn một hay nhiều tin')}");
return false;
}
vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_highlight_checked/'+objChecked,'vs_panel_{$this->modelName}');
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
vsf.submitForm($("#vs_panel_{$this->modelName} #frm_obj_list"),'{$bw->input[0]}/{$this->modelName}_index_change/','vs_panel_{$this->modelName}');
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
function __foreach_loop__id_5483da325e0271_07422031($objItems=array(),$option=array())
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

EOF;
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_Id','ID',$bw->input[0].'_'.$this->modelName.'_list')) {
$BWHTML .= <<<EOF

<td>{$item->getId()}</td>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_image_field','Image',$bw->input[0].'_'.$this->modelName.'_list')) {
$BWHTML .= <<<EOF

<td> <a onClick="btnEditItem_Click({$item->getId()},this);return false;" href="">{$item->createImageCache($item->getImage(),100,50)}</a></td>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_title','Title',$bw->input[0].'_'.$this->modelName.'_list')) {
$BWHTML .= <<<EOF

<td><a onClick="btnEditItem_Click({$item->getId()},this);return false;" href="">{$item->getTitle()}</a></td>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_category_list','Category',$bw->input[0].'_'.$this->modelName.'_list')) {
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

{$this->getLang()->getWords("Uncategory","Không có danh mục")}

EOF;
}
$BWHTML .= <<<EOF

</td>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_status','Status',$bw->input[0].'_'.$this->modelName.'_list')) {
$BWHTML .= <<<EOF

<td class="status"><img src="{$bw->vars['img_url']}/status/status_{$item->getStatus()}.png"></td>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_postdate','postdate',$bw->input[0].'_'.$this->modelName.'_list')) {
$BWHTML .= <<<EOF

<td>{$this->dateTimeFormat($item->getPostDate(),"d/m/Y") }</td>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_index','index',$bw->input[0].'_'.$this->modelName.'_list')) {
$BWHTML .= <<<EOF

<td class="index"><input type="text" name="indexitem[{$item->getId()}]" value="{$item->getIndex()}" size="3"/></td>

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
// <vsf:displayObjTab:desc::trigger:>
//===========================================================================
function displayObjTab($option="") {global $bw;

//--starthtml--//
$BWHTML .= <<<EOF
        {$option ['objList']}
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:addOtionList:desc::trigger:>
//===========================================================================
function addOtionList($obj="") {global $bw;

//--starthtml--//
$BWHTML .= <<<EOF
        <input type="button" onClick="btnEditItem_Click({$obj->getId()},this)" class="icon-wrapper icon-wrapper-vs btnEdit" title="{$this->getLang()->getWords('action_edit','Sửa')}" />
            
EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_delete',1)) {
$BWHTML .= <<<EOF

<input  type="button" onClick="btnRemoveItem_Click({$obj->getId()})" class="icon-wrapper icon-wrapper-vs btnDelete" title="{$this->getLang()->getWords('action_delete','Xóa')}" />

EOF;
}

$BWHTML .= <<<EOF

                
EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_video',0, $bw->input[0], 1, 1)) {
$BWHTML .= <<<EOF

                    <input  type="button" class="icon-wrapper icon-wrapper-vs btnVideo" title="{$this->getLang()->getWords('video','Video')}" onclick="vsf.popupGet('gallerys/gallerys_display-album-tab/{$bw->input[0]}/{$obj->getId()}&albumCode=video_{$bw->input[0]}','albumn')">
                            
               
EOF;
}

$BWHTML .= <<<EOF
     
               
EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_album',0, $bw->input[0], 1, 1)) {
$BWHTML .= <<<EOF

                    <input class="icon-wrapper icon-wrapper-vs btnAlbum" type="button" onclick="vsf.popupGet('gallerys/gallerys_display-album-tab/{$bw->input[0]}/{$obj->getId()}&albumCode=image','albumn',700,500,'{$this->getLang()->getWords('album','Album hình ảnh')}')" title="{$this->getLang()->getWords('album','Album hình ảnh')}" />
                
EOF;
}

$BWHTML .= <<<EOF

                
EOF;
if( $this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_comment',0, $bw->input[0], 1, 1)) {
$BWHTML .= <<<EOF

                    <input  type="button"  title="{$this->getLang()->getWords('comment')}" class="icon-wrapper icon-wrapper-vs btnComment" href="comments/comment-tab/{$this->modelName}/{$obj->getId()}" title="{$this->getLang()->getWords('comment','Bình luật')}" />
                            
                
EOF;
}

$BWHTML .= <<<EOF

EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:addEditObjForm:desc::trigger:>
//===========================================================================
function addEditObjForm($obj="",$option=array()) {global $bw;
$seo = "style='display:none'";
if ($obj->getMTitle() or $obj->getMKeyword() or $obj->getMUrl() or $obj->getMIntro()){
$seo = "";
}
//echo 123; exit();

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
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_status','Status',$bw->input[0].'_'.$this->modelName.'_form')) {
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
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_category_list','Category',$bw->input[0].'_'.$this->modelName.'_form') and $this->model->getCategories()->getChildren()) {
$BWHTML .= <<<EOF

<tr>
<td><label>{$this->getLang()->getWords("category",'Danh mục')}</label></td>
<td>
<select  name="{$this->modelName}[catId]" id="vs_cate">
{$this->model->getCategories()->getChildrenBoxOption($obj->getCatId())}
</select>
<br>
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_index','index',$bw->input[0].'_'.$this->modelName.'_form')) {
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
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_code','code',$bw->input[0].'_'.$this->modelName.'_form')) {
$BWHTML .= <<<EOF

<tr>
<td><label>{$this->getLang()->getWords("code","Mã")}</label></td>
<td>
<input  name="{$this->modelName}[code]" id="{$this->modelName}_code" type="text" value="{$obj->getCode()}" />
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_image_field','Image',$bw->input[0].'_'.$this->modelName.'_form')) {
$BWHTML .= <<<EOF

<tr>
<td><label>{$this->getLang()->getWords('image','Hình ảnh')}</label>
<p>

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_image_width",'')&&$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_image_height",'')) {
$BWHTML .= <<<EOF

{$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_image_width",'')}x{$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_image_height",'')}px

EOF;
}

$BWHTML .= <<<EOF

</p>
</td>
<td>
<div style="float:left;width:300px">
<label>
<input name="filetype[image]" value="file" type="radio" checked='checked' obj="image-file"/>
{$this->getLang()->getWords('upload','Tải lên từ máy')}:</label>
<label>
<input    type="file" value="" style='width:250px;'  id="image-file" name="image"/>
</label>
<br/>
<label>
<input name="filetype[image]"   value="link" type="radio" obj="image-link"/>
{$this->getLang()->getWords('download_from','Tải về từ đường dẫn')}:
</label>
<label>
<input disabled='disabled' type="text" value="" style='width:250px;' id="image-link" name="links[image]"/>
</label>
</div>
<div style="float:left;width:200px">

EOF;
if($obj->getImage()) {
$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_image_height",'')&&$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_image_width",'')) {
$BWHTML .= <<<EOF

{$obj->createImageEditable($obj->getImage(),100,90,$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_image_width",''),$this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_image_height",''))}

EOF;
}

else {
$BWHTML .= <<<EOF

{$obj->createImageEditable($obj->getImage(),100,90)}

EOF;
}
$BWHTML .= <<<EOF


EOF;
}

$BWHTML .= <<<EOF

</div>
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_intro','Intro',$bw->input[0].'_'.$this->modelName.'_form')) {
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


EOF;
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_content','Content',$bw->input[0].'_'.$this->modelName.'_form')) {
$BWHTML .= <<<EOF

<tr>
<td><label>{$this->getLang()->getWords('content','Nội dung')}</label></td>
<td>
{$this->createEditor($obj->getContent(), "{$this->modelName}[content]", "100%", "333px","full")}
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
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_disable',1)) {
$BWHTML .= <<<EOF

<input type="button" class="icon-wrapper icon-wrapper-vs btnDisable" id="btn-disable-obj" title="{$this->getLang()->getWords('global_action_hide','Ẩn')}"/>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName.'_button_visible',1)) {
$BWHTML .= <<<EOF

<input type="button" class="icon-wrapper icon-wrapper-vs btnEnable" id="btn-enable-obj" title="{$this->getLang()->getWords('global_action_visible','Hiện')}"/>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_status_home",0,$bw->input[0])) {
$BWHTML .= <<<EOF

<input type="button" class="icon-wrapper icon-wrapper-vs btnHome" id="btn-home-obj" title="{$this->getLang()->getWords('global_action_home','Trang chủ')}"/>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_status_trash_action",0,$bw->input[0])) {
$BWHTML .= <<<EOF

<input type="button" class="icon-wrapper icon-wrapper-vs btnTrash" id="btn-trash-obj" title="{$this->getLang()->getWords('global_action_trash','Đưa vào thùng rác')}"/>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_status_highlight",0,$bw->input[0])) {
$BWHTML .= <<<EOF

<input type="button" class="icon-wrapper icon-wrapper-vs bt_highlight"  id="btn-highlight-obj" title="{$this->getLang()->getWords('global_action_hightlight','Nỗi bật')}"/>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_index','index',$bw->input[0].'_'.$this->modelName.'_list')) {
$BWHTML .= <<<EOF

<input type="button" class="icon-wrapper icon-wrapper-vs btnIndexChange" id="btn-index-change-obj" title="{$this->getLang()->getWords('global_action_index_change','Cập nhật thứ tự')}"/>

EOF;
}

$BWHTML .= <<<EOF

EOF;
//--endhtml--//
return $BWHTML;
}


}
?>