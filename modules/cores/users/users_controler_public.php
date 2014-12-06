<?php
require_once(CORE_PATH.'users/users.php');


class users_controler_public extends VSControl_public {
	function __construct($modelName){
		global $vsTemplate,$bw,$vsPrint,$vsSkin;
//		if(file_exists(ROOT_PATH.$vsSkin->basicObject->getFolder()."/skin_".$bw->input[0].".php")){
//			parent::__construct($modelName,"skin_".$bw->input[0],"page",$bw->input[0]);;
//		}else{
		parent::__construct($modelName,"skin_users","user");
//		}
		//$this->model->categoryName=$bw->input[0];
		//$vsPrint->addExternalJavaScriptFile("http://maps.google.com/maps/api/js?sensor=true&language=vi",1);
	}
	public	function auto_run(){
	
	global $bw;
			
			switch ($bw->input['action']) {
				
			case $this->modelName.'_registry':
				$this->registry($bw->input[2]);
				break;
			case $this->modelName.'_do_registry':
				$this->doRregistry();
				break;				
			case $this->modelName.'_do_login':
				$this->doLogin();
				break;
//			case $this->modelName.'_login':
//				$this->Login();
//				break;
			case $this->modelName . '_fb_login' :
				$this->fb_login ();
				break;
			case $this->modelName.'_logout':
				$this->doLogOut();
				break;
			case $this->modelName.'_forgot_password':
				$this->forgotPassword();
				break;
			case $this->modelName.'_do_forgot_password':
				$this->doForgotPassword();
				break;
			case $this->modelName.'_chang_password':
				$this->changePassword();
				break;
			case $this->modelName.'_do_chang_password':
				$this->doChangePassword();
				break;				
//			case $this->modelName.'_find':
//				$this->Find();
//				break;		
				
			default:
				//parent::auto_run();
				$this->Find();
				break;
			}
	}
function Find($option=array()){
		global $bw, $vsPrint;
		if($_SESSION['user']['obj']['id']){
			
			if(!$option['message']){
				$option['message']="Xin chào <span>{$_SESSION['user']['obj']['title']}</span> !!!";
				}
			$option['breakcrum']=$this->createBreakCrum($option);
		//$option['message']="xuanvuong";
		
			return $this->output= $this->html->find($option);
		}else{
	
			$option['breakcrum']=$this->createBreakCrum($option);
			return $this->output= $this->html->loginForm($option);
		}
		
	}
function registry($option=array()){
		global $bw, $vsPrint;
		if($_SESSION['user']['obj']['id']){
			if(!$option['message']){
			$option['message']="Xin chào <span>{$_SESSION['user']['obj']['title']}</span> !!!";
			}
			return $this->output= $this->html->find($option);	
		}else{
	
			$option['breakcrum']=$this->createBreakCrum($option);
			return $this->output= $this->html->registry($option);
		}
	}
	
