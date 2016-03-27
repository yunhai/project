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
	function __construct($modelName, $pathModel, $classModelName){
		global $vsStd, $vsTemplate, $tableName,$bw;

		// Initialize model
		$this->modelName = $modelName;
		$this->modelName = $modelName;
		$vsStd->requireFile($pathModel. $this->modelName.'.php');

		$this->classNameModel = $classModelName;
		$this->model = new $this->classNameModel;

		$this->tableName = $this->model->getTableName();

		$tableName = $this->tableName;


		// trở về dung modun
		$skin  = 'skin_objectpublic';
                if(file_exists(SKIN_PATH."finance/skin_".str_replace("-","", $bw->input['module']).".php"))
                        $skin  = "skin_".str_replace("-","", $bw->input['module']);


		//$this->html = $vsTemplate->load_template("skin_objectpublic");
		$this->html = $vsTemplate->load_template("$skin");

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

			case 'detail_video':
				$this->showDetail_video($bw->input[2]);
				break;



			case 'category':
				$this->showCategory($bw->input[2]);
				break;
			case 'search':
				$this->loadSearch();
				break;
			case 'form':
				return $this->output = $this->html->recruitmentForm();
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
		global $vsSettings,$vsMenu,$bw,$vsTemplate,$vsCom,$vsPrint;

		$categories = $this->model->getCategories();
		$strIds = $vsMenu->getChildrenIdInTree($categories);

		$this->model->setCondition("{$this->tableName}Status > 0 and {$this->tableName}CatId in ({$strIds})");
		$this->model->setOrder("{$this->tableName}Index ASC, {$this->tableName}Id DESC");
		$size = $vsSettings->getSystemKey("{$bw->input[0]}_user_item_quality",10,$bw->input[0]);
		$option = $this->model->getPageList($bw->input['module'], 1, $size);

		if($option['pageList']) {
			$this->model->convertFileObject($option['pageList'],$bw->input['module']);
		}

 		if(in_array($bw->input['module'],array('abouts','dichvu', 'ho-tro-khach-hang')) && $option['pageList']){
   		$curre = current($option['pageList']);
    	$exac_url = strtr($curre->getUrl($bw->input['module']), $vsCom->SEO->aliasurl);

    	$vsPrint->boink_it($exac_url);
   	}

   	$option['cate'] = $categories;

    $this->model->getNavigator();

  	return $this->output = $this->html->showDefault($option);
	}


	/*
	 * Show detail action
	 */
	function showDetail($objId){
		global $vsPrint, $vsLang, $bw,$vsMenu,$vsTemplate,$DB,$vsSettings;

		$query = explode('-',$objId);
		$objId = intval($query[count($query)-1]);
		if(!$objId) return $vsPrint->redirect_screen($vsLang->getWords('global_no_item','Không có dữ liệu theo yêu cầu!'));
		$obj=$this->model->getObjectById($objId);

		$this->model->convertFileObject(array($obj),$bw->input['module']);
		$cat=$this->model->vsMenu->getCategoryById($obj->getCatId());
		$this->model->getNavigator($obj->getCatId());

		$option['cate'] =  $vsMenu->getCategoryById($obj->getCatId());
		if($bw->input['module']=="products")
			$option['gallery'] = $this->model->getarrayGallery($obj->getId(),$bw->input['module']);

		$vsPrint->mainTitle = $vsPrint->pageTitle = $obj->getTitle();

		$option['other'] = $this->model->getOtherList($obj);
		$this->model->convertFileObject($option['other'],$bw->input['module']);


		$array = array('dichvu', 'ho-tro-khach-hang');
		if (in_array($bw->input['module'], $array)) {
			$categories = $this->model->getCategories();

     	$strIds = $vsMenu->getChildrenIdInTree($categories);
			$this->model->setCondition("{$this->tableName}Status > 0 and {$this->tableName}CatId in ({$strIds})");
			$this->model->setOrder("{$this->tableName}Index ASC, {$this->tableName}Id DESC");
			$size = $vsSettings->getSystemKey("{$bw->input[0]}_user_item_quality",10,$bw->input[0]);
			$option = $this->model->getPageList($bw->input['module'], 1, $size);
			if($option['pageList']) {
				$this->model->convertFileObject($option['pageList'],$bw->input['module']);
			}
		}

		$this->output = $this->html->showDetail($obj, $option);
	}







function showDetail_video($objId){


		global $vsPrint, $vsLang, $bw,$vsMenu,$vsTemplate,$DB;

		$query = explode('-',$objId);
		$objId = intval($query[count($query)-1]);
		if(!$objId) return $vsPrint->redirect_screen($vsLang->getWords('global_no_item','Không có dữ liệu theo yêu cầu!'));
		$obj=$this->model->getObjectById($objId);

		$this->model->convertFileObject(array($obj),$bw->input['module']);
		$cat=$this->model->vsMenu->getCategoryById($obj->getCatId());
		$this->model->getNavigator($obj->getCatId());
//		echo 123;exit();


		$option['cate'] =  $vsMenu->getCategoryById($obj->getCatId());
		//$vsPrint->mainTitle = $vsPrint->pageTitle = $obj->getTitle();

		 $this->html = $vsTemplate->load_template('skin_objectpublic');

		$this->output = $this->html->showDetail_video($obj,$option);

	}

/*
	 * Show category action
	 */
	function showCategory($catId){


		global $vsPrint,$bw,$vsSettings, $vsMenu,$vsTemplate,$vsCom;

		$query = explode('-',$catId);
		$idCate = abs(intval($query[count($query)-1]));
		$categories = $this->model->getCategories();

		if(!intval($idCate)){
			$strIds = $vsMenu->getChildrenIdInTree( $categories);
		}else{
			$result = $vsMenu->extractNodeInTree($idCate, $categories->getChildren());
			if($result)
			//$strIds = implode (",", $result['ids']);
			$strIds = $vsMenu->getChildrenIdInTree( $result['category']);
		}

		if($strIds)
			$this->model->setCondition($this->model->getCategoryField().' in ('. $strIds. ") and {$this->tableName}Status > 0 ");
		if($bw->input['module']!="quality")
       	//$this->model->setFieldsString("{$this->tableName}Title, {$this->tableName}Image, {$this->tableName}Id, {$this->tableName}Intro,{$this->tableName}CatId,{$this->tableName}PostDate");

		$this->model->setOrder("{$this->tableName}Index Asc,{$this->tableName}Id Desc");
		$size  = $vsSettings->getSystemKey("{$bw->input[0]}_user_item_quality",12,$bw->input[0]);

    	$option = $this->model->getPageList($bw->input['module']."/category/".$catId."/", 3, $size);


    	if($option['pageList']){
        	$this->model->convertFileObject($option['pageList'],$bw->input['module']);
      	}



      	//$option['cate'] = $categories->getChildren();
      	$this->model->getNavigator($idCate);
		$option['cate'] =  $vsMenu->getCategoryById($idCate);

		$vsPrint->mainTitle = $vsPrint->pageTitle = $option['cate']->getTitle();

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
