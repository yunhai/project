<?php
require_once(CORE_PATH.'assessments/assessments.php');

class assessments_controler extends VSControl_admin {

		function __construct($modelName){
			global $vsTemplate,$bw;//		$this->html=$vsTemplate->load_template("skin_assessments");
		parent::__construct($modelName,"skin_assessments","assessment");
		$this->model->categoryName="assessments";

	}





	function getHtml(){
		return $this->html;
	}



	function getOutput(){
		return $this->output;
	}



	function setHtml($html){
		$this->html=$html;
	}




	function setOutput($output){
		$this->output=$output;
	}



	
	/**
	*Skins for assessment ...
	*@var skin_assessments
	**/
	var		$html;

	
	/**
	*String code return to browser
	**/
	var		$output;
}
