<?php
class BasicObject {
	protected $id 			= NULL;
	protected $catId 		= NULL;
	protected $category	 	= NULL;
	protected $index 		= NULL;
	protected $title 		= NULL;
	protected $intro 		= NULL;
	protected $content 		= NULL;
	protected $status 		= NULL;
	protected $url 			= NULL;
	protected $postdate             = NULL;
        protected $code                 = NULL;
        protected $image                = NULL;
        public    $record               = NULL;
        protected $author = NULL;
         protected $price = NULL;
          protected $hotPrice = NULL;
        

       
	public function getAuthor() {
		return $this->author;
	}

	public function setAuthor($author) {
		$this->author = $author;
	}

        function getTitle($size=0) {
		if($size)
			return VSFTextCode::cutString($this->title,$size);
		return $this->title;
	}

	function getCleanTitle(){
		return strtolower(VSFTextCode::removeAccent(str_replace("/", '-', trim($this->title)),'-'));
	}
	
	function setImage ($imag) {
		return $this->image = $imag;
	}

        function getIndex() {
		return $this->index;
	}

	function setIndex($index) {
		$this->index = $index;
	}

	function setTitle($title) {
		$this->title = $title;
	}

	function getId() {
		return $this->id;
	}

        function getImage() {
		return $this->image;
	}

	function getCatId() {
		return $this->catId;
	}
        function getCode() {
		return $this->code;
	}


