<?php
/*
 +-----------------------------------------------------------------------------
 |   VSF version 3.0.0.0
 |	Author: BabyWolf
 |	Homepage: http://www.vietsol.net
 |	If you use this code, please don't delete these comment lines!
 |	Start Date: 10/21/2007
 |	Finish Date: 10/21/2007
 |	Modified Start Date: 10/27/2007
 |	Modified Finish Date: 10/28/2007
 |	News Description: This News is for management all travels in system.
 +-----------------------------------------------------------------------------
 */
require_once (CORE_PATH . "travels/travels.php");

class travels_admin {
	protected $html = "";
	protected $module;
	
	protected $output = "";
	
	public function __construct() {
		global $vsTemplate, $vsPrint;
		$vsPrint->addJavaScriptFile ( "jquery/ui.datepicker" );
		$vsPrint->addCSSFile ( 'ui.datepicker' );
		$this->module = new travels ();
		$this->html = $vsTemplate->load_template ( 'skin_travels' );
	}
	
	function auto_run() {
		global $bw;
		
		switch ($bw->input [1]) {
			case 'delete-checked-obj' :
				$this->module->delete ( rtrim ( $bw->input ['checkedObj'], "," ) );
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
				$this->getObjList ( $bw->input [2], $this->module->result ['message'] );
				break;
			
			case 'add-edit-obj-form' :
				$this->addEditObjForm ( $bw->input [2] );
				break;
			
			case 'add-edit-obj-process' :
				$this->addEditObjProcess ();
				break;
			case 'search' :
				$_SESSION ['pageSearch'] = "";
				$_SESSION ['pagepaging'] = 1;
				$this->searchValue ();
				break;
			
			case 'delete-obj' :
				$this->deleteObj ( $bw->input [2] );
				break;
			case 'autocomplete' :
				$this->autoComplet ( $bw->input [2] );
				break;
			case 'create_rss_file' :
				$this->createRSS ( $bw->input [2] );
				break;
			
			default :
				$this->loadDefault ();
		}
	}
	
	public function autoComplet() {
		global $bw;
		
		if ($bw->input ['q']) {
			$this->module->setFieldsString ( "travelTitle,travelId" );
			if ($bw->input ['searchCate']) {
				$cond .= "travelCatId = {$bw->input['searchCate']} ";
			
			} else {
				$categories = $this->module->getCategories ();
				$strIds = $this->module->vsMenu->getChildrenIdInTree ( $categories );
				$cond = $this->module->getCategoryField () . ' in (' . $strIds . ')';
			}
			$cond .= "and travelTitle like '%" . $bw->input ['q'] . "%'";
			$this->module->setLimit ( array (0, 10 ) );
			$this->module->setCondition ( $cond );
			$value = $this->module->getObjectsByCondition ();
			
			if ($value)
				foreach ( $value as $v )
					echo $v->getTitle () . "\n";
		}
	}
	
	public function paseUrl() {
		global $bw;
		if ($_SESSION ['pageSearch'])
			$arr = explode ( "/", $_SESSION ['pageSearch'] );
		foreach ( $arr as $key => $val )
			$bw->input [$key] = $val;
		$bw->input ['ajax'] = 0;
		//        $bw->input = array_merge($bw->input,$arr);
		

		return $this->searchValue ();
	}
	
