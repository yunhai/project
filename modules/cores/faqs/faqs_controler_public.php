<?php
require_once (CORE_PATH . 'faqs/faqs.php');
class faqs_controler_public extends VSControl_public {

	public function auto_run() {
		global $bw;
		switch ($bw->input ['action']) {
			case $this->modelName . '_detail' :
				$this->showDetail ( $bw->input [2] );
				break;
			
			case $this->modelName . '_questions' :
				$this->showQuestion ( $bw->input [2] );
				break;
			case $this->modelName . '_send' :
				$this->showSend ();
				break;
			case $this->modelName . '_thanks' :
				$this->showThanks();
				break;
			case $this->modelName . '_form' :
				$this->showForm();
				break;
			case $this->modelName . '_search' :
				$this->showSearch ();
				break;
			default :
				$this->showDefault ();
				break;
		}
	}

	public function __construct($modelName) {
		global $vsTemplate, $bw;
		// $this->html=$vsTemplate->load_template("skin_faq");
		parent::__construct ( $modelName, "skin_faqs", "faq", $bw->input [0] );
		
		// $this->model->categoryName=$bw->input[0];
	}

	function showDefault($option = array()) {
		global $bw, $vsTemplate, $vsStd, $vsPrint;
		
		$category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
		if(!$category){
			$vsPrint->boink_it($bw->base_url);
		}
		
		
		$ids=VSFactory::getMenus()->getChildrenIdInTree($category);
		$this->model->setCondition("status>0 and catId in ($ids)");
		$this->model->setOrder("`index`,id desc");
		$tmp=$this->model->getPageList($bw->input[0],1,VSFactory::getSettings()->getSystemKey($bw->input[0].'_paging_limit_show',12));
		$option=array_merge($tmp,$option);
		$option['breakcrum']=$this->createBreakCrum(null);
		$option['title']=VSFactory::getLangs()->getWords($bw->input[0]);		
		$vsPrint->mainTitle=$vsPrint->pageTitle=$option['title'];
		$option ['cate'] = $category->getChildren ();
		$this->showQuestion($option);

		return $this->output = $this->getHtml ()->showDefault ( $option );
	}
function showThanks($option = array()) {
		global $bw, $vsTemplate, $vsStd, $vsPrint;
		
	

		return $this->output = $this->getHtml ()->showThanks ( $option );
	}
function showForm($option = array()) {
		global $bw, $vsTemplate, $vsStd, $vsPrint;
		$vsStd->requireFile ( ROOT_PATH . "vscaptcha/VsCaptcha.php" );
		$image = new VsCaptcha ();
		$option['faqs']=$bw->input['faqs'];
       	if($bw->input['faqs']['submit']){
       		
       	
			if ($image->check ( $bw->input ['sec_code'] )) {
       	
       		$category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
       		$bw->input['faqs']['catId']=$category->getid();
//			$bw->input['proposals']['postdate']=time();
			$bw->input['faqs']['status']=0;
			$this->model->basicObject->convertToObject($bw->input['faqs']);
					
			$this->model->insertObject();
			
			//$this->output = $this->getHtml()->showThanks($option);
			$option['error'] = VSFactory::getLangs()->getWords('thanks_faqs')."!";
			unset($option['faqs']);
			}
			else{
				$option['error'] = VSFactory::getLangs()->getWords('captcha_not_match')."!";
			}
			
			

       	}
		
		return $this->output = $this->getHtml ()->showForm ( $option );
	}
	
	function showDetail($objId,$option=array()){
		global $vsPrint, $bw,$vsTemplate;
		$category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
		$obj=$this->model->getObjectById($this->getIdFromUrl($objId));
		if(!$obj->getId()||$obj->getStatus()<=0){
			return $this->output=VSFactory::getLangs()->getWords('not_count_item');
		}
		$obj->createSeo();
		$option['breakcrum']=$this->createBreakCrum($obj);
		$option['other']=$this->model->getOtherList($obj);
		$option['cate'] = $category->getChildren();
		$option['cate_obj']=VSFactory::getMenus()->getCategoryById($obj->getCatId());
		$obj->createSeo();
		$this->showQuestion($option);
		
		$this->output = $this->getHtml()->showDetail($obj,$option);
	}
	
	function showQuestion(&$option) {
		require_once CORE_PATH.'pages/pages.php';
		$pages=new pages();
		
		$category=VSFactory::getMenus()->getCategoryGroup('customer-service');
		$ids=VSFactory::getMenus()->getChildrenIdInTree($category);
		
		$pages->setCondition("catId in ($ids)");
		$pages->setOrder("`index`");
		$pages->setFieldsString ( "id,title" );
		$option['obj_list']=$pages->getObjectsByCondition();
	}

	function showSend() {
		global $bw, $vsTemplate, $vsPrint, $vsStd;
		
		$category = VSFactory::getMenus ()->getCategoryGroup ( $bw->input [0] );
		
			
			$this->model->basicObject->setTitle ( $bw->input ['faq_content'] );
			$this->model->basicObject->setCatId ( $category->getId() );
			$this->model->basicObject->setStatus ( 0 );
			$this->model->basicObject->setFullName ( $bw->input ['faq_name'] );
			$this->model->basicObject->setEmail ( $bw->input ['faq_email'] );
			
			$return = $this->model->insertObject ();
			
			$message = "<strong>Họ tên:</strong> {$bw->input ['faq_name']}<br />
		   	<strong>Email:</strong> {$bw->input ['faq_email']} <br />";
			$message .= "<br /><strong>Câu hỏi:</strong> {$bw->input ['faq_content']}<br /><br />";
			
			$vsStd->requireFile ( LIBS_PATH . "Email.class.php", true );
			$this->email = new Emailer ();
			$this->email->setTo ( VSFactory::getSettings ()->getSystemKey ( "email_receive_support", "support@myphamthanhthuy.vn", "configs" ) );
			
			$this->email->setFrom ( VSFactory::getSettings ()->getSystemKey ( "email_sender", "customer@vstatic.net", "configs" ), "Idea Mobile" );
			$this->email->setSubject ( "Câu hỏi: ".$bw->input ['faq_content'] );
			$this->email->setBody ( $this->html->showEmail ( $message ) );
			$this->email->sendMail ();
			
			echo 'sent';
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
	 * @var faqs
	 *
	 */
	var $model;
	
	/**
	 *
	 * @var skin_faqs
	 *
	 */
	var $html;
}
