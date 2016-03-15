<?php
/*
 +-----------------------------------------------------------------------------
 |   VIETSOL CMS version 1.0.0.0
 |	Author: BabyWolf
 |	Homepage: http://www.vietsol.net
 |	If you use this code, please don't delete these comment lines!
 |	Start Date: 10/21/2007
 |	Finish Date: 10/21/2007
 |	Modified Start Date: 10/27/2007
 |	Modified Finish Date: 10/28/2007
 |	Module Description: This module is for management all modules in system.
 +-----------------------------------------------------------------------------
 */

if ( ! defined( 'IN_VSF' ) )
{
	print "<h1>Permission denied!</h1>You cannot access this area. (VS Framework is powered by <a href=\"http://www.vietsol.net\">Viet Solution webdesign company</a>)";
	exit();
}

class menus_admin
{
	private $output		= "";
	private $html       = "";
	protected $module;
	/*-------------------------------------------------------------------------*/
	// INIT
	/*-------------------------------------------------------------------------*/

	/**
	 * @return unknown
	 */
	public function getOutput() {
		return $this->output;
	}

	/**
	 * @param unknown_type $output
	 */
	public function setOutput($output) {
		$this->output = $output;
	}
	function __construct(){
		global $bw, $vsTemplate;
		$this->module = new menus();
		$this->base_url = $bw->base_url;
		$this->html = $vsTemplate->load_template('skin_menus');
	}

	function getPermission() {
		global $vsLang;

		$vsLang->setCurrentArea('menus');

		$permission = array($vsLang->getWords('menus_perm','Menus manager permission'),
		array(
										'default'		=> $vsLang->getWords('menu_perm_global','Access menu module'),
										'buildcache'	=> $vsLang->getWords('menu_perm_cache','Build cache for menus'),
										'viewadmin'		=> $vsLang->getWords('menu_perm_viewadmin','View admin menus control'),
										'viewuser'		=> $vsLang->getWords('menu_perm_viewuser','View user menus control'),
										'getmenulist'	=> $vsLang->getWords('menu_perm_menulist','View list of menus in control'),
										'addmenuform'	=> $vsLang->getWords('menu_perm_addform','Add new menu'),
										'editmenu'		=> $vsLang->getWords('menu_perm_editform','Edit a menu'),
										'deletemenu'	=> $vsLang->getWords('menu_perm_delete','Delete a menu'),
		)
		);
		return $permission;
	}

	function auto_run()
	{
		global $bw;
		//-------------------------------------------
		// What to do?
		//-------------------------------------------
		 
		switch($bw->input[1]) {
			case 'edit-category':
					$option['cate']=$bw->input[2];
					$this->setOutput($this->addEditCategoryForm($bw->input[3],$option));
				break;

			case 'add-edit-category':
					$this->addEditCategoryProcess();
				break;

			case 'delete-category':
					$this->deleteCategory($bw->input[3]);
				break;

			case 'display-category-tab':
					$this->buildCategoryTab();
				break;

			case 'buildcache':
				$this->buildCache();
				break;

			case 'viewadmin':
				$this->viewAdminMenu();
				break;

			case 'viewuser':
				$this->viewUserMenu();
				break;
					
			case 'getmenulist':
				$this->displayMenuList();
				break;

			case 'addmenuform':
				$this->addMenuForm();
				break;

			case 'editmenu':
				$this->editMenu();
				break;

			case 'deletemenu':
				$this->RemoveMenu();
				break;

			case 'addeditmenu':
				$this->addEditMenu();
				break;

			case 'display-dialog':
				$this->displayDialog();
				break;
					
			default:
				$this->loadDefault();
				break;
		}
	}

	function displayDialog(){
		$this->module->getAllMenu('user');

		$option = array('listStyle' => "| - -",
						'id'		=> 'all-category',
						'size'		=> 18,
		);
		$this->module->buildOptionMenuTree($this->module->arrayTreeCategory, &$menulisthtml, $option);

		return $this->output = $this->html->displayDialog($menulisthtml);
	}

