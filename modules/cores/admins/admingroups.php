<?php
require_once(CORE_PATH."admins/Admingroup.class.php");

class admingroups extends VSFObject {


	/**
	*Enter description here ...
	**/
	public	function __construct($category=''){
			$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Admingroup';
		$this->tableName 		= 'admingroup';
		//$this->categoryField='catId';
		//$this->categoryName=$category?$category:"admingroups";
		$this->createBasicObject();		
		parent::__construct();

	}
function getPermissionForGroup($groupId){
		VSFactory::createConnectionDB()->query("
				SELECT `permission`
				FROM `vsf_admin_permission`
				where `groupId`='$groupId'
		
		");
		$array=array();
		while($row=VSFactory::createConnectionDB()->fetch_row()){
			$array[$row['permission']]=1;
		}
		return $array;
	}
	function getAdminForGroup($groupIds){
		if(!$groupIds) return array();
		$admins=new admins();
		$admins->setCondition("`id` in (select adminId from vsf_admin_group where groupId in ({$groupIds}) )");
		$array= $admins->getObjectsByCondition();
		unset($admins);
		return $array;
		
	}
	function getGroupHavePermission($permission=""){
		$this->setCondition("`id` in (select groupId from vsf_admin_permission where permission='$permission' )");
		return $this->getObjectsByCondition();
	}



	
	/**
	*Enter description here ...
	*@var Admingroup
	**/
	var		$obj;
}
