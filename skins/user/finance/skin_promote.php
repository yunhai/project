<?php
class skin_promote{
	
	function showDefault($option = array()){
		global $bw, $vsLang;
		
		$BWHTML .= <<<EOF
		<div class='row'>
			<div class="span6 well">
		        <h3 class="center_title">
		        	<span>
						<img class="noodle-icon" src='{$bw->vars['img_url']}/noodle.png' alt='icon' />
					</span>
		        	<a href="#" title='{$vsLang->getWords($bw->input[0]."_title", $bw->input[0])}'>
						{$vsLang->getWords($bw->input[0]."_title", $bw->input[0])}
					</a>
				</h3>
		        <div class="center_group">
		        	<foreach=" $option['pageList'] as $obj ">
		        	<div class="item">
		        		<h3><a href="#" title='{$obj->getTitle()}'>{$obj->getTitle()}</a></h3>
		        		<if=" $obj->file ">
		            	<a href="#" class="promote_image" title='{$obj->getTitle()}'>
		            		{$obj->createImageCache($obj->file, 200, 200, 0)}
		            	</a>
		            	</if>
		                <p>{$obj->getContent(500)}</p>
		                <div class="clear"></div>
		            </div>
		            </foreach>
		        </div>
		        <div class='paging'>
		        	{$option['paging']}
		        </div>
        	</div>
		        			
		    <!-- CONTACT MAPS -->    			
        </div>
EOF;
		return $BWHTML;
	}
	
	function showDetail($obj, $option = array()){
		global $bw, $vsLang;
		
		$BWHTML .= <<<EOF
		<div class='row'>
			<div class="span6 well">
		        <h3 class="center_title">
		        	<span>
						<img class="noodle-icon" src='{$bw->vars['img_url']}/noodle.png' alt='icon' />
					</span>
		        	<a href="#" title='{$vsLang->getWords($bw->input[0]."_title", $bw->input[0])}'>
						{$obj->getTitle()}
					</a>
				</h3>
		        <div class="detail"> 
					{$obj->getContent()}
				</div>
		        
		        <if=" $option['other'] ">
		        <div class="other">
		        	<h4>{$vsLang->getWords($bw->input[0].'_others', 'Bài viết khác')}</h4>
		        	<foreach=" $option['other'] as $item ">
		            <a href="{$item->getUrl($bw->input[0])}" title="{$item->getTitle()}">
		            	<i class='icon-heart'></i>
		            	{$item->getTitle()}
		            </a>
		            </foreach>
		        </div>
		        </if>
        	</div>
		    <!-- CONTACT MAPS -->        			
        </div>
EOF;
		return $BWHTML;
	}
}
