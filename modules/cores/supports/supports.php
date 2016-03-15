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

	public function portlet(){
            global $vsMenu;
		$listObj= $this->getListWithCat(); // lấy theo 1 danh mục hoặc lấy tất cả
		$listFile = $vsMenu->getImgeOfMenu('nickicons','menuId');
      	$nikon = $listFile->getChildren();

     	foreach($listObj as $obj)
       	{
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
		$this->setOrder("supportIndex");
		return $this->getObjectsByCondition ();
	}
	
	function getListWithCat() {
		$listcate =$this->vsMenu->getChildrenIdInTree ( $this->getCategories() );
		$this->setCondition("supportCatId in (" . $listcate . ") and supportStatus > 0");
		$this->setLimit(array(0,20));
		$this->setOrder("supportType DESC,supportIndex");
		return $this->getObjectsByCondition();
	}
	
}
?>