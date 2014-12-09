<?php
if(!class_exists('skins_board'))
require_once ('./cache/skins/admin/red/skins_board.php');
class skin_skins extends skins_board {

//===========================================================================
// <vsf:skinList:desc::trigger:>
//===========================================================================
function skinList($option=array()) {global $vsLang, $bw;

//--starthtml--//
$BWHTML .= <<<EOF
        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all">
<div >
<span class="ui-icon ui-icon-triangle-1-e"></span>
<span class="ui-dialog-title">{$vsLang->getWords('skin_list','Current skin')}</span>
</div>
<div class="error">{$message}</div>
<table cellspacing="1" cellpadding="0" width="100%">
<thead>
<tr>
<th>{$vsLang->getWords('skin_list_id','Id')}</th>
<th>{$vsLang->getWords('skin_list_name','Skin name')}</th>
<th>{$vsLang->getWords('skin_list_author','Author')}</th>
<th>{$vsLang->getWords('skin_list_for','Use for')}</th>
<th>{$vsLang->getWords('skin_list_folder','Folder')}</th>
<th>{$vsLang->getWords('skin_list_action','Action')}</th>
</tr>
</thead>

EOF;
if(count($option['pageList'])&&is_array($option['pageList'])) {
$BWHTML .= <<<EOF

{$this->__foreach_loop__id_5483ca9860f513_18341874($option)}

EOF;
}

$BWHTML .= <<<EOF

</table>
{$option['paging']}
</div>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_5483ca9860f513_18341874($option=array())
{
global $vsLang, $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['pageList'])){
    foreach( $option['pageList'] as $obj )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<tr class="{$class}">
<td>{$obj->getId()}</td>
<td>{$obj->getTitle()}</td>
<td>{$obj->getAuthorName()}</td>
<td>{$obj->getIsAdmin('text')}</td>
<td>{$obj->getFolder()}</td>
<td>
<a class="ui-state-default ui-corner-all ui-state-focus" href="javascript:vsf.get('skins/edit-obj/{$obj->getId()}/','skin-form')" title='{$vsLang->getWords('newsItem_EditObjTitle',"Click here to edit this {$bw->input[0]}")}'>{$vsLang->getWords('global_edit','Sửa')}</a>
</td>
</tr>

EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:addEditObjForm:desc::trigger:>
//===========================================================================
function addEditObjForm($obj=null,$form=array()) {global $vsLang;

//--starthtml--//
$BWHTML .= <<<EOF
        <form method="post" id="add-obj-form">
<input type="hidden" name="skinId" value="{$obj->getId()}" />
<div class="ui-dialog ui-widget ui-widget-content ui-corner-all vs-lbox">
    <div >
        <span class="ui-icon ui-icon-triangle-1-e"></span><span class="ui-dialog-title">{$form['formTitle']}</span>
    </div>
    <div class="red">{$form['message']}</div>
    <table cellpadding="0" cellspacing="1" width="100%">
    <thead>
    
EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_title',1)) {
$BWHTML .= <<<EOF

        <tr>
            <th>{$vsLang->getWords('skin_form_name','Skin name')}</th>
                <td><input id="input" type="text" value="{$obj->getTitle()}" name="skinTitle" size="26" /></td>
            </tr>
            
EOF;
}

$BWHTML .= <<<EOF

            
EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_author_name',1)) {
$BWHTML .= <<<EOF

            <tr>
            <th>{$vsLang->getWords('skin_form_author','Author')}</th>
            <td><input class="input" type="text" value="{$obj->getAuthorName()}" name="skinAuthorName" size="26" /></td>
            </tr>
            
EOF;
}

$BWHTML .= <<<EOF

            
EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_author_email',1)) {
$BWHTML .= <<<EOF

            <tr>
            <th>{$vsLang->getWords('skin_form_author_email','Author email')}</th>
            <td><input class="input" type="text" value="{$obj->getAuthorEmail()}" name="skinAuthorEmail" size="26" /></td>
            </tr>
            
EOF;
}

$BWHTML .= <<<EOF

            
EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_author_website',1)) {
$BWHTML .= <<<EOF

            <tr>
            <th>{$vsLang->getWords('skin_form_author_url','Author url')}</th>
            <td><input class="input" type="text" value="{$obj->getAuthorWebsite()}" name="skinAuthorWebsite" size="26" /></td>
            </tr>
            
EOF;
}

$BWHTML .= <<<EOF

            
EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_folder',1)) {
$BWHTML .= <<<EOF

            <tr>
            <th>{$vsLang->getWords('skin_form_folder','Folder')}</th>
                <td><input class="input" type="text" value="{$obj->getFolder()}" name="skinFolder" size="26" /></td>
            </tr>
            
EOF;
}

$BWHTML .= <<<EOF

            
EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_admin',1)) {
$BWHTML .= <<<EOF

            <tr>
            <th>{$vsLang->getWords('skin_form_use_for','Use For')}</th>
                <td>
                <input class="input" type="radio" value="1" name="skinIsAdmin" /> Admin 
                <input class="input" type="radio" value="0" name="skinIsAdmin" /> User
                </td>
            </tr>
            
EOF;
}

$BWHTML .= <<<EOF

            
EOF;
if($this->getSettings()->getSystemKey($bw->input[0].'_default',1)) {
$BWHTML .= <<<EOF

             <tr>
            <th>{$vsLang->getWords('skin_form_default','Default')}</th>
                <td><input class="input" type="checkbox" value="1" name="skinDefault" id="skinDefault" /></td>
            </tr>
            
EOF;
}

$BWHTML .= <<<EOF

            <tr>
            <th>&nbsp;</th>
            <td>
EOF;
if($obj->getId()) {
$BWHTML .= <<<EOF

            <button id="switch-bt" class="ui-state-default ui-corner-all">{$vsLang->getWords('skin_form_switch',"Switch to add form")}</button>
            
EOF;
}

$BWHTML .= <<<EOF

            <button id="add-edit-bt" class="ui-state-default ui-corner-all">{$form['formSubmit']}</button>
            </td>
            </tr>
        </thead>
    </table>
</div>
</form>
<script type="text/javascript">
$(document).ready(function() {
vsf.jCheckbox('{$obj->getDefault()}','skinDefault');
vsf.jRadio('{$obj->getIsAdmin()}','skinIsAdmin');
$('#add-edit-bt').click(function() {
vsf.submitForm($('#add-obj-form'),'skins/add-edit-obj/','skin-list');
vsf.get('skins/add-obj/','skin-form');
});
});
</script>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:MainPage:desc::trigger:>
//===========================================================================
function MainPage($objform="",$objlist="") {
//--starthtml--//
$BWHTML .= <<<EOF
        <div class="ui-tabs ui-widget ui-widget-content ui-corner-all-top">
<div id="skin-form" class="left-cell">{$objform}</div>
<div id="skin-list" class="right-cell">{$objlist}</div>
<div class="clear"></div>
</div>
EOF;
//--endhtml--//
return $BWHTML;
}


}
?>