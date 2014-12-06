<?php 
require_once(CORE_PATH."contacts/Contact.class.php");

class contacts extends VSFObject {


	/**
	*Enter description here ...
	**/
	public	function __construct($category=''){
			$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Contact';
		$this->tableName 		= 'contact';
		//$this->categoryField='catId';
		//$this->categoryName=$category?$category:"contacts";
		$this->createBasicObject();		parent::__construct();

	}




	
	/**
	*Enter description here ...
	*@var Contact
	**/
	var		$obj;
}
