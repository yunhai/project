<?php
require_once(CORE_PATH.'supports/supports.php');

class supports_controler extends VSControl_admin {

		function __construct($modelName){
			global $vsTemplate,$bw;//		$this->html=$vsTemplate->load_template("skin_supports");
		parent::__construct($modelName,"skin_supports","support");
		$this->model->categoryName="supports";

	}
	function addEditObjForm($objId = 0, $option = array()) {
		global  $vsStd, $bw, $vsPrint;
		//require_once CORE_PATH.'supports/supporttypes.php';
		//$sptype=new supporttypes();
		//$option['type']=$sptype->getObjectsByCondition();
		return parent::addEditObjForm($objId,$option);
//		$obj=$this->model->getObjectById($objId);
//		$option['vdata']=$_REQUEST['vdata'];
//		return $this->output = $this->html->addEditObjForm ( $obj, $option );
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
	*Skins for support ...
	*@var skin_supports
	**/
	var		$html;

	
	/**
	*String code return to browser
	**/
	var		$output;
}
