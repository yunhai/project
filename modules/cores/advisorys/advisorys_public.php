<?php

class advisorys_public  extends ObjectPublic{
function __construct(){
            global $vsTemplate;
            parent::__construct('advisorys', CORE_PATH.'advisorys/', 'advisorys');
			$this->html = $vsTemplate->load_template('skin_advisorys');    
	}
    function auto_run() {
		global $bw, $vsPrint;

//		$vsPrint->addCurentJavaScriptFile('imenu');
$this->model->getNavigator();
		switch ($bw->input['action']) {
			case 'detail':
				$this->showDetail($bw->input[2]);
				break;

			case 'category':
				$this->showCategory($bw->input[2]);
				break;
                        case 'send':
				$this->sendadvisory();
				break;
                        case 'form':
                                $this->output = $this->html->showFormDefault ( );
                                break;
			case 'thanks':
				$this->thankadvisory();
				break;
			default:
				$this->showDefault();
				break;
		}
	}
	
	function sendadvisory(){
		global $bw,$vsLang,$vsSettings,$vsStd;

		$bw->input['advisoryPostDate'] = time();
$vsStd->requireFile(ROOT_PATH."captcha/securimage.php");
			$image = new Securimage();
			if(!$image->check($bw->input['advisorySecurity'])) {
				$message = $vsLang->getWords('thank_message','Security code doesnot match');
                                $java = <<<EOF
                                    <script>
                                        $(document).ready(function(){
                                        jAlert('{$vsLang->getWords('thank_message','Security code doesnot match')}','{$bw->vars['global_websitename']} Dialog');
});
                                    </script>    

EOF;
				//$vsPrint->redirect_screen($message, "contacts");
                                return $this->output = $this->html->showFormDefault () .$java;
			}

		$bw->input['advisoryCatId'] = $bw->input['advisoryCatId'] ? $bw->input['advisoryCatId'] : $this->model->categories->getId();
		
		$bw->input['advisoryPostDate'] = time();
		$this->model->obj->convertToObject($bw->input);
		$this->model->insertObject($this->model->obj);


		if($this->error) $this->sendadvisoryError();
		else $this->thankadvisory($bw->input['module']);
	}

	function errorCallback($advisoryType=0, $error){
		global $bw, $vsStd;
		$vsStd->requireFile(UTILS_PATH.'PostParser.class.php');

		$parser = new PostParser();
		$parser->pp_nl2br = 1;

		if($advisoryType){
			$this->consulting();
			$bw->input['advisoryCompany'] = $parser->post_db_parse_html($bw->input['advisoryCompany']);
			$bw->input['advisoryAddress'] = $parser->post_db_parse_html($bw->input['advisoryAddress']);

			$this->output .= <<<EOF
				<script type='text/javascript'>
					reloadadvisoryInformation(jsonObj);
				</script>
EOF;
		}
		else{
			$bw->input['advisoryMessage'] = $parser->post_db_parse_html($bw->input['advisoryMessage']);
			$this->output = <<<EOF
				<div id='errorDisplay'>
					<b>The following errors were found</b>:<br />{$error}
				</div>
				<script type='text/javascript'>
					setTimeout('removeDiv()', 3000);
					function removeDiv(){
	    				$('#errorDisplay').fadeOut('slow');
					}
				  	$('#recaptcha_response_field').focus();
				  	$('#recaptcha_response_field').addClass('vs-error');
					$('#advisoryName').attr("value","{$bw->input['advisoryName']}");
					$('#advisoryAddress').attr("value","{$bw->input['advisoryAddress']}");
					$('#advisoryPhone').attr("value","{$bw->input['advisoryPhone']}");
					$('#advisoryEmail').attr("value","{$bw->input['advisoryEmail']}");
					$('#advisoryTitle').attr("value","{$bw->input['advisoryTitle']}");
					$('#advisoryMessage').attr("value","{$bw->input['advisoryMessage']}");
					refreshIdentifyCode();
				</script>
EOF;
		}
	}

	function sentadvisoryByEmail($addon_profile){
		global $vsStd, $vsLang, $bw,$vsSettings;
		$vsStd->requireFile(LIBS_PATH."Email.class.php",true);
		$this->email = new Emailer();


		$message = "<strong>Name:</strong> {$this->model->obj->getName()}<br />
					<strong>Email:</strong> {$this->model->obj->getEmail()}<br />";
		$message.= "<strong>Address:</strong>".$addon_profile[0]."<br /><strong>Phone:</strong>".$addon_profile[1]."<br />";
		$message.= "<strong>Message subject:</strong> {$this->model->obj->getTitle()}<br />
				    <strong>Message:</strong>".$this->model->obj->getContent();
		$this->email->setTo($vsSettings->getSystemKey("advisory_emailRecerver","admin@vietsol.net"));

		$this->email->setFrom($this->model->obj->getEmail());
		$this->email->setSubject($vsLang->getWords('advisorySubject', 'advisory'));
		$this->email->setMessage($message);

		$this->email->send_mail();
	}

	function thankadvisory($url){
		global $vsPrint, $vsLang, $bw;
		
		$text = $vsLang->getWords('advisory_redirectText','Câu hỏi của bạn đã được gửi');
		
		$categories = $this->model->getCategories();
		$option['catList'] = $categories->getChildren();
		$this->output = $this->html->thankyou($text, $url, $option);
	}

	function sendadvisoryError(){
		global $vsLang;
		$this->output = $vsLang->getWords('advisory_sendContentError','The following errors were found! Unknow!');
	}

   
}
?>