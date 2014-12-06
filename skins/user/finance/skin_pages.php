<?php
class skin_pages extends skin_objectpublic{
	function showDefault($option = array()) {
		global $bw,$vsPrint;
		$this->bw=$bw;
		//$option['cate'] = VSFactory::getMenus ()->getCategoryGroup ( $bw->input [0] )->getChildren();
		//$option['title'] = VSFactory::getLangs()->getWords($bw->input[0]."s");
		
		$cateId = $option['obj']?$option['obj']->getId():0;
		
		$vsLang = VSFactory::getLangs();
		$this->vsLang = VSFactory::getLangs();	
		$count =9;
		//echo 123; exit;
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
        <foreach="$option['pageList'] as $value">
            <li>
                <span class="number">{$value->count}</span>
                <div>
                    <h4><a href='{$value->getUrl($value->getModule())}'>{$value->getTitle()}</a></h4>
                    <p>{$this->cut($value->getIntro(),850)}</p>
                </div>
            </li>
          </foreach>              
        </ul>
        
         <if="$option['paging']">                  	                                 
		                    <div class="page">
									{$option['paging']}
							</div>
						</if>
    </section><!--#faqs-->
			
EOF;
	}
	
	function showDetail($obj,$option = array()) {
		global $bw,$vsPrint;
//		echo "vuong"; exit();
		$vsLang = VSFactory::getLangs();
		$this->bw=$bw;
		
		require_once CORE_PATH.'gallerys/gallerys.php';
		$gallerys=new gallerys();
		$option['file_list']=$gallerys->getAlbumByCode($bw->input[0].'_'.$obj->getId());
		$vsLang = VSFactory::getLangs();
		$this->vsLang = VSFactory::getLangs();	
		
		
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
					           <foreach="$option['other'] as $value">
					            <li>
					               
					                <div>
					                    <h4><a href='{$value->getUrl($value->getModule())}'>{$value->getTitle()}</a></h4>
					                    <p>{$this->cut($value->getIntro(),350)}</p>
					                </div>
					            </li>
					          </foreach> 
					           
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
							<if="$option['file_list']">
                            <hr>

                            <!-- gallery -->
                            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
							  <!-- Indicators -->
							  <ol class="carousel-indicators">
							  <foreach="$option['file_list'] as $value">
							    <li data-target="#carousel-example-generic" data-slide-to="{$this->numberFormat($vsf_count-1)}" ></li>
							    </foreach>
							    
							  </ol>
							
							  <!-- Wrapper for slides -->
							  <div class="carousel-inner">
							   <foreach="$option['file_list'] as $value">
							    <div class="item ">
							      <img class="img-responsive" src="{$value->getPathView()}" width="100%" alt="" />
							    </div>
							    </foreach>
							    
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
							
							
                            </if>
                            <p>&nbsp;</p>
                        </div>
                    </div><!--/.blog-item-->
                </div>
            </div><!--/.col-md-8-->
        </div><!--/.row-->
    </section><!--/#blog-->
    
EOF;
	}
	
function showSearch($option = array()) {
		global $bw,$vsPrint;
		$this->bw=$bw;
		//$option['cate'] = VSFactory::getMenus ()->getCategoryGroup ( $bw->input [0] )->getChildren();
		//$option['title'] = VSFactory::getLangs()->getWords($bw->input[0]."s");
		
		$cateId = $option['obj']?$option['obj']->getId():0;
		
		$vsLang = VSFactory::getLangs();
		$this->vsLang = VSFactory::getLangs();	
		
		
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
                                            <foreach="$option['entrepreneurs'] as $value">
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
                                          	</foreach>
                                          	<foreach="$option['pageList'] as $value">
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
                                          	</foreach>

                                              
                                            </div>

                                            <!--page-->
                                            <div class="box_news">
                                                <if="$option['paging']">
								                    <div class="clear"></div>	                                 
								                    <div class="page">
															{$option['paging']}
													</div>
												</if>
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
	}
function showSendcontact($option=null){
		global $bw,$vsLang,$vsMenu,$vsSettings,$urlcate,$vsExperts,$vsTemplate,$vsPrint;
		
		$BWHTML .= <<<EOF

		{$option['reset']}
EOF;
						
	
	}
}
?>
	

