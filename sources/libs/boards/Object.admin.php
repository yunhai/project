<?php
/*
 * @author Luu Quang Vu
 * This class is used to describle the genaral for objects admin of VSF
 */
class ObjectAdmin {
	public $html;
	public $modelName;
	public $model;
	public $output;
	public $skinName;
	public $tableName;
	public $classNameModel;
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
	function __construct($skinName, $modelName, $pathModel, $classModelName) {
		global $vsStd, $vsTemplate, $tableName, $vsModule;
		// Initialize model
		$this->modelName = $modelName;
		$vsStd->requireFile ( $pathModel . $this->modelName . '.php' );
		$this->classNameModel = $classModelName;
		$this->model = new $this->classNameModel ();
		
		$this->tableName = $this->model->getTableName ();
		$tableName = $this->tableName;
		// Initialize skin
		$this->skinName = $skinName;
		$this->html = $vsTemplate->load_template ( $this->skinName );
	}
	
	function auto_run() {
		global $bw, $search_module, $vsSettings;
		$search_module = array ("restaurants" );
		
		switch ($bw->input ['action']) {
			case 'delete-checked-obj' :
				$this->module->delete ( rtrim ( $bw->input ['checkedObj'], "," ) );
				$this->lastModifyChange();
				break;
			
			case 'visible-checked-obj' :
				$this->checkShowAll ( 1 );
				break;
			
			case 'home-checked-obj' :
				$this->checkShowAll ( 2 );
				break;
			
			case 'hide-checked-obj' :
				$this->checkShowAll ( 0 );
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
				$this->lastModifyChange();
				$this->getObjList ();
				break;
			
			case 'delete-obj' :
				$this->deleteObj ( $bw->input [2] );
				break;
				
			case 'display_list_news_comments' :
				$this->displayListNewsComments ( $bw->input [2], $this->module->result ['message'] );
				break;
				
			default :
				$this->loadDefault ();
				break;
		}
	}
	function lastModifyChange(){
		if(!LAST_MODIFY_FILE) return false;
		$fp = fopen(LAST_MODIFY_FILE, 'w');
		fwrite($fp, 'modified');
		fclose($fp);
	}
	function deleteObj($ids, $cate = 0) {
		global $bw, $search_module, $vsStd;
		
		$this->model->setCondition ( "{$this->tableName}Id IN (" . $ids . ")" );
		$list = $this->model->getObjectsByCondition ();
		if (! count ( $list ))
			return false;
		$this->model->setCondition ( "{$this->tableName}Id IN (" . $ids . ")" );
		if (! $this->model->deleteObjectByCondition ())
			return false;
		$vsFile = VSFactory::getFiles ();
		foreach ( $list as $news )
			$vsFile->deleteFile ( $news->getImage () );
		if (in_array ( $bw->input ['module'], $search_module )) {
			$vsStd->requireFile ( CORE_PATH . "searchs/searchs.php" );
			$search = new searchs ();
			$search->setCondition ( "searchId in ({$ids}) and searchModule = '{$bw->input['module']}'" );
			$search->deleteObjectByCondition ();
		}
		$this->lastModifyChange();
		return $this->output = $this->getObjList ( $cate );
	}
	
	function checkShowAll($val = 0) {
		global $bw, $search_module, $vsStd;
		$this->model->setCondition ( "{$this->tableName}Id in ({$bw->input[2]})" );
		$this->model->updateObjectByCondition ( array ("{$this->tableName}Status" => $val ) );
		if (in_array ( $bw->input ['module'], $search_module )) {
			$vsStd->requireFile ( CORE_PATH . "searchs/searchs.php" );
			$search = new searchs ();
			$search->setCondition ( "searchId in ({$bw->input[2]}) and searchModule = '{$bw->input['module']}'" );
			$search->updateObjectByCondition ( array ("searchStatus" => $val ) );
		}
		$this->lastModifyChange();
		return $this->output = $this->getObjList ( $bw->input [3] );
	}
	
	function displayObjTab() {
		global $bw;
		
		if (VSFactory::getSettings()->getSystemKey ( $bw->input [0] . '_category_list', 0, $bw->input [0] ))
			$option ['categoryList'] = $this->getCategoryBox ();
		
		$option ['objList'] = $this->getObjList ();
		$this->output = $this->html->displayObjTab ( $option );
		
	}
	
