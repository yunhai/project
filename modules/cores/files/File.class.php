<?php
class File extends BasicObject{
	private $module 	= NULL;
	private $type 		= NULL;
	private $size 		= NULL;
	private $uploadTime = NULL;
	private $path 		= NULL;
	private $name 	= NULL;
        private $field=NULL;
        

	function validate() {
		global $vsLang;
		$status = true;
		if ($this->title == "") {
			$this->message .= $vsLang->getWords ( 'file_err_name_blank', "File name cannot be blank!" );
			$status = false;
		}
		return $status;
	}
	function __construct() {
		parent::__construct();
	}
	function convertToDB() {
	
		isset ( $this->id ) 		? ($dbobj ['fileId'] 			= $this->id) 			: '';
		isset ( $this->title ) 		? ($dbobj ['fileTitle'] 		= $this->title) 		: '';
		isset ( $this->module ) 	? ($dbobj ['fileModule'] 		= $this->module) 		: '';
		isset ( $this->intro ) 		? ($dbobj ['fileIntro'] 		= $this->intro)		 	: '';
		isset ( $this->type ) 		? ($dbobj ['fileType'] 			= $this->type) 			: '';
		isset ( $this->url ) 		? ($dbobj ['fileUrl'] 			= $this->url) 			: '';
		isset ( $this->path ) 		? ($dbobj ['filePath'] 			= $this->path) 			: '';
		isset ( $this->status ) 	? ($dbobj ['fileStatus'] 		= $this->status) 		: '';
		isset ( $this->index ) 		? ($dbobj ['fileIndex'] 		= $this->index) 		: '';
		isset ( $this->name ) 		? ($dbobj ['fileName'] 			= $this->name) 			: '';
		isset ( $this->size ) 		? ($dbobj ['fileSize'] 			= $this->size) 			: '';
		isset ( $this->uploadTime ) ? ($dbobj ['fileUploadTime'] 	= $this->uploadTime) 	: '';
                isset ( $this->field ) ? ($dbobj ['fileField'] 	= $this->field) 	: '';
		return $dbobj;
	}

	function convertToObject($object = array()) {

		isset ( $object ['fileId'] ) 			? $this->setId($object ['fileId']) 					: '';
		isset ( $object ['fileTitle'] ) 		? $this->setTitle($object ['fileTitle']) 			: '';
		isset ( $object ['fileIntro'] ) 		? $this->setIntro($object ['fileIntro']) 			: '';
		isset ( $object ['fileModule'] ) 		? $this->setModule($object ['fileModule']) 			: '';
		isset ( $object ['fileType'] ) 			? $this->setType($object ['fileType']) 				: '';
		isset ( $object ['fileUrl'] ) 			? $this->setUrl($object ['fileUrl']) 				: '';
		isset ( $object ['filePath'] ) 			? $this->setPath($object ['filePath']) 				: '';
		isset ( $object ['fileIndex'] ) 		? $this->setIndex($object ['fileIndex']) 			: '';
		isset ( $object ['fileStatus'] ) 		? $this->setStatus($object ['fileStatus']) 			: '';
		isset ( $object ['fileName'] ) 			? $this->setName($object ['fileName']) 				: '';
		isset ( $object ['fileSize'] ) 			? $this->setSize($object ['fileSize']) 				: '';
                isset ( $object ['fileField'] ) 		? $this->setField($object ['fileField']) 			: '';
		isset ( $object ['fileUploadTime'] ) 	? $this->setUploadTime($object ['fileUploadTime']) 	: '';
	}
	
	function __set_state($array=array()) {
		$file = new File();
		foreach ($array as $key => $value) {
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
        
        function getField() {
		return $this->field;
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
	function getTitle(){
		return ltrim($this->title,"~");
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

	function getName(){
		return ltrim($this->name,"~");
	}
        function setField($name){
		 $this->field = $name;
	}

//	function getPathView($type=true) {
//		global $bw;
//
//		if(!$type) return UPLOAD_PATH . "{$this->path}{$this->getName()}_{$this->uploadTime}.{$this->type}";
//		return $bw->vars['board_url']."/uploads/".$this->path.$this->getName().'_'.$this->uploadTime.'.'.$this->type;
//	}
	
	function getPathView($type=2) {
		global $bw;
		if(!$type) return UPLOAD_PATH . "{$this->path}{$this->getName()}_{$this->uploadTime}.{$this->type}";
		if($type==1) return "{$this->path}{$this->getName()}_{$this->uploadTime}.{$this->type}";
		return $bw->vars['upload_url']."/".$this->path.$this->getName().'_'.$this->uploadTime.'.'.$this->type;
	}
	
	function show($width=150, $height=150,$divId=null){
		global $bw,$vsPrint;
		if(stristr("doc pdf docx xlxs ", $this->type))
		return "<div>".$this->getName().".".$this->getType()."</div>";
		
		if(stristr("jpg gif png", $this->type))
		return "<img src='{$bw->vars['board_url']}/utils/timthumb.php?src={$this->getPathView()}&w=$width&h=$height&zc=1' alt='{$this->getName()}' />";
		if($this->type=="swf")
			return <<<EOF
			<object height="$height" width="$width" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
	              <param value="{$this->getPathView()}" name="movie">
	              <param name="wmode" value="transparent">
	              <param value="high" name="quality">
	              <embed height="$height" width="$width" wmode="transparent" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" quality="high" src="{$this->getPathView()}">
	   	    </object>
EOF;
		if($this->type=="flv") {
			if(!$divId)
			{
				$div="<div id='flvdix{$this->id}' style='width:{$width}px;height:{$height}px'></div>";
				$divId="flvdix{$this->id}";
			}
			else
			$div="
				<script>
					$('#{$divId}').css('width','{$width}px');
					$('#{$divId}').css('height','{$height}px');
				</script>
				";
			if(!isset($bw->jsflv))
			$bw->jsflv="<script type='text/javascript' src='{$bw->vars['board_url']}/javascripts/player/flowplayer-3.2.2.js'></script>";
			else
			$bw->jsflv="";
			if(file_exists(UPLOAD_PATH."{$this->getPath()}{$this->getName()}_{$this->uploadTime}.png"))
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
							url: '{$bw->vars['upload_url']}/{$this->getPath()}{$this->getName()}_{$this->uploadTime}.png', 
							scaling: 'orig'
						},
						{url:'{$this->getPathView()}',autoPlay: false}]
						})
				});
			</script>
EOF;
			else
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
			$bw->jsflv="";
			return $BWHTML;
		}
	}
}
?>