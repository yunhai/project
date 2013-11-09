<?php
class skin_home {
	
	function showDefault($option) {
		global $bw, $vsTemplate, $vsLang, $vsPrint, $vsSettings;
		$lang = $_SESSION['user']['language']['currentLang']['langFolder'];
		
		$BWHTML .= <<<EOF
			
		<div id="bodyLowerSection">
			<foreach=" $option['category'] as $key => $category ">
				<if=" $option['item'][$key] ">
				<div class="container">
					<section class="menu-list">
						<div class="box">
							<h4 class='notice-title'>
								<span>
									<img class="noodle-icon" src='{$bw->vars['img_url']}/noodle.png' alt='{$category->getTitle()}' />
								</span>
								{$category->getTitle()}
							</h4>
						</div>
						<div class="row">
							<foreach=" $option['item'][$key] as $item ">			
							<div class="span4 simpleCart_shelfItem">
								<div class="well well-small">
									<div class="displayImg">
										{$item->createImageCache($item->getImage(), 187, 150, 0, 1)}	
									</div>
									<h3 class="price">
										<span class="item_price" title='{$item->getTitle()}'>{$item->getTitle()}</span>
										<span class="item_price" title='{$item->getTitle()}'>{$item->getPrice()}</span>
									</h3>
								</div>
							</div>
							</foreach>
						</div>
					</section>
				</div>
				</if>
			</foreach>


			<div class="container">
				<div class="accordion" id="accordion2">
					<div class="accordion-group">
						<div class="accordion-heading">
							<h4>
								<a class="accordion-toggle collapsed" data-toggle="collapse"
									data-parent="#accordion2" href="#collapseOne"> 
									{$option['about']->getTitle()}
								</a>
							</h4>
						</div>
						<div id="collapseOne" class="accordion-body collapse" style="height: 0px;">
							<div class="accordion-inner">
								{$option['about']->getContent()}
							</div>
						</div>
					</div>
				</div>

				<h5 class="cntr" id='working_time'>
					{$vsSettings->getSystemKey("config_open_time", 'Opening time:  Monday-Thrusday 5:30 to 11:00, Friday - Saturday  5:00 to 11:00 & Sunday 5:30 to 10:30', 'config')}
										
				</h5>
			</div>
		</div>
EOF;
		return $BWHTML;
	}
}
?>