<?php
class pcontacts_public extends ObjectPublic {
	
	function __construct() {
		global $vsTemplate;
		parent::__construct ( 'pcontacts', CORE_PATH . 'pcontacts/', 'pcontacts' );
		$this->html = $vsTemplate->load_template ( 'skin_pcontacts' );
	}
	
	function showDefault($opt = array()) {
		global $bw, $vsStd, $vsSettings, $vsLang, $vsMenu;
		
		$categories = $vsMenu->getCategoryGroup ( "pcontacts" );
		$strIds = $vsMenu->getChildrenIdInTree ( $categories );
		$this->model->setCondition ( "pcontactCatId in ({$strIds}) and pcontactStatus > 0" );
		$option = $this->model->getObjectsByCondition ();
		if ($option)
			$this->model->convertFileObject ( $option, "pcontacts" );
		
		$this->model->getNavigator ();
		//if(!$option['page'])$option['page'] = new pcontacts();
		$this->output = $this->html->showDefault ( $option );
	}
	
	function showDetail($objId) {
		global $vsPrint, $vsLang, $bw, $vsMenu, $vsTemplate, $vsStd, $vsSettings, $DB;
		$query = explode ( '-', $objId );
		$objId = intval ( $query [count ( $query ) - 1] );
		if (! $objId)
			return $vsPrint->redirect_screen ( $vsLang->getWords ( 'global_no_item', 'Không có dữ liệu theo yêu cầu' ) );
		$obj = $this->model->getObjectById ( $objId );
		$this->model->convertFileObject ( array ($obj ), $bw->input ['module'] );
		$cat = $this->model->vsMenu->getCategoryById ( $obj->getCatId () );
		$this->model->getNavigator ( $obj->getCatId () );
		
		$option ['gallery'] = $this->model->getarrayGallery ( $obj->getId (), $bw->input ['module'] );
		
		$option ['cate'] = $vsMenu->getCategoryById ( $obj->getCatId () );
		
		$vsPrint->mainTitle = $vsPrint->pageTitle = $obj->getTitle ();
		
		$this->output = $this->html->showDetail ( $obj, $option );
	}
}
?>