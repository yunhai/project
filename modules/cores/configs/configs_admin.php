<?php
require_once(LIBS_PATH.'boards/VSAdminBoard.php');

class configs_admin extends VSAdminBoard {


	/**
	*auto run function
	*System IDE create
	**/
	public	function auto_run(){
		global $bw,$vsPrint;	
	$this->tabs[]=array(
				'href'=>"{$bw->base_url}settings/moduleObjTab/configs/&ajax=1",
				'title'=>$this->getLang()->getWords("configs","Thiết lập"),
				'default'=>0,
				);
		parent::auto_run();
	}
	


}
