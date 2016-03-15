<?php
require_once(CORE_PATH."products/Option.class.php");
class options extends VSFObject {
	public $obj;
	
	function __construct(){
		parent::__construct();
		$this->primaryField 	= 'optId';
		$this->basicClassName 	= 'Option';
		$this->tableName 		= 'product_option';
		
		$this->obj = $this->createBasicObject();
		$this->fields = $this->obj->convertToDB();
	}
	
	function __destruct(){	
		unset($this);
	}	
	
	function delete($ids = 0) {
		global $vsStd;
		$this->createMessageSuccess($this->vsLang->getWords('product_delete_by_id_success', "Deleted product successfully!"));
		// Get objects information
		$this->fieldsString = "productImage";
		$this->condition = "productId IN (".$ids .")";
		$list = $this->getObjectsByCondition();
		if(!count($list)) return false;
		// Delete product data
		$this->condition = "productId IN (".$ids .")";
		if(!$this->deleteObjectByCondition()) return false;
		foreach ($list as $product){
			$this->vsFile->deleteFile($product->getImage());
		}	
		unset($product);
		unset($list);
		return true;
	}
	

	function getListByProductId($productId=0){
		$this->setCondition("productId IN (". $productId.")");
		return $this->getObjectsByCondition();
	}
}
?>