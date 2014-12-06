<?php
if(!class_exists('skin_objectadmin'))
require_once ('./cache/skins/admin/red/skin_objectadmin.php');
class skin_pages extends skin_objectadmin {

//===========================================================================
// <vsf:addEditObjForm:desc::trigger:>
//===========================================================================
function addEditObjForm($obj="",$option=array()) {global $bw;
$seo = "style='display:none'";
if ($obj->getMTitle() or $obj->getMKeyword() or $obj->getMUrl() or $obj->getMIntro()){
$seo = "";
}
if($obj->getOption()){
$this->option=explode(",",$obj->getOption());
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
<input  name="{$this->modelName}[title]" id="{$this->modelName}_title" type="text" value="{$obj->getTitle()}" style='width:99%' />
</td>
</tr>

EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_website",0,$bw->input[0])) {
$BWHTML .= <<<EOF

<tr>
<td style="width: 111px;"><label>{$this->getLang()->getWords('website','website')}</label></td>
<td>
<input  name="{$this->modelName}[website]" id="{$this->modelName}_website" type="text" value="{$obj->getWebsite()}" style='width:99%' />
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF



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


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_status_highlight",0,$bw->input[0])) {
$BWHTML .= <<<EOF

<label>
<input  
EOF;
if($obj->getStatus()==3) {
$BWHTML .= <<<EOF
checked='checked'
EOF;
}

$BWHTML .= <<<EOF
  name="{$this->modelName}[status]" id="{$this->modelName}_status_3" type="radio" value="3"  />
Nổi bật
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
<select name="{$this->modelName}[catId]" id="vs_cate">
{$this->model->getCategories()->getChildrenBoxOption($obj->getCatId())}
</select>
<br>
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF




EOF;
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_price','price',$bw->input[0].'_'.$this->modelName.'_price',0)) {
$BWHTML .= <<<EOF

<tr>
<td><label>{$this->getLang()->getWords("price","Giá")}</label></td>
<td>
<input  name="{$this->modelName}[price]" type="text" value="{$obj->getPrice()}" style="width:50%" />
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_phone','phone',$bw->input[0].'_'.$this->modelName.'_phone',0)) {
$BWHTML .= <<<EOF

<tr>
<td><label>{$this->getLang()->getWords("phone","Điện thoại")}</label></td>
<td>
<input  name="{$this->modelName}[phone]" type="text" value="{$obj->getPhone()}" style="width:50%" />
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_number",0,$bw->input[0])) {
$BWHTML .= <<<EOF

<tr>
<td><label>Số lượng:</label></td>
<td>
<input  name="{$this->modelName}[number]" type="text" value="{$obj->getNumber()}" style="width:50%" />
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_deadline",0,$bw->input[0])) {
$BWHTML .= <<<EOF

<tr>
<td><label>{$this->getLang()->getWords("deadline","Thời hạn nộp ")}</label></td>
<td>
<input  name="{$this->modelName}[deadline]" type="text" value="{$obj->getDeadline()}" style="width:50%" />
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
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_code','code',$bw->input[0].'_'.$this->modelName.'_form',0)) {
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


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_tag",0,$bw->input[0])) {
$BWHTML .= <<<EOF

<td><label>{$this->getLang()->getWords('tags')}</label></td>
<td>
<div id="tag_panel_diplay">
<script src='{$bw->base_url}tags/tags_get_tag_for_obj/{$bw->input[0]}/{$obj->getId()}'>
</script>
</div>
</td>
</tr>  

EOF;
}

$BWHTML .= <<<EOF

<tr>
<td></td>
<td>
EOF;
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_seo_option','SEO Option',$bw->input[0].'_'.$this->modelName.'_form')) {
$BWHTML .= <<<EOF

<button onclick="$('#seo').toggle();return false;">Seo option</button>

EOF;
}

$BWHTML .= <<<EOF

</td>
</tr>

EOF;
if($this->getSettings()->getKeyGroup($bw->input[0].'_'.$this->modelName.'_seo_option','SEO Option',$bw->input[0].'_'.$this->modelName.'_form')) {
$BWHTML .= <<<EOF

<tr id="seo" $seo>
<td><label>{$this->getLang()->getWords('seo')}</label></td>
<td>
<label>Slug:<input type="text" style="width:100%" value="{$obj->getSlug()}" name="{$this->modelName}[slug]" /></label>
<label>Meta Title:<input type="text" style="width:100%" value="{$obj->getMTitle()}" name="{$this->modelName}[mTitle]" /></label>
<label>Meta Description:<textarea style="width:100%"   name="{$this->modelName}[mIntro]" >{$obj->getMIntro()}</textarea></label>
<label>Meta Keyword:<textarea style="width:100%"   name="{$this->modelName}[mKeyword]" >{$obj->getMKeyword()}</textarea></label>
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


}
?>