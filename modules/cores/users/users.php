<?php 
require_once(CORE_PATH."users/User.class.php");

class users extends VSFObject {


	/**
	*Enter description here ...
	**/
	public	function __construct($category=''){
			$this->primaryField 	= 'id';
		$this->basicClassName 	= 'User';
		$this->tableName 		= 'user';
		//$this->categoryField='catId';
		//$this->categoryName=$category?$category:"users";
		$this->createBasicObject();		parent::__construct();

	}




	
	/**
	*Enter description here ...
	*@var User
	**/
	var		$obj;
	function updateSession($obj=null){
//		print  "<pre>";
//		print_r ($obj);
//		print  "<pre>";
//		exit();
		if(!$obj){
			$obj=$this->basicObject;
		}
		$_SESSION['user']['obj']=$obj->convertToDB();
//		print  "<pre>";
//		print_r ($_SESSION['user']['obj']['id']);
//		print  "<pre>";
//		exit();
	}
	function getObjectByName($name){
		$name=strtolower($name);
		$this->setCondition("name='$name'");
		return $this->getOneObjectsByCondition();
	}
}
