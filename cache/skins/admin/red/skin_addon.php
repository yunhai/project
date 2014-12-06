<?php
class skin_addon{

//===========================================================================
// <vsf:acpHelpHTML:desc::trigger:>
//===========================================================================
function acpHelpHTML($acp_help="") {global $bw;

//--starthtml--//

//--starthtml--//
$BWHTML .= <<<EOF
        <script type="text/javascript">
$(document).ready(function(){
$("#acp-helper").click(function(){
$('#acp-helper-expandable').toggle('fast')});
})
</script>
<div class="vsf-help-box">
<h3><a id="acp-helper" href="#">{$acp_help['help_title']}</a></h3>
<div id="acp-helper-expandable" style="display:none">{$acp_help['help_body']}</div>
</div>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:userLanguages:desc::trigger:>
//===========================================================================
function userLanguages($arrayObj=array(),$title='') {global $bw;
$this->vsLang = VSFactory::getLangs();
//--starthtml--//

//--starthtml--//
$BWHTML .= <<<EOF
        <div id="user-language">
<form id="form-user-language" name='form-user-language' method="post">
<input type="hidden" name="currentModule" value="{$bw->input['module']}" />
<input type="hidden" name="currentAction" value="{$bw->input['action']}" />
{$title}
<select name='languageid' id="language-list">
{$this->__foreach_loop__id_547ddc103150a5_65534186($arrayObj,$title)}
</select>
</form>
</div>
<script type="text/javascript">
$(document).ready(function() {
$('#language-list').change(function() {
$('#form-user-language').submit();
});
vsf.jSelect('{$this->vsLang->currentLang->getId()}','language-list')
$('#form-user-language').submit(function() {
var action='{$bw->base_url}languages/languages_switch/'+$('#language-list').val()+'/';
$('#form-user-language').attr('action',action);
return true;
});
});
</script>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547ddc103150a5_65534186($arrayObj=array(),$title='')
{
global $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($arrayObj)){
    foreach( $arrayObj as $obj )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<option value="{$obj->getId()}" >{$obj->getName()}</option>

EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:statusInterpretation:desc::trigger:>
//===========================================================================
function statusInterpretation() {global $bw;
$this->vsLang = VSFactory::getLangs();

//--starthtml--//
$BWHTML .= <<<EOF
        <table cellspacing="1" cellpadding="1" id="objListInfo" width="100%">
<tbody>
<tr align="left">
<span style="padding-left: 10px;line-height:16px;">
<img src="{$bw->vars['img_url']}/enable.png" />
{$this->vsLang->getWords('global_status_enable', 'Enable')}
</span>
<span style="padding-left: 10px;line-height:16px;">
<img src="{$bw->vars['img_url']}/disabled.png" />
{$this->vsLang->getWords('global_status_disabled', 'Disable')}
</span>
<span style="padding-left: 10px;line-height:16px;">
<img src="{$bw->vars['img_url']}/home.png" />
{$this->vsLang->getWords('global_status_home', 'Home')}
</span>
</tr>
</tbody>
</table>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:notifyList:desc::trigger:>
//===========================================================================
function notifyList($option="") {global $bw;
$this->vsLang = VSFactory::getLangs();

//--starthtml--//
$BWHTML .= <<<EOF
        <div id="notify-list">
<div id='notify-total'>
{$this->vsLang->getWords('global_notification', 'Notifications')}: <span id='notify'><b>{$option['total']}</b></span>
</div>
<div id='notifylist' style='display:none;'>
        {$this->__foreach_loop__id_547ddc10317379_47646708($option)}
        <div id='allnotify'>
        <a href='{$bw->base_url}notifys/mylist' title='{$this->vsLang->getWords('global_all_notification', 'All notifications')}'>
        {$this->vsLang->getWords('global_all_notification', 'All notifications')}
        </a>
        </div>
        </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
var flag = true; var update = true;
$("#notify-total").click(function(){
if(update){
var nids = '';
$('#notifylist .item').each(function(){
nids += $(this).attr('ref') + ',';
});
vsf.get('notifys/updateanalytics/&no='+nids, 'notify');
}
if(flag){
$('#notifylist').css({display: "block"}).show();
$(this).addClass('active');
update = false;
}else{
$('#notifylist').css({display: "none"}).hide();
$(this).removeClass('active');
update = false;
}
flag = !flag;
});
});
</script>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547ddc10317379_47646708($option="")
{
global $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array( $option['notify'])){
    foreach(  $option['notify'] as $notify  )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
        <div class='item' ref='{$notify->getId()}'>
        {$notify->getTitle()} [{$notify->getTime('LONG')}]
        </div>
        
EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:getAnalytic:desc::trigger:>
//===========================================================================
function getAnalytic($option=array()) {global $bw;
$this->vsLang = VSFactory::getLangs();


//--starthtml--//
$BWHTML .= <<<EOF
        <p style="color: #fff">Đang truy cập: <span >{$option['online']}</span>  |   ngày hôm nay: <span >{$option['today']}</span>  | Tuần: <span >{$option['week']}</span>  |  Tháng: <span >{$option['month']}</span>  |  Tổng truy cập: <span >{$option['total']}</span></p>
EOF;
//--endhtml--//
return $BWHTML;
}


}
?>