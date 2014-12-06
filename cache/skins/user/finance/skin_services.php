<?php
if(!class_exists('skin_objectpublic'))
require_once ('./cache/skins/user/finance/skin_objectpublic.php');
class skin_services extends skin_objectpublic {

//===========================================================================
// <vsf:showDefault:desc::trigger:>
//===========================================================================
function showDefault($option=array()) {global $bw,$vsPrint;
$this->bw=$bw;
//$option['cate'] = VSFactory::getMenus ()->getCategoryGroup ( $bw->input [0] )->getChildren();
//$option['title'] = VSFactory::getLangs()->getWords($bw->input[0]."s");

$vsLang = VSFactory::getLangs();
$this->vsLang = VSFactory::getLangs();


//--starthtml--//
$BWHTML .= <<<EOF
        <section id="title" class="emerald">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h1>{$this->vsLang->getWords("{$bw->input[0]}_title","{$bw->input[0]}")}</h1>
                    <p>{$this->vsLang->getWords("{$bw->input[0]}_intro","Pellentesque habitant morbi tristique senectus et netus et malesuada")}</p>
                </div>
                <div class="col-sm-6">
                 
                 <ul class="breadcrumb pull-right">
                        {$option['breakcrum']}
                    </ul>
                </div>
            </div>
        </div>
    </section><!--/#title-->        
    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="center gap">
                        <h2>{$this->vsLang->getWords("what_we_do","What we do")}</h2>
                        <p>{$this->vsLang->getWords("what_we_do_intro","Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.")}</p>
                    </div>                
                </div>
            </div>
            <div class="row">
            {$this->__foreach_loop__id_547dd957ac6698_02590468($option)}
                
            </div><!--/.row-->
        </div>
         
EOF;
if($option['paging']) {
$BWHTML .= <<<EOF
                                                   
                    <div class="page">
{$option['paging']}
</div>

EOF;
}

$BWHTML .= <<<EOF




    </section><!--/#services-->
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547dd957ac6698_02590468($option=array())
{
global $bw,$vsPrint;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['pageList'])){
    foreach( $option['pageList'] as $value )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
                <div class="col-md-4 col-sm-6">
                    <div class="media">
                        <div class="pull-left">
                            <i class="icon-dribbble icon-md"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading"><a href='{$value->getUrl($value->getModule())}'>{$value->getTitle()}</a></h3>
                            <p>{$this->cut($value->getIntro(),100)}</p>
                        </div>
                    </div>
                </div><!--/.col-md-4-->
                
EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:showDetail:desc::trigger:>
//===========================================================================
function showDetail($obj="",$option=array()) {global $bw,$vsPrint;
//echo "vuong"; exit();
$vsLang = VSFactory::getLangs();
$this->bw=$bw;
require_once CORE_PATH.'gallerys/gallerys.php';
$gallerys=new gallerys();
$option['file_list']=$gallerys->getAlbumByCode($bw->input[0].'_'.$obj->getId());
$vsLang = VSFactory::getLangs();
$this->vsLang = VSFactory::getLangs();


//--starthtml--//
$BWHTML .= <<<EOF
        <section id="title" class="emerald">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h1>{$this->vsLang->getWords("{$bw->input[0]}_title","{$bw->input[0]}")}</h1>
                    <p>{$this->vsLang->getWords("{$bw->input[0]}_intro","Pellentesque habitant morbi tristique senectus et netus et malesuada")}</p>
                </div>
                <div class="col-sm-6">
                 
                 <ul class="breadcrumb pull-right">
                        {$option['breakcrum']}
<li>{$obj->getTitle()}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section><!--/#title-->        
<section id="blog" class="container">
        <div class="row">
            <aside class="col-sm-4 col-sm-push-8">
                <div class="widget other-post">
                   <h3><span class="glyphicon glyphicon-list"></span>&nbsp;<span class='blue'>{$this->vsLang->getWords("other_post_{$bw->input[0]}","Other post")}</span></h3>
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="unstyled">
           {$this->__foreach_loop__id_547dd957acb486_30847483($obj,$option)} 
           
            </ul>
                        </div>
                    </div>                     
                </div><!--/.categories-->
            </aside>        
            <div class="col-sm-8 col-sm-pull-4">
                <div class="blog">
                    <div class="blog-item">
                        <div class="blog-content">
                            <h3>{$obj->getTitle()}</h3>
                            <div class="entry-meta">
                                <span><i class="icon-calendar"></i> {$this->dateTimeFormat($obj->getPostDate(),"d-m-Y")}</span>
                            </div>
                            <p>{$obj->getContent()}</p>

EOF;
if($option['file_list']) {
$BWHTML .= <<<EOF

                            <hr>
                            <!-- gallery -->
                            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
  {$this->__foreach_loop__id_547dd957ace496_78526189($obj,$option)}
    
  </ol>
  <!-- Wrapper for slides -->
  <div class="carousel-inner">
   {$this->__foreach_loop__id_547dd957acf8f9_70907465($obj,$option)}
    
  </div>
  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
</div><!-- gallery -->
<script type="text/javascript">
$( document ).ready(function() {
$('ol.carousel-indicators >li:first-child').addClass('active');
$('.carousel-inner >div:first-child').addClass('active');
});    
</script>

                            
EOF;
}

$BWHTML .= <<<EOF

                            <p>&nbsp;</p>
                        </div>
                    </div><!--/.blog-item-->
                </div>
            </div><!--/.col-md-8-->
        </div><!--/.row-->
    </section><!--/#blog-->
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547dd957acb486_30847483($obj="",$option=array())
{
global $bw,$vsPrint;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['other'])){
    foreach( $option['other'] as $value )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
            <li>
               
                <div>
                    <h4><a href='{$value->getUrl($value->getModule())}'>{$value->getTitle()}</a></h4>
                    <p>{$this->cut($value->getIntro(),350)}</p>
                </div>
            </li>
          
EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}


//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547dd957ace496_78526189($obj="",$option=array())
{
global $bw,$vsPrint;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['file_list'])){
    foreach( $option['file_list'] as $value )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
    <li data-target="#carousel-example-generic" data-slide-to="{$this->numberFormat($vsf_count-1)}" ></li>
    
EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}


//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547dd957acf8f9_70907465($obj="",$option=array())
{
global $bw,$vsPrint;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['file_list'])){
    foreach( $option['file_list'] as $value )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
    <div class="item ">
      <img class="img-responsive" src="{$value->getPathView()}" width="100%" alt="" />
    </div>
    
EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}
//===========================================================================
// <vsf:showSearch:desc::trigger:>
//===========================================================================
function showSearch($option=array()) {global $bw,$vsPrint;
$this->bw=$bw;
//$option['cate'] = VSFactory::getMenus ()->getCategoryGroup ( $bw->input [0] )->getChildren();
//$option['title'] = VSFactory::getLangs()->getWords($bw->input[0]."s");
$cateId = $option['obj']?$option['obj']->getId():0;
$vsLang = VSFactory::getLangs();
$this->vsLang = VSFactory::getLangs();


//--starthtml--//
$BWHTML .= <<<EOF
        <div class="container">
                <div class="row">
                    <div class="wt_content">
                        <!--content right-->
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <div class="clearfix">
                                <div class="main_content">
                                    <div class="box_info">
                                        <div class="box_title">
                                            <h2>{$option['title']}</h2>
                                        </div>
                                        <div class="box_maincontent">
                                            <div class="box_news">
                                            {$this->__foreach_loop__id_547dd957ad5e14_62182411($option)}
                                          {$this->__foreach_loop__id_547dd957ad74d6_66056741($option)}
                                              
                                            </div>
                                            <!--page-->
                                            <div class="box_news">
                                                
EOF;
if($option['paging']) {
$BWHTML .= <<<EOF

                    <div class="clear"></div>                                 
                    <div class="page">
{$option['paging']}
</div>

EOF;
}

$BWHTML .= <<<EOF

                                            </div>
                                            <!--end page-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end content right-->
                        <!--content left-->
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                           
                            <div class="clearfix">
                                <div class="main_content">
                                    {$this->getAddon()->getAdvLeft()}
                                </div>
                            </div>
                        </div>
                        <!--end content left-->

                    </div>
                </div>
            </div>
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547dd957ad5e14_62182411($option=array())
{
global $bw,$vsPrint;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['entrepreneurs'])){
    foreach( $option['entrepreneurs'] as $value )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
                                                <div class="media bor_bot wrap_intro">
                                                    <div class="media-body">
                                                        <a href="{$value->getUrl($value->getModule())}" title="" class="pull-left mar_ri">
                                                            <img style="width: 133px; height: 99px;" alt="" src="{$value->getCacheImagePathByFile($value->getImage(),1,1,1,1)}" class="media-object img_intro_page">
                                                        </a>
                                                        <div class="cont_news">
                                                            <h2 class="media-heading font-5">
                                                                  <h2><a href="{$value->getUrl($value->getModule())}"> {$value->getTitle()} <span>Ngày đăng {$this->dateTimeFormat($value->getPostDate())}</span></a></h2>
                                                            </h2>
                                                            <p>{$this->cut($value->getIntro(), 300)} </p>
                                                            <span class="readmore_news">
                                                                <a href="{$value->getUrl($value->getModule())}" title="">Xem chi tiết
                                                                </a></span>
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
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547dd957ad74d6_66056741($option=array())
{
global $bw,$vsPrint;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['pageList'])){
    foreach( $option['pageList'] as $value )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
                                                <div class="media bor_bot wrap_intro">
                                                    <div class="media-body">
                                                        <a href="{$value->getUrl($value->getModule())}" title="" class="pull-left mar_ri">
                                                            <img style="width: 133px; height: 99px;" alt="" src="{$value->getCacheImagePathByFile($value->getImage(),1,1,1,1)}" class="media-object img_intro_page">
                                                        </a>
                                                        <div class="cont_news">
                                                            <h2 class="media-heading font-5">
                                                                  <h2><a href="{$value->getUrl($value->getModule())}"> {$value->getTitle()} <span>Ngày đăng {$this->dateTimeFormat($value->getPostDate())}</span></a></h2>
                                                            </h2>
                                                            <p>{$this->cut($value->getIntro(), 300)} </p>
                                                            <span class="readmore_news">
                                                                <a href="{$value->getUrl($value->getModule())}" title="">Xem chi tiết
                                                                </a></span>
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
// <vsf:showSendcontact:desc::trigger:>
//===========================================================================
function showSendcontact($option=null) {global $bw,$vsLang,$vsMenu,$vsSettings,$urlcate,$vsExperts,$vsTemplate;

//--starthtml--//
$BWHTML .= <<<EOF
        <script type="text/javascript">
alert('{$option['mess']}');
</script>
EOF;
//--endhtml--//
return $BWHTML;
}


}
?>