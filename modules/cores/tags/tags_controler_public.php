<?php
require_once(CORE_PATH.'tags/tags.php');

class tags_controler_public extends VSControl_public {

	public	function auto_run(){
	
	global $bw;
				switch ($bw->input['action']) {
//			case $this->modelName.'_some_action':
//				$this->someMethod($bw->input[2]);
//				break;
			default:
				parent::auto_run();
				break;
		}

	}





	function getHtml(){
		return $this->html;
	}



	function setHtml($html){
		$this->html=$html;
	}



	
	/**
	*
	*@var tags
	**/
	var		$model;

	
	/**
	*
	*@var skin_tags
	**/
	var		$html;
}
