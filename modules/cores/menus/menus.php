<?php
require_once (CORE_PATH . "/menus/Menu.class.php");
class menus extends VSFObject {
	public $arrayTreeMenu = array ();
	public $arrayMenu = array ();
	public $arrayTreeCategory = array ();
	public $arrayCategory = array ();
	public $arraySelected = array ();
	public $obj;
	public $filtercondition = array ();
	public $objsource = "menu";
	public $result = array ();
	public $displayType = "text";

	function __construct() {
		parent::__construct ();
		$this->primaryField = 'menuId';
		$this->basicClassName = 'Menu';
		$this->tableName = 'menu';
		$this->createBasicObject ();
		$this->getAllMenu ();
	}

	function __destruct() {
		unset ( $this->arrayTreeMenu );
	}

	function copyArrayTreeMenu() {
		return $this->arrayTreeMenu;
	}

	function getImgeOfMenu($key = '', $group = "") {
		if ($key) {
			$menu = $this->getCategoryGroup ( $key );
			
			$strids = $this->getChildrenIdInTree ( $menu );
			$this->setFieldsString ( "menuId, vsf_file.*" );
			$this->setTableName ( "menu LEFT JOIN vsf_file ON menuFileId = fileId" );
			$this->setCondition ( "menuId in ({$strids}) and fileId > 0 " );
			$listImg = $this->getArrayByCondition ( 1, 1 );
			$menua = $this->converFileObj ( $menu, $listImg );
			return $menua;
		}
		return "";
	}

	function converFileObj(&$menu, $listImg = array()) {
		if ($listImg [$menu->getId ()]) {
			$menu->convertToObject ( $listImg [$menu->getId ()] );
		}
		if ($menu->getChildren ()) {
			foreach ( $menu->getChildren () as $cr )
				$cr = $this->converFileObj ( $cr, $listImg );
		}
		return $menu;
	}

	/**
	 *
	 * @return Menu
	 */
	function getCategoryById($categoryId = 0) {
		$this->result ['status'] = true;
		$categoryId = intval ( $categoryId ) ? $categoryId : 0;
		
		if (! isset ( $this->arrayCategory [$categoryId] )) {
			$this->result ['status'] = false;
			$this->result ['message'] = "There is no item with specified ID!";
			return;
		}
		return $this->basicObject = $this->arrayCategory [$categoryId];
	}

	function getMenuById($objId) {
		$this->result ['status'] = true;
		$objId = intval ( $objId ) ? $objId : 0;
		if (! isset ( $this->arrayMenu [$objId] )) {
			$this->result ['status'] = false;
			$this->result ['message'] = "There is no item with specified ID!";
			return false;
		}
		
		return $this->basicObject = $this->arrayMenu [$objId];
	}


	function addEditCategory() {
		global $bw, $vsSettings;
		
		$categoryObj = new Menu ();
		$categoryObj->setTitle ( $bw->input ['categoryName'] );
		$categoryObj->setStatus ( $bw->input ['categoryStatus'] );
		$categoryObj->setType ( 0 );
		isset ( $bw->input ['categoryDesc'] ) ? $categoryObj->setAlt ( $bw->input ['categoryDesc'] ) : '';
		
		$categoryObj->setStatus ( $bw->input ['categoryIsVisible'] );
		
		if ($vsSettings->getSystemKey ( $bw->input ['categoryGroup'] . '_status', 1 ) == 0)
			$categoryObj->setStatus ( 1 );
		
		if ($vsSettings->getSystemKey ( $bw->input ['categoryGroup'] . '_value', 1 ))
			$categoryObj->setIsLink ( $bw->input ['categoryValue'] );
		
		$categoryObj->setIsDropdown ( $bw->input ['categoryIsDropdown'] );
		$categoryObj->setIndex ( $bw->input ['categoryIndex'] );
		$categoryObj->setIsAdmin ( - 1 );
		if ($bw->input ['fileId'])
			$categoryObj->setFileId ( $bw->input ['fileId'] );
			
			// Set the parent Id
			// If choose root, the parent will be the root category of this module and its level is 2
		if ($bw->input ['categoryParentId'] == 0) {
			$parentCategory = $this->getCategoryGroup ( $bw->input ['categoryGroup'] );
			$categoryObj->setParentId ( $parentCategory->getId () );
			$categoryObj->setLevel ( 2 );
		} else {
			$parentCategory = $this->getCategoryById ( $bw->input ['categoryParentId'] );
			// Set the parent Id
			$categoryObj->setParentId ( $parentCategory->getId () );
			// The level of the category will be its parent's + 1
			$categoryObj->setLevel ( $parentCategory->getLevel () + 1 );
			$categoryObj->setUrl ( $parentCategory->getUrl () );
		}
		
		if (! empty ( $bw->input ['categoryId'] )) {
			$menus = $this->getCategoryById ( $bw->input ['categoryId'] );
			if ($bw->input ['fileId'])
				VSFactory::getFiles ()->deleteFile ( $menus->getFileId () );
			$categoryObj->setId ( $bw->input ['categoryId'] );
			$this->basicObject = $categoryObj;
			$this->basicObject->setUrl ( $menus->getBackup () );
			$this->basicObject->setBackup ( "" );
			$this->updateMenu ();
		} else {
			$this->basicObject = $categoryObj;
			$this->insertMenu ();
		}
		$this->getAllMenu ();
	}

