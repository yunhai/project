<?php
class Gallery extends BasicObject {
	function __construct() {
		parent::__construct ();
	}
	
	function __destruct() {
		unset ( $this );
	}
	
	public function convertToDB() {
		isset ( $this->id ) ? ($dbobj ['id'] = $this->id) : '';
		isset ( $this->catId ) ? ($dbobj ['catId'] = $this->catId) : '';
		isset ( $this->title ) ? ($dbobj ['title'] = $this->title) : '';
		isset ( $this->album ) ? ($dbobj ['album'] = $this->album) : '';
		isset ( $this->intro ) ? ($dbobj ['intro'] = $this->intro) : '';
		isset ( $this->index ) ? ($dbobj ['index'] = $this->index) : '';
		isset ( $this->status ) ? ($dbobj ['status'] = $this->status) : '';
		isset ( $this->code ) ? ($dbobj ['code'] = $this->code) : '';
		isset ( $this->module ) ? ($dbobj ['module'] = $this->module) : '';
		isset ( $this->image ) ? ($dbobj ['image'] = $this->image) : '';
		isset ( $this->passWord ) ? ($dbobj ['passWord'] = $this->passWord) : '';
		isset ( $this->postDate ) ? ($dbobj ['postDate'] = $this->postDate) : '';
		return $dbobj;
	}
	
	public function convertToObject($object = array()) {
		isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
		isset ( $object ['catId'] ) ? $this->setCatId ( $object ['catId'] ) : '';
		isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
		isset ( $object ['album'] ) ? $this->setAlbum ( $object ['album'] ) : '';
		isset ( $object ['intro'] ) ? $this->setIntro ( $object ['intro'] ) : '';
		isset ( $object ['index'] ) ? $this->setIndex ( $object ['index'] ) : '';
		isset ( $object ['status'] ) ? $this->setStatus ( $object ['status'] ) : '';
		isset ( $object ['code'] ) ? $this->setCode ( $object ['code'] ) : '';
		isset ( $object ['image'] ) ? $this->setImage ( $object ['image'] ) : '';
		isset ( $object ['module'] ) ? $this->setModule ( $object ['module'] ) : '';
		isset ( $object ['passWord'] ) ? $this->setPassWord ( $object ['passWord'] ) : '';
		isset ( $object ['postDate'] ) ? $this->setPostDate ( $object ['postDate'] ) : '';
	}
	public $id=NuLL;
	public $catId=NuLL;
	public $album=NuLL;
	public $module=NuLL;
	public $intro=NuLL;
	public $index=NuLL;
	public $status=NuLL;
	public $code=NuLL;
	public $image=NuLL;
	public $passWord=NuLL;
	public $postDate=NuLL;
	/**
	 * @return the $module
	 */
	/**
	 * @return the $postDate
	 */
	public function getPostDate() {
		return $this->postDate;
	}

	/**
	 * @param field_type $postDate
	 */
	public function setPostDate($postDate) {
		$this->postDate = $postDate;
	}

	public function getModule() {
		return $this->module;
	}

	/**
	 * @param field_type $module
	 */
	public function setModule($module) {
		$this->module = $module;
	}
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return the $catId
	 */
	public function getCatId() {
		return $this->catId;
	}

	/**
	 * @return the $album
	 */
	public function getAlbum() {
		return $this->album;
	}

	/**
	 * @return the $intro
	 */
	public function getIntro() {
		return $this->intro;
	}

	/**
	 * @return the $index
	 */
	public function getIndex() {
		return $this->index;
	}

	/**
	 * @return the $status
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @return the $code
	 */
	public function getCode() {
		return $this->code;
	}

	/**
	 * @return the $image
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * @return the $passWord
	 */
	public function getPassWord() {
		return $this->passWord;
	}

	/**
	 * @param field_type $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @param field_type $catId
	 */
	public function setCatId($catId) {
		$this->catId = $catId;
	}

	/**
	 * @param field_type $album
	 */
	public function setAlbum($album) {
		$this->album = $album;
	}

	/**
	 * @param field_type $intro
	 */
	public function setIntro($intro) {
		$this->intro = $intro;
	}

	/**
	 * @param field_type $index
	 */
	public function setIndex($index) {
		$this->index = $index;
	}

	/**
	 * @param field_type $status
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

	/**
	 * @param field_type $code
	 */
	public function setCode($code) {
		$this->code = $code;
	}

	/**
	 * @param field_type $image
	 */
	public function setImage($image) {
		$this->image = $image;
	}

	/**
	 * @param field_type $passWord
	 */
	public function setPassWord($passWord) {
		$this->passWord = $passWord;
	}

}