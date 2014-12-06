<?php
require_once LIBS_PATH.'boards/addons/Addon.class.php';
class addon_admin_board extends VSAddon{
	var $html=NULL;
	/**
	 * @return the $html
	 */
	public function getHtml() {
		global $vsTemplate;
		if($this->html===NULL){
			$this->html=$vsTemplate->load_template("skin_addon");
		}
		return $this->html;
	}

	/**
	 * @param $html the $html to set
	 */
	public function setHtml($html) {
		$this->html = $html;
	}

	function getMenuTop(){
		global $vsTemplate,$bw;
		if($this->menus===NULL){
			$vsMenu = VSFactory::getMenus();
			$vsMenu->basicObject->setIsAdmin(1);
			$vsMenu->basicObject->setStatus(1);
			$vsMenu->basicObject->setPosition('top');
			$vsMenu->basicObject->setTitle('Categories');
	
			$this->menus=$vsMenu->getAdminMenu();
// 			$vsMenu->filterMenuPermission($this->menus);
			$vsMenu->basicObject->setLangId($_SESSION [APPLICATION_TYPE] ['language']['vsfcurrentLang']['langId']);
		}
		
		foreach ($this->menus as $menu ) {
			
			$url = str_replace($bw->base_url, "", $menu->getUrl (false));

			if (@strpos ( $bw->input ['vs'], trim ( $url, '/' ) ) === 0) {
				$menu->active = "active";
			}
			if ($bw->vars ['public_frontpage'] == $bw->input ['vs'] && $url == '') {
				$menu->active = "active";
			}
		}
		
		return $this->menus;
	}
	function getLangList(){
		global $vsStd, $vsTemplate;
        $vsStd->requireFile ( CORE_PATH . "languages/languages.php" );         
		if (! isset($_SESSION [APPLICATION_TYPE] ['language']['vsfcurrentLang'] )) {
			$oLanguages = new languages ( );
			//$oLanguages->language->setAdminDefault ( 1 );
			$langResult = $oLanguages->getLangByObject ( array ('getAdminDefault'), $oLanguages->arrayLang );
				
			reset($langResult);
			$language = current($langResult);
			$_SESSION [APPLICATION_TYPE]['language']['vsfcurrentLang'] = $language->convertToDB();
		}
		$currentUserLanguage = new Lang1 ( );
		$currentUserLanguage->convertToObject ( $_SESSION [APPLICATION_TYPE] ['language']['vsfcurrentLang'] );
		
		$languages = new languages();
		
		return $this->getHtml()->userLanguages($languages->getObjectsByCondition(), $title);
	}
	function getNotify(){
		global $vsStd;
//		$vsStd->requireFile(CORE_PATH.'notifys/notifys.php');
//		$notify = new notifys();
//		$option = $notify->getUserNotify(VSFactory::getAdmins()->basicObject->getId());
//		
//		if($option['total']) return $this->getHtml()->notifyList($option);
//		else 
		return "";
	}
	function getAcpHelp(){
		global $bw, $vsSkin;
		$DB = VSFactory::createConnectionDB();
		$curr_action	=	$bw->input['module'];
		if($bw->input['action']!=""){
			$curr_action	.=	"::".$bw->input['action'];
		}

		$curr_LangId	=	$_SESSION[APPLICATION_TYPE]['language']['vsfcurrentLang']['id'];
		$DB->simple_construct	(	array(	'select'	=>	'*',
                                                        'from'		=>	'acp_help',
                                                        'where'		=>	'langId='.$curr_LangId.' AND `module_key`="'.$curr_action.'"',
                                                        'order'		=>	'id'
                                        ));
                                        $DB->simple_exec();
                                        if($acp_help	=	$DB->fetch_row()){
                                                return 	$this->getHtml()->acpHelpHTML($acp_help);
                                        }
                return "";
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
}

?>