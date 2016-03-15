<?php
class searchs_public extends ObjectPublic{
	function __construct(){
		global $vsTemplate,$bw;
		parent::__construct('searchs', CORE_PATH.'searchs/', 'searchs');
		
	}
	
	function showDefault(){
		global $vsSettings,$vsMenu,$bw,$vsLang,$DB,$vsPrint;


		if($bw->input['keySearch'])
			$keywords=strtolower(VSFTextCode::removeAccent(trim($bw->input['keySearch'])));
		else 
			$keywords=strtolower(VSFTextCode::removeAccent(trim($bw->input[1])));

		$keywords = strtolower(VSFTextCode::removeAccent(trim($keywords)));	
		$where .= " and (searchTitle like '%".$keywords."%' or searchIntro like '%".$keywords."%' or searchContent like '%".$keywords."%')";
	
		$size  = $vsSettings->getSystemKey("{$bw->input[0]}_user_item_quality",16,$bw->input[0]);
		$this->model->setFieldsString("{$this->tableName}Title, {$this->tableName}Image, {$this->tableName}Id, {$this->tableName}Intro, {$this->tableName}CatId,{$this->tableName}Module,{$this->tableName}Record");
		$this->model->setCondition("{$this->tableName}Status > 0 and {$this->tableName}CatId in ({$vsLang->currentLang->getId()})".$where);
		$this->model->setOrder("{$this->tableName}Id DESC");
		
		
		$option = $this->model->getPageList($this->modelName."/{$keywords}", 2, $size);
	
                $this->model->getNavigator();
                if($option['pageList'])
                    foreach($option['pageList'] as $obj)
                        $this->model->convertFileObject(array($obj),$obj->module);
               else 
     		$option['error_search'] = $vsLang->getWords($bw->input['module'].'_search_emty','Không tìm thấy dữ liệu theo yêu cầu. Vui lòng nhập từ khóa khác!');
		return $this->output = $this->html->showSearch($option);

	}
}

?>