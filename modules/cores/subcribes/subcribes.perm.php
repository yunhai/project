<?php
class travels_perm {
	function getAdminPermission() {
		global $vsLang;

		$permission = array($vsLang->getWords('Travel_perm','Travel manager permission', 1, 'travels'),
		array(// admin permission
                        
                        'add-edit-obj-process'	=> $vsLang->getWords('add-edit-obj-process_travel','Edit an Travel', 1, 'travels'),
                        'display-obj-list'		=> $vsLang->getWords('display-obj-list_travel'	,'View Travel list', 1, 'travels'),
                        'hide_show-obj-list'	=> $vsLang->getWords('hideshow-obj-list_travel','Hide Show Travel', 1, 'travels'),
                        'delete_obj-list'		=> $vsLang->getWords('delete-obj-list_travel','Delete  Travel', 1, 'travels'),
                        'display_category_tab'	=> $vsLang->getWords('display_category_tab_travel','View category tab', 1, 'travels'),
                        'display_settings_tab'	=> $vsLang->getWords('display_settings_tab_travel','View Setting Tab', 1, 'travels'),
						'search'				=> $vsLang->getWords('search','Tìm kiếm', 1, 'travels'),
		
		// group admin permission
										
		)
		);
		return $permission;
	}
}
?>