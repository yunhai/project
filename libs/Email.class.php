<?php

//http://www.web-development-blog.com/archives/send-e-mail-messages-via-smtp-with-phpmailer-and-gmail/

class Email {
	private $_from = '';
	private $_label = '';
	private $_to = '';
	private $_bcc = '';
	private $_subject = '';
	private $_body = '';

	public function __construct($option = array()) {		
		foreach($option as $f => $value) {
			$this->$f($value);
		}
	}

	public function to($to = null) {
		$this->_to = $to;
	}
	
	public function bcc($bcc = null) {
		$this->_bcc = $bcc;
	}
	
	public function from($from = array()) {
		foreach ($from as $email => $label) {
			$this->_from = $email;
			$this->_label = $label;
		}		
	}
	
	public function subject($subject = null) {
		$this->_subject = $subject;
	}

	public function body($body = null) {
		$this->_body = $body;
	}

	function sendEmail($option = array()) {
		global $vsStd;
		try {
			$vsStd->requireFile ( UTILS_PATH . "mailer/PHPMailerAutoload.php", true );
			$mail = new PHPMailer();
			
			$mail->IsSMTP();
			$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
			$mail->SMTPAuth   = true;                  // enable SMTP authentication
			$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
			$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
			$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
			$mail->Username   = "vietsolsmtp@gmail.com";  // GMAIL username
			$mail->Password   = "smtp@vietsol";            // GMAIL password
			
			if (!empty($this->_bcc)) {
				$mail->addBcc($this->_bcc);
			}
			
			$mail->AddAddress($this->_to);
			
			$mail->SetFrom($this->_from, $this->_label);
			
			$mail->Subject = $this->_subject;

			$mail->MsgHTML($this->_body);
			return $mail->Send();
		} catch (phpmailerException $e) {  
		} catch (Exception $e) {
		}
    }
}