	function Login($option=array()){
		global $bw, $vsPrint;
		if($_SESSION['user']['obj']['id']){
			if(!$option['message']){
			$option['message']="Xin chào <span>{$_SESSION['user']['obj']['title']}</span> !!!";
			}
			return $this->output= $this->html->find($option);	
		}else{
	
			$option['breakcrum']=$this->createBreakCrum($option);
			return $this->output=$this->html->loginForm($option);
		}
	}
	
	

	
function fb_login() {
		global $bw, $vsPrint, $vsUser;
		//echo 123; exit();
		require_once (ROOT_PATH . "plugins/facebook/facebook.php");
		
		$facebook = new Facebook ( array ('appId' => $bw->vars ['appId'], 'secret' => $bw->vars ['secret'] ) );
		
		$user = $facebook->getUser ();

		if ($user) {

			try {
				$user_profile = $facebook->api ( '/me' );
		

					
					$obj = $this->model->createBasicObject ();
					$obj->setTitle ( $user_profile ['name'] );
					$obj->setEmail ( $user_profile ['email'] );
					$obj->setScore ( $user_profile ['id'] );
					//$obj->setPhone ( $bw->input ['phone'] );
					//$_SESSION['user']['obj']=$obj->convertToDB();
					$i = rand ( 0, time () );
					$obj->setInterested ( $i );
					$obj->setName ( $user_profile ['email'] );
					$email=$user_profile ['email'];
					$this->model->setCondition("type = 1 and email='{$email}'");
						
					$result = $this->model->getOneObjectsByCondition ();
						
					if($result){
					
						$this->model->getObjectById($result->getId());
						$this->model->basicObject->setTitle($user_profile ['name']);
	
						$this->model->updateObject();
						$_SESSION['user']['obj']=$this->model->basicObject->convertToDB();
						$vsPrint->boink_it ( $bw->vars ['board_url'] );
					}
					else{
					
						//$time = time () + ($bw->vars ['TimeZone'] ? $bw->vars ['TimeZone'] : 7) * 3600;
						$obj->setStatus ( 1 );
						//$obj->setType (1);
						
						$time = time () + ($bw->vars ['TimeZone'] ? $bw->vars ['TimeZone'] : 7) * 3600;
			
						$this->model->basicObject->setMinutes ( date ( "i", $time ) );
						$this->model->basicObject->setHour ( date ( "h", $time ) );
						$this->model->basicObject->setDay ( date ( "d", $time ) );
						$this->model->basicObject->setMonth ( date ( "m", $time ) );
						$this->model->basicObject->setYear ( date ( "Y", $time ) );
						$this->model->basicObject->setType(1);
						
						
						$this->model->insertObject ( $obj );
				
				
						require_once CORE_PATH.'entrepreneurs/entrepreneurs.php';
						$entrepreneurs =new entrepreneurs() ;
						$cate_entrepreneurs=VSFactory::getMenus()->getCategoryGroup("entrepreneurs");	
						$entrepreneurs->basicObject->setCatId($cate_entrepreneurs->getId());
						$entrepreneurs->basicObject->setTitle($user_profile ['name'] );						
						$entrepreneurs->basicObject->setEmail($user_profile ['email']);
						$entrepreneurs->basicObject->setStatus(0);
						$entrepreneurs->basicObject->setUserId($this->model->obj->getId());	
						$entrepreneurs->basicObject->setModule("entrepreneurs");			
						$entrepreneurs->insertObject();
						$_SESSION['user']['obj']=$this->model->basicObject->convertToDB();

						

					}
					
				
					
					
				/*	
					VSFactory::getUsers ()->basicObject = $obj;
					//VSFactory::getUsers ()->updateSession ();
					
				
				
				$this->model->setCondition ( "email='{$user_profile['email']}'" );
				$obj = $this->model->getOneObjectsByCondition ();
		
				if ($obj) {
					$obj->setScore ( $user_profile ['id'] );
					//$this->model->setCondition ( "email='" .$user_profile ['email'] "'" );
					//$result = $this->model->getOneObjectsByCondition ();
				
					$this->model->updateObjectById ( $obj );
				}
				
				$this->model->setCondition ( "score='{$user_profile['id']}'" );
				$obj = $this->model->getOneObjectsByCondition ();
		
				if ($obj) {
					VSFactory::getUsers ()->basicObject = $obj;
					VSFactory::getUsers ()->updateSession ();
					$vsPrint->boink_it ( $bw->vars ['board_url'] );
				}
					*/
				$vsPrint->boink_it ( $bw->vars ['board_url'] );
				//$this->output = $this->html->loginFB ( $user_profile );
			} catch ( FacebookApiException $e ) {
			
			}
		} else
			$vsPrint->boink_it ( $bw->base_url );
	}
	
