<?php

class partners_public extends ObjectPublic{
	function __construct(){
            global $vsTemplate;
            parent::__construct( 'partners', CORE_PATH.'partners/', 'partners');
            $this->html = $vsTemplate->load_template('skin_news');    
	}
}

?>