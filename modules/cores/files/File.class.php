<?php
class File extends BasicObject {
	private $module = NULL;
	private $type = NULL;
	private $size = NULL;
	private $uploadTime = NULL;
	private $path = NULL;
	private $name = NULL;
	
	function validate() {
		$status = true;
		if ($this->title == "") {
			$this->message .= VSFactory::getLangs ()->getWords ( 'file_err_name_blank', "File name cannot be blank!" );
			$status = false;
		}
		return $status;
	}
	function __construct() {
		parent::__construct ();
	}
	
	function __destruct() {
		unset ( $this->id );
		unset ( $this->title );
		unset ( $this->module );
		unset ( $this->intro );
		unset ( $this->type );
		unset ( $this->url );
		unset ( $this->path );
		unset ( $this->status );
		unset ( $this->index );
		unset ( $this->name );
		unset ( $this->size );
		unset ( $this->uploadTime );
	}
	function convertToDB() {
		
		isset ( $this->id ) ? ($dbobj ['id'] = $this->id) : '';
		isset ( $this->title ) ? ($dbobj ['title'] = $this->title) : '';
		isset ( $this->module ) ? ($dbobj ['module'] = $this->module) : '';
		isset ( $this->intro ) ? ($dbobj ['intro'] = $this->intro) : '';
		isset ( $this->type ) ? ($dbobj ['type'] = $this->type) : '';
		isset ( $this->url ) ? ($dbobj ['url'] = $this->url) : '';
		isset ( $this->path ) ? ($dbobj ['path'] = $this->path) : '';
		isset ( $this->status ) ? ($dbobj ['status'] = $this->status) : '';
		isset ( $this->index ) ? ($dbobj ['index'] = $this->index) : '';
		isset ( $this->name ) ? ($dbobj ['name'] = $this->name) : '';
		isset ( $this->size ) ? ($dbobj ['size'] = $this->size) : '';
		isset ( $this->uploadTime ) ? ($dbobj ['uploadTime'] = $this->uploadTime) : '';
		return $dbobj;
	}
	
	function convertToObject($object = array()) {
		
		isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
		isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
		isset ( $object ['intro'] ) ? $this->setIntro ( $object ['intro'] ) : '';
		isset ( $object ['module'] ) ? $this->setModule ( $object ['module'] ) : '';
		isset ( $object ['type'] ) ? $this->setType ( $object ['type'] ) : '';
		isset ( $object ['url'] ) ? $this->setUrl ( $object ['url'] ) : '';
		isset ( $object ['path'] ) ? $this->setPath ( $object ['path'] ) : '';
		isset ( $object ['index'] ) ? $this->setIndex ( $object ['index'] ) : '';
		isset ( $object ['status'] ) ? $this->setStatus ( $object ['status'] ) : '';
		isset ( $object ['name'] ) ? $this->setName ( $object ['name'] ) : '';
		isset ( $object ['size'] ) ? $this->setSize ( $object ['size'] ) : '';
		isset ( $object ['uploadTime'] ) ? $this->setUploadTime ( $object ['uploadTime'] ) : '';
	}
	function convertToObjectDelta($object = array()) {
		
		isset ( $object ['fid'] ) ? $this->setId ( $object ['fid'] ) : '';
		isset ( $object ['ftitle'] ) ? $this->setTitle ( $object ['ftitle'] ) : '';
		isset ( $object ['fintro'] ) ? $this->setIntro ( $object ['fintro'] ) : '';
		isset ( $object ['fmodule'] ) ? $this->setModule ( $object ['fmodule'] ) : '';
		isset ( $object ['ftype'] ) ? $this->setType ( $object ['ftype'] ) : '';
		isset ( $object ['furl'] ) ? $this->setUrl ( $object ['furl'] ) : '';
		isset ( $object ['fpath'] ) ? $this->setPath ( $object ['fpath'] ) : '';
		isset ( $object ['findex'] ) ? $this->setIndex ( $object ['findex'] ) : '';
		isset ( $object ['fstatus'] ) ? $this->setStatus ( $object ['fstatus'] ) : '';
		isset ( $object ['fname'] ) ? $this->setName ( $object ['fname'] ) : '';
		isset ( $object ['fsize'] ) ? $this->setSize ( $object ['fsize'] ) : '';
		isset ( $object ['fuploadTime'] ) ? $this->setUploadTime ( $object ['fuploadTime'] ) : '';
	}
	function __set_state($array = array()) {
		$file = new File ();
		foreach ( $array as $key => $value ) {
			$file->$key = $value;
		}
		return $file;
	}
	function getModule() {
		return $this->module;
	}
	
	function getType() {
		return $this->type;
	}
	
	function getSize() {
		return $this->size;
	}
	
	function getUploadTime() {
		return $this->uploadTime;
	}
	