	function deleteCategoryById($categoryIds = "") {
		global $DB, $bw;
		$cat = $this->getObjectById ( $categoryIds );
		if (! is_object ( $cat )) {
			$this->result ['message'] = "There is an error when deleted!";
			return $this->result ['status'] = false;
		}
		$categoryIds;
		$this->deleteObjectById ( $categoryIds );
		$this->condition = "{$this->primaryField} IN (" . $categoryIds . ")";
		VSFactory::getFiles ()->deleteFile ( $cat->getFileId () );
		if ($this->deleteObjectByCondition ()) {
			unset ( $this->arrayTreeCategory );
			unset ( $this->arrayCategory );
			$this->getAllMenu ();
			$this->buildCacheMenu ();
		}
	}

	function deleteMenuById($objId = 0) {
		global $DB;
		$cat = $this->getObjectById ( $objId );
		$this->condition = "{$this->primaryField} IN (" . $objId . ")";
		$this->deleteObjectByCondition ();
		VSFactory::getFiles ()->deleteFile ( $cat->getFileId () );
	}

	function changeIndex($arrayCat = null, $property = "id") {
		if (! $arrayCat && count ( $arrayCat ))
			return;
		$array = array ();
		foreach ( $arrayCat as $cat )
			$array [$cat->$property] = $cat;
		return $array;
	}

	function updateMenu() {
		global $DB;
		
		$this->basicObject->setLangId ( $_SESSION [APPLICATION_TYPE] ['language'] ['vsfcurrentLang'] ['id'] );
		$this->updateObjectById ( $this->basicObject );
	}

	function insertMenu() {
		global $DB;
		$this->basicObject->setLangId ( $_SESSION [APPLICATION_TYPE] ['language'] ['vsfcurrentLang'] ['id'] );
		$this->insertObject ( $this->basicObject );
	}

	function getCategoryGroup($categoryGroup = '', $extent = array(), $langId = 0) {
		global $vsStd;
		$this->tableName = "menu";
		if (! $categoryGroup)
			return false;
		if (count ( $this->arrayTreeCategory ) < 1)
			return false;
		$this->createBasicObject ();
		$this->basicObject->setUrl ( $categoryGroup );
		
		reset ( $this->arrayTreeCategory );
		$categories = $this->arrayTreeCategory [18];
		$listChildren = $categories->getChildren ();
		if (! in_array ( $categoryGroup, array ("settings" ) )) {
			if (! $langId)
				$this->basicObject->setLangId ( $_SESSION [APPLICATION_TYPE] ['language'] ['vsfcurrentLang'] ['id'] );
			else
				$this->basicObject->setLangId ( $langId );
			$option = array ('url' => true, 'langId' => true );
			
			if(APPLICATION_TYPE=="user") $extent = array_merge($extent,array('status'=>array(true,array(1,2)))); 
				
			unset ( $listChildren [14] );
		} else {
			$option = array ('url' => true );
		}
		
		if ($extent) {
			$option = array_merge ( $option, $extent );
			$result = $this->filterMenu ( $option, $listChildren );
		}
		else
			$result = $this->filterMenu ( $option, $listChildren,1 );
		reset ( $result );
		$thisCategory = current ( $result );
		if ($extent ['no-create'])
			return $thisCategory;
		
		if (! is_object ( $thisCategory )) {
			$this->setCondition ( "langId =" . $this->basicObject->langId . " and menuIsAdmin=-1 and menuUrl = '{$this->basicObject->url}' and parentId = 18 " );
			$thisCategory = $this->getOneObjectsByCondition ();
			if (! is_object ( $thisCategory ))
				$thisCategory = $this->createRootCategory ( $categoryGroup );
		}
		return $thisCategory;
	}

