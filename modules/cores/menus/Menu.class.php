<?php
class Menu extends BasicObject {
	public $langId = NULL;
	public $id = NULL;
	public $url = NULL;
	public $title = NULL;
	public $status = NULL;
	public $index = NULL;
	public $alt = NULL;
	public $parentId = NULL;
	public $isLink = NULL;
	public $isDropdown = NULL;
	public $isAdmin = NULL;
	public $level = NULL;
	public $type = NULL;
	public $template = NULL;
	public $slug = NULL;
	public $top = 0;
	public $main = 0;
	public $right = 0;
	public $bottom = 0;
	public $left = 0;
	public $fileId = NULL;
	public $backup = NULL;
	public $children = array ();
	public $cate = array ();

	function getBackup() {
		return $this->backup;
	}

	function setBackup($backup) {
		$this->backup = $backup;
	}

	function getCate() {
		return $this->cate;
	}

	function setCate($cate) {
		$this->cate = $cate;
	}

	function convertToDB() {
		isset ( $this->id ) ? ($dbobj ['menuId'] = $this->id) : '';
		isset ( $this->langId ) ? ($dbobj ['langId'] = $this->langId) : '';
		isset ( $this->title ) ? ($dbobj ['menuTitle'] = $this->title) : '';
		isset ( $this->url ) ? ($dbobj ['menuUrl'] = $this->url) : '';
		isset ( $this->index ) ? ($dbobj ['menuIndex'] = $this->index) : '';
		isset ( $this->status ) ? ($dbobj ['menuStatus'] = $this->status) : '';
		isset ( $this->alt ) ? ($dbobj ['menuAlt'] = $this->alt) : '';
		isset ( $this->parentId ) ? ($dbobj ['parentId'] = $this->parentId) : '';
		isset ( $this->isLink ) ? ($dbobj ['menuIsLink'] = $this->isLink) : '';
		isset ( $this->isDropdown ) ? ($dbobj ['menuIsDropDown'] = $this->isDropdown) : '';
		isset ( $this->isAdmin ) ? ($dbobj ['menuIsAdmin'] = $this->isAdmin) : '';
		isset ( $this->type ) ? ($dbobj ['menuType'] = $this->type) : '';
		isset ( $this->level ) ? ($dbobj ['menuLevel'] = $this->level) : '';
		isset ( $this->fileId ) ? ($dbobj ['menuFileId'] = $this->fileId) : '';
		isset ( $this->backup ) ? ($dbobj ['menuBackup'] = $this->backup) : '';
		isset ( $this->template ) ? ($dbobj ['menuTemplate'] = $this->template) : '';
		isset ( $this->slug ) ? ($dbobj ['menuSlug'] = $this->slug) : '';
		isset ( $this->quick ) ? ($dbobj ['menuQuick'] = $this->quick) : '';
		isset ( $this->mTitle ) ? ($dbobj ['menuMtTitle'] = $this->mTitle) : '';
		isset ( $this->mIntro ) ? ($dbobj ['menuMtDesc'] = $this->mIntro) : '';
		isset ( $this->mKeyword ) ? ($dbobj ['menuMtKeyWord'] = $this->mKeyword) : '';
		
		isset ( $this->cate ) ? ($dbobj ['menuCate'] = $this->cate) : '';
		$posStr = "@";
		$posStr .= $this->top;
		$posStr .= $this->right;
		$posStr .= $this->bottom;
		$posStr .= $this->left;
		$posStr .= $this->main;
		$dbobj ['menuPosition'] = $posStr;
		return $dbobj;
	}

