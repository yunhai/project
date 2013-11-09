<?php

class advisorys_admin extends ObjectAdmin{
	public function __construct(){
		global $vsTemplate;
		parent::__construct('advisorys', CORE_PATH.'advisorys/', 'advisorys');
                $this->html = $vsTemplate->load_template('skin_advisorys');
	}
	
	function auto_run() {
		global $bw;
	
		switch($bw->input[1]){
			case 'delete-checked-obj':
					$this->module->delete(rtrim($bw->input['checkedObj'],","));
				break;
					
			case 'visible-checked-obj':
					$this->checkShowAll(1);
				break;
				
			case 'hide-checked-obj':
					$this->checkShowAll(0);				
				break;
				
			case 'home-checked-obj':
					$this->checkShowAll(2);				
				break;	
				
			case 'display-obj-tab':
					$this->displayObjTab();
				break;
				
			case 'display-obj-list':					
					$this->getObjList($bw->input[2], $this->module->result['message']);
				break;
			
			case 'add-edit-obj-form':
					$this->addEditObjForm($bw->input[2]);
				break;
				
			case 'add-edit-obj-process':
					$this->addEditObjProcess();
				break;
				
			case 'delete-obj':		
					$this->deleteObj($bw->input[2]);
				break;
			case 'reply':
					$this->showReplyadvisoryForm($bw->input[2]);
				break;
				
			case 'replyProcess':
					$this->replyProcess($bw->input[2], $bw->input[3]);
				break;		
				
			default:
				$this->loadDefault();
		}
	}
	
	function replyProcess($advisoryId, $advisoryType=0) {
		global $bw, $vsLang, $vsStd ,$vsSettings;

		$vsStd->requireFile ( LIBS_PATH . "Email.class.php", true );

		$this->email = new Emailer ( );
		$message = $this->email->clean_message($bw->input['Content']);
		$this->email->setTo($bw->input['email']);
		$this->email->setSubject($vsSettings->getSystemKey("global_websitename", "www.vietsol.net"));
		$this->email->setBody($message);
		$this->email->sendMail();


		$option['message'] = $vsLang->getWords('advisory_send_fail', 'Send mail fail');

		if(!$this->email->error) {
			$this->module->getObjectById($advisoryId);
			$this->module->updateObjectById($this->module->obj);
				
			$option['message'] = $vsLang->getWords('advisory_send_success', 'You have successfully send mail');
		}
		print 	"<script>
					vsf.alert(\"{$option['message']}\");
					$('#albumn-reply').remove();
				</script>";	
		return true;
	}
	
	function showReplyadvisoryForm($advisoryId){
		global $bw, $vsStd ,$vsSettings, $vsPrint;

		$this->module->getObjectById($advisoryId);
		
		$message = <<<EOF
			<br />
			On: <strong>{$this->module->obj->getPostDate()}, 
                            {$this->module->obj->getName()} <i>
                            &lt;{$this->module->obj->getEmail()}&gt;</i></strong> wrote:<br />
                    {$this->module->obj->getIntro()}
	        <blockquote style="border-left: 2px solid rgb(16, 16, 255); margin: 0pt 0pt 0pt 0.8ex; padding-left: 1ex; background:#F4F4F4;">
	        	From: {$this->module->obj->getEmail()} <{$this->module->obj->getEmail()}><br/>
	        	Subject: {$this->module->obj->getTitle()}<br/>
	        	To: {$vsSettings->getSystemKey("global_websitename","www.vietsol.net")}<br/>
	        	Address:{$this->module->obj->getAddress()}<br/>
	        	Phone:{$this->module->obj->getPhone()}<br/>
	        	Date:{$this->module->obj->getPostDate('LONG')}<br/>
	        	
	        	
	        </blockquote><br /><br />
	        
			
EOF;

		$vsPrint->addJavaScriptFile("tiny_mce/tiny_mce");
		$vsStd->requireFile(JAVASCRIPT_PATH."/tiny_mce/tinyMCE.php");
		
		$editor = new tinyMCE();
		$editor->setWidth('100%');
		$editor->setHeight('500px');
		$editor->setToolbar('narrow');
		$editor->setTheme("advanced");
		$editor->setInstanceName('newsIntro');
		$editor->setValue($message);
		$this->module->obj->setIntro($editor->createHtml());
	        	
        $option['obj'] = $this->module->obj;
        $option['currenPage'] = $bw->input[4];
        $this->module->obj->setStatus(1);
        $this->module->updateObjectById($this->module->obj);
        
        return $this->output = $this->html->replyadvisoryForm($option);
	}
}
?>