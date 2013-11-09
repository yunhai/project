<?php
class Addon {
	
	public $html;
	
	function __construct() {
		global $vsTemplate;
		
		$this->html = $vsTemplate->load_template ( 'skin_addon' );
		
		if (APPLICATION_TYPE == 'user')
			$this->runUserAddOn ();
		else
			$this->runAdminAddOn ();
	}
	
	function runUserAddOn() {
		global $vsTemplate, $vsMenu, $bw, $vsStd, $vsCounter;
		
		$vsCounter->visitCounter ();
		$listmenu = $vsMenu->getMenuForUser();
		
		$vsTemplate->global_template->topmenu = $this->html->topmenu($listmenu);
		$vsTemplate->global_template->bottommenu = $this->html->bottomenu($listmenu);
		
		
		
		$vsStd->requireFile ( CORE_PATH . 'pages/pages.php' );
		$page = new pages();
		
		$promote = $page->getObjByModule('promote', 4);
		$vsTemplate->global_template->promote = $this->html->portlet_promote($promote);
			
		
		$vsStd->requireFile ( CORE_PATH . 'partners/partners.php' );
		$partners = new partners();
		$ad = $partners->getArrayPartners(array('slidehome'));
		
		$slidehome = array();
		foreach ($ad['slidehome'] as $element)
			$slidehome[] = $element;
		
		$vsTemplate->global_template->slideshow = $this->html->portlet_slideshow($slidehome);
		
		
		$vsStd->requireFile(CORE_PATH.'pcontacts/pcontacts.php');
		$page = new pcontacts();
		$categories = $vsMenu->getCategoryGroup("branch");
		
		$strIds = $vsMenu->getChildrenIdInTree($categories);
		$page->setCondition("pcontactCatId in ({$strIds}) and pcontactStatus > 0");
		$page->setOrder("pcontactIndex, pcontactId");
		$branches = $page->getObjectsByCondition();
		
		if($branches) {
			$main = current($branches);
			$vsTemplate->global_template->map = $this->html->portlet_map($branches, $main);
			
			$vsTemplate->global_template->branch = $this->html->portlet_branch($branches);
		}
	}
	
	function buildMenuLeft($listmenu) {
		global $vsTemplate, $access;
		
		if ($listmenu) {
			foreach ( $listmenu as $key => $men ) {
				if ($men->getChildren ())
					$access [$men->getUrl ()] = $this->getSubMenuLeft ( $men );
			}
		}
		return $access;
	}
	
	function getSubMenuLeft($children) {
		global $vsTemplate, $arracc;
		$retur = "";
		$arracc ['news'] [] = 'news';
		if ($children->getChildren ())
			foreach ( $children->getChildren () as $obj ) {
				$arracc [$children->getUrl ()] [] = $obj->getUrl ();
				$retur .= "<li><a href='{$obj->getUrl(0)}' title='{$obj->getTitle()}' class='{$obj->getClassActive()}'><span>{$obj->getTitle()}</span></a>";
				if ($vsTemplate->global_template->menu_sub [$obj->getUrl ()])
					$retur .= "<ul>{$vsTemplate->global_template->menu_sub[$obj->getUrl()]}</ul>";
				$retur .= '</li>';
			}
		return $retur;
	}
	
	function getkeyAcc($key) {
		global $vsTemplate, $arracc;
		
		if (! is_array ( $arracc ))
			return "";
		foreach ( $arracc as $ke => $val ) {
			if (in_array ( $key, $val ))
				return $ke;
		}
		return "";
	}
	
	function getThoiTiet() {
		global $vsStd, $vsTemplate, $vsLang;
		$vsStd->requireFile ( UTILS_PATH . 'class_utilities.php' );
		$utilities = new class_ultilities ();
		$citys = array (array ('city' => 'Sonla', 'name' => $vsLang->getWords ( 'global_nSonLa', 'Sơn La' ) ), //  					array('city'=>'Haipho', 'name'=>$vsLang->getWords('global_nHaiPhong','Hải Phòng')),
		array ('city' => 'Hanoi', 'name' => $vsLang->getWords ( 'global_nHanoi', 'Hà Nôi' ) ), array ('city' => 'Vinh', 'name' => $vsLang->getWords ( 'global_nVinh', 'Vinh' ) ), array ('city' => 'Danang', 'name' => $vsLang->getWords ( 'global_ndanang', 'Ðà Nẵng' ) ), array ('city' => 'Nhatra', 'name' => $vsLang->getWords ( 'global_nnhatrang', 'Nha Trang' ) ), array ('city' => 'Pleicu', 'name' => $vsLang->getWords ( 'global_npleiku', 'Pleiku' ) ), array ('city' => 'HCM', 'name' => $vsLang->getWords ( 'global_nHCM', 'Tp. Hồ Chí Minh' ) ) );
		
		$weather = $utilities->getWeatherFromVNExpress ( $citys );
		$vsTemplate->global_template->weatherArray = $citys;
		
		//                       foreach($weather as $key=>$obj){
		//                           $weather[$key]['weatherDes'] = substr ($obj['weatherDes'], -12,4);
		//                       }
		

		$vsTemplate->global_template->weather = $weather;
	}
	
