<?php
require_once(CORE_PATH.'products/productlabels.php');

class productlabels_controler extends VSControl_admin {

		function __construct($modelName){
			global $vsTemplate,$bw;//		$this->html=$vsTemplate->load_template("skin_productlabels");
		parent::__construct($modelName,"skin_productlabels","productlabel");
		$this->model->categoryName="productlabels";

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
	*Skins for productlabel ...
	*@var skin_productlabels
	**/
	var		$html;

	
	/**
	*String code return to browser
	**/
	var		$output;
}
