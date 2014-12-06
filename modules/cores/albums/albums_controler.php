<?php
require_once(CORE_PATH.'albums/albums.php');

class albums_controler extends VSControl_admin {

		function __construct($modelName){
			global $vsTemplate,$bw;//		$this->html=$vsTemplate->load_template("skin_albums");
		parent::__construct($modelName,"skin_albums","album");
		$this->model->categoryName="albums";

	}


function auto_run() {
		global $bw;
		
		
		switch ($bw->input [1]) {
			case $this->modelName . '_display_tab' :
				$this->displayObjTab ();
				break;
			case $this->modelName . '_search' :
				$this->displaySearch ();
				break;
			case $this->modelName . '_visible_checked' :
				$this->checkShowAll ( 1 );
				break;
			case $this->modelName . '_home_checked' :
				$this->checkShowAll ( 2 );
				break;
			case $this->modelName . '_index_change' :
				$this->indexChange();
				break;
				
			case $this->modelName.'_home_checked' :
				$this->checkShowAll(2);
				break;
			case $this->modelName.'_highlight_checked' :
				$this->checkShowAll(3);
				break;	
				
			case $this->modelName.'_trash_checked' :
				$this->checkTrash();
				break;
			
			case $this->modelName.'_hide_checked' :
				$this->checkShowAll(0);
				break;
			case $this->modelName.'_display_list' :
				$this->getObjList ( $bw->input [2], $this->model->result ['message'] );
				break;
			
			case $this->modelName.'_add_edit_form' :
				//echo 123; exit();
				$this->addEditObjForm ( $bw->input [2] );
				
				break;
			case $this->modelName.'_selectpro' :
				//echo 123; exit();
				$this->SelectPro ( $bw->input [2] );
				
				break;
			
			case $this->modelName.'_add_edit_process' :
				
				$this->addEditObjProcess ();
				break;
			
			case $this->modelName.'_delete' :
				$this->deleteObj($bw->input[2]);
				break;
			case $this->modelName.'_change_cate' :
				$this->changeCate($bw->input[2]);
				break;	
				
			case $this->modelName."_display_answer_tab":
				$this->displayAnswer();
				break;
			case $this->modelName."_upload_image":
				$this->uploadImage();
				break;	
				
			
				
		}
	}

function SelectPro(){
		global $bw,$DB;
		//echo 123; exit();
		require_once CORE_PATH.'products/products.php';
		$products=new products();
		if($bw->input['objId']>0){
		$category=VSFactory::getMenus()->getCategoryById($bw->input['objId']);
		$ids=VSFactory::getMenus()->getChildrenIdInTree($category->getId());
		$products->setCondition("status > 0 and catId in ({$ids})");
		$products->setOrder("`index` DESC,id desc");
		$option['objPro']=$products->getObjectsByCondition();
		//$html=$this->html->SelectPro($option['objPro']);
		
		}
		
		$bw->input['ajax']=1;
		/*print  "<pre>";
		print_r ($option['objPro']);
		print  "<pre>";
		exit();*/
		$obj=nul;
		echo $this->getHtml()->showItemProduct($option);die;
		
		
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
	*Skins for album ...
	*@var skin_albums
	**/
	var		$html;

	
	/**
	*String code return to browser
	**/
	var		$output;
}