	public function buildchildMenuPro($key = "products") {
		global $vsMenu, $bw, $vsLang, $vsStd;
		$re = "";
		$count = 0;
		$count_li = 0;
		$list = $vsMenu->getCategoryGroup ( $key );
		
		$vsStd->requireFile ( CORE_PATH . "products/products.php" );
		$product = new products ();
		
		$strIds = $vsMenu->getChildrenIdInTree ( $list );
		$product->setFieldsString ( 'productId,productTitle,productCatId' );
		$product->setOrder ( 'productIndex DESC,productId DESC' );
		$product->setCondition ( "productCatId in ({$strIds}) and productStatus > 0" );
		$listpro = $product->getObjectsByCondition ( "getCatId", 1 );
		
		if ($list)
			if ($list->getChildren ()) {
				foreach ( $list->getChildren () as $k => $obj ) {
					$count += 1;
					if ($obj->getChildren ()) {
						$re .= "<li><a title='{$obj->getTitle()}'>{$obj->getTitle()}</a><ul class='abc{$count}'>";
						foreach ( $obj->getChildren () as $k1 => $obj1 ) {
							$count_li += 1;
							if ($listpro [$k1]) {
								if ($count_li == 1)
									$re .= "<li><a title='{$obj1->getTitle()}'>{$obj1->getTitle()}</a><ul class='abc{$count}'>";
								else
									$re .= "<li><a title='{$obj1->getTitle()}'>{$obj1->getTitle()}</a><ul>";
								foreach ( $listpro [$k1] as $pro )
									$re .= "<li><a href='{$pro->getUrl('products')}' title='{$pro->getTitle()}'>{$pro->getTitle()}</a></li>";
								$re .= "</ul></li>";
							} else
								$re .= "<li><a title='{$obj1->getTitle()}'>{$obj1->getTitle()}</a></li>";
						}
						$re .= "</ul></li>";
					} else {
						
						if ($listpro [$k]) {
							$re .= "<li><a title='{$obj->getTitle()}'>{$obj->getTitle()}</a><ul class='abc{$count}'>";
							foreach ( $listpro [$k] as $pro1 )
								$re .= "<li><a href='{$pro1->getUrl('products')}' title='{$pro1->getTitle()}'>{$pro1->getTitle()}</a></li>";
							$re .= "</ul></li>";
						} else
							$re .= "<li><a title='{$obj->getTitle()}'>{$obj->getTitle()}</a></li>";
					}
				}
			
			}
		
		return $re;
	}
	function getTygia() {
		global $vsStd, $vsTemplate, $vsLang;
		$vsStd->requireFile ( UTILS_PATH . 'class_utilities.php' );
		$utilities = new class_ultilities ();
		$time = time ();
		$array = array ('USD', 'EUR', 'JPY', 'SGD' );
		$exchange = $utilities->getCurrencyFormVietcombank ( $array, $time );
		
		foreach ( $array as $obj )
			$rates .= <<<EOF
	            	<tr><td>{$obj}:</td><td>{$exchange[$obj]['exchangeSell']}</td><td>{$exchange[$obj]['exchangeBuy']}</td></tr>
EOF;
		
		$vsTemplate->global_template->rates = $rates;
	}
	
	function runAdminAddOn() {
		global $bw, $vsTemplate;
		
		if ($bw->vars ['user_multi_lang'])
			$this->displayChooseLanguage ();
		
		$this->displayAdminMenus ();
	}
	
	function displayChooseLanguage($langType = 1, $display = '<!--USER LANGUAGE LIST-->') {
		global $vsStd, $vsTemplate;
		
		if (! isset ( $_SESSION [APPLICATION_TYPE] ['language'] ['currentLang'] )) {
			$oLanguages = new languages ();
			$oLanguages->language
				->setAdminDefault ( 1 );
			$langResult = $oLanguages->getLangByObject ( array ('getAdminDefault' ), $oLanguages->arrayLang );
			
			reset ( $langResult );
			$language = current ( $langResult );
			$_SESSION [APPLICATION_TYPE] ['language'] ['currentLang'] = $language->convertToDB ();
		}
		
		$currentUserLanguage = new Lang ();
		$currentUserLanguage->convertToObject ( $_SESSION [APPLICATION_TYPE] ['language'] ['currentLang'] );
		
		$vsStd->requireFile ( CORE_PATH . "languages/languages.php" );
		$languages = new languages ();
		$vsTemplate->global_template->LANGUAGE_LIST = $this->html
			->userLanguages ( $languages->arrayLang, $title );
	}
	