	function getObjList($catId = '', $message = "") {
		global $bw;
		$catId = intval ( $catId );
		$vsMenu = VSFactory::getMenus ();
		$vsSettings = VSFactory::getSettings();
		$categories = $this->model->getCategories ();
		if ($bw->input ['pageCate'])
			$bw->input [2] = $catId = $bw->input ['pageCate'];
		if ($bw->input ['pageIndex'])
			$bw->input [3] = $bw->input ['pageIndex'];
		
		// Check if the catIds is specified
		// If not just get all product
		if (intval ( $catId )) {
			$result = $vsMenu->extractNodeInTree ( $catId, $categories->getChildren () );
			if ($result)
				$strIds = trim ( $catId . "," . $vsMenu->getChildrenIdInTree ( $result ['category'] ), "," );
		}
		if (! $strIds)
			$strIds = $vsMenu->getChildrenIdInTree ( $categories );
		
		// Set the condition to get all product in specified category and its chidlren
		$this->model->setCondition ( $this->model->getCategoryField () . " in (" . $strIds . ") and {$this->tableName}Status > -1" );
		
		$size = $vsSettings->getSystemKey ( "admin_{$bw->input[0]}_list_number", 10 );
		
		$option = $this->model->getPageList ( "{$bw->input[0]}/display-obj-list/{$catId}", 3, $size, 1, 'obj-panel' );
		$option ['message'] = $message;
		$option ['categoryId'] = $catId;
	
		$this->output = $this->html->objListHtml ( $this->model->getArrayObj (), $option );
		return $this->output ;
	}
	
	function addEditObjForm($objId = 0, $option = array()) {
		global $vsStd, $bw, $vsPrint;
		$vsLang = VSFactory::getLangs();
		$option ['skey'] = $bw->input ['module'];
		$obj = $this->model->createBasicObject ();
		$option ['formSubmit'] = $vsLang->getWords ( 'obj_EditObjFormButton_Add', 'Add' );
		$option ['formTitle'] = $vsLang->getWords ( 'obj_EditObjFormTitile_Add', "Add {$bw->input[0]}" );
		if ($objId) {
			
			$option ['formSubmit'] = $vsLang->getWords ( 'obj_EditObjFormButton_Edit', 'Edit' );
			$option ['formTitle'] = $vsLang->getWords ( 'obj_EditObjFormTitile_Edit', "Edit {$bw->input[0]}" );
			$obj = $this->model->getObjectById ( $objId, 1 );
		}
		
		$vsPrint->addJavaScriptFile ( "tiny_mce/tiny_mce" );
		$vsStd->requireFile ( JAVASCRIPT_PATH . "/tiny_mce/tinyMCE.php" );
		$editor = new tinyMCE ();
		if (VSFactory::getSettings()->getSystemKey ( $option ['skey'] . '_intro_editor', 1, $option ['skey'] )) {
			$editor->setWidth ( '100%' );
			$editor->setHeight ( '150px' );
			$editor->setToolbar ( 'simple' );
			$editor->setTheme ( "advanced" );
			$editor->setInstanceName ( "{$this->tableName}Intro" );
			$editor->setValue ( $obj->getIntro () );
			$obj->setIntro ( $editor->createHtml () );
		} else
			$obj->setIntro ( '<textarea name="' . $this->tableName . 'Intro" style="width:100%;height:100px;">' . strip_tags ( $obj->getIntro () ) . '</textarea>' );
		
		$editor->setWidth ( '100%' );
		$editor->setHeight ( '350px' );
		$editor->setToolbar ( 'full' );
		$editor->setTheme ( "advanced" );
		$editor->setInstanceName ( "{$this->tableName}Content" );
		$editor->setValue ( $obj->getContent () );
		$obj->setContent ( $editor->createHtml () );
		
		return $this->output = $this->html->addEditObjForm ( $obj, $option );
	}
	
