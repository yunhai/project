<?php
/*
+-----------------------------------------------------------------------------
|   VS FRAMEWORK 3.0.0
|	Author: BabyWolf
|	Homepage: http://vietsol.net
|	If you use this code, please don't delete these comment line!
|	Start Date: 21/09/2004
|	Finish Date: 22/09/2004
|	Version 2.0.0 Start Date: 07/02/2007
|	Version 3.0.0 Start Date: 03/29/2009
+-----------------------------------------------------------------------------
*/

if ( ! defined( 'IN_VSF' ) )
{
	print "<h1>Permission denied!</h1>You cannot access this area. (VS Framework is powered by <a href=\"http://www.vietsol.net\">Viet Solution webdesign company</a>)";
	exit();
}
global $vsStd,$vsUser;
$vsStd->requireFile(CORE_PATH."users/users.php");
$vsStd->requireFile(CORE_PATH."cards/cards.php");
$vsStd->requireFile(CORE_PATH."rebates/rebates.php");
$vsStd->requireFile(CORE_PATH."cards/terms.php");
$vsStd->requireFile(CORE_PATH."wincards/wincards.php");
$vsStd->requireFile(ROOT_PATH."captcha/securimage.php");

class users_public 
{
    public 		$output 	= "";
	private 	$html       = "";	
	protected  	$module 		= "";

	function getOutput(){
		return $this->output;
	}
	
	function setOutput($outputHTML){
		$this->output = $outputHTML;
	}
	
    function __construct(){
		global $bw, $vsTemplate;
    	$this->module = new users();
    	$this->card  = new cards();
    	$this->term  = new terms();
    	$this->rebate  = new rebates();
    	$this->win	 = new wincards();
        $this->html = $vsTemplate->load_template('skin_users');
    }
	
    function auto_run(){
		global $bw,$vsUser,$vsLang,$member;	
		
		switch($bw->input[1]){	
			//form đăng  ký
			case "resgister":
				$this->registerUserForm($this->module->obj);
				break;
			case 'signup':
					$this->signupProcess();
				break;
			// thoát ko lưu session	
			case 'logout':
					$this->logoutProcess();
				break;
			//form login	
			case 'login-form':
				$this->loginForm();
				break;
						
			case 'login':
					$this->loginProcess();
				break;
			// quên mật khẩu	
			case 'forgot-password':				
					$this->forgotPasswordForm();
				break;	
			//send Email and res	
			case 'send-password':				
					$this->sendPassword();
				break;	
			//tao  mot pass moi bang email	
			case 'renew-password':
					$this->renewPassword();
				break;
					
			case 'renew-password-process':
					$this->renewPasswordProcess();
				break;	
			//form thay đổi thông tin
			case 'user-info':
					$member = 1;
					$this->userInfoForm();
				break;
				
			case 'changinfo':
					$this->changInfoProcess();
				break;	
			// show thong tin cá nhân	
			case 'user-personal':
					$member = 1;
					$this->userPersionNal();
				break;	
			//show thông tin trúng thưởng user	
			case 'user-win':
					$member = 1;
					$this->userWin();
				break;
					
			case 'check-win':
				$member = 1;
					$this->checkWin();
				break;		
			// show số dư tài khoản	
			case 'account-balance':
					$member = 1;
				$this->accountBalance();
				break;
			//check multi rebate cards		
			case 'rebate':
					$member = 1;
				$this->rebate();
				break;	
			case 'check-rebate':
					$member = 1;
				$this->checkRebate($bw->input['rebateCheck']);
				break;		
			//change pass process	
			case 'change-pass-form':
					$member = 1;
				$this->changePasswordForm();
				break;
					
			case 'changepass':
					$member = 1;
					$this->changePasswordProcess();
				break;
						
			case 'active-account':
				$this->activeAccount();
				break;
					
			case 'info-trade':
				$member = 1;
				$this->infoTrade();
				break;
				
			default:
				$this->loadDefault();
				break;
		}
	}
	
