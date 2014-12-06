<?php
require_once(CORE_PATH."assessments/Assessment.class.php");

class assessments extends VSFObject {


	/**
	*Enter description here ...
	**/
	public	function __construct($category=''){
			$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Assessment';
		$this->tableName 		= 'assessment';
		//$this->categoryField='catId';
		//$this->categoryName=$category?$category:"assessments";
		$this->createBasicObject();		parent::__construct();

	}




	
	/**
	*Enter description here ...
	*@var Assessment
	**/
	var		$obj;
}
