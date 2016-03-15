<?php
require_once (CORE_PATH . "pcontacts/Pcontact.class.php");
class pcontacts extends VSFObject {
	public $obj;
	function __construct() {
		global $vsMenu, $bw;
		parent::__construct ();
		$this->categoryField = "pcontactCatId";
		$this->primaryField = 'pcontactId';
		$this->basicClassName = 'Pcontact';
		$this->tableName = 'pcontact';
		$this->obj = $this->createBasicObject ();
		$this->obj = &$this->basicObject;
		$this->fields = $this->obj->convertToDB ();
		$this->categories = array ();
		$this->categories = $vsMenu->getCategoryGroup ( $bw->input ['module'] );
	}
	function __destruct() {
		unset ( $this );
	}
	
	function getPageContact($module = 'pcontacts') {
		global $bw, $vsStd, $vsSettings, $vsLang, $vsMenu;
		
		$categories = $vsMenu->getCategoryGroup ( $module );
		$strIds = $vsMenu->getChildrenIdInTree ( $categories );
		$this->setCondition ( "pcontactCatId in ({$strIds}) and pcontactStatus > 0" );
		$option = $this->getOneObjectsByCondition ();
		return $option;
	}

}
?>