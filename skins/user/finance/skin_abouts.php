<?php
class skin_abouts extends  skin_objectpublic{

function showDefault($option){
		global $bw,$vsLang,$vsPrint,$vsTemplate;
		
		$BWHTML .= <<<EOF
			
				<h3 class="title_cate">{$vsPrint->mainTitle}</h3>
                <div class="main_item">
                <foreach="$option['pageList'] as $obj">
                	<div class="item_th">
                    	<h3><a title="{$obj->getTitle()} href="{$obj->getUrl('abouts')}">{$obj->getTitle()}</a></h3>
                    	<a title="{$obj->getTitle()} href="{$obj->getUrl('abouts')}" class="img_th">{$obj->createImageCache($obj->file,315,220,1,0,$obj->getTitle())}</a>
                    	<p>{$obj->getIntro()}</p>
                    </div>  
                </foreach>    
                    
                </div>
            </div>
	
EOF;
	}
	
function showDetail($obj,$option){
		global $bw,$vsLang,$vsPrint,$vsTemplate;
		
		
		
		$BWHTML .= <<<EOF
		
    				<h3 class="title_cate">{$vsLang->getWords($option['cate']->getTitle(), "Giới Thiệu")}</h3>
                	<div class="main_abouts">
                    	<if="$obj->file">
        				<div class="img_abouts">{$obj->createImageCache($obj->file,182,80,3,0)}</div>
        				</if>
                        <h3 class="title_abouts">{$obj->getTitle()}</h3>
                    	<p>{$obj->getContent()} </p>
                    	</div>
                    	
                    
                    
   
    <!-- STOP CENTER -->
	
EOF;
	}
}

?>	

