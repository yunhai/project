<?php
require_once(CORE_PATH.'tags/tags.php');

class tags_controler extends VSControl_admin {

		function __construct($modelName){
			global $vsTemplate,$bw;//		$this->html=$vsTemplate->load_template("skin_tags");
		parent::__construct($modelName,"skin_tags","tag");
		$this->model->categoryName="tags";

	}
function auto_run(){
		global $bw;
		switch($bw->input[1]){
			case $this->modelName.'_get_tag_for_obj':
				$this->getTagForObj($bw->input[2],$bw->input[3]);
				break;
			case $this->modelName.'_display_obj_help_tags':
				$this->display_obj_help_tags();
				break;
			default :
				parent::auto_run();
				break;
				
		}
}
//function addEditObjProcess() {
//		global $bw, $vsStd;
////		if(!$bw->input[$this->modelName]['trimText']){
////			$bw->input[$this->modelName]['trimText']=VSFactory::getTitleCode()->removeTags($bw->input[$this->modelName]['title']);
////		}
//		return parent::addEditObjProcess();
//	}

function getTagForObj($module,$content){
		global $bw;
		$option['taged_array']=$this->model->getTagByContent($module,$content);
		$t=array();
		foreach($option['taged_array'] as $tag){
			$t[]=$tag->getTitle();
		}
		$option['taged']=implode(", ", $t);
//		//$this->model->setFieldsString("*,(select count(*) from ".SQL_PREFIX."tagcontent where tagId=id ) as _count  ");
//		//$this->model->setTableName("tag");
//		//$this->model->setLimit(array(0,40));
//		//$this->model->setOrder("_count");
//		$option['newtag']=$this->model->getTopTags();
//		global $DB;
//		$DB->query("select *,count(tagId) as count 
//			from ".SQL_PREFIX."tagcontent 
//			group by tagId
//		");
//		
//		
//		if($max>$min)
//		foreach ($array as $row){
//			if(is_object($option['newtag'][$row['tagId']]))
//			$option['newtag'][$row['tagId']]->size=($row['count']-$min)/($max-$min)*20+10;
//		}
		$this->model=new tags();
		$this->model->setOrder('`count`');
		$this->model->setLimit(array(0,VSFactory::getSettings()->getSystemKey('limit_tags',40)));
		$option['newtag']=$this->model->getObjectsByCondition();
				$array=array();
		$max=0;
		$min=null;
		foreach ($option['newtag'] as $value) {
			if($max<$value->getCount()) $maxcount=$value->getCount();
			if($min>$value->getCount()||$min===null) $min=$value->getCount();
		}
		$max=1;
		$min=0;
		foreach ($option['newtag'] as $value) {
			$value->size=($value->getCount()-$min)/($max-$min)*5+10;
		}
		$script=$this->html->getTagScript($option);
		/*echo "<pre>";
		print_r($DB->obj);
		echo "</pre>";
		exit;*/
		
		header('Content-type: text/javascript');
		echo $script;
		exit;
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
	*Skins for tag ...
	*@var skin_tags
	**/
	var		$html;

	
	/**
	*String code return to browser
	**/
	var		$output;
}
