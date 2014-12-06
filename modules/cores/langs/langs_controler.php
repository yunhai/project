<?php
require_once(CORE_PATH.'langs/langs.php');

class langs_controler extends VSControl_admin {

		function __construct($modelName){
			global $vsTemplate, $bw;
			
			$this->deleteDir ( CACHE_PATH . "langs/" );
			parent::__construct($modelName,"skin_langs","lang");
			$this->model->categoryName="langs";
		}
	
	
	private static function deleteDir($dirPath) {
		if (! is_dir ( $dirPath )) {
			return;
		}
		if (substr ( $dirPath, strlen ( $dirPath ) - 1, 1 ) != '/') {
			$dirPath .= '/';
		}
		$files = glob ( $dirPath . '*', GLOB_MARK );
		foreach ( $files as $file ) {
			if (is_dir ( $file )) {
				self::deleteDir ( $file );
			} else {
				unlink ( $file );
			}
		}
		rmdir ( $dirPath );
	}

	function auto_run(){
		global $bw;
		if(in_array($bw->input[1],array($this->modelName.'_add_edit_process',$this->modelName.'_delete',))){
				VSFactory::getLangs()->clearCache();
		}
		switch($bw->input[1]){
			case $this->modelName.'_update' :
				$this->update();
				break;
				
			case $this->modelName.'_search' :
				$this->displaySearch();
				break;
				
			case $this->modelName.'_display_tab' :
				$this->displayObjTab ();
				break;	
				
			default :
				parent::auto_run();
				break;
				
			case 'language_tab':
					$this->languageTab();
				break;
		}
	}

	function languageTab(){
		$languages = new languages();
		$temp =  $languages->getObjectsByCondition();
		
		return $this->output = $this->html->objListHtml_languages($option);
	}
	
	function displayObjTab() {
		global $bw;
		$option ['objList'] = $this->getObjList();
               
		return $this->output = $this->html->displayObjTab ( $option );
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
			$option['table'] = $this->displaySearch();
			
			$languages = new languages();
			$cond = 'status > 0';
			$languages->setCondition($cond);
			$option['langs'] = $languages->getObjectsByCondition();
		}else{
			if($bw->input['pageIndex']) $bw->input[2] = $bw->input['pageIndex'];
			
			if(!VSFactory::getAdmins()->basicObject->checkPermission('view_root_langs')){
				$this->model->setCondition('`root` = 0');
			}
			
			$url = $bw->input [0]."/{$this->modelName}_display_tab/";
			$size = VSFactory::getSettings()->getSystemKey("{$this->modelName}_paging_limit",20);
			$option=array_merge($option, $this->model->getPageList($url, 2, $size, 1, "vs_panel_{$this->modelName}"));
			
			$bw->input['pageIndex']=$bw->input[2];
			$languages = new languages();
			$cond = 'status > 0';
			$languages->setCondition($cond);
			$option['langs'] =  $languages->getObjectsByCondition();
			$option['table'] = $this->html->getListItemTable ($this->model->getArrayObj(), $option );
		}
		

