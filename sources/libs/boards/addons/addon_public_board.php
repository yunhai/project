<?php
require_once LIBS_PATH . 'boards/addons/Addon.class.php';
class addon_public_board extends VSAddon {
	var $html = NULL;

	/**
	 *
	 * @return skin_addon
	 */
	public function getHtml() {
		if ($this->html === NULL) {
			global $vsTemplate;
			$this->html = $vsTemplate->load_template ( "skin_addon" );
		}
		return $this->html;
	}

	/**
	 *
	 * @param $html the
	 *        	$html to set
	 */
	public function setHtml($html) {
		$this->html = $html;
	}

	function getProductCategory($option = array()) {
		require_once CORE_PATH . 'products/products.php';
		$option ['category'] = VSFactory::getMenus ()->getCategoryGroup ( 'products' );
		return $this->getHtml ()->getProductCategory ( $option );
	}

	function getProductSearch($option = array()) {
		return $this->getHtml ()->getProductSearch ( $option );
	}

	function getWeatherBlock($option = array()) {
		return $this->getHtml ()->getWeatherBlock ( $option );
	}

	function getMenuTop($option=array()){
		global   $bw;
		
		$option['menu']=VSFactory::getMenus()->getMenuByPosition('top');
         $option['list'] = VSFactory::getMenus()->getListGroup();      
		foreach ($option['menu'] as $menu) {
//			echo $bw->input['vs'].":".trim($menu->getUrl(),'/').":".strpos($bw->input['vs'], trim($menu->getUrl(),'/'))."<br>";
			if(@strpos($bw->input['vs'], trim($menu->getUrl(),'/')) ===0){
				$menu->active="active";
			}
			if($bw->vars['public_frontpage']== $bw->input['vs']&&$menu->getUrl()=='' ){
				$menu->active="active";
			}
			if(in_array($menu->getUrl(), array("abouts"))){
				$category=VSFactory::getMenus()->getCategoryGroup("abouts");
				$ids=VSFactory::getMenus()->getChildrenIdInTree($category);
				if($ids){
					require_once CORE_PATH.'pages/pages.php';
					$pages=new pages();
					$pages->setCondition("catId in ($ids)");
					$pages->setOrder("`index`");
					$option['obj_list'][$menu->getId()]=$pages->getObjectsByCondition();
				}
			}
		}
                
             
		return $this->getHtml()->getMenuTop($option);
	}
	
	function getMenuMain() {
		global $bw;
	
		$option ['menu'] = VSFactory::getMenus ()->getMenuByPosition ( 'main' );
		foreach ( $option ['menu'] as $menu ) {
			if (@strpos ( $bw->input ['vs'], trim ( $menu->getUrl (), '/' ) ) === 0) {
				$menu->active = "active";
			}
			if ($bw->vars ['public_frontpage'] == $bw->input ['vs'] && $menu->getUrl () == '') {
				$menu->active = "active";
			}
			if($menu->getUrl ()=='services'){
				$this->menu_top = $menu;
			}
		}
	
		return $this->getHtml ()->getMenuMain ( $option );
	}

	function getMenuBottom($option = array()) {
		global $bw;
		$option ['menu'] = VSFactory::getMenus ()->getMenuByPosition ( 'bottom' );
		foreach ( $option ['menu'] as $menu ) {
			if (@strpos ( $bw->input ['vs'], trim ( $menu->getUrl (), '/' ) ) === 0) {
				$menu->active = "active";
			}
			if ($bw->vars ['public_frontpage'] == $bw->input ['vs'] && $menu->getUrl () == '') {
				$menu->active = "active";
			}
		}
		return $this->getHtml ()->getMenuBottom ( $option );
	}

	function getMenuLeft($option = array()) {
		$option ['menu'] = VSFactory::getMenus ()->getMenuByPosition ( 'left' );
		return $this->getHtml ()->getMenuLeft ( $option );
	}

	function getMenuRight() {
		$option = VSFactory::getMenus ()->getMenuByPosition ( 'right' );
		return $this->getHtml ()->getMenuRight ( $option );
	}

	function getSupport($option = array()) {
		$DB = VSFactory::createConnectionDB ();
		require_once CORE_PATH . 'supports/supports.php';
		$supports = new supports ();
		
		$option = $supports->getListWithCat ();
		return $this->getHtml ()->getSupport ( $option );
	}

	function getAnalytic($option = array()) {
		require_once LIBS_PATH . 'Counter.class.php';
		$counter = new VSSCounter ();
		// $tb=time();
		// $counter->datetime['flag']=($tb-$tb%300);
		if (! $_SESSION ['vs_static'] || intval ( $_SESSION ['vs_static'] ) != $counter->datetime ['flag']) {
			$counter->insertCounter ();
			$_SESSION ['vs_static'] = $counter->datetime ['flag'];
		}
		$option = $counter->visitCounter ();
		
		return $this->getHtml ()->getAnalytic ( $option );
	}

	/**
	 *
	 * @return Order Enter description here ...
	 */
	function getCart() {
		require_once CORE_PATH . 'orders/orders.php';
		require_once CORE_PATH . 'orders/carts.php';
		return carts::getCartInfo ();
	}

	public function getObjModule($root = "pages", $module = "", $status=0, $limit=0, $type=2) {
		require_once CORE_PATH . $root . "/" . $root . '.php';
		
		$pages = new $root ();
		$category = VSFactory::getMenus ()->getCategoryGroup ( $module );
		$ids = VSFactory::getMenus ()->getChildrenIdInTree ( $category );
		$pages->setCondition ( "status>{$status} and catId in ($ids)" );
		$pages->setOrder ( "`index` DESC,id desc" );
		if ($limit)
			$pages->setLimit ( array (0, $limit ) );
		if ($type == 1)
			return $pages->getOneObjectsByCondition ();
		if ($type == 2)
			return $pages->getObjectsByCondition ();
	}
	function getWidgetByCode($code){
		if($this->wresult) return $this->wresult;
		$this->wresult=array();
		require_once CORE_PATH.'widgets/widgets.php';
		$widgets=new widgets();
		$widgets->setCondition("`position`='$code'");
		$widgets->setOrder('`index` DESC');
		$wlist=$widgets->getObjectsByCondition();
		foreach ($wlist as $widget) {
				$this->wresult[]=$widget->getObj();
		}
		return $this->wresult;
	}
	
}

?>