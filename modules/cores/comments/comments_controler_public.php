<?php
require_once (CORE_PATH . 'comments/comments.php');
class comments_controler_public extends VSControl_public {

	function __construct($modelName) {
		global $vsTemplate, $bw, $vsPrint, $vsSkin;
		parent::__construct ( $modelName, "skin_comments", "comment" );
	}

	public function auto_run() {
		global $bw;
		
		
		switch ($bw->input ['action']) {
			case $this->modelName . '_service' :
				$this->loadService ();
				break;
			case $this->modelName . '_send' :
				$this->send ();
				break;
			case $this->modelName . '_loadForm' :
				return $this->output = $this->html->loadForm ( $bw->input['userId'],$bw->input['id'] );
				exit ();
				break;
			default :
				parent::auto_run ();
				break;
		}
	}

	function send(){
		global $bw,$vsStd;
		$vsStd->requireFile ( ROOT_PATH . "vscaptcha/VsCaptcha.php" );
			
		$image = new VsCaptcha ();
		if ($image->check ( $bw->input ['recaptcha_response_field'] )) {
		
			$bw->input ['postdate'] = time ();
				
			$bw->input ['status'] = 1;
				
			$this->model->basicObject->convertToObject ( $bw->input );
			$this->model->basicObject->setObjId($bw->input['comment_post_ID']);
			$this->model->basicObject->setModule($bw->input['comment_post_M']);
				
		
			$this->model->insertObject ();
			echo 'ok';die;
		}else{
			echo 'recaptcha';
			exit ();
		}
	}
	
	function loadService() {
		global $bw,$DB;
		
		$this->model->setCondition ( "status > 0 and objId = {$bw->input ['cate']} and module='{$bw->input ['mo']}' and userId=0" );
		$this->model->setOrder("postdate desc");
		
		$bw->input [4] = $bw->input ['pageindex'];
		
		$option = $this->model->getPageList ( $bw->input [0], 4, 8 );
		
		foreach ($option['pageList'] as $key => $value){
			$child = $this->model->getChildren($key, $bw->input ['cate'], $bw->input ['mo']);
			if($child){
				$option['pageList'][$key]->child = $child;
			}
		}
		
		return $this->output = $this->html->loadService ( $option );
		exit ();
	}

	function submitComment() {
		global $bw;
		// echo "<pre>";
		// print_r($_REQUEST);
		// echo "<pre>";
		// exit;
		$this->model->basicObject->convertToObject ( $_REQUEST ['comments'] );
		$this->model->basicObject->setPostDate ( null );
		if (! $this->model->basicObject->getTitle ()) {
			$this->model->basicObject->setTitle ( "no title" );
		}
		if (VSFactory::getSettings ()->getSystemKey ( 'auto_approve_comment', 1 )) {
			$this->model->basicObject->setStatus ( 1 );
		} else {
			$this->model->basicObject->setStatus ( 0 );
		}
		
		require_once ROOT_PATH . 'vscaptcha/VsCaptcha.php';
		$result = array ();
		$vscaptcha = new VsCaptcha ();
		if ($vscaptcha->check ( $bw->input ['security'] )) {
			if (strlen ( $this->model->basicObject->getContent () ) < 5) {
				$result ['status'] = 0;
				$result ['message'] = VSFactory::getLangs ()->getWords ( 'comment_content_too_short', 'Nội dung quá ngắn' );
			} else {
				$this->model->insertObject ();
				$result ['status'] = 1;
				$result ['message'] = VSFactory::getLangs ()->getWords ( 'comment_submit_success', 'Gửi comment thành công' );
				$result ['content'] = $this->model->basicObject->getContent ();
				$result ['poster'] = $this->model->basicObject->getPoster ();
				$result ['postDate'] = date ( "d/m/y h:i:s", $this->model->basicObject->getPostDate () );
				$_SESSION ['poster'] = $result ['poster'];
			}
		} else {
			$result ['status'] = 0;
			$result ['message'] = VSFactory::getLangs ()->getWords ( 'captcha_not_match', 'Mã bảo vệ không chính xác' );
		}
		echo json_encode ( $result );
		VSFactory::createConnectionDB ()->close_db ();
		exit ();
	}

	function getHtml() {
		return $this->html;
	}

	function setHtml($html) {
		$this->html = $html;
	}
	
	/**
	 *
	 * @var comments
	 *
	 */
	var $model;
	
	/**
	 *
	 * @var skin_comments
	 *
	 */
	var $html;
}