	function getListGroup() {
		global $vsStd;
		
		$this->tableName = "menu";
		if (count ( $this->arrayTreeCategory ) < 1)
			return false;
		$this->createBasicObject ();
		// $this->basicObject->setUrl ( $categoryGroup );
		
		reset ( $this->arrayTreeCategory );
		$categories = $this->arrayTreeCategory [18];
		$listChildren = $categories->getChildren ();
		$this->basicObject->setLangId ( $_SESSION [APPLICATION_TYPE] ['language'] ['vsfcurrentLang'] ['id'] );
		$option = array ('langId' => true, 'children' => false );
		$result = $this->filterMenu ( $option, $listChildren, 1 );
		reset ( $result );
		foreach ( $result as $obj )
			$rs [$obj->getTitle ()] = $obj;
		return $rs;
	}

	function getSubCategory($categoryGroup = '') {
		$query = explode ( '/', $categoryGroup );
		$categoryGroup = $query [0];
		return $this->getCategoryGroup ( $categoryGroup, array ('no-create' => 1 ) );
	}

	public function createRootCategory($categoryGroup = "") {
		$this->basicObject->__destruct ();
		$this->basicObject->setTitle ( $categoryGroup );
		$this->basicObject->setUrl ( $categoryGroup ); // Category url will be the modules url
		$this->basicObject->setType ( 0 ); // Menu type of category is internal
		$this->basicObject->setAlt ( '' );
		$this->basicObject->setStatus ( 1 );
		$this->basicObject->setIsDropdown ( 1 );
		$this->basicObject->setIndex ( 0 );
		$this->basicObject->setIsLink ( 1 );
		$this->basicObject->setIsAdmin ( - 1 ); // Category will have menu type -1
		$this->basicObject->setParentId ( 18 );
		$this->basicObject->setLevel ( 1 );
		$this->insertMenu ();
		return $this->basicObject;
	}

	function getAllMenu($user = 'admin') {
		global $bw;
		
		$query = array ('select' => '*', 'from' => $this->objsource, 'order' => 'menuLevel DESC, menuIndex' );
		
		if (APPLICATION_TYPE == 'user' || $user == 'user') {
			$query ['where'] = "menuIsAdmin<>1 AND menuStatus=1";
			$arrayTreeMenu = array ();
			$arrayMenu = array ();
			$arrayTreeCategory = array ();
			$arrayCategory = array ();
			if (file_exists ( CACHE_PATH . "menus.cache" )) {
				require_once (CACHE_PATH . "menus.cache");
				$this->arrayTreeMenu = $arrayTreeMenu;
				$this->arrayMenu = $arrayMenu;
				$this->arrayTreeCategory = $arrayTreeCategory;
				$this->arrayCategory = $arrayCategory;
				unset ( $arrayTreeMenu );
				unset ( $arrayMenu );
				unset ( $arrayTreeCategory );
				unset ( $arrayCategory );
				return;
			}
		}
		VSFactory::createConnectionDB ()->simple_construct ( $query );
		VSFactory::createConnectionDB ()->simple_exec ();
		
		while ( $obj = VSFactory::createConnectionDB ()->fetch_row () ) {
			$createMenu = new Menu ();
			$createMenu->convertToObject ( $obj );
			// If element is Category type, put them in array of Category
			if ($createMenu->getIsAdmin () == - 1) {
				$this->arrayCategory [$createMenu->getId ()] = $createMenu;
				$createMenu = new Menu ();
				$createMenu->convertToObject ( $obj );
				$this->arrayTreeCategory [$createMenu->getId ()] = $createMenu;
			} else {
				$this->arrayMenu [$createMenu->getId ()] = $createMenu;
				$createMenu = new Menu ();
				$createMenu->convertToObject ( $obj );
				$this->arrayTreeMenu [$createMenu->getId ()] = $createMenu;
			}
			unset ( $createMenu );
		}
		
		// build tree structure for menus
		$this->buildTreeStructure ( $this->arrayTreeMenu );
		// build tree structure for category
		$this->buildTreeStructure ( $this->arrayTreeCategory );
		$this->buildCacheMenu ();
	}

