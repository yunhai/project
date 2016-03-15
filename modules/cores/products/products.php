<?php
//require_once(CORE_PATH."products/options.php");
require_once(CORE_PATH."products/Product.class.php");
class products extends VSFObject {
        public $obj;
        public $service 			=null;
	function __construct(){
            global $vsMenu,$bw;
            $this->requireFileUseFull();
		parent::__construct();
		$this->categoryField 	= "productCatId";
		$this->primaryField 	= 'productId';
		$this->basicClassName 	= 'Product';
		$this->tableName 		= 'product';
		$this->obj              = $this->createBasicObject();
		$this->obj              =&$this->basicObject;
		$this->fields           = $this->obj->convertToDB();
		$this->categories       = array();
		$this->categories       = $vsMenu->getCategoryGroup(strtolower($bw->input['module']));

	}

	
	function requireFileUseFull() {
		global $vsStd;
		$vsStd->requireFile(UTILS_PATH."TextCode.class.php");
	}

	public function setCategoryField($categoryField) {
		$this->categoryField = $categoryField;
	}

	
	/**
	 * @return the $categories
	 */
	public function getCategories() {
		return $this->categories;
	}

	/**
	 * @return the $categoryField
	 */
	
	public function getListWithCat($treeCat) {
            global $vsMenu;
            if(!is_object($treeCat))
		return false;
		$ids=$vsMenu->getChildrenIdInTree($treeCat);
		if($ids)
		$this->condition = "productCatId in ( {$ids})";
		$this->setOrder("productIndex Desc, productId Desc");
		$this->limit=array(0,30);
		return $this->getObjectsByCondition();
	}


	public function getOtherList($obj) {
		global  $vsSettings,$vsMenu;

		$cat=$vsMenu->getCategoryById($obj->getCatId());
		$ids=$vsMenu->getChildrenIdInTree($cat);
		
		//$this->setFieldsString('productId,productTitle,productImage,productPostDate');
		$this->setOrder("productIndex Desc, productId Desc");
                $this->condition = "productId <> {$obj->getId()} and productStatus >0";
               // $this->setTableName ("product left join vsf_file on productImage = fileId");
                $size =  $vsSettings->getSystemKey("product_user_list_number_other",9);
		//$this->setLimit(array(0,$size));
		if($ids)
		$this->condition .= " and productCatId in ( {$ids})";
		

		return $this->getObjectsByCondition();
	}
	
	
	public function getOtherListHome($obj) {
		global  $vsSettings,$vsMenu;
		$cat=$vsMenu->getCategoryById($obj->getCatId());
		$ids=$vsMenu->getChildrenIdInTree($cat);
		
		$this->setFieldsString('productId,productTitle,productImage,vsf_file.*');
		$this->setOrder("productIndex Desc, productId Desc");
        $this->condition = "productId <> {$obj->getId()} and productStatus >0";
        $this->setTableName ("product left join vsf_file on productImage = fileId");
        $size =  $vsSettings->getSystemKey("product_user_list_number_other_home",2);
		$this->setLimit(array(0,$size));
		if($ids)
		$this->condition .= " and productCatId in ( {$ids})";
		
		return $this->getObjectsByCondition();
	}

	
	public function getHomeList($ids,$limit) {
            global $vsMenu;
   		if(!$ids)
     	$ids=$vsMenu->getChildrenIdInTree($this->getCategories());

        $this->setFieldsString('productId,productTitle,productIntro,productImage');
		$this->setOrder('productId Desc,productIndex Desc');
        $this->setCondition("productCatId in ({$ids}) and productStatus = 2");
        if($limit)
      	$this->setLimit(array(0, $limit));
       	return $this->getObjectsByCondition();       
	}
	
	function getLastest($limit=1){
		$this->condition .= " productStatus > 0 ";
		$this->setOrder("productId Desc");
		$this->setLimit(array(0, $limit));
		return $this->getObjectsByCondition();
	}
	
	function __destruct(){
		unset($this);
	}

	function deleteObjInCategory($catIds = 0){
		global $vsStd;
		
		$query = "SELECT productId, productImage from vsf_product where productCatId in(".$catIds.")";
		$list = $this->executeQuery($query, 0);

		if(!count($list)) return false;
		
		$this->condition = "productCatId IN (".$catIds.")";
		if(!$this->deleteObjectByCondition()) return false;
		
		foreach ($list as $product)
			$this->vsFile->deleteFile($product['productImage']);

		return true;
	}

        function createRSS($id=""){
            global $vsMenu,$vsStd,$vsLang;
            $vsStd->requireFile(UTILS_PATH."/class_rss.php");
            $rss = new VSSRss();

            $categories = $this->getCategories();
            if($id){
                $result = $vsMenu->extractNodeInTree($id, $categories->getChildren());
                if($result){
                    $strIds = trim($idCate.",".$vsMenu->getChildrenIdInTree($result['category']),",");
                    $rss->cate =$result['category'];
                }
            }
            if(!$strIds){
                $strIds = $vsMenu->getChildrenIdInTree($categories);
                $rss->cate =$categories;
            }
               $this->setFieldsString("productTitle,productImage,productId,productIntro,productPostDate,productCatId,vsf_file.*");
               $this->setTableName ("product left join vsf_file on productImage = fileId");
        
            $this->setOrder("productIndex ASC,productId DESC");
            $this->setCondition("productStatus > 0 and productCatId in ({$strIds})");
            $this->setLimit(array(0,10));
            $arr = $this->getObjectsByCondition();
           
            $rss->arrayObj = $arr;
            $rss->buildRss();
           	print "<script>alert('".$vsLang->getWordsGlobal("alert_RSS","Bạn đã tạo RSS thành công")."')</script>";

        }

	function buildCacheProduct() {
		// Only build cache for user menus
		$this->obj->setStatus(1);
		
		$list =$this->getArrayByCondition("product");

		$cache_content  = "<?php\n";
		$cache_content .= "\$arrayTreeMenu = ".var_export($arrayTreeMenu,true).";\n";
		
		$cache_content .= "?>";
		$cache_path = CACHE_PATH."menus.cache";
		$cache_content = preg_replace('/\s\s+/', '', $cache_content);
		$file = fopen($cache_path, "w");
		fwrite($file, $cache_content);
		fclose($file);
	}
}
?>