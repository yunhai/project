<?php
require_once(CORE_PATH.'entrepreneurs/entrepreneurs.php');

class entrepreneurs_controler_public extends VSControl_public {

	public	function __construct($modelName){
	
		global $vsTemplate,$bw;
//		$this->html=$vsTemplate->load_template("skin_entrepreneur");
		parent::__construct($modelName,"skin_entrepreneurs","entrepreneur",$bw->input[0]);
//		$this->model->categoryName=$bw->input[0];

	}
	function auto_run() {
		global $bw;
		
		switch ($bw->input ['action']) {
			case $this->modelName . '_detail' :
				$this->showDetail ( $bw->input [2] );
				break;
			
			case $this->modelName . '_category' :
				$this->showCategory ( $bw->input [2] );
				break;
			case $this->modelName . '_profile' :
				$this->showProfile ( $bw->input [2] );
				break;
			case $this->modelName . '_review' :
				$this->showReview ( $bw->input [2] );
				break;
			case $this->modelName . '_search' :
				$this->showSearch ();
				break;
			case $this->modelName.'_form_tuvan':
				$this->showFromTuvan();
				break;		
			default :
				$this->showDefault ();
				break;
		}
	}




function showProfile($option=array()){
		global $bw,$vsTemplate,$vsStd,$vsPrint;
		
		if($_SESSION['user']['obj']['id']){
		
			$category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
			$option['cate_list']=VSFactory::getMenus()->getCategoryGroup($bw->input[0])->getChildren();
			$ids=VSFactory::getMenus()->getChildrenIdInTree($category);
			$this->model->setCondition(" catId in ($ids) and userId ={$_SESSION['user']['obj']['id']}");
			$obj=$this->model->getOneObjectsByCondition();
			
			if($bw->input['entrepreneurs']['submit']){
				
				
				$bw->input['entrepreneurs']['intro']=$bw->input['entrepreneurs']['content'];
				$file=new files();
				 if($file->uploadLocalToHost($_FILES['files']['tmp_name'],'entrepreneurs',$_FILES['files']['name'], $file->obj)){
				 	
				 	
				 	$bw->input['entrepreneurs']['image']=$file->obj->getId();
		          
		        }
				
		        
//		        foreach ($bw->input['entrepreneurs'] as $Key=>$value){
//		        	$bw->input['entrepreneurs'][$key]=mysql_real_escape_string($value);        	
//		        }
				
			
				if($bw->input['entrepreneurs']['id']){
					$obj_affter=$this->model->getObjectById($bw->input['entrepreneurs']['id']);
					if(!$this->model->basicObject->getId()){
						return $this->output =  $this->getObjList ($bw->input['pageIndex'],"Not define object of id={$bw->input[$this->modelName]['id']} submited!");
					}
					if($bw->input[$this->modelName]['image']){
						$files=new files();
						$files->deleteFile($this->model->basicObject->getImage());				
					}
					/////delete some here..........................................
				}
				$this->model->basicObject->convertToObject($bw->input['entrepreneurs']);
//				print  "<pre>";
//				print_r ($this->model);
//				print  "<pre>";
//				exit();
				$this->model->updateObject();
				if($obj_affter){
					$vsPrint->boink_it($obj_affter->getUrl($obj_affter->getModule()));
				}
	       	}
	 		   return $this->output = $this->getHtml()->showProfile($obj,$option);
		}       
        else{
        	$vsPrint->boink_it($bw->base_url."/users/login");
        }      
       
	}


function showDefault($option=array()){
		global $bw,$vsTemplate,$vsStd,$vsPrint;
		//echo 123; exit();
                //if(in_array($bw->input['module'], array('abouts','maps','helps')))return $this->showDefault1 ();
		$category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
		$option['cate_list']=VSFactory::getMenus()->getCategoryGroup($bw->input[0])->getChildren();
		
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

	function showCategory($catId){
		global $bw,$vsPrint;
        $category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
		$idcate = $this->getIdFromUrl($catId);		
		$category=VSFactory::getMenus()->getCategoryById($idcate);
		if(!$category){
			$vsPrint->boink_it($bw->base_url);
		}
		
		
		$ids=VSFactory::getMenus()->getChildrenIdInTree($category);
		$this->model->setCondition("status>0 and catId in ({$idcate})");
		
		$this->model->setOrder("`index` desc,id desc");
		$option=$this->model->getPageList($bw->input[0]."/".$bw->input[1]."/".$bw->input[2],3,VSFactory::getSettings()->getSystemKey($bw->input[0].'_paging_limit',12));

		$option['title']=$category->getTitle();
		$vsPrint->mainTitle=$vsPrint->pageTitle=$option['title'];
        
        $option['breakcrum']=$this->createBreakCrum(VSFactory::getMenus()->getCategoryById($idcate) );
        $option['obj']=$category;
     	if($option['pageList'] and in_array($bw->input[0],array('proservicer'))){
         	$obj=current($option['pageList']);
         	$vsPrint->boink_it($obj->getUrl($bw->input[0]));
         } 
        $option['cate'] = VSFactory::getMenus ()->getCategoryGroup ( $bw->input [0] )->getChildren();
		foreach ($option['cate'] as $value) {
      		if($value->getId()==$category->getId()){
      			$value->active="active";
      		}
      		else{
      			$value->active="";
      		}
      	}
      
		return $this->output = $this->getHtml()->showDefault($option);
	}
function showDetail($objId,$option=array()){
		global $bw,$vsTemplate,$vsStd,$vsPrint;
		$category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
		$obj=$this->model->getObjectById($this->getIdFromUrl($objId));
		
		if(!$obj->getId()){
			return $this->output=VSFactory::getLangs()->getWords('not_count_item');
		}
		
		if($obj->getStatus()==0){
			if($_SESSION['user']['obj']['id']!=$obj->getUserId()){
			return $this->output=VSFactory::getLangs()->getWords('not_count_item');
			}
		}
		//echo 123; exit();
		$obj->createSeo();
		
		$ids=VSFactory::getMenus()->getChildrenIdInTree($category);
		
		$this->model->setCondition("status >0 and id not in ({$obj->getId()}) and catId in ($ids)");
		$this->model->setOrder("`index` desc,id desc");
		$option=$this->model->getPageList($bw->input[0]."/".$bw->input[1]."/".$bw->input[2],3,VSFactory::getSettings()->getSystemKey($bw->input[0].'_paging_detail_limit',2));
		//$option=array_merge($tmp,$option);
			
//		print  "<pre>";
//		print_r ($option);
//		print  "<pre>";
//		exit();
       	
       	
		$this->output = $this->getHtml()->showDetail($obj,$option);
	}
	
	


	function getHtml(){
		return $this->html;
	}



	function setHtml($html){
		$this->html=$html;
	}



	
	/**
	*
	*@var entrepreneurs
	**/
	var		$model;

	
	/**
	*
	*@var skin_entrepreneurs
	**/
	var		$html;
}
