<?php
if(!class_exists('skin_objectadmin'))
require_once ('./cache/skins/admin/red/skin_objectadmin.php');
class skin_gallerys extends skin_objectadmin {

//===========================================================================
// <vsf:showDialog:desc::trigger:>
//===========================================================================
function showDialog($option="") {global $bw;

//--starthtml--//
$BWHTML .= <<<EOF
        <div id="dialog" title="Dialog Title" 
style="width: 100%; height: 450px; overflow: auto;">
<div>
<div id='file-form' >
<form>
<div id="file-uploader">
<input type="button" value="Upload..." />
</div>
</form>
<div class="clear"></div>
<div class="album_info">

EOF;
if($this->getSettings()->getSystemKey($option['obj']->getModule()."_limit_files",0,'gallerys')) {
$BWHTML .= <<<EOF

<p>
{$this->getLang()->getWords('max_file_upload',sprintf("Số lượng tải lên tối đa <b>%s</b> hình",$this->getSettings()->getSystemKey($option['obj']->getModule()."_limit_files",0,'gallerys')))}
</p>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if($option['size']) {
$BWHTML .= <<<EOF

<p>{$this->getLang()->getWords('size')}: <b> {$option['size']['w']}x{$option['size']['h']}</b></p>
 
EOF;
}

$BWHTML .= <<<EOF

 </div>
</div>
</div>
<div id="file-panel" >
<ul style="width:100%;" id="sortable" class="sortable">
{$this->__foreach_loop__id_5483ca98047ee3_38829252($option)}
</ul>
</div>
<div class="clear"></div>
</div>
<div style=" bottom: 10px;position: absolute;right: 31px;z-index: 3;">
<input type="button" id="btncheckall" class="btnCheckAll" value="{$this->getLang()->getWords('action_checkall')}"/>
<input type="button" id="btnuncheckall" class="btnUnCheckAll"  value="{$this->getLang()->getWords('action_uncheckall')}"/>
<input type="button" id="btndelete_checked" class="btnDelete"  value="{$this->getLang()->getWords('action_delete')}"/>
</div>
<script>
$("#btncheckall").click(function(){
$(".album_item_checkbox").each(function(){
$(this).attr("checked","checked").change();
});
});
$("#btnuncheckall").click(function(){
$(".album_item_checkbox").each(function(){
$(this).removeAttr("checked").change();
});
});
$("#btndelete_checked").click(function(){
if($(".album_item_checkbox:checked").length==0){
alert("{$this->getLang()->getWords('error_none_select')}");
return false;
}
jConfirm(
                     "{$this->getLang()->getWords('yesno_delete')}?",
                     "{$bw->vars['global_websitename']} Dialog",
                     function(r){
if(r){
$(".album_item_checkbox:checked").each(function(){
var obj=$(this).parents('li');
$.ajax({
type: "POST",
url: baseUrl+"files/files_delete_file/"+obj.find("input[name='id']").val(),
data: "ajax=1&json=1",
dataType:'json',
success: function(msg){
if(!msg.status){
JAlert(msg.message);
return;
}
//$("#img_panel").append(msg);
obj.remove();
},
error: function(msg){
message.html("Bị lỗi trong khi kết nối");
}
});
});

}
 }
);
});
var template='{$option['template']}';
 var uploader = new qq.FileUploader({
                element: document.getElementById('file-uploader'),
                action: '{$bw->base_url}files/files_upload',
                debug: true,
                params: {
        fmodule: '{$bw->input[0]}',
        json: 1,
        ajax:1,
        galleryId:'{$option['obj']->getId()}'
    },
    onSubmit: function(id, fileName){},
onProgress: function(id, fileName, loaded, total){},
onComplete: function(id, fileName, responseJSON){
if(!responseJSON.success) {
alert(responseJSON.message);
return false;
}
var item=
template.replace(/{id}/gi, responseJSON.objId)
.replace(/{img}/gi, responseJSON.img)
.replace(/{path}/gi, responseJSON.path)
.replace(/{index}/gi, responseJSON.index)
.replace(/{intro}/gi, responseJSON.intro)
.replace(/{alt}/gi, responseJSON.alt)
.replace(/{name}/gi, responseJSON.name)
.replace(/{title}/gi, responseJSON.title);
$( "#sortable" ).prepend($(item));
},
onCancel: function(id, fileName){}
            });  

$( "#sortable" ).sortable({
handle:'.up_down_able',
update: function(event, ui) { 
var array=$( "#sortable" ).sortable('toArray');
//console.log(array);
var data="";
for(var i=0;i<array.length;i++){
var index=array.length-i;
if(i==0){
data='data['+$("#"+array[i]).find("input[name='id']").val()+']='+index;
}else{
 data+='&data['+$("#"+array[i]).find("input[name='id']").val()+']='+index;
}
$("#"+array[i]).find("input[name='index']").val(index);
}
$.ajax({
type: "POST",
url: baseUrl+"files/files_index_change/",
data: "galleryId={$option['obj']->getId()}&"+data,
success: function(msg){
//$("#img_panel").append(msg);
//obj.remove();
//alert("Chua co gi thay doi");
//console.log($( "#sortable" ).sortable('toArray'));

},
error: function(msg){
message.html("Bị lỗi trong khi kết nối");
}
});
}
});
$( "#sortable input.editable" ).keydown(function(e){
var code = (e.keyCode ? e.keyCode : e.which);
 if(code == 13||code == 40) { //Enter keycode
 if(e.ctrlKey){
 //alert("control");
 ///some here............
 if($(this).parents('li').next().find("input.editable").length>0){
   $(this).blur().parents('li').next().find("input.editable").get(0).focus();
   }
 }else{
   //alert("lsdflkdjf");
   if($(this).parents('tr').next().find("input.editable").length>0){
   $(this).blur().parents('tr').next().find("input.editable").focus();
   }else{
   if($(this).parents('li').next().find("input.editable").length>0){
   $(this).blur().parents('li').next().find("input.editable").get(0).focus();
   }
   }
   }
   
   
 }
if(code == 38) { 
if($(this).parents('tr').prev().find("input.editable").length>0){
   $(this).blur().parents('tr').prev().find("input.editable").focus();
   }else{
   if($(this).parents('li').prev().find("input.editable").length>0){
   $(this).blur().parents('li').prev().find("input.editable").focus();
   }
   }
}
});
$( "#sortable input.editable" ).blur(onChangeLotFocus);
function onChangeLotFocus(){
var inp=$(this);
$.ajax({
type: "POST",
url: baseUrl+"files/files_propertis_change/",
data: "json=1&ajax=1&id="+inp.attr('fileid')+"&name="+inp.attr('name')+"&value="+inp.val(),
success: function(msg){
//$("#img_panel").append(msg);
//obj.remove();
//alert("Chua co gi thay doi");
//console.log($( "#sortable" ).sortable('toArray'));

},
error: function(msg){
message.html("Bị lỗi trong khi kết nối");
}
});
}
</script>
<style>
ul#sortable li{
float:left;
} 
</style>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_5483ca98047ee3_38829252($option="")
{
global $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['file_list'])){
    foreach( $option['file_list'] as $file )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
{$this->getFileItem($file,$option)}

EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:getFileItem:desc::trigger:>
//===========================================================================
function getFileItem($file="",$option="") {if(!$file->getId()){//is template
$file->setId('{id}');
$file->setIntro('{intro}');
$file->setTitle('{title}');
$file->setName('{name}');
$file->setIndex('{index}');
$file->alt='{alt}';
if($option['size']){
$file->pathView="<img src=\"{img}\" path='{path}' width='60' height='60' onclick=\"editImage(this)\" class=\"img_edit_able \" vsheight=\"{$option['size']['h']}\" vswidth=\"{$option['size']['w']}\">";
}else{
$file->pathView="<img src=\"{img}\" path='{path}' width='60' height='60' onclick=\"editImage(this)\" class=\"img_edit_able \" >";
}
}else{
$file->alt=$file->getIntro();
//$file->pathView=$file->getPathView(2);
if($option['size']){
$file->pathView=$file->createImageEditable($file->getId(),60,60,$option['size']['w'],$option['size']['h']);
}else{
$file->pathView=$file->createImageEditable($file->getId(),60,60);
}
}

//--starthtml--//
$BWHTML .= <<<EOF
        <li  class="ui-state-default album_item_img" id="al_item_{$file->getId()}">
<div style="margin:8px 10px 0 0;float: left; width: 60px; height: 60px;  border: 1px solid;">
             <span style="display: table-cell;   vertical-align: middle;">
{$file->pathView}
 </span>
     </div>
     <div style="float: left; width: 500px;">
    <table style="font-weight:normal;font-size:11px;width:100%;">
    <tbody><tr style="padding:0px">
    <td style="width:60px">Title</td>
    <td style=""><input type="text" title="Control enter for auto set other field" class="editable" value="{$file->getTitle()}" name="title" style="width:100%;" fileid="{$file->getId()}"></td>
    </tr>
    <tr>
    <td>Alt</td>
    <td><input type="text" class="editable" value="{$file->alt}"  name="intro" fileid="{$file->getId()}" style="width:100%;"></td>
    </tr>
    <tr>
    <td>File name:</td>
    <td><input type="text" class="editable" value="{$file->getName()}" name="name" fileid="{$file->getId()}" style="width:100%;"></td>
    </tr>
    </tbody></table>
     </div>
     <div style="float: left; margin: 29px 0px 0px 12px;"><input type="checkbox" value="xóa" class="album_item_checkbox"></div>
     <div style="height: 34px; float: right; width: 20px; margin: 18px 6px;" class="up_down_able">
</div>
     <input type="hidden" value="{$file->getIndex()}" id="index" name="index">
     <input type="hidden" value="{$file->getId()}" id="item_id" name="id">
     </li>
EOF;
//--endhtml--//
return $BWHTML;
}


}
?>