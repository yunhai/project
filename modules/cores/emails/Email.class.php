<?php
class Email extends BasicObject {
	public $email = NULL;

	function __construct() {
		parent::__construct ();
	}

	function __destruct() {
		parent::__destruct ();
		
	}
	public function convertToDB() {
		$dbobj = parent::convertToDB('email');
                isset ( $this->postdate )     ? ($dbobj ["emailPostDate"] = $this->postdate) : "";
                isset ( $this->email )         ? ($dbobj ["emailEmail"] = $this->email) : "";
                 
                return $dbobj;
	}
	function convertToObject($object) {
		global $vsMenu;
       	parent::convertToObject($object,'email');
		isset ( $object ['emailEmail'] ) ? $this->setEmail ( $object ['emailEmail'] ) : '';
		isset ( $object ['emailPostDate'] ) ? $this->setPostDate( $object ['emailPostDate'] ) : '';
	}

	
	public function setEmail($hits) {
		$this->email = $hits;
	}

	public function getEmail() {
		return $this->email;
	}
        

}