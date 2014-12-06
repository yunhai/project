<?php
class Post extends BasicObject {

	public function convertToDB() {
		isset ( $this->id ) ? ($dbobj ['id'] = $this->id) : '';
		isset ( $this->title ) ? ($dbobj ['title'] = $this->title) : '';
		isset ( $this->info ) ? ($dbobj ['info'] = $this->info) : '';
		isset ( $this->intro ) ? ($dbobj ['intro'] = $this->intro) : '';
		isset ( $this->content ) ? ($dbobj ['content'] = $this->content) : '';
		isset ( $this->author ) ? ($dbobj ['author'] = $this->author) : '';
		isset ( $this->postDate ) ? ($dbobj ['postDate'] = $this->postDate) : '';
		isset ( $this->hit ) ? ($dbobj ['hit'] = $this->hit) : '';
		isset ( $this->status ) ? ($dbobj ['status'] = $this->status) : '';
		isset ( $this->publish ) ? ($dbobj ['publish'] = $this->publish) : '';
		isset ( $this->publishDate ) ? ($dbobj ['publishDate'] = $this->publishDate) : '';
		isset ( $this->lastModify ) ? ($dbobj ['lastModify'] = $this->lastModify) : '';
		isset ( $this->modifyBy ) ? ($dbobj ['modifyBy'] = $this->modifyBy) : '';
		isset ( $this->owner ) ? ($dbobj ['owner'] = $this->owner) : '';
		isset ( $this->albumTemplate ) ? ($dbobj ['albumTemplate'] = $this->albumTemplate) : '';
		isset ( $this->video ) ? ($dbobj ['video'] = $this->video) : '';
		isset ( $this->template ) ? ($dbobj ['template'] = $this->template) : '';
		isset ( $this->catId ) ? ($dbobj ['catId'] = $this->catId) : '';
		isset ( $this->index ) ? ($dbobj ['index'] = $this->index) : '';
		isset ( $this->image ) ? ($dbobj ['image'] = $this->image) : '';
		isset ( $this->type ) ? ($dbobj ['type'] = $this->type) : '';
		isset ( $this->mTitle ) ? ($dbobj ['mTitle'] = $this->mTitle) : '';
		isset ( $this->mKeyword ) ? ($dbobj ['mKeyword'] = $this->mKeyword) : '';
		isset ( $this->mIntro ) ? ($dbobj ['mIntro'] = $this->mIntro) : '';
		isset ( $this->mUrl ) ? ($dbobj ['mUrl'] = $this->mUrl) : '';
		return $dbobj;
	}

	public function convertToObject($object = array()) {
		isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
		isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
		isset ( $object ['info'] ) ? $this->setInfo ( $object ['info'] ) : '';
		isset ( $object ['intro'] ) ? $this->setIntro ( $object ['intro'] ) : '';
		isset ( $object ['content'] ) ? $this->setContent ( $object ['content'] ) : '';
		isset ( $object ['author'] ) ? $this->setAuthor ( $object ['author'] ) : '';
		isset ( $object ['postDate'] ) ? $this->setPostDate ( $object ['postDate'] ) : '';
		isset ( $object ['hit'] ) ? $this->setHit ( $object ['hit'] ) : '';
		isset ( $object ['status'] ) ? $this->setStatus ( $object ['status'] ) : '';
		isset ( $object ['publish'] ) ? $this->setPublish ( $object ['publish'] ) : '';
		isset ( $object ['publishDate'] ) ? $this->setPublishDate ( $object ['publishDate'] ) : '';
		isset ( $object ['lastModify'] ) ? $this->setLastModify ( $object ['lastModify'] ) : '';
		isset ( $object ['modifyBy'] ) ? $this->setModifyBy ( $object ['modifyBy'] ) : '';
		isset ( $object ['owner'] ) ? $this->setOwner ( $object ['owner'] ) : '';
		isset ( $object ['albumTemplate'] ) ? $this->setAlbumTemplate ( $object ['albumTemplate'] ) : '';
		isset ( $object ['video'] ) ? $this->setVideo ( $object ['video'] ) : '';
		isset ( $object ['template'] ) ? $this->setTemplate ( $object ['template'] ) : '';
		isset ( $object ['catId'] ) ? $this->setCatId ( $object ['catId'] ) : '';
		isset ( $object ['index'] ) ? $this->setIndex ( $object ['index'] ) : '';
		isset ( $object ['image'] ) ? $this->setImage ( $object ['image'] ) : '';
		isset ( $object ['type'] ) ? $this->setType ( $object ['type'] ) : '';
		isset ( $object ['mTitle'] ) ? $this->setMTitle ( $object ['mTitle'] ) : '';
		isset ( $object ['mKeyword'] ) ? $this->setMKeyWord ( $object ['mKeyword'] ) : '';
		isset ( $object ['mIntro'] ) ? $this->getMIntro ( $object ['mIntro'] ) : '';
		isset ( $object ['mUrl'] ) ? $this->setMUrl ( $object ['mUrl'] ) : '';
	}

