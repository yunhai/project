<?php
require_once CORE_PATH.'contacts/pcontacts.php';
class pcontacts_controler_public extends VSControl_public {
	function __construct($modelName){
		global $vsTemplate,$bw,$vsPrint;
//		$this->html=$vsTemplate->load_template("skin_product");
		parent::__construct($modelName,"skin_pcontacts","pcontact",$bw->input[0]);
		//$this->model->categoryName=$bw->input[0];
		$vsPrint->addExternalJavaScriptFile("http://maps.google.com/maps/api/js?sensor=true&language=vi",1);
	}
	
	/*
	 * Show default action 
	 */
	function showDefault(){
		global $bw,$vsTemplate,$vsStd,$vsPrint;
		$category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
		$ids=VSFactory::getMenus()->getChildrenIdInTree($category);
		if(!$ids){
			return $this->output=VSFactory::getLangs()->getWords('not_count_item');
		}
		$this->model->setCondition("status=1 and catId in ($ids)");
		$this->model->setOrder("`index`");
		$obj=$this->model->getOneObjectsByCondition();
		require_once CORE_PATH.'contacts/contacts.php';
		$contacts=new contacts();
		if(!$obj){
			return $this->output=VSFactory::getLangs()->getWords('not_count_item');
		}
//		$option['hot']=$this->model->getHotpcontact(VSFactory::getSettings()->getSystemKey('hot_pcontact_limit',4));
		if(isset($_POST['btnSubmit'])){
			$vsStd->requireFile ( ROOT_PATH . "vscaptcha/VsCaptcha.php" );
			if($_FILES['file']['size']){
				$files=new files();
				$id=$files->copyFile($_FILES['file']['tmp_name'],"contacts",$_FILES['file']['name']);
				$contacts->basicObject->setImage($id);
			}
			if($bw->input['prefix']) $bw->input['prefix']=$bw->input['prefix'].":";
			//$bw->input['name']=$bw->input['title'];
		   	$contacts->basicObject->setTitle($bw->input['title']);
		   	$contacts->basicObject->setName($bw->input['name']);
		   	$contacts->basicObject->setPhone($bw->input['phone']);
		   	$contacts->basicObject->setAddress($bw->input['address']);
		   	$contacts->basicObject->setCompany($bw->input['company']);
		   	$contacts->basicObject->setEmail($bw->input['email']);
		   	$contacts->basicObject->setContent($bw->input['content']);
		   	$image = new VsCaptcha ();

			
//			echo "<pre>";
//			print_r($contacts);
//			echo "</pre>";
//			exit();
			
			
		   	
		  	if ( $image->check ( $bw->input['sec_code'])) {
		    	$contacts->insertObject();
				
				
				
				$vsStd->requireFile ( LIBS_PATH . "Email.class.php", true );
				$this->email = new Emailer ();
				$this->email->setTo(VSFactory::getSettings ()->getSystemKey ("email_sender_booking", "lysontravel2012@gmail.com", "configs"));
				$this->email->addBCC($contacts->basicObject->getEmail());
				$time=VSFactory::getDateTime()->getDate(time(),"d/m/y h:i");
				$this->email->setFrom ('ly-son-travel@lysontravel.org');
				$this->email->setSubject ("Liên hệ Lý Sơn Travel - {$time})" );
				
				
				$content.="<h1 class='titile_contacts'>Lý Sơn Travel</h1>
							<p>Trụ sở: Th&ocirc;n T&acirc;y, X&atilde; An Vĩnh, Huyện L&yacute; Sơn, Tỉnh Quảng Ng&atilde;i</p>
							<p>ĐT: 0976 878 346 (Mr Ngọc Trai) - 0972 110 313 (Mr Thắm)</p>
							<p>Email: lysontravel2012@gmail.com</p>
							<p><span style='color: #ff9900;'><strong>Th&ocirc;ng tin thanh to&aacute;n: </strong></span>Ng&acirc;n h&agrave;ng Techcombank, L&ecirc; Ngọc Trai, <strong>116 220 263 64 011</strong> (chi nh&aacute;nh Techcombank Nguyễn Kiệm, HCM)</p>";
				$content.="<table style='border-collapse:collapse;' border=1 cellspacing=0 cellpadding='0'>";
				$content.="<tr>";
					$content.="<td style='padding:8px 8px;'>Họ tên:</td><td style='padding:8px 8px;' ><b>{$contacts->basicObject->getName()}</b></td>";
				$content.="</tr>";
				$content.="<tr>";
					$content.="<td style='padding:8px 8px;'>Số điện thoại:</td><td style='padding:8px 8px;' ><b>{$contacts->basicObject->getPhone()}</b></td>";
				$content.="</tr>";
				$content.="<tr>";
					$content.="<td style='padding:8px 8px;'>Email:</td><td style='padding:8px 8px;' ><b>{$contacts->basicObject->getEmail()}</b></td>";
				$content.="</tr>";
				$content.="<tr>";
					$content.="<td style='padding:8px 8px;'>Địa chỉ:</td><td style='padding:8px 8px;' ><b>{$contacts->basicObject->getAddress()}</b></td>";
				$content.="</tr>";
				$content.="<tr>";
					$content.="<td style='padding:8px 8px;'>Nội dung:</td><td style='padding:8px 8px;' ><b>{$contacts->basicObject->getContent()}</b></td>";
				$content.="</tr>";
				
				$content.="</table>";
				
				$content.="<h4><i>Trân trong<br/>Lý Sơn Travel<i></h4>";
				
				$this->email->setBody ($content);
				$this->email->sendMail ();
				
		    	return $this->sendContactSuccess ($contacts->basicObject,$option);
		   	}
			if($_POST['return']){
		    		$vsPrint->boink_it($bw->base_url.$_POST['return']."?error=".VSFactory::getLangs()->getWords('captcha_not_match')."!");
		    		return;
		    }
		   	$option['error']= VSFactory::getLangs()->getWords('captcha_not_match')."!";
		   	
		   	
		}
		$option['obj']=$contacts->basicObject;
		$option['breakcrum']=$this->createBreakCrum(null);
        return $this->output = $this->getHtml()->showDefault($obj,$option);
	}
	function sendContactSuccess($obj,$option){
		$option['breakcrum']=$this->createBreakCrum(null);
		return $this->output = $this->getHtml()->sendContactSuccess($obj,$option);
	}

	protected $model;
	
	
    function getListLangObject(){
         	
    }
       /**
        * 
        * @param BasicObject
        */ 
    protected  function  onDeleteObject($obj){
    }
	public function getHtml() {
		return $this->html;
	}
	
	public function getOutput() {
		return $this->output;
	}
	
	public function setHtml($html) {
		$this->html = $html;
	}
	
	public function setOutput($output) {
		$this->output = $output;
	}
	/**
	 * 
	 * Enter description here ...
	 * @var skin_pcontacts
	 */
	public $html;
}

?>