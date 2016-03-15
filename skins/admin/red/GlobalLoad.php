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
		global $vsPrint, $vsUser, $bw,$vsLang;
		
		$vsPrint->addJavaScriptFile ( 'jquery', 1 );
		if (! $vsUser->obj->getId ())
			return;
		$vsPrint->addJavaScriptString ( 'global_var', '
    			var vs = {};
    		    var ajaxfile = "admin.php";
				var noimage=0;
				var imgurl = "' . $bw->vars ['img_url'] . '/";
				
				var global_website_title = "' . $bw->vars ['global_websitename'] . '/";
				var global_website_choise = "' .$vsLang->getWordsGlobal('global_website_choise','You haven\'t choose any items !') . '";
				var boardUrl = "' . $bw->vars ['board_url'] . '";
				var baseUrl  = "' . $bw->base_url . '";
				
				var myArray = {"doc" : "doc","docx" : "docx", "xls" : "xls", "pdf" : "pdf","zip":"zip","rar":"rar","exe":"exe" }; 
    		' );
		
		$vsPrint->addJavaScriptFile ( 'ajaxupload/ajaxfileupload' );
		$vsPrint->addJavaScriptFile ( 'vs.ajax' );
		$vsPrint->addJavaScriptFile ( 'jquery/ui.core' );
		$vsPrint->addJavaScriptFile ( "jquery/ui.widget");
		$vsPrint->addJavaScriptFile ( "jquery/ui.mouse");
		
		$vsPrint->addJavaScriptFile ( 'jquery/ui.position' );
		$vsPrint->addJavaScriptFile ( 'jquery/ui.tabs' );
		$vsPrint->addJavaScriptFile ( 'jquery/ui.dialog' );
		$vsPrint->addJavaScriptFile ( 'jquery/ui.draggable' );
		$vsPrint->addJavaScriptFile ( 'jquery/ui.accordion' );
		$vsPrint->addJavaScriptFile ( 'jquery/ui.alerts' );
		$vsPrint->addJavaScriptFile ( 'jquery.numeric' );
		$vsPrint->addJavaScriptFile("jquery/jquery.tablesorter");
                $vsPrint->addJavaScriptFile("fileuploader");
                //$vsPrint->addJavaScriptFile ( 'jquery/ui.datepicker',1 );

		$vsPrint->addJavaScriptFile ( 'ddsmoothmenu' );
                $vsPrint->addJavaScriptFile ( 'jquery.timeout' );

		$vsPrint->addJavaScriptFile ( 'checkbox' );
		$vsPrint->addJavaScriptString ( 'topmenu', '
    		$(document).ready(function(){
    			ddsmoothmenu.init({
				mainmenuid: "topmenu",
				orientation: "h",
				classname: "ddsmoothmenu vsf-topmenu",
				img: 0,
				//customtheme: ["#1c5a80", "#18374a"], //override default menu CSS background values? Uncomment: ["normal_background", "hover_background"]
				contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
				
				});
    		})' );
	}
	
	/**
	 * This function is for add global css
	 * @name addDefaultCSS
	 * @author BabyWolf
	 * @return void
	 */
	
	function addDefaultCSS() {
		global $vsUser, $vsPrint, $vsModule;
		
		if (! $vsUser->obj->getId ()) {
			$vsPrint->addCSSFile ( 'uvn-login' );
			return;
		}
		
		// Add the default script that only use for admin
		//    	$vsPrint->addGlobalCSSFile('jquery/base/ui.all');
		$vsPrint->addCSSFile ( 'global' );
		$vsPrint->addCSSFile ( 'ceedos' );
		$vsPrint->addCSSFile ( 'input_style' );
                $vsPrint->addCSSFile ( 'fileuploader' );
		$vsPrint->addCSSFile ( 'comments' );
                $vsPrint->addCSSFile ( 'bx_styles' );
		$vsPrint->addGlobalCSSFile ( 'jquery/base/ui.core' );
		$vsPrint->addGlobalCSSFile ( 'ddsmoothmenu' );
		$vsPrint->addGlobalCSSFile ( 'jquery/base/ui.theme' );
		$vsPrint->addGlobalCSSFile ( 'jquery/base/ui.tabs' );
		$vsPrint->addGlobalCSSFile ( 'jquery/base/ui.accordion' );
		$vsPrint->addGlobalCSSFile ( 'jquery/base/ui.dialog' );
		$vsPrint->addGlobalCSSFile ( 'jquery/base/ui.custom' );
		
		$vsPrint->addCSSFile ( $vsModule->obj->getClass () );
	}
}

$styleLoad = new GlobalLoad ();