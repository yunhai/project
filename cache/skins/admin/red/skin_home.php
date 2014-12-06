<?php
if(!class_exists('skin_objectadmin'))
require_once ('./cache/skins/admin/red/skin_objectadmin.php');
class skin_home extends skin_objectadmin {

//===========================================================================
// <vsf:loadDefault:desc::trigger:>
//===========================================================================
function loadDefault($option=array()) {global $bw;

//--starthtml--//
$BWHTML .= <<<EOF
        mặc định
EOF;
//--endhtml--//
return $BWHTML;
}


}
?>