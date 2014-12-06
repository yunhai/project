<?php
require_once(CORE_PATH.'seos/seos.php');

class seos_controler extends VSControl_admin {

		function __construct($modelName){
			global $vsTemplate,$bw;//		$this->html=$vsTemplate->load_template("skin_seos");
		parent::__construct($modelName,"skin_seos","seo");
		$this->model->categoryName="seos";

	}

function displaySearch(){
		global $bw;
//		if (VSFactory::getSettings()->getSystemKey ( $bw->input [0] . '_category_list', 0, $bw->input[0] ))
//			$option ['categoryList'] = $this->getCategoryBox ();
			//$option ['objList'] = $this->getObjList ();
        	$order="";
        	$from="vsf_".$this->tableName;
        	$where="1=1";
        	if($bw->input['search']['title']){
        		$where.=" and ( `title` like '%{$bw->input['search']['title']}%' or `aliasUrl` like '%{$bw->input['search']['title']}%' or `realUrl` like '%{$bw->input['search']['title']}%' )";
        	}
        	if($bw->input['search']['id']){
        		$where.=" and `id`='{$bw->input['search']['id']}' ";
        	}
        	if($bw->input['search']['status']!=-1&&$bw->input['search']['status']!==NULL){
	        		$where.=" and `status`='{$bw->input['search']['status']}'";
        		
        	}
			if($bw->input['search']['keyword']){
	        		$where.=" and `keyword` like '%{$bw->input['search']['keyword']}%' ";
        		
        	}
        	$this->model->setCondition($where);
        	
        	$itemList=$this->model->getObjectsByCondition();
        	$vdata['search']=$bw->input['search'];
        	$option['vdata']=json_encode($vdata);
        	$tmp['search']=$_GET['search'];
        	$bw->input['back']=urldecode( http_build_query($tmp	))."&pageIndex=".$bw->input['pageIndex'];
		return $this->output = $this->html->getListItemTable ($itemList, $option );
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
	*Skins for seo ...
	*@var skin_seos
	**/
	var		$html;

	
	/**
	*String code return to browser
	**/
	var		$output;
}
