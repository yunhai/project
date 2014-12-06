<?php
require_once CORE_PATH.'pages/pages_controler_public.php';
class abouts_controler_public extends pages_controler_public {
	
	
	/*
	 * Show default action 
	 */
	function showDefault(){
		global $bw,$vsTemplate,$vsStd,$vsPrint;
		$category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
		$ids=VSFactory::getMenus()->getChildrenIdInTree($category);
		if(!$ids){
			$this->output =VSFactory::getLangs()->getWords('not_count_item');
		}
		$option['breakcrum']=$this->createBreakCrum(null);
		$this->model->setCondition("catId in ($ids) and status =1");
		$this->model->setOrder("`index` desc,id desc");
		$this->model->getOneObjectsByCondition();
		$this->showQuestion($option);
		$bw->input ['vs'] = "abouts/detail/".$this->model->basicObject->getSlugId().".html";
        return $this->output = $this->getHtml()->showDetail($this->model->basicObject,$option);
	}
	
	
	function showDetail($objId,$option=array()){
		global $vsPrint, $bw,$vsTemplate;
		$category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
		$obj=$this->model->getObjectById($this->getIdFromUrl($objId));
		if(!$obj->getId()||$obj->getStatus()<=0){
			return $this->output=VSFactory::getLangs()->getWords('not_count_item');
		}
		$obj->createSeo();
		$option['breakcrum']=$this->createBreakCrum($obj);
		$option['other']=$this->model->getOtherList($obj);
		$option['cate'] = $category->getChildren();
		$option['cate_obj']=VSFactory::getMenus()->getCategoryById($obj->getCatId());
		$obj->createSeo();
		$this->showQuestion($option);
	
		$this->output = $this->getHtml()->showDetail($obj,$option);
	}
	
	function showQuestion(&$option) {
		require_once CORE_PATH.'pages/pages.php';
		$pages=new pages();
	
		$category=VSFactory::getMenus()->getCategoryGroup('abouts');
		$ids=VSFactory::getMenus()->getChildrenIdInTree($category);
	
		$pages->setCondition("catId in ($ids)");
		$pages->setOrder("`index`");
		$pages->setFieldsString ( "id,title" );
		$option['obj_list']=$pages->getObjectsByCondition();
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @var skin_abouts
	 */
	public $html;
}

?>