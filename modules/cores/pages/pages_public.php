 <?php
class pages_public extends ObjectPublic{
	function __construct(){
		parent::__construct('pages', CORE_PATH.'pages/', 'pages');
	}
}
?>
