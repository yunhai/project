<?php
class Addon {

	public $html;

	function __construct() {

		global $vsTemplate;
		$this->html = $vsTemplate->load_template('skin_addon');

		if (APPLICATION_TYPE == 'user') {$this->runUserAddOn();} else { $this->runAdminAddOn();}

	}

	function runUserAddOn() {
            global $vsStd, $vsCounter, $vsTemplate, $bw;
            $vsCounter->visitCounter();
            $this->managerPortlet();
	}

    function managerPortlet() {
            global $vsTemplate, $vsStd, $vsMenu, $vsSettings, $DB, $bw, $vsLang;

            $vsStd->requireFile(CORE_PATH . "pages/pages.php");

//
            $menu = $vsMenu->getMenuForUser();

            $vsTemplate->global_template->menu_sub["products"] = $this->buildchildMenu('products');
            $vsTemplate->global_template->menu_sub["abouts"] = $this->getPagemenu('abouts');
            $vsTemplate->global_template->menu_sub["news"] = $this->buildchildMenu('news');
            $vsTemplate->global_template->menu_sub["dichvu"] = $this->getPagemenu('dichvu');
            $vsTemplate->global_template->menu_sub["quatang"] = $this->buildchildMenu('quatang');
            $vsTemplate->global_template->menu_sub["contacts"] = $this->buildchildMenu('contacts');


            $vsTemplate->global_template->quatangCate = $vsMenu->getCategoryGroup("quatang")->getChildren();
            $vsTemplate->global_template->menu = $this->html->showMenuTopForUser($menu);
            $vsTemplate->global_template->menu_footer = $this->html->showMenuBottomForUser($menu);


            $vsStd->requireFile(CORE_PATH . "pages/pages.php");
            $pages = new pages();
            $vsStd->requireFile(CORE_PATH . "contacts/contacts.php");
            $contacts = new contacts();
            $vsStd->requireFile(CORE_PATH . "products/products.php");
            $products = new products();

            $vsTemplate->global_template->products = $products->getObjPage('products');
            $vsTemplate->global_template->cateproducts = $vsMenu->getCategoryGroup('products')->getChildren();
            $vsTemplate->global_template->quatang = $products->getObjPage('quatang');
            $vsTemplate->global_template->catequatang = $vsMenu->getCategoryGroup('quatang')->getChildren();
            $vsStd->requireFile(CORE_PATH . "news/news.php");
            $news = new newses();
            $abouts = $pages->getObjPage('abouts', 1, 3);
            if ($abouts) {
                    $vsTemplate->global_template->about = current($abouts);
            }
            $vsStd->requireFile(CORE_PATH . 'partners/partners.php');
            $partners = new partners();
            $vsTemplate->global_template->wl = $pn = $partners->getArrayPartners(array("banner", 'weblinks', 'qctop', 'khang', 'videos'));
            $vsTemplate->global_template->portlet_partner = $this->html->portlet_partner($pn["banner"]);
            $vsTemplate->global_template->portlet_dropdown_weblink = $this->html->portlet_dropdown_weblink($pn["weblinks"]);
            $vsTemplate->global_template->getvideos = $this->html->getvideos($pn["videos"]);

            $vsStd->requireFile(CORE_PATH . "pcontacts/pcontacts.php");
            $pcontact = new pcontacts();
            $categories = $vsMenu->getCategoryGroup("pcontacts");
            $strIds = $vsMenu->getChildrenIdInTree($categories);
            $pcontact->setCondition("pcontactCatId in ({$strIds}) and pcontactStatus > 0");
            $pcontact->setOrder("pcontactIndex ASC, pcontactId ASC");
            $vsTemplate->global_template->contacts = $pcontact->getOneObjectsByCondition();

            $vsTemplate->global_template->search = $this->html->portlet_search();

            $vsStd->requireFile(CORE_PATH . 'supports/supports.php');
            $supports = new supports();
            $vsTemplate->global_template->portlet_supports = $supports->portlet();
    }

