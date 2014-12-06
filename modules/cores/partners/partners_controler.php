<?php
require_once(CORE_PATH.'partners/partners.php');

class partners_controler extends VSControl_admin {

		function __construct($modelName){
			global $vsTemplate,$bw;//		$this->html=$vsTemplate->load_template("skin_partners");
		//parent::__construct($modelName,"skin_partners","partner");
		parent::__construct($modelName,"skin_partners","partner",$bw->input[0]);
		//$this->model->categoryName="partners";

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
	*Skins for partner ...
	*@var skin_partners
	**/
	var		$html;

	
	/**
	*String code return to browser
	**/
	var		$output;
}
