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

			case 'viewform' :
					print $this->html->contactForm(); exit;
				break;
			case 'send' :
					$this->sendContact ();
				break;

			case 'thanks' :
					$this->thankContact();
				break;
			
			default :
				$this->showDefault ();
				
		}
	}

	
	function showDefault() {
		global $bw, $vsStd, $vsSettings, $vsLang,$vsMenu,$vsPrint;
 
		$vsStd->requireFile(CORE_PATH.'pcontacts/pcontacts.php');
		$page = new pcontacts();
		$categories = $vsMenu->getCategoryGroup("pcontacts");
      	$strIds=$vsMenu->getChildrenIdInTree($categories);
      	$page->setCondition("pcontactCatId in ({$strIds}) and pcontactStatus > 0");
      	$page->setOrder("pcontactIndex ASC, pcontactId ASC");
		$option['contact'] = $page->getOneObjectsByCondition();
//		print "<pre>";
//		print_r ($option['contact']);
//		print "</pre>";
//		exit();
//		if($option['contact'])
//        	$this->model->convertFileObject(array($option['contact']),'pcontacts'); 

//          print "<pre>";
//          print_r ($option['contact']);
//          print "</pre>";
//          exit();	
		$this->model->getNavigator();
		return $this->output = $this->html->showDefault($option);
		
	}

	function sendContact() {
		global $bw, $vsLang, $vsSettings, $vsPrint, $vsStd,$DB;

		$vsStd->requireFile ( CORE_PATH . 'files/files.php' );
		$file = new files ();
		if($vsSettings->getSystemKey("contact_form_security", 1, "contacts", 1, 1)){
			$security = $bw->input ['contactSecurity'];
			$vsStd->requireFile ( ROOT_PATH . "vscaptcha/VsCaptcha.php" );
			$image = new VsCaptcha();
			if (! $image->check ( $security )) {
				$bw->input['message'] = $vsLang->getWords('thank_message','Security code doesnot match');
				
		
				return $this->showDefault();
			}
		}
		
		$bw->input['contactPostDate'] = time();
//		$default_profile = array(
//								"contactAddress" 	=> $bw->input['contactAddress'],
//								"contactPhone"		=> $bw->input['contactPhone'],
//						);
		if($vsSettings->getSystemKey("contact_form_file", 0, "contacts", 0, 1))			
	    	if($_FILES[contactFile]){
	       		$infoupload = $file->uploadFile('contactFile',$bw->input['module']);
	          	$bw->input['contactFileId'] = $infoupload['fileId'];
	      	}
		//$bw->input ['contactProfile'] = serialize($default_profile);
		$this->model->obj->convertToObject($bw->input);

		$result = $this->model->insertObject();
		if($vsSettings->getSystemKey("contact_sendMail", 1, "contacts")){
			$this->sentContactByEmail($infoupload['objfile']);

		}
		if ($this->model->error != "")
			return $this->sendContactError();
		if($bw->input['contactType']==1)$url = "recruitments";
		else $url = $bw->input['module'];
		$this->thankcontact($url);
	}

	function sentContactByEmail($file) {
		global $vsStd, $vsLang, $bw, $vsSettings;
		$vsStd->requireFile ( LIBS_PATH . "Email.class.php", true );
		$this->email = new Emailer ();

		if($vsSettings->getSystemKey("contact_form_name", 1, "contacts", 1, 1))
			$message = "<strong>{$vsLang->getWords('contact_full_name','Họ và tên')}:</strong> {$this->model->obj->getName()}<br />";

		if($vsSettings->getSystemKey("contact_form_email", 1, "contacts", 1, 1))
			$message .= "<strong>{$vsLang->getWords('contact_email','Email')}:</strong> {$this->model->obj->getEmail()}<br />";

		if($vsSettings->getSystemKey("contact_form_address", 1, "contacts", 1, 1))
			$message .= "<strong>{$vsLang->getWords('contact_address','Địa chỉ')}:</strong>" . $this->model->obj->getAddress();

		if($vsSettings->getSystemKey("contact_form_phone", 1, "contacts", 1, 1))
			$message .= "<br /><strong>{$vsLang->getWords('contact_phone','Điện thoại')}:</strong>" . $this->model->obj->getPhone();

		if($vsSettings->getSystemKey("contact_form_company", 0, "contacts", 1, 1))
			$message .= "<br /><strong>{$vsLang->getWords('contact_company','Công ty:')}:</strong>" . $this->model->obj->getCompany();

		if($vsSettings->getSystemKey("contact_form_cell", 0, "contacts", 1, 1))
			$message .= "<br /><strong>{$vsLang->getWords('contact_mobile','Di động')}:</strong>" . $this->model->obj->getDidong() . "<br />";


		if($vsSettings->getSystemKey("contact_form_title", 1, "contacts", 1, 1))
			$message .= "<br /><strong>{$vsLang->getWords('contact_title','Tiêu đề')}:</strong> {$this->model->obj->getTitle()}<br />";

		$message .= "<br /><strong>{$vsLang->getWords('contact_message','Subject')}:</strong>" . $this->model->obj->getContent();
		$this->email->setTo ( $vsSettings->getSystemKey("contact_emailrecerver", "minhhai@vietsol.net", "contacts"));
      	if($vsSettings->getSystemKey("contact_form_file", 0, "contacts", 0, 1))	
			if($file){
			$f = file_get_contents($bw->base_url."uploads/".$file->getPath().$file->getName()."_{$file->getUploadTime()}".".".$file->getType(), true);
			$this->email->addAttachment($f,$file->getName()."_{$file->getUploadTime()}".".".$file->getType(),"application/force-download");
	      	}
		$this->email->setFrom ( $this->model->obj->getEmail (), $this->model->obj->getName() );
		$this->email->setSubject ($this->model->obj->getTitle () );
		$this->email->setBody ( $message );

		$this->email->sendMail ();
	}

	function thankcontact($url="contacts") {
		global $vsLang, $vsPrint;
		$text = $vsLang->getWords($url.'_redirectText', 'Thankyou! Your message have been sent.');
		
		$this->output = $this->html->thankyou ( $text, $url );
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