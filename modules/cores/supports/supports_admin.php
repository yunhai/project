<?php
require_once(LIBS_PATH.'boards/VSAdminBoard.php');

class supports_admin extends VSAdminBoard {


	/**
	*auto run function
	*System IDE create
	**/
	public	function auto_run(){
	
		global $bw;		$this->tabs[]=array(
				'href'=>"{$bw->base_url}supports/supports_display_tab/&ajax=1",
				'title'=>$this->getLang()->getWords("tab_support",'support'),
				'default'=>0,
		);
		if(VSFactory::getSettings()->getSystemKey ( $bw->input[0]. 'supporttypes_display_tab', 0, $bw->input[0] )){
		$this->tabs[]=array(
				'href'=>"{$bw->base_url}supports/supporttypes_display_tab/&ajax=1",
				'title'=>$this->getLang()->getWords("tab_supporttype",'supporttype'),
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
