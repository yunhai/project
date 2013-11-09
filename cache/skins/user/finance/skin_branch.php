<?php
class skin_branch{

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
        {$this->__foreach_loop__id_509e51fef0d4d($option)}
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
function __foreach_loop__id_509e51fef0d4d($option=array())
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
            <a href="{$obj->getUrl($bw->input[0])}" class="news_img" title='{$obj->getTitle()}'>
            {$obj->createImageCache($obj->file, 118, 109)}
            </a>
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

        <div class="map">
        <span class='map-title'>{$vsLang->getWords('map','Bản đồ')}</span>
           <div id='map_canvas'></div> 
</div>


        
EOF;
if( $option['other'] ) {
$BWHTML .= <<<EOF

        <div class="other">
        <h3>{$vsLang->getWords($bw->input[0].'_others', 'Bài viết khác')}</h3>
        {$this->__foreach_loop__id_509e51fef151c($obj,$option)}
        </div>
        
EOF;
}

$BWHTML .= <<<EOF

        <div id='hidden' style='display: none !important;'>{$obj->getIntro()}</div>
</div>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true&language=vi"></script>
    <script  type="text/javascript">
    function init() {
    var myHtml = "<h4>{$obj->getTitle()}</h4>"+$('#hidden').html();
                                                

      var map = new google.maps.Map(
      document.getElementById("map_canvas"),
      {scaleControl: true}
      );
      map.setCenter(new google.maps.LatLng({$obj->getLatitude()},{$obj->getLongitude()}));
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
console.log($('#hidden').html());
});
</script>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_509e51fef151c($obj="",$option=array())
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