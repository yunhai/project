<?php
class skin_home {
	
	function showDefault($option) {
		global $bw, $vsTemplate, $vsLang, $vsPrint;
		$vsPrint->addCurentJavaScriptFile('jcarousellite', 1);
		$BWHTML .= <<<EOF
			<div id="center">
		    	<h3 class="center_title">
		    		<a href="{$bw->base_url}branch" title="{$vsLang->getWords("branch", "Chuỗi cửa hàng")}">{$vsLang->getWords("branch", "Chuỗi cửa hàng")}</a>
		    	</h3>
		        <div class="center_group">
		        	<foreach=" $option['branch'] as $obj ">
		        	<div class="cuahang_item">
		            	<a href="{$obj->getUrl('branch')}" class="cuahang_img" title='{$obj->getTitle()}'>
		            		{$obj->createImageCache($obj->file, 200, 125)}
		            	</a>
		                <h3><a href="{$obj->getUrl('branch')}" title='{$obj->getTitle()}'>{$obj->getTitle()}</a></h3>
		                <p>{$obj->getContent(300)}</p>
		            </div>
		            </foreach>
		            <div class="clear_left"></div>
		        </div>
		        
		        <h3 class="center_title"><a href="{$bw->base_url}news" title='{$vsLang->getWords("news", "Tin tức mới")}'>{$vsLang->getWords("news", "Tin tức mới")}</a></h3>
		        <div class="center_group">
		        	<foreach=" $option['news'] as $obj ">
		        	<div class="news_item">
		            	<a href="{$obj->getUrl('news')}" class="news_img" title='{$obj->getTitle()}'>
		            		{$obj->createImageCache($obj->file, 118, 109)}
		            	</a>
		                <h3><a href="{$obj->getUrl('news')}" title='{$obj->getTitle()}'>{$obj->getTitle()}</a></h3>
		                <p>{$obj->getContent(300)}</p>
		                <p class="news_date">{$vsLang->getWords('posttime','Ngày đăng')} {$obj->getPostDate('SHORT')}</p>
		            </div>
		            </foreach>
		            <div class="clear_left"></div>
		        </div>
		    </div>
		    <script>
		    	$(".center_group").find(".news_item:last").css({border:"none"});
				$(".center_group").find(".news_item:last").prev().css({border:"none"});
				$(function() {
					$(".slidetabs").tabs(".images > div.slide_item", {
						effect: "fade",
						fadeOutSpeed: "slow",
						rotate: true,
						auto:false
					}).slideshow();
					$(".slidetabs").data("slideshow").play();
				});
				
				$(".slide_item_home").jCarouselLite({
					btnNext: ".next_home",btnPrev: ".prev_home",speed:2000,visible:4,vertical:false,auto:1
				});
		    </script>
EOF;
		return $BWHTML;
	}
}
?>