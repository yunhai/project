<?php
if(!class_exists('skin_objectadmin'))
require_once ('./cache/skins/admin/red/skin_objectadmin.php');
class skin_partners extends skin_objectadmin {

//===========================================================================
// <vsf:addEditObjForm:desc::trigger:>
//===========================================================================
function addEditObjForm($objItem="",$option=array()) {global $vsLang, $bw,$vsSettings,$langObject;
                if($objItem->getPosition()) $pos = $objItem->getPosition();
                else $pos = 1;

//--starthtml--//
$BWHTML .= <<<EOF
        <div id="error-message" name="error-message"></div>
<form id='add-edit-obj-form' name="add-edit-obj-form" method="POST"  enctype='multipart/form-data'>
<input type="hidden" id="obj-cat-id" name="partnerCatId" value="{$objItem->getCatId()}" />
<input type="hidden" id="pageCate" name="pageCate" value="{$bw->input['pageCate']}" />
<input type="hidden" id="pageIndex" name="pageIndex" value="{$bw->input['pageIndex']}" />
<input type="hidden" name="partnerId" value="{$objItem->getId()}" />
<div class='ui-dialog ui-widget ui-widget-content ui-corner-all'>
<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
<span class="ui-dialog-title">{$option['formTitle']}</span>
                                         <p style="float:right; cursor:pointer;">
                                                <span class='ui-dialog-title' id='closeObj'>
                                                 {$langObject['itemObjBack']}
                                                </span>
                                            </p>
</div>
<table class="ui-dialog-content ui-widget-content" cellspacing="1" border="0" style="width:100%">
                                              
                                        <tr class="smalltitle">
                                                <td class="label_obj">{$langObject['itemObjWebsite_Name']}:</td>
                                                <td><input size="43" type="text" name="partnerTitle" value="{$objItem->getTitle()}" id="obj-title"/></td>
                                         
EOF;
if($vsSettings->getSystemKey($bw->input[0].'_image', 1, $bw->input[0])) {
$BWHTML .= <<<EOF
       
                                                <td align='left' rowspan="3">
                                                
EOF;
if($objItem->getImage()) {
$BWHTML .= <<<EOF

                                                    {$objItem->createImageCache($objItem->getImage(), '', 33)}
                                                    <input name="oldImage" value="{$objItem->getImage()}" type="hidden" />
                                                    <p>{$langObject['itemObjDeleteImage']}<input type="checkbox" class="checkbox" name="partnerDeleteImage" /></p>
                                                
EOF;
}

else {
$BWHTML .= <<<EOF

                                                    {$objItem->createImageCache($objItem->getImage(), 250, 150, 0, 1, 1, 1)}
                                                
EOF;
}
$BWHTML .= <<<EOF

                                                </td>
                                           
EOF;
}

$BWHTML .= <<<EOF

                                            
EOF;
if($vsSettings->getSystemKey($bw->input[0].'_address',0, $bw->input[0])) {
$BWHTML .= <<<EOF
   
                                                            <td align='left' rowspan="3">
                                           <iframe  id="videos_obj_code_img" style="" 
width="200" height="200" src="http://www.youtube.com/embed/{$objItem->getAddress()}" frameborder="0" allowfullscreen></iframe>
                                                                </td>
                                                            
EOF;
}

$BWHTML .= <<<EOF

                                                                
                                        </tr>
                                                    
                                        
EOF;
if($vsSettings->getSystemKey($bw->input[0].'_address',0, $bw->input[0])) {
$BWHTML .= <<<EOF

                                            <tr class="smalltitle">
                                                    <td class="label_obj">{$langObject['itemObjAddress']}:</td>
                                                    <td><input size="43" type="text" name="partnerAddress" value="{$objItem->getAddress()}" id="videos_obj_code"/></td>
                                            </tr>
                                        
EOF;
}

$BWHTML .= <<<EOF

                                       
EOF;
if($vsSettings->getSystemKey($bw->input[0].'_websites',1, $bw->input[0])) {
$BWHTML .= <<<EOF
   
                                            <tr class="smalltitle">
                                                    <td class="label_obj">{$langObject['itemObjWebsite']}:</td>
                                                    <td><input size="43" type="text" name="partnerWebsite" value="{$objItem->getWebsite()}" id="obj-website"/></td>
                                            </tr>
                                       
EOF;
}

$BWHTML .= <<<EOF
 
                                       <tr class="smalltitle">
                                           <td class="label_obj">{$langObject['itemObjIndex']}:</td>
                                            <td>
                                            <input size="43" type="text" name="partnerIndex" value="{$objItem->getIndex()}" id="obj-Index"/>
                                            </td>
                                        </tr>

                                        <tr class="smalltitle">
                                                <td class="label_obj">{$langObject['itemObjStatus']}:</td>
                                            <td>

                                               <input type="radio" value="1" name="partnerStatus" id="partnerStatus" class="radio" checked>
                                                                        <label style="padding-right: 10px" for="left">{$langObject['itemObjDisplay']}</label>  

                                              <input type="radio" value="0" name="partnerStatus" id="partnerStatus" class="radio">
                                                                        <label style="padding-right: 10px" for="left">{$langObject['itemObjHide']}</label>

                                               
                                            </td>
                                            </tr>
                            
EOF;
if($vsSettings->getSystemKey($bw->input[0].'_exptime',0,$bw->input[0])) {
$BWHTML .= <<<EOF

                            <tr class="smalltitle">
                                    <td>
                                            {$vsLang->getWords('obj_begtime', 'Begin Time')}
                                    </td>
                                    <td colspan="2">
                                        <input size="43" name="partnerBeginTime" value="{$objItem->getExpTime("SHORT")}" id="partnerBeginTime"/>
                                    </td>
                            </tr>
                            <tr class="smalltitle">
                                    <td>
                                            {$vsLang->getWords('obj_exptime', 'Expire Time')}
                                    </td>
                                   <td colspan="2">
                                        <input size="43" name="partnerExpTime" value="{$objItem->getBeginTime("SHORT")}" id="partnerExpTime"/>
                                    </td>
                            </tr>
                            
EOF;
}

$BWHTML .= <<<EOF


                            
EOF;
if($vsSettings->getSystemKey($bw->input[0].'_price', 0, $bw->input[0])) {
$BWHTML .= <<<EOF

                            <tr class="smalltitle">
                                <td>
                                    {$langObject['itemObjPrice']}
                                </td>
                                <td colspan="2">
                                    <input  size="43" type="text" name="partnerPrice" value="{$objItem->getPrice()}" id="obj-price"/>
                                </td>
                            </tr>
                            
EOF;
}

$BWHTML .= <<<EOF

                            
EOF;
if($vsSettings->getSystemKey($bw->input[0].'_image', 1, $bw->input[0])) {
$BWHTML .= <<<EOF

                            <tr class="smalltitle">
                                    <td class="label_obj">{$langObject['itemObjFile']}:</td>
                                    <td>
                                            <div style="padding:2px 5px;">
                                            <input size="29" type="file" name="partnerIntroImage" id="partnerIntroImage"/>
                                            </div>
                                    </td>
                                    <td colspan="2" align="center">
                                        ({$vsSettings->getSystemKey($bw->input[0].'_image_timthumb_size', 'Size: 500 x 305 px', $bw->input[0])})
                                    </td>
                            </tr>
                            
EOF;
}

$BWHTML .= <<<EOF


                            
EOF;
if($vsSettings->getSystemKey($bw->input[0].'_intro', 0, $bw->input[0])) {
$BWHTML .= <<<EOF

                            <tr class="smalltitle">
                                    <td class="label_obj">{$langObject['itemObjIntro']}:</td>
                                    <td colspan="3">{$objItem->getIntro()}</td>
                            </tr>
                            
EOF;
}

$BWHTML .= <<<EOF


                            
EOF;
if($vsSettings->getSystemKey($bw->input[0].'_content', 0, $bw->input[0])) {
$BWHTML .= <<<EOF

                            <tr class="smalltitle">
                                            <td colspan="4" class="label_obj">{$langObject['itemObjContent']}:</td>
                            </tr>
                            <tr class="smalltitle">
                                    <td colspan="4" align="center">{$objItem->getContent()}</td>
                            </tr>
                            
EOF;
}

$BWHTML .= <<<EOF


                            <tr class="smalltitle">
                                    <td class="ui-dialog-buttonpanel" colspan="4" align="center">
                                            <input type="submit" name="submit" value="{$option['formSubmit']}" />
                                    </td>
                            </tr>
                            </table>
                    </div>
            </form>
<script language="javascript">
              $('#closeObj').click(function(){                  
vsf.get('{$bw->input[0]}/display-obj-list/{$bw->input['pageCate']}/&pageIndex={$bw->input['pageIndex']}','obj-panel');
});
function updateobjListHtml(categoryId){
vsf.get('{$bw->input[0]}/display-obj-list/'+categoryId+'/','obj-panel');
}
function alertError(message){
jAlert(
message,
'{$bw->vars['global_websitename']} Dialog'
);
}

//$(window).ready(function() {
//                                        $("input.numeric").numeric();
//vsf.jRadio('{$objItem->getStatus()}','partnerStatus');
//vsf.jRadio('{$pos}','partnerPosition');
//                                        vsf.jSelect('{$objItem->getCatId()}','obj-category');
//
//                                        $('#partnerExpTime').datepicker({dateFormat: 'dd/mm/yy'});
//                                        $('#partnerBeginTime').datepicker({dateFormat: 'dd/mm/yy'});
//
//                                        if(!$("#obj-cat-id").val()) $("#obj-cat-id").val($("#idCategory").val());
//
//                                       
//});

$(document).ready(function() {
               $('#obj-category option').each(function(){
$(this).removeAttr('selected');
});
$("input.numeric").numeric();
vsf.jRadio('{$pos}','partnerPosition');
vsf.jRadio('{$objItem->getStatus()}','partnerStatus');
vsf.jSelect('{$objItem->getCatId()}','obj-category');
//$('#partnerExpTime').datepicker({dateFormat: 'dd/mm/yy'});
//               $('#partnerBeginTime').datepicker({dateFormat: 'dd/mm/yy'});
});

                                $('#obj-category').change(function() {
var parentId = '';
$("#obj-category option:selected").each(function () {
parentId = $(this).val();
});
$('#obj-cat-id').val(parentId);
});
$('#add-edit-obj-form').submit(function(){
var flag  = true;
var error = "";
var categoryId = 0;
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
$('#obj-title').addClass('ui-state-error ui-corner-all-inner');
}

                   if(!flag){
error = "<ul class='ul-popu'>" + error + "</ul>";
vsf.alert(error);
return false;
}
$('#obj-cat-id').val($('#obj-category').val());
$('#obj-category').removeClass('ui-state-error ui-corner-all-inner');
vsf.uploadFile("add-edit-obj-form", "{$bw->input[0]}", "add-edit-obj-process", "obj-panel", "{$bw->input[0]}");
return false;
});
                                
</script>
                        <script>
//$(document).mousedown(refreshImage);
$("#videos_obj_code").keyup(refreshImage);
function refreshImage(){
$("#videos_obj_code_img").attr("src","http://www.youtube.com/embed/"+$("#videos_obj_code").val()).show();
}
</script>
EOF;
//--endhtml--//
return $BWHTML;
}


}?>