	function checkRebate($reba = ""){
		global $vsUser,$vsLang,$bw;
		if(!$vsUser->obj->getDealer())return $this->loginForm($vsLang->getWords('login_error_dealer',"Bạn phải đăng nhập vào hệ thống với quyền hạn Dealer"));
		$option['mess']=$vsLang->getWords('check_rebate','Nhập vào mã Rebate cần kiểm tra!');
		if(!$reba)return $this->rebate($option);
		$st = str_replace(",","','",$reba);
		$arr = explode(",",$reba);
		$this->rebate->setCondition("rebateCode in ('".$st."')");
		$items = $this->rebate->getObjectsByCondition();
		if(!$_SESSION [$_SESSION [$vsUser->obj->getName()][APPLICATION_TYPE]] ['rebatefail'])$_SESSION [$_SESSION [$vsUser->obj->getName()][APPLICATION_TYPE]] ['rebatefail']=0;
			$_SESSION [$_SESSION [$vsUser->obj->getName()][APPLICATION_TYPE]] ['rebatefail']  = $_SESSION [$_SESSION [$vsUser->obj->getName()][APPLICATION_TYPE]] ['rebatefail'] + 1;
		if(count($items)<count($arr)){
			if($_SESSION [$_SESSION [$vsUser->obj->getName()][APPLICATION_TYPE]] ['rebatefail'] > 2){
					$message = sprintf("Bạn đã nhập sai mã Rebate lần thứ [%s].  Tài khoản [%s] sẽ bi khóa",
																		$_SESSION [$_SESSION [$vsUser->obj->getName()][APPLICATION_TYPE]] ['rebatefail'] ,
																		$vsUser->obj->getName() );
					$_SESSION [$_SESSION [$vsUser->obj->getName()][APPLICATION_TYPE]] ['rebatefail'] =0;													
				$vsUser->obj->setStatus(0);
				$vsUser->updateObjectById($vsUser->obj);	
				$info['re']="Thông báo khóa tài khoản";
				$info['message']=$message;	
				$this->sendPassword($info);													
				return $this->logoutProcess($message);
			}	
			$option['item'] = $items;
			$option['reba'] = $reba;
			$option['mess'] = sprintf("Nhập sai mã Rebate .Bạn đã nhập sai lần thứ [%s].Sau 3 lần nhập sai account [%s] sẽ bi khóa",
							$_SESSION [$_SESSION [$vsUser->obj->getName()][APPLICATION_TYPE]] ['rebatefail'],$vsUser->obj->getName());
						return $this->rebate($option);
		}
		$money =0;
		foreach($items as $obj){
			
			if($obj->getStatus()&&$obj->getResult())
			$money += intval($obj->getScore());
		}
		$_SESSION [$_SESSION [$vsUser->obj->getName()][APPLICATION_TYPE]] ['rebatefail'] =0;
		if(!$money ){
			$option['mess']=sprintf("Tổng giá trị thẻ Rebate không có .Vui lòng nhập lại thẻ Rebate khác");
			return $this->rebate($option);
		}else{
			$option['mess']=sprintf("Tổng số điểm [%s] sẽ được cộng dồn vào tài khoản của bạn",$money);
			$this->rebate->setCondition("rebateCode in ('".$st."')");
			$this->rebate->updateObjectByCondition(array('rebateStatus'=>0));
			$scor = intval($vsUser->obj->getScore())+ intval($money);
					$vsUser->obj->setScore($scor);
					$user = $vsUser->obj;
					$this->module->updateObjectById($vsUser->obj);
					$this->module->sessions->updateLoginSession($user);
					$_SESSION[APPLICATION_TYPE]['obj']=$user->convertToDB();
			$info['re']="Chúc mừng bạn trúng thưởng thẻ Rebate";
			$info['message']=	$option['mess'];
			$this->send_email($info);	
		}				
				
		return $this->rebate($option);
		
	}
	