	function convertToObject($object) {
		parent::convertToObject ( $object );
		isset ( $object ['menuId'] ) ? $this->setId ( $object ['menuId'] ) : '';
		isset ( $object ['langId'] ) ? $this->setLangId ( $object ['langId'] ) : '';
		isset ( $object ['menuTitle'] ) ? $this->setTitle ( $object ['menuTitle'] ) : '';
		isset ( $object ['menuUrl'] ) ? $this->setUrl ( $object ['menuUrl'] ) : '';
		isset ( $object ['menuIndex'] ) ? $this->setIndex ( $object ['menuIndex'] ) : '';
		isset ( $object ['menuStatus'] ) ? $this->setStatus ( $object ['menuStatus'] ) : '';
		isset ( $object ['menuAlt'] ) ? $this->setAlt ( $object ['menuAlt'] ) : '';
		isset ( $object ['parentId'] ) ? $this->setParentId ( $object ['parentId'] ) : '';
		isset ( $object ['menuIsLink'] ) ? $this->setIsLink ( $object ['menuIsLink'] ) : '';
		isset ( $object ['menuIsDropDown'] ) ? $this->setIsDropdown ( $object ['menuIsDropDown'] ) : '';
		isset ( $object ['menuIsAdmin'] ) ? $this->setIsAdmin ( $object ['menuIsAdmin'] ) : '';
		isset ( $object ['menuType'] ) ? $this->setType ( $object ['menuType'] ) : '';
		isset ( $object ['menuLevel'] ) ? $this->setLevel ( $object ['menuLevel'] ) : '';
		isset ( $object ['menuFileId'] ) ? $this->setFileId ( $object ['menuFileId'] ) : '';
		isset ( $object ['menuBackup'] ) ? $this->setBackup ( $object ['menuBackup'] ) : '';
		isset ( $object ['menuSlug'] ) ? $this->setSlug ( $object ['menuSlug'] ) : '';
		
		isset ( $object ['menuMtTitle'] ) ? $this->setMTitle ( $object ['menuMtTitle'] ) : '';
		isset ( $object ['menuMtDesc'] ) ? $this->setMIntro ( $object ['menuMtDesc'] ) : '';
		isset ( $object ['menuMtKeyWord'] ) ? $this->setMKeyword ( $object ['menuMtKeyWord'] ) : '';
		
		isset ( $object ['menuTemplate'] ) ? $this->setTemplate ( $object ['menuTemplate'] ) : '';
		isset ( $object ['menuCate'] ) ? $this->setCate ( $object ['menuCate'] ) : '';
		isset ( $object ['menuQuick'] ) ? $this->setQuick ( $object ['menuQuick'] ) : '';
		if ($object ['menuPosition']) {
			$posString = trim ( $object ['menuPosition'], '@' );
			$this->top = $posString [0];
			$this->right = $posString [1];
			$this->bottom = $posString [2];
			$this->left = $posString [3];
			$this->main = $posString [4];
		}
	}

	function validate() {
		$status = true;
		if ($this->title == "") {
			$status = false;
			$this->message .= "Menu title can't be left blank!<br>";
		}
		return $status;
	}

	function getUrl($real = true) {
		global $bw;
		if ($real)
			return $this->url;
		return $bw->vars ['board_url'] . '/' . $this->url;
	}

	function getSlug($space = "-") {
		global $bw;
		if ($this->slug)
			return $this->slug;
		else
			return parent::getSlug ( $space );
	}

	function getTemplate() {
		global $bw;
		return $this->template;
	}

	function setSlug($slug) {
		global $bw;
		return $this->slug = $slug;
	}

	function getUrlCategory($post = false) {
		global $bw;
		if ($post)
			return $this->url . "/category/".$this->getSlugId ();
		return $bw->base_url . $this->url . "/category/".$this->getSlugId ();
	}

	function getUrlCatePag($post = false) {
		global $bw;
		if ($post)
			return $this->url . "/category/$this->id";
		return $this->url . "/category/$this->id";
	}

	function getUrlRSS() {
		global $bw;
		return $bw->vars ['board_url'] . "/rss/" . strtolower ( VSFTextCode::removeAccent ( str_replace ( "/", '-', trim ( $this->title ) ), '-' ) ) . '-' . $this->id . '.rss';
	}

	function getClassActive() {
		global $bw, $vsMenu;
		
		if ($bw->input ['vs'] == "home" && trim ( $this->url, "/" ) == trim ( $bw->vars ['board_url'], "/" )) {
			return 'active';
		}
	}

	function getFileId() {
		return $this->fileId;
	}

	function setFileId($fileId) {
		$this->fileId = $fileId;
	}

	function __construct() {
		parent::__construct ();
	}

	function __destruct() {
		unset ( $this->langId );
		unset ( $this->id );
		unset ( $this->url );
		unset ( $this->title );
		unset ( $this->status );
		unset ( $this->index );
		unset ( $this->alt );
		unset ( $this->parentId );
		unset ( $this->isLink );
		unset ( $this->isDropdown );
		unset ( $this->isAdmin );
		unset ( $this->level );
		unset ( $this->type );
		unset ( $this->top );
		unset ( $this->main );
		unset ( $this->right );
		unset ( $this->bottom );
		unset ( $this->left );
		unset ( $this->fileId );
		unset ( $this->backup );
		unset ( $this->children );
	}

