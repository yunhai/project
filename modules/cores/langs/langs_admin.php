<?php
require_once(LIBS_PATH.'boards/VSAdminBoard.php');

class langs_admin extends VSAdminBoard {


	/**
	*auto run function
	*System IDE create
	**/
	function auto_run(){
	
		global $bw;		
			
		$this->tabs[]=array(
				'href'=>"{$bw->base_url}langs/langs_display_tab/&ajax=1",
				'title'=>$this->getLang()->getWords("tab_lang",'lang'),
				'default'=>0,
		);
		if(!VSFactory::getSettings()->getSystemKey ( $bw->input[0]. '_vslang_tab', 0, $bw->input[0] )){
			$this->tabs[]=array(
					'href'=>"{$bw->base_url}langs/vlanguages_display_tab/&ajax=1",
					'title'=>$this->getLang()->getWords("tab_language",'language'),
					'default'=>0,
			);
		}
	if(VSFactory::getSettings()->getSystemKey ( $bw->input[0]. '_category_list', 0, $bw->input[0] )){
			$this->tabs[]=array(
				'href'=>"{$bw->base_url}menus/display-category-tab/{$bw->input[0]}/&ajax=1",
				'title'=>$this->getLang()->getWords("{$bw->input[0]}_category","{$bw->input[0]} Category"),
				'default'=>0,
				);
	}
	
		parent::auto_run();
	}
}