	function deleteCategory($categoryIds){
		global $vsLang, $vsModule, $bw;

		$flag = true;

		$categoryIdArray = explode(',', $categoryIds);
		$errorMessage = $vsLang->getWords('err_category_delete_unempty', "Here are several category cannot be deleted due to being unempty! Please delete its children first.");

		foreach($categoryIdArray as $categoryId){
			$this->module->obj->setParentId($categoryId);

			$categories = $this->module->filterMenu(array('parentId' => true), $this->module->arrayCategory);

			if(count($categories)){
				$flag = false;
				$errorMessage .="&nbsp; &nbsp;". $this->module->arrayCategory[$categoryId]->getTitle();
				unset($categoryIdArray[array_search($categoryId, $categoryIdArray)]);
			}
		}

		$categoryIds = implode(",", $categoryIdArray);

		if($flag) $errorMessage = '';
		if(!empty($categoryIds)) $this->module->deleteCategoryById($categoryIds);


		global $vsStd;
		$module = $bw->input[2];
                $modulePath = $module . "/" . $module.".php";
                if(file_exists(CORE_PATH. $modulePath)){
                    $vsStd->requireFile(CORE_PATH. $modulePath);
                    if($module == "news") $module = $module."es";
                    $model = new $module();
                    if(method_exists($model,'deleteObjInCategory'))
			$model->deleteObjInCategory($categoryIds);
                }
//		$vsStd->requireFile(CORE_PATH.$bw->input[2]."/".$bw->input[2].".php");
//		if($module == "news") $module = $module."es";
//		$model = new $module();
//
//
//		if(method_exists($model,'deleteObjInCategory'))
//			$model->deleteObjInCategory($categoryIds);
//
		$categoryGroup = $this->module->getCategoryGroup($bw->input[2]);

		$message = $this->module->result['message'].$errorMessage."<br />";
		$this->output = $this->getCategoryBox($categoryGroup, $message);
	}

	function addEditCategoryProcess() {
		global $bw,$vsSettings;
		$categoryObj = new Menu();
		$categoryObj->setTitle($bw->input['categoryName']);
		$categoryObj->setUrl($bw->input['categoryGroup']);
		$categoryObj->setType(0);

		isset($bw->input['categoryDesc'])?$categoryObj->setAlt($bw->input['categoryDesc']):'';
		$categoryObj->setStatus($bw->input['categoryIsVisible']);

		if($vsSettings->getSystemKey($bw->input['categoryGroup'].'_status',1)==0)
		$categoryObj->setStatus(1);
			
		if($vsSettings->getSystemKey($bw->input['categoryGroup'].'_value',1))
		$categoryObj->setIsLink($bw->input['categoryValue']);

		$categoryObj->setIsDropdown($bw->input['categoryIsDropdown']);
		$categoryObj->setIndex($bw->input['categoryIndex']);
		$categoryObj->setIsAdmin(-1);
		if($bw->input['fileId'])
		$categoryObj->setFileId($bw->input['fileId']);
		$lv = 2;
		// Set the parent Id
		// If choose root, the parent will be the root category of this module and its level is 2
		if($bw->input['categoryParentId']==0) {
			$parentCategory = $this->module->getCategoryGroup($bw->input['categoryGroup']);
			$categoryObj->setParentId($parentCategory->getId());
			$categoryObj->setLevel(2);
		}
		else {	
			$parentCategory = $this->module->getCategoryById($bw->input['categoryParentId']);
			//if($bw->input['categoryId']) {
//				$list  = $this->module->extractNodeInTree($bw->input['categoryId'],$this->module->arrayTreeCategory);
//				$list['category']->setParentId($parentCategory->getId());
//				$list['category']->setId($bw->input['categoryId']);
//				$this->setLevelChild($list['category'],$parentCategory->getLevel()+1);
//				$this->module->buildCacheMenu();
			//}else{
			// Set the parent Id
			$categoryObj->setParentId($parentCategory->getId());
			// The level of the category will be its parent's + 1
			$lv = $parentCategory->getLevel()+1;
			
			//}
		}
		$categoryObj->setLevel($lv);
		if($bw->input['categoryId']) {
			$menus=$this->module->getCategoryById($bw->input['categoryId']);
			if($bw->input['fileId'])
			$this->module->vsFile->deleteFile($menus->getFileId());
			$categoryObj->setId($bw->input['categoryId']);
			$this->module->obj = $categoryObj;
                       
			if($menus->getBackup()){
				$this->module->obj->setUrl($menus->getBackup());
				$this->module->obj->setBackup("");
			}
                        
//                        $this->module->updateMenu();
//                        print "<pre>";
//                        print_r( $this->module->obj);
//                        print "<pre>";
//                        exit();
			$list  = $this->module->extractNodeInTree($bw->input['categoryId'],$this->module->arrayTreeCategory);
			$list['category']->setParentId($parentCategory->getId());
			$list['category']->setId($bw->input['categoryId']);
			$this->setLevelChild($list['category'],$parentCategory->getLevel()+1);
                        
			$this->module->buildCacheMenu();
			
		}
		else {
			$this->module->obj = $categoryObj;
			$this->module->insertMenu();
		}

		if($this->pandog) return;

		$this->module->getAllMenu();

		$this->buildCache(true);

		
		$bw->input[2] = $bw->input['categoryGroup'];
		
		$message = $this->module->result['message'].$message."<br />";

		$this->buildCategoryTab();
	}
 
