<?php 
require_once(CORE_PATH."contacts/Pcontact.class.php");

class pcontacts extends VSFObject {


	/**
	*Enter description here ...
	**/
	public	function __construct($category=''){
			$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Pcontact';
		$this->tableName 		= 'pcontact';
		$this->categoryField='catId';
		$this->categoryName=$category?$category:"pcontacts";
		$this->createBasicObject();		parent::__construct();

	}




	
	/**
	*Enter description here ...
	*@var Pcontact
	**/
	var		$obj;
}
