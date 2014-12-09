<?php
if(!class_exists('skin_objectadmin'))
require_once ('./cache/skins/admin/red/skin_objectadmin.php');
class skin_banners extends skin_objectadmin {

//===========================================================================
// <vsf:getSearchForm:desc::trigger:>
//===========================================================================
function getSearchForm($option=array()) {global $bw;
$token=base64_encode(time());

//--starthtml--//
$BWHTML .= <<<EOF
        <form class="frm_search" id="frm_search">
<label>
{$this->getLang()->getWords('id')}
<input size="2" type="text"  name='search[id]' value="{$bw->input['search']['id']}"/>
</label>
<label>
{$this->getLang()->getWords('title')}
<input  name='search[title]' size="25" type="text" value="{$bw->input['search']['title']}"/>
</label>

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_category_list",0,$bw->input[0])) {
$BWHTML .= <<<EOF

<label>
{$this->getLang()->getWords("category")}
<select name='search[catId]'>
<option value="-1">{$this->getLang()->getWords("All")}</option>
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
{$this->getLang()->getWords('status')}
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
 value="0">{$this->getLang()->getWords('action_hide')}</option>
<option 
EOF;
if($bw->input['search']['status']==1) {
$BWHTML .= <<<EOF
selected='selected'
EOF;
}

$BWHTML .= <<<EOF
 value="1">{$this->getLang()->getWords('action_visible')}</option>
</select>
</label>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_position",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<label>
{$this->getLang()->getWords('position','Vị trí')}
<select name='search[position]'>
<option 
EOF;
if($bw->input['search']['position']==-1) {
$BWHTML .= <<<EOF
selected='selected'
EOF;
}

$BWHTML .= <<<EOF
 value="-1">{$this->getLang()->getWords('all')}</option>
{$this->__foreach_loop__id_5483ca97d85414_90550762($option)}
</select>
</label>

EOF;
}

$BWHTML .= <<<EOF

<input type="hidden" id="sorder" value="{$option['s_order']}" name="search[s_order]"/>
<input type="hidden" id="sfield" value="{$option['s_ofield']}" name="search[s_ofield]"/>
<input type="hidden" value="$token" name="token"/>
<input  class="btnSearch" type="submit" value="{$this->getLang()->getWords('Search')}"/>
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
function __foreach_loop__id_5483ca97d85414_90550762($option=array())
{
global $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['position'])){
    foreach( $option['position'] as $value )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<option 
EOF;
if($bw->input['search']['position']==$value->getId()) {
$BWHTML .= <<<EOF
selected='selected'
EOF;
}

$BWHTML .= <<<EOF
 value="{$value->getId()}">{$value->getTitle()}</option>

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

//--starthtml--//
$BWHTML .= <<<EOF
        <div class="vs_panel" id="vs_panel_{$this->modelName}">
<div class="ui-dialog">
<form class="frm_add_edit_obj" id="frm_add_edit_obj"  method="POST" enctype='multipart/form-data'>
<input type="hidden" value="{$bw->input['vdata']}" name="vdata"/>
<input type="hidden" value="{$bw->input['pageIndex']}" name="pageIndex"/>
<input type="hidden" value="{$obj->getId()}" name="{$this->modelName}[id]"/>
<table class="obj_add_edit" width="100%">
<thead>
<tr>
<th colspan="2">
<span class="ui-dialog-title-form">{$this->getLang()->getWords('add_edit_'.$bw->input[0],'Thêm/Sửa banner')}</span>
<div class="vs-buttons">
<button type="submit" ><span><img src="{$bw->vars['img_url']}/pixel-vfl3z5WfW.gif" class="icon-wrapper-vs vs-icon-accept"></span><span>{$this->getLang()->getWords('global_accept')}</span></button>
<button type="button" id="frm_close" class="btnCancel frm_close"><span><img src="{$bw->vars['img_url']}/pixel-vfl3z5WfW.gif" class="icon-wrapper-vs vs-icon-cancel"></span><span>{$this->getLang()->getWords("global_cancel")}</span></button>
</div>
</th>
</tr>
</thead>
<tbody>
<tr>
<td style="width: 111px;"><label>{$this->getLang()->getWords('title')}</label></td>
<td>
<input  name="{$this->modelName}[title]" id="{$this->modelName}_title" type="textbox" value="{$obj->getTitle()}" style='width:99%' />
</td>
</tr>

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_url",0,$bw->input[0])) {
$BWHTML .= <<<EOF

<tr>
<td style="width: 111px;"><label>{$this->getLang()->getWords('url')}</label></td>
<td>
<input  name="{$this->modelName}[url]" id="{$this->modelName}_url" type="textbox" value="{$obj->getUrl()}" style='width:99%' />
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF


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
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_category_list",0,$bw->input[0])) {
$BWHTML .= <<<EOF

<tr>
<td><label>{$this->getLang()->getWords("category")}</label></td>
<td>
<select  name="{$this->modelName}[catId]">
{$this->model->getCategories()->getChildrenBoxOption($obj->getCatId())}
</select>
<br>
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_position",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<tr>
<td><label>{$this->getLang()->getWords("position")}</label></td>
<td>
<select name="{$this->modelName}[position]" id="{$this->modelName}_position">
{$this->__foreach_loop__id_5483ca97d91770_58389972($obj,$option)}
</select>
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_index",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<tr>
<td><label>{$this->getLang()->getWords("index")}</label></td>
<td>
<input  name="{$this->modelName}[index]" id="{$this->modelName}_index" type="textbox" value="{$obj->getIndex()}" />
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_image",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<tr>
<td><label>{$this->getLang()->getWords('image')}
</label>
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
<input name="filetype[image]" value="file" checked='checked' type="radio" obj="image-file"/>
{$this->getLang()->getWords('upload')}:</label>
<label>
<input    type="file" value="" style='width:250px;'  id="image-file" name="image"/>
</label>
<br/>
<label>
<input name="filetype[image]"   value="link" type="radio" obj="image-link"/>
{$this->getLang()->getWords('download_from')}:
</label>
<label>
<input disabled='disabled' type="text" value="" style='width:250px;' id="image-link" name="links[image]"/>
</label>
</div>
<div style="float:left;width:200px">

EOF;
if($obj->getImage()) {
$BWHTML .= <<<EOF

{$obj->createImageCache($obj->getImage(),100,90)}

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


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_content",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<tr>
<td><label>{$this->getLang()->getWords('content')}</label></td>
<td>
{$this->createEditor($obj->getContent(), "{$this->modelName}[content]", "100%", "333px","full")}
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF

<tr>
<td class="vs-button" colspan="2">
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
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_5483ca97d91770_58389972($obj="",$option=array())
{
global $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['position'])){
    foreach( $option['position'] as $po )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<option value="{$po->getId()}" 
EOF;
if($obj->getPosition()==$po->getId()) {
$BWHTML .= <<<EOF
selected='selected'
EOF;
}

$BWHTML .= <<<EOF
>
 {$po->getTitle()} 
</option>

EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}


}
?>