	function activeAccount(){
		global $vsLang,$vsPrint,$bw;
		$this->module->setCondition("userName='{$bw->input[2]}' AND userPassword='{$bw->input[3]}' ");
		$account=$this->module->getOneObjectsByCondition();
	
		if(!is_object($account)){
			$message=$vsLang->getWords('wrong_account','Tài khoản này không tồn tại trong hệ thống!');		
			 return 	$vsPrint->redirect_screen($message);
		}
		
		if($account->getScore()||$account->getStatus()){
			$message=$vsLang->getWords('wrong_account_active','Tài khoản này đã được kích hoạt!');
			 return 	$vsPrint->redirect_screen($message);
		}
		
		$abc = time();
		$this->term->setCondition("termStatus > 0 AND termEndDate >= {$abc} AND termStartDate <= {$abc} ");
		$term = $this->term->getOneObjectsByCondition();
		
		if($term)
			$account->setScore($term->getScore());
		else $account->setScore(1);
		$account->setStatus(1);
		$this->module->updateObjectById($account);
		return $vsPrint->redirect_screen($vsLang->getWords('global_activesucess','Hoàn tất kích hoạt tài khoản! Hệ thống tự động chuyển bạn về trang đăng nhập.'),'users/login-form');
	}
	
	
	function checkWin($code = ""){
		global $bw,$vsUser,$vsLang;
		if(!$vsUser->obj->getId())return $this->loginForm($vsLang->getWords('login_error',"Ban phai dang nhap vao he thong"));
		if($bw->input['value_check'])$code = $bw->input['value_check'];
		if($code=="") return $this->userWin($vsLang->getWords('error_null_code',"Không tồn tại mã code"));
		$this->card->setCondition("cardCode = '{$code}'");
		$obj = $this->card->getOneObjectsByCondition();
		if(!$_SESSION [$_SESSION [$vsUser->obj->getName()][APPLICATION_TYPE]] ['fail'])$_SESSION [$_SESSION [$vsUser->obj->getName()][APPLICATION_TYPE]] ['fail']=0;

		$_SESSION [$_SESSION [$vsUser->obj->getName()][APPLICATION_TYPE]] ['fail']  = $_SESSION [$_SESSION [$vsUser->obj->getName()][APPLICATION_TYPE]] ['fail'] + 1;
		
		if(!$obj){
			$message = sprintf("Mã code [%s] không tồn tại trong hệ thống .Bạn đã nhập sai lần thứ [%s].Sau 3 lần nhập sai account [%s] sẽ bi khóa",
																	$bw->input['value_check'],
																	$_SESSION [$_SESSION [$vsUser->obj->getName()][APPLICATION_TYPE]] ['fail'] ,
															$vsUser->obj->getName());
			if($_SESSION [$_SESSION [$vsUser->obj->getName()][APPLICATION_TYPE]] ['fail'] > 2){
					$message = sprintf("Mã code [%s] không tồn tại trong hệ thống .Bạn đã nhập sai lần thứ [%s].  Tài khoản [%s] sẽ bi khóa",
																		$bw->input['value_check'],
																		$_SESSION [$_SESSION [$vsUser->obj->getName()][APPLICATION_TYPE]] ['fail'] ,
																		$vsUser->obj->getName() );
					$_SESSION [$_SESSION [$vsUser->obj->getName()][APPLICATION_TYPE]] ['fail'] =0;													
				$vsUser->obj->setStatus(0);
				$vsUser->updateObjectById($vsUser->obj);															
				return $this->logoutProcess($message);
			}															
		}else {
			$_SESSION [$_SESSION [$vsUser->obj->getName()][APPLICATION_TYPE]] ['fail'] = 0;
			if(!$obj->getStatus()){
				$message = $vsLang->getWords('has_boss',"Quà này đã có người nhận.Vui lòng nhập lại code để nhận quà khác.Thanks");
				return $this->userWin($message);
			}
			$message = sprintf("Chúc mừng bạn đã trúng thưởng [ %s ].Liên hệ với chúng tôi sớm nhất để được nhận quà",
															$obj->getTitle());
			$this->term->setCondition("termId = {$obj->getTerm()}");												
			$term = $this->term->getOneObjectsByCondition();
		
			if($term)	{
					$arr = array('wincardTitle'=>$term->getTitle(),'wincardCode'=>$code,
								 'wincardScore'=>$obj->getScore(),'wincardPresent'=>$obj->getPresent(),
								 'wincardUser' => $vsUser->obj->getId(),'wincardPostDate' => time()	
					);			
					$this->win->obj->convertToObject($arr);
					$this->win->insertObject($this->win->obj);			
				}
				else{
					return $this->userWin("Mã thẻ của bạn không thuộc chương trình khuyến mãi hiện hành nào.Không hợp lệ.Vui lòng liên hệ nhà quản trị");
				}	
			if($this->card->obj->getScore()&&$this->card->obj->getResult()){
				$scor = intval($vsUser->obj->getScore())+ intval($this->card->obj->getScore());
				$vsUser->obj->setScore($scor);
				$user = $vsUser->obj;
				$this->module->updateObjectById($vsUser->obj);
				$this->module->sessions->updateLoginSession($user);
				$_SESSION[APPLICATION_TYPE]['obj']=$user->convertToDB();
			}					
			$obj->setStatus(0);												
			$this->card->updateObjectById($obj);
			
			
			$option['message'] = $this->html->reportUserWinner(array('user'=>$vsUser->obj,'card'=>$this->card->obj,'term'=>$this->win->obj,'card'=>$obj));
		
			$option['re'] = $vsLang->getWords('user_win_wellcom','Chúc mừng bạn đã trúng thưởng');
			$this->send_email($option);
			$this->card->obj->__destruct();
			$this->win->obj->__destruct();
		}
			
		return $this->userWin($message);
			
	}
	
