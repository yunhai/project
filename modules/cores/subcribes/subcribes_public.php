<?php

global $vsStd;
$vsStd->requireFile ( CORE_PATH . 'subcribes/subcribes.php' );

class subcribes_public {
	
	
	function __construct() {
		global $vsTemplate, $vsPrint;
                 
		$this->model = new subcribes();		
		$vsPrint->addCSSFile('subcribe');
               
		$this->html = $vsTemplate->load_template('skin_subcribes');
	}
	
	function auto_run() {
		global $bw;

		switch ($bw->input[1]){
			case 'register' :
					$this->register();
				break;
			case 'registerprocess' :
					$this->registerProcess();
				break;
			case 'default':
					$this->loadDefault();
				break;
			case 'unsubcribeform':
					$this->unsubcribeForm();
				break;
			case 'unsubcribe':
					$this->unsubcribe();
				break;
			case 'subcribe':
					$this->subcribe();
				break;
		}
	}

	function unsubcribeForm(){
		global $bw;
		
		$option['subId'] = $bw->input[2];
		$this->output = $this->html->unsubcribeForm($option);
	}
	
	function unsubcribe(){
		global $bw, $vsLang;
		
		$cond = 'subId = '.$bw->input['id'];
		$option['message'] = $vsLang->getWords('subcribe_unsubcribe_email_error', 'Email bạn đã nhập không đúng');
		$this->model->getObjectById($bw->input['id']);
		if($this->model->obj->getEmail() == $bw->input['email']){
			$option['message'] = $vsLang->getWords('subcribe_unsubcribe_update_error', 'Đã xảy ra lỗi trong quá trình cập nhật.');
			$this->model->setCondition($cond);
			
			
			if($this->model->updateObjectByCondition(array('subStatus'=>0)))
				$option['message'] = $vsLang->getWords('subcribe_unsubcribe_update_ok', 'Bạn đã hủy chức năng nhận tin nhắn');
		}
		return $this->output = $this->html->unsubcribeForm($option);
	}
	
	function subcribe(){
		global $bw;
		//if($bw->input['vss'] != 'sendsubcribe') return false;
		
		$this->model->setCondition('subStatus > 0');
		$this->model->setLimit(array(0, 10));
		
		$mods = array('reals', 'travels', 'news','projects');
		$temp = $this->model->getObjectsByCondition('getContent', 1);
		foreach($temp as $key=>$value){
			if(in_array($key, $mods)){
				$fn = 'get'.$key.'item';
				$this->$fn($value);
			}
		}
	}
	
	function getrealsitem($members = array()){
		global $bw, $vsStd;
		$vsStd->requireFile(CORE_PATH.'reals/reals.php');
		$reals = new reals();
		$cond = 'realStatus > 0';
		
		$reals->setCondition($cond);
		$reals->setOrder('realId DESC');
		$item = $reals->getOneObjectsByCondition();
		
		if($item){
			$content = $this->html->realsHTML($item);
			$item->mname = 'reals';
			$title = $item->getTitle();
			$this->sendEmail($title, $content, $members);
		}
	}
	
	function gettravelsitem($members = array()){
		global $bw, $vsStd;
		$vsStd->requireFile(CORE_PATH.'travels/travels.php');
		$reals = new travels();
		$cond = 'travelStatus > 0';
		
		$reals->setCondition($cond);
		$reals->setOrder('travelId DESC');
		$item = $reals->getOneObjectsByCondition();
		if($item){
			$content = $this->html->realsHTML($item);
			$item->mname = 'travels';
			$title = $item->getTitle();
			$this->sendEmail($title, $content, $members);
		}
	}
	
	function getnewsitem($members = array()){
		global $bw, $vsStd;
		$vsStd->requireFile(CORE_PATH.'news/news.php');
		$reals = new newses();
		$cond = 'newsStatus > 0';
		
		$reals->setCondition($cond);
		$reals->setOrder('newsId DESC');
		$item = $reals->getOneObjectsByCondition();
		
		if($item){
			$item->mname = 'news';
			$content = $this->html->realsHTML($item);
			
			$title = $item->getTitle();
			$this->sendEmail($title, $content, $members);
		}
	}
	
	function getprojectsitem($members = array()){
		global $bw, $vsStd;
		$vsStd->requireFile(CORE_PATH.'projects/projects.php');
		$reals = new projects();
		$cond = 'projectStatus > 0';
		
		$reals->setCondition($cond);
		$reals->setOrder('projectId DESC');
		$item = $reals->getOneObjectsByCondition();
		if($item){
			$content = $this->html->realsHTML($item);
			$item->mname = 'projects';
			$title = $item->getTitle();
			$this->sendEmail($title, $content, $members);
		}
	}
	
	
	function sendEmail($title, $content, $members){
		global $bw, $vsStd;
		$vsStd->requireFile ( LIBS_PATH . "Email.class.php", true );
		$email = new Emailer ();
		$email->setTo($bw->vars['global_systememail']);
		
		foreach($members as $member){
			$cc = $member->getEmail();
			$email->addBCC($cc);
		}
		
		$email->setFrom($bw->vars['global_systememail'], $title);
		$email->setSubject($title);
		$email->setBody($content);
		$email->sendMail();
	}
	
	
	function register(){
		global $bw, $vsLang;
		
		
		$option['content'] = array(
					'reals' 	=> $vsLang->getWords('subscribe_type_reals','Bất động sản'), 
					'projects' 	=> $vsLang->getWords('subscribe_type_projects','Dự án'), 
					'travels' 	=> $vsLang->getWords('subscribe_type_travels','Du lịch'), 
					'news' 		=> $vsLang->getWords('subscribe_type_news','Tin tức'),
		); 
		return $this->output = $this->html->register($option);
	}
	
	function registerProcess(){
		global $bw;
		unset($bw->input['isubmit']);
		
		$profile['fullname'] 	= $bw->input['fullname'];
		$profile['phone'] 		= $bw->input['phone'];
		$bw->input['subProfile']= serialize($profile);
		
		$this->model->obj->convertToObject($bw->input);
		$this->model->insertObject();
		
		$this->output = $this->html->registerProcess();
	}
	
	function loadDefault(){
		$this->output = 'default';
	}
	
	protected $html;
	protected $model;
	protected $output;
	
	public function getOutput() {
		return $this->output;
	}
	
	public function setOutput($output) {
		$this->output = $output;
	}
}
?>