<?php
require_once LIBS_PATH.'boards/skins/skins_board.php';
class skin_board_admin extends skins_board{
	/**
	 * @return addon_admin
	 */
	function getAddon(){
		static $addon=null;
		if($addon===NULL){
		require_once INC_PATH . 'addon_admin.php' ; 
			$addon=new addon_admin();
		}
		return $addon;
	}
	function getMenu(){
		return VSFactory::getMenus();
	}
}

?>