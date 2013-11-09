<?php
if(!class_exists('skin_objectpublic'))
require_once ('./cache/skins/user/finance/skin_objectpublic.php');
class skin_contacts extends skin_objectpublic {

//===========================================================================
// <vsf:contactForm:desc::trigger:>
//===========================================================================
function contactForm() {global $vsLang, $bw, $vsSettings,$vsPrint;
$vsPrint->addJavaScriptFile ("jquery.numeric",1);

//--starthtml--//
$BWHTML .= <<<EOF
        <form name="formContact" id="formContact" class="contact_form" method="POST" action="{$bw->base_url}contacts/send" enctype="multipart/form-data">
<input type="hidden" name="targetpage" value="{$bw->input['targetpage']}" />
         <input type="hidden" value="{$bw->input['contactType']}" name="contactType"/>

EOF;
if( $vsSettings->getSystemKey("contact_form_name", 1, "contacts", 0, 1)) {
$BWHTML .= <<<EOF

<label>{$vsLang->getWords('contact_fullname','Họ tên')}:</label>
            <input type="text" id="contactName" name="contactName" value="{$bw->input['contactName']}" title="{$vsLang->getWords('contact_fullname','Họ tên')}" />
            <div class='clear_left'></div>
            
EOF;
}

$BWHTML .= <<<EOF

            
            
EOF;
if( $vsSettings->getSystemKey("contact_form_address", 1, "contacts", 0, 1)) {
$BWHTML .= <<<EOF

            <label>{$vsLang->getWords('contact_address','Địa chỉ')}:</label>
            <input id="contactAddress" name="contactAddress" value="{$bw->input['contactAddress']}" title="{$vsLang->getWords('contact_address','Địa chỉ')}"  type="text" />
<div class='clear_left'></div>
            
EOF;
}

$BWHTML .= <<<EOF

            
EOF;
if( $vsSettings->getSystemKey("contact_form_phone", 1, "contacts", 0, 1)) {
$BWHTML .= <<<EOF

            <label>{$vsLang->getWords('contact_phone','Điện thoại')}:</label>
            <input type="text" class="numeric"  value="{$bw->input['contactPhone']}" id="contactPhone" name="contactPhone" maxlength="11" title="{$vsLang->getWords('contact_phone','Điện thoại')}" />
            <div class='clear_left'></div>

EOF;
}

$BWHTML .= <<<EOF


EOF;
if( $vsSettings->getSystemKey("contact_form_email", 1, "contacts", 0, 1)) {
$BWHTML .= <<<EOF

            <label>{$vsLang->getWords('contact_email','Email')}:</label>
<input type="text" id="contactEmail" value="{$bw->input['contactEmail']}" name="contactEmail" title="{$vsLang->getWords('contact_email','Email')}" />
<div class='clear_left'></div>
            
EOF;
}

$BWHTML .= <<<EOF

            
            
EOF;
if( $vsSettings->getSystemKey("contact_form_title", 1, "contacts", 0, 1)) {
$BWHTML .= <<<EOF

            <label>{$vsLang->getWords('contact_title','Tiêu đề')}:</label>
            <input type="text" class='col_left' id="contactTitle" name="contactTitle" value="{$bw->input['contactTitle']}" title="{$vsLang->getWords('contact_title','Tiêu đề')}" />
            <div class='clear_left'></div>
            
EOF;
}

$BWHTML .= <<<EOF

            
            
EOF;
if($vsSettings->getSystemKey("contact_form_file", 0, "contacts", 0, 1)) {
$BWHTML .= <<<EOF

            <label>File:</label>
            <input type="file" class="file_input" size="72" id="contactFile" name="contactFile"  />
<div class="clear_left"></div>
            
EOF;
}

$BWHTML .= <<<EOF

               
            
EOF;
if($vsSettings->getSystemKey("contact_form_content", 1, "contacts", 0, 1)) {
$BWHTML .= <<<EOF

         <label>{$vsLang->getWords("contact_message","Nội dung")}</label>
            <textarea id="contactMessage" name="contactContent">{$bw->input['contactContent']}</textarea>
            
EOF;
}

$BWHTML .= <<<EOF

     
            
EOF;
if($vsSettings->getSystemKey("contact_form_capchar", 0, "contacts", 0, 1)) {
$BWHTML .= <<<EOF

            <label>{$vsLang->getWords("contact_captcha","Mã bảo vệ")}:</label>
<input type="text" name="contactSecurity" id="contactSecurity" style="width:100px"/> 
<div style="margin-left:10px;float:left;">
            <a href="javascript:;" style="float:left; padding-right:10px;">
                <img id="vscapcha" src="{$bw->vars['board_url']}/vscaptcha">
               </a>      
   <a href="javascript:;" class="mamoi" id="reload_img">
{$vsLang->getWords('contact_security','Tạo mã mới')}
</a>
</div>
<div class="clear"></div>

EOF;
}

$BWHTML .= <<<EOF

<label>&nbsp;</label>
<input type="submit" value="{$vsLang->getWords('contact_sends','Gửi')}" class="button" />
<input type="reset" value="{$vsLang->getWords('contact_reset','Làm lại')}" class="button" />
<div class="clear_left"></div>
</form>
<script type='text/javascript'>
$("#reload_img").click(function(){
                          $("#vscapcha").attr("src",$("#vscapcha").attr("src")+"?a");
                          $('#random').val('');
                          return false;
       });
       
function checkMail(mail){
var filter = /^([a-zA-Z0-9_\\.\\-])+\\@(([a-zA-Z0-9\\-])+\\.)+([a-zA-Z0-9]{2,4})+$/;
if (!filter.test(mail)) return false;
return true;
}
$("input.numeric").numeric();
$('#formContact').submit(function(){

EOF;
if( $vsSettings->getSystemKey("contact_form_name", 1, "contacts", 1, 1)) {
$BWHTML .= <<<EOF

if(!$('#contactName').val()) {
jAlert('{$vsLang->getWords('err_contact_name_blank','Vui lòng nhập họ tên!')}','{$bw->vars['global_websitename']} Dialog');
$('#contactName').addClass('vs-error');
$('#contactName').focus();
return false;
}

EOF;
}

$BWHTML .= <<<EOF


EOF;
if( $vsSettings->getSystemKey("contact_form_address", 1, "contacts", 1, 1)) {
$BWHTML .= <<<EOF

if(!$('#contactAddress').val()) {
jAlert('{$vsLang->getWords('err_contact_address_blank','Vui lòng nhập địa chỉ!')}','{$bw->vars['global_websitename']} Dialog');
$('#contactAddress').addClass('vs-error');
$('#contactAddress').focus();
return false;
}

EOF;
}

$BWHTML .= <<<EOF


EOF;
if( $vsSettings->getSystemKey("contact_form_phone", 1, "contacts", 1, 1)) {
$BWHTML .= <<<EOF

if(!$('#contactPhone').val()) {
jAlert('{$vsLang->getWords('err_contact_phone_blank','Vui lòng nhập số điện thoại!')}','{$bw->vars['global_websitename']} Dialog');
$('#contactPhone').addClass('vs-error');
$('#contactPhone').focus();
return false;
}

EOF;
}

$BWHTML .= <<<EOF


if(!$('#contactEmail').val()|| !checkMail($('#contactEmail').val())) {
jAlert('{$vsLang->getWords('err_contact_email_blank','Vui lòng nhập đúng loại email!')}','{$bw->vars['global_websitename']} Dialog');
$('#contactEmail').addClass('vs-error');
$('#contactEmail').focus();
return false;
}


EOF;
if( $vsSettings->getSystemKey("contact_form_title", 1, "contacts", 1, 1)) {
$BWHTML .= <<<EOF

if(!$('#contactTitle').val()) {
jAlert('{$vsLang->getWords('err_contact_title_blank','Vui lòng nhập câu hỏi!')}','{$bw->vars['global_websitename']} Dialog');
$('#contactTitle').addClass('vs-error');
$('#contactTitle').focus();
return false;
}

EOF;
}

$BWHTML .= <<<EOF

if($('#contactMessage').val().length < 15) {
jAlert('{$vsLang->getWords('err_contact_message_blank','Thông tin quá ngắn!')}','{$bw->vars['global_websitename']} Dialog');
$('#contactMessage').addClass('vs-error');
$('#contactMessage').focus();
return false;
}
                                        

EOF;
if( $vsSettings->getSystemKey("contact_form_capchar", 0, "contacts", 1, 1)) {
$BWHTML .= <<<EOF

if(!$('#contactSecurity').val()) {
jAlert('{$vsLang->getWords('err_contact_phone_security','Vui lòng nhập mã bảo vệ!')}','{$bw->vars['global_websitename']} Dialog');
$('#contactSecurity').addClass('vs-error');
$('#contactSecurity').focus();
return false;
}

EOF;
}

$BWHTML .= <<<EOF

$('#formContact').submit();
return false;
});
</script>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:thankyou:desc::trigger:>
//===========================================================================
function thankyou($url="",$option="") {global $vsLang,$bw,$vsTemplate,$vsPrint;

//--starthtml--//
$BWHTML .= <<<EOF
        <script type='text/javascript'>
setTimeout('delayer()', 3000);
function delayer(){
    window.location = "{$url}";
}
</script>
<div id="center">
        <h3 class="center_title detail_title">
        <a href="{$bw->base_url}{$bw->input[0]}" title='{$vsLang->getWords($bw->input[0]."_title", $bw->input[0])}'>
{$vsLang->getWords($bw->input[0]."_title", $bw->input[0])}
</a>
</h3>
<div id="branch-list">
{$this->__foreach_loop__id_524aa3d4833dc($url,$option)}
                <div class='clear'></div>
           </div>
           <style>
           .thankyou p{
           font-weight: bold; 
           margin-bottom: 10px;
           font-size: 14px;
           }
           .thankyou a{
           color:#F01863;
           }
           </style>
           <div class='detail'>
           <div class='thankyou'>
        <p>{$vsLang->getWords('contacts_redirectText', 'Thank you! Your message have been sent.')}</p>
        
        <p>{$vsLang->getWords('redirect_title','Chuyển trang...')}</p>
        <a href='{$url}'>
        ({$vsLang->getWords('redirect_immediate','Click vào đây nếu không muốn chờ lâu')})
        </a>
        </div>
           </div>
</div>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_524aa3d4833dc($url="",$option="")
{
global $vsLang,$bw,$vsTemplate,$vsPrint;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach(  $option['plist'] as $obj  )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
           <a class="{$obj->active}" href="{$bw->base_url}contacts/{$obj->getCleanTitle()}-{$obj->getId()}" title='{$obj->getTitle()}'>
{$obj->getTitle()}
</a>
                
EOF;
$vsf_count++;
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:showDefault:desc::trigger:>
//===========================================================================
function showDefault($option=array()) {global $bw, $vsLang, $vsSettings,$vsLang;
             
$bw->input['contactType'] = 0;

//--starthtml--//
$BWHTML .= <<<EOF
        <div id="center">
        <h3 class="center_title detail_title">
        <a href="{$bw->base_url}{$bw->input[0]}" title='{$vsLang->getWords($bw->input[0]."_title", $bw->input[0])}'>
{$vsLang->getWords($bw->input[0]."_title", $bw->input[0])}
</a>
</h3>
<div id="branch-list">
{$this->__foreach_loop__id_524aa3d483bb0($option)}
                <div class='clear'></div>
           </div>
           
        <div class="map">
           <div id='map_canvas'></div> 
</div>
<p class="note">{$vsLang->getWords('contact_note','Xin vui lòng liên hệ với chúng tôi theo các số điện thoại trên hoặc bằng cách điền thông tin vào mẫu sau:')}</p>
{$this->contactForm()}
        <div id='hidden' style='display: none !important;'>{$option['contact']->getIntro()}</div>
</div>

    
EOF;
if( $option['contact'] ) {
$BWHTML .= <<<EOF

    
EOF;
if($option['contact']->getLongitude() && $option['contact']->getLatitude()) {
$BWHTML .= <<<EOF

    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true&language=vi"></script>
    <script  type="text/javascript">
    function init() {
    var myHtml = "<h4>{$option['contact']->getTitle()}</h4><p>{$option['contact']->getAddress()}</p>";
                                                
      var map = new google.maps.Map(
      document.getElementById("map_canvas"),
      {scaleControl: true}
      );
      map.setCenter(new google.maps.LatLng({$option['contact']->getLatitude()},{$option['contact']->getLongitude()}));
      map.setZoom(15);
      map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
      var marker = new google.maps.Marker({
      map: map,
      position:map.getCenter()
});
var infowindow = new google.maps.InfoWindow({
'pixelOffset': new google.maps.Size(0,15)
});
      infowindow.setContent(myHtml);
      infowindow.open(map, marker);
    }
    $(document).ready(function(){
init();
});
</script>

EOF;
}

$BWHTML .= <<<EOF


EOF;
}

$BWHTML .= <<<EOF

EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_524aa3d483bb0($option=array())
{
global $bw, $vsLang, $vsSettings,$vsLang;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach(  $option['plist'] as $obj  )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
           <a class="{$obj->active}" href="{$bw->base_url}contacts/{$obj->getCleanTitle()}-{$obj->getId()}" title='{$obj->getTitle()}'>
{$obj->getTitle()}
</a>
                
EOF;
$vsf_count++;
    }
    return $BWHTML;
}


}?>