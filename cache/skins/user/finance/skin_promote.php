<?php
class skin_promote{

//===========================================================================
// <vsf:showDefault:desc::trigger:>
//===========================================================================
function showDefault($option=array()) {global $bw, $vsLang;

//--starthtml--//
$BWHTML .= <<<EOF
        <div class='row'>
<div class="span6 well">
        <h3 class="center_title">
        <span>
<img class="noodle-icon" src='{$bw->vars['img_url']}/noodle.png' alt='icon' />
</span>
        <a href="#" title='{$vsLang->getWords($bw->input[0]."_title", $bw->input[0])}'>
{$vsLang->getWords($bw->input[0]."_title", $bw->input[0])}
</a>
</h3>
        <div class="center_group">
        {$this->__foreach_loop__id_527bc19a12680($option)}
        </div>
        <div class='paging'>
        {$option['paging']}
        </div>
        </div>
        
    <!-- CONTACT MAPS -->    
        </div>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_527bc19a12680($option=array())
{
global $bw, $vsLang;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach(  $option['pageList'] as $obj  )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
        <div class="item">
        <h3><a href="#" title='{$obj->getTitle()}'>{$obj->getTitle()}</a></h3>
        
EOF;
if( $obj->file ) {
$BWHTML .= <<<EOF

            <a href="#" class="promote_image" title='{$obj->getTitle()}'>
            {$obj->createImageCache($obj->file, 200, 200, 0)}
            </a>
            
EOF;
}

$BWHTML .= <<<EOF

                <p>{$obj->getContent(500)}</p>
                <div class="clear"></div>
            </div>
            
EOF;
$vsf_count++;
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:showDetail:desc::trigger:>
//===========================================================================
function showDetail($obj="",$option=array()) {global $bw, $vsLang;

//--starthtml--//
$BWHTML .= <<<EOF
        <div class='row'>
<div class="span6 well">
        <h3 class="center_title">
        <span>
<img class="noodle-icon" src='{$bw->vars['img_url']}/noodle.png' alt='icon' />
</span>
        <a href="#" title='{$vsLang->getWords($bw->input[0]."_title", $bw->input[0])}'>
{$obj->getTitle()}
</a>
</h3>
        <div class="detail"> 
{$obj->getContent()}
</div>
        
        
EOF;
if( $option['other'] ) {
$BWHTML .= <<<EOF

        <div class="other">
        <h4>{$vsLang->getWords($bw->input[0].'_others', 'Bài viết khác')}</h4>
        {$this->__foreach_loop__id_527bc19a12a6d($obj,$option)}
        </div>
        
EOF;
}

$BWHTML .= <<<EOF

        </div>
    <!-- CONTACT MAPS -->        
        </div>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_527bc19a12a6d($obj="",$option=array())
{
global $bw, $vsLang;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach(  $option['other'] as $item  )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
            <a href="{$item->getUrl($bw->input[0])}" title="{$item->getTitle()}">
            <i class='icon-heart'></i>
            {$item->getTitle()}
            </a>
            
EOF;
$vsf_count++;
    }
    return $BWHTML;
}


}?>