	function doRregistry(){
		global $bw,$vsPrint;
		
		if($_SESSION['user']['obj']['id']){
			if(!$option['message']){
			$option['message']="Xin chào <span>{$_SESSION['user']['obj']['title']}</span> !!!";
			}
			return $this->output= $this->html->find($option);	
		}else{
			$option['registry']=$bw->input;
			require_once ROOT_PATH.'vscaptcha/VsCaptcha.php';
			$vscaptcha=new VsCaptcha();
			if($vscaptcha->check($bw->input['sec_code'])){
				if(strlen($bw->input['name'])<4){
					$option['message']= VSFactory::getLangs()->getWords('name_not_available','Tên đăng nhập quá ngắn!!');
					return $this->output= $this->registry($option);
				}
				if(($bw->input['password']!=$bw->input['password_confirm'])||!$bw->input['password']){
					$option['message']= VSFactory::getLangs()->getWords('password_not_available','Mật khẩu nhập lại không khớp!!!');
					return $this->output= $this->registry($option);
				}
				
				
				
				$this->model->setCondition("`name`='".strtolower($bw->input['name'])."'");
				$this->model->getOneObjectsByCondition();
				if($this->model->basicObject->getId()){
					$option['message']= 'Tài khoản đã tồn tại';
					return $this->output= $this->registry($option);
				}
				$this->model->setCondition("`email`='".strtolower($bw->input['email'])."'");
				$this->model->getOneObjectsByCondition();
				if($this->model->basicObject->getId()){
					$option['message']= 'Email đã được sử dụng';
					return $this->output= $this->registry($option);
				}
	//			if(!preg_match('/[a-zA-Z0-9_-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/iu', $bw->input['email'])){
	//				return $this->output= $this->registry(VSFactory::getLangs()->getWords('email_not_available','Email khÃƒÂ´ng hÃ¡Â»Â£p lÃ¡Â»â€¡'));
	//			}
				if($_FILES['image']['size']){
					$files=new files();
					if($id=$files->copyFile($_FILES['image']['tmp_name'], "users",$_FILES['image']['name'])){
						$bw->input['image']=$id;
					}
					
				}			
				$bw->input['name']=strtolower($bw->input['name']);
				$bw->input['phone']=strtolower($bw->input['phone']);
				$bw->input['email']=strtolower($bw->input['email']);
				$bw->input['address']=strtolower($bw->input['address']);
				$this->model->basicObject->convertToObject($bw->input);
				$this->model->basicObject->setPassword(md5($bw->input['password']));
				$this->model->basicObject->setStatus(1);
				$time=time()+($bw->vars['TimeZone']?$bw->vars['TimeZone']:7)*3600;;
				$this->model->basicObject->setMinutes(date("i",$time));
				$this->model->basicObject->setHour(date("h",$time));
				$this->model->basicObject->setDay(date("d",$time));
				$this->model->basicObject->setMonth(date("m",$time));
				$this->model->basicObject->setYear(date("yyyy",$time));
				$this->model->basicObject->setTitle($bw->input['name']);
				$this->model->basicObject->setType(0);			
				$this->model->insertObject();
				$this->model->updateSession();
				require_once CORE_PATH.'entrepreneurs/entrepreneurs.php';
				$entrepreneurs =new entrepreneurs() ;
				$cate_entrepreneurs=VSFactory::getMenus()->getCategoryGroup("entrepreneurs");	
				$entrepreneurs->basicObject->setCatId($cate_entrepreneurs->getId());
				$entrepreneurs->basicObject->setTitle($bw->input['name']);
				$entrepreneurs->basicObject->setPhone($bw->input['phone']);
				$entrepreneurs->basicObject->setEmail($bw->input['email']);
				$entrepreneurs->basicObject->setStatus(0);
				$entrepreneurs->basicObject->setUserId($this->model->obj->getId());	
				$entrepreneurs->basicObject->setModule("entrepreneurs");			
				$entrepreneurs->insertObject();
				$option['message']=VSFactory::getLangs()->getWords('find_registry','Chúc mừng bạn đã đăng ký thành công!!!!');
				return $this->output= $this->html->find($option);			
			}else{
				$option['message']=VSFactory::getLangs()->getWords('captcha_not_match','Mã bảo mật không đúng');
				return $this->output= $this->registry($option);
			}	
		}	
	}
	function forgotPassword($message=""){
		if($_SESSION['user']['obj']['id']){
			if(!$option['message']){
			$option['message']="Xin chào <span>{$_SESSION['user']['obj']['title']}</span> !!!";
			}
			return $this->output= $this->html->find($option);	
		}else{
			return $this->output= $this->html->forgotPassword($option);
		}
	}
	function doForgotPassword($message=""){
		global $bw,$vsStd;
		$option=array();
		if($_SESSION['user']['obj']['id']){
			if(!$option['message']){
			$option['message']="Xin chào <span>{$_SESSION['user']['obj']['title']}</span> !!!";
			}
			return $this->output= $this->html->find($option);	
		}else{
			$this->model->setCondition("name='".strtolower($bw->input['name'])."' and type=0 and email='".(strtolower($bw->input['email']))."'");
			$result=$this->model->getOneObjectsByCondition();
	
	
			require_once ROOT_PATH.'vscaptcha/VsCaptcha.php';
			$vscaptcha=new VsCaptcha();
//			if(!$vscaptcha->check($bw->input['sec_code'])){
//				$option['message']='Mã bảo vệ không đúng';
//				return $this->output=$this->html->forgotPassword($option);
//			}
			if(!count($result)){
				$option['message']='Tài khoản hoặc email không đúng';
				return $this->output=$this->html->forgotPassword($option);
			}
			
			$option['token']=rand(100000,1000000);
			$this->model->getObjectById($result->getId());
			$this->model->basicObject->setPassword(md5($option['token']));
			$this->model->updateObject();
			$vsStd->requireFile ( LIBS_PATH . "Email.class.php", true );
		    $this->email = new Emailer();
			//$this->email->setTo('tu.nguyen@mekongtech.net');
			$this->email->setTo($bw->input['email']);
			$time=VSFactory::getDateTime()->getDate(time(),"d/m/y h:i");
			
			
			
			$this->email->setFrom ("alert@vietsol.net");
			$this->email->setSubject ("Yêu cầu lấy mật khẩu - {$time}" );
			
			$content="<h1 class='titile_contacts'>Chào <span style='color:#000; font-weight: bold;'>{$result->getTitle()}</span></h1>
							<p></p>
							<p>Bạn vừa thực hiện yêu cầu lấy lại mật khẩu, Mật khẩu cảu bạn đã được thay đổi lại thành : <span style='color:#000; font-weight: bold;'>{$option['token']}</span></p>
							";
				
				$this->email->setBody ($content);
				$this->email->sendMail ();
			/*$from="alert@vietsol.net";
			$to=$bw->input['email'];
			$subject="Yêu cầu lấy mật khẩu - {$time})";
			$message=$content;
			$options="Content-type:text/html;charset=utf-8\r\nFrom:$from\r\nReply-to:$from";
			mail($to,$subject,$message,$options);*/
				
			$option['message']='Hệ thống đã gửi mật khẩu mới vào Email của bạn, xin vui lòng kiểm tra Email';
			return $this->output= $this->html->find($option);
		}
	}
	
