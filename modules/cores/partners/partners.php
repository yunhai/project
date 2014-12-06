<?php 
require_once(CORE_PATH."partners/Partner.class.php");

class partners extends VSFObject {


	/**
	*Enter description here ...
	**/
	public	function __construct($category=''){
			$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Partner';
		$this->tableName 		= 'partner';
		$this->categoryField='catId';
		$this->categoryName=$category?$category:"partners";
		$this->createBasicObject();		parent::__construct();

	}




	
	/**
	*Enter description here ...
	*@var Partner
	**/
	var		$obj;
}