	public function searchValue() {
		global $bw, $vsStd, $vsSettings, $vsUser, $vsLang, $DB;
		
		$datetime = new VSFDateTime ();
		
		if ($bw->input [2])
			$bw->input ['searchId'] = $bw->input [2];
		if ($bw->input [3])
			$bw->input ['searchTitle'] = $bw->input [3];
		if ($bw->input [4])
			$bw->input ['startDate'] = $datetime->getDate ( $bw->input [4], 'SHORT' );
		if ($bw->input [5])
			$bw->input ['endDate'] = $datetime->getDate ( $bw->input [5], 'SHORT' );
		if ($bw->input [6])
			$bw->input ['searchStatus'] = $bw->input [6];
		if ($bw->input [7])
			$bw->input ['searchCate'] = $bw->input [7];
		$arr = $this->module->getJsonPermission ( 'travels' );
		$arrkey = array ();
		
		if (! $arr ['read']) {
			$option ['message'] = $vsLang->getWords ( 'permission_deny', 'Permission deny!Contact administrator' );
			return $this->output = $this->html->objListHtml ( array (), $option );
		}
		//		if($bw->input['pageIndex'])	$bw->input[3] = $bw->input['pageIndex'];
		$categories = $this->module->getCategories ();
		$strIds = implode ( ",", $arr ['read'] );
		//		if(!$strIds){
		//			$option['message'] = $vsLang->getWords ( 'permission_deny', 'Permission deny!Contact administrator' );
		//			return $this->output = $this->html->objListHtml(array(), $option);
		//		}else{
		//                    $cond  = $this->module->getCategoryField().' in ('. $strIds. ')';
		//
		//		}
		if ($bw->input ['searchCate']) {
			$cond .= "travelCatId = {$bw->input['searchCate']} ";
			$bw->input [7] = $bw->input ['searchCate'];
		} else {
			$bw->input [7] = 0;
			$strIds = $this->module->vsMenu->getChildrenIdInTree ( $categories );
			$cond = $this->module->getCategoryField () . ' in (' . $strIds . ')';
		}
		
		if ($bw->input ['searchId']) {
			$cond .= "and travelId = " . $bw->input ['searchId'] . " ";
			$bw->input [2] = $bw->input ['searchId'];
		} else {
			$bw->input [2] = 0;
		}
		
		if ($bw->input ['searchTitle']) {
			$title = VSFTextCode::removeAccent ( strtolower ( $bw->input ['searchTitle'] ) );
			$cond .= "and travelCleanTitle like '%" . $title . "%'";
			$bw->input [3] = $title;
		} else {
			$bw->input [3] = 0;
		}
		if ($bw->input ['startDate']) {
			$datetime = new VSFDateTime ();
			$datetimeArray = explode ( "/", $bw->input ['startDate'] );
			$datetime->day = $datetimeArray [0];
			$datetime->month = $datetimeArray [1];
			$datetime->year = $datetimeArray [2];
			$pd = $datetime->TimeToInt ();
			$cond .= "and travelPostDate > {$pd} ";
			$bw->input [4] = $pd;
		
		} else
			$bw->input [4] = 0;
		
		if ($bw->input ['endDate']) {
			$datetime = new VSFDateTime ();
			$datetimeArray = explode ( "/", $bw->input ['endDate'] );
			$datetime->day = $datetimeArray [0];
			$datetime->month = $datetimeArray [1];
			$datetime->year = $datetimeArray [2];
			$pd = $datetime->TimeToInt ();
			$cond .= "and travelPostDate < {$pd} ";
			$bw->input [5] = $pd;
		} else
			$bw->input [5] = 0;
		
		if ($bw->input ['searchStatus']) {
			$int = $bw->input ['searchStatus'] - 1;
			$gt = intval ( $int );
			$cond .= "and travelStatus = {$gt} ";
			$bw->input [6] = $bw->input ['searchStatus'];
		} else
			$bw->input [6] = 0;
		
		$this->module->setCondition ( $cond );
		
		$url = "{$bw->input[0]}/search/{$bw->input[2]}/{$bw->input[3]}/{$bw->input[4]}/{$bw->input[5]}/{$bw->input[6]}/{$bw->input[7]}";
		if (! $bw->input [8])
			$bw->input [8] = $_SESSION ['pagepaging'];
		$option = $this->module->getPageList ( $url, 8, 10, 1, 'content_search' );
		
		$_SESSION ['pageSearch'] = $url;
		$_SESSION ['pagepaging'] = $bw->input [8];
		$delet = array ();
		if ($option ['pageList'])
			foreach ( $option ['pageList'] as $obj )
				if (in_array ( $obj->getCatId (), $arr ['delete'] ))
					$delet [$obj->getId ()] = $obj->getId ();
		
		//		$option['delete'] = json_encode($delet);
		$option ['message'] = $message;
		$option ['categoryId'] = $catId;
		
		return $this->output = $this->html->getHtmlFullSearch ( $option ['pageList'], $option );
	}
	
