 <?php
class pages_public extends ObjectPublic{
	function __construct(){
		parent::__construct('pages', CORE_PATH.'pages/', 'pages');
	}

	
//	function showDefault(){
//	
//		
//		global $vsSettings,$vsMenu,$bw,$vsTemplate,$vsCom,$vsPrint;              
//		
//		$categories = $this->model->getCategories();  
//       	$strIds = $vsMenu->getChildrenIdInTree($categories);
//       	//$this->model->setFieldsString("{$this->tableName}Title, {$this->tableName}Image, {$this->tableName}Id, {$this->tableName}Intro,{$this->tableName}CatId,{$this->tableName}PostDate");	
//		$this->model->setCondition("{$this->tableName}Status > 0 and {$this->tableName}CatId in ({$strIds})");
//		$this->model->setOrder("{$this->tableName}Index ASC, {$this->tableName}Id DESC");
//		
//		$size  = $vsSettings->getSystemKey("{$bw->input[0]}_user_item_quality",10,$bw->input[0]);
//		$option = $this->model->getPageList($bw->input['module'], 1, $size);
//		if($option['pageList'])
//        	$this->model->convertFileObject($option['pageList'],$bw->input['module']);
//
//		
//			 
//     	//$option['cate'] = $categories;
//        $this->model->getNavigator();
//        
//
//        // ******* tro tin dau tien **************/
//        if(in_array($bw->input['module'],array('policy','abouts'))&&$option['pageList']){
//                     
//                     $curre =  current($option['pageList']);
////                    $exac_url=strtr($curre->getUrl($bw->input['module']), $vsCom->SEO->aliasurls);
//                    $exac_url=$curre->getUrl($bw->input['module']);
//                    
//                    $vsPrint->boink_it($exac_url);
//                 }
//		//$option['curr']=array_shift($option['pageList']);
////		print "<pre>";
////		print_r ($option['pageList']);
////		print "</pre>";
////		exit();
//
//                 
//    	return $this->output = $this->html->showDefault($option);
//		
//	}	
	
	
	
	
	
	
//	function showDetail($objId){
//		
//	
//		global $vsPrint, $vsLang, $bw,$vsMenu,$vsTemplate,$DB;              
//		$query = explode('-',$objId);
//		$objId = intval($query[count($query)-1]);
//		if(!$objId) return $vsPrint->redirect_screen($vsLang->getWords('global_no_item','Không có dữ liệu theo yêu cầu!'));
//		$obj=$this->model->getObjectById($objId);
//		$this->model->convertFileObject(array($obj),$bw->input['module']);
//		$cat=$this->model->vsMenu->getCategoryById($obj->getCatId());
//		$this->model->getNavigator($obj->getCatId());
//		
//		$option['cate'] =  $vsMenu->getCategoryById($obj->getCatId());
//		
//        	
//		$vsPrint->mainTitle = $vsPrint->pageTitle = $obj->getTitle();
//
//		$categories = $this->model->getCategories();  
//       	$strIds = $vsMenu->getChildrenIdInTree($categories);
//       	//$this->model->setFieldsString("{$this->tableName}Title, {$this->tableName}Image, {$this->tableName}Id, {$this->tableName}Intro,{$this->tableName}CatId,{$this->tableName}PostDate");	
//		$this->model->setCondition("{$this->tableName}Status > 0 and {$this->tableName}CatId in ({$strIds})");
//		$this->model->setOrder("{$this->tableName}Index ASC, {$this->tableName}Id DESC");
//	 
//		
//		$array = array("phatsu","culture","knowledge","abouts");
//		if(in_array($bw->input['module'], $array)){	
//			$categories = $vsMenu->getCategoryGroup("phatsu","culture","knowledge","abouts");
//			$this->model->setCondition("{$this->tableName}Status > 0 and {$this->tableName}CatId in ({$strIds})");
//			$this->model->setOrder("{$this->tableName}Index ASC, {$this->tableName}Id DESC");
//			$this->model->setLimit(array(0,5));
//	        $option['news'] = $this->model->getObjectsByCondition();
//	        
//	        
//	        $categories = $vsMenu->getCategoryGroup("phatsu","culture","knowledge","abouts");
//			$this->model->setCondition("{$this->tableName}Status > 0 and {$this->tableName}CatId in ({$strIds})");
//	        $this->model->setOrder("{$this->tableName}Index ASC, {$this->tableName}Id DESC, {$this->tableName}Count DESC");
//	        $this->model->setLimit(array(0,5));
//	        $option['newsCount'] = $this->model->getObjectsByCondition();
//	        
//        
//		}
//		
//		$obj->setCount($obj->getCount()+1);
//		$this->model->updateObjectById ( $obj );
//		
//$option['gallery'] = $this->model->getarrayGallery($obj->getId(),$bw->input['module']);
//		$this->output = $this->html->showDetail($obj,$option);
//	}
	
	
	
	
	
	
	
	
	
	
	
	
	
}
?>
