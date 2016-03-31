<?php
class skin_addon {
	///show menu top cho user.SU dung mac dinh co san.Chinh sua mot it cho nhanh.Thanks
	function showMenuTopForUser($option= array()) {
		global $bw, $vsLang ,$vsTemplate;

		$BWHTML .= <<<EOF
        <nav class="visible-lg" id="max-menu-page">
	        <ul class="menu_top">
	            <foreach="$option as $obj">
	                <li>
						<a title="{$obj->getAlt()}" href="{$obj->getUrl(0)}" class="{$obj->getClassActive()}" >{$obj->getTitle()}</a>
	                    <if="$vsTemplate->global_template->menu_sub[$obj->getUrl()] || $obj->getChildren()">
	                        <ul >
	                            {$vsTemplate->global_template->menu_sub[$obj->getUrl()]}
	                            {$obj->getChildrenLi($vsTemplate->global_template->menu_sub)}
	                        </ul>
	                    </if>
	                </li>
	                <span></span>
	            </foreach>
	     		</ul>
        </nav>
                <!-- #max-menu-page -->
                <nav data-fix-extend="#min-menu-page" class="open-m-extend hidden-lg" id="nav-menu-page">
                    <button class="btn btn-info btn-xs"><i class="zmdi zmdi-hc-3x zmdi-view-headline"></i></button><div class="lbl"></div>
                </nav>
                <div class="m-extend-overlay close-m-extend"></div>
                <nav class="m-extend m-extend-fix-left min-menu-page" id="min-menu-page">
                <div class="title">Menu</div>
                <ul class="lv1">
                    <foreach="$option as $obj">
                        <if="$vsTemplate->global_template->menu_sub[$obj->getUrl()] || $obj->getChildren()">
                            <li class="have-child"><a title="{$obj->getAlt()}" href="javascript:;" class="{$obj->getClassActive()}" >{$obj->getTitle()}</a>
                            <ul class="lv2">
                                {$vsTemplate->global_template->menu_sub[$obj->getUrl()]}
                                {$obj->getChildrenLi($vsTemplate->global_template->menu_sub)}
                            </ul>
                        <else />
                            <li><a title="{$obj->getAlt()}" href="{$obj->getUrl(0)}" class="{$obj->getClassActive()}" >{$obj->getTitle()}</a>
                        </if>
                        </li>
                    </foreach>
                </ul>
                <div data-fix-extend="#min-menu-page" class="exit close-m-extend">
                    <i class="zmdi zmdi-close zmdi-hc-fw"></i>
                </div>
                </nav><!-- #min-menu-page -->

EOF;
		return $BWHTML;
	}

	function showMenuBottomForUser($option= array()) {

		global $bw, $vsLang, $vsTemplate;

		$BWHTML .= <<<EOF
		<nav data-fix-extend="#min-menu-page2" class="open-m-extend hidden-lg" id="nav-menu-page2">
				<button class="btn btn-info btn-xs"><i class="zmdi zmdi-hc-3x zmdi-view-headline"></i></button><div class="lbl"></div>
		</nav>
		<div class="m-extend-overlay close-m-extend"></div>
		<nav class="m-extend m-extend-fix-left min-menu-page" id="min-menu-page2">
			<div class="title">Menu</div>
			<ul class="lv1">
					<foreach="$option as $obj">
							<li><a title="{$obj->getAlt()}" href="{$obj->getUrl(0)}" class="{$obj->getClassActive()}" >{$obj->getTitle()}</a></li>
					</foreach>
			</ul>
			<div data-fix-extend="#min-menu-page2" class="exit close-m-extend">
					<i class="zmdi zmdi-close zmdi-hc-fw"></i>
			</div>
		</nav><!-- #min-menu-page -->
		<ul class="menu_footer visible-lg">
				<foreach="$option as $obj">
						<li><a href="{$obj->getUrl(0)}" class="{$obj->getClassActive()}" title="{$obj->getTitle()}"><span>{$obj->getTitle()}</span></a></li>
				</foreach>
				<div class="clear_left"></div>
		</ul>

	EOF;
		return $BWHTML;
	}

