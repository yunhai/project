<?php
class skin_global{

//===========================================================================
// <vsf:vs_global:desc::trigger:>
//===========================================================================
function vs_global() {global $bw,$vsLang, $vsMenu, $vsSettings, $vsPrint;
$year = date("Y");
$lang = $_SESSION["user"]["language"]["currentLang"]["langFolder"];
$active[$_SESSION["user"]["language"]["currentLang"]["langFolder"]] = 'active';

//--starthtml--//
$BWHTML .= <<<EOF
        <div id="header">
<a href="{$bw->base_url}" class="logo">
<img src="{$bw->vars['img_url']}/logo.png" />
</a>
{$this->about}
{$this->support}
    <div class='reservation'>
    <p class='hotline_{$lang}'>{$vsLang->getWords('global_hotline', 'Điện thoại đặt chỗ')}:</p>
    <span class='hotlinenumber_{$lang}'>{$vsSettings->getSystemKey("config_reservation", '0903 935 300', 'config')}</span>
    </div>
    <div class="lang_link">
    <a href="{$bw->vars['board_url']}" title='{$vsLang->getWords('global_vietnamese','Tiếng Việt')}' class='{$active['vi']}'>
{$vsLang->getWords('global_vietnamese','Tiếng Việt')}
</a>
        <a href="{$bw->vars['board_url']}/cn" title='{$vsLang->getWords('global_chinese','中文')}' class='{$active['cn']}'>
{$vsLang->getWords('global_chinese','中文')}
</a>
        <a href="{$bw->vars['board_url']}/en" title='{$vsLang->getWords('global_english','English')}' class='{$active['en']}'>
{$vsLang->getWords('global_english','English')}
</a>
    </div>
{$this->topmenu}
    
    {$this->slideshow}
</div>
<!-- STOP HEADER -->
{$this->service}
<!-- STOP SLIDE DICH VU -->
<div id="content">
{$this->SITE_MAIN_CONTENT}
    <!-- STOP CENTER -->
    
    <div id="sitebar">
    {$this->recruitment}
    {$this->promote}
        
        {$this->partner}
    </div>
    <!-- STOP SITEBAR -->
    
    <div class="clear"></div>
</div>
<!-- STOP CONTENT -->
<div id="footer">
<p class="copyright">
© {$year} {$vsLang->getWords('global_copyright','Bản quyền thuộc về Monica Spa')} <br/>
</p>
<p class='footer-reservation'>
<span class='reservation-text'>{$vsLang->getWords('global_hotline', 'Điện thoại đặt chỗ')}:</span>
    <span class='reservation-number'>{$vsSettings->getSystemKey("config_reservation", '0903 935 300', 'config')}</span>
</p>
    <div class="truycap">
    <p>{$vsLang->getWords('global_access_today','Đang truy cập')}: <span>{$this->state['today']}</span></p>
    <p>{$vsLang->getWords('global_access_total','Tổng lượt truy cập')}: <span>{$this->state['visits']}</span></p>
    </div>
</div>

<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-32732641-1']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:addCSS:desc::trigger:>
//===========================================================================
function addCSS($cssUrl="") {
//--starthtml--//
$BWHTML .= <<<EOF
        <link type="text/css" rel="stylesheet" href="{$cssUrl}.css" />
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:addFlash:desc::trigger:>
//===========================================================================
function addFlash($url="",$width=0,$height=0,$mode="opaque") {
//--starthtml--//
$BWHTML .= <<<EOF
        <object height="{$height}" width="{$width}" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0">
        <param name="movie" value="{$url}">
        <param name="quality" value="high">
        <param name="allowscriptaccess" value="samedomain">
        <param value="{$mode}" name="wmode">
        <embed height="{$height}" width="{$width}" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" src="{$url}" quality="high" allowscriptaccess="samedomain" wmode="{$mode}">
          <noembed>
          </noembed>
        
      </object>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:importantAjaxCallBack:desc::trigger:>
//===========================================================================
function importantAjaxCallBack() {global $bw,$vsLang;

//--starthtml--//
$BWHTML .= <<<EOF
        
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:addJavaScriptFile:desc::trigger:>
//===========================================================================
function addJavaScriptFile($file="",$type='file') {global $bw;

//--starthtml--//
$BWHTML .= <<<EOF
        
EOF;
if($type=='cur_file') {
$BWHTML .= <<<EOF

<script type="text/javascript" src='{$bw->vars['cur_scripts']}/{$file}.js'></script>

EOF;
}

else {
$BWHTML .= <<<EOF


EOF;
if($type=='external') {
$BWHTML .= <<<EOF

<script type="text/javascript" src='{$file}'></script>

EOF;
}

else {
$BWHTML .= <<<EOF


EOF;
if($type=='file') {
$BWHTML .= <<<EOF

<script type="text/javascript" src='{$bw->vars['board_url']}/javascripts/{$file}.js'></script>

EOF;
}

$BWHTML .= <<<EOF


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
// <vsf:addJavaScript:desc::trigger:>
//===========================================================================
function addJavaScript($script="") {$BWHTML = "";

//--starthtml--//
$BWHTML .= <<<EOF
        <script language="javascript" type="text/javascript">
{$script}
</script>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:addDropDownScript:desc::trigger:>
//===========================================================================
function addDropDownScript($id="") {$BWHTML = "";
//--starthtml--//

//--starthtml--//
$BWHTML .= <<<EOF
        ddsmoothmenu.init({
mainmenuid: "{$id}", //Menu DIV id
orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
classname: 'ddsmoothmenu-v', //class added to menus outer DIV
//customtheme: ["#804000", "#482400"],
contentsource: "markup", //"markup" or ["container_id", "path_to_menu_file"]
})
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:PermissionDenied:desc::trigger:>
//===========================================================================
function PermissionDenied($error="") {
//--starthtml--//
$BWHTML .= <<<EOF
        <div class="red">
{$error}</div>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:displayFatalError:desc::trigger:>
//===========================================================================
function displayFatalError($message="",$line="",$file="",$trace="") {
//--starthtml--//
$BWHTML .= <<<EOF
        <div class="vs-common">
<div class="red" align="left" style="padding: 20px">
Error: {$message}<br />
Line: {$line}<br />
File: {$file}<br />
Trace: <pre>{$trace}</pre><br />
</div>
</div>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:global_main_title:desc::trigger:>
//===========================================================================
function global_main_title() {global $bw, $vsPrint;
$BWHTML = "";
//--starthtml--//

//--starthtml--//
$BWHTML .= <<<EOF
        <span class="{$bw->input['module']}">{$vsPrint->mainTitle}</span>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:pop_up_window:desc::trigger:>
//===========================================================================
function pop_up_window($title="",$css="",$text="") {
//--starthtml--//
$BWHTML .= <<<EOF
        
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:Redirect:desc::trigger:>
//===========================================================================
function Redirect($Text="",$Url="",$css="") {global $bw;
$BWHTML = "";
//--starthtml--//
//

//--starthtml--//
$BWHTML .= <<<EOF
        <!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html40/loose.dtd">
<html>
<head>
<title>Redirecting...</title>
<meta http-equiv='refresh' content='2; url=$Url' />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
$css
<style type="text/css">
.title
{
color:red;
}
.text
{
padding:10px;
color:#009F3C;
}
</style>
</head>
  <body >
<center>
<table style="background-color:#6ac3cb" cellpadding="0" cellspacing="0" width="100%" height="100%"> 
<tr>
<td width="416px" align="center" valign="middle" style="background:url({$bw->vars ['board_url']}/styles/redirect/direct.jpg) no-repeat center  top;" height="432px">
<br/><br/><br/><br/>
<img src="{$bw->vars ['board_url']}/styles/redirect/turtle.gif">
<br/><br/>
<p class="text">{$Text}</p>
    <a href='$Url' title="{$Url}" class="title">( Click here if you do not wish to wait )</a>
 </td>
</tr>  
</table> 
</center>
</body>
</html>
EOF;
//--endhtml--//
return $BWHTML;
}


}?>