	function send_email($info = array()){
		global $vsUser,$vsStd,$vsLang;
			$vsStd->requireFile(LIBS_PATH."Email.class.php",true);
			$this->email = new Emailer();
			$this->email->setTo($vsUser->obj->getEmail());
			$this->email->setSubject("Re: ".$info['re']);
			$this->email->setBody($info['message']);
			
			$this->email->sendMail();
	}
	
	
	function changInfoProcess(){
		global $bw, $vsStd, $vsLang,$vsUser,$DB,$vsPrint;
		$message = $vsLang->getWords('error_update',"Có lỗi xảy ra trong quá trình cập nhật thông tin");
		
		if($bw->input['userId']){
			$vsUser->obj->convertToObject($bw->input);
			$this->module->updateObjectById($vsUser->obj);
			$user = $vsUser->obj;
			$message =$vsLang->getWords('update_info_succes','Cập nhật thông tin thành công');	
			$vsUser->sessions->updateLoginSession($user);
		}
		$_SESSION[APPLICATION_TYPE]['obj']=$user->convertToDB();
		$vsPrint->redirect_screen($vsLang->getWords('global_renew_success1','Hoàn tất thay đổi thông tin! Hệ thống tự động chuyển bạn về trang thông tin thành viên.'),'users/user-personal');
		;
	}
	
