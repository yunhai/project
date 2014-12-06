<?php 
require_once(CORE_PATH."supports/Support.class.php");

class supports extends VSFObject {


	/**
	*Enter description here ...
	**/
	public	function __construct($category=''){
			$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Support';
		$this->tableName 		= 'support';
		$this->categoryField='catId';
		$this->categoryName=$category?$category:"supports";
		$this->createBasicObject();		parent::__construct();

	}




	
	/**
	*Enter description here ...
	*@var Support
	**/
	var		$obj;
}
