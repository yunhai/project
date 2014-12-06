<?php
require_once LIBS_PATH.'IPermission.php';
class langs_admin_permission implements IPermission{
function getPermisstionList(){
		$array= array(
			'langs_access_module'=>VSFactory::getLangs()->getWords('langs_access_module','Access langs module'),
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