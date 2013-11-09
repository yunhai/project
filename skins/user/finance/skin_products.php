<?php
class skin_objectpublic{
	
	function showDefault($option = array()){
		global $bw, $vsLang, $vsTemplate;
		
		$BWHTML .= <<<EOF
		
		<div class="main_title">
        	<h3>{$option['category']->getTitle()}</h3>
        </div>

        <div class="product_group">
            <if=" $option['pageList'] ">
        	<foreach=" $option['pageList'] as $item ">
                <div class="product_item">
	            	<a href="{$item->getUrl('products')}" class="product_item_img" title='{$item->getTitle()}'>
	            		<span>
            				{$item->createImageCache($item->getImage(), 156, 186)}
            			</span>
	            	</a>
	            	<div class="product_intro">
	                	<h3><a href="{$item->getUrl('products')}" title='{$item->getTitle()}'>{$item->getTitle()}</a></h3>
	                    <p>{$item->getIntro()}</p>
	                </div>
	            </div>
        	</foreach>
        	
        	<div class='clear'></div>
        	<else />
        	{$vsLang->getWords('no_item','Hiện tại mục này chưa có thông tin.')}
        	</if>
        	<div class="clear"></div>
        </div>
        <!-- STOP PRODCT GROUP -->
        
        <if=" $option['paging'] ">
        <div class="page">{$option['paging']}</div>
		</if>
EOF;
	}
	
	function showDetail($obj,$option){
		global $bw, $vsLang, $vsTemplate;
       
		$BWHTML .= <<<EOF
        <div class="main_title">
        	<h3>{$option['category']->getTitle()}</h3>
        </div>
		<div class="about_detail"> 
        	<div class="product_img">
        		<a class='mainimage' titte="{$obj->getTitle()}" href="{$obj->getCacheImagePathByFile($obj->file, 600, '', 4)}">
            	{$obj->createImageCache($obj->getImage(), 325, 372)}
            	</a>
            </div>
            
            <div class="product_detail">
                <h1>{$obj->getTitle()}</h1>
                <p class="nhanxe">{$vsLang->getWords('label_title', 'Nhãn xe')}: <span>{$obj->getLabel()}</span></p>
				<p class="nhanxe">{$vsLang->getWords('model_title', 'Model')}:  <span>{$obj->getModel()}</span></p>
                <h3 class="thongsokt">{$vsLang->getWords('spec_title', 'Thông số kỹ thuật')}</h3>
                {$obj->getSpec()}
                
                <h3 class="thongsokt">{$vsLang->getWords('content_title', 'Mô tả thêm')}</h3>
                {$obj->getContent()}
			</div>
        </div>
        
        <if=" $option['other'] ">
        <div class="main_title">
        	<h3>{$vsLang->getWords('others', 'các sản phẩm cùng loại')}</h3>
            <a href="{$option['category']->getUrlCategory()}">{$vsLang->getWords('global_product_all','xem tất cả')}</a>
        </div>
        <div class="product_group">
        	<foreach=" $option['other'] as $item ">
                <div class="product_item">
	            	<a href="{$item->getUrl('products')}" class="product_item_img" title='{$item->getTitle()}'>
	            		<span>
            				{$item->createImageCache($item->getImage(), 156, 186)}
            			</span>
	            	</a>
	            	<div class="product_intro">
	                	<h3><a href="{$item->getUrl('products')}" title='{$item->getTitle()}'>{$item->getTitle()}</a></h3>
	                    <p>{$item->getIntro()}</p>
	                </div>
	            </div>
        	</foreach>
        	<div class="clear"></div>
        </div>
        </if>
EOF;
	}
}
?>