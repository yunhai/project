<?php
require_once(CORE_PATH."seos/Seo.class.php");

class seos extends VSFObject {


	/**
	*Enter description here ...
	**/
	public	function __construct($category=''){
			$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Seo';
		$this->tableName 		= 'seo';
		//$this->categoryField='catId';
		//$this->categoryName=$category?$category:"seos";
		$this->createBasicObject();		parent::__construct();

	}




	
	/**
	*Enter description here ...
	*@var Seo
	**/
	var		$obj;
}
