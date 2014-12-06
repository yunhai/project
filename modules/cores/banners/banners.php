<?php 
require_once(CORE_PATH."banners/Banner.class.php");

class banners extends VSFObject {


	/**
	*Enter description here ...
	**/
	public	function __construct($category=''){
			$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Banner';
		$this->tableName 		= 'banner';
		$this->categoryField='catId';
		$this->categoryName=$category?$category:"banners";
		$this->createBasicObject();		parent::__construct();

	}




	
	/**
	*Enter description here ...
	*@var Banner
	**/
	var		$obj;
}