	function setCatId($catId) {
		$this->catId = $catId;
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

	function getIntro($size=0, $br = 0, $tags = ""){
		$parser = new PostParser ();
		$parser->pp_do_html = 1;
		$parser->pp_nl2br = $br;
		$intro = $parser->post_db_parse($this->intro);
		if($size){
			if($tags) $intro = strip_tags($intro, $tags);
			else $intro = strip_tags($intro);
			return VSFTextCode::cutString($intro,$size);
		}
		return $intro;
	}

	function getUrl($module=null) {
		global $bw;
		if(!$module) return $this->url;
		return $bw->base_url . "{$module}/detail/".strtolower(VSFTextCode::removeAccent(str_replace("/", '-', trim($this->title)),'-')). '-' . $this->getId () . '.html';
	}

        function getRssUrl($module=null){
            global $vsLang,$bw;
            $de ="";
            if(!$module) return $this->url;
            if(!$vsLang->currentLang->getUserDefault())$de = $vsLang->currentLang->getFolderName()."/";
           return $bw->vars['board_url'] . "/{$de}{$module}/detail/".strtolower(VSFTextCode::removeAccent(str_replace("/", '-', trim($this->title)),'-')). '-' . $this->getId () . '/';
        }


	function getStatus($type=null) {
		global $bw, $vsLang;
		
		if(!$type) return isset($this->status) ? $this->status : 1;
		
		if($type=="image"){
			$imgArray = array('disabled.png', 'enable.png', 'home.png','hethang.png','khuyenmai.gif','special.gif','new.png', 'coming.png','special.png');			
			return $this->status = "<img src='{$bw->vars ['img_url']}/{$imgArray[$this->getStatus()]}' alt='{$this->getStatus()}' />";
		}
		if($type=="text")
			$text = array($vsLang->getWords('global_enable', 'Enable'), $vsLang->getWords('global_disable', 'Disbale'), $vsLang->getWords('global_home', 'Home'));
			return $text['$this->status'];
	}

	
	function getPostDate($format = NULl, $standard = false){
		if($format) {
			$datetime= new VSFDateTime();
			return $datetime->getDate($this->postdate, $format, $standard);
		}
		return $this->postdate;
	}

	function setPostDate($postDate){
		$this->postdate = $postDate;
	}
	
	function setId($id) {
		$this->id = $id;
	}
        
        function setCode($id) {
		$this->code = $id;
	}
	
	function setUrl($url) {
		$this->url = $url;
	}
	
	function setStatus($status) {
		$this->status = $status;
	}
	
	function setContent($content, $parse = 0, $br = 0) {
		if($parse){
	        $parser = new PostParser ();
			$parser->pp_do_html = 1;
			$parser->pp_nl2br = $br;
			$content = $parser->post_db_parse($content);
		}
		$this->content = $content;
	}

	function setIntro($intro, $parse = 0, $br = 0) {
		if($parse){
			$parser = new PostParser ();
			$parser->pp_do_html = 1;
			$parser->pp_nl2br = $br;
			$intro = $parser->post_db_parse($intro);
		}
		$this->intro = $intro;
	}

	function getCategory(){
		return $this->category;
	}

	function setCategory($category) {
		$this->category = $category;
	}

	function getResizeImagePath($path,$width = 130, $height = 100,$type=0) {
		global $bw;
		if(TIMTHUMB==1) return $bw->vars['board_url']."/cache/images/{$width}x{$height}-{$type}/uploads/{$path}";
		return "{$bw->vars['board_url']}/utils/timthumb.php?src={$path}&w={$width}&h={$height}&zc={$type}";
	}
	
	function getResizeImagePathScale($fileObject,$width = 130, $height = 100,$type=0) {
		global $bw,$vsStd;
		$size = $vsStd->scaleImage($fileObject->getPathView(0), $width, $height);
		$width = round($size['width']);
		$height = round($size['height']);
		$path = $fileObject->getPathView(TIMTHUMB);
		if(TIMTHUMB==1) return $bw->vars['board_url']."/cache/images/{$width}x{$height}-{$type}/uploads/{$path}";
		return "{$bw->vars['board_url']}/utils/timthumb.php?src={$path}&w={$width}&h={$height}&zc={$type}";
	}
	
	function getCacheImagePathByFile($fileObject, $width = 130, $height = 100, $type=0, $timthumb=0) {
		global $vsFile, $vsSettings, $bw;
	
		if(!is_object($fileObject)){
            $vsFile = new files();
            /*ghu chu*/
            
			$fileObject = $vsFile->getObjectById(intval($fileObject));
                }
		if(!is_a($fileObject,"File")){
			$noimage = $vsSettings->getSystemKey('system_noimage_img_path','styles/images/noimage.gif', 'global', 0, 1);	
			return $this->getResizeImagePath($noimage,$width,$height);
		}
		
		if($timthumb || $fileObject->getType()=="gif" || $fileObject->getType()=="flv")
			return $fileObject->getPathView();
		return
			$this->getResizeImagePath($fileObject->getPathView(TIMTHUMB),$width,$height,$type);
	}

/**
 * createImageCache($fileObject, $width=100, $height=100, $type=0, $noimage=0)
 * dinh nghia $type
 * $type = 0 || $type = 1 dinh nghia theo cach mac dinh cua timthumb
 * $type = 2 scale dung ty le theo kich thuoc hinh cu (co padding-top).su dung site cua a Duc
 * $type = 3 cho hinh co gian muc toi da.phan du du cua hinh duoc overflow:hidden
 * test ra loi xin lien he : sangpm@vietsol.net
 */

	

function createImageCache($fileObject, $width=100, $height=100, $type=0, $noimage=0, $alt="") {
		global $vsFile, $bw,$vsStd;
        $defaut_tim = 0;

		$id = intval($fileObject);
		if(!is_object($fileObject)){
				$vsFile = new files();
				$fileObject = $vsFile->getObjectById(intval($fileObject));
         }
       
		if(!is_a($fileObject, "File")){
			if($noimage)
				return $this->imageCache="<img title='{$bw->vars['global_websitename']} alt='{$bw->vars['global_websitename']} Image' src='{$this->getCacheImagePathByFile($fileObject,$width,$height)}'/>";
			return "";
		}

        if(! file_exists ( $fileObject->getPathView (0) )) return "";
		if(!$alt)
			$alt = $fileObject->getIntro() ? $fileObject->getIntro() : $fileObject->getTitle();

		if($fileObject->getType()=="gif"){
			if($height!=0)
				return $this->imageCache="<img title='{$alt}' alt='{$alt}' src='{$this->getCacheImagePathByFile($fileObject,$width,$height,$type)}' width='$width' height='$height'/>";
			else 
				return $this->imageCache="<img title='{$alt}' alt='{$alt}' src='{$this->getCacheImagePathByFile($fileObject,$width,$height,$type)}' width='$width'/>";
		}
		if($fileObject->getType()=="flv"){
			$convertimg = str_replace(".flv", ".png", $this->getCacheImagePathByFile($fileObject,$width,$height,$type));
			return $this->imageCache="<img title='{$alt}' alt='{$alt}' src='{$convertimg}' width='$width' height='$height'/>";
		}
        if($type == 2){
			$size = $vsStd->scaleImage($fileObject->getPathView(0), $width, $height);
			
			return $this->imageCache="<img title='{$alt}' alt='{$alt}' src='{$this->getCacheImagePathByFile($fileObject,round($size['width']),round($size['height']),0)}' style='padding-top:{$size['padding-top']}px;'/>";
		}

        if($type == 3){
			return $this->imageCache="<img title='{$alt}' alt='{$alt}' src='{$this->getCacheImagePathByFile($fileObject,$width,$height,2)}'/>";
		}
		
		if($type == 4){
			$size = $vsStd->scaleImage($fileObject->getPathView(0), $width, $height);
			return $this->imageCache="<img title='{$alt}' alt='{$alt}' src='{$this->getCacheImagePathByFile($fileObject,round($size['width']),round($size['height']),0)}' />";
		}
		if($type == 5){
                    return $this->imageCache="<img title='{$alt}' class='img_full' alt='{$alt}' src='{$this->getCacheImagePathByFile($fileObject,1,1,1,1)}' />";
		}

		return $this->imageCache="<img title='{$alt}' alt='{$alt}' class='img_full' src='{$this->getCacheImagePathByFile($fileObject,$width,$height,$type)}'/>";
	}
	function showImagePopup( $fileObject="",$width=100, $height=100, $class ="" , $type=0, $noimage=0,$startDiv="",$endDiv=""){
            global $vsFile, $bw,$vsStd;
           $RET ="";
		if(!is_object($fileObject)){
				$vsFile = new files();
				$fileObject = $vsFile->getObjectById(intval($fileObject));
         }
            if($fileObject && file_exists ( $fileObject->getPathView (0) ))
            $RET .= <<<EOF
                {$startDiv}
                <a href="{$this->getCacheImagePathByFile($fileObject,1,1,1,1)}" class="highslide {$class}" onclick="return hs.expand(this)" title="{$fileObject->getTitle()}">
                                    {$this->createImageCache($fileObject, $width, $height, $type, $noimage)}
                </a>
                {$endDiv}
                
EOF;

                                    return $RET;
        }
        
	function showImageVideo( $fileObject="",$width=100, $height=100, $thumbwidth=100,$thumbheight=100 , $type=0){
            global $vsFile, $bw,$vsStd;
           $RET ="";
            if($fileObject && file_exists ( $fileObject->getPathView (0) ))
            $convertimg = str_replace(".flv", ".png", $this->getCacheImagePathByFile($fileObject,$width,$height,$type));
            $RET .= <<<EOF
                <a href="javascript:;" onclick="vsf.get('files/view/{$fileObject->getId()}/&width={$width}&height={$height}','video');" title="{$fileObject->getTitle()}"><img alt='{$fileObject->getTitle()}' src='{$convertimg}' width='$thumbwidth' height='$thumbheight'/></a>
                
EOF;

	 return $RET;
        }
        
        function createSeo(){
		global $vsCom,$bw,$vsPrint;
		$exac_url=strtr($this->getUrl($bw->input['module']), $vsCom->SEO->aliasurl);
  		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  		if($url!=$exac_url)
   			$vsPrint->boink_it($exac_url);
		if(is_object($vsCom->SEO->obj)){
			if(!$vsCom->SEO->obj->getIntro())
			{
				$intro = $this->intro?$this->getIntro(100):$this->getContent(100);
				$oTitle = strip_tags($this->title);
				$specialchar = "&acute; &grave; &circ; &tilde; &cedil; &ring; &uml; &amp; &quot;";
				$specialchar .= " , . ? : ! < > & * ^ % $ # @ ; ' ( ) { } [ ] + ~ = - 39 / 33";				
				$specialcharArr = explode(" ",$specialchar);
				$oTitle = str_replace($specialcharArr,'',$oTitle);				
				$oIntro = $oTitle.": ".VSFTextCode::cutString(strip_tags($intro),100);
				$vsCom->SEO->obj->setIntro($oIntro);
			}
			if(!$vsCom->SEO->obj->getTitle())
			{
				$vsCom->SEO->obj->setTitle($oTitle);
			}
			if(!$vsCom->SEO->obj->getKeyword())
			{
				$vsCom->SEO->obj->setKeyword(VSFTextCode::removeAccent($oTitle).", ".$oTitle.", ".VSFTextCode::removeAccent($oTitle,", "));
			} 		}
	}

	function __construct(){
	}

	function __destruct(){
		unset ( $this->id );
		unset ( $this->catId );
		unset ( $this->category );
		unset ( $this->content );
		unset ( $this->index );
		unset ( $this->intro );
		unset ( $this->title );
		unset ( $this->status );
		unset ( $this->url);
                unset ($this->image);
	}
        function convertToObject($object,$tableName="") {
                global $vsFile,$DB;
                if ( $object ['fileId'] ){
                        $file = new File();
                        $file->convertToObject($object);
                        $this->file=$file;
                    }
//               if($object['relId']){
//                            $file = new File();
//                            $file->convertToObject($object);
//                            $this->slide = $file;
//               }
                if($tableName){
                isset ( $object ["{$tableName}Id"] )      ? $this->setId ( $object ["{$tableName}Id"] )             : '';
                isset ( $object ["{$tableName}CatId"] )   ? $this->setCatId ( $object ["{$tableName}CatId"] )       : "";
                isset ( $object ["{$tableName}CatId"] )   ? $this->setCategory ( $object ["{$tableName}CatId"] )    : "";
                isset ( $object ["{$tableName}Title"] )   ? $this->setTitle ( $object ["{$tableName}Title"] )       : "";
                isset ( $object ["{$tableName}Intro"] )   ? $this->setIntro ( $object ["{$tableName}Intro"] )       : "";
                isset ( $object ["{$tableName}Index"] )   ? $this->setIndex ( $object ["{$tableName}Index"] )       : "";
                isset ( $object ["{$tableName}Image"] )   ? $this->setImage ( $object ["{$tableName}Image"] )       : "";
                isset ( $object ["{$tableName}Content"] ) ? $this->setContent ( $object ["{$tableName}Content"] )   : "";
                isset ( $object ["{$tableName}Status"] )  ? $this->setStatus ( $object ["{$tableName}Status"] )     : "";
                isset ( $object ["{$tableName}Code"] )    ? $this->setCode ( $object ["{$tableName}Code"] )         : "";
                isset ( $object ["{$tableName}Url"] )     ? $this->setUrl ( $object ["{$tableName}Url"] )           : "";
                isset ( $object ["searchRecord"] )        ? $this->record = $object ["searchRecord"]                : "";
                isset ( $object ["{$tableName}Author"] )  ? $this->setAuthor ( $object ["{$tableName}Author"] )             : '';

                }

        }
         public function convertToDB($tableName="news") {                
		isset ( $this->catId )      ? ($dbobj ["{$tableName}CatId"] = $this->getCatId ()) : "";
		isset ( $this->id )         ? ($dbobj ["{$tableName}Id"] = $this->id) : "";
		isset ( $this->title )      ? ($dbobj ["{$tableName}Title"] = $this->title) : "";
		isset ( $this->intro )      ? ($dbobj ["{$tableName}Intro"] = $this->intro) : "";
		isset ( $this->image )      ? ($dbobj ["{$tableName}Image"] = $this->image) : "";
		isset ( $this->content )    ? ($dbobj ["{$tableName}Content"] = $this->content) : "";
		isset ( $this->index )      ? ($dbobj ["{$tableName}Index"] = $this->index) : "";
		isset ( $this->status )     ? ($dbobj ["{$tableName}Status"] = $this->status) : "";
		if($this->author)       $dbobj ["{$tableName}Author"]   = $this->author;
                if( $this->code )       $dbobj ["{$tableName}Code"]     = $this->code;
                
		return $dbobj;
	}
        
        public function convertSearchDB(){
                global $bw,$vsLang;
		isset ( $this->id )         ? ($dbobj ["searchId"]      = $this->id) : "";
		isset ( $this->title )      ? ($dbobj ["searchTitle"]   = $this->title) : "";
		isset ( $this->image )      ? ($dbobj ["searchImage"]   = $this->image) : "";
		isset ( $this->index )      ? ($dbobj ["searchIndex"]   = $this->index) : "";
		isset ( $this->postdate )   ? ($dbobj ["searchPostDate"] = $this->postdate) : "";
		isset ( $this->status )     ? ($dbobj ["searchStatus"]  = $this->status) : "";
		isset ( $this->author )     ? ($dbobj ["searchAuthor"]  = $this->author) : "";
		isset ( $this->price )     ? ($dbobj ["searchPrice"]  = $this->price) : "";
		//isset ( $this->hotPrice )     ? ($dbobj ["searchHotPrice"]  = $this->hotPrice) : "";
                isset ( $this->record )     ? ($dbobj ["searchRecord"]  = $this->record) : "";
                    $dbobj ["searchUpdate"] = time();
                    $dbobj ["searchModule"] = $bw->input['module'];
                    $dbobj ["searchContent"] = $this->getCleanSearch123();
                    $dbobj ["searchCatId"] =$vsLang->currentLang->getId();
                    $dbobj ["searchIntro"] =$this->intro ? $this->intro : $this->getContent(300);
                 
                return $dbobj;
        }

        function getCleanSearch123() {
		$cleanContent = VSFTextCode::removeAccent($this->title)." ";
                if($this->intro)
                    $cleanContent .= VSFTextCode::removeAccent(strip_tags($this->getIntro()))." ";
                else
                    $cleanContent.= VSFTextCode::removeAccent(strip_tags($this->getContent()));
		return strtolower($cleanContent);
	}



        function validate() {
		$status = true;
		if ($this->title == "") {
			$this->message .= " title can not be blank!";
			$status = false;
		}
		return $status;
	}
        
}