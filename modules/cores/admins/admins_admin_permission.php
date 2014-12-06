<?php
require_once LIBS_PATH.'IPermission.php';
class admins_admin_permission implements IPermission{
function getPermisstionList(){
		$array= array(
		'admins_access_module'=>VSFactory::getLangs()->getWords('admins_access_module','Access admins module'),
		'admins_account_manager'=>VSFactory::getLangs()->getWords('admins_account_manager','Quản lý tài khoản'),
		);	
		return $array;
	}
	function getPermissionGroup(){
		$array=array();
		$array[0]['name']=VSFactory::getLangs()->getWords('uncategory','Uncategory');
		$array[0]['permistion_list']=array_keys($this->getPermisstionList());
		return $array;
	}

}

?>