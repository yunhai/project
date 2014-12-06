<?php
require_once CORE_PATH.'modules/modules.php';
class modules_controler extends VSControl_admin {
	function __construct($modelName){
		global $vsTemplate,$bw;
//		$this->html=$vsTemplate->load_template("skin_module");
		parent::__construct($modelName,"skin_modules","module");
		//$this->model->categoryName=$bw->input[0];
	}
	
	function addEditObjForm($objId = 0, $option = array()) {
		global  $vsStd, $bw, $vsPrint;
		
		$obj=$this->model->getObjectById($objId);
		$option['vdata']=$_REQUEST['vdata'];
		if(count($_GET['search'])){
			$tmp['search']=$_GET['search'];
	        $bw->input['back']=$bw->input['back']="/".$bw->input[0]."/".$this->modelName."_search&".urldecode( http_build_query($tmp	));
		}else{
			$bw->input['back']="/{$bw->input[0]}/{$this->modelName}_display_tab/";
		}
		$bw->input['back'].="&pageIndex=".$bw->input['pageIndex'];
		
		$this->model->setCondition("isParent =1 ");
		$option['parent']=$this->model->getObjectsByCondition();
		
		return $this->output = $this->html->addEditObjForm ( $obj, $option );
	}

function addEditObjProcess() {
		global $bw, $vsStd;
		/****file processing**************/
//		if(is_array($bw->input['files'])){
//			foreach ($bw->input['files'] as $name=> $file) {
//				$bw->input[$this->modelName][$name]=$file;
//			}
//			
//		}
//        if(is_array($bw->input['links'])){
//			foreach ($bw->input['links'] as $name=> $value) {
//				$url=parse_url($value);
//				if($bw->input['filetype'][$name]=='link'&&$url['host']){
//					$files=new files();
//					$fid=$files->copyFile($value,$bw->input[0]);
//					if($fid)
//					$bw->input[$this->modelName][$name]=$fid;
//				}
//				unset($url);
//			}
//			
//		}
		if(!$bw->input[$this->modelName]['isParent']){
			$bw->input[$this->modelName]['isParent']=0;
		}
		if(!$bw->input[$this->modelName]['isAdmin']){
			$bw->input[$this->modelName]['isAdmin']=0;
		}
		if(!$bw->input[$this->modelName]['isUser']){
			$bw->input[$this->modelName]['isUser']=0;
		}
		if(!$bw->input[$this->modelName]['virtual']){
			$bw->input[$this->modelName]['virtual']=0;
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
			/////delete some here..........................................
		}else{
			$bw->input[$this->modelName]['postDate']=time();
			
			/////delete some here before inserting...................
		}
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
	/**
	 * 
	 * @var modules
	 */
	protected $model;
	
	
    function getListLangObject(){
         	
    }
       /**
        * 
        * @param BasicObject
        */ 
    protected  function  onDeleteObject($obj){
    }
	public function getHtml() {
		return $this->html;
	}
	
	public function getOutput() {
		return $this->output;
	}
	
	public function setHtml($html) {
		$this->html = $html;
	}
	
	public function setOutput($output) {
		$this->output = $output;
	}
	/**
	 * 
	 * Enter description here ...
	 * @var skin_modules
	 */
	public $html;
}

?>