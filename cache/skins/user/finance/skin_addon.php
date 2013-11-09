<?php
class skin_addon{

//===========================================================================
// <vsf:topmenu:desc::trigger:>
//===========================================================================
function topmenu($option=array(),$index=1) {global $bw, $vsLang, $vsTemplate;

//--starthtml--//
$BWHTML .= <<<EOF
        <ul class="nav pull-right menu_top{$vsLang->currentLang->getFoldername()}">
{$this->__foreach_loop__id_527ceeb6bd252($option,$index)}
</ul>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_527ceeb6bd252($option=array(),$index=1)
{
global $bw, $vsLang, $vsTemplate;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach( $option as $obj )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        

EOF;
if( $obj->top ) {
$BWHTML .= <<<EOF

<li>
<a href="{$obj->getUrl(0)}" title="{$obj->getTitle()}"

EOF;
if( $obj->getClassActive('active') ) {
$BWHTML .= <<<EOF

style="padding: 0 14px;">
<span class="btn btn-warning">{$obj->getTitle()}</span>

EOF;
}

else {
$BWHTML .= <<<EOF

>
{$obj->getTitle()}

EOF;
}
$BWHTML .= <<<EOF

</a>
</li>

EOF;
}

$BWHTML .= <<<EOF


EOF;
$vsf_count++;
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:bottomenu:desc::trigger:>
//===========================================================================
function bottomenu($option=array()) {global $bw, $vsLang, $vsTemplate;
$this->index = 0;

//--starthtml--//
$BWHTML .= <<<EOF
        <div id="footerMenu">
{$this->__foreach_loop__id_527ceeb6bd626($option)}
</div>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_527ceeb6bd626($option=array())
{
global $bw, $vsLang, $vsTemplate;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach(  $option as $menu  )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        

EOF;
if( $menu->bottom ) {
$BWHTML .= <<<EOF

<a href="{$menu->getUrl(0)}" title='{$menu->getTitle()}'>{$menu->getTitle()}</a>

EOF;
if($this->index++ < 3) {
$BWHTML .= <<<EOF

&nbsp;|&nbsp;

EOF;
}

$BWHTML .= <<<EOF


EOF;
}

$BWHTML .= <<<EOF


EOF;
$vsf_count++;
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:portlet_branch:desc::trigger:>
//===========================================================================
function portlet_branch($option=array()) {global $bw, $vsLang;

//--starthtml--//
$BWHTML .= <<<EOF
        <div class="branch_portlet" >
<div class="branch_portlet_title">
{$vsLang->getWords('global_branch_list','Danh sách chi nhánh')}
</div>
<div class="branch_list">
{$this->__foreach_loop__id_527ceeb6bda0e($option)}
</div>
</div>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_527ceeb6bda0e($option=array())
{
global $bw, $vsLang;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach(  $option as $obj  )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<div class='branch-item'>
<span class="branch-title">{$obj->getTitle()}</span>
{$obj->getIntro()}
</div>

EOF;
$vsf_count++;
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:portlet_recruitment:desc::trigger:>
//===========================================================================
function portlet_recruitment($option=array()) {global $bw, $vsLang;

//--starthtml--//
$BWHTML .= <<<EOF
        <div class="sitebar_tuyendung">
        <h3 class="center_title">
        <a href="{$bw->base_url}recruitment" title="{$vsLang->getWords('global_recruitment','Tuyển dụng')}">
{$vsLang->getWords('global_recruitment','Tuyển dụng')}
</a>
</h3>
{$this->__foreach_loop__id_527ceeb6bddf7($option)}
        </div>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_527ceeb6bddf7($option=array())
{
global $bw, $vsLang;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach( $option as $obj )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<div class="tuyendung_item">
            <a href="{$obj->getUrl('recruitment')}" title='{$obj->getTitle()}'>{$obj->getTitle()}</a>
                <p class='datetime'>[{$obj->getPostDate("SHORT")}]</p>
                {$obj->getContent()}
            </div>

EOF;
$vsf_count++;
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:portlet_promote:desc::trigger:>
//===========================================================================
function portlet_promote($option=array()) {global $bw, $vsLang;

//--starthtml--//
$BWHTML .= <<<EOF
        <div id="postCodeInner">

EOF;
if( count($option) ) {
$BWHTML .= <<<EOF

<span class="btn horizontal_scroller-title">
<img src='{$bw->vars['img_url']}/store.png' style="height: 30px"/>
{$vsLang->getWords('global_promote', 'Khuyến mãi')}
</span>
<div style="float: left;">&nbsp;</div>
<div>
<ul id="ticker01">
{$this->__foreach_loop__id_527ceeb6be1de($option)}
</ul>
</div>

EOF;
}

else {
$BWHTML .= <<<EOF

<span style='height: 30px;display:block;'>&nbsp;
</span>

EOF;
}
$BWHTML .= <<<EOF

<div class="clear"></div>
</div>
<div class='clear'></div>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_527ceeb6be1de($option=array())
{
global $bw, $vsLang;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach( $option as $obj )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<li>
<a href="{$obj->getUrl('promote')}" title='{$obj->getTitle()}'>
[{$obj->getPostDate('SHORT')}] {$obj->getTitle()}
</a>
</li>

EOF;
$vsf_count++;
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:portlet_slideshow:desc::trigger:>
//===========================================================================
function portlet_slideshow($option=array()) {global $bw, $vsLang;

//--starthtml--//
$BWHTML .= <<<EOF
        <ol class="carousel-indicators">
{$this->__foreach_loop__id_527ceeb6be5d8($option)}
</ol>
<div class="carousel-inner">
{$this->__foreach_loop__id_527ceeb6be9ae($option)}   
</div>
<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
  <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_527ceeb6be5d8($option=array())
{
global $bw, $vsLang;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach(  $option as $k => $obj  )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
                <li data-target="#myCarousel" data-slide-to="{$k}" class="active"></li>

EOF;
$vsf_count++;
    }
    return $BWHTML;
}


//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_527ceeb6be9ae($option=array())
{
global $bw, $vsLang;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach(  $option as $k => $obj  )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
                <div class="item 
EOF;
if( $k == 0 ) {
$BWHTML .= <<<EOF
active
EOF;
}

$BWHTML .= <<<EOF
">
<p>
{$obj->createImageCache($obj->file, 1170, 500)}
</p>
</div>          
             
EOF;
$vsf_count++;
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:portlet_map:desc::trigger:>
//===========================================================================
function portlet_map($branches="",$main="") {global $bw, $vsLang;
$this->index = 1;
$this->total = count($branches);

//--starthtml--//
$BWHTML .= <<<EOF
        <div class="span5 well">
<h3 class="center_title detail_title">
        <a href="{$bw->base_url}contacts#contact-main-content" title='{$vsLang->getWords("contacts_title", $bw->input[0])}'>
{$vsLang->getWords("contacts_map_title", 'Bản đồ')}
</a>
</h3>
<div id="contact-map-list">
{$this->__foreach_loop__id_527ceeb6bed97($branches,$main)}
                <div class='clear'></div>
           </div>
           
        <div class="map">
           <div id='map_canvas'></div> 
</div>
</div>

EOF;
if( $main ) {
$BWHTML .= <<<EOF

    
EOF;
if( $main->getLongitude() && $main->getLatitude() ) {
$BWHTML .= <<<EOF

    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true&language=vi"></script>
    <script  type="text/javascript">
    //key=AIzaSyD2heuHJ0KdL8IPCyE3OYQrARjSjCeVGMI&
    function init() {
    var myHtml = "<h4>{$main->getTitle()}</h4><p>{$main->getAddress()}</p>";
    
      var map = new google.maps.Map(
      document.getElementById("map_canvas"),
      {scaleControl: true}
      );
      map.setCenter(new google.maps.LatLng({$main->getLatitude()},{$main->getLongitude()}));
      map.setZoom(15);
      map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
      var marker = new google.maps.Marker({
      map: map,
      position:map.getCenter()
});
var infowindow = new google.maps.InfoWindow({
'pixelOffset': new google.maps.Size(0,15)
});
      infowindow.setContent(myHtml);
      infowindow.open(map, marker);
    }
      
      
    $(document).ready(function(){
init();
});
</script>

EOF;
}

$BWHTML .= <<<EOF


EOF;
}

$BWHTML .= <<<EOF

EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_527ceeb6bed97($branches="",$main="")
{
global $bw, $vsLang;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach(  $branches as $obj  )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
           <a class="{$obj->active}" href="{$bw->base_url}contacts/{$obj->getCleanTitle()}-{$obj->getId()}#contact-main-content" title='{$obj->getTitle()}'>
{$obj->getTitle()}
</a>

EOF;
if( $this->index++ < $this->total ) {
$BWHTML .= <<<EOF

 |

EOF;
}

$BWHTML .= <<<EOF

                
EOF;
$vsf_count++;
    }
    return $BWHTML;
}


}?>