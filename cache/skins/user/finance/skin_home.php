<?php
class skin_home{

//===========================================================================
// <vsf:showDefault:desc::trigger:>
//===========================================================================
function showDefault($option="") {global $bw, $vsTemplate, $vsLang, $vsPrint, $vsSettings;
$vsPrint->addCurentJavaScriptFile('jcarousellite', 1);
$lang = $_SESSION['user']['language']['currentLang']['langFolder'];

//--starthtml--//
$BWHTML .= <<<EOF
        <div id="center">
    <h3 class="center_title">
    <a href="{$bw->base_url}branch" title="{$vsLang->getWords("branch", "Chuỗi cửa hàng")}">{$vsLang->getWords("branch", "Chuỗi cửa hàng")}</a>
    </h3>
        <div class="branch-div center_group">
        <ul>
        {$this->__foreach_loop__id_524ab88740c7d($option)}
            </ul>
            <div class="clear_left"></div>
        </div>
        
        <h3 class="center_title"><a href="{$bw->base_url}news" title='{$vsLang->getWords("news", "Tin tức mới")}'>{$vsLang->getWords("news", "Tin tức mới")}</a></h3>
        <div class="center_group">
        {$this->__foreach_loop__id_524ab8874144c($option)}
            <div class="clear_left"></div>
        </div>
        
        <div class='sitebar_tuyendung' style='width: 640px; font-weight: bold;'>
        {$vsSettings->getSystemKey("config_notice_".$lang.'_1', '- Tất cả khăn của chúng tôi đều được giặt và thay mới sau khi sử dụng.', 'config')}<br />
        {$vsSettings->getSystemKey("config_notice_".$lang.'_2', '- Tất cả sản phẩm của chúng tôi đều sử dụng các nhãn hiệu nổi tiếng và chính hãng, tuyệt đối không sử dụng hàng giả, quý khách có thể an tâm sử dụng.', 'config')}
        </div>
    </div>
    <script>
    $(".center_group").find(".news_item:last").css({border:"none"});
$(".center_group").find(".news_item:last").prev().css({border:"none"});

$(".slide_item_home").jCarouselLite({
btnNext: ".next_home",btnPrev: ".prev_home",speed:5000,visible:4,vertical:false,auto:1
});

EOF;
if( count($option['branch']) > 3) {
$BWHTML .= <<<EOF

$(".branch-div").jCarouselLite({
btnNext: ".next_home",btnPrev: ".prev_home",speed:5000,visible:4,vertical:false,auto:1
});

EOF;
}

$BWHTML .= <<<EOF

    </script>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_524ab88740c7d($option="")
{
global $bw, $vsTemplate, $vsLang, $vsPrint, $vsSettings;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach(  $option['branch'] as $obj  )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
        <li>
        <div class="cuahang_item">
            <a href="{$obj->getUrl('branch')}" class="cuahang_img" title='{$obj->getTitle()}'>
            {$obj->createImageCache($obj->file, 200, 125)}
            </a>
                <h3><a href="{$obj->getUrl('branch')}" title='{$obj->getTitle()}'>{$obj->getTitle()}</a></h3>
                <p>{$obj->getContent(300)}</p>
            </div>
            </li>
            
EOF;
$vsf_count++;
    }
    return $BWHTML;
}


//===========================================================================
// Foreach loop function 
//===========================================================================
function __foreach_loop__id_524ab8874144c($option="")
{
global $bw, $vsTemplate, $vsLang, $vsPrint, $vsSettings;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    foreach(  $option['news'] as $obj  )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
        <div class="news_item">
            <a href="{$obj->getUrl('news')}" class="news_img" title='{$obj->getTitle()}'>
            {$obj->createImageCache($obj->file, 118, 109)}
            </a>
                <h3><a href="{$obj->getUrl('news')}" title='{$obj->getTitle()}'>{$obj->getTitle()}</a></h3>
                <p>{$obj->getContent(300)}</p>
                <p class="news_date">{$vsLang->getWords('posttime','Ngày đăng')} {$obj->getPostDate('SHORT')}</p>
            </div>
            
EOF;
$vsf_count++;
    }
    return $BWHTML;
}


}?>