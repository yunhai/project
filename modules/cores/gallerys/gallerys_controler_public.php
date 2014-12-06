<?php
require_once CORE_PATH.'gallerys/gallerys.php';
class gallerys_controler_public extends VSControl_public {
	function __construct($modelName){
		global $vsTemplate,$bw,$vsPrint,$vsSkin;
		if(file_exists(ROOT_PATH.$vsSkin->basicObject->getFolder()."/skin_".$bw->input[0].".php")
		||file_exists(CACHE_PATH.$vsSkin->basicObject->getFolder()."/skin_".$bw->input[0].".php")){
		parent::__construct($modelName,"skin_".$bw->input[0],"page",$bw->input[0]);;
		}else{
		parent::__construct($modelName,"skin_pages","page",$bw->input[0]);
		}
		//$this->model->categoryName=$bw->input[0];
		//$vsPrint->addExternalJavaScriptFile("http://maps.google.com/maps/api/js?sensor=true&language=vi",1);
	}
	
	/*
	 * Show default action 
	 */
//	function showDefault(){
//		global $bw,$vsTemplate,$vsStd,$vsPrint;
//		$option['breakcrum']=$this->createBreakCrum(null);
//        return $this->output = $this->getHtml()->showDefault($option);
//	}
	
	function showDefault(){
		global $bw,$vsTemplate,$vsStd,$vsPrint;
		$category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
		$ids=VSFactory::getMenus()->getChildrenIdInTree($category);
		if(!$ids){
			$this->output =VSFactory::getLangs()->getWords('not_count_item');
		}
		$option['breakcrum']=$this->createBreakCrum(null);
//		$this->model->setCondition("catId in ($ids) and status >0");
//		$this->model->setOrder("`index`");
//		$this->model->getOneObjectsByCondition();
//		$obj = $this->model->basicObject;
		$this->model=new gallerys();
		$this->model->setCondition("status>0");
		$option=$this->model->getPageList("gallerys",2,VSFactory::getSettings()->getSystemKey('limit_album_home',10));
		
//		$option['gallery'] =$this->model->getAlbumByCode($bw->input['module']."_".$obj->getId());
		$vsPrint->pageTitle = $vsPrint->mainTitle=VSFactory::getLangs()->getWords($bw->input[0]);
		
        return $this->output = $this->getHtml()->showDefault($option);
	}
	
	function showDetail($objId,$option=array()){
		global $vsPrint, $bw,$vsTemplate;  
		           
		$obj=$this->model->getObjectById($this->getIdFromUrl($objId));
		if(!$obj->getId()){
			return $this->output=VSFactory::getLangs()->getWords('not_count_item');
		}
		 
		$obj->createSeo();
	
		$option['breakcrum']=$this->createBreakCrum(null);
		
		$option['gallery'] =$this->model->getAlbumPaging($bw->input['module']."_".$obj->getId(),"gallerys/detail/".$obj->getSlugId(),3,16);
//		echo "<pre>";
//		print_r($option['gallery']);
//		echo "<pre>";
//		exit;
    	$this->output = $this->getHtml()->showDetail($obj,$option);
	}
	/**
	 * 
	 * @var pages
	 */
	protected $model;
	
	
    function getListLangObject(){
         	
    }
       /**
        * 
        * @param BasicObject
        */ 
    protected  function  onDeleteObject($obj){
    }
	public function getHtml() {
		return $this->html;
	}
	
	public function getOutput() {
		return $this->output;
	}
	
	public function setHtml($html) {
		$this->html = $html;
	}
	
	public function setOutput($output) {
		$this->output = $output;
	}
	/**
	 * 
	 * Enter description here ...
	 * @var skin_pages
	 */
	public $html;
}

?>