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
        <div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<button type="button" class="btn btn-navbar collapsed"
data-toggle="collapse" data-target=".nav-collapse">
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<div class="nav-collapse collapse">
<ul class="nav">
<li>
<a href="{$bw->base_url}" title='{$vsSettings->getSystemKey("global_websitename", 'Noodle88', 'global')}'> 
<i class="icon-home"></i>
{$vsLang->getWords('global_nav_home', "Home")}
</a>
</li>
</ul>
<ul class="followUs pull-right">
<li>
<a  class="facebook qtip" title="facebook"
href="{$vsSettings->getSystemKey("config_facebook", 'http://www.facebook.com', 'config')}" target="_blank">
</a>
</li>
<li>
<a  class="twitter" title="Twitter"
href="{$vsSettings->getSystemKey("config_twitter", 'http://www.twitter.com', 'config')}" target="_blank">
</a>
</li>
</ul>
<!--
<ul class="nav pull-right">
<li>
<a href="http://line.naver.jp/R/msg/text/?LINE%20it%21%0d%0ahttp%3a%2f%2fline%2enaver%2ejp%2f" style='padding: 0 15px;'>
<img src="{$bw->vars['img_url']}/linebutton_40x40_en.png" width="40" height="40" alt="LINE it!" />
</a>
</li>
</ul>
-->
{$this->topmenu}
</div>
</div>
</div>
</div>
<!-- STOP HEADER -->
<div id="content">
<div class="wrapper">
<header class="header">
<div class="container">
<div class="row">
<div class="span4">
<a id="logo" href="{$bw->vars['board_url']}" title="{$vsLang->getWords('global_logo_homepage', 'Trang chủ')}">
<img src="{$bw->vars['img_url']}/logo.jpg" alt="logo">
</a>
</div>
<div class="span4">&nbsp;</div>
<div class="span4">
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
<div class='clear'></div>
    </div>
    <div class='clear'></div>
<a class="txtRaling" href="tel:{$vsSettings->getSystemKey("config_telephone", '0906-941-599', 'config')}">
<img src='{$bw->vars['img_url']}/phone.png' />
{$vsSettings->getSystemKey("config_telephone", '0906-941-599', 'config')}
</a>
</div>
</div>
</div>
</header>
<div id="bodySection">
<div class="container">
<div id="myCarousel" class="carousel slide">
<!-- Carousel items -->
{$this->slideshow}
{$this->branch}
</div>
</div>
<div class='clear'></div>
</div>
{$this->promote}
    
    <div class='clear'></div>
{$this->SITE_MAIN_CONTENT}
<div class='clear'></div>
</div>
    
    <div class="clear"></div>
</div>
<!-- STOP CONTENT -->
<footer class="footer">
<div class="container">
<ul class="followUs" style='margin-top: 10px;'>
<li>
<a class="mail" title="Email" href="{$bw->base_url}contacts"></a></li>
<li>
<a  class="facebook qtip" title="facebook" target="_blank"
href="{$vsSettings->getSystemKey("config_facebook", 'http://www.facebook.com', 'config')}">
</a>
</li>
<li>
<a  class="twitter" title="Twitter" target="_blank"
href="{$vsSettings->getSystemKey("config_twitter", 'http://www.twitter.com', 'config')}">
</a>
</li>
<li>
<a  class="dribble qtip" title="Google plus" target="_blank"
href="{$vsSettings->getSystemKey("config_google_plus", 'https://plus.google.com/u/0/', 'config')}">
</a>
</li>
</ul>
{$this->bottommenu}
</div>
</footer>
{$this->footer}
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