	function sendPassword(){
		global $bw, $vsStd, $vsLang,$vsSettings;

		$this->module->setCondition("userEmail='{$bw->input['userEmail']}'");
		$account=$this->module->getOneObjectsByCondition();
	
		if(!is_object($account)){
			$message=$vsLang->getWords('wrong_email','Email này không tồn tại trong hệ thống!');	
			
			 return $this->forgotPasswordForm($message);
		}
		
		if($vsSettings->getSystemKey("use_send_mail_renew_password",1)){
			$vsStd->requireFile(LIBS_PATH."Email.class.php",true);
			$this->email = new Emailer();
			$this->email->setTo($account->getEmail());
			$this->email->setSubject("Re: ".$vsLang->getWords('user_sendEmail_forgot','Re New PassWord!'));
			$this->email->setBody($this->html->emailHtmlFogot($account));
			$this->email->sendMail();
		}
		$message=$vsLang->getWords('send_email_note','Bạn vui lòng kiểm tra email để thực hiện quá trình phục hồi mật mã!');	
		$this->forgotPasswordForm($message);
	}
	
	function forgotPasswordForm($mess=""){
		global $bw, $vsStd, $vsLang,$vsUser,$DB;
		$this->output = $this->html->forgotPasswordForm($mess);
		}
	
	
	function changePasswordProcess(){
		global $bw, $vsStd, $vsLang,$vsUser,$DB;
		
		$userId = $bw->input['userId'];
		if($vsUser->obj->getPassword()!= md5($bw->input['userOldPassword'])){
			$message=$vsLang->getWords('error_user_password_old','Mật khẩu củ không đúng!');		
			return $this->changePasswordForm(null,$message);
			  
		}
		
		$message = $vsLang->getWords("user_ChangePasswordSuccessfully", "Bạn đã đổi thành công mật khẩu của mình!"); 								
		
		$vsUser->obj->setPassword($bw->input['userPassword']);
		$vsUser->updateObjectById($vsUser->obj);

		$vsUser->sessions->updateLoginSession($vsUser->obj);
		
//		if($bw->input['EmailAnouncement']=='on'){
//			$user->getUserById($bw->input[2]);
//			$vsStd->requireFile(LIBS_PATH."Email.class.php",true);
//	
//			$tempMessage = 'Your password has to be change to: <b>'.$bw->input['rawdata'].'<b>!';
//			$message = $vsLang->getWords('user_sendemail_Message',$tempMessage);
//
//			$this->email = new Emailer();
//			$this->email->setTo($user->user->getEmail());
//			$this->email->setSubject("Re: ".$vsLang->getWords('user_sendEmail_Re','Password change!'));
//			$this->email->setBody($message);
//			$this->email->sendMail();
//		}
		$this->changePasswordForm(null,$message);
		return  ;
	}
	
	function changePasswordForm($status=null,$message=NULL){
		global $vsUser,$vsSettings;
		
		$this->output=$this->html->changePasswordForm($option,$message);
	}
	function rebate($option=array()){
		$this->output=$this->html->rebate($option);
	}
	function accountBalance(){
		global $vsUser;
		
		$this->module->vsRelation->setRelId($vsUser->obj->getId());
		$this->module->vsRelation->setTableName("user_gift");
		$this->module->vsRelation->getObjectByRel(true);
		
		$this->output = $this->html->accountBalance($this->module->vsRelation->arrval);
	}
	function userWin($message=""){
		global $bw,$vsUser;
		$time = time();
		$this->term->setCondition("termStatus =1 AND termStartDate <= {$time} AND termEndDate >= {$time}");
		$items = $this->term->getObjectsByCondition();
		$this->win->setCondition("wincardUser = {$vsUser->obj->getId()}");
		$option = $this->win->getPageList("users/user-win/",2,15);
		
		$option ['term']=$items;
		$option ['mess']=$message;
		$this->output=$this->html->userWin($option);
	}
	function userPersionNal(){
		$this->output=$this->html->userPersionNal();
	}
	
	function userInfoForm($status=null){
		global $vsUser,$vsSettings;
		$option['provice'] = $this->module->vsMenu->getCategoryGroup("provice");

		$this->output=$this->html->userInfoForm($this->module->obj,$option);
	}
	