	public function createRSS($idCate = "") {
		global $bw;
		return $this->module->createRSS ( $idCate );
	}
	function deleteObj($ids, $cate = 0) {
		global $bw;
		
		$this->module->setCondition ( "travelId IN (" . $ids . ")" );
		$list = $this->module->getObjectsByCondition ();
		if (! count ( $list ))
			return false;
		
		$this->module->setCondition ( "travelId IN (" . $ids . ")" );
		if (! $this->module->deleteObjectByCondition ())
			return false;
		foreach ( $list as $travel )
			$this->module->vsFile->deleteFile ( $travel->getImage () );
		
		return $this->output = $this->getObjList ( $cate );
	}
	function checkShowAll($val = 0) {
		global $bw;
		
		$this->module->setCondition ( "travelId in ({$bw->input[2]})" );
		$this->module->updateObjectByCondition ( array ('travelStatus' => $val ) );
		return $this->output = $this->getObjList ( $bw->input [3] );
	
	}
	
	function displayObjTab() {
		$option ['categoryList'] = $this->getCategoryBox ();
		$option ['objList'] = $this->getObjList ();
		$this->output = $this->html->displayObjTab ( $option );
	}
	function getObjList($catId = '', $message = "") {
		global $bw, $vsStd, $vsSettings;
		if ($bw->input ['pageCate']) {
			$catId = $bw->input ['pageCate'];
			$bw->input [2] = $bw->input ['pageCate'];
		}
		if ($bw->input ['pageIndex'])
			$bw->input [3] = $bw->input ['pageIndex'];
		$catId = intval ( $catId );
		$categories = $this->module->getCategories ();
		// Check if the catIds is specified
		// If not just get all product
		if (! intval ( $catId )) {
			$strIds = $this->module->vsMenu->getChildrenIdInTree ( $categories );
		} else {
			$result = $this->module->vsMenu->extractNodeInTree ( $catId, $categories->getChildren () );
			if ($result)
				$strIds = trim ( $catId . "," . $this->module->vsMenu->getChildrenIdInTree ( $result ['category'] ), "," );
		}
		
		// Set the condition to get all product in specified category and its chidlren
		if ($strIds)
			$this->module->setCondition ( $this->module->getCategoryField () . ' in (' . $strIds . ')' );
		
		$size = $vsSettings->getSystemKey ( "admin_{$bw->input[0]}_list_number", 10 );
		
		$option = $this->module->getPageList ( "{$bw->input[0]}/display-obj-list/{$catId}", 3, 10, 1, 'obj-panel' );
		$option ['message'] = $message;
		$option ['categoryId'] = $catId;
		return $this->output = $this->html->objListHtml ( $this->module->getArrayObj (), $option );
	}
	//	function getObjList($catId='', $message=""){
	//		global $bw, $vsStd ,$vsSettings,$vsUser,$vsLang;
	//
	//                if($_SESSION['pageSearch'] && $bw->input['ajax']==1)
	//                        return $this->paseUrl();
	//		$arr = $this->module->getJsonPermission('travel');
	////		if(!$arr['read']){
	////			$option['message'] = $vsLang->getWords ( 'permission_deny', 'Permission deny!Contact administrator' );
	////			return $this->output = $this->html->objListHtml(array(), $option);
	////		}
	//
	//
	//		if($bw->input['pageCate'])	{
	//			$catId = $bw->input['pageCate'];
	//			$bw->input[2] = $bw->input['pageCate'];
	//		}
	//		if($bw->input['pageIndex'])	$bw->input[3] = $bw->input['pageIndex'];
	//		$catId = intval($catId);
	//		$categories = $this->module->getCategories();
	//		// Check if the catIds is specified
	//		// If not just get all product
	//		if(!intval($catId)){
	////			$strIds = implode(",", $arr['read']);
	//			$strIds = $this->module->vsMenu->getChildrenIdInTree( $categories);
	//		}else{
	//			$result = $this->module->vsMenu->extractNodeInTree($catId, $categories->getChildren());
	//			if($result){
	//				if($result['category']->getChildren()){
	//					$arrkey = array_keys($result['category']->getChildren());
	//				}
	//				$arrkey[] = $result['category']->getId();
	//				foreach ($arrkey as $key => $val)
	//				if(!in_array($val, $arr['read']))
	//					unset($arrkey[$key]);
	//			}
	//			if($arrkey)
	//			$strIds = implode(",", $arrkey);
	//		}
	//		if(!$strIds){
	//			$option['message'] = $vsLang->getWords ( 'permission_deny', 'Permission deny!Contact administrator' );
	//			return $this->output = $this->html->objListHtml(array(), $option);
	//		}else{
	//			$this->module->setCondition($this->module->getCategoryField().' in ('. $strIds. ')');
	//		}
	//
	//		$size = $vsSettings->getSystemKey("admin_{$bw->input[0]}_list_number",10);
	//
	//		$option=$this->module->getPageList("{$bw->input[0]}/display-obj-list/{$catId}", 3,$size,1,'obj-panel');
	//
	//		$delet = array();
	//		if($option['pageList'])
	//			foreach($option['pageList'] as $obj)
	//				if(in_array($obj->getCatId(), $arr['delete']))
	//					$delet[$obj->getId()] = $obj->getId();
	//
	//		$option['delete'] = json_encode($delet);
	//
	//		$option['message'] = $message;
	//		$option['categoryId'] = $catId;
	//
	//		return $this->output = $this->html->objListHtml($option['pageList'], $option);
	//	}
	

