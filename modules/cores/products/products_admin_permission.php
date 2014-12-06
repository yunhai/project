<?php
require_once LIBS_PATH.'IPermission.php';
class products_admin_permission implements IPermission{
function getPermisstionList(){
		$array= array(
		'products_access_module'=>VSFactory::getLangs()->getWords('products_access_module','Access products module'),
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