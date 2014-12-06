<?php
class GlobalLoad {

	function __construct() {
		$this->addDefaultScript ();
		$this->addDefaultCSS ();
	}
	function addDefaultScript() {
		global $vsPrint, $bw, $vsSkin;
		
		$vsPrint->addJavaScriptFile ('vs.ajax',1);
		$vsPrint->addCurentJavaScriptFile ( 'jquery',1 );		
		$vsPrint->addCurentJavaScriptFile ( 'bootstrap.min');	
		$vsPrint->addCurentJavaScriptFile ( 'html5shiv');			
		$vsPrint->addCurentJavaScriptFile ( 'jquery.isotope.min');
		$vsPrint->addCurentJavaScriptFile ( 'main');
		$vsPrint->addCurentJavaScriptFile ( 'respond.min');
		


//		$vsPrint->addJavaScriptFile ('vs.ajax');

	//	$vsPrint->addJavaScriptFile ( 'jquery-ui-1.8.16' );
//		
//		
//		$vsPrint->addCurentJavaScriptFile("jquery-1.7.1.min",1);
//		$vsPrint->addCurentJavaScriptFile("jquery.bxslider");
//		$vsPrint->addCurentJavaScriptFile("imenu");
//		$vsPrint->addCurentJavaScriptFile("highslide/highslide-full");
		
		
		
//		$jspath = ROOT_PATH . $vsSkin->basicObject->getFolder () . "/javascripts/";
//		$files = $this->find ( $jspath, '/\.js/' );
//		foreach ( $files as $value ) {
//			if ($value == "jquery.js") {
//				// $vsPrint->addCurentJavaScriptFile(str_replace(".js","",$value),1);
//			} else {
//				//$vsPrint->addCurentJavaScriptFile(str_replace(".js","",$value));
//			}
//		}
//		$vsPrint->addJavaScriptFile ( 'jquery.numeric' );
		$vsPrint->addJavaScriptString ( 'global_var', '
		
		
    			var vs = {};
				var noimage=0;
				var image = "loader.gif";
				var imgurl = "' . $bw->vars ['img_url'] . '";
				var img = "' . $bw->vars ['cur_folder'] . 'htc";
				var boardUrl = "' . $bw->vars ['board_url'] . '";
				var baseUrl  = "' . $bw->base_url . '";
				 var ajaxfile = boardUrl + "/index.php";
				var global_website_title = "' . $bw->vars ['global_websitename'] . '";
    		', 1 );
		
			$vsPrint->addJavaScriptString ( 'global_analysis', "
    			 (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-49749690-1', 'lysontravel.org');
  ga('send', 'pageview');
    		",1);
		
	}

	function addDefaultCSS() {
		global $vsUser, $vsPrint, $vsModule, $vsSkin;
		$vsPrint->addGlobalCSSFile('jquery/jquery-ui-1.10.4.custom');

		$vsPrint->addCSSFile("bootstrap.min");
		$vsPrint->addCSSFile("font-awesome.min");	
		$vsPrint->addCSSFile("prettyPhoto");
		$vsPrint->addCSSFile("animate");
		$vsPrint->addCSSFile("main");
		
		
		
	}

	function find($direct, $pattern) {
		$images = array ();
		if ($dir = opendir ( $direct )) {
			
			while ( false !== ($file = readdir ( $dir )) ) {
				if ($file != "." && $file != ".." && $file != '.svn') {
					if (is_dir ( $file )) {
						// $images=array_merge($images,$this->find($file,$pattern,$file."/"));
					} else {
						if (preg_match ( $pattern, $file )) {
							$images [] = $file;
						}
					}
				}
			}
			closedir ( $dir );
		}
		return $images;
	}
}
$styleLoad = new GlobalLoad ();