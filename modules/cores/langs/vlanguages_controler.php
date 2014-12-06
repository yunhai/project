<?php
require_once(CORE_PATH.'langs/vlanguages.php');

class vlanguages_controler extends VSControl_admin {
	function __construct($modelName){
		global $vsTemplate, $bw;
		parent::__construct($modelName, "skin_vlanguages", "langs");
	}

	function auto_run(){
		global $bw;
		switch($bw->input[1]){
			case $this->modelName.'_display_tab' :
				$this->displayObjTab ();
				break;
			
			case $this->modelName.'_visible_checked' :
				$this->checkShowAll(1);
				break;
		
			
			case $this->modelName.'_hide_checked' :
				$this->checkShowAll(0);
				break;
			case $this->modelName.'_display_list' :
				$this->getObjList ( $bw->input [2], $this->model->result ['message'] );
				break;
			
			case $this->modelName.'_add_edit_form' :
				$this->addEditObjForm ( $bw->input [2] );
				break;
			
			case $this->modelName.'_add_edit_process' :
				$this->addEditObjProcess ();
				break;
			
			case $this->modelName.'_delete' :
				$this->deleteObj($bw->input[2]);
				break;
			
			default :
				$this->loadDefault ();
				break;
		}
	}

	

	function getObjList($catId = '', $message = "") {
		global $bw;
		$option['message']=str_replace(array("'","\n"),array("\\'","\\n"), $message) ;
		$catId=intval($catId);
		if($_REQUEST['vdata']){
			$vdata=json_decode($_REQUEST['vdata'],true);
		}
		if($vdata['search']){//last query search
			$bw->input['search']=$vdata['search'];
			$option['table']=$this->displaySearch();
		}else{
			if($bw->input['pageIndex']){
				$bw->input[2]=$bw->input['pageIndex'];
			}
			
			$url = $bw->input[0]."/{$this->modelName}_display_tab/";
			$size = VSFactory::getSettings()->getSystemKey("{$this->modelName}_paging_limit",20);
			$option= array_merge($option, 
								 $this->model->getPageList($url, 2, $size, 1, "vs_panel_{$this->modelName}"));
			$bw->input['pageIndex']=$bw->input[2];
			$option['table']=$this->html->getListItemTable ($this->model->getArrayObj(), $option );
		}
		
		return $this->output = $this->html->objListHtml ( $option );
	}
	
	function addEditObjForm($objId = 0, $option = array()) {
		global  $vsStd, $bw, $vsPrint;
		$obj=$this->model->getObjectById($objId);
		$option['vdata']=$_REQUEST['vdata'];
		$option['langs'] = $this->model->getObjectsByCondition();
		return $this->output = $this->html->addEditObjForm ( $obj, $option );
	}
	
	function addEditObjProcess() {
		global $bw, $vsStd;
		
		if($bw->input['vlanguages']['adminDefault'] || $bw->input['vlanguages']['userDefault']){
			$query = "UPDATE vsf_langs SET "; $flag = false;
			if($bw->input['vlanguages']['adminDefault']){
				$query .= " adminDefault = 0, "; 
			}
			
			if($bw->input['vlanguages']['userDefault']){
				$query .= " userDefault = 0, "; 
			}
			$query = trim($query, ', ');
			$this->model->executeNoneQuery($query);
		}
		
		if($bw->input[$this->modelName]['id']){
			$this->model->getObjectById($bw->input[$this->modelName]['id']);
			if(!$this->model->basicObject->getId()){
				return $this->output =  $this->getObjList ($bw->input['pageIndex'],"Not define object of id={$bw->input[$this->modelName]['id']} submited!");
			}
		}
		
		$this->model->basicObject->convertToObject($bw->input[$this->modelName]);
		
		if($this->model->basicObject->getId()){
			$this->model->updateObject();
			$message='Update success!';
		}else{
			$this->model->insertObject();
			$message='Insert success!';
		}
		if($this->model->result['status']){
			$DB = VSFactory::createConnectionDB();
			if(!$DB->field_exists($bw->input['vlanguages']['code'], 'lang')){
				$query = "ALTER TABLE vsf_lang ADD {$bw->input['vlanguages']['code']} VARCHAR( 512 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL";
				$this->model->executeNoneQuery($query);
			}
		}else{
			$message=$this->model->result['developer'];
		}

		return $this->output =  $this->getObjList ($bw->input['pageIndex'],$message);
	}

	function deleteObj($ids, $cate = 0){
		global $bw,$vsStd;
		
		if(!$ids) return $this->output = $this->getObjList($cate);
		
		$this->model->setCondition("{$this->model->getPrimaryField()} IN (".$ids .")");
		$list = $this->model->getObjectsByCondition();
		if(!count($list)) return false;
		$this->model->setCondition("`{$this->model->getPrimaryField()}` IN (".$ids .")");
		if(!$this->model->deleteObjectByCondition()) return false;
		$DB = VSFactory::createConnectionDB();
		foreach($list as $element){
			$code = $element->getCode();
			if($DB->field_exists($code, 'lang')){
			$query = 'ALTER TABLE `vsf_lang` DROP '.$code;
			$this->model->executeNoneQuery($query);
			}
		}
		
		return $this->output = $this->getObjList($cate);
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
	*Skins for lang ...
	*@var skin_langs
	**/
	var		$html;

	
	/**
	*String code return to browser
	**/
	var		$output;
}
