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
require_once(CORE_PATH."comments/comments.php");

class comments_admin {
	/**
	 * 
	 * Enter description here ...
	 * @var skin_comments
	 */
	protected $html = "";
	/**
	 * 
	 * Enter description here ...
	 * @var comments
	 */
	protected $module;

	protected $output = "";

	public function __construct(){
		global $vsTemplate,$vsPrint;
		$this->module = new comments();
               
		$this->html = $vsTemplate->load_template('skin_comments');
	}

	function auto_run() {
		global $bw;

		switch($bw->input[1]){
						
			case 'display_panel_popup_comment':
				$this->displayPanelCommentPopup();
				break;
				
			case 'update-all':
				$this->updateAll();
				break;
			
	
			//something....
			case 'display_obj_tab_comments':
				$this->displayObjTabComments("",$bw->input[2],$bw->input[3],$bw->input[4]);
				break;
			case 'edit_obj_form_comments':
				$this->editObjectFormComments($bw->input[2]);
				break;
			case 'add_obj_form_comments':
				$this->addObjFormComments();
				break;
			case 'hide_checked_obj_comments':
				$this->hideCheckedObjComments();
				break;
			case 'delete_checked_obj_comments':
				$this->deleteCheckedObjComments();
				break;
//			case 'display_obj_tab_comments_fillter':
//				$this->displayObjTabComments();
//				break;
			case 'visible_checked_obj_comments':
				$this->setStatus($bw->input['checkedObj'],0);
				break;
			case 'approve_checked_obj_comments':
				$this->setStatus($bw->input['checkedObj'],1);
				break;
			case 'unapprove_checked_obj_comments':
				$this->setStatus($bw->input['checkedObj'],0);
				break;
				
			default:
				$this->loadDefault();
		}
	}
        
        
        function displayPanelCommentPopup(){
		global $bw;
		$option['tableName'] = $tableName = $bw->input[2];
		$option['objectId'] = $objectId  = $bw->input[3];

		$this->module->setCondition("objId in ({$objectId}) and module ='{$tableName}'");
                $option['list'] = $this->module->getObjectsByCondition();
               $option['strIds']=implode(",",array_keys($option['list']));
      
		$this->output = $this->html->displayPanelCommentPopup($option);
		
		return $this->output;
	}

