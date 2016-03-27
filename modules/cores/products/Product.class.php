<?php
class Product extends BasicObject {

  	//private $urlvideo = NULL;
  	private $module = NULL;
	private $clearSearch = NULL;
        private $congsuat = NULL;
        private $congsuatlientuc = NULL;
		private $model = NULL;
		private $dongco = NULL;
		private $dauphat = NULL;
		private $productflash = NULL;

	function __construct() {
		parent::__construct ();
	}

	function __destruct() {
		parent::__destruct ();
		unset ( $this->price );
		unset ( $this->hotPrice );
		//unset ( $this->urlvideo );
		unset ( $this->module );
		unset ( $this->cleanTitle);
         unset ($this->seo);

	}
	public function convertToDB() {
		$dbobj = parent::convertToDB('product');
    	isset ( $this->postdate )       ? ($dbobj ["productPostDate"]   = $this->postdate) : "";
      	isset ( $this->price)           ? ($dbobj ['productPrice']	 = $this->price) : '';
       	isset ( $this->hotPrice)	? ($dbobj ['productHotPrice']	 = $this->hotPrice) : '';
       //	isset ( $this->urlvideo)	? ($dbobj ['productUrlVideo']	 = $this->urlvideo) : '';
		isset ( $this->productflash )  ? ($dbobj ['productflash']       = $this->productflash) : '';

		isset ( $this->clearSearch )  ? ($dbobj ['productClearSearch']       = $this->clearSearch) : '';
		isset ( $this->module )  ? ($dbobj ['productModule']       = $this->module) : '';
        isset ( $this->seo )  ? ($dbobj ['productSEO']       = $this->seo) : '';


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
		isset ( $object ['productIntroImage'] )   ? $this->setImage( $object ['productIntroImage'] ) : '';
		isset ( $object ['productPostDate'] )   ? $this->setPostDate( $object ['productPostDate'] ) : '';
		isset ( $object ['productPrice'] )      ? $this->setPrice( $object ['productPrice'] )       : '';
		isset ( $object ['productflash'] )      ? $this->setPrice( $object ['productflash'] )       : '';
		//isset ( $object ['productUrlVideo'] )      ? $this->setUrlVideo( $object ['productUrlVideo'] )       : '';
    	isset ( $object ['productHotPrice'] )   ? $this->setHotPrice( $object ['productHotPrice'] ) : '';
    	isset ( $object ['productModule'] )   ? $this->setModule( $object ['productModule'] ) : '';
    	isset ( $object ['productClearSearch'] )   ? $this->setCleanSearch ( $object ['productClearSearch'] ) : '';

    	isset ( $object ['productSEO'] )   ? $this->setSEO ( $object ['productSEO'] ) : '';

	}

        function getNameModel($array = array()){
            if($array[$this->model])return $array[$this->model]->getTitle();

        }


	public function getModule() {
			return $this->module;
		}

	public function setModule($module) {
			$this->module = $module;
		}
	public function getSEO() {
			return $this->seo;
		}

	public function setSEO($seo) {
			$this->seo = $seo;
		}
	// get set cong suat lien tuc

	public function setFileupload($file) {
			$this->productflash = $file;
		}

	  	public function getFileupload() {
			return $this->productflash;
		}











  	public function getPrice($number=true, $force = false) {
		global $vsLang;
		if (APPLICATION_TYPE=='user' && $number){
			if ($this->price>0){
				return number_format ( $this->price,0,"","." )." VNĐ";
			}
			return $vsLang->getWords('callprice','Call');
		}
		return $number&&force ? number_format ($this->price ,0, "", ",") : $this->price;
	}



        public function getHotPrice($number=true) {
		global $vsLang;
		if (APPLICATION_TYPE=='user' && $number){
			if ($this->hotPrice>0){
				return number_format ( $this->hotPrice,0,"","." );
			}
			return $vsLang->getWords('callprice','Call');
		}
		return $this->hotPrice;
	}

