<?php

class Subcribe extends BasicObject {
	private $email 	= NULL;
	private $user	= NULL;
	private $profile = NULL;
	
	function __construct() {
		parent::__construct();
	}

	function __destruct() {
		parent::__destruct();
	}
	
	function convertToDB() {
		isset ( $this->id ) 	? ($dbobj ['subId'] 		= $this->id) 		: '';
		isset ( $this->user ) 	? ($dbobj ['subUser'] 		= $this->user) 		: '';
		isset ( $this->email ) 	? ($dbobj ['subEmail'] 		= $this->email) 	: '';
		isset ( $this->content)	? ($dbobj ['subContent'] 	= $this->content) 	: '';
		isset ( $this->profile)	? ($dbobj ['subProfile'] 	= $this->profile) 	: '';
		isset ( $this->status ) ? ($dbobj ['subStatus'] 	= $this->status) 	: '';
		return $dbobj;
	}
	
	function convertToObject($object) {
		global $vsMenu;

		parent::convertToObject($object);
		isset ( $object ['subId'] ) 	? $this->setId ( $object ['subId'] ) : '';
		isset ( $object ['subUser'] ) 	? $this->setUser ( $object ['subUser'] ) : '';
		isset ( $object ['subEmail'] ) 	? $this->setEmail ( $object ['subEmail'] ) : '';
		isset ( $object ['subContent'])	? $this->setContent ( $object ['subContent'] ) : '';
		isset ( $object ['subProfile'])	? $this->setProfile ( $object ['subProfile'] ) : '';
		isset ( $object ['subStatus'] ) ? $this->setStatus ( $object ['subStatus'] ) : '';
	}
	
	function getEmail() {
		return $this->email;
	}

	function getUser() {
		return $this->user;
	}

	function getProfile() {
		return $this->profile;
	}

	function setEmail($email) {
		$this->email = $email;
	}

	function setUser($user) {
		$this->user = $user;
	}

	function setProfile($profile) {
		$this->profile = $profile;
	}

	
}