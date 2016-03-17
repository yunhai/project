<?php
class skin_home{

function showDefault($option){
	global $bw,$vsLang,$vsPrint,$vsTemplate,$vsSettings;

		$BWHTML .= <<<EOF
            <h3 class="title_cate">{$vsLang->getWords("sanphamtieubieu","Sản phẩm tiêu biểu")}</h3>
            <div class="main_item">
                <foreach="$option['products'] as $obj">
                    {$this->showObj($obj,'products')}
                </foreach>
                <div class="clear"></div>
            </div>
            <h3 class="title_cate">{$vsLang->getWords("quatang","Quà tặng")}</h3>
            <div class="main_item">
                <foreach="$option['quatang'] as $obj">
                    {$this->showObj($obj,'quatang')}
                </foreach>
            </div>

EOF;
	}

function showObj($obj, $module){
		global $bw,$vsLang,$vsPrint,$vsTemplate,$vsMenu;

		$BWHTML .= <<<EOF
		<div class="item-list col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<div class='item'>
					<h3><a class="title" title="{$obj->getTitle()}" href="{$obj->getUrl('products')}">{$obj->getTitle()}</a></h3>
					<if=" $bw->isMobile ">
					<a title="{$obj->getTitle()}" href="{$obj->getUrl('products')}" title="{$obj->getTitle()}">
					<else />
					<a title="{$obj->getTitle()}" class="thickbox" href="{$obj->getCacheImagePathByFile($obj->getImage(),1,1,1,1,$obj->getTitle())}" title="{$obj->getTitle()}">
					</if>
						{$obj->createImageCache($obj->getImage(),187,189,1,0,$obj->getTitle())}
					</a>
					<span class='product-price'>{$obj->getPrice()}</span>
					<a title="{$obj->getTitle()}" href="{$bw->base_url}orders/addtocart/{$obj->getId()}" class="order_item">{$vsLang->getWords("giohang","+  Giỏ hàng")}</a>
					<a title="{$obj->getTitle()}" href="{$obj->getUrl('products')}" class="views_item">{$vsLang->getWords("chitiet","Chi tiết")}</a>
				</div>
		</div>
EOF;
	}
}
?>
