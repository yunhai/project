<?php
require_once(LIBS_PATH.'boards/VSAdminBoard.php');

class tags_admin extends VSAdminBoard {


	/**
	*auto run function
	*System IDE create
	**/
	public	function auto_run(){
	
		global $bw;		$this->tabs[]=array(
				'id'=>'tags',
				'href'=>"{$bw->base_url}tags/tags_display_tab/&ajax=1",
				'title'=>$this->getLang()->getWords("tab_tag",'tag'),
				'default'=>0,
		);
	if(VSFactory::getSettings()->getSystemKey ( $bw->input[0]. '_category_list', 0, $bw->input[0] )){
			$this->tabs[]=array(
				'id'=>'categorys_tagss',
				'href'=>"{$bw->base_url}menus/display-category-tab/{$bw->input[0]}/&ajax=1",
				'title'=>$this->getLang()->getWords("{$bw->input[0]}_category","{$bw->input[0]} Category"),
				'default'=>0,
				);
	}
		parent::auto_run();
	}



}
