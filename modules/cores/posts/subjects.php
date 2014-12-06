<?php

require_once(CORE_PATH."posts/Subject.class.php");

class subjects extends VSFObject {

/**
 * 
 * Enter description here ...
 * @var Subject
 */
	function __construct(){
            global $vsMenu;
            parent::__construct();
		$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Subject';
		$this->tableName 		= 'subject';
		$this->createBasicObject();
	}
	
	function __destruct(){
		unset($this);
	}
	function insertObject($obj=null){
		$tmp=null;
		if($obj){
			$tmp=$obj;
		}else{
			$tmp=$this->basicObject;
		}
		require_once UTILS_PATH . 'TextCode.class.php';
		$tmp->setRemovedText(VSFTextCode::strimText($tmp->getTitle())." ".$tmp->getCode());
		return parent::insertObject($tmp);
	}
	function updateObject($obj=null){
		$tmp=null;
		if($obj){
			$tmp=$obj;
		}else{
			$tmp=$this->basicObject;
		}
		require_once UTILS_PATH . 'TextCode.class.php';
		$tmp->setRemovedText(VSFTextCode::strimText($tmp->getTitle())." ".$tmp->getCode());
		return parent::updateObject($tmp);
	}
}
?>