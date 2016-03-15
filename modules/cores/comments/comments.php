<?php

require_once(CORE_PATH."comments/Comment.class.php");

class comments extends VSFObject {

/**
 * 
 * Enter description here ...
 * @var Comment
 */
	public $obj;

	function __construct(){
            global $vsMenu;
            parent::__construct();
		$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Comment';
		$this->tableName 		= 'comment';
		$this->basicObject = $this->obj = $this->createBasicObject();
		
	}
	
	function __destruct(){
		unset($this);
	}
	function getCommentForObject($objId,$module,$getall=false){
		if(!$getall){
			$this->setCondition("`status`=2");
		}
		$this->setOrder("postDate");
		return $this->getObjectsByCondition();
		
	}
	
	function getCommentAsOption($objId,$module){
		$cond = "`status`=2 AND objId = $objId AND module = '{$module}'";
		$this->setCondition($cond);
		$this->setOrder("postDate");
		return $this->getPageList($url);
	}
}
?>