	function buildTreeStructure(&$array = array()) {
		foreach ( $array as $element ) {
			if ($element->getLevel ()) {
				if (isset ( $array [$element->getParentId ()] )) {
					$array [$element->getParentId ()]->setChild ( $element );
					unset ( $array [$element->getId ()] );
				}
			}
		}
	}

	/**
	 * Filter array tree menu
	 * 
	 * @param array $properties
	 *        	(property_name => true/false)
	 * @param array $objs
	 *        	array of tree menu
	 * @param int $recursiveLevel
	 *        	for limit the recursive loop
	 * @return array $objs that have filtered
	 */
	function filterMenu($properties = array(), $objs, $recursiveLevel = 0, $currentLevel = 0) {
		$currentLevel ++;
		if ($recursiveLevel >= 1 && $recursiveLevel < $currentLevel)
			return;
		foreach ( $properties as $property => $value ) {
			foreach ( $objs as $obj ) {
				if (! isset ( $obj->$property ))
					continue;
				
				if (is_bool ( $value )) {
					$this->boolFilter ( $value, $property, $properties, $obj, $objs, $recursiveLevel, $currentLevel );
				} else {
					$this->arrayFilter ( $value, $property, $properties, $obj, $objs, $recursiveLevel, $currentLevel );
				}
			}
		}
		return $objs;
	}

	/**
	 */
	function filterMenuPermission(&$menusar = array()) {
		foreach ( $menusar as $index => $mn ) {
			if (! VSFactory::getAdmins ()->basicObject->checkPermission ( 'menu_show_' . $mn->getId () )) {
				unset ( $menusar [$index] );
			} else {
				$this->filterMenuPermission ( $mn->children );
			}
		}
	}

	function getAdminMenu() {
		static $adminmenu = NULL;
		$arrays=$this->arrayTreeMenu;
		if ($adminmenu === NULL) {
			if (VSFactory::getSettings ()->getSystemKey ( 'admin_multi_lang', 0, 'global', 1, 1 )) {
				VSFactory::getMenus()->basicObject->setLangId ( $_SESSION [APPLICATION_TYPE] ['language'] ['vsfcurrentLang'] ['id'] );
				$adminmenu = $this->filterMenu ( array ('isAdmin' => true, 'langId' => true, 'status' => true, 'position' => true ), $arrays );
			} else
				$adminmenu = $this->filterMenu ( array ('isAdmin' => true, 'status' => true, 'position' => true ), $arrays );
		}
		return $adminmenu;
	}

	function arrayFilter($value, &$property, $properties, $obj, &$objs, $recursiveLevel, $currentLevel) {
		if ($value [0]) {
			if (! in_array ( $obj->$property, $value [1] )) {
				unset ( $objs [$obj->id] );
			} elseif (count ( $obj->getChildren () )) {
				$this->filterMenu ( $properties, $objs [$obj->getId ()]->children, $recursiveLevel, $currentLevel );
			}
		} else {
			if (in_array ( $obj->$property, $value [1] )) {
				unset ( $objs [$obj->id] );
			} elseif (count ( $obj->getChildren () )) {
				$this->filterMenu ( $properties, $objs [$obj->getId ()]->children, $recursiveLevel, $currentLevel );
			}
		}
	}

