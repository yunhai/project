<?php
if(!class_exists('skin_objectpublic'))
require_once ('./cache/skins/user/finance/skin_objectpublic.php');
class skin_pages extends skin_objectpublic {

//===========================================================================
// <vsf:showDefault:desc::trigger:>
//===========================================================================
function showDefault($option=array()) {global $bw,$vsPrint;
$this->bw=$bw;
//$option['cate'] = VSFactory::getMenus ()->getCategoryGroup ( $bw->input [0] )->getChildren();
//$option['title'] = VSFactory::getLangs()->getWords($bw->input[0]."s");
$cateId = $option['obj']?$option['obj']->getId():0;
$vsLang = VSFactory::getLangs();
$this->vsLang = VSFactory::getLangs();
$count =9;
//echo 123; exit;

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
    <section id="faqs" class="container">
        <ul class="faq unstyled">
        {$this->__foreach_loop__id_54871081da2272_77739340($option)}              
        </ul>
        
         
EOF;
if($option['paging']) {
$BWHTML .= <<<EOF
                                                   
                    <div class="page">
{$option['paging']}
</div>

EOF;
}

$BWHTML .= <<<EOF

    </section><!--#faqs-->
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_54871081da2272_77739340($option=array())
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
        
            <li>
                <span class="number">{$value->count}</span>
                <div>
                    <h4><a href='{$value->getUrl($value->getModule())}'>{$value->getTitle()}</a></h4>
                    <p>{$this->cut($value->getIntro(),850)}</p>
                </div>
            </li>
          
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
           {$this->__foreach_loop__id_54871081da8371_16705002($obj,$option)} 
           
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
  {$this->__foreach_loop__id_54871081da9507_50444769($obj,$option)}
    
  </ol>
  <!-- Wrapper for slides -->
  <div class="carousel-inner">
   {$this->__foreach_loop__id_54871081daaac0_77620219($obj,$option)}
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
function __foreach_loop__id_54871081da8371_16705002($obj="",$option=array())
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
function __foreach_loop__id_54871081da9507_50444769($obj="",$option=array())
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
function __foreach_loop__id_54871081daaac0_77620219($obj="",$option=array())
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
// <vsf:showAboutDefault:desc::trigger:>
//===========================================================================
function showAboutDefault($option=array()) {    global $bw,$vsPrint;
    $this->bw=$bw;
    $cateId = $option['obj']?$option['obj']->getId():0;
    $vsLang = VSFactory::getLangs();
    $this->vsLang = VSFactory::getLangs();
    $count =9;
    
    
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
    <section id="faqs" class="container">
        <div class='col-md-8'>
            <ul class="faq unstyled">
                {$this->__foreach_loop__id_54871081db1a43_13224289($option)}
             </ul>
             
EOF;
if($option['paging']) {
$BWHTML .= <<<EOF

                <div class="page">
    {$option['paging']}
    </div>
    
EOF;
}

$BWHTML .= <<<EOF

        </div>
        <div class='col-md-4'>
       <div class="list-group">
       <!--
              <a href="#" class="list-group-item active">
                {$this->vsLang->getWords("{$bw->input[0]}_category_list", "Giới thiệu về Weicovina chúng tôi")}
              </a>
              -->
          {$this->__foreach_loop__id_54871081db4e91_29681796($option)}
            </div>        
            
        </div>
    </section><!--#faqs-->
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_54871081db1a43_13224289($option=array())
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
        
                    <li>
                        <span class="number">{$value->count}</span>
                        <div>
                            <h4><a href='{$value->getUrl($value->getModule())}'>{$value->getTitle()}</a></h4>
                            <p>{$this->cut($value->getIntro(),850)}</p>
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
function __foreach_loop__id_54871081db4e91_29681796($option=array())
{
    global $bw,$vsPrint;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option['category'])){
    foreach( $option['category'] as $value )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
                <a href="{$value->getCatUrl()}" class="list-group-item 
EOF;
if($option ['idcate'] == $value->getId()) {
$BWHTML .= <<<EOF
active
EOF;
}

$BWHTML .= <<<EOF
" title="{$value->getTitle()}">{$value->getTitle()}</a>
              
EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}


}
?>