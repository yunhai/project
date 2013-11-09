<?php
class gallery_public extends ObjectPublic{
	function __construct(){
		global $vsTemplate;
		parent::__construct('pages', CORE_PATH.'pages/', 'pages');
		$this->html = $vsTemplate->load_template('skin_gallery');
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
		global $vsPrint, $vsLang, $bw, $vsMenu, $vsTemplate, $vsStd;              
		$query = explode('-',$objId);
		$id = intval($query[count($query)-1]);
		$obj = $this->model->getObjectById($id);
		
		if(!$obj) return $vsPrint->redirect_screen($vsLang->getWords('global_no_item', 'Trang này không tồn tại.'));
		
		$this->model->convertFileObject(array($obj), $bw->input['module']);
		$obj->createSeo();
		
		$this->model->setOrder($this->tableName.'Id DESC');
		$option['other'] = $this->model->getOtherList($obj);
		if($option['other'])
			$this->model->convertFileObject($option['other'],$bw->input['module']);
		
		$vsStd->requireFile(CORE_PATH.'gallerys/gallerys.php');
		$gallery = new gallerys();
		$option['gallery'] = $gallery->getAlbumByObj($id, 'gallery', 'image');	
			
		$vsPrint->addCSSFile("highslide/highslide");
		
		$this->model->getNavigator();
		$this->output = $this->html->showDetail($obj, $option);
	}
}