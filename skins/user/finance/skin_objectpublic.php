<?php
class skin_objectpublic extends skin_board_public{
	function showDefault($option = array()) {
		global $bw;
		
		$BWHTML .= <<<EOF
	
EOF;
	}
	
	
function loadTour($option = array()) {
		global $bw;
		$BWHTML .= <<<EOF
		
		<foreach="$option as $key=>$value">
	    	<div class="tourtop_item">
	    		<div class="im"><a href="{$value->getUrl($value->getModule())}">{$value->createImageCache($value->getImage(),260,178)}</a></div>
	       	 	<div class="tour_ct">
	                <div class="left">
	                    <h2 class="na"><a href="{$value->getUrl($value->getModule())}">{$value->getTitle()}</a></h2>
	                    <div class="num">{$value->getNumber()}</div>
	                    <div class="intro">{$value->getIntro()}</div>
	                </div>
	                <div class="right">
	                    <div class="star">{$value->getStar()}</div>
	                    <div class="price">{$value->getPrice()}</div>
	                    <div class="time">Ngày/đêm</div>
	                    <a href="{$bw->base_url}bookings/tour/{$value->getId()}" class="booking_color bookTour">Đặt tour</a>
	                </div>
	        	</div>
	    	</div>
    	</foreach>
		
EOF;
	}
	
	
function loadTourDefault($option = array()) {
		global $bw;
		$BWHTML .= <<<EOF
		
		<foreach="$option as $key=>$value">
	    	 <div class="tour_item">
	        	<div class="im"><a href="{$value->getUrl($value->getModule())}">{$value->createImageCache($value->getImage(),260,178)}</a></div>    
	            <div class="ser">
	            	<div class="na"><a href="{$value->getUrl($value->getModule())}">{$value->getTitle()}</a></div>
	                <div class="phone">ĐT: {$value->getPhone()}</div>
					<div class="ser_item">
	                	{$value->getOptionIcon()}
	                </div>
	                <div class="clear"></div>
	                <div class="note"></div>
	                <ul>{$value->getIntro()}</ul>
	            </div> 
	            <div class="booking">
	            	<div class="line"></div>
	            	<div class="star">{$value->getStar()}</div>
	                <div class="price">{$value->getPrice()}</div>
	                <div class="time">Ngày/đêm</div>
	                <a href="{$bw->base_url}bookings/tour/{$value->getId()}"  class="booking_color bookTour">Đặt tour</a>
	            </div>      
	        </div>
	        
    	</foreach>
		
EOF;
	}	
	

	
	
	
	
	
	
}
?>