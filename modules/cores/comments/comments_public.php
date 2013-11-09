<?php
class comments_public extends ObjectPublic{
	
	function __construct() {
		global $vsTemplate;
		parent::__construct('comments', CORE_PATH.'comments/', 'comments');
	}
	
	function auto_run() {
		global $bw, $vsPrint;
		switch ($bw->input [1]) {
		
			
			case 'form-comment' :
				$vsPrint->addJavaScriptFile ( 'jquery/ui.alerts' );
				$vsPrint->addJavaScriptFile ( 'ajaxupload/ajaxfileupload' );
				$vsPrint->addJavaScriptFile ( 'vs.ajax' );
				
				$vsPrint->addGlobalCSSFile ( 'jquery/base/ui.dialog' );
				$vsPrint->addGlobalCSSFile ( 'jquery/base/ui.theme' );
				$vsPrint->addGlobalCSSFile ( 'jquery/base/ui.core' );
				$this->output = $this->html->displayComment ();
				break;
			case 'load-form' :
				$this->output = $this->html->formComment ();
				break;
			
			case 'process-add' :
			$vsPrint->addJavaScriptFile ( 'jquery/ui.alerts' );
				$vsPrint->addJavaScriptFile ( 'ajaxupload/ajaxfileupload' );
				$vsPrint->addJavaScriptFile ( 'vs.ajax' );
				
				$vsPrint->addGlobalCSSFile ( 'jquery/base/ui.dialog' );
				$vsPrint->addGlobalCSSFile ( 'jquery/base/ui.theme' );
				$vsPrint->addGlobalCSSFile ( 'jquery/base/ui.core' );
				$this->processAdd ();
				break;

		}
	}
	
	function processAdd() {
		global $bw, $vsStd, $vsLang, $vsSettings;
		
		$bw->input ['commentPostDate'] = time ();
		$bw->input ['commentStatus'] = $bw->input ['commentStatus'] ? $bw->input ['commentsStatus'] : 0;
		
		$bw->input ['commentCatId'] = $this->model->getCategories ()->getId ();
		
		if ($bw->input ['fileId'])
			$bw->input ['commentsImage'] = $bw->input ['fileId'];
		
		$com = $this->model->createBasicObject();
		$com->convertToObject ( $bw->input );
		$this->model->insertObject ($com);
		
		$obj = $this->model->vsRelation->createBasicObject();
		$this->model->vsRelation->setObjectId($bw->input ['objectId']);
		$this->model->vsRelation->setRelId($com->getId());
		$this->model->vsRelation->setTableName("{$bw->input ['tableName']}");
		$this->model->vsRelation->insertRel(NULL,NULL, false);
	}
	
	function loadDefault() {
		global $vsMenu, $vsSettings;
		
		$categories = $this->model->getCategories ();
		$strIds = $vsMenu->getChildrenIdInTree ( $categories );
		$size = $vsSettings->getSystemKey ( "comments_show_cat_num", 7, "comments" );
		
		$this->model->setFieldsString ( "commentsTitle,commentsImage,commentsId,commentsIntro,commentsContent,vsf_file.*" );
		$this->model->setCondition ( "commentsStatus > 0 and commentsCatId in ({$strIds})" );
		$this->model->setOrder ( "commentsId DESC" );
		$this->model->setTableName ( "comments left join vsf_file on commentsImage = fileId" );
		
		$option = $this->model->getPageList ( "comments", 1, 5 );
		
		return $this->output = $this->html->loadDefault ( $option );
	}
	
	
	public function loadDetail($objId) {
		global $bw, $vsLang, $vsPrint, $vsStd, $vsSettings, $vsMenu;
		
		$query = explode ( '-', $objId );
		$objId = abs ( intval ( $query [count ( $query ) - 1] ) );
		$this->model->setTableName ( "comments left join vsf_file on commentsImage = fileId" );
		$obj = $this->model->getObjectById ( $objId );
		if (! $obj)
			return $vsPrint->redirect_screen ( 'Không có dữ liệu theo yêu cầu' );
		$vsPrint->pageTitle = $obj->getTitle ();
		$option ['obj'] = $obj;
		$option ['category'] = $vsMenu->getCategoryById ( $obj->getCatId () );
		$option ['other'] = $this->model->getOtherList ( $obj );
		$otherHtml .= "<ul>";
		foreach ( $option ['other'] as $news ) {
			$otherHtml .= "<li><a href='" . $bw->base_url . "comments/detail/" . $news->getId () . "'>" . $news->getTitle () . "</a></li>";
		}
		$otherHtml .= "</ul>";
		$option ['other'] = " <div class='other'>" . "<h3>" . $vsLang->getWords ( 'comments_other_title', 'Các ý kiến khác' ) . "</h3>" . $otherHtml . "</div>";
		
		return $this->output = $this->html->loadDetail ( $obj, $option );
	}
	
	public function getOutput() {
		return $this->output;
	}
	
	public function setOutput($output) {
		$this->output = $output;
	}

}

?>