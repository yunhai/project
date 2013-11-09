<?php
class Product extends BasicObject {	
	private $clearSearch = NULL;
	private $hot		= NULL;
	private $spec		= NULL;
	private $label		= NULL;
	private $model		= NULL;

	function __construct() {
		parent::__construct ();
	}

	function __destruct() {
		parent::__destruct ();
		unset ( $this->ship);
		unset ( $this->hot);
		unset ( $this->price );
		
		unset ( $this->cleanTitle);
		unset ( $this->cleanContent);
	}
	function convertToDB() {
		$dbobj = parent::convertToDB('product');
    	isset ( $this->postdate )       ? ($dbobj ["productPostDate"]   = $this->postdate) : "";
    	isset ( $this->hot)           	? ($dbobj ['productHot']	 = $this->hot) : '';
      	isset ( $this->price)           ? ($dbobj ['productPrice']	 = $this->price) : '';
		
		isset ( $this->clearSearch )  	? ($dbobj ['productClearSearch']   = $this->clearSearch) : '';
		if(isset ( $this->intro ) || isset($this->content) || isset ( $this->title )){
			$cleanContent = VSFTextCode::removeAccent($this->title)." ";
			$cleanContent .= VSFTextCode::removeAccent(strip_tags($this->getIntro()))." ";
			$cleanContent.= VSFTextCode::removeAccent(strip_tags($this->getContent()));
			$dbobj['productClearSearch'] = $cleanContent;
		}
      	 return $dbobj;
	}
	function convertToObject($object) {
		global $vsMenu;
       	parent::convertToObject($object,'product');
		
		isset ( $object ['productPostDate'] )   ? $this->setPostDate( $object ['productPostDate'] ) : '';
		isset ( $object ['productPrice'] )      ? $this->setPrice( $object ['productPrice'] )       : '';
    	isset ( $object ['productClearSearch'] )? $this->clearSearch = $object ['productClearSearch'] : '';
		isset ( $object ['productHot'] ) 		? $this->hot = $object ['productHot'] : '';
	}
	

	function convertOrderItem() {
		global $bw, $vsPrint;
		
		if(!$this->getId())$vsPrint->boink_it($bw->vars['board_url']);
		
		$item = array ( 'productId'   	=> $this->getId(),
						'itemPrice'   	=> $this->getPrice(false),
						'itemTitle'   	=> $this->getTitle(),
						'itemStatus'	=> 0,
						'itemQuantity'  => 1
                                );
		return $item;
 
	}
	
	function getPrice($number=true, $raw = false) {
		global $vsLang;
		if ((APPLICATION_TYPE=='user' || $raw) && $number){
			if ($this->price>0){
				return number_format ( $this->price,0,"",".").'&nbsp;'.$vsLang->getWords('global_unit','VND');
			}
			return $vsLang->getWords('callprice','Call');
		}
		return $this->price;
	}
	
	function getHot($number=true) {
		global $vsLang;
		if (APPLICATION_TYPE=='user' && $number){
			if ($this->hot > 0){
				return number_format ( $this->hot, 0, "", "." ).$vsLang->getWords('global_unit', 'VND');
			}
			return $vsLang->getWords('callprice','Call');
		}
		return $this->hot;
	}

	function setPrice($price) {
		$this->price = $price;
	}

	function getContent($size=0, $br = 0, $tags = "") {
		global $vsCom;

		$parser = new PostParser ();
		$parser->pp_do_html = 1;
		$parser->pp_nl2br = $br;
		
		$content = $parser->post_db_parse($this->content);
		if($size){
			if($tags) $content = strip_tags($content, $tags);
			else $content = strip_tags($content);
			return VSFTextCode::cutString($content, $size);
		}
		return $content;
	}
}