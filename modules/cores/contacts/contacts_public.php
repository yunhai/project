<?php

if (! defined ( 'IN_VSF' )) {
	print "<h1>Permission denied!</h1>You cannot access this area. (VS Framework is powered by <a href=\"http://www.vietsol.net\">Viet Solution webdesign company</a>)";
	exit ();
}

global $vsStd;
$vsStd->requireFile ( CORE_PATH . 'contacts/contacts.php' );

class contacts_public {
	private $html = "";
	public $output = "";
	public $model;

	function __construct() {
		global $vsTemplate, $vsPrint,$vsTemplate;
		$this->model = new contacts ();
		$this->html = $vsTemplate->load_template ( 'skin_contacts' );
	}

	function auto_run() {
		global $bw, $vsTemplate;
                
		switch ($bw->input ['action']) {
			case 'send':
					$this->sendContact();
				break;

			case 'thanks' :
					$this->thankContact();
				break;
			
			default :
				$this->showDefault($bw->input[1]);
		}
	}

	
	function showDefault($id = 0){
		global $bw, $vsStd, $vsSettings, $vsLang, $vsMenu, $vsPrint;

		$vsStd->requireFile(CORE_PATH.'pcontacts/pcontacts.php');
		$page = new pcontacts();
		$categories = $vsMenu->getCategoryGroup("branch");

		$strIds = $vsMenu->getChildrenIdInTree($categories);
		$page->setCondition("pcontactCatId in ({$strIds}) and pcontactStatus > 0");
		$page->setOrder("pcontactIndex, pcontactId");
		$plist = $page->getObjectsByCondition();
		
		$main = current($plist);
		if(!$main) return;
		if(!$id) {
			global $vsPrint;

			$target = $bw->base_url.'contacts/'.$main->getCleanTitle().'-'.$main->getId();
			return $vsPrint->boink_it($target);
		}
		
		$vsPrint->addJavaScriptFile( 'jquery/ui.core');
		$vsPrint->addJavaScriptFile( 'jquery/ui.widget');
		$vsPrint->addJavaScriptFile( "jquery/ui.alerts");
		
		
		$vsPrint->addGlobalCSSFile('jquery/base/ui.theme');
		$vsPrint->addGlobalCSSFile('jquery/base/ui.core');
		$vsPrint->addGlobalCSSFile('jquery/base/ui.theme');
		$vsPrint->addGlobalCSSFile('jquery/base/ui.dialog');
		
		$query = explode('-',$id);
		$id = intval($query[count($query)-1]);
		$main = $plist[$id];
		
		$plist[$id]->active= 'active';
		
		$option['plist'] = $plist;
		$option['contact'] = $main;
		$this->model->getNavigator();
		$bw->input['targetpage'] = 'contacts/'.$main->getCleanTitle().'-'.$main->getId();
		return $this->output = $this->html->showDefault($option);
	}
        
	function sendContact() {
		global $bw, $vsStd, $vsSettings, $vsLang, $vsMenu, $vsPrint, $DB;
		
		
		$query = explode('-',$bw->input['targetpage']);
		$id = intval($query[count($query)-1]);
		
		$vsStd->requireFile(CORE_PATH.'pcontacts/pcontacts.php');
		$page = new pcontacts();
		$branch = $page->getObjectById($id);
		if($branch) $bw->input['contactTitle'] = $branch->getTitle() . " | " . $bw->input['contactTitle'];
		$bw->input['branch'] = $branch->getTitle();
		$bw->input['contactPostDate'] = time();
		$default_profile = array(
								"contactAddress" 	=> $bw->input['contactAddress'],
								"contactPhone"		=> $bw->input['contactPhone'],
						);
		
		$bw->input ['contactProfile'] = serialize($default_profile);
		$this->model->obj->convertToObject($bw->input);

		$result = $this->model->insertObject();
		if($vsSettings->getSystemKey("contact_sendMail", 1, "contacts"))
			$this->sentContactByEmail($default_profile);
		
		if ($this->model->error != "") return $this->sendContactError();
		
		$url = $bw->input['targetpage']?$bw->input['targetpage']:$bw->input['module'];
		
		$vsStd->requireFile(CORE_PATH.'pcontacts/pcontacts.php');
		$page = new pcontacts();
		$categories = $vsMenu->getCategoryGroup("branch");
		
		$strIds = $vsMenu->getChildrenIdInTree($categories);
		$page->setCondition("pcontactCatId in ({$strIds}) and pcontactStatus > 0");
		$page->setOrder("pcontactIndex, pcontactId");
		$plist = $page->getObjectsByCondition();
		
		$main = current($plist);
		if(!$main) return;
		if(!$id) {
			$target = $bw->base_url.'contacts/'.$main->getCleanTitle().'-'.$main->getId();
			return $vsPrint->boink_it($target);
		}
		
		
		
		$query = explode('-',$id);
		$id = intval($query[count($query)-1]);
		$main = $plist[$id];
		
		$plist[$id]->active= 'active';
		
		$option['plist'] = $plist;
		$option['contact'] = $main;
		
		$this->thankcontact($url, $option);
	}

