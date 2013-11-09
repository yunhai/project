 <?php
	class pages_public extends ObjectPublic {
		function __construct() {
			global $incon, $vsMenu;
			parent::__construct ( 'pages', CORE_PATH . 'pages/', 'pages' );
		}
		
		function auto_run() {
			global $bw;
			
			switch ($bw->input ['action']) {
				case 'detail' :
					$this->showDetail ( $bw->input [2] );
					break;
				case 'form' :
					$this->output = $this->html
						->getForm ();
					break;
				case 'category' :
					$this->showCategory ( $bw->input [2] );
					break;
				case 'searchs' :
					$this->showSearch ();
					break;
				case 'send' :
					$this->sendContact ();
					break;
				
				case 'thanks' :
					$this->thankContact ();
					break;
				default :
					$this->showDefault ();
					break;
			}
		}
		function sendContact() {
			global $bw, $vsLang, $vsSettings, $vsPrint, $vsStd, $DB;
			$vsStd->requireFile ( CORE_PATH . 'contacts/contacts.php' );
			$vsStd->requireFile ( CORE_PATH . 'files/files.php' );
			$this->model = new contacts ();
			$file = new files ();
			
			$vsStd->requireFile ( ROOT_PATH . "captcha/securimage.php" );
			$image = new Securimage ();
			if (! $image->check ( $bw->input ['contactSecurity'] )) {
				$message = $vsLang->getWords ( 'thank_message', 'Security code doesnot match' );
				$vsPrint->redirect_screen ( $message, "{$bw->input['module']}/form" );
			}
			
			$bw->input ['contactPostDate'] = time ();
			$bw->input ['contactType'] = 1;
			$default_profile = array ("contactAddress" => $bw->input ['noio'], "contactPhone" => $bw->input ['dienthoai'], "contactMobile" => $bw->input ['didong'], "contactCountry" => $bw->input ['quoctich'], "contactStatus" => $bw->input ['tinhtranghonnhan'], "contactBirth" => $bw->input ['day'] . "-" . $bw->input ['month'] . "-" . $bw->input ['year'] );
			
			$infoupload = $file->uploadFile ( 'fileupload', $bw->input ['module'] );
			$bw->input ['contactFileId'] = $infoupload ['fileId'];
			$bw->input ['contactProfile'] = serialize ( $default_profile );
			
			$this->model->obj
				->convertToObject ( $bw->input );
			$this->model->obj
				->setContent ( $this->getContentRecruiment ( $default_profile ) );
			$result = $this->model
				->insertObject ();
			
			if ($vsSettings->getSystemKey ( "recruitment_sendMail", 1, "contacts" ))
				$this->sentContactByEmail ( $default_profile, $infoupload ['objfile'] );
			
			if ($this->model->error != "")
				return $this->sendContactError ();
			
			$this->thankcontact ( "{$bw->input['module']}/form" );
		}
		
		function sentContactByEmail($addon_profile, $file) {
			global $vsStd, $vsLang, $bw, $vsSettings;
			
			$vsStd->requireFile ( LIBS_PATH . "Email.class.php", true );
			$this->email = new Emailer ();
			
			$message = $this->getContentRecruiment ( $addon_profile );
			$f = file_get_contents ( $bw->base_url . "uploads/" . $file->getPath () . $file->getName () . "_{$file->getUploadTime()}" . "." . $file->getType (), true );
			$this->email
				->setTo ( $vsSettings->getSystemKey ( "recruitment_emailrecerver", "baochau@vietsol.net", "recruitment" ) );
			$this->email
				->addAttachment ( $f, $file->getName () . "_{$file->getUploadTime()}" . "." . $file->getType (), "application/force-download" );
			$this->email
				->setFrom ( $this->model->obj
				->getEmail (), $this->model->obj
				->getTitle () );
			$this->email
				->setSubject ( $vsLang->getWords ( $bw->input ['recruitment'] . '_position', 'Vị trí dự tuyển' ) . ":  {$this->model->obj->getTitle()}" );
			$this->email
				->setBody ( $message );
			
			$this->email
				->sendMail ();
		}
		function getContentRecruiment($addon_profile = array()) {
			global $vsLang;
			$message = "<strong>{$vsLang->getWords($bw->input['recruitment']."_position", "Vị trí dự tuyển")}:</strong> {$this->model->obj->getTitle()} <br />";
			$message .= "<p><strong>{$vsLang->getWords($bw->input['recruitment']."_fullname", "Họ tên")}:</strong> {$this->model->obj->getName()}<br />";
			$message .= "</p><p><strong>{$vsLang->getWords($bw->input['module']."_birth", "Ngày sinh")}: </strong>" . $addon_profile ["contactBirth"];
			$message .= "</p><p><br /><strong>{$vsLang->getWords($bw->input['recruitment']."_country", "Quốc tịch")}: </strong>" . $addon_profile ["contactCountry"];
			$message .= "</p><p><br /><strong>{$vsLang->getWords($bw->input['recruitment']."_status", "Tình trạng hôn nhân")}: </strong>" . $addon_profile ["contactStatus"];
			$message .= "</p><p><br /><strong>{$vsLang->getWords($bw->input['recruitment']."_address", "Địa chỉ nơi ở")}: </strong>" . $addon_profile ["contactAddress"] . "<br />";
			$message .= "</p><p><br /><strong>{$vsLang->getWords($bw->input['recruitment']."_phone", "Điện thoại")}: </strong>" . $addon_profile ["contactPhone"] . "<br />";
			$message .= "</p><p><br /><strong>{$vsLang->getWords($bw->input['recruitment']."_mobile", "Số di động")}: </strong>" . $addon_profile ["contactMobile"] . "<br />";
			$message .= "</p><p><br /><strong>{$vsLang->getWords($bw->input['recruitment']."_email", "Địa chỉ Email")}: </strong> {$this->model->obj->getEmail()}<br />";
			$message .= "</p><p><br /><strong>{$vsLang->getWords('contactSubject','Subject:')}: </strong> {$this->model->obj->getTitle()}<br /></p>";
			return $message;
		}
		
		function thankcontact($url = "recruitment") {
			global $vsLang, $vsPrint;
			$text = $vsLang->getWords ( 'contact_redirectText', 'Thankyou! Your message have been sent.' );
			$this->output = $this->html
				->thankyou ( $text, $url );
		}
		
		function sendContactError() {
			global $vsLang;
			$this->output = $vsLang->getWords ( 'contact_sendContentError', 'The following errors were found! Unknow!' );
		}
	}
	?>
