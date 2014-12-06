<?php
require_once(CORE_PATH."posts/Post.class.php");

class posts extends VSFObject {


	/**
	*Enter description here ...
	**/
	public	function __construct($category=''){
			$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Post';
		$this->tableName 		= 'post';
		$this->categoryField='catId';
		$this->categoryName=$category?$category:"posts";
		$this->createBasicObject();		parent::__construct();

	}
	function getOtherPost($obj,$limit=5){
		if(!is_object($obj)) return array();
		$ids=VSFactory::getMenus()->getChildrenIdInTree(VSFactory::getMenus()->getCategoryById($obj->getCatId()));
		if($ids){
			$this->setCondition("id!='{$obj->getId()}' and catId in ($ids)");
		}
		
		$this->setLimit(array(0,$limit));
		return $this->getObjectsByCondition();
	}

	function getHotPost($limit=5){
		$this->setCondition("status =2");
		$this->setLimit(array(0,$limit));
		return $this->getObjectsByCondition();
	}

	
	/**
	*Enter description here ...
	*@var Post
	**/
	var		$obj;
}
