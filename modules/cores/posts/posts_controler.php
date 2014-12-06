<?php
require_once (CORE_PATH . 'posts/posts.php');
class posts_controler extends VSControl_admin {

	function __construct($modelName) {
		global $vsTemplate, $bw; // $this->html=$vsTemplate->load_template("skin_posts");
		parent::__construct ( $modelName, "skin_posts", "post" );
		$this->model->categoryName = "posts";
		
	}

	function addEditObjProcess() {
		global $bw, $vsStd;
		/****file processing**************/
	
		$bw->input[$this->modelName]['module'] = $bw->input[0];
		$bw->input[$this->modelName]['hit'] = $bw->input[$this->modelName]['hit']?$bw->input[$this->modelName]['hit']:0;
		$bw->input[$this->modelName]['publishDate']= VSFactory::getDateTime()->TimeToInt($bw->input[$this->modelName]['publishDate']);
		$bw->input[$this->modelName]['lastModify']= VSFactory::getDateTime()->TimeToInt($bw->input[$this->modelName]['lastModify']);
		
		$arr = explode(" ", $bw->input[$this->modelName]['postDate']);
		$arr = array_merge(explode(":", $arr[1]), explode("/", $arr[0]),$arr);
		
		$bw->input[$this->modelName]['postDate']= gmmktime($arr[0],$arr[1],0,$arr[3],$arr[2],$arr[4])-(7*3600);
		
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
			$message= VSFactory::getLangs()->getWords('update_success');
		}else{
			$this->model->insertObject();
			$message=VSFactory::getLangs()->getWords('insert_success');
		}
		/**add tags process***/
		require_once CORE_PATH.'tags/tags.php';
		$tags=new tags();
		$tags->addTagForContentId($bw->input[0], $this->model->basicObject->getId(), $bw->input['tags_submit_list']);
		/****/
		$this->afterProcess($this->model);
		if(!$this->model->result['status']){
			$message=$this->model->result['developer'];
				
		}
		///////some here.....................
	
		return $this->output =  $this->getObjList ($bw->input['pageIndex'],$message);
	}
	
	function getHtml() {
		return $this->html;
	}

	function getOutput() {
		return $this->output;
	}

	function setHtml($html) {
		$this->html = $html;
	}

	function setOutput($output) {
		$this->output = $output;
	}
	
	/**
	 * Skins for post .
	 * ..
	 * 
	 * @var skin_posts
	 *
	 */
	var $html;
	
	/**
	 * String code return to browser
	 */
	var $output;
}
