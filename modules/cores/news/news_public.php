<?php

class news_public extends ObjectPublic{
    function __construct(){
            global $vsTemplate;
            parent::__construct( 'news', CORE_PATH.'news/', 'newses');
//            $this->html = $vsTemplate->load_template('skin_news');    
    }
}
?>