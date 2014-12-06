<?php
require_once(CORE_PATH.'banners/banners.php');

class banners_controler extends VSControl_admin {

		function __construct($modelName){
			global $vsTemplate,$bw;//		$this->html=$vsTemplate->load_template("skin_banners");
		parent::__construct($modelName,"skin_banners","banner");
		$this->model->categoryName="banners";

	}
	function addEditObjForm($objId = 0, $option = array()) {
		global  $vsStd, $bw, $vsPrint;
		require_once CORE_PATH.'banners/bannerpos.php';
		$bannerpos=new bannerpos();
		$option['position']=$bannerpos->getObjectsByCondition();
		return parent::addEditObjForm($objId,$option);
	}


	function getObjList($catId = '', $message = "") {
		global $bw,$DB;
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
				$bw->input[3]=$bw->input['pageIndex'];
			}
				
			if($this->model->getCategoryField()){
				$ids=VSFactory::getMenus()->getChildrenIdInTree($this->model->getCategories());
				if($ids)
					$this->model->setCondition("{$this->model->getCategoryField()} in ($ids)");
			}
			if($bw->input['module']=='products'){
				$this->model->setOrder('`index` ASC');
			}
			$result = $DB->query("SHOW COLUMNS FROM `".$bw->vars['sql_tbl_prefix_0'].$this->tableName."` LIKE 'status'");
			$exists = (mysql_num_rows($result))?TRUE:FALSE;
			if($exists)
			if($this->model->getCondition())
				$this->model->setCondition($this->model->getCondition().' AND status>=0');
			else $this->model->setCondition('status>=0');
			 
			$option=array_merge($option, $this->model->getPageListHash($this->modelName."/".$bw->input [0]."/{$this->modelName}_display_tab/{$catId}/",3,
				
			VSFactory::getSettings()->getSystemKey("{$this->modelName}_paging_limit",20)));
	
			$option['s_order'] = $bw->input['search']['s_order']=='ASC'?'DESC':'ASC';
			$option['s_ofield'] = $bw->input['search']['s_ofield'];
			$bw->input['pageIndex']=$bw->input[3];
			$bw->input['back']="&pageIndex=".$bw->input['pageIndex'];
			
			require_once CORE_PATH.'banners/bannerpos.php';
			$bannerpos=new bannerpos();
			$option['position']=$bannerpos->getObjectsByCondition();
			
			
			$option['table']=$this->html->getListItemTable ($this->model->getArrayObj (), $option );
			///some here..................
		}
		return $this->output = $this->html->objListHtml ( $option );
	}

	function displaySearch(){
		global $bw;
		if($bw->input['search']['s_order']&&$bw->input['search']['s_ofield'])
			$order=$bw->input['search']['s_ofield'].' '.$bw->input['search']['s_order'];
		$from="vsf_".$this->tableName;
		$where="1=1";
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
		if($bw->input['search']['position']!=-1&&$bw->input['search']['position']!==NULL){
			$where.=" and `position`='{$bw->input['search']['position']}'";
		
		}
		$this->model->setCondition($where);
		$this->model->setOrder($order);
		 
		$itemList=$this->model->getObjectsByCondition();
		$vdata['search']=$bw->input['search'];
		$option['vdata']=json_encode($vdata);
		//if(!is_object($_GET['search'])) $_GET['search']=array();
		$tmp['search']=$_GET['search'];
		$bw->input['back']=urldecode( http_build_query($tmp	))."&pageIndex=".$bw->input['pageIndex'];
		 
		$option['s_order'] = $bw->input['search']['s_order']=='ASC'?'DESC':'ASC';
		$option['s_ofield'] = $bw->input['search']['s_ofield'];
		
		require_once CORE_PATH.'banners/bannerpos.php';
		$bannerpos=new bannerpos();
		$option['position']=$bannerpos->getObjectsByCondition();
		
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
	*Skins for banner ...
	*@var skin_banners
	**/
	var		$html;

	
	/**
	*String code return to browser
	**/
	var		$output;
}
