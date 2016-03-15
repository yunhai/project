<?php
class gallerys_public extends ObjectPublic{
	function __construct(){
            global $vsTemplate;
            parent::__construct('gallerys', CORE_PATH.'gallerys/', 'gallerys');
             
	}

	function showCategory($catId){
		global $bw, $vsPrint, $vsSettings, $vsMenu, $vsTemplate;
               
		$query = explode('-', $catId);
		$idCate = abs(intval($query[count($query)-1]));
		$categories = $this->model->getCategories();
                
		if(!intval($idCate)){
			$strIds = $vsMenu->getChildrenIdInTree($categories);
		}else{
			$result = $vsMenu->extractNodeInTree($idCate, $categories->getChildren());
			if($result) $strIds = $vsMenu->getChildrenIdInTree($result['category']);
			
			$strIds = $idCate;
		}
		
		if($strIds)
			$this->model->setCondition($this->model->getCategoryField().' in ('. $strIds. ") and {$this->tableName}Status > 0");
		$this->model->setOrder("{$this->tableName}Index DESC");
		
		$temp = $this->model->getObjectsByCondition();
		
		$pagecat = $result['category']->getChildren();
		
		if($temp){
			reset($temp);
			$ftmp = current($temp);
			$url = $ftmp->getUrl($bw->input[0]);
			return $vsPrint->boink_it($url);
		}
		
		$option['category'] = $result['category'];
		$vsPrint->mainTitle = $vsPrint->pageTitle =  $result['category']->getTitle();
		$option['subcat'] = $categories->getChildren();
		if($option['subcat'][$idCate])
			$option['subcat'][$idCate]->active = 'active';

		return $this->output = $this->html->showDefault($option);
		

	}
	
}
?>