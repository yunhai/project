<?php
class home_public extends ObjectPublic{
 
	function __construct(){
		global $vsTemplate;
		
		parent::__construct('products', CORE_PATH.'products/', 'products');
		$this->html = $vsTemplate->load_template('skin_home');
	}
        
  	function showDefault(){
		global $vsStd;

		$vsStd->requireFile(CORE_PATH.'products/products.php');
		$model = new products();
		$temp = $model->getCategories();
		$option['category'] = $temp->children;
		
		
		$condition  = 'productStatus > 0 ';
		$order	    = "productCatId, productIndex, productId";
		$group		= 'productCatId';
		
		$model->setCondition($condition);
		$model->setOrder($order);
		
		$option['item'] = $model->getObjectsByCondition('getCatId', 1);
		
		$vsStd->requireFile ( CORE_PATH . 'pages/pages.php' );
		$page = new pages();
		$option['about'] = $page->getPageByCodeLanguage ( 'about', 'about' );
		
// 		$vsStd->requireFile(CORE_PATH.'pcontacts/pcontacts.php');
// 		$page = new pcontacts();
// 		$option['branch'] = $page->getLastestByModule('branch', 9);
		
// 		$vsStd->requireFile(CORE_PATH.'news/news.php');
// 		$news = new newses();
// 		$option['news'] = $news->getLastestList(6);
		
		$this->output = $this->html->showDefault($option);
	}
}