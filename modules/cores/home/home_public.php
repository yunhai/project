<?php
class home_public extends ObjectPublic{
 
	function __construct(){
		global $vsTemplate;
		
		parent::__construct('products', CORE_PATH.'products/', 'products');
		$this->html = $vsTemplate->load_template('skin_home');
	}
        
  	function showDefault(){
		global $vsStd;

		$vsStd->requireFile(CORE_PATH.'pcontacts/pcontacts.php');
		$page = new pcontacts();
		$option['branch'] = $page->getLastestByModule('branch', 9);
		
		$vsStd->requireFile(CORE_PATH.'news/news.php');
		$news = new newses();
		$option['news'] = $news->getLastestList(6);
		
		$this->output = $this->html->showDefault($option);
	}
}