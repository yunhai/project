<?php
require_once(CORE_PATH."langs/VLanguage.class.php");

class vlanguages extends VSFObject {

	public	function __construct(){
			
		$this->primaryField 	= 'id';
		$this->basicClassName 	= 'VLanguage';
		$this->tableName 		= 'langs';
		$this->createBasicObject();		
		parent::__construct();
	}

	var		$obj;
}
?>