	function getThoiTiet() {
		global $vsStd, $vsTemplate;
		$vsStd->requireFile(UTILS_PATH . 'class_utilities.php');
		$utilities = new class_ultilities();
		$citys = array(
			array('city' => 'Sonla', 'name' => 'Sơn La'),
			array('city' => 'Haipho', 'name' => 'Hải Phòng'),
			array('city' => 'Hanoi', 'name' => 'Hà Nôi'),
			array('city' => 'Vinh', 'name' => 'Vinh'),
			array('city' => 'Danang', 'name' => 'Ðà Nẵng'),
			array('city' => 'Nhatra', 'name' => 'Nha Trang'),
			array('city' => 'Pleicu', 'name' => 'Pleiku'),
			array('city' => 'HCM', 'name' => 'Tp. Hồ Chí Minh'),
		);

		$weather = $utilities->getWeatherFromVNExpress($citys);

		$vsTemplate->global_template->weatherArray = $citys;
		$vsTemplate->global_template->weather = $weather;

	}

	function getGiavangSJC() {
		global $vsStd, $vsTemplate;
		$vsStd->requireFile(UTILS_PATH . 'class_xml.php');

		$myXML = new class_xml();
		$xmlFile = "http://www.sjc.com.vn/xml/tygiavang.xml";

		$myXML->xml_parse_document(file_get_contents($xmlFile));
		$array = current($myXML->xml_array);

		$myarray = array();
		$i = 0;
		foreach ($array['ratelist']['city'] as $element) {
			$myarray[$i]['title'] = $element['ATTRIBUTES']['name'];
			if (count($element['item']) == 2) {
				$myarray[$i]['items'][] = $element['item']['ATTRIBUTES'];
			} else {
				foreach ($element['item'] as $value) {
					$myarray[$i]['items'][] = $value['ATTRIBUTES'];
				}
			}
			$i++;
		}

		foreach ($myarray as $key => $obj) {
			$giavang .= <<<EOF
	        		<tr>
	        		<td colspan="3">{$myarray[$key]['title']}</td>
	        		</tr>
EOF;

			foreach ($myarray[$key]['items'] as $val) {
				$giavang .= <<<EOF
	        		<tr>
	        		<td class="col_td">{$val['type']}</td>
	            	<td class="col_td1">{$val['buy']}</td>
	            	<td class="col_td1">{$val['sell']}</td>
	            	</tr>
EOF;
			}

		}
		$vsTemplate->global_template->giavang = $giavang;

	}

	function getTygia() {
		global $vsStd, $vsTemplate, $vsLang;
		$vsStd->requireFile(UTILS_PATH . 'class_utilities.php');
		$utilities = new class_ultilities();
		$time = time();
		$array = array('USD', 'JPY', 'EUR', 'AUD');
		$exchange = $utilities->getCurrencyFormVietcombank($array, $time);

		foreach ($array as $obj) {
			$rates .= <<<EOF
	        		<tr>
	        		<td>{$obj}</td>
	            	<td class="col_td1">{$exchange[$obj]['exchangeBuy']}</td>
	            	<td class="col_td1">{$exchange[$obj]['exchangeSell']}</td>
	            	</tr>
EOF;
		}

		$vsTemplate->global_template->rates = $rates;
	}
/*========================= TI GIA ACB =================*/

	function get_string($string, $start, $end) {
		$ex = explode($start, $string);
		$ex = explode($end, $ex[1]);
		return $ex[0];
	}

	function get_data($url, $follow_location = false, $return_last_url = false) {
		$browser_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/2.0.0.16";
		$cookie_file = 'my.cookie';
		$f = fopen($cookie_file, 'wb');
		fclose($f);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		if ($follow_location) {
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		}

		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
		curl_setopt($ch, CURLOPT_USERAGENT, $browser_agent);
		curl_setopt($ch, CURLOPT_URL, $url);
		$result = curl_exec($ch);
		$last_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
		curl_close($ch);
		if ($return_last_url) {
			return $last_url;
		} else {
			return $result;
		}

	}

