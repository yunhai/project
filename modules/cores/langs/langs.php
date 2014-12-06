<?php
require_once(CORE_PATH."langs/Lang.class.php");

class langs extends VSFObject {

	public	function __construct($category=''){
		$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Lang';
		$this->tableName 		= 'lang';
		$this->createBasicObject();		parent::__construct();
	}

	var	$obj;
}
