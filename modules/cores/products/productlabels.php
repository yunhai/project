<?php
require_once(CORE_PATH."products/Productlabel.class.php");

class productlabels extends VSFObject {


	/**
	*Enter description here ...
	**/
	public	function __construct($category=''){
			$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Productlabel';
		$this->tableName 		= 'productlabel';
		//$this->categoryField='catId';
		//$this->categoryName=$category?$category:"productlabels";
		$this->createBasicObject();		parent::__construct();

	}




	
	/**
	*Enter description here ...
	*@var Productlabel
	**/
	var		$obj;
}