	function setLevelChild($object,$level){
		global $DB,$bw;
		
		$count = $level + 1;
		$object->setLevel($level);
                if(!$this->module->obj)
                    $this->module->obj = $object;
		$this->module->updateMenu();
                $this->module->obj->__destruct();
		if($object->getChildren())
		foreach( $object->getChildren() as $obj){	
			$this->setLevelChild($obj,$count);			 
		}
	}
	function checkParent($pid,$list){
		if($list->getChildren())
		foreach( $list->getChildren() as $obj){
			if($obj->getId() == $pid){
				$mess = "không được sửa";
				return $mess;
			}
			if($obj->getChildren()){
			 	foreach( $obj->getChildren() as $obj1){
				 	if($obj1->getId() == $pid){
				 		$mess = "không được sửa";
						return $mess;
					}
			 	}
			 	
			 }
			 
		}
		return;
	}
	
	
	function addEditCategoryForm($categoryId=0, $option=array()) {
		global $vsLang,$bw,$vsSettings;
		
		
		$categoryObj = new Menu();

		$option['formTitle'] = $vsLang->getWords('news_EditCategoryFormTilte_Add', 'Add Category');
		$option['formSubmit'] = $vsLang->getWords('news_EditCategoryFormButton_Add', 'Add');
		$option['parentId'] = 'parentId = $("#category-table-list option:selected").val();';

		if($categoryId && $categoryId > 0){
			$arrayCheck = array('','checked');
			$option['formTitle'] = $vsLang->getWords('news_EditCategoryFormTilte_Edit', 'Edit Category');
			$option['formSubmit'] = $vsLang->getWords('news_EditCategoryFormButton_Edit', 'Edit');
			$categoryObj = $this->module->arrayCategory[$categoryId];
			$image=$this->module->vsFile->getObjectById($categoryObj->getFileId());
				
		}

		return $this->html->addEditCategoryForm($categoryObj, $option);
	}

	function getCategoryBox($categoryGroup, $message="", $option=array()) {
		global $bw , $vsMenu;
		
		$data['message'] = $message;

		$option = array('listStyle' => "| - -",
						'id'		=> 'menus-category'.$categoryGroup->getUrl(),
						'size'		=> 18,
						'multiple'	=> true,
						'onclick'	=> "setValue_category{$categoryGroup->getUrl()}"
		);
		$data['html']= $this->module->displaySelectBox($categoryGroup->getChildren(), $option);

		return $this->html->categoryList($data,$categoryGroup);
	}

	function getSimpleListCatHtml($categoryGroup, $message="",$option=array()) {
		global $bw , $vsMenu;

		$data['message'] = $message;

		$option = array('listStyle' => "| - -",
						'id'		=> 'menus-category'.$categoryGroup->getUrl(),
						'size'		=> 18,
						'multiple'	=> true,
						'onclick'	=> "setValue_category{$categoryGroup->getUrl()}"
		);
		$data['html']= $this->module->displaySelectBox($categoryGroup->getChildren(), $option);

		return $this->html->getSimpleListCatHtml($data,$categoryGroup);
	}

