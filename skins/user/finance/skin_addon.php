<?php
class skin_addon {
	///show menu top cho user.SU dung mac dinh co san.Chinh sua mot it cho nhanh.Thanks
	function topmenu($option = array(), $index = 1) {
		global $bw, $vsLang, $vsTemplate;
		
		$this->menu_sub = $vsTemplate->global_template->menu_sub;
		$BWHTML .= <<<EOF
			<ul class="menu_top menu_top{$vsLang->currentLang->getFoldername()}">
                    <foreach="$option as $obj">
                        <li>
                        	<a href="{$obj->getUrl(0)}" title="{$obj->getTitle()}" class="{$obj->getClassActive('active')}">
                        		{$obj->getTitle()}
                        	</a>
                            <if="$vsTemplate->global_template->menu_sub[$obj->getUrl()] || $obj->getChildren()">
                                <ul >
                                    {$obj->getChildrenLi()}
                                </ul>
                            </if>
                        </li>
                    </foreach>
                    <div class="clear_left"></div>
				</ul>
EOF;
		return $BWHTML;
	}
	
	function bottomenu($option = array()) {
		global $bw, $vsLang, $vsTemplate;
		
		$BWHTML .= <<<EOF
		
       	<ul class="menu footer_menu">
	       	<foreach="$option as $obj">
	        	<li><a href="{$obj->getUrl(0)}" class="{$obj->getClassActive()}" title="{$obj->getTitle()}"><span>{$obj->getTitle()}</span></a></li>
	      	</foreach>
        	<div class="clear_left"></div>
     	</ul>
     	
EOF;
		return $BWHTML;
	}
	
	function portlet_slideshow($option = array()) {
		global $bw, $vsLang;
		
		$BWHTML .= <<<EOF
		<div id="slide_face">
         <div class="images">
         	<foreach=" $option as $obj ">
                <div class="slide_item" title='{$obj->getTitle()}'>
                	{$obj->createImageCache($obj->file, 716, 305)}
                </div>          
             </foreach>   
         </div>
         <!-- the tabs -->
                       
         <div class="slidetabs">
         	<foreach=" $option as $obj ">
                <a href="#" title='{$obj->getTitle()}'></a> 
			</foreach>
        </div>
     	<script type='text/javascript'>
             $(function() {
                  $(".slidetabs").tabs(".images > div.slide_item", {
                         effect: 'fade',
                         fadeOutSpeed: "slow",
                         rotate: true,
                         auto:true
                  }).slideshow();
                  $(".slidetabs").data("slideshow").play();
             });
     	</script>
   </div>
   <!-- STOP SLIDE -->
   <if=" $bw->input['module'] == 'home' ">
   <div class="shadow_bottom"><img src="{$bw->vars['img_url']}/shadow.png" /></div>
   </if>
EOF;
		return $BWHTML;
	}
	
	function portlet_recruitment($option = array()) {
		global $bw, $vsLang;
		
		$BWHTML .= <<<EOF
			<div class="sitebar_tuyendung">
	        	<h3 class="center_title">
	        		<a href="{$bw->base_url}recruitment" title="{$vsLang->getWords('global_recruitment','Tuyển dụng')}">
						{$vsLang->getWords('global_recruitment','Tuyển dụng')}
					</a>
				</h3>
				<foreach="$option as $obj">
					<div class="tuyendung_item">
		            	<a href="{$obj->getUrl('recruitment')}" title='{$obj->getTitle()}'>{$obj->getTitle()}</a>
		                <p class='datetime'>[{$obj->getPostDate("SHORT")}]</p>
		                {$obj->getContent()}
		            </div>
				</foreach>
	        </div>
		
EOF;
		return $BWHTML;
	}
	
	function portlet_promote($option = array()) {
		global $bw, $vsLang;
		
		$BWHTML .= <<<EOF
			<div class="sitebar_tuyendung">
	        	<h3 class="center_title">
	        		<a href="{$bw->base_url}promote" title="{$vsLang->getWords('global_promote','Khuyến mãi')}">
						{$vsLang->getWords('global_promote','Khuyến mãi')}
					</a>
				</h3>
				<foreach="$option as $obj">
					<div class="promote_item">
						<if=" $obj->file ">
		            	<a href="{$obj->getUrl('promote')}" class="" title='{$obj->getTitle()}'>
		            		{$obj->createImageCache($obj->file, 120, 120)}
		            	</a>
		            	</if>
		            	<a href="{$obj->getUrl('promote')}" title='{$obj->getTitle()}' class="promote">{$obj->getTitle()}</a>
		                <p>[{$obj->getPostDate("SHORT")}]</p>
		                <div class='clear'></div>
		            </div>
				</foreach>
				<div class='clear'></div>
	        </div>
		
EOF;
		return $BWHTML;
	}
	
	function portlet_partner($option = array()) {
		global $bw, $vsLang;
		
		$BWHTML .= <<<EOF
			<div class="sitebar_quangcao">
				<foreach=' $option as $obj '>
				<a href="{$obj->getWebsite()}" class="quangcao" title='{$obj->getTitle()}'>
					{$obj->createImageCache($obj->file, 306, '')}
				</a>
				</foreach>
            </div>
EOF;
		return $BWHTML;
	}
	
