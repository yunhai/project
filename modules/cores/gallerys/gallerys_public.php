<?php
require_once LIBS_PATH.'boards/VSPublicBoard.php';
class gallerys_public extends VSPublicBoard{
	function auto_run(){
		global $bw,$vsModule;
		parent::auto_run($vsModule->basicObject->getClass());
	}
	
}
?>