<?php
require_once(LIBS_PATH.'boards/VSPublicBoard.php');

class proposals_public extends VSPublicBoard {

	public	function auto_run(){
	
		global $bw;
		parent::auto_run($bw->input[0]);


	}



}
