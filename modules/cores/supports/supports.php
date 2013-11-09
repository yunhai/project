<?php
require_once (CORE_PATH . "supports/Support.class.php");
class supports extends VSFObject{
	public $obj;
	function __construct(){
		parent::__construct();
		$this->categoryField 	= "supportCatId";
		$this->primaryField 	= 'supportId';
		$this->basicClassName 	= 'Support';
		$this->tableName 		= 'support';
		$this->obj = $this->createBasicObject();
		$this->categories = array();
		$this->categories = $this->vsMenu->getCategoryGroup("supports");
	}

	function __destruct() {
	}

	
	function portlet(){
		global $vsMenu;
		$listObj= $this->getListWithCat();
		$listFile = $vsMenu->getImgeOfMenu('nickicons', 'menuId');
		
		$nikon = $listFile->getChildren();
		foreach($listObj as $obj1)
			foreach($obj1 as $obj){
				if($nikon[$obj->getImageOnline()])$obj->fileOnl = $nikon[$obj->getImageOnline()]->file;
				if($nikon[$obj->getImageOffline()])$obj->fileOff = $nikon[$obj->getImageOffline()]->file;
			}
		return $listObj;
	}
	
	function getSupportWithCatId($catId=0 ) {
		
		$treeCat=$this->vsMenu->getCategoryById($catId);
		if(is_object($treeCat))
		$listcate =$this->vsMenu->getChildrenIdInTree ( $treeCat );
		else
		$listcate =$this->vsMenu->getChildrenIdInTree ( $this->categories );
		$this->getCondition()?$this->setCondition($this->getCondition()." and supportCatId in (" . $listcate . ")"):$this->setCondition("supportStatus >0 and supportCatId in (" . $listcate . ")");
		$this->setLimit(array(0,20));
		$this->setOrder("supportIndex DESC");
		return $this->getObjectsByCondition ();
	}
	
	function getListWithCat($func='getCatId', $group = 1){
		$listcate =$this->vsMenu->getChildrenIdInTree ( $this->getCategories() );
		$this->setCondition("supportCatId in (" . $listcate . ") and supportStatus > 0");
		$this->setLimit(array(0,20));
		$this->setOrder("supportCatId, supportType, supportIndex DESC");
		return $this->getObjectsByCondition($func, $group);
	}
}
?>