	function boolFilter($value, $property, $properties, $obj, &$objs, $recursiveLevel, $currentLevel) {
		if ($value) {
			if ($obj->$property != $this->basicObject->$property)
				unset ( $objs [$obj->id] );
			elseif (count ( $obj->getChildren () )) {
				$this->filterMenu ( $properties, $objs [$obj->getId ()]->children, $recursiveLevel, $currentLevel );
			}
		} else {
			if ($obj->$property == $this->basicObject->$property)
				unset ( $objs [$obj->id] );
			elseif (count ( $obj->getChildren () )) {
				$this->filterMenu ( $properties, $objs [$obj->getId ()]->children, $recursiveLevel, $currentLevel );
			}
		}
	}

	function buildOptionMenuTree($oMenus = array(), &$html = "", $option = array(), $count = 0, $pr = 0) {
		if (! is_array ( $oMenus ))
			return;
		if ($count > 0)
			$option ['listStyle'] = " &nbsp; &nbsp; &nbsp;" . $option ['listStyle'];
		
		foreach ( $oMenus as $oMenu ) {
			$selected = "";
			if (isset ( $option ['selected'] ) && $oMenu->id == $option ['selected'])
				$selected = "selected='selected' ";
			if ($option ['index'])
				$html .= '<option ' . $selected . 'value="' . $oMenu->id . '" class="parent' . $pr . '" >' . $option ['listStyle'] . ' ' . $oMenu->title . ' (' . $oMenu->getIndex () . ' - ' . $oMenu->id . ')</option>';
			else
				$html .= '<option ' . $selected . 'value="' . $oMenu->id . '" class="parent' . $pr . '" >' . $option ['listStyle'] . ' ' . $oMenu->title . ' (' . $oMenu->getIndex () . ' - ' . $oMenu->id . ')</option>';
			
			if (is_array ( $oMenu->getChildren () )) {
				$count ++;
				$this->buildOptionMenuTree ( $oMenu->getChildren (), $html, $option, $count, $oMenu->getId () );
			}
		}
	}

	/**
	 * Build select box html by BabyWolf
	 * 
	 * @param array $objs
	 *        	of Menu object
	 * @param array $option[id,size,class,multiple,listStyle]
	 *        	for select tag
	 * @return $html of select box
	 */
	function displaySelectBox($objs = array(), $option = array()) {
		$rootId = 0;
		if ($option ['rootId'])
			$rootId = $option ['rootId'];
			
			// Build select tag
		$html = '<select id="' . $option ['id'] . '" style="width:100%;height:370px"';
		$html .= $option ['size'] ? ' size="' . $option ['size'] . '"' : '';
		$html .= $option ['class'] ? ' class="' . $option ['class'] . '"' : '';
		$html .= $option ['multiple'] ? ' multiple' : '';
		$html .= $option ['name'] ? ' name="' . $option ['name'] . '"' : '';
		$html .= $option ['onclick'] ? ' onclick="' . $option ['onclick'] . '()"' : '';
		$html .= '><option value="' . $rootId . '">' . VSFactory::getLangs ()->getWords ( 'menus_option_root', "Root" ) . '</option>';
		isset ( $option ['index'] ) ? "" : $option ['index'] = 1;
		$this->buildOptionMenuTree ( $objs, $html, $option );
		$html .= "</select>";
		return $html;
	}

	function getMenuForUser() {
		$this->basicObject->setLangId ( VSFactory::getLangs ()->currentLang->getId () );
		$this->basicObject->setIsAdmin ( 0 );
		$this->basicObject->setStatus ( 1 );
		$this->basicObject->setTitle ( 'Categories' );
		$result = $this->filterMenu ( array ('isAdmin' => true, 'langId' => true, 'status' => true, 'title' => false ), $this->arrayTreeMenu, 1 );
		
		$this->basicObject->__destruct ();
		
		return $result;
	}

	/**
	 * extract a branch from a tree structure of category
	 * 
	 * @author BabyWolf
	 * @param interger $categoryId
	 *        	the id of the node you want to extract
	 * @param $categories tree
	 *        	structure of category objects
	 * @return $result[category,ids] list of path from root and tree category structure
	 */
	function extractNodeInTree($categoryId = 0, $categories = array()) {
		foreach ( $categories as $category ) {
			if ($category->getId () == $categoryId) {
				$result ['ids'] [] = $category->getId ();
				$result ['category'] = $category;
				return $result;
			}
			if (count ( $category->getChildren () ) > 0) {
				$result = $this->extractNodeInTree ( $categoryId, $category->getChildren () );
				
				if (is_object ( $result ['category'] )) {
					$result ['ids'] [] = $category->getId ();
					return $result;
				}
			}
		}
		return false;
	}
	

