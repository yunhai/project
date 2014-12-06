<?php
require_once(CORE_PATH.'faqs/faqs.php');

class faqs_controler extends VSControl_admin {

		function __construct($modelName){
			global $vsTemplate,$bw;//		$this->html=$vsTemplate->load_template("skin_faqs");
		parent::__construct($modelName,"skin_faqs","faq");
		$this->model->categoryName="faqs";

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
	*Skins for faq ...
	*@var skin_faqs
	**/
	var		$html;

	
	/**
	*String code return to browser
	**/
	var		$output;
}