	function addEditObjForm($objId = 0, $option = array()) {
		global $vsLang, $vsStd, $bw, $vsSettings, $vsPrint;
		$obj = $this->module->createBasicObject ();
		$option ['formSubmit'] = $vsLang->getWords ( 'obj_EditObjFormButton_Add', 'Add' );
		$option ['formTitle'] = $vsLang->getWords ( 'obj_EditObjFormTitile_Add', "Add {$bw->input[0]}" );
		
		if ($objId) {
			$option ['formSubmit'] = $vsLang->getWords ( 'obj_EditObjFormButton_Edit', 'Edit' );
			$option ['formTitle'] = $vsLang->getWords ( 'obj_EditObjFormTitile_Edit', "Edit {$bw->input[0]}" );
			$obj = $this->module->getObjectById ( $objId );
			$option ['categoryId'] = $obj->getCategory ();
		}
		$vsPrint->addJavaScriptFile ( "tiny_mce/tiny_mce" );
		$vsStd->requireFile ( JAVASCRIPT_PATH . "/tiny_mce/tinyMCE.php" );
		$editor = new tinyMCE ();
		
		if ($vsSettings->getSystemKey ( $bw->input ['module'] . '_intro_editor', 0, $bw->input ['module'] )) {
			$editor->setWidth ( '100%' );
			$editor->setHeight ( '150px' );
			$editor->setToolbar ( 'narrow' );
			$editor->setTheme ( "advanced" );
			$editor->setInstanceName ( 'travelIntro' );
			$editor->setValue ( $obj->getIntro () );
			$obj->setIntro ( $editor->createHtml () );
		} else
			$obj->setIntro ( "<textarea name='travelIntro' style='width:100%;height:100px;'>" . strip_tags ( $obj->getIntro () ) . "</textarea>" );
		$editor->setWidth ( '100%' );
		$editor->setHeight ( '350px' );
		$editor->setToolbar ( 'full' );
		$editor->setTheme ( "advanced" );
		$editor->setInstanceName ( 'travelContent' );
		$editor->setValue ( $obj->getContent () );
		$obj->setContent ( $editor->createHtml () );
		
		return $this->output = $this->html->addEditObjForm ( $obj, $option );
	}
	