	function getUtilitys($categoryId = 0) {
		$obj = $this->getCategoryById ( $categoryId );
		if (! $obj)
			return false;
		return $obj->getUtilitys ();
	}

	function getChildrenIdInTree($category) {
		if (! is_object ( $category )) {
			$arraycate = $this->extractNodeInTree ( $category, $this->arrayTreeCategory );
			
			$category = $arraycate ['category'];
		}
		if (! is_object ( $category ))
			return;
		$strIds = $category->getId ();
		if ($category->getChildren ()) {
			$arrayIds = array_keys ( $category->getChildren () );
			$arrayIds ? $strIds .= ',' . implode ( ",", $arrayIds ) : $strIds .= implode ( ",", $arrayIds );
			foreach ( $category->getChildren () as $thisCategory ) {
				if (count ( $thisCategory->getChildren () ))
					$strIds .= "," . $this->getChildrenIdInTree ( $thisCategory );
			}
		}
		return $strIds;
	}

	function buildCacheMenu() {
		// Only build cache for user menus
		
		
		$arrayTreeMenu = $this->filterMenu ( array ('status', 'isAdmin' => array (true, array (0, - 1 ) ) ), $this->arrayTreeMenu );
		$arrayMenu = $this->filterMenu ( array ('status', 'isAdmin' => array (true, array (0, - 1 ) ) ), $this->arrayMenu );
		$arrayTreeCategory = $this->filterMenu ( array ('status', 'isAdmin' => array (true, array (0, - 1 ) ) ), $this->arrayTreeCategory );
		$arrayCategory = $this->filterMenu ( array ('status', 'isAdmin' => array (true, array (0, - 1 ) ) ), $this->arrayCategory );
//		echo "<pre>";
//				print_r($arrayTreeMenu);
//				echo "</pre>";
//				exit;
		$cache_content = "<?php\n";
		$cache_content .= "\$arrayTreeMenu = " . var_export ( $arrayTreeMenu, true ) . ";\n";
		$cache_content .= "\$arrayMenu = " . var_export ( $arrayMenu, true ) . ";\n";
		$cache_content .= "\$arrayTreeCategory = " . var_export ( $arrayTreeCategory, true ) . ";\n";
		$cache_content .= "\$arrayCategory = " . var_export ( $arrayCategory, true ) . ";\n";
		$cache_content .= "?>";
		$cache_path = CACHE_PATH . "menus.cache";
		$cache_content = preg_replace ( '/\s\s+/', '', $cache_content );
		$file = fopen ( $cache_path, "w" );
		fwrite ( $file, $cache_content );
		fclose ( $file );
	}

	function updateURL($url = "", $menuIds = "") {
		$arrayId = explode ( ',', $menuIds );
		$trueIds = '-11';
		foreach ( $arrayId as $value ) {
			$arrMenu [$value] = $this->arrayCategory [$value];
			if (! is_object ( $arrMenu [$value] ))
				$arrMenu [$value] = $this->arrayMenu [$value];
			if ($arrMenu [$value]->getBackup ())
				$error .= "{$arrMenu[$value]->getTitle()}, ";
			else {
				$trueIds .= ", " . $value;
				$success .= "{$arrMenu[$value]->getTitle()}, ";
			}
			$success = substr ( $success, 0, - 2 );
			$error = substr ( $error, 0, - 2 );
		}
		if ($error || $success) {
			
			$message = $success ? "cập nhật Link Thành công Menu [ {$success} ] " : "";
			$message .= $error ? " Chú ý Menu [ {$error} ] đã được cập nhật Trước đó vui lòng vào menus khôi phục lại" : "";
			print <<<EOF
						<script type='text/javascript'>
							alert('{$message}');
						</script>
EOF;
		}
		$this->setCondition ( 'menuId in (' . $trueIds . ")" );
		$query = "UPDATE " . SQL_PREFIX . "menu SET menuBackup = menuUrl, menuUrl = '" . $url . "' WHERE menuId in (" . $trueIds . ")";
		$this->executeQuery ( $query );
		$this->getAllMenu ();
		$this->buildCacheMenu ();
	}

