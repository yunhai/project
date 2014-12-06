<?php
require_once CORE_PATH.'pages/pages_controler_public.php';
class search_controler_public extends pages_controler_public {
	
	
	/*
	 * Show default action 
	 */
	function showDefault(){
		global $bw,$vsTemplate,$vsStd,$vsPrint;
		
		if ($bw->input ['keyword']) {
			$category = VSFactory::getMenus ()->getCategoryGroup ('brands' );
			$about = VSFactory::getMenus ()->getCategoryGroup ('abouts' );
			
			
			$keyword = strtolower(VSFactory::getTextCode()->removeAccent($bw->input ['keyword']," "));
			$keyword = ereg_replace ( '[[:<:]](and|or|the)[[:>:]]', '', $keyword );
			$keyword = ereg_replace ( ' ', '|', trim ( stripslashes ( $keyword ) ) );
				
			$condition = "status >0 and cleanTitle REGEXP '$keyword' and catId not in({$about->getId()},{$category->getId()})";
			$url.="keyword={$bw->input ['keyword']}&page=";
			$this->model->setCondition($condition);
			
			$bw->input[1] = $bw->input['page'];
			
			$option = $this->getPageList("search?".$url,1,10);
		}
		
		
		$vsPrint->mainTitle=$vsPrint->pageTitle='Kết quả tìm kiếm';
        
        return $this->output = $this->getHtml()->showDefault($option);
	}
	
	function getPageList($url="", $objIndex=3, $size=10, $ajax = 0, $callack=""){
		global $vsStd,$bw;
		$vsStd->requireFile(LIBS_PATH."/Pagination.class.php");
		$total = $this->model->getNumberOfObject();
		if($size < $total){
			$pagination = new VSFPagination();
			$pagination->ajax				= $ajax;
			$pagination->callbackobjectId 	= $callack;
			$pagination->url 				= $url;
	
			$pagination->p_Size 			= $size;
			$pagination->p_TotalRow 		= $total;
			$pagination->SetCurrentPage($objIndex);
			$pagination->BuildPageLinks();
				
			$this->model->setLimit(array($pagination->p_StartRow,$pagination->p_Size));
		}
		$option['paging'] = $pagination->p_Links;
		$option['totalPage'] = $pagination->p_TotalPage;
		$option['pageList'] = $this->model->getObjectsByCondition();
		$option['total'] = $total;
		return $option;
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
	
	
	/**
	 * 
	 * Enter description here ...
	 * @var skin_abouts
	 */
	public $html;
}

?>