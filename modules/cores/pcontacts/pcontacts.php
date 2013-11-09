<?php
require_once (CORE_PATH . "pcontacts/Pcontact.class.php");
class pcontacts extends VSFObject {
	
	function __construct() {
		global $vsMenu, $bw;
		parent::__construct ();
		$this->categoryField = "pcontactCatId";
		$this->primaryField = 'pcontactId';
		$this->basicClassName = 'Pcontact';
		$this->tableName = 'pcontact';
		$this->obj = $this->createBasicObject ();
		$this->categories = $vsMenu->getCategoryGroup ( $bw->input ['module'] );
	}
	function __destruct() {
		unset ( $this );
	}
	
	function getPageContact($module = 'pcontacts') {
		global $vsMenu;
		
		$categories = $vsMenu->getCategoryGroup ( $module );
		$strIds = $vsMenu->getChildrenIdInTree ( $categories );
		
		if( !$strIds ) return;
		$this->setCondition ( "pcontactCatId in ({$strIds}) and pcontactStatus > 0" );
		$option = $this->getOneObjectsByCondition();
		return $option;
	}
	
	function getLastestByModule($module = "pcontacts", $size = 10) {
		global $vsMenu;
		if ($module)
			$categories = $this->vsMenu->getCategoryGroup ( $module );
		else
			$categories = $this->getCategories ();
		
		$strIds = $vsMenu->getChildrenIdInTree ( $categories );
		if( !$strIds ) return array();
		
		$this->setCondition("pcontactStatus > 0 AND pcontactCatId in ({$strIds})");
		
		if( !$this->getOrder() )
			$this->setOrder("pcontactIndex, pcontactId DESC");
			
		$this->setLimit(array(0, $size));
		$result = $this->getObjectsByCondition ();
		if($result) $this->convertFileObject($result, $module);
		return $result;
	}
}
?>