<?php
require_once(CORE_PATH.'supports/supporttypes.php');

class supporttypes_controler extends VSControl_admin {

		function __construct($modelName){
			global $vsTemplate,$bw;//		$this->html=$vsTemplate->load_template("skin_supporttypes");
		parent::__construct($modelName,"skin_supporttypes","supporttype");
		$this->model->categoryName="supporttypes";

	}

function addEditObjProcess() {
		global $bw, $vsStd;
		if($bw->input[$this->modelName]['id']){
			$this->model->getObjectById($bw->input[$this->modelName]['id']);
			if($this->model->basicObject->getId()){
				if($bw->input['files']['onImage']){
					$files=new files();
					$files->deleteFile($this->model->basicObject->getOnImage());				
				}
				if($bw->input['files']['offImage']){
					$files=new files();
					$files->deleteFile($this->model->basicObject->getOffImage());				
				}
			}
			
			/////delete some here..........................................
		}
		return parent::addEditObjProcess();
		
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
	*Skins for supporttype ...
	*@var skin_supporttypes
	**/
	var		$html;

	
	/**
	*String code return to browser
	**/
	var		$output;
}
