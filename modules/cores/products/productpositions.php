<?php

require_once(CORE_PATH."products/Productposition.class.php");

class productpositions extends VSFObject {

/**
 * 
 * Enter description here ...
 * @var Productposition
 */
	function __construct(){
            parent::__construct();
		$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Productposition';
		$this->tableName 		= 'productposition';
		$this->createBasicObject();
	}
	
	function __destruct(){
		unset($this);
	}
}
?>