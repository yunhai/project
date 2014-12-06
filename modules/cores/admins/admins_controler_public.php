<?php
require_once CORE_PATH.'admins/admins.php';
class admins_controler_public extends VSControl_public {
	function __construct($modelName){
		global $vsTemplate,$bw;
//		$this->html=$vsTemplate->load_template("skin_admin");
		parent::__construct($modelName,"skin_admins","admin",$bw->input[0]);
		//$this->model->categoryName=$bw->input[0];
	}
function auto_run() {
	global $bw;
		
		switch ($bw->input['action']) {
//			case $this->modelName.'_download':
//				$this->download($bw->input[2]);
//				break;
			default:
				parent::auto_run();
				break;
		}
		
	}
/*
	 * Show default action 
	 */
	function showDefault(){
		global $bw,$vsTemplate,$vsPrint;
		$category=VSFactory::getMenus()->getCategoryGroup("admins");
		if(!$category){
			$vsPrint->boink_it($bw->base_url);
		}
		$ids=VSFactory::getMenus()->getChildrenIdInTree($category);
		$this->model->setCondition("status>0 and isLink!=1 and catId in ($ids)");
		$this->model->setOrder("`index`");
		$option=$this->model->getPageList("admins",1,VSFactory::getSettings()->getSystemKey('admin_page_limit',9));
		//$option['hot']=$this->model->getHotPost(VSFactory::getSettings()->getSystemKey('hot_post_limit',4));
		$option['breakcrum']=$this->createBreakCrum(null);
        return $this->output = $this->getHtml()->showDefault($option);
	}
	/**
	 * 
	 * @var admins
	 */
	protected $model;
/*
	 * Show detail action 
	 */
	function showDetail($objId){
		global $vsPrint, $bw,$vsTemplate;       
		$obj=$this->model->getObjectById($this->getIdFromUrl($objId));
		if(!is_object($obj)){
			$vsPrint->boink_it($bw->base_url);
		}       
		$option['other']=$this->model->getOtheradmins($obj);
		$option['breakcrum']=$this->createBreakCrum($obj);
    	$this->output = $this->getHtml()->showDetail($obj,$option);
	}
	
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
	 * @var skin_admins
	 */
	public $html;
}

?>