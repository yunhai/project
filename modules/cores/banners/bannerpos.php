<?php
require_once(CORE_PATH."banners/Bannerpo.class.php");

class bannerpos extends VSFObject {


	/**
	*Enter description here ...
	**/
	public	function __construct($category=''){
			$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Bannerpo';
		$this->tableName 		= 'bannerpo';
		//$this->categoryField='catId';
		//$this->categoryName=$category?$category:"bannerpos";
		$this->createBasicObject();		parent::__construct();

	}




	
	/**
	*Enter description here ...
	*@var Bannerpo
	**/
	var		$obj;
}