	function getTygiaACB() {
		global $vsTemplate;
		$known_bank = array("acb" => "http://www.acb.com.vn/tygia/");
		$name = array(
			"USD" => "US Dollar",
			"EUR" => "Euro",
			"JPY" => "Japanese Yen",
			"GBP" => "GB Yen",
			"AUD" => "Australia Dollar",
			"SGD" => "Singapore Dollar",
			"NZD" => "NewZeland Dollar",
			"THB" => "Thai Baht",
			"HKD" => "HongKong Dollar",
			"CAD" => "Canadian Dollar",
			"CHF" => "Swiss France",
		);

		$source = $this->get_data($known_bank['acb'], $follow_location = false, $return_last_url = false);
		if (empty($source)) {
			exit("Unknown bank");
		}

		$tygia = array();
		foreach ($name as $nt => $value) {
			$str = strstr($source, strtoupper($nt));
			$tygia[$nt]['mua'] = $this->get_string($str, 'class="cap-r2">', "</td>");
			$tygia[$nt]['mck'] = $this->get_string($str, 'class="cap-r3">', "</td>");
			$tygia[$nt]['ban'] = $this->get_string($str, 'class="cap-r4">', "</td>");
		}

		foreach ($tygia as $k => $obj) {
			$rates .= <<<EOF
	        		<tr>
	        		<td>{$k}</td>
	            	<td class="col_td1">{$obj['mua']}</td>
	            	<td class="col_td1">{$obj['ban']}</td>
	            	</tr>
EOF;
		}

		$vsTemplate->global_template->tygia = $rates;

	}

/*=======================================================*/

	function runAdminAddOn() {
		global $bw, $vsTemplate;

		if ($bw->vars['user_multi_lang']) {
			$this->displayChooseLanguage();
		}

		$this->displayAdminMenus();
	}

	function displayChooseLanguage($langType = 1, $display = '<!--USER LANGUAGE LIST-->') {
		global $vsStd, $vsTemplate;

		if (!isset($_SESSION[APPLICATION_TYPE]['language']['currentLang'])) {
			$oLanguages = new languages();
			$oLanguages->language->setAdminDefault(1);
			$langResult = $oLanguages->getLangByObject(array('getAdminDefault'), $oLanguages->arrayLang);

			reset($langResult);
			$language = current($langResult);
			$_SESSION[APPLICATION_TYPE]['language']['currentLang'] = $language->convertToDB();
		}

		$currentUserLanguage = new Lang();
		$currentUserLanguage->convertToObject($_SESSION[APPLICATION_TYPE]['language']['currentLang']);

		$vsStd->requireFile(CORE_PATH . "languages/languages.php");
		$languages = new languages();
		$vsTemplate->global_template->LANGUAGE_LIST = $this->html->userLanguages($languages->arrayLang, $title);
	}

	function displayAdminMenus() {
		global $vsTemplate, $vsMenu, $vsSettings;

		$vsMenu->obj->setIsAdmin(1);
		$vsMenu->obj->setStatus(1);
		$vsMenu->obj->setPosition('top');
		$vsMenu->obj->setTitle('Categories');

		if ($vsSettings->getSystemKey('admin_multi_lang', 0, 'global', 1, 1)) {
			$vsMenu->obj->setLangId($_SESSION[APPLICATION_TYPE]['language']['currentLang']['langId']);
			$menus = $vsMenu->filterMenu(array('isAdmin' => true, 'langId' => true, 'status' => true, 'position' => true), $vsMenu->arrayTreeMenu);
		} else {
			$menus = $vsMenu->filterMenu(array('isAdmin' => true, 'status' => true, 'position' => true), $vsMenu->arrayTreeMenu);
		}

		$vsTemplate->global_template->ADMIN_TOP_MENU = $menus;
		$vsMenu->obj->setLangId($_SESSION[APPLICATION_TYPE]['language']['currentLang']['langId']);
	}

	function displayAcpHelp() {
		global $bw, $vsSkin, $DB;
		$curr_action = $bw->input['module'];
		if ($bw->input['action'] != "") {
			$curr_action .= "::" . $bw->input['action'];
		}

		$curr_LangId = $_SESSION[APPLICATION_TYPE]['language']['currentLang']['langId'];
		$DB->simple_construct(array('select' => '*',
			'from' => 'acp_help',
			'where' => 'langId=' . $curr_LangId . ' AND `module_key`="' . $curr_action . '"',
			'order' => 'id',
		));
		$DB->simple_exec();
		if ($acp_help = $DB->fetch_row()) {
			$vsSkin->ACP_HELP_SYSTEM = $this->html->acpHelpHTML($acp_help);
		}
	}