	function sentContactByEmail($addon_profile, $file) {
		global $vsStd, $vsLang, $bw, $vsSettings;
		$vsStd->requireFile ( LIBS_PATH . "Email.class.php", true );
		$email = new Emailer ();

		$message  = "<strong>{$vsLang->getWords('contact_fullname','Fullname')}:</strong> {$this->model->obj->getName()}<br />";
		$message .= "<strong>{$vsLang->getWords('contact_phone','Phone')}:</strong> {$addon_profile ["contactPhone"]}<br />";
		$message .= "<strong>{$vsLang->getWords('contact_address','contactAddress')}:</strong> {$addon_profile ["contactAddress"]}<br />";
		$message .= "<strong>{$vsLang->getWords('contact_email','Email')}:</strong> {$this->model->obj->getEmail()}<br />";
		$message .= "<strong>{$vsLang->getWords('contactSubject','Subject:')}:</strong> {$this->model->obj->getTitle()}<br />";

		$recipient_temp = $vsSettings->getSystemKey("contact_emailrecipient", "yunhaihuang@gmail.com", "config");
		$recipients = explode(",", $recipient_temp);
		if(!$recipients) return;
		
		$index = 0;
		foreach($recipients as $recipient){
			$recipient = trim($recipient);
			if($index++ == 0){
				$email->setTo($recipient);
			}else{
				$email->addBCC($recipient);
			}
		}
		
		$message .= "<br /><strong>Message:</strong>" . $this->model->obj->getContent();
		$email->setFrom($this->model->obj->getEmail(), $this->model->obj->getTitle());
		
		$subject = $vsSettings->getSystemKey('global_websitename', 'Pandog', 'global', 1, 1).' - '.
					$bw->input['branch'].' | '.
					$vsLang->getWords('contact_email_subject', 'Contact');
					
		$email->setSubject($subject);
		$email->setBody($message);

		$email->sendMail();
	}

	function thankcontact($url = "contacts"){
		global $bw, $vsStd, $vsSettings, $vsLang,$vsMenu,$vsPrint;
		
		
		$vsStd->requireFile(CORE_PATH.'pcontacts/pcontacts.php');
		$page = new pcontacts();
		$categories = $vsMenu->getCategoryGroup("branch");
		$strIds=$vsMenu->getChildrenIdInTree($categories);
		$page->setCondition("pcontactCatId in ({$strIds}) and pcontactStatus > 0");
		$page->setOrder("pcontactIndex DESC, pcontactId");
		$plist = $page->getObjectsByCondition();
		
				
		$query = explode('-', $url);
		$id = intval($query[count($query)-1]);
		$main = $plist[$id];
		if($main){
			$plist[$id]->active= 'active';
			
			$option['plist'] = $plist;
			$option['contact'] = $main;
		}
		$this->model->getNavigator();
		
		
		$url = $bw->base_url.$url;
		$this->output = $this->html->thankyou($url, $option);
	}

	function sendContactError() {
		global $vsLang;
		$this->output = $vsLang->getWords ( 'contact_sendContentError', 'The following errors were found! Unknow!' );
	}

	function __destruct() {
		unset ( $this->html );
		unset ( $this->ouput );
	}

	function getOutput() {
		return $this->output;
	}
}
?>