	function showProductFilterPortlet($option= array()) {
		global $bw, $vsLang, $vsTemplate;

 		$this->filter = $bw->input['filter'];
		$this->priceList = array(
			'0' => $vsLang->getWords('global_product_filter_price_0', 'Tất cả'),
			'100-500' => $vsLang->getWords('global_product_filter_price_1', '100,000 ~ 500,000'),
			'500-1000' => $vsLang->getWords('global_product_filter_price_2', '500,000 ~ 1,000,000'),
			'1000-2000' => $vsLang->getWords('global_product_filter_price_3', '1,000,000 ~ 2,000,000'),
			'2000-5000' => $vsLang->getWords('global_product_filter_price_4', '2,00,000 ~ 5,000,000'),
			'5000' => $vsLang->getWords('global_product_filter_price_5', '5,000,000 trở lên')
		);
		$BWHTML .= <<<EOF
			<div class='products-filter-portlet main_cate_left'>
				<form action='{$bw->base_url}products/filter' method='post'>
					<h3 class='header'>{$vsLang->getWords('global_product_filter', 'Tư vấn chọn hoa')}</h3>
					<div class='body'>
						<span class='filter-title'>{$vsLang->getWords('global_product_filter_category', 'Chủ đề')}</span>
						<div class='filter-criteria'>
							<select name='filter[category]'>
								<option value='0'> {$vsLang->getWords('global_product_filter_category_all', 'Tất cả')}</option>
								<foreach="$option['category'] as $obj">
									<option value='{$obj->getId()}' <if="$obj->getId() == $this->filter['category']">selected</if>>{$obj->getTitle()}</option>
								</foreach>
							</select>
						</div>
						<span class='filter-title'>{$vsLang->getWords('global_product_filter_price', 'Mức giá')}</span>
						<div class='filter-criteria'>
							<select name='filter[price]'>
								<foreach="$this->priceList as $key => $val">
									<option value='{$key}' <if="$key == $this->filter['price']">selected</if>>{$val}</option>
								</foreach>
							</select>
						</div>
						<span class='description'>{$vsLang->getWords('global_product_filter_description', '* Bạn có thể gọi nhanh cho chúng tôi theo số 0936 65 27 27 để đặt hoa theo thiết kế riêng')}</span>
						<div class='button-bar text-center'>
							<input type='submit' class='btn btn-primary' value='{$vsLang->getWords('global_product_filter_submit', 'Gửi')}' />
						</div>
					</div>
				</form>
			</div>
EOF;
		return $BWHTML;
	}





function getvideos($o){
		global $bw,$vsLang;


$BWHTML .= <<<EOF
 <h3 class="title_cate">Video</h3>
                <div class="main_item main_video">
                	<div class="prev_video">prev</div>
                	<div class="video_home">
                	<ul>
                	<foreach="$o as $obj">

                    	<li><img  id="videos_obj_code_img" style="" width="141" height="112" src="http://img.youtube.com/vi/{$obj->getAddress()}/2.jpg" /></li>
                     </foreach>

                     </ul>


                	</div>
                	<div class="next_video">next</div>
				</div>
EOF;
		//--endhtml--//
return $BWHTML;



/***<script type="text/javascript">

 $(document).ready( function(){
		$('.cate_top').find('li:first').addClass('cate_top_first');
		$('.cate_top').find('li:last').addClass('cate_top_last');
	  $(window).load(function() {
        $('#slider').nivoSlider();

    });
	$('.item_images').find('span').hide();
	$('.item_images').hover(function(){
			$(this).find('span').fadeIn(100);
			$(this).find('h3').css({'font-size':'12px'});
			//$(this).find('img').fadeTo("slow", 0.33);

		},function(){
			$(this).find('span').hide();
			$(this).find('h3').css({'font-size':'0px'});
		 });

 $(".video_home").jCarouselLite({
			btnNext: ".next_video",btnPrev: ".prev_video",speed:3500,visible:7,vertical:false,auto:1
		});



	});

</script>***/
	}
function showMenuTopForPro($option= array()) {
		global $bw, $vsLang ,$vsTemplate;

		$BWHTML .= <<<EOF

     	<ul class="menu_top menu_top_intro">
									<li><a href="{$bw->vars['board_url']}/home">Diệu Tướng Am </li>
                                    {$vsTemplate->global_template->menu_sub['gallerys123']}

     	</ul>

EOF;
		return $BWHTML;
	}




