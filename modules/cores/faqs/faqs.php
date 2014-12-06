<?php
require_once(CORE_PATH."faqs/Faq.class.php");

class faqs extends VSFObject {


	/**
	*Enter description here ...
	**/
	public	function __construct($category=''){
			$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Faq';
		$this->tableName 		= 'faq';
		//$this->categoryField='catId';
		//$this->categoryName=$category?$category:"faqs";
		$this->createBasicObject();		parent::__construct();

	}




	
	/**
	*Enter description here ...
	*@var Faq
	**/
	var		$obj;
}
