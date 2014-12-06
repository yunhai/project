<?php
require_once (CORE_PATH . 'admins/admins.php');
class admins_controler extends VSControl_admin {

	function __construct($modelName) {
		global $vsTemplate, $bw; // $this->html=$vsTemplate->load_template("skin_admins");
		parent::__construct ( $modelName, "skin_admins", "admin" );
		// $this->model->categoryName="admins";
	}

	function auto_run() {
		global $bw;
		switch ($bw->input ['action']) {
			
			case 'dologin' :
				$this->doLogin ();
				break;
			
			case 'login' :
				$this->displayLoginForm ();
				break;
			
			case 'logout' :
				$this->doLogout ();
				break;
			case 'admins_info_form' :
				$this->admins_info_form ();
				break;
			case 'admins_info_form_process' :
				$this->admins_info_form_process ();
				break;
			default :
				parent::auto_run ();
				break;
		}
	}

	function displaySearch() {
		global $bw;
		$order = "";
		$from = "vsf_" . $this->tableName;
		$where = "1=1";
		if ($bw->input ['search'] ['title']) {
			$where .= " and `name` like '%{$bw->input['search']['title']}%'";
		}
		if ($bw->input ['search'] ['id']) {
			$where .= " and `id`='{$bw->input['search']['id']}' ";
		}
		if ($bw->input ['search'] ['status'] != - 1 && $bw->input ['search'] ['status'] !== NULL) {
			$where .= " and `status`='{$bw->input['search']['status']}'";
		}
		$this->model->setCondition ( $where );
		
		$itemList = $this->model->getObjectsByCondition ();
		$vdata ['search'] = $bw->input ['search'];
		$option ['vdata'] = json_encode ( $vdata );
		// if(!is_object($_GET['search'])) $_GET['search']=array();
		$tmp ['search'] = $_GET ['search'];
		$bw->input ['back'] = urldecode ( http_build_query ( $tmp ) ) . "&pageIndex=" . $bw->input ['pageIndex'];
		return $this->output = $this->html->getListItemTable ( $itemList, $option );
	}

	function admins_info_form_process() {
		global $bw;
		$admins = new admins ();
		$admins->getObjectById ( VSFactory::getAdmins ()->basicObject->getId () );
		$admins->basicObject->setEmail ( $bw->input ['admins'] ['email'] );
		$admins->basicObject->setAddress ( $bw->input ['admins'] ['address'] );
		$admins->basicObject->setPhone ( $bw->input ['admins'] ['phone'] );
		if ($bw->input ['admins'] ['password']) {
			$admins->basicObject->setPassword ( md5 ( $bw->input ['admins'] ['password'] ) );
		}
		$admins->updateObject ();
		VSFactory::getAdmins ()->basicObject = $admins->basicObject;
		return $this->admins_info_form ( $this->output = VSFactory::getLangs ()->getWords ( 'admin_update_successfully', "update successfully!" ) );
	}

	function admins_info_form($message = "") {
		$option ['message'] = $message;
		return $this->output = $this->html->addChangInfoForm ( VSFactory::getAdmins ()->basicObject, $option );
	}

	function addEditObjForm($objId = 0, $option = array()) {
		global $vsStd, $bw, $vsPrint;
		$admingroup = new admingroups ();
		$option ['groupList'] = $admingroup->getObjectsByCondition ();
		$DB = VSFactory::createConnectionDB ();
		$DB->query ( "select * from vsf_admin_group where adminId='$objId'" );
		while ( $row = $DB->fetch_row () ) {
			$option ['groupped'] [$row ['groupId']] = $row ['groupId'];
		}
		return parent::addEditObjForm ( $objId, $option );
	}

