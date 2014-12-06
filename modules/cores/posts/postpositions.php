<?php

require_once(CORE_PATH."posts/Postposition.class.php");

class postpositions extends VSFObject {

/**
 * 
 * Enter description here ...
 * @var Postposition
 */
	function __construct(){
            global $vsMenu;
            parent::__construct();
		$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Postposition';
		$this->tableName 		= 'postposition';
		$this->createBasicObject();
	}
	
	function __destruct(){
		unset($this);
	}
}
?>