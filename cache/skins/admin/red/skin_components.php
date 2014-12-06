<?php
class skin_components{

//===========================================================================
// <vsf:mainCom:desc::trigger:>
//===========================================================================
function mainCom() {
//--starthtml--//
$BWHTML .= <<<EOF
        <div class="ui-tabs ui-widget ui-widget-content ui-corner-all-top">
<div id="comCurrent" class="right-cell"><!--COM LIST--></div>
<div id="comForm" class="left-cell"><!--COM FORM--></div>
<div class="clear"></div>
</div>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:uninstallLink:desc::trigger:>
//===========================================================================
function uninstallLink($com="") {
//--starthtml--//
$BWHTML .= <<<EOF
        <a href="javascript:vsf.get('components/un_install/un/{$com->getComId()}/','comCurrent');" Title="Uninstall">Uninstall</a>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:installLink:desc::trigger:>
//===========================================================================
function installLink($com="") {
//--starthtml--//
$BWHTML .= <<<EOF
        <a href="javascript:vsf.get('components/un_install/in/{$com->getComId()}/','comCurrent');" Title="Install">Install</a>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:comListHTML:desc::trigger:>
//===========================================================================
function comListHTML($com="",$message="") {$vsLang = VSFactory::getLangs();

//--starthtml--//
$BWHTML .= <<<EOF
        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all">
<div >
<span class="ui-icon ui-icon-triangle-1-e"></span>
<span class="ui-dialog-title">{$vsLang->getWords('component_list','Current Component')}</span>
</div>
<div class="error">{$message}</div>
<table cellspacing="1" cellpadding="0" width="100%">
<thead>
<tr>
<th>{$vsLang->getWords('component_name','Component name')}</th>
<th>{$vsLang->getWords('component_package','Package')}</th>
<th>{$vsLang->getWords('component_option','Options')}</th>
</tr>
</thead>
$com
</table>
</div>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:addComList:desc::trigger:>
//===========================================================================
function addComList($com="",$format_class="",$install="") {global $bw;
$vsLang = VSFactory::getLangs();

//--starthtml--//
$BWHTML .= <<<EOF
        <tr class="$format_class">
<td>{$com->getComName()}
<div class="desctext">{$com->getComDescription()}</div>
</td>
<td>{$com->getComPackage()}</td>
<td>
<a class="ui-state-default ui-corner-all ui-state-focus" href="javascript:vsf.get('components/editComponent/{$com->getComId()}/','comForm')" title='{$vsLang->getWords('newsItem_EditObjTitle',"Click here to edit this {$bw->input[0]}")}'>{$vsLang->getWords('global_edit','Sửa')}</a>
{$install}
</tr>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:addEditForm:desc::trigger:>
//===========================================================================
function addEditForm($com=array(),$form="") {$vsLang = VSFactory::getLangs();

//--starthtml--//
$BWHTML .= <<<EOF
        <form action="javascript:vsf.submitForm($('#addmodule'),'components/addEditComponent','comCurrent'); javascript:vsf.get('components/addComponent/','comForm');" method="post" name="form" id="addmodule">
<input type="hidden" name="comId" value="" />
<div class="ui-dialog ui-widget ui-widget-content ui-corner-all vs-lbox">
    <div >
        <span class="ui-icon ui-icon-triangle-1-e"></span><span class="ui-dialog-title">{$form['title']}</span>
    </div>
    <table cellpadding="0" cellspacing="1" width="100%">
    <thead>
        <tr>
            <th>{$vsLang->getWords('component_name_form','Name')}</th>
                <td><input id="input" type="text" value="" name="comName" size="30" /></td>
            </tr>
            <tr>
            <th>{$vsLang->getWords('component_package','Package')}</th>
            <td><input class="input" type="text" value="{$com->getComPackage()}" name="comPackage" size="30" /></td>
            </tr>
            <tr>
            <th>{$vsLang->getWords('component_Description','Description')}</th>
                <td><textarea cols="25" rows="5" name="comDescription">{$com->getComDescription()}</textarea></td>
            </tr>
            <tr>
            <th>&nbsp;</th>
            <td>{$form['switchform']} <button class="ui-state-default ui-corner-all" type="submit">{$form['submit']}</button></td>
            </tr>
        </thead>
    </table>
</div>
</form>
EOF;
//--endhtml--//
return $BWHTML;
}


}
?>