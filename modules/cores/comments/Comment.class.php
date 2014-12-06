<?php
class Comment extends BasicObject {

	public function convertToDB() {
		isset ( $this->objId ) ? ($dbobj ['objId'] = $this->objId) : '';
		isset ( $this->catId ) ? ($dbobj ['catId'] = $this->catId) : '';
		isset ( $this->title ) ? ($dbobj ['title'] = $this->title) : '';
		isset ( $this->image ) ? ($dbobj ['image'] = $this->image) : '';
		isset ( $this->module ) ? ($dbobj ['module'] = $this->module) : '';
		isset ( $this->content ) ? ($dbobj ['content'] = $this->content) : '';
		isset ( $this->postdate ) ? ($dbobj ['postdate'] = $this->postdate) : '';
		isset ( $this->lastUpdate ) ? ($dbobj ['lastUpdate'] = $this->lastUpdate) : '';
		isset ( $this->status ) ? ($dbobj ['status'] = $this->status) : '';
		isset ( $this->userId ) ? ($dbobj ['userId'] = $this->userId) : '';
		isset ( $this->poster ) ? ($dbobj ['poster'] = $this->poster) : '';
		isset ( $this->profile ) ? ($dbobj ['profile'] = $this->profile) : '';
		isset ( $this->name ) ? ($dbobj ['name'] = $this->name) : '';
		isset ( $this->email ) ? ($dbobj ['email'] = $this->email) : '';
		return $dbobj;
	}

	public function convertToObject($object = array()) {
		isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
		isset ( $object ['objId'] ) ? $this->setObjId ( $object ['objId'] ) : '';
		isset ( $object ['catId'] ) ? $this->setCatId ( $object ['catId'] ) : '';
		isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
		isset ( $object ['image'] ) ? $this->setImage ( $object ['image'] ) : '';
		isset ( $object ['module'] ) ? $this->setModule ( $object ['module'] ) : '';
		isset ( $object ['content'] ) ? $this->setContent ( $object ['content'] ) : '';
		isset ( $object ['postdate'] ) ? $this->setPostdate ( $object ['postdate'] ) : '';
		isset ( $object ['lastUpdate'] ) ? $this->setLastUpdate ( $object ['lastUpdate'] ) : '';
		isset ( $object ['status'] ) ? $this->setStatus ( $object ['status'] ) : '';
		isset ( $object ['userId'] ) ? $this->setUserId ( $object ['userId'] ) : '';
		isset ( $object ['poster'] ) ? $this->setPoster ( $object ['poster'] ) : '';
		isset ( $object ['profile'] ) ? $this->setProfile ( $object ['profile'] ) : '';
		isset ( $object ['name'] ) ? $this->setName ( $object ['name'] ) : '';
		isset ( $object ['email'] ) ? $this->setEmail ( $object ['email'] ) : '';
	}

	function getId() {
		return $this->id;
	}

	function getObjId() {
		return $this->objId;
	}

	function getCatId() {
		return $this->catId;
	}

	function getTitle() {
		return $this->title;
	}

	function getImage() {
		return $this->image;
	}

	function getModule() {
		return $this->module;
	}

	function getContent() {
		return $this->content;
	}

	function getPostdate() {
		return $this->postdate;
	}

	function getLastUpdate() {
		return $this->lastUpdate;
	}

	function getStatus() {
		return $this->status;
	}

	function getUserId() {
		return $this->userId;
	}

	function getPoster() {
		return $this->poster;
	}

	function getProfile() {
		return $this->profile;
	}

	function getName() {
		return $this->name;
	}

	function getEmail() {
		return $this->email;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setObjId($objId) {
		$this->objId = $objId;
	}

	function setCatId($catId) {
		$this->catId = $catId;
	}

	function setTitle($title) {
		$this->title = $title;
	}

	function setImage($image) {
		$this->image = $image;
	}

	function setModule($module) {
		$this->module = $module;
	}

	function setContent($content) {
		$this->content = $content;
	}

	function setPostdate($postdate) {
		$this->postdate = $postdate;
	}

	function setLastUpdate($lastUpdate) {
		$this->lastUpdate = $lastUpdate;
	}

	function setStatus($status) {
		$this->status = $status;
	}

	function setUserId($userId) {
		$this->userId = $userId;
	}

	function setPoster($poster) {
		$this->poster = $poster;
	}

	function setProfile($profile) {
		$this->profile = $profile;
	}

	function setName($name) {
		$this->name = $name;
	}

	function setEmail($email) {
		$this->email = $email;
	}
	
	function validate() {
		return true;
	}
	
	var $id;
	var $objId;
	var $catId;
	var $title;
	var $image;
	var $module;
	var $content;
	var $postdate;
	var $lastUpdate;
	var $status;
	var $userId;
	var $poster;
	var $profile;
	var $name;
	var $email;
}
