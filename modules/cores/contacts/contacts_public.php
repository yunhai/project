<?php
/*
 +-----------------------------------------------------------------------------
 |   VSF version 5.0
 |	Author: System
 |	Homepage: http://www.vietsol.net
 |	If you use this code, please don't delete these comment lines!
 |	Start Date: 
 |	Finish Date: 
 |	Modified Start Date: 
 |	Modified Finish Date: 
 |	News Description: this file created by auto system
 +-----------------------------------------------------------------------------
 */
require_once LIBS_PATH.'boards/VSPublicBoard.php';
class contacts_public extends VSPublicBoard{
	function auto_run(){
		global $bw;
		parent::auto_run($bw->input[0],"pcontacts");
	}
}
?>