	function getId() {
		return $this->id;
	}

	function getTitle() {
		return $this->title;
	}

	function getInfo() {
		return $this->info;
	}

	function getIntro() {
		return $this->intro;
	}

	function getContent() {
		return $this->content;
	}

	function getAuthor() {
		return $this->author;
	}

	function getPostDate() {
		return $this->postDate;
	}

	function getHit() {
		return $this->hit;
	}

	function getStatus() {
		return $this->status;
	}

	function getPublish() {
		return $this->publish;
	}

	function getPublishDate() {
		return $this->publishDate;
	}

	function getLastModify() {
		return $this->lastModify;
	}

	function getModifyBy() {
		return $this->modifyBy;
	}

	function getOwner() {
		return $this->owner;
	}

	function getAlbumTemplate() {
		return $this->albumTemplate;
	}

	function getVideo() {
		return $this->video;
	}

	function getTemplate() {
		return $this->template;
	}

	function getCatId() {
		return $this->catId;
	}

	function getIndex() {
		return $this->index;
	}

	function getImage() {
		return $this->image;
	}

	function getType() {
		return $this->type;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setTitle($title) {
		$this->title = $title;
	}

	function setInfo($info) {
		$this->info = $info;
	}

	function setIntro($intro) {
		$this->intro = $intro;
	}

	function setContent($content) {
		$this->content = $content;
	}

	function setAuthor($author) {
		$this->author = $author;
	}

	function setPostDate($postDate) {
		$this->postDate = $postDate;
	}

	function setHit($hit) {
		$this->hit = $hit;
	}

	function setStatus($status) {
		$this->status = $status;
	}

	function setPublish($publish) {
		$this->publish = $publish;
	}

	function setPublishDate($publishDate) {
		$this->publishDate = $publishDate;
	}

	function setLastModify($lastModify) {
		$this->lastModify = $lastModify;
	}

	function setModifyBy($modifyBy) {
		$this->modifyBy = $modifyBy;
	}

	function setOwner($owner) {
		$this->owner = $owner;
	}

	function setAlbumTemplate($albumTemplate) {
		$this->albumTemplate = $albumTemplate;
	}

	function setVideo($video) {
		$this->video = $video;
	}

	function setTemplate($template) {
		$this->template = $template;
	}

	function setCatId($catId) {
		$this->catId = $catId;
	}

	function setIndex($index) {
		$this->index = $index;
	}

	function setImage($image) {
		$this->image = $image;
	}

	function setType($type) {
		$this->type = $type;
	}
	var $id;
	var $title;
	var $info;
	var $intro;
	var $content;
	var $author;
	var $postDate;
	var $hit;
	var $status;
	var $publish;
	var $publishDate;
	var $lastModify;
	var $modifyBy;
	var $owner;
	var $albumTemplate;
	var $video;
	var $template;
	var $catId;
	var $index;
	var $image;
	var $type;
}
