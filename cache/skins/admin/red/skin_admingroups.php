<?php
if(!class_exists('skin_objectadmin'))
require_once ('./cache/skins/admin/red/skin_objectadmin.php');
class skin_admingroups extends skin_objectadmin {

//===========================================================================
// <vsf:addEditObjForm:desc::trigger:>
//===========================================================================
function addEditObjForm($obj="",$option=array()) {global $bw;

//--starthtml--//
$BWHTML .= <<<EOF
        <div class="vs_panel" id="vs_panel_{$this->modelName}">
<div class="ui-dialog">
<div >
<span class="ui-dialog-title">{$this->getLang()->getWords('add_edit_'.$bw->input[0].'_'.$this->modelName,'Add edit '.$this->modelName)}</span>
<a href="#" class="ui-dialog-titlebar-close ui-corner-all frm_close" role="button" id="frm_close">{$this->getLang()->getWords('close')}</a>
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
{$this->getLang()->getWords('hide')}
<!--<img title="{$this->getLang()->getWords('hide')}" src="{$bw->vars['img_url']}/status_0.png"/>-->
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
{$this->getLang()->getWords('visible')}
<!--<img title="{$this->getLang()->getWords('visible')}" src="{$bw->vars['img_url']}/status_1.png"/>-->
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
{$this->getLang()->getWords('home')}
<!--<img title="{$this->getLang()->getWords('home')}" src="{$bw->vars['img_url']}/status_2.png"/>-->
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
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_default",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<tr>
<td style="width: 121px;"><label>{$this->getLang()->getWords('default')}</label></td>
<td>
<label>
<input 
EOF;
if($obj->getDefault()=='1') {
$BWHTML .= <<<EOF
checked='checked'
EOF;
}

$BWHTML .= <<<EOF
  name="{$this->modelName}[default]" id="{$this->modelName}_default" type="checkbox" value="1"  />
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
{$this->createEditor($obj->getContent(), "{$this->modelName}[content]", "100%", "333px")}
</td>
</tr>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_permission",1,$bw->input[0])) {
$BWHTML .= <<<EOF

<tr>
<td><label>{$this->getLang()->getWords('permission')}</label></td>
<td>
{$this->__foreach_loop__id_5483ca97c68fe0_02844926($obj,$option)}

EOF;
}

$BWHTML .= <<<EOF

</td>
</tr>
</if>
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
if(flag){
jAlert(message);
return false;
}
vsf.uploadFile("frm_add_edit_obj", "{$bw->input[0]}", "{$this->modelName}_add_edit_process", "vs_panel_{$this->modelName}","{$bw->input[0]}",1,
function(){
var hashbase=frm.parents('.ui-tabs-panel').attr('id');
window.location.hash=hashbase+"{$bw->input['back']}";
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
function __foreach_loop__id_5483ca97c68208_44411030($obj="",$option=array(),$module='',$list='')
{
;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($list)){
    foreach( $list as $key => $permission )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<label><input 
EOF;
if($option['myspermission'][$key]) {
$BWHTML .= <<<EOF
checked='checked'
EOF;
}

$BWHTML .= <<<EOF
 name="permission[$key]" type="checkbox" value="$key"/> $permission </label>

EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}


//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_5483ca97c68fe0_02844926($obj="",$option=array())
{
global $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['permission_list'])){
    foreach( $option['permission_list'] as $module => $list )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        

EOF;
if(count($list)) {
$BWHTML .= <<<EOF

<h3>{$this->getLang()->getWords($module)}</h3>
{$this->__foreach_loop__id_5483ca97c68208_44411030($obj,$option,$module,$list)}

EOF;
}

$BWHTML .= <<<EOF


EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}


}
?>