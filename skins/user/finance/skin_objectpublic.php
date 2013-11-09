<?php
class skin_objectpublic{
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
		            		{$obj->createImageCache($obj->file, 200, 125, 1)}
		            	</a>
		            	</if>
		                <h3><a href="{$obj->getUrl($bw->input[0])}" title='{$obj->getTitle()}'>{$obj->getTitle()}</a></h3>
		                <p>{$obj->getContent(500)}</p>
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