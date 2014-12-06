<?php
if(!class_exists('skin_board_admin'))
require_once ('./cache/skins/admin/red/skin_board_admin.php');
class skin_global extends skin_board_admin {

//===========================================================================
// <vsf:addCSS:desc::trigger:>
//===========================================================================
function addCSS($cssUrl="",$media="") {$media = $media?"media='$media'":'';

//--starthtml--//
$BWHTML .= <<<EOF
        <link type="text/css" rel="stylesheet" href="{$cssUrl}.css"  $media/>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:addJavaScriptFile:desc::trigger:>
//===========================================================================
function addJavaScriptFile($file="",$type='file') {global $bw;
$BWHTML = "";

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
function addJavaScript($script="") {
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
// <vsf:SelectOption:desc::trigger:>
//===========================================================================
function SelectOption($options=array()) {
//--starthtml--//
$BWHTML .= <<<EOF
        <option value="{$options['value']}" {$options['selected']}>{$options['name']}</option>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:Select:desc::trigger:>
//===========================================================================
function Select($options=array()) {
//--starthtml--//
$BWHTML .= <<<EOF
        <select name="{$options['name']}" id="{$options['name']}"{$options['properties']}>
<!--OPTION LIST-->
</select>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:addDropDownScript:desc::trigger:>
//===========================================================================
function addDropDownScript($id="") {
//--starthtml--//
$BWHTML .= <<<EOF
        
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
        <div class="red" align="left" style="padding: 20px">
Error: {$message}<br />
Line: {$line}<br />
File: {$file}<br />
Trace: <pre>{$trace}</pre><br />
</div>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:global_main_title:desc::trigger:>
//===========================================================================
function global_main_title() {global $vsPrint;

//--starthtml--//
$BWHTML .= <<<EOF
        {$vsPrint->mainTitle}
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:vs_global:desc::trigger:>
//===========================================================================
function vs_global() {global $bw,  $vsUser;
$this->bw = $bw;
$BWHTML = "";
$vsUser = VSFactory::getAdmins();
$vsLang = VSFactory::getLangs();



//--starthtml--//
$BWHTML .= <<<EOF
        
EOF;
if( !$this->getAdmin()->basicObject->getId() ) {
$BWHTML .= <<<EOF

{$this->SITE_MAIN_CONTENT}

EOF;
}

else {
$BWHTML .= <<<EOF

<div id="header">
<ul class="headerTop left">
<li class="menu_collapse">
<span>Menu</span>
</li>
<li class="user_header">

EOF;
if($vsUser->obj->getImage()) {
$BWHTML .= <<<EOF

{$vsUser->obj->createImageCache($vsUser->obj->getImage(),40,40)}

EOF;
}

else {
$BWHTML .= <<<EOF

<img src="{$bw->vars['img_url']}/avatar.png" />

EOF;
}
$BWHTML .= <<<EOF

<div>
<p>{$vsLang->getWords("admins_welcome",'Chào mừng')}, <span class="title_semibold">{$vsUser->obj->getName()}</span></p>
<p>{$vsLang->getWords("admins_login_last",'Hoạt động cuối')}: {$this->dateTimeFormat($vsUser->obj->getLastLogin(),'d/m/Y h:i')}</p>
</div>
</li>
</ul>
<ul class="right">
<li><a href="{$bw->vars['board_url']}" class="back_home" target="_blank"/><span class="icon-wrapper"><img class="icon-wrapper-vs vs-icon-home" src="{$bw->vars['img_url']}/pixel-vfl3z5WfW.gif" /></span><span>{$vsLang->getWords("global_title_home",'Xem trang chủ')}</span></a></li>
<li><a href="{$bw->base_url}admins/logout" class="logout"/><span class="icon-wrapper"><img class="icon-wrapper-vs vs-icon-logout" src="{$bw->vars['img_url']}/pixel-vfl3z5WfW.gif" /></span><span>{$vsLang->getWords("global_logout",'Thoát')}</span></a></li>
<li> {$this->getAddon()->getLangList()}</li>
</ul>
<div class="clear"></div>
</div>
<div id="vsf_wrapper">
<div id="adminmenuback"></div>
<div id="contextLeft">
<ul id="menu">

EOF;
if( $this->getAddon()->getMenuTop() ) {
$BWHTML .= <<<EOF

{$this->__foreach_loop__id_547ddc1065bb25_41222615()}

EOF;
}

$BWHTML .= <<<EOF

</ul>
</div>
<div id="contextRight">
{$this->SITE_MAIN_CONTENT}
</div>
</div>
<div id="footer" class="vs_footer">
<div id="footerWrap">
<ul class="navFooter">
<ul>
<p class="coppyright"></p>
</div>
</div>
<script type="text/javascript">
$(document).ready(function()
{
 $( document ).tooltip({items: "input, [data-title], button",
content: function() {
var element = $( this );
var title = element.attr( "title" );
if ( element.is( "[data-title]" ) ) title = element.attr( "data-title" ); 
return title;
}
});
$("#countries").msDropDown().data("dd");
 $('.menu_collapse').click(function() {
$('#contextRight').css('margin-left',265);
$('#adminmenuback').slideToggle(300,function() {
      if($(this).css('display')=='none') $('#contextRight').css('margin-left',0);
  else $('#contextRight').css('margin-left',265);
  });
$('#contextLeft').slideToggle(300);
}); 
});
</script>

EOF;
}
$BWHTML .= <<<EOF

EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547ddc1065bb25_41222615()
{
global $bw,  $vsUser;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($this->getAddon()->getMenuTop())){
    foreach( $this->getAddon()->getMenuTop() as $menu )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<li class="{$menu->active}"><a href="
EOF;
if($menu->getType()==1) {
$BWHTML .= <<<EOF
{$menu->getUrl(1)}
EOF;
}

else {
$BWHTML .= <<<EOF
{$menu->getUrl(0)}
EOF;
}
$BWHTML .= <<<EOF
" ><span>{$menu->getTitle()}</span><span class="icon-wrapper right"><img class="icon-wrapper-vs vs-menu-hover" src="{$bw->vars['img_url']}/pixel-vfl3z5WfW.gif" /></span></a>
</li>

EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:importantAjaxCallBack:desc::trigger:>
//===========================================================================
function importantAjaxCallBack($Text="",$Url="",$css="") {global $bw;
$BWHTML = "";
//--starthtml--//
//

//--starthtml--//
$BWHTML .= <<<EOF
        <script type="text/javascript">
$(document).ready(function(){
Custom.init();
});
</script>
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


}
?>