	function changePassword(){
		global $vsPrint;
		
		if(!$_SESSION['user']['obj']['id']){
			$vsPrint->redirect_screen(VSFactory::getLangs()->getWords('not_login','Bạn chưa đăng nhập'),'users/do_login');
		}
		return $this->output= $this->html->changePassword($option);
	}
	function doChangePassword(){
		global $vsPrint,$bw;
		if(!$_SESSION['user']['obj']['id']){
			$vsPrint->redirect_screen(VSFactory::getLangs()->getWords('not_login','Bạn chưa đăng nhập'),'users/do_login');
		}
		if($_SESSION['user']['obj']['type']==0){
			
		
		$user=$this->model->getObjectById($this->getIdFromUrl($_SESSION['user']['obj']['id']));
//		print  "<pre>";
//		print_r ($user);
//		print  "<pre>";
//		exit();
//print  "<pre>";
//print_r ($bw->input);
//print  "<pre>";

		if(md5($bw->input['oldpassword'])!=$user->getPassword() ){
			$option['message']="Mật khẩu cũ không đúng !!!";
			
			return $this->output= $this->html->changePassword($option);
		}
//		print  "<pre>";
//		print_r ($bw->input['password']);
//		print  "<pre>";
//		echo "-----------<br/>";
//		
//		print  "<pre>";
//		print_r ($bw->input['password']);
//		print  "<pre>";
//		exit();
		if($bw->input['password']!=$bw->input['password_confirm']){
			$option['message']="Mật khẩu mới không khớp";
			return $this->output= $this->html->changePassword($option);
		}
		
		$this->model->basicObject->setPassword(md5($bw->input['password']));
//		print  "<pre>";
//		print_r ($this->model->basicObject);
//		print  "<pre>";
//		exit();
		$this->model->updateObject();
		$option['message']="Cập nhật mật khẩu thành công";
		//echo 123;exit();
		return $this->output=  $this->html->find($option);
		}
		else{
			$vsPrint->redirect_screen(VSFactory::getLangs()->getWords('not_change','Bạn ko được đổi pass'),'users/find');
		}
	}
	
	function doLogin(){
		global $bw,$vsPrint;
		if($_SESSION['user']['obj']['id']){
			if(!$option['message']){
			$option['message']="Xin chào <span>{$_SESSION['user']['obj']['title']}</span> !!!";
			}
			return $this->output= $this->html->find($option);	
		}else{
	
			$user_profile = '';	
			$option['user'] = $user;
			$option['loginUrl'] = $loginUrl;
			$option['logoutUrl'] = $logoutUrl;
			$option['user_profile'] = $user_profile;
			$now=time();		
			$this->model->setCondition("name='".strtolower($bw->input['name'])."' and password='".md5(strtolower($bw->input['password']))."' and status > 0 and type =0");		
			$result=$this->model->getObjectsByCondition();
			$this->model->updateSession($this->model->obj);
			if(!count($result)){
				$option['message']=VSFactory::getLangs()->getWords('user_password_not_exist','Đăng nhập thất bại');
				return $this->output=$this->Login($option);
			}
			$result=current($result);		
			$option['message']="Chào mừng <span> ".$_SESSION['user']['obj']['title']. "</span> đăng nhập thành công!!";
			return $this->output= $this->find($option);
		}
		
	}
	function doLogOut(){
		//echo 123; exit();
		global $bw,$vsPrint;
		unset($_SESSION['user']);
		foreach ($_SESSION as $key=>$ses)
			if(substr($key, 0, 2)=='fb')
				unset($_SESSION[$key]);
				

		return $this->output=$this->Login($option);
		
	}
	
	function getHtml(){
		return $this->html;
	}



	function setHtml($html){
		$this->html=$html;
	}



	
	/**
	*
	*@var users
	**/
	var		$model;

	
	/**
	*
	*@var skin_users
	**/
	var		$html;
}
