<?php
require_once(CORE_PATH.'banners/bannerpos.php');

class bannerpos_controler extends VSControl_admin {

		function __construct($modelName){
			global $vsTemplate,$bw;//		$this->html=$vsTemplate->load_template("skin_bannerpos");
		parent::__construct($modelName,"skin_bannerpos","bannerpo");
		//$this->model->categoryName="bannerpos";

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
	*Skins for bannerpo ...
	*@var skin_bannerpos
	**/
	var		$html;

	
	/**
	*String code return to browser
	**/
	var		$output;
}
