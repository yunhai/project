<?php
class skin_objectpublic{

//===========================================================================
// <vsf:showDefault:desc::trigger:>
//===========================================================================
function showDefault($option=array()) {global $bw, $vsLang;

//--starthtml--//
$BWHTML .= <<<EOF
        <div id="center">
        <h3 class="center_title">
        <a href="{$bw->base_url}{$bw->input[0]}" title='{$vsLang->getWords($bw->input[0]."_title", $bw->input[0])}'>
{$vsLang->getWords($bw->input[0]."_title", $bw->input[0])}
</a>
</h3>
        <div class="center_group">
        {$this->__foreach_loop__id_524aa3d484b58($option)}
        </div>
        <div class='paging'>
        {$option['paging']}
        </div>
    </div>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_524aa3d484b58($option=array())
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
        
EOF;
if( $obj->file ) {
$BWHTML .= <<<EOF

            <a href="{$obj->getUrl($bw->input[0])}" class="width_img" title='{$obj->getTitle()}'>
            {$obj->createImageCache($obj->file, 200, 125, 1)}
            </a>
            
EOF;
}

$BWHTML .= <<<EOF

                <h3><a href="{$obj->getUrl($bw->input[0])}" title='{$obj->getTitle()}'>{$obj->getTitle()}</a></h3>
                <p>{$obj->getContent(500)}</p>
                <div class="clear_left"></div>
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
        <div id="center">
        <h3 class="center_title detail_title">
        <a href="{$bw->base_url}{$bw->input[0]}" title='{$vsLang->getWords($bw->input[0]."_title", $bw->input[0])}'>
{$vsLang->getWords($bw->input[0]."_title", $bw->input[0])}
</a>
</h3>
<div class="detail"> 
        <h1 class='title'>{$obj->getTitle()}</h1>
{$obj->getContent()}
</div>
        
        
EOF;
if( $option['other'] ) {
$BWHTML .= <<<EOF

        <div class="other">
        <h3>{$vsLang->getWords($bw->input[0].'_others', 'Bài viết khác')}</h3>
        {$this->__foreach_loop__id_524aa3d485327($obj,$option)}
        </div>
        
EOF;
}

$BWHTML .= <<<EOF

</div>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_524aa3d485327($obj="",$option=array())
{
global $bw, $vsLang;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach(  $option['other'] as $item  )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
            <a href="{$item->getUrl($bw->input[0])}" title="{$item->getTitle()}">{$item->getTitle()}</a>
            
EOF;
$vsf_count++;
    }
    return $BWHTML;
}


}?>