	function showMenuGallery($option) {
		$re = "";
		foreach ($option as $menu) {
			if ($menu->children) {
				foreach ($menu->children as $obj) {
					$re .= "<li><a href='{$obj->getUrl(0)}' title='{$obj->getTitle()}'>{$obj->getTitle()}</a></li>";
				}

			}
		}

		return $re;
	}

	public function getPagemenu($key = 'pages', $size = '1000') {
		global $vsStd, $bw, $vsMenu, $DB;
		$categories = $vsMenu->getCategoryGroup($key);
		$strIds = $vsMenu->getChildrenIdInTree($categories);

		if ($key == 'gallerys') {
			$vsStd->requireFile(CORE_PATH . "gallerys/gallerys.php");
			$pages = new gallerys();
			$pages->setFieldsString('galleryId,galleryTitle');
			$pages->setOrder('galleryIndex ASC,galleryId DESC');
			$pages->setCondition("galleryCatId in ({$strIds}) and galleryStatus > 0");
		} else {
			$pages = new pages();
			$pages->setFieldsString('pageId,pageTitle');
			$pages->setOrder('pageIndex ASC,pageId DESC');
			if ($key == 'abouts') {
				$pages->setCondition("pageCatId in ({$strIds}) and pageStatus > 0 and pageCode = ''");
			} else {
				$pages->setCondition("pageCatId in ({$strIds}) and pageStatus > 0");
			}

		}
		$list = $pages->getObjectsByCondition();

		return $this->buildLi($key, $list, $size);
	}

	public function buildLi($key = 'pages', $list = array(), $size = '1000') {
		global $vsLang, $bw;
		$re = "";
		if (count($list)) {
			foreach ($list as $obj) {
				$re .= "<li><a href='{$obj->getUrl($key)}' title='{$obj->getTitle()}'>{$obj->getTitle($size)}</a></li>";
			}
		}

		return $re;
	}

	public function buildchildMenu($key = "news") {
		global $vsMenu, $bw, $vsLang;
		$re = "";

		$list = $vsMenu->getCategoryGroup($key);

		if ($list) {
			if ($list->getChildren()) {
				foreach ($list->getChildren() as $obj) {
					if ($obj->getChildren()) {
						$re .= "<li><a href='{$obj->getUrlCategory()}' title='{$obj->getTitle()}'>{$obj->getTitle()}</a><ul>";
						foreach ($obj->getChildren() as $obj1) {
							$re .= "<li><a href='{$obj1->getUrlCategory()}' title='{$obj1->getTitle()}'>{$obj1->getTitle()}</a></li>";
						}

						$re .= "</ul></li>";
					} else {
						$re .= "<li><a href='{$obj->getUrlCategory()}' title='{$obj->getTitle()}'>{$obj->getTitle()}</a></li>";
					}

				}

			}
		}

		return $re;
	}

	public function buildchildMenu1($key = "news") {
		global $vsMenu, $bw, $vsLang;
		$re = "";

		$list = $vsMenu->getCategoryGroup($key);

		if ($list) {
			if ($list->getChildren()) {
				foreach ($list->getChildren() as $obj) {

					$re .= "<li><a href='{$obj->getUrlCategory()}' title='{$obj->getTitle()}'>{$obj->getTitle()}</a></li>";
				}

			}
		}

		return $re;
	}

	public function buildchildMenuPro($key = "news") {
		global $vsMenu, $bw, $vsLang;
		$re = "";

		$list = $vsMenu->getCategoryGroup($key, array('status' => true));

		if ($list) {
			if ($list->getChildren()) {
				foreach ($list->getChildren() as $obj) {
					if ($obj->getChildren()) {
						$re .= "<li><a href='{$obj->getUrlCategory()}' title='{$obj->getTitle()}'>{$obj->getTitle()}</a><ul>";
						foreach ($obj->getChildren() as $obj1) {
							if ($obj1->getChildren()) {
								$re .= "<li><a href='{$obj1->getUrlCategory()}' title='{$obj1->getTitle()}'>{$obj1->getTitle()}</a><ul>";
								foreach ($obj1->getChildren() as $obj2) {
									if ($obj2->getChildren()) {
										$re .= "<li><a href='{$obj2->getUrlCategory()}' title='{$obj2->getTitle()}'>{$obj2->getTitle()}</a><ul>";
										foreach ($obj2->getChildren() as $obj3) {
											$re .= "<li><a href='{$obj3->getUrlCategory()}' title='{$obj3->getTitle()}'>{$obj3->getTitle()}</a></li>";
										}

										$re .= "</ul></li>";
									} else {
										$re .= "<li><a href='{$obj2->getUrlCategory()}' title='{$obj2->getTitle()}'>{$obj2->getTitle()}</a></li>";
									}
								}

								$re .= "</ul></li>";
							} else {
								$re .= "<li><a href='{$obj1->getUrlCategory()}' title='{$obj1->getTitle()}'>{$obj1->getTitle()}</a></li>";
							}
						}

						$re .= "</ul></li>";
					} else {
						$re .= "<li><a href='{$obj->getUrlCategory()}' title='{$obj->getTitle()}' class='product_list_title'>{$obj->getTitle()}</a></li>";
					}

				}

			}
		}

		return $re;
	}