	function renewPassword(){
		global $bw, $vsStd, $vsLang,$vsUser,$DB;
		$this->module->setCondition("userName='{$bw->input[2]}' AND userPassword='{$bw->input[3]}'");
		$account=$this->module->getOneObjectsByCondition();
	
		if(!is_object($account)){
			$message=$vsLang->getWords('wrong_account','Tài khoản này không tồn tại trong hệ thống!');		
			 return 	$this->forgotPasswordForm($message);
		}
		return $this->output	=	$this->html->renewPasswordForm($account,$message);
	}
	function renewPasswordProcess(){
		global $bw, $vsStd, $vsLang,$vsUser,$vsSettings,$vsPrint;
		$this->module->setCondition("userPassword='{$bw->input['passCode']}'");
		$account=$this->module->getOneObjectsByCondition();
		if(!is_object($account)){
			$message=$vsLang->getWords('wrong_account','Tài khoản này không tồn tại trong hệ thống!');		
			 return $this->output	=	$this->forgotPasswordForm($message);
		}
		if($bw->input['confirmPassword']!= $bw->input['userPassword']){
			$message=$vsLang->getWords('error_user_password_old','Mật khẩu Xác nhận không đúng!');		
			return $this->output	=	$this->forgotPasswordForm($message);
		}
		
		$account->setPassword($bw->input['userPassword']);
		$vsUser->updateObjectById($account);
		if($vsSettings->getSystemKey("use_send_mail_renew_password",1)){
			$vsStd->requireFile(LIBS_PATH."Email.class.php",true);
			$this->email = new Emailer();
			$this->email->setTo($account->getEmail());
			$this->email->setSubject($vsLang->getWords('user_info_sendEmail_forgot','Thông thi tài khoản mới!'));
			$this->email->setBody($this->html->emailHtmlFogotSuccess($account));
			$this->email->sendMail();
		}
		$vsPrint->redirect_screen($vsLang->getWords('global_renew_success','Hoàn tất thay đổi mật khẩu! Hệ thống tự động chuyển bạn về trang đăng nhập.'),'users/login-form');
	}
	