	function addEditObjProcess() {
		global $bw, $vsStd;
		if ($bw->input ['admins'] ['id'] == 10 && VSFactory::getAdmins ()->basicObject->getId () != 10) {
			return $this->output = $this->getObjList ( $bw->input ['pageIndex'], "Not modify this account!" );
		}
		if (! $bw->input ['admins'] ['password']) {
			unset ( $bw->input ['admins'] ['password'] );
			unset ( $_REQUEST ['admins'] ['password'] );
			unset ( $_POST ['admins'] ['password'] );
			unset ( $_GET ['admins'] ['password'] );
		} else {
			$bw->input ['admins'] ['password'] = md5 ( $bw->input ['admins'] ['password'] );
			$_REQUEST ['admins'] ['password'] = md5 ( $_REQUEST ['admins'] ['password'] );
			$_POST ['admins'] ['password'] = md5 ( $_POST ['admins'] ['password'] );
			$_GET ['admins'] ['password'] = md5 ( $_GET ['admins'] ['password'] );
		}
		return parent::addEditObjProcess ();
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see sources/libs/boards/VSControl_admin::afterProcess()
	 * @param
	 *        	admins
	 */
	function afterProcess($model) {
		global $bw;
		
		if ($model->basicObject->getId () == 10)
			return;
		$DB = VSFactory::createConnectionDB ();
		$DB->query ( "  DELETE FROM `vsf_admin_group` WHERE `adminId` = '{$model->basicObject->getId()}' " );
		if (count ( $bw->input ['group'] )) {
			foreach ( $bw->input ['group'] as $index => $value ) {
				$query = "
				INSERT INTO `vsf_admin_group` (
				`adminId` ,
				`groupId`
				)
				VALUES (
				'{$model->basicObject->getId()}', '$value'
				);
				
				";
				$DB->query ( $query );
			}
		} else {
			$admingroups = new admingroups ();
			$admingroups->setCondition ( '`default`>0' );
			$objs = $admingroups->getObjectsByCondition ();
			if (count ( $objs )) {
				foreach ( $objs as $obj ) {
					$query = "
				INSERT INTO `vsf_admin_group` (
				`adminId` ,
				`groupId`
				)
				VALUES (
				'{$model->basicObject->getId()}', '{$obj->getId()}'
				);
				
				";
					$DB->query ( $query );
				}
			}
		}
	}

	function doLogout() {
		global $bw, $vsPrint;
		unset ( $_SESSION [APPLICATION_TYPE] );
		$vsPrint->boink_it ( $bw->base_url );
	}

	function displayLoginForm() {
		global $bw;
		$vsLang = VSFactory::getLangs ();
		$error = "";
		if ($bw->input [2] == "timeout")
			$error = $vsLang->getWords ( 'admin_session_timeout', 'Administration session time out' );
		$this->output = $this->html->LoginForm ( $error );
	}

	function doLogin() {
		global $bw, $vsPrint;
		// echo "Do LOgin";
		
		if (VSFactory::getAdmins ()->basicObject->getId ())
			$vsPrint->boink_it ( $bw->vars ['board_url'] . '/admin.' . $bw->vars ['php_ext'] );
		VSFactory::getAdmins ()->basicObject->setName ( $bw->input ['adminName'] );
		VSFactory::getAdmins ()->basicObject->setPassword ( md5 ( $bw->input ['adminPassword'] ) );
		if (! $bw->input ['adminName'] || ! $bw->input ['adminPassword']) {
			$this->output = $this->html->LoginForm ( VSFactory::getLangs ()->getWords ( 'password_username_not_match', 'Tên đăng nhập hoặc mật khẩu không đúng' ) );
			return false;
		}
		$this->model->loadAdmin ();
		if (! $this->model->result ['status']) {
			// echo "<pre> Load admin faile";
			// print_r($this->model->basicObject);
			// echo "</pre>";exit;
			$this->output = $this->html->LoginForm ( $this->model->result ['message'] );
			return false;
		}
		
		$thisTime = time ();
		$this->model->basicObject->setLastLogin ( $thisTime );
		
		$this->model->updateObjectById ();
		
		if (! $this->result ['status'])
			$this->output = $this->html->LoginForm ( $this->result ['message'] );
		
		$this->model->sessions->updateLoginSession ();
		if (! $this->result ['status'])
			$this->output = $this->html->LoginForm ( $this->result ['message'] );
		
		$vsPrint->boink_it ( $bw->vars ['board_url'] . '/admin.' . $bw->vars ['php_ext'] );
	}

	function deleteObj($ids, $cate = 0) {
		global $bw, $vsStd;
		$ids = explode ( ",", $ids );
		foreach ( $ids as $index => $value ) {
			if ($value == 10 || $value == VSFactory::getAdmins ()->basicObject->getId ()) {
				unset ( $ids [$index] );
			}
		}
		$ids = implode ( ",", $ids );
		if (! $ids) {
			return $this->output = $this->getObjList ( $cate );
		}
		$this->model->setCondition ( "`{$this->model->getPrimaryField()}` IN (" . $ids . ")" );
		$list = $this->model->getObjectsByCondition ();
		if (! count ( $list ))
			return false;
		$this->model->setCondition ( "`{$this->model->getPrimaryField()}` IN (" . $ids . ")" );
		if (! $this->model->deleteObjectByCondition ())
			return false;
		foreach ( $list as $news ) {
			$this->model->onDeleteObjectById ( $news );
			VSFactory::getFiles ()->deleteFile ( $news->getImage () );
		}
		return $this->output = $this->getObjList ( $cate );
	}

	function getHtml() {
		return $this->html;
	}

	function getOutput() {
		return $this->output;
	}

	function setHtml($html) {
		$this->html = $html;
	}

	function setOutput($output) {
		$this->output = $output;
	}
	
	/**
	 * Skins for admin .
	 * ..
	 * 
	 * @var skin_admins
	 *
	 */
	var $html;
	
	/**
	 * String code return to browser
	 */
	var $output;
	/**
	 *
	 *
	 * Enter description here ...
	 * 
	 * @var admins
	 */
	var $model;
}