	function restoreURL($menuIds = "") {
		$this->setCondition ( 'menuId in (' . $menuIds . ")" );
		$query = "UPDATE " . SQL_PREFIX . "menu SET menuUrl = menuBackup WHERE menuId in (" . $menuIds . "); ";
		$query = "UPDATE " . SQL_PREFIX . "menu SET menuBackup = '' WHERE menuId in (" . $menuIds . "); ";
		$this->executeQuery ( $query );
		$this->getAllMenu ();
		$this->buildCacheMenu ();
	}

	function buildchildMenu($key = "news") {
		global $bw, $vsPrint;
		$re = "";
		
		$list = $this->getCategoryGroup ( $key );
		if ($list->getChildren ()) {
			$re = "
             <ul id='menu' class='imenu'><h3>{$vsPrint->pageTitle}</h3>";
			foreach ( $list->getChildren () as $obj ) {
				if ($obj->getChildren ()) {
					$re .= "<li><a href='{$obj->getUrlCategory()}' title='{$obj->getTitle()}'>{$obj->getTitle()}</a><ul>";
					foreach ( $obj->getChildren () as $obj1 )
						$re .= "<li><a href='{$obj1->getUrlCategory()}' title='{$obj1->getTitle()}'>{$obj1->getTitle()}</a></li>";
					$re .= "</ul></li>";
				} else
					$re .= "<li><a href='{$obj->getUrlCategory()}' title='{$obj->getTitle()}'>{$obj->getTitle()}</a></li>";
			}
			$re .= "</ul>";
		}
		
		return $re;
	}

	function getMenuByPosition($position) {
		$this->basicObject->setLangId ( VSFactory::getLangs ()->currentLang->getId () );
		$this->basicObject->setIsAdmin ( 0 );
		$this->basicObject->setStatus ( 1 );
		$this->basicObject->setPosition ( $position );
		$this->basicObject->setTitle ( 'Categories' );
		$result = $this->filterMenu ( array ('isAdmin' => true, 'langId' => true, 'status' => true, $position => true, 'title' => false ), $this->arrayTreeMenu, 1 );
		
		$this->basicObject->__destruct ();
		return $result;
	}

	function getMenuByUrl($url) {
		$this->basicObject->setLangId ( VSFactory::getLangs ()->currentLang->getId () );
		$this->basicObject->setIsAdmin ( 0 );
		$this->basicObject->setStatus ( 1 );
		$this->basicObject->setUrl ( $url );
		$this->basicObject->setTitle ( 'Categories' );
		$result = $this->filterMenu ( array ('isAdmin' => true, 'langId' => true, 'status' => true, 'url' => true, 'title' => false ), $this->arrayTreeMenu, 1 );
		
		$this->basicObject->__destruct ();
		return reset ( $result );
	}

	function getMenuByStatus($status) {
		$this->basicObject->setLangId ( VSFactory::getLangs ()->currentLang->getId () );
		$this->basicObject->setStatus ( $status );
		$result = $this->filterMenu ( array ('langId' => true, 'status' => true ), $this->arrayCategory, 1 );
		$this->basicObject->__destruct ();
		return $result;
	}

	function isParent($obj, $obj1) {
		$list = $obj->getChildren ();
		if (count ( $list )) {
			foreach ( $list as $ele ) {
				if ($ele->getId () == $obj1->getId ())
					return true;
				$this->isParent ( $ele, $obj1 );
			}
		}
		return false;
	}

	function is_contain($obj, $obj1) {
		if ($obj->getId () == $obj1->getId ())
			return true;
		$list = $obj->getChildren ();
		if (count ( $list )) {
			foreach ( $list as $ele ) {
				if ($this->is_contain ( $ele, $obj1 ))
					return true;
			}
		}
		return false;
	}

	function searchIdInTree($id, $tree) {
		if ($tree->getId () == $id)
			return $tree;
		foreach ( $tree->getChildren () as $chil ) {
			$tmp = $this->searchIdInTree ( $id, $chil );
			if ($tmp != NULL)
				return $tmp;
		}
		return NULL;
	}
}
?>