	function addEditObjProcess() {
		global $bw, $vsStd, $vsLang, $vsSettings;
		
		$bw->input ['travelPostDate'] = time ();
		$bw->input ['travelStatus'] = $bw->input ['travelStatus'] ? $bw->input ['travelStatus'] : 0;
		
		if (! $bw->input ['travelCatId'])
			$bw->input ['travelCatId'] = $this->module->getCategories ()->getId ();
		
		if ($bw->input ['fileImageId'])
			$bw->input ['travelImage'] = $bw->input ['fileImageId'];
		
		elseif ($bw->input ['txtlink'])
			$bw->input ['travelImage'] = $this->module->vsFile->copyFile ( $bw->input ['txtlink'], $bw->input [0] );
		
		if ($bw->input ['travelId']) {
			$obj = $this->module->getObjectById ( $bw->input ['travelId'] );
			
			if (! $obj)
				$this->alertMessage ();
			
			if ($bw->input ['deleteImage']) {
				$imageOld = $obj->getImage ();
				if ($imageOld)
					$this->module->vsFile->deleteFile ( $imageOld );
				if (! $bw->input ['travelImage'])
					$bw->input ['travelImage'] = 0;
			}
			$objUpdate = $this->module->createBasicObject ();
			$objUpdate->convertToObject ( $bw->input );
			$this->module->updateObjectById ( $objUpdate );
			if ($this->module->result ['status']) {
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
			$this->module->obj->convertToObject ( $bw->input );
			
			$this->module->insertObject ();
			if ($this->module->result ['status']) {
				$confirmContent = $vsLang->getWords ( 'pages_addPageItem_Successful', 'you have successfully add a page!' ) . '\n' . $vsLang->getWords ( 'pages_addPageItem_AddMore', 'Do you want to add another page?' );
				$javascript = <<<EOF
					<script type='text/javascript'>
						jConfirm(
							"{$confirmContent}",
							'{$bw->vars['global_websitename']} Dialog',
							function(r){
								if(r){
									vsf.get("{$bw->input[0]}/add-edit-obj-form/&pagingPage={$bw->input['pagingPage']}&pageCate={$bw->input['pageCate']}&skey={$bw->input['skey']}",'obj-panel');
								}
							}
						);
					</script>
EOF;
			}
		}
		
		if ($vsSettings->getSystemKey ( $bw->input [0] . "_multi_file", 1 )) {
			$vsStd->requireFile ( LIBS_PATH . "Relationship.class.php" );
			$rel = new VSFRelationship ();
			$rel->setObjectId ( $this->module->obj->getId () );
			$rel->setRelId ( $bw->input ['fileImageId'] );
			$rel->setTableName ( $this->module->getRelTableName () );
			$rel->insertRel ();
		}
		$cat = $bw->input ['pageCate'] ? $bw->input ['pageCate'] : $bw->input ['pageCatId'];
		$url = $bw->input [0] . '/display-obj-list/' . $cat;
		return $this->output = $javascript . $this->getObjList ( $cat );
	
		//		$this->alertMessage();
	}
	
	//	function alertMessage() {
	//		global $bw ;
	//
	//		print 	"<script>
	//					vsf.alert(\"{$this->module->result['message']}\");
	//					vsf.get('{$bw->input[0]}/display-obj-list/{$bw->input['pageCate']}/{$bw->input['pageIndex']}', 'obj-panel')
	//			</script>";
	//		return true;
	//	}
	

	function getCategoryBox($message = "") {
		global $bw, $vsMenu;
		
		$data ['message'] = $message;
		
		$option = array ('listStyle' => "| - -", 'id' => 'obj-category', 'size' => 10 );
		$menu = new Menu ();
		$menu = $this->module->getCategories ();
		$data ['html'] = $vsMenu->displaySelectBox ( $menu->getChildren (), $option );
		//		$data['permit'] = $permit->getArrPermit(1,"travel");
		//		$data['abc'] =  json_encode($data['permit']);
		$list = $this->module->getJsonPermission ( 'travels' );
		$data ['abc'] = json_encode ( $list );
		return $this->html->categoryList ( $data );
	}
	
	function loadDefault() {
		global $vsPrint;
		$_SESSION ['pageSearch'] = "";
		$vsPrint->addJavaScriptFile ( "tiny_mce/tiny_mce" );
		
		$vsPrint->addJavaScriptString ( 'init_tab', '
			$(document).ready(function(){
    			$("#page_tabs").tabs({
    				cache: false
    			});
  			});
		' );
		
		$this->setOutput ( $this->html->managerObjHtml () );
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
?>