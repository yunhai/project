<?php
require_once LIBS_PATH.'boards/skins/skins_board.php';
class skin_board_public extends skins_board{
	/**
	 * @return addon_public
	 */
	function getAddon(){
		static $addon=null;
		if($addon===NULL){
		require_once INC_PATH . 'addon_public.php' ; 
			$addon=new addon_public();
		}
		return $addon;
	}

}
?>