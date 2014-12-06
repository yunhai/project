<?php

class VSFSession {

	function __construct(){
		global $DB;
		if(APPLICATION_TYPE=='admin')
		$this->createAdminSession();
		else
		$this->createUserSession();
	}

	function __destruct() {
	}

	function createAdminSession() {
		$thisTime = time();
		
		if(!isset($_SESSION[APPLICATION_TYPE]['session']['sessionId'])) {
			VSFactory::getAdmins()->sessions->deleteSession();
			VSFactory::getAdmins()->sessions->basicObject->setTime($thisTime);
			VSFactory::getAdmins()->sessions->basicObject->setCode($thisTime);
			VSFactory::getAdmins()->sessions->basicObject->setAdminId(VSFactory::getAdmins()->basicObject->getId());
			VSFactory::getAdmins()->sessions->insertObject();
			$_SESSION[APPLICATION_TYPE]['session'] = VSFactory::getAdmins()->sessions->basicObject->convertToDB();
			$_SESSION[APPLICATION_TYPE]['obj'] = VSFactory::getAdmins()->basicObject->convertToDB();
		}
		else{	
			VSFactory::getAdmins()->sessions->setCondition('sessionId='.$_SESSION[APPLICATION_TYPE]['session']['sessionId']);
			VSFactory::getAdmins()->sessions->getOneObjectsByCondition();
			VSFactory::getAdmins()->sessions->basicObject->setTime($thisTime);
			VSFactory::getAdmins()->sessions->basicObject->setCode($thisTime);
			VSFactory::getAdmins()->sessions->basicObject->setAdminId($_SESSION[APPLICATION_TYPE]['session']['adminId']);
			//VSFactory::getAdmins()->sessions->setCondition("sessionId={VSFactory::getAdmins()->sessions->basicObject->getId()}");
			
			if(VSFactory::getAdmins()->sessions->result['status']){ VSFactory::getAdmins()->sessions->updateObjectById(VSFactory::getAdmins()->sessions->obj);
			}
			else{
				VSFactory::getAdmins()->sessions->insertObject();
				VSFactory::getAdmins()->sessions->obj = VSFactory::getAdmins()->sessions->basicObject;
			}

		$_SESSION[APPLICATION_TYPE]['session'] = VSFactory::getAdmins()->sessions->basicObject->convertToDB();
		
//		VSFactory::getAdmins()->basicObject->convertToObject($_SESSION[APPLICATION_TYPE]['obj']);
//			if(count($_SESSION[APPLICATION_TYPE]['vsgroups'])>0)
//			foreach ($_SESSION[APPLICATION_TYPE]['vsgroups'] as $groupId) {
//				VSFactory::getAdmins()->basicObject->addGroup(VSFactory::getAdmins()->admingroups->getGroupById($groupId));
//			}
//			
		}
	}

	function createUserSession() {
		global $vsUser;
		$thisTime = time();

//		if(!isset($_SESSION[APPLICATION_TYPE]['session'])){
//			$vsUser->sessions->deleteSession();
//			$vsUser->sessions->basicObject->setTime($thisTime);
//			$vsUser->sessions->basicObject->setCode($thisTime);
//			$vsUser->sessions->basicObject->setUserId(0);
//			$vsUser->sessions->insertObject();
////			$vsCounter->insertCounter(1,1,0);
////			$_SESSION[APPLICATION_TYPE]['session'] = $vsUser->sessions->basicObject->convertToDB();
//
//		}
//		else{
//			$vsUser->sessions->setCondition('sessionId='.$_SESSION[APPLICATION_TYPE]['session']['sessionId']);
//			$vsUser->sessions->getOneObjectsByCondition();
//			$vsUser->sessions->basicObject->setTime($thisTime);
//			$vsUser->sessions->basicObject->setCode($thisTime);
//			$vsUser->sessions->basicObject->setUserId($_SESSION[APPLICATION_TYPE]['session']['userId']);
//			$vsUser->sessions->setCondition("sessionId={$vsUser->sessions->basicObject->getId()}");
//			if($vsUser->sessions->result['status']) $vsUser->sessions->updateObjectById($vsUser->sessions->obj);
//			else{
//				$vsUser->sessions->insertObject();
//				$_SESSION[APPLICATION_TYPE]['session'] = $vsUser->sessions->basicObject->convertToDB();
////				$vsCounter->insertCounter(1,0,1);
//			}
//			$vsUser->basicObject->convertToObject($_SESSION[APPLICATION_TYPE]['obj']);
//			
//			if(count($_SESSION[APPLICATION_TYPE]['vsgroups'])>0)
//			foreach ($_SESSION[APPLICATION_TYPE]['vsgroups'] as $groupId) {
//				$vsUser->basicObject->addGroup($vsUser->groupusers->getGroupById($groupId));
//			}
//		}
	}
}
?>