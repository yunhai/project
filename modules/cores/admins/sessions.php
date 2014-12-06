<?php
require_once(CORE_PATH."admins/Session.class.php");
class sessions extends VSFObject {
	public $obj;
	/**
	 * @return the $relTableName
	 */
	function __construct(){
		parent::__construct();
		$this->primaryField 	= 'sessionId';
		$this->basicClassName 	= 'Session';
		$this->tableName 		= 'admin_session';
		
		$this->createBasicObject();
		
	}

	function deleteSession(){
		global $bw;
		$this->setCondition('sessionTime < ' . (time()-$bw->vars['admin_timeout']*4*60));
		$this->deleteObjectByCondition();
	}
	
	function updateLoginSession(){
		$thisTime= time();
		VSFactory::getAdmins()->sessions->basicObject->setTime($thisTime);
		VSFactory::getAdmins()->sessions->basicObject->setCode($thisTime);
		VSFactory::getAdmins()->sessions->basicObject->setAdminId(VSFactory::getAdmins()->basicObject->getId());
		VSFactory::getAdmins()->sessions->basicObject->setId($_SESSION[APPLICATION_TYPE]['session']['sessionId']);
		
		VSFactory::getAdmins()->sessions->updateObjectById(VSFactory::getAdmins()->sessions->basicObject);
		$_SESSION[APPLICATION_TYPE]['session'] = VSFactory::getAdmins()->sessions->basicObject->convertToDB();
		$_SESSION[APPLICATION_TYPE]['obj'] = VSFactory::getAdmins()->basicObject->convertToDB();
		if(count(VSFactory::getAdmins()->basicObject->getGroups())>0)
			foreach (VSFactory::getAdmins()->basicObject->getGroups() as $group){
			$_SESSION[APPLICATION_TYPE]['vsgroups'][$group->getId()] = $group->getId();
		}

	}
}