<?php
class skin_products extends skin_home{

//sanpham
function showDefault($option){
	global $bw,$vsLang,$vsPrint,$vsTemplate;
        $this->vsLang=$vsLang;
	$this->bw=$bw;
		$BWHTML .= <<<EOF

                <foreach="$option['cate'] as $ke => $va">
                    <if="$option[$ke]">
                        <h3 class="title_cate">{$va->getTitle()}</h3>
                        <div class="main_item">
                            <foreach="$option[$ke] as $k => $v">
                                {$this->showObj($v,'products')}
                            </foreach>
                            <div class="clear"></div>
                            <div class="views_all"><a href="{$va->getCatUrl($bw->input["module"])}" >{$vsLang->getWords("xemtatca","..Xem tất cả")}</a></div>
                        </div>
                    </if>
                </foreach>

EOF;
	}



function showDefault_cate($option){
	global $bw,$vsLang,$vsPrint,$vsTemplate;

		$BWHTML .= <<<EOF


                <h3 class="title_cate">{$option['cate']->getTitle()}</h3>
                <div class="main_item">
                    <foreach="$option['pageList'] as $obj">
                        {$this->showObj($obj,'products')}
                    </foreach>
                </div>

        	<if="$option['paging']">
                    <div class="page">
                        {$option['paging']}
                    </div>
                </if>



EOF;
	}





function showDetail($obj,$option){
		global $bw,$vsLang,$vsPrint,$vsTemplate,$vsMenu;


		$BWHTML .= <<<EOF



            <h3 class="title_cate">{$option['cate']->getTitle()}</h3>
                <div class="main_item main_detail_h">
                    <if="$obj->file">
                        <if="$bw->isMobile">
                        <div class="img_pro">{$obj->createImageCache($obj->file,302,235,1,0,$obj->getTitle())}</div>
                        </if>
                        <if="!$bw->isMobile">
                        <div class="img_pro"><a tittle="{$obj->getTitle()}" class="thickbox" href="{$obj->getCacheImagePathByFile($obj->file,1,1,1,1,$obj->getTitle())}">{$obj->createImageCache($obj->file,302,235,1,0,$obj->getTitle())}</a></div>
                        </if>
                    </if>
                    <h3 class="title_pro_detail" >{$obj->getTitle()}</h3>
                    <div class="price">Mã: <span>{$obj->getCode()}</span></br>
                    {$vsLang->getWords("gia"," Giá:")}   <span>{$obj->getPrice()}</span></div>
                    <div class="order_chi"><a  href="{$bw->base_url}orders/addtocart/{$obj->getId()}">{$vsLang->getWords("dathang","+ Đặt hàng")}</a></div>

                    <p class="content_pro"> {$obj->getContent()}</p>
                </div>
                <div class="clear"></div>
                <if="$option['other']">
                    <h3 class="title_cate">{$vsLang->getWords("sanphamkhac","Sản phẩm khác")}</h3>
                    <div class="main_item">
                        <foreach="$option['other'] as $obj">
                            {$this->showObj($obj,'products')}
                        </foreach>
                    </div>
                </if>



EOF;
	}













	function loadProduct($option){
		global $bw,$vsLang, $vsPrint;

		$BWHTML .= <<<EOF


        <foreach="$option as $obj">
        <div class="thiettritontuong_item">
                <div class="motasp">
                        	<div class="mota_text">
                            	{$obj->getIntro()}
                            </div>
                            <a href="{$bw->base_url}orders/addtocart/{$obj->getId()}/" class="mota_dathang">Đặt hàng</a>
                            <a href="{$obj->getUrl($bw->input['module'])}" class="mota_chitiet">Chi tiết</a>
                        </div>
        	<p class="thiettritontuong_img"><a href="{$obj->getUrl($bw->input['module'])}" title="{$obj->getTitle()}">{$obj->createImageCache($obj->file, 279,320, 1, 0)}</a></p>
            <p class="thiettritontuong_intro"><a href="{$obj->getUrl($bw->input['module'])}"><span>{$obj->getTitle()}</span></a></p>
      	</div>
        </foreach>

EOF;
}






function getSearchPro($pro){
    global $vsLang,$bw,$vsMenu,$vsTemplate;
    $stringSearch = $vsLang->getWords('global_search_key1','Tên hoặc mã sản phẩm...');
    //$this->procate = $vsMenu->getCategoryGroup ( 'products',array('status'=>true))->getChildren();
    $this->model = $vsMenu->getCategoryGroup('model')->getChildren();

    	$BWHTML .= <<<EOF


        <div class="search_product">
            <input type="text" id="keySearch" onfocus="if(this.value=='{$stringSearch}') this.value='';" onblur="if(this.value=='') this.value='{$stringSearch}';" value="{$stringSearch}"  />
             <select class="select" name="generator" id="model">
            <option value="0">{$vsLang->getWords('model_css','Theo chất liệu')}...</option>
            <foreach="$this->model as $key => $ct1 ">
                                <option value="{$key}">{$ct1->getTitle()}</option>

                            </foreach>
            </select>
            <input type="button" name="search" id="submit_form_search" value="tìm kiếm" class="search_btn">

	</div>
        <div class="support">
                	{$vsTemplate->global_template->portlet_supports}
                </div>


<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		$("#keySearch").keydown(function(e){
        	if(e.keyCode==13){
          	var str =  $('#keySearch').val();
    		if(str=="" || str =="{$stringSearch}")return false;
                $('#submit_form_search').click();
                }
  		})
    	$('#submit_form_search').click(function()  {

        	if($('#keySearch').val()==""||$('#keySearch').val()=="{$stringSearch}") {
           		jAlert('{$vsLang->getWords('global_tim_thongtin','Vui lòng nhập thông tin cần search:please!!!!!')}',
                        '{$bw->vars['global_websitename']} Dialog');
               	return false;
          	}
          	str =  $('#model').val()+"-"+$('#keySearch').val()+"/";
           	document.location.href="{$bw->base_url}products/search/"+ str;
           	return;
    	});

	});
</script>
EOF;
}









}
?>
