<?php

class products_public extends ObjectPublic{
	function __construct(){
            global $vsTemplate,$donvi,$vsMenu;
            parent::__construct('products', CORE_PATH.'products/', 'products');
            $this->html = $vsTemplate->load_template('skin_products');
	}
	
	function showCategory($catId){
		global $vsPrint,$bw,$vsSettings, $vsMenu,$vsTemplate;
               
		$query = explode('-',$catId);
		$idCate = abs(intval($query[count($query)-1]));
		$categories = $this->model->getCategories();
                
		if(!intval($idCate)){
			$strIds = $vsMenu->getChildrenIdInTree( $categories);
		}else{
			$result = $vsMenu->extractNodeInTree($idCate, $categories->getChildren());
			if($result)
			$strIds = $vsMenu->getChildrenIdInTree( $result['category']);
		}
             
		if($strIds) $this->model->setCondition('productCatId in ('. $strIds. ") and productStatus > 0 ");
		$this->model->setOrder("productIndex, productId DESC");
		
		
		$size = $vsSettings->getSystemKey("{$bw->input[0]}_user_item_quality", 7, $bw->input[0]);
		
                
		$option = $this->model->getPageList($bw->input['module']."/category/".$catId."/", 3, $size);
		$this->model->getNavigator($idCate);
		if($option['pageList'])
			$this->model->convertFileObject($option['pageList'],$bw->input['module']);
      	
		$option['category'] = $vsMenu->getCategoryById($idCate);
		
		$vsPrint->mainTitle = $vsPrint->pageTitle =  $result['category']->getTitle();
	
    	return $this->output = $this->html->showDefault($option);
	}

	function showDefault(){
		global $bw, $vsCom, $vsPrint;
              
		$categories = $this->model->getCategories();
		$temp = $categories->getChildren();
		$subcat = current($temp);
		
		$url = $subcat->getCatUrl('products');
		$exac_url = strtr($url, $vsCom->SEO->aliasurls);

		$vsPrint->boink_it($exac_url);
	}

	function showDetail($objId){
		global $vsPrint, $vsLang, $bw, $vsMenu, $vsPrint;
		
		$vsPrint->addCSSFile ( "jquery.lightbox-0.5" );
		$vsPrint->addCurentJavaScriptFile ( "jquery.lightbox-0.5" );
		$vsPrint->addJavaScriptString ( 'script_product', "
			$('.mainimage').lightBox();
		");
		
		$query = explode('-',$objId);
		$id = intval($query[count($query)-1]);
		
		$obj = $this->model->getObjectById($id);
		if(!$obj) return $vsPrint->redirect_screen($vsLang->getWords('global_no_item', 'Your requested was not found on this server'));
		
		$this->model->convertFileObject(array($obj),$bw->input['module']);
		$option['other'] =  $this->model->getOtherList($obj);
		$option['category'] = $vsMenu->getCategoryById($obj->getCatId());

		$obj->createSeo();
		
		$this->model->getNavigator($obj->getCatId());		
		$this->output = $this->html->showDetail($obj,$option);
	}
}
?>