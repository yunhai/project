<?php
class skin_gallery{

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
        {$this->__foreach_loop__id_524aa3e04f09d($option)}
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
function __foreach_loop__id_524aa3e04f09d($option=array())
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
            {$obj->createImageCache($obj->file, 200, 125)}
            </a>
            
EOF;
}

$BWHTML .= <<<EOF

                <h3><a href="{$obj->getUrl($bw->input[0])}" title='{$obj->getTitle()}'>{$obj->getTitle()}</a></h3>
                <p>{$obj->getContent(500)}</p>
                <p class="news_date">{$vsLang->getWords('posttime','Ngày đăng')} {$obj->getPostDate('SHORT')}</p>
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
        <script src='{$bw->vars['board_url']}/skins/user/finance/css/highslide/highslide-full.js'></script>
<script type="text/javascript">
hs.graphicsDir = '{$bw->vars['board_url']}/skins/user/finance/css/highslide/graphics/';
hs.align = 'center';
hs.transitions = ['expand', 'crossfade'];
hs.outlineType = 'rounded-white';
hs.fadeInOut = true;
hs.dimmingOpacity = 0.75;
// define the restraining box
hs.useBox = true;
hs.width = 640;
hs.height = 480;
// Add the controlbar
hs.addSlideshow({
//slideshowGroup: 'group1',
interval: 5000,
repeat: false,
useControls: true,
fixedControls: 'fit',
overlayOptions: {
opacity: 1,
position: 'bottom center',
hideOnMouseOut: true
}
});
</script>
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
<div class='gallery'>
{$this->__foreach_loop__id_524aa3e04f86d($obj,$option)}
<div class='clear'></div>
</div>
        
        
EOF;
if( $option['other'] ) {
$BWHTML .= <<<EOF

        <div class="other">
        <h3>{$vsLang->getWords($bw->input[0].'_others', 'Bài viết khác')}</h3>
        {$this->__foreach_loop__id_524aa3e050043($obj,$option)}
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
function __foreach_loop__id_524aa3e04f86d($obj="",$option=array())
{
global $bw, $vsLang;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach(  $option['gallery'] as $item  )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<div class='gallery-item'>
<a href="{$item->getPathView()}" class="highslide" onclick="return hs.expand(this, {autoplay:true});" title="{$obj->getTitle()}" >
{$item->createImageCache($item, 200, 150, 1)}
</a>
</div>

EOF;
$vsf_count++;
    }
    return $BWHTML;
}


//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_524aa3e050043($obj="",$option=array())
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