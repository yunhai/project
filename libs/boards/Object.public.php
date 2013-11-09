<?php

class ObjectPublic{
	public $html;
	public $modelName;
	public $model;
	public $output;
	public $skinName;
	public $classNameModel;
	public $tableName;
	
	
	function __construct($modelName, $pathModel, $classModelName){
		global $vsStd, $vsTemplate, $tableName,$bw;
		
		$this->modelName = $modelName;
		$vsStd->requireFile($pathModel. $this->modelName.'.php');
		
		$this->classNameModel = $classModelName;
		$this->model = new $this->classNameModel;
		
		$this->tableName = $this->model->getTableName();
		
		$tableName = $this->tableName;
		$skin  = 'skin_objectpublic';
		if(file_exists(SKIN_PATH."finance/skin_".str_replace("-","", $bw->input['module']).".php"))
			$skin  = "skin_".str_replace("-","", $bw->input['module']);
                   
		$this->html = $vsTemplate->load_template($skin);
	}
	
	function auto_run() {
		global $bw,$class_def;
                
                
		switch ($bw->input['action']) {
			case 'detail':
					$this->showDetail($bw->input[2]);
				break;

			case 'category':
					$this->showCategory($bw->input[2]);
				break;
				
			case 'search':
					$this->showSearch();
				break;
				
			default:
					$this->showDefault();
				break;
		}
	}

	function showDefault(){
		global $vsPrint,$bw,$vsSettings, $vsMenu,$vsTemplate;
               
		$categories = $this->model->getCategories();
               
		$strIds = $vsMenu->getChildrenIdInTree($categories);
		
		if(!$strIds) return $this->output = $this->html->showDefault();
			
		$tablename = $this->tableName;
		$this->model->setCondition($this->model->getCategoryField().' in ('. $strIds. ") and {$tablename}Status > 0");
		$this->model->setOrder("{$tablename}Index, {$tablename}Id DESC");
		
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
		
		$option['category'] = $vsMenu->getCategoryById($obj->getCatId());

		$obj->createSeo();
		
		$option['other'] = $this->model->getOtherList($obj);
		if($option['other'])
			$this->model->convertFileObject($option['other'], $bw->input['module']);
		
		$this->model->getNavigator();
		$this->output = $this->html->showDetail($obj, $option);
	}
	
	function showCategory($catId){
		global $vsPrint,$bw,$vsSettings, $vsMenu,$vsTemplate;
               
		$query = explode('-', $catId);
		$idCate = abs(intval($query[count($query)-1]));
		$categories = $this->model->getCategories();
                
		$strIds = $idCate;
		if(!intval($idCate)){
			$strIds = $vsMenu->getChildrenIdInTree($categories);
		}else{
			$result = $vsMenu->extractNodeInTree($idCate, $categories->getChildren());
			if($result) $strIds = $vsMenu->getChildrenIdInTree($result['category']);
		}
		if($strIds)
			$this->model->setCondition($this->model->getCategoryField().' in ('. $strIds. ") and {$this->tableName}Status > 0");
		
		$this->model->setOrder("{$this->tableName}Index, {$this->tableName}Id DESC");
		
		$size = $vsSettings->getSystemKey("{$bw->input[0]}_user_item_quality", 7, $bw->input[0]);
		$url = $bw->input['module']."/category/".$catId."/";
		$option = $this->model->getPageList($url, 2, $size);
		$this->model->getNavigator($idCate);
		if($option['pageList'])
			$this->model->convertFileObject($option['pageList'],$bw->input['module']);
                
		$option['category'] = $result['category'];
		$vsPrint->mainTitle = $vsPrint->pageTitle =  $result['category']->getTitle();
		
    	return $this->output = $this->html->showDefault($option);
	}

	function showSearch(){
		global $vsSettings,$vsMenu,$bw,$vsLang,$DB,$vsPrint;

		$categories = $this->model->getCategories();
		if(intval($bw->input[2])){
			$result = $vsMenu->extractNodeInTree($bw->input[2], $categories->getChildren());
			if($result)
				$strIds = $vsMenu->getChildrenIdInTree( $result['category']);
		}else
			$strIds = $vsMenu->getChildrenIdInTree($categories);
			
		$keywords = strtolower(VSFTextCode::removeAccent(trim($bw->input[3])));
		$where .= " AND ({$this->tableName}ClearSearch like '%".$keywords."%')";
		$size  = $vsSettings->getSystemKey("{$bw->input[0]}_user_item_quality", 16, $bw->input[0]);
		$this->model->setCondition("{$this->tableName}Status > 0 and {$this->tableName}CatId in ({$strIds})".$where);
		$this->model->setOrder("{$this->tableName}Id DESC");
		
		$option = $this->model->getPageList($this->modelName."/search/{$bw->input[2]}{$keywords}", 4, $size);
		$this->model->getNavigator();
		
		if($option['pageList'])
			$this->model->convertFileObject($option['pageList'],$bw->input['module']);
			
		$bw->input['keyCate'] = $bw->input[2];
		$bw->input['keySearch'] = $bw->input[3];
                
        return $this->output = $this->html->showDefault($option);
	}
        
	function getHtml() {
		return $this->html;
	}

	function getModelName() {
		return $this->modelName;
	}

	function getModel() {
		return $this->model;
	}

	function getOutput() {
		return $this->output;
	}

	function getSkinName() {
		return $this->skinName;
	}

	function getClassNameModel() {
		return $this->classNameModel;
	}

	function getTableName() {
		return $this->tableName;
	}

	function setHtml($html) {
		$this->html = $html;
	}

	function setModelName($modelName) {
		$this->modelName = $modelName;
	}

	function setModel($model) {
		$this->model = $model;
	}

	function setOutput($output) {
		$this->output = $output;
	}

	function setGallery($gallery) {
		$this->gallery = $gallery;
	}

	function setSkinName($skinName) {
		$this->skinName = $skinName;
	}

	function setClassNameModel($classNameModel) {
		$this->classNameModel = $classNameModel;
	}

	function setTableName($tableName) {
		$this->tableName = $tableName;
	}
	
}