	function getPath() {
		return $this->path;
	}
	function getUrl() {
		return $this->url;
	}
	function setUrl($path) {
		$this->url = $path;
	}
	function getTitle() {
		return ltrim ( $this->title, "~" );
	}
	
	function setModule($module) {
		$this->module = $module;
	}
	
	function setType($type) {
		$this->type = $type;
	}
	
	function setSize($size) {
		$this->size = $size;
	}
	
	function setUploadTime($uploadTime) {
		$this->uploadTime = $uploadTime;
	}
	
	function setPath($path) {
		$this->path = $path;
	}
	
	function setName($name) {
		$this->name = $name;
	}
	
	function getName() {
		return ltrim ( $this->name, "~" );
	}
	
	function getPathResize($width,$height,$type = 2,$color='ffffff',$wm=0) {
		global $bw;
		
		return "{$bw->vars['board_url']}/sources/utils/timthumb.php?src={$this->getPathView()}&w=$width&h=$height&zc=$type&c=$color&wm=$wm";
	}
	
	/**
	 * type=0 /uploads/products/file-name.jpg
	 * type=1 products/file-name.jpg 
	 * type=2 http://domainname.com/uploads/products/file-name.jpg
	 * @param $type default 2
	 * 
	 */
	function getPathView($type = 2) {
		global $bw;
		if (! $type)
			return UPLOAD_PATH . "{$this->path}{$this->getName()}.{$this->type}";
		if ($type == 1)
			return "{$this->path}{$this->getName()}.{$this->type}";
		return $bw->vars ['upload_url'] . "/" . $this->path . $this->getName () .'.' . $this->type;
	}
	
	function show($width = 150, $height = 150, $divId = null) {
		global $bw, $vsPrint;
		$allowFile = array ("doc", "docx", "xls", "xlsx", "pdf", "zip", "rar", "rtf" );
		if (in_array ( $this->type, $allowFile ))
			return "<div>" . $this->getName () . "." . $this->getType () . "</div>";
		
		$allowImage = array ("png", "jpeg", "jpg", "gif", "psd", "crd" );
		if (in_array ( $this->type, $allowImage ))
			return "<img src='{$bw->vars['board_url']}/sources/utils/timthumb.php?src={$this->getPathView()}&w=$width&h=$height&zc=1' alt='{$this->getName()}' />";
		if ($this->type == "swf")
			return <<<EOF
			<object height="$height" width="$width" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
	              <param value="{$this->getPathView()}" name="movie">
	              <param name="wmode" value="transparent">
	              <param value="high" name="quality">
	              <embed height="$height" width="$width" wmode="transparent" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" quality="high" src="{$this->getPathView()}">
	   	    </object>
EOF;
		$allowVideo = array ("dat", "avi", "mp4", "3gp", "wmv", "swf", "mpeg", "mpg", "flv" );
		if (in_array ( $this->type, $allowVideo ))
			if (! $divId) {
				$div = "<div id='flvdix{$this->id}' style='width:{$width}px;height:{$height}px'></div>";
				$divId = "flvdix{$this->id}";
			} else
				$div = "
				<script>
					$('#{$divId}').css('width','{$width}px');
					$('#{$divId}').css('height','{$height}px');
				</script>
				";
		if (! isset ( $bw->jsflv ))
			$bw->jsflv = "<script type='text/javascript' src='{$bw->vars['board_url']}/javascripts/player/flowplayer-3.2.2.js'></script>";
		else
			$bw->jsflv = "";
		if (file_exists ( UPLOAD_PATH . "{$this->getPath()}{$this->getName()}.png" )){
			
			$BWHTML .= <<<EOF
			{$bw->jsflv}
			{$div}
			<script>
				$(document).ready(function(){
					flowplayer("{$divId}", "{$bw->vars['board_url']}/javascripts/player/flowplayer-3.2.2.swf",
					  {
					  	key: '#$7162d2d730cf607ac6d',
					  	playlist: [
						{
							url: '{$bw->vars['upload_url']}/{$this->getPath()}{$this->getName()}.png', 
							scaling: 'orig'
						},
						{url:'{$this->getPathView()}',autoPlay: false}]
						})
				});
			</script>
EOF;
		}else{
			$BWHTML .= <<<EOF
			{$bw->jsflv}
			{$div}
			<script>
			$(document).ready(function(){
				flowplayer("{$divId}", "{$bw->vars['board_url']}/javascripts/player/flowplayer-3.2.2.swf",
				  {
				  	key: '#$7162d2d730cf607ac6d',
				  	playlist: [
					{url:'{$this->getPathView()}',autoPlay: false}]
					})
			});
			</script>
EOF;
		}
		$bw->jsflv = "";
		return $BWHTML;
	}
}
?>