<?php
require_once(CORE_PATH."supports/Supporttype.class.php");

class supporttypes extends VSFObject {


	/**
	*Enter description here ...
	**/
	public	function __construct($category=''){
			$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Supporttype';
		$this->tableName 		= 'supporttype';
		//$this->categoryField='catId';
		//$this->categoryName=$category?$category:"supporttypes";
		$this->createBasicObject();		parent::__construct();

	}




	
	/**
	*Enter description here ...
	*@var Supporttype
	**/
	var		$obj;
}
