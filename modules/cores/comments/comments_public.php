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
	if (! defined ( 'IN_VSF' )) {
		print "<h1>Permission denied!</h1>You cannot access this area. (VS Framework is powered by <a href=\"http://www.vietsol.net\">Viet Solution webdesign company</a>)";
		exit ();
	}
	
	require_once (CORE_PATH . "comments/comments.php");
	class comments_public {
		/**
		 * 
		 * Enter description here ...
		 * @var unknown_type
		 */
		protected $html;
		/**
		 * 
		 * Enter description here ...
		 * @var comments
		 */
		protected $module;
		protected $output;
		
		function __construct() {
			global $vsTemplate, $bw, $vsModule;
			$this->html = $vsTemplate->load_template ( 'skin_comments' );
			$this->module = new comments ();
		}
		
		function auto_run() {
			global $bw, $vsSettings;
			
			switch ($bw->input ['action']) {
				case 'get_comment_module' :
					$this->getCommentByModule ($bw->input[2], $bw->input[3]);
					break;
				case 'add_comment' :
					$this->addComment ();
					break;
				case 'get_list':
					$this->getList ($bw->input[2], $bw->input[3]);
					break;
				default :
					$this->loadDefault ();
					break;
			}
		}
		function getList($objId, $module){
			global $vsTemplate, $vsSettings;
			$condition = "status = 1 AND objId = $objId AND module = '$module'";
			$this->module->setCondition($condition);
			$size =$vsSettings->getSystemKey($module.'_comments_list_user', 5, $module);
			$option = $this->module->getPageList ( "comments/get_list/$objId/$module", 4, $size, 1, 'comment_view_panel' );
			return $this->output = $this->html->getList ( $option );
		}
		
		function getCommentByModule($objId, $module){
			global $vsTemplate, $vsSettings;
			$condition = "status = 1 AND objId = $objId AND module = '$module'";
			$this->module->setCondition($condition);
			$size = $vsSettings->getSystemKey($module.'_comments_list_user', 5, $module);
			$option = $this->module->getPageList ( "comments/get_list/$objId/$module", 4, $size, 1, 'comment_view_panel' );
			
			return $this->output = $this->html->getComments ( $option );
		}
		
		function getFormComment($objId=0, $module='news',$catId){
			return $this->html->getFormComment($objId, $module,$catId);
		}
		
		function addComment() {
			global $vsStd, $bw, $vsPrint, $vsLang;
                      
			$objId = $bw->input ['cobjId'];
			$objCatId = $bw->input ['cobjCatId'];
			$module = $bw->input ['cmodule'];
			$email = $bw->input ['commentEmail'];
			$name = $bw->input ['commentName'];
			$title = $bw->input ['commentTitle'];
			$content = $_POST ['commentContent'];
			$security = $bw->input ['commentSecurity'];
			$callback = $_SERVER ['HTTP_REFERER'] ? $_SERVER ['HTTP_REFERER'] : $bw->base_url;
			$option = pathinfo ( $callback );
			$vsStd->requireFile ( ROOT_PATH . "vscaptcha/VsCaptcha.php" );
			$image = new VsCaptcha ();
			if (! $image->check ( $security )) {
				$error = $vsLang->getWords($module.'_thanks_message',"Mã xác nhận không đúng!");
			}
			
			if ($error) {
				$bw->input ['message'] = $error;
				$option ['back'] = $callback;
				return $this->output ="<script>vsf.alert('{$error}');$('#vscapcha').attr('src',$('#vscapcha').attr('src')+'?a');</script>";
			}
			
			$this->module->getBasicObject()->setModule ( $module );
			$this->module->getBasicObject()->setObjId ( $objId );
			$this->module->getBasicObject()->setCatId ( $objCatId );
			$this->module->getBasicObject()->setTitle ( $title );
			$this->module->getBasicObject()->setEmail ( $email );
			$this->module->getBasicObject()->setName ( $name );
			$this->module->getBasicObject()->setContent ( $content );
			$this->module->getBasicObject()->setPostDate ( time () );
			
			$this->module->insertObject ();
			return $this->output ="<script>vsf.alert('{$vsLang->getWords('{$module}_thanks_message','Cám ơn bạn đã đóng góp ý kiến. Ý kiến của bạn đã được chuyển đến bộ phận chức năng xem xét.')}');$('#vscapcha').attr('src',$('#vscapcha').attr('src')+'?a');$('#frComment')[0].reset();</script>";
		
		}
		function loadDefault() {
			global $vsPrint, $vsLang, $bw, $vsSettings, $vsTemplate, $vsStd, $vsMenu;
			
			$this->output = $this->html->loadDefault ( $option );
		}
		
		function loadDetail($pageId, $com = NULL) {
			global $vsPrint, $vsLang, $bw, $vsMenu, $vsStd, $vsSettings;
			
			$this->output = $this->html->loadDetail ( $obj, $option );
		}
		
		function loadCategory($catId) {
			global $vsPrint, $vsLang, $bw, $vsSettings, $vsTemplate, $vsStd, $vsMenu, $DB;
			
			$this->output = $this->html->loadCategory ( $option );
		}
		
		function setOutput($out) {
			return $this->output = $out;
		}
		
		function getOutput() {
			return $this->output;
		}
	}
	?>
