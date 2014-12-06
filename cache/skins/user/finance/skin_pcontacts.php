<?php
if(!class_exists('skin_objectpublic'))
require_once ('./cache/skins/user/finance/skin_objectpublic.php');
class skin_pcontacts extends skin_objectpublic {

//===========================================================================
// <vsf:showDefault:desc::trigger:>
//===========================================================================
function showDefault($obj="",$option=array()) {global $bw;
//echo 123; exit();
$vsLang = VSFactory::getLangs();
//echo "<pre>";
//print_r($obj);
//echo "</pre>";
//exit();

//--starthtml--//
$BWHTML .= <<<EOF
        <!--maps-->
        <div class="maps">
           <div style="width:100%; height: 392px;" class="map" id="map_canvas"></div>
        </div>
        <!--end maps-->
        <!--content-->
        <div class="container">
            <div class="row">
                <div class="wrapper">
                    <div class="content">
                        <div class="navigaters">
                            {$option['breakcrum']}
                        </div>
                        <div class="rowfull">
                            <div class="col-md-6 col-sm-6 col-xs-12 padding_left sm_padding">
                                <div class="wrapper_content">
                                   
                                    <div class="bgContact">
                                        {$this->getContactForm($option)}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="wrapper_content">
                                    <h5 class="contact_title">{$obj->getTitle()}</h5>
                                    <div class="contact_address">
                                        <p>{$obj->getContent()}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--end content-->
                        
                        
                        
   <script>

EOF;
if($option['error']) {
$BWHTML .= <<<EOF

alert('{$option['error']}');

EOF;
}

$BWHTML .= <<<EOF


function init() {
                                               
    var myHtml = "<h4>{$obj->getTitle()}</h4><p>{$obj->getAddress()}</p>";
                                                
      var map = new google.maps.Map(
      document.getElementById("map_canvas"),
      {scaleControl: true}
      );
      map.setCenter(new google.maps.LatLng({$obj->getLatitude()},{$obj->getLongitude()}));
      map.setZoom({$obj->getZoom()});
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
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:getContactForm:desc::trigger:>
//===========================================================================
function getContactForm($option=array()) {global $bw;

$vsLang = VSFactory::getLangs();
$this->vsLang=VSFactory::getLangs();

//--starthtml--//
$BWHTML .= <<<EOF
        <form class="" action="" method="POST" role="form">
<div class="form_cont">
<div class="form-group">
<label for="" class=" control-label">{$this->getLang()->getWords('title')} <span style="color: #e51925">*</span>:</label>
<div class="">
<input  required type="name" name="title"  value="{$option['obj']->getTitle()}" class="form-control" id="name" placeholder="{$this->getLang()->getWords('title')}">
</div>
</div>
<div class="form-group">
<label for="inputEmail3" class=" control-label">Email <span style="color: #e51925">*</span>:</label>
<div class="">
<input name="email"  required type="email" value="{$option['obj']->getEmail()}" class="form-control" id="Email" placeholder="Email">
</div>
</div>
<div class="form-group">
<label for="" class=" control-label">{$this->getLang()->getWords('content')} <span style="color: #e51925">*</span>:</label>
<div class="">
<textarea name="content" class="form-control" rows="3" placeholder="{$this->getLang()->getWords('content')}">{$option['obj']->getContent()}</textarea>
</div>
</div>
<div id="serc" class="col-sm-12 col-md-7 form-group padding_left">
<div class="col-sm-6 padding_left sm_padding">
<input type="text" name="sec_code" placeholder="{$this->getLang()->getWords('capcha')}" class="form-control">
</div>
<div class="col-sm-6 bgwhite">
<img id="siimage" src="{$bw->vars['board_url']}/vscaptcha/">
<a href="#" id="reload_img" class="mamoi">{$this->getLang()->getWords('refresh')}</a>
</div>
</div>
<input name="btnSubmit" class="btn btn-danger" type="submit" value="GỬI NGAY">
<input type="reset" class="btn btn-danger" value="LÀM LẠI">


</div>
</form>




                         
                         <script>
                            $("#reload_img").click(function(){
                            $("#siimage").attr("src",$("#siimage").attr("src")+"?a");
                            return false;
                            
});
</script>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:sendContactSuccess:desc::trigger:>
//===========================================================================
function sendContactSuccess($obj="",$option=array()) {global $bw;
$vsLang = VSFactory::getLangs();
$this->vsLang=VSFactory::getLangs();

//--starthtml--//
$BWHTML .= <<<EOF
        <!--content-->
        <div class="container">
            <div class="row">
                <div class="wrapper">
                    <div class="content">
                        <div class="navigaters">
                            {$option['breakcrum']}
                        </div>
                        <div class="rowfull">
                             <p class="thanks">{$this->getLang()->getWords('thanks_you_booking')}</p>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--end content-->




<script type='text/javascript'>
setTimeout('delayers()', 5000);
function delayers(){
window.location = "{$bw->base_url}";
}
</script>
EOF;
//--endhtml--//
return $BWHTML;
}


}
?>