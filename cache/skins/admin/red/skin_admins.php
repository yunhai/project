<?php
class skin_admins{

//===========================================================================
// <vsf:MainPage:desc::trigger:>
//===========================================================================
function MainPage() {global $bw, $vsLang,$vsUser,$vsSettings;
$BWHTML = "";

//--starthtml--//
$BWHTML .= <<<EOF
        <div id="page_tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all-top">
<ul id="tabs_nav" class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all-inner">
<li class="ui-state-default ui-corner-top">
        <a href="{$bw->base_url}admins/displayadmin/&ajax=1">{$vsLang->getWords('tab_admin_users','Admin Users')}</a>
        </li>
        
EOF;
if($vsUser->checkViewPermission($bw->input[0],'displaygroup') and $vsSettings->getSystemKey($bw->input['module'].'_group_tab', 0, $bw->input['module'])) {
$BWHTML .= <<<EOF

    <li class="ui-state-default ui-corner-top ">
    <a href="{$bw->base_url}admins/displaygroup/&ajax=1">{$vsLang->getWords('tab_admin_groups','Admin Groups')}</a></li>
    
EOF;
}

$BWHTML .= <<<EOF

    
EOF;
if($vsUser->checkViewPermission($bw->input[0],'permission')and  $vsSettings->getSystemKey($bw->input['module'].'_permission_tab', 0, $bw->input['module'])) {
$BWHTML .= <<<EOF

<li class="ui-state-default ui-corner-top">
        <a href="{$bw->base_url}admins/permission/&ajax=1">{$vsLang->getWords('tab_admin_permission','Admin Permission')}</a></li>
        
EOF;
}

$BWHTML .= <<<EOF

        
EOF;
if( $vsSettings->getSystemKey($bw->input['module'].'_settings_tab', 0, $bw->input['module']) ) {
$BWHTML .= <<<EOF

        <li class="ui-state-default ui-corner-top">
        <a href="{$bw->base_url}settings/moduleObjTab/{$bw->input[0]}/&ajax=1">{$vsLang->getWords("tab_{$bw->input[0]}_ss",'Settings')}</a></li>
        
EOF;
}

$BWHTML .= <<<EOF

        
EOF;
if( $vsSettings->getSystemKey($bw->input['module'].'_config_tab', 0, $bw->input['module']) ) {
$BWHTML .= <<<EOF

        <li class="ui-state-default ui-corner-top">
        <a href="{$bw->base_url}settings/moduleObjTab/config/&ajax=1">{$vsLang->getWords('tab_contact_config','User config')}</a>
        </li>
        
EOF;
}

$BWHTML .= <<<EOF
 
</ul>
<div class="clear"></div>
</div>
<div id="temp"></div>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:ModuleOption:desc::trigger:>
//===========================================================================
function ModuleOption($name="",$module="") {$BWHTML = "";

//--starthtml--//
$BWHTML .= <<<EOF
        <option value="{$module->getId()}">{$name}</option>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:ModuleBox:desc::trigger:>
//===========================================================================
function ModuleBox($moduleOption="",$message="") {global $vsLang;
$BWHTML = "";

//--starthtml--//
$BWHTML .= <<<EOF
        <script type="text/javascript">
var permModule = "";
$('#adminperm_module').change(function() {
var str = "";
$("#adminperm_module option:selected").each(function () {
str = $(this).val();
});
permModule = str;
});
</script>
<div class="ui-dialog ui-widget ui-widget-content ui-corner-all" style="width:200px !important; float:right !important">
<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
<span class="ui-dialog-title">{$vsLang->getWords('module_box_title','Permission List')}
</div>
<div class="red">{$message}</div>
<table  cellpadding="0" cellspacing="0">
<tr>
<td class="ui-dialog-selectpanel">
<select id="adminperm_module" size='15' name="adminperm_module" multiple>{$moduleOption}</select>
</td>
</tr>
</table>
</div>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:AdminPermList:desc::trigger:>
//===========================================================================
function AdminPermList($perm=array(),$message="") {global $vsLang;
$count = 0;
$BWHTML = "";

//--starthtml--//
$BWHTML .= <<<EOF
        <div class="red">{$message}</div>
<form id="adminpermform" method="post">
<input type="hidden" name="permCount" value="{$perm['count']}" />
<input type="hidden" name="groupId" value="{$perm['groupId']}" />
<input type="hidden" name="moduleId" value="{$perm['moduleId']}" />
<div class="ui-dialog ui-widget ui-widget-content ui-corner-all">
<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
<span class="ui-dialog-title">{$vsLang->getWords('permlist_title','List of permissions')}
</div>
<table cellpadding="0" cellspacing="0" class="ui-dialog-content ui-widget-content" style="width:100%;">
<tr>
<th colspan="2">{$perm['perTitle']}</th>
</tr>
{$this->__foreach_loop__id_5246b29e8799f($perm,$message)}
<tr>
<td class="ui-dialog-buttonpanel" class="2">
<input type="submit" name="submit" value="{$vsLang->getWords('perm_bt_submit','Save permission')}">
</td>
</tr>
</table>
</form>
</div>
<script type="text/javascript">
$('#adminpermform').submit(function() {
vsf.submitForm($(this),'admins/savepermission/','perm_list');
return false;
});
</script>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_5246b29e8799f($perm=array(),$message="")
{
global $vsLang;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach( $perm['perm'] as $key => $val )
    {
        $vsf_class = $vsf_count%2?'odd':'even';$count++;
$class="odd";
if($count%2)$class="even";
$link = $perm['module'].$key;
    $BWHTML .= <<<EOF
        

<tr class="{$class}">
<td>{$val}</td>
<td>

EOF;
if($perm['listpermobj'][$link]) {
$BWHTML .= <<<EOF

<input class="checkbox" type="checkbox" name="perm_{$count}" value="{$key}" checked />

EOF;
}

else {
$BWHTML .= <<<EOF

<input class="checkbox" type="checkbox" name="perm_{$count}" value="{$key}" />

EOF;
}
$BWHTML .= <<<EOF

</td>
</tr>

EOF;
$vsf_count++;
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:AdminPermGroupBox:desc::trigger:>
//===========================================================================
function AdminPermGroupBox($groupOption=array(),$message='') {global $vsLang;
$BWHTML = "";

//--starthtml--//
$BWHTML .= <<<EOF
        <script type="text/javascript">
var permGroup = "";
$('#adminperm_group').change(function() {
var str ="";
$("#adminperm_group option:selected").each(function () {
str = $(this).val();
});
permGroup = str;
});
</script>
<div class="ui-dialog ui-widget ui-widget-content ui-corner-all" style="width:200px !important;">
<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
<span class="ui-dialog-title">{$vsLang->getWords('group_box_title','Group Admin List')}
</div>
<div class="red">{$message}</div>
<table  cellpadding="0" cellspacing="0" style="width:100%">
<tr>
<td class="ui-dialog-selectpanel">
<select size='15' id="adminperm_group" name="adminperm_group" multiple>

EOF;
if(count($groupOption)) {
$BWHTML .= <<<EOF

{$this->__foreach_loop__id_5246b29e8816e($groupOption,$message)}

EOF;
}

$BWHTML .= <<<EOF
    
</select>
</td>
</tr>
</table>
</div>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_5246b29e8816e($groupOption=array(),$message='')
{
global $vsLang;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach( $groupOption as $group )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
         <option value="{$group->getId()}"  >{$group->getName()}</option>
    
EOF;
$vsf_count++;
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:mainAdminPermission:desc::trigger:>
//===========================================================================
function mainAdminPermission($modulelist="",$groupbox="") {global $bw, $vsLang;
$BWHTML = "";
//--starthtml--//

//--starthtml--//
$BWHTML .= <<<EOF
        <script type="text/javascript">
$('#bt_setperm').click(function() {
var error = "";
if(permGroup=="") {
error += '{$vsLang->getWords('err_perm_choose_module',"Please choose group!")}<br />';
$('#adminperm_group').addClass('ui-state-error');
}
else { $('#adminperm_group').removeClass('ui-state-error'); }
if(permModule=="") {
error += '{$vsLang->getWords('err_perm_choose_group',"Please choose module!")}<br />';
$('#adminperm_module').addClass('ui-state-error');
}
else { $('#adminperm_module').removeClass('ui-state-error'); }

if(error!="") {
$('#permbox_message').html(error);
return;
}

$('#permbox_message').html('');
vsf.get('admins/getpermission/'+permModule+'/'+permGroup+'/','perm_list');
});
</script>
<!--<div id="perm_groupbox" class="left-cell" style="width:410px !important; padding:0px 5px">{$groupbox}</div>
<div class="right-cell" >
<div id="perm_modulebox" style="float:left; width:310px !important; padding:0px 5px">
{$modulelist}
<div class="ui-dialog-buttonpanel">
<input id="bt_setperm" type="button" value="{$vsLang->getWords('perm_bt_set','Set Permission')}" />
</div>
</div>
<div id="perm_list"  style="float:left; width:210px !important; padding:0px 5px" class="ui-dialog-buttonpanel">
</div>
</div>
<div class="clear"></div>-->

<div class="left-cell">
    <div class="ui-accordion ui-helper-reset" id="perm_groupbox">{$groupbox}</div>
</div>
<div class="right-cell ui-accordion ui-helper-reset" id="obj-list">
<div id="perm_modulebox" style="float:left;">
{$modulelist}
<p>
<input id="bt_setperm" type="button" value="{$vsLang->getWords('perm_bt_set','Set Permission')}" />
</p>
</div>
<div id="perm_list" style="float:right; width:390px;" ></div>
</div>
<div class="clear"></div>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:MainAdmin:desc::trigger:>
//===========================================================================
function MainAdmin($groupbox="",$userform="",$usertable="") {global $bw, $vsLang;
$BWHTML = "";
//--starthtml--//



//--starthtml--//
$BWHTML .= <<<EOF
        <div class="left-cell">
    <div class="ui-accordion ui-helper-reset" id="adminform">{$userform}</div>
    <div class="ui-accordion ui-helper-reset" id="admingroupbox">{$groupbox}</div>
</div>
<div class="right-cell ui-accordion ui-helper-reset" id="obj-list">{$usertable}</div>
<div class="clear"></div>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:MainUserAdmin:desc::trigger:>
//===========================================================================
function MainUserAdmin($groupbox="",$userform="",$usertable="") {global $bw, $vsLang;
$BWHTML = "";
//--starthtml--//

//--starthtml--//
$BWHTML .= <<<EOF
        <div id="uni_mainContent" class="margin0auto">
    <div id="maincontent_top" class="margin0auto">
    <div id="date_time" class="margin0auto">
        <span>Bây giờ là: </span>
            <span id="clock"></span>
        </div>
        </div>
        <div id="maincontent" class="margin0auto">
        <div id="content_header" class="margin0auto">
            <h3>{$vsLang->getWords('global_stst','CẤU HÌNH HỆ THỐNG')}</h3>
            </div>
            <div id="content1" class="margin0auto">
            <div class="system">
                    <form name="contactform" id="contactform">
                        <label>{$vsLang->getWords('global_club_name','Tên cơ sở')}:</label><br/>
                        <input type="text" name="system[24-contact_company]" value="{$bw->vars['contact_company']}"><div class="col-right"><span class="system_span">{$vsLang->getWords('global_vd_club_name','Câu lạc bộ bida')}: </span><span class="system_span1">{$bw->vars['contact_company']}</span><br/></div>
                        <div class="clear"></div>
                        <label>{$vsLang->getWords('global_address','Địa chỉ')}:</label><br/>
                        <input type="text" name="system[25-contact_address]" value="{$bw->vars['contact_address']}"><div class="col-right">{$bw->vars['contact_address']}</div><br/>
                        <div class="clear"></div>
                        <label>{$vsLang->getWords('global_phone','Điện thoại')}:</label><br/>
                        <input type="text" name="system[26-contact_phone]" value="{$bw->vars['contact_phone']}"><div class="col-right">{$bw->vars['contact_phone']}</div><br/>
                        <div class="btn_form">
                        <div class="floadleft"><img src="{$bw->vars ['img_url']}/left_btn1.jpg"></div>
                            <div class="btn_form_bg"><a href="javascript: " onclick="vsf.submitForm($('#contactform'),'admins/addeditcontact/','uni_mainContent'); return false;">{$vsLang->getWords('global_club_update','Lưu thay đổi')}</a></div>
                        <div class="floadleft"><img src="{$bw->vars ['img_url']}/right_btn1.jpg"></div>
                            
                        </div>
                        <br/>
                    </form>
                </div>
                <div class="clr-left"></div>
<!--START ACCOUNT-->
                <div class="account">
                <div class="account_title">
                    <div class="floadleft"><img src="{$bw->vars ['img_url']}/left_btn2.jpg"></div>
                        <div class="account_title_bg"><a href="javascript:" onclick="javascript:vsf.get('admins/editadmin/','adminform'); return false;">{$vsLang->getWords('user_account','TÀI KHOẢN NGƯỜI DÙNG')}</a></div>
                        <div class="floadleft"><img src="{$bw->vars ['img_url']}/right_btn2.jpg"></div>
                    </div>
<div id="adminform" class="register_account">
{$userform}
                    </div>
                    <div id="obj-list" class="account_list">
                     {$usertable}
                    </div>
                </div>
<!--STOP ACCOUNT-->     
<div class="clr"></div>
</div>
<!--STOP CONTENT-->                        
        </div>
        <div id="content_bottom1" class="margin0auto"></div>
        <div class="clr"></div>
    </div>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:objListHtml:desc::trigger:>
//===========================================================================
function objListHtml($option=null) {global $bw, $vsLang;
$BWHTML = "";
//--starthtml--//



//--starthtml--//
$BWHTML .= <<<EOF
        <input type="hidden" name="checkedObj" id="checked-obj" value="" />
<h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-top">
<span class="ui-icon ui-icon-triangle-1-e"></span><a href="#">{$vsLang->getWords('admin_list','List of admins')}</a></h3>
<div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
    <div id="err_admin_message" class="red">{$message}</div>
    <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-corner-all-inner ui-widget-header">
    <li class="ui-state-default ui-corner-top">
    <a id="addPage" title="{$vsLang->getWords('pages_addPage','Add')}" onclick="addPage()" href="javascript:vsf.get('admins/addformadmin/','adminform');">
{$vsLang->getWords('pages_addPage','Add')}
</a>
    </li>
    <li class="ui-state-default ui-corner-top">
        <a id="deletePage" title="{$vsLang->getWords('pages_deletePage','Delete')}" onclick="deleteAllAdmin()" href="#">
{$vsLang->getWords('pages_deletePage','Delete')}
</a>
</li>
        <li class="ui-state-default ui-corner-top">
        <a onclick="hiddenAllAdmin()" title="{$vsLang->getWords('pages_hidePage','Hide')}" href="#">
{$vsLang->getWords('pages_hidePage','Hide')}
</a>
</li>
        <li class="ui-state-default ui-corner-top">
        <a id="displayPage" title="{$vsLang->getWords('pages_unhidePage','Display')}" onclick="showAllAdmin()" href="#">
{$vsLang->getWords('pages_unhidePage','Display')}
</a>
</li>
</ul>
    <table  cellpadding="0" cellspacing="1" width="100%">
        <thead>
            <tr>
            <th width="15"><input type="checkbox" onclick="vsf.checkAll()" name="all" /></th>
                <th>{$vsLang->getWords('admin_list_name','Account')}</th>
                <th>{$vsLang->getWords('admin_list_visible','Is Visible?')}</th>
                <th>{$vsLang->getWords('admin_list_joindate','Joined date')}</th>
                <th>{$vsLang->getWords('admin_list_lastlogin','Last login')}</th>
                <th>{$vsLang->getWords('admin_list_option','Option')}</th>
            </tr>
        </thead>
        
EOF;
if($option['pageList']) {
$BWHTML .= <<<EOF

        {$this->__foreach_loop__id_5246b29e8893e($option)}
        
EOF;
}

$BWHTML .= <<<EOF

        <tr>
        <td></td><td></td><td></td><td></td><td></td>
        <td colspan="2">{$option['paging']}</td>
        </tr>
    </table>
    <div class="clear"></div>
</div>
<script>
     
        function deleteAllAdmin(){
                if(vsf.checkValue())
                            jConfirm(
                                    '{$vsLang->getWords("contact_deleteContactConfirm","Are you sure to delete this contact information?")}',
                                    '{$bw->vars['global_websitename']} Dialog',
                                    function(r){
                                            if(r){
                                                    vsf.get('admins/deleteadmins/'+$('#checked-obj').val()+'/&pageIndex={$bw->input[2]}','obj-list');
                                            }
                                    }
                            );
                }
        function showAllAdmin(){
        if(vsf.checkValue())
                jConfirm(
                        '{$vsLang->getWords("contact_showAdminConfirm","Are you sure to show this contact information?")}',
                        '{$bw->vars['global_websitename']} Dialog',
                        function(r){
                                if(r){
                                        vsf.get('admins/showAdmins/'+ $('#checked-obj').val() +'/&pageIndex={$bw->input[2]}','obj-list');
                                }
                        }
                );
        }
        function hiddenAllAdmin(){
        if(vsf.checkValue())
                jConfirm(
                        '{$vsLang->getWords("contact_hiddenContactConfirm","Are you sure to hidden this contact information?")}',
                        '{$bw->vars['global_websitename']} Dialog',
                        function(r){
                                if(r){
                                        vsf.get('admins/hiddenAdmins/'+$('#checked-obj').val()+'/&pageIndex={$bw->input[2]}','obj-list');
                                }
                        }
                );
        }
        </script>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_5246b29e8893e($option=null)
{
global $bw, $vsLang;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach( $option['pageList'] as $obj )
    {
        $vsf_class = $vsf_count%2?'odd':'even';$class= 'even';
if($obj->stt%2)$class='old';
    $BWHTML .= <<<EOF
        
            
<tr class="{$class}">
<td>

EOF;
if( !$obj->current ) {
$BWHTML .= <<<EOF

<input type="checkbox"  onclick="vsf.checkObject();" name="obj_{$obj->getId()}" value="{$obj->getId()}" class="myCheckbox" />

EOF;
}

else {
$BWHTML .= <<<EOF

<img src='{$bw->vars['img_url']}/disabled.png' alt='X' style="margin-left: 3px;" />

EOF;
}
$BWHTML .= <<<EOF

</td>
<td  class="cursor" ">
<a title="{$vsLang->getWords('global_a_title_edit',"Edit this information")}" href="javascript:vsf.get('admins/editadmin/{$obj->getId()}/','adminform');">
               {$obj->getName()}
               </a>
            </td>
<td>{$obj->getStatus('image')}</td>
<td>{$obj->getJoinDate(false)}</td>
<td>{$obj->getLastLogin(false,'g:i A d/m/Y')}</td>
<td>
<a title="{$vsLang->getWords('edit_title','Edit this information')}" id="view-obj-bt" href="javascript:vsf.get('admins/editadmin/{$obj->getId()}/','adminform');;" class="ui-state-default ui-corner-all ui-state-focus">
{$vsLang->getWords('edit','Edit')}
</a>
</td>
</tr>
        
EOF;
$vsf_count++;
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:AddEditAdminForm:desc::trigger:>
//===========================================================================
function AddEditAdminForm($form=array(),$obj="") {global $vsLang,$vsUser,$vsSettings;
$BWHTML = "";

$checked = $obj->getStatus()?'checked ' : '';


//--starthtml--//
$BWHTML .= <<<EOF
        <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-top">
<span class="ui-icon ui-icon-triangle-1-e"></span>
<a href="#">
{$vsLang->getWords('admin_form_title_'.$form['type'], $form['type']." admin form")}
</a>
</h3>
<div id="err_admin_message" class="red">{$form['message']}</div>
    <form id="addeditadmin" method="post">
    <input type="hidden" id="formType" name="formType" value="{$form['type']}" />
    <input type="hidden" name="adminId" value="{$obj->getId()}" />
    
EOF;
if( $obj->oldName ) {
$BWHTML .= <<<EOF

    <input type="hidden" name="oldName" value="{$obj->oldName}" />
    
EOF;
}

else {
$BWHTML .= <<<EOF

    <input type="hidden" name="oldName" value="{$obj->getName()}" />
    
EOF;
}
$BWHTML .= <<<EOF

    
    <input type="hidden" id="groupId" name="groupId" value="{$obj->groupIds}" />
    <input type="hidden" id="groupIds" name="groupIds" value="" />
<div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
        <table  cellpadding="0" cellspacing="1" width="100%">
        <tr>
                <th>{$vsLang->getWords('admin_form_header_name','Account')}</th>
                <td><input id="adminName" type="text" name="adminName" value="{$obj->getName()}" /></td>
            </tr>
            <tr>
                <th valign="top">{$vsLang->getWords('admin_form_header_password','Password')}</th>
                <td><input id="adminPassword" type="password" name="adminPassword" value="" /></td>
            </tr>
            
            <tr>
                <th valign="top">{$vsLang->getWords('admin_form_header_visible','Is visible')}</th>
                <td><input class="checkbox" type="checkbox" name="adminStatus" id="adminStatus" value="1"/></td>
            </tr>
             
            
EOF;
if($vsSettings->getSystemKey('admin_index',0, 'admins')) {
$BWHTML .= <<<EOF

            <tr>
                <th valign="top">{$vsLang->getWords('admin_form_header_index','Index')}</th>
                <td><input class="checkbox" type="checkbox" name="adminIndex" value="1"/></td>
            </tr>
            
EOF;
}

$BWHTML .= <<<EOF

            
EOF;
if( $obj->displayGroup ) {
$BWHTML .= <<<EOF

            <tr>
                <th valign="top">{$vsLang->getWords('admin_form_listgroup','Group List')}</th>
                <td>&nbsp;</td>
            </tr>
            
EOF;
if(count($vsUser->obj->getGroups())) {
$BWHTML .= <<<EOF

            {$this->__foreach_loop__id_5246b29e8910e($form,$obj)}
            
EOF;
}

$BWHTML .= <<<EOF

            
EOF;
}

$BWHTML .= <<<EOF

            <tr>
                <th>&nbsp;</th>
                <td class="ui-dialog-buttonpane ui-helper-clearfix"><button class="ui-state-default ui-corner-all" id="addedtiadmin" type="button">{$form['submit']}</button></td>
            </tr>
</table>
<div class="clear"></div>
</div>
</form>
<script type="text/javascript">

    
$('#addedtiadmin').click(function(){
var error = 0; var str = "";

var name = $('#adminName').val();
name = jQuery.trim(name);

if(name.length < 4){
if($('#adminName').val().length < 1){
str += '* {$vsLang->getWords('err_admin_name_blank','Please enter the admin name!')}<br />';
}else{
str += '* {$vsLang->getWords('err_admin_name_short','Admin name is at lease 4 characters!')}<br />';
}
$('#adminName').addClass('ui-state-error');
}
else $('#adminName').removeClass('ui-state-error');

if($('#adminPassword').val().length < 4 && $('#formType').val()=='add') {
if($('#adminPassword').val().length < 1)
str += "* {$vsLang->getWords('err_admin_password_blank','Please enter the password!')}<br />";
else 
str += '* {$vsLang->getWords('err_admin_password_short','Password is at lease 4 characters!')}<br />';
$('#adminPassword').addClass('ui-state-error');
}
else $('#adminPassword').removeClass('ui-state-error');


if($('#formType').val()=='edit'){
if($('#adminPassword').val().length < 4 && $('#adminPassword').val().length > 0){
str += '* {$vsLang->getWords('err_admin_password_short','Password is at lease 4 characters!')}<br />';
$('#adminPassword').addClass('ui-state-error')
}else  $('#adminPassword').removeClass('ui-state-error');
}


EOF;
if( $obj->displayGroup ) {
$BWHTML .= <<<EOF

var jsonStr="";
$("input[name=group]").each(function(){
if(this.checked)
jsonStr += this.value + ',';
});
jsonStr = jsonStr.substr(0,jsonStr.lastIndexOf(','));

EOF;
}

else {
$BWHTML .= <<<EOF

jsonStr = {$vsSettings->getSystemKey("default_normal_group",2)}

EOF;
}
$BWHTML .= <<<EOF



if(jsonStr) $('#groupIds').val(jsonStr);
else{
vsf.alert("{$vsLang->getWords('none_group','Accout must belong to at least one group!')}");
return;
}

if(str) {
$('#err_admin_message').html(str);
return false;
}

$('#err_admin_message').html('');
var groupId = $('#groupId').val();

$("#adminform").html('<img src="'+imgurl+'loader.gif"/>');
vsf.submitForm($(this).closest("form"),'admins/addeditadmin/','',{
sucess:function(data){
$("#adminform").html(data);
vsf.get('admins/display-obj-list/','obj-list');
}
});
});
</script>
<script>
$(document).ready(function () {
var the_LANGFORM= window.document.getElementById('addeditadmin');

vsf.jCheckbox('{$obj->getStatus()}','adminStatus');
var listgroup = "{$obj->getGroups()}";

if(listgroup.length){
var list =listgroup.split(",");
for(var i=0;i<list.length;i++){
var name='#group'+list[i];
$(name).attr('checked','checked')

}
}
});


EOF;
if($form['message']) {
$BWHTML .= <<<EOF

vsf.alert('{$form['message']}');

EOF;
}

$BWHTML .= <<<EOF

</script>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_5246b29e8910e($form=array(),$obj="")
{
global $vsLang,$vsUser,$vsSettings;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach( $vsUser->obj->getGroups() as $group )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
            <tr>
                <th valign="top"></th>
                <td><input style="margin-right:4px;" class="checkbox" id="group{$group->getId()}" type="checkbox" name="group" value="{$group->getId()}" />{$group->getName()}</td>
            </tr>
            
EOF;
$vsf_count++;
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:GroupAdminBox:desc::trigger:>
//===========================================================================
function GroupAdminBox($groupOption="") {global $vsLang, $bw;
$BWHTML = "";
//--starthtml--//

//--starthtml--//
$BWHTML .= <<<EOF
        <script type="text/javascript">
var chosenGroup = "";
$('#bt_viewadmin').click(function() {
if(chosenGroup==0 || chosenGroup=="") {
alert('{$vsLang->getWords('err_admin_choose_group',"Please choose a group to view admin in it!")}');
$('#groupusers').addClass('ui-state-error');
return false;
}
$('#groupusers').removeClass('ui-state-error');
vsf.get('admins/displayobj-list/'+chosenGroup+'/','obj-list');
});
$('#groupusers').change(function() {
var str = "";
$("#groupusers option:selected").each(function () {
str += $(this).val() + ",";
});
chosenGroup = str.substr(0,str.length-1);
$("#groupId").val(chosenGroup);
$('#tdChosenGroup').html('{$vsLang->getWords('group_box_chosen','Chosen groups')}: '+chosenGroup);
});
</script>
<h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-top">
<span class="ui-icon ui-icon-triangle-1-e"></span><a href="#">{$vsLang->getWords('group_box_title','Group Admin List')}</a></h3>
<div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
    <div id="err_admin_message" class="red">{$form['message']}</div>
        <table  cellpadding="1" cellspacing="0" width="100%">
            <tr>
            <th id="tdChosenGroup">{$vsLang->getWords('group_box_chosen','Chosen groups')}: 0</th>
                <th>
                <img src="{$bw->vars['img_url']}/view.png" id="bt_viewadmin" alt="{$vsLang->getWords('group_box_bt_view','View users')}" /></th>
            </tr>
        <tr>
                <td colspan="2">
                <select id="groupusers" name="groupusers" multiple>
                
EOF;
if(count($groupOption)) {
$BWHTML .= <<<EOF

                {$this->__foreach_loop__id_5246b29e898de($groupOption)}
                
EOF;
}

$BWHTML .= <<<EOF

                </select>
                </td>
            </tr>
</table>
<div class="clear"></div>
</div>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_5246b29e898de($groupOption="")
{
global $vsLang, $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach( $groupOption as $group )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
                <option value="{$group->getId()}"  >{$group->getName()}</option>
                
EOF;
$vsf_count++;
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:LoginForm:desc::trigger:>
//===========================================================================
function LoginForm($error="") {global $bw, $vsLang, $vsSettings;
$BWHTML = "";

//--starthtml--//
$BWHTML .= <<<EOF
        
EOF;
if($bw->input['ajax']) {
$BWHTML .= <<<EOF

        <script>
        $(document).ready(function()
        {
            document.location.href='{$bw->vars['board_url']}/admin.php';
            });
        </script>

EOF;
}

else {
$BWHTML .= <<<EOF


<center>
<a id="checkie" href="#TB_inline?height=220&width=600&inlineId=hiddenModalContent&modal=true" class="thickbox"></a>
<div style="display: none;" id="hiddenModalContent">
<p style="text-align:center; font-size:16px; padding-top:40px"><span>{$vsLang->getWords('ie6_notes','You are using IE. Please use FireFox to website administrator.
If not FireFox. You can download the browser here.')}</span><br />
    <p style="text-align:center">
        <a href="{$vsSettings->getSystemKey('firefox_link', 'http://www.mozilla.com/', 'global', 1, 1)}" target="_blank">
            <img src="{$bw->vars['img_url']}/download.gif" />
        </a>
    </p>
</p>
<p style="float:right; vertical-align:bottom;">

<!--<a id="TB_closeWindowButton" href="#">{$vsLang->getWords('close', 'Close')}</a>-->
</p>
</div>
<a target="_blank" href="{$bw->vars ['board_url']}" class="buttom_back_cd" title="{$bw->vars ['global_websitename']}">Trở lại trang chủ</a>

<div id="vsf-wrapper-container">
<div id="vsf-wrapper" align="center">
<!-- BEGIN OF HEADER -->
<div class="vsf-header">
<div class="header_vs_ceedos">
<span>{$vsLang->getWords('global_adminControlPanel','Admin Control Panel')}</span>
</div>
    <div class="clear"></div>
<center>
<div class="uvn-login" align="center">
<div class="uvn-login-form">
        
        
<div class="login-form">
<p align="center" class="system_error"></p>
<form action="{$bw->base_url}admins/dologin/" method="post">
<div class="text-cell">{$vsLang->getWords('admins_userName','Username')}</div>
<div class="input-cell" title="{$vsLang->getWords('admins_userNameTitle','Input your Username')}">
<input type="text" name="adminName" id="adminName" />
</div>
<div class="text-cell">{$vsLang->getWords('admins_password','Password')}</div>
<div class="input-cell" title="{$vsLang->getWords('admins_passwordTitle','Input your password')}">
<input id="adminPassword" name="adminPassword" type="password" />
<label class="error" for="adminPassword"></label>
</div>
<!--
<div class="remember">

<span><a href="">{$vsLang->getWords('admins_forgorpass','Forgot Password')}</a></span>

</div>
-->
<div class="submit-cell"><button class="log_me_in" type="submit">{$vsLang->getWords('admins_logInTitle','Login')}</button></div>
</form>
</div>
<div class="clear"></div>
</div>
</div>
<div class="clear"></div>
</div>




<script type="text/javascript">
$(document).ready(function()
{
         var viewportwidth;

 if (typeof window.innerWidth != 'undefined')
 {
      viewportwidth = window.innerWidth,
      viewportheight = window.innerHeight
 }
 else if (typeof document.documentElement != 'undefined'
     && typeof document.documentElement.clientWidth !=
     'undefined' && document.documentElement.clientWidth != 0)
 {
       viewportwidth = document.documentElement.clientWidth,
       viewportheight = document.documentElement.clientHeight
 }
 else
 {
       viewportwidth = document.getElementsByTagName('body')[0].clientWidth,
       viewportheight = document.getElementsByTagName('body')[0].clientHeight
 }

var percent=((viewportheight-$('#wrapper').height())/viewportheight*100)/2;
var percentwidth=((viewportwidth-$('#wrapper').width())/viewportwidth*100)/2;
                        
$('#container').css('top','140px');
$('#container').css('left','150px');

$('#container').css('top',percent+'%');
$('#container').css('left',percentwidth+'%');
});
$("#adminPassword").keydown(function(e){
var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
if(e.keyCode==13)
$('#frmlogin').submit()
})

$('#frmlogin').submit(function(){
if(!$("#adminPassword").val()||!$("#adminName").val())
{
$('.error').css("display","block");
$('.error').html('<strong style="color:red">Tài khoản hoặc mật khẩu không được để trống.</strong>');
return false;
}
});
function setfocus(){
$("#adminName").focus();
var error = '{$error}';
if(error){
$('.system_error').html(error);
}
}

function detect_caps_lock(D){
D=(D?D:window.event);
var A=(D.which?D.which:(D.keyCode?D.keyCode:(D.charCode?D.charCode:0)));
var C=(D.shiftKey||(D.modifiers&&(D.modifiers&4)));
var B=(D.ctrlKey||(D.modifiers&&(D.modifiers&2)));
return(A>=65&&A<=90&&!C&&!B)||(A>=97&&A<=122&&C)
}
function caps_check(e){
var detected_on = detect_caps_lock(e);
if (!detected_on){
$('.error').css("display","");
}
if (detected_on){
$('.error').css("display","block");
$('.error').html('<strong>Đang bật chế độ Caps Lock!</strong><br /> Mật mã phân biệt chữ HOA - chữ thường.');
}

}
setfocus();
document.getElementById('adminPassword').onkeypress = caps_check;
</script>

EOF;
}
$BWHTML .= <<<EOF

EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:MainGroup:desc::trigger:>
//===========================================================================
function MainGroup($grouptable="",$groupform="") {global $bw, $vsLang;
$BWHTML = "";
//--starthtml--//



//--starthtml--//
$BWHTML .= <<<EOF
        <div class="left-cell" id="groupform">{$groupform}</div>
<div class="right-cell" id="grouptable">{$grouptable}</div>
<div class="clear"></div>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:GroupTable:desc::trigger:>
//===========================================================================
function GroupTable($grouplist="",$message="") {global $vsLang,$bw;
$BWHTML = "";
//--starthtml--//



//--starthtml--//
$BWHTML .= <<<EOF
        <div class="ui-accordion ui-helper-reset">
<h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-top">
    <span class="ui-icon ui-icon-triangle-1-e"></span>
        <a href="#">{$vsLang->getWords('group_list','List of groups')}</a>
       
    </h3>
     <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-corner-all-inner ui-widget-header">
    <li class="ui-state-default ui-corner-top">
    <a id="addPage" title="{$vsLang->getWords('pages_addPage','Add')}" onclick="addPage()" href="javascript:vsf.get('admins/addgroupform/','groupform');">
{$vsLang->getWords('pages_addPage','Add')}
</a>
    </li>
    <li class="ui-state-default ui-corner-top">
        <a id="deletePage" title="{$vsLang->getWords('pages_deletePage','Delete')}" onclick="deleteAllGroup()" href="#">
{$vsLang->getWords('pages_deletePage','Delete')}
</a>
</li>
       
</ul>     
<div class="red">{$message}</div>
<table cellpadding="0" cellspacing="1" width="100%">
    <thead>
        <tr>
        <th width="15"><input type="checkbox" onclick="checkAll()" onclicktext="checkAll()" name="allgroup" /></th>
            <th>{$vsLang->getWords('group_header_id','Group ID')}</th>
            <th>{$vsLang->getWords('group_header_name','Name')}</th>
            <th>{$vsLang->getWords('group_header_description','Description')}</th>
            
</tr>
</thead>
        <tbody>
{$this->__foreach_loop__id_5246b29e8a0af($grouplist,$message)}

        </tbody>
</table>
<script>
function checkObject() {
var checkedString = '';
$("input[type=checkbox]").each(function(){
if($(this).hasClass('myCheckbox')){
if(this.checked) checkedString += $(this).val()+',';
}
});
checkedString = checkedString.substr(0,checkedString.lastIndexOf(','));
$('#checked-obj').val(checkedString);

}
function checkAll() {
var checked_status = $("input[name=allgroup]:checked").length;
var checkedString = '';
$("input[type=checkbox]").each(function(){
if($(this).hasClass('myCheckbox')){
this.checked = checked_status;
if(checked_status) checkedString += $(this).val()+',';
}
});
$("span[acaica=myCheckbox]").each(function(){
if(checked_status)
this.style.backgroundPosition = "0 -50px";
else this.style.backgroundPosition = "0 0";
});
$('#checked-obj').val(checkedString.substr(0,checkedString.lastIndexOf(',')));
}
function deleteAllGroup(){
jConfirm(
'{$vsLang->getWords("contact_deleteContactConfirm","Are you sure to delete this contact information?")}', 
'{$bw->vars['global_websitename']} Dialog', 
function(r){
if(r){
var flag="true"; var jsonStr = "";
$("input[type=checkbox]").each(function(){
if($(this).hasClass('myCheckbox')){
if(this.checked){
flag="false";
jsonStr += this.value + ',';
}
}
});
$("input[class=ck_group]").each(function(){
if(this.checked){
flag="false";
jsonStr += this.value + ',';
}
});

jsonStr = jsonStr.substr(0,jsonStr.lastIndexOf(','));

if(flag=="true"){
jAlert(
"{$vsLang->getWords('contact_deleteAllConfirm_NoItem', 'You have not choose any items!')}",
"{$bw->vars['global_websitename']} Dialog"
);
return false;
}
if(jsonStr)
vsf.get('admins/deletegroups/'+jsonStr+'/','grouptable');
}

}
);
}
</script>
</div>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_5246b29e8a0af($grouplist="",$message="")
{
global $vsLang,$bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach( $grouplist as $key => $group )
    {
        $vsf_class = $vsf_count%2?'odd':'even';$count++;
if($count%2)
               $class='old';
               else $class= 'even';
    $BWHTML .= <<<EOF
        
     
<tr class="{$class}">
<td>
<input type="checkbox" onclicktext="checkObject({$group->getId()});" onclick="checkObject({$group->getId()});" name="obj_group{$group->getId()}" value="{$group->getId()}" class="myCheckbox" />
</td>
    <td>{$group->getId()}</td>
    <td>
    <a title="{$vsLang->getWords('global_a_title_edit',"Edit this")}" href="javascript:;" onclick="javascript:vsf.get('admins/editgroup/{$group->getId()}/','groupform'); return false;">
               {$group->getName()}
               </a>
               </td>
    <td>{$group->getIntro()}</td>
   
</tr>
   

EOF;
$vsf_count++;
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:AddEditGroupForm:desc::trigger:>
//===========================================================================
function AddEditGroupForm($form=array(),$group="",$message="") {global $bw, $vsLang;
$BWHTML = "";
//--starthtml--//



//--starthtml--//
$BWHTML .= <<<EOF
        <script type="text/javascript">
$('#addeditgroup').submit(function() {
if(!$('#groupName').val()) {
alert('{$vsLang->getWords('err_group_name_blank','Please enter the group name!')}');
$('#groupName').addClass('ui-state-error ui-corner-all-inner');
$('#groupName').focus();
return false;
}
vsf.submitForm($(this),'admins/addeditgroup/','groupform');
vsf.get('admins/displaygrouptable/','grouptable');
});
</script>
<div class="ui-accordion ui-helper-reset">
<h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-top">
    <span class="ui-icon ui-icon-triangle-1-e"></span><a href="#">{$form['title']}</a>
    </h3>
    <div style="color:red">{$message}</div>
<form id="addeditgroup">
<input type="hidden" name="formType" value="{$form['type']}" />
<input type="hidden" name="groupId" value="{$group->getId()}" />
    <table cellpadding="0" cellspacing="1" width="100%">
    <tr>
        <th>{$vsLang->getWords('group_header_name','Group name')}</th>
            <td><input id="groupName" type="text" name="groupName" value="{$group->getName()}" autocomplate="0" /></td>
</tr>
        <tr>
        <th>{$vsLang->getWords('group_header_description','Description')}</th>
            <td><textarea rows="7" name="groupIntro">{$group->getIntro()}</textarea></td>
</tr>
        <tr>
        <th>&nbsp;</th>
        <td align="center">
            <button class="ui-state-default ui-corner-all" type="submit">{$form['submit']}</button></td>
</tr>
</table>
</form>
</div>
EOF;
//--endhtml--//
return $BWHTML;
}


}?>