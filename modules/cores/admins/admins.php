<?php
require_once (CORE_PATH . "admins/Admin.class.php");
require_once (CORE_PATH . "admins/sessions.php");
require_once CORE_PATH . "admins/admingroups.php";
class admins extends VSFObject {
	
	/**
	 *
	 *
	 * Enter description here ...
	 * 
	 * @var Admin
	 */
	var $basicObject;

	/**
	 * Enter description here .
	 * ..
	 */
	public function __construct($category = '') {
		$this->primaryField = 'id';
		$this->basicClassName = 'Admin';
		$this->tableName = 'admin';
		$this->createBasicObject ();
		parent::__construct ();
		$this->relTableName = "admin_group";
		$this->sessions = new sessions ();
		$this->admingroups = new admingroups ();
	}

	function checkViewPermission($module = "", $action = "") {
		global $vsStd;
		$permFilePath = CORE_PATH . $module . "/" . $module . ".perm.php";
		// $vsModule->basicObject->getClass() . "/" . $vsModule->basicObject->getClass() . ".perm.php";
		if ($vsStd->requireFile ( $permFilePath )) {
			$permClass = $module . "_perm";
			$permClass = new $permClass ();
			if (method_exists ( $permClass, 'getAdminPermission' )) {
				return $this->checkPermission ( $permClass->getAdminPermission (), $module, $action );
			}
		}
		return true;
	}

	function loadAdmin() {
		global $vsPrint;
		
		$vsLang = VSFactory::getLangs ();
		$this->setCondition ( "`name`='" . VSFactory::getAdmins ()->basicObject->getName () . "'" );
		
		$this->getOneObjectsByCondition ();
		// Return if there is no admin found
		if (! $this->result ['status']) {
			$this->result ['message'] = $vsLang->getWords ( 'admin_no_username', 'Tài khoản không tồn tại!' );
			return;
		}
		if (! $this->basicObject->getStatus ()) {
			$this->result ['status'] = false;
			$this->result ['message'] = $vsLang->getWords ( 'admin_account_disabled', 'Tài khoản đã bị khóa!' );
			return;
		}
		if ($this->basicObject->getPassword () != VSFactory::getAdmins ()->basicObject->getPassword ()) {
			$this->result ['status'] = false;
			$this->result ['message'] = $vsLang->getWords ( 'admin_wrong_password', 'Mật khẩu không đúng!' );
			return;
		}
		VSFactory::getAdmins ()->basicObject = $this->basicObject;
	}

	function getAdminWithGroup() {
		$this->getOneObjectsByCondition ();
		$vsRelation = VSFactory::getRelation ();
		$vsRelation->setObjectId ( $this->basicObject->getId () );
		$vsRelation->setTableName ( $this->getRelTableName () );
		$array = $vsRelation->arrval;
		foreach ( $array as $id => $group ) {
			$this->basicObject->addGroup ( $this->groupadmins->getGroupById ( $id ) );
		}
	}

	/**
	 * delete Admin on database
	 * 
	 * @return void
	 */
	function deleteAdmin() {
		$DB = VSFactory::createConnectionDB ();
		$vsLang = VSFactory::getLangs ();
		$this->deleteObjectById ( $this->basicObject->getId () );
		// Delete the relationship
		$DB->simple_delete ( 'admin_groups_user', 'adminId=' . $this->basicObject->getId () );
		if (! $DB->simple_exec ()) {
			$this->result ['status'] = false;
			$this->result ['message'] = $vsLang->getWords ( 'admin_delete_rel', 'There was an error when delete admin relationship!' );
			return;
		}
		$this->result ['message'] = $vsLang->getWords ( 'admin_delete_success', 'You have successfully deleted an admin account name ' ) . ' <span style="color:red"> [ ' . $this->basicObject->getName () . " ]</span> ";
	}

	/**
	 * validate if Admin object is valid
	 * 
	 * @return void
	 */
	function validate($checkPassword = true) {
		$vsLang = VSFactory::getLangs ();
		
		$this->result ['status'] = true;
		$this->result ['message'] = "";
		
		if ($this->basicObject->getName () == "") {
			$this->result ['status'] = false;
			$this->result ['message'] .= $vsLang->currentArrayWords ['err_admin_name_blank'];
		}
		
		if ($this->basicObject->getPassword () == "" && $checkPassword) {
			$this->result ['status'] = false;
			$this->result ['message'] .= $vsLang->currentArrayWords ['err_admin_password_blank'];
		}
		if ($checkPassword && $this->basicObject->getPassword () && $this->basicObject->getName ()) {
			$managerObj = new admins ();
			$managerObj->condition = "adminName='{$this->basicObject->getName()}'";
			$managerObj->getAllAdmin ();
			if (count ( $managerObj->arrayAdmin )) {
				$this->result ['status'] = false;
				$this->result ['message'] .= $vsLang->getWords ( 'account_exits', 'Tài khoản không tồn tại trong hệ thống' );
			}
		}
		
		if (count ( $this->basicObject->getGroups () ) < 1) {
			$this->result ['status'] = false;
			$this->result ['message'] .= $vsLang->currentArrayWords ['err_admin_choose_group'];
		}
	}

