<?php

class products_public extends ObjectPublic{
	function __construct(){
            global $vsTemplate;
            parent::__construct('products', CORE_PATH.'products/', 'products');
           $this->html = $vsTemplate->load_template('skin_products');
	}
function auto_run() {
		global $bw;

		switch ($bw->input['action']) {
			case 'detail':
				$this->showDetail($bw->input[2]);
				break;

			case 'category':
				$this->showCategory($bw->input[2]);
				break;
			case 'search':
				$this->loadSearch();
				break;
                        case 'abouts':
                                $this->getAbouts($bw->input[2]);
                            break;
                        case 'gallery':
                                $this->getshowGallery($bw->input[2]);
                            break;
			case 'form':
				return $this->output = $this->html->recruitmentForm();	
				break;
			default:
				$this->showDefault();
				break;
		}
	}
	
function showDefault(){
		global $vsSettings,$vsMenu,$bw,$vsTemplate,$vsCom,$vsPrint;
               
		$categories = $this->model->getCategories();
       	$strIds = $vsMenu->getChildrenIdInTree($categories);

       	//$this->model->setFieldsString("{$this->tableName}Title, {$this->tableName}Image, {$this->tableName}Id, {$this->tableName}Intro,{$this->tableName}CatId,{$this->tableName}PostDate");
       	
		$this->model->setCondition("{$this->tableName}Status > 0 and {$this->tableName}CatId in ({$strIds})");
		$this->model->setOrder("{$this->tableName}Index ASC, {$this->tableName}Id DESC");
		$size  = $vsSettings->getSystemKey("{$bw->input[0]}_user_item_quality",10,$bw->input[0]);
		$option = $this->model->getPageList($bw->input['module'], 1, $size);
		if($option['pageList'])
        	$this->model->convertFileObject($option['pageList'],$bw->input['module']);

    	
     	$option['cate'] = $categories;
        $this->model->getNavigator();
        if(in_array($bw->input['module'],array('abouts','policy'))&&$option['pageList']){
                     
                     $curre =  current($option['pageList']);
//                    $exac_url=strtr($curre->getUrl($bw->input['module']), $vsCom->SEO->aliasurls);
                    $exac_url=$curre->getUrl($bw->input['module']);
                    
                    $vsPrint->boink_it($exac_url);

                 }
           
	       
    	return $this->output = $this->html->showDefault($option);
		
	}	
	
	
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
		
        	
		$vsPrint->mainTitle = $vsPrint->pageTitle = $obj->getTitle();
		
		
		if ($bw->input['module']=='products'){
			$option['gallery'] = $this->model->getarrayGallery($obj->getId(),$bw->input['module']);
			//$option['other'] = $this->model->getOtherListProduct($obj);
			$this->model->convertFileObject($option['other'],$bw->input['module']);
                        //$obj->setView($obj->getView()+1);
                        $this->model->updateObjectById($obj);
		}
		

		
		$this->output = $this->html->showDetail($obj,$option);
	}	
	
	
	
 function loadSearch(){
		global $vsSettings,$vsMenu,$bw,$vsLang,$DB,$vsPrint;
                $where ="";
		if($bw->input['keySearch'])
			$keywords=strtolower(VSFTextCode::removeAccent(trim($bw->input['keySearch'])));
		else 
			$keywords=strtolower(VSFTextCode::removeAccent(trim($bw->input[3])));
		$keywords = strtolower(VSFTextCode::removeAccent(trim($keywords)));
                if($bw->input[2]){
                    $arr = explode("-", $bw->input[2]);
                   
//                    if($arr[0])$strIds = $arr[0];
//                    else{
                        $categories = $this->model->getCategories();
                        $strIds = $vsMenu->getChildrenIdInTree($categories);
                  //  }
                    $where .= "and {$this->tableName}CatId in ($strIds)".$where;
                    
                    
                    if($arr[1])
                        $where .= "and {$this->tableName}Model in ($arr[1])";
                       
                }
                
//                if(!$bw->input[2]){
//		$categories = $this->model->getCategories();
//                $strIds = $vsMenu->getChildrenIdInTree($categories);
//                }else $strIds = $bw->input[2];
       	
		//$where .= " and ({$this->tableName}ClearSearch like '%".$keywords."%' or {$this->tableName}Title like '%".$keywords."%'  or {$this->tableName}Intro like '%".$keywords."%')";
		$size  = $vsSettings->getSystemKey("{$bw->input[0]}_user_item_quality",16,$bw->input[0]);
//		$this->model->setFieldsString("{$this->tableName}Title, {$this->tableName}Image, {$this->tableName}Id, {$this->tableName}CatId,{$this->tableName}Price");
		$this->model->setCondition("{$this->tableName}Status > 0 ".$where);
		$this->model->setOrder("{$this->tableName}Id DESC");
		
		$option = $this->model->getPageList($bw->input['module']."/search/{$strIds}", 3, $size);

    	$this->model->getNavigator();
      	$vsPrint->mainTitle = $vsPrint->pageTitle = $option['title_search'] = $vsLang->getWords($bw->input['module'].'_search_result','Result search');
      	if ($option['pageList'])
     		$this->model->convertFileObject($option['pageList'],$bw->input['module']);
     	else 
     		$option['error_search'] = $vsLang->getWords($bw->input['module'].'_search_emty','Không tìm thấy dữ liệu theo yêu cầu. Vui lòng nhập từ khóa khác!');
     		
	
        return $this->output = $this->html->showDefault($option);
	}
	
	
	
	
	
	
        
        function getshowGallery($catId){
		global $vsPrint,$bw,$vsSettings, $vsMenu,$vsTemplate,$vsCom;
               
		$query = explode('-',$catId);
		$idCate = abs(intval($query[count($query)-1]));
		$categories = $this->model->getCategories();
		$option['cate'] =  $vsMenu->getCategoryById($idCate);
		$option['gallery'] = $this->model->getarrayGallery($idCate,'category');
		
              
    	return $this->output = $this->html->getGallery($option);
    	
	}
        
        function getAbouts($catId){
		global $vsPrint,$bw,$vsSettings, $vsMenu,$vsTemplate,$vsCom;
               
		$query = explode('-',$catId);
		$idCate = abs(intval($query[count($query)-1]));
		$categories = $this->model->getCategories();
		$option['cate'] =  $vsMenu->getCategoryById($idCate);
		
    	return $this->output = $this->html->getAbouts($option['cate']);
    	
}
	
