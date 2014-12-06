<?php

class VLanguage extends BasicObject {
	
	protected $name 		= null; // name of language package
	protected $admindefault = null; // 0 for admin and 1 for user
	protected $userdefault 	= null; // 0 for not default, 1 for default
	protected $code 		= null; // folder name of language when store language in files
	protected $symbol 		= null; // the symbol of language, e.g: vietnamese flag for vietnamese language


	function convertToDB(){
		isset ( $this->id ) 			? ($dbobj ['id'] = $this->id) : '';
		isset ( $this->name ) 			? ($dbobj ['name'] = $this->name) : '';
		isset ( $this->userdefault ) 	? ($dbobj ['userdefault'] = $this->userdefault) : '';
		isset ( $this->admindefault ) 	? ($dbobj ['admindefault'] = $this->admindefault) : '';
		isset ( $this->code ) 			? ($dbobj ['code'] = $this->code) : '';
		isset ( $this->symbol ) 		? ($dbobj ['symbol'] = $this->symbol) : '';
		isset ( $this->status ) 		? ($dbobj ['status'] = $this->status) : '';
		return $dbobj;

	}

	function convertToObject($object = array()){
		isset ( $object ['id'] ) ? ($this->id = $object ['id'] ) : '';
		isset ( $object ['name'] ) ? ($this->name = $object ['name'] ) : '';
		isset ( $object ['userDefault'] ) ? ($this->userdefault = $object ['userDefault'] ) : '';
		isset ( $object ['adminDefault'] ) ? ($this->admindefault = $object ['adminDefault'] ) : '';
		isset ( $object ['code'] ) ? ($this->code = $object ['code'] ) : '';
		isset ( $object ['symbol'] ) ? ($this->symbol = $object ['symbol'] ) : '';
		isset ( $object ['status'] ) ? ($this->status = $object ['status'] ) : '';
	}
	
	function getName() {
		return $this->name;
	}

	function getAdmindefault() {
		return $this->admindefault;
	}

	function getUserdefault() {
		return $this->userdefault;
	}

	function getCode() {
		return $this->code;
	}

	function getSymbol() {
		return $this->symbol;
	}

	function setName($name) {
		$this->name = $name;
	}

	function setAdmindefault($admindefault) {
		$this->admindefault = $admindefault;
	}

	function setUserdefault($userdefault) {
		$this->userdefault = $userdefault;
	}

	function setCode($code) {
		$this->code = $code;
	}

	function setSymbol($symbol) {
		$this->symbol = $symbol;
	}
	
	function validate() {
		$status = true;
		if ($this->name == "") {
			$this->message .= " key can not be blank!";
			$status = false;
		}
		return $status;
	}
}
?>