	function buildCategoryTab() {
		global $vsLang, $bw;
		$option = array();
		$option['cate'] = $bw->input[2];

		$categoryGroup = $this->module->getCategoryGroup($bw->input[2]);

		$categoryTable = $this->getCategoryBox($categoryGroup);
		$categoryForm  = $this->addEditCategoryForm(0,$option);

		$this->output = $this->html->MainCategories($categoryForm, $categoryTable,$bw->input[2]);
	}

	function displayMenuList() {
		global $bw, $vsMenu;
		$filterArray = array('isAdmin'=>true,'title'=>false);
		$bw->typemenu=$bw->input[2];
		$vsMenu->obj->setIsAdmin($bw->input[2]);
		if($vsMenu->obj->getIsAdmin()!=1) {
			$vsMenu->obj->setLangId($_SESSION[APPLICATION_TYPE]['language']['currentLang']['langId']);
			$filterArray['langId'] = true;
		}
		$vsMenu->obj->setTitle('Categories');
		$menus = $vsMenu->filterMenu($filterArray,$this->module->arrayTreeMenu);

		$buildCache = $vsMenu->obj->getIsAdmin()?false:true;
		$this->output = $this->getMenuList($menus,$buildCache);
	}

	function loadDefault() {
		global $vsPrint;

		$vsPrint->addJavaScriptString('init_tab',
			'$(document).ready(function(){$("#page_tabs").tabs({fx: { opacity: "toggle" },cache: false});});'
			);

			$this->output = $this->html->MainPage();
	}

	function viewAdminMenu($message="") {
		global $vsMenu,$bw,$vsSettings;
		$bw->typemenu=1;
		$vsMenu->obj->setIsAdmin(1);
		
		if(!$vsSettings->getSystemKey('admin_multi_lang', 0,'global', 1, 1))
			$menus = $vsMenu->filterMenu(array('isAdmin'=>true),$this->module->arrayTreeMenu);
		else{
			$vsMenu->obj->setLangId($_SESSION[APPLICATION_TYPE]['language']['currentLang']['langId']);
			$menus = $vsMenu->filterMenu(array('isAdmin'=>true,'langId'=>true),$this->module->arrayTreeMenu);
		}
		$this->module->obj->setIsAdmin(1);
		$addeditmenu = $this->addEditMenuForm($message);
		$menulist = $this->getMenuList($menus,false,$message);
		$this->output = $this->html->objMain($menulist,$addeditmenu);
	}

	function viewUserMenu($message = "") {
		global $vsMenu,$bw;
		$bw->typemenu=0;
		$vsMenu->obj->setIsAdmin(0);
		$vsMenu->obj->setTitle('Categories');
		$vsMenu->obj->setLangId($_SESSION[APPLICATION_TYPE]['language']['currentLang']['langId']);

		$menus = $vsMenu->filterMenu(array('isAdmin'=>true,'title'=>false,'langId'=>true),$vsMenu->arrayTreeMenu);
		$this->module->obj->setIsAdmin(0);
		$addeditmenu = $this->addEditMenuForm($message);
		$menulist = $this->getMenuList($menus,true,$message);
			
		$this->output = $this->html->objMain($menulist,$addeditmenu);
	}

	function buildCache($flag=false) {
		global $vsMenu, $vsLang;
		$this->module->buildCacheMenu();

		if ($flag) return 1;
		$vsMenu->getAllMenu();
		$vsMenu->obj->setLangId($_SESSION[APPLICATION_TYPE]['language']['currentLang']['langId']);
		$vsMenu->obj->setIsAdmin(0);
		$vsMenu->obj->setTitle('Categories');
		$menus = $vsMenu->filterMenu(array('isAdmin'=>true,'title'=>false, 'langId'=>true),$vsMenu->arrayTreeMenu);

		$this->output = $this->getMenuList($menus,true,$vsLang->currentArrayWords['menu_cache_build_success']);
	}

