<?php

class menus_admin_permission implements IPermission{
//	/**
//	 * 
//	 */
//	public function getPermissionGroup() {
//		$array=array();
//		$array[0]['name']=VSFactory::getLangs()->getWords('uncategory','Uncategory');
//		$array[0]['permistion_list']=array_keys($this->getPermisstionList());
//		return $array;
//	}

	/**
	 * 
	 */
	public function getPermisstionList() {
		
		$array= array(
		'menus_access_module'=>VSFactory::getLangs()->getWords('menus_access_module','Access menus module',0,'permissions'),
		);	
		$vsMenu = VSFactory::getMenus();
			$vsMenu->basicObject->setIsAdmin(1);
			$vsMenu->basicObject->setStatus(1);
			$vsMenu->basicObject->setPosition('top');
			$vsMenu->basicObject->setTitle('Categories');
	
			$category=$vsMenu->getAdminMenu();
//		$category=VSFactory::getMenus()->getAdminMenu();
		$a=$this->menuNoteToArray($category,$abc);
		if($a){
			foreach ($a as $value) {
				$array['menu_show_'.$value->getId()]=$value->getTitle();
			}
		}
		return $array;
	}
	function menuNoteToArray($array,&$objs){
		if(!is_array($array)) return;
		if($objs==NULL) $objs=array();
		foreach ($array as  $index => $value) {
			
			$objs[$index]=$value;
			$this->menuNoteToArray($value->getChildren(),$objs);
			
		}
		return $objs;
	}


}

?>