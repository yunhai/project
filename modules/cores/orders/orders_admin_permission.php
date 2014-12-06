<?php
require_once LIBS_PATH.'IPermission.php';
class orders_admin_permission implements  IPermission{
	function getPermisstionList(){
		$array= array(
		'orders_access_module'=>VSFactory::getLangs()->getWords('orders_access_module','Access orders module',0,'permissions'),
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