	function signupProcess(){
		global $bw, $vsStd,$vsLang,$vsUser,$vsPrint,$vsSettings;
	
		$this->module->obj->convertToObject($bw->input);
		$objfail = $this->module->obj;
		$defaultGroup = empty($bw->vars['user_defaultGroup'])?1:$bw->vars['user_defaultGroup'];
//		$image = new Securimage();
//	    if ($image->check($bw->input['userSecurity']) == true) {
	    
			$this->module->setCondition("userName ='{$bw->input['userName']}' OR userEmail ='{$bw->input['userEmail']}'");
			
			$users = $this->module->getObjectsByCondition();
			
			if(count($users)){
				foreach($users as $obj){
					if($obj->getName()==$bw->input['userName']){
						$optionfff['mess'].=$vsLang->getWords('e_duplicate','Tài khoản này đả tồn tại trong hệ thống!')."</br>";
						$optionfff['name']=$obj->getName();
					}
					if($obj->getEmail()==$bw->input['userEmail']){
						$optionfff['mess'].=$vsLang->getWords('e_duplicate_email','Email này đã tồn tại trong hệ thống.Hãy nhập email khác!')."</br>";
						$optionfff['email']=$obj->getEmail();
					}
				}	
		
				return $this->output	=	$this->registerUserForm($objfail,$optionfff);	
			}
	
			$bw->input['userJoinedDate']= time();
			$bw->input['userLastLogin'] = time();
			$bw->input['userStatus']  = empty($bw->vars['user_defaultActive'])?0:$bw->vars['user_defaultActive'];
			
			$groups=$this->module->groupusers->getGroupById($defaultGroup);
			$this->module->obj->addGroup($groups);
			
			if($this->module->obj->getId()) {
				$this->module->updateObjectById($this->module->obj);
			}
			else {
				$this->module->obj->setJoinDate(time());
				$this->module->obj->setLastLogin(time());
				$this->module->obj->setPassword($bw->input['userPassword']);
				$this->module->insertObject($this->module->obj);
			}
			if($this->module->result['status'])
			{
				$this->module->vsRelation->setObjectId($this->module->obj->getId());
				$this->module->vsRelation->setRelId($defaultGroup);
				$this->module->vsRelation->setTableName($this->module->getRelTableName());
				$this->module->vsRelation->insertRel();
			}
			$this->module->sessions->updateLoginSession($this->module->obj);
			$vsUser->obj=$this->module->obj;
			if($vsSettings->getSystemKey("use_send_mail_renew_password",1)){
				$vsStd->requireFile(LIBS_PATH."Email.class.php",true);
				$this->email = new Emailer();
				$this->email->setTo($this->module->obj->getEmail());
				$this->email->setSubject($vsLang->getWords('user_info_sendEmail_forgot','Vui lòng check mail để kích hoạt tài khoản!'));
				$this->email->setBody($this->html->emailRegisterSuccess($this->module->obj));
				$this->email->sendMail();
				$mes = $vsLang->getWords('user_info_sendEmail_forgot','Vui lòng check mail để kích hoạt tài khoản!');
			}
			$vsPrint->redirect_screen($vsLang->getWords('global_register_success','Bạn đã đăng ký thành công! Hệ thống tự động chuyễn bạn về trang Chủ.')."</br>".$mes);
//	     } else {
//		      $this->module->obj->convertToObject($bw->input);
//		      $message=$vsLang->getWords('error_security','Nhập sai mã xác nhận!');
//			return $this->output	=	$this->loginForm($message,$objfail);
//	    }
	}
	function loginForm($message = ""){	
		global $bw,$vsLang;
		if($bw->input[2]=="nosession")
			$message=$vsLang->getWords('require_login', 'Hệ thống yêu cầu Bạn phải đăng nhập trước khi truy cập chức năng này');
		elseif($bw->input[2]=="timeout")
			$message=$vsLang->getWords('require_login_timeout', 'Tài khoản của bạn đã hết thời gian sử dụng, vui lòng đăng nhập lại');
		
		return $this->output	=	$this->html->pageLogin($message,$this->module->obj);
	}	
	function loginProcess() {		
		global $bw, $vsPrint,$vsLang;
		$this->module->setCondition("userName ='{$bw->input['userName']}'");
		$this->module->getOneObjectsByCondition();
		if(!$this->module->result['status']){
			$message=$vsLang->getWords('none_useraccount','Không tồn tại tài khoản này trong hệ thống!');
			
			return $this->output	=	$this->loginForm($message);	
		}
		if(!$this->module->obj->getStatus()){
			$message=$vsLang->getWords('none_user_notactive','Tài khoản bị khóa hay chưa được kích hoạt.Liên hệ nhà quản trị');
			$this->module->obj->__destruct();
			return $this->output	=	$this->loginForm($message);	
		}
		if($this->module->obj->getPassword()!= md5($bw->input['userPassword'])){
			$message=$vsLang->getWords('error_user_password','Mật khẩu không đúng!');
			$this->module->obj->__destruct();
			return $this->output	=	$this->loginForm($message);
		}
		$this->module->vsRelation = new VSFRelationship();
		$this->module->vsRelation->setObjectId($this->module->obj->getId());
		$this->module->vsRelation->setTableName($this->module->getRelTableName());
		$groupStr=$this->module->vsRelation->getRelByObject();
	
		if(!$groupStr)
		{
			$message=$vsLang->getWords('invalid_account','Tài khoản của bạn không hợp lệ vì chưa thuộc nhóm phân quyền nào');
			return $this->output	=	$this->loginForm($message);
		}
		$array=$this->module->vsRelation->arrval;
		
		foreach ($array as $id => $group) {
			$this->module->obj->addGroup($this->module->groupusers->getGroupById($id));
		}
		
		$this->module->sessions->updateLoginSession($this->module->obj);
		$_SESSION[APPLICATION_TYPE]['obj']=$this->module->obj->convertToDB();
//		$_SESSION[APPLICATION_TYPE]['obj']=$this->module->obj;
		$vsPrint->redirect_screen($vsLang->getWords('global_login_success','Đăng nhập thành công! Hệ thống tự động chuyển trang.'),'users/user-personal');
	}
	function logoutProcess($message =""){	
		global $bw, $vsLang,$vsPrint;
		unset($_SESSION[APPLICATION_TYPE]['obj']);
		unset($_SESSION[APPLICATION_TYPE]['groups']);
		$_SESSION[APPLICATION_TYPE]['session']['userId']=0;
		$returnmes = $vsLang->getWords('global_logout_success','Bạn đã thoát khỏi hệ thống!.');
			if($message)$returnmes = $message;
		$vsPrint->redirect_screen($returnmes);
	}
	