	function displayAdminMenus() {
		global $vsTemplate, $vsMenu, $vsSettings;
		
		$vsMenu->obj
			->setIsAdmin ( 1 );
		$vsMenu->obj
			->setStatus ( 1 );
		$vsMenu->obj
			->setPosition ( 'top' );
		$vsMenu->obj
			->setTitle ( 'Categories' );
		
		if ($vsSettings->getSystemKey ( 'admin_multi_lang', 0, 'global', 1, 1 )) {
			$vsMenu->obj
				->setLangId ( $_SESSION [APPLICATION_TYPE] ['language'] ['currentLang'] ['langId'] );
			$menus = $vsMenu->filterMenu ( array ('isAdmin' => true, 'langId' => true, 'status' => true, 'position' => true ), $vsMenu->arrayTreeMenu );
		} else
			$menus = $vsMenu->filterMenu ( array ('isAdmin' => true, 'status' => true, 'position' => true ), $vsMenu->arrayTreeMenu );
		
		$vsTemplate->global_template->ADMIN_TOP_MENU = $menus;
		$vsMenu->obj
			->setLangId ( $_SESSION [APPLICATION_TYPE] ['language'] ['currentLang'] ['langId'] );
	}
	
	function getPagemenu($key = 'pages') {
		global $vsStd, $bw, $vsMenu;
		$categories = $vsMenu->getCategoryGroup ( $key );
		$strIds = $vsMenu->getChildrenIdInTree ( $categories );
		if ($key == 'gallerys') {
			$pages = new gallerys ();
			$pages->setFieldsString ( 'galleryId,galleryTitle' );
			$pages->setOrder ( 'galleryIndex,galleryId DESC' );
			$pages->setCondition ( "galleryCatId in ({$strIds}) and galleryStatus > 0" );
		} else {
			$vsStd->requireFile ( CORE_PATH . 'pages/pages.php' );
			$pages = new pages ();
			$pages->setFieldsString ( 'pageId,pageTitle,pageCode' );
			$pages->setOrder ( 'pageIndex, pageId DESC' );
			$pages->setCondition ( "pageCatId in ({$strIds}) and pageStatus > 0" );
		}
		$list = $pages->getObjectsByCondition ();
		
		return $this->buildLi ( $key, $list );
	}
	
	public function buildLi($key = 'pages', $list = array()) {
		global $vsTemplate;
		$re = "";
		if (count ( $list )) {
			foreach ( $list as $obj ) {
				if ($obj->getCode () && $vsTemplate->global_template->menu_sub [$obj->getCode ()])
					$re .= "<li><a href='{$obj->getUrl($key)}' title='{$obj->getTitle()}'>{$obj->getTitle()}</a><ul>{$vsTemplate->global_template->menu_sub[$obj->getCode()]}</ul></li>";
				else
					$re .= "<li><a href='{$obj->getUrl($key)}' title='{$obj->getTitle()}'>{$obj->getTitle()}</a></li>";
			}
		}
		return $re;
	}
	
	function buildchildMenu($key = "news") {
		global $vsMenu;
		
		$return = "";
		$flag = true;
		$flag1 = true;
		$list = $vsMenu->getCategoryGroup ( $key, array ('status' => true ) );
		if ($list)
			if ($list->getChildren ()) {
				foreach ( $list->getChildren () as $obj ) {
					$class = 'product_list_even';
					if ($flag)
						$class = 'product_list_odd';
					$flag = ! $flag;
					
					$return .= "<li class='{$class}'><a href='{$obj->getUrlCategory()}' title='{$obj->getTitle()}'><span>{$obj->getTitle()}</span></a>";
					if ($obj->getChildren ()) {
						$return .= "<ul>";
						foreach ( $obj->getChildren () as $obj1 ) {
							$class1 = 'product_list_even';
							if ($flag1)
								$class1 = 'product_list_odd';
							$flag1 = ! $flag1;
							$return .= "<li class='{$class1}'><a href='{$obj1->getUrlCategory()}' title='{$obj1->getTitle()}'><span>{$obj1->getTitle()}</span></a>";
							if ($obj1->getChildren ()) {
								$return .= "<ul>";
								foreach ( $obj1->getChildren () as $obj2 )
									$return .= "<li><a href='{$obj2->getUrlCategory()}' title='{$obj2->getTitle()}'><span>{$obj2->getTitle()}</span></a></li>";
								$return .= "</ul>";
							}
							$return .= "</li>";
						}
						$return .= "</ul>";
					}
					$return .= "</li>";
				}
			}
		return $return;
	}
	
	function buildchildMenu2($key = "news") {
		global $vsMenu;
		$re = "";
		$list = $vsMenu->getCategoryGroup ( $key, array ('status' => true ) );
		if ($list)
			foreach ( $list->getChildren () as $obj )
				$re .= "<li><a href='{$obj->getUrlCategory()}' title='{$obj->getTitle()}'><span>{$obj->getTitle()}</span></a></li>";
		return $re;
	}
	
	public function getTitleMenu($option) {
		global $vsTemplate;
		
		foreach ( $option as $obj ) {
			if ($obj->getClassActive ()) {
				return $obj;
			}
		}
		return;
	}

}
?>