	function getNormalGroup($user = null) {
		global $bw;
		foreach ( $this->groupadmins->arrayGroup as $group ) {
			if ($group->getId () != $bw->vars ['root_admin_groups'])
				return $group;
		}
	}

	function checkRoot($user = null) {
		if ($this->basicObject->getName () == "vietsol") {
			return true;
		}
		return false;
	}

	function authorizeAdmin() {
		global $vsPrint, $bw;
		$vsModule = VSFactory::getModules ();
		
		$this->sessions->deleteSession ();
		if (! VSFactory::getAdmins ()->basicObject->getId ()) {
			$vsModule->basicObject->setClass ( 'admins' ); // No Admin session
			
			if ($bw->input ['action'] != 'dologin') {
				$bw->input [2] = "nosession";
				$bw->input ['action'] = "login";
				$bw->input [0] = 'admins';
				$bw->input ['module'] = 'admins';
				unset ( $_SESSION [APPLICATION_TYPE] ['obj'] );
				unset ( $_SESSION [APPLICATION_TYPE] ['session'] );
				unset ( $_SESSION [APPLICATION_TYPE] ['groups'] );
			}
		} else {
			$this->sessions->setCondition ( "sessionCode='" . VSFactory::getAdmins ()->sessions->basicObject->getCode () . "'" );
			$this->sessions->getObjectsByCondition ();
			
			if (! $this->sessions->result ['status']) {
				$vsModule->basicObject->setClass ( 'admins' ); // Admin session time out
				$bw->input [2] = "timeout";
				$bw->input ['action'] = "login";
				VSFactory::getAdmins ()->basicObject->__destruct ();
				unset ( $_SESSION [APPLICATION_TYPE] ['obj'] );
				unset ( $_SESSION [APPLICATION_TYPE] ['session'] );
				unset ( $_SESSION [APPLICATION_TYPE] ['vsgroups'] );
			} else {
				// $vsUser->sessions->basicObject->setTime(time());
				VSFactory::getAdmins ()->sessions->updateLoginSession ();
			}
		}
	}

	function getAllAdmin() {
		$this->setCondition ( '`status` > 0 ' );
		return $this->getObjectsByCondition ();
	}

	function getGroupForAdmin($adminId) {
		$groups = new admingroups ();
		$groups->setCondition ( "id in (select groupId from vsf_admin_group where adminId='{$adminId}' )" );
		$array = $groups->getObjectsByCondition ();
		unset ( $groups );
		return $array;
	}

	function getPermissionForModule($moduleName) {
		$className = $moduleName . "_admin_permission";
		$filepath = CORE_PATH . $moduleName . "/$className.php";
		
		if (! file_exists ( $filepath ))
			return array ();
		require_once $filepath;
		
		if (! class_exists ( $className ))
			return array ();
		$class = new $className ();
		return $class->getPermisstionList ();
	}

	function getPermissionForModuleGroup($moduleName) {
		$className = "{$moduleName}_admin_permission";
		$filepath = CORE_PATH . $moduleName . "/$className.php";
		
		if (! file_exists ( $filepath ))
			return array ();
		require_once $filepath;
		
		if (! class_exists ( $className ))
			return array ();
		$class = new $className ();
		return $class->getPermissionGroup ();
	}

	function getPermisstionList() {
		$modules = new modules ();
		$modules->setCondition ( "isAdmin=1" );
		$modullist = $modules->getObjectsByCondition ();
		$result = array ();
		foreach ( $modullist as $module ) {
			$list = $this->getPermissionForModule ( $module->getClass () );
			;
			// if($list){
			$result [$module->getClass ()] = $list;
			// $result[$className['moduleObj']]=$module;
			// }
		}
		unset ( $modullist );
		return $result;
	}
	
	/**
	 * Enter description here .
	 * ..
	 * 
	 * @var Admin
	 *
	 */
	var $obj;
}
