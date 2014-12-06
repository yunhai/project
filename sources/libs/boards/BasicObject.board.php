<?php
class BasicObject {
	function __set_state(){
		
	}
	
	
	/**
	 * @return the $publisher
	 */
	public function getPublisher() {
		return $this->publisher;
	}
	
	/**
	 * @param field_type $publisher
	 */
	public function setPublisher($publisher) {
		$this->publisher = $publisher;
	}
	
	static function compareObjByTitle($a, $b) {
		require_once (UTILS_PATH . "TextCode.class.php");
		$v = new VSFTextCode ();
		$a = $v->removeAccent ( $a->title );
		$b = $v->removeAccent ( $b->title );
		$al = strtolower ( $a);
		$bl = strtolower ( $b);
		if ($al == $bl) {
			return 0;
		}
		return ($al > $bl) ? 1 : - 1;
	}
	
	public function getAuthor() {
		return $this->author;
	}
	
	public function setAuthor($author) {
		$this->author = $author;
	}
	
	function getTitle($size = 0) {
		if ($size)
			return VSFTextCode::cutString ( $this->title, $size );
		return $this->title;
	}
	
	function getCleanTitle() {
		return strtolower ( VSFTextCode::removeAccent ( str_replace ( "/", '-', trim ( $this->title ) ), '-' ) );
	}
	
