<?php
/*
 +-----------------------------------------------------------------------------
 |   VIET SOLUTION SJC  base on IPB Code version 2.0.0
 |	Author: BabyWolf
 |	Homecontact: http://khkt.net
 |	If you use this code, please don't delete these comment line!
 |	Start Date: 21/09/2004
 |	Finish Date: 22/09/2004
 |	Modified Start Date: 07/02/2007
 |	Modified Finish Date: 10/02/2007
 +-----------------------------------------------------------------------------
 */
require_once (CORE_PATH . "menus/menus.php");
require_once (CORE_PATH . "contacts/contacts.php");

if (! defined ( 'IN_VSF' )) {
	print "<h1>Permission denied!</h1>You cannot access this area. (VS Framework is powered by <a href=\"http://www.vietsol.net\">Viet Solution webdesign company</a>)";
	exit ();
}

class contacts_admin  {
	public $html = "";
	public $output = "";

	function __construct() {
		global $vsPrint,$vsTemplate;
		$this->module = new contacts();
		$vsPrint->addJavaScriptFile("tiny_mce/tiny_mce");
		$this->html = $vsTemplate->load_template('skin_contacts');

	}

	function auto_run() {
		global $bw;

		switch ($bw->input[1]) {
			case 'read':
					$this->readContactProcess($bw->input[2]);
				break;

			case 'reply':
				$this->showReplyContactForm($bw->input[2]);
				break;

			case 'replyProcess':
				$this->replyProcess($bw->input[2], $bw->input[3]);
				break;


			case 'deleteAllContact':
				$this->deleteContactAll();
				break;

			case 'showContact':
					$this->output = $this->showContactList($bw->input['contactType']);
				break;
					
			default:
				$contactType = empty($bw->input[1]) ? 0 : 1;
				$this->showContacts($contactType);
		}
	}



	function showContactList($contactType=0) {
		global $vsLang, $bw ,$vsSettings;

		if(!isset($contactType)) $contactType = $bw->input[2] ? $bw->input[2] : 0;
		$this->module->setCondition('contactType = '.$contactType);
		
		$size = $vsSettings->getSystemKey("list_quality", 10);
		
		$option = $this->module->getPageList("contacts/showContact/{$contactType}", 3, $size, 1, 'ContactList');
		$option['contactType'] = $contactType;
		return $this->output = $this->html->contactList($option);
	}

	function deleteContactAll() {
		global $bw;
		
		$this->module->setCondition("contactId in ({$bw->input[3]})");
		$this->module->deleteObjectByCondition();
		unset($bw->input[3]);
		$this->output = $this->showContactList($bw->input[2]);
	}

	function readContactProcess($contactId){
		global $vsStd;
		$contact = $this->module->getObjectById($contactId);
		$contactProfile	= unserialize($contact->getProfile());		
		
		$this->output = $this->html->readContactInfo($contact, $contactProfile);
		
		$contact->setStatus(1);
		$this->module->updateObjectById($contact, "contacts");
	}

