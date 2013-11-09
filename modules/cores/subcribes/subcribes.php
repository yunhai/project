<?php
require_once(CORE_PATH."subcribes/Subcribe.class.php");
//require_once(CORE_PATH."permits/permits.php");

class subcribes extends VSFObject {
//	public $obj;
//	protected $categoryField 	="";
//	protected $categories 		= array();

	function __construct(){
            global $vsMenu;
			parent::__construct();
			$this->primaryField 	= 'subId';
			$this->basicClassName 	= 'Subcribe';
			$this->tableName 		= 'subcribe';
			$this->obj = $this->createBasicObject();
			$this->obj = &$this->basicObject;
			$this->fields = $this->obj->convertToDB();
	}
	
	function __destruct(){
		unset($this);
	}

}
?>