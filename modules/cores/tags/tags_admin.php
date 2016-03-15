<?php
/*
 +-----------------------------------------------------------------------------
 |   VSF version 5.0
 |	Author: System
 |	Homepage: http://www.vietsol.net
 |	If you use this code, please don't delete these comment lines!
 |	Start Date: 
 |	Finish Date: 
 |	Modified Start Date: 
 |	Modified Finish Date: 
 |	News Description: this file created by auto system
 +-----------------------------------------------------------------------------
 */
require_once(CORE_PATH."tags/tags.php");

class tags_admin {
	/**
	 * 
	 * Enter description here ...
	 * @var skin_tags
	 */
	protected $html = "";
	/**
	 * 
	 * Enter description here ...
	 * @var tags
	 */
	protected $module;

	protected $output = "";

	public function __construct(){
		global $vsTemplate;
		$this->module = new tags();
		
		$this->html = $vsTemplate->load_template('skin_tags');
		
	}

	function auto_run() {
		global $bw;

		switch($bw->input[1]){
			//something....
			case 'display_obj_tab_tags':
				$this->displayObjTabTags();
				break;
			case 'edit_obj_form_tags':
				$this->editObjectFormTags($bw->input[2]);
				break;
			case 'add_obj_form_tags':
				$this->addObjFormTags();
				break;
			case 'hide_checked_obj_tags':
				$this->hideCheckedObjTags();
				break;
			case 'delete_checked_obj_tags':
				$this->deleteCheckedObjTags();
				break;
			#more_action#
			case 'get_tag_for_obj':
				$this->getTagForObj($bw->input[2],$bw->input[3]);
				break;
			case 'display_obj_help_tags':
				$this->display_obj_help_tags();
				break;
			
			default:
				$this->loadDefault();
		}
	}
	//return a javascript type
	function display_obj_help_tags(){
		$this->output=$this->html->helpGuide($option);
	}
	function getTagForObj($module,$content){
		global $bw;
		$option['taged_array']=$this->module->getTagByContent($module,$content);
		$t=array();
		foreach($option['taged_array'] as $tag){
			$t[]=$tag->getText();
		}
		$option['taged']=implode(", ", $t);
		//$this->module->setFieldsString("*,(select count(*) from ".SQL_PREFIX."tagcontent where tagId=id ) as _count  ");
		//$this->module->setTableName("tag");
		//$this->module->setLimit(array(0,40));
		//$this->module->setOrder("_count");
		$option['newtag']=$this->module->getTopTags();
		global $DB;
		$DB->query("select *,count(tagId) as count 
			from ".SQL_PREFIX."tagcontent 
			group by tagId
		");
		
		$array=array();
		$max=0;
		$min=0;
		while($row=$DB->fetch_row()){
			if($max<$row['count']) $max=$row['count'];
			if($min>$row['count']||$min==0) $min=$row['count'];
			$array[]=$row;
		}
		
		if($max>$min)
		foreach ($array as $row){
			if(is_object($option['newtag'][$row['tagId']]))
			$option['newtag'][$row['tagId']]->size=($row['count']-$min)/($max-$min)*20+10;
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
        

	function loadDefault() {
		global $vsPrint;

		$vsPrint->addJavaScriptFile("tiny_mce/tiny_mce");

		$vsPrint->addJavaScriptString('init_tab','
			$(document).ready(function(){
    			$("#page_tabs").tabs({
    				cache: false
    			});
  			});
		');

		$this->setOutput($this->html->managerObjHtml());
	}
#more_function#

	/*
	add this code when using datepicker
	$vsPrint->addJavaScriptFile("jquery/ui.datepicker");
	$vsPrint->addCSSFile('ui.datepicker');
	*/
	//require_once CORE_PATH.$bw->input[0]."tags.php";
	function deleteCheckedObjTags(){
			global $bw,$vsLang;
			$tags=new tags();
			if($bw->input['checkedObj']){
				$tags->setCondition($tags->getPrimaryField()." in ({$bw->input['checkedObj']}) ");
				$tags->deleteObjectByCondition();
				global $DB;
				$DB->query("DELETE FROM ".SQL_PREFIX."tagcontent WHERE tagId in ({$bw->input['checkedObj']})");
				$message=$vsLang->getWords('delete_success',"Delete success!");
			}
			return $this->displayObjTabTags();
		}
	function hideCheckedObjTags(){
			global $bw,$vsLang;
			$tags=new tags();
			if($bw->input['checkedObj']){
				$tags->setCondition($tags->getPrimaryField()." in ({$bw->input['checkedObj']}) ");
				$tags->updateObjectByCondition(array("status"=>"0"));
				$message=$vsLang->getWords('delete_success',"Delete success!");
			}
			return $this->displayObjTabTags();
		}
		function addObjFormTags(){
			global $bw,$vsLang;
			$tags=new tags();
			
			$tags->obj->convertToObject($bw->input['tags']);
			if($tags->obj->getId()){
				$tags->updateObject();
			}else{
				if(!$tags->checkTag($tags->obj->getText()))
				$tags->insertObject();
				else $error.=$vsLang->getWords("delete_tags_duplicate", "Can not success for duplicate keyword");
			}
			if(!$tags->result['status']) {
				$error.=$vsLang->getWords("delete_tags_not_success", "Can not success:".$tags->result['developer']);
			}
			return $this->displayObjTabTags($error);
		}
     function editObjectFormTags($objId){
     	global $bw;
     	$tags=new tags();
     	$tags->getObjectById($objId);
     	$obj=$tags->obj;
			
     	return $this->output=$this->html->addEditObjFormTags($obj, $option);
     }
	function displayObjTabTags($error=""){
		global $vsSettings,$bw;
		$tags=new tags();
		$option=$tags->getPageList("{$bw->input[0]}/display_obj_tab_tags",2,$vsSettings->getSystemKey($bw->input[0]."_limit_row_list",15),1,"obj_panel_tags");
		$option['error']=$error;
		return $this->output=$this->html->objListHtmlTags($option);
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
}
?>