<?php

class posts_admin_permission implements IPermission{

	/**
	 * 
	 */
	public function getPermisstionList() {
		
		$array= array(
		'posts_access_module'=>VSFactory::getLangs()->getWords('posts_access_module','Access posts module',0,'permissions'),
		);	
		return $array;
	}


}

?>