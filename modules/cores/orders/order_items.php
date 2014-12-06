<?php 
require_once(CORE_PATH."orders/Order_item.class.php");

class order_items extends VSFObject {


	/**
	*Enter description here ...
	**/
	public	function __construct($category=''){
			$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Order_item';
		$this->tableName 		= 'order_item';
		//$this->categoryField='catId';
		//$this->categoryName=$category?$category:"order_items";
		$this->createBasicObject();		parent::__construct();

	}




	
	/**
	*Enter description here ...
	*@var Order_item
	**/
	var		$obj;
}
