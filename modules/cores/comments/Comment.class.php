<?php
require_once (CORE_PATH . "menus/Menu.class.php");
class Comment extends BasicObject {
	private $hits = NULL;
	private $objId 		= NULL;
	private $profile	= NULL;
	public $parser = NULL;
	public $message = NULL;

	function __construct() {
		parent::__construct ();
	}

	function __destruct() {
		parent::__destruct ();
		unset($this->objId);
		unset($this->profile);
		unset ( $this->hits );
	}
	public function convertToDB() {
		$dbobj = parent::convertToDB('comment');
		isset ( $this->objId) 		? ($dbobj ['commentObjId'] 		= $this->objId) 	: '';
		isset ( $this->postdate ) ? ($dbobj ['commentPostdate'] = $this->postdate) : '';
		isset ( $this->hits ) ? ($dbobj ['commentHits'] = $this->hits) : '';
		isset ( $this->profile ) 	? ($dbobj ['commentProfile'] 	= $this->profile) 	: '';
		return $dbobj;
	}
	function convertToObject($object) {
		global $vsMenu;
                parent::convertToObject($object,'comment');
                if($object['menuId']){
                            $menu = new Menu();
                            $menu->convertToObject($object);
                            $this->categoryObj = $menu;
                        }
		isset ( $object ['commentObjId'] ) 	? $this->setObjId($object ['commentObjId'] ) 	: '';
		isset ( $object ['commentPostdate'] ) ? $this->setPostDate ( $object ['commentPostdate'] ) : '';
		isset ( $object ['commentHits'] ) ? $this->setHits ( $object ['commentHits'] ) : '';
		isset ( $object ['commentProfile'])	? $this->setProfile( $object ['commentProfile']): '';
	}

	function validate() {
		$status = true;
		if ($this->author == "") {
			$this->message .= "comments author can not be blank!<br />";
			$status = false;
		}

		
		return $status;
	}
	/**
	 * @param $hits the $hits to set
	 */
	public function setHits($hits) {
		$this->hits = $hits;
	}

	
	public function setCategory($category) {
		$this->category = $category;
	}

	
	/**
	 * @return the $hits
	 */
	public function getHits() {
		return $this->hits;
	}

	function getObjId() {
		return $this->objId;
	}
	function getProfile() {
		return unserialize($this->profile);
	}
	function getEmail() {
		$profile = $this->getProfile();
		
		return $profile['email'];
	}

	
	function setObjId($objId) {
		$this->objId = $objId;
	}


	function setProfile($profile){
		$this->profile = $profile;
	}

}