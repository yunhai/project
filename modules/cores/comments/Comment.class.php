<?php
/**
 +-----------------------------------------------------------------------------
 |   VSF version 5.0
 |	Author: TuyenBui
 |	Email: tuyenbui@vietsol.net
 |	Homepage: http://www.vietsol.net
 |	If you use this code, please don't delete these comment lines!
 |	Comment class builded by classbuilder for all problem contact tuyenbui@vietsol.net
 |	Start Date: 
 |	Finish Date: 
 |	Modified Start Date: 
 |	Modified Finish Date: 
 +-----------------------------------------------------------------------------
 * 
 * @author tuyenbui
 *
 */
class Comment extends BasicObject {
	
	function __construct() {
		/****contructor here****/
		parent::__construct ();
	}
	
	function convertToDB() {
		isset ( $this->id ) ? ($dbobj ['id'] = $this->getId ()) : '';
		isset ( $this->objId ) ? ($dbobj ['objId'] = $this->getObjId ()) : '';
		isset ( $this->catId ) ? ($dbobj ['catId'] = $this->getCatId ()) : '';
		isset ( $this->title ) ? ($dbobj ['title'] = $this->getTitle ()) : '';
		isset ( $this->name ) ? ($dbobj ['name'] = $this->getName ()) : '';
		isset ( $this->email ) ? ($dbobj ['email'] = $this->getEmail ()) : '';
		isset ( $this->image ) ? ($dbobj ['image'] = $this->getImage ()) : '';
		isset ( $this->module ) ? ($dbobj ['module'] = $this->getModule ()) : '';
		isset ( $this->content ) ? ($dbobj ['content'] = $this->getContent ()) : '';
		isset ( $this->postdate ) ? ($dbobj ['postdate'] = $this->getPostdate ()) : '';
		isset ( $this->lastUpdate ) ? ($dbobj ['lastUpdate'] = $this->getLastUpdate ()) : '';
		isset ( $this->status ) ? ($dbobj ['status'] = $this->getStatus ()) : '';
		isset ( $this->userId ) ? ($dbobj ['userId'] = $this->getUserId ()) : '';
		isset ( $this->expertId ) ? ($dbobj ['expertId'] = $this->getExpertId ()) : '';
		isset ( $this->poster ) ? ($dbobj ['poster'] = $this->getPoster ()) : '';
		isset ( $this->profile ) ? ($dbobj ['profile'] = $this->getProfile ()) : '';
		return $dbobj;
	
	}
	
	function convertToObject($object) {
		isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
		isset ( $object ['objId'] ) ? $this->setObjId ( $object ['objId'] ) : '';
		isset ( $object ['catId'] ) ? $this->setCatId ( $object ['catId'] ) : '';
		isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
		isset ( $object ['name'] ) ? $this->setName ( $object ['name'] ) : '';
		isset ( $object ['email'] ) ? $this->setEmail ( $object ['email'] ) : '';
		isset ( $object ['image'] ) ? $this->setImage ( $object ['image'] ) : '';
		isset ( $object ['module'] ) ? $this->setModule ( $object ['module'] ) : '';
		isset ( $object ['content'] ) ? $this->setContent ( $object ['content'] ) : '';
		isset ( $object ['postdate'] ) ? $this->setPostdate ( $object ['postdate'] ) : '';
		isset ( $object ['lastUpdate'] ) ? $this->setLastUpdate ( $object ['lastUpdate'] ) : '';
		isset ( $object ['status'] ) ? $this->setStatus ( $object ['status'] ) : '';
		isset ( $object ['userId'] ) ? $this->setUserId ( $object ['userId'] ) : '';
		isset ( $object ['expertId'] ) ? $this->setExpertId ( $object ['expertId'] ) : '';
		isset ( $object ['poster'] ) ? $this->setPoster ( $object ['poster'] ) : '';
		isset ( $object ['profile'] ) ? $this->setProfile ( $object ['profile'] ) : '';
	
	}
	
	function validate() {
		return true;
	}
	
	function __destruct() {
		unset ( $this );
	}
	
	protected $id = NULL;
	
	protected $objId = NULL;
	
	protected $catId = NULL;
	
	protected $title = NULL;
	
	protected $name = NULL;
	
	protected $email = NULL;
	
	protected $image = NULL;
	
	protected $module = NULL;
	
	protected $content = NULL;
	
	protected $postdate = NULL;
	
	protected $lastUpdate = NULL;
	
	protected $status = 0;
	
	protected $userId = NULL;
	
	protected $expertId = NULL;
	
	protected $poster = NULL;
	
	protected $profile = NULL;
	
	function setId($id) {
		$this->id = $id;
	}
	function getId() {
		return $this->id;
	}
	
	function setObjId($objId) {
		$this->objId = $objId;
	}
	function getObjId() {
		return $this->objId;
	}
	
	function setCatId($catId) {
		$this->catId = $catId;
	}
	function getCatId() {
		return $this->catId;
	}
	
	function setTitle($title) {
		$this->title = $title;
	}
	function getTitle() {
		return $this->title;
	}
	
	function setName($name) {
		$this->name = $name;
	}
	function getName() {
		return $this->name;
	}
	
	function setEmail($email) {
		$this->email = $email;
	}
	function getEmail() {
		return $this->email;
	}
	
	function setImage($image) {
		$this->image = $image;
	}
	function getImage() {
		return $this->image;
	}
	
	function setModule($module) {
		$this->module = $module;
	}
	function getModule() {
		return $this->module;
	}
	
	function setContent($content) {
		$this->content = $content;
	}
	function getContent() {
		$parser = new PostParser ();
		$parser->pp_do_html = 1;
		$parser->pp_nl2br = 1;
		$content = $parser->post_db_parse($this->content);
		return $content;
	}
	
	function setPostdate($postdate) {
		$this->postdate = $postdate;
	}
	
	
	function setLastUpdate($lastUpdate) {
		$this->lastUpdate = $lastUpdate;
	}
	function getLastUpdate() {
		return $this->lastUpdate;
	}
	
	
	function setUserId($userId) {
		$this->userId = $userId;
				}
				function getUserId() {
					return $this->userId;
				}
			
				function setExpertId($expertId) {
					$this->expertId = $expertId;
				}
				function getExpertId() {
					return $this->expertId;
				}
			
				function setPoster($poster) {
					$this->poster = $poster;
				}
				function getPoster() {
					return $this->poster;
				}
			
				function setProfile($profile) {
					$this->profile = $profile;
				}
				function getProfile() {
					return $this->profile;
				}
			

}
?>