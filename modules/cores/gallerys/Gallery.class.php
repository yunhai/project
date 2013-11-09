<?php
class Gallery extends BasicObject {
	private $passWord = NULL;
        public $module = NULL;
	
	public function getPassWord() {
		return $this->passWord;
	}

	/**
	 * @param $pass the $pass to set
	 */
	public function setPassWord($pass) {
		$this->passWord = $pass;
	}
	
	function __construct() {
		parent::__construct ();
	}
	
	function __destruct() {
		unset ( $this );
	}
	
	public function convertToDB() {
            global $bw;
                $dbobj = parent::convertToDB('gallery');
		isset ( $this->passWord ) ? ($dbobj ['galleryPassWord'] = $this->passWord) : '';
                isset ( $this->code ) ? ($dbobj ['galleryCode'] = $this->code) : '';
                $dbobj ['galleryModule'] = $bw->input['module'];
                
                if( isset ( $this->title ))
                    $cleanContent = VSFTextCode::removeAccent($this->title)." ";
                   
                    $dbobj ['galleryClearSearch'] = strtolower($cleanContent);
		return $dbobj;
	}
	
	public function convertToObject($object = array()) {
                parent::convertToObject($object,'gallery');
		isset ( $object ['galleryPassWord'] ) ? $this->setPassWord ( $object ['galleryPassWord'] ) : '';
                isset ( $object ['galleryModule'] ) ? $this->module = $object ['galleryModule']: '';
	}
        
        function getUrl($module=null) {
		global $bw;
		if(!$module) return $this->url;
		return $bw->base_url . "{$this->module}/detail/".strtolower(VSFTextCode::removeAccent(str_replace("/", '-', trim($this->title)),'-')). '-' . $this->getId () . '.html';
	}
}