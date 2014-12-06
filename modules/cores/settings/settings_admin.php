<?php
require_once(LIBS_PATH.'boards/VSAdminBoard.php');

class settings_admin extends VSAdminBoard {


	/**
	*auto run function
	*System IDE create
	**/
	public	function auto_run(){
	
		global $bw;		$this->tabs[]=array(
				'id'=>'settings',
				'href'=>"{$bw->base_url}settings/settings_display_tab/&ajax=1",
				'title'=>$this->getLang()->getWords("tab_setting",'setting'),
				'default'=>0,
		);
			/*$this->tabs[]=array(
				'id'=>'categorys_settingss',
				'href'=>"{$bw->base_url}menus/display-category-tab/{$bw->input[0]}/&ajax=1",
				'title'=>$this->getLang()->getWords("{$bw->input[0]}_category","{$bw->input[0]} Category"),
				'default'=>0,
				);
			*/
		parent::auto_run();
	}



}
