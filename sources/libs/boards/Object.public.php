<?php
/*
 * @author Luu Quang Vu
 * This class is used to describle the genaral for objects public of VSF
 */
class ObjectPublic{
	public $html;
	public $modelName;
	public $model;
	public $output;
	public $gallery;
	public $skinName;
	public $classNameModel;
	public $tableName;
	
	/*
	 * @description  initialize contructor
	 * @param $skinName string <p>
	 * The name of skin that you want to show 
	 * </p>
	 * @param $modelName string <p>
	 * The nam of model that you want to process
	 * </p>
	 * @param $pathModel string <p>
	 * Path to file model(It can: CORE_PATH.'/news' or other)
	 * </p>
	 * @return void
	 */
	function __construct($skinName, $modelName, $pathModel, $classModelName){
		global $vsStd, $vsTemplate, $tableName;
		
		// Initialize model
		$this->modelName = $modelName;
		$this->modelName = $modelName;
		$vsStd->requireFile($pathModel. $this->modelName.'.php');
		
		$this->classNameModel = $classModelName;
		$this->model = new $this->classNameModel;
		
		$this->tableName = $this->model->getTableName();
		$tableName = $this->tableName;
		// Initialize gallery
		// Initialize skin
		$this->skinName = $skinName;
		$this->html = $vsTemplate->load_template($this->skinName);
   		
	}
	
	/*
	 * @description function auto_run, it's a router for actions in model 
	 */
	function auto_run() {
		global $bw;

		switch ($bw->input['action']) {
			case 'detail':
				$this->showDetail($bw->input[2]);
				break;

			case 'category':
				$this->showCategory($bw->input[2]);
				break;
		
			default:
				$this->showDefault();
				break;
		}
	}
	
	/*
	 * Show default action 
	 */
	function showDefault(){
		global $bw,$vsTemplate;
		
        $vsMenu = VSFactory::getMenus();        
		$categories = $this->model->getCategories();
     	$strIds = $vsMenu->getChildrenIdInTree($categories);
		$size  = VSFactory::getSettings()->getSystemKey("{$bw->input[0]}_user_item_quality",6,$bw->input[0]);
		
		$this->model->setFieldsString("{$this->tableName}Title, {$this->tableName}Image, {$this->tableName}Id, {$this->tableName}Intro, {$this->tableName}CatId, {$this->tableName}PostDate");
		$this->model->setCondition("{$this->tableName}Status > 0 and {$this->tableName}CatId in ({$strIds})");
		$this->model->setOrder("{$this->tableName}Index ASC, {$this->tableName}Id DESC");
		$option = $this->model->getPageList($bw->input['module'], 1, $size);
        $this->model->getNavigator();
      	if($option['pageList'])
        	$this->model->convertFileObject($option['pageList'],$bw->input['module']);

		$option['cate'] = $categories->getChildren();
        $vsTemplate->global_template->menu_left = $this->html->portlet_menu_left($vsMenu->getCategoryGroup($bw->input['module'])->getChildren());       
        return $this->output = $this->html->showDefault($option);
	}
	
