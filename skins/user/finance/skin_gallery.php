<?php
class skin_gallery{
	
	function showDefault($option = array()){
		global $bw, $vsLang;
		
		$BWHTML .= <<<EOF
			<div id="center">
		        <h3 class="center_title">
		        	<a href="{$bw->base_url}{$bw->input[0]}" title='{$vsLang->getWords($bw->input[0]."_title", $bw->input[0])}'>
						{$vsLang->getWords($bw->input[0]."_title", $bw->input[0])}
					</a>
				</h3>
		        <div class="center_group">
		        	<foreach=" $option['pageList'] as $obj ">
		        	<div class="item">
		        		<if=" $obj->file ">
		            	<a href="{$obj->getUrl($bw->input[0])}" class="width_img" title='{$obj->getTitle()}'>
		            		{$obj->createImageCache($obj->file, 200, 125)}
		            	</a>
		            	</if>
		                <h3><a href="{$obj->getUrl($bw->input[0])}" title='{$obj->getTitle()}'>{$obj->getTitle()}</a></h3>
		                <p>{$obj->getContent(500)}</p>
		                <p class="news_date">{$vsLang->getWords('posttime','Ngày đăng')} {$obj->getPostDate('SHORT')}</p>
		                <div class="clear_left"></div>
		            </div>
		            </foreach>
		        </div>
		        <div class='paging'>
		        	{$option['paging']}
		        </div>
		    </div>
EOF;
		return $BWHTML;
	}
	
	function showDetail($obj, $option = array()){
		global $bw, $vsLang;
		
		$BWHTML .= <<<EOF
		<script src='{$bw->vars['board_url']}/skins/user/finance/css/highslide/highslide-full.js'></script>
		<script type="text/javascript">
			hs.graphicsDir = '{$bw->vars['board_url']}/skins/user/finance/css/highslide/graphics/';
			hs.align = 'center';
			hs.transitions = ['expand', 'crossfade'];
			hs.outlineType = 'rounded-white';
			hs.fadeInOut = true;
			hs.dimmingOpacity = 0.75;
		
			// define the restraining box
			hs.useBox = true;
			hs.width = 640;
			hs.height = 480;
		
			// Add the controlbar
			hs.addSlideshow({
				//slideshowGroup: 'group1',
				interval: 5000,
				repeat: false,
				useControls: true,
				fixedControls: 'fit',
				overlayOptions: {
					opacity: 1,
					position: 'bottom center',
					hideOnMouseOut: true
				}
			});
		</script>
		<div id="center">
	        <h3 class="center_title detail_title">
	        	<a href="{$bw->base_url}{$bw->input[0]}" title='{$vsLang->getWords($bw->input[0]."_title", $bw->input[0])}'>
					{$vsLang->getWords($bw->input[0]."_title", $bw->input[0])}
				</a>
			</h3>
			<div class="detail"> 
	        	<h1 class='title'>{$obj->getTitle()}</h1>
				{$obj->getContent()}
			</div>
			<div class='gallery'>
				<foreach=" $option['gallery'] as $item ">
				<div class='gallery-item'>
					<a href="{$item->getPathView()}" class="highslide" onclick="return hs.expand(this, {autoplay:true});" title="{$obj->getTitle()}" >
					{$item->createImageCache($item, 200, 150, 1)}
					</a>
				</div>
				</foreach>
				<div class='clear'></div>
			</div>
	        
	        <if=" $option['other'] ">
	        <div class="other">
	        	<h3>{$vsLang->getWords($bw->input[0].'_others', 'Bài viết khác')}</h3>
	        	<foreach=" $option['other'] as $item ">
	            <a href="{$item->getUrl($bw->input[0])}" title="{$item->getTitle()}">{$item->getTitle()}</a>
	            </foreach>
	        </div>
	        </if>
		</div>

EOF;
		return $BWHTML;
	}
}
?>