	function addEditObjProcess() {
		global $bw, $vsStd, $search_module;
		$vsLang = VSFactory::getLangs();
		$vsFile = VSFactory::getFiles();
		$bw->input ["{$this->tableName}PostDate"] = time();
		$bw->input ["{$this->tableName}Status"] = $bw->input ["{$this->tableName}Status"] ? $bw->input ["{$this->tableName}Status"] : 0;
		
		if (! $bw->input ["{$this->tableName}CatId"])
			$bw->input ["{$this->tableName}CatId"] = $this->model->getCategories ()->getId ();
		
		if ($bw->input ['fileImageId'])
			$bw->input ["{$this->tableName}Image"] = $bw->input ['fileImageId'];
		elseif($bw->input ['txtlink'])
			$bw->input ["{$this->tableName}Image"] = $vsFile->copyFile ( $bw->input ["txtlink"], $bw->input [0] );
		
		// If there is Object Id passed, processing updating Object
		if ($bw->input ["{$this->tableName}Id"]) {
			
			$obj = $this->model->getObjectById ( $bw->input ["{$this->tableName}Id"] );
			
			$imageOld = $obj->getImage ();
			if ($bw->input ['deleteImage']) {
				$imageOld = $obj->getImage ();
				if ($imageOld)
					$vsFile->deleteFile ( $imageOld );
				if (! $bw->input ["{$this->tableName}Image"])
					$bw->input ["{$this->tableName}Image"] = 0;
			}
			
			$objUpdate = $this->model->createBasicObject ();
			$objUpdate->convertToObject ( $bw->input );
			
			$this->model->updateObjectById ( $objUpdate );
			if ($this->model->result ['status']) {
				$alert = $vsLang->getWords ( 'pages_editPageItem_Successful', 'you have successfully edit a page!' );
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
			$bw->input ["{$this->tableName}PostDate"] = time ();
			$this->model->basicObject->convertToObject ( $bw->input );
			$this->model->insertObject ( $this->model->obj );
			if ($this->model->result ['status']) {
				$confirmContent = $vsLang->getWords ( 'pages_addPageItem_Successful', 'you have successfully add a page!' ) . '\n' . $vsLang->getWords ( 'pages_addPageItem_AddMore', 'Do you want to add another page?' );
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
		
		//convert to Search
		if (in_array ( $bw->input ['module'], $search_module )) {
			if ($bw->input ['searchRecord']) {
				$vsStd->requireFile ( CORE_PATH . "searchs/searchs.php" );
				$search = new searchs ();
				$search->setCondition ( "searchRecord  = " . $bw->input ['searchRecord'] );
				$search->updateObjectByCondition ( $this->model->basicObject->convertSearchDB () );
			} elseif (isset ( $bw->input ['searchRecord'] )) {
				VSFactory::createConnectionDB()->do_insert ( "search", $this->model->basicObject->convertSearchDB () );
			}
		}
		
		//end convert to Search
		$cat = $bw->input ['pageCate'] ? $bw->input ['pageCate'] : $bw->input ['pageCatId'];
		//$vsFile->buildCacheFile ( $bw->input ['module'] );
		$this->lastModifyChange();
		return $this->output = $javascript . $this->getObjList ();
	}
	
	function getCategoryBox($message = "") {
		global $bw;
		
		$data ['message'] = $message;
		
		$option = array ('listStyle' => "| - -", 'id' => 'obj-category', 'size' => 10 );
		$menu = new Menu ();
		$menu = $this->model->getCategories ();
		$data ['html'] = VSFactory::getMenus()->displaySelectBox ( $menu->getChildren (), $option );
		
		return $this->html->categoryList ( $data );
	}
	
	function loadDefault() {
		global $vsPrint, $bw;
		$vsPrint->addJavaScriptFile ( "tiny_mce/tiny_mce" );
		$vsPrint->addJavaScriptString ( 'init_tab', "
			$(document).ready(function(){
    			$(\"#page_tabs\").tabs({
    				cache: false,
    				select : window.location.hash
    			});
    			$(\"#tabs\").bind(\"tabsselect\", function(event, ui) { 
			      window.location.hash = ui.tab.hash;
			    })
    			
  			});
		");
		if (! $bw->input ['ajax'] && VSFactory::getSettings()->getSystemKey ( $bw->input [0] . '_googleposition', 0, $bw->input [0] ))
			$script = <<<EOF
			<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&key=ABQIAAAAFchR-gNjD0MQ7LJ6awqichTNHz2w15vTCggQMczdoQ-_ZgOzOBTJdQuflmfPJtQDBLcIi3vpSZLLTw"></script>
EOF;
		$this->output = $this->html->managerObjHtml () . $script;
	}
	
	public function getHtml() {
		return $this->html;
	}
	
	public function getOutput() {
		return $this->output;
	}
	
	public function setHtml($html) {
		$this->html = $html;
	}
	
	public function setOutput($output) {
		$this->output = $output;
	}
}