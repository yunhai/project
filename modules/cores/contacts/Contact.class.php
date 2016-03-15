<?php

class Contact extends BasicObject{

	private $profile 	= NULL;
	private $email 		= NULL;
	private $address 	= NULL;
	private $isReply 	= NULL;
	private $phone 		= NULL;
	private $name  		= NULL;
	private $type		= NULL;
	private $fileId		= NULL;

	function convertToDB() {
		$dbobj = parent::convertToDB('contact');
		
		isset ( $this->name ) 			? ($dbobj ['contactName'] 			= $this->name) 				: '';//name
		isset ( $this->profile ) 		? ($dbobj ['contactProfile'] 		= serialize ( $this->profile )) 			: '';//profile		
		isset ( $this->email ) 			? ($dbobj ['contactEmail'] 			= $this->email) 			: '';//email
		isset ( $this->type ) 			? ($dbobj ['contactType'] 			= $this->type) 				: '';//type	
		isset ( $this->postdate ) 		? ($dbobj ['contactPostDate'] 		= $this->postdate) 			: '';//postdate
		isset ( $this->isReply ) 		? ($dbobj ['contactIsReply'] 		= $this->isReply) 			: '';//reply
		isset ( $this->fileId ) 		? ($dbobj ['contactFileId'] 	= $this->fileId) 				: '';//fileId
		return $dbobj;
	}

	function convertToObject($object) {
		global $vsMenu;
		parent::convertToObject($object,'contact');
		
		
		isset ( $object ['contactType'] ) 		? $this->setType ( $object ['contactType'] ) 			: '';
		
		isset ( $object ['contactEmail'] ) 		? $this->setEmail ( $object ['contactEmail'] ) 			: '';
		isset ( $object ['contactProfile'] ) 	? $this->setProfile ( $object ['contactProfile'] ) 		: '';
		isset ( $object ['contactAddress'] ) 		? $this->setAddress( $object ['contactAddress'] ) 			: '';
		isset ( $object ['contactPostDate'] ) 	? $this->setPostDate ( $object ['contactPostDate'] ) 	: '';
		isset ( $object ['contactIsReply'] ) 	? $this->setIsReply ( $object ['contactIsReply'] ) 		: '';
		isset ( $object ['contactName'] ) 		? $this->setName ( $object ['contactName'] ) 			: '';
		isset ( $object ['contactPhone'] ) 		? $this->setPhone ( $object ['contactPhone'] ) 			: '';
		isset ( $object ['contactFileId'] ) 	? $this->setFileId ( $object ['contactFileId'] ) 		: '';
	}

	function __construct(){
		parent::__construct();
	}
	
	function validate(){
		global $vsLang, $vsSettings;
              
		$this->result ['status'] = true;
		$this->result ['message'] = "";
		if($vsSettings->getSystemKey("contact_form_name", 1, "contacts", 1, 1)){
			if($this->getName() == ""){
				$this->result['status'] = false;
				$this->result['message'] .= $vsLang->getWords("contacts_ErrorNameEmpty","* Name cannot be blank!");
			}
		}
		
		if($vsSettings->getSystemKey("contact_form_title", 1, "contacts", 1, 1)){
			if($this->getTitle() == ""){
				$this->result['status'] = false;
				$this->result['message'] .= $vsLang->getWords("contacts_ErrorTitleEmpty","* Title cannot be blank!");
			}
		}
		
	
		return $this->result['status'];
	}
	
	function __destruct() {
		parent::__destruct ();
		unset ( $this->profile );
		unset ( $this->email );
		unset ( $this->isReply );
		unset ( $this->address );
		unset ( $this->phone );
		unset ( $this->name );
		unset ( $this->type );
		unset ( $this->fileId );
	}
	public function setFileId($fileId) {
		$this->fileId = $fileId;
	}


	public function getFileId() {
		return $this->fileId;
	}
	public function setType($type) {
		$this->type = $type;
	}

	
	public function getType() {
		return $this->type;
	}


	public function setName($name) {
		$this->name = $name;
	}


	public function getName() {
		return $this->name;
	}


	public function setPhone($phone) {
		
//			$profile = $this->getProfile();
//			$this->phone = $profile['contactPhone'];
			$this->profile['contactPhone']= $phone;
		
		
	}

	public function getPhone() {
		return $this->profile['contactPhone'];
	}


	public function setIsReply($isReply) {
		$this->isReply = $isReply;
	}


	public function setAddress($address) {
		
//			$profile = $this->getProfile();
//			$this->address = $profile['contactAddress'];
			$this->profile['contactAddress']= $address;
		
		
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function setProfile($profile) {
		$this->profile = unserialize($profile);
	}

	public function getIsReply() {
		return $this->isReply;
	}

	public function getAddress() {
		return $this->profile['contactAddress'];
	}


	public function getEmail() {
		return $this->email;
	}


	public function getProfile() {
		return $this->profile;
	}
}
?>