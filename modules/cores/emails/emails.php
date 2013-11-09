<?php
require_once(CORE_PATH."emails/Email.class.php");
class emails extends VSFObject {
        public $obj;
	function __construct(){
            global $vsMenu;
		parent::__construct();
		$this->categoryField 	= "emailCatId";
		$this->primaryField 	= 'emailId';
		$this->basicClassName 	= 'Email';
		$this->tableName 	= 'email';
		$this->obj              = $this->createBasicObject();
		$this->obj              =&$this->basicObject;
		$this->fields           = $this->obj->convertToDB();
		$this->categories       = array();
		$this->categories       = $vsMenu->getCategoryGroup(($this->tableName));
	}
	
}
?>