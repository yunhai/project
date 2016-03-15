<?php
class Poll extends BasicObject{

	private $click	 	= NULL;
	function __construct() {
		parent::__construct ();
	}
	function __destruct() {
		parent::__destruct();
		unset($this->click);
	}
	public function getClick() {
		return $this->click;
	}

	public function setClick($click) {
		$this->click = $click;
	}

	function convertToDB() {
		$dbobj = parent::convertToDB('poll');
		isset ( $this->click ) 			? ($dbobj ['pollClick'] 		= $this->click) 			: '';
	
		return $dbobj;
	}

	function convertToObject($object) {
		parent::convertToObject($object,'poll');
		isset ( $object ['pollClick'] ) 		? $this->setClick ( $object ['pollClick'] ) 			: '';
		
	}

	
}