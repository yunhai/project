<?php

class GlobalLoad {
	
	function __construct() {
		$this->addDefaultScript ();
		$this->addDefaultCSS ();
	}
	
	/**
	 * This function is for add global javascript
	 * @name addDefaultScript
	 * @author BabyWolf
	 * @return void
	 */
	function addDefaultScript() {
		global $vsPrint,  $bw,$vsSkin;
		
		$vsPrint->addJavaScriptFile ( 'jquery', 1 );
		$vsPrint->addJavaScriptFile ( 'jquery-migrate-1.2.1.min' );
		if (! VSFactory::getAdmins()->basicObject->getId ())
			return;
		$vsPrint->addJavaScriptString ( 'global_var', '
    			var vs = {};
				var noimage=0;
				var imgurl = "' . $bw->vars ['img_url'] . '/";
				var global_website_title = "' . $bw->vars ['global_websitename'] . '";
				var global_website_choise = "' .VSFactory::getLangs()->getWords('global_website_choise','You haven\'t choose any items !') . '";
				var boardUrl = "' . $bw->vars ['board_url'] . '";
				var baseUrl  = "' . $bw->base_url . '";
				 var ajaxfile = boardUrl + "/admin.php";
				var allowFile = {"doc" : "doc", "docx" : "docx", "xls" : "xls", "xlsx" : "xlsx","pdf" : "pdf", "zip" : "zip", "rar" : "rar", "rtf":"rtf"};
				var allowImage = {"png" : "png","jpeg" : "jpeg", "jpg" : "jpg", "gif" : "gif", "psd" : "psd", "crd" : "crd"};
				var allowVideo = {"dat" : "dat","avi" : "avi", "mp4" : "mp4", "3gp" : "3gp", "wmv" : "wmv", "swf" : "swf", "mpeg":"mpeg", "mpg":"mpg","flv":"flv" }; 
    		' );
		
		$vsPrint->addJavaScriptFile ( 'ajaxupload/ajaxfileupload' );
		$vsPrint->addJavaScriptFile ('vs.fwadmin');
		$vsPrint->addJavaScriptFile ( 'vs.ajax' );
		$vsPrint->addCurentJavaScriptFile ("jquery.dd");
		$vsPrint->addCurentJavaScriptFile ("imenu");
	
		
 		$vsPrint->addJavaScriptFile ( 'jquery-ui-1.8.16' );
 		$vsPrint->addJavaScriptFile("jquery.price_format.1.8");
		$vsPrint->addJavaScriptFile ( "tiny_mce/tiny_mce" );
		$vsPrint->addJavaScriptFile ( "tiny_mce/jquery.tinymce" );
		$vsPrint->addJavaScriptFile ( 'jquery/ui.alerts' );
		$vsPrint->addJavaScriptFile ( 'jquery.numeric' );
		$vsPrint->addJavaScriptFile ( 'jquery.address-1.5.min' );
		$vsPrint->addJavaScriptFile ( 'jquery.history' );
		$vsPrint->addJavaScriptFile("jquery/jquery-ui-datetimepicker");
        $vsPrint->addJavaScriptFile("fileuploader");
		$vsPrint->addJavaScriptFile("star-rating");
        $vsPrint->addJavaScriptFile ( 'jquery.timeout' );
		$vsPrint->addJavaScriptFile("default");
		
		
		$vsPrint->addJavaScriptFile ( "html5uploader" );
	}
	
	/**
	 * This function is for add global css
	 * @name addDefaultCSS
	 * @author BabyWolf
	 * @return void
	 */
	
	function addDefaultCSS() {
		global  $vsPrint,$vsSkin;
		
		$vsPrint->addCSSFile ( 'global','screen' );
 		if (! VSFactory::getAdmins()->basicObject->getId ()) {
			$vsPrint->addCSSFile ( 'uvn-login' );
			return;
		}
		$vsPrint->addCSSFile ( 'dd' );
		
		$vsPrint->addCSSFile("jquery/jquery-ui");
		$vsPrint->addCSSFile ( 'jquery/jquery.ui.tabs' );
		$vsPrint->addGlobalCSSFile('jquery/base/ui.alert');
		$vsPrint->addCSSFile ( 'star-rating' );
		$vsPrint->addCSSFile ( 'bootstrap' );
		$vsPrint->addCSSFile ( VSFactory::getModules()->basicObject->getClass () );
	}
	
	private function find($direct, $pattern){
		$files = array();
			if ($dir = opendir($direct)) {
				
				while (false !== ($file = readdir($dir))) {
					if ($file != "." && $file != ".."&&$file!='.svn') {
						if(is_dir($file)){
							//$images=array_merge($images,$this->find($file,$pattern,$file."/"));
						}else{
							if(preg_match($pattern,$file)){
								$files[] = $file;
							}
						}
					}
				}
				closedir($dir);
			}
	    return $files;
	}
}

$styleLoad = new GlobalLoad ();