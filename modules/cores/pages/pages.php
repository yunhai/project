<?php

global $vsStd;
$vsStd->requireFile(CORE_PATH . "pages/Page.class.php");
class pages extends VSFObject {
	public $obj;
	function __construct() {
		global $vsMenu, $vsStd,$DB,$bw;
		parent::__construct ();
                $this->categoryField 	= "pageCatId";
		$this->primaryField     = "pageId";
		$this->basicClassName   = "Page";
		$this->tableName        = 'page';
		$this->obj = $this->createBasicObject ();
		$this->categories = $vsMenu->getCategoryGroup($bw->input['module']);
                
	}
	function __destruct() {
		unset($this);
	}
	
	
	function getMenuList() {
		global $vsMenu;
		
		$vsMenu->obj->setIsAdmin(0);
		$vsMenu->obj->setLangId($_SESSION[APPLICATION_TYPE]['language']['currentLang']['langId']);
		$menus = $vsMenu->filterMenu(array('isAdmin' => true, 'langId' => true ), $vsMenu->arrayTreeMenu);

		$html = "";
		$vsMenu->buildOptionMenuTree($menus, &$html);
		return '<select size="10" id="menuSelect" multiple="true" class="menu-cat-select">'.
					$html.
				'</select>';
	}
	
	function getCatList() {
		global $vsMenu;
		reset($vsMenu->arrayTreeCategory );
		$categoryRoot = current($vsMenu->arrayTreeCategory );
		$categories = $categoryRoot->getChildren ();
		$vsMenu->obj->setIsAdmin(-1);
		$vsMenu->obj->setLangId($_SESSION [APPLICATION_TYPE] ['language'] ['currentLang'] ['langId'] );
		$menus = $vsMenu->filterMenu ( array ('isAdmin' => true, 'langId' => true ), $categories );
		
		if(count($menus)){
			$html = "";
			$vsMenu->buildOptionMenuTree($menus, &$html);
		}
		return "<select size='10' id='catSelect' multiple='true' class='menu-cat-select'>".$html.'</select>';
	}
	
	function getVirModCatList($module = ""){
		global $vsMenu, $vsSettings;
		
		if(!$module) return "";
		$category = $vsMenu->getCategoryGroup($module);
		
		$option = array(
						'listStyle' => "| - -",
						'id' 		=> 'catSelect',
						'size' 		=> 10,
						'multiple' 	=> false,
						'rootId'	=> $category->getId()
						);
						
		if($vsSettings->getSystemKey($module."_multi_category", 0, $module, 1, 1))
			$option['multiple'] = true;

		return $vsMenu->displaySelectBox($category->getChildren(), $option );
	}
	
	// get page obj in an module.
	function getObjByModule($module="pages", $url="", $pIndex = 2, $size = 10) {
		global $bw, $vsSettings, $vsMenu;
		
		$categories = $vsMenu->getCategoryGroup($module);
		$strIds = $vsMenu->getChildrenIdInTree($categories);
		
		$cond = $this->getCondition();
		if($cond) $cond .= " AND ";
		$this->setCondition("pageCatId in (".$strIds.") AND pageStatus > 0".$cond);
		
		$url =  $module . "/" . $url;
		return $this->getPageList($url, $pIndex, $size);
	}
	
	function getHostListByModule($module, $size = 10) {
		global $vsMenu,$vsSettings;
			$categories = $vsMenu->getCategoryGroup ( $module );	
			$strIds = $this->vsMenu->getChildrenIdInTree ( $categories );
			if ($strIds) {
				$this->setFieldsString('pageId,pageTitle,pageIntro,pagePostDate,pageImage');
        		//$this->setTableName ("page left join vsf_file on pageImage = fileId");
				$this->getCondition () ? $this->setCondition ( $this->getCondition () . ' and pageCatId in (' . $strIds . ') and pageStatus > 0' ) : $this->setCondition ( 'pageCatId in (' . $strIds . ') and pageStatus > 0' );
				$this->getOrder () ? $this->setOrder ( $this->getOrder () . " , pageId DESC" ) : $this->setOrder ( "pageIndex ASC, pageId DESC" );
				$this->setLimit ( array (0, $size ) );
				return $this->getObjectsByCondition ();
			}
		
	}
	
	function getObjSpecial($module = "") {
		global $vsMenu;
		if($module)
			$categories = $this->vsMenu->getCategoryGroup($module);			
		else $categories = $this->getCategories();
		
		$strIds = $vsMenu->getChildrenIdInTree($categories);	
		
		$this->setFieldsString('pageId,pageTitle,pageIntro,pageContent,pagePostDate,pageImage');
		$this->setCondition ( "pageStatus = 2 and pageCatId in ({$strIds})" );
		
		return $this->getOneObjectsByCondition();
	}
	
	public function getarrayGallery1($id = ""){
		global $vsStd,$DB;
		
		$this->setFieldsString("pageId,pageTitle,pageIntro,pageContent,pageImage, vsf_file.*");
                $this->setTableName("page LEFT JOIN vsf_gallery_pages ON pageId = vsf_gallery_pages.relId
                                                                        LEFT JOIN vsf_rel_gallery_file ON relId = vsf_rel_gallery_file.objectId
                                                                        LEFT JOIN vsf_file ON objectId = fileId");
                $this->setOrder("fileId DESC");
                $condi = "pageCatId in ({$id})";


                $this->getCondition() == "" ? $this->setCondition($condi): $this->setCondition($this->getCondition()." and ".$condi) ;

                $result = $this->getObjectsByCondition();
                return $result;

	}

        
        public function getPagemenu($key = 'pages'){
		global $vsStd,$bw,$vsMenu;
                $categories = $vsMenu->getCategoryGroup($key);
		$strIds = $vsMenu->getChildrenIdInTree($categories);
                $this->setFieldsString('pageId,pageTitle');
                $this->setOrder('pageIndex ASC,pageId DESC');
		$this->setCondition("pageCatId in ({$strIds}) and pageStatus > 0");
		$list = $this->getObjectsByCondition();
		return $this->buildLi($key,$list);
	}

        public function buildLi($key = 'pages',$list=array()){
        	global $vsMenu,$bw,$vsLang,$vsPrint;
                $re ="";
		if(count($list)){
			$re ="<h3>{$vsPrint->pageTitle}</h3>
                                <ul id='menu' class='imenu'>";
			foreach( $list as $obj){
				$re .= "<li><a href='{$obj->getUrl($key)}' title='{$obj->getTitle()}'>{$obj->getTitle()}</a></li>";
			}
			$re .= "</ul>";
		}
                return $re;
        }
	
}
?>