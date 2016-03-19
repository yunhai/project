<?php
class skin_home{

function showDefault($option){
	global $bw,$vsLang,$vsPrint,$vsTemplate,$vsSettings;

		$BWHTML .= <<<EOF
		<if=" $option['promote']">
		<h3 class="title_cate">{$vsLang->getWords("promote", "Khuyến mãi")}</h3>
		<div class="main_item">
				<foreach="$option['promote'] as $i => $product">
						{$this->showObj($product, 'products')}
				</foreach>
				<div class="clear"></div>
		</div>
		</if>
		<foreach="$option['category'] as $key => $item">
		<if=" $option['product'][$key] ">
		<h3 class="title_cate">{$item->getTitle()}</h3>
		<div class="main_item">
				<foreach="$option['product'][$key] as $i => $product">
						{$this->showObj($product,'products')}
				</foreach>
				<div class="clear"></div>
				<div class="views_all"><a href="{$item->getCatUrl('products')}" >{$vsLang->getWords("xemtatca","..Xem tất cả")}</a></div>
		</div>
		</if>
					</foreach>
EOF;
	}

function showObj($obj, $module){
		global $bw,$vsLang,$vsPrint,$vsTemplate,$vsMenu;

		$BWHTML .= <<<EOF
		<div class="item-list col-lg-4 col-md-4 col-sm-6 col-xs-6">
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
