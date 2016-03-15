<?php
class Gallery extends BasicObject {
	private $passWord = NULL;
	private $fileupload = NULL;
	
	public function getPassWord() {
		return $this->passWord;
	}

	/**
	 * @param $pass the $pass to set
	 */
	public function setPassWord($pass) {
		$this->passWord = $pass;
	}
	
	public function setFileupload($file) {
		$this->fileupload = $file;
	}

  	public function getFileupload() {
		return $this->fileupload;
	}
	
	function __construct() {
		parent::__construct ();
	}
	
	function __destruct() {
		unset ( $this );
	}
	
	public function convertToDB() {
                $dbobj = parent::convertToDB('gallery');
		isset ( $this->passWord ) ? ($dbobj ['galleryPassWord'] = $this->passWord) : '';
 		isset ( $this->code ) ? ($dbobj ['galleryCode'] = $this->code) : '';
        isset ( $this->fileupload)	? ($dbobj ['galleryFileupload']	 = $this->fileupload) : '';
		return $dbobj;
	}
	
	public function convertToObject($object = array()) {
                parent::convertToObject($object,'gallery');
        isset ( $object ['galleryIntroImage'] )   ? $this->setImage( $object ['galleryIntroImage'] ) : '';
		isset ( $object ['galleryPassWord'] ) ? $this->setPassWord ( $object ['galleryPassWord'] ) : '';
		isset ( $object ['galleryFileupload'] )   ? $this->setFileupload( $object ['galleryFileupload'] ) : '';
	}
	
	public function getFUllImage($arr=array(),$id=0,$dele="deleteImage") {
		global $vsLang;
		if($arr[$id]){
       	return "{$vsLang->getWordsGlobal('obj_deletefile','Delete')} :<input type='checkbox' name='{$dele}' id='{$dele}' />{$arr[$id]->getTitle()}.{$arr[$id]->getType()}";
      	}
	}
}