	function setImage($imag) {
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
	
	function getOptionIcon() {
		$arr=explode(",",$this->getOption());
		$html="";
		
		/*
		1">Wifi
		2">Quạt máy
		3">Nhà hàng
		4">Cà phê
		5">Tủ lạnh
		6">Máy giặt
		7">Điện thoại<br/>
		8">TiVi
		9">Xe du lịch
		10">Karaoke
		11">Máy lạnh
		12">xe may
		13">Quà tặng
		*/
		
	
		$arr_title=array(
			1=>"Wifi",
			2=>"Quạt máy",
			3=>"Nhà hàng",
			4=>"Cà phê",
			5=>"Tủ lạnh",
			6=>"Máy giặt",
			7=>"Điện thoại",
			8=>"TiVi",
			9=>"Xe du lịch",
			10=>"Karaoke",
			11=>"Máy lạnh",
			12=>"Xe máy",
			13=>"Quà tặng"
		);
		
		foreach ($arr as $key=>$value){
			$html.="<span title='{$arr_title[$value]}' class='icon_option_{$value}'></span>";	
		}
		

		
		return $html;
	}
	
	function getStar() {
		
		$html.="";
		$star=2;
		if($this->getVisit()>=10){
			$star=3;
		}
		if($this->getVisit()>=20){
			$star=4;
		}
		if($this->getVisit()>=40){
			$star=5;
		}
		for($i=1;$i<=$star;$i++){
			$html.="<span class='star_icon'></span>";
		}
		
		for($i=1;$i<=5-$star;$i++){
			$html.="<span class='star_icon_none'></span>";
		}
		
		$html.="<div class='clear'></div>";
		return $html;
		
	}
	
	function setCatId($catId) {
		$this->catId = $catId;
	}
	
	function getContent($size = 0, $br = 0, $tags = "") {
		global $vsCom;
		
//		$parser = new PostParser ();
//		$parser->pp_do_html = 1;
//		$parser->pp_nl2br = $br;
		
		$content = $this->content;//$parser->post_db_parse ( $this->content );
		if ($size) {
			if ($tags)
				$content = strip_tags ( $content, $tags );
			else
				$content = strip_tags ( $content );
			return VSFactory::getTextCode()->cutString ( $content, $size );
		}
		return $content;
	}
	
	function getIntro($size = 0, $br = 0, $tags = "") {
		$parser = VSFactory::getPostParser();
		$parser->pp_do_html = 1;
		$parser->pp_nl2br = $br;
		$intro = $parser->post_db_parse ( $this->intro );
		if ($size) {
			if ($tags)
				$intro = strip_tags ( $intro, $tags );
			else
				$intro = strip_tags ( $intro );
			return VSFactory::getTextCode()->cutString ( $intro, $size );
		}
		return $intro;
	}
	
	function getUrl($module = null) {
		global $bw;
		if (! $module)
			return $this->url;
		if(APPLICATION_TYPE=='user')
		return $bw->base_url . "{$module}/detail/" . $this->getSlugId(). '.html';
		return $bw->vars['board_url'] . "/{$module}/detail/" . $this->getSlugId(). '.html';
	}
	function getSlugId(){
		
		
		return  $this->getSlug().'-'.$this->getId () ;
		
	}
	function getSlug($space="-"){
		if(!$this->mUrl){
			$this->mUrl=strtolower( VSFactory::getTextCode()->removeAccent($this->title,$space));
		}
		
		return $this->mUrl;
	}
	
	function getRssUrl($module = null) {
		global $bw;
		$vsLang = VSFactory::getLangs ();
		$de = "";
		if (! $module)
			return $this->url;
		if (! $vsLang->currentLang->getUserDefault ())
			$de = $vsLang->currentLang->getFolderName () . "/";
		return $bw->vars ['board_url'] . "/{$de}{$module}/detail/" . strtolower ( VSFTextCode::removeAccent ( str_replace ( "/", '-', trim ( $this->title ) ), '-' ) ) . '-' . $this->getId () . '/';
	}
	
	function getStatus($type = null) {
		global $bw;
		$vsLang = VSFactory::getLangs ();
		if (! $type)
			return isset ( $this->status ) ? $this->status : 1;
		
		if ($type == "image") {
			$imgArray = array ('disabled.png', 'enable.png', 'home.png', 'hot.png' );
			return $this->status = "<img src='{$bw->vars ['img_url']}/{$imgArray[$this->getStatus()]}' alt='{$this->getStatus()}' />";
		}
		if ($type == "text")
			$text = array ($vsLang->getWords ( 'global_enable', 'Enable' ), $vsLang->getWords ( 'global_disable', 'Disbale' ), $vsLang->getWords ( 'global_home', 'Home' ) );
		return $text ['$this->status'];
	}
	
	function getPostDate($format = NULl, $standard = false) {
		if ($format) {
                    
                  //  echo VSFactory::getDateTime()->getDate ( $this->postdate, $format, $standard );exit();
			return VSFactory::getDateTime()->getDate ( $this->postDate, $format, $standard );
		}
		return $this->postDate;
	}
	
	function setPostDate($postDate) {
		$this->postdate = $postDate;
	}
	
	function setId($id) {
		$this->id = $id;
	}
	
	function setCode($code) {
		$this->code = $code;
	}
	
	function setUrl($url) {
		$this->url = $url;
	}
	
	function setStatus($status) {
		$this->status = $status;
	}
	
	function setContent($content, $parse = 0, $br = 0) {
		if ($parse) {
			$parser = new PostParser ();
			$parser->pp_do_html = 1;
			$parser->pp_nl2br = $br;
			$content = $parser->post_db_parse ( $content );
		}
		$this->content = $content;
	}
	
	function setIntro($intro, $parse = 0, $br = 0) {
		if ($parse) {
			$parser = new PostParser ();
			$parser->pp_do_html = 1;
			$parser->pp_nl2br = $br;
			$intro = $parser->post_db_parse ( $intro );
		}
		$this->intro = $intro;
	}
	
	function getCategory() {
		return $this->category;
	}
	
	function setCategory($category) {
		$this->category = $category;
	}
	
	function getResizeImagePath($path, $width = 130, $height = 100, $type = 0) {
		global $bw;
		if (TIMTHUMB == 1)
			return $bw->vars ['board_url'] . "/cache/images/{$width}x{$height}-{$type}/uploads/{$path}";
		return "{$bw->vars['board_url']}/sources/utils/timthumb.php?src={$path}&w={$width}&h={$height}&zc={$type}";
	}
	/**
	 * 
	 * @param $fileObject File
	 * @param $width 
	 * @param $height
	 * @param $type
	 * @param $timthumb
	 */
	function getCacheImagePathByFile($fileObject, $width = 130, $height = 100, $type = 0, $timthumb = 0) {
		global $bw;
		if (! is_object ( $fileObject )) {
			$fileObject = VSFactory::getFiles ()->getObjectById ( intval ( $fileObject ) );
		}
		if (! is_a ( $fileObject, "File" )) {
			$noimage = VSFactory::getSettings ()->getSystemKey ( 'system_noimage_img_path', 'styles/images/noimage.gif', 'global', 0, 1 );
			return $this->getResizeImagePath ( $noimage, $width, $height );
		}
		
		if ($timthumb || $fileObject->getType () == "gif")
			return $fileObject->getPathView ();
		return $this->getResizeImagePath ( $fileObject->getPathView ( TIMTHUMB ), $width, $height, $type );
	}

	function createImageEditable($fileObject, $width = 100, $height = 100,$vswidth=0,$vsheight=0, $class = '') {
		global $bw, $vsStd;
		$defaut_tim = 0;
		
		$id = intval ( $fileObject );
		if (! is_object ( $fileObject )) {
			require_once CORE_PATH . 'files/files.php';
			$files = new files ();
			$fileObject = $files->getObjectById ( intval ( $fileObject ) );
		}
		
		if (! is_a ( $fileObject, "File" )) {
			if ($noimage)
				return $this->imageCache = "<img {$class} alt='{$bw->vars['global_websitename']} Image' src='{$this->getCacheImagePathByFile($fileObject,$width,$height)}'/>";
			return "";
		}
		
		if (! file_exists ( $fileObject->getPathView ( 0 ) ))
			return "";
		$alt = $fileObject->getIntro () ? $fileObject->getIntro () : $fileObject->getTitle ();
		
//		if ($fileObject->getType () == "gif") {
//			if ($height != 0)
//				return $this->imageCache = "<img {$class} alt='{$alt}' src='{$this->getCacheImagePathByFile($fileObject,$width,$height,$type)}' width='$width' height='$height'/>";
//			else
//				return $this->imageCache = "<img {$class} alt='{$alt}' src='{$this->getCacheImagePathByFile($fileObject,$width,$height,$type)}' width='$width'/>";
//		}
//		if ($type == 2) {
//			$size = $vsStd->scaleImage ( $fileObject->getPathView ( 0 ), $width, $height );
//			return $this->imageCache = "<img {$class} alt='{$fileObject->getTitle()}' src='{$this->getCacheImagePathByFile($fileObject,round($size['width']),round($size['height']),0)}' style='padding-top:{$size['padding-top']}px;'/>";
//		}
//		
//		if ($type == 3) {
//			return $this->imageCache = "<img {$class} alt='{$alt}' src='{$this->getCacheImagePathByFile($fileObject,$width,$height,2)}'/>";
//		}
//		
//		if ($type == 4) {
//			//$size = $vsStd->scaleImage ( $fileObject->getPathView ( 0 ), $width, $height );
//			return $this->imageCache = "<img {$class} alt='{$alt}' src='{$this->getCacheImagePathByFile($fileObject,$width,$height,2)}'/>";
//		}
		if($vswidth){
			$vswidth="vswidth='$vswidth'";
		}
		if($vsheight){
			$vsheight="vsheight='$vsheight'";
		}
		
		return $this->imageCache = "<img $vswidth $vsheight class=\"img_edit_able {$class}\" onClick=\"editImage(this)\" path=\"{$fileObject->getPathView(0)}\" src='{$this->getCacheImagePathByFile($fileObject,$width,$height,0)}'/>";
	}
	/**
	 * createImageCache($fileObject, $width=100, $height=100, $type=0, $noimage=0)
	 * dinh nghia $type
	 * $type = 0 || $type = 1 dinh nghia theo cach mac dinh cua timthumb
	 * $type = 2 scale dung ty le theo kich thuoc hinh cu (co padding-top).su dung site cua a Duc
	 * $type = 3 cho hinh co gian muc toi da.phan du du cua hinh duoc overflow:hidden
	 * $type = 4 bí mật
	 * test ra loi xin lien he : sangpm@vietsol.net
	 */
	
	function createImageCache($fileObject, $width = 100, $height = 100, $type = 0, $noimage = 0, $class = '') {
		global $bw, $vsStd;
		$defaut_tim = 0;
		$id = intval ( $fileObject );
		if(is_object($this->vsImage)&&$this->vsImage->getId()==$id){
			$fileObject=$this->vsImage;
		}
		if(!$fileObject){
			return "";
		}
		if (! is_object ( $fileObject )) { 
			require_once CORE_PATH . 'files/files.php';
			$files = new files ();
			$fileObject = $files->getObjectById ( intval ( $fileObject ) );
		}
		
		if (! is_a ( $fileObject, "File" )) {
			if ($noimage)
				return $this->imageCache = "<img {$class} alt='{$bw->vars['global_websitename']} Image' src='{$this->getCacheImagePathByFile($fileObject,$width,$height)}'/>";
			return "";
		}
		
		if (! file_exists ( $fileObject->getPathView ( 0 ) ))
			return "";
		$alt = $fileObject->getIntro () ? $fileObject->getIntro () : $fileObject->getTitle ();
		
		if ($fileObject->getType () == "gif") {
			if ($height != 0)
				return $this->imageCache = "<img {$class} alt='{$alt}' src='{$this->getCacheImagePathByFile($fileObject,$width,$height,$type)}' width='$width' height='$height'/>";
			else
				return $this->imageCache = "<img {$class} alt='{$alt}' src='{$this->getCacheImagePathByFile($fileObject,$width,$height,$type)}' width='$width'/>";
		}
		if ($type == 2) {
			$size = $vsStd->scaleImage ( $fileObject->getPathView ( 0 ), $width, $height );
			return $this->imageCache = "<img {$class} alt='{$fileObject->getTitle()}' src='{$this->getCacheImagePathByFile($fileObject,round($size['width']),round($size['height']),0)}' style='padding-top:{$size['padding-top']}px;'/>";
		}
		
		if ($type == 3) {
			return $this->imageCache = "<img {$class} alt='{$alt}' src='{$this->getCacheImagePathByFile($fileObject,$width,$height,2)}'/>";
		}
		
		if ($type == 4) {
			//$size = $vsStd->scaleImage ( $fileObject->getPathView ( 0 ), $width, $height );
			return $this->imageCache = "<img {$class} alt='{$alt}' src='{$this->getCacheImagePathByFile($fileObject,$width,$height,2)}'/>";
		}
		
		return $this->imageCache = "<img {$class} alt='{$alt}' src='{$this->getCacheImagePathByFile($fileObject,$width,$height,$type)}'/>";
	}
function showImage($width = 100, $height = 100, $type = 0, $noimage = 0, $class = '') {
		global $bw, $vsStd;
		$defaut_tim = 0;
		if(!is_object($this->vsImage)){
			return "";
		}
//		if (! is_object ( $fileObject )) { 
//			require_once CORE_PATH . 'files/files.php';
//			$files = new files ();
//			$fileObject = $files->getObjectById ( intval ( $fileObject ) );
//		}
		
		if (! is_a ( $this->vsImage, "File" )) {
			if ($noimage)
				return $this->imageCache = "<img {$class} alt='{$bw->vars['global_websitename']} Image' src='{$this->getCacheImagePathByFile($this->vsImage,$width,$height)}'/>";
			return "";
		}
		
		if (! file_exists ( $this->vsImage->getPathView ( 0 ) ))
			return "";
		$alt = $this->vsImage->getIntro () ? $this->vsImage->getIntro () : $this->vsImage->getTitle ();
		
		if ($this->vsImage->getType () == "gif") {
			if ($height != 0)
				return $this->imageCache = "<img {$class} alt='{$alt}' src='{$this->getCacheImagePathByFile($this->vsImage,$width,$height,$type)}' width='$width' height='$height'/>";
			else
				return $this->imageCache = "<img {$class} alt='{$alt}' src='{$this->getCacheImagePathByFile($this->vsImage,$width,$height,$type)}' width='$width'/>";
		}
		if ($type == 2) {
			$size = $vsStd->scaleImage ( $this->vsImage->getPathView ( 0 ), $width, $height );
			return $this->imageCache = "<img {$class} alt='{$this->vsImage->getTitle()}' src='{$this->getCacheImagePathByFile($this->vsImage,round($size['width']),round($size['height']),0)}' style='padding-top:{$size['padding-top']}px;'/>";
		}
		
		if ($type == 3) {
			return $this->imageCache = "<img {$class} alt='{$alt}' src='{$this->getCacheImagePathByFile($this->vsImage,$width,$height,2)}'/>";
		}
		
		if ($type == 4) {
			//$size = $vsStd->scaleImage ( $this->vsImage->getPathView ( 0 ), $width, $height );
			return $this->imageCache = "<img {$class} alt='{$alt}' src='{$this->getCacheImagePathByFile($this->vsImage,$width,$height,2)}'/>";
		}
		
		return $this->imageCache = "<img {$class} alt='{$alt}' src='{$this->getCacheImagePathByFile($this->vsImage,$width,$height,$type)}'/>";
	}
	function showImagePopup($fileObject = "", $width = 100, $height = 100, $class = "", $type = 0, $noimage = 0, $startDiv = "", $endDiv = "") {
		global $bw, $vsStd;
		$RET = "";
		if ($fileObject && file_exists ( $fileObject->getPathView ( 0 ) ))
			$RET .= <<<EOF
                {$startDiv}
                <a href="{$this->getCacheImagePathByFile($fileObject,1,1,1,1)}" class="highslide {$class}" onclick="return hs.expand(this)">
                                    {$this->createImageCache($fileObject, $width, $height, $type, $noimage)}
                </a>
                {$endDiv}
EOF;
		
		return $RET;
	}
	function createSeo() {
		global $vsCom;
                require_once (UTILS_PATH . "TextCode.class.php");
		if (is_object ( $vsCom->SEO->basicObject )) {
			if (! $vsCom->SEO->basicObject->getIntro ()&&!$this->mIntro) {
				$intro = $this->intro ? $this->getIntro () : $this->getContent ( 450 );
				$oTitle = strip_tags ( $this->title );
				$specialchar = "&acute; &grave; &circ; &tilde; &cedil; &ring; &uml; &amp; &quot;";
				$specialchar .= " , . ? : ! < > & * ^ % $ # @ ; ' ( ) { } [ ] + ~ = - 39 / 33";
				$specialcharArr = explode ( " ", $specialchar );
				$oTitle = str_replace ( $specialcharArr, '', $oTitle );
				$oIntro = $oTitle . ": " .VSFactory::getTextCode()->cutString ( strip_tags ( $intro ), 300 );
			}
			$vsCom->SEO->basicObject->setIntro ( $this->mIntro?$this->mIntro:$oIntro );
			if (! $vsCom->SEO->basicObject->getTitle ()) {
				$vsCom->SEO->basicObject->setTitle ( $this->mTitle?$this->mTitle:$oTitle );
			}
			if (! $vsCom->SEO->basicObject->getKeyword ()) {
				$vsCom->SEO->basicObject->setKeyword ( $this->mIntro?$this->mIntro:VSFTextCode::removeAccent ( $oTitle ) . ", " . $oTitle . ", " . VSFTextCode::removeAccent ( $oTitle, ", " ) );
			}
		}
	}
	
	function __construct() {
	}
	
	function convertToObject($object) {
	
	}
	public function convertToDB($tableName = "news") {
		return array();
	}
	
	
	function getCleanSearch() {
		$cleanContent = VSFTextCode::removeAccent ( $this->title ) . " ";
		if ($this->intro)
			$cleanContent .= VSFTextCode::removeAccent ( strip_tags ( $this->getIntro () ) ) . " ";
		else
			$cleanContent .= VSFTextCode::removeAccent ( strip_tags ( $this->getContent () ) );
		return strtolower ( $cleanContent );
	}
	function validate() {
		$status = true;
		if ($this->title == "") {
			$this->message .= " title can not be blank!";
			$status = false;
		}
		return $status;
	}
/**
	 * @return the $mKeyword
	 */
	public function getMKeyword() {
		return $this->mKeyword;
	}

	/**
	 * @return the $mIntro
	 */
	public function getMIntro() {
		return $this->mIntro;
	}

	/**
	 * @return the $mTitle
	 */
	public function getMTitle() {
		return $this->mTitle;
	}

	/**
	 * @param field_type $mKeyword
	 */
	public function setMKeyword($mKeyword) {
		$this->mKeyword = $mKeyword;
	}

	/**
	 * @param field_type $mIntro
	 */
	public function setMIntro($mIntro) {
		$this->mIntro = $mIntro;
	}

	/**
	 * @param field_type $mTitle
	 */
	public function setMTitle($mTitle) {
		$this->mTitle = $mTitle;
	}

	/**
	 * @return the $mUrl
	 */
	public function getMUrl() {
		return $this->mUrl;
	}

	/**
	 * @param field_type $mUrl
	 */
	public function setMUrl($mUrl) {
		$this->mUrl = $mUrl;
	}
protected $id = NULL;
	protected $catId = NULL;
	protected $category = NULL;
	protected $index = NULL;
	protected $title = NULL;
	protected $intro = NULL;
	protected $content = NULL;
	protected $status = NULL;
	protected $publisher = 0;
	protected $url = NULL;
	protected $postdate = NULL;
	protected $code = NULL;
	protected $image = NULL;
	public $record = NULL;
	protected $author = NULL;
	public $mKeyword = NULL;
	public $mIntro = NULL;
	public $mTitle = NULL;
	public $mUrl = NULL;

	
	


	function __destruct() {
		unset ( $this->id );
		unset ( $this->catId );
		unset ( $this->category );
		unset ( $this->index );
		unset ( $this->title );
		unset ( $this->intro );
		unset ( $this->content );
		unset ( $this->status );
		unset ( $this->url );
		unset ( $this->postdate );
		unset ( $this->code );
		unset ( $this->image );
		unset ( $this->record );
		unset ( $this->author );
		unset ( $this->mKeyword );
		unset ( $this->mIntro );
		unset ( $this->mTitle );
		unset ( $this->mUrl );
	}
}