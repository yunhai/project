<?php
class VSControl {
    protected $output;
    function  auto_run() {
        return;
    }
    function setOutput($out) {
            return $this->output = $out;
        }

        function getOutput() {
            return $this->output;
        }
    function exitDenyAccess($error=''){
        return $this->output=$error?$error:VSFactory::getLangs()->getWords('exitDenyAccess','Access denied!');
    }
    /**
     * @return skins_board
     */
    public function getHtml() {
        return $this->html;
    }

    /**
     * @param $html string file name
     */
    public function setHtml($html) {
        $this->html = $html;
    }
    function getIdFromUrl($url,$sep="-"){
        $url=str_replace(".html", "", $url);
        $url=explode($sep, $url);
        return intval($url[count($url)-1]);
    }
    function lastModifyChange(){
        if(!LAST_MODIFY_FILE) return false;
        $fp = fopen(LAST_MODIFY_FILE, 'w');
        fwrite($fp, 'modified');
        fclose($fp);
    }

    function sendEmail($option) {
        global $vsStd, $bw;

        extract($option);

        $vsStd->requireFile ( UTILS_PATH . "mailer/PHPMailerAutoload.php", true );
        $mail = new PHPMailer();

        // set mailer to use SMTP
        $mail->IsSMTP();

        // As this email.php script lives on the same server as our email server
        // we are setting the HOST to localhost
        $mail->Host = "localhost";  // specify main and backup server

        $mail->SMTPAuth = true;     // turn on SMTP authentication

        // When sending email using PHPMailer, you need to send from a valid email address
        // In this case, we setup a test email account with the following credentials:
        // email: contact@domain.com
            // pass: password

        $mail->Username = $bw->vars['email_smtp_user'];  // SMTP username
        $mail->Password = $bw->vars['email_smtp_password']; // SMTP password

        // $email is the user's email address the specified
        // on our contact us page. We set this variable at
        // the top of this page with:
        // $email = $_REQUEST['email'] ;
        $mail->From     = $bw->vars['email_smtp_user'];
        $mail->FromName = $fromName;

        // below we want to set the email address we will be sending our email to.
        $mail->AddAddress($recipient, $recipientAlias);

        // set word wrap to 50 characters
        $mail->WordWrap = 5000;
        // set email format to HTML
        $mail->IsHTML(true);

        $mail->Subject = $subject;

        // $message is the user's message they typed in
        // on our contact us page. We set this variable at
        // the top of this page with:
        // $message = $_REQUEST['message'] ;
        $mail->Body    = $message;
        $mail->AltBody = $message;

        return $mail->Send();
    }



}
?>