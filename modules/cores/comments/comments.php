<?php 
require_once(CORE_PATH."comments/Comment.class.php");

class comments extends VSFObject {


	/**
	*Enter description here ...
	**/
	public	function __construct($category=''){
			$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Comment';
		$this->tableName 		= 'comment';
		$this->createBasicObject();		parent::__construct();

	}

	public function getCommentList($objId,$module,$url = "comments/view", $objIndex = 8, $size =8, $ajax = 1, $callack = "comment_page") {
		global $DB,$bw;
		
		
		$this->setCondition("status > 0 and objId = $objId and module='$module'  and userId=0");
		$this->setOrder("postdate desc");
		

		$list = $this->getPageList($url."/$objId",$objIndex,$size,$ajax,$callack);
		
		foreach ($list['pageList'] as $key => $value){
			$child = $this->getChildren($key, $objId, $module);
			if($child){
				$list['pageList'][$key]->child = $child;
			}
		}
		
		return $list;
	}


	function getChildren($id,$objId,$module){
		$this->setCondition("status > 0 and objId = $objId and module='$module' and userId in($id)");
		$this->setOrder("postdate desc");
		return  $this->getObjectsByCondition();
	}
	
	/**
	*Enter description here ...
	*@var Comment
	**/
	var		$obj;
}
