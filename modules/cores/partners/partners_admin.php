<?php
class partners_admin extends ObjectAdmin{
        function __construct(){
                global $vsTemplate, $vsPrint;
		parent::__construct('partners', CORE_PATH.'partners/', 'partners');
//                $vsPrint->addJavaScriptFile("jquery/ui.datepicker");
//		$vsPrint->addCSSFile('ui.datepicker');
               // $vsPrint->addJavaScriptFile("jquery.dimensions");
                $this->html = $vsTemplate->load_template('skin_partners');
	}

}
?>