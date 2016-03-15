<?php
class Advisory extends BasicObject{
	private $email 		= NULL;
	private $address 	= NULL;
	private $phone 		= NULL;
	private $type		= NULL;
	private $name		= NULL;

	function __construct(){
		parent::__construct();
	  
	}
	
	function __destruct() {
		parent::__destruct ();
		unset ( $this->email );
		unset ( $this->address );
		unset ( $this->phone );
		unset ( $this->type );
		unset ( $this->name);
		
	}
	
	public function setType($type) {
		$this->type = $type;
	}

	public function setPhone($phone) {
		$this->phone = "#".$phone;
	}

	public function setAddress($address) {
		$this->address = $address;
	}

	public function setEmail($email) {
		$this->email = $email;
	}
	public function getType() {
		return $this->type;
	}

	public function getPhone() {
		return str_replace("#", "", $this->phone);
	}

	public function getAddress() {
		return $this->address;
	}

	public function getEmail() {
		return $this->email;
	}

	public function convertToDB() {
     	$dbobj = parent::convertToDB('advisory');
		isset ( $this->email ) 			? ($dbobj ['advisoryEmail'] 		= $this->email) 			: '';//email
		isset ( $this->phone ) 			? ($dbobj ['advisoryPhone'] 		= $this->phone) 			: '';//TITLE
		isset ( $this->address ) 		? ($dbobj ['advisoryAddress'] 		= $this->address) 			: '';//TITLE
		isset ( $this->name ) 			? ($dbobj ['advisoryName'] 		= $this->name) 				: '';
		return $dbobj;
	}

	function convertToObject($object) {
		global $vsMenu;

      	parent::convertToObject($object,'advisory');
		isset ( $object ['advisoryEmail'] ) 	? $this->setEmail ( $object ['advisoryEmail'] ) 		: '';
		isset ( $object ['advisoryAddress'] ) 	? $this->setAddress ( $object ['advisoryAddress'] )             : '';
		isset ( $object ['advisoryPhone'] ) 	? $this->setPhone ( $object ['advisoryPhone'] ) 		: '';
		isset ( $object ['advisoryName'] ) 	? $this->setName ( $object ['advisoryName'] ) 			: '';
	}

	public function setName($name) {
		$this->name = $name;
	}

	
	public function getName() {
		return $this->name;
	}
}
?>