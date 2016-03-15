<?php
class News extends BasicObject {
	private $hits = NULL;
	public $parser = NULL;
	public $message = NULL;

	function __construct() {
		parent::__construct ();
	}

	function __destruct() {
		parent::__destruct ();
		unset ( $this->author );
		unset ( $this->hits );
	}
	public function convertToDB() {
		$dbobj = parent::convertToDB('news');
        isset ( $this->postdate )     ? ($dbobj ["newsPostDate"] = $this->postdate) : "";
       	return $dbobj;
	}
	function convertToObject($object) {
		global $vsMenu;
       	parent::convertToObject($object,'news');
		isset ( $object ['newsHits'] ) ? $this->setHits ( $object ['newsHits'] ) : '';
		isset ( $object ['newsPostDate'] ) ? $this->setPostDate( $object ['newsPostDate'] ) : '';
	}

	/**
	 * @param $hits the $hits to set
	 */
	public function setHits($hits) {
		$this->hits = $hits;
	}

	
	
	/**
	 * @return the $hits
	 */
	public function getHits() {
		return $this->hits;
	}

	

}