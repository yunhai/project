<?php
if(!class_exists('skin_objectpublic'))
require_once ('./cache/skins/user/finance/skin_objectpublic.php');
class skin_home extends skin_objectpublic {

//===========================================================================
// <vsf:loadDefault:desc::trigger:>
//===========================================================================
function loadDefault($option=array()) {global $bw, $vsTemplate, $vsPrint, $vsUser,$menu;
$vsLang = VSFactory::getLangs();
$this->vsLang = VSFactory::getLangs();
$pagpage = VSFactory::getSettings ()->getSystemKey ( "Links Panpage", "https://www.facebook.com/FacebookDevelopers", "configs" );

//--starthtml--//
$BWHTML .= <<<EOF
        <section id="services" class="emerald">
        <div class="container">
            <div class="row">
            {$this->__foreach_loop__id_547dd9579b0f78_16692877($option)}
                
            </div>
        </div>
    </section><!--/#services-->
    <section id="recent-works">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h3>{$this->vsLang->getWords("Our_Latest_Project_title","Our Latest Project")}</h3>
                    <p>{$this->vsLang->getWords("Our_Latest_Project_intro","Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.")}</p>
                    <div class="btn-group">
                        <a class="btn btn-danger" href="#scroller" data-slide="prev"><i class="icon-angle-left"></i></a>
                        <a class="btn btn-danger" href="#scroller" data-slide="next"><i class="icon-angle-right"></i></a>
                    </div>
                    <p class="gap"></p>
                </div>
                <div class="col-md-9">
                    <div id="scroller" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="item active">
                                <div class="row">
                                {$this->__foreach_loop__id_547dd9579b1db4_68933974($option)}                            
                                    
                                </div><!--/.row-->
                            </div><!--/.item-->
                            
                        </div>
                    </div>
                </div>
            </div><!--/.row-->
        </div>
    </section><!--/#recent-works-->
EOF;
//--endhtml--//
return $BWHTML;
}

//===========================================================================
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547dd9579b0f78_16692877($option=array())
{
global $bw, $vsTemplate, $vsPrint, $vsUser,$menu;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option ['services'])){
    foreach( $option ['services'] as $key => $value )
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
                            <p>{$this->cut($value->getIntro(),150)}</p>
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
// Foreach loop function ifstatement
//===========================================================================
function __foreach_loop__id_547dd9579b1db4_68933974($option=array())
{
global $bw, $vsTemplate, $vsPrint, $vsUser,$menu;
    $BWHTML = '';
    $vsf_count = 1;
    $vsf_class = '';
    if(is_array($option ['projects'])){
    foreach( $option ['projects'] as $key => $value )
    {
        $vsf_class = $vsf_count%2?'odd':'even';
    $BWHTML .= <<<EOF
        
                                    <div class="col-xs-4">
                                        <div class="portfolio-item">
                                            <div class="item-inner">
                                                <img class="img-responsive" src="{$value->getCacheImagePathByFile($value->getImage(),1,1,1,1)}" alt="{$value->getTitle()}">
                                                <h5>
                                                  {$value->getTitle()}
                                                </h5>
                                                <div class="overlay">
                                                    <a class="preview btn btn-danger" title="{$value->getTitle()}" href="{$value->getUrl($value->getModule())}"><i class="icon-eye-open"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
EOF;
if($vsf_count%3==0 && $option['count']!=$vsf_count) {
$BWHTML .= <<<EOF
 </div><!--/.row-->  </div><!--/.item--><div class="item {$vsf_count} ">        <div class="row">
EOF;
}

$BWHTML .= <<<EOF

                                    
EOF;
if($option['count']%3!=0 && $option['count']==$vsf_count) {
$BWHTML .= <<<EOF
</div><!--/.row-->  </div><!--/.item-->
EOF;
}

$BWHTML .= <<<EOF

                                    
EOF;
$vsf_count++;
    }
    }
    return $BWHTML;
}


}
?>