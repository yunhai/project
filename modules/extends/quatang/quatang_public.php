 <?php
class quatang_public extends ObjectPublic{
	function __construct(){
		global $vsTemplate;
		parent::__construct('products', CORE_PATH.'products/', 'products');
		$this->html = $vsTemplate->load_template('skin_quatang');
	}

	
	
function showDefault(){
		
		global $vsSettings,$vsMenu,$bw,$vsTemplate,$vsCom,$vsPrint;
              ;
//echo 123; exit();
		$categories = $this->model->getCategories();
       	$strIds = $vsMenu->getChildrenIdInTree($categories);
       	
     
		
       	//$this->model->setFieldsString("{$this->tableName}Title, {$this->tableName}Image, {$this->tableName}Id, {$this->tableName}Intro,{$this->tableName}CatId,{$this->tableName}PostDate");
       	
		$this->model->setCondition("{$this->tableName}Status > 0 and {$this->tableName}CatId in ({$strIds})");
		$this->model->setOrder("{$this->tableName}Index ASC, {$this->tableName}Id DESC");
		$size  = $vsSettings->getSystemKey("{$bw->input[0]}_user_item_quality",10,$bw->input[0]);
		$option = $this->model->getPageList($bw->input['module'], 1, $size);
		if($option['pageList'])
        	$this->model->convertFileObject($option['pageList'],$bw->input['module']);
    	
   		if(in_array($bw->input['module'],array('abouts'))&&$option['pageList']){
   			
     		$curre =  current($option['pageList']);
          	$exac_url=strtr($curre->getUrl($bw->input['module']), $vsCom->SEO->aliasurl);
          	
          	$vsPrint->boink_it($exac_url);
          	 
       	     	
     	}
//	print "<pre>";
//	print_r ($option['pageList']);
//	print "</pre>";
//	exit();
//     	foreach($option['pageList'] as $value){
//     		echo $value->getTitle()."</br>";
//     	}
//     	exit();

     	$option['cate'] = $categories;
        $this->model->getNavigator();
    	return $this->output = $this->html->showDefault($option);
		
	}
	
	
	/*
	 * Show detail action 
	 */
	function showDetail($objId){
		global $vsPrint, $vsLang, $bw,$vsMenu,$vsTemplate;  
		
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
		$option['other1'] = $this->model->getOtherList($obj,"<");
		$this->model->convertFileObject($option['other'],$bw->input['module']);
		
		$this->output = $this->html->showDetail($obj,$option);
	}
	
	
}
?>