	function portlet_supports($option= array()) {
		global $bw, $vsLang;

				$BWHTML .= <<<EOF
		<if="$option">

	    	<foreach=" $option as $key =>$obj">
            	{$obj->show()}

       		</foreach>

		</if>


EOF;
		return $BWHTML;
	}


	function portlet_banner($option) {
		global $bw, $vsLang,$vsPrint,$vsTemplate;
        $vsPrint->addCurentJavaScriptFile("jquery.prettyPhoto");
 		$vsPrint->addCurentJavaScriptFile("jquery.aviaSlider.min");
 		$vsPrint->addCSSFile('style');
		$BWHTML .= <<<EOF
    	<if="$option">
    	<div class="banner">
            <ul class='aviaslider' id="frontpage-slider">
				<foreach="$option as $slide">
                	<li>{$slide->show(987,255)}</li>
               	</foreach>
			</ul>
        </div>

		</if>

EOF;
	}



	function portlet_weblink($option=array()){
		global $bw,$vsLang,$vsMenu,$vsStd,$vsPrint;

		$BWHTML .= <<<EOF

      	<div class="lienketweb">
                	<h3>{$vsLang->getWordsGlobal("global_lienketweb","Liên kết website")}:</h3>
                    <div class="lienketweb_content">
                        <foreach="$option as $wl">
                        <a href="{$wl->getWebsite()}" target="_blank">
                        <if="$wl->getImage()">
                        {$wl->createImageCache($wl->getImage(),200,35,4)}
                        <else />
						{$wl->getWebsite()}
						</if>
						</a>
                        </foreach>
                    </div>
                    <div class="lienket_bottom"><img src="{$bw->vars['img_url']}/lienket_bottom.jpg" /></div>
                </div>


EOF;
   		return $BWHTML;
	}

function portlet_dropdown_weblink($option=array()){
		global $bw,$vsLang,$vsMenu,$vsStd,$vsPrint;
		$vsPrint->addJavaScriptString ( 'global_weblink', '
    			   $("#link").change(function(){
                               if($("#link").val())
                                    window.open($("#link").val(),"_blank");
                            });
    		' );

		$BWHTML .= <<<EOF
            <form class="lienket">

                    <select id="link" class="styled">
                    	<option value="0">---{$vsLang->getWordsGlobal("global_lienketweb","Liên kết website")}---</option>
                        <foreach="$option as $wl">
                            <option value="{$wl->getWebsite()}" > {$wl->getTitle()}</option>
                    	</foreach>
                    </select>

            </form>





EOF;
   		return $BWHTML;
	}

	function portlet_partner($option) {
		global $bw, $vsLang,$vsPrint;


		$BWHTML .= <<<EOF

      	<if="$option">
      	<div class="banner_top">
		<div class="banner_shadow"></div>
	    <ul id="banner_page">
	    	<foreach="$option as $obj">
	    	<li>{$obj->createImageCache($obj->file,988,363,1)}</li>
	        </foreach>
	    </ul>
		</div>
      </if>






EOF;
	}

function portlet_search($option){
		global $bw, $vsLang,$vsPrint,$vsTemplate,$vsSettings;
		$stringSearch = $vsLang->getWords('search_key','Từ khóa tìm kiếm...');

		$BWHTML .= <<<EOF

        <form cclass="search_top search_form" name='form_search' id='form_search' method='GET' action="http://www.google.com/search"  name="google-search">
		<input type="hidden" name="sitesearch" value="{$bw->vars['board_url']}" />
            <input id="keySearch" name="q" type="text" placeholder="Tìm kiếm"  class="input_text" />
        	<input type="submit" name="sa" value="" class="search_btn" id='submit_form_search'/>
        	<div class="clear_left"></div>
       	</form>

        <script language="javascript" type="text/javascript">
	$(document).ready(function(){
		$("#keySearch").keydown(function(e){
        	if(e.keyCode==13)
          	var str =  $('#keySearch').val();
    		if(str=="")return false;
  		})
    	$('#submit_form_search').click(function()  {
            if($('#keySearch').val()=="") {
                jAlert('{$vsLang->getWords('global_tim_thongtin','Vui lòng nhập thông tin cần search:please!!!!!')}','{$bw->vars['global_websitename']} Dialog');
                return false;
            }
    	});

	});
</script>

EOF;
	}




}
?>
