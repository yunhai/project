<?php
class branch_public extends ObjectPublic{
	function __construct(){
		global $vsTemplate;
		parent::__construct('pcontacts', CORE_PATH.'pcontacts/', 'pcontacts');
	}
	
	function showDetail($objId){
		global $vsPrint, $vsLang, $bw, $vsMenu, $vsTemplate;              
		$query = explode('-',$objId);
		$id = intval($query[count($query)-1]);
		$obj = $this->model->getObjectById($id);
		
		if(!$obj) return $vsPrint->redirect_screen($vsLang->getWords('global_no_item', 'Trang này không tồn tại.'));
		
		$this->model->convertFileObject(array($obj), $bw->input['module']);
		
		$option['category'] = $vsMenu->getCategoryById($obj->getCatId());

		$obj->createSeo();
		
		$option['other'] = $this->model->getOtherListFull($obj);
		if($option['other'])
			$this->model->convertFileObject($option['other'],$bw->input['module']);
		
		$this->model->getNavigator();
		$this->output = $this->html->showDetail($obj, $option);
	}
}