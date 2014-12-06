<?php 
require_once(CORE_PATH."products/Product.class.php");

class products extends VSFObject {


	/**
	*Enter description here ...
	**/
	public	function __construct($category=''){
			$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Product';
		$this->tableName 		= 'product';
		$this->categoryField='catId';
		$this->categoryName=$category?$category:"products";
		$this->createBasicObject();		parent::__construct();

	}

public function getOtherList($obj) {
		global $bw;
		$vsMenu = VSFactory::getMenus();
		$cat = $vsMenu->getCategoryById ( $obj->getCatId () );
		$ids = $vsMenu->getChildrenIdInTree ( $cat );
		
		//$this->setFieldsString ( "id,title,postDate,catId" );
		$this->setOrder ( "`index` Desc, id Desc" );
		$this->condition = "id <> {$obj->getId()} and status >0";
		$size = VSFactory::getSettings()->getSystemKey($bw->input[0].'_paging_limit_other',12);
		$this->setLimit ( array (0, $size ) );
		if ($ids)
			$this->condition .= " and catId in ( {$ids})";
		
		return $this->getObjectsByCondition ();
	}


	
	/**
	*Enter description here ...
	*@var Product
	**/
	var		$obj;
}
