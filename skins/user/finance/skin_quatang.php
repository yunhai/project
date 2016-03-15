<?php
class skin_quatang extends skin_home{

function showDetail($obj,$option){
		global $bw,$vsLang,$vsPrint,$vsTemplate;
		

		
		$BWHTML .= <<<EOF
	
                <h3 class="title_cate">{$vsLang->getWords($option['cate'],'Quà Tặng')}</h3>
                <div class="main_item main_detail_h">
                    <if="$obj->file">	
                        <div class="img_pro" ><a class="thickbox"  href="{$obj->getCacheImagePathByFile($obj->file,1,1,1,1,$obj->getTitle())}">{$obj->createImageCache($obj->file,302,235,1,0,$obj->getTitle())}</a></div>
                    </if>
                    <h3 class="title_pro_detail">{$obj->getTitle()}</h3>
                    <div class="price">Mã: <span>{$obj->getCode()}</span> </br>
                    {$vsLang->getWords('gia',' Giá: ')} <span>{$obj->getPrice()}</span></div>
                    <div class="order_chi"><a   href="{$bw->base_url}orders/addtocart/{$obj->getId()}">{$vsLang->getWords("dathang","+ Đặt hàng")}</a></div>
                    <p class="content_pro"> {$obj->getContent()}</p>
                </div>
                
                <div class="clear"></div>
                <if="$option['other']">
                    <h3 class="title_cate">{$vsLang->getWords('sanphamkhac','Sản Phẩm Khác')}</h3>
                    <div class="main_item">
                        <foreach="$option['other'] as $obj">
                            {$this->showObj($obj,'quatang')}
                        </foreach>  
                    </div>
                </if>

EOF;
	}
	
function showDefault($option){
	global $bw,$vsLang,$vsPrint,$vsTemplate;

		$BWHTML .= <<<EOF
	
                <h3 class="title_cate">{$vsLang->getWords($option['cate'],'Quà Tặng')}</h3>
                <div class="main_item">
                <foreach="$option['pageList'] as $obj">
                    {$this->showObj($obj,'quatang')}
                </foreach>                     
                  <div class="clear"></div>
                    <if="$option['paging']">
                        <div class="page">
                            {$option['paging']}
                        </div>
                    </if>
                </div>
              
    <!-- STOP CENTER -->
    

EOF;
	}

	

}
?>