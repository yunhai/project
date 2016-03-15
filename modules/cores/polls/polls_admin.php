<?php
class polls_admin extends ObjectAdmin{
	function __construct(){
            global $vsTemplate;
		parent::__construct('polls', CORE_PATH.'polls/', 'polls');
                 $this->html = $vsTemplate->load_template('skin_polls');
	}
	function auto_run() {
		global $bw,$search_module,$vsSettings;
		
		switch ($bw->input ['action']) {
			
			case 'visible-checked-obj' :
				$this->checkShowAll(1);
				break;
			
			case 'home-checked-obj' :
				$this->checkShowAll(2);
				break;
			
			case 'hide-checked-obj' :
				$this->checkShowAll(0);
				break;
			
			case 'display-obj-tab' :
				$this->displayObjTab ();
				break;
			
			case 'display-obj-list' :
				$this->getObjList ( $bw->input [2], $this->model->result ['message'] );
				break;
			
			case 'add-edit-obj-form' :
				$this->addEditObjForm ( $bw->input [2] );
				break;
			
			case 'add-edit-obj-process' :
				$this->addEditObjProcess ();
				break;
			
			case 'change-objlist-bt' :
				$this->model->changeCateList ();
				$this->getObjList ($bw->input[2],$bw->input[3], $this->module->result['message']);
				break;
			
			case 'delete-obj' :
				$this->deleteObj($bw->input[2]);
				break;
			case "display-answer-tab":
				$this->displayAnswer();
				break;	
			default :
				$this->loadDefault ();
				break;
			
		}
	}
	
	function displayAnswer(){
		$menu = $this->model->getCategories();
		$answerList = $this->getObjList('','answerListHtml');
		$this->output = $this->html->displayAnswer($menu,$answerList);
	}
	
	function displayObjTab() {
		global $bw, $vsSettings;
		if($vsSettings->getSystemKey($bw->input[0].'_category_tab',1))
		$option['categoryList'] = $this->getCategoryBox();
		$this->output = $this->html->displayObjTab($option);
	}
	
	function getCategoryBox($message="") {
		global $bw , $vsMenu;
		$menu = $this->model->getCategories();
		return $this->html->categoryList($menu);
	}	
	
	function getObjList($catId='',$action="objListHtml",$message=""){
		global $bw, $vsSettings;
		
		$catId = intval($catId);
		$categories = $this->model->getCategories();
		// Check if the catIds is specified
		// If not just get all product
		if(intval($catId)){
			$result = $this->model->vsMenu->extractNodeInTree($catId, $categories->getChildren());
			if($result)
			$strIds = trim($catId.",".$this->model->vsMenu->getChildrenIdInTree($result['category']),",");
		}
		if(!$strIds)
		$strIds = $this->model->vsMenu->getChildrenIdInTree($categories);
		// Set the condition to get all product in specified category and its chidlren
		$this->model->setCondition($this->model->getCategoryField().' in ('. $strIds. ')');
		$size = $vsSettings->getSystemKey("admin_{$bw->input[0]}_list_number",10);

		$option=$this->model->getPageList("{$bw->input[0]}/display-obj-list/{$catId}/$action/", 3,$size,1,'obj-panel');
		$option ['message'] = $message;
		$option ['categoryId'] = $catId;
       	$option['totalClick'] = $this->model->getTotalClick($catId);     
       	if($action=='answerListHtml' || $bw->input [3]=='answerListHtml' ||$bw->input [4]=='answerListHtml')
       	return $this->output = $this->html->answerListHtml( $this->model->getArrayObj (), $option );
       	else
		return $this->output = $this->html->objListHtml( $this->model->getArrayObj (), $option );
	}
	
	function addEditObjProcess() {
		global $bw, $vsStd, $vsLang, $vsFile,$DB,$vsSettings,$search_module,$langObject;
	
		$bw->input ["{$this->tableName}Status"] = $bw->input ["{$this->tableName}Status"] ? $bw->input ["{$this->tableName}Status"] : 0;
                
	
		if (! $bw->input ["{$this->tableName}CatId"])
			$bw->input ["{$this->tableName}CatId"] = $this->model->getCategories ()->getId ();
                        
		if ($bw->input ['fileId'])
			$bw->input ["{$this->tableName}Image"] = $bw->input ['fileId'];
                elseif($bw->input['txtlink'])
			$bw->input["{$this->tableName}Image"]=$vsFile->copyFile($bw->input["txtlink"],$bw->input[0]);
		
		// If there is Object Id passed, processing updating Object
		if ($bw->input ["{$this->tableName}Id"]) {
			$obj = $this->model->getObjectById ( $bw->input ["{$this->tableName}Id"] );
                        
			$imageOld = $obj->getImage ();
                        if($bw->input['deleteImage']){
				$imageOld = $obj->getImage();
				if($imageOld) $vsFile->deleteFile($imageOld);
				if(!$bw->input["{$this->tableName}Image"]) $bw->input["{$this->tableName}Image"] = 0;
			}
			
			$objUpdate = $this->model->createBasicObject ();
			$objUpdate->convertToObject ( $bw->input );
                       
			$this->model->updateObjectById ( $objUpdate );
			if ($this->model->result ['status']) {
				$alert = $langObject['itemEditSuccess'];
				$javascript = <<<EOF
						<script type='text/javascript'>
							jAlert(
								"{$alert}",
								"{$bw->vars['global_websitename']} Dialog"
							);
						</script>
EOF;
			}
		} else {
            $bw->input["{$this->tableName}PostDate"] = time();           
			$this->model->obj->convertToObject ( $bw->input );
			
			$this->model->insertObject ( $this->model->obj );
			if ($this->model->result ['status']) {
				$confirmContent = $langObject['itemAddSuccess'] . '\n' . $langObject['itemAddAnother'] ." ?";
				$javascript = <<<EOF
					<script type='text/javascript'>
						jConfirm(
							"{$confirmContent}",
							'{$bw->vars['global_websitename']} Dialog',
							function(r){
								if(r){
									vsf.get("{$bw->input[0]}/add-edit-obj-form/&pageIndex={$bw->input['pageIndex']}&pageCate={$bw->input['pageCate']}",'obj-panel');
								}
							}
						);
					</script>
EOF;
			}
		}
		if ($imageOld && $bw->input ['fileId']) {
			$vsFile->deleteFile ( $imageOld );
		}
		
        
        //end convert to Search
		$cat = $bw->input ['pageCate'] ? $bw->input ['pageCate'] : $bw->input ['pageCatId'];
		$vsFile->buildCacheFile ( $bw->input ['module'] );
		return $this->output = $javascript . $this->getObjList ('','answerListHtml');
	}
	

}

?>