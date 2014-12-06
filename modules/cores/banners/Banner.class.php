<?php
class Banner extends BasicObject {

	public function convertToDB() {
		isset ( $this->id ) ? ($dbobj ['id'] = $this->id) : '';
		isset ( $this->catId ) ? ($dbobj ['catId'] = $this->catId) : '';
		isset ( $this->title ) ? ($dbobj ['title'] = $this->title) : '';
		isset ( $this->intro ) ? ($dbobj ['intro'] = $this->intro) : '';
		isset ( $this->content ) ? ($dbobj ['content'] = $this->content) : '';
		isset ( $this->url ) ? ($dbobj ['url'] = $this->url) : '';
		isset ( $this->image ) ? ($dbobj ['image'] = $this->image) : '';
		isset ( $this->position ) ? ($dbobj ['position'] = $this->position) : '';
		isset ( $this->status ) ? ($dbobj ['status'] = $this->status) : '';
		isset ( $this->index ) ? ($dbobj ['index'] = $this->index) : '';
		return $dbobj;
	}

	public function convertToObject($object = array()) {
		isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
		isset ( $object ['catId'] ) ? $this->setCatId ( $object ['catId'] ) : '';
		isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
		isset ( $object ['intro'] ) ? $this->setIntro ( $object ['intro'] ) : '';
		isset ( $object ['content'] ) ? $this->setContent ( $object ['content'] ) : '';
		isset ( $object ['url'] ) ? $this->setUrl ( $object ['url'] ) : '';
		isset ( $object ['image'] ) ? $this->setImage ( $object ['image'] ) : '';
		isset ( $object ['position'] ) ? $this->setPosition ( $object ['position'] ) : '';
		isset ( $object ['status'] ) ? $this->setStatus ( $object ['status'] ) : '';
		isset ( $object ['index'] ) ? $this->setIndex ( $object ['index'] ) : '';
	}

	function getId() {
		return $this->id;
	}

	function getCatId() {
		return $this->catId;
	}

	function getTitle() {
		return $this->title;
	}

	function getIntro() {
		return $this->intro;
	}

	function getContent() {
		return $this->content;
	}

	function getUrl() {
		$url = str_replace("http://", "", $this->url);
		return "http://".$url;
	}

	function getImage() {
		return $this->image;
	}

	function getPosition() {
		return $this->position;
	}

	function getStatus() {
		return $this->status;
	}

	function getIndex() {
		return $this->index;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setCatId($catId) {
		$this->catId = $catId;
	}

	function setTitle($title) {
		$this->title = $title;
	}

	function setIntro($intro) {
		$this->intro = $intro;
	}

	function setContent($content) {
		$this->content = $content;
	}

	function setUrl($url) {
		$this->url = $url;
	}

	function setImage($image) {
		$this->image = $image;
	}

	function setPosition($position) {
		$this->position = $position;
	}

	function setStatus($status) {
		$this->status = $status;
	}

	function setIndex($index) {
		$this->index = $index;
	}
	var $id;
	var $catId;
	var $title;
	var $intro;
	var $content;
	var $url;
	var $image;
	var $position;
	var $status;
	var $index;
}