        public function setPrice($price) {
		$this->price = $price;
	}

        public function setHotPrice($price) {
		$this->hotPrice = $price;
	}

 	public function getUrlVideo() {
		return $this->urlvideo;
	}
function getUrl1() {
		global $bw;

		return $bw->base_url . "{$this->module}/detail/".strtolower(VSFTextCode::removeAccent(str_replace("/", '-', trim($this->title)),'-')). '-' . $this->getId () . '.html';
	}
  	public function setUrlVideo($url) {
		$this->urlvideo = $url;
	}
	public function getPlayer(){
			$youtube = strpos($this->urlvideo, "youtube");
			$vimeo = strpos($this->urlvideo, "vimeo");

			if ($youtube){
				$id = str_replace("=", "/", substr($this->urlvideo,strpos($this->urlvideo, "?")+1));

				//return '<object width="513px" height="300px" type="application/x-shockwave-flash" data="http://www.youtube.com/'.$id.'?autoplay=0" wmode="opaque" id="video_overlay"><param name="allowScriptAccess" value="always"><param name="allowFullScreen" value="true"><param name="FlashVars" value=""></object>';
				return '<object width="513" height="300"><param name="movie" value="http://www.youtube-nocookie.com/'.$id.'?autoplay=0&version=3&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube-nocookie.com/'.$id.'?autoplay=0&version=3&amp;hl=en_US" type="application/x-shockwave-flash" width="513" height="300" allowscriptaccess="always" allowfullscreen="true"></embed></object>';
			}
			if($vimeo){
				$id = substr($this->url,strpos($this->url, ".")+5);
				return '<iframe src="http://player.vimeo.com/video/'.$id.'?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff&amp;autoplay=1" width="479px" height="267px" frameborder="0"></iframe>';
			}
			return $this->url;
		}

    function getIntro($size=0, $br = 0, $tags = "") {
  		global $vsCom;

  		$parser = new PostParser ();
  		$parser->pp_do_html = 1;
  		$parser->pp_nl2br = $br;

  		$content = $parser->post_db_parse($this->intro);
  		if($size) {
  			if($tags) $content = strip_tags($content, $tags);
  			else $content = strip_tags($content);
  			return VSFTextCode::cutString($content, $size);
  		}

  		return $content;
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

	public function getCleanSearch() {
		return $this->cleanSearch;
	}

	public function setCleanSearch($cleanSearch) {
		$this->cleanSearch = $cleanSearch;
	}

		public function getFUllImage($arr=array(),$id=0,$dele="deleteImage") {
			global $vsLang;
			if($arr[$id]){
	       	return "{$vsLang->getWordsGlobal('obj_deletefile','Delete')} :<input type='checkbox' name='{$dele}' id='{$dele}' />{$arr[$id]->getTitle()}.{$arr[$id]->getType()}";
	      	}
		}


	public function convertOrderItem() {
            global $vsPrint,$bw;

		if(!$this->getId())$vsPrint->boink_it($_SERVER['HTTP_REFERER']);
		//if($bw->input['3']!=2)
                $item = array ( 'productId' 		=> $this->getId(),
                                'itemPrice' 		=>$this->getPrice(false),
                                'itemTitle' 		=> $this->getTitle(),
                				'itemImage' 		=> $this->getImage(),
                                'itemStatus'      	=>$this->getStatus(),
                                'itemQuantity' 		=> 1,
                				//'itemModule' 		=> $this->getModule(),
                				'itemType' 		=> 1
                                );
        /*else
                $item = array ( 'productId' 		=> $this->getId(),
                                'itemPrice' 		=>$this->getHotPrice(false),
                                'itemTitle' 		=> $this->getTitle(),
                				//'itemImage' 		=> $this->getImage(),
                                'itemStatus'      	=>$this->getStatus(),
                                'itemQuantity' 		=> 1,
                				//'itemModule' 		=> $this->getModule(),
                				'itemType' 		=> $bw->input['3']
                                );*/

                return $item;
	}
}
