<?php
class gallerys_public extends ObjectPublic{
	function __construct(){
            global $vsTemplate;
            parent::__construct('gallerys', CORE_PATH.'gallerys/', 'gallerys');
            $this->html = $vsTemplate->load_template('skin_gallerys');    
	}
	
function showDefault(){
		global $vsSettings,$vsMenu,$bw,$vsTemplate,$vsCom,$vsPrint,$vsStd;
              $vsStd->requireFile(CORE_PATH.'pages/pages.php');
              $pages = new pages();
              $option['page']= $pages->getObjByCode($bw->input['module'], 'pgallerys');
          
                return $this->output = $this->html->showDefault($option);		
	}
	function showDetail($objIds){
		global $vsPrint, $vsLang, $bw,$vsMenu,$vsSettings;              
		$query = explode('-',$objIds);
		$objId = intval($query[count($query)-1]);
		if(!$objId) return $vsPrint->redirect_screen($vsLang->getWords('global_no_item','Không có dữ liệu theo yêu cầu!'));
		$obj = $this->model->getObjectById($objId);
		
		
		$this->model->getNavigator($obj->getCatId());
	
		$categories = $this->model->getCategories();
       	$strIds = $vsMenu->getChildrenIdInTree($categories);
		$size  = $vsSettings->getSystemKey("{$bw->input[0]}_other_item",7,$bw->input[0]);
		
		$this->model->setCondition("{$this->tableName}Status > 0 and {$this->tableName}CatId in ({$strIds}) and {$this->tableName}Id <> {$objId}");
		$this->model->setOrder("{$this->tableName}Index ASC, {$this->tableName}Id DESC");
		$this->model->setFieldsString("{$this->tableName}Title, {$this->tableName}Image, {$this->tableName}Id, {$this->tableName}CatId");
		$option = $this->model->getPageList($bw->input['module']."/detail/".$objIds, 3, $size);
		
		$option['curr'] = $obj;
		$option['img'] = $this->model->getFileByAlbumId($objId);
		$this->model->convertFileObject(array($option['curr']),$bw->input['module']);
		
		$vsPrint->mainTitle = $vsPrint->pageTitle = $option['curr']->getTitle();
		$this->output = $this->html->showDetail($obj,$option);
	}
        
        function showSearch(){
		global $vsSettings,$vsMenu,$bw,$vsLang,$DB,$vsPrint;
                $module = "'{$bw->input['module']}'";
                if($bw->input['module']=='gallerys')
                    $module ="'tcgallery','hngallery'";
		$categories = $this->model->getCategories();
                $strIds = $vsMenu->getChildrenIdInTree($categories);
		$keywords=strtolower(VSFTextCode::removeAccent(trim($bw->input[2])));
		$where .= " and ({$this->tableName}ClearSearch like '%".$keywords."%')";
		$size  = $vsSettings->getSystemKey("{$bw->input[0]}_user_item_quality",16,$bw->input[0]);
		$this->model->setCondition("{$this->tableName}Status > 0 and {$this->tableName}Module in ({$module})".$where);
		$this->model->setOrder("{$this->tableName}Id DESC");
              
		$option = $this->model->getPageList($this->modelName."/search/{$keywords}", 3, $size);
               
                $this->model->getNavigator();
                if($option['pageList'])
                    foreach($option['pageList'] as $obj)
                        $this->model->convertFileObject(array($obj),$obj->module);

        return $this->output = $this->html->showSearch($option);
	}
	
}
?>