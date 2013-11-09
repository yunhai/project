<?php
require_once (CORE_PATH . "news/News.class.php");
class newses extends VSFObject {
	public $obj;
	
	function __construct() {
		global $vsMenu, $catelist;
		parent::__construct ();
		$this->categoryField = "newsCatId";
		$this->primaryField = 'newsId';
		$this->basicClassName = 'News';
		$this->tableName = 'news';
		$this->obj = $this->createBasicObject ();
		$this->obj = &$this->basicObject;
		$this->fields = $this->obj->convertToDB ();
		$this->categories = array ();
		$catelist = $this->categories = $vsMenu->getCategoryGroup ( ($this->tableName) );
	}
}
?>