	function addMenuForm() {
		global $bw,$vsMenu;

		$bw->typemenu = $bw->input[2];
		$this->output = $this->addEditMenuForm();
	}

	function getMenuList($menus=array(),$buildCache=false, $message = "") {
		global $bw;

		$menulisthtml = "<option value='0' selected>Root</option>";
		$option['listStyle'] = "| - - ";

		$this->module->buildOptionMenuTree($menus, &$menulisthtml, $option);

		$menuhtml = $this->html->objList($menulisthtml, $buildCache, $message);

		return $menuhtml;
	}

	function RemoveMenu() {
		global $bw;
		$menu = $this->module->getMenuById($bw->input[2]);
		$this->module->deleteMenuById($bw->input[2]);
		if($this->module->result['status']) {
			$this->module->arrayTreeMenu = array();
			$this->module->getAllMenu();
		}
		$this->module->obj->setTitle('Categories');
		$menus = $this->module->filterMenu(array('isAdmin'=>true,'title'=>false),$this->module->arrayTreeMenu);
		$buildCache = $this->module->obj->getIsAdmin()?false:true;
		$bw->typemenu	=	$this->module->obj->getIsAdmin();
		$this->output = $this->getMenuList($menus,$buildCache,$this->module->result['message']);
	}

	function editMenu() {
		global $bw;

		$menuId = intval($bw->input[2]);

		$this->module->obj = $this->module->getMenuById($menuId);
		$this->output = $this->addEditMenuForm('',1);
	}
	function addEditMenu() {
		global $bw, $vsMenu;
		// Get parent Menu to set level
		$parentMenu = $vsMenu->getMenuById($bw->input['parentId']);
		if($vsMenu->result['status'])
		$this->module->obj->setLevel($parentMenu->level+1);
		$bw->input['menuStatus']=$bw->input['menuStatus']?1:0;
		$bw->input['menuIsLink']=$bw->input['menuIsLink']?1:0;
		$this->module->obj->convertToObject($bw->input);
		$bw->input['menuIsDropdown']?$this->module->obj->setIsDropdown(1):$this->module->obj->setIsDropdown(0);
		if($bw->input['fileId'])
		$this->module->obj->setFileId($bw->input['fileId']);
		if($bw->input['posTop'])
		$this->module->obj->setPosition('top');
		if($bw->input['posRight'])
		$this->module->obj->setPosition('right');
		if($bw->input['posBottom'])
		$this->module->obj->setPosition('bottom');
		if($bw->input['posLeft'])
		$this->module->obj->setPosition('left');
		if($bw->input['posMain'])
		$this->module->obj->setPosition('main');

		if($bw->input['formType']) {
			$menus=$vsMenu->getMenuById($bw->input['ID']);
			if($bw->input['menuRetore'])
			{
				$this->module->obj->setUrl($menus->getBackup());
				$this->module->obj->setBackup("");
			}
			$this->module->obj->setId($bw->input['ID']);
			if($bw->input['fileId'])
			$this->module->vsFile->deleteFile($menus->getFileId());
			$this->module->updateMenu();
		}
		else
		$this->module->insertMenu();

		if($this->module->result['status']) {
			$vsMenu->getAllMenu();
		}

		$this->module->obj = $this->module->createBasicObject();
		$this->module->obj->isAdmin=$bw->input['menuIsAdmin'];
		$this->output = $this->addEditMenuForm($this->module->result['message']);
	}

	function addEditMenuForm($message = "", $formType=0) {
		global $vsLang;

		$form['type'] = $formType;
		$form['title'] = $vsLang->getWords('menu_title_add',"Add new menu");
		$form['submit'] = $vsLang->getWords('menu_bt_add',"Add");
		if($form['type']) {
			$form['title'] = $vsLang->getWords('menu_title_edit',"Edit a menu");
			$form['submit'] = $vsLang->getWords('menu_bt_edit',"Edit");
		}

		$addEditFormHTML = $this->html->addEditMenuForm($form, $message, $this->module->obj);

		return $addEditFormHTML;
	}
}
?>