<?php
require_once(CORE_PATH."albums/Album.class.php");

class albums extends VSFObject {


	/**
	*Enter description here ...
	**/
	public	function __construct($category=''){
			$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Album';
		$this->tableName 		= 'album';
		//$this->categoryField='catId';
		//$this->categoryName=$category?$category:"albums";
		$this->createBasicObject();		parent::__construct();

	}




	
	/**
	*Enter description here ...
	*@var Album
	**/
	var		$obj;
}
