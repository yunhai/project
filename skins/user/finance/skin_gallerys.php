<?php
class skin_gallerys extends skin_objectpublic {
	
	function showDefault($option) {
		global $bw, $vsLang, $vsPrint, $vsTemplate;
		
		//$vsPrint->addCurentJavaScriptFile ( "jcarousellite" );
		//$vsPrint->addCurentJavaScriptFile ( "jqzoom.pack.1.0.1" );
		//$vsPrint->addCSSFile ( 'jcarousellite' );
		//$vsPrint->addCSSFile ( 'jqzoom' );
		
		$BWHTML .= <<<EOF


    <div id="content">		
				<div id="content_sub">
				   	<div id="content_center">
					<if="$option['gallery']">
	    			<div class="thiettritontuong">
 					<div class="slide_product" style="height:700px;">
                        <div class="jqzoom_bg">
                        	<foreach=" $option['gallery'] as $image ">
                            <a href="{$image->getResizeImagePath($image->getPathView(),1000,1000,1)}" class="jqzoom"  style="position:absolute" id="slide{$vsf_count}">
                                {$image->createImageCache($image,300,350,1)}
                            </a>
                            </foreach>
                        </div>
                         <div class="slide_product_zoom">
                                 <div class="prev_product_zoom"><img src="{$bw->vars['img_url']}/prev_slide_home.png" /></div>
                                 <div class="slide_item_home">
                                       <ul>	
                                       		<foreach=" $option['gallery'] as $image ">
                                             <li><img id="span{$vsf_count}" src="{$image->getResizeImagePath($image->getPathView(),180,195,1)}" onclick="switchTo({$vsf_count});" /></li>
                                             </foreach>                       
                                        </ul>
                                 </div>
                                 <div class="next_product_zoom"><img src="{$bw->vars['img_url']}/next_slide_home.png" /></div>
                         </div>
                   </div>
                   <!-- STOP SLIDE -->
				  
					<div class="clear"></div>
                </div> 
				<else />
				<h3>Dử liệu đang cập nhật</h3>
				</if>		
            </div>
            
        </div>
    </div>
    <!-- STOP CONTENT DIEU TUONG AM -->

EOF;
	}
	function showDetail($obj, $option) {
		global $bw, $vsLang, $vsPrint, $vsTemplate;
		$BWHTML .= <<<EOF
		<script>
		$(document).ready(function(){
		var slider1 = $("#slider1").bxSlider({
				infiniteLoop: false,
				hideControlOnEnd: true,
				mode: "fade",
				auto: true,
				pager: true
			});
		});
		</script>
			<div id="content">
		    	<div id="content_sub">
		        	<div id="content_center">
		                <div class="show">
			                <if="count($option['gallery'])">
			                    <ul id="slider1">
			                    	<foreach="$option['gallery'] as $obj">
			                        	<li><a href="{$obj->getUrl()}">{$obj->createImageCache($obj, 900, 413, 2)}</a></li>
									</foreach>
			                    </ul>
			                </if>
		                </div>
		                 <!-- STOP SLIDE -->    
		                
		            </div>
		        </div>
		    </div>
EOF;
	
	}
	function showDetail1($obj, $option) {
		global $bw, $vsLang, $vsPrint, $vsTemplate;
		
		//		$vsPrint->addCurentJavaScriptFile("highslide/highslide-full");
		//		if ($option['gallery']){
		//			$vsPrint->addCurentJavaScriptFile("jquery.galleriffic");
		//			$vsPrint->addCurentJavaScriptFile("jquery.opacityrollover");
		//		}
		//		$vsPrint->addCSSFile('galleriffic-2');
		

		$vsPrint->addCurentJavaScriptFile ( "jcarousellite" );
		$vsPrint->addCurentJavaScriptFile ( "jqzoom.pack.1.0.1" );
		$vsPrint->addCSSFile ( 'jcarousellite' );
		$vsPrint->addCSSFile ( 'jqzoom' );
		

		$BWHTML .= <<<EOF
		
		
<script type="text/javascript">
		    $(document).ready(function(){
				$('.page').find('a:first').css({padding:'0px'});
				$('.page').find('a:last').css({padding:'0px'});
				$(".slide_item_home").jCarouselLite({
						btnNext: ".next_product_zoom",btnPrev: ".prev_product_zoom",visible:3,vertical:false,auto:0
					});
		    });
			$(function() {
			var options4 =
			{
			zoomWidth: 627,
			zoomHeight: 488,
			title :false
			}
			$(".jqzoom").jqzoom(options4);
		});
		function switchTo(id) {
			<foreach=" $option['gallery'] as $image ">
		    document.getElementById('slide{$vsf_count}').style.zIndex=(id=={$vsf_count})?'1':'-1';
		    </foreach> 
		}

</script>

		<div id="content">
    	<div id="content_sub">
        	<div id="content_center">
				<if="$option['gallery']">
                <div class="webshop_detail">
                	<div class="slide_product" style="height:700px;">
                        <div class="jqzoom_bg">
                        	<foreach=" $option['gallery'] as $image ">
                            <a href="{$image->getResizeImagePath($image->getPathView(),1000,1000,1)}" <if="$image->getUrl()"> onClick="window.open('{$image->getUrl()}')" </if> class="jqzoom"  style="position:absolute" id="slide{$vsf_count}">
                                {$image->createImageCache($image,300,350,1)}
                            </a>
                            </foreach>
                        </div>
                         <div class="slide_product_zoom">
                                 <div class="prev_product_zoom"><img src="{$bw->vars['img_url']}/prev_slide_home.png" /></div>
                                 <div class="slide_item_home">
                                       <ul>	
                                       		<foreach=" $option['gallery'] as $image ">
                                             <li><img id="span{$vsf_count}" src="{$image->getResizeImagePath($image->getPathView(),180,195,1)}" onclick="switchTo({$vsf_count});" /></li>
                                             </foreach>                       
                                        </ul>
                                 </div>
                                 <div class="next_product_zoom"><img src="{$bw->vars['img_url']}/next_slide_home.png" /></div>
                         </div>
                   </div>
                   <!-- STOP SLIDE -->
                    
                    <div class="product_right">
                    	<h1>{$obj->getTitle()}</h1>
                        {$obj->getContent()}

                    </div>
                    <div class="clear"></div>
                    <a href="{$_SERVER['HTTP_REFERER']}" class="back_btn">Trở lại</a>
                    <div class="clear_right"></div>
                </div>
				<else />
				<h3>Dử liệu đang cập nhật</h3>
				</if>
            </div>
        </div>
    </div>
    <!-- STOP CONTENT DIEU TUONG AM -->
		
			
EOF;
	}

}
?>	
	