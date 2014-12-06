<?php

require_once CORE_PATH.'gallerys/gallerys.php';
class gallerys_controler extends VSControl_admin {
	function __construct($modelName){
		global $vsTemplate,$bw;
//		$this->html=$vsTemplate->load_template("skin_gallery");
		parent::__construct($modelName,"skin_gallerys","gallery");
		$this->model->categoryName=$bw->input[0];
	
	}
	function auto_run(){
		global $bw;
		switch ($bw->input[1]){
			case $this->modelName.'_display-album-tab' :
				$this->displayGalleryTab();
				break;
			default:
			parent::auto_run();		
				break;
		}
		
		
	}
	//	gallerys/display-album-tab/products/20&albumCode=image
	function displayGalleryTab(){
		global $bw;
		
		$vsLang = VSFactory::getLangs();
		if(!$bw->input[2]){
			$this->message=VSFactory::getLangs()->getWords("global_none_model",'Bạn phải truyền tên model cần tạo Album');
			return false;
		}
		
		if(!$bw->input[3]){
			$this->message=$vsLang->getWords("global_none_id",'Bạn phải truyền Id của đối tượng cần tạo Album');
			return false;
		}
		

		$newAlbum=$this->model->createAlbum($bw->input[2].'_'.$bw->input[3],$bw->input[2]);
	
		if(!$this->model->basicObject->getId()){
			$this->message=$vsLang->getWords("global_error_system",'Có lỗi trong quá trình tạo Album');
			return false;
		}
		
		return 	$this->showDialog($this->model->basicObject->getId());
	}
	
	function showDialog($GalleryObj){
		
		if(!is_object($GalleryObj)) $GalleryObj=$this->model->getObjectById($GalleryObj);
		$option['obj']=$GalleryObj;
		$option['file_list']=$this->model->getFileByAlbumId($GalleryObj->getId());
		if(VSFactory::getSettings()->getSystemKey('album_image_size_width_'.$option['obj']->getModule(),'')||
		VSFactory::getSettings()->getSystemKey('album_image_size_height_'.$option['obj']->getModule(),'')){
			$option['size']['w']=VSFactory::getSettings()->getSystemKey('album_image_size_width_'.$option['obj']->getModule(),'');
			$option['size']['h']=VSFactory::getSettings()->getSystemKey('album_image_size_height_'.$option['obj']->getModule(),'');
		}
		$option['template']=$this->html->getFileItem(new File(), $option);
		$option['template']=str_replace(array("'","\n"), array("\\'","\\n"), $option['template']);
		return $this->output=$this->html->showDialog($option);
	}
	
	
function displaySearch(){
		global $bw;
//		if (VSFactory::getSettings()->getSystemKey ( $bw->input [0] . '_category_list', 0, $bw->input[0] ))
//			$option ['categoryList'] = $this->getCategoryBox ();
			//$option ['objList'] = $this->getObjList ();
        	$order="";
        	$from="vsf_".$this->tableName;
        	$where="statuc>=0";
        	if($bw->input['search']['title']){
        		$where.=" and `title` like '%{$bw->input['search']['title']}%'";
        	}
        	if($bw->input['search']['id']){
        		$where.=" and `id`='{$bw->input['search']['id']}' ";
        	}
        	if(isset($bw->input['search']['catId']))
        	if($bw->input['search']['catId']>0){
        		$category=VSFactory::getMenus()->getCategoryById($bw->input['search']['catId']);
        		if($category){
	        		$idns=VSFactory::getMenus()->getChildrenIdInTree($category->getId());
	        		$where.=" and `catId` in ({$idns})";
        		}
        	}else{
        		if($this->model->categoryName){
        			$category=VSFactory::getMenus()->getCategoryGroup($this->model->categoryName);
        			if($category){
		        		$idns=VSFactory::getMenus()->getChildrenIdInTree($category->getId());
		        		$where.=" and `catId` in ({$idns})";
        			}
        		}
        	}
        	if($bw->input['search']['status']!=-1&&$bw->input['search']['status']!==NULL){
	        		$where.=" and `status`='{$bw->input['search']['status']}'";
        		
        	}
        	$this->model->setCondition($where);
        	
        	$itemList=$this->model->getObjectsByCondition();
        	$vdata['search']=$bw->input['search'];
        	$option['vdata']=json_encode($vdata);
        	//if(!is_object($_GET['search'])) $_GET['search']=array();
        	$tmp['search']=$_GET['search'];
        	$bw->input['back']=urldecode( http_build_query($tmp	))."&pageIndex=".$bw->input['pageIndex'];
		return $this->output = $this->html->getListItemTable ($itemList, $option );
	}
	
function getObjList($catId = '', $message = "") {
		global $bw;
		$option['message']=str_replace(array("'","\n"),array("\\'","\\n"), $message) ;
		$catId=intval($catId);
		if($_REQUEST['vdata']){
			$vdata=json_decode($_REQUEST['vdata'],true);
		}
//		echo "<pre>111";
//		print_r($vdata);
//		echo "222<pre>";
//		exit;
		if($vdata['search']){//last query search
			$bw->input['search']=$vdata['search'];
			$option['table']=$this->displaySearch();
		}else{
			if($bw->input['pageIndex']){
				$bw->input[3]=$bw->input['pageIndex'];
			}
			
			if($this->model->getCategoryField()){
				$ids=VSFactory::getMenus()->getChildrenIdInTree($this->model->getCategories());
				if($ids)
				$this->model->setCondition("{$this->model->getCategoryField()} in ($ids) and status >= 0");
			}else{
				$this->model->setCondition("status >= 0");
			}
			$option=array_merge($option, $this->model->getPageListHash($this->modelName."/".$bw->input [0]."/{$this->modelName}_display_tab/{$catId}/",3,
			VSFactory::getSettings()->getSystemKey("{$this->modelName}_paging_limit",20)));
//			$bw->input['catId']=$catId;
//echo "<pre>";
//print_r(VSFactory::createConnectionDB()->obj);
//echo "<pre>";
//exit;
			$bw->input['pageIndex']=$bw->input[3];
			$bw->input['back']="&pageIndex=".$bw->input['pageIndex'];
			$option['table']=$this->html->getListItemTable ($this->model->getArrayObj (), $option );
			///some here..................
		}
		return $this->output = $this->html->objListHtml ( $option );
	}
	
	
	
	
	
	
	
	
	
	/**
	 * 
	 * @var gallerys
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
	 * @var skin_gallerys
	 */
	public $html;
}


?>