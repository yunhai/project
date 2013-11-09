<?php
class products_admin extends ObjectAdmin{
	function __construct(){
            global $vsTemplate;
		parent::__construct('products', CORE_PATH.'products/', 'products');
                 $this->html = $vsTemplate->load_template('skin_products');
	}
        
	function addEditObjForm($objId = 0, $option = array()) {
		global $vsLang, $vsStd, $bw, $vsPrint,$vsSettings,$search_module,$langObject;
		
     	$option['skey'] = $bw->input['module'];
		$obj = $this->model->createBasicObject ();
		$option ['formSubmit'] = $langObject['itemFormAddButton'];
		$option ['formTitle'] = $langObject['itemFormAdd'];
		if ($objId) {
			$option ['formSubmit'] = $langObject['itemFormEditButton'];
			$option ['formTitle'] = $langObject['itemFormEdit'];
			$obj = $this->model->getObjectById ( $objId ,1);
		} 
              
		$vsPrint->addJavaScriptFile ( "tiny_mce/tiny_mce" );
		$vsStd->requireFile ( JAVASCRIPT_PATH . "/tiny_mce/tinyMCE.php" );
		$editor = new tinyMCE ();
		
		if($vsSettings->getSystemKey($option['skey'].'_intro_editor', 1, $option['skey'])){
			$editor->setWidth ( '100%' );
			$editor->setHeight ( '150px' );
			$editor->setToolbar ( 'narrow' );
			$editor->setTheme ( "advanced" );
			$editor->setInstanceName ( "{$this->tableName}Intro" );
			$editor->setValue ( $obj->getIntro () );
			$obj->setIntro ( $editor->createHtml () );
		}else
			$obj->setIntro ('<textarea name="'.$this->tableName.'Intro" style="width:100%;height:100px;">'. strip_tags($obj->getIntro()) .'</textarea>');
                   
		
		$editor->setWidth ( '100%' );
		$editor->setHeight ( '350px' );
		$editor->setToolbar ( 'full' );
		$editor->setTheme ( "advanced" );
		$editor->setInstanceName ( "{$this->tableName}Content");
		$editor->setValue('');
		if($obj->getContent()){
			$editor->setValue($obj->getContent());
		}else{
			$val=$vsSettings->getSystemKey($bw->input[0]."_contentdefault{$vsLang->currentLang->getFoldername()}", 0, $bw->input[0], 1, 1);
			if(!is_numeric($val)){
				$editor->setValue($vsSettings->getSystemKey($bw->input[0]."_contentdefault{$vsLang->currentLang->getFoldername()}", 0, $bw->input[0], 1, 1));
			}
		}
		$obj->setContent ( $editor->createHtml () );

	    
		return $this->output = $this->html->addEditObjForm ( $obj, $option );
	}

	function getObjList($catId = '', $message = "") {
		global $bw, $vsSettings;
		$catId = intval ( $catId );
	
		$categories = $this->model->getCategories ();
	
		if ($bw->input ['pageCate'])
			$bw->input [2] = $catId = $bw->input ['pageCate'];
		if ($bw->input ['pageIndex'])
			$bw->input [3] = $bw->input ['pageIndex'];
	
		// Check if the catIds is specified
		// If not just get all product
		if (intval ( $catId )) {
			$result = $this->model->vsMenu->extractNodeInTree ( $catId, $categories->getChildren () );
			if ($result)
				$strIds = trim ( $catId . "," . $this->model->vsMenu->getChildrenIdInTree ( $result ['category'] ), "," );
		}
		if (! $strIds)
			$strIds = $this->model->vsMenu->getChildrenIdInTree ( $categories );
		// Set the condition to get all product in specified category and its chidlren
		$this->model->setCondition ( $this->model->getCategoryField () . " in (" . $strIds . ") and {$this->tableName}Status > -1" );
		$this->model->setOrder("productCatId, productIndex ");
		
		$size = $vsSettings->getSystemKey ( "admin_{$bw->input[0]}_list_number", 10 );
	
		$option = $this->model->getPageList ( "{$bw->input[0]}/display-obj-list/{$catId}", 3, $size, 1, 'obj-panel' );
		$option ['message'] = $message;
		$option ['categoryId'] = $catId;
	
		return $this->output = $this->html->objListHtml ( $this->model->getArrayObj (), $option );
	}

}