	public function buildchildMenuPro1($key = "news") {
		global $vsMenu, $bw, $vsLang;
		$re = "";

		$list = $vsMenu->getCategoryGroup($key, array('status' => true));

		if ($list) {
			if ($list->getChildren()) {
				foreach ($list->getChildren() as $obj) {
					if ($obj->getChildren()) {
						$re .= "<li><a href='{$obj->getUrlCategory()}' title='{$obj->getTitle()}'>{$obj->getTitle()}</a><ul>";
						foreach ($obj->getChildren() as $obj1) {
							if ($obj1->getChildren()) {
								$re .= "<li><a href='{$obj1->getUrlCategory()}' title='{$obj1->getTitle()}'>{$obj1->getTitle()}</a><ul>";
								foreach ($obj1->getChildren() as $obj2) {
									if ($obj2->getChildren()) {
										$re .= "<li><a href='{$obj2->getUrlCategory()}' title='{$obj2->getTitle()}'>{$obj2->getTitle()}</a><ul>";
										foreach ($obj2->getChildren() as $obj3) {
											$re .= "<li><a href='{$obj3->getUrlCategory()}' title='{$obj3->getTitle()}'>{$obj3->getTitle()}</a></li>";
										}

										$re .= "</ul></li>";
									} else {
										$re .= "<li><a href='{$obj2->getUrlCategory()}' title='{$obj2->getTitle()}'>{$obj2->getTitle()}</a></li>";
									}
								}

								$re .= "</ul></li>";
							} else {
								$re .= "<li><a href='{$obj1->getUrlCategory()}' title='{$obj1->getTitle()}'>{$obj1->getTitle()}</a></li>";
							}
						}

						$re .= "</ul></li>";
					} else {
						$re .= "<li><a href='{$obj->getUrlCategory()}' title='{$obj->getTitle()}' class='product_list_title'>{$obj->getTitle()}</a></li>";
					}

				}

			}
		}

		return $re;
	}

	public function buildchildRss($key = "news") {
		global $vsMenu, $bw, $vsLang;
		$re = "";

		$list = $vsMenu->getCategoryGroup($key);

		if ($list) {
			$re .= "<li><a href='{$list->getUrlRSS()}' title='{$list->getTitle()}' target='_blank'> + {$list->getTitle()}</a></li><ul>";
			if ($list->getChildren()) {
				foreach ($list->getChildren() as $obj) {

					if ($obj->getChildren()) {
						$re .= "<li><a href='{$obj->getUrlRSS()}' title='{$obj->getTitle()}'>{$obj->getTitle()}</a><ul>";
						foreach ($obj->getChildren() as $obj1) {
							$re .= "<li><a href='{$obj1->getUrlRSS()}' title='{$obj1->getTitle()}'>{$obj1->getTitle()}</a></li>";
						}

						$re .= "</ul></li>";
					} else {
						$re .= "<li><a href='{$obj->getUrlRSS()}' title='{$obj->getTitle()}' target='_blank'> - {$obj->getTitle()}</a></li>";
					}

				}

			}
			$re .= "</ul></li>";
		}
		return $re;
	}

	public function getTitleMenu($option) {
		global $vsTemplate;

		foreach ($option as $obj) {
			if ($obj->getClassActive()) {
				return $obj;
			}
		}
		return;
	}

}
?>
