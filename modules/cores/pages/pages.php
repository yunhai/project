<?php

global $vsStd;
$vsStd->requireFile ( CORE_PATH . "pages/Page.class.php" );
class pages extends VSFObject {
	public $obj;
	function __construct() {
		global $vsMenu, $vsStd, $DB, $bw;
		parent::__construct ();
		
		$this->categoryField = "pageCatId";
		$this->primaryField = "pageId";
		$this->basicClassName = "Page";
		$this->tableName = 'page';
		$this->obj = $this->createBasicObject ();
		$this->categories = $vsMenu->getCategoryGroup($bw->input['module']);
	
	}
	function __destruct() {
		unset ( $this );
	}
	
	function getMenuList() {
		global $vsMenu;
		
		$vsMenu->obj->setIsAdmin ( 0 );
		$vsMenu->obj->setLangId ( $_SESSION [APPLICATION_TYPE] ['language'] ['currentLang'] ['langId'] );
		$menus = $vsMenu->filterMenu ( array ('isAdmin' => true, 'langId' => true ), $vsMenu->arrayTreeMenu );
		
		$html = "";
		$vsMenu->buildOptionMenuTree ( $menus, &$html );
		return '<select size="10" id="menuSelect" multiple="true" class="menu-cat-select">' . $html . '</select>';
	}
	
	function getCatList() {
		global $vsMenu;
		reset ( $vsMenu->arrayTreeCategory );
		$categoryRoot = current ( $vsMenu->arrayTreeCategory );
		$categories = $categoryRoot->getChildren ();
		$vsMenu->obj->setIsAdmin ( - 1 );
		$vsMenu->obj->setLangId ( $_SESSION [APPLICATION_TYPE] ['language'] ['currentLang'] ['langId'] );
		$menus = $vsMenu->filterMenu ( array ('isAdmin' => true, 'langId' => true ), $categories );
		
		if (count ($menus )) {
			$html = "";
			$vsMenu->buildOptionMenuTree ( $menus, &$html );
		}
		return "<select size='10' id='catSelect' multiple='true' class='menu-cat-select'>" . $html . '</select>';
	}
	
	function getVirModCatList($module = "") {
		global $vsMenu, $vsSettings;
		
		if (! $module)
			return "";
		$category = $vsMenu->getCategoryGroup ( $module );
		
		$option = array ('listStyle' => "| - -", 'id' => 'catSelect', 'size' => 10, 'multiple' => false, 'rootId' => $category->getId () );
		
		if ($vsSettings->getSystemKey ( $module . "_multi_category", 0, $module, 1, 1 ))
			$option ['multiple'] = true;
		
		return $vsMenu->displaySelectBox ( $category->getChildren (), $option );
	}
	
	// get page obj in an module.
	

	function getObjByModule($module = "pages", $size = 10, $key = 'getId', $group = 0) {
		global $bw, $vsSettings, $vsMenu;
		
		$categories = $vsMenu->getCategoryGroup($module);
		$strIds = $vsMenu->getChildrenIdInTree($categories);
		
		if(!$strIds) return array();
		$cond = $this->getCondition();
		if($cond) $cond .= ' AND ';
		$cond .= 'pageCatId in (' . $strIds . ') and pageStatus > 0';
		$this->setCondition($cond);
		
		if( !$this->getOrder() )
			$this->setOrder("pageIndex, pageId DESC");
			
		$this->setLimit(array(0, $size));
		$result = $this->getObjectsByCondition($key, $group);
		if($result) $this->convertFileObject($result, $module);
		return $result;
	}
	
	function getSpecialByModule($module = "", $size = 10) {
		global $vsMenu;
		
		$categories = $this->getCategories ();
		if ($module)
			$categories = $vsMenu->getCategoryGroup ( $module );
		
		$strIds = $vsMenu->getChildrenIdInTree ( $categories );
		if (! $strIds)
			return array ();
		
		$this->setFieldsString ( 'pageId, pageTitle, pageIntro, pageContent, pagePostDate, pageImage' );
		$this->setCondition ( "pageStatus = 2 and pageCatId in ({$strIds})" );
		$this->getOrder () ? '' : $this->setOrder ( "pageIndex DESC, pageId DESC" );
		$this->setLimit ( array (0, $size ) );
		return $this->getObjectsByCondition ();
	}
	
