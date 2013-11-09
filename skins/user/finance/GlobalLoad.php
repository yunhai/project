<?php

class GlobalLoad {

	function __construct() {
		$this->addDefaultScript();
		$this->addDefaultCSS();
	}


	function addDefaultScript(){
		global $vsPrint, $bw;
		

		$vsPrint->addCurentJavaScriptFile("jquery-1.7.1.min", 1);
		$vsPrint->addCurentJavaScriptFile("jquery.tools.min", 1);
		
		
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
                    	$(".menu_top li").hover(function(){
							 $(this).find("ul:first").css({visibility: "visible",display: "none"}).show();
							 $(this).parent().prev().addClass("active1");
							 /* -- nếu bỏ display none thì khi hover lại lần thứ 2 thì kg có faceIn -- */
							 },function(){
								 $(this).find("ul:first").css({display: "none"}).hide();
								 $(this).parent().prev().removeClass("active1");
							 });
							 $(".menu_top li ul li a").each(function(){
							 if(this.href == document.location.href){
								 $(this).parent().parent().prev().addClass("active");
							 }
						});
						$(".menu_top").find("li:first").addClass("menu_first");
						$(".menu_top").find("li:last").css({background:"none"});
						 
//						$(".lang_link").find("a:last").css({background:"none",padding:"0px"});
						
						$(".sitebar_tuyendung").find(".tuyendung_item:last").css({border:"none",padding:"0px",margin:"0px"});
					});
    			');
	}

	function addDefaultCSS() {
		global $vsPrint;

		
		$vsPrint->addCSSFile('default');
		$vsPrint->addCSSFile('global');
		$vsPrint->addCSSFile('content');
		$vsPrint->addCSSFile('menu');
		$vsPrint->addCSSFile('tabs-slideshow');
		$vsPrint->addCSSFile('jcarousellite');
		
		
		$vsPrint->addGlobalCSSFile('jquery/base/ui.theme');
		$vsPrint->addGlobalCSSFile('jquery/base/ui.core');
		$vsPrint->addGlobalCSSFile('jquery/base/ui.theme');
		$vsPrint->addGlobalCSSFile('jquery/base/ui.dialog');
	}
}
	$styleLoad = new GlobalLoad();