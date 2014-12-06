<?php
require_once(CORE_PATH.'albums/albums.php');

class albums_controler_public extends VSControl_public {

	public	function auto_run(){
	
	global $bw;
				switch ($bw->input['action']) {
//			case $this->modelName.'_some_action':
//				$this->someMethod($bw->input[2]);
//				break;
			case $this->modelName.'_addtshowbox':
				$this->showbox();
				break;
			case $this->modelName.'_tags':
				//echo 123; exit();
				$this->showTag($bw->input[2]);
			break;	
			default :
			//echo 123; exit();
				$this->showDefault ();
				break;
		}

	}



function showDefault($option=array()){
//echo 123; exit();
		global $bw,$vsTemplate,$vsStd,$vsPrint;
                //if(in_array($bw->input['module'], array('abouts','maps','helps')))return $this->showDefault1 ();
		$category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
		$option['cate_list']=VSFactory::getMenus()->getCategoryGroup($bw->input[0])->getChildren();
		$_SESSION['active']=0;
		if(!$category){
			$vsPrint->boink_it($bw->base_url);
		}
		$ids=VSFactory::getMenus()->getChildrenIdInTree($category);
		$this->model->setCondition("status>0 and catId in ($ids)");
		$this->model->setOrder("`index` desc,id desc");
		$tmp=$this->model->getPageList($bw->input[0],1,VSFactory::getSettings()->getSystemKey($bw->input[0].'_paging_public_limit',30));
		$option=array_merge($tmp,$option);
		$option['breakcrum']=$this->createBreakCrum($category);
		$option['title']=VSFactory::getLangs()->getWords($bw->input[0]);
		$vsPrint->mainTitle=$vsPrint->pageTitle=$option['title'];
       	$option['cate'] = $category->getChildren();
      
        if($option['pageList'] and in_array($bw->input[0],array('abouts','branch','supply','companylinking'))){
         	$obj=current($option['pageList']);
         	$vsPrint->boink_it($obj->getUrl($bw->input[0]));
         }       
                
          
        return $this->output = $this->getHtml()->showDefault($option);
	}
function showbox($option=array()){			
		global $bw,$vsTemplate,$vsStd,$vsPrint;
		$bw->input['ajax']=1;

		$arrayObj=array();
		$oldIds = $bw->input[2];
		$this->model->setCondition("status>0 and id ={$oldIds}");
		$obj=$this->model->getOneObjectsByCondition();
		
		require_once CORE_PATH.'gallerys/gallerys.php';
		$gallerys=new gallerys();
		$option['galary']=$gallerys->getAlbumByCode($bw->input['module'].'_'.$oldIds);
//		print  "<pre>";
//		print_r ($obj);
//		print  "<pre>";
//		exit();
		return $this->output =$this->getHtml()->showbox($option,$obj);
		

	}	
function showTag($tagId){
		global $bw,$vsPrint;
		require_once(CORE_PATH.'tags/tags.php');
		$tags = new tags();	
		$idtag = $this->getIdFromUrl($tagId);
		$_SESSION['active']['tag']=$idtag;
		
		$id = $tags->getContentByTagId($bw->input['module'],$idtag);	
        $category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
		$ids=VSFactory::getMenus()->getChildrenIdInTree($category);
		$this->model->setCondition("status >0 and catId in ({$ids}) and id in ({$id})");	
		//$this->model->setOrder("`index` desc,id desc");		
		$option=$this->model->getPageList($bw->input[0]."/".$bw->input[1]."/".$bw->input[2],3,VSFactory::getSettings()->getSystemKey($bw->input[0].'_paging_limit',12));

		$option['title']=$category->getTitle();
		$vsPrint->mainTitle=$vsPrint->pageTitle=$option['title'];       
        $option['breakcrum']=$this->createBreakCrum(null);
       // $option['obj']=$category;
		
        $option['cate'] = VSFactory::getMenus ()->getCategoryGroup ( $bw->input [0] )->getChildren();
		 
		
      
		return $this->output = $this->getHtml()->showDefault($option);
	}
	public	function __construct($modelName){
	
		global $vsTemplate,$bw;
//		$this->html=$vsTemplate->load_template("skin_album");
		parent::__construct($modelName,"skin_albums","album",$bw->input[0]);
//		$this->model->categoryName=$bw->input[0];

	}





	function getHtml(){
		return $this->html;
	}



	function setHtml($html){
		$this->html=$html;
	}



	
	/**
	*
	*@var albums
	**/
	var		$model;

	
	/**
	*
	*@var skin_albums
	**/
	var		$html;
}