	function __set_state($array = array()) {
		$menu = new Menu ();
		foreach ( $array as $key => $value ) {
			$menu->$key = $value;
		}
		return $menu;
	}

	function setTemplate($template) {
		$this->template = $template;
	}

	function setLangId($langId = 0) {
		$this->langId = intval ( $langId );
	}

	function getLangId() {
		return $this->langId;
	}

	function setChild($menu) {
		$this->children [$menu->getId ()] = $menu;
	}

	function &getChildren() {
		return $this->children ? $this->children : array ();
	}

	function getAlt() {
		return $this->alt;
	}

	function getIsAdmin() {
		return $this->isAdmin;
	}

	function getIsDropdown() {
		return $this->isDropdown;
	}

	function getIsLink() {
		return $this->isLink;
	}

	function getValue() {
		return $this->isLink;
	}

	function getLevel() {
		return $this->level;
	}

	function getUtilitys() {
		if (is_array ( $this->isDropdown ))
			return $this->isDropdown;
		if ($this->isDropdown)
			return explode ( ',', $this->isDropdown );
		return array ();
	}

	function getBenefits() {
		if (is_array ( $this->isLink ))
			return $this->isLink;
		if ($this->isLink)
			return explode ( ',', $this->isLink );
		return array ();
	}

	function getParentId() {
		return $this->parentId;
	}

	function getPosition($position = "top") {
		return $this->$position;
	}

	function getType() {
		return $this->type;
	}

	function get_type_unit() {
		if (is_array ( $this->alt ))
			return $this->alt;
		return $this->alt ? $this->alt = unserialize ( $this->alt ) : '';
		return array ();
	}

	function get_areas_type() {
		if (is_array ( $this->fileId ))
			return $this->fileId;
		return $this->fileId ? $this->fileId = explode ( ',', $this->fileId ) : '';
		return array ();
	}

	function getCatUrl($url = '') {
		global $bw;
		
		$url = $url ? $url : "{$this->url}/category/";
		
		return $bw->base_url . $url . $this->getSlugId ();
	}


	function getPermalink(){
		global $bw;
	
		return $bw->vars ['board_url'] . "/{$this->url}/category/<span id='editable-mUrl'>". $this->getSlug () . '</span>.html';
	}
	
	
	/*function getSlugId() {
		return $this->getSlug ().".html";
	}*/
	
	// $alt
	function setAlt($alt) {
		$this->alt = $alt;
	}
	
	// $isAdmin
	function setIsAdmin($isAdmin) {
		$this->isAdmin = $isAdmin;
	}
	
	// $isDropdown
	function setIsDropdown($isDropdown) {
		$this->isDropdown = $isDropdown;
	}
	
	// $isLink
	function setIsLink($isLink) {
		$this->isLink = $isLink;
	}

	function setLevel($level) {
		$this->level = $level;
	}
	
	// $parentId
	function setParentId($parentId) {
		$this->parentId = intval ( $parentId );
	}
	
	// $position
	function setPosition($position) {
		if (! $position)
			return;
		$this->$position = 1;
	}
	
	// $type
	function setType($type) {
		$this->type = $type;
	}

	function getImage() {
		return $this->fileId;
	}

	function getChildrenLi() {
		$re = "";
		if ($this->children) {
			foreach ( $this->children as $obj )
				$re .= "<li><a href='{$obj->getUrl(0)}' title='{$obj->getTitle()}' target='_blank'>{$obj->getTitle()}</a></li>";
		}
		return $re;
	}

	function getChildrenBoxOption($selectedId = '',$lever=true) {
		$option = "";
		foreach ( $this->getChildren () as $menu ) {
			$i = $menu->getLevel ();
			$title = $menu->getTitle ();
			while ( $i > 2 ) {
				$title = "--" . $title;
				$i --;
			}
			$selected = "";
			if ($selectedId == $menu->getId ())
				$selected = "selected='selected'";
			$option .= "<option $selected value='{$menu->getId()}'>{$title}</option>";
			if($lever) $option .= $menu->getChildrenBoxOption ( $selectedId );
		}
		return $option;
	}
	var $quick;
	/**
	 * @return the $quick
	 */
	public function getQuick() {
		return $this->quick;
	}

	/**
	 * @param field_type $quick
	 */
	public function setQuick($quick) {
		$this->quick = $quick;
	}

}
?>