	function showReplyContactForm($contactId){
		global $bw, $vsPrint, $vsStd, $vsSettings, $vsLang;
		
		$vsPrint->addJavaScriptFile ( "tiny_mce/tiny_mce" );
		$vsStd->requireFile ( JAVASCRIPT_PATH . "/tiny_mce/tinyMCE.php" );
		$editor = new tinyMCE();
		$this->module->getObjectById($contactId);
			
		$contactProfile = unserialize($this->module->obj->getProfile());
	
		$this->module->objMessage = $this->module->obj->getContent();

		
		if($vsSettings->getSystemKey("contact_form_address", 1, "contacts", 1, 1) && $contactProfile[0])
			$address = "<strong>{$vsLang->getWords('reply_address','Address')}:</strong> {$contactProfile[0]}<br />;";
			
		if($vsSettings->getSystemKey("contact_form_phone", 1, "contacts", 1, 1) && $contactProfile[1] )
			$phone = "<br /><strong>{$vsLang->getWords('reply_phone','Phone')}:</strong>" . $contactProfile[1]; 

		if($vsSettings->getSystemKey("contact_form_company", 1, "contacts", 1, 1) && $contactProfile[2] )
			$company = "<br /><strong>{$vsLang->getWords('reply_company','Company')}:</strong>" . $contactProfile[2];
		
		
		$contactPreMessage = <<<EOF
			<br />
			{$this->module->obj->getPostDate('SHORT')} <strong>{$this->module->obj->getName()} <i>&lt;{$this->module->obj->getEmail()}&gt;</i></strong>:<br />
	        <blockquote style="border-left: 2px solid rgb(16, 16, 255); margin: 0pt 0pt 0pt 0.8ex; padding-left: 1ex; background:#F4F4F4;">
	        	{$vsLang->getWords('reply_from','From')}: 
				{$this->module->obj->getEmail()} <{$this->module->obj->getEmail()}><br />
	        	
				{$vsLang->getWords('reply_subject','Subject')}:
				{$this->module->obj->getTitle()}<br />
				
				{$address}
				
				{$phone}
				
				{$company}
				
	        	{$vsLang->getWords('reply_to','To')}:
	        	{$vsSettings->getSystemKey("global_websitename", "www.vietsol.net", "global", 0)}<br />
	        </blockquote><br /><br />
			{$this->module->obj->getContent()}
EOF;

	        $option['obj'] = $this->module->obj;
	        $option['currenPage']=$bw->input[4];
	        
	        
			$editor->setWidth('100%');
			$editor->setHeight('500px');
			$editor->setToolbar('advanced');
			$editor->setTheme("advanced");
	        
						
			
			$editor->setInstanceName('contactContent');
			$editor->setValue($contactPreMessage);
			$option['replyFormEditor'] = ($editor->createHtml());
			
			
			
			
	        $this->module->obj->setStatus(1);
	        $this->module->updateObjectById($this->module->obj);
	        $this->output = $this->html->replyContactForm( $option);
	}

	function replyProcess($contactId, $contactType=0) {
		global $bw, $vsLang, $vsStd ,$vsSettings;

		$parser = new PostParser ();
		$parser->pp_do_html = 1;
		$parser->pp_nl2br = 0;
		$body =  $parser->post_db_parse($bw->input['contactContent']);
		
		$this->module->getObjectById($contactId);
		$vsStd->requireFile ( LIBS_PATH . "Email.class.php", true );

		$email = new Emailer();
		$email->setTo($bw->input['email']);
		
		$email->setFrom($vsSettings->getSystemKey("contact_emailrecipient", "yunhaihuang@gmail.com", "config"), $this->module->obj->getTitle());
		$email->setSubject($vsSettings->getSystemKey("global_websitename","www.vietsol.net", "global", 0));
		
		
		$email->setBody($body);
           
		$email->sendMail();

		$option['message'] = $vsLang->getWords('contact_send_fail', 'Send mail fail');

		if(!$this->email->error) {
			
			$this->module->obj->setIsReply(1);
			$this->module->obj->setStatus(1);
			$this->module->updateObjectById($this->module->obj);
				
			$option['message'] = $vsLang->getWords('contact_send_success', 'You have successfully send mail');
		}
		$this->showContacts($contactType, $option);
	}

	function showContacts($contactType = 0, $option=''){
		global $bw,$vsPrint,$vsSettings;

		$vsPrint->addJavaScriptString('init_tab','
			$(document).ready(function(){
    			$("#page_tabs").tabs({
    				cache: false
    			});
  			});
		');

		$script = '<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyBUmE1ByJKy7AmcERUfyf2ggIJaTVk9ars"></script>';
		$this->output=$this->html->contactMainLayout($option).$script;
	}

	public function getContact() {
		return $this->contact;
	}

	public function setContact($contact) {
		$this->contact = $contact;
	}

	public function getOutput() {
		return $this->output;
	}

	public function setOutput($outputHTML){
		$this->output = $outputHTML;
	}
}
?>