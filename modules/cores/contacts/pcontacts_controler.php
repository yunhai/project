<?php
require_once(CORE_PATH.'contacts/pcontacts.php');

class pcontacts_controler extends VSControl_admin {

		function __construct($modelName){
			global $vsTemplate,$bw;//		$this->html=$vsTemplate->load_template("skin_pcontacts");
			parent::__construct($modelName,"skin_pcontacts","pcontact","contacts");
	}


function addEditObjProcess() {
		global $bw, $vsStd;
		/****file processing**************/
		if(is_array($bw->input['files'])){
			foreach ($bw->input['files'] as $name=> $file) {
				$bw->input[$this->modelName][$name]=$file;
			}
			
		}
        if(is_array($bw->input['links'])){
			foreach ($bw->input['links'] as $name=> $value) {
				$url=parse_url($value);
				if($bw->input['filetype'][$name]=='link'&&$url['host']){
					$files=new files();
					$fid=$files->copyFile($value,$bw->input[0]);
					if($fid)
					$bw->input[$this->modelName][$name]=$fid;
				}
				unset($url);
			}
		}
		
		/****end file processing**************/
		if($bw->input[$this->modelName]['id']){
			$this->model->getObjectById($bw->input[$this->modelName]['id']);
			if(!$this->model->basicObject->getId()){
				return $this->output =  $this->getObjList ($bw->input['pageIndex'],"Not define object of id={$bw->input[$this->modelName]['id']} submited!");
			}
			if($bw->input[$this->modelName]['image']){
				$files=new files();
				$files->deleteFile($this->model->basicObject->getImage());				
			}
			
			if(VSFactory::getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_google_map", 1, $this->modelName)&&
				!($bw->input[$this->modelName]["longitude"] && $bw->input[$this->modelName]["latitude"])
			){
					
					if(($bw->input[$this->modelName]["address"] != $this->model->basicObject->getAddress())){
						$vsStd->requireFile(UTILS_PATH."googleMap.class.php");
						$googleMap = new googleMap();
						$address = $bw->input[$this->modelName]["address"];
						$googleMap->setAddress($address);
					
						$googleMap->getCoordinate();
						$bw->input[$this->modelName]["longitude"] = $googleMap->getLongitude();
						$bw->input[$this->modelName]["latitude"] = $googleMap->getLatitude();
					}	
			}	
		}else{
			$bw->input[$this->modelName]['postDate']=time();
			
			if(VSFactory::getSettings()->getSystemKey($bw->input[0].'_'.$this->modelName."_google_map",0, $this->modelName)&&
				!($bw->input[$this->modelName]["longitude"] && $bw->input[$this->modelName]["latitude"])
			){
					if(($bw->input[$this->modelName]["address"])){
					$vsStd->requireFile(UTILS_PATH."googleMap.class.php");
					$googleMap = new googleMap();
					$address = $bw->input[$this->modelName]["address"];
					$googleMap->setAddress($address);
				
					$googleMap->getCoordinate();
					$bw->input[$this->modelName]["longitude"] = $googleMap->getLongitude();
					$bw->input[$this->modelName]["latitude"] = $googleMap->getLatitude();
					}	
			}
		}
//		print "<pre>";
//		print_r ($bw->input[$this->modelName]);
//		print "</pre>";
		$this->model->basicObject->convertToObject($bw->input[$this->modelName]);
		if(!$this->model->basicObject->getCatId()){
			if($this->model->getCategoryField()){
				$this->model->basicObject->setCatId($this->model->getCategories()->getId());
			}
		}
		if($this->model->basicObject->getId()){
			$this->model->updateObject();
			$message='Update success!';
		}else{
			$this->model->insertObject();
			$message='Insert success!';
		}
		if(!$this->model->result['status']){
			$message=$this->model->result['developer'];
			
		}
		///////some here.....................
		
		return $this->output =  $this->getObjList ($bw->input['pageIndex'],$message);
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
	*Skins for pcontact ...
	*@var skin_pcontacts
	**/
	var		$html;

	
	/**
	*String code return to browser
	**/
	var		$output;
}
