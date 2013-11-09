<?php
class skin_addon {
	///show menu top cho user.SU dung mac dinh co san.Chinh sua mot it cho nhanh.Thanks
	function topmenu($option = array(), $index = 1) {
		global $bw, $vsLang, $vsTemplate;
		
		$BWHTML .= <<<EOF
			<ul class="nav pull-right menu_top{$vsLang->currentLang->getFoldername()}">
				<foreach="$option as $obj">
				<if=" $obj->top ">
				<li>
					<a href="{$obj->getUrl(0)}" title="{$obj->getTitle()}"
						<if=' $obj->getClassActive('active') '>
						style="padding: 0 14px;">
						<span class="btn btn-warning">{$obj->getTitle()}</span>
						<else />
						>
						{$obj->getTitle()}
						</if>
					</a>
				</li>
				</if>
				</foreach>
			</ul>
		
EOF;
		return $BWHTML;
	}
	
	function bottomenu($option = array()) {
		global $bw, $vsLang, $vsTemplate;
		
		$this->index = 0;
		$BWHTML .= <<<EOF
		<div id="footerMenu">
			<foreach=" $option as $menu ">
				<if=" $menu->bottom ">
				<a href="{$menu->getUrl(0)}" title='{$menu->getTitle()}'>{$menu->getTitle()}</a>
				<if="$this->index++ < 3">
					&nbsp;|&nbsp;
				</if>
				</if>
			</foreach>
		</div>							
     	
EOF;
		return $BWHTML;
	}
	
	function portlet_branch($option = array()) {
		global $bw, $vsLang;
	
		$BWHTML .= <<<EOF
			<div class="branch_portlet" >
				<div class="branch_portlet_title">
					{$vsLang->getWords('global_branch_list','Danh sách chi nhánh')}
				</div>
				<div class="branch_list">
					<foreach=" $option as $obj ">		
						<div class='branch-item'>		
							<span class="branch-title">{$obj->getTitle()}</span>
							{$obj->getIntro()}
						</div>
					</foreach>
				</div>
			</div>
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
			<div id="postCodeInner">
				<if=' count($option) '>
				<span class="btn horizontal_scroller-title">
					<img src='{$bw->vars['img_url']}/store.png' style="height: 30px"/>
					{$vsLang->getWords('global_promote', 'Khuyến mãi')}
				</span>
				<div style="float: left;">&nbsp;</div>
				<div>
					<ul id="ticker01">
						<foreach="$option as $obj">
							<li>
								<a href="{$obj->getUrl('promote')}" title='{$obj->getTitle()}'>
									[{$obj->getPostDate('SHORT')}] {$obj->getTitle()}
								</a>
							</li>
						</foreach>
					</ul>
				</div>
											<else />
											<span style='height: 30px;display:block;'>&nbsp;
				</span>
											</if>
				<div class="clear"></div>
			</div>
			<div class='clear'></div>								
EOF;
		return $BWHTML;
	}
	
	function portlet_slideshow($option = array()) {
		global $bw, $vsLang;
	
		$BWHTML .= <<<EOF
			<ol class="carousel-indicators">
				<foreach=" $option as $k => $obj ">
	                <li data-target="#myCarousel" data-slide-to="{$k}" class="active"></li>
				</foreach>
			</ol>
			<div class="carousel-inner">
				<foreach=" $option as $k => $obj ">
	                <div class="item <if=" $k == 0 ">active</if>">
						<p>
							{$obj->createImageCache($obj->file, 1170, 500)}
						</p>
					</div>          
	             </foreach>   
			</div>
									
			<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
  			<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
EOF;
						return $BWHTML;
	}
	
	function portlet_map($branches, $main) {
		global $bw, $vsLang;
	
		$this->index = 1;
		$this->total = count($branches);
		
		$BWHTML .= <<<EOF
			<div class="span5 well">
				<h3 class="center_title detail_title">
		        	<a href="{$bw->base_url}contacts#contact-main-content" title='{$vsLang->getWords("contacts_title", $bw->input[0])}'>
						{$vsLang->getWords("contacts_map_title", 'Bản đồ')}
					</a>
				</h3>
				<div id="contact-map-list">
					<foreach=" $branches as $obj ">
		           		<a class="{$obj->active}" href="{$bw->base_url}contacts/{$obj->getCleanTitle()}-{$obj->getId()}#contact-main-content" title='{$obj->getTitle()}'>
							{$obj->getTitle()}
						</a>
						<if=" $this->index++ < $this->total ">
							 |
						</if>
	                </foreach>
	                <div class='clear'></div>
	           </div>
	           
		        <div class="map">
	           		<div id='map_canvas'></div> 
				</div>
			</div>
		<if=" $main ">
    	<if=" $main->getLongitude() && $main->getLatitude() ">
    		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true&language=vi"></script>
    		<script  type="text/javascript">
    		//key=AIzaSyD2heuHJ0KdL8IPCyE3OYQrARjSjCeVGMI&
			    function init() {
			    	var myHtml = "<h4>{$main->getTitle()}</h4><p>{$main->getAddress()}</p>";

			    	
			      	var map = new google.maps.Map(
			      					document.getElementById("map_canvas"),
			      					{scaleControl: true}
			      				);
			      	map.setCenter(new google.maps.LatLng({$main->getLatitude()},{$main->getLongitude()}));
			      	map.setZoom(15);
			      	map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
	
			      	var marker = new google.maps.Marker({
			      						map: map,
			      						position:map.getCenter()
									});
	
					var infowindow = new google.maps.InfoWindow({
										'pixelOffset': new google.maps.Size(0,15)
									});
			      	infowindow.setContent(myHtml);
			      	infowindow.open(map, marker);
			    }
			      			
			      			
		    	$(document).ready(function(){
					init();
				});
			</script>
		</if>
		</if>		
EOF;
						return $BWHTML;
	}
}