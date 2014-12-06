<?php
require_once(CORE_PATH.'partners/partners.php');

class partners_controler_public extends VSControl_public {

	public	function auto_run(){
	
	global $bw;
				switch ($bw->input['action']) {
//			case $this->modelName.'_some_action':
//				$this->someMethod($bw->input[2]);
//				break;
			default:
				parent::auto_run();
				break;
		}

	}



function showDefault($option = array()) {
		global $bw, $vsTemplate, $vsStd, $vsPrint;
		echo 123; exit();
		if (in_array ( $bw->input ['module'], array ('abouts', 'maps', 'helps' ) ))
			return $this->showDefault1 ();
		$category = VSFactory::getMenus ()->getCategoryGroup ( $bw->input [0] );
		if (! $category) {
			$vsPrint->boink_it ( $bw->base_url );
		}
		$ids = VSFactory::getMenus ()->getChildrenIdInTree ( $category);
		$this->model->setCondition("status>0 and catId in ($ids)");
		$this->model->setOrder("`index`,id desc");
		$tmp=$this->model->getPageList($bw->input[0],1,VSFactory::getSettings()->getSystemKey($bw->input[0].'_paging_limit',12));
		$option=array_merge($tmp,$option);
		$option['breakcrum']=$this->createBreakCrum(null);
		$option['title']=VSFactory::getLangs()->getWords($bw->input[0]);
		$vsPrint->mainTitle=$vsPrint->pageTitle=$option['title'];
                $option['cate'] = $category->getChildren();
        return $this->output = $this->getHtml()->showDefault($option);
	}

	public	function __construct($modelName){
	
		global $vsTemplate,$bw;
//		$this->html=$vsTemplate->load_template("skin_partner");
		parent::__construct($modelName,"skin_partners","partner",$bw->input[0]);
//		$this->model->categoryName=$bw->input[0];

	}





	function getHtml(){
		return $this->html;
	}



	function setHtml($html){
		$this->html=$html;
	}



	
	/**
	*
	*@var partners
	**/
	var		$model;

	
	/**
	*
	*@var skin_partners
	**/
	var		$html;
}