	function portlet_supports($option = array()) {
		global $bw, $vsLang, $vsSettings;
		
		$BWHTML .= <<<EOF
			<div class="support">
	            <p class="hotline">{$vsLang->getWords('global_support', 'Hỗ trợ')}:</p>
	            <foreach="$option as $k => $v">
					<foreach=" $v as $key =>$obj">
						{$obj->showAdvance()}
					</foreach>
				</foreach>
				<div class="link_mangxahoi">
				<p>{$vsLang->getWords('global_follow_us','Theo chúng tôi tại')}:</p>
		        <a href="{$vsSettings->getSystemKey("config_facebook", 'http://www.facebook.com', 'config')}" target='_blank'>
		        	<img src="{$bw->vars['img_url']}/face.png" />
		        </a>
		        <a href="{$vsSettings->getSystemKey("config_twitter", 'http://www.twitter.com', 'config')}" target='_blank'>
		        	<img src="{$bw->vars['img_url']}/tweet.png" />
		        </a>
		        <a href="{$vsSettings->getSystemKey("config_google_plus", 'https://plus.google.com/u/0/', 'config')}" target='_blank'>
		        	<img src="{$bw->vars['img_url']}/google.png" /></a>
		        	</div>
	        </div>
EOF;
		return $BWHTML;
	}
	
	function portlet_about($obj = null) {
		
		
		$lang = $_SESSION['user']['language']['currentLang']['langFolder'];
		$BWHTML .= <<<EOF
		    <div class="about_home about_home_{$lang}">
		    	<span class="about_home_title">{$obj->getTitle()}</span>
		        <p>{$obj->getIntro()}</p>
		    </div>
  
EOF;
		return $BWHTML;
	}
	
	function portlet_productcategory($option) {
		global $bw, $vsLang;
		
		$BWHTML .= <<<EOF
		<if=" $option ">
			<h3 class="sitebar_title">{$vsLang->getWords('global_productcategory', 'Danh mục sản phẩm')}</h3>
			<div class="product_list">
			<ul id='menu'>
				{$option}
			</ul>
			</div>
		</if>		
  
EOF;
		return $BWHTML;
	}
	
	function portlet_service($option) {
		global $bw, $vsLang;
		
		$BWHTML .= <<<EOF
		<if=" $option ">
			<div id="slide_dichvu">
     			<div class="next_home">prev</div>
			    <div class="slide_item_home">
			    	<ul>
			    		<foreach=' $option as $obj '>
			    		<li>
			    			<a href="{$obj->getUrl("service")}" title='{$obj->getTitle()}' class='service_img'>
			    				<span>{$obj->createImageCache($obj->file, 205, 127)}</span>
			    			</a>
			    			<h3><a href="{$obj->getUrl("service")}" title='{$obj->getTitle()}'>{$obj->getTitle()}</a></h3>
			    			<p>{$obj->getContent(200)}</p>
			    		</li>
			    		</foreach>
					</ul>
			     </div>
			     <div class="prev_home">next</div>
			</div>
		</if>		
EOF;
		return $BWHTML;
	}
	
	function portlet_search() {
		global $bw, $vsLang, $vsTemplate;
		
		$stringSearch = $vsLang->getWords ( 'global_tim', 'Tìm kiếm sản phẩm...' );
		$BWHTML .= <<<EOF
                
                <div class="search_top" id='global_search'>
		        	<input id='keySearch' class="input_text" type="text" onfocus="if(this.value=='{$stringSearch}') this.value='';" onblur="if(this.value=='') this.value='{$stringSearch}';" value="{$stringSearch}" />
		            <input type="submit" value="" class="search_btn" id='submit_form_search'/>
		        </div>
		        
		        <script language="javascript" type="text/javascript">
		        $(document).ready(function(){
		        	$("#keySearch").keydown(function(e){
		        		var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
		        		if(e.keyCode==13) return $('#submit_form_search').click();
		        	});
                
		        	$('#global_search').submit(function(){
	                    if($('#keySearch').val()==""||$('#keySearch').val()=="{$stringSearch}") {
	                        jAlert('{$vsLang->getWords('global_tim_thongtin', 'Vui lòng nhập thông tin cần tìm kiếm')}',
	                        '{$bw->vars['global_websitename']} Dialog');
	                        return false;
	                    }
	                    return true;
                	});
                	$('#submit_form_search').click(function()  {
				         if($('#keySearch').val()==""||$('#keySearch').val()=="{$stringSearch}") {
				             jAlert('{$vsLang->getWords('global_tim_thongtin','Vui lòng nhập thông tin cần search:please!!!!!')}',
				                        '{$bw->vars['global_websitename']} Dialog');
				                return false;
				           }
				           str =  $('#keySearch').val()+"/";
				            document.location.href="{$bw->base_url}searchs/"+ str;
				            return;
				     });
                });
                </script> 
       	
EOF;
		return $BWHTML;
	}
	
	function portlet_dropdown_weblink($option = array()) {
		global $bw, $vsLang, $vsMenu, $vsStd, $vsPrint;
		$vsPrint->addJavaScriptString ( 'global_weblink', '
    			   $("#link").change(function(){
                               if($("#link").val())
                                    window.open($("#link").val(),"_blank");
                            });
    		' );
		
		$BWHTML .= <<<EOF
		    <div class='web_link'>
		    	<form>
                    <select class="styled" id="link">
                    	<option value="0">{$vsLang->getWordsGlobal('global_lienket','Liên kết')}</option>
                        <foreach="$option as $wl">
                            <option value="{$wl->getWebsite()}"> {$wl->getTitle()}</option>
                        </foreach>       
                    </select>
				</form>
            </div>
        
EOF;
		return $BWHTML;
	}
}
?>