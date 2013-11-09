<?php
class skin_addon{

//===========================================================================
// <vsf:topmenu:desc::trigger:>
//===========================================================================
function topmenu($option=array(),$index=1) {global $bw, $vsLang, $vsTemplate;
$this->menu_sub = $vsTemplate->global_template->menu_sub;

//--starthtml--//
$BWHTML .= <<<EOF
        <ul class="menu_top menu_top{$vsLang->currentLang->getFoldername()}">
                    {$this->__foreach_loop__id_524ab88744713($option,$index)}
                    <div class="clear_left"></div>
</ul>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_524ab88744713($option=array(),$index=1)
{
global $bw, $vsLang, $vsTemplate;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach( $option as $obj )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
                        <li>
                        <a href="{$obj->getUrl(0)}" title="{$obj->getTitle()}" class="{$obj->getClassActive('active')}">
                        {$obj->getTitle()}
                        </a>
                            
EOF;
if($vsTemplate->global_template->menu_sub[$obj->getUrl()] || $obj->getChildren()) {
$BWHTML .= <<<EOF

                                <ul >
                                    {$obj->getChildrenLi()}
                                </ul>
                            
EOF;
}

$BWHTML .= <<<EOF

                        </li>
                    
EOF;
$vsf_count++;
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:bottomenu:desc::trigger:>
//===========================================================================
function bottomenu($option=array()) {global $bw, $vsLang, $vsTemplate;

//--starthtml--//
$BWHTML .= <<<EOF
        <ul class="menu footer_menu">
       {$this->__foreach_loop__id_524ab88744ee3($option)}
        <div class="clear_left"></div>
     </ul>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_524ab88744ee3($option=array())
{
global $bw, $vsLang, $vsTemplate;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach( $option as $obj )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
        <li><a href="{$obj->getUrl(0)}" class="{$obj->getClassActive()}" title="{$obj->getTitle()}"><span>{$obj->getTitle()}</span></a></li>
      
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
        <div id="slide_face">
         <div class="images">
         {$this->__foreach_loop__id_524ab887456b3($option)}   
         </div>
         <!-- the tabs -->
                       
         <div class="slidetabs">
         {$this->__foreach_loop__id_524ab88745e83($option)}
        </div>
     <script type='text/javascript'>
             $(function() {
                  $(".slidetabs").tabs(".images > div.slide_item", {
                         effect: 'fade',
                         fadeOutSpeed: "slow",
                         rotate: true,
                         auto:true
                  }).slideshow();
                  $(".slidetabs").data("slideshow").play();
             });
     </script>
   </div>
   <!-- STOP SLIDE -->
   
EOF;
if( $bw->input['module'] == 'home' ) {
$BWHTML .= <<<EOF

   <div class="shadow_bottom"><img src="{$bw->vars['img_url']}/shadow.png" /></div>
   
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
function __foreach_loop__id_524ab887456b3($option=array())
{
global $bw, $vsLang;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach(  $option as $obj  )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
                <div class="slide_item" title='{$obj->getTitle()}'>
                {$obj->createImageCache($obj->file, 716, 305)}
                </div>          
             
EOF;
$vsf_count++;
    }
    return $BWHTML;
}


//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_524ab88745e83($option=array())
{
global $bw, $vsLang;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach(  $option as $obj  )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
                <a href="#" title='{$obj->getTitle()}'></a> 

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
{$this->__foreach_loop__id_524ab88746653($option)}
        </div>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_524ab88746653($option=array())
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
        <div class="sitebar_tuyendung">
        <h3 class="center_title">
        <a href="{$bw->base_url}promote" title="{$vsLang->getWords('global_promote','Khuyến mãi')}">
{$vsLang->getWords('global_promote','Khuyến mãi')}
</a>
</h3>
{$this->__foreach_loop__id_524ab88746e24($option)}
<div class='clear'></div>
        </div>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_524ab88746e24($option=array())
{
global $bw, $vsLang;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach( $option as $obj )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<div class="promote_item">

EOF;
if( $obj->file ) {
$BWHTML .= <<<EOF

            <a href="{$obj->getUrl('promote')}" class="" title='{$obj->getTitle()}'>
            {$obj->createImageCache($obj->file, 120, 120)}
            </a>
            
EOF;
}

$BWHTML .= <<<EOF

            <a href="{$obj->getUrl('promote')}" title='{$obj->getTitle()}' class="promote">{$obj->getTitle()}</a>
                <p>[{$obj->getPostDate("SHORT")}]</p>
                <div class='clear'></div>
            </div>

EOF;
$vsf_count++;
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:portlet_partner:desc::trigger:>
//===========================================================================
function portlet_partner($option=array()) {global $bw, $vsLang;

//--starthtml--//
$BWHTML .= <<<EOF
        <div class="sitebar_quangcao">
{$this->__foreach_loop__id_524ab887475f3($option)}
            </div>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_524ab887475f3($option=array())
{
global $bw, $vsLang;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach(  $option as $obj  )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
<a href="{$obj->getWebsite()}" class="quangcao" title='{$obj->getTitle()}'>
{$obj->createImageCache($obj->file, 306, '')}
</a>

EOF;
$vsf_count++;
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:portlet_supports:desc::trigger:>
//===========================================================================
function portlet_supports($option=array()) {global $bw, $vsLang, $vsSettings;

//--starthtml--//
$BWHTML .= <<<EOF
        <div class="support">
            <p class="hotline">{$vsLang->getWords('global_support', 'Hỗ trợ')}:</p>
            {$this->__foreach_loop__id_524ab88748592($option)}
<div class="link_mangxahoi">
<p>{$vsLang->getWords('global_follow_us','Theo chúng tôi tại')}:</p>
        <a href="{$vsSettings->getSystemKey("config_facebook", 'http://www.facebook.com', 'config')}" target='_blank'>
        <img src="{$bw->vars['img_url']}/face.png" />
        </a>
        <a href="{$vsSettings->getSystemKey("config_twitter", 'http://www.twitter.com', 'config')}" target='_blank'>
        <img src="{$bw->vars['img_url']}/tweet.png" />
        </a>
        <a href="{$vsSettings->getSystemKey("config_google_plus", 'https://plus.google.com/u/0/', 'config')}" target='_blank'>
        <img src="{$bw->vars['img_url']}/google.png" /></a>
        </div>
        </div>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_524ab88747dc3($option=array(),$k='',$v='')
{
;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach(  $v as $key =>$obj )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
{$obj->showAdvance()}

EOF;
$vsf_count++;
    }
    return $BWHTML;
}


//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_524ab88748592($option=array())
{
global $bw, $vsLang, $vsSettings;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach( $option as $k => $v )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
{$this->__foreach_loop__id_524ab88747dc3($option,$k,$v)}

EOF;
$vsf_count++;
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:portlet_about:desc::trigger:>
//===========================================================================
function portlet_about($obj=null) {
$lang = $_SESSION['user']['language']['currentLang']['langFolder'];

//--starthtml--//
$BWHTML .= <<<EOF
        <div class="about_home about_home_{$lang}">
    <span class="about_home_title">{$obj->getTitle()}</span>
        <p>{$obj->getIntro()}</p>
    </div>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:portlet_productcategory:desc::trigger:>
//===========================================================================
function portlet_productcategory($option="") {global $bw, $vsLang;

//--starthtml--//
$BWHTML .= <<<EOF
        
EOF;
if( $option ) {
$BWHTML .= <<<EOF

<h3 class="sitebar_title">{$vsLang->getWords('global_productcategory', 'Danh mục sản phẩm')}</h3>
<div class="product_list">
<ul id='menu'>
{$option}
</ul>
</div>

EOF;
}

$BWHTML .= <<<EOF

EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:portlet_service:desc::trigger:>
//===========================================================================
function portlet_service($option="") {global $bw, $vsLang;

//--starthtml--//
$BWHTML .= <<<EOF
        
EOF;
if( $option ) {
$BWHTML .= <<<EOF

<div id="slide_dichvu">
     <div class="next_home">prev</div>
    <div class="slide_item_home">
    <ul>
    {$this->__foreach_loop__id_524ab88748d63($option)}
</ul>
     </div>
     <div class="prev_home">next</div>
</div>

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
function __foreach_loop__id_524ab88748d63($option="")
{
global $bw, $vsLang;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach(  $option as $obj  )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
    <li>
    <a href="{$obj->getUrl("service")}" title='{$obj->getTitle()}' class='service_img'>
    <span>{$obj->createImageCache($obj->file, 205, 127)}</span>
    </a>
    <h3><a href="{$obj->getUrl("service")}" title='{$obj->getTitle()}'>{$obj->getTitle()}</a></h3>
    <p>{$obj->getContent(200)}</p>
    </li>
    
EOF;
$vsf_count++;
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:portlet_search:desc::trigger:>
//===========================================================================
function portlet_search() {global $bw, $vsLang, $vsTemplate;
$stringSearch = $vsLang->getWords ( 'global_tim', 'Tìm kiếm sản phẩm...' );

//--starthtml--//
$BWHTML .= <<<EOF
        <div class="search_top" id='global_search'>
        <input id='keySearch' class="input_text" type="text" onfocus="if(this.value=='{$stringSearch}') this.value='';" onblur="if(this.value=='') this.value='{$stringSearch}';" value="{$stringSearch}" />
            <input type="submit" value="" class="search_btn" id='submit_form_search'/>
        </div>
        
        <script language="javascript" type="text/javascript">
        $(document).ready(function(){
        $("#keySearch").keydown(function(e){
        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
        if(e.keyCode==13) return $('#submit_form_search').click();
        });
                
        $('#global_search').submit(function(){
                    if($('#keySearch').val()==""||$('#keySearch').val()=="{$stringSearch}") {
                        jAlert('{$vsLang->getWords('global_tim_thongtin', 'Vui lòng nhập thông tin cần tìm kiếm')}',
                        '{$bw->vars['global_websitename']} Dialog');
                        return false;
                    }
                    return true;
                });
                $('#submit_form_search').click(function()  {
         if($('#keySearch').val()==""||$('#keySearch').val()=="{$stringSearch}") {
             jAlert('{$vsLang->getWords('global_tim_thongtin','Vui lòng nhập thông tin cần search:please!!!!!')}',
                        '{$bw->vars['global_websitename']} Dialog');
                return false;
           }
           str =  $('#keySearch').val()+"/";
            document.location.href="{$bw->base_url}searchs/"+ str;
            return;
     });
                });
                </script>
EOF;
//--endhtml--//
return $BWHTML;
}
//===========================================================================
// <vsf:portlet_dropdown_weblink:desc::trigger:>
//===========================================================================
function portlet_dropdown_weblink($option=array()) {global $bw, $vsLang, $vsMenu, $vsStd, $vsPrint;
$vsPrint->addJavaScriptString ( 'global_weblink', '
       $("#link").change(function(){
                               if($("#link").val())
                                    window.open($("#link").val(),"_blank");
                            });
    ' );

//--starthtml--//
$BWHTML .= <<<EOF
        <div class='web_link'>
    <form>
                    <select class="styled" id="link">
                    <option value="0">{$vsLang->getWordsGlobal('global_lienket','Liên kết')}</option>
                        {$this->__foreach_loop__id_524ab88749532($option)}       
                    </select>
</form>
            </div>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_524ab88749532($option=array())
{
global $bw, $vsLang, $vsMenu, $vsStd, $vsPrint;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach( $option as $wl )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
                            <option value="{$wl->getWebsite()}"> {$wl->getTitle()}</option>
                        
EOF;
$vsf_count++;
    }
    return $BWHTML;
}


}?>