	function getLastestByModule($module = "", $size = 10) {
		global $vsMenu;
		if ($module)
			$categories = $vsMenu->getCategoryGroup ( $module );
		else
			$categories = $this->getCategories ();
		
		$strIds = $vsMenu->getChildrenIdInTree ( $categories );
		if (! $strIds)
			return array ();
		$this->setFieldsString ( 'pageId, pageTitle, pageIntro, pageContent, pagePostDate, pageImage' );
		$this->setCondition ( "pageStatus > 0 and pageCatId in ({$strIds})" );
		$this->getOrder () ? $this->setOrder ( $this->getOrder () . ", pageId DESC" ) : $this->setOrder ( "pageIndex DESC, pageId DESC" );
		$this->setLimit ( array (0, $size ) );
		return $this->getObjectsByCondition ();
	}
	
	function getPageByCode($code = '') {
		if (! $code) return NULL;
		
		$this->setCondition ( 'pageCode ="' . $code . '" AND pageStatus > 0' );
		$temp = $this->getObjectsByCondition();
		reset ( $temp );
		return current ( $temp );
	}
	
	function getPageByCodeLanguage($code = '', $module = 'pages') {
		if (! $code) return NULL;
		
		global $vsMenu;
		
		$strIds = $vsMenu->getChildrenIdInTree ( $vsMenu->getCategoryGroup ( $module ) );
		if (! $strIds)
			return;
		$this->setCondition ( 'pageCode ="' . $code . '" AND pageStatus > 0 AND pageCatId IN (' . $strIds . ')' );
		$temp = $this->getObjectsByCondition ();
		reset ( $temp );
		return current ( $temp );
	}
	
	function getObjPageCate($module = "", $status = 1, $limit = 10) {
		global $vsMenu;
		if ($module)
			$categories = $vsMenu->getCategoryGroup ( $module );
		else
			$categories = $this->getCategories ();
		
		$option ['cate'] = $categories->getChildren ();
		$strIds = $vsMenu->getChildrenIdInTree ( $categories );
		if(!$strIds) return array();
		$this->setFieldsString ( "{$this->tableName}Id,{$this->tableName}Title,{$this->tableName}Intro,{$this->tableName}PostDate,{$this->tableName}Image" );
		$this->setLimit ( array (0, $limit ) );
		$this->setOrder ( "{$this->tableName}Index DESC , {$this->tableName}Id DESC" );
		$cond = "{$this->tableName}Status >={$status} and {$this->tableName}CatId in ({$strIds}) ";
		if ($this->getCondition ())
			$cond .= " and " . $this->getCondition ();
		$this->setCondition ( $cond );
		$list = $this->getObjectsByCondition ();
		if ($list) {
			$this->convertFileObject ( $list, $module );
			$option ['big'] = current ( $list );
			unset ( $list [$option ['big']->getId ()] );
			if (count ( $list ) > 2) {
				$option ['links'] = array_splice ( $list, 0, 2 );
				$option ['imglinks'] = $list;
			} else
				$option ['links'] = $list;
		
		}
		return $option;
	}
	
	function getPagemenu($key = 'pages') {
		global $vsStd, $bw, $vsMenu;
		$categories = $vsMenu->getCategoryGroup ( $key );
		$strIds = $vsMenu->getChildrenIdInTree ( $categories );
		if(!$strIds) return array();
		
		$this->setFieldsString('pageId, pageTitle');
		$this->setOrder('pageIndex DESC, pageId DESC');
		$this->setCondition ( "pageCatId in ({$strIds}) and pageStatus > 0" );
		$list = $this->getObjectsByCondition ();
		return $this->buildLi ( $key, $list );
	}
	
	function buildLi($key = 'pages', $list = array()) {
		global $vsMenu, $bw, $vsLang, $vsPrint;
		$re = "";
		if (count ( $list )) {
			$re = "<h3>{$vsPrint->pageTitle}</h3>
                                <ul id='menu' class='imenu'>";
			foreach ( $list as $obj ) {
				$re .= "<li><a href='{$obj->getUrl($key)}' title='{$obj->getTitle()}'>{$obj->getTitle()}</a></li>";
			}
			$re .= "</ul>";
		}
		return $re;
	}

}
?>