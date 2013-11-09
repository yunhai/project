<?php

class comments_admin extends ObjectAdmin{
	public function __construct() {
		global $vsTemplate;
		parent::__construct('comments', CORE_PATH.'comments/', 'comments');
		$this->html = $vsTemplate->load_template('skin_comments');
	}
	
	function auto_run() {
		global $bw;
		
		switch ($bw->input [1]) {
			
			case 'display_panel_popup_comment':
				$this->displayPanelCommentPopup();
				break;
				
			case 'update-all':
				$this->updateAll();
				break;
			default :
				$this->loadDefault ();
		}
	}
	
	function updateAll(){
		global $bw,$DB,$bug;
		$tableRel =  $bw->input['tableName'];
		$strIds = $bw->input['strIds'];
		$arrId = explode(",", $strIds);
		
		foreach ($arrId as $id){
			$this->model->createBasicObject();
			$comment = $this->model->getBasicObject();
			if($bw->input["ra_comment_$id"] == 3){
				$ids .= $id.",";
			}else{
				$comment->setId($id);
				$comment->setStatus($bw->input["ra_comment_$id"]);
				$comment->setAuthor($bw->input["commentAuthor_$id"]);
				$comment->setContent($bw->input["commentContent_$id"]);			
				$this->model->updateObject($comment);
			
				
			}
		} 
		
		$ids = trim($ids, ",");
		if($ids){
			$this->model->setCondition("commentId IN ( $ids ) ");
			$this->model->deleteObjectByCondition();
			$this->model->vsRelation->setTableName("{$tableRel}");
			
			$con = "relId IN ($ids) AND objectId = {$bw->input['objectId']}";
			$this->model->vsRelation->setCondition($con);
			$this->model->vsRelation->deleteObjectByCondition($con);
		}
		
		return $this->output = $this->displayFormPopup("{$tableRel}", $bw->input['objectId']);
	}
	
	
	function displayFormPopup($tableName, $objectId){
		global $bw;
		$this->model->vsRelation->setTableName($tableName);
		$this->model->vsRelation->setObjectId($objectId);
		$this->model->vsRelation->setRelId(NULL);
		$this->model->vsRelation->setFieldsString("relId");
		
		$strIds = $this->model->vsRelation->getRelByObject();
		
		if($strIds){
	        $this->model->setTableName('comment');
	        $this->model->setCondition("commentId IN ( $strIds ) ");
	        $option['list'] =  $this->model->getObjectsByCondition();
		}
		$option['strIds'] = $strIds;
		$option['objectId'] = $objectId; 
		$option['tableName'] = $tableName; 
		$this->output = $this->html->formPopup($option);
		return $this->output;
	}
	
	function displayPanelCommentPopup(){
		global $bw;
		$tableName = $bw->input[2];
		$objectId  = $bw->input[3];

		$this->model->vsRelation->setTableName($tableName);
		$this->model->vsRelation->setObjectId($objectId);
		$this->model->vsRelation->setRelId(NULL);
		$this->model->vsRelation->setFieldsString("relId");
		
		$strIds = $this->model->vsRelation->getRelByObject();
		
		if($strIds){
	        $this->model->setTableName('comment');
	        $this->model->setCondition("commentId IN ( $strIds ) ");
		
	        $option['list'] =  $this->model->getObjectsByCondition();
		}
		$option['strIds'] = $strIds;
		$option['objectId'] = $objectId; 
		$option['tableName'] = $tableName;
		$this->output = $this->html->displayPanelCommentPopup($option);
		
		return $this->output;
	}
	
	public function createRSS($idCate = "") {
		global $bw;
		return $this->model->createRSS ( $idCate );
	}
	function deleteObj($ids, $cate = 0) {
		global $bw;
		
		$this->model->setCondition ( "commentId IN (" . $ids . ")" );
		$list = $this->model->getObjectsByCondition ();
		if (! count ( $list ))
			return false;
		
		$this->model->setCondition ( "commentId IN (" . $ids . ")" );
		if (! $this->model->deleteObjectByCondition ())
			return false;
		foreach ( $list as $news )
			$this->model->vsFile->deleteFile ( $news->getImage () );
		
		return $this->output = $this->getObjList ( $cate );
	}	
	
}
?>