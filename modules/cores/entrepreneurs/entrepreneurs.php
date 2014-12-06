<?php
require_once(CORE_PATH."entrepreneurs/Entrepreneur.class.php");

class entrepreneurs extends VSFObject {


	/**
	*Enter description here ...
	**/
	public	function __construct($category=''){
			$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Entrepreneur';
		$this->tableName 		= 'entrepreneur';
		//$this->categoryField='catId';
		//$this->categoryName=$category?$category:"entrepreneurs";
		$this->createBasicObject();		parent::__construct();

	}




	
	/**
	*Enter description here ...
	*@var Entrepreneur
	**/
	var		$obj;
}
