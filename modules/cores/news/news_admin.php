<?php

class news_admin extends ObjectAdmin{
	function __construct(){
		parent::__construct('news', CORE_PATH.'news/', 'newses');
	}
}

?>