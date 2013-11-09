<?php
if(!class_exists('skin_objectadmin'))
require_once ('./cache/skins/admin/red/skin_objectadmin.php');
class skin_pages extends skin_objectadmin {

//===========================================================================
// <vsf:displayVirtualTab:desc::trigger:>
//===========================================================================
function displayVirtualTab($option=array()) {global $vsLang, $bw;


//--starthtml--//
$BWHTML .= <<<EOF
        <div id='virtualTabContainer'>
<div class="left-cell">
<div class="ui-dialog ui-widget ui-widget-content ui-corner-all">
<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
<span class="ui-icon ui-icon-triangle-1-e"></span>
<span class="ui-dialog-title">{$vsLang->getWords('pages_virtual_module_title_header','Virtual Module')}</span>
</div>

<div id="virtualForm">{$option['form']}</div>
</div>
</div>
<div class='right-cell' id="mainPageContainer">
{$option['list']}
</div>
<div class="clear"></div>
</div>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:displayVirtualItemContainer:desc::trigger:>
//===========================================================================
function displayVirtualItemContainer($virtualList=array(),$option=array()) {global $vsLang, $bw;
$message = $vsLang->getWords('pages_deleteConfirm_NoItem', "You haven't choose any items!");



//--starthtml--//
$BWHTML .= <<<EOF
        <input type='hidden' id="checked-obj1" value=""/>
<div class='ui-dialog ui-widget ui-widget-content ui-corner-all'>
    <div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
        <span class="ui-icon ui-icon-triangle-1-e"></span>
        <span class="ui-dialog-title">
{$vsLang->getWords('virtual_list','List of Virtual Module')}
</span>

        <p class="closeObj">
        <span id="deleteVirtual">Delete</span>
        </p>
    </div>
<table cellspacing="1" cellpadding="1" id='productListTable' width="100%">
<thead>
    <tr>
        <th width="15"><input type="checkbox" onclick="vsf.checkAll('myCheckbox1','checked-obj1')" onclicktext="vsf.checkAll('myCheckbox1','checked-obj1')" name="all" /></th>
        <th >{$vsLang->getWords('pages_virtual_labelStatus', 'Tên module')}</td>
                                                <th >{$vsLang->getWords('pages_virtual_Parent', 'Parent')}</td>
    </tr>
</thead>
<tbody>

EOF;
if( count($virtualList) > 0) {
$BWHTML .= <<<EOF

{$this->__foreach_loop__id_51e0f7e30225a($virtualList,$option)}

EOF;
}

$BWHTML .= <<<EOF

</tbody>
</table>
</div>
<script type='text/javascript'>
$('#deleteVirtual').click(function(){
                                if(vsf.checkValue('checked-obj1'))
jConfirm(
'{$vsLang->getWords("delete_virtual_confirm","Are you sure to delete these information?")}',
'{$bw->vars['global_websitename']} Dialog',
function(r){
if(r){
jsonStr = $('#checked-obj1').val();
vsf.get('pages/deleteVirtual/'+jsonStr+'/', 'virtualTabContainer');
}
}
);
});

</script>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_51e0f7e30225a($virtualList=array(),$option=array())
{
global $vsLang, $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach( $virtualList as $virtual )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<tr>
<td align="center" width="15">
<input type="checkbox" onclicktext="vsf.checkObject('myCheckbox1','checked-obj1');" onclick="vsf.checkObject('myCheckbox1','checked-obj1');" name="obj_{$virtual->getId()}" value="{$virtual->getId()}" class="myCheckbox1" />
</td>
<td>
<a href="javascript:vsf.get('pages/virtualForm/{$virtual->getId()}','virtualForm')" title='{$vsLang->getWords('edit_virtual_module_title','Click here to edit')}' class="editObj">
<strong>{$virtual->getTitle()} ({$virtual->getClass()})</strong>
</a>
<br />
<div class="desctext">{$virtual->getIntro()}</div>
</td>
                                                                <td>
{$virtual->getParent()}
</td>
</tr>

EOF;
$vsf_count++;
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:virtualForm:desc::trigger:>
//===========================================================================
function virtualForm($module="",$option='') {global $vsLang;


//--starthtml--//
$BWHTML .= <<<EOF
        <form id="editVirtualForm" method="post">
    <input class="input" type="hidden" value="{$module->getId()}" name="moduleId" />
    <input class="input" type="hidden" value="{$module->getTitle()}" name="oldModuleTitle" />
<table cellpadding="0" cellspacing="1" width="100%">
    <tr>
        <th>{$vsLang->getWords('module_list_name','Title')}</th>
            <td><input id="moduleTitle" type="text" value="{$module->getTitle()}" name="moduleTitle" /></td>
        </tr>
        <tr>
        <th>{$vsLang->getWords('module_list_desc','Intro')}</th>
            <td><textarea cols="18" rows="5" name="moduleIntro">{$module->getIntro()}</textarea></td>
        </tr>
                                        <tr>
        <th>{$vsLang->getWords('module_list_pr','Parent')}</th>
            <td>
            <select name="moduleParent" id="moduleParent">
                                                    <option value="pages">Pages </option>
                                                    <option value="partners">Partners </option>
                                                    <option value="pcontacts">P Contact </option>
                                                    <option value="advisorys">Advisorys </option>
                                                    <option value="gallerys">Gallerys </option>
                                                    <option value="products">Products </option>
                                                </select>
            </td>
        </tr>
        <tr>
        <th>{$vsLang->getWords('module_list_use','Base')}</th>
            <td>
            {$vsLang->getWords('module_list_use_admin','Admin')}
            <input type="checkbox" name="moduleIsAdmin" id="moduleIsAdmin" value="1" />

            {$vsLang->getWords('module_list_use_user','User')}
            <input type="checkbox" name="moduleIsUser" id="moduleIsUser" value="1" />
            </td>
        </tr>
        <tr>
        <th>&nbsp;</th>
            <td>
            <button class="ui-state-default ui-corner-all" type="submit">
            {$option['submitValue']}
            </button>
            </td>
        </tr>
    </table>
</form>

<div id="result"></div>
<script type="text/javascript">
$(window).ready(function() {
vsf.jCheckbox('{$module->getAdmin()}','moduleIsAdmin');
vsf.jCheckbox('{$module->getUser()}','moduleIsUser');
                                        vsf.jSelect('{$module->getParent()}','moduleParent');
});
$('#editVirtualForm').submit(function(){
if(!$('#moduleTitle').val()){
jAlert(
        '{$vsLang->getWords('page_virtualModule_empty','This field can not be empty!')}',
        '{$bw->vars['global_websitename']} Dialog'
        );
        $('#moduleTitle').focus();
$('#moduleTitle').addClass('ui-state-error ui-corner-all-inner');
        return false;
}
        vsf.submitForm($('#editVirtualForm'),'pages/editVirtual/', 'virtualTabContainer');
        return false;
});
</script>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:managerObjHtml:desc::trigger:>
//===========================================================================
function managerObjHtml() {global $bw, $vsLang,$vsSettings,$langObject;

//--starthtml--//
$BWHTML .= <<<EOF
        <div id="page_tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all-top">
<ul id="tabs_nav" class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-corner-all-inner">
                                
EOF;
if($bw->input['module'] == 'pages' ) {
$BWHTML .= <<<EOF

                                    <li class="ui-state-default ui-corner-top">
                                            <a href="{$bw->base_url}pages/displayVirtualTab/&ajax=1">
                                                    <span>{$langObject['tabVirtualModule']}</span>
                                            </a>
                                    </li>
        
EOF;
}

$BWHTML .= <<<EOF

    <li class="ui-state-default ui-corner-top">
        <a href="{$bw->base_url}{$bw->input[0]}/display-obj-tab/&ajax=1"><span>{$vsLang->getWords("tab_obj_objes_{$bw->input[0]}","{$bw->input[0]}")}</span></a>
        </li>
                                
EOF;
if($vsSettings->getSystemKey($bw->input[0].'_category_tab',0, "{$bw->input[0]}", 1, 1)) {
$BWHTML .= <<<EOF

                                        <li class="ui-state-default ui-corner-top">
                                        <a href="{$bw->base_url}menus/display-category-tab/{$bw->input[0]}/&ajax=1">
                                        <span>{$langObject['categoriesTitle']}</span></a>
                                </li>
        
EOF;
}

$BWHTML .= <<<EOF

       
                                   <!--     <li class="ui-state-default ui-corner-top">
                                        <a href="{$bw->base_url}menus/display-category-tab/picon/&ajax=1">
                                        <span>picon</span></a>
                                </li> -->
      
        
EOF;
if($vsSettings->getSystemKey($bw->input[0].'_setting_tab',0, "{$bw->input[0]}", 1, 1)) {
$BWHTML .= <<<EOF

        <li class="ui-state-default ui-corner-top">
        <a href="{$bw->base_url}settings/moduleObjTab/{$bw->input[0]}/&ajax=1">
<span>Settings</span>
</a>
        </li>
        
EOF;
}

$BWHTML .= <<<EOF

</ul>
</div>
EOF;
//--endhtml--//
return $BWHTML;
}


}?>