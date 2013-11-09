<?php
class news_public extends ObjectPublic{
	function __construct(){
		global $vsTemplate;
		parent::__construct( 'news', CORE_PATH.'news/', 'newses');
	}
	
	function showDefault(){
		global $vsPrint,$bw,$vsSettings, $vsMenu,$vsTemplate;
               
		$categories = $this->model->getCategories();
               
		$strIds = $vsMenu->getChildrenIdInTree($categories);
		
		if(!$strIds) return $this->output = $this->html->showDefault();
			
		$tablename = $this->tableName;
		$this->model->setCondition($this->model->getCategoryField().' in ('. $strIds. ") and {$tablename}Status > 0");
		$this->model->setOrder("{$tablename}Index DESC, {$tablename}Id DESC");
		
		$size = $vsSettings->getSystemKey("{$bw->input[0]}_user_item_quality", 8, $bw->input[0]);
		$url = $bw->input['module']."/";
		$option = $this->model->getPageList($url, 1, $size);
		if($option['pageList'])
			$this->model->convertFileObject($option['pageList'], $bw->input['module']);
		return $this->output = $this->html->showDefault($option);
	}
	
	function showDetail($objId){
		global $vsPrint, $vsLang, $bw, $vsMenu, $vsTemplate;              
		$query = explode('-',$objId);
		$id = intval($query[count($query)-1]);
		$obj = $this->model->getObjectById($id);
		
		if(!$obj) return $vsPrint->redirect_screen($vsLang->getWords('global_no_item', 'Trang này không tồn tại.'));
		$this->model->convertFileObject(array($obj), $bw->input['module']);
		
		$this->model->setOrder($this->tableName.'Id DESC');
		$option['other'] = $this->model->getOtherList($obj);
		if($option['other'])
			$this->model->convertFileObject($option['other'], $bw->input['module']);
			
		$categories = $this->model->getCategories();
		foreach($categories->getChildren() as $key => $cat){
			if($key == $obj->getCatId()) $cat->active = 'active';
			$option['categorylist'][$key] = $cat;	
		}
		$obj->createSeo();
		$this->model->getNavigator($obj->getCatId());
		
		$this->output = $this->html->showDetail($obj, $option);
	}

}