		return $this->output = $this->html->objListHtml($option);
	}
	
	function update(){
		global $bw;
		$this->deleteDir ( CACHE_PATH . "langs/" );
		if($bw->input['vdata']){
			$vdata = json_decode($_REQUEST['vdata'], true);
			$langs = $vdata['search']['lang'];
			if(!$langs){
				return $this->output = $this->getObjList();
			} 
			
			foreach($langs as $element){
				if($bw->input[$element]){
					$ids = array_keys($bw->input[$element]);
				}
				$langcodes .= "'".$element."',";
			}
			$langcodes = trim($langcodes, ',');
			
			$languages = new languages();
			$cond = 'status > 0 AND code IN ('.$langcodes.')';
			$languages->setCondition($cond);
			$temp =  $languages->getObjectsByCondition();
		}else{
			$ids = array_keys($bw->input['en']);
			$languages = new languages();
			$cond = 'status > 0';
			$languages->setCondition($cond);
			$temp =  $languages->getObjectsByCondition();
		}
	
		foreach($ids as $id){
			$query = "UPDATE vsf_lang SET ";
			foreach($temp as $l){
				$code = $l->getCode();
				$query .= $code." = '".mysql_real_escape_string($bw->input[$code][$id])."', ";
			}
			if(isset($bw->input['root'][$id]))
			$query .= "`root` = '".$bw->input['root'][$id]."', ";
			$query = trim($query, ', ');
			$query .= ' WHERE id ='.$id;
			
			$this->model->executeNoneQuery($query);
		}
		return $this->output = $this->getObjList();
	}

	function displaySearch(){
		global $bw;

        if($bw->input['sformat']){
        	$bw->input['search']['id'] = $bw->input['sid'];
        	$bw->input['search']['title'] = $bw->input['stitle'];
        	$bw->input['search']['module'] = $bw->input['smodule'];
        	if($bw->input['stype']){
        		$stype = trim($bw->input['stype'], ',');
        		$bw->input['search']['type'] = explode(',', $stype);
        	}
        	if(isset($bw->input['sroot'])){
        		$sroot = trim($bw->input['sroot'], ',');
        		$bw->input['search']['root'] = explode(',', $sroot);
        	}
        }
		if($bw->input['slang']){
			$stype = trim($bw->input['slang'], ',');
			$list= explode(',', $stype);
			foreach ($list as $value){
				$bw->input['search']['lang'][$value]=$value;
			}
        }
		$cond = 'status > 0';
		
		$where = ""; $suburl = "";
		if($bw->input['search']['title']){
			$languages = new languages();
			$languages->setCondition($cond);
			$langs =  $languages->getObjectsByCondition();
		
			$DB = VSFactory::createConnectionDB();
			$title = $bw->input['search']['title'];
			$subwhere = "`key` LIKE '%{$title}%' OR ";
			foreach($langs as $l){
				$code = $l->getCode();
				if($DB->field_exists($code, 'lang')){
					$subwhere .= $code." LIKE '%".$title."%' OR ";
				}
			}
			
			$subwhere = trim($subwhere, 'OR ');
			$where .= " (".$subwhere.") AND ";
			$suburl .= 'stitle='.$bw->input['search']['title'].'&';
		}
		
		if($bw->input['search']['id']){
			$where .= " `id` ='{$bw->input['search']['id']}' AND ";
			$suburl .= 'sid='.$bw->input['search']['id'].'&';
		}
        	
		if($bw->input['search']['module']){
			$where .= " module LIKE '%{$bw->input['search']['module']}%' AND ";
			$suburl .= 'smodule='.$bw->input['search']['module'].'&';
		}
		if($bw->input['search']['type']){
			foreach($bw->input['search']['type'] as $value){
				$type .= "'".$value."', ";
				$utype .= $value.",";
			}
			
			$type = trim($type, ', ');
			$where .= " type IN ({$type}) AND ";
			$suburl .= 'stype='.$utype.'&';
		}
		if($bw->input['search']['lang']){
        	foreach(array_keys($bw->input['search']['lang']) as $element){
        		$langcodes[] ="'".$element."'";
        		$slang .= $element.",";
        	}
        	//$langcodes = trim($langcodes, ",");
        	$suburl .= 'slang='.$slang.'&';
        }
        
		if(VSFactory::getAdmins()->basicObject->checkPermission('view_root_langs')){
			if($bw->input['search']['root']){
				$subroot = '';
				foreach($bw->input['search']['root'] as $root){
					$subroot .= '`root` = '.$root.' OR ';
				}
				$subroot = '('.trim($subroot, 'OR ').')';
				$where .= $subroot." AND ";
				$suburl .= 'sroot='.implode(',', $bw->input['search']['root']).'&';
			}
		}else{
			$where .= '`root` = 0 AND ';
		}
		$where = trim($where, ' AND ');
        $this->model->setCondition($where);

        $url = $bw->input [0]."/{$this->modelName}_search/";
        $bw->input['advance'] = '&spage=1&sformat=1&'.trim($suburl,'&');
        $size = VSFactory::getSettings()->getSystemKey("{$this->modelName}_paging_limit",20);
        $option = $this->model->getPageList($url, 2, $size, 1, $this->modelName."_item_panel");
       
        $vdata['search']=$bw->input['search'];
        $option['vdata']=json_encode($vdata);
        
        if($bw->input['search']['lang']){
        	foreach(array_keys($bw->input['search']['lang']) as $element){
        		$langcodes[]="'".$element."'";
        	}
        }
		$cond = 'status > 0';
		if($langcodes) $cond .= ' AND code IN ('.implode(",", $langcodes).')';

		$languages = new languages();
		$languages->setCondition($cond);
		$option['langs'] =  $languages->getObjectsByCondition();
		return $this->output = $this->html->getListItemTable ($this->model->getArrayObj(), $option);
	}

	function addEditObjForm($objId = 0, $option = array()) {
		global  $vsStd, $bw, $vsPrint;
		$obj=$this->model->getObjectById($objId);
		$option['vdata']=$_REQUEST['vdata'];
		
		
		$languages = new languages();
		$cond = 'status > 0';
		$languages->setCondition($cond);
		$option['langs'] =  $languages->getObjectsByCondition();
		
		return $this->output = $this->html->addEditObjForm ( $obj, $option );
	}
	
	function addEditObjProcess() {
		global $bw, $vsStd;
		
		if($bw->input['id']){
			$this->model->getObjectById($bw->input[$this->modelName]['id']);
			if(!$this->model->basicObject->getId()){
				return $this->output =  $this->getObjList($bw->input['pageIndex'],"Not define object of id={$bw->input[$this->modelName]['id']} submited!");
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
		if(!$this->model->result['status']){
			$message=$this->model->result['developer'];
			
		}
		
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
	*Skins for lang ...
	*@var skin_langs
	**/
	var		$html;

	
	/**
	*String code return to browser
	**/
	var		$output;
}
