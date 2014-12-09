<?php
if(!class_exists('skin_board_public'))
require_once ('./cache/skins/user/finance/skin_board_public.php');
class skin_objectpublic extends skin_board_public {

//===========================================================================
// <vsf:showDefault:desc::trigger:>
//===========================================================================
function showDefault($option=array()) {global $bw;

//--starthtml--//
$BWHTML .= <<<EOF
        
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:loadTour:desc::trigger:>
//===========================================================================
function loadTour($option=array()) {global $bw;

//--starthtml--//
$BWHTML .= <<<EOF
        {$this->__foreach_loop__id_5483138d3bc3a0_40907735($option)}
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_5483138d3bc3a0_40907735($option=array())
{
global $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option)){
    foreach( $option as $key=>$value )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
    <div class="tourtop_item">
    <div class="im"><a href="{$value->getUrl($value->getModule())}">{$value->createImageCache($value->getImage(),260,178)}</a></div>
        <div class="tour_ct">
                <div class="left">
                    <h2 class="na"><a href="{$value->getUrl($value->getModule())}">{$value->getTitle()}</a></h2>
                    <div class="num">{$value->getNumber()}</div>
                    <div class="intro">{$value->getIntro()}</div>
                </div>
                <div class="right">
                    <div class="star">{$value->getStar()}</div>
                    <div class="price">{$value->getPrice()}</div>
                    <div class="time">Ngày/đêm</div>
                    <a href="{$bw->base_url}bookings/tour/{$value->getId()}" class="booking_color bookTour">Đặt tour</a>
                </div>
        </div>
    </div>
    
EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:loadTourDefault:desc::trigger:>
//===========================================================================
function loadTourDefault($option=array()) {global $bw;

//--starthtml--//
$BWHTML .= <<<EOF
        {$this->__foreach_loop__id_5483138d3bf761_36884044($option)}
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_5483138d3bf761_36884044($option=array())
{
global $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option)){
    foreach( $option as $key=>$value )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
     <div class="tour_item">
        <div class="im"><a href="{$value->getUrl($value->getModule())}">{$value->createImageCache($value->getImage(),260,178)}</a></div>    
            <div class="ser">
            <div class="na"><a href="{$value->getUrl($value->getModule())}">{$value->getTitle()}</a></div>
                <div class="phone">ĐT: {$value->getPhone()}</div>
<div class="ser_item">
                {$value->getOptionIcon()}
                </div>
                <div class="clear"></div>
                <div class="note"></div>
                <ul>{$value->getIntro()}</ul>
            </div> 
            <div class="booking">
            <div class="line"></div>
            <div class="star">{$value->getStar()}</div>
                <div class="price">{$value->getPrice()}</div>
                <div class="time">Ngày/đêm</div>
                <a href="{$bw->base_url}bookings/tour/{$value->getId()}"  class="booking_color bookTour">Đặt tour</a>
            </div>      
        </div>
        
    
EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}


}
?>