        function updateAll(){
		global $bw,$DB,$bug;
		$tableRel =  $bw->input['tableName'];
		$strIds = $bw->input['strIds'];
		$arrId = explode(",", $strIds);

		foreach ($arrId as $id){
			$this->model = new comments();
			$comment = $this->model->obj;
			if($bw->input["ra_comment_$id"] == 3){
				$ids .= $id.",";
			}else{
				$comment->setId($id);
				$comment->setStatus($bw->input["ra_comment_$id"]);
				$comment->setName($bw->input["commentAuthor_$id"]);
				$comment->setContent($bw->input["commentContent_$id"]);	
				$this->model->updateObject($comment);
			}
		} 
		
		$ids = trim($ids, ",");
		if($ids){
			$this->model->setCondition("id IN ( $ids ) ");
			$this->model->deleteObjectByCondition($con);
		}
		
		return $this->output = $this->displayFormPopup("{$tableRel}", $bw->input['objectId']);
	}
	
        
        function displayFormPopup($tableName, $objectId){
		global $bw;
		$option['tableName'] = $tableName ;
		 
                $option['objectId'] =  $bw->input['objectId'];
		$this->module->setCondition("objId in ({$objectId}) and module ='{$tableName}'");
                $option['list'] = $this->module->getObjectsByCondition();
                 $option['strIds']=implode(",",array_keys($option['list']));
//		$this->output = $this->html->formPopup($option);
		$this->output = $this->html->formPopup($option);
		return $this->output;
	}
function setStatus($id,$status){
	global $bw;
		if($id){
			$this->module->setCondition("`id` in ({$id})");
					$array=$this->module->getObjectsByCondition();
					foreach ($array as $obj) {
						$obj->setStatus($status);
						$this->module->updateObject($obj);
					}
				}
	return $this->displayObjTabComments($error,$bw->input['comments']['group'],$bw->input['comments']['objId'],$bw->input['comments']['status']);
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
	This code created by system
	add this code when using datepicker
	$vsPrint->addJavaScriptFile("jquery/ui.datepicker");
	$vsPrint->addCSSFile('ui.datepicker');
	*/
	//require_once CORE_PATH.$bw->input[0]."comments.php";
	function deleteCheckedObjComments(){
			global $bw,$vsLang;
			$comments=new comments();
			if($bw->input['checkedObj']){
				$comments->setCondition($comments->getPrimaryField()." in ({$bw->input['checkedObj']}) ");
				$comments->deleteObjectByCondition();
				$message=$vsLang->getWords('delete_success',"Delete success!");
			}
			return $this->displayObjTabComments("",$bw->input['comments']['group'],$bw->input['comments']['objId'],$bw->input['comments']['status']);
		}
	function hideCheckedObjComments(){
			global $bw,$vsLang;
			$comments=new comments();
			if($bw->input['checkedObj']){
				$comments->setCondition($comments->getPrimaryField()." in ({$bw->input['checkedObj']}) ");
				$comments->updateObjectByCondition(array("status"=>"0"));
				$message=$vsLang->getWords('delete_success',"Delete success!");
			}
			return $this->displayObjTabComments("",$bw->input['comments']['group'],$bw->input['comments']['objId'],$bw->input['comments']['status']);
		}
		function addObjFormComments(){
			global $bw,$vsLang;
			$comments=new comments();
			if($bw->input['users']['id']){
				$comments->getObjectById($bw->input['comments']['id']);
			}
			
			if($bw->input['fileId']){
					if($comments->obj->getImage()){
						$files=new files();
						$files->deleteFile($comments->obj->getImage());
					}
				$bw->input['comments']['image']=$bw->input['fileId'];
			}
			if($bw->input['users']['status'])$bw->input['users']['status']=1;
			else $bw->input['users']['status']=0;
			
			$bw->input['comments']['intro']=$_REQUEST['comments']['intro'];
			$bw->input['comments']['content']=$_REQUEST['comments']['content'];
			$bw->input['comments']['status']=$_REQUEST['cstatus'];
			$comments->obj->convertToObject($bw->input['comments']);
			if($comments->obj->getId()){
				$comments->updateObject();
			}else{
				$comments->insertObject();
			}
			if(!$comments->result['status']) {
				$erro.=$vsLang->getWords("delete_tags_not_success", "Can not success:".$tags->result['developer']);
			}
			return $this->displayObjTabComments($error,$bw->input['comments']['group'],$bw->input['comments']['objId'],$bw->input['comments']['status']);
		}
     function editObjectFormComments($objId){
     	global $bw;
     	$comments=new comments();
     	$comments->getObjectById($objId);
     	$obj=$comments->obj;
			
			$option['catId_properties_list']=array("1"=>"value 1","2"=>"value 2");
			
     	return $this->output=$this->html->addEditObjFormComments($obj, $option);
     }
	function displayObjTabComments($error="",$module=NULL,$objId=NULL,$status=NULL){
		global $vsSettings, $bw;
		
		$comments = new comments();
		$condition = array();
		
		if(isset($status)&&$status!="all") $condition[]="status='$status'";
		//else $status="all";
		
		
		if($module&&$module!="all") $condition[]="module='$module'";
		//else $module="all";
		
//		if($objId) $condition[]="objId='$objId'";
//		else $objId=0;
		
		$comments->setCondition(implode(" and ", $condition));
		$size = $vsSettings->getSystemKey($bw->input[0]."_limit_row_list",15);
		$option = $comments->getPageList("{$bw->input[0]}/display_obj_tab_comments/{$module}/$objId/$status",5,$size,1,"obj_panel_comments");
		$option['error']=$error;
		$option['module']=$module;
		$option['objId']=$objId;
		$option['status']=$status;
		$query = "
			SELECT module 
			FROM vsf_comment
			GROUP BY module
		";
		global $DB;
		$DB->query($query);
		$option['module_list'] = array();
		$option['module_list']['all'] = "Tất cả";
		while($row = $DB->fetch_row()){
			if(!$row['module']) $row['module'] = "Không có nhóm";
			$option['module_list'][$row['module']]=$row['module'];
		}
		
		return $this->output = $this->html->objListHtmlComments($option).$error;
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