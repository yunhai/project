<?php
require_once(LIBS_PATH.'boards/VSAdminBoard.php');

class contacts_admin extends VSAdminBoard {


	/**
	*auto run function
	*System IDE create
	**/
	public	function auto_run(){
		global $bw,$vsPrint;	
		$vsPrint->addExternalJavaScriptFile("http://maps.google.com/maps/api/js?sensor=true&language=vi");	
		$this->tabs[]=array(
				'id'=>'contacts',
				'href'=>"{$bw->base_url}contacts/contacts_display_tab/&ajax=1",
				'title'=>$this->getLang()->getWords("tab_contact",'contact'),
				'default'=>0,
		);
		$this->tabs[]=array(
				'id'=>'pcontacts',
				'href'=>"{$bw->base_url}contacts/pcontacts_display_tab/&ajax=1",
				'title'=>$this->getLang()->getWords("tab_pcontact",'pcontact'),
				'default'=>0,
		);
	if(VSFactory::getSettings()->getSystemKey ( $bw->input[0]. '_category_list', 0, $bw->input[0] )){
			$this->tabs[]=array(
				'href'=>"{$bw->base_url}menus/display-category-tab/{$bw->input[0]}/&ajax=1",
				'title'=>$this->getLang()->getWords("{$bw->input[0]}_category","{$bw->input[0]} Category"),
				'default'=>0,
				);
	}
	
	if(VSFactory::getSettings()->getSystemKey ( $bw->input[0]. '_settings_tab', 0, $bw->input[0] )){
			$this->tabs[]=array(
				'href'=>"{$bw->base_url}settings/moduleObjTab/{$bw->input[0]}/&ajax=1",
				'title'=>$this->getLang()->getWords("{$bw->input[0]}_ss","{$bw->input[0]} Settings"),
				'default'=>0,
				);
	}
		parent::auto_run();
		
	}
	


}
