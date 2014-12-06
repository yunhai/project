<?php
if(!class_exists('skin_board_public'))
require_once ('./cache/skins/user/finance/skin_board_public.php');
class skin_addon extends skin_board_public {

//===========================================================================
// <vsf:getMenuTop:desc::trigger:>
//===========================================================================
function getMenuTop($option=array(),$id="") {global $bw,$vsLang;
$this->bw = $bw;
$this->vsLang = VSFactory::getLangs();
$total = count($_SESSION['vs_item_cart']);

//print_r($option['services']);exit();
$module=array('projects','recruitments');
if($bw->input[0]=='home'){
$active="active";
}
$lang=$_SESSION['user']['language']['vsfcurrentLang'];
$option['resumes']=Object::getObjModule('pages', 'resumes', '>0', '1', ' 1');
$option['introduce']=Object::getObjModule('pages', 'introduce', '>0', '1', '1 ');
$option['cate_projects']=VSFactory::getMenus()->getCategoryGroup('projects')->getChildren();


//--starthtml--//
$BWHTML .= <<<EOF
        <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                  <li 
EOF;
if($bw->input[0]=='home') {
$BWHTML .= <<<EOF
class="active "
EOF;
}

$BWHTML .= <<<EOF
><a href="{$bw->base_url}" >{$this->vsLang->getWords("home","Trang chủ")}</a></li>                
                  {$this->__foreach_loop__id_547dd9578e2442_88955421($option,$id)}                      
                    
                    <li class="dropdown language">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{$lang['name']} <i class="icon-angle-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="{$bw->vars['board_url']}/en">English</a></li>
                            <li><a href="{$bw->vars['board_url']}">Tiếng Việt</a></li>
                            <li><a href="{$bw->vars['board_url']}/cn">繁體中文</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547dd9578e11d8_94175879($option=array(),$id="",$mn='')
{
;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['cate_projects'])){
    foreach( $option['cate_projects'] as $value  )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
                            <li><a href="{$value->getCatUrl()}"><span>{$value->getTitle()}</span></a></li>
                            
EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}


//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547dd9578e2442_88955421($option=array(),$id="")
{
global $bw,$vsLang;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['menu'])){
    foreach( $option['menu'] as $mn  )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
                  
EOF;
if($mn->getUrl() =='projects'  ) {
$BWHTML .= <<<EOF

                   
                  <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{$mn->getTitle()} <i class="icon-angle-down"></i></a>

EOF;
if($mn->getUrl()=='projects') {
$BWHTML .= <<<EOF

                        <ul class="dropdown-menu">
                            {$this->__foreach_loop__id_547dd9578e11d8_94175879($option,$id,$mn)}                            
                        </ul>
                        
EOF;
}

$BWHTML .= <<<EOF

                        
EOF;
if($mn->getUrl()=='recruitments') {
$BWHTML .= <<<EOF

                        <ul class="dropdown-menu">
                            <li><a href="{$bw->base_url}introduce">{$option['introduce']->getTitle()}</a></li>
                            <li><a href="{$bw->base_url}recruitments">{$this->vsLang->getWords("recruitments_info","Thông tin Tuyển dụng")}</a></li>        
                             <li><a href="{$bw->base_url}resumes">{$option['resumes']->getTitle()}</a></li>                    
                        </ul>
                        
EOF;
}

$BWHTML .= <<<EOF

                        
                    </li>
                    
                  
EOF;
}

else {
$BWHTML .= <<<EOF

                  
                    <li class="{$mn->active} {$mn->getUrl()}" ><a href="{$this->bw->base_url}{$mn->getUrl()}" title="" >{$mn->getTitle()}</a></li>
                  
EOF;
}
$BWHTML .= <<<EOF

                  
EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:getMenuBottom:desc::trigger:>
//===========================================================================
function getMenuBottom($option=array()) {global $bw,$vsLang;
$this->bw = $bw;
$vsLang = VSFactory::getLangs();

//--starthtml--//
$BWHTML .= <<<EOF
        <ul class="pull-right">
                                          <li 
EOF;
if($bw->input[0]=='home') {
$BWHTML .= <<<EOF
class="active "
EOF;
}

$BWHTML .= <<<EOF
><a 
EOF;
if($bw->input[0]=='home') {
$BWHTML .= <<<EOF
class="active "
EOF;
}

$BWHTML .= <<<EOF
  href="{$bw->base_url}" >{$this->vsLang->getWords("home","Trang chủ")}</a></li>                
                       {$this->__foreach_loop__id_547dd9578e7796_09982959($option)}
                        
                        <li><a id="gototop" class="gototop" href="#"><i class="icon-chevron-up"></i></a></li><!--#gototop-->
                    </ul>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547dd9578e7796_09982959($option=array())
{
global $bw,$vsLang;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['menu'])){
    foreach( $option['menu'] as $mn  )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<li class="{$mn->active}" ><a href="{$this->bw->base_url}{$mn->getUrl()}" title="" class="{$mn->active} ">{$mn->getTitle()}</a></li>
   
EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:getAnalytic:desc::trigger:>
//===========================================================================
function getAnalytic($option=array()) {global $bw;
$this->vsLang = VSFactory::getLangs();


//--starthtml--//
$BWHTML .= <<<EOF
        <p>Đang truy cập: <span style="color: #666666">{$option['online']}</span>  |  Tổng truy cập: <span style="color: #666666">{$option['total']}</span></p>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:getContact:desc::trigger:>
//===========================================================================
function getContact($option=array()) {//print  "<pre>";
//print_r ($option['obj']);
//print  "<pre>";
//exit();
global $bw,$vsPrint;
$vsLang = VSFactory::getLangs();
$this->vsLang = VSFactory::getLangs();
$lang=$_SESSION['user']['language']['vsfcurrentLang']['code'];
$vsPrint->addExternalJavaScriptFile("http://maps.google.com/maps/api/js?sensor=true&language={$lang}",1);

//--starthtml--//
$BWHTML .= <<<EOF
        
EOF;
if($option['obj']) {
$BWHTML .= <<<EOF

      
                                
                               <section id="bottom" class="wet-asphalt">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h4>{$this->vsLang->getWords("address_footer","Address")}</h4>
                    <p>{$option['obj']->getContent()}</p>
                </div><!--/.col-sm-3-->
                
                <div class="col-sm-5">
                    <h4>{$this->vsLang->getWords("contact_form_footer","Contact Form")}</h4>
                    <form id="main-contact-form" class="contact-form" name="contact-form" method="post" action="" role="form">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input name="email_contacts" id="email_contacts" type="text" class="form-control" required="required" placeholder="{$this->vsLang->getWords("email_address","Email address")}">
                                </div>
                                <div class="form-group">
                                    <input name="name_contacts" id="full_name_contacts" type="text" class="form-control" required="required" placeholder="{$this->vsLang->getWords("full_name","Full Name")}">
                                </div>
                                <div class="form-group">
                                    <textarea name="message_contacts" id="message_contacts" required="required" class="form-control" rows="3" placeholder="{$this->vsLang->getWords("message_contacts","Message")}"></textarea>
                                </div>
                                <div class="form-group">
                                    <button id="submit_form_mail" type="button" class="btn btn-primary btn-lg">{$this->vsLang->getWords("send_message","Send Message")}</button>
                                </div>
                            </div>
                        </div>
                        
                    </form>
                </div><!--/.col-sm-8-->
                <div class="col-sm-4">
                    <h4>{$this->vsLang->getWords("our_location_footer","Our Location")}</h4>
                    <div style="width:100%; height: 215px;" class="map" id="map_canvas"></div>
                    
                </div><!--/.col-sm-4-->
            </div>
        </div>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">{$this->vsLang->getWords("warrning","Thông Báo")}</h4>
<hr/>
      </div>
      <div class="modal-body">
        <div id="return"></div>
      </div>
      
    </div>
  </div>
</div>
<script type="text/javascript">
$("#submit_form_mail").click(function(){
$('#myModal').modal({
  backdrop: true
});
var x = document.forms["contact-form"]["email_contacts"].value;
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        document.getElementById("return").innerHTML = '<p style="font-size: 17px; color: rgb(255, 0, 0); font-family: arial;">{$this->vsLang->getWords("Mmail_error","Vui lòng điền email chính xác")}</p>';
        return false;
    }
if($("#full_name_contacts").val().length<1){
return false;
}
 var message_contacts = document.getElementById("message_contacts").value;
 if(message_contacts.length<1){
document.getElementById("return").innerHTML = '<p style="font-size: 17px; color: rgb(255, 0, 0); font-family: arial;">{$this->vsLang->getWords("error_mess","Please enter Message!!!")}</p>';
return false;
}
var email = document.forms["contact-form"]["email_contacts"].value;
    var name = document.getElementById("full_name_contacts").value;
var content = document.getElementById("message_contacts").value;
$.ajax({
type:'POST',
url: baseUrl+'pages/sendcontacts',
data:'ajax=1&json=1&name_contacts='+name+'&email_contacts='+email+'&message_contacts='+content+'',
success: function(data) {
//$('#return').html(data);
}
});
document.getElementById("return").innerHTML = '<p style="font-size: 17px; color: rgb(255, 0, 0); font-family: arial;">{$this->vsLang->getWords("mess_oki","Gởi Nội dung liên hệ thành công!!")}</p>';
document.getElementById('main-contact-form').reset();
});
</script>  
                     
        
    </section><!--/#bottom-->
      <script>

function init() {
                                               
    var myHtml = "<h4 class='map_intro'>{$option['obj']->getTitle()}</h4><!---<p class='map_intro'>{$option['obj']->getAddress()}</p>--->";
                                                
      var map = new google.maps.Map(
      document.getElementById("map_canvas"),
      {scaleControl: true}
      );
      map.setCenter(new google.maps.LatLng({$option['obj']->getLatitude()},{$option['obj']->getLongitude()}));
      map.setZoom({$option['obj']->getZoom()});
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
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:getAbouts:desc::trigger:>
//===========================================================================
function getAbouts($option=array()) {
global $bw;

//--starthtml--//
$BWHTML .= <<<EOF
        
EOF;
if($bw->input[0]!='home') {
$BWHTML .= <<<EOF

      <div class="wt_content">
                                <div class="intelegan_in">
                                    <div class="footer_title">
                                        <h5>nội thất thông minh</h5>
                                    </div>
                                    <div class="footer_info">
                                        <ul class="media-list">
                                        {$this->__foreach_loop__id_547dd9578f12d3_30171212($option)}
                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
     
EOF;
}

else {
$BWHTML .= <<<EOF

     <div class="wt_content intro_footer">
                                <div class="footer_title">
                                    <h5>giới thiệu</h5>
                                </div>
                                <div class="footer_info">
                                    <p>{$this->cut($option['abouts']?$option['abouts']->getIntro():"",600)}</p>
                                </div>
                            </div>
     
EOF;
}
$BWHTML .= <<<EOF

EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547dd9578f12d3_30171212($option=array())
{

global $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['news'])){
    foreach( $option['news'] as $value )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
                                            <li class="media">
                                             <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 padding_f">
                                                <a class="pull-left" href="{$value->getUrl($value->getModule())}" title="">
                                                    <img style="width: 100%; class="media-object" src="{$value->getCacheImagePathByFile($value->getImage(),1,1,1,1)}" alt="">
                                                </a>
                                                </div>
                                                <div class="media-body media_fo">
                                                    <a href="{$value->getUrl($value->getModule())}" title="">
                                                        <h4 class="media-head-fo">{$value->getTitle()}</h4>
                                                    </a>
                                                    <p>{$this->cut($value->getIntro(), 100)}</p>
                                                </div>
                                                <div class="clear"></div>
                                            </li>
                                            
EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:getSupports:desc::trigger:>
//===========================================================================
function getSupports($option=array()) {global $bw;
//echo "<pre>";
//print_r($option);
//echo "</pre>";
//exit();
$this->url=$bw->vars['img_url'];

//--starthtml--//
$BWHTML .= <<<EOF
        <div class="">
{$this->__foreach_loop__id_547dd9578f45b8_59028791($option)}
    
                                        
</div>
<div class="">
{$this->__foreach_loop__id_547dd9578f5ab5_55446666($option)}
    
                                        
</div>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547dd9578f45b8_59028791($option=array())
{
global $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['support'])){
    foreach( $option['support'] as $value )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        

EOF;
if($value->getSkype()) {
$BWHTML .= <<<EOF

<a href="skype:{$value->getSkype()}?chat">
    <img src="{$this->url}/skype.png" />
</a>

EOF;
}

$BWHTML .= <<<EOF


EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}


//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547dd9578f5ab5_55446666($option=array())
{
global $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['support'])){
    foreach( $option['support'] as $value )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        

EOF;
if($value->getYahoo()) {
$BWHTML .= <<<EOF

<a href="ymsgr:sendIM?{$value->getYahoo()}">
    <img src="{$this->url}/yahoo.png" />
</a>

EOF;
}

$BWHTML .= <<<EOF


EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:getAdvLeft:desc::trigger:>
//===========================================================================
function getAdvLeft($option=array()) {global $bw;
$this->vsLang = VSFactory::getLangs();


//--starthtml--//
$BWHTML .= <<<EOF
        <div class="advertise">
       {$this->__foreach_loop__id_547dd9578f8825_61673264($option)}
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547dd9578f8825_61673264($option=array())
{
global $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['advleft'])){
    foreach( $option['advleft'] as $value )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
                                        <a target=" _blank" href="{$value->getWebsite()}">
                                            <img src="{$value->getCacheImagePathByFile($value->getImage(),1,1,1,1)}" alt="" />
                                        </a>
                                
EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:getWeblinks:desc::trigger:>
//===========================================================================
function getWeblinks($option=array()) {global $bw;

//--starthtml--//
$BWHTML .= <<<EOF
        
EOF;
if($option['weblinks']) {
$BWHTML .= <<<EOF

       
<select id="link" class="form-control" style="margin-top: 20px;">
<option value="0">{$this->getLang()->getWords('weblinks')}</option>
{$this->__foreach_loop__id_547dd9578fa8f1_37420743($option)}
</select>
<script language="javascript" type="text/javascript">
       $("#link").change(function(){
                               if($("#link").val())
                                    window.open($("#link").val(),"_blank");
                            });    
</script> 

<div class="clear"></div>
        
EOF;
}

$BWHTML .= <<<EOF

EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547dd9578fa8f1_37420743($option=array())
{
global $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['weblinks'])){
    foreach( $option['weblinks'] as $value )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<option value="{$value->getWebsite()}"> {$value->getTitle()}</option>

EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:getBannerTop:desc::trigger:>
//===========================================================================
function getBannerTop($option=array()) {global $bw;


//--starthtml--//
$BWHTML .= <<<EOF
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <!-- Indicators -->
                            <ol class="carousel-indicators dote_banner">
                            {$this->__foreach_loop__id_547dd9578fce43_03928080($option)}
                                
                            </ol>
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner img_banner">
                            {$this->__foreach_loop__id_547dd9578fd9c3_64996399($option)}
                
            </div>
            
                            <!-- Controls -->
                            
EOF;
if($option['banner']) {
$BWHTML .= <<<EOF

<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
<span class="glyphicon glyphicon-chevron-left"></span>
</a>
<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
<span class="glyphicon glyphicon-chevron-right"></span>
</a>
                            
EOF;
}

$BWHTML .= <<<EOF

                        </div>    
                        <script type="text/javascript">
$(document).ready(function() {
$('.dote_banner > li:first-child').addClass("active");
$('.img_banner > div:first-child').addClass("active");
});
</script>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547dd9578fce43_03928080($option=array())
{
global $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['banner'])){
    foreach( $option['banner'] as $value )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<li data-target="#carousel-example-generic" data-slide-to="{$this->numberFormat($vsf_count-1)}" class=""></li>

EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}


//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547dd9578fd9c3_64996399($option=array())
{
global $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['banner'])){
    foreach( $option['banner'] as $value )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
                <div class="item  ">
                    <img src="{$value->getCacheImagePathByFile($value->getImage(),1,1,1,1)}" alt="{$value->getTitle()}">
                    <div class="carousel-caption">
                        <div class="text_caption">
                            <h2 class="title_caption">{$value->getTitle()}</h2>
                            <p style="width: 600px; margin-bottom: 20px;" class="descrip_caption ">{$this->cut($value->getintro(), 250)}</p>
                            
                            <div class="clear"></div>
                            <a href="{$value->getWebsite()}"><button type="submit" class="btn btn-info read_caption">Xem chi tiết</button></a>
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
// <vsf:getBannerBottom:desc::trigger:>
//===========================================================================
function getBannerBottom($option=array()) {global $bw;
$i=1;
foreach( $option['banner'] as $value ){
if($i%2==0){
$value->class="padding_right";
}
else{
$value->class="padding_left";
}
$i++;
}

//--starthtml--//
$BWHTML .= <<<EOF
        
EOF;
if($option['banner']) {
$BWHTML .= <<<EOF

        {$this->__foreach_loop__id_547dd9578ffcf0_99730513($option)}
                        
        
EOF;
}

$BWHTML .= <<<EOF

EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547dd9578ffcf0_99730513($option=array())
{
global $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['banner'])){
    foreach( $option['banner'] as $value )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 {$value->class}">
                            <div class="ad_img1">
                                <a target =" _blank" href="{$value->getWebsite()}"><button type="button" class="btn_ad_view_banner">Xem chi tiết</button></a>
                                
                                    <img src="{$value->getCacheImagePathByFile($value->getImage(),1,1,1,1)}" alt="{$value->getTitle()}">
                               
                            </div>
                        </div>
                        
EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:getTag:desc::trigger:>
//===========================================================================
function getTag($option=array(),$module="") {global $bw;

//--starthtml--//
$BWHTML .= <<<EOF
        
EOF;
if($option['list']) {
$BWHTML .= <<<EOF

<div class="tag_interior">
<div class="bootstrap-tagsinput">
<div class="tag_title">
<span class="bg_tag"></span>
<h6>Tags &nbsp; </h6>
</div>
<div class="tag_cotent">
{$this->__foreach_loop__id_547dd9579020b1_08066970($option,$module)}
   
</div>
</div>
</div>

EOF;
}

$BWHTML .= <<<EOF

EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547dd9579020b1_08066970($option=array(),$module="")
{
global $bw;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['list'])){
    foreach( $option['list'] as $value )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
   <a  class="tag_a 
EOF;
if($_SESSION['active']['tag']==$value->getId()) {
$BWHTML .= <<<EOF
active
EOF;
}

$BWHTML .= <<<EOF
 {$_SESSION['active']['tag']}" href="{$bw->input['base_url']}/{$module}/tags/{$value->getSlugId()}" title=""> <span class="tag label label-info ">{$value->getTitle()}</span></a>

EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}


}
?>