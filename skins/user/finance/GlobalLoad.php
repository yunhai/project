<?php

class GlobalLoad {

	function __construct() {
		$this->addDefaultScript();
		$this->addDefaultCSS();
	}


	function addDefaultScript(){
		global $vsPrint, $bw;
		
		
		$vsPrint->addCurentJavaScriptFile("jquery", 1);
		$vsPrint->addCurentJavaScriptFile("bootstrap", 1);
		$vsPrint->addCurentJavaScriptFile("jquery.li-scroller.1.0", 1);
		
		$vsPrint->addJavaScriptString ( 'global_var', '
                    var vs = {};
    		    	var ajaxfile = "index.php";
                    var noimage=0;
                    var image = "loader.gif";
                    var imgurl = "' . $bw->vars ['img_url'] . '/";
                    var img = "' . $bw->vars ['cur_folder'] . 'htc";
                    var boardUrl = "'.$bw->vars['board_url'].'";
                    var baseUrl  = "'.$bw->base_url.'";
                    var global_website_title = "'.$bw->vars['global_websitename'].'/";
    			', 1 );
		
			$vsPrint->addJavaScriptString ( 'script', '
                    $(document).ready(function(){
						$("ul#ticker01").liScroll();
						$(".carousel").carousel();
					});
    			');
	}

	function addDefaultCSS() {
		global $vsPrint;

		$vsPrint->addCSSFile('global');
		$vsPrint->addCSSFile('bootstrap');
		$vsPrint->addCSSFile('bootstrap-responsive');
		$vsPrint->addCSSFile('main');
		$vsPrint->addCSSFile('li-scroller');
	}
}
	$styleLoad = new GlobalLoad();