	/*
	 * Show detail action 
	 */
	function showDetail($objId){
		global $vsPrint, $bw,$vsTemplate;              
		$query = explode('-',$objId);
		$objId = intval($query[count($query)-1]);
		if(!$objId) return $vsPrint->redirect_screen(VSFactory::getLangs()->getWords('global_no_item','KhÃ´ng cÃ³ dá»¯ liá»‡u theo yÃªu cáº§u'));
		$obj=$this->model->getObjectById($objId);
		$this->model->convertFileObject(array($obj),$bw->input['module']);
		
		$vsMenu = VSFactory::getMenus();
		$cat=$vsMenu->getCategoryById($obj->getCatId());
		
		$this->model->getNavigator($obj->getCatId());
		if ($bw->input['module'] == 'promotions'){
			$other = $this->model->getOtherList($obj);
			$this->model->convertFileObject($other,$bw->input['module']);
			$vsTemplate->global_template->page_other = $this->html->promotion_other($other);
		}
		else 
			$vsTemplate->global_template->page_other = $this->html->page_other($this->model->getOtherList($obj)); 
		if ($bw->input['module']!='abouts')
		$vsPrint->mainTitle = $vsPrint->pageTitle = $obj->getTitle();
    	$this->output = $this->html->showDetail($obj);
	}
	
/*
	 * Show category action 
	 */
	function showCategory($catId){
		global $vsPrint,$bw,$vsTemplate;
		$vsMenu = VSFactory::getMenus();
		
		$query = explode('-',$catId);
		$idCate = abs(intval($query[count($query)-1]));
		$categories = $this->model->getCategories();
		if(!intval($idCate)){
			$strIds = $vsMenu->getChildrenIdInTree( $categories);
		}else{
			$result = $vsMenu->extractNodeInTree($idCate, $categories->getChildren());
			if($result)
			$strIds = trim($idCate.",".$vsMenu->getChildrenIdInTree($result['category']),",");
		}
		if($strIds)
			$this->model->setCondition($this->model->getCategoryField().' in ('. $strIds. ") and {$this->tableName}Status > 0 ");
		
		$this->model->setFieldsString("{$this->tableName}Title,{$this->tableName}Image,{$this->tableName}Id,{$this->tableName}Intro,{$this->tableName}PostDate,{$this->tableName}CatId");
		$this->model->setOrder("{$this->tableName}Status Desc,{$this->tableName}Index Asc,{$this->tableName}Id Desc");
		
		$size  = VSFactory::getSettings()->getSystemKey("{$bw->input[0]}_user_item_quality",6,$bw->input[0]);
       	$option=$this->model->getPageList("{$bw->input['module']}/category/".$catId."/", 3, $size);
       	if($option['pageList'])
        	$this->model->convertFileObject($option['pageList'],$bw->input['module']);
               
      	$this->model->getNavigator($idCate);

   		$option['cate']= $result['category'];
		$vsPrint->mainTitle = $vsPrint->pageTitle =   $option['cate']->getTitle();
		$vsTemplate->global_template->menu_left = $this->html->portlet_menu_left($vsMenu->getCategoryGroup($bw->input['module'])->getChildren());
		return $this->output = $this->html->showDefault($option);
	}
	/**
	 * @return the $html
	 */
	public function getHtml() {
		return $this->html;
	}

	/**
	 * @return the $modelName
	 */
	public function getModelName() {
		return $this->modelName;
	}

	/**
	 * @return the $model
	 */
	public function getModel() {
		return $this->model;
	}

	/**
	 * @return the $output
	 */
	public function getOutput() {
		return $this->output;
	}

	/**
	 * @return the $gallery
	 */
	public function getGallery() {
		return $this->gallery;
	}

	/**
	 * @return the $skinName
	 */
	public function getSkinName() {
		return $this->skinName;
	}

	/**
	 * @return the $classNameModel
	 */
	public function getClassNameModel() {
		return $this->classNameModel;
	}

	/**
	 * @return the $tableName
	 */
	public function getTableName() {
		return $this->tableName;
	}

	/**
	 * @param field_type $html
	 */
	public function setHtml($html) {
		$this->html = $html;
	}

	/**
	 * @param field_type $modelName
	 */
	public function setModelName($modelName) {
		$this->modelName = $modelName;
	}

	/**
	 * @param field_type $model
	 */
	public function setModel($model) {
		$this->model = $model;
	}

	/**
	 * @param field_type $output
	 */
	public function setOutput($output) {
		$this->output = $output;
	}

	/**
	 * @param field_type $gallery
	 */
	public function setGallery($gallery) {
		$this->gallery = $gallery;
	}

	/**
	 * @param field_type $skinName
	 */
	public function setSkinName($skinName) {
		$this->skinName = $skinName;
	}

	/**
	 * @param field_type $classNameModel
	 */
	public function setClassNameModel($classNameModel) {
		$this->classNameModel = $classNameModel;
	}

	/**
	 * @param field_type $tableName
	 */
	public function setTableName($tableName) {
		$this->tableName = $tableName;
	}

	
	
}