	function registerUserForm($obj = Null,$mess=""){
		global $vsMenu,$DB;
		$option = $mess;
		$option['provice'] = $this->module->vsMenu->getCategoryGroup("provice");
	
		return $this->output = $this->html->registerUserForm($obj,$option);
	}
	function loadDefault(){
	
		return $this->output = $this->registerUserForm($this->module->obj);
	}
	
	function infoTrade(){
		global $bw,$vsRelation,$vsUser,$vsStd;
		
				
		$vsStd->requireFile(CORE_PATH."orders/orders.php");
		$order = new orders();
		
		$order->setCondition("userId in ({$vsUser->obj->getId()})");
		$order->setFieldsString("orderId");
		$order->getObjectsByCondition();
		$orderId = implode(",",array_keys($order->getArrayObj()));
		if($orderId){
			$order->orderitem->setCondition("orderId in ($orderId)");
			
			$order->orderitem->getObjectsByCondition();
			$option['cart'] = $order->orderitem->getArrayObj();
			
			$vsRelation->setTableName("order_gift");
			$vsRelation->setObjectId($orderId);
			$vsRelation->setRelId(0);
			$vsRelation->getRelByObject(1);
			
			$option['gift'] = $vsRelation->arrval;
			if(count($option['gift'])){
				$vsRelation->__destruct();
				$vsRelation->__construct();
				$vsRelation->setTableName("gift_product");
				$vsRelation->setArrayField(array("productImage"=>"productImage","optionTitle"=>"optionTitle","productTitle"=>"productTitle"));
				$vsRelation->setPrimaryField(array("objectId"=>"objectId","relId"=>"relId"));
				$vsRelation->getRelationObjByOption(array("group"=>"objectId, relId"),1);
				
				$option['gProduct'] = $vsRelation->getArrObj();
				
				
				$vsRelation->__destruct();
				$vsRelation->__construct();
				$vsRelation->setTableName("gift_product_replate");
				$vsRelation->setArrayField(array("productId"=>"productId","productImage"=>"productImage","price"=>"price","optionTitle"=>"optionTitle","productTitle"=>"productTitle"));
				$vsRelation->setPrimaryField(array("objectId"=>"objectId","productId"=>"productId","relId"=>"relId"));
				$vsRelation->getRelationObjByOption(array("group"=>"objectId,productId, relId"),1);
				$option['rProduct'] = $vsRelation->getArrObj();
			}
		}
		
		$this->output = $this->html->infoTrade($option);
	}
	
	/**
	 * @param $module the $module to set
	 */
	public function setModule($module) {
		$this->module = $module;
	}

	/**
	 * @param $html the $html to set
	 */
	public function setHtml($html) {
		$this->html = $html;
	}

	/**
	 * @return the $module
	 */
	public function getModule() {
		return $this->module;
	}

	/**
	 * @return the $html
	 */
	public function getHtml() {
		return $this->html;
	}

	
}
?>