//	function loadSearch(){
//		global $vsSettings,$vsMenu,$bw,$vsLang,$DB,$vsPrint;
//		if($bw->input['keySearch'])
//			$keywords=strtolower(VSFTextCode::removeAccent(trim($bw->input['keySearch'])));
//		else 
//			$keywords=strtolower(VSFTextCode::removeAccent(trim($bw->input[2])));
//		$keywords = strtolower(VSFTextCode::removeAccent(trim($keywords)));	
//		$categories = $this->model->getCategories();
//       	$strIds = $vsMenu->getChildrenIdInTree($categories);
//       	
//		$where = " and ({$this->tableName}ClearSearch like '%".$keywords."%' or {$this->tableName}Title like '%".$keywords."%' or {$this->tableName}Content like '%".$keywords."%' or {$this->tableName}Intro like '%".$keywords."%')";
//		$size  = $vsSettings->getSystemKey("{$bw->input[0]}_user_item_quality",16,$bw->input[0]);
//		$this->model->setFieldsString("{$this->tableName}Title, {$this->tableName}Image, {$this->tableName}Id, {$this->tableName}CatId,{$this->tableName}Price");
//		$this->model->setCondition("{$this->tableName}Status > 0 and {$this->tableName}CatId in ($strIds)".$where);
//		$this->model->setOrder("{$this->tableName}Id DESC");
//		
//		$option = $this->model->getPageList($bw->input['module']."/search/{$keywords}", 3, $size);
//
//    	$this->model->getNavigator();
//      	$vsPrint->mainTitle = $vsPrint->pageTitle = $option['title_search'] = $vsLang->getWords($bw->input['module'].'_search_result','Result search');
//      	if ($option['pageList'])
//     		$this->model->convertFileObject($option['pageList'],$bw->input['module']);
//     	else 
//     		$option['error_search'] = $vsLang->getWords($bw->input['module'].'_search_emty','Không tìm thấy dữ liệu theo yêu cầu. Vui lòng nhập từ khóa khác!');
//     		
//	
//        return $this->output = $this->html->showCategory($option);
//	}
	
}

?>