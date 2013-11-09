<?php
class skin_home{

//===========================================================================
// <vsf:showDefault:desc::trigger:>
//===========================================================================
function showDefault($option="") {global $bw, $vsTemplate, $vsLang, $vsPrint, $vsSettings;
$lang = $_SESSION['user']['language']['currentLang']['langFolder'];

//--starthtml--//
$BWHTML .= <<<EOF
        <div id="bodyLowerSection">
{$this->__foreach_loop__id_527ceeb6bbecd($option)}

<div class="container">
<div class="accordion" id="accordion2">
<div class="accordion-group">
<div class="accordion-heading">
<h4>
<a class="accordion-toggle collapsed" data-toggle="collapse"
data-parent="#accordion2" href="#collapseOne"> 
{$option['about']->getTitle()}
</a>
</h4>
</div>
<div id="collapseOne" class="accordion-body collapse" style="height: 0px;">
<div class="accordion-inner">
{$option['about']->getContent()}
</div>
</div>
</div>
</div>
<h5 class="cntr" id='working_time'>
{$vsSettings->getSystemKey("config_open_time", 'Opening time:  Monday-Thrusday 5:30 to 11:00, Friday - Saturday  5:00 to 11:00 & Sunday 5:30 to 10:30', 'config')}
</h5>
</div>
</div>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_527ceeb6bbaec($option="",$key='',$category='')
{
;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach(  $option['item'][$key] as $item  )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<div class="span4 simpleCart_shelfItem">
<div class="well well-small">
<div class="displayImg">
{$item->createImageCache($item->getImage(), 187, 150, 0, 1)}
</div>
<h3 class="price">
<span class="item_price" title='{$item->getTitle()}'>{$item->getTitle()}</span>
<span class="item_price" title='{$item->getTitle()}'>{$item->getPrice()}</span>
</h3>
</div>
</div>

EOF;
$vsf_count++;
    }
    return $BWHTML;
}


//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_527ceeb6bbecd($option="")
{
global $bw, $vsTemplate, $vsLang, $vsPrint, $vsSettings;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach(  $option['category'] as $key => $category  )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        

EOF;
if( $option['item'][$key] ) {
$BWHTML .= <<<EOF

<div class="container">
<section class="menu-list">
<div class="box">
<h4 class='notice-title'>
<span>
<img class="noodle-icon" src='{$bw->vars['img_url']}/noodle.png' alt='{$category->getTitle()}' />
</span>
{$category->getTitle()}
</h4>
</div>
<div class="row">
{$this->__foreach_loop__id_527ceeb6bbaec($option,$key,$category)}
</div>
</section>
</div>

EOF;
}

$BWHTML .= <<<EOF


EOF;
$vsf_count++;
    }
    return $BWHTML;
}


}?>