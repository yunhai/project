<?php
require_once(CORE_PATH."proposals/Proposal.class.php");

class proposals extends VSFObject {


	/**
	*Enter description here ...
	**/
	public	function __construct($category=''){
			$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Proposal';
		$this->tableName 		= 'proposal';
		//$this->categoryField='catId';
		//$this->categoryName=$category?$category:"proposals";
		$this->createBasicObject();		parent::__construct();

	}




	
	/**
	*Enter description here ...
	*@var Proposal
	**/
	var		$obj;
}
