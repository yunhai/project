<?php
global $vsStd;

$vsStd->requireFile(CORE_PATH."searchs/Search.class.php");
class searchs extends VSFObject {
	public $obj;	
	function __construct(){
            global $vsMenu;
		parent::__construct();
		$this->categoryField 	= "searchCatId";
		$this->primaryField 	= 'searchRecord';
		$this->basicClassName 	= 'Search';
		$this->tableName 	= 'search';
                $this->obj              = $this->createBasicObject();
		$this->obj              =&$this->basicObject;
		$this->fields           = $this->obj->convertToDB();
		$this->categories       = array();
		$this->categories       = $vsMenu->getCategoryGroup(($this->tableName."s"));
	}
	
	function getPageList($url="", $objIndex=3, $size=10, $ajax = 0, $callack=""){
		global $vsStd,$bw,$DB;
		$vsStd->requireFile(LIBS_PATH."/Pagination.class.php");

		$total = $this->getNumberOfObject();
		if($size < $total){
			$pagination = new VSFPagination();
			$pagination->ajax				= $ajax;
			$pagination->callbackobjectId 	= $callack;
			$pagination->url 				= $ajax?ltrim($url,'/')."/":$bw->base_url.(trim($url,'/')."/");

			$pagination->p_Size 			= $size;
			$pagination->p_TotalRow 		= $total;
			$pagination->SetCurrentPage($objIndex);
			$pagination->BuildPageLinks();
			$this->setLimit(array($pagination->p_StartRow,$pagination->p_Size));
		}
		$option['paging'] = $pagination->p_Links;

		$option['pageList'] = $this->getObjectsByCondition("getRecord");
	
		$option['total'] = $total;
		return $option;
	}
	
}
?>