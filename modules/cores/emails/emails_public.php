<?php

class news_public extends ObjectPublic{
	function __construct(){
            global $vsTemplate;
            parent::__construct( 'news', CORE_PATH.'news/', 'newses');
        	
	}
	
//	function showDefault(){
//		global $vsPrint;
//		$categories = $this->model->getCategories()->getChildren();
//		reset($categories);
//		$cat = current($categories);
//		$url = $cat->getUrlCategory();
//		return $vsPrint->boink_it($url);
//	}


}
?>