<?php 
require_once(CORE_PATH."pages/Page.class.php");

class pages extends VSFObject {


	/**
	*Enter description here ...
	**/
	public	function __construct($category=''){
			$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Page';
		$this->tableName 		= 'page';
		$this->categoryField='catId';
		$this->categoryName=$category?$category:"pages";
		$this->createBasicObject();		parent::__construct();

	}




	
	/**
	*Enter